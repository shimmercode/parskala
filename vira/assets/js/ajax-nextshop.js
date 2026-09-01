jQuery(document).ready(function() {
    jQuery(document).on('click', '.prk-add-to-next-shopping-list', function (e){
        e.preventDefault();
        let product_id = jQuery(this).closest('tr').children('.product-thumbnail').find('a.remove').data('product_id');

        let userlogin = document.location.href +  '/my-account'//jQuery('#redirect-to-url').text(); //
        jQuery.ajax({
            type: 'POST',
            url: vira_values.ajax_url, // where to submit the data
            data: {
                action     : 'prk_add_to_next_shopping_action', // load function hooked to: "wp_ajax_*" action hook
                product_id : product_id,           // PHP: $_POST['product_id']
                type:'add_to_next_list',
            },
            beforeSend: function (response) {
                jQuery(".onliner_main_loading").css("display", "block");
            },
            success: function (response) {
                if (response == -1){//user is not logged in , redirect to login page
                    top.location.replace(userlogin);
                }
                else {
                    location.reload();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                jQuery(".onliner_main_loading").css("display", "none");
            },

        });
    });

    jQuery(document).on('click', '.add-to-shopping-cart', function (e){
        e.preventDefault();
		jQuery(".onliner_main_loading").css("display", "block");
        let product_id = jQuery(this).data('product_id');
        jQuery.ajax({
            type: 'POST',
            url: vira_values.ajax_url, // where to submit the data
            data: {
                action     : 'prk_add_to_next_shopping_action', // load function hooked to: "wp_ajax_*" action hook
                product_id : product_id,           // PHP: $_POST['product_id']
                type : 'add_to_cart',
            },
            beforeSend: function (response) {
                jQuery(".onliner_main_loading").css("display", "block");
            },
            success: function (response) {
                // update next shopping list
                jQuery("#card-container").empty();
                jQuery("#card-container").append(response);
                jQuery(".onliner_main_loading").css("display", "none");

            },

            error: function (xhr, ajaxOptions, thrownError) {
                jQuery(".onliner_main_loading").css("display", "none");
            }
        });
    });

    jQuery(document).on('click', '.Delete-product', function (e){
        e.preventDefault();
        jQuery(".onliner_main_loading").css("display", "block");
        let product_id = jQuery(this).data('product_id');
        jQuery.ajax({
            type: 'POST',
            url: vira_values.ajax_url, // where to submit the data
            data: {
                action     : 'prk_add_to_next_shopping_action', // load function hooked to: "wp_ajax_*" action hook
                product_id : product_id,           // PHP: $_POST['product_id']
                type : 'delete_product',
            },
            beforeSend: function (response) {
                jQuery(".onliner_main_loading").css("display", "block");
            },
            success: function (response) {
                jQuery('#card-container').empty();
                jQuery('#card-container').append(response);
            },
            complete: function(){
                jQuery(".onliner_main_loading").css("display", "none");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                jQuery(".onliner_main_loading").css("display", "none");
            }
        });
    });

    jQuery(document).on('click', '#add-all-product', function (e){
        e.preventDefault();
        jQuery(".onliner_main_loading").css("display", "block");
        // let product_id = jQuery(this).data('product_id');
        jQuery.ajax({
            type: 'POST',
            url: vira_values.ajax_url, // where to submit the data
            data: {
                action     : 'prk_add_to_next_shopping_action', // load function hooked to: "wp_ajax_*" action hook
                type : 'add_all_product',
            },
            beforeSend: function (response) {
                jQuery(".onliner_main_loading").css("display", "block");
            },
            success: function (response) {
                jQuery('#card-container').empty();
                jQuery('#card-container').append(response);
                jQuery(".onliner_main_loading").css("display", "none");

            },
            error: function (xhr, ajaxOptions, thrownError) {
                jQuery(".onliner_main_loading").css("display", "none");
            }
        });
    });
});
