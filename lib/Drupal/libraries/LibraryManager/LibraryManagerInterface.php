<?php

/**
 * Definition of \Drupal\libraries\LibraryManager\LibraryManagerInterface.
 */

namespace Drupal\libraries\LibraryManager;

use Drupal\libraries\LibraryManager\Discovery\LibraryInfoDiscoveryInterface;

/**
 * Provides a common interface for library managers.
 *
 * @see \Drupal\Component\Plugin\PluginManagerInterface
 */
interface LibraryManagerInterface extends LibraryInfoDiscoveryInterface {

  /**
   * Instantiates a library object.
   *
   * @param string $name
   *   The machine-readable name of the library to instantiate.
   *
   * @throws \Drupal\libraries\LibraryManager\Exception\LibraryClassNotFoundException
   *
   * @see \Drupal\Component\Plugin\Mapper\MapperInterface
   */
  public function getLibraryInstance($name);

  /**
   * Checks whether a given library is enabled.
   *
   * Whether a library is enabled or not depends on whether a module or theme
   * depends on it. Therefore, the library class itself does not know whether it
   * is enabled or not, but instead we keep track of this in the library
   * manager.
   *
   * @param string $name
   *   The machine-readable name of the library.
   *
   * @return bool
   *   TRUE if the library is enabled, FALSE if the library is disabled.
   */
  public function isEnabled($name);

  /**
   * Enables a library.
   *
   * @param string $name
   *   The machine-readable name of the library to enable.
   *
   * @see \Drupal\libraries\Library\LibraryInterface::enable()
   */
  public function enable($name);

  /**
   * Disable a library.
   *
   * @param string $name
   *   The machine-readable name of the library to disable.
   *
   * @see \Drupal\libraries\Library\LibraryInterface::disable()
   */
  public function disable($name);
}

