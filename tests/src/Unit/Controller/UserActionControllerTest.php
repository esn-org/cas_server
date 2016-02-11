<?php

/**
 * @file
 * Contains Drupal\Tests\cas_server\Unit\Controller\UserActionControllerTest.
 */

namespace Drupal\Tests\cas_server\Unit\Controller;

use Drupal\Tests\UnitTestCase;
use Drupal\cas_server\Controller\UserActionController;

/**
 * UserActionController unit tests.
 *
 * @ingroup cas_server
 * @group cas_server
 *
 * @coversDefaultClass \Drupal\cas_server\Controller\UserActionController
 */
class UserActionControllerTest extends UnitTestCase {

  /**
   * The mocked Request Stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $requestStack;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->requestStack = $this->getMock('\Symfony\Component\HttpFoundation\RequestStack');
  }

  /**
   * Test user logins.
   *
   * @covers ::login
   */
  public function testLogin() {
    // @TODO
  }

  /**
   * Test user logouts.
   *
   * @covers ::logout
   */
  public function testLogout() {
    // @TODO
  }

  /**
   * Test the static create method.
   *
   * @covers ::create
   * @covers ::__construct
   */
  public function testCreate() {

    $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
    $container->expects($this->any())
      ->method('get')
      ->willReturn($this->requestStack);

    $this->assertInstanceOf('\Drupal\cas_server\Controller\UserActionController', UserActionController::create($container));
  }

}
