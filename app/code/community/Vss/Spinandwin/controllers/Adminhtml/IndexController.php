<?php

/**
 * Created by Velsof.
 * @author Bhupendra Singh Bisht
 * Created at 09/18/2018(mm/dd/yyyy)
 *
 * @use: controller for the Admin end of Free spin and win module module.
 */
class Vss_Spinandwin_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        return $this;
    }

    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('system/knowbandextension/spinandwin');
    }

    /*
     * This function will be called when the admin configuration panel is accessed.
     */

    public function indexAction() {
        $helper = Mage::helper('spinandwin');
        $this->loadLayout()->_setActiveMenu('system/spinandwin');
        $this->getLayout()->getBlock('head')->setVssSpinandwinBaseMediaAllowed(true);
        $this->_title(Mage::helper('spinandwin')->__('Spin and Win') . ' - ' . Mage::helper('spinandwin')->__('Module Configurations'));
        Mage::getSingleton('spinandwin/spinandwin')->setData('scope', Mage::helper('spinandwin')->getScope());

        $general_settings_data = Mage::helper('spinandwin')->getSettings('general_settings');
        Mage::getSingleton('spinandwin/spinandwin')->setData('general_settings', $general_settings_data);


        $display_settings = Mage::helper('spinandwin')->getSettings('display_settings');
        Mage::getSingleton('spinandwin/spinandwin')->setData('display_settings', $display_settings);

        $lookandfeel_data = Mage::helper('spinandwin')->getSettings('lookandfeel_settings');
        Mage::getSingleton('spinandwin/spinandwin')->setData('lookandfeel_settings', $lookandfeel_data);
        $slice_data = Mage::helper('spinandwin')->getSettings('slice_settings');
        Mage::getSingleton('spinandwin/spinandwin')->setData('slice_settings', $slice_data);


        $this->getLayout()->getBlock('head')->setTitle($helper->__('Spin and Win'));
        $this->_initAction();
        $this->renderLayout();
    }

    /*
     * Function to handle the post action of Admin Configuration form
     */

    public function saveAction() {
        try {
            $post_data = $this->getRequest()->getPost();

            $coreModel = Mage::getModel("core/config");
            if (isset($post_data['vss_spinandwin'])) {
                $slices_data = $post_data['vss_spinandwin']['slice_settings'];

                $slice_predifined = Mage::helper('spinandwin')->getSliceSettingsDefaultData();

                foreach ($slices_data as $key => $value) {
                    
                    $slices_data[$key]['gravity'] = $slice_predifined[$key]['gravity'];
                     
                }
                
                $coreModel->saveConfig(
                        'vss/spinandwin/slice_settings', serialize($slices_data), $post_data['scope'], $post_data['scope_id']
                );

                $general_settings_data = $post_data['vss_spinandwin']['general'];

                $coreModel->saveConfig(
                        'vss/spinandwin/general_settings', serialize($general_settings_data), $post_data['scope'], $post_data['scope_id']
                );

                if (isset($post_data['vss_spinandwin']['general']['enabled'])) {
                    $coreModel->saveConfig('vss/spinandwheel/active', 1, $post_data['scope'], $post_data['scope_id']);
                } else {
                    $coreModel->saveConfig('vss/spinandwheel/active', 0, $post_data['scope'], $post_data['scope_id']);
                }

                $display_settings_data = $post_data['vss_spinandwin']['display'];
                $coreModel->saveConfig(
                        'vss/spinandwin/display_settings', serialize($display_settings_data), $post_data['scope'], $post_data['scope_id']
                );

                $image_flag = false;
                if ((isset($_FILES['front_image_upload']) && $_FILES['front_image_upload']['size'] > 0) || $post_data['front_image_upload_hidden']) {
                    $path = Mage::getBaseDir('media') . DS . 'vss_spinandwin';
                    $mask = $path . '/front_image.*';
                    $matches = glob($mask);
                    if (!empty($matches))
                        array_map('unlink', $matches);

                    $uploader = new Varien_File_Uploader('front_image_upload');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->addValidateCallback('size', $this, 'validateMaxSize');
                    $ext = explode('.', $_FILES['front_image_upload']['name']);
                    $ext = array_pop($ext);
                    $uploader->setFilesDispersion(false);
                    $file_url = '';
                    if ($uploader->save($path, 'front_image.' . $ext)) {
                        $file_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'vss_spinandwin' . DS . 'front_image.' . $ext;
                        $image_flag = true;
                        Mage::getSingleton('core/session')->addSuccess($this->__('Image has been uploaded successfully!'));
                    } else {
                        Mage::getSingleton('core/session')->addWarning($this->__('There was some error while uploading the image for the front end.'));
                    }
                }

                $lnf_settings_data = $post_data['vss_spinandwin']['lookandfeel'];
                if ($image_flag) {
                    $lnf_settings_data['image_url'] = $file_url;
                } else {
                    $lookandfeel_data = Mage::helper('spinandwin')->getSettings('lookandfeel_settings');
                    $lnf_settings_data['image_url'] = $lookandfeel_data['image_url'];
                }

                $coreModel->saveConfig(
                        'vss/spinandwin/lookandfeel_settings', serialize($lnf_settings_data), $post_data['scope'], $post_data['scope_id']
                );
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Module configuration have been saved successfully!'));
                Mage::app()->getCacheInstance()->cleanType('config');
            }

            $this->_redirectReferer();
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('core/session')->addError($e->getMessage());
        }

        $this->_redirectReferer();
    }

}
