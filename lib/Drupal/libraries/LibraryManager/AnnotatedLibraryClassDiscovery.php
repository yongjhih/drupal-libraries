<?php

/**
 * @file
 * Definition of \Drupal\libraries\LibraryManager\AnnotatedLibraryClassDiscovery
 */

namespace Drupal\libraries\LibraryManager;

use Doctrine\Common\Annotations\AnnotationReader;

use \Drupal\Component\Plugin\Discovery\DiscoveryInterface;

/**
 * Defines a discovery mechanism to find annotated library classes.
 *
 * Instead of defining a custom LibraryClassDiscoveryInterface similar to the
 * LibraryClassFetcherInterface, we re-use the DiscoveryInterface from the
 * Plugin API even though we do not use the Plugin API itself.
 */
class AnnotatedLibraryClassDiscovery implements DiscoveryInterface {

  /**
   * Implements Drupal\Component\Plugin\Discovery\DiscoveryInterface::getDefinition().
   */
  public function getDefinition($plugin_id) {
    $plugins = $this->getDefinitions();
    return isset($plugins[$plugin_id]) ? $plugins[$plugin_id] : array();
  }

  /**
   * Implements Drupal\Component\Plugin\Discovery\DiscoveryInterface::getDefinitions().
   *
   * Calling functions should statically cache the returned information.
   */
  public function getDefinitions() {
    $reader = new AnnotationReader();

    AnnotationRegistry::registerAutoloadNamespace('Drupal\libraries\Annotation', array(drupal_get_path('module', 'libraries') . '/lib'));
    // Support the Translation annotation class.
    AnnotationRegistry::registerAutoloadNamespace('Drupal\Core\Annotation', array(DRUPAL_ROOT . '/core/lib'));

    // Directories to search for library classes.
    $subdirectory = array('lib', 'Drupal', 'Library');
    // Apparently we need to use OS-safe directory separators.
    // @see \Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery
    $directories = array(
      array(DRUPAL_ROOT, 'core') + $subdirectory,
      drupal_get_path('profile', drupal_get_profile()) + $subdirectory,
      array(DRUPAL_ROOT) + $subdirectory,
      array(DRUPAL_ROOT, conf_path(), $subdirectory),
    );
    $paths = array();
    foreach ($directories as $directory) {
      $paths[] = implode(DIRECTORY_SEPARATOR, $directory);      
    }

    $defintions = array();
    foreach ($paths as $path) {
      if (is_dir($path)) {
        $files = new DirectoryIterator($path);
        foreach ($files as $file) {
          if (is_file($path . DIRECTORY_SEPARATOR . $file) && (substr($file, -4) == '.php')) {
            $class_path = $path . DIRECTORY_SEPARATOR . $file;
            // Remove the file-ending ('.php').
            $class = str_replace(DIRECTORY_SEPARATOR, '\\', substr($classpath, 0, -4));

            // @see \Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery::getDefinitions()
            // The filename is already known, so there is no need to find the
            // file. However, StaticReflectionParser needs a finder, so use a
            // mock version.
            $finder = MockFileFinder::create($class_path);
            $parser = new StaticReflectionParser($class, $finder);

            if ($annotation = $reader->getClassAnnotation($parser->getReflectionClass(), 'Drupal\libraries\Annotation\Library')) {
              // AnnotationInterface::get() returns the array definition
              // instead of requiring us to work with the annotation object.
              $definition = $annotation->get();
              $definition['name'] = $class;
              $definitions[$class] = $definition;
            }
          }
        }
      }
    }
  }
}
