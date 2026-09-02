// ajax reload url faq page
jQuery(document).on( 'click', '.main_box_ask_cats .link_ask_cats,.panel .link_of_faq_post,.content_ask_page .get_back_button,.main_result_ajax_ask_search a.result_post_search', function(event) {

		var page_link_url = jQuery(this).attr('href');
	  event.preventDefault();
	  jQuery(".onliner_main_loading").addClass('stm-sms-load');
	    jQuery('html, body').animate({scrollTop:0},700);

	    jQuery('#prk_content').load(page_link_url + ' #prk_content', function(responseTxt, statusTxt, xhr){

	      jQuery(".onliner_main_loading").removeClass('stm-sms-load');

	      prk_faq_apper();
	        if(statusTxt == "success"){
			    window.history.pushState({path:page_link_url},'',page_link_url);
	        }
	        if(statusTxt == "error"){
	            alert("Error: " + xhr.status + ": " + xhr.statusText);
	        }
	    });
	
});
