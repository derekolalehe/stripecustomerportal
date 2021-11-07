<?php
/**
* Stripe Customer Portal class file
*
* @package Stripe Customer Portal
* @license GPL2
* @copyright 2021
*/

class SCP {

    protected static $version = '1.0.0';
    protected static $plugin_slug = 'scp';
    protected static $instance = null;
    private function __construct() {

        function scp_admin_scripts_styles() {

            wp_enqueue_script('jquery','', false, true );

            //Make ajax url available on the front end
            $protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
        
            $params = array(
                'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ),
                'home_url' => home_url(),
                'theme_url' => get_template_directory_uri(),
                'plugins_url' => plugins_url(),
            );
          
        }

        add_action( 'admin_enqueue_scripts', 'scp_admin_scripts_styles' );  

        require_once( 'admin-pages.php' );

        require_once( 'assets/lib/Stripe.php' );
        require_once( 'assets/lib/BillingPortal/Session.php' );

        require_once( 'methods.php' );

        add_action( 'admin_post_create_customer_portal_session', 'create_customer_portal_session' );
        add_action( 'admin_post_nopriv_create_customer_portal_session', 'create_customer_portal_session' );

        /**
        * Shortcodes
        */

        function scp_setup_shortcodes () {

            add_shortcode( 'scp_button', 'scp_button_shortcode' );

        }

        add_action( 'init', 'scp_setup_shortcodes' );

        function scp_button_shortcode(){

            echo    '<form action="' . esc_attr('admin-post.php') . '" method="POST">' .
                        '<input type="hidden" name="action" value="create_customer_portal_session" />' .
                        '<button type="submit">Customer Portal</button>' .
                    '</form>';

        }

    }

    public static function get_instance() {
    
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
        
    }

}