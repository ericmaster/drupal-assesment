<?php

namespace Drupal\custom_module\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'uppercase_text' formatter.
 */
#[FieldFormatter(
  id: 'uppercase_text',
  label: new TranslatableMarkup('Uppercase Text'),
  description: new TranslatableMarkup('Displays text in all uppercase letters.'),
  field_types: [
    'string',
    'string_long',
    'text',
    'text_long',
    'text_with_summary',
  ]
)]
class UppercaseTextFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings(): array {
    return [
      'trim_whitespace' => TRUE,
      'html_tag' => 'span',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state): array {
    $form = parent::settingsForm($form, $form_state);

    $form['trim_whitespace'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Trim whitespace'),
      '#description' => $this->t('Remove extra whitespace from the beginning and end of the text.'),
      '#default_value' => $this->getSetting('trim_whitespace'),
    ];

    $form['html_tag'] = [
      '#type' => 'select',
      '#title' => $this->t('HTML tag'),
      '#description' => $this->t('The HTML tag to wrap the uppercase text.'),
      '#default_value' => $this->getSetting('html_tag'),
      // phpcs:disable
      '#options' => [
        'span' => 'span',
        'div' => 'div',
        'p' => 'p',
        'h1' => 'h1',
        'h2' => 'h2',
        'h3' => 'h3',
        'h4' => 'h4',
        'h5' => 'h5',
        'h6' => 'h6',
        'strong' => 'strong',
        'em' => 'em',
      ],
      // phpcs:enable
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(): array {
    $summary = [];

    $trim_whitespace = $this->getSetting('trim_whitespace');
    $html_tag = $this->getSetting('html_tag');

    $summary[] = $this->t('HTML tag: @tag', ['@tag' => $html_tag]);

    if ($trim_whitespace) {
      $summary[] = $this->t('Trim whitespace: Yes');
    }
    else {
      $summary[] = $this->t('Trim whitespace: No');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = [];
    $trim_whitespace = $this->getSetting('trim_whitespace');
    $html_tag = $this->getSetting('html_tag');

    foreach ($items as $delta => $item) {
      $value = $item->value;
      if (!empty($value)) {
        // Trim whitespace if enabled.
        if ($trim_whitespace) {
          $value = trim($value);
        }

        // Convert to uppercase.
        $uppercase_value = strtoupper($value);

        $elements[$delta] = [
          '#type' => 'html_tag',
          '#tag' => $html_tag,
          '#value' => $uppercase_value,
          '#cache' => [
            'contexts' => ['languages:language_content'],
          ],
        ];
      }
    }

    return $elements;
  }

}
