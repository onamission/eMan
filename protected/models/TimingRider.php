<?php

/**
 * This is the model class for table "jos_timing_rider".
 *
 * The followings are the available columns in table 'jos_timing_rider':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $owner_id
 */
class TimingRider extends ActiveRecordWithAttributes
{
    public $name = null;
    public $fastest = 0;
    public $raceCount = 0;
    public $handicapOpen = 0;
    public $handicapStock = 0;
    public $lastRace = 0;
    const HANDICAP_MAX_NUM_RACES = 8;
    const HANDICAP_MIN_RACES = 3;
    const HANDICAP_IN_SECONDS = 1200 ; // 20 minutes

    /**
    * Returns the static model of the specified AR class.
    * @return TimingRider the static model class
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
            return 'timing_rider';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('first_name, last_name', 'required'),
                    array('first_name, last_name', 'length', 'max'=>255),
                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('id, first_name, last_name, owner_id', 'safe', 'on'=>'search'),
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
        'owner' => array(self::BELONGS_TO, 'TimingOwners', 'owner_id'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'first_name' => 'First Name',
                    'last_name' => 'Last Name',
                    'owner_id' => 'Owner',
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
            $criteria->compare('owner_id',$this->owner_id);
            $criteria->compare('first_name',$this->first_name,true);
            $criteria->compare('last_name',$this->last_name,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function afterFind()
    {
                parent::afterFind();
                $this->name = "{$this->first_name} {$this->last_name}";
    }

    public function getMyStats()
    {
        $this->fastest = $this->getFastestTime();
        $this->handicapStock = $this->getHandicap( 'S' );
        $this->handicapOpen = $this->getHandicap( 'O' );
        $this->raceCount = $this->getCountOfRaces();
        $this->lastRace = $this->getLastRace();
	}

    public function getHandicap( $class )
    {
        $criteria=new CDbCriteria;
        $criteria->select ='duration';  // only select the 'title' column
        $criteria->limit = self::HANDICAP_MAX_NUM_RACES;
        $criteria->order = 'event.eventDate DESC';
        $criteria->condition = 'rider_id=:r and rider_class=:c and event.eventDate<:d';
        $criteria->params = array( ':r' => $this->id , ':c'=>$class , ':d'=>date( 'Y-m-d 00:00:00') );
        $races = TimingDetails::model()->with('event')->findAll( $criteria );
        $count = 0;
        $totalTime = 0;
        foreach ( $races as $race )
        {
            $count++;
            $totalTime += brUtils::getTimeInSeconds( $race->duration );
        }
        $average = ( $count > 0 ) ? $totalTime / $count : 0 ;
        if ( $count >= self::HANDICAP_MIN_RACES && $average > 0 )
        {
            return brUtils::convertSecondsToTime ( $average - self::HANDICAP_IN_SECONDS );
        }
        else
        {
            return "00:00:00";
        }
    }

    public function getFastestTime()
    {
//        $row = Yii::app()->db->createCommand(array(
        $dbConnect = $this->getDbConnection();
        $row = $dbConnect->createCommand( array(
            'select' => array('MIN( duration ) as fastest'),
            'from' => 'timing_details',
            'where' => 'rider_id=:r',
            'params' => array(':r'=>$this->id),
        ))->queryRow();
        return $row['fastest'] == '' ? '00:00:00' : $row[ 'fastest' ];
    }

    public function getCountOfRaces()
    {
//        $row = Yii::app()->db->createCommand(array(
        $dbConnect = $this->getDbConnection();
        $row = $dbConnect->createCommand( array(
            'select' => array('count( event_id ) as eventCount'),
            'from' => 'timing_details',
            'where' => 'rider_id=:r',
            'params' => array(':r'=>$this->id),
        ))->queryRow();
        return $row['eventCount'];
    }

    public function getLastRace()
    {
        $criteria=new CDbCriteria;
        $criteria->select = 'max( eventDate ) as lastRace';
        $criteria->condition = 'rider_id=:r';
        $criteria->group= 'rider_id';
        $criteria->params = array(':r' => $this->id);
        $dateTime = TimingDetails::model()->with( 'event' )->find( $criteria )->lastRace;
        return $dateTime != '' ? date( 'Y-m-d', strtotime($dateTime ) ) : '';

        //return $race->lastRace ;
    }

    public function adjustCredit ( $creditNumber )
    {
        $this->attrMap[ 'credit' ] =
            brUtils::increment( isset( $this->attrMap[ 'credit' ] )
                    ? $this->attrMap[ 'credit' ]
                    : 0
                , $creditNumber );
        $this->save();
    }

    public function adjustDdCredit ( $creditNumber )
    {
        $this->attrMap[ 'dd_credit' ] =
            brUtils::increment( isset( $this->attrMap[ 'dd_credit' ] )
                    ? $this->attrMap[ 'dd_credit' ]
                    : 0
                , $creditNumber );
        $this->save();
    }
}