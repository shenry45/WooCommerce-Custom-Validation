<?php
    /**
     * Plugin Name:       WooCommerce Custom Validation
     * Plugin URI:        n/a
     * Description:       Wordpress plugin to allow user defined WooCommerce checkout validation
     * Version:           0.0.1
     * Author:            Shawn Henry
     * Author URI:        http://shawnphenry.com/
     **/

    register_activation_hook( __FILE__, 'wc_cust_val_init_options' );
    register_deactivation_hook( __FILE__, 'wc_cust_val_remove_options' );

    // include( ABSPATH . 'wp-content/woocommerce-custom-validation/' . 'admin.php');

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

    /* WC Setting Tabs and Tab Settings */

    if ( !function_exists( 'wc_cust_val_admin_menus' ) ) {
        add_filter( 'woocommerce_settings_tabs_array', 'wc_cust_val_admin_menus', 50 );
        function wc_cust_val_admin_menus( $tabs ) {
            $tabs['wc_cust_val'] = __( 'WC Custom Validation', 'woocommerce-settings-tab-demo' );
            return $tabs;
        }
    }

    if ( !function_exists( 'wc_cust_val_tab' ) ) {
        function wc_cust_val_tab() {
            woocommerce_admin_fields( wc_cust_val_tab_settings() );
        }
        add_action( 'woocommerce_settings_tabs_wc_cust_val', 'wc_cust_val_tab' );
    }

    if ( !function_exists( 'wc_cust_val_tab_settings' ) ) {
        function wc_cust_val_tab_settings() {
            $settings = array(
                'section_title' => array(
                    'name'     => __( 'Section Title', 'woocommerce-settings-tab-demo' ),
                    'type'     => 'title',
                    'desc'     => '',
                    'id'       => 'wc_settings_tab_demo_section_title'
                ),
                'title' => array(
                    'name' => __( 'Title', 'woocommerce-settings-tab-demo' ),
                    'type' => 'text',
                    'desc' => __( 'This is some helper text', 'woocommerce-settings-tab-demo' ),
                    'id'   => 'wc_settings_tab_demo_title'
                ),
                'description' => array(
                    'name' => __( 'Description', 'woocommerce-settings-tab-demo' ),
                    'type' => 'textarea',
                    'desc' => __( 'This is a paragraph describing the setting. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda.', 'woocommerce-settings-tab-demo' ),
                    'id'   => 'wc_settings_tab_demo_description'
                ),
                'section_end' => array(
                     'type' => 'sectionend',
                     'id' => 'wc_settings_tab_demo_section_end'
                )
            );
            return apply_filters( 'wc_settings_tab_demo_settings', $settings );
        }
    }

?>