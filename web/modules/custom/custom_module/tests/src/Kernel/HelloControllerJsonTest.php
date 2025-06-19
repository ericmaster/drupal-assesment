<?php

declare(strict_types=1);

namespace Drupal\Tests\custom_module\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Tests the Hello Controller JSON functionality.
 *
 * @group custom_module
 */
class HelloControllerJsonTest extends KernelTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'custom_module',
    'system',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
  }

  /**
   * Tests that the hello-velir-2 route returns a JSON response.
   */
  public function testJsonRouteReturnsJsonResponse(): void {
    // Instantiate the JSON controller directly.
    $controller = new \Drupal\custom_module\Controller\HelloControllerJson();

    // Execute the greetingJson method.
    $response = $controller->greetingJson();

    // Assert the response is a JsonResponse.
    $this->assertInstanceOf(JsonResponse::class, $response);

    // Assert the response has the correct content type.
    $this->assertEquals('application/json', $response->headers->get('Content-Type'));

    // Decode the JSON response.
    $data = json_decode($response->getContent(), TRUE);

    // Assert the JSON structure and content.
    $this->assertIsArray($data);
    $this->assertArrayHasKey('message', $data);
    $this->assertArrayHasKey('status', $data);
    $this->assertEquals('success', $data['status']);
    $this->assertStringContainsString('Hello, my name is Eric.', $data['message']);
  }

  /**
   * Tests that the JSON route works with custom names.
   */
  public function testJsonRouteWithCustomName(): void {
    // Instantiate the JSON controller directly.
    $controller = new \Drupal\custom_module\Controller\HelloControllerJson();

    // Execute the greetingJson method with a custom name.
    $response = $controller->greetingJson('John');

    // Assert the response is a JsonResponse.
    $this->assertInstanceOf(JsonResponse::class, $response);

    // Decode the JSON response.
    $data = json_decode($response->getContent(), TRUE);

    // Assert the custom name is in the message.
    $this->assertStringContainsString('Hello, my name is John.', $data['message']);
  }

}
