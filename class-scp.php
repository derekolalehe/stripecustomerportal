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

        require_once('stripe-php-7.100.0/init.php');

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

            echo    '<form action="' . esc_attr( admin_url( 'admin-post.php', 'https' ) ) . '" method="POST">' .
                        '<input type="hidden" name="action" value="create_customer_portal_session" />' .
                        '<button type="submit">Customer Portal</button>' .
                    '</form>';

        }

        //Stripe endpoint setup  *http://domain/wp-json/stripecustomerportal/v1/subscriptionended
        add_action( 'rest_api_init', function () {
            register_rest_route( 'stripecustomerportal/v1', '/subscriptionended', array(
              'methods' => \WP_REST_Server::CREATABLE,
              'callback' => 'change_customer_role',
            ) );
        } );

        function change_customer_role ( $data ) {

            global $wpdb;

            $sent_stripe_customerID = $data[ 'data' ][ 'object' ][ 'customer' ];

            $userID = $wpdb->get_var(
                "SELECT user_id FROM $wpdb->usermeta " . 
                "WHERE meta_key = '" . $wpdb->prefix . "_stripe_customer_id" . "' " .
                "AND meta_value = '" . $sent_stripe_customerID . "'"
            );

            $user = get_user_by( 'id', (int)$userID );

            if( $user ){

                $user->remove_role( 'subscriber' );

                $user->add_role( 'customer' );

            }
            else {

                return new WP_Error( 'user_mismatch', 'User does not exist', array( 'status' => 404 ) );

            }
                      
            return 'Customer ' . $sent_stripe_customerID . ' with subscription ' . 
            $data[ 'data' ][ 'object' ][ 'id' ] . ' - SUBSCRIPTION EDNDED';

        }

    }

    public static function get_instance() {
    
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
        
    }

}