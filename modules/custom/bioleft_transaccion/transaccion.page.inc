<?php

/**
 * @file
 * Contains transaccion.page.inc.
 *
 * Page callback for Transacción entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Transacción templates.
 *
 * Default template: transaccion.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_transaccion(array &$variables) {
  // Fetch Transaccion Entity Object.
  // $transaccion = $variables['elements']['#transaccion'];
  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
