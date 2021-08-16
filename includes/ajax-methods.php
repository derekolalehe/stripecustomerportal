<?php

include( 'class-country-data.php' );
include( 'class-connection.php' );
include( 'class-create-customer.php' );

function process_order_as_magento (){

    $MGConnection = new MGConnection();

    $userEmail = $MGConnection->$userEmail;
    $adminToken = $MGConnection->getToken();

    // Create/Login Customer
    $CustomerCreation = new CreateCustomer();

    $CustomerCreation->$emailAddress = $userEmail;
    $CustomerCreation->$administrationToken = $adminToken;

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


        }

    }

    

    // Add Items To Cart

    // Prepare For Checkout

    // Create An Order

    // Create An Invoice

    // Create A Shipment

}

?>