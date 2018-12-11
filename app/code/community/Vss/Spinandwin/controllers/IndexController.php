<?php

/**
 * Created by Velsof.
 * @author Bhupendra Singh Bisht
 * Created at 09/18/2018(mm/dd/yyyy)
 *
 * @use: controller for the Front end of Free spin and win module module.
 */

class Vss_Spinandwin_IndexController extends Mage_Core_Controller_Front_Action
{
    /*
     * Function to handle the front end rotate wheel functionality though Ajax
     */
    public function frontAjaxAction() 
    {
        $post_data = $this->getRequest()->getPost();
        if (isset($post_data['ajax']) && $post_data['ajax'] == true) {
            $json_array = array();
            if (isset($post_data['method'])) {
                if ($post_data['method'] == 'checkWinningAndGenerateCoupon') {
                    $cus_email = $post_data['customer_email'];
                    $cus_fname = $post_data['customer_fname'];
                    $cus_lname = $post_data['customer_lname'];
                    $json_array = $this->checkSlicesAndGenerateCoupon($cus_email, $cus_fname, $cus_lname);
                }
                
            }

            $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
            $this->getResponse()->setBody(json_encode($json_array));
        }
    }
    
    /*
     * Function to handle the front end rotate wheel functionality and create a coupon code in case the customer wins
     */
    private function checkSlicesAndGenerateCoupon($email = '', $fname = '', $lname = '') 
    {
        $response_array = array();
        $general_settings = Mage::helper('spinandwin')->getSettings('general_settings');
       


        $slice_data = Mage::helper('spinandwin')->getSettings('slice_settings');
        $prob_arr = array();
        foreach ($slice_data as $key => $slice) {
            for ($i = 0; $i < $slice['gravity']; $i++) {
                $prob_arr[] = $key;
            }
        }

        $random_key = array_rand($prob_arr);
        $selected_slice = $prob_arr[$random_key];
        $exploded_slice = explode('_', $selected_slice);
        $response_array['slice_to_select'] = $exploded_slice[1];
        
        if ($slice_data[$selected_slice]['discount_type'] != 'freeship' && $slice_data[$selected_slice]['value'] == 0) {
            $response_array['win'] = false;
            $response_array['error'] = Mage::helper('spinandwin')->__('Not your lucky day today. Better Luck Next Time.');
        } else {
            $response_array['win'] = true;
            //generate automatic coupon code
            $coupon_code = Mage::helper('spinandwin')->generateRandomCouponCode();
            //creating rule & coupon
            
            $freeShipping = false;
            if ($slice_data[$selected_slice]['discount_type'] == 'freeship') {
                $freeShipping = true;
            }
            $check_rule_creation = Mage::helper('spinandwin')->createRule(
                $coupon_code,
                1,
                $slice_data[$selected_slice]['discount_type'],
                $slice_data[$selected_slice]['value'],
                $freeShipping,
                true
            );
            if ($check_rule_creation) {
                $coupon_id = Mage::helper('spinandwin')->addCouponToCouponsList(
                    $coupon_code,
                    $slice_data[$selected_slice]['value'],
                    $slice_data[$selected_slice]['discount_type']
                );
              
                $response_array['coupon_code'] = $coupon_code;
                $response_array['label'] = $slice_data[$selected_slice]['label'];
            } else {
                $response_array['coupon_code'] = '';
                $response_array['coupon_error'] = Mage::helper('spinandwin')->__('Something went wrong while generating the coupon code, please try again.');
            }
        }

        return $response_array;
    }
    
    
}
