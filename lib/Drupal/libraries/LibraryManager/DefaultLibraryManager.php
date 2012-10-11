<?php

/**
 * @file
 * Definition of \Drupal\libraries\LibraryManager\DefaultLibraryManager.
 */

namespace Drupal\libraries\LibraryManager;

use Drupal\Core\KeyValueStore\KeyValueStoreInterface;
use Drupal\libraries\LibraryManager\Discovery\LibraryInfoDiscoveryInterface;
use Drupal\libraries\LibraryManager\Exception\LibraryClassNotFoundException;

/**
 * Provides a default library manager.
 *
 * @see \Drupal\Component\Plugin\PluginManagerBase
 */
class DefaultLibraryManager implements LibraryManagerInterface {

  /**
   * The library class discovery object to use.
   *
   * @var \Drupal\libraries\LibraryManager\Discovery\LibraryInfoDiscoveryInterface
   */
  protected $discovery;

  /**
   * The key value store to track which libraries are enabled.
   *
   * @var \Drupal\Core\KeyValueStore\KeyValueStoreInterface
   */
  protected $keyValueStore;

  /**
   * An array of library instances.
   *
   * @var array
   */
  protected $instances = array();

  /**
   * Constructs a DefaultLibraryManager object.
   */
  public function __construct(LibraryInfoDiscoveryInterface $discovery, KeyValueStoreInterface $keyValueStore) {
    $this->discovery = $discovery;
    $this->keyValueStore = $keyValueStore;
  }

  /**
   * Implements LibraryManagerInterface::getLibraryInfo().
   */
  public function getLibraryInfo($name) {
    return $this->discovery->getLibraryInfo($name);
  }

  /**
   * Implements LibraryManagerInterface::getAllLibraryInfo().
   */
  public function getAllLibraryInfo() {
    return $this->discovery->getAllLibraryInfo();
  }

  /**
   * Implements LibraryManagerInterface::getLibraryInstance().
   */
  public function getLibraryInstance($name) {
    if (!isset($this->instances[$name])) {
      $class = "Drupal\\Library\\$name";
      $this->instances[$name] = new $class();
    }
    return $this->instances[$name];
  }

  /**
   * Implements LibraryManagerInterface::isEnabled().
   */
  public function isEnabled($name) {
    return in_array($name, $this->keyValueStore->get('libraries.enabled_libraries') ?: array());
  }

  /**
   * Implements LibraryManagerInterface::enable().
   */
  public function enable($name) {
    $enabled_libraries = $this->keyValueStore->get('libraries.enabled_libraries') ?: array();
    $enabled_libraries[$name] = $name;
    $this->keyValueStore->set('libraries.enabled_libraries', $enabled_libraries);

    $this->getLibraryInstance($name)->enable();
  }

  public function disable($name) {
    $enabled_libraries = $this->keyValueStore->get('libraries.enabled_libraries') ?: array();
    unset($enabled_libraries[$name]);
    $this->keyValueStore->set('libraries.enabled_libraries', $enabled_libraries);

    $this->getLibraryInstance($name)->disable();
  }

}
