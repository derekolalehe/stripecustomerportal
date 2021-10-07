<?php
    class ProductData{
       
        private $url;
        private $storeCode;

       
        private function __construct(){
            
            $this->administrationToken = $adminToken;

            $storeCode = get_option( 'magento_store_code' );
            $url = get_option( 'magento_domain' ) . '/rest/default/V1/stockItems/';
        }

        protected function GetProductData($productSku){
        
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, $this->url + $productSku);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $headers = array(
                'Authorization: ' . $this->administrationToken,
                'Content-Type: application/json',
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
            $result = curl_exec( $curl );

            if( !$result ){
                die("Product Retrieval Failed");
            } 

            curl_close($curl);

            return $result;
        }
    }
    
?>