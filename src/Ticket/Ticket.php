<?php

/**
 * @file
 * Contains \Drupal\cas_server\Ticket\Ticket
 */

namespace Drupal\cas_server\Ticket;

abstract class Ticket {

  /**
   * @var string
   *
   * The ticket identifier string.
   */
  private $id;

  /**
   * @var string
   *
   * A unix timestamp representing the expiration time of the ticket.
   */
  private $expirationTime;

  /**
   * @var string
   *
   * A hashed session ID for the session that requested ticket.
   */
  private $session;

  /**
   * @var string
   *
   * The username of the user who requested the ticket.
   */
  private $user;

  /**
   * Constructor.
   *
   * @param string $ticket_id
   *   The ticket id.
   * @param string $timestamp
   *   The expiration time of the ticket.
   * @param string $session_id
   *   The hashed session id.
   * @param string $username
   *   The username of requestor.
   */
  public function __construct($ticket_id, $timestamp, $session_id, $username) {
    $this->id = $ticket_id;
    $this->expirationTime = $timestamp;
    $this->session = $session_id;
  }

}
