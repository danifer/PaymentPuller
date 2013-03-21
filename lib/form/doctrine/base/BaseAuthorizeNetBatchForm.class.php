<?php

/**
 * AuthorizeNetBatch form base class.
 *
 * @method AuthorizeNetBatch getObject() Returns the current form's model object
 *
 * @package    payment_puller
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAuthorizeNetBatchForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'batch_id'              => new sfWidgetFormInputText(),
      'settlement_time_utc'   => new sfWidgetFormDateTime(),
      'settlement_time_local' => new sfWidgetFormDateTime(),
      'settlement_state'      => new sfWidgetFormInputText(),
      'payment_method'        => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'batch_id'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'settlement_time_utc'   => new sfValidatorDateTime(array('required' => false)),
      'settlement_time_local' => new sfValidatorDateTime(array('required' => false)),
      'settlement_state'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'payment_method'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('authorize_net_batch[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AuthorizeNetBatch';
  }

}
