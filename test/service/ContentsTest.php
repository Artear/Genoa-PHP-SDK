<?php

namespace genoaTest\service;

use genoa\ApiCall;
use genoaTest\mock\MockedClient;
use PHPUnit_Framework_TestCase;

use genoa\service\Contents;

class ContentsTest extends PHPUnit_Framework_TestCase {

  /**
   * @var Contents
   */
  private $contentsService;

  private $apiBase;
  private $publisherId = 99;

  public function setUp() {
    $mockedClient = new MockedClient('client-id', 'secret-id');
    $this->apiBase = $mockedClient->getApiHost();
    $this->contentsService = new Contents($mockedClient, $this->publisherId);
  }

  public function testGetLatestContents() {
    $result = $this->contentsService->getLatestContents();
    $expected = [
      'method' => ApiCall::METHOD_GET,
      'url' => $this->apiBase . "/content/list?pids={$this->publisherId}&limit=20&order=false&access_token=my-access-token",
      'body' => NULL,
      'headers' => [
        'content-type: application/json'
      ]
    ];

    $this->assertEquals($expected,  $result);

    $result = $this->contentsService->getLatestContents(50);
    $expected = [
      'method' => ApiCall::METHOD_GET,
      'url' => $this->apiBase . "/content/list?pids={$this->publisherId}&limit=50&order=false&access_token=my-access-token",
      'body' => NULL,
      'headers' => [
        'content-type: application/json'
      ]
    ];

    $this->assertEquals($expected,  $result);
  }

  public function testGetCategoryContents() {
    $result = $this->contentsService->getCategoryContents(1000);
    $expected = [
      'method' => ApiCall::METHOD_GET,
      'url' => $this->apiBase . "/category?pubs_id={$this->publisherId}&cid=1000&page=1&access_token=my-access-token",
      'body' => NULL,
      'headers' => [
        'content-type: application/json'
      ]
    ];

    $this->assertEquals($expected,  $result);

    $result = $this->contentsService->getCategoryContents(1000, 2);
    $expected = [
      'method' => ApiCall::METHOD_GET,
      'url' => $this->apiBase . "/category?pubs_id={$this->publisherId}&cid=1000&page=2&access_token=my-access-token",
      'body' => NULL,
      'headers' => [
        'content-type: application/json'
      ]
    ];

    $this->assertEquals($expected,  $result);
  }

  public function testDeletedContents() {
    $result = $this->contentsService->getDeletedContents();
    $expected = [
      'method' => ApiCall::METHOD_GET,
      'url' => $this->apiBase . "/category?pubs_id={$this->publisherId}&cid=0&page=1&access_token=my-access-token",
      'body' => NULL,
      'headers' => [
        'content-type: application/json'
      ]
    ];

    $this->assertEquals($expected,  $result);

    $result = $this->contentsService->getDeletedContents(2);
    $expected = [
      'method' => ApiCall::METHOD_GET,
      'url' => $this->apiBase . "/category?pubs_id={$this->publisherId}&cid=0&page=2&access_token=my-access-token",
      'body' => NULL,
      'headers' => [
        'content-type: application/json'
      ]
    ];

    $this->assertEquals($expected,  $result);
  }

}
