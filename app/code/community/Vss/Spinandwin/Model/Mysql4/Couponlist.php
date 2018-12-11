<?php

class Vss_Spinandwin_Model_Mysql4_Couponlist extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('spinandwin/couponlist', 'coupon_id');
        $this->_isPkAutoIncrement = true;
    }   
}
