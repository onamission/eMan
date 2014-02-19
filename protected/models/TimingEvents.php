<?php

/**
 * This is the model class for table "jos_timing_events".
 *
 * The followings are the available columns in table 'timing_events':
 * @property integer $id
 * @property string $name
 * @property integer $eventDate
 * @property integer $startTime
 * @property integer $owner_id
 * @property date $eventDate
 * @property string $startTime
 * @property string $event_status
 */
class TimingEvents extends ActiveRecordWithAttributes
{

    public $intervalInSeconds = null;
    public $startTimeInSeconds = null;
	/**
	 * Returns the static model of the specified AR class.
	 * @return TimingEvents the static model class
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
		return 'timing_events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, owner_id, eventDate, startTime, event_status', 'required'),
			array('owner_id', 'numerical', 'integerOnly'=>true),
			//array('eventDate', 'date'),
			array('name, event_status', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, event_status, eventDate, startTime, owner_id', 'safe', 'on'=>'search'),
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
			'event' => array(self::BELONGS_TO, 'TimingOwners', 'owner_id'),
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
		//	'ord' => 'Order',
			'interval' => 'Interval',
            'event_status'=>'Event Status',
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
	//	$criteria->compare('ord',$this->ord);
		$criteria->compare('interval',$this->interval);
        $criteria->compare('event_status',$this->event_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getSplits( )
    {
        $returnArray = array();
        $splitList = TimingAttributes::getTimingAttribute(get_class($this), $this->id, 'split', null, null, 'all');
        foreach ( $splitList as $key=>$split )
        {
            $id = ( count( $splitList ) > 1 )? $split->id : $splitList->id;
            $splitOrder = TimingAttributes::getTimingAttributeValue('split', $id, 'order');
            $splitName = TimingAttributes::getTimingAttributeValue('split', $id, 'name');
            $returnArray[ $splitOrder ] = $splitName;
        }
        ksort($returnArray);
        return $returnArray;
    }

    public function getWinner ( $winnerType )
    {
        $fastestRider = '';
        $fastestRiderTime = 1000000;
        $raceDets = TimingDetails::model()->findAll( 'event_id=:e', array( ":e"=>$this->id ) );
        $riderHandicap = 0;
        foreach ( $raceDets as $rider )
        {
            $racer = TimingRider::model()->findByPk( $rider->rider_id );
            if ( $winnerType == 'net' )
            {
                $riderHandicap = brUtils::getTimeInSeconds( $rider->attrMap[ 'handicap' ] ) ;
            }
            $riderNetTime = brUtils::getTimeInSeconds($rider->duration ) - $riderHandicap;
            if ( $riderNetTime < $fastestRiderTime )
            {
                $fastestRiderTime = $riderNetTime;
                $fastestRider = $rider->rider_id;
            }
        }
        return TimingRider::model()->findByPk( $fastestRider );
    }

    public function getFastestTimesInSecs ( )
    {
        $fastestRider = '';
        $fastestRiderTime = 1000000;
        $raceDets = TimingDetails::model()->with( 'rider' )->findAll( array( 'condition'=>'event_id=:e', 'order'=>'duration', 'params' => array( ":e"=>$this->id ) ) );
        $fastest = brUtils::getTimeInSeconds( $raceDets[ 0 ]['duration' ] );
        $ret = array();
        foreach ( $raceDets as $ride )
        {
            $s = $fastest / brUtils::getTimeInSeconds( $ride[ 'duration' ] ) * 100;
            $score = number_format( $s, 3 );
            $ret[ $score . " - " . $ride->rider->name ] = array(
                'cat' => $ride->rider_category,
                'class' => $ride->rider_class,
                'gender' => $ride->rider->attrMap['gender' ],
                'score' => $score,
                'name' => $ride->rider->name,
            );
        }
        return $ret;
    }

    public function afterFind()
    {
        $this->startTimeInSeconds = brUtils::getTimeInSeconds( $this->startTime );
        $this->intervalInSeconds  = brUtils::getTimeInSeconds( $this->interval );
        return parent::afterFind();
    }
}