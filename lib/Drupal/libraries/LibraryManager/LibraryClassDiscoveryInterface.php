<?php

/**
 * @file
 * Definition of \Drupal\libraries\LibraryManager\LibraryClassDiscoveryInterface.php
 */

namespace Drupal\libraries\LibraryManager;

use Drupal\Component\Plugin\Discovery\DiscoveryInterface;

/**
 * Provides a common interface for library class discovery.
 */
interface LibraryClassDiscoveryInterface extends DiscoveryInterface {

  /**
   * Sets the list of paths to search for library classes.
   *
   * @param array|\Traversable $paths
   *   A list of paths to search for library classes.
   */
  public function setPaths($paths);
}
