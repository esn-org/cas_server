<?php

/**
 * @file
 * Contains \Drupal\cas_server\Configuration\ConfigHelper
 */

namespace Drupal\cas_server\Configuration;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class ConfigHelper
 */
Class ConfigHelper {

  /**
   * Stores settings object.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $settings;

  /**
   * Constructor.
   *
   * @param ConfigFactoryInterface $config_factory
   *   The configuration factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->settings = $config_factory->get('cas_server.settings');
  }

  /**
   * Check a service against the service whitelist.
   *
   * @param string $service
   *   A supplied service string.
   *
   * @return bool
   *   Whether or not the service is allowed.
   */
  public function checkServiceAgainstWhitelist($service) {
    //TODO
    return TRUE;
  }

  /**
   * Return the list of attributes to be released for a service.
   *
   * @param string $service
   *   A supplied service string.
   *
   * @return array
   *   An array of user field names to be released as attributes.
   */
  public function getAttributesForService($service) {
    //TODO
    return [];
  }


}
