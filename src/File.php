<?php

namespace genoa;

class File {

  private $path;
  private $mimetype;
  private $name;

  /**
   * ApiException constructor.
   * @param string $message
   * @param string $message
   * @param string $message
   */
  public function __construct($path, $mimetype, $name) {
    $this->path = $path;
    $this->mimetype = $mimetype;
    $this->name = $name;
  }

  /**
   * @return string
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * @return string
   */
  public function getMimeType() {
    return $this->mimetype;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

}
