<?php

/**
 * @file
 * Contains \Drupal\cas_server\Ticket\ServiceTicket
 */

namespace Drupal\cas_server\Ticket;

class ServiceTicket extends Ticket {

  /**
   * @var string
   * The service this ticket was granted for.
   */
  private $service;

  /**
   * Constructs a service ticket.
   *
   * @param string $identifier
   *   The data used to identify the ticket.
   * @param string $expiry
   *   A unix timestamp describing the expiration time.
   * @param string $service_string
   *   URL of the service the ticket is to be used for.
   * @param session $session_string
   *   The hashed session ID of the requestor of ticket.
   */
  public function __construct($identifier, $expiry, $service_string, $session_string) {
    $this->id = $identifier;
    $this->expirationTime = $expiry;
    $this->service = $service_string;
    $this->session = $session_string;
  }

  /**
   * Returns whether or not the ticket is valid for usage with the supplied service.
   *
   * @param string $supplied_service
   *   The service presented in the url.
   */
  public function isValid($supplied_service) {
    return (time() < $this->expirationTime) && $supplied_service == $this->service;
  }
}
