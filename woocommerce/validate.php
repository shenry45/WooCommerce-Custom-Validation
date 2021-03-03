<?php

    add_action( 'woocommerce_after_checkout_validation', 'wc_cust_validate', 10, 2);
    
    function wc_cust_validate( $fields, $errors ){
        // $user_values = get_option( 'wc_cust_val_blacklist', array('') );
        $filter = get_option( 'wc_cust_val_blacklist', '' );
        $notice = get_option( 'wc_cust_val_notice', 'One of your fields triggered our firewall!' );

        $entry = strtolower( $filter );

        foreach ($fields as $field) {
            // convert to string and lowercase
            $field = strval( $field );
            $field = strtolower( $field );

            if ( strpos( $field, $entry ) > -1 ) {
                $errors->add( 'validation', $notice );
            }
        }

        // for each filter added, check if filter value found in a field
        // foreach ($user_values as $entry) {
        //     echo $entry;

        //     $entry = strtolower( $entry );

        //     foreach ($fields as $field) {
        //         // convert to string and lowercase
        //         $field = strval( $field );
        //         $field = strtolower( $field );

        //         if ( strpos( $field, $entry ) > -1 ) {
        //             $errors->add( 'validation', $notice );
        //         }
        //     }
        // }
    }

?>