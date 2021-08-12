<?php
/*
Plugin Name: WP Magento Sync
Description: Pass order processing from WooCommerce to Magento & Synchronize Products
Version: 1.0.0
Author: Caribbean Examinations Council
Author URI: https://www.cxc.org
License: GPL2
*/

/* Copyright 2021 Caribbean Examinations Council
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

require_once( plugin_dir_path( __FILE__ ) . 'class-wp-magento-sync.php' );

WPMagentoSync::get_instance();

register_activation_hook( __FILE__, 'wpms_activations' );

function wpms_activations(){

    wp_schedule_event( strtotime("September 1, 2021 00:00:00"), 'wpms_monthly', 'products_sync' );

}

register_deactivation_hook( __FILE__, 'wpms_deactivations' );

function wpms_deactivations(){    
   
    
}

?>