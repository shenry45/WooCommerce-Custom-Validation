<?php
    /**
     * Plugin Name:       WooCommerce Custom Validation
     * Plugin URI:        n/a
     * Description:       Wordpress plugin to allow user defined WooCommerce checkout validation
     * Version:           0.0.1
     * Author:            Shawn Henry
     * Author URI:        http://shawnphenry.com/
     **/

    include('wc-checkout.php');

    register_activation_hook( __FILE__, 'wc_cust_val_init_options' );
    register_deactivation_hook( __FILE__, 'wc_cust_val_remove_options' );

    if ( !function_exists( 'wc_cust_val_init_options' ) ) {
        function wc_cust_val_init_options() {
            add_option( 'wc_cust_blacklist', array() );
            add_option( 'wc_cust_notice', '' );
        }
    }

    if ( !function_exists( 'wc_cust_val_remove_options' ) ) {
        function wc_cust_val_remove_options() {
            delete_option( 'wc_cust_blacklist' );
            delete_option( 'wc_cust_notice' );
        }
    }

    function cust_val_init() {
        add_filter( 'woocommerce_settings_tabs_array', 'cust_val_admin_menus', 50 );
        add_action( 'woocommerce_settings_tabs_wc_cust_val', 'cust_val_tab' );
        add_action( 'woocommerce_update_options_cust_val', 'cust_val_update_settings' );
    }
    add_action( 'admin_init', 'cust_val_init' );

    /* WC Setting Tabs and Tab Settings */
    if ( !function_exists( 'cust_val_admin_menus' ) ) {
        // add_filter( 'woocommerce_settings_tabs_array', 'wc_cust_val_admin_menus', 50 );

        function cust_val_admin_menus( $tabs ) {
            $tabs['cust_val'] = __( 'Custom Validation', 'wc-custom-validation' );
            return $tabs;
        }
    }

    if ( !function_exists( 'cust_val_tab' ) ) {
        // add_action( 'woocommerce_settings_tabs_wc_cust_val', 'cust_val_tab' );

        function cust_val_tab() {
            woocommerce_admin_fields( cust_val_tab_settings() );
        }
    }

    if ( !function_exists( ' cust_val_update_settings ' ) ) {
        // add_action( 'woocommerce_update_options_settings_wc_cust_val', 'wc_cust_update_settings' );

        function cust_val_update_settings() {
            woocommerce_update_options( cust_val_tab_settings() );
        }
    }

    if ( !function_exists( 'cust_val_tab_settings' ) ) {
        function cust_val_tab_settings() {
            $settings = array(
                'section_title' => array(
                    'name'     => __( 'Custom Checkout Validation', 'wc-custom-validation' ),
                    'type'     => 'title',
                    'id'       => 'cust_val_section_title'
                ),
                'message' => array(
                    'name' => __( 'Custom Message', 'wc-custom-validation' ),
                    'type' => 'text',
                    'desc' => __( '' , 'wc-custom-validation' ),
                    'id'   => 'wc_cust_notice'
                ),
                'selections' => array(
                    'name' => __( 'Active Filters', 'wc-custom-validation' ),
                    'type' => 'multiselect',
                    'id' => 'cust_val_select',
                    'options' => array(
                        'key' => 'value'
                    )
                ),
                'section_end' => array(
                     'type' => 'sectionend',
                     'id' => 'cust_val_section_end'
                )
            );
            return apply_filters( 'wc_cust_val_settings', $settings );
        }
    }

    // class WC_Settings_Tab_Demo {

    //     /*
    //      * Bootstraps the class and hooks required actions & filters.
    //      *
    //      */
    //     public static function init() {
    //         add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
    //         add_action( 'woocommerce_settings_tabs_settings_tab_demo', __CLASS__ . '::settings_tab' );
    //         add_action( 'woocommerce_update_options_settings_tab_demo', __CLASS__ . '::update_settings' );
    //     }
        
        
    //     /* Add a new settings tab to the WooCommerce settings tabs array.
    //      *
    //      * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
    //      * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
    //      */
    //     public static function add_settings_tab( $settings_tabs ) {
    //         $settings_tabs['settings_tab_demo'] = __( 'Settings Demo Tab', 'woocommerce-settings-tab-demo' );
    //         return $settings_tabs;
    //     }
    
    
    //     /* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
    //      *
    //      * @uses woocommerce_admin_fields()
    //      * @uses self::get_settings()
    //      */
    //     public static function settings_tab() {
    //         woocommerce_admin_fields( self::get_settings() );
    //     }
    
    
    //     /* Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
    //      *
    //      * @uses woocommerce_update_options()
    //      * @uses self::get_settings()
    //      */
    //     public static function update_settings() {
    //         woocommerce_update_options( self::get_settings() );
    //     }
    
    
    //     /* Get all the settings for this plugin for @see woocommerce_admin_fields() function.
    //      *
    //      * @return array Array of settings for @see woocommerce_admin_fields() function.
    //      */
    //     public static function get_settings() {
    
    //         $settings = array(
    //             'section_title' => array(
    //                 'name'     => __( 'Section Title', 'woocommerce-settings-tab-demo' ),
    //                 'type'     => 'title',
    //                 'desc'     => '',
    //                 'id'       => 'wc_settings_tab_demo_section_title'
    //             ),
    //             'title' => array(
    //                 'name' => __( 'Title', 'woocommerce-settings-tab-demo' ),
    //                 'type' => 'text',
    //                 'desc' => __( 'This is some helper text', 'woocommerce-settings-tab-demo' ),
    //                 'id'   => 'wc_settings_tab_demo_title'
    //             ),
    //             'description' => array(
    //                 'name' => __( 'Description', 'woocommerce-settings-tab-demo' ),
    //                 'type' => 'textarea',
    //                 'desc' => __( 'This is a paragraph describing the setting. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda.', 'woocommerce-settings-tab-demo' ),
    //                 'id'   => 'wc_settings_tab_demo_description'
    //             ),
    //             'section_end' => array(
    //                  'type' => 'sectionend',
    //                  'id' => 'wc_settings_tab_demo_section_end'
    //             )
    //         );
    
    //         return apply_filters( 'wc_settings_tab_demo_settings', $settings );
    //     }
    
    // }
    
    // WC_Settings_Tab_Demo::init();

?>