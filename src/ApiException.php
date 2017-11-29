<?php

namespace genoa;

use Exception;

class ApiException extends Exception {

  /**
   * ApiException constructor.
   * @param string $message
   * @param int $code
   * @param \Exception|NULL $previous
   */
  public function __construct($message = "", $code = 0, Exception $previous = NULL) {
    $message = "API: " . $message;
    parent::__construct($message, $code, $previous);
  }

}
