<?php

/**
 * @file
 * Definition of \Drupal\libraries\Tests\LibraryClassDiscoveryTest.
 */

namespace Drupal\libraries\Tests;

use Drupal\simpletest\UnitTestBase;
use Drupal\libraries\LibraryManager\Discovery\AnnotatedLibraryClassDiscovery;

/**
 * Tests the discovery of library classes.
 */
class LibraryClassDiscoveryTest extends UnitTestBase {

  public static function getInfo() {
    return array(
      'name' => 'Library class discovery',
      'description' => 'Tests the discovery of library classes.',
      'group' => 'Libraries API',
    );
  }

  public function setUp() {
    parent::setUp();
    // Allow the Example library class to be found.
    drupal_classloader_register('Library', drupal_get_path('module', 'libraries') . '/tests');
  }

  /**
   * Tests AnnotatedLibraryClassDiscovery.
   */
  public function testAnnotatedLibraryClassDiscovery() {
    $discovery = new AnnotatedLibraryClassDiscovery();

    // Test that AnnotatedLibraryClassDiscovery does not throw errors when used
    // without setting paths before.
    $this->assertIdentical($discovery->getAllLibraryInfo(), array());
    $this->assertIdentical($discovery->getLibraryInfo('Example'), NULL);

    // Now set the proper test path to actually test library class discovery.
    $test_path = implode(DIRECTORY_SEPARATOR, array(
      DRUPAL_ROOT,
      drupal_get_path('module', 'libraries'),
      'tests',
      'lib',
    ));
    $discovery->setPaths(array($test_path));

    // Test AnnotatedLibraryClassDiscovery::getDefinitions().
    $expected = array(
      'Example' => array(
        'label' => 'Example test library',
        'vendor' => 'example_vendor',
        'package' => 'example_package',
        'name' => 'Example',
      ),
    );
    $this->assertEqual($discovery->getAllLibraryInfo(), $expected);

    // Test AnnotatedLibraryClassDiscovery::getLibraryInfo().
    $this->assertEqual($discovery->getLibraryInfo('Example'), $expected['Example']);
    $this->assertIdentical($discovery->getLibraryInfo('Missing'), NULL);
  }
}
