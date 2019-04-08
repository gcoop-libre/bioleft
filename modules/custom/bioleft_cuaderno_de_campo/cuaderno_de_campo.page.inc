<?php

/**
 * @file
 * Contains cuaderno_de_campo.page.inc.
 *
 * Page callback for Cuaderno de campo entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Cuaderno de campo templates.
 *
 * Default template: cuaderno_de_campo.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_cuaderno_de_campo(array &$variables) {
  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
