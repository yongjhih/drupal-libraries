<?php

/**
 * @file
 * Contains \Drupal\libraries\Tests\LibraryInfoDiscoveryTest.
 */

namespace Drupal\libraries\Tests;

use Drupal\simpletest\DrupalUnitTestBase;
use Drupal\libraries\LibraryManager\Discovery\AnnotatedLibraryClassDiscovery;

/**
 * Tests the discovery of library classes.
 */
class LibraryInfoDiscoveryTest extends DrupalUnitTestBase {

  /**
   * An array of modules to install.
   *
   * @var array
   */
  static $modules = array('libraries', 'libraries_test');

  public static function getInfo() {
    return array(
      'name' => 'Library info discovery',
      'description' => 'Tests the discovery of library information.',
      'group' => 'Libraries API',
    );
  }

  /**
   * Tests AnnotatedLibraryClassDiscovery.
   */
  public function testAnnotatedLibraryClassDiscovery() {
    // Test that AnnotatedLibraryClassDiscovery does not throw errors when used
    // without setting paths.
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
      'NotInstalled' => array(
        'label' => 'Test library with missing library files',
        'vendor' => 'example_vendor',
        'package' => 'example_package',
        'name' => 'NotInstalled',
      ),
      'Disabled' => array(
        'label' => 'Disabled test library',
        'vendor' => 'example_vendor',
        'package' => 'example_package',
        'name' => 'Disabled',
      ),
      'IncompatibleVersion' => array(
        'label' => 'Test library with incompatible version',
        'vendor' => 'example_vendor',
        'package' => 'example_package',
        'name' => 'IncompatibleVersion',
      ),
      'Enabled' => array(
        'label' => 'Enabled test library',
        'vendor' => 'example_vendor',
        'package' => 'example_package',
        'name' => 'Enabled',
      ),
    );
    $this->assertEqual($discovery->getAllLibraryInfo(), $all_expected);

    // Test AnnotatedLibraryClassDiscovery::getLibraryInfo().
    foreach ($all_expected as $name => $expected) {
      $this->assertEqual($discovery->getLibraryInfo($name), $expected);
    }
  }
}
