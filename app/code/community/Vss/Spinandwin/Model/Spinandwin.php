<?php

/**
 * Created by Velsof.
 * @author Bhupendra Singh Bisht
 * Created at 09/18/2018(mm/dd/yyyy)
 *
 * @use: Model for the Free spin and win module module.
 */

class Vss_Spinandwin_Model_Spinandwin extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('spinandwin/spinandwin');
    }
}
