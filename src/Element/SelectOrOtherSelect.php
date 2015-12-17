<?php
/**
 * @file
 * Contains Drupal\select_or_other\Element\SelectOrOtherSelect.
 */

namespace Drupal\select_or_other\Element;


use Drupal\Core\Form\FormStateInterface;

/**
 *  * Provides a form element with a select box and other option.
 *
 * Properties:
 * @see SelectOrOtherElementBase
 *
 * @FormElement("select_or_other_select")
 */
class SelectOrOtherSelect extends SelectOrOtherElementBase {

  /**
   * {@inheritdoc}
   */
  public static function processSelectOrOther(&$element, FormStateInterface $form_state, &$complete_form) {
    $element = parent::processSelectOrOther($element, $form_state, $complete_form);

    $element['select']['#type'] = 'select';

    if ($element['#cardinality'] === 1) {
      $element['other']['#states'] = SelectOrOtherElementBase::prepareStates('visible', $element['#name'], 'value', 'select_or_other');
    }
    else {
      $element['select']['#multiple'] = TRUE;

      // todo Drupal #states does not support multiple select elements. We have
      // to simulate #states using our own javascript until #1149078 is
      // resolved. @see https://www.drupal.org/node/1149078
      $element['select']['#attached'] = [
        'library' => ['select_or_other/multiple_select_states_hack']
      ];
    }

    return $element;
  }

}
