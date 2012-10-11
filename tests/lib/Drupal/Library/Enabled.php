<?php

/**
 * @file
 * Definition of Drupal\libraries\Tests\Library\Enabled.
 */

namespace Drupal\Library;

use Drupal\libraries\Annotation\Library;

/**
 * @Library(
 *   label = "Enabled test library",
 *   vendor = "example_vendor",
 *   package = "example_package"
 * )
 */
class Enabled extends TestLibraryBase {}

