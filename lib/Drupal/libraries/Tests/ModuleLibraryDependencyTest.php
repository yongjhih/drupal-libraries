<?php

/**
 * @file
 * Contains \Drupal\libraries\Tests\ModuleLibraryDependencyTest.
 */

namespace Drupal\libraries\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests that modules that depend on libraries are handled correctly.
 */
class ModuleLibraryDependencyTest extends WebTestBase {

  /**
   * An array of modules to install.
   *
   * @var array
   */
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

    $admin_user = $this->drupalCreateUser(array('administer modules'));
    $this->drupalLogin($admin_user);
  }

  public function testModulePage() {
    $this->drupalGet('admin/modules');
    $this->assertRaw('Enabled test library (Library) (<span class="admin-enabled">enabled</span>)');
    $this->assertRaw('Disabled test library (Library) (<span class="admin-disabled">disabled</span>)');
    $this->assertRaw('Test library with incompatible version (Library) (<span class="admin-missing">incompatible version</span>)');
    $this->assertRaw('Test library with missing library files (Library) (<span class="admin-missing">missing files</span>)');
    $this->assertRaw('MissingInfo (Library) (<span class="admin-missing">missing information</span>)');
  }

}

