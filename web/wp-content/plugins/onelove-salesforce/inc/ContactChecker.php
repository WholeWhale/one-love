<?php

use Firebase\JWT\JWT;
use Davispeixoto\ForceDotComToolkitForPhp\QueryResult;

class ContactChecker extends Salesforce {

  // public static $COOKIE_DURATION = DAYS_IN_SECONDS; // 1 day
  public static $COOKIE_DURATION = 0; // for the session
  public static $COOKIE_NAME = 'wp-ol_email_cookie';

  public $canView = false;
  public $viewError = false;

  /**
   * Constructor.
   */
  public function __construct() {
    add_action('wp', array($this, 'setCanView'));
    add_action('the_content', array($this, 'validatePost'));

    add_action('admin_post_nopriv_sf_email_validate', array($this, 'processEmailForm'));
    add_action('admin_post_sf_email_validate', array($this, 'processEmailForm'));
  }

  public static function getContactInfo() {
    if (isset($_COOKIE[self::$COOKIE_NAME])) {
      if ($tok = self::getJWT($_COOKIE[self::$COOKIE_NAME])) {
        return $tok;
      }
    }

    return false;
  }

  public function findByEmail($email, $return = ['CONTACT' => ['ID', 'EMAIL', 'FIRSTNAME', 'LASTNAME', 'npsp__Primary_Affiliation__c']]) {
    $returning = [];

    foreach ($return as $type => $fields) {
      $fields = implode(',', $fields);
      $returning[] = "$type($fields)";
    }

    $email = str_replace('+', '\+', $email);
    $resp = $this->conn->search('FIND {"'.$email.'"} RETURNING '.implode(',', $returning));

    return $resp->searchRecords;
  }

  protected function getCampaignMemberships($contactId, $campaignId) {
    $resp = $this->conn->query("SELECT Id, Status FROM CampaignMember WHERE CampaignId='$campaignId' AND ContactId='$contactId'");

    $result = new QueryResult($resp);

    $campaigns = [];
    for ($result->rewind(); $result->pointer < $result->size; $result->next()) {
      $record = $result->current();

      $campaigns[$campaignId] = $record->fields->Status;
    }

    return $campaigns;
  }

  protected function updateCampaignMembership(&$tok, $campaignId) {
    static $hasRun = [];

    if (!isset($hasRun[$campaignId])) {
      $memberships = $this->getCampaignMemberships($tok->Id, $campaignId);

      foreach ($memberships as $campaign => $status) {
        $tok->campaigns[$campaign] = $status;
      }

      $this->setCookie($this->generateJWT($tok));

      $hasRun[$campaignId] = true;
    }
  }

  public function isInCampaign($tok, $campaignId, $isRetry = false) {
    if (isset($tok->campaigns) && array_key_exists($campaignId, $tok->campaigns)) {
      return true;
    } else {
      if (!$isRetry) {
        $this->updateCampaignMembership($tok, $campaignId);
        return $this->isInCampaign($tok, $campaignId, true);
      } else {
        return false;
      }
    }
  }

  public function hasCampaignStatus($tok, $campaignId, $status, $isRetry = false) {
    if (isset($tok->campaigns[$campaignId]) && $tok->campaigns[$campaignId] == $status) {
      return true;
    } else {
      if (!$isRetry) {
        $this->updateCampaignMembership($tok, $campaignId);
        return $this->hasCampaignStatus($tok, $campaignId, $status, true);
      } else {
        return false;
      }
    }
  }

  public function setCanView() {
    global $post;

    $settings = Metaboxes::getSettings($post->ID);
    $shouldValidate = $settings !== false;

    if (!$shouldValidate) {
      $this->canView = true;
      return;
    }

    $this->initializeSalesforce();

    // If we have a valid token because they exist in SF
    if ($tok = self::getContactInfo()) {
      // If we need to check the campaign
      if ($settings['campaign']) {
        if ($this->isInCampaign($tok, $settings['campaign'])) {
          if ($settings['status']) {
            if ($this->hasCampaignStatus($tok, $settings['campaign'], $settings['status'])) {
              $this->canView = true;
            } else { // in campaign, but wrong status
              $this->error = true;
            }
          } else { // in campaign, no status requirement
            $this->canView = true;
          }
        } else { // not in campaign
          $this->error = true;
        }
      } else { // no need to check campaign
        $this->canView = true;
      }
    }
  }

  public function validatePost($content) {
    if ($this->canView) {
      return $content;
    } else {
      return $this->generateEmailForm();
    }
  }

  protected function generateJWT($sfUser) {
    $data = [
      'data' => $sfUser,
    ];

    return JWT::encode($data, SECURE_AUTH_KEY, 'HS256');
  }

  protected static function getJWT($jwt) {
    try {
      $decoded = JWT::decode($jwt, SECURE_AUTH_KEY, ['HS256']);
    } catch (Exception $e) {
      return false;
    }

    if ($decoded->data->campaigns) {
      $decoded->data->campaigns = (array) $decoded->data->campaigns;
    }

    return $decoded->data;
  }

  protected function generateEmailForm() {
    $error = $this->error;
    if (isset($_GET['failed'])) {
      $error = true;
      $email = $_GET['failed'];
    } else if ($tok = $this->getContactInfo()) {
      $email = $tok->fields->Email;
    }

    ob_start();
    include dirname(__FILE__) . '/../form.html.php';
    return ob_get_clean();
  }

  public function processEmailForm() {
    $this->initializeSalesforce();

    $email = sanitize_email($_POST['email']);

    $results = $this->findByEmail($email);

    if (count($results) > 0) {
      $this->setCookie($this->generateJWT($results[0]));
      wp_redirect($_SERVER['HTTP_REFERER']);
    } else {
      $redirect = $_SERVER['HTTP_REFERER'];
      if (strpos($redirect, '?')) {
        $redirect .= '&';
      } else {
        $redirect .= '?';
      }
      $redirect .= 'failed='.$email;
      wp_redirect($redirect);
    }
  }

  public function setCookie($jwt) {
    setcookie(self::$COOKIE_NAME, $jwt, self::$COOKIE_DURATION, '/');
  }
}
