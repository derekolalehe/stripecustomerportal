<?php

<?php
/**
* WP Magento Sync class file
*
* @package WP Magento Sync
* @author CXC ESAD
* @license GPL2
* @copyright 2021
*/

class WPMagentoSync {

    protected static $version = '1.0.0';
    protected static $plugin_slug = 'wp-magento-sync';
    protected static $instance = null;
    private function __construct() {

        function wpms_admin_scripts_styles() {

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

        add_action( 'admin_enqueue_scripts', 'wpms_admin_scripts_styles' );  

        function  wpms_scripts_styles() {

            wp_enqueue_script('jquery','', false, true );

            //Make ajax url available on the front end
            $protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
        
            $params = array(
                'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ),
                'home_url' => home_url(),
                'theme_url' => get_template_directory_uri(),
                'plugins_url' => plugins_url(),
            );
            
            wp_enqueue_script( 'main', plugins_url( 'assets/js/main.js', __FILE__ ), array(), (string)microtime(), true);
                
            wp_localize_script( 'main', 'wpms_urls', $params ); 

            wp_enqueue_style( 'style', plugins_url( 'assets/css/style.css?v=' . (string)microtime(), __FILE__ ), array(), false ); 

        
        }

        add_action( 'wp_enqueue_scripts', 'wpms_scripts_styles' );  

        // Regular Methods
        require_once( 'includes/methods.php' );

        add_action( 'products_sync', 'pull_magento_products' );

        // AJAX Methods
        require_once( 'includes/ajax-methods.php' );

        add_action('wp_ajax_process_order_as_magento', 'process_order_as_magento');
        add_action('wp_ajax_nopriv_process_order_as_magento', 'process_order_as_magento');
        
        function wpms_every_month( $schedules ) {
            if( !isset($schedules["wpms_monthly"])):
            
                $schedules['wpms_monthly'] = array(
                    'interval' => 2628000,
                    'display' => __( 'Every Month' )
                );
                return $schedules;

            endif;
        }
        
        add_filter( 'cron_schedules', 'wbw_every_month' );
        
        // /**
        // * Table Names
        // */
        // global $wpdb;

        // if ( ! isset( $wpdb->table_name ) ) {
        //     $wpdb->_table_name = $wpdb->prefix . 'table_name';
        // }

        function wpms_plugin_path() {
        
            return untrailingslashit( plugin_dir_path( __FILE__ ) );

        }    
    
        add_filter( 'woocommerce_locate_template', 'wpms_locate_woocommerce_template', 10, 3 );
        
        function wpms_locate_woocommerce_template( $template, $template_name, $template_path ) {

            global $woocommerce;
            
            $_template = $template;
            
            if ( ! $template_path ) $template_path = $woocommerce->template_url;
            
            $plugin_path  = wpms_plugin_path() . '/woocommerce/';
            
            // Look within passed path within the theme - this is priority
            $template = locate_template(
            
                array(
                $template_path . $template_name,
                $template_name
                )
            );
            
            // Modification: Get the template from this plugin, if it exists
            if ( ! $template && file_exists( $plugin_path . $template_name ) )
                $template = $plugin_path . $template_name;
            
            // Use default template
            if ( ! $template )
                $template = $_template;
            
            // Return what we found
            return $template;
        
        }

        // function meks_which_template_is_loaded() {
        //     //if ( is_super_admin() ) {
        //     global $template;
        
        //     print_r( $template );
        // }
        
        // add_action( 'wp_footer', 'meks_which_template_is_loaded' );

    }

    public static function get_instance() {
    
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
        
    }

}