<?php

declare(strict_types=1);

namespace Drupal\Tests\custom_module\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;

/**
 * Tests the Node Normalizer functionality.
 *
 * @group custom_module
 */
class NodeNormalizerTest extends KernelTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'custom_module',
    'system',
    'user',
    'node',
    'field',
    'text',
    'filter',
    'serialization',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->installEntitySchema('user');
    $this->installEntitySchema('node');
    $this->installSchema('node', ['node_access']);
    $this->installConfig(['node', 'filter']);

    // Create a basic page content type.
    $node_type = NodeType::create([
      'type' => 'page',
      'name' => 'Basic page',
    ]);
    $node_type->save();
  }

  /**
   * Tests node serialization includes the "velir" attribute with value "212".
   */
  public function testNodeSerializationIncludesVelirAttribute(): void {
    // Create a test node.
    $node = Node::create([
      'type' => 'page',
      'title' => 'Test Node',
      'status' => 1,
    ]);
    $node->save();

    // Get the serializer service.
    $serializer = $this->container->get('serializer');

    // Serialize the node.
    $serialized = $serializer->normalize($node, 'json');

    // Assert that the serialized data is an array.
    $this->assertIsArray($serialized);

    // Assert that the "velir" attribute exists.
    $this->assertArrayHasKey('velir', $serialized);

    // Assert that the "velir" attribute has the correct value.
    $this->assertEquals('212', $serialized['velir']);
  }

  /**
   * Tests that different node types also get the "velir" attribute.
   */
  public function testDifferentNodeTypesGetVelirAttribute(): void {
    // Create another content type.
    $node_type = NodeType::create([
      'type' => 'article',
      'name' => 'Article',
    ]);
    $node_type->save();

    // Create an article node.
    $node = Node::create([
      'type' => 'article',
      'title' => 'Test Article',
      'status' => 1,
    ]);
    $node->save();

    // Get the serializer service.
    $serializer = $this->container->get('serializer');

    // Serialize the node.
    $serialized = $serializer->normalize($node, 'json');

    // Assert that the serialized data is an array.
    $this->assertIsArray($serialized);

    // Assert that the "velir" attribute exists.
    $this->assertArrayHasKey('velir', $serialized);

    // Assert that the "velir" attribute has the correct value.
    $this->assertEquals('212', $serialized['velir']);
  }

}
