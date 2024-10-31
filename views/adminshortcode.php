<div class="wrap">
  <h2>Payza Payments - Shortcode</h2>
  
  <?php if ( get_option('payza_ap_merchant') == '' || get_option('payza_ap_security_code') == '' ) { ?>
    <div class="updated" id="message">
		  <p><strong>Before you can use shortcode you need to set your Payza credentials, go to <a href="<?php echo $config->getItem('plugin_configuration_url'); ?>" title="configuration page">the configuration page</a>.</strong></p>
		</div>
  <?php } else { ?>
    <p>
      You can easily add Payza buttons to your pages with shortcode. Here you can see the shortcode options.<br />
      If you need help visit the <a href="<?php echo $config->getItem('plugin_help_url'); ?>" title="Payza Help">Help</a> page.
    </p>
    <p>&nbsp;</p>
    <p>
      <strong>Example #1</strong>(pay 30 USD)<br />
      [payza amount=30 currency="USD" purchasetype="item" itemname="My Super Test Item"]
    </p>
    
    <p>
      Here you can found the supported currencies and currency codes. <a href="https://dev.payza.com/resources/references/currency-codes" target="_blank" title="Supported currencies">Supported currencies</a>.
    </p>
    <p>
     Supported values for purchasetype:
    </p>
    <ul style="list-style-type:decimal;margin:0px 0px 0px 35px;">
      <li>item</li>
      <li>service</li>
      <li>item-goods</li>
      <li>item-auction</li>
    </ul>
    
    <p>&nbsp;</p>
    <p>
      <strong>Example #2</strong>(all parameters passed)<br />
      [payza amount=30 currency="USD" purchasetype="item" itemname="My Super Test Item" quantity=1 itemcode="XYZ123" description="Best test item every seen" returnurl="http://hccoder.info/payza/return/" cancelurl="http://hccoder.info/payza/cancel/"]
    </p>
  <?php } ?>
</div><!-- .wrap -->