<?php

/**
 * @file
 * Definition of \Drupal\libraries\Library\LibraryInterface.
 */

namespace Drupal\libraries\Library;

/**
 * Defines a common interface for all libraries.
 *
 * Libraries should declare their label and their vendor and package as
 * specified in the project's composer.json file using Annotations. For example:
 * @code
 *  **
 *  * @Library(
 *  *   label: "Example",
 *  *   vendor: "example",
 *  *   package: "example"
 *  * )
 *  *
 * class Example {
 *   ...
 * }
 * @endcode
 * (The '/' are omitted from the PHPDoc in the code example.)
 * Because the Composer information is used to download the library from
 * Packagist, only libraries that contain a composer.json file are supported.
 * Packagist has become the de-facto package manager in the PHP world, so this
 * should not be seen as a limitation of Libraries API. Instead, libraries that
 * do not already should be encouraged to include a composer.json file upstream.
 */
interface LibraryInterface {

  /**
   * Gets the machine-readable name of the library.
   *
   * This should be identical to the class name of the library class.
   *
   * @return string
   *   The machine-readable name of the library.
   *
   * @see \Drupal\libraries\Library\LibraryBase::getName()
   */
  public function getName();

  /**
   * Checks whether or not the library files are available.
   *
   * @return bool
   *   Whether or not the library is installed.
   */
  public function isInstalled();

  /**
   * Downloads the library files from the vendor and makes them available.
   *
   * LibraryBase::install() automatically downloads the library files from
   * Packagist using the vendor and package information. Libraries that are
   * available externally, i.e. do not need to be installed, are also catered
   * for.
   *
   * @throws \Drupal\libraries\Library\Exception\InstallationException
   *
   * @see \Drupal\libraries\Library\LibraryBase::install()
   */
  public function install();

  /**
   * Returns the version of the library.
   *
   * Because Drupal modules and themes that integrate with an external library
   * need to be able to specify compatibility as the library code changes, only
   * libraries that have explicit versions are supported.
   *
   * To facilitate the usual case, where the version string is embedded in a
   * file inside the library (e.g. CHANGELOG.txt or README.txt),
   * LibraryBase::getVersionFromFile() is provided.
   *
   * @return string
   *   A version string, for example '1.2.3'.
   *
   * @throws \Drupal\libraries\Library\Exception\VersionUndeterminedException
   *
   * @see \Drupal\libraries\Library\LibraryBase::getVersionFromFile()
   */
  public function getVersion();

  /**
   * Enables the library.
   *
   * For JavaScript or CSS libraries, which are loaded on-demand, nothing needs
   * to be done when enabling. PHP libraries that provide autoloadable classes,
   * on the other hand, should use this method to register their namespaces.
   * LibraryBase supports defining a $namespaces class variable and registers
   * the provided namespaces automatically.
   *
   * @see \Drupal\libraries\Library\LibraryBase::enable()
   */
  public function enable();

  /**
   * Disables the library.
   *
   * @see \Drupal\libraries\Library\LibraryBase::disable()
   */
  public function disable();
}
