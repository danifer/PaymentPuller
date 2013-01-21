<?php

/**
 * PaypalTransaction form base class.
 *
 * @method PaypalTransaction getObject() Returns the current form's model object
 *
 * @package    payment_puller
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePaypalTransactionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'timestamp'      => new sfWidgetFormDateTime(),
      'timezone'       => new sfWidgetFormInputText(),
      'type'           => new sfWidgetFormInputText(),
      'email'          => new sfWidgetFormInputText(),
      'name'           => new sfWidgetFormInputText(),
      'transaction_id' => new sfWidgetFormInputText(),
      'status'         => new sfWidgetFormInputText(),
      'amount'         => new sfWidgetFormInputText(),
      'currency_code'  => new sfWidgetFormInputText(),
      'fee_amount'     => new sfWidgetFormInputText(),
      'net_amount'     => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'timestamp'      => new sfValidatorDateTime(array('required' => false)),
      'timezone'       => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'type'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'transaction_id' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'status'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'amount'         => new sfValidatorNumber(array('required' => false)),
      'currency_code'  => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'fee_amount'     => new sfValidatorNumber(array('required' => false)),
      'net_amount'     => new sfValidatorNumber(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'PaypalTransaction', 'column' => array('transaction_id')))
    );

    $this->widgetSchema->setNameFormat('paypal_transaction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PaypalTransaction';
  }

}
