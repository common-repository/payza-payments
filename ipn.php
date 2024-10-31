<?php
/**
 * Payza IPN
 * handling incoming IPN requests
 */

// load WordPress core
require '../../../wp-load.php';

if ( count($_POST) ) {
  if ( get_option('payza_environment') == 'sandbox' )
    validate_token('https://sandbox.payza.com/sandbox/IPN2.ashx');
  else
    validate_token('https://secure.payza.com/ipn2.ashx');
}

/**
 * Validate Payza token and save payment info
 */
function validate_token($handler) {
  global $wpdb;
  
  $token = urlencode($_POST['token']);
  
  $token = "token=".$token;
  
  $response = '';
  
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL, $handler);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $token);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  
  $response = curl_exec($ch);
  
  curl_close($ch);
  
  if(strlen($response) > 0)
  {
    if(urldecode($response) == "INVALID TOKEN")
    {
      //the token is not valid
    }
    else
    {
      $response = urldecode($response);
      
      $aps = explode("&", $response);
      
      $info = array();
      
      foreach ($aps as $ap)
      {
        $ele = explode("=", $ap);
        $info[$ele[0]] = $ele[1];
      }
      
      //setting information about the transaction from the IPN information array
      $receivedMerchantEmailAddress = $info['ap_merchant'];
      $transactionStatus = $info['ap_status'];
      $testModeStatus = $info['ap_test'];
      $purchaseType = $info['ap_purchasetype'];
      $totalAmountReceived = $info['ap_totalamount'];
      $feeAmount = $info['ap_feeamount'];
      $netAmount = $info['ap_netamount'];
      $transactionReferenceNumber = $info['ap_referencenumber'];
      $currency = $info['ap_currency'];
      $transactionDate = $info['ap_transactiondate'];
      $transactionType = $info['ap_transactiontype'];
      
      //setting the customer's information from the IPN information array
      $customerFirstName = $info['ap_custfirstname'];
      $customerLastName = $info['ap_custlastname'];
      $customerAddress = $info['ap_custaddress'];
      $customerCity = $info['ap_custcity'];
      $customerState = $info['ap_custstate'];
      $customerCountry = $info['ap_custcountry'];
      $customerZipCode = $info['ap_custzip'];
      $customerEmailAddress = $info['ap_custemailaddress'];
      
      //setting information about the purchased item from the IPN information array
      $myItemName = $info['ap_itemname'];
      $myItemCode = $info['ap_itemcode'];
      $myItemDescription = $info['ap_description'];
      $myItemQuantity = $info['ap_quantity'];
      $myItemAmount = $info['ap_amount'];
      
      //setting extra information about the purchased item from the IPN information array
      $additionalCharges = $info['ap_additionalcharges'];
      $shippingCharges = $info['ap_shippingcharges'];
      $taxAmount = $info['ap_taxamount'];
      $discountAmount = $info['ap_discountamount'];
      
      //setting your customs fields received from the IPN information array
      $myCustomField_1 = $info['apc_1'];
      $myCustomField_2 = $info['apc_2'];
      $myCustomField_3 = $info['apc_3'];
      $myCustomField_4 = $info['apc_4'];
      $myCustomField_5 = $info['apc_5'];
      $myCustomField_6 = $info['apc_6'];
      
      $insert_data = array('amount' => $totalAmountReceived,
                           'currency' => $currency,
                           'status' => $transactionStatus,
                           'firstname' => $customerFirstName,
                           'lastname' => $customerLastName,
                           'email' => $customerEmailAddress,
                           'description' => $myItemDescription,
                           'summary' => $response,
                           'created' => time());
      
      $insert_format = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d');
      
      $wpdb->insert('hccoder_payza', $insert_data, $insert_format);
    }
  }
  else
  {
    //something is wrong, no response is received from Payza
  }
}