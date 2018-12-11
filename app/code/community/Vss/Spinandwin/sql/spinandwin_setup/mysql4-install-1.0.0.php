<?php

/**
 * Created by Velsof.
 * @author Bhupendra Singh Bisht
 * Created at 09/18/2018(mm/dd/yyyy)
 *
 */

/* This file is responsible for creating the tables for this module when the module runs for the first time. */
$installer = $this;

$installer->startSetup();

$installer->run(
    "CREATE TABLE IF NOT EXISTS `{$installer->getTable('vss_spinandwin_coupons')}` (
        `coupon_id` int(11) NOT NULL auto_increment,
        `store_id` smallint(5) unsigned default '0',
        `website_id` smallint(5) unsigned default NULL,
        `coupon_code` varchar(250) NOT NULL,
        `coupon_value` varchar(50) NOT NULL,
        `coupon_value_type` varchar(20) NOT NULL,
        `use_type` TINYINT(1),
        `discount_currency` VARCHAR(11) NOT NULL,
        `coupon_expire_in_days` TINYINT(2) NOT NULL,
        `coupon_expire_date` DATETIME NOT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY  (`coupon_id`),
        INDEX (`coupon_code`),
        KEY `FK_SPCOUPONS_TO_WEBSITE_ID` (`website_id`),
        KEY `FK_SPCOUPONS_TO_STORE_ID` (`store_id`),
        CONSTRAINT `FK_SPCOUPONS_TO_WEBSITE_ID` FOREIGN KEY (`website_id`) REFERENCES `{$installer->getTable('core_website')}` (`website_id`) ON DELETE SET NULL ON UPDATE CASCADE,
        CONSTRAINT `FK_SPCOUPONS_TO_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `{$installer->getTable('core_store')}` (`store_id`) ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='TABLE FOR SAVING DATA OF SPIN AND WIN COUPONS';

    ALTER TABLE `{$installer->getTable('vss_spinandwin_coupons')}` AUTO_INCREMENT=1;"
);

$installer->endSetup();
