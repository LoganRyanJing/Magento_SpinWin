<?php

/*
 * Observer to update when the Spin and Win coupon gets used
 */

class Vss_Spinandwin_Model_Observer_Spinandwin extends Varien_Event_Observer
{

    public function markCouponUsed($observer)
    {
        unset($observer);
        try {
            $coupon_code = Mage::getSingleton('checkout/session')->getQuote()->getCouponCode();
            if ($coupon_code) {
                $collection = Mage::getModel('spinandwin/couponlist')->getCollection();
                $collection->addFieldToFilter('main_table.coupon_code', array('eq' => $coupon_code));
                $coupon_data = $collection->getData();
                if (!empty($coupon_data)) {
                    $coupon_detail = $collection->getFirstItem();
                    $u_collection = Mage::getModel('spinandwin/userlist')->getCollection();
                    $u_collection->addFieldToFilter('main_table.coupon_id', array('eq' => $coupon_detail['coupon_id']));
                    $user_data = $u_collection->getData();
                    if (!empty($user_data)) {
                        $user_detail = $u_collection->getFirstItem();
                        $used_model = Mage::getModel('spinandwin/userlist')->load($user_detail['id_user_list']);
                        $used_model->setCouponUsage('1');
                        $used_model->setUpdatedAt(Varien_Date::now());
                    }

                    $used_model->save()->getId();
                }
            }
        } catch (Exception $e) {
            Mage::logException($e->getMessage());
        }
    }

}







