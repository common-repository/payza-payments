<div class="wrap">
  <h2>Payza Payments - Configuration</h2>
  
  <p>
    If you need help visit the <a href="<?php echo $config->getItem('plugin_help_url'); ?>" title="Payza Help">Help</a> page.
  </p>
  
  <?php if ( isset($config_saved) && $config_saved === TRUE ) { ?>
    <div class="updated" id="message">
		  <p><strong>Configuration updated.</strong></p>
		</div>
  <?php } ?>
  
  <form method="post" action="<?php echo $config->getItem('plugin_configuration_url'); ?>">
    <table class="form-table">
      <tbody>
        <tr class="form-field">
          <th scope="row"><label for="environment"><strong>Payza environment:</strong></label></th>
          <td>
            <select id="environment" name="environment">
              <option value="">Please select</option>
              <option value="sandbox" <?php echo get_option('payza_environment') == 'sandbox' ? 'selected="selected"' : ''; ?>>Sandbox - Testing</option>
              <option value="live" <?php echo get_option('payza_environment') == 'live' ? 'selected="selected"' : ''; ?>>Live - Production</option>
            </select>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="submit">
      <input type="submit" value="Save" class="button-primary" />
    </p>
  </form>
  
  <p>
    <strong>Payza API credentials:</strong>
  </p>
  <form method="post" action="<?php echo $config->getItem('plugin_configuration_url'); ?>">
    <table class="form-table">
      <tbody>
        <tr class="form-field form-required">
          <th scope="row"><label for="payza_ap_merchant">Merchant <span class="description">(required)</span></label></th>
          <td><input type="text" aria-required="true" value="<?php echo get_option('payza_ap_merchant'); ?>" id="payza_ap_merchant" name="payza_ap_merchant"></td>
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="payza_ap_security_code">IPN security code<span class="description">(required)</span></label></th>
          <td><input type="text" aria-required="true" value="<?php echo get_option('payza_ap_security_code'); ?>" id="payza_ap_security_code" name="payza_ap_security_code"></td>
        </tr>
      </tbody>
    </table>
    <p class="submit">
      <input type="submit" value="Save" class="button-primary" />
    </p>
  </form>
  
  <table class="form-table">
    <tbody>
      <tr class="form-field form-required">
        <th scope="row"><label for="payza_ipn_url"><strong>Your IPN URL</strong></label></th>
        <td><input type="text" aria-required="true" value="<?php echo $config->getItem('plugin_ipn_url'); ?>" id="payza_ipn_url" name="payza_ipn_url"></td>
      </tr>
    </tbody>
  </table>
  
</div><!-- .wrap -->