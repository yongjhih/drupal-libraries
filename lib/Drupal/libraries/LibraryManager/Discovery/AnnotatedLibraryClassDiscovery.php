<?php

/**
 * @file
 * Contains \Drupal\libraries\LibraryManager\Discovery\AnnotatedLibraryClassDiscovery
 */

namespace Drupal\libraries\LibraryManager\Discovery;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Reflection\StaticReflectionParser;

use Drupal\Component\Reflection\MockFileFinder;

/**
 * Defines a discovery mechanism to find annotated library classes.
 *
 * @see \Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery
 *
 * @todo If http://drupal.org/node/1847002 gets in, utilize
 *   AnnotatedClassDiscoveryBase.
 */
class AnnotatedLibraryClassDiscovery implements LibraryInfoDiscoveryInterface {

  /**
   * A list of paths to search for library classes.
   *
   * @var array|object|\Traversable
   */
  protected $paths = array();

  /**
   * Constructs an AnnotatedLibraryClassDiscovery object.
   *
   * @param array|object|\Traversable $paths
   *   A list of paths to search for library classes.
   */
  public function __construct($paths) {
    $this->paths = $paths;
  }

  /**
   * Implements LibraryClassDiscoveryInterface::getDefinition().
   */
  public function getLibraryInfo($name) {
    $libraries = $this->getAllLibraryInfo();
    return isset($libraries[$name]) ? $libraries[$name] : NULL;
  }

  /**
   * Implements LibraryClassDiscoveryInterface::getDefinitions().
   */
  public function getAllLibraryInfo() {
    $reader = new AnnotationReader();

    AnnotationRegistry::registerAutoloadNamespace('Drupal\libraries\Annotation', array(drupal_get_path('module', 'libraries') . '/lib'));

    // Directories to search for library classes.
    $namespace_path = 'Drupal' . DIRECTORY_SEPARATOR . 'Library';
    $directories = array_map(function($path) use ($namespace_path) {
      return $path . DIRECTORY_SEPARATOR . $namespace_path ;
    }, $this->paths);

    $libraries = array();
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

            $finder = MockFileFinder::create($file_info->getPathName());
            $parser = new StaticReflectionParser($class, $finder);

            if ($annotation = $reader->getClassAnnotation($parser->getReflectionClass(), 'Drupal\libraries\Annotation\Library')) {
              $library = $annotation->get();
              $library['name'] = $basename;
              $libraries[$basename] = $library;
            }
          }
        }
      }
    }

    return $libraries;
  }
}
