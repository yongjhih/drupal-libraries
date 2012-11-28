<?php

/**
 * @file
 * Contains \Drupal\libraries\LibraryManager\Mapper\LibraryMapperInterface.php
 */

namespace Drupal\libraries\LibraryManager\Mapper;

/**
 * Provides a common interface for library factories.
 *
 * @see \Drupal\Component\Plugin\Discovery\DiscoveryInterface
 */
interface LibraryMapperInterface {

  /**
   * Returns a library instance.
   *
   * All libraries live in the Drupal\Library namespace, so for a given $name
   * an instance of the \Drupal\Library\$name class is instantiated.
   *
   * @param string $name
   *   The machine-readable name of the library to instantiate.
   *
   * @throws \Drupal\libraries\LibraryManager\Mapper\LibraryClassNotFoundException
   *
   * @see \Drupal\Component\Plugin\Mapper\MapperInterface
   */
  public function getLibraryInstance($name);
}
