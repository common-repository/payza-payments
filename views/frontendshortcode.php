<form method="post" action="<?php echo get_option('payza_environment') == 'sandbox' ? 'https://sandbox.Payza.com/sandbox/payprocess.aspx ' : 'https://secure.payza.com/checkout'; ?>">
  <input type="hidden" name="ap_merchant" value="<?php echo get_option('payza_ap_merchant'); ?>"/>
  <input type="hidden" name="ap_purchasetype" value="<?php echo $atts['purchasetype']; ?>"/>
  <input type="hidden" name="ap_itemname" value="<?php echo $atts['itemname']; ?>"/>
  <input type="hidden" name="ap_amount" value="<?php echo $atts['amount']; ?>"/>
  <input type="hidden" name="ap_currency" value="<?php echo $atts['currency']; ?>"/>
  
  <?php if ( isset($atts['quantity']) ) { ?>
    <input type="hidden" name="ap_quantity" value="<?php echo $atts['quantity']; ?>"/>
  <?php } ?>
  
  <?php if ( isset($atts['itemcode']) ) { ?>
    <input type="hidden" name="ap_itemcode" value="<?php echo $atts['itemcode']; ?>"/>
  <?php } ?>
  
  <?php if ( isset($atts['description']) ) { ?>
    <input type="hidden" name="ap_description" value="<?php echo $atts['description']; ?>"/>
  <?php } ?>
  
  <?php if ( isset($atts['returnurl']) ) { ?>
    <input type="hidden" name="ap_returnurl" value="<?php echo $atts['returnurl']; ?>"/>
  <?php } ?>
  
  <?php if ( isset($atts['cancelurl']) ) { ?>
    <input type="hidden" name="ap_cancelurl" value="<?php echo $atts['cancelurl']; ?>"/>
  <?php } ?>
  
  <input type="image" src="https://www.payza.com/images/payza-buy-now.png"/>
</form>