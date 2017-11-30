<?php

namespace genoa;

use Exception;

class ApiCall {

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

  protected $curl_options;
  protected $host = NULL;
  protected $headers = array();

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
   * @return string
   */
  public function getHost() {
    return $this->host;
  }

  /**
   * @param $key
   * @param $value
   * @return ApiCall
   */
  public function setCurlOption($key, $value) {
    $this->curl_options[$key] = $value;
    return $this;
  }

  /**
   * @param string $header
   * @return ApiCall
   */
  public function addHeader($key, $value) {
    $this->headers[strtolower($key)] = $value;
    return $this;
  }

  /**
   * @return ApiCall
   */
  public function asJSON() {
    $this->addHeader('content-type', 'application/json');
    return $this;
  }

  /**
   * @param null $payload
   * @return mixed
   */
  public function get($payload = NULL) {
    return $this->call($this->host, $payload, self::METHOD_GET);
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

  /**
   * @param $url
   * @param $payload
   * @param $method
   * @return mixed
   * @throws \Exception
   */
  public function call($url, $payload, $method) {
    $request = $this->prepareCurlRequest($url, $payload, $method);

    // @codeCoverageIgnoreStart

    $ch = curl_init();

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
    curl_setopt_array($ch, $curl_options);

    if ($method === self::METHOD_POST) {
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $request['body']);
    }
    elseif ($method === self::METHOD_PUT) {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $request['body']);
    }
    elseif ($method === self::METHOD_DELETE) {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $request['body']);
    }
    elseif ($method === self::METHOD_PATCH) {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $request['body']);
    }

    curl_setopt($ch, CURLOPT_URL, $request['url']);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request['headers']);

    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $response = json_decode($result);

    if (curl_error($ch) || $httpcode >= 400) {
      $errno = curl_errno($ch);
      if ($errno > 0) {
        throw new ApiException(curl_strerror($errno));
      }
      else {
        throw new ApiException($response->error . " (code $httpcode)");
      }
    }

    curl_close($ch);
    return $response;

    // @codeCoverageIgnoreEnd
  }

  /**
   * @param $file_path
   * @param $mimetype
   * @param $filename
   * @return string
   */
  public function uploadFile($file_path, $mimetype, $filename) {
    $request = $this->prepareCurlFileRequest($file_path, $mimetype, $filename);

    // @codeCoverageIgnoreStart

    $ch = curl_init();
    $options = array(
      CURLOPT_VERBOSE => TRUE,
      CURLOPT_URL => $request['url'],
      CURLOPT_HEADER => TRUE,
      CURLOPT_POST => 1,
      CURLOPT_HTTPHEADER => $request['headers'],
      CURLOPT_POSTFIELDS => $request['body'],
      CURLOPT_RETURNTRANSFER => TRUE
    );

    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);

    if (curl_errno($ch)) {
      return curl_error($ch);
    }

    curl_close($ch);

    return json_encode($result);

    // @codeCoverageIgnoreEnd
  }

  protected function prepareCurlRequest($url, $payload, $method) {
    if (!in_array($method, self::METHODS)) {
      throw new ApiException('The method ' . $method . ' is not supported');
    }

    if ($url === NULL) {
      throw new ApiException("The host can't be null");
    }

    $body = NULL;
    if ($method === self::METHOD_GET) {
      $url .= '?' . http_build_query($payload);
    } else {
      if (is_object($payload) || is_array($payload)) {
        $body = json_encode($payload);
      }
      else {
        $body = $payload;
      }
    }

    if (!isset($this->headers['content-type'])) {
      $this->asJSON();
    }

    $headers =  array_map(function($key, $value) {
      return "$key: $value";
    }, array_keys($this->headers), array_values($this->headers));

    return [
      'method' => $method,
      'url' => $url,
      'headers' => $headers,
      'body' => $body
    ];
  }

  protected function prepareCurlFileRequest($file_path, $mimetype, $filename) {
    $file = new \CURLFile($file_path, $mimetype, $filename);

    return [
      'url' => $this->host,
      'headers' => array('Content-Type:multipart/form-data'),
      'body' => array('file' => $file)
    ];
  }

}
