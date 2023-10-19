<?php declare(strict_types = 1);

namespace Drupal\weather;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface defining a city entity type.
 */
interface CityInterface extends ContentEntityInterface {

  /**
   * @return string
   */
  public function getDescription(): string;

  /**
   * @return array
   */
  public function getCoordinates(): array;

}
