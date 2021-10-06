<?php
    class CreateQuote{
        private $administrationToken;  
        private $quoteId;
        private $storeCode;
        private $url;

       
        private function __construct(){
            
            $this->administrationToken = $adminToken;

            $storeCode = get_option( 'magento_store_code' );
            $url = get_option( 'magento_domain' ) . '/rest' . '/' . $storeCode . '/V1/carts/mine'; //URL needs to be checked
    
        }

        protected function createQuoteId($customerToken){

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, $this->url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $headers = array(
                'Authorization: ' . $customerToken ?? $this->administrationToken,
                "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
            $result = curl_exec( $curl );

            if( !$result ){
                die("Quote Creation Failure");
            } 

            curl_close($curl);

            return $result;
        }
    }
    
?>