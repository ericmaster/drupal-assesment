<?php

namespace Drupal\custom_module\Controller;

/**
 * Admin Controller for the Custom Module that extends HelloController.
 */
class HelloControllerAdmin extends HelloController {

  /**
   * Returns a personalized greeting message for administrators only.
   *
   * @param string $name
   *   Optional name parameter. Defaults to 'Eric'.
   *
   * @return array
   *   A render array containing the greeting message.
   */
  public function adminGreeting(string $name = 'Eric'): array {
    return [
      '#markup' => $this->getGreetingMessage($name),
      '#cache' => [
        'contexts' => ['url', 'user.roles'],
        'max-age' => 3600,
      ],
    ];
  }

}
