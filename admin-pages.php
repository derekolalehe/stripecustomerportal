<?php

add_action( 'admin_menu', 'scp_menu_pages' );

function scp_menu_pages(){ 
    
    add_submenu_page( 'options-general.php','Stripe API', 'Stripe API','administrator',
    'scp-options','scp_options' );
    
}

function scp_options(){  

    if( isset( $_POST[ 'set-options' ] ) ){

        update_option( 'stripe_api_key', $_POST[ 'stripe_api_key' ] );

        update_option( 'no_customer_id_redirect', $_POST[ 'no_customer_id_redirect' ] );
        
    }

?>

    <h2 style="margin-top: 60px;">Stripe API Keys</h2>
    <hr/>
    <div style="height: 30px;"></div>

    <form method="POST" action="">
        <label for="stripe-api-key">Stripe API Secret Key</label><br/>
        <input type="text" style="width: 300px;" id="stripe-api-key" name="stripe_api_key" 
        value="<?php echo get_option( 'stripe_api_key' );?>"/>
        <br/><br/>
        <label for="no-customer-id-redirect">Redirect URL no Stripe Customer ID</label><br/>
        <input type="text" style="width: 300px;" id="no-customer-id-redirect" name="no_customer_id_redirect" 
        value="<?php echo get_option( 'no_customer_id_redirect' );?>"/>
        <br/><br/>
        <button type="submit" class="button button primary" name="set-options">Set Options</button>
    </form>

<?php

}
?>