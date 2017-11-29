<?php

namespace genoa;

use genoa\service\AuthorizationAccess;

class Client {

  public $host = 'https://api.vodgc.net/';
  public $version = "v1";
  public $client_id;
  public $secret_id;

  private $access_token = NULL;

  /**
   * Client constructor.
   * @param $client_id
   * @param $secret_id
   */
  public function __construct($client_id, $secret_id) {
    $this->client_id = $client_id;
    $this->secret_id = $secret_id;
  }

  protected function getApiCall($endpoint) {
    return new ApiCall($endpoint);
  }

  /**
   * @return mixed
   * @throws \Exception
   */
  public function getAccessToken() {
    try {
      if ($this->access_token != NULL) {
        return $this->verifyToken();
      }

      $endpoint = $this->host . "auth/accessToken";
      $api = $this->getApiCall($endpoint);
      $response = $api->post(new AuthorizationAccess($this->client_id, $this->secret_id));
      return $response->access_token;
    } catch (\Exception $e) {
      throw $e;
    }
  }

  /**
   * @return mixed
   * @throws \Exception
   */
  private function verifyToken() {
    if ($this->access_token !== NULL) {

      try {
        $endpoint = $this->host . 'auth/token/client_id/' . $this->client_id . '/access_token/' . $this->access_token;
        $api = $this->getApiCall($endpoint);
        $api->put();

        return $this->access_token;
      } catch (\Exception $e) {
        try {
          $response = $this->refreshToken();
          $this->access_token = $response->access_token;
          return $this->access_token;
        } catch (\Exception $e) {
          throw $e;
        }
      }

    }
    else {
      throw new \Exception("Error Token: Can't be empty");
    }
  }

  /**
   * @return mixed
   * @throws \Exception
   */
  private function refreshToken() {
    try {
      $endpoint = $this->host . 'auth/refreshToken';
      $api = $this->getApiCall($endpoint);
      return $api->post(new AuthorizationAccess($this->client_id, $this->secret_id));
    } catch (\Exception $e) {
      throw $e;
    }
  }

  /**
   * @return string
   */
  public function getApiHost() {
    return $this->host . "api/" . $this->version;
  }

  public function get($path, $payload = NULL) {
    return $this->call('get', $path, $payload);
  }

  public function post($path, $payload) {
    return $this->call('post', $path, $payload);
  }

  public function put($path, $payload = NULL) {
    return $this->call('put', $path, $payload);
  }

  protected function call($method, $path, $payload) {
    $api = $this->getApiCall($this->getApiHost() . $path);
    $payload['access_token'] = $this->getAccessToken();

    return $api->$method($payload);
  }

  public function upload($path, $query = array(), $file) {
    $queryString = http_build_query(array_merge($query, array(
      'access_token' => $this->getAccessToken(),
    )));
    $endpoint = $this->getApiHost() . $path . '?' . $queryString;
    $api = $this->getApiCall($endpoint);

    return $api->uploadFile($file->getPath(), $file->getMimeType(), $file->getName());
  }
}
