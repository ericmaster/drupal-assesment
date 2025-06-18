<?php

namespace Drupal\custom_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for the Custom Module.
 */
class HelloController extends ControllerBase {

  /**
   * Gets the greeting message.
   *
   * @param string $name
   *   The name to include in the greeting. Defaults to 'Eric'.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   The greeting message.
   */
  protected function getGreetingMessage(string $name = 'Eric') {
    return $this->t('Hello, my name is @name.', ['@name' => $name]);
  }

  /**
   * Returns a personalized greeting message.
   *
   * @param string $name
   *   Optional name parameter. Defaults to 'Eric'.
   *
   * @return array
   *   A render array containing the greeting message.
   */
  public function greeting(string $name = 'Eric'): array {
    return [
      '#markup' => $this->getGreetingMessage($name),
      '#cache' => [
        'contexts' => ['url'],
        'max-age' => 3600,
      ],
    ];
  }

}
