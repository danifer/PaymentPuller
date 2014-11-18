<?php

/**
 * paypal actions.
 *
 * @package    payment_puller
 * @subpackage paypal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class paypalActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    
  }

  public function executeCheckRecurring(sfWebRequest $request)
  {
    $this->form = new BaseForm();

    $this->form->setWidgets(array(
      'paypal_ids' => new sfWidgetFormTextarea(),
    ));

    $this->form->setValidators(array(
      'paypal_ids' => new sfValidatorString(array('required' => true)),
    ));

    $this->form->getWidgetSchema()->setNameFormat('recurring[%s]');

    $this->results = array();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));

      if ($this->form->isValid())
      {
        $ids = explode("\n", $this->form->getValue('paypal_ids'));

        if (count($ids)) {
          $paypal = new paypal();

          foreach ($ids as $key => $id) {

            $id = preg_replace("/[^a-zA-Z0-9-]/",'',$id);

            $paypal->profile_ref = $id;
            $result = $paypal->getRecurringPaymentsProfileDetails();

            if (strtolower($result['ACK']) == 'success') {

              $this->results[$id] = array(
                'profile_id' => urldecode($result['PROFILEID']),
                'status' => urldecode($result['STATUS']),
                'desc' => urldecode($result['DESC']),
                'aggregate_amount' => urldecode($result['AGGREGATEAMT']),
                'last_payment_date' => urldecode($result['LASTPAYMENTDATE']),
                'last_payment_amount' => urldecode($result['LASTPAYMENTAMT']),
                'outstanding_balance' => urldecode($result['LASTPAYMENTAMT']),
                'cycles_completed' => urldecode($result['NUMCYCLESCOMPLETED']),
              );
            }
            else {
              $this->results[$id] = array();
            }
          }
        }
      }
    }
  }
}
