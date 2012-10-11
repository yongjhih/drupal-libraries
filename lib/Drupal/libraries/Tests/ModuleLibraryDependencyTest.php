<?php

/**
 * @file
 * Definition of \Drupal\libraries\Tests\ModuleLibraryDependencyTest.
 */

namespace Drupal\libraries\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests that modules that depend on libraries are handled correctly.
 */
class ModuleLibraryDependencyTest extends WebTestBase {
  static $modules = array('libraries', 'libraries_test');

  public static function getInfo() {
    return array(
      'name' => 'Module dependency',
      'description' => 'Tests that modules that depend on libraries are handled correctly.',
      'group' => 'Libraries API',
    );
  }

  public function setUp() {
    parent::setUp();
    // Allow the test library classes to be autoloaded.
    drupal_classloader_register('Library', drupal_get_path('module', 'libraries') . '/tests');
    // Make the library manager discover the test library classes.
    $test_path = implode(DIRECTORY_SEPARATOR, array(
      DRUPAL_ROOT,
      drupal_get_path('module', 'libraries'),
      'tests',
      'lib',
    ));
    drupal_container()->getDefinition('libraries.library_manager.discovery')->replaceArgument(0, array($test_path));
    $admin_user = $this->drupalCreateUser(array('administer modules'));
    $this->drupalLogin($admin_user);
  }

  public function testModulePage() {
    $this->drupalGet('admin/modules');
  }

}

