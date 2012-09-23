<?php

/**
 * @file
 * Definition of \Drupal\libraries\LibraryManager\DefaultLibraryManager.
 */

namespace Drupal\libraries\LibraryManager;

use Drupal\libraries\LibraryManager\Discovery\LibraryClassDiscoveryInterface;

/**
 * Provides a default library manager.
 *
 * @see \Drupal\Component\Plugin\PluginManagerBase
 */
class DefaultLibraryManager implements LibraryManagerInterface {

  /**
   * The library class discovery object to use.
   */
  protected $discovery;

  /**
   * Constructs a DefaultLibraryManager object.
   */
  public function __construct(LibraryClassDiscoveryInterface $discovery) {
    $this->discovery = $discovery;
  }

  /**
   * Implements LibraryManagerInterface::getLibraryInfo().
   */
  public function getLibraryInfo($name) {
    return $this->discovery->getLibraryInfo($name);
  }

  /**
   * Implements LibraryManagerInterface::setDiscovery().
   */
  public function getAllLibraryInfo() {
    return $this->discovery->getAllLibraryInfo();
  }

  /**
   * Implements LibraryManagerInterface::setPaths().
   */
  public function setPaths($paths) {
    $this->discovery->setPaths($paths);
  }
}
