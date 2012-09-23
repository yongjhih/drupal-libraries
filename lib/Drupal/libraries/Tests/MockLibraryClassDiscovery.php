<?php

/**
 * @file
 * Definition of \Drupal\libraries\Tests\MockLibraryClassDiscovery
 */

namespace Drupal\libraries\Tests;

use Drupal\libraries\LibraryManager\Discovery\LibraryClassDiscoveryInterface;

/**
 * Defines a mock discovery mechanism to annotated library classes.
 *
 * This class simply returns the library information passed in the constructor.
 */
class MockLibraryClassDiscovery implements LibraryClassDiscoveryInterface {

  /**
   * Static library information to return.
   */
  protected $libraries;

  /**
   * An array of paths passed into MockLibraryClassDiscovery::setPaths().
   *
   * For testability, this is a public variable.
   */
  public $paths = array();

  /**
   * Construct a MockLibraryClassDiscovery object.
   *
   * @param array $libraries
   *   An array of library information that will be returned.
   *
   * @see \Drupal\libraries\LibraryManager\Discovery\LibraryClassDiscoveryInterface::getDefinitions()
   */
  public function __construct($libraries) {
    $this->libraries = $libraries;
  }

  /**
   * Implements LibraryClassDiscoveryInterface::getDefinition().
   */
  public function getLibraryInfo($name) {
    return isset($this->libraries[$name]) ? $this->libraries[$name] : NULL;
  }

  /**
   * Implements LibraryClassDiscoveryInterface::getDefinitions().
   */
  public function getAllLibraryInfo() {
    return $this->libraries;
  }

  /**
   * Implements LibraryClassDiscoveryInterface::setPaths().
   */
  public function setPaths($paths) {
    $this->paths = $paths;
  }
}
