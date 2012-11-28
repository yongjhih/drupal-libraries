<?php

/**
 * @file
 * Contains \Drupal\libraries\LibrariesBundle.php
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
    $container->register('libraries.library_manager', 'Drupal\libraries\LibraryManager\DefaultLibraryManager')
      ->addArgument(new Reference('config.factory'));
  }

}
