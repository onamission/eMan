<?php

/**
 * This is the model class for table "timing_attributes".
 *
 * The followings are the available columns in table 'timing_attributes':
 * @property integer $id
 * @property string $parent
 * @property integer $parent_id
 * @property string $name
 * @property string $value
 * @property string $value_type
 * @property boolean $is_parent [ 0 = false; 1 = true]
 */
class TimingAttributes extends ActiveRecordWithAttributes
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TimingAttributes the static model class
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
		return 'timing_attributes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, is_parent', 'numerical', 'integerOnly'=>true),
			array('parent, name, value_type', 'length', 'max'=>45),
			array('value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent, parent_id, name, is_parent, value, value_type', 'safe', 'on'=>'search'),
            array( 'parent', 'UniqueAttributesValidator', 'with'=>'parent_id,name' ),
  /*          array('parent,parent_id,name', 'unique', 'criteria'=>array(
            'condition'=>'parent=:key1 and parent_id`=:key2 and name=:key3',
            'params'=>array(
                ':key1'=>$this->parent,
                ':key2'=>$this->parent_id,
                ':key3'=>$this->name
            )
        )),*/
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent' => 'Parent',
			'parent_id' => 'Parent ID',
			'name' => 'Name',
			'value' => 'Value',
			'value_type' => 'Value Type',
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
		$criteria->compare('parent',$this->parent,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('value_type',$this->value_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     *
     * @param string $parent
     * @param int $parent_id
     * @param string $attributeName
     * @param text $attributeValue
     * @return string
     *
     */
    public static function getTimingAttributeValue( $parent = null, $parent_id = null, $attributeName = null, $attributeValue = null )
    {
        return self::getTimingAttribute( $parent, $parent_id, $attributeName, $attributeValue)->value;
    }

        /**
     *
     * @param string $parent
     * @param int $parent_id
     * @param string $attributeName
     * @param text $attributeValue
     * @return int
     *
     */
    public static function getTimingAttributeId( $parent = null, $parent_id = null, $attributeName = null, $attributeValue = null )
    {
        return self::getTimingAttribute( $parent, $parent_id, $attributeName, $attributeValue)->id;
    }

    /**
     *
     * @param string $parent
     * @param int $parent_id
     * @param string $attributeName
     * @param text $attributeValue
     * @param string $attributeValueType
     * @param string $returnSet; If set to 'one', then it will return a single object, if set to 'all' it will return
     *                            an array of objects
     * @return object or array of objects
     *
     */
    public static function getTimingAttribute(
              $parent = null
            , $parent_id = null
            , $attributeName = null
            , $attributeValue = null
            , $attributeValueType=null
            , $returnSet = 'one' )
    {
        // Establish Criteria and parameters based on what is passed
        $criteria = '';
        $params = array();
        if ( $parent != null )
        {
            if ( strlen($criteria) > 0 ) $criteria .= ' and ';
            $criteria .= " parent=:p ";
            $params[':p'] = $parent ;
        }
        if ( $parent_id != null )
        {
            if ( strlen($criteria) > 0 ) $criteria .= ' and ';
            $criteria .= " parent_id=:pid ";
            $params[ ':pid'] = $parent_id  ;
        }
        if ( $attributeName != null )
        {
            if ( strlen($criteria) > 0 ) $criteria .= ' and ';
            $criteria .= " name=:n ";
            $params[':n'] = $attributeName  ;
        }
        if ( $attributeValue != null )
        {
            if ( strlen($criteria) > 0 ) $criteria .= ' and ';
            $criteria .= " value=:v ";
            $params[':v' ] = $attributeValue ;
        }

        if( $returnSet == 'all' )
        {
            $tAttr = TimingAttributes::model()->findAll($criteria, $params);
        }else{
            $tAttr = TimingAttributes::model()->find( $criteria, $params );
        }
        // If there is a record, return it, if there isn't any, then create one.
        if ( ! $tAttr )
        {
            $tAttr = new TimingAttributes();
            $tAttr->parent = $parent;
            $tAttr->parent_id = $parent_id;
            $tAttr->name = $attributeName;
            $tAttr->value = $attributeValue;
            $tAttr->value_type = $attributeValueType;
        }

        return $tAttr;
    }

}