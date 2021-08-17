<?php

    private $url = get_option( 'magento_domain' ) . '/rest/V1/intergration/admin/token';

    private $username = get_option( 'magento_admin_username' );
    private $password = get_option( 'magento_admin_password' );

    class MGConnection {

        protected function createMGAdminToken (){

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->$url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $headers = array(
                "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $data_array =  array(
                "username"     => $this->$username,
                "password"     => $this->$password,
            );
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_array);
            
            $result = curl_exec( $curl );
            
            if( !$result ){
                die("Connection Failure");
            } 

            curl_close($curl);

            return $result;
    }
?>