<?php
require_once(dirname(__FILE__).'/../lib/system.php');
require_once(dirname(__FILE__).'/../lib/debug.php');
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);

sfContext::createInstance($configuration);

if (strtotime( Variable::getAuthorizeNetStart()->getValue()) > strtotime('now -1 day')) {

  exit;
}

$authNet = new authorizeNet();
$placeholder = Variable::getAuthorizeNetStart();

$start_date = gmdate("Y-m-d\TH:i:s\Z", strtotime($placeholder->getValue()));
$end_date = gmdate("Y-m-d\TH:i:s\Z", strtotime($start_date.' +25 days'));

$batches = $authNet->getBatchByDateRange($start_date, $end_date);

foreach ($batches as $key => $batch) {

  if (count($batch)) {
    //Check if the batch already exists
    if (Doctrine::getTable('AuthorizeNetBatch')->findOneByBatchId($batch['batchId'])) {

    }
    else {
      $transactions = $authNet->getTransactionListByBatchId($batch['batchId']);
      foreach ($transactions as $key => $transaction) {

        if (count($transaction)) {

          //Check if the transaction already exists
          if (Doctrine::getTable('AuthorizeNetTransaction')->findOneByTransId($transaction['transId'])) {

          }
          else {

            try {

              $AuthorizeNetTransaction = new AuthorizeNetTransaction();
              $AuthorizeNetTransaction->setTransId($transaction['transId']);
              $AuthorizeNetTransaction->setBatchId($batch['batchId']);
              $AuthorizeNetTransaction->setSubmitTimeUtc($transaction['submitTimeUTC']);
              $AuthorizeNetTransaction->setSubmitTimeLocal($transaction['submitTimeLocal']);
              $AuthorizeNetTransaction->setTransactionStatus($transaction['transactionStatus']);
              $AuthorizeNetTransaction->setFirstName($transaction['firstName']);
              $AuthorizeNetTransaction->setLastName($transaction['lastName']);
              $AuthorizeNetTransaction->setAccountType($transaction['accountType']);
              $AuthorizeNetTransaction->setAccountNumber($transaction['accountNumber']);
              $AuthorizeNetTransaction->setSettleAmount($transaction['settleAmount']);
              $AuthorizeNetTransaction->save();

            } catch (Exception $e) {

            }
          }
        }
      }

      //Record the batch entry AFTER all of the transactions are processed
      try {

        $AuthorizeNetBatch = new AuthorizeNetBatch();
        $AuthorizeNetBatch->setBatchId($batch['batchId']);
        $AuthorizeNetBatch->setSettlementTimeUtc($batch['settlementTimeUTC']);
        $AuthorizeNetBatch->setSettlementTimeLocal($batch['settlementTimeLocal']);
        $AuthorizeNetBatch->setSettlementState($batch['settlementState']);
        $AuthorizeNetBatch->setPaymentMethod($batch['paymentMethod']);
        $AuthorizeNetBatch->save();

      } catch (Exception $e) {

      }
    }
  }
}

$placeholder->setValue(date('Y-m-d H:i:s', strtotime($end_date)));
$placeholder->save();
