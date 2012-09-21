<?php

/**
 * @file
 * Definition of Drupal\libraries\Library\Exception\LibraryException.
 */

namespace Drupal\libraries\Library\Exception;

class LibraryException extends \Exception {

  /**
   * The machine-readable library name.
   */
  protected $name;

  /**
   * The error message.
   */
  protected $message;

  /**
   * Constructs a LibraryException object.
   *
   * @name string
   *   The machine-readable library name.
   * @message string
   *   An error message.
   */
  public function __construct($name, $message) {
    $this->name = $name;
    $this->message = $message;

    parent::__construct('Error with library ' . $this->name . ': ' . $this->message);
  }

  /**
   * Returns the machine-readable name of the library.
   */
  public function getName() {
    return $this->name;
  }
}
