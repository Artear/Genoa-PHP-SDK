<?php

namespace genoa\service;

class AuthorizationAccess {

  public $client_id;
  public $secret_id;

  /**
   * AuthorizationAccess constructor.
   * @param $client_id
   * @param $secret_id
   */
  public function __construct($client_id, $secret_id) {
    $this->client_id = $client_id;
    $this->secret_id = $secret_id;
  }
}