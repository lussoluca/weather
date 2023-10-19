<?php

namespace Drupal\weather\Controller;

use Drupal\weather\CityInterface;
use Drupal\weather\WeatherClientInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Weather routes.
 */
class ForecastController extends ControllerBase {

  /**
   * The controller constructor.
   *
   * @param \Drupal\weather\WeatherClientInterface $weatherClient
   *   The weather.weather_client service.
   */
  public function __construct(
    private readonly WeatherClientInterface $weatherClient,
  ) {
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('weather.weather_client'),
    );
  }

  /**
   * @param \Drupal\weather\CityInterface $city
   *
   * @return string
   */
  public function title(CityInterface $city): string {
    return $this->t('Weather forecast for @city', [
      '@city' => $city->label(),
    ]);
  }

  /**
   * Return a render array with full forecast data for the next 5 days.
   *
   * @param \Drupal\weather\CityInterface $city
   *
   * @return array
   */
  public function page(CityInterface $city): array {
    $forecast = $this->weatherClient->getForecastData($city->label());

    $build['content'] = [
      '#theme' => 'weather_forecast',
      '#forecast' => $forecast,
      '#units' => $this->config('weather.settings')->get('units'),
      '#description' => $city->getDescription(),
      '#coordinates' => $city->getCoordinates(),
      '#cache' => [
        'max-age' => 10800, // 3 hours.
        'tags' => [
          'forecast:' . strtolower($city->label()),
        ],
      ],
    ];

    return $build;
  }

  /**
   * Return a render array with details for a specific day and time.
   *
   * @param \Drupal\weather\CityInterface $city
   * @param string $date
   *
   * @return array
   */
  public function details(CityInterface $city, string $date): array {
    $forecast = $this->weatherClient->getForecastDetail($city->label(), $date);

    $build['content'] = [
      '#theme' => 'weather_details',
      '#forecast' => $forecast,
      '#units' => $this->config('weather.settings')->get('units'),
      '#cache' => [
        'max-age' => 10800,
        'tags' => [
          'forecast:' . $city->label(),
        ],
      ],
    ];

    return $build;
  }

}
