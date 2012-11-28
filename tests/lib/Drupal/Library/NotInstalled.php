<?php

/**
 * @file
 * Contains \Drupal\libraries\Tests\Library\NotInstalled.
 */

namespace Drupal\Library;

use Drupal\libraries\Annotation\Library;

/**
 * @Library(
 *   label = "Test library with missing library files",
 *   vendor = "example_vendor",
 *   package = "example_package"
 * )
 */
class NotInstalled extends TestLibraryBase {

  /**
   * Implements LibraryInterface::isInstalled().
   */
  public function isInstalled() {
    return FALSE;
  }
}

