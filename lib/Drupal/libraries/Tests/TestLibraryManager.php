<?php

/**
 * @file
 * Contains \Drupal\libraries\Tests\TestLibraryManager.
 */

namespace Drupal\libraries\Tests;

use Drupal\libraries\LibraryManager\DefaultLibraryManager;
use Drupal\Core\Config\ConfigFactory;
use Drupal\libraries\LibraryManager\Discovery\AnnotatedLibraryClassDiscovery;
use Drupal\libraries\LibraryManager\Mapper\StaticLibraryMapper;
use Drupal\libraries\LibraryManager\StatusStorage\ConfigLibraryStatusStorage;

/**
 * Provides a default library manager.
 *
 * @see \Drupal\Component\Plugin\PluginManagerBase
 */
class TestLibraryManager extends DefaultLibraryManager {

  /**
   * Constructs a TestLibraryManager object.
   *
   * Except for the Contains $paths this is identical to
   * DefaultLibraryManager::__construct().
   *
   * @param \Drupal\Core\Config\ConfigFactory $configFactory
   *   A configuration factory object.
   *
   * @todo Find a way to override the paths without duplicating the entire
   *   constructor.
   */
  public function __construct(ConfigFactory $configFactory) {
    // Build an array of root paths to search for both library classes and
    // library files in declining order of precedence.
    $paths = array(DRUPAL_ROOT . '/' . drupal_get_path('module', 'libraries') . '/tests');

    $map = function ($suffix) use ($paths) {
      $append = function ($path) use ($suffix) {
        return "$path/$suffix";
      };
      return array_map($append, $paths);
    };

    $class_paths = $map('lib');
    $library_paths = $map('libraries');

    $this->discovery = new AnnotatedLibraryClassDiscovery($class_paths);
    $this->mapper = new StaticLibraryMapper();
    $this->statusStorage = new ConfigLibraryStatusStorage($configFactory->get('libraries.library'));
  }

  /**
   * Overrides ConfigLibraryStatusStorage::isEnabled().
   */
  public function isEnabled($name) {
    return $name == 'Enabled';
  }

}
