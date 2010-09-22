// $Id$

/**
 * @file
 * Test JavaScript file for Libraries loading.
 *
 * Insert a 'libraries-test' div and some text below the page title. See
 * example_installed.txt for more information.
 */

(function ($) {

Drupal.behaviors.librariesTest = {
  attach: function(context, settings) {
    $('h1#page-title').after('<div id="libraries-test">If this text shows up, the JavaScript file was loaded successfully. If this text is orange, the CSS file was loaded successfully.</div>')
  }
};

})(jQuery);
