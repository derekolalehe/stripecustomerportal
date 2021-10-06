<?php
    
    class MGConnection {

        private $url;

        private $username;
        private $password;       

        protected function createMGAdminToken (){

            $url = get_option( 'magento_domain' ) . '/rest/V1/intergration/admin/token';

            $username = get_option( 'magento_admin_username' );
            $password = get_option( 'magento_admin_password' );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $headers = array(
                "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $data_array =  array(
                "username"     => $this->username,
                "password"     => $this->password,
            );
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_array);
            
            $result = curl_exec( $curl );
            
            if( !$result ){
                die("Connection Failure");
            } 

            curl_close($curl);

            return $result;

        }

    }

?>