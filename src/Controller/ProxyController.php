<?php

/**
 * @file
 * Contains \Drupal\cas_server\Controller\ProxyController.
 */

namespace Drupal\cas_server\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\cas_server\Ticket\TicketStorageInterface;
use Drupal\cas_server\Exception\TicketTypeException;
use Drupal\cas_server\Exception\TicketMissingException;
use Drupal\cas_server\Logger\DebugLogger;

/**
 * Class ProxyController.
 */
class ProxyController implements ContainerInjectionInterface {
  
  /**
   * Used to get the query string parameters from the request.
   *
   * @var RequestStack
   */
  protected $requestStack;

  /**
   * The ticket store.
   *
   * @var TicketStorageInterface
   */
  protected $ticketStore;

  /**
   * The logger.
   *
   * @var DebugLogger
   */
  protected $logger;

  /**
   * Constructor.
   *
   * @param RequestStack $request_stack
   *   Symfony request stack.
   * @param TicketStorageInterface $ticket_store
   *   The ticket store.
   * @param DebugLogger $debug_logger
   *   The logger.
   */
  public function __construct(RequestStack $request_stack, TicketStorageInterface $ticket_store, DebugLogger $debug_logger) {
    $this->requestStack = $request_stack;
    $this->ticketStore = $ticket_store;
    $this->logger = $debug_logger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('request_stack'), $container->get('cas_server.storage'), $container->get('cas_server.logger'));
  }

  /**
   * Supply a proxy ticket to a request with a valid proxy-granting ticket.
   */
  public function proxy() {
    // TODO
  }

}
