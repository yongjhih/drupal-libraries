<?php

/**
 * @file
 * Definition of \Drupal\libraries\LibraryManager\LibraryInfoDiscoveryInterface.php
 */

namespace Drupal\libraries\LibraryManager\Discovery;

/**
 * Provides a common interface for library info discovery.
 *
 * @see \Drupal\Component\Plugin\Discovery\DiscoveryInterface
 */
interface LibraryInfoDiscoveryInterface {

  /**
   * Gets information about a library.
   *
   * @param string $name
   *   The machine-readable name of the library to return information
   *   for.
   *
   * @return array
   *   An associative array of library information containing the following
   *   keys:
   *   - label: The human-readable label of the library.
   *   - vendor: The vendor of the library as specified in its composer.json
   *     file.
   *   - package: The package of the library as specified in its composer.json
   *     file.
   */
  public function getLibraryInfo($name);

  /**
   * Gets information about all libraries.
   *
   * @return array
   *   An associative array where the keys are the machine-readable library
   *   names and the values are in turn arrays of library information as
   *   depicted in LibraryClassDiscoveryInterface::getLibraryInfo().
   */
  public function getAllLibraryInfo();
}
