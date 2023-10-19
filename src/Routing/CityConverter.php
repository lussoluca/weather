<?php

declare(strict_types=1);

namespace Drupal\weather\Routing;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Drupal\weather\CityInterface;
use Symfony\Component\Routing\Route;

/**
 * Param converter to convert a city name to a City object.
 */
class CityConverter implements ParamConverterInterface {

  /**
   * CityConverter constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   */
  public function __construct(private readonly EntityTypeManagerInterface $entityTypeManager) {
  }

  /**
   * {@inheritdoc}
   */
  public function convert(
    $value, $definition, $name, array $defaults
  ): ?CityInterface {
    /** @var \Drupal\weather\CityInterface[] $cities */
    $cities = $this->entityTypeManager->getStorage('city')->loadByProperties(['label' => $value]);

    if (count($cities) == 0) {
      return NULL;
    }

    return reset($cities);
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route): bool {
    if (!empty($definition['type']) && $definition['type'] === 'weather:city') {
      return TRUE;
    }

    return FALSE;
  }

}
