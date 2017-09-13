<?php

namespace genoa\service;

use genoa\Api;
use genoa\Client;

class Content {

  private $client;

  /**
   * Content constructor.
   * @param \genoa\Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * @param mixed $content_id
   * @return mixed
   * @throws \Exception
   */
  public function getContentById($content_id) {
    try {
      $endpoint = $this->client->getApiHost() . "/content/" . $content_id;
      $api = new Api($endpoint);

      $payload = array(
        'access_token' => $this->client->getAccessToken()
      );

      return $api->get($payload);
    } catch (\Exception $e) {
      throw $e;
    }
  }

  /**
   * Update a content
   *
   * @param $content_id
   * @param array $payload
   *  description: optional (String)
   *  name: optional (String)
   *  categories: optional (int,int)
   *  status: optional ('enabled','disabled')
   *  tags: optional (String)
   *  comscore: {"ns_st_st":"test","ns_st_pu":"test2"}
   *
   * @link https://api.vodgc.net/api/v1/docs
   * @return mixed
   * @throws \Exception
   */
  public function updateContent($content_id, $payload = []) {
    try {
      $endpoint = $this->client->getApiHost() . "/content/" . $content_id;
      $api = new Api($endpoint);

      $payload['access_token'] = $this->client->getAccessToken();
      return $api->put($payload);

    } catch (\Exception $e) {
      throw $e;
    }
  }

  /**
   * @param integer $content_id
   * @param string $relative_file_path
   * @return mixed
   * @throws \Exception
   */
  public function updateHighlightThumbnial($content_id, $relative_file_path) {
    try {

      $endpoint = $this->client->getApiHost() . "/content/image";
      $api = new Api($endpoint);
      $api->addHeader("Content-Type: multipart/form-data");

      $payload = [];
      $payload['access_token'] = $this->client->getAccessToken();
      $payload['content_id'] = $content_id;
      $payload['file'] = '@' . $relative_file_path;

      return $api->post($payload);

    } catch (\Exception $e) {
      throw $e;
    }
  }
}