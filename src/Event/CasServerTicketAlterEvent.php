<?php

namespace Drupal\cas_server\Event;


use Drupal\cas_server\Ticket\ServiceTicket;
use Drupal\user\UserInterface;
use Symfony\Component\EventDispatcher\Event;

class CasServerTicketAlterEvent extends Event {

  const CAS_SERVER_TICKET_ALTER_EVENT = 'cas_server.ticket.alter';

  protected $ticket;

  /**
   * CasServerTicketAlterEvent constructor.
   *
   * @param UserInterface $user
   * @param ServiceTicket $ticket
   */
  public function __construct(ServiceTicket $ticket) {
    $this->ticket = $ticket;
  }

  /**
   * @return ServiceTicket
   */
  public function getTicket() {
    return $this->ticket;
  }

}
