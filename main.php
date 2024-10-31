<?php
/*
  Plugin Name: Sell Media Affiliate Integration
  Version: 1.0.1
  Plugin URI: https://noorsplugin.com/sell-media-file-plugin-for-wordpress/
  Author: naa986
  Author URI: https://noorsplugin.com/
  Description: Track affiliate commission through the Sell Media File plugin.
  Text Domain: sell-media-affiliate
  Domain Path: /languages
 */

add_action('smf_order_processed', 'wpam_sellmediafile_integration');

function wpam_sellmediafile_integration($post_id) {
    WPAM_Logger::log_debug('Sell Media File Integration - Order notification received.');
    if(isset($_COOKIE['wpam_id']))
    {
        $aff_id = $_COOKIE['wpam_id'];
        WPAM_Logger::log_debug('Sell Media File Integration - Tracking data present. Need to track affiliate commission. Tracking value: ' . $aff_id);
        $args = array();
        $args['txn_id'] = get_post_meta($post_id, '_txn_id', true);
        $args['amount'] = get_post_meta($post_id, '_amount', true);
        $args['aff_id'] = $aff_id;
        do_action('wpam_process_affiliate_commission', $args);
        WPAM_Logger::log_debug('Sell Media File Integration - Commission tracked for transaction ID: ' . $args['txn_id'] . '. Purchase amt: ' . $args['amount']);
    }
    else{
        WPAM_Logger::log_debug('Sell Media File Integration - Tracking data is not present. This is not an affiliate sale.');
    }
}
