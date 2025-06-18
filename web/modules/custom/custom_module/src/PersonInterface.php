<?php

declare(strict_types=1);

namespace Drupal\custom_module;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining a person entity type.
 */
interface PersonInterface extends ConfigEntityInterface {

  /**
   * Gets the first name.
   *
   * @return string
   *   The first name.
   */
  public function getFirstName(): string;

  /**
   * Sets the first name.
   *
   * @param string $first_name
   *   The first name.
   *
   * @return static
   *   The called Person entity.
   */
  public function setFirstName(string $first_name): static;

  /**
   * Gets the last name.
   *
   * @return string
   *   The last name.
   */
  public function getLastName(): string;

  /**
   * Sets the last name.
   *
   * @param string $last_name
   *   The last name.
   *
   * @return static
   *   The called Person entity.
   */
  public function setLastName(string $last_name): static;

  /**
   * Gets the full name (first name + last name).
   *
   * @return string
   *   The full name.
   */
  public function getFullName(): string;

}
