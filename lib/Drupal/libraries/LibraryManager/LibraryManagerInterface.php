<?php

/**
 * Definition of \Drupal\libraries\LibraryManager\LibraryManagerInterface.
 */

namespace Drupal\libraries\LibraryManager;

use Drupal\libraries\LibraryManager\Discovery\LibraryClassDiscoveryInterface;

/**
 * Provides a common interface for library managers.
 *
 * @see \Drupal\Component\Plugin\PluginManagerInterface
 */
interface LibraryManagerInterface extends LibraryClassDiscoveryInterface {}
