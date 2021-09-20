<?php

include( 'class-country-data.php' );
include( 'class-connection.php' );
include( 'class-create-customer.php' );
include( 'class-create-quote.php' );
include( 'class-customer-cart.php' );
 
function process_order_as_magento (){

    $MGConnection = new MGConnection();

    $userEmail = $MGConnection->userEmail;
    $adminToken = $MGConnection->getToken();

    $CreateQuote = new CreateQuote();

    // Create/Login Customer
    $CustomerCreation = new CreateCustomer();

    $CustomerCreation->emailAddress = $userEmail;
    $CustomerCreation->administrationToken = $adminToken;

    $customerExists = $CustomerCreation->isExistingMGCustomer();

    if( $customerExists ){

        // Create Quote

    }
    else {

        // Create New Customer
        $customerCreated = $CustomerCreation->createNewMGUser();

        if( $customerCreated ){

            // Get Customer Token
            $customerToken = $CustomerCreation->getCustomerToken();
            
            // Create Quote
            $customerQuote = $CreateQuote->createQuoteId($customerToken);

        }

    }

    // Add Items To Cart
    $CustomerCart = new CustomerCart();

    $CustomerCart->AddItems( $customerQuote, $customerToken );


    // Prepare For Checkout (Needed only if doing shipping. Omitted for now.)

    // Create An Order
    $CustomerCart->CreateOrder( $customerToken );

    // Create An Invoice

    // Create A Shipment (Needed only if doing shipping. Omitted for now.)

}

?>