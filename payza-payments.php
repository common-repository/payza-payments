<?php
/*
Plugin Name: Payza Payments
Plugin URI: http://hccoder.info/
Description: Easy integration of Payza payments / AlertPay payments
Author: hccoder - Sándor Fodor
Version: 1.0
Author URI: http://hccoder.info/
*/

require ABSPATH.'wp-content/plugins/payza-payments/classes/config.php';
require ABSPATH.'wp-content/plugins/payza-payments/classes/shortcode.php';
require ABSPATH.'wp-content/plugins/payza-payments/classes/payza-admin.php';

/* Set base configuration */
$config = HCCoder_PayzaConfig::getInstance();

$config->addItem('plugin_id', 'payza-payments');
$config->addItem('plugin_configuration_id', 'payza-payments-configuration');
$config->addItem('plugin_shortcode_id', 'payza-payments-shortcode');
$config->addItem('plugin_help_id', 'payza-payments-help');
$config->addItem('plugin_history_id', 'payza-payments-history');

$config->addItem('plugin_path', plugin_dir_path(__FILE__));
$config->addItem('views_path', $config->getItem('plugin_path').'views/');

$config->addItem('plugin_url', home_url('/wp-admin/admin.php?page='.$config->getItem('plugin_id')));
$config->addItem('plugin_configuration_url', home_url('/wp-admin/admin.php?page='.$config->getItem('plugin_configuration_id')));
$config->addItem('plugin_shortcode_url', home_url('/wp-admin/admin.php?page='.$config->getItem('plugin_shortcode_id')));
$config->addItem('plugin_help_url', home_url('/wp-admin/admin.php?page='.$config->getItem('plugin_help_id')));
$config->addItem('plugin_history_url', home_url('/wp-admin/admin.php?page='.$config->getItem('plugin_history_id')));

$config->addItem('plugin_ipn_url', home_url('/wp-content/plugins/'.$config->getItem('plugin_id').'/ipn.php'));

$config->addItem('plugin_name', 'Payza');

/**
 * Create admin menus
 */
function payza_payments_admin_menu() {
  $config = HCCoder_PayzaConfig::getInstance();
  
  add_menu_page($config->getItem('plugin_name'), $config->getItem('plugin_name'), 'level_10', $config->getItem('plugin_id'), array('HCCoder_PayzaAdmin', 'adminIndex'), home_url('/wp-content/plugins/'.$config->getItem('plugin_id').'/static/images/icon.png'));
  add_submenu_page($config->getItem('plugin_id'), 'Configuration', 'Configuration', 'level_10', $config->getItem('plugin_configuration_id'), array('HCCoder_PayzaAdmin', 'adminConfiguration'));
  add_submenu_page($config->getItem('plugin_id'), 'Shortcode', 'Shortcode', 'level_10', $config->getItem('plugin_shortcode_id'), array('HCCoder_PayzaAdmin', 'adminShortcode'));
  add_submenu_page($config->getItem('plugin_id'), 'Payments history', 'Payments history', 'level_10', $config->getItem('plugin_history_id'), array('HCCoder_PayzaAdmin', 'adminHistory'));
  add_submenu_page($config->getItem('plugin_id'), 'Help', 'Help', 'level_10', $config->getItem('plugin_help_id'), array('HCCoder_PayzaAdmin', 'adminHelp'));
}
add_action('admin_menu', 'payza_payments_admin_menu');

/**
 * Create shortcode
 */
add_shortcode('payza', array('HCCoder_PayzaShortcode', 'frontendIndex'));

/**
 * Create table for payment history on plugin activation
 */
register_activation_hook(__FILE__, array('HCCoder_PayzaAdmin', 'pluginInstall'));