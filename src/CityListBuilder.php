<?php declare(strict_types = 1);

namespace Drupal\weather;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the city entity type.
 */
final class CityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['id'] = $this->t('ID');
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\weather\CityInterface $entity */
    $row['id'] = $entity->id();
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

}
