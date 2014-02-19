<?php
/**
 * Description of ActiveRecordWithAttributes
 *
 * @author tturnquist
 *
 * @example
 * Timing Attribue List:
 *  +---------------------+----------------------------+
 *  |       OBJECT        |         ATTRIBUTES         |
 *  +---------------------+----------------------------+
 *  | TimingRider         |                            |
 *  |   • Contact         |  email                     |
 *  |                     |  phone                     |
 *  |   • Contact/Address |  Street                    |
 *  |                     |  City                      |
 *  |                     |  State                     |
 *  |                     |  Zip                       |
 *  +---------------------+----------------------------+
 *  | TimingEvent         |  Class List                |
 *  |                     |  Category List             |
 *  |                     |  Split Name List           |
 *  |                     |  Status                    |
 *  |                     |  Color List                |
 *  |                     |  Logo                      |
 *  |                     |  Date / Time               |
 *  |                     |  Location                  |
 *  |                     |  Status                    |
 *  +---------------------+----------------------------+
 *  | TimingDetails       |  Rider Class               |
 *  |                     |  Rider Category            |
 *  |                     |  Split Start Timestamp     |
 *  |                     |  Split Finish Timestamp    |
 *  |                     |  Rider Handicap            |
 *  +---------------------+----------------------------+
 *  | TimingOwner         |  Userid                    |
 *  |                     |  Password                  |
 *  |                     |  Status                    |
 *  +---------------------+----------------------------+
 *
 */
class ActiveRecordWithAttributes extends CActiveRecord
{
    public $attrMap = array();
    public static $mode = null;
/*    private static $demoDb = null;
    private static $testDb = null;*/

    public function getDbConnection()
    {
        if ( Yii::app()->user->getState( 'mode' ) == 'demo' )
        {
            self::$mode  = Yii::app()->dbDemo;
        }
        elseif ( Yii::app()->user->getState( 'mode' ) == 'test' )
        {
            self::$mode = Yii::app()->dbTest;
        }
        else
        {
            self::$mode = Yii::app()->db;
        }
        if ( self::$mode instanceof CDbConnection )
        {
            self::$mode->setActive( true );
            return self::$mode;
        }
        else
        {
            throw new CDbExeption( Yii::t( 'yii','Active Record requires a "db CDbConnection application component.' ) );
        }
    }

    protected function afterFind()
    {
        parent::afterFind();
        $this->attrMap = $this->getAllAttributes( get_class( $this ) , $this->id );
    }

    protected function afterSave()
    {
        parent::afterSave();
        if ( $this->attrMap )
        {
            $this->saveAllMyAttributes( get_class( $this) , $this->id, $this->attrMap );
        }
    }


    /** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *
     *                             LOGIN ATTRIBUTES
     *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    /**
     *
     * @param int $owner
     * @return int
     *
     * @example $id = $this->getLoginIdByOwner( 1 );
     */
    public function getLoginIdByOwner( $owner )
    {
        return TimingAttributes::getTimingAttributeId(get_class($this), $this->id, 'login', $owner );
    }

    /**
     *
     * @param int $owner
     * @return array of objects
     *
     * @example $id = $this->getLoginIdByOwner( 1 );
     */
    public static function getLoginList( )
    {
        $returnList = array();
        $loginList = TimingAttributes::getTimingAttribute(null, null, 'login', null );
        foreach ( $loginList as $login )
        {
            $returnList[] = $login;
        }
        return $returnList;
    }

    /**
     *
     * @param int $owner
     * @param string $attributeName
     * @return array( 'username', 'password' )
     *
     * @example $userId = $this->getLoginElement( 1, 'userid' )
     */
    public static function getLoginElement( $attributeName=null, $attributeValue=null )
    {
        $loginData= array();
        $login =  TimingAttributes::getTimingAttribute('login', null, $attributeName, $attributeValue );
        if ( $login )
        {
            $loginElement = TimingAttributes::model()->findByPk( $login->parent_id);
            if ( $loginElement )
            {
                $loginData[ 'parent' ] = $loginElement->parent;
                $loginData[ 'parent_id' ] = $loginElement->parent_id;
                $parent = $loginElement->parent;
                $user = $parent::model()->findByPk( $loginElement->parent_id );
                $loginData[ 'owner_id' ] = $user->owner_id;

                if ( $login->name == 'username' )
                {
                    $loginData[ 'username' ] = $login->value;
                    $loginData[ 'password' ] = TimingAttributes::getTimingAttributeValue('login', $login->parent_id, 'password');
                }
                if ( $login->name == 'password' )
                {
                    $loginData[ 'password' ] = $login->password;
                    $loginData[ 'username' ] = TimingAttributes::getTimingAttributeValue('login', $login->parent_id, 'username');
                }
            }
        }
        return $loginData;
    }

    /**
     *
     * @param int $owner
     * @param string $user
     * @param string $pswd
     * @param string $type
     *
     * @return string
     */
    public function saveLoginAttributes ( $owner, $username, $pswd )
    {
        $retval = 'Error saving Login';
        if ( self::isUsernameUnique( $username ) )
        {
            $result = $this->saveMyAttribute(get_class($this), $this->id, 'login', $owner, null, 1 );
            if( is_numeric( $result ) )
            {
                $contactId = $result;

                $result1 = $this->saveMyAttribute( 'login', $contactId, 'username', $username, 'string');
                $result1 = ( is_numeric( $result1 ) ) ? '' : 'username: ' . $result1;
                $result2 = $this->saveMyAttribute( 'login', $contactId, 'password', md5($pswd), 'password');
                $result2 = ( is_numeric( $result2 ) ) ? '' : ' password: ' . $result2;
                $retval =  $result1 . $result2;
                if ( $retval == '' )
                {
                    $retval = 'Login Saved';
                }
            }else{
                $retval = ' login:' . $result;
            }
        }else{
            $retval = "'$username' is not Unique";
        }
        return $retval;
    }

    protected static function isUsernameUnique( $username )
    {
        $login = self::getLoginElement( 'username', $username );
        return ( $login->username == $username )? false : true;
    }


    /** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *
     *                      GENERIC ATTRIBUTE SETS AND GETS
     *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    /**
     *
     * @param string $attributeName
     * @return string
     *
     */
    public function getAttributeValue( $attributeName )
    {
        return TimingAttributes::getTimingAttribute( get_class( $this ), $this->id, $attributeName )->value;
    }

    /**
     *
     * @param string $attributeName
     * @param string $attributeValue
     *
     */
    public function saveAttibuteValue ( $attributeName, $attributeValue, $type = 'string', $isParent = 0 )
    {
        $timingAtt = TimingAttributes::getTimingAttribute(get_class( $this ), $this->id, $attributeName, null, $type );
        $timingAtt->value = $attributeValue;
        $timingAtt->is_parent = $isParent;
        $timingAtt->save( );
    }

    /**
     *
     * @param string $parent
     * @param int $parent_id
     * @param string $name
     * @param string $value
     * @param string $type
     * @return string that is an error status
     */
    public static function saveMyAttribute( $parent, $parent_id, $name, $value=null, $type='String', $isParent=0 )
    {
        $return = 'Generic failure in saveMyAttribute';
        $timingAtt = TimingAttributes::getTimingAttribute( $parent, $parent_id, $name );
        if ( !$timingAtt )
        {
            $timingAtt = new TimingAttributes();
            $timingAtt->parent = $parent;
            $timingAtt->parent_id = $parent_id;
            $timingAtt->name = $name;
            $timingAtt->value=$value;
            $timingAtt->is_parent = $isParent;
            $timingAtt->value_type=$type;
            $return = 'Error creating new record ';
        }else{
            $timingAtt->value=$value;
            $return = 'Error updating record ';
        }
        $result = $timingAtt->save();
        return ( $result ) ? $timingAtt->id : $return ;
    }

    public static function getAllAttributes( $parent, $parent_id, $itteration = 0 )
    {
        $returnVal = null;
        $attributeList = TimingAttributes::getTimingAttribute( $parent, $parent_id, null, null, null, 'all');
        if ( $attributeList )
        {
            foreach ( $attributeList as $attribute )
            {
                if ( isset( $attribute->name )  && $attribute->name != '' )
                {
                    $subAttributes = self::getAllAttributes( $attribute->name, $attribute->id , $itteration );
                    if ( $subAttributes && isset( $attribute->value ) )
                    {
                        $returnVal[$attribute->name][$attribute->value] =  $subAttributes;
                    }elseif( !isset( $attribute->value ) ){
                        $returnVal[$attribute->name] = $subAttributes ;
                    }else{
                        $returnVal[$attribute->name] = $attribute->value;
                    }
                }
            }
        }
        return $returnVal;
    }

    public static function getAttributeList( $parent )
    {
        $objects = TimingAttributes::getTimingAttribute( $parent, null, null, null, null, 'all' );
        $returnList = array();
        $count=0;
        foreach ( $objects as $key=>$attribute )
        {
            if ( !array_key_exists( $attribute->name, $returnList ) )
            {
                if ( $attribute->is_parent == 1 )
                {
                    $childList = self::getAttributeList( $attribute->name );
                    foreach( $childList as $key=>$child )
                    {
                       $returnList[ $attribute->name ][ $key ] = $child ;
                    }
                }else{
                    $returnList[ $attribute->name ] = $attribute->name ;
                }
            }
        }
        return $returnList;
    }

    /**
     *
     * @param string $parent
     * @param integer $parent_id
     * @param array $attributeMap
     *
     *
     * @uses
     *         $attributeMap = $this->getAllAttributes( $parent, $parent_id );
     *         $this->saveAllAttributes( $attributeMap );
     */
    public function saveAllMyAttributes( $parent, $parent_id, $attrMap= array() )
    {
        foreach ( $attrMap as $key => $attribute )
        {
            if ( is_array( $attribute ) )
            {
                $this->saveMyAttribute( $parent, $parent_id, $key, '', 'Array', 1 );
                $element = TimingAttributes::model()->find( 'parent=:p and parent_id=:pid and name=:n',
                        array( ':p'=>$parent, ':pid'=>$parent_id, ':n'=>$key ) );
                $this->saveAllMyAttributes( $key, $element->id, $attribute );
            }
            else
            {
                $this->saveMyAttribute( $parent, $parent_id, $key, $attribute, 'String', 0 );
            }
       }
    }

    function saveAttributesFromString( $elementTag, $elementValue, $prefix, $delimiter )
    {
        $object = get_class( $this );
        $parent = $object;   // start at the object level
        $parent_id = $this->id; // start with this ID
        if ( stristr($elementTag, $prefix ) )
        {
            $elementList = explode( $delimiter, $elementTag );
            for ( $i = 1; $i < count( $elementList ) - 1 ; $i++ ) //start at '1' to skip the prefix
            {
                $object::saveMyAttribute($parent, $parent_id, $elementList[ $i ], null, 'array', 1 );
                $att = TimingAttributes::getTimingAttribute($parent, $parent_id, $elementList[ $i ] );
                $parent = $elementList[ $i ];
                $parent_id = $att->id;
            }

            if ( $elementList[ count( $elementList ) - 1 ] == 'address' )
            {
                $object::saveMyAttribute($parent, $parent_id, 'address', null, 'array', 1 );
                $att = TimingAttributes::getTimingAttribute($parent, $parent_id, 'address' );
                list( $street, $cityStateZip ) = explode( "\n", $elementValue );
                list( $city, $state, $zip ) = explode( ',', $cityStateZip );
                $object::saveMyAttribute('address', $att->id ,'street', $street );
                $object::saveMyAttribute('address', $att->id ,'city', $city );
                $object::saveMyAttribute('address', $att->id ,'state', $state );
                $object::saveMyAttribute('address', $att->id ,'zip', $zip );
                $parent = false;
            }
            elseif( $elementList[ count( $elementList ) - 1 ] == 'nameLastFirst' )
            {
                $nameArray = explode(',', $elementValue );
                $object->lastName = $nameArray[0];
                $object->firstName = $nameArray[1];
            }
            elseif( $elementList[ count( $elementList ) - 1 ] == 'nameFirstLast' )
            {
                $nameArray = explode(' ', $elementValue );
                $object = $parent::model()->findByPk( $parent_id );
                $object->lastName = trim( $nameArray[ count( $nameArray ) - 1 ] );
                for ( $i = 0 ; $i < count( $nameArray ) - 1 ; $i++ )
                {
                    $firstName .= $nameArray . ' ';
                }
                    $object->firstName = trim( $firstName );

            }
            else
            {
                $object::saveAttribute($parent, $parent_id, $elementList[ count( $elementList ) - 1 ], $elementValue );
            }
        }
    }

    public function saveDelimitedAttributes( $delimiter, $parent, $tag, $value )
    {
        $tags = explode( $delimiter, $tag);
        $parent[$tags] = $value;
    }

    public function addStringToAttrMap( $stringKey, $value, $delimieter )
    {
        $stringList = explode( $delimieter, $stringKey );
        $list = array();
        for ( $i = count( $stringList ) -1; $i >= 0; $i-- )
        {
            if ( count( $list ) < 1 )
                $list[ $i ] = $value;
            else
                $list[ $i ] = $list;
        }
        $this->attrMap[] = $list;
    }
}
?>
