<?php

    private $url = get_option( 'magento_domain' ) . '/rest/V1/intergration/admin/token';

    private $username = get_option( 'magento_admin_username' );
    private $password = get_option( 'magento_admin_password' );
    private $adminToken;

    class MGConnection {
        protected function getMGAdminToken (){
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_POST, 1);
        
            curl_setopt($curl, CURLOPT_URL, $this->$url);

            curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);

            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            ));

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec( $curl );
            
            if( !$result ){
                die("Connection Failure");
            } else{
                $adminToken = $result;
            }

            curl_close($curl);
    }

    protected function getToken(){
        return $adminToken;
    }
?>