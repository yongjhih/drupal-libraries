<?php

/**
 * @file
 * Definition of \Drupal\libraries\Annotation\Library.
 */

namespace Drupal\libraries\Annotation;

use Drupal\Core\Annotation\Plugin;

/**
 * Defines a Library annotation object.
 *
 * The Plugin class already contains the necessary handling, we only override
 * that class so we can use the "@Library" Annotation.
 *
 * @see \Drupal\Core\Annotation\Plugin
 *
 * @Annotation
 */
class Library extends Plugin {}
