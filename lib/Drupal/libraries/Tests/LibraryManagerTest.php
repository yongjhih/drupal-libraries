<?php

/**
 * @file
 * Definition of \Drupal\libraries\Tests\LibraryManagerTest.
 */

namespace Drupal\libraries\Tests;

use Drupal\simpletest\UnitTestBase;
use Drupal\libraries\LibraryManager\DefaultLibraryManager;
use Drupal\libraries\Tests\MockLibraryClassDiscovery;

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
   * Tests AnnotatedLibraryClassDiscovery.
   */
  public function testDefaultLibraryManager() {
    $libraries = array(
      'Example' => array(
        'label' => 'Example test library',
        'vendor' => 'example',
        'package' => 'example',
      ),
    );
    $discovery = new MockLibraryClassDiscovery($libraries);
    $manager = new DefaultLibraryManager($discovery);

    // Tests that getLibraryInfo() is dispatched to the discovery object.
    $this->assertIdentical($discovery->getLibraryInfo('Example'), $manager->getLibraryInfo('Example'));
    $this->assertIdentical($discovery->getLibraryInfo('Missing'), $manager->getLibraryInfo('Missing'));

    // Tests that getAllLibraryInfo() is dispatched to the discovery object.
    $this->assertIdentical($discovery->getAllLibraryInfo(), $manager->getAllLibraryInfo());

    // Tests that setPaths() is dispatched to the discovery object.
    $this->assertEqual($discovery->paths, array());
    $paths = array('a', 'b', 'c');
    $manager->setPaths($paths);
    $this->assertEqual($discovery->paths, $paths);
  }
}
