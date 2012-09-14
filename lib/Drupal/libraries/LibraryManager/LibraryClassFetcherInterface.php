<?php

/**
 * @file
 * Definition of \Drupal\libraries\LibraryManager\LibraryClassFetcherInterface.php
 */

namespace Drupal\libraries\LibraryManager;

/**
 * Provides a common interface for library class fetchers.
 */
interface LibrayClassFetcherInterface {

  /**
   * Fetches the library class for a specified library.
   *
   * @param string $name
   *   The machine-readable name of the library. This is identical to the class
   *   name.
   *
   * @todo We need to figure out:
   *   1. How to actually be able to do this when we want to either use
   *      authorize.php or Drush.
   *   2. Where to put the fetched file, which is one of:
   *      A: /lib/Drupal/Library/Example.php
   *      B: /sites/example.com/lib/Drupal/Library/Example.php
   *      (Should we support /core and/or install profiles, as well?)
   *
   * @throws \Drupal\libraries\LibraryManager\LibraryClassFetchingFailedException
   */
  public function fetch($name);
}
