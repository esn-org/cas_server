<?php

/**
 * @file
 * Contains \Drupal\cas\Form\CasServerSettings.
 */

namespace Drupal\cas_server\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CasServerSettings.
 *
 * @codeCoverageIgnore
 */
class CasServerSettings extends ConfigFormBase {

  /**
   * Constructs a \Drupal\cas_server\Form\CasServerSettings object.
   *
   * @param ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('config.factory'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'cas_server_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // @TODO


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // @TODO
    
    return parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // @TODO

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return array('cas_server.settings');
  }

}
