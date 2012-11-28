<?php

/**
 * @file
 * Contains \Drupal\libraries\LibraryManager\DefaultLibraryManager.
 */

namespace Drupal\libraries\LibraryManager;

use Drupal\Core\Config\ConfigFactory;
use Drupal\libraries\LibraryManager\Discovery\AnnotatedLibraryClassDiscovery;
use Drupal\libraries\LibraryManager\Mapper\StaticLibraryMapper;
use Drupal\libraries\LibraryManager\StatusStorage\ConfigLibraryStatusStorage;

/**
 * Provides a default library manager.
 *
 * @see \Drupal\Component\Plugin\PluginManagerBase
 */
class DefaultLibraryManager implements LibraryManagerInterface {

  /**
   * The library info discovery mechanism to use.
   *
   * @var \Drupal\libraries\LibraryManager\Discovery\AnnotatedLibraryInfoDiscovery
   */
  protected $discovery;

  /**
   * The library factory to use.
   *
   * @var \Drupal\libraries\LibraryManager\Factory\LibraryFactoryInterface
   */
  protected $mapper;

  /**
   * The status storage for library status information.
   *
   * @var \Drupal\libraries\LibraryManager\StatusStorage\LibraryStatusStorageInterface
   */
  protected $statusStorage;

  /**
   * An array of library instances.
   *
   * @var array
   */
  protected $instances = array();

  /**
   * Constructs a DefaultLibraryManager object.
   *
   * @param \Drupal\Core\Config\ConfigFactory $configFactory
   *   A configuration factory object.
   */
  public function __construct(ConfigFactory $configFactory) {
    // Build an array of root paths to search for both library classes and
    // library files in declining order of precedence.
    $paths = array(
      DRUPAL_ROOT . '/' . conf_path(),
      DRUPAL_ROOT,
      DRUPAL_ROOT . '/' . drupal_get_path('profile', drupal_get_profile()),
      DRUPAL_ROOT . '/core',
    );

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
   * Implements LibraryManagerInterface::createLibraryInstance().
   */
  public function getLibraryInstance($name) {
    return $this->mapper->getLibraryInstance($name);
  }

  /**
   * Implements LibraryManagerInterface::isEnabled().
   */
  public function isEnabled($name) {
    return $this->statusStorage->isEnabled($name);
  }

  /**
   * Implements LibraryManagerInterface::enable().
   */
  public function enable($name) {
    if (!$this->statusStorage->isEnabled()) {
      $this->statusStorage->setEnabled($name);
      $library = $this->getLibraryInstance($name);
      if ($library instanceof VariantLibraryInterface) {
        $info = $this->getLibraryInfo($name);
        if (isset($info['default variant'])) {
          $this->setActiveVariant($name);
        }
      }
      $library->enable();
    }
  }

  /**
   * Implements LibraryManagerInterface::disabled().
   */
  public function disable($name) {
    if ($this->statusStorage->isEnabled()) {
      $this->statusStorage->setDisabled($name);
      $library = $this->getLibraryInstance($name);
      if ($library instanceof VariantLibraryInterface) {
        $this->statusStorage->unsetVariant($name);
      }
      $library->disable();
    }
  }

  /**
   * Implements LibraryManagerInterface::getVariantName().
   */
  public function getVariantName($name) {
    $this->statusManager->getVariant($name);
  }

  /**
   * Implements LibraryManagerInterface::getVariantLabel().
   */
  public function getVariantLabel($name) {
    $variant_name = $this->statusStorage->getVariant($name);
    if ($variant_name) {
      $info = $this->discovery->getLibraryInfo($name);
      return $info['variants'][$variant_name];
    }
  }

  /**
   * Implements LibraryManagerInterface::setVariant().
   */
  public function setVariant($name, $variant) {
    $this->statusManager->setVariant($name, $variant);
  }
}
