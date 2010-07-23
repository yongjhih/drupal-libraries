// $Id$

/**
 * @file
 * Test JavaScript file for Libraries loading.
 *
 * Because we cannot test JavaScript programatically with SimpleTest, the
 * JavaScript below can be useful for debugging with SimpleTest's verbose mode.
 */

(function ($) {

Drupal.behaviors.librariesTest = {
  attach: function(context, settings) {
    $('h1#page-title').after('<div id="libraries-test">If this text shows up, the JavaScript file was loaded successfully. If this text is green, the CSS file was loaded successfully.</div>')
  }
};

})(jQuery); 
