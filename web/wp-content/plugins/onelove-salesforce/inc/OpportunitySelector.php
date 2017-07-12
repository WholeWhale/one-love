<?php

use Davispeixoto\ForceDotComToolkitForPhp\QueryResult;

class OpportunitySelector extends Salesforce {
  public function addTag() {
    wpcf7_add_form_tag('sfopportunity', array($this, 'tagHandler'), array('name-attr' => true));
  }

  public function tagHandler($tag) {
    if ($user = ContactChecker::getContactInfo()) {
      $this->initializeSalesforce();

      $name = $tag->name;
      if (!$name) {
        $name = 'opportunityId';
      }

      if (defined('SALESFORCE_WORKSHOP_RECORD_TYPE_ID')) {
        $recordTypeId = SALESFORCE_WORKSHOP_RECORD_TYPE_ID;
      } else {
        $recordTypeId = '012j0000000pgwJ';
      }

      $accountId = $user->fields->npsp__Primary_Affiliation__c;

      $resp = $this->conn->query("SELECT Id, Name FROM Opportunity WHERE StageName='Planning' AND RecordTypeId='$recordTypeId' AND AccountId='$accountId'");

      $result = new QueryResult($resp);

      if ($result->size == 0) {
        return 'There are currently no workshops scheduled at your school.';
      } else if ($result->size == 1) {
        $result->rewind();
        $record = $result->current();

        return '<input type="hidden" name="'.$name.'" value="'.$record->Id.'" />';
      } else {
        $return = '<select name="'.$name.'">';

        for ($result->rewind(); $result->pointer < $result->size; $result->next()) {
          $record = $result->current();
          $return .= '<option value="'.$record->Id.'">'.$record->fields->Name.'</option>';
        }

        $return .= '</select>';

        return $return;
      }
    } else {
      return 'Unable to find Salesforce user id. Is the "Salesforce contact" gate turned on for this post?';
    }
  }
}
