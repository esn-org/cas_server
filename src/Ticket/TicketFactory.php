<?php

/**
 * @file
 * Contains Drupal\cas_server\Ticket\TicketFactory
 */

namespace Drupal\cas_server\Ticket;

use Drupal\Component\Utility\Crypt;
use Drupal\cas_server\Configuration\ConfigHelper;
use Drupal\Core\Session\SessionManagerInterface;


class TicketFactory {

  /**
   * @var TicketStorageInterface
   *
   * The ticket store.
   */
  protected $ticketStore;

  /**
   * @var ConfigHelper
   *
   * The configuration helper.
   */
  protected $configHelper;

  /**
   * @var SessionManagerInterface
   *
   * The session manager.
   */
  protected $sessionManager;

  /**
   * Constructor.
   *
   * @param TicketStorageInterface $ticket_store
   *   The ticket store to use.
   * @param ConfigHelper $config_helper
   *   The configuration helper.
   */
  public function __construct(TicketStorageInterface $ticket_store, ConfigHelper $config_helper, SessionManagerInterface $session_manager) {
    $this->ticketStore = $ticket_store;
    $this->configHelper = $config_helper;
    $this->sessionManager = $session_manager;
  }

  /**
   * Create a proxy granting ticket.
   *
   * @param array $proxy_chain
   *   The proxy chain.
   *
   * @return ProxyGrantingTicket
   *   The created and saved PGT.
   */
  public function createProxyGrantingTicket($proxy_chain) {
    $id = 'PGT-';
    $id .= Crypt::randomBytesBase64(32);
    $expiration_time = REQUEST_TIME + $this->configHelper->getProxyGrantingTicketTimeout();
    $session = Crypt::hashBase64($this->sessionManager->getId());
    $name = \Drupal::currentUser()->getUsername();

    $pgt = new ProxyGrantingTicket($id, $expiration_time, $session, $name, $proxy_chain);
    $this->ticketStore->storeProxyGrantingTicket($pgt);

    return $pgt;

  }


}
