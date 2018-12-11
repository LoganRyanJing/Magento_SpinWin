<?php

class Vss_Spinandwin_Model_Couponlist extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('spinandwin/couponlist');
    }
}
