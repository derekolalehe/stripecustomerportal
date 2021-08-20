jQuery(document).ready(function(){

    jQuery("#process-order").click(function(){
        jQuery.ajax({
 
            type: "POST",
            url: wbw_urls.ajaxurl,
            data: {
                action: 'process_order_as_magento',
            },
            success: function(data) {  
                                
            },
            error: function(){
           
                
            }
    
        });
    });
});