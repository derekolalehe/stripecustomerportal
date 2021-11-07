<?php
/*
Plugin Name: Stripe Customer Portal
Description: Connect to Stripe Customer Portal
Version: 1.0.0
Author: 
Author URI: 
License: GPL2
*/

/* Copyright 2021 
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

require_once( plugin_dir_path( __FILE__ ) . 'class-scp.php' );

SCP::get_instance();

register_activation_hook( __FILE__, 'scp_activations' );

function scp_activations(){

    
}

register_deactivation_hook( __FILE__, 'scp_deactivations' );

function scp_deactivations(){    
   
    
}

?>