<?php

function create_customer_portal_session(){

    $userID = get_current_user_id();

    $stripe_customerID = get_user_meta( $userID, '', true );
    
    Stripe::setApiKey( get_option( 'stripe_api_key' ) );

    // Authenticate your user.
    $session = Session::create([
    'customer' => '{{ ' . $stripe_customerID . ' }}',
    'return_url' => home_url(),
    ]);

    // Redirect to the customer portal.
    header("Location: " . $session->url);
    exit();

}

?>