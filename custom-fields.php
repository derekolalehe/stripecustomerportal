<?php

//Custom Product Tabs
add_filter( 'woocommerce_product_data_tabs', 'custom_product_tabs' );

function custom_product_tabs( $product_data_tabs ){

    $product_data_tabs[ 'magento-sync' ] = array(
        'label'     => __( 'Magento Sync', 'woocommerce' ),
        'target'    => 'magento-sync-fileds-container', 
    );

    return $product_data_tabs;

}

//Magento Sync Tab Content
add_action( 'woocommerce_product_data_panels', 'magento_sync_tab_content' );

function magento_sync_tab_content(){

    global $post;

    ?>
    
    <div id="magento-sync-fileds-container" class="panel woocommerce_options_panel">
        <div class='options_group'>

            <p><strong>Last Synchronized: </strong>
                <span><?php echo get_post_meta( $post->ID, 'last_mg_sync', true );?></span> | 
                <span><?php echo get_post_meta( $post->ID, 'last_mg_sync_status', true );?></span>
            </p>

    <?php

    woocommerce_wp_checkbox(
        array(
            'id'            =>  '_is_mg_synched',
            'label'         =>  __( 'Sync with corresponding Magento product', 'woocommerce' ),
            'cbvalue'       =>  'no',
            'desc_tip'      =>  'true',
            'description'   =>  __( 'Check this box if this product is to undergo periodic synchronization with Magento' ),
        )
    );

}

add_action( 'woocommerce_process_product_meta_simple', 'mg_sync_save_product_custom_fields' );

add_action( 'woocommerce_process_product_meta_variable', 'mg_sync_save_product_custom_fields' );

function mg_sync_save_product_custom_fields( $post_id ){

    update_post_meta( $post_id, '_is_mg_synched', $_POST[ '_is_mg_synched' ] );

}

?>