<?php

/**
 * @file
 * Definition of \Drupal\libraries\Library\LibraryBase.
 */

namespace Drupal\libraries\Library;

use Drupal\libraries\Library\Exception\VersionUndeterminedException;

/**
 * Defines a base library for typical implementations.
 */
abstract class LibraryBase implements LibraryInterface{

  /**
   * Implements LibraryInterface::getName().
   *
   * The fact that the machine-readable name of a library is identical to the
   * class name of its library class is integral to the concept of Libraries API
   * because we need to instantiate an instance of the library class given only
   * the machine-readable name. That is why this method is final. Any classes
   * implementing LibraryInterface without sub-classing this class are strongly
   * encouraged to copy this method.
   */
  final public function getName() {
    return get_class($this);
  }
}
