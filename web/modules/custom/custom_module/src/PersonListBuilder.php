<?php

declare(strict_types=1);

namespace Drupal\custom_module;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of persons.
 */
final class PersonListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    $header['id'] = $this->t('Machine name');
    $header['first_name'] = $this->t('First Name');
    $header['last_name'] = $this->t('Last Name');
    $header['full_name'] = $this->t('Full Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\custom_module\PersonInterface $entity */
    $row['label'] = $entity->label();
    $row['id'] = $entity->id();
    $row['first_name'] = $entity->getFirstName();
    $row['last_name'] = $entity->getLastName();
    $row['full_name'] = $entity->getFullName();
    return $row + parent::buildRow($entity);
  }

}
