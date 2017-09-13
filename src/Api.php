<?php

namespace genoa;


use Exception;

class Api {
  const METHOD_DELETE = "DELETE";
  const METHOD_POST = "POST";
  const METHOD_PUT = "PUT";
  const METHOD_GET = "GET";
  const METHOD_PATCH = "PATCH";
  const METHODS = array(
    self::METHOD_DELETE,
    self::METHOD_POST,
    self::METHOD_PUT,
    self::METHOD_GET,
    self::METHOD_PATCH
  );
  public $curl_options;
  private $host = NULL;
  private $headers = array();

  /**
   * Api constructor.
   * @param string $host
   * @param array $headers
   */
  public function __construct($host, $headers = []) {
    $this->host = $host;
    $this->headers = $headers;
  }

  /**
   * @param $key
   * @param $value
   */
  public function setCurlOption($key, $value) {
    $this->curl_options[$key] = $value;
  }

  /**
   * @param string $header
   * @return void
   */
  public function addHeader($header) {
    $this->headers[] = $header;
  }

  /**
   * @param null $payload
   * @return mixed
   */
  public function get($payload = NULL) {
    return $this->call($this->host, $payload, self::METHOD_GET);
  }

  /**
   * @param $url
   * @param $payload
   * @param $method
   * @return mixed
   * @throws \Exception
   */
  public function call($url, $payload, $method) {

    if (!in_array($method, self::METHODS)) {
      throw new Exception('The method ' . $method . ' is not supported');
    }

    if ($url == NULL) {
      throw new Exception("The host can't be null");
    }

    // @codeCoverageIgnoreStart

    $default_curl_options = [
      CURLOPT_VERBOSE => FALSE,
      CURLOPT_FORBID_REUSE => TRUE,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_HEADER => FALSE,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYPEER => FALSE
    ];

    $curl_options = $default_curl_options;
    if (isset($this->curl_options) && is_array($this->curl_options)) {
      $curl_options = array_replace($default_curl_options, $this->curl_options);
    }

    $ch = curl_init();
    curl_setopt_array($ch, $curl_options);

    $json_data = json_encode($payload);

    if ($method === self::METHOD_POST) {
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    }
    elseif ($method === self::METHOD_PUT) {
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    }
    elseif ($method === self::METHOD_DELETE) {
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    }
    elseif ($method === self::METHOD_PATCH) {
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    }
    else {
      $url .= '?' . http_build_query($payload);
    }

    if (empty($this->headers)) {
      $this->headers[] = 'Content-Type: application/json';
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_error($ch) || $httpcode >= 400) {
      $errno = curl_errno($ch);
      if ($errno > 0) {
        throw new Exception(curl_strerror($errno));
      }
      else {
        throw new Exception("Error Code: " . $httpcode);
      }
    }

    $response = json_decode($result);

    curl_close($ch);
    return $response;

    // @codeCoverageIgnoreEnd
  }

  /**
   * @param $payload
   * @return mixed
   */
  public function post($payload) {
    return $this->call($this->host, $payload, self::METHOD_POST);
  }

  /**
   * @param $payload
   * @return mixed
   */
  public function put($payload = NULL) {
    return $this->call($this->host, $payload, self::METHOD_PUT);
  }
}