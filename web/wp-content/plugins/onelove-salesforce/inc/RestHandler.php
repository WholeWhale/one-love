<?php

use Davispeixoto\ForceDotComToolkitForPhp\QueryResult;

class RestHandler extends Salesforce {
  public function setup() {
    register_rest_route('ol-sf/v1', 'school-autocomplete', [
      'methods' => 'GET',
      'callback' => [$this, 'autocomplete'],
    ]);
  }

  public function autocomplete($request) {
    if (empty($request['value'])) {
      return;
    }

    $this->initializeSalesforce();

    $name = preg_replace('/[^ \w]+/', '', $request['value']);

    $resp = $this->conn->query("SELECT Id, Name FROM Account WHERE Type='College/University' AND Name LIKE '%$name%'");
    $result = new QueryResult($resp);

    $return = [];
    for ($result->rewind(); $result->pointer < $result->size; $result->next()) {
      $record = $result->current();

      $return[] = [
        'id' => $record->Id,
        'name' => $record->fields->Name,
      ];
    }

    return $return;
  }
}
