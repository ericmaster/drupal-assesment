<?php

namespace Drupal\custom_module\Normalizer;

use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityTypeRepositoryInterface;
use Drupal\node\NodeInterface;
use Drupal\serialization\Normalizer\ContentEntityNormalizer;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * Custom normalizer for Node entities that adds a "velir" attribute.
 */
class NodeNormalizer extends ContentEntityNormalizer {

  /**
   * The interface or class that this Normalizer supports.
   */
  protected array $supportedInterfaceOrClass = [NodeInterface::class];

  /**
   * Constructs a NodeNormalizer object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   * @param \Drupal\Core\Entity\EntityTypeRepositoryInterface $entityTypeRepository
   *   The entity type repository.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entityFieldManager
   *   The entity field manager.
   */
  // phpcs:disable
  public function __construct(
    #[Autowire(service: 'entity_type.manager')]
    EntityTypeManagerInterface $entityTypeManager,
    #[Autowire(service: 'entity_type.repository')]
    EntityTypeRepositoryInterface $entityTypeRepository,
    #[Autowire(service: 'entity_field.manager')]
    EntityFieldManagerInterface $entityFieldManager,
  ) {
    parent::__construct($entityTypeManager, $entityTypeRepository, $entityFieldManager);
  }
  // phpcs:enable

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = []): array|string|int|float|bool|\ArrayObject|NULL {
    $data = parent::normalize($object, $format, $context);

    // Add the custom "velir" attribute with value "212".
    if (is_array($data)) {
      $data['velir'] = '212';
    }

    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL, array $context = []): bool {
    return $data instanceof NodeInterface;
  }

}
