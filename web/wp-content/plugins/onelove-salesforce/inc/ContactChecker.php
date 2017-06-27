<?php

use Davispeixoto\ForceDotComToolkitForPhp\SforcePartnerClient;
use Firebase\JWT\JWT;

class ContactChecker {

  // public static $COOKIE_DURATION = DAYS_IN_SECONDS; // 1 day
  public static $COOKIE_DURATION = 0; // for the session
  public static $COOKIE_NAME = 'ol-email-cookie';

  /**
   * @var SforcePartnerClient Salesforce connection
   */
  protected $conn;

  /**
   * @var
   */
  protected $client;

  /**
   * @var
   */
  protected $auth;

  /**
   * string Directory of ForceDotComToolkitForPhp
   */
  protected $sfDir;

  /**
   * Constructor.
   */
  public function __construct() {
    add_action('the_content', array($this, 'validatePost'));

    add_action('admin_post_nopriv_sf_email_validate', array($this, 'processEmailForm'));
    add_action('admin_post_sf_email_validate', array($this, 'processEmailForm'));
  }

  public function initializeSalesforce() {
    if (!$this->client) {
      try {
        // FIXME (cjcodes): is there a better way to do this?
        $this->sfDir = ABSPATH . '../../vendor/davispeixoto/force-dot-com-toolkit-for-php';
        $this->conn = new SforcePartnerClient();
        $this->conn->SforcePartnerClient();
        $this->client = $this->conn->createConnection($this->sfDir . "/wsdl/partner.wsdl.xml");
        $this->auth = $this->conn->login(SALESFORCE_LOGIN, SALESFORCE_PASSWORD . SALESFORCE_TOKEN);
      } catch (Exception $e) {
        // noop
      }
    }
  }

  public function findByEmail($email, $return = ['CONTACT' => ['ID', 'EMAIL', 'FIRSTNAME', 'LASTNAME']]) {
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

    if (isset($_COOKIE[self::$COOKIE_NAME])) {
      if ($tok = $this->getJWT($_COOKIE[self::$COOKIE_NAME])) {
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
    }

    return $this->generateEmailForm($email, $error);
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

  protected function getJWT($jwt) {
    try {
      $decoded = JWT::decode($jwt, SECURE_AUTH_KEY, ['HS256']);
    } catch (Exception $e) {
      return false;
    }

    return $decoded->data;
  }

  protected function generateEmailForm($email, $error = false) {
    if ($_GET['failed'] == 'true') {
      $error = true;
    }

    $content = include dirname(__FILE__) . '/../form.html.php';

    return $content;
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
      $redirect .= 'failed=true';
      wp_redirect($redirect);
    }
  }

  public function setCookie($jwt) {
    setcookie(self::$COOKIE_NAME, $jwt, self::$COOKIE_DURATION, '/');
  }
}
