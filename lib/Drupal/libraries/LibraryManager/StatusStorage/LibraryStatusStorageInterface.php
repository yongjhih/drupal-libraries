<?php

/**
 * Contains \Drupal\libraries\LibraryManager\StatusStorage\LibraryStatusStorageInterface.
 */

namespace Drupal\libraries\LibraryManager\StatusStorage;

/**
 * Provides a common interface for library status storages.
 *
 * @see \Drupal\Component\Plugin\PluginManagerInterface
 */
interface LibraryStatusStorageInterface {

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
   * Sets a library as enabled.
   *
   * @param string $name
   *   The machine-readable name of the library to enable.
   */
  public function setEnabled($name);

  /**
   * Sets a library as disabled.
   *
   * @param string $name
   *   The machine-readable name of the library to disable.
   */
  public function setDisabled($name);

  /**
   * Gets the name of the current variant of a library.
   *
   * @param string $name
   *   The machine-readable name of the library to return the variant name for.
   *
   * @return string|null
   *   The machine-readable name of the library variant, or NULL if the library
   *   does not have a variant.
   */
  public function getVariant($name);

  /**
   * Sets the current variant of a library.
   *
   * @param string $name
   *   The machine-readable name of the library.
   * @param string $variant
   *   The machine-readable name of the variant to set.
   */
  public function setVariant($name, $variant);

  /**
   * Unsets the current variant of a library.
   *
   * @param string $name
   *   The machine-readable name of the library whose variant to unset.
   */
  public function unsetVariant($name);
}

