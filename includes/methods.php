<?php

include( 'class-product-data.php' );

function pull_magento_products() {

    global $post;

    // Get WooCommerce products to be synced
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => '_is_mg_synched',
                'value' => 1,
                'compare' => '=',
            )
        ),
    );

    $products = get_posts( $args );

    foreach( $products as $post ){

        setup_postdata( $post );

        $notes = '';

        $sku = get_post_meta( $post->ID, '_sku', true );

        $productData = new ProductData();

        $productDetails = $productData.GetProductData( $sku );

        $titleResult = wp_update_post(
            array(
                'ID' => $post->ID,
                'post_title' => $productDetails->name;
            )
        );

        // Add code for updateing fearured image(s) if needed

        if( is_wp_error( $titleResult ) ){
            $notes .= 'Title not updated.';
        }
        else{
            $notes .= 'Title updated.';
        }

        $priceResult = update_post_meta( $post->ID, '_price', $productDetails->price );
        $priceResult = update_post_meta( $post->ID, 'regular_price', $productDetails->price );

        if( !$priceResult ){
            $notes .= 'Price update failure or price unchanged.';
        }
        else {
            $notes .= 'Price updated.';
        }

        update_post_meta( $post->ID, 'last_mg_sync', date( 'm/d/Y h:i:sa' ) );
        update_post_meta( $post->ID, 'last_mg_sync_status', $notes ) );

    }

}

?>