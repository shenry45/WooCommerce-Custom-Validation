<?php
    /**
     * Plugin Name:       WooCommerce Custom Validation
     * Plugin URI:        n/a
     * Description:       Wordpress plugin to allow user defined WooCommerce checkout validation
     * Version:           0.0.1
     * Author:            Shawn Henry
     * Author URI:        http://shawnphenry.com/
     **/

    include('woocommerce/validate.php');

    add_filter( 'woocommerce_settings_tabs_array', 'cust_add_settings_tab', 50 );
    add_action( 'woocommerce_settings_tabs_cust_val', 'cust_settings_tab' );
    add_action( 'woocommerce_update_options_cust_val', 'cust_update_settings' );


    /*
    PLUGIN OPTIONS
    */
    register_activation_hook( __FILE__, 'wc_cust_val_init_options' );
    register_deactivation_hook( __FILE__, 'wc_cust_val_remove_options' );

    if ( !function_exists( 'wc_cust_val_init_options' ) ) {
        function wc_cust_val_init_options() {
            add_option( 'wc_cust_val_blacklist', array() );
            add_option( 'wc_cust_val_notice', '' );
        }
    }

    if ( !function_exists( 'wc_cust_val_remove_options' ) ) {
        function wc_cust_val_remove_options() {
            delete_option( 'cust_val_blacklist' );
            delete_option( 'wc_cust_val_notice' );
        }
    }


    /*
    WC Setting Tabs and Tab Settings
    */
    if ( !function_exists( 'cust_add_settings_tab' ) ) {
        function cust_add_settings_tab( $settings_tabs ) {
            $settings_tabs['cust_val'] = __( 'Custom Validation', 'woocommerce-cust-val' );
            return $settings_tabs;
        }
    }

    if ( !function_exists( 'cust_settings_tab' ) ) {
        function cust_settings_tab() {
            woocommerce_admin_fields( cust_get_settings() );

            /*
                Add update filter mechanic here
                Must be seperate from other fields due to conflict on save and update order, not sure if can get live update?
            */
        }
    }

    if ( !function_exists( ' cust_update_settings ' ) ) {
        function cust_update_settings() {
            woocommerce_update_options( cust_get_settings() );
        }
    }

    if ( !function_exists( 'cust_get_settings' ) ) {
        function cust_get_settings() {
            $settings = array(
                'section_title' => array(
                    'name' => __( 'Custom Checkout Validation', 'woocommerce-cust-val' ),
                    'type' => 'title',
                    'desc' => __( '', 'woocommerce-cust-val' ),
                    'id' => 'wc_cust_val_section_title'
                ),
                'notice' => array(
                    'name' => __( 'Custom Message', 'woocommerce-cust-val' ),
                    'type' => 'text',
                    'desc' => __( '', 'woocommerce-cust-val' ),
                    'id' => 'wc_cust_val_notice'
                ),
                // 'selections' => array(
                //     'name' => __( 'Active Filters', 'woocommerce-cust-val' ),
                //     'type' => 'multiselect',
                //     'id' => 'wc_cust_val_selections',
                //     'options' => array(
                //         'key' => 'value'
                //     )
                // ),
                'add_filter' => array(
                    'name' => __( 'Add Filter', 'woocommerce-cust-val'),
                    'type' => 'text',
                    'desc' => __( 'Add a custom value to the filter list', 'woocommerce-cust-val' ),
                    'id' => 'wc_cust_val_blacklist'
                ),
                'section_end' => array(
                     'type' => 'sectionend',
                     'id' => 'wc_cust_val_section_end'
                )
                );

            // $filters = get_option( 'wc_cust_val_blacklist', array('No results found') );

            return apply_filters( 'wc_cust_val_settings', $settings );
        }
    }
?>