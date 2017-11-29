<?php

namespace genoa\service;

use genoa\Client;

class Contents {

  private $client;
  private $publisher_id;

  /**
   * Content constructor.
   * @param \genoa\Client $client
   */
  public function __construct(Client $client, $publisher_id) {
    $this->client = $client;
    $this->publisher_id = $publisher_id;
  }

  /**
   * Return the last $limit contents from the publisher (defaults to 20)
   * @param number $limit
   * @param number $order_by
   * @return array
   * @throws \Exception
   */
  public function getLatestContents($limit = 20) {
    return $this
      ->client
      ->get("/content/list", array(
        'pids' => $this->publisher_id,
        'limit' => $limit,
        'order' => 'false'
      ));
  }

  /**
   * Return category contents
   * @param number $category_id
   * @param number $page
   * @return array
   * @throws \Exception
   */
  public function getCategoryContents($category_id, $page = 1) {
    return $this
      ->client
      ->get("/category", array(
        'pubs_id' => $this->publisher_id,
        'cid' => $category_id,
        'page' => $page
      ));
  }

  /**
   * Return deleted contents
   * @param number $page
   * @return array
   * @throws \Exception
   */
  public function getDeletedContents($page = 1) {
    return $this->getCategoryContents(0, $page);
  }

}
