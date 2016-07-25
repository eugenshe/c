<?php

/**
 * @property integer $id
 * @property string $movieId
 * @property string $apiKey
 * @property integer $rate
 */
class RateModel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return static the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('movieId, apiKey, rate', 'required')
		);
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
}