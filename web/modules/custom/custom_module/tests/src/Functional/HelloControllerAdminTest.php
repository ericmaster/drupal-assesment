<?php

declare(strict_types=1);

namespace Drupal\Tests\custom_module\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests the Hello Controller Admin functionality.
 *
 * @group custom_module
 */
class HelloControllerAdminTest extends BrowserTestBase {

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
   * A regular user with basic permissions.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $webUser;

  /**
   * An administrative user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    // Create the Article content type.
    $this->drupalCreateContentType(['type' => 'article', 'name' => 'Article']);

    // Create a regular user with basic permissions.
    $this->webUser = $this->drupalCreateUser(['access content'], 'web-user');

    // Create the administrator role if it doesn't exist.
    $role_storage = $this->container->get('entity_type.manager')->getStorage('user_role');
    if (!$role_storage->load('administrator')) {
      $role_storage->create([
        'id' => 'administrator',
        'label' => 'Administrator',
        'weight' => 2,
        'is_admin' => TRUE,
      ])->save();
    }

    // Create an administrative user with the administrator role.
    $this->adminUser = $this->drupalCreateUser(['access content'], 'admin-user', TRUE);
    $this->adminUser->addRole('administrator');
    $this->adminUser->save();
  }

  /**
   * Tests that anonymous users receive a 403 for the admin greeting route.
   */
  public function testAnonymousUserAccessDenied(): void {
    // Don't log in any user (anonymous).
    // Visit the admin greeting route.
    $this->drupalGet('/hello-velir-3');

    // Assert that the anonymous user receives a 403 Forbidden response.
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Tests that regular users receive a 403 for the admin greeting route.
   */
  public function testRegularUserAccessDenied(): void {
    $this->drupalLogin($this->webUser);

    // Visit the admin greeting route.
    $this->drupalGet('/hello-velir-3');

    // Assert that the user receives a 403 Forbidden response.
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Test regular users receive a 403 for admin greeting route with custom name.
   */
  public function testRegularUserAccessDeniedWithCustomName(): void {
    $this->drupalLogin($this->webUser);

    // Visit the admin greeting route with a custom name.
    $this->drupalGet('/hello-velir-3/John');

    // Assert that the user receives a 403 Forbidden response.
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Tests that administrative users can access the admin greeting route.
   */
  public function testAdminUserAccessGranted(): void {
    $this->drupalLogin($this->adminUser);

    // Visit the admin greeting route.
    $this->drupalGet('/hello-velir-3');

    // Assert that the admin user receives a 200 OK response.
    $this->assertSession()->statusCodeEquals(200);

    // Assert that the default greeting message appears.
    $this->assertSession()->pageTextContains('Hello, my name is Eric.');
  }

  /**
   * Tests admin users can access the admin greeting route with custom name.
   */
  public function testAdminUserAccessGrantedWithCustomName(): void {
    $this->drupalLogin($this->adminUser);

    // Visit the admin greeting route with a custom name.
    $custom_name = 'Administrator';
    $this->drupalGet('/hello-velir-3/' . $custom_name);

    // Assert that the admin user receives a 200 OK response.
    $this->assertSession()->statusCodeEquals(200);

    // Assert that the custom greeting message appears.
    $this->assertSession()->pageTextContains('Hello, my name is ' . $custom_name . '.');
  }

}
