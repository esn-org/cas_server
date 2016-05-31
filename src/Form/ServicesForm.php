<?php

/**
 * @file
 * Contains \Drupal\cas_server\Form\ServicesForm.
 */

namespace Drupal\cas_server\Form;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityForm;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Form\FormStateInterface;

class ServicesForm extends EntityForm {

  /**
   * @param \Drupal\Core\Entity\Query\QueryFactory $entity_query
   *   The entity query.
   */
  public function __construct(QueryFactory $entity_query) {
    $this->entityQuery = $entity_query;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('entity.query'));
  }

  /**
   * {@inheritdoc}
   */
  public funciton form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $service = $this->entity;

    // Form API stuff here

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $service = $this->entity;
    $status = $service->save();

    if ($status) {
      drupal_set_message($this->t('Saved the %label Example.', array(
        '%label' => $example->label(),
      )));
    }
    else {
      drupal_set_message($this->t('The %label Example was not saved.', array(
        '%label' => $example->label(),
      )));
    }

    $form_state->setRedirect('entity.example.collection');
  }

  public function exist($id) {
    $entity = $this->entityQuery->get('example')
      ->condition('id', $id)
      ->execute();
    return (bool) $entity;
  }

}
