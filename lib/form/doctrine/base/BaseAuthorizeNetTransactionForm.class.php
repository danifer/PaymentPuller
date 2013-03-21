<?php

/**
 * AuthorizeNetTransaction form base class.
 *
 * @method AuthorizeNetTransaction getObject() Returns the current form's model object
 *
 * @package    payment_puller
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAuthorizeNetTransactionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'trans_id'           => new sfWidgetFormInputText(),
      'batch_id'           => new sfWidgetFormInputText(),
      'submit_time_utc'    => new sfWidgetFormDateTime(),
      'submit_time_local'  => new sfWidgetFormDateTime(),
      'transaction_status' => new sfWidgetFormInputText(),
      'first_name'         => new sfWidgetFormInputText(),
      'last_name'          => new sfWidgetFormInputText(),
      'account_type'       => new sfWidgetFormInputText(),
      'account_number'     => new sfWidgetFormInputText(),
      'settle_amount'      => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'trans_id'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'batch_id'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'submit_time_utc'    => new sfValidatorDateTime(array('required' => false)),
      'submit_time_local'  => new sfValidatorDateTime(array('required' => false)),
      'transaction_status' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'first_name'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'last_name'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'account_type'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'account_number'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'settle_amount'      => new sfValidatorNumber(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('authorize_net_transaction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AuthorizeNetTransaction';
  }

}
