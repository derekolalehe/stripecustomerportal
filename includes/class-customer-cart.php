<?php

class CustomerCart {

    private $storeCode;
    private $items;
    private $addToCartURL;
    private $createOrderURL;

    private function __construct(){

        global $woocommerce;
        $items = $woocommerce->cart->get_cart();

        $this->items = $items;

        $storeCode = get_option( 'magento_store_code' );
        $items = array();
        $addToCartURL = get_option( 'magento_domain' ) . '/rest' . '/' . $storeCode . '/V1/carts/mine/items';
        $createOrderURL = get_option( 'magento_domain' ) . '/rest' . '/' . $storeCode . '/V1/carts/mine/payment-information';

    }

    protected function AddItems( $quoteID, $customerToken ){

        foreach( $this->items as $item => $values ){

            $sku = get_post_meta( $values[ 'product_id' ] , '_sku', true );
            $qty = $values[ 'quantity' ];

            $data_array = array(

                "cartItem" => array(
                    "sku" => $sku,
                    "qty" => $qty,
                    "quote_id" => $quoteID,
                )

            );

            $curl = curl_init();

            curl_setopt( $curl, CURLOPT_POST, 1 );
        
            curl_setopt( $curl, CURLOPT_URL, $this->addToCartURL );

            curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $customerToken,
            'Content-Type: application/json',
            ));

            curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );

            curl_setopt( $crl, CURLOPT_POSTFIELDS, $data_array );

            $result = curl_exec( $curl );

            if( !$result ){
                die("Connection Failure");
            }

            curl_close($curl);

            return $result;

        }

    }

    protected function CreateOrder($customerToken ){
                
        curl_setopt( $curl, CURLOPT_POST, 1 );
    
        curl_setopt( $curl, CURLOPT_URL, $this->createOrderURL );

        curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $customerToken,
        'Content-Type: application/json',
        ));

        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );

        curl_setopt( $crl, CURLOPT_POSTFIELDS, $data_array );

        $result = curl_exec( $curl );

        if( !$result ){
            die("Connection Failure");
        }

        curl_close($curl);

        return $result;

    }

}

?>