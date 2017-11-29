<?php

namespace genoaTest\service;

use genoa\ApiCall;
use genoaTest\mock\MockedClient;
use PHPUnit_Framework_TestCase;

use genoa\service\Content;

class ContentTest extends PHPUnit_Framework_TestCase {

  /**
   * @var Content
   */
  private $contentService;

  private $apiBase;

  public function setUp() {
    $mockedClient = new MockedClient('client-id', 'secret-id');
    $this->apiBase = $mockedClient->getApiHost();
    $this->contentService = new Content($mockedClient);
  }

  public function testGetContentById() {
    $result = $this->contentService->getContentById(123123);
    $expected = [
      'method' => ApiCall::METHOD_GET,
      'url' => $this->apiBase . '/content/123123?access_token=my-access-token',
      'body' => NULL,
      'headers' => [
        'content-type: application/json'
      ]
    ];

    $this->assertEquals($expected,  $result);
  }

  public function testUpdateContent() {
    $result = $this->contentService->updateContent(123123, array(
      'description' => 'New description'
    ));
    $expected = [
      'method' => ApiCall::METHOD_PUT,
      'url' => $this->apiBase . '/content/123123',
      'body' => json_encode(array(
        'description' => 'New description',
        'access_token' => 'my-access-token'
      )),
      'headers' => [
        'content-type: application/json'
      ]
    ];

    $this->assertEquals($expected,  $result);
  }

  public function testUpdateHighlightThumbnail() {
    $result = $this->contentService->updateHighlightThumbnail(123123, '/data/my_image.png', 'image/png', 'my-image');
    $expectedUrl = $this->apiBase . '/content/image?content_id=123123&access_token=my-access-token';
    $expectedHeaders = array('Content-Type:multipart/form-data');
    $expectedFileData = [
      'path' => '/data/my_image.png',
      'mimetype' => 'image/png',
      'name' => 'my-image'
    ];

    $this->assertEquals($expectedUrl, $result['url']);
    $this->assertEquals($expectedHeaders, $result['headers']);
    $this->assertArrayHasKey('body', $result);
    $this->assertArrayHasKey('file', $result['body']);
    $this->assertEquals($expectedFileData['path'],  $result['body']['file']->getFilename());
    $this->assertEquals($expectedFileData['mimetype'],  $result['body']['file']->getMimeType());
    $this->assertEquals($expectedFileData['name'],  $result['body']['file']->getPostFilename());
  }

  public function testGetQualities() {
    $result = $this->contentService->getQualities(123123);
    $expected = [
      'method' => ApiCall::METHOD_GET,
      'url' => $this->apiBase . '/content/qualities?content_id=123123&access_token=my-access-token',
      'body' => NULL,
      'headers' => [
        'content-type: application/json'
      ]
    ];

    $this->assertEquals($expected,  $result);
  }

}
