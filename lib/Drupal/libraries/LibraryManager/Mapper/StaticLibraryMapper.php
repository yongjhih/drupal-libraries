<?php

/**
 * @file
 * Contains \Drupal\libraries\LibraryManager\Mapper\StaticLibraryMapper.
 */

namespace Drupal\libraries\LibraryManager\Mapper;

use Drupal\libraries\LibraryManager\Exception\LibraryClassNotFoundException;

/**
 * Provides a default library manager.
 *
 * @see \Drupal\Component\Plugin\PluginManagerBase
 */
class StaticLibraryMapper implements LibraryMapperInterface {

  /**
   * An array of library instances.
   *
   * Because there cannot be multiple library instances, each library class is
   * only instantiated once and kept in memory.
   *
   * @var array
   */
  protected $instances;

  /**
   * Implements LibraryFactoryInterface::getLibraryInstance().
   */
  public function getLibraryInstance($name) {
    // Cache the library instances that the factory creates.
    if (!isset($this->instances[$name])) {
      $class = "Drupal\\Library\\$name";

      if (!class_exists($class)) {
        throw new LibraryClassNotFoundException("The class $class was not found.");
      }

      $this->instances[$name] = new $class();

    }

    return $this->instances[$name];
  }
}

