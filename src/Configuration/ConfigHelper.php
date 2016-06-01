<?php

/**
 * @file
 * Contains \Drupal\cas_server\Configuration\ConfigHelper
 */

namespace Drupal\cas_server\Configuration;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\cas_server\Entity\CasServerService;
use Drupal\Core\Entity\EntityManager;

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
   * Entity Query handler for service definitions.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entityQuery;

  /**
   * Service entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $storage;

  /**
   * Constructor.
   *
   * @param ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param QueryFactory $entity_query
   *   The entity query handler.
   * @param EntityManager $entity_manager
   *   The entity manager.
   */
  public function __construct(ConfigFactoryInterface $config_factory, QueryFactory $entity_query, EntityManager $entity_manager) {
    $this->settings = $config_factory->get('cas_server.settings');
    $this->entityQuery = $entity_query;
    $this->storage = $entity_manager->getStorage('cas_server_service');
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
    return (bool)$this->matchServiceAgainstConfig($service);
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
    if ($def = $this->matchServiceAgainstConfig($service)) {
      return array_keys($def->getAttributes());
    }
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
    if ($def = $this->matchServiceAgainstConfig($service)) {
      return $def->getSso();
    }
    return FALSE;
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

  /**
   * Match a service string to a service definition.
   *
   * @param string $service
   *   The provided service string.
   *
   * @return CasServerService | bool
   *   A matching CasServerService object or FALSE if no match.
   */
  private function matchServiceAgainstConfig($service) {
    $sids = $this->entityQuery('cas_server_service')
      ->execute();
    $service_definitions = $this->storage->loadMultiple($sids);
    foreach ($service_definitions as $def) {
      if ($this->matchServiceString($def->getService(), $service)) {
        return $def;
      }
    }
    return FALSE;
  }

  /**
   * Match a string against a wildcard pattern.
   *
   * @param string $pattern
   *   The string pattern to match against
   * @param string $service
   *   The string to try to match.
   *
   * @return bool
   *   Whether the string matched or not.
   */
  private function matchServiceString($pattern, $service) {
    return fnmatch($pattern, $service, FNM_CASEFOLD);
  }

}
