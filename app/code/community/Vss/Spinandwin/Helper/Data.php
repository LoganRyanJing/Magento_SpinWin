<?php

/**
 * Created by Velsof.
 * @author Bhupendra Singh Bisht
 * Created at 09/18/2018(mm/dd/yyyy)
 *
 * @use: Helper for the Free spin and win module module.
 */

class Vss_Spinandwin_Helper_Data extends Mage_Core_Helper_Abstract
{
    /*
     * Function to get the current URL Key
     */

    public function getUrlKey()
    {
        $params = Mage::app()->getRequest()->getParams();
        $urlKey = 'spinandwin/adminhtml_index/index';
        if (isset($params['website'])) {
            $urlKey .= '/website/' . $params['website'];
        }

        if (isset($params['store'])) {
            $urlKey .= '/store/' . $params['store'];
        }

        return $urlKey;
    }

    /*
     * Function for getting the current scope (Called from the admin panel)
     */

    public function getScope()
    {
        $code = Mage::app()->getRequest()->getParam('store');
        $code_w = Mage::app()->getRequest()->getParam('website');
        if ($code != '') {
            $store_id = Mage::getModel('core/store')->load($code)->getId();
        } else if ($code_w != '') {
            $website_id = Mage::getModel('core/website')->load($code)->getId();
            $store_id = Mage::app()->getWebsite($website_id)->getDefaultStore()->getId();
        } else {
            $store_id = 0;
        }

        if ($code == '' && $code_w == '') {
            $data['scope'] = 'default';
            $data['scope_id'] = 0;
        } else if (isset($website_id)) {
            $data['scope'] = 'websites';
            $data['scope_id'] = $website_id;
        } else if (isset($store_id)) {
            $data['scope'] = 'stores';
            $data['scope_id'] = $store_id;
        } else {
            $data['scope'] = 'default';
            $data['scope_id'] = 0;
        }

        return $data;
    }

    /*
     * Function for getting the settings/configurations for the module
     */

    public function getSettings($name = 'general')
    {
        $code = Mage::app()->getRequest()->getParam('store');
        $code_w = Mage::app()->getRequest()->getParam('website');
        if ($code != '') {
            $store_id = Mage::getModel('core/store')->load($code)->getId();
        } else if ($code_w != '') {
            $website_id = Mage::getModel('core/website')->load($code)->getId();
            $store_id = Mage::app()->getWebsite($website_id)->getDefaultStore()->getId();
        } else {
            $store_id = 0;
        }

        if ($code == '' && $code_w == '')
            $settings = Mage::getStoreConfig('vss/spinandwin/' . $name, $store_id);
        else if (isset($website_id))
            $settings = Mage::app()->getWebsite($website_id)->getConfig('vss/spinandwin/' . $name);
        else if (isset($store_id))
            $settings = Mage::getStoreConfig('vss/spinandwin/' . $name, $store_id);
        else
            $settings = Mage::getStoreConfig('vss/spinandwin/' . $name);

        if (trim($settings) != "")
            $settings = unserialize($settings);
        else
            $settings = $this->getDefaultSettings($name);

        return $settings;
    }

    /*
     * Function for getting the default values for the module
     */

    public function getDefaultSettings($index)
    {
        return $this->getDefaultConfigDataTabWise($index);
    }

    /*
     * Function for getting the default data of the module tab wise
     */

    public function getDefaultConfigDataTabWise($case)
    {
        $settings_array = array();
        switch ($case) {
            case 'general_settings':
                $settings_array = $this->getGeneralSettingsDefaultData();
                break;
            case 'display_settings':
                $settings_array = $this->getDisplaySettingsDefaultData();
                break;
            case 'lookandfeel_settings':
                $settings_array = $this->getLookAndFeelSettingsDefaultData();
                break;
            case 'slice_settings':
                $settings_array = $this->getSliceSettingsDefaultData();
                break;
            case 'email_marketing':
                $settings_array = $this->getEmailMarketingDefaultData();
                break;
            case 'email_settings':
                $settings_array = $this->getEmailSettingsDefaultData();
                break;
        }

        return $settings_array;
    }

   

    /*
     * Function for getting the default data of slice settings tab
     */

    public function getSliceSettingsDefaultData()
    {
        $settings = array(
            'slice_1' => array(
                'label' => '10% OFF',
                'discount_type' => 'percent',
                'value' => 10,
                'gravity' => '20',
            ),
            'slice_2' => array(
                'label' => 'Not Lucky Today',
                'discount_type' => 'fixed',
                'value' => 0,
                'gravity' => '5',
            ),
            'slice_3' => array(
                'label' => '35% OFF',
                'discount_type' => 'percent',
                'value' => 35,
                'gravity' => '0',
            ),
            'slice_4' => array(
                'label' => 'Opps! Sorry',
                'discount_type' => 'fixed',
                'value' => 0,
                'gravity' => '5',
            ),
            'slice_5' => array(
                'label' => '15% OFF',
                'discount_type' => 'percent',
                'value' => 15,
                'gravity' => '10',
            ),
            'slice_6' => array(
                'label' => 'Better Luck Next Time',
                'discount_type' => 'fixed',
                'value' => 0,
                'gravity' => '10',
            ),
            'slice_7' => array(
                'label' => '50% OFF',
                'discount_type' => 'percent',
                'value' => 50,
                'gravity' => '0',
            ),
            'slice_8' => array(
                'label' => 'Try Next Time',
                'discount_type' => 'fixed',
                'value' => 0,
                'gravity' => '10',
            ),
            'slice_9' => array(
                'label' => 'Free Shipping',
                'discount_type' => 'freeship',
                'value' => 0,
                'gravity' => '10',
            ),
            'slice_10' => array(
                'label' => 'Come Again',
                'discount_type' => 'fixed',
                'value' => 0,
                'gravity' => '10',
            ),
            'slice_11' => array(
                'label' => '5% OFF',
                'discount_type' => 'percent',
                'value' => 5,
                'gravity' => '10',
            ),
            'slice_12' => array(
                'label' => 'Try Again',
                'discount_type' => 'fixed',
                'value' => 0,
                'gravity' => '10',
            )
        );
        return $settings;
    }

    /*
     * Function for getting the default data of general settings tab
     */

    public function getGeneralSettingsDefaultData()
    {
        $settings = array(
            'enabled' => 1,
            'pull_out' => 1,
            'display_interval' => 1,
            'custom_css' => '',
            'wheel_sound' => 1,
            'show_fireworks' => 0,
            'pull_out_image_url' => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'vss_spinandwin' . DS . 'gift.png'
        );
        return $settings;
    }

    /*
     * Function for getting the default data for Display Settings Tab
     */

    public function getDisplaySettingsDefaultData()
    {
        $settings = array(
            'screen_size' => '320_480',
            'display_frequency' => 1,
            'hide_after' => 1,
            'display_position' => 1,
            'who_to_show' => 'all',
            'when_to_display' => 'immediately',
            'time_in_seconds' => 5,
            'scroll_percent' => 10,
            'geo_location' => 'always'
        );
        return $settings;
    }

    /*
     * Function for getting the default data for Look and Feel Settings Tab
     */

    public function getLookAndFeelSettingsDefaultData()
    {
        $settings = array(
            'image_url' => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'vss_spinandwin' . DS . 'front_image.png',
            'try_luck_color' => '00c74c',
            'try_luck_text_color' => 'ffffff',
            'feel_lucky_text_color' => 'fffbf8',
            'continue_color' => 'd6042e',
            'next_time_color' => 'ff8400',
            'background_color' => '007aa7',
            'text_color' => 'ffffff',
            'wheel_color' => '4497bb',
            'wheel_text_color' => 'ffffff',
            'theme' => 0,
            'wheel_design'  => 1
        );
        return $settings;
    }

    /*
     * Function to create the Coupon Code Based on slice settings
     */

    public function createRule($rand_code, $expiration_time, $discount_type, $discount_amount, $allow_free_shipping, $stop_further_discount)
    {
        try {
            $customer_groups = $this->getCustomerGroups(); //get through functions

            $from_date = date('Y-m-d');
            if ($expiration_time > 1) {
                $to_date = date('Y-m-d', strtotime($from_date . ' + ' . $expiration_time . ' days'));
            } else {
                $to_date = date('Y-m-d', strtotime($from_date . ' + 1 day'));
            }
$from_date = date('Y-m-d', strtotime($from_date . ' -1 day'));
            $rule = Mage::getModel('salesrule/rule');
            $rule->setName($rand_code);
            $rule->setDescription('Coupon Created By Spin and Win (Knowband)');
            $rule->setFromDate($from_date); //starting today
            $rule->setToDate($to_date); //if you need an expiration date
            $rule->setCouponType(2);
            $rule->setCouponCode($rand_code);
            $rule->setUsesPerCoupon(1); //number of allowed uses for this coupon
            $rule->setUsesPerCustomer(1); //number of allowed uses for this coupon for each customer
            $rule->setCustomerGroupIds($customer_groups); //if you want only certain groups replace getAllCustomerGroups() with an array of desired ids 
            $rule->setIsActive(1);

            $rule->setStopRulesProcessing($stop_further_discount); //set to 1 if you want all other rules after this to not be processed
            $rule->setIsRss(0); //set to 1 if you want this rule to be public in rss
            $rule->setIsAdvanced(1); //have no idea what it means :)
            $rule->setProductIds('');
            $rule->setSortOrder(0); // order in which the rules will be applied
            $rule->setWebsiteIds(array(Mage::app()->getWebsite()->getId())); // order in which the rules will be applied

            if ($discount_type == 'fixed') {
                $rule->setSimpleAction('by_fixed');
            } else {
                $rule->setSimpleAction('by_percent');
            }

            //all available discount types
            //by_percent - Percent of product price discount
            //by_fixed - Fixed amount discount
            //cart_fixed - Fixed amount discount for whole cart
            //buy_x_get_y - Buy X get Y free (discount amount is Y)

            $rule->setDiscountAmount($discount_amount); //the discount amount/percent. if SimpleAction is by_percent this value must be <= 100
            $rule->setDiscountQty(0); //Maximum Qty Discount is Applied to
            $rule->setDiscountStep(0); //used for buy_x_get_y; This is X
            if ($allow_free_shipping) {
                $rule->setSimpleFreeShipping(Mage_SalesRule_Model_Rule::FREE_SHIPPING_ADDRESS); //set to 1 for Free shipping
                $rule->setApplyToShipping(1); //set to 1 for Free shipping
            } else {
                $rule->setSimpleFreeShipping(0); //set to 1 for Free shipping
                $rule->setApplyToShipping(0); //set to 1 for Free shipping
            }

//            $rule->setApplyToShipping(0); //set to 0 if you don't want the rule to be applied to shipping
//            $rule->setWebsiteIds(array(1));//if you want only certain websites replace getAllWbsites() with an array of desired ids

            $conditions = array();
            $conditions[1] = array(
                'type' => 'salesrule/rule_condition_combine',
                'aggregator' => 'all',
                'value' => "1", //[UPDATE] added quotes on the value. Thanks Aziz Rattani [/UPDATE]
                'new_child' => ''
            );
            //the conditions above are for 'if all of these conditions are true'
            //for if any one of the conditions is true set 'aggregator' to 'any'
            //for if all of the conditions are false set 'value' to 0.
            //for if any one of the conditions is false set 'aggregator' to 'any' and 'value' to 0
            $conditions['1--1'] = Array
                (
                'type' => 'salesrule/rule_condition_address',
                'attribute' => 'base_subtotal',
                'operator' => '>=',
                'value' => 1
            );
            //the constraints above are for 'Subtotal is equal or grater than 200'
            //for 'equal or less than' set 'operator' to '<='... You get the idea other operators for numbers: '==', '!=', '>', '<'
            //for 'is one of' set operator to '()';
            //for 'is not one of' set operator to '!()';
            //in this example the constraint is on the subtotal
            //for other attributes you can change the value for 'attribute' to: 'total_qty', 'weight', 'payment_method', 'shipping_method', 'postcode', 'region', 'region_id', 'country_id'
            //to add an other constraint on product attributes (not cart attributes like above) uncomment and change the following:
            /*
              $conditions['1--2'] = array
              (
              'type' => 'salesrule/rule_condition_product_found',//-> means 'if all of the following are true' - same rules as above for 'aggregator' and 'value'
              //other values for type: 'salesrule/rule_condition_product_subselect' 'salesrule/rule_condition_combine'
              'value' => 1,
              'aggregator' => 'all',
              'new_child' => '',
              );

              $conditions['1--2--1'] = array
              (
              'type' => 'salesrule/rule_condition_product',
              'attribute' => 'sku',
              'operator' => '==',
              'value' => '12',
              );
             */
            //$conditions['1--2--1'] means sku equals 12. For other constraints change 'attribute', 'operator'(see list above), 'value'

            $rule->setData('conditions', $conditions);
            $rule->loadPost($rule->getData());
            $rule->save();
            return true;
        } catch (Exception $e) {
            Mage::logException($e);
            return false;
        }
    }

    /*
     * Function to get all customer groups
     */

    public function getCustomerGroups()
    {

        $allGroups = Mage::getResourceModel('customer/group_collection')->toOptionHash();
        foreach ($allGroups as $key => $allGroup) {
            $customerGroup[] = $key;
        }

        return $customerGroup;
    }

    /*
     * Function to generate a random code for Spin Wheel Coupon
     */

    public function generateRandomCouponCode()
    {
        $length = 12;
        $code = '';
        $chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ0123456789';
        $maxlength = strlen($chars);
        if ($length > $maxlength) {
            $length = $maxlength;
        }

        $i = 0;
        while ($i < $length) {
            $char = substr($chars, mt_rand(0, $maxlength - 1), 1);
            if (!strstr($code, $char)) {
                $code .= $char;
                $i++;
            }
        }

        $code = strtoupper($code);
        return $code;
    }

    /*
     * Function for adding coupon to coupons list
     */

    public function addCouponToCouponsList($code, $c_val, $c_val_type)
    {
        try {
            $couponModel = Mage::getModel('spinandwin/couponlist');
            $storeId = Mage::app()->getStore()->getStoreId();
            $websiteId = Mage::app()->getStore()->getWebsiteId();
            $couponModel->setStoreId($storeId);
            $couponModel->setWebsiteId($websiteId);
            $couponModel->setCouponCode($code);
            $couponModel->setCouponValue($c_val);
            $couponModel->setCouponValueType($c_val_type);
            $couponModel->setUseType('1');
            $couponModel->setCouponExpireInDays('1');
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d', strtotime($from_date . ' + 1 day'));
            $couponModel->setCouponExpireDate($to_date);
            $currency = Mage::app()->getStore()->getCurrentCurrencyCode();
            $couponModel->setDiscountCurrency($currency);
            $couponModel->setCreatedAt(Varien_Date::now());
            $couponModel->setUpdatedAt(Varien_Date::now());
            $couponModel->save();
            $inserted_id = $couponModel->getId();
            $couponModel->unsetData();
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $inserted_id;
    }

    
    public function getMonths($month_num)
    {
        $month_name = '';
        switch ($month_num) {
            case '1':
                $month_name = $this->__('Jan');
                break;
            case '2':
                $month_name = $this->__('Feb');
                break;
            case '3':
                $month_name = $this->__('Mar');
                break;
            case '4':
                $month_name = $this->__('Apr');
                break;
            case '5':
                $month_name = $this->__('May');
                break;
            case '6':
                $month_name = $this->__('Jun');
                break;
            case '7':
                $month_name = $this->__('Jul');
                break;
            case '8':
                $month_name = $this->__('Aug');
                break;
            case '9':
                $month_name = $this->__('Sep');
                break;
            case '10':
                $month_name = $this->__('Oct');
                break;
            case '11':
                $month_name = $this->__('Nov');
                break;
            case '12':
                $month_name = $this->__('Dec');
                break;
        }
        return $month_name;
    }

   
}
