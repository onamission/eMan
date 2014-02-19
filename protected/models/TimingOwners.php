<?php

/**
 * This is the model class for table "timing_owners".
 *
 * The followings are the available columns in table 'timing_owners':
 * @property integer $id
 * @property string $name
 * @property integer $status_id
 * @property string $contact_name
 *
 * The followings are the available model relations:
 * @property TimingEvents[] $timingEvents
 * @property TimingRider[] $timingRiders
 */
class TimingOwners extends ActiveRecordWithAttributes
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TimingOwners the static model class
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
		return 'timing_owners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status_id', 'numerical', 'integerOnly'=>true),
			array('name, contact_name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, status_id, contact_name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'timingEvents' => array(self::HAS_MANY, 'TimingEvents', 'owner_id'),
			'timingRiders' => array(self::HAS_MANY, 'TimingRider', 'owner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'status_id' => 'Status',
			'contact_name' => 'Contact Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('contact_name',$this->contact_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterSave()
    {
/*        $this->setAttribute('Address', $this->address );
        $this->setAttribute('Phone', $this->phone );
        $this->setAttribute('Email', $this->email );
        return parent::afterSave();
    }


    public function afterFind()
    {
        $this->phone = $this->getAttribute('Phone');
        $this->address = $this->getAttribute('Address');
        $this->Email = $this->getAttribute('Email');
        return parent::afterFind();
*/    }
}