<?php

/**
 * report actions.
 *
 * @package    payment_puller
 * @subpackage report
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reportActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->paypal = Doctrine_Query::create()
      ->from('PaypalTransaction p')
      ->orderBy('p.timestamp DESC')
      ->limit(10)
      ->fetchArray();

    $this->auth_net = Doctrine_Query::create()
      ->from('AuthorizeNetTransaction a')
      ->orderBy('a.submit_time_utc DESC')
      ->limit(10)
      ->fetchArray();

  }

  public function executeMonthly(sfWebRequest $request)
  {
    $num_reporting_months = 36;

    $period_end = date('Y-m-d H:i:s', strtotime('now -'.$num_reporting_months.' months'));
    $results = array();

    for ($i=0; $i <= $num_reporting_months; $i++) { 
      $results[ date('Y-m', strtotime('now -'.$i.' months')) ] = array('paypal' => 0, 'auth_net' => 0);
    }

    $paypal = Doctrine_Query::create()
      ->select('SUM(amount) as amount, YEAR(timestamp) as year, MONTH(timestamp) as month')
      ->from('PaypalTransaction p')
      ->whereIn('type', array('Payment', 'Recurring Payment'))
      ->andWhere('p.timestamp > ?', $period_end)
      ->groupBy('year DESC, month DESC')
      ->fetchArray();

    foreach ($paypal as $key => $value) {
      $key = str_pad($value['year'], 2, '0', STR_PAD_LEFT).'-'.str_pad($value['month'], 2, '0', STR_PAD_LEFT);
      $results[$key]['paypal'] = $value['amount'];
    }

    $auth_net = Doctrine_Query::create()
      ->select('SUM(settle_amount) as amount, YEAR(submit_time_utc) as year, MONTH(submit_time_utc) as month')
      ->from('AuthorizeNetTransaction a')
      ->whereIn('transaction_status', array('settledSuccessfully'))
      ->andWhere('a.submit_time_utc > ?', $period_end)
      ->groupBy('year DESC, month DESC')
      ->fetchArray();

    foreach ($auth_net as $key => $value) {
      $key = str_pad($value['year'], 2, '0', STR_PAD_LEFT).'-'.str_pad($value['month'], 2, '0', STR_PAD_LEFT);
      $results[$key]['auth_net'] = $value['amount'];
    }

    $num_summary_months = 3;
    $slice = array_slice($results, 1, $num_summary_months, true);

    $summary = array('sum_paypal' => 0, 'sum_auth_net' => 0, 'sum_total' => 0);

    foreach ($slice as $key => $value) {
      $summary['sum_paypal'] += $value['paypal'];
      $summary['sum_auth_net'] += $value['auth_net'];
      $summary['sum_total'] += ($value['paypal']+$value['auth_net']);
    }

    $summary['avg_paypal'] = ($summary['sum_paypal'] > 0) ? $summary['sum_paypal']/$num_summary_months : 0;
    $summary['avg_auth_net'] = ($summary['sum_auth_net'] > 0) ? $summary['sum_auth_net']/$num_summary_months : 0;
    $summary['avg_total'] = ($summary['sum_total'] > 0) ? $summary['sum_total']/$num_summary_months : 0;
    $summary['months'] = $num_summary_months;

    $this->summary = $summary;
    $this->results = $results;
  }
}
