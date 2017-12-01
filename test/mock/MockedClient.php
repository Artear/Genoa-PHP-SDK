<?php

namespace genoaTest\mock;

use genoa\Client;

class MockedClient extends Client {

  protected function getApiCall($endpoint) {
    return new MockedApiCall($endpoint);
  }

  public function getAccessToken() {
    return 'my-access-token';
  }

}
