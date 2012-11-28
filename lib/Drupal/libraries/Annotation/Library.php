<?php

/**
 * @file
 * Contains \Drupal\libraries\Annotation\Library.
 */

namespace Drupal\libraries\Annotation;

use Drupal\Core\Annotation\Plugin;

/**
 * Defines a Library annotation object.
 *
 * The Plugin class already contains the necessary handling, we only override
 * that class so we can use the '@Library' annotation.
 *
 * @see \Drupal\Core\Annotation\Plugin
 *
 * @Annotation
 */
class Library extends Plugin {}

