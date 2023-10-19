<?php

namespace Drupal\weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Weather settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'weather_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['weather.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API URL'),
      '#default_value' => $this->config('weather.settings')->get('url'),
    ];

    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#default_value' => $this->config('weather.settings')
        ->get('api_key'),
    ];

    $form['units'] = [
      '#type' => 'select',
      '#title' => $this->t('Unit'),
      '#options' => [
        'metric' => $this->t('Metric'),
        'imperial' => $this->t('Imperial'),
      ],
      '#default_value' => $this->config('weather.settings')->get('units'),
    ];

    $form['cnt'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of timestamps to retrieve'),
      '#min' => 1,
      '#max' => 40,
      '#default_value' => $this->config('weather.settings')->get('cnt'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('weather.settings')
      ->set('url', $form_state->getValue('url'))
      ->set('api_key', $form_state->getValue('api_key'))
      ->set('units', $form_state->getValue('units'))
      ->set('cnt', $form_state->getValue('cnt'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
