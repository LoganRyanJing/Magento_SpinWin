<?php

class Vss_Spinandwin_Block_Adminhtml_Renderer extends Mage_Adminhtml_Block_System_Config_Switcher {

    public function __construct() {
        parent::__construct();
    }

    protected function _prepareLayout() {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }

        return $this;
    }

}
