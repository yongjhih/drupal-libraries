<?php

/**
 * @file
 * Libraries test theme.
 */

/**
 * Implements hook_libraries_info().
 */
function libraries_test_theme_libraries_info() {
  $libraries['example_theme'] = array(
    'name' => 'Example theme',
    'theme_altered' => FALSE,
  );
  return $libraries;
}

/**
 * Implements hook_libraries_info_alter().
 */
function libraries_test_theme_libraries_info_alter(&$libraries) {
  $libraries['example_theme']['theme_altered'] = TRUE;
}
