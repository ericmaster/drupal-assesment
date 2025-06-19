<?php

declare(strict_types=1);

namespace Drupal\Tests\custom_module\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests the Hello Controller functionality.
 *
 * @group custom_module
 */
class HelloControllerTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'custom_module',
    'field',
    'field_ui',
    'node',
    'text',
    'user',
    'system',
    'block',
  ];

  /**
   * A user with permission to access content.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $webUser;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    // Create the Article content type.
    $this->drupalCreateContentType(['type' => 'article', 'name' => 'Article']);

    // Create a user with permission to access content.
    $this->webUser = $this->drupalCreateUser(['access content']);
  }

  /**
   * Tests the default greeting route without name parameter.
   */
  public function testDefaultGreeting(): void {
    $this->drupalLogin($this->webUser);

    // Visit the greeting route without a name parameter.
    $this->drupalGet('/hello-velir-1');

    // Assert that the default greeting message appears.
    $this->assertSession()->pageTextContains('Hello, my name is Eric.');
  }

  /**
   * Tests the greeting route with a custom name parameter.
   */
  public function testCustomNameGreeting(): void {
    $this->drupalLogin($this->webUser);

    // Visit the greeting route with a custom name.
    $custom_name = 'John';
    $this->drupalGet('/hello-velir-1/' . $custom_name);

    // Assert that the custom greeting message appears.
    $this->assertSession()->pageTextContains('Hello, my name is ' . $custom_name . '.');
  }

}
