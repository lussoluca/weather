<?php declare(strict_types = 1);

namespace Drupal\weather\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\weather\CityInterface;

/**
 * Defines the city entity class.
 *
 * @ContentEntityType(
 *   id = "city",
 *   label = @Translation("City"),
 *   label_collection = @Translation("Cities"),
 *   label_singular = @Translation("city"),
 *   label_plural = @Translation("cities"),
 *   label_count = @PluralTranslation(
 *     singular = "@count cities",
 *     plural = "@count cities",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\weather\CityListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\weather\Form\CityForm",
 *       "edit" = "Drupal\weather\Form\CityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\weather\Routing\CityHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "city",
 *   admin_permission = "administer city",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/city",
 *     "add-form" = "/city/add",
 *     "canonical" = "/city/{city}",
 *     "edit-form" = "/city/{city}",
 *     "delete-form" = "/city/{city}/delete",
 *     "delete-multiple-form" = "/admin/content/city/delete-multiple",
 *   },
 * )
 */
final class City extends ContentEntityBase implements CityInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Label'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Description'))
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => 25,
        'settings' => [
          'rows' => 4,
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['lat_lng'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Coordinates'))
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription(): string {
    return $this->get('description')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getCoordinates(): array {
    return explode(',', $this->get('lat_lng')->value);
  }

}
