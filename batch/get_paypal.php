<?php
require_once(dirname(__FILE__).'/../lib/system.php');
require_once(dirname(__FILE__).'/../lib/debug.php');
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);

sfContext::createInstance($configuration);

if (strtotime( Variable::getPaypalStart()->getValue()) > strtotime('now -1 day')) {

  exit;
}

$paypal = new paypal();
$placeholder = Variable::getPaypalStart();

$start_date = gmdate("Y-m-d\TH:i:s\Z", strtotime($placeholder->getValue()));
$end_date = gmdate("Y-m-d\TH:i:s\Z", strtotime($start_date.' +8 hours'));

$results = $paypal->getTransactionSearchArray($start_date, $end_date);

foreach ($results['TRANSACTIONS'] as $key => $result) {

  try {

    $transaction = new PaypalTransaction();
    $transaction->setTimestamp($result['L_TIMESTAMP']);
    $transaction->setTimezone($result['L_TIMEZONE']);
    $transaction->setType($result['L_TYPE']);
    $transaction->setEmail($result['L_EMAIL']);
    $transaction->setName($result['L_NAME']);
    $transaction->setTransactionId($result['L_TRANSACTIONID']);
    $transaction->setStatus($result['L_STATUS']);
    $transaction->setAmount($result['L_AMT']);
    $transaction->setCurrencyCode($result['L_CURRENCYCODE']);
    $transaction->setFeeAmount($result['L_FEEAMT']);
    $transaction->setNetAmount($result['L_NETAMT']);
    $transaction->save();

  } catch (Exception $e) {
    

  }
}

$placeholder->setValue(date('Y-m-d H:i:s', strtotime($end_date)));
$placeholder->save();
