<?php
/**
 * Our main class
 */
if ( ! class_exists('HCCoder_PayzaAdmin') ) {
  class HCCoder_PayzaAdmin {
  
    /**
     * Admin interface > overview
     */
    public function adminIndex() {
      $config = HCCoder_PayzaConfig::getInstance();
      require $config->getItem('views_path').'adminindex.php';
    }
    
    /**
     * Admin interface > configuration
     */
    public function adminConfiguration() {
      $config = HCCoder_PayzaConfig::getInstance();
      
      $environment_values = array('sandbox', 'live');
      if ( isset($_POST['environment']) && in_array($_POST['environment'], $environment_values) ) {
        update_option('payza_environment', $_POST['environment']);
        $config_saved = TRUE;
      }
      
      if ( isset($_POST['payza_ap_merchant']) && isset($_POST['payza_ap_security_code']) ) {
        update_option('payza_ap_merchant', $_POST['payza_ap_merchant']);
        update_option('payza_ap_security_code', $_POST['payza_ap_security_code']);
        $config_saved = TRUE;
      }
      
      require $config->getItem('views_path').'adminconfiguration.php';
    }
    
    /**
     * Admin interface > shortcode
     */
    public function adminShortcode() {
      $config = HCCoder_PayzaConfig::getInstance();
      require $config->getItem('views_path').'adminshortcode.php';
    }
    
    /**
     * Admin interface > help
     */
    public function adminHelp() {
      $config = HCCoder_PayzaConfig::getInstance();
      require $config->getItem('views_path').'adminhelp.php';
    }
    
    /**
     * Admin interface > payments history
     */
    public function adminHistory() {
      $config = HCCoder_PayzaConfig::getInstance();
      
      global $wpdb;
      
      $allowed_statuses = array('Success', 'Pending', 'Failed');
      if ( count($_POST) && isset($_POST['status']) && in_array($_POST['status'], $allowed_statuses) && isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0 ) {
       $config_saved = TRUE;
       
       $update_data = array('status' => $_POST['status']);
       $where = array('id' => $_POST['id']);
        
       $update_format = array('%s');
        
       $wpdb->update('hccoder_payza', $update_data, $where, $update_format);
      }
      
      if ( isset($_GET['action']) && $_GET['action'] == 'details' && is_numeric($_GET['id']) && $_GET['id'] > 0 ) {
        $details = $wpdb->get_row('SELECT hccoder_payza.id,
                                    hccoder_payza.amount,
                                    hccoder_payza.currency,
                                    hccoder_payza.status,
                                    hccoder_payza.firstname,
                                    hccoder_payza.lastname,
                                    hccoder_payza.email,
                                    hccoder_payza.description,
                                    hccoder_payza.summary,
                                    hccoder_payza.created
                                  FROM
                                    hccoder_payza
                                  WHERE
                                    hccoder_payza.id = '. (int)$_GET['id']);
        
        require $config->getItem('views_path').'adminhistorydetails.php';
      } elseif ( isset($_GET['action']) && $_GET['action'] == 'edit' && is_numeric($_GET['id']) && $_GET['id'] > 0 ) {
        $details = $wpdb->get_row('SELECT 
                                    hccoder_payza.status
                                  FROM
                                    hccoder_payza
                                  WHERE
                                    hccoder_payza.id = '. (int)$_GET['id']);
        
        require $config->getItem('views_path').'adminhistoryedit.php';
      } else {
        $rows = $wpdb->get_results('SELECT hccoder_payza.id,
                                    hccoder_payza.amount,
                                    hccoder_payza.currency,
                                    hccoder_payza.status,
                                    hccoder_payza.firstname,
                                    hccoder_payza.lastname,
                                    hccoder_payza.email,
                                    hccoder_payza.description,
                                    hccoder_payza.summary,
                                    hccoder_payza.created
                                  FROM
                                    hccoder_payza
                                  ORDER BY
                                    hccoder_payza.id DESC');
      
        require $config->getItem('views_path').'adminhistory.php';
      }
      
    }
    
    
    /**
     * Create table for payment history
     */
    public static function pluginInstall() {
      global $wpdb;
      $wpdb->query('CREATE TABLE IF NOT EXISTS `hccoder_payza` (
                    `id` bigint(20) unsigned NOT NULL auto_increment,
                    `amount` float unsigned NOT NULL,
                    `currency` varchar(3) NOT NULL,
                    `status` text NOT NULL,
                    `firstname` text NOT NULL,
                    `lastname` text NOT NULL,
                    `email` text NOT NULL,
                    `description` text NOT NULL,
                    `summary` text NOT NULL,
                    `created` int(4) unsigned NOT NULL,
                    PRIMARY KEY  (`id`)
                  ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');
    }
    
  }
}