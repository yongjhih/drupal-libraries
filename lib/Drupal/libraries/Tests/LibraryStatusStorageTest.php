<?php

/**
 * @file
 * Contains \Drupal\libraries\Tests\LibraryStatusStorageTest.
 */

namespace Drupal\libraries\Tests;

use Drupal\simpletest\UnitTestBase;
use Drupal\libraries\LibraryManager\StatusStorage\ConfigLibraryStatusStorage;

/**
 * Tests the discovery of library classes.
 */
class LibraryStatusStorageTest extends UnitTestBase {

  public static function getInfo() {
    return array(
      'name' => 'Library status storage',
      'description' => 'Tests setting libraries as enabled and disabled and the setting of variants.',
      'group' => 'Libraries API',
    );
  }

  /**
   * Tests ConfigLibraryStatusStorage.
   *
   * In contrast to the actual library manager, the status storage does not
   * require the specified library to actually exist.
   *
   * @see \Drupal\libraries\LibraryManager\LibraryManagerInterface
   */
  public function testConfigLibraryStatusStorage() {
    $config = drupal_container()->get('config.factory')->get('libraries.library');
    $statusStorage = new ConfigLibraryStatusStorage($config);

    $this->assertFalse($statusStorage->isEnabled('example'));
    $statusStorage->setEnabled('example');
    $this->assertTrue($statusStorage->isEnabled('example'));
    $statusStorage->setDisabled('example');
    $this->assertFalse($statusStorage->isEnabled('example'));

    $this->assertNull($statusStorage->getVariant('example'));
    $statusStorage->setVariant('example', 'variant');
    $this->assertEqual('variant', $statusStorage->getVariant('example'));
    $statusStorage->unsetVariant('example');
    $this->assertNull($statusStorage->getVariant('example'));
  }

}
