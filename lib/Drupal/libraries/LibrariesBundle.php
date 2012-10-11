<?php

/**
 * @file
 * Definition of \Drupal\libraries\LibrariesBundle.php
 */

namespace Drupal\libraries;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * A bundle for libraries.module.
 */
class LibrariesBundle extends Bundle {

  public function build(ContainerBuilder $container) {
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

    $container->register('libraries.library_manager.discovery', 'Drupal\libraries\LibraryManager\Discovery\AnnotatedLibraryClassDiscovery')
      ->addArgument($class_paths);
    $container->register('libraries.library_manager', 'Drupal\libraries\LibraryManager\DefaultLibraryManager')
      ->addArgument(new Reference('libraries.library_manager.discovery'))
      ->addArgument(new Reference('state.storage'));
  }
}
