<?php

/**
 * Created by Velsof.
 * @author Bhupendra Singh Bisht
 * Created at 09/18/2018(mm/dd/yyyy)
 *
 */

class Vss_Spinandwin_Block_Spinandwinfront extends Mage_Checkout_Block_Onepage_Abstract
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        return $this;
    }

    /*
     * Function for getting the module settings tab wise
     */

    public function getModuleSettings($index)
    {
        $settings_data = Mage::helper('spinandwin')->getSettings($index);
        return $settings_data;
    }


    /*
     * Function for getting the URL of Spin and Win media directory
     */

    public function getFrontMediaURL()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'vss_spinandwin' . DS;
    }


}
