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
   * If library information is found for the specified name, it is assumed to be
   * safe to instantiate the \Drupal\Library\$name class. Therefore, by default,
   * annotated classes are used to discover this library information.
   *
   * @param string $name
   *   The machine-readable name of the library to return information
   *   for.
   *
   * @return array|null
   *   An associative array of library information containing the following
   *   keys:
   *   - label: The human-readable label of the library.
   *   - vendor: The vendor of the library as specified in its composer.json
   *     file.
   *   - package: The package of the library as specified in its composer.json
   *     file.
   *   If no library information could be found for the specified name, NULL is
   *   returned.
   */
  public function getLibraryInfo($name);

  /**
   * Gets information about all libraries.
   *
   * For each library name for which library information is found, it is assumed
   * to be safe to instantiate the \Drupal\Library\$name class. See
   * LibraryInfoDiscoveryInterface::getLibraryInfo().
   *
   * @return array
   *   An associative array where the keys are the machine-readable library
   *   names and the values are in turn arrays of library information as
   *   depicted in LibraryInfoDiscoveryInterface::getLibraryInfo().
   */
  public function getAllLibraryInfo();
}
