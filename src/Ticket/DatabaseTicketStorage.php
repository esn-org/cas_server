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
        array('id', 'expiration', 'type', 'session', 'user', 'service', 'renew'),
        array($ticket->getId(), date('Y-m-d H:i:s', $ticket->getExpirationTime()), 'service', $ticket->getSession(), $ticket->getUser(), $ticket->getService(), $ticket->getRenew()),
      )
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function retrieveServiceTicket($ticket_string) {
    $result = $this->connection->select('cas_server_ticket_store', 'c')
      ->fields('c', array('id', 'expiration', 'type', 'session', 'user', 'service', 'renew')
      ->condition('id', $ticket_string)
      ->execute()
      ->fetch();
    if (!empty($result)) {
      if ($result->type == 'service') {
        return new ServiceTicket($result->id, strtotime($result->expiration), $result->session, $result->user, $result->service, $result->renew);
      }
      else {
        throw new TicketTypeException('Expected ticket of type service; found ticket of type ' . $result->type);
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
        array('id', 'expiration', 'type', 'session', 'user', 'service', 'renew', 'proxy_chain'),
        array($ticket->getId(), date('Y-m-d H:i:s', $ticket->getExpirationTime()), 'proxy', $ticket->getSession(), $ticket->getUser(), $ticket->getService(), $ticket->getRenew(), serialize($ticket->getProxyChain())),
      )
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function retrieveProxyTicket($ticket_string) {
    $result = $this->connection->select('cas_server_ticket_store', 'c')
      ->fields('c', array('id', 'expiration', 'type', 'session', 'user', 'service', 'renew', 'proxy_chain')
      ->condition('id', $ticket_string)
      ->execute()
      ->fetch();
    if (!empty($result)) {
      if ($result->type == 'service') {
        return new ServiceTicket($result->id, strtotime($result->expiration), $result->session, $result->user, $result->service, $result->renew);
      }
      else if ($result->type == 'proxy') {
        return new ProxyTicket($result->id, strtotime($result->expiration), $result->session, $result->user, $result->session, $result->renew, unserialize($result->proxy_chain));
      }
      else {
        throw new TicketTypeException('Expected ticket of type service or proxy; found ticket of type ' . $result->type);
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
        array('id', 'expiration', 'type', 'session', 'user', 'proxy_chain'),
        array($ticket->getId(), date('Y-m-d H:i:s', $ticket->getExpirationTime()), 'proxygranting', $ticket->getSession(), $ticket->getUser(), serialize($ticket->getProxyChain()),
      )
      ->execute();
  }
  
  /**
   * {@inheritdoc}
   */
  public function retrieveProxyGrantingTicket($ticket_string) {
    $result = $this->connection->select('cas_server_ticket_store', 'c')
      ->fields('c', array('id', 'expiration', 'type', 'session', 'user', 'proxy_chain')
      ->condition('id', $ticket_string)
      ->execute()
      ->fetch();
    if (!empty($result)) {
      if ($result->type == 'proxygranting') {
        return new ProxyGrantingTicket($result->id, strtotime($result->expiration), $result->session, $result->user, unserialize($result->proxy_chain);
      }
      else {
        throw new TicketTypeException('Expected ticket of type proxygranting; found ticket of type ' . $result->type);
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
        array('id', 'expiration', 'type', 'session', 'user'),
        array($ticket->getId(), date('Y-m-d H:i:s', $ticket->getExpirationTime()), 'ticketgranting', $ticket->getSession(), $ticket->getUser()),
      )
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function retrieveTicketGrantingTicket($ticket_string) {
    $result = $this->connection->select('cas_server_ticket_store', 'c')
      ->fields('c', array('id', 'expiration', 'type', 'session', 'user')
      ->condition('id', $ticket_string)
      ->execute()
      ->fetch();
    if (!empty($result)) {
      if ($result->type == 'ticketgranting') {
        return new TicketGrantingTicket($result->id, strtotime($result->expiration), $result->session, $result->user);
      }
      else {
        throw new TicketTypeException('Expected ticket of type ticketgranting; found ticket of type ' . $result->type);
      }
    }
    else {
      throw new TicketMissingException();
    }
  }
  
  /**
   * {@inheritdoc}
   */
  public function deleteTicket(Ticket $ticket) {
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
