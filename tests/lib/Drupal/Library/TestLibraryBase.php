<?php

/**
 * @file
 * Contains \Drupal\libraries\Tests\Library\Disabled.
 */

namespace Drupal\Library;

use Drupal\libraries\Annotation\Library;
use Drupal\libraries\Library\LibraryBase;

/**
 * Defines a base class for all test library classes.
 */
class TestLibraryBase extends LibraryBase {

  /**
   * Implements LibraryInterface::isInstalled().
   */
  public function isInstalled() {
    return TRUE;
  }

  /**
   * Implements LibraryInterface::getVersion().
   */
  public function getVersion() {
    return '1.0';
  }

  /**
   * Implements LibraryInterface::install().
   */
  public function install() {}

  /**
   * Implements LibraryInterface::enable().
   */
  public function enable() {}

  /**
   * Implements LibraryInterface::disable().
   */
  public function disable() {}
}

