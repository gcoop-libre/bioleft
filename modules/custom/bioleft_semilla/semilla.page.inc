<?php

/**
 * @file
 * Contains semilla.page.inc.
 *
 * Page callback for Semilla entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Semilla templates.
 *
 * Default template: semilla.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_semilla(array &$variables) {
  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
