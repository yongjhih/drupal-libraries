<?php

/**
 * @file
 * Definition of \Drupal\libraries\LibraryManager\Discovery\AnnotatedLibraryClassDiscovery
 */

namespace Drupal\libraries\LibraryManager\Discovery;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Reflection\StaticReflectionParser;

use Drupal\Component\Plugin\Discovery\DiscoveryInterface;
use Drupal\Component\Reflection\MockFileFinder;

/**
 * Defines a discovery mechanism to find annotated library classes.
 */
class AnnotatedLibraryClassDiscovery implements LibraryClassDiscoveryInterface {

  /**
   * A list of paths to search for library classes.
   *
   * @var array|\Traversable
   */
  protected $paths = array();

  /**
   * Implements LibraryClassDiscoveryInterface::setPaths().
   */
  public function setPaths($paths) {
    $this->paths = $paths;
  }

  /**
   * Implements LibraryClassDiscoveryInterface::getDefinition().
   */
  public function getDefinition($plugin_id) {
    $plugins = $this->getDefinitions();
    return isset($plugins[$plugin_id]) ? $plugins[$plugin_id] : NULL;
  }

  /**
   * Implements LibraryClassDiscoveryInterface::getDefinitions().
   */
  public function getDefinitions() {
    $reader = new AnnotationReader();

    AnnotationRegistry::registerAutoloadNamespace('Drupal\libraries\Annotation', array(drupal_get_path('module', 'libraries') . '/lib'));

    // Directories to search for library classes.
    // We need to use OS-safe directory separators.
    // @see \Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery
    $namespace_path = 'Drupal' . DIRECTORY_SEPARATOR . 'Library';
    $directories = array_map(function($path) use ($namespace_path) {
      return $path . DIRECTORY_SEPARATOR . $namespace_path ;
    }, $this->paths);

    $definitions = array();
    foreach ($directories as $directory) {
      if (is_dir($directory)) {
        $directory_info = new \DirectoryIterator($directory);
        foreach ($directory_info as $file_info) {
          if ($file_info->getExtension() == 'php') {
            $basename = $file_info->getBasename('.php');
            $class = str_replace(
              DIRECTORY_SEPARATOR,
              '\\',
              $namespace_path . DIRECTORY_SEPARATOR . $basename
            );

            // @see \Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery::getDefinitions()
            // The filename is already known, so there is no need to find the
            // file. However, StaticReflectionParser needs a finder, so use a
            // mock version.
            $finder = MockFileFinder::create($file_info->getPathName());
            $parser = new StaticReflectionParser($class, $finder);

            if ($annotation = $reader->getClassAnnotation($parser->getReflectionClass(), 'Drupal\libraries\Annotation\Library')) {
              // AnnotationInterface::get() returns the array definition
              // instead of requiring us to work with the annotation object.
              $definition = $annotation->get();
              $definition['name'] = $basename;
              $definitions[$basename] = $definition;
            }
          }
        }
      }
    }

    return $definitions;
  }
}
