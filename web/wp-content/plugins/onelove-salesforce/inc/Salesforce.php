<?php

use Davispeixoto\ForceDotComToolkitForPhp\SforcePartnerClient;

class Salesforce {
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

  public function initializeSalesforce() {
    if (!$this->conn) {
      // FIXME (cjcodes): is there a better way to do this?
      $this->sfDir = ABSPATH . '../../vendor/davispeixoto/force-dot-com-toolkit-for-php';
      $this->conn = new SforcePartnerClient();
      $this->conn->SforcePartnerClient();
      $this->client = $this->conn->createConnection($this->sfDir . "/wsdl/partner.wsdl.xml");

      if (defined('SALESFORCE_USE_SANDBOX') && SALESFORCE_USE_SANDBOX == '1') {
        $this->conn->setEndpoint('https://test.salesforce.com/services/Soap/u/27.0');
      }

      $this->auth = $this->conn->login(SALESFORCE_LOGIN, SALESFORCE_PASSWORD . SALESFORCE_TOKEN);
    }
  }
}
