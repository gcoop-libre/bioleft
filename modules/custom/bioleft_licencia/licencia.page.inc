<?php

/**
 * @file
 * Contains licencia.page.inc.
 *
 * Page callback for Licencia entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Licencia templates.
 *
 * Default template: licencia.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_licencia(array &$variables) {
  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
