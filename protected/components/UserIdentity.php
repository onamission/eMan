<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    /**
     * Authenticates a user using the Users data model.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        if ( $this->username == 'demo' && $this->password == 'demo' )
        {
            $this->errorCode=self::ERROR_NONE;
            $this->_id = 0;
            $this->setState('owner_id', 1 );
            $this->setState('parent', 'TimingRider');
            $this->setState('username', 'Demo');
            $this->setState('ownerName', 'Demonstration');
            $this->setState( 'mode', 'demo' );
            return !$this->errorCode;
        }
        if ( $this->username == 'test' && $this->password == 'test' )
        {
            $this->errorCode=self::ERROR_NONE;
            $this->_id = 0;
            $this->setState('owner_id', 1 );
            $this->setState('parent', 'TimingRider');
            $this->setState('username', 'Test');
            $this->setState('ownerName', 'Testing');
            $this->setState( 'mode', 'test' );
            return !$this->errorCode;
        }
        //$user = Users::model()->findByAttributes( array( 'username'=>$this->username ) );
        $user = TimingRider::getLoginElement('username', $this->username );
        if( $user === null )
        {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
        else
        {
            if( $user[ 'password' ] !== md5( $this->password ) )
            {
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
            else
            {
                $this->errorCode=self::ERROR_NONE;
                $this->_id = $user['parent_id'];
                $this->setState('owner_id', $user['owner_id']);
                $this->setState('parent', $user['parent']);
                $this->setState('username', $user['username']);
                $owner = TimingOwners::model()->findByPk( $user['owner_id'] );
                $this->setState('ownerName', $owner['name']);
            }
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function authenticate_old() {
        $userList = TimingRider::getLoginList();
        $users = array();
        foreach ( $userList as $user )
        {
            $username = TimingAttributes::getTimingAttribute('login', $user->id, 'username' )->value;
            $password = TimingAttributes::getTimingAttribute('login', $user->id, 'password' )->value;
            if ( $user != '' ) $users[ $username ] = $password;
        }

        if(!isset($users[$this->username]))
        {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
        }else if( $users[$this->username] !== md5( $this->password ) ){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
        }else{
			$this->errorCode=self::ERROR_NONE;
        }
		return !$this->errorCode;
	}
}