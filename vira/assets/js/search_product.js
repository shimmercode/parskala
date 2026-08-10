var access_do_ajax = true;
function ajax_search(){

    var length_text = jQuery('.prk_input_serach').val().length;
    if ( length_text >= 1) {
        jQuery('.prk_close_search_result').show();

    }else {
        jQuery('.prk_close_search_result').hide();
        jQuery('#submit_search i').show();
    }
    if ( length_text >= 4 && access_do_ajax ) {

        access_do_ajax = false;

        jQuery('.main_results_ajax_search').show(0);
        // var productCat = jQuery('.form_search #productcat');
        jQuery.ajax({
            type: "GET",
            url: parskala_values.ajax_url ,
            data:  {
            action: 'ajax_search_onliner',
            product_cat: jQuery('.form_search #searchform_cat').find(":selected").val(),
            s: jQuery('.prk_input_serach').val(),
            post_type: 'product'
            },
            success: function(msg){
            jQuery('.search_image').hide(150);
            jQuery('.main_results_ajax_search').show(0);
            jQuery('.main_results_ajax_search .products_resulter').html(msg);

            access_do_ajax = true;
            console.log('SEARCH SUCCESS!');
            }
        });

    } else {

        jQuery('.search_image').show(100);
        jQuery('.main_results_ajax_search .products_resulter').html('');

    }

}

jQuery('.prk_close_search_result').on('click',function(){
    jQuery('.prk_close_search_result').hide();
    jQuery('.search_image').show(100);
    jQuery('.main_results_ajax_search .products_resulter').html('');
    jQuery('#txt_search').val('');
    jQuery('#submit_search i').show();
    // jQuery(".form_search #searchform_cat").removeAttr("selected");
    jQuery('.form_search #searchform_cat option').removeAttr("selected");

  });

  jQuery('.form_search #searchform_cat').on('click',function(){
    jQuery('.prk_close_search_result').hide();
    jQuery('.search_image').show(100);
    jQuery('.main_results_ajax_search .products_resulter').html('');
    jQuery('#txt_search').val('');
    jQuery('#submit_search i').show();
    

  });


  
/**

** prk search box

*/

jQuery(".desktop.search-section .prk_input_serach").click(function (e) {
    e.stopPropagation();
      jQuery(".main_results_ajax_search").fadeIn(100);
      jQuery('.blacki').addClass('activ');
      jQuery('.search-section').addClass('active');
      jQuery('.search-section input').addClass('active');
      jQuery('.search-box').addClass('active_full');
      jQuery('.form_search #submit_search').addClass('active');
      jQuery(".search-box").css("top", "0");
  });
  
  jQuery(document).click(function (e) {
    if (!jQuery(e.target).closest(".search-section").length) {
        jQuery(".main_results_ajax_search").fadeOut(100);
        jQuery('.blacki').removeClass('activ');
        jQuery('.search-section').removeClass('active');
        jQuery('.search-section input').removeClass('active');
        jQuery('.search-box').removeClass('active_full');
        jQuery('.form_search #submit_search').removeClass('active');
        jQuery("#submit_search i").show();
    }
  });
  
  jQuery('.prk_close_search_box').on('click',function(){
      jQuery(".main_results_ajax_search").hide();
      jQuery('body').removeClass('hidden_scroll');
      jQuery('.blacki').removeClass('activ');
      jQuery('.search-section').removeClass('active');
      jQuery('.search-section input').removeClass('active');
      jQuery('.search-box').removeClass('active_full');
      jQuery('.form_search #submit_search').removeClass('active');
      jQuery('.main_results_ajax_search .products_resulter').html('');
      jQuery('#txt_search').val('');
      jQuery(".search-box").css("top", "100%");
      jQuery("#submit_search i").show();
  });
  
  