<?php

/**
 * @file
 * Contains \Drupal\cas_server\Controller\UserActionController.
 */

namespace Drupal\cas_server\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class UserActionController.
 */
class UserActionController implements ContainerInjectionInterface {

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
   * Handles a page request for /cas/login.
   */
  public function login() {
    // @TODO
  }

  /**
   * Handles a page request for /cas/logout.
   */
  public function logout() {
    // @TODO

  }

}
