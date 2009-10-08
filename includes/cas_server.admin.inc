<?php
// $Id$ 

function cas_server_admin_form() {
  $form = array();
  $form['cas_server_warning_box'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show warning checkbox'),
    '#description' => t('The CAS server can let the logging in user decide if they would like to be warned when multiple services are authenticating them against this CAS server. By checking this box, the user will be presented with this option on the login form.'),
    '#default_value' => variable_get('cas_server_warning_box', FALSE),
  );
  
  $form['cas_server_username_value'] = array(
    '#type' => 'select',
    '#title' => t('Username'),
    '#options' => array('name' => t('Username'), 'mail' => t('E-mail')),
    '#description' => t('Select which of the options should be sent as the username to a service'),
    '#default_value' => variable_get('cas_server_username_value', 'name'),
  );
  
  return system_settings_form($form);
}