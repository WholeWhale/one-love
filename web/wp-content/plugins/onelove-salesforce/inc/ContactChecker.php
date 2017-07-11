<?php

use Firebase\JWT\JWT;

class ContactChecker extends Salesforce {

  // public static $COOKIE_DURATION = DAYS_IN_SECONDS; // 1 day
  public static $COOKIE_DURATION = 0; // for the session
  public static $COOKIE_NAME = 'ol-email-cookie';

  /**
   * Constructor.
   */
  public function __construct() {
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

  public function isInCampaign($contactId, $campaignId) {
    $resp = $this->conn->query("SELECT Id FROM CampaignMember WHERE CampaignId='$campaignId' AND ContactId='$contactId'");

    return count($resp->records) > 0;
  }


  public function validatePost($content) {
    $shouldValidate = get_post_meta(get_the_ID(), Metaboxes::KEY, true);

    if (!$shouldValidate || $shouldValidate == 0) {
      return $content;
    }

    $this->initializeSalesforce();

    $error = false;
    $email = null;

    if ($tok = self::getContactInfo()) {
      $email = $tok->Email;
      if ($shouldValidate > 1) {
        if ($tok->campaigns && in_array($shouldValidate, $tok->campaigns)) {
          return $content;
        } else if ($this->isInCampaign($tok->Id, $shouldValidate)) {
          $newTok = $this->generateJWT($tok, $shouldValidate);
          $this->setCookie($newTok);
          return $content;
        } else {
          $error = true;
        }
      } else {
        return $content;
      }
    }

    return $this->generateEmailForm($error);
  }

  protected function generateJWT($sfUser, $campaign = null) {
    if ($campaign) {
      if (!$sfUser->campaigns) {
        $sfUser->campaigns = [];
      }

      $sfUser->campaigns[] = $campaign;
    }

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

    return $decoded->data;
  }

  protected function generateEmailForm($error = false) {
    if ($error = isset($_GET['failed'])) {
      $email = $_GET['failed'];
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
