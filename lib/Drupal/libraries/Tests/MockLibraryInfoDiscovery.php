<?php

/**
 * @file
 * Definition of \Drupal\libraries\Tests\MockLibraryInfoDiscovery
 */

namespace Drupal\libraries\Tests;

use Drupal\libraries\LibraryManager\Discovery\LibraryInfoDiscoveryInterface;

/**
 * Defines a mock discovery mechanism to annotated library information.
 *
 * This class simply returns the library information passed in the constructor.
 */
class MockLibraryInfoDiscovery implements LibraryInfoDiscoveryInterface {

  /**
   * Static library information to return.
   *
   * @var array
   */
  protected $libraries;

  /**
   * Constructs a MockLibraryClassDiscovery object.
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
}
