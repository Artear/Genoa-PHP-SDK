<?php

namespace genoa\service;

use genoa\Client;
use genoa\File;

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
    return $this
      ->client
      ->get("/content/{$content_id}");
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
    return $this
      ->client
      ->put("/content/{$content_id}", $payload);
  }

  /**
   * @param $content_id
   * @param string $path
   * @param string $mimetype
   * @param string $name
   * @return string
   * @throws \Exception
   */
  public function updateHighlightThumbnail($content_id, $path, $mimetype, $name) {
    $query = array(
      'content_id' => $content_id
    );
    $file = new File($path, $mimetype, $name);

    return $this
      ->client
      ->upload("/content/image", $query, $file);
  }
  
  /**
   * Return the qualities of the video
   * @param mixed $content_id
   * @return mixed
   * @throws \Exception
   */
  public function getQualities($content_id) {
    return $this
      ->client
      ->get("/content/qualities", array(
        'content_id' => $content_id
      ));
  }

}
