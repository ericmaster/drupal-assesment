<?php

namespace Drupal\custom_module\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * JSON Controller for the Custom Module that extends HelloController.
 */
class HelloControllerJson extends HelloController {

  /**
   * Returns a personalized greeting message as JSON.
   *
   * @param string $name
   *   Optional name parameter. Defaults to 'Eric'.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   A JSON response containing the greeting message.
   */
  public function greetingJson(string $name = 'Eric'): JsonResponse {
    $message = $this->getGreetingMessage($name);
    
    return new JsonResponse([
      'message' => $message->render(),
      'status' => 'success',
    ]);
  }

}
