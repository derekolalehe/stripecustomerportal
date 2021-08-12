<?php

class CreateCustomer {

    private $emailAddress;
    private $administrationToken;
    private $password;    
    private $storeCode = get_option( 'magento_store_code' );
    private $url = get_option( 'magento_domain' ) . '/rest' . '/' . $storeCode . '/V1/customers/isEmailAvailable';

    private function __construct(){

        $this->$emailAddress = $userEmail;
        $this->$administrationToken = $adminToken;

    }
    
    protected function isExistingMGCustomer() {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_POST, 1);
       
        curl_setopt($curl, CURLOPT_URL, $this->$url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'Authorization: ' . $this->$administrationToken,
           'Content-Type: application/json',
        ));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        
        $data_array =  array(
                            "customerEmail"     => $this->$emailAddress,
                            "websiteId"         => $this->$websiteId,
                        );

        $result = curl_exec( $curl );

        if( !$result ){
            die("Connection Failure");
        }

        curl_close($curl);

        return $result;

    }

    protected function createNewMGUser(){

        // {
        //     "customer": {
        //       "email": "jdoe@example.com",
        //       "firstname": "Jane",
        //       "lastname": "Doe",
        //       "addresses": [
        //         {
        //           "defaultShipping": true,
        //           "defaultBilling": true,
        //           "firstname": "Jane",
        //           "lastname": "Doe",
        //           "region": {
        //             "regionCode": "NY",
        //             "region": "New York",
        //             "regionId": 43
        //           },
        //           "postcode": "10755",
        //           "street": [
        //             "123 Oak Ave"
        //           ],
        //           "city": "Purchase",
        //           "telephone": "512-555-1111",
        //           "countryId": "US"
        //         }
        //       ]
        //     },
        //     "password": "Password1"
        // }

        return '';

    }

}

?>