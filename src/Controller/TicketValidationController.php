<?php

/**
 * @file
 * Contains \Drupal\cas_server\Controller\TicketValidationController.
 */

namespace Drupal\cas_server\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class TicketValidationController.
 */
class TicketValidationController implements ContainerInjectionInterface {

  /**
   * Used to get the query string parameters from the request.
   *
   * @var RequestStack
   */
  protected $requestStack;

  /**
   * Constructor.
   *
   * @param RequestStack $request_stack
   *   Symfony request stack.
   */
  public function __construct(RequestStack $request_stack) {
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('request_stack'));
  }

  /**
   * Handles a validation request for CASv1.
   */
  public function validate1() {
    // @TODO
  }

  /**
   * Handles a validation request for CASv2.
   */
  public function validate2() {
    // @TODO

  }

  /**
   * Handles a proxy validation request for CASv2.
   */
  public function proxyValidate2() {
    // @TODO
  }

  /**
   * Handles a validation request for CASv3.
   */
  public function validate3() {
    // @TODO
  }

  /**
   * Handles a proxy validation request for CASv3.
   */
  public function proxyValidate3() {
    // @TODO
  }

}
