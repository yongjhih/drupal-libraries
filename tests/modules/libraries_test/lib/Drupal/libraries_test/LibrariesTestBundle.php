<?php

/**
 * @file
 * Contains \Drupal\libraries\LibrariesTestBundle.php
 */

namespace Drupal\libraries_test;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * A bundle for libraries_test.module.
 */
class LibrariesTestBundle extends Bundle {

  public function build(ContainerBuilder $container) {
    $container->register('libraries.library_manager', 'Drupal\libraries\Tests\TestLibraryManager')
      ->addArgument(new Reference('config.factory'));
  }

}
