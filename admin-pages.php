<?php

add_action( 'admin_menu', 'scp_menu_pages' );

function scp_menu_pages(){ 
    
    add_submenu_page( 'options-general.php','Stripe API', 'Stripe API','administrator',
    'scp-options','scp_options' );
    
}

function scp_options(){  

    if( isset( $_POST[ 'set-options' ] ) ){

        update_option( 'stripe_api_key', $_POST[ 'stripe_api_key' ] );

    }

?>

    <h2 style="margin-top: 60px;">Stripe API Options</h2>
    <hr/>
    <div style="height: 30px;"></div>

    <form method="POST" action="">
        <label for="stripe-api-key">Stripe API Key</label><br/>
        <input type="text" style="width: 300px;" id="stripe-api-key" name="stripe_api_key" 
        value="<?php echo get_option( 'stripe_api_key' );?>"/>
        <br/><br/>
        <button type="submit" class="button button primary" name="set-options">Set Options</button>
    </form>

<?php

}
?>