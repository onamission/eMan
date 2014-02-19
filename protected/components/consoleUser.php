<?php
class consoleUser extends CApplicationComponent implements IWebUser
{
    private $__state = array();
    public function checkAccess( $op, $params = array() )
    {
        return true;
    }
    public function getId()
    {
        return 1;
    }
    public function getIsGuest()
    {
        return false;
    }
    public function getName()
    {
        return 'demo';
    }
    public function loginRequired()
    {
        return false;
    }
    public function getState( $key )
    {
        return $this->__state[ $key ];
    }
    public function setState( $key, $value )
    {
        $this->__state[ $key ] = $value;
        return true;
    }
}
?>