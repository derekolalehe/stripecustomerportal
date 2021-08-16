<?php

class CreateCustomer {

    private $emailAddress;
    private $administrationToken;
    private $password;    
    private $storeCode = get_option( 'magento_store_code' );
    private $isEmailAvailableURL = get_option( 'magento_domain' ) . '/rest' . '/' . $storeCode . '/V1/customers/isEmailAvailable';
    private $createCustomerURL = get_option( 'magento_domain' ) . '/rest' . '/' . $storeCode . '/V1/customers';
    private $customerTokenURL = get_option( 'magento_domain' ) . '/rest' . '/' . $storeCode . '/V1/integration/customer/token';

    private function __construct(){

        $this->$emailAddress = $userEmail;
        $this->$administrationToken = $adminToken;

    }
    
    protected function isExistingMGCustomer() {

        $curl = curl_init();

        curl_setopt( $curl, CURLOPT_POST, 1 );
       
        curl_setopt( $curl, CURLOPT_URL, $this->isEmailAvailableURL );

        curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
           'Authorization: ' . $this->$administrationToken,
           'Content-Type: application/json',
        ));

        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        
        $data_array =  array(
                            "customerEmail"     => $this->$emailAddress,
                            "websiteId"         => $this->$websiteId,
                        );

        curl_setopt( $crl, CURLOPT_POSTFIELDS, $data_array );

        $result = curl_exec( $curl );

        if( !$result ){
            die("Connection Failure");
        }

        curl_close($curl);

        return $result;

    }

    protected function createNewMGUser(){

        $user = get_current_user();

        $tempPassword = wp_generate_password();

        $user_country = get_post_meta( $user->ID, 'billing_country', true )

        $countryId = '';
        $region = (object)[];

        $countries = new CountryData();

        foreach( $countries as $country ){

            if( strtolower( $country->full_name_english ) == strtolower( $user_country ) ){

                $countryId = $country->id;

                $region = $country->available_regions[0];

            }

        }

        $new_customer_data = array(

            "customer" => array(
                "email" => $user->user_email,
                "firstname" => $user->user_firstname,
                "lastname" => $user->user_lastname,
                "addresses" => array (
                    "defaultShipping": true,
                    "defaultBilling": true,
                    "firstname": $user->user_firstname,
                    "lastname": $user->user_lastname,
                    "region" => array(
                        "regionCode" => $region->code,
                        "region" => $region->name,
                        "regionId" => $region->id,
                    ),
                    "postcode" => get_post_meta( $user->ID, 'billing_postcode', true ),
                    "street" => array(
                        get_post_meta( $user->ID, 'billing_address_1', true )
                    ),
                    "city" => get_post_meta( $user->ID, 'billing_city', true ),
                    "telephone" => get_user_meta( $user->ID, 'billing_phone', true ),
                    "countryId" => $countryId,
                ), 
            ),
            "password" => $tempPassword,

        );

        $curl = curl_init();

        curl_setopt( $curl, CURLOPT_POST, 1 );
       
        curl_setopt( $curl, CURLOPT_URL, $this->$createCustomerURL );

        curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
           'Authorization: ' . $this->$administrationToken,
           'Content-Type: application/json',
        ));

        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );

        curl_setopt( $crl, CURLOPT_POSTFIELDS, $new_customer_data );

        $result = curl_exec( $curl );

        if( !$result ){
            die("Connection Failure");
        }

        curl_close($curl);

        $this->$password = $this->$password;

        return true;

    }

    protected function getCustomerToken(){

        $curl = curl_init();

        curl_setopt( $curl, CURLOPT_POST, 1 );
       
        curl_setopt( $curl, CURLOPT_URL, $this->$customerTokenURL );

        curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
        ));

        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );

        $customer_token_data =  array(
                                    "username"     => $this->$emailAddress,
                                    "password"         => $this->$password,
                                );

        curl_setopt( $crl, CURLOPT_POSTFIELDS, $customer_token_data );

        $result = curl_exec( $curl );

        if( !$result ){
            die("Connection Failure");
        }

        curl_close($curl);

        return $result;

    }

}

?>