<?php

/**
 * PaypalTransaction filter form base class.
 *
 * @package    payment_puller
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePaypalTransactionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'timestamp'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'timezone'       => new sfWidgetFormFilterInput(),
      'type'           => new sfWidgetFormFilterInput(),
      'email'          => new sfWidgetFormFilterInput(),
      'name'           => new sfWidgetFormFilterInput(),
      'transaction_id' => new sfWidgetFormFilterInput(),
      'status'         => new sfWidgetFormFilterInput(),
      'amount'         => new sfWidgetFormFilterInput(),
      'currency_code'  => new sfWidgetFormFilterInput(),
      'fee_amount'     => new sfWidgetFormFilterInput(),
      'net_amount'     => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'timestamp'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'timezone'       => new sfValidatorPass(array('required' => false)),
      'type'           => new sfValidatorPass(array('required' => false)),
      'email'          => new sfValidatorPass(array('required' => false)),
      'name'           => new sfValidatorPass(array('required' => false)),
      'transaction_id' => new sfValidatorPass(array('required' => false)),
      'status'         => new sfValidatorPass(array('required' => false)),
      'amount'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'currency_code'  => new sfValidatorPass(array('required' => false)),
      'fee_amount'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'net_amount'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('paypal_transaction_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PaypalTransaction';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'timestamp'      => 'Date',
      'timezone'       => 'Text',
      'type'           => 'Text',
      'email'          => 'Text',
      'name'           => 'Text',
      'transaction_id' => 'Text',
      'status'         => 'Text',
      'amount'         => 'Number',
      'currency_code'  => 'Text',
      'fee_amount'     => 'Number',
      'net_amount'     => 'Number',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
