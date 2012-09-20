<?php

/**
 * @file
 * Definition of Drupal\libraries\Tests\Library\Example.
 */

namespace Drupal\Library;

use Drupal\libraries\Annotation\Library;

/**
 * @Library(
 *   label = "Example test library",
 *   vendor = "example_vendor",
 *   package = "example_package"
 * )
 */
class Example {
  protected $dir = 'test';
}
