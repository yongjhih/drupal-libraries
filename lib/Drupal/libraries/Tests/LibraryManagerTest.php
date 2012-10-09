<?php

/**
 * @file
 * Definition of \Drupal\libraries\Tests\LibraryManagerTest.
 */

namespace Drupal\libraries\Tests;

use Drupal\simpletest\UnitTestBase;
use Drupal\libraries\LibraryManager\DefaultLibraryManager;
use Drupal\libraries\Tests\MockLibraryInfoDiscovery;

/**
 * Tests the discovery of library classes.
 */
class LibraryManagerTest extends UnitTestBase {

  public static function getInfo() {
    return array(
      'name' => 'Library manager',
      'description' => 'Tests the library manager functionality.',
      'group' => 'Libraries API',
    );
  }

  /**
   * Tests DefaultLibraryManager.
   */
  public function testDefaultLibraryManager() {
    $libraries = array(
      'Example' => array(
        'name' => 'Example',
        'label' => 'Example test library',
        'vendor' => 'example_vendor',
        'package' => 'example_package',
      ),
    );
    $discovery = new MockLibraryInfoDiscovery($libraries);
    $manager = new DefaultLibraryManager($discovery);

    // Tests that getAllLibraryInfo() is dispatched to the discovery object.
    $this->assertIdentical($discovery->getAllLibraryInfo(), $manager->getAllLibraryInfo());

    // Tests that getLibraryInfo() is dispatched to the discovery object.
    foreach ($libraries as $name => $library) {
      $this->assertIdentical($discovery->getLibraryInfo($name), $manager->getLibraryInfo($name));
    }
  }
}
