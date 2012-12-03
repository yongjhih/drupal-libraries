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
   * Overrides DefaultLibraryManager::getPaths().
   */
  protected function getPaths() {
    return array(DRUPAL_ROOT . '/' . drupal_get_path('module', 'libraries') . '/tests');
  }

}
