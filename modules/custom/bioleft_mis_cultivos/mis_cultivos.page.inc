<?php

/**
 * @file
 * Contains mis_cultivos.page.inc.
 *
 * Page callback for Mis cultivos entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Mis cultivos templates.
 *
 * Default template: mis_cultivos.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_mis_cultivos(array &$variables) {

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
