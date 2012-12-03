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
    // @todo Use this anonymous function to also build an array of paths to
    //  search for library files.
    $paths = $this->getPaths();
    $map = function ($suffix) use ($paths) {
      $append = function ($path) use ($suffix) {
        return "$path/$suffix";
      };
      return array_map($append, $paths);
    };

    $this->discovery = new AnnotatedLibraryClassDiscovery($map('lib'));
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

  /**
   * Returns an array of paths to search for library classes and files.
   *
   * Separating this out into a function allows library functionality to be
   * tested, even though in tests we can never assume library classes or files
   * to exist in the locations where they would be found.
   *
   * @return array
   *
   * @see \Drupal\libraries\Tests\TestLibraryManager::getPaths()
   */
  protected function getPaths() {
    return array(
      DRUPAL_ROOT . '/' . conf_path(),
      DRUPAL_ROOT,
      DRUPAL_ROOT . '/' . drupal_get_path('profile', drupal_get_profile()),
      DRUPAL_ROOT . '/core',
    );
  }
}

