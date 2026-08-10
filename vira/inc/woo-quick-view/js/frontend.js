
jQuery(document).ready(function($){


    var prev_post_title,prev_thumbnail,next_post_title,next_thumbnail;


    // //Browser resize 
    // $(window).resize(function() {
	//     var height = $('.remodal').height();
   	// 	$('#wcqv_contend .summary').css('height',height);
    //     var scrollable = document.getElementsByClassName('scrollable')[0];
    //     if(scrollable){
    //     	if ((scrollable.scrollHeight>scrollable.clientHeight) === true){
	// 	    	$('.scrollbar_bg').css('height',height);
	// 	    	$('.scrollbar_bg').show();
	// 	    }else{
	// 	    	$('.scrollbar_bg').hide();
	// 	    }
    //     }
	   
   		
  
    // });

    // //remodel js open 
    // $(document).on('opened','.remodal', function(){
    // 	$('body').css('overflow','hidden');
    // 	$('.spinner').remove();
    // });

    // //remodel js closed 
    // $(document).on('closed','.remodal', function(){
    // 	$('body').css('overflow','auto');
    // });

    //shop page button click 
    $(document).on('click', ".quick_add2cart", function() {

        var product_id = $(this).data('product-id');
		var parent_el = $(this).closest('.product-box-inner').find('.variable-cart-product .wcqv_contend');
        wcqv_get_product_details(parent_el,product_id);
		
        // $(this).append('<div class="spinner"></div>')

    });

    // //woocommerce gallery 
    // $(document).on('click','#wcqv_contend .product .images a',function(e){

   	// 	e.preventDefault();
   	// 	var img_url = $(this).attr('href');
   	// 	var img_src = $(this).find('img').attr('srcset');
 	// 	$('.woocommerce-main-image').find('img').attr('src',img_url);
 	// 	$('.woocommerce-main-image').find('img').attr('srcset',img_src);
 	// 	$('.woocommerce-main-image').closest('a').attr('href',img_url);

 	// 	$("a.zoom").prettyPhoto({
	// 		hook: 'data-rel',
	// 		social_tools: false,
	// 		theme: 'pp_woocommerce',
	// 		horizontal_padding: 20,
	// 		opacity: 0.8,
	// 		deeplinking: false
	// 	});
	// 	$("a[data-rel^='prettyPhoto']").prettyPhoto({
	// 		hook: 'data-rel',
	// 		social_tools: false,
	// 		theme: 'pp_woocommerce',
	// 		horizontal_padding: 20,
	// 		opacity: 0.8,
	// 		deeplinking: false
	// 	});

 	// });
 
     
    // //scrolling enable or not
    // $(document).on('mouseenter', "#wcqv_contend .summary", function() {
    //     var scrollable = document.getElementsByClassName('scrollable')[0];
	//     if ((scrollable.scrollHeight>scrollable.clientHeight) === true){
    //         var $scrollable = $('.scrollable'),
	// 	    $scrollbar  = $('.scrollbar'),
	// 	    H   = $scrollable.outerHeight(true),
	// 	    sH  = $scrollable[0].scrollHeight,
	// 	    sbH = H*H/sH;
		   
	// 	    $scrollbar.height(sbH).hide();

    //         $scrollable.on("scroll", function(){

	// 		    $scrollbar.css({top: $scrollable.scrollTop()/H*sbH });
	// 		});
	//     	$('.scrollbar').show();
	//     }
    // });

    // $(document).on('mouseleave', "#wcqv_contend .summary", function(scrollable) {
    //     var scrollable = document.getElementsByClassName('scrollable')[0];
	//     if ((scrollable.scrollHeight>scrollable.clientHeight) === true){

	//     	$('.scrollbar').hide();
	//     }
    // });
    
 
	// //hover previous button 
	// $(document).on('mouseenter', ".wcqv_prev", function() {
    //     if($('.wcqv_prev_title').length === 0){
	// 		$(this).append('<div class="wcqv_prev_title"><h4>'+prev_post_title+'</h4></div>');
	// 		$(this).append('<div class="wcqv_prev_thumbnail"></div>');
	// 		$('.wcqv_prev_thumbnail').html(prev_thumbnail);
			 
	//     }   
	// });

	// $(document).on('mouseleave', ".wcqv_prev", function() {
    //     if($('.wcqv_prev_title').length !== 0){
	//         $(this).removeClass('wcqv_prev_title');
	// 		$('.wcqv_prev_title').remove();
	// 		$('.wcqv_prev_thumbnail').remove();
			 
	//     }   
	// });

	// $(document).on('click', ".wcqv_prev", function() {
	    
	//     var product_id = $(this).data('data-prev-post');
	// 	wcqv_get_product_details(product_id);   
	// });

	// //hover next button 
	// $(document).on('mouseenter', ".wcqv_next", function() {
    //     if($('.wcqv_next_title').length === 0){
    //     	$(this).append('<div class="wcqv_next_thumbnail"></div>');
	// 		$(this).append('<div class="wcqv_next_title"><h4>'+next_post_title+'</h4></div>');
	// 		$('.wcqv_next_thumbnail').html(next_thumbnail);
			 
	//     }   
	// });

	// $(document).on('mouseleave', ".wcqv_next", function() {
    //     if($('.wcqv_next_title').length !== 0){
	//         $(this).removeClass('wcqv_next_title');
	// 		$('.wcqv_next_title').remove();
	// 		$('.wcqv_next_thumbnail').remove();
			 
	//     }   
	// });

	// $(document).on('click', ".wcqv_next", function() {
	    
	//     var product_id = $(this).data('data-next-post');
	// 	wcqv_get_product_details(product_id);  
	// });

$(document).on('click', ".back-to-product", function(){
	jQuery(this).parent().parent().removeAttr('style');
	jQuery(this).parent().siblings().fadeIn();
	jQuery(this).parent().parent().siblings().not('script').show();
	jQuery(this).parent().parent().parent().removeClass('disbale-hover');
})
$(document).on('click', ".quick_add2cart", function(){
	


	
})


$(document).on('click', ".quick_add2cart", function(){
	

	


	jQuery(document).find('.current-open-cart').removeAttr('style');
	jQuery(document).find('.current-open-cart .variable-cart-product').siblings().fadeIn();
	jQuery(document).find('.current-open-cart').siblings().not('script').show();
	jQuery(document).find('.parent-current-open-cart').removeClass('disbale-hover');

	jQuery(document).find('.current-open-cart').removeClass('current-open-cart');
	jQuery(document).find('.parent-current-open-cart').removeClass('parent-current-open-cart');



    if(jQuery('.info-product').find('.variable-cart-product')){
        var x = jQuery(this).parent().parent();
        x.append(x.find('.variable-cart-product'));
    }
	jQuery(this).parent().parent().parent().addClass('parent-current-open-cart');
	jQuery(this).parent().parent().addClass('current-open-cart');
    jQuery(this).parent().parent().attr('style','transform: rotateY(180deg)');
    jQuery('.quick_add2cart').not(this).parent().parent().removeAttr('style');
    jQuery('.quick_add2cart').not(this).parent().fadeIn();
	jQuery(this).parent().parent().parent().toggleClass('disbale-hover');
    jQuery(this).parent().removeAttr('style');
    jQuery(this).parent().fadeOut();
    jQuery(this).parent().parent().siblings().not('script').hide();
})

function wcqv_get_product_details(parent_element, product_id){

if(product_id !== undefined){

	        jQuery.ajax({
	        	type: 'POST',
			    url: wcqv_frontend_obj.ajaxurl, 
			    data :{
			        'action': 'wcqv_get_product',
			        'product_id':  product_id,
 
			    }, 
				beforeSend: function(){
					$(parent_element).html('');
					$('.variable-cart-product .loading').show();
				},
			    success:function(response){

	
					$('.variable-cart-product .loading').hide();
			        $(parent_element).html(response);

                    if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
			
						$( '.variations_form' ).each( function() {
							$( this ).thwvsf_variation_form();
						});
					}
                    // var prev_post_id     = $('.wcqv_prev_data').data('wcqv-prev-id');
                    // var next_post_id     = $('.wcqv_next_data').data('wcqv-next-id');
                    // prev_post_title      = $('.wcqv_prev_data').text();
                    // next_post_title      = $('.wcqv_next_data').text();
                    // var prev_src         = ($('.wcqv_prev_data>img').length !== 0)?$('.wcqv_prev_data>img').attr( 'src' ):'';
                    // var nex_src          = ($('.wcqv_next_data>img').length !== 0)?$('.wcqv_next_data>img').attr( 'src' ):'';
                    // prev_thumbnail       = '<img src = "'+ prev_src +'">';
                    // next_thumbnail       = '<img src = "'+ nex_src+'">';
      
          

              

                    // $('.wcqv_prev_title').html('<h4>'+prev_post_title+'</h4>');
                    // $('.wcqv_prev_thumbnail').html(prev_thumbnail);

                    // $('.wcqv_next').data('data-next-post',next_post_id);
                    // $('.wcqv_next_title').html('<h4>'+next_post_title+'</h4>');
                    // $('.wcqv_next_thumbnail').html(next_thumbnail);
 

                    // if( prev_post_id === ''){
                    //     $('.wcqv_prev').remove();
                    // }
                    // if(next_post_id === ''){
                    //     $('.wcqv_next').remove();
                    // }

                //   //open modal 
			    //   var inst  = $('[data-remodal-id=modal]').remodal();
			    //   var state = inst.getState();
			    //   if(state == 'closed'){
			    //   	inst.open();
			    //   }


			        // var height = $('.remodal').height();
			        // $('#wcqv_contend .summary').css('height',height);

				    //sroll
				    // var color = $('.remodal').css('background-color');

				    // $('#wcqv_contend .scrollbar_bg').css('background',color);
				    // $('#wcqv_contend .scrollbar_bg').html('<div class="scrollbar"></div>');
				  	// var height = $('.remodal').height();
			   		// $('.scrollbar_bg').css('height',height);
			   		// var scrollable = document.getElementsByClassName('scrollable')[0];
	                // if ((scrollable.scrollHeight>scrollable.clientHeight) === false){
			   		// 	$('.scrollbar_bg').hide();
			   	    // }
				    //end scroll 
			      
			    }
			});

	        
		}

}

 


});