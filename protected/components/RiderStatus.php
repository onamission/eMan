<?php
class RiderStatus extends CWidget {

    public $crumbs = array();
    public $delimiter = ' / ';

    public function run() {
        $this->render('riderStatus');
    }

}
?>
