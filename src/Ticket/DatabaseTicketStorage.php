<?php

/**
 * @file
 * Contains \Drupal\cas_server\Ticket\DatabaseTicketStorage.
 */

namespace Drupal\cas_server\Ticket;

use Drupal\Core\Database\Connection;
use Drupal\cas_server\Exception\TicketTypeException;
use Drupal\cas_server\Exception\TicketMissingException;

/**
 * Class DatabaseTicketStorage.
 */
class DatabaseTicketStorage implements TicketStorageInterface {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Database\Connection
   *   The database connection.
   */
  public function __construct(Connection $database_connection) {
    $this->connection = $database_connection;
  }

  /**
   * {@inheritdoc}
   */
  public function storeServiceTicket(ServiceTicket $ticket) {
    $this->connection->insert('cas_server_ticket_store')
      ->fields(
        array('id', 'expiration', 'type', 'session', 'service'),
        array($ticket->id, $ticket->expirationTime, 'service', $ticket->session, $ticket->service),
      )
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function retrieveServiceTicket($ticket_string) {
    $result = $this->connection->select('cas_server_ticket_store', 'c')
      ->fields('c', array('id', 'expiration', 'type', 'session', 'service')
      ->condition('id', $ticket_string)
      ->execute()
      ->fetch();
    if (!empty($result)) {
      if ('type' == 'service') {
        return new ServiceTicket($result->id, $result->expiration, $result->service, $result->session);
      }
      else {
        throw new TicketTypeException();
      }
    }
    else {
      throw new TicketMissingException();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function deleteServiceTicket(ServiceTicket $ticket) {
    $this->connection->delete('cas_server_ticket_store')
      ->condition('id', $ticket->id)
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function purgeUnvalidatedServiceTickets() {
    $this->connection->delete('cas_server_ticket_store')
      ->condition('type', 'service')
      ->condition('expiration', date('Y-m-d H:i:s'), '<')
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function storeProxyTicket(ProxyTicket $ticket) {
    $this->connection->insert('cas_server_ticket_store')
      ->fields(
        array('id', 'expiration', 'type', 'session', 'service'),
        array($ticket->id, $ticket->expirationTime, 'proxy', $ticket->session, $ticket->service),
      )
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function retrieveProxyTicket($ticket_string) {
    $result = $this->connection->select('cas_server_ticket_store', 'c')
      ->fields('c', array('id', 'expiration', 'type', 'session', 'service')
      ->condition('id', $ticket_string)
      ->execute()
      ->fetch();
    if (!empty($result)) {
      if ('type' == 'service') {
        return new ServiceTicket($result->id, $result->expiration, $result->service, $result->session);
      }
      else if ('type' == 'proxy') {
        return new ProxyTicket($result->id, $result->expiration, $result->service, $result->session);
      }
      else {
        throw new TicketTypeException();
      }
    }
    else {
      throw new TicketMissingException();
    }
  }
  
  /**
   * {@inheritdoc}
   */
  public function deleteProxyTicket(ProxyTicket $ticket) {
    $this->connection->delete('cas_server_ticket_store')
      ->condition('id', $ticket->id)
      ->execute();
  }
  
  /**
   * {@inheritdoc}
   */
  public function purgeUnvalidatedProxyTickets() {
    $this->connection->delete('cas_server_ticket_store')
      ->condition('type', 'proxy')
      ->condition('expiration', date('Y-m-d H:i:s'), '<')
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function storeProxyGrantingTicket(ProxyGrantingTicket $ticket) {
    $this->connection->insert('cas_server_ticket_store')
      ->fields(
        array('id', 'expiration', 'type', 'session'),
        array($ticket->id, $ticket->expirationTime, 'proxygranting', $ticket->session),
      )
      ->execute();
  }
  
  /**
   * {@inheritdoc}
   */
  public function retrieveProxyGrantingTicket($ticket_string) {
    $result = $this->connection->select('cas_server_ticket_store', 'c')
      ->fields('c', array('id', 'expiration', 'type', 'session', 'service')
      ->condition('id', $ticket_string)
      ->execute()
      ->fetch();
    if (!empty($result)) {
      if ('type' == 'proxygranting') {
        return new ProxyGrantingTicket($result->id, $result->expiration, $result->session);
      }
      else {
        throw new TicketTypeException();
      }
    }
    else {
      throw new TicketMissingException();
    }
  }
  
  /**
   * {@inheritdoc}
   */
  public function deleteProxyGrantingTicket(ProxyGrantingTicket $ticket) {
    $this->connection->delete('cas_server_ticket_store')
      ->condition('id', $ticket->id)
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function purgeExpiredProxyGrantingTickets() {
    $this->connection->delete('cas_server_ticket_store')
      ->condition('type', 'proxygranting')
      ->condition('expiration', date('Y-m-d H:i:s'), '<')
      ->execute();
  }
  
  /**
   * {@inheritdoc}
   */
  public function storeTicketGrantingTicket(TicketGrantingTicket $ticket) {
    $this->connection->insert('cas_server_ticket_store')
      ->fields(
        array('id', 'expiration', 'type', 'session'),
        array($ticket->id, $ticket->expirationTime, 'ticketgranting', $ticket->session),
      )
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function retrieveTicketGrantingTicket($ticket_string) {
    $result = $this->connection->select('cas_server_ticket_store', 'c')
      ->fields('c', array('id', 'expiration', 'type', 'session', 'service')
      ->condition('id', $ticket_string)
      ->execute()
      ->fetch();
    if (!empty($result)) {
      if ('type' == 'ticketgranting') {
        return new TicketGrantingTicket($result->id, $result->expiration, $result->session);
      }
      else {
        throw new TicketTypeException();
      }
    }
    else {
      throw new TicketMissingException();
    }
  }
  
  /**
   * {@inheritdoc}
   */
  public function deleteTicketGrantingTicket(TicketGrantingTicket $ticket) {
    $this->connection->delete('cas_server_ticket_store')
      ->condition('id', $ticket->id)
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function purgeExpiredTicketGrantingTickets() {
    $this->connection->delete('cas_server_ticket_store')
      ->condition('type', 'ticketgranting')
      ->condition('expiration', date('Y-m-d H:i:s'), '<')
      ->execute();
  }

}
