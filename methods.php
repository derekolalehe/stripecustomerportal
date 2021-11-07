<?php

function create_customer_portal_session(){

    $userID = get_current_user_id();

    $stripe_customerID = get_user_meta( $userID, 'wp__stripe_customer_id', true );
    
    \Stripe\Stripe::setApiKey( 'sk_test_quJXFb8Cq66QT30tzjMeZojh00Uy7y1nMQ' );//( get_option( 'stripe_api_key' ) );

    // Authenticate your user.
    $session = \Stripe\BillingPortal\Session::create([
    'customer' => 'cus_KYOfCBUP2FPX2t',
    'return_url' => home_url(),
    ]);

    // Redirect to the customer portal.
    header("Location: " . $session->url);
    exit();

}

?>