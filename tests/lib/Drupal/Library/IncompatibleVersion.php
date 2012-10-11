<?php

/**
 * @file
 * Definition of Drupal\libraries\Tests\Library\IncompatibleVersion.
 */

namespace Drupal\Library;

use Drupal\libraries\Annotation\Library;

/**
 * @Library(
 *   label = "Test library with incompatible version",
 *   vendor = "example_vendor",
 *   package = "example_package"
 * )
 */
class IncompatibleVersion extends TestLibraryBase {}

