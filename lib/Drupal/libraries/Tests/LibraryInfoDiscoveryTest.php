<?php

/**
 * @file
 * Definition of \Drupal\libraries\Tests\LibraryInfoDiscoveryTest.
 */

namespace Drupal\libraries\Tests;

use Drupal\simpletest\UnitTestBase;
use Drupal\libraries\LibraryManager\Discovery\AnnotatedLibraryClassDiscovery;

/**
 * Tests the discovery of library classes.
 */
class LibraryInfoDiscoveryTest extends UnitTestBase {

  public static function getInfo() {
    return array(
      'name' => 'Library info discovery',
      'description' => 'Tests the discovery of library information.',
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
    // Test that AnnotatedLibraryClassDiscovery does not throw errors when used
    // without setting paths before.
    $discovery = new AnnotatedLibraryClassDiscovery(array());
    $this->assertIdentical($discovery->getAllLibraryInfo(), array());
    $this->assertIdentical($discovery->getLibraryInfo('Example'), NULL);

    // Now set the proper test path to actually test library class discovery.
    $test_path = implode(DIRECTORY_SEPARATOR, array(
      DRUPAL_ROOT,
      drupal_get_path('module', 'libraries'),
      'tests',
      'lib',
    ));
    $discovery = new AnnotatedLibraryClassDiscovery(array($test_path));

    // Test AnnotatedLibraryClassDiscovery::getAllLibraryInfo().
    $all_expected = array(
      'Example' => array(
        'name' => 'Example',
        'label' => 'Example test library',
        'vendor' => 'example_vendor',
        'package' => 'example_package',
      ),
    );
    $this->assertEqual($discovery->getAllLibraryInfo(), $all_expected);

    // Test AnnotatedLibraryClassDiscovery::getLibraryInfo().
    foreach ($expected as $name => $expected) {
      $this->assertEqual($discovery->getLibraryInfo($name), $expected);
    }
  }
}
