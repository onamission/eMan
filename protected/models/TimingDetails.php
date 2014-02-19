<?php

/**
 * This is the model class for table "jos_timing_details".
 *
 * The followings are the available columns in table 'jos_timing_details':
 * @property integer $id
 * @property integer $event_id
 * @property integer $rider_id
 * @property string $category
 * @property string $class
 * @property string $duration
 */
class TimingDetails extends ActiveRecordWithAttributes
{

    public $lastRace = null;
    public $eventCount = null;
    public $fastest = null;
    public $class = '';
    public $category = '';
    public $duration = '0';

    /**
	 * Returns the static model of the specified AR class.
	 * @return TimingDetails the static model class
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
		return 'timing_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, rider_id, rider_category, rider_class, rider_num', 'required'),
			array('event_id, rider_id, rider_num', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, event_id, rider_id, rider_category, rider_class'
                            . 'start_time, finish_time, rider_num, duration'
                            , 'safe', 'on'=>'search'),
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
			'event' => array(self::BELONGS_TO, 'TimingEvents', 'event_id'),
			'rider' => array(self::BELONGS_TO, 'TimingRider' , 'rider_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_id' => 'Event',
			'rider_id' => 'Rider',
			'rider_category' => 'Category',
			'rider_class' => 'Class',
			'start_time' => 'Start Time',
			'finish_time' => 'Finish Time',
            'duration'=> 'Time'
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
        $criteria->compare('event_id',$this->event_id);
        $criteria->compare('rider_id',$this->rider_id);
        $criteria->compare('rider_category',$this->rider_category);
        $criteria->compare('rider_class',$this->rider_class);
        $criteria->compare('finish_time',$this->finish_time,true);
        $criteria->compare('start_time',$this->start_time,true);
        $criteria->compare('duration',$this->duration,true);

        return new CActiveDataProvider(
            $this
            , array(
             'Pagination' => array (
                  'PageSize' => 100 //edit your number items per page here
              ),
            'criteria'=>$criteria,
            )
        );
    }

    public function afterSave()
    {
       $rider = TimingRider::model()->findByPk( $this->rider_id );
       if ($this->duration == 0 || $this->duration == '0' )
       {
            $this->attrMap[ 'handicap' ] = $rider->getHandicap( $this->rider_class );
       }
       return parent::afterSave();
    }

    public function beforeSave()
    {
       if ( $this->duration != '0' )
       {
            $rider = TimingRider::model()->findByPk( $this->rider_id );
            $fastest = brUtils::getTimeInSeconds( $rider->getFastestTime() );
            if( $fastest > 0 && brUtils::getTimeInSeconds( $this->duration ) <= $fastest )
            {
                $rider->attrMap[ 'Personal Record' ] =
                        brUtils::increment( isset( $rider->attrMap[ 'Personal Record' ] )
                        ? $rider->attrMap[ 'Personal Record' ]
                        : 0 );
                $rider->save();
  //              echo "{$rider->name} has set a new PR at {$this->duration}\n";
            }
       }
       return parent::beforeSave();
    }

    public function afterFind()
    {
        $this->class = TimingAttributes::getAttribute(get_class(), $this->id, 'Class');
        $this->category = TimingAttributes::getAttribute(get_class(), $this->id, 'Category');
        return parent::afterFind();
    }

}
?>
