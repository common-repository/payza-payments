<?php
/**
 * Shortcode class
 *
 * usage:
 * add_shortcode('your_shortcode_name', array('HCCoder_PayzaShortcode', 'frontendIndex'));
 */
if ( ! class_exists('HCCoder_PayzaShortcode') ) {

  class HCCoder_PayzaShortcode {
  
    public function frontendIndex($atts) {
    
      if ( ! isset($atts['amount']) || ( isset($atts['amount']) && ! is_numeric($atts['amount']) || $atts['amount'] < 0 ) )
        trigger_error('Payza shortcode error: You need to specify the amount of the payment.', E_USER_ERROR);
      
      $supported_currencies = array('AUD', 'BGN', 'CAD', 'CHF', 'CZK', 'DKK', 'EEK', 'EUR', 'GBP', 'HKD', 'HUF', 'LTL', 'MYR', 'MKD', 'NOK', 'NZD', 'PLN', 'RON', 'SEK', 'SGD', 'USD', 'ZAR');      
      if ( ! isset($atts['currency']) || ! in_array($atts['currency'], $supported_currencies) )
        trigger_error('Payza shortcode error: You need to specify the currency of the payment.', E_USER_ERROR);
    
      ob_start();
      
      $config = HCCoder_PayzaConfig::getInstance();
      
      require $config->getItem('views_path').'frontendshortcode.php';
      
      return ob_get_clean();
    }
  
  }
  
}