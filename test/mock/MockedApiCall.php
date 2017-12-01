<?php

namespace genoaTest\mock;

use genoa\ApiCall;


class MockedApiCall extends ApiCall {

  public function call($url, $payload, $method) {
    return $this->prepareCurlRequest($url, $payload, $method);
  }

  public function uploadFile($file_path, $mimetype, $filename) {
    return $this->prepareCurlFileRequest($file_path, $mimetype, $filename);
  }

}
