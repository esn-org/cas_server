<?php

/**
 * @file
 * Contains \Drupal\cas\Form\UserLogin.
 */

namespace Drupal\cas_server\Form;

use Drupal\user\UserAuthInterface;
use Drupal\user\Entity\User;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Utility\Crypt;
use Drupal\cas_server\Ticket\TicketFactory;
use Drupal\cas_server\Configuration\ConfigHelper;
use Drupal\Core\Url;

/**
 * Class UserLogin.
 *
 * @codeCoverageIgnore
 */
class UserLogin extends FormBase {

  /**
   * Constructs a \Drupal\cas_server\Form\UserLogin object.
   *
   * @param UserAuthInterface $user_auth
   *   The authentication provider.
   * @param TicketFactory $ticket_factory
   *   The ticket factory.
   * @param ConfigHelper $config_helper
   *   The configuration helper.
   */
  public function __construct(UserAuthInterface $user_auth, TicketFactory $ticket_factory, ConfigHelper $config_helper) {
    $this->authService = $user_auth;
    $this->ticketFactory = $ticket_factory;
    $this->configHelper = $config_helper;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('user.auth'), $container->get('cas_server.ticket_factory'), $container->get('cas_server.config_helper'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'cas_server_user_login';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $service = '') {
    $form['username'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    );

    $form['password'] = array(
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#size' => 60,
      '#required' => TRUE,
    );

    $lt = 'LT-' . Crypt::randomBytesBase64(32);
    $_SESSION['cas_lt'] = $lt;

    $form['lt'] = array(
      '#type' => 'hidden',
      '#value' => $lt,
    );

    $form['service'] = array(
      '#type' => 'hidden',
      '#value' => $service,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('lt') != $_SESSION['cas_lt']) {
      $form_state->setErrorByName('lt', $this->t('Login ticket invalid. Please try again.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $username = trim($form_state->getValue('username'));
    $password = trim($form_state->getValue('password'));
    $service = $form_state->getValue('service');
    if ($uid = $this->authService->authenticate($username, $password)) {
      $account = User::load($uid);
      user_login_finalize($account);
      if (empty($service) || $this->configHelper->verifyServiceForSso($service)) {
        $tgt = $this->ticketFactory->createTicketGrantingTicket();
        setcookie('cas_tgc', $tgt->getId(), REQUEST_TIME + $this->configHelper->getTicketGrantingTicketTimeout(), '/cas');
      }
      if (!empty($service)) {
        $st = $this->ticketFactory->createServiceTicket($service, TRUE);
        $url = Url::fromUri($service, ['query' => ['ticket' => $st->getId()]]);
        $form_state->setRedirectUrl($url);
      }
      else {
        $form_state->setRedirectUrl(Url::fromRoute('cas_server.login'));
      }
    }

  }

}
