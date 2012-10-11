<?php

/**
 * @file
 * Definition of Drupal\libraries\Tests\Library\Disabled.
 */

namespace Drupal\Library;

use Drupal\libraries\Annotation\Library;


/**
 * @Library(
 *   label = "Disabled test library",
 *   vendor = "example_vendor",
 *   package = "example_package"
 * )
 */
class Disabled extends TestLibraryBase {}

