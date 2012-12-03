<?php

/**
 * @file
 * Contains \Drupal\libraries\LibraryManager\StatusStorage\ConfigLibraryStatusStorage.
 */

namespace Drupal\libraries\LibraryManager\StatusStorage;

use Drupal\Core\Config\Config;

/**
 * Provides a library status manager that stores library status in config.
 *
 * @todo Re-visit usage of the ternary operator per
 *   http://drupal.org/node/1838368
 */
class ConfigLibraryStatusStorage implements LibraryStatusStorageInterface {

  /**
   * A config object to store library status in.
   *
   * This corresponds to the 'libraries.library' configuration object.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * Constructs a ConfigLibraryStatusManager object.
   */
  public function __construct(Config $config) {
    $this->config = $config->load();
  }

  /**
   * Implements LibraryStatusManagerInterface::isEnabled().
   */
  public function isEnabled($name) {
    return in_array($name, $this->config->get('enabled') ?: array());
  }

  /**
   * Implements LibraryStatusManagerInterface::setEnabled().
   */
  public function setEnabled($name) {
    $enabled = ($this->config->get('enabled') ?: array()) + array($name);
    $this->config->set('enabled', $enabled)->save();
  }

  /**
   * Implements LibraryStatusManagerInterface::setDisabled().
   */
  public function setDisabled($name) {
    $enabled = array_diff(($this->config->get('enabled') ?: array()), array($name));
    $this->config->set('enabled', $enabled)->save();
  }

  /**
   * Implements LibraryStatusManagerInterface::getVariant().
   */
  public function getVariant($name) {
    return $this->config->get("variant.$name");
  }

  /**
   * Implements LibraryStatusManagerInterface::setVariant().
   */
  public function setVariant($name, $variant) {
    $this->config->set("variant.$name", $variant)->save();
  }

  /**
   * Implements LibraryStatusManagerInterface::unsetVariant().
   */
  public function unsetVariant($name) {
    $this->config->clear("variant.$name")->save();
  }
}
