<?php   
  
class paypal
{
  //paypal specific
  public $paypal_api_env;
  public $return_url;
  public $cancel_url;
  public $ip_address;
  public $credit_card_type;
  public $credit_card_number;
  public $expiration_date;
  public $cvv2;
  public $salutation;
  public $email;
  public $first_name;
  public $middle_name;
  public $last_name;
  public $suffix;
  public $address1;
  public $address2;
  public $city;
  public $state;
  public $country = 'US';
  public $postal_code;
  public $phone_number;
  public $amount;
  public $currency = 'USD';
  public $description;
  public $profile_ref;
  public $token;
  public $payer_id;
  public $profile_start_date;
  public $period = 'Month';
  public $frequency = 1;
  public $max_failed_payments;
  public $brand_name;
  public $trial_period;
  public $trial_frequency;
  public $trial_cycles;
  public $trial_amount;
  
  //other
  public $error;
  public $express_checkout_redirect_url;

  function __construct( $arr = array())
  {
    foreach ($arr as $key => $value)
    {
      $this->$key = $value;
    }
    
    if ($this->expiration_date())
    {
      $this->expiration_date = date('m-Y',strtotime($this->expiration_date()));
    }

    $this->paypal_api_username = sfConfig::get('app_paypal_api_username');
    $this->paypal_api_password = sfConfig::get('app_paypal_api_password');
    $this->paypal_api_signature = sfConfig::get('app_paypal_api_signature');
    $this->paypal_api_endpoint = sfConfig::get('app_paypal_api_endpoint');
    $this->paypal_api_webscr = sfConfig::get('app_paypal_api_webscr');
    $this->paypal_api_version = sfConfig::get('app_paypal_api_version');
  }

  public function __call($method, $args)
  {
    if (isset($this->$method))
    {
      return urldecode($this->$method);
    }

    return null;
  }

  public function getTransactionSearchArray($start_date = null, $end_date = null)
  {
    $result = $this->getTransactionSearch($start_date, $end_date );

    if (isset($result['ACK']))
    {
      if ( strpos(strtolower($result['ACK']),'success') !== false)
      {
        $result['TRANSACTIONS'] = array();
        foreach ($result as $key => $value)
        {
          $num = preg_replace('/[^0-9]+/', '', $key);
    
          if (is_numeric($num))
          {
            $column_name = str_replace($num,'',$key);

            if (in_array($column_name, array('L_TIMESTAMP', 'L_TIMEZONE', 'L_TYPE', 'L_EMAIL', 'L_NAME', 'L_TRANSACTIONID', 'L_STATUS', 'L_AMT', 'L_CURRENCYCODE', 'L_FEEAMT', 'L_NETAMT') )) {

              $result['TRANSACTIONS'][$num][ $column_name ] = urldecode($value);
              unset($result[$key]);
            }
          }
        }
      }
    }

    return $result;
  }
  
  public function getTransactionSearch($start_date = null, $end_date = null)
  {
    if (!$start_date)
    {
      $start_date = date('c', strtotime('now - 1 month'));
    }

    $nvpStr = '&PROFILEID='.urlencode($this->profile_ref());
    $nvpStr .= '&STARTDATE='.urlencode($start_date);
    $nvpStr .= '&ENDDATE='.urlencode($end_date);

    $result = $this->paypalHttpPost('TransactionSearch', $nvpStr);

    if (isset($result['ACK']))
    {
      if ( strpos(strtolower($result['ACK']),'success') === false)
      {
        $this->error = (isset($result['L_LONGMESSAGE0'])) ? $result['L_LONGMESSAGE0'] : '';
      }
    }

    return $result;
  }
  
  public function getRecurringPaymentsProfileDetails()
  {
    $nvpStr = '&PROFILEID='.urlencode($this->profile_ref());
    
    $result = $this->paypalHttpPost('GetRecurringPaymentsProfileDetails', $nvpStr);

    if (isset($result['ACK']))
    {
      if ( strpos(strtolower($result['ACK']),'success') === false)
      {
        $this->error = (isset($result['L_LONGMESSAGE0'])) ? $result['L_LONGMESSAGE0'] : '';
      }
    }
    
    return $result;
  }

  public function createRecurringPaymentProfile()
  {
    $nvpStr = '&BILLINGTYPE=RecurringPayments';
    $nvpStr .= '&PAYMENTACTION=Authorization';
    $nvpStr .= '&RETURNURL='.urlencode($this->return_url());
    $nvpStr .= '&CANCELURL='.urlencode($this->cancel_url());
    $nvpStr .= '&IPADDRESS='.urlencode($this->ip_address());
    $nvpStr .= '&CREDITCARDTYPE='.urlencode($this->credit_card_type());
    $nvpStr .= '&ACCT='.urlencode($this->credit_card_number());
    $nvpStr .= '&EXPDATE='.urlencode($this->expiration_date());
    $nvpStr .= '&CVV2='.urlencode($this->cvv2());
    $nvpStr .= '&COUNTRYCODE='.urlencode($this->country());
    $nvpStr .= '&SALUTATION='.urlencode($this->salutation());

    $nvpStr .= '&EMAIL='.urlencode($this->email());
    $nvpStr .= '&FIRSTNAME='.urlencode($this->first_name());
    $nvpStr .= '&MIDDLENAME='.urlencode($this->middle_nam());
    $nvpStr .= '&LASTNAME='.urlencode($this->last_name());
    $nvpStr .= '&SUFFIX='.urlencode($this->suffix());
    
    $nvpStr .= '&STREET='.urlencode($this->address1());
    $nvpStr .= '&STREET2='.urlencode($this->address2());
    $nvpStr .= '&CITY='.urlencode($this->city());
    $nvpStr .= '&STATE='.urlencode($this->state());
    $nvpStr .= '&COUNTRYCODE='.urlencode($this->country());
    $nvpStr .= '&ZIP='.urlencode($this->postal_code());
    $nvpStr .= '&PHONENUM='.urlencode($this->phone_number());
    
    $nvpStr .= '&AMT='.urlencode($this->amount());
    $nvpStr .= '&CURRENCYCODE='.urlencode($this->currency());
    $nvpStr .= '&DESC='.urlencode($this->description());
    $nvpStr .= '&INVNUM='.urlencode($this->profile_ref());
    
    $nvpStr .= '&TOKEN='.urlencode($this->token());
    $nvpStr .= '&PAYERID='.urlencode($this->payer_id());
    
    $nvpStr .= '&PROFILESTARTDATE='.urlencode($this->profile_start_date());
    $nvpStr .= '&BILLINGPERIOD='.urlencode($this->period());
    $nvpStr .= '&BILLINGFREQUENCY='.urlencode($this->frequency());
    $nvpStr .= '&MAXFAILEDPAYMENTS='.urlencode($this->max_failed_payments());
    
    $nvpStr .= '&TRIALBILLINGPERIOD='.urlencode($this->trial_period());
    $nvpStr .= '&TRIALBILLINGFREQUENCY='.urlencode($this->trial_frequency());
    $nvpStr .= '&TRIALTOTALBILLINGCYCLES='.urlencode($this->trial_cycles());
    $nvpStr .= '&TRIALAMT='.urlencode($this->trial_amount());

    $result = $this->paypalHttpPost('CreateRecurringPaymentsProfile', $nvpStr);

    if (isset($result['ACK']))
    {
      if ( strpos(strtolower($result['ACK']),'success') !== false)
      {
        $this->profile_ref = $result['PROFILEID'];
        
        return true;
      }
      
      $this->error = (isset($result['L_LONGMESSAGE0'])) ? $result['L_LONGMESSAGE0'] : '';
      
    }
    
    return false;
  }

  public function cancelProfile()
  {
    $nvpStr = '&PROFILEID='.urlencode($this->profile_ref());
    $nvpStr .= '&ACTION=Cancel';
    
    $result = $this->paypalHttpPost('ManageRecurringPaymentsProfileStatus', $nvpStr);

    if (isset($result['ACK']))
    {
      if ( strpos(strtolower($result['ACK']),'success') !== false)
      {
        return true;
      }
      
      $this->error = (isset($result['L_LONGMESSAGE0'])) ? $result['L_LONGMESSAGE0'] : '';
    }
    
    return false;
  }
  
  public function getExpressCheckoutRedirectUrl()
  {
    return $this->express_checkout_redirect_url(); 
  }

  public function setExpressCheckout ()
  {
    $nvpStr = '&RETURNURL='.urlencode($this->return_url());
    $nvpStr .= '&CANCELURL='.urlencode($this->cancel_url());
    $nvpStr .= '&AMT='.$this->amount();
    $nvpStr .= '&BRANDNAME='.$this->brand_name();
    $nvpStr .= '&NOSHIPPING=1';
    $nvpStr .= '&LANDINGPAGE=Login';
    $nvpStr .= '&CHANNELTYPE=Merchant';
    $nvpStr .= '&L_BILLINGTYPE0=RecurringPayments';
    $nvpStr .= '&L_BILLINGAGREEMENTDESCRIPTION0='.urlencode($this->description());

    $result = $this->paypalHttpPost('SetExpressCheckout', $nvpStr);

    if ( strpos(strtolower($result['ACK']),'success') !== false)
    {
      $this->express_checkout_redirect_url = $this->paypal_api_webscr.'?cmd=_express-checkout&token='.$result['TOKEN'];
      
      return true;
    }
    
    $this->error = (isset($result['L_LONGMESSAGE0'])) ? $result['L_LONGMESSAGE0'] : '';
    
    
    return false;
  }
  
  public function getExpressCheckoutDetails ()
  {
    $nvpStr = '&TOKEN='.$this->token();
    
    $result = $this->paypalHttpPost('GetExpressCheckoutDetails', $nvpStr);
    
    if (isset($result['ACK']))
    {
      if ( strpos(strtolower($result['ACK']),'success') === false)
      {
        $this->error = (isset($result['L_LONGMESSAGE0'])) ? $result['L_LONGMESSAGE0'] : '';
      }
    }

    return $result;
  }

  public function getError()
  {
    return urldecode($this->error);
  }
  
  /*
  * Send HTTP POST Request
  *
  * @param  string  The API method name
  * @param  string  The POST Message fields in &name=value pair format
  * @return  array  Parsed HTTP Response body
  */
  private function paypalHttpPost($methodName_, $nvpStr_)
  {
    $environment = $this->paypal_api_env();
  
    $API_UserName = urlencode($this->paypal_api_username());
    $API_Password = urlencode($this->paypal_api_password());
    $API_Signature = urlencode($this->paypal_api_signature());
    $API_Endpoint = $this->paypal_api_endpoint();

    $version = urlencode($this->paypal_api_version());

    // setting the curl parameters.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
  
    // turning off the server and peer verification(TrustManager Concept).
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
  
    // NVPRequest for submitting to server
    $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
  
    // setting the nvpreq as POST FIELD to curl
    curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
  
    // getting response from server
    $httpResponse = curl_exec($ch);
  
    if(!$httpResponse)
    {
      exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
    }

    // Extract the RefundTransaction response details
    $httpResponseAr = explode("&", $httpResponse);
  
    $httpParsedResponseAr = array();
    foreach ($httpResponseAr as $i => $value)
    {
      $tmpAr = explode("=", $value);
      if(sizeof($tmpAr) > 1)
      {
        $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
      }
    }
  
    if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr))
    {
      exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
    }
  
    return $httpParsedResponseAr;
  }
}