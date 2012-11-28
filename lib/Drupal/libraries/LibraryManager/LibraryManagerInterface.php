<?php

/**
 * Contains \Drupal\libraries\LibraryManager\LibraryManagerInterface.
 */

namespace Drupal\libraries\LibraryManager;

use Drupal\libraries\LibraryManager\Discovery\LibraryInfoDiscoveryInterface;
use Drupal\libraries\LibraryManager\Mapper\LibraryMapperInterface;

/**
 * Provides a common interface for library managers.
 *
 * In simply extending the discovery and mapper interfaces, the architecture
 * resembles that of the core Plugin API.
 *
 * Because changing library status needs to interact with the status storage,
 * the discovery mechanism, and the library instance itself, we do not
 * extend LibraryStatusStorageInterface directly.
 *
 * @see \Drupal\Component\Plugin\PluginManagerInterface
 *
 * @todo Instead of passing $name around like crazy, consider splitting this
 *   into a manager that manages all libraries and a per-library manager. We
 *   would need a name for either of them that is not LibraryManager.
 */
interface LibraryManagerInterface extends LibraryInfoDiscoveryInterface, LibraryMapperInterface {

  /**
   * Returns a library instance.
   *
   * If this library instance has not been requested before, this uses
   * a factory that implements LibraryFactoryInterface to create it.
   *
   * @param string $name
   *   The machine-readable name of the library to instantiate.
   *
   * @throws \Drupal\libraries\LibraryManager\Exception\LibraryClassNotFoundException
   *
   * @see \Drupal\Component\Plugin\Factory\FactoryInterface
   */
  public function getLibraryInstance($name);

  /**
   * Checks whether a given library is enabled.
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
   * Enabling a library consists of the following steps:
   * 1. Mark the library as enabled in configuration using a status manager that
   *    implements LibraryStatusManagerInterface.
   * 2. If the library supports variants and, hence, the library instance
   *    implements VariantLibraryInterface, and declares a default variant, set
   *    the declared variant as active.
   * 3. Allow the library to react to its enabling by calling
   *    LibraryInterface::enable().
   *
   * @param string $name
   *   The machine-readable name of the library to enable.
   *
   * @see \Drupal\libraries\Library\LibraryInterface::enable()
   */
  public function enable($name);

  /**
   * Disables a library.
   *
   * Disabling a library consists of the following steps:
   * 1. Remove the library from configuration using a status manager that
   *    implements LibraryStatusManagerInterface.
   * 2. Allow the library to react to its disabling by calling
   *    LibraryInterface::disable.
   *
   * @param string $name
   *   The machine-readable name of the library to disable.
   *
   * @see \Drupal\libraries\Library\LibraryInterface::disable()
   */
  public function disable($name);

  /**
   * Gets the machine-readable name of the current variant of a library.
   *
   * @param string $name
   *   The machine-readable name of the library to return the variant name for.
   *
   * @return string
   *   The machine-readable name of the library variant.
   *
   * @throws \Drupal\libraries\LibraryManager\Exception\LibraryDoesNotHaveVariantsException
   */
  public function getVariantName($name);

  /**
   * Gets the translated, human-readable label of the current variant of a library.
   *
   * @param string $name
   *   The machine-readable name of the library to return the variant label for.
   *
   * @return string
   *   The translated, human-readable label of the library variant.
   *
   * @throws \Drupal\libraries\LibraryManager\Exception\LibraryDoesNotHaveVariantsException
   */
  public function getVariantLabel($name);

  /**
   * Sets the current variant of a library.
   *
   * @param string $name
   *   The machine-readable name of the library.
   * @param string $variant
   *   The machine-readable name of the variant to set.
   *
   * @throws \Drupal\libraries\LibraryManager\Exception\LibraryDoesNotHaveVariantsException
   */
  public function setVariant($name, $variant);
}

