<?php   
  
class authorizeNet
{
  public $error;
  public $error_code;
  
  function __construct( $arr = array())
  {
    foreach ($arr as $key => $value)
    {
      $this->$key = $value;
    }

    if ($this->card_expiration())
    {
      $this->expiration_date = date('Y-m',strtotime($this->card_expiration()));
    }

    if ($this->name())
    {
      $this->first_name = Billing::findFirstName($this->name());
      $this->last_name = Billing::findLastName($this->name());
    }

    $this->auth_mode = sfConfig::get('app_auth_mode');
    $this->auth_endpoint = sfConfig::get('app_auth_endpoint');
    $this->auth_x_login = sfConfig::get('app_auth_x_login');
    $this->auth_x_tran_key = sfConfig::get('app_auth_x_tran_key');
    $this->auth_x_version = sfConfig::get('app_auth_x_version');
    $this->auth_delim_data = sfConfig::get('app_auth_delim_data');
    $this->auth_delim_char = sfConfig::get('app_auth_delim_char');
    $this->auth_encap_char = sfConfig::get('app_auth_encap_char');
    $this->auth_x_relay_response = sfConfig::get('app_auth_x_relay_response');
  }
  
  public function __call($method, $args)
  {
    if (isset($this->$method))
    {
      return urldecode($this->$method);
    }

    return null;
  }

  public function getTransactionListByBatchId($batch_id)
  {
    $writer = new XMLWriter(); 
    $writer->openMemory();
    $writer->startDocument('1.0','utf-8'); 
      $writer->setIndent(4); 
      $writer->startElement('getTransactionListRequest');
        $writer->writeAttribute('xmlns', 'AnetApi/xml/v1/schema/AnetApiSchema.xsd');
        $writer->startElement('merchantAuthentication');
          $writer->writeElement('name', $this->auth_x_login());
          $writer->writeElement('transactionKey', $this->auth_x_tran_key());
        $writer->endElement();
        $writer->writeElement('batchId', $batch_id);
      $writer->endElement();
    $writer->endDocument(); 
    
    $xml = $writer->flush();

    $result = $this->authNetHttpPost('getTransactionListRequest', $xml);

    if (isset($result['messages']['resultCode']))
    {
      if ( strpos(strtolower($result['messages']['resultCode']),'ok') !== false)
      {
        if (isset($result['transactions'])) {

          //$result['batchList']['batch'] can be single or multi-dimensional
          if (isset($result['transactions']['transaction'][0])) {

            return $result['transactions']['transaction'];
          }
          else {

            return array($result['transactions']['transaction']);
          }
        }

        return array();
      }
      
      $this->error = (isset($result['messages']['message']['text'])) ? $result['messages']['message']['text'] : '';
      $this->error_code = (isset($result['messages']['message']['code'])) ? $result['messages']['message']['code'] : '';
    }
    
    return null;
  }

  public function getBatchByDateRange($start_date, $end_date)
  {
    $writer = new XMLWriter(); 
    $writer->openMemory();
    $writer->startDocument('1.0','utf-8'); 
      $writer->setIndent(4); 
      $writer->startElement('getSettledBatchListRequest');
        $writer->writeAttribute('xmlns', 'AnetApi/xml/v1/schema/AnetApiSchema.xsd');
        $writer->startElement('merchantAuthentication');
          $writer->writeElement('name', $this->auth_x_login());
          $writer->writeElement('transactionKey', $this->auth_x_tran_key());
        $writer->endElement();
        $writer->writeElement('firstSettlementDate', $start_date);
        $writer->writeElement('lastSettlementDate', $end_date);
      $writer->endElement();
    $writer->endDocument(); 
    
    $xml = $writer->flush();

    $result = $this->authNetHttpPost('getSettledBatchListRequest', $xml);

    if (isset($result['messages']['resultCode']))
    {
      if ( strpos(strtolower($result['messages']['resultCode']),'ok') !== false)
      {
        if (isset($result['batchList'])) {

          //$result['batchList']['batch'] can be single or multi-dimensional
          if (isset($result['batchList']['batch'][0])) {

            return $result['batchList']['batch'];
          }
          else {

            return array($result['batchList']['batch']);
          }
        }

        return array();
      }
      
      $this->error = (isset($result['messages']['message']['text'])) ? $result['messages']['message']['text'] : '';
      $this->error_code = (isset($result['messages']['message']['code'])) ? $result['messages']['message']['code'] : '';
    }
    
    return null;
  }

  public function getError()
  {
    return urldecode($this->error);
  }

  public function getErrorCode()
  {
    return urldecode($this->error_code);
  }
  
  /*
  * Send HTTP POST Request
  *
  * @param  string  The API method name
  * @param  string  The POST Message fields in &name=value pair format
  * @return  array  Parsed HTTP Response body
  */
  private function authNetHttpPost($methodName_, $xml)
  {
    $post_string = $xml;
    
    // setting the curl parameters.
    $request = curl_init();
    curl_setopt($request, CURLOPT_URL, $this->auth_endpoint());
    curl_setopt($request, CURLOPT_VERBOSE, 1);
    curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
    
    // turning off the server and peer verification(TrustManager Concept).
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
    curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
  
    // setting the nvpreq as POST FIELD to curl
    curl_setopt($request, CURLOPT_POST, 1);
    curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
    
    curl_setopt($request, CURLOPT_HTTPHEADER, array("Content-Type: text/xml")); 

    
    // getting response from server
    $response = curl_exec($request);

    if(!$response)
    {
      exit("$methodName_ failed: ".curl_error($request).'('.curl_errno($request).')');
    }

    // Extract the response details
    curl_close ($request); // close curl object
    
    $response = preg_replace('/ xmlns:xsi[^>]+/','',$response);
    $xml = simplexml_load_string($response);
    
    $json = json_encode($xml);

    return json_decode($json,TRUE);
  }
}