<?php

/**
 * @file
 * Contains Drupal\Tests\cas_server\Unit\Controller\TicketValidationControllerTest.
 */

namespace Drupal\Tests\cas_server\Unit\Controller;

use Drupal\Tests\UnitTestCase;
use Drupal\cas_server\Controller\TicketValidationController;


/**
 * TicketValidationController unit tests.
 *
 * @ingroup cas_server
 * @group cas_server
 *
 * @coversDefaultClass \Drupal\cas_server\Controller\TicketValidationController
 */
class TicketValidationControllerTest extends UnitTestCase {

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
   * Test CASv1 validation.
   *
   * @covers ::validate1
   */
  public function testValidate1() {
    // @TODO
  }

  /**
   * Test CASv2 validation.
   *
   * @covers ::validate2
   */
  public function testValidate2() {
    // @TODO
  }

  /**
   * Test CASv2 proxy validation.
   *
   * @covers ::proxyValidate2
   */
  public function testProxyValidate2() {
    // @TODO
  }

  /**
   * Test CASv3 validation.
   *
   * @covers ::validate3
   */
  public function testValidate3() {
    // @TODO
  }

  /**
   * Test CASv3 proxy validation.
   *
   * @covers ::proxyValidate3
   */
  public function testProxyValidate3() {
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

    $this->assertInstanceOf('\Drupal\cas_server\Controller\TicketValidationController', TicketValidationController::create($container));
  }

}
