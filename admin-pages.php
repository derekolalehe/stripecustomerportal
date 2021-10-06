<?php

add_action( 'admin_menu', 'wpms_menu_pages' );

function wpms_menu_pages(){ 
    
    add_submenu_page( 'options-general.php','Magento Sync', 'Magento Sync','administrator',
    'wpms-options','wpms_options' );
    
}

function wpms_options(){  

    if( isset( $_POST[ 'set-options' ] ) ){

        update_option( 'magento_store_code', $_POST[ 'magento_store_code' ] );
        update_option( 'magento_domain', $_POST[ 'magento_domain' ] );
        update_option( 'magento_domain_pwd', $_POST[ 'magento_domain_pwd' ] );

    }

?>

    <h2 style="margin-top: 60px;">Magento Options</h2>
    <hr/>
    <div style="height: 30px;"></div>

    <form method="POST" action="">
        <label for="magento_domain">DOMAIN</label><br/>
        <input type="text" style="width: 300px;" id="magento_domain" name="magento_domain" 
        value="<?php echo get_option( 'magento_domain' );?>"/>
        <br/><br/>
        <label for="magento_domain_pwd">DOMAIN PASSWORD</label><br/>
        <input type="password" style="width: 300px;" id="magento_domain_pwd" name="magento_domain_pwd" 
        value="<?php echo get_option( 'magento_domain_pwd' );?>"/>
        <br/><br/>
        <label for="magento_store_code">STORE CODE</label><br/>
        <input type="text" style="width: 300px;" id="magento_store_code" name="magento_store_code" 
        value="<?php echo get_option( 'magento_store_code' );?>"/>
        <br/><br/>
        <button type="submit" class="button button primary" name="set-interval">Set Interval</button>
    </form>

    <div style="height: 30px;"></div>

<?php

}
?>