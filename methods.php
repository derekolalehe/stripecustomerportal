<?php

function create_customer_portal_session(){

    global $wpdb;

    $userID = get_current_user_id();

    $stripe_customerID = get_user_meta( $userID, $wpdb->prefix . '_stripe_customer_id', true );

    if( $stripe_customerID != false && $stripe_customerID != '' ){
    
        \Stripe\Stripe::setApiKey( get_option( 'stripe_api_key' ) );

        // Authenticate your user.
        $session = \Stripe\BillingPortal\Session::create([
        'customer' => $stripe_customerID,
        'return_url' => home_url(),
        ]);

        // Redirect to the customer portal.
        header("Location: " . $session->url);
        exit();
    }
    else {

        // Redirect to the custome location.
        header("Location: " . get_option( 'no_customer_id_redirect' ));
        exit();
        
    }

}

?>