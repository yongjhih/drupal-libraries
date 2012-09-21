<?php

/**
 * @file
 * Definition of \Drupal\libraries\Library\VariantLibraryInterface.
 */

namespace Drupal\libraries\Library;

/**
 * Defines a common interface for all libraries that have multiple variants.
 *
 * These libraries should provide information about the possible variants in
 * their library definition. The value to the 'variants' key should be an object
 * with a key for each machine-readable variant name. The corresponding values
 * are the translated, human-readable labels. If a certain variant should be
 * active by default, this should be declared with the 'default variant' key.
 * The corresponding value should be the machine-readable name of the variant.
 * If no default variant is specified, a variant must be specified before the
 * library can be used.
 * For example, if a library has a 'source' and a 'minified' variant:
 * @code
 *  **
 *  * @Library(
 *  *   ...
 *  *   variants: {
 *  *     source: @Translation("Source"),
 *  *     minified: @Translation("Minified")
 *  *   }
 *  *   defaultVariant: "minified",
 *  * )
 *  *
 * class Example {
 *   ...
 * }
 * @endcode
 * (The '/' are omitted from the PHPDoc in the code example.)
 */
interface VariantLibraryInterface extends LibraryInterface {

  /**
   * Gets the name of the currently active variant.
   *
   * In case the library does not specify a default variant and no variant has
   * been set previously, an exception is thrown.
   *
   * @return string
   *   The machine-readable name of the variant.
   *
   * @throws \Drupal\libraries\Library\Exception\VariantUndeterminedException
   *
   * @see \Drupal\libraries\Library\VariantLibraryInterface::setVariant()
   */
  public function getVariant();


  /**
   * Sets the given variant as active.
   *
   * If the library is loaded subsequently, this variant is used.
   *
   * In case an unsupported or uninstalled variant ist passed to this method, an
   * exception is thrown.
   *
   * @param string $variant
   *   The machine-readable name of the variant.
   *
   * @throws \Drupal\libraries\Library\Exception\InvalidVariantException
   * @throws \Drupal\libraries\Library\Exception\UninstalledVariantException
   *
   * @see \Drupal\libraries\Library\VariantLibraryInterface::variantIsInstalled()
   */
  public function setVariant($variant);

  /**
   * Checks whether a given variant is installed.
   *
   * @param string $variant
   *   The machine-readable name of the variant.
   *
   * @return bool
   *   Whether or not a given variant is installed.
   */
  public function variantIsInstalled($variant);
}
