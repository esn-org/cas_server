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

  /**
   * Return the timeout for a proxy-granting ticket.
   *
   * @return int
   *   The number of seconds a proxy-granting ticket is valid.
   */
  public function getProxyGrantingTicketTimeout() {
    return $this->settings->get('ticket.proxy_granting_ticket_timeout');
  }

  /**
   * Return the timeout for a ticket-granting ticket.
   *
   * @return int
   *   The number of seconds a ticket-granting ticket is valid.
   */
  public function getTicketGrantingTicketTimeout() {
    return $this->settings->get('ticket.ticket_granting_ticket_timeout');
  }

  /**
   * Return the timeout for a proxy ticket.
   *
   * @return int
   *   The number of seconds a proxy ticket is valid.
   */
  public function getProxyTicketTimeout() {
    return $this->settings->get('ticket.proxy_ticket_timeout');
  }

  /**
   * Return the timeout for a service ticket.
   *
   * @return int
   *   The number of seconds a service ticket is valid.
   */
  public function getServiceTicketTimeout() {
    return $this->settings->get('ticket.service_ticket_timeout');
  }

  /**
   * Check whether a service is configured for single sign on.
   *
   * @param string $service
   *
   * @return bool
   *   Whether or not the service is authorized.
   */
  public function verifyServiceForSso($service) {
    //TODO
    return TRUE;
  }

  /**
   * Return the custom invalid service message, or FALSE
   *
   * @return string|bool
   */
  public function getInvalidServiceMessage() {
    if (!empty($m = $this->settings->get('messages.invalid_service'))) {
      return $m;
    }
    return FALSE;
  }

  /**
   * Return the custom user logout message, or FALSE
   *
   * @return string|bool
   */
  public function getUserLogoutMessage() {
    if (!empty($m = $this->settings->get('messages.user_logout'))) {
      return $m;
    }
    return FALSE;
  }

  /**
   * Return the custom logged in message, or FALSE
   *
   * @return string|bool
   */
  public function getLoggedInMessage() {
    if (!empty($m = $this->settings->get('messages.logged_in'))) {
      return $m;
    }
    return FALSE;
  }

}
