<?php

class CountryData {
    
    private $administrationToken;
    private $storeCode = get_option( 'magento_store_code' );
    private $url = get_option( 'magento_domain' ) . '/rest/V1/directory/countries';
    private $countries;

    private function __construct(){

        $this->$countries = GetAllCountriesData();

    }
        
    protected function GetAllCountriesData() {

        $curl = curl_init();

        curl_setopt( $curl, CURLOPT_GET, 1 );
       
        curl_setopt( $curl, CURLOPT_URL, $this->$url );

        curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
           'Authorization: ' . $this->$administrationToken,
           'Content-Type: application/json',
        ));

        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        
        $result = curl_exec( $curl );

        if( !$result ){
            die("Connection Failure");
        }

        curl_close($curl);

        return $result;

    }

}

?>