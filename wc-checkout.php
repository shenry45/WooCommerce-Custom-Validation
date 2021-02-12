<?php

    add_action( 'woocommerce_after_checkout_validation', 'misha_validate_fname_lname', 10, 2);
    
    function misha_validate_fname_lname( $fields, $errors ){
        $user_values = array('Tacos', 'bbb', 'a@a.com');

        // for each filter added, check if filter value found in a field
        foreach ($user_values as $entry) {
            $entry = strtolower( $entry );

            foreach ($fields as $field) {
                // convert to string and lowercase
                $field = strval( $field );
                $field = strtolower( $field );

                if ( strpos( $field, $entry ) > -1 ) {
                    $errors->add( 'validation', "One of your fields triggered our firewall! Try again :3" );
                }
            }
        }
    }

?>