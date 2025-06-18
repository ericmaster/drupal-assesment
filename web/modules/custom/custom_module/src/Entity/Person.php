<?php

declare(strict_types=1);

namespace Drupal\custom_module\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\Attribute\ConfigEntityType;
use Drupal\Core\Entity\EntityDeleteForm;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\custom_module\Form\PersonForm;
use Drupal\custom_module\PersonInterface;
use Drupal\custom_module\PersonListBuilder;

/**
 * Defines the person entity type.
 */
#[ConfigEntityType(
  id: 'person',
  label: new TranslatableMarkup('Person'),
  label_collection: new TranslatableMarkup('Persons'),
  label_singular: new TranslatableMarkup('person'),
  label_plural: new TranslatableMarkup('persons'),
  config_prefix: 'person',
  entity_keys: [
    'id' => 'id',
    'label' => 'label',
    'uuid' => 'uuid',
  ],
  handlers: [
    'list_builder' => PersonListBuilder::class,
    'form' => [
      'add' => PersonForm::class,
      'edit' => PersonForm::class,
      'delete' => EntityDeleteForm::class,
    ],
  ],
  links: [
    'collection' => '/admin/structure/person',
    'add-form' => '/admin/structure/person/add',
    'edit-form' => '/admin/structure/person/{person}',
    'delete-form' => '/admin/structure/person/{person}/delete',
  ],
  admin_permission: 'administer person',
  label_count: [
    'singular' => '@count person',
    'plural' => '@count persons',
  ],
  config_export: [
    'id',
    'label',
    'first_name',
    'last_name',
  ],
)]
final class Person extends ConfigEntityBase implements PersonInterface {

  /**
   * The person ID.
   */
  protected string $id;

  /**
   * The person label.
   */
  protected string $label;

  /**
   * The first name.
   */
  protected string $first_name = '';

  /**
   * The last name.
   */
  protected string $last_name = '';

  /**
   * Gets the first name.
   *
   * @return string
   *   The first name.
   */
  public function getFirstName(): string {
    return $this->first_name;
  }

  /**
   * Sets the first name.
   *
   * @param string $first_name
   *   The first name.
   *
   * @return static
   *   The called Person entity.
   */
  public function setFirstName(string $first_name): static {
    $this->first_name = $first_name;
    return $this;
  }

  /**
   * Gets the last name.
   *
   * @return string
   *   The last name.
   */
  public function getLastName(): string {
    return $this->last_name;
  }

  /**
   * Sets the last name.
   *
   * @param string $last_name
   *   The last name.
   *
   * @return static
   *   The called Person entity.
   */
  public function setLastName(string $last_name): static {
    $this->last_name = $last_name;
    return $this;
  }

  /**
   * Gets the full name (first name + last name).
   *
   * @return string
   *   The full name.
   */
  public function getFullName(): string {
    return trim($this->first_name . ' ' . $this->last_name);
  }

}
