// ajax reload url shop page
jQuery(document).on( 'click', '.woocommerce-pagination a.page-numbers,.widget_layered_nav_filters a,.wc-layered-nav-rating a,.prk-order-products li a, .woocommerce-widget-layered-nav-list__item.wc-layered-nav-term a', function(event) {

	var page_link_url = jQuery(this).attr('href');
  event.preventDefault();
  jQuery(".onliner_main_loading").addClass('stm-sms-load');
    jQuery('html, body').animate({scrollTop:0},700);

    jQuery('#prk_content').load(page_link_url + ' #prk_content', function(responseTxt, statusTxt, xhr){

      jQuery(".onliner_main_loading").removeClass('stm-sms-load');
			jQuery("html").removeClass('remodal-is-locked');
      prk_product_filters();

        if(statusTxt == "success"){
		    window.history.pushState({path:page_link_url},'',page_link_url);
		    fix_price_filter();


        }
        if(statusTxt == "error"){
            alert("Error: " + xhr.status + ": " + xhr.statusText);
        }
    });
});

jQuery(document).on( 'click', '.widget_price_filter .price_slider_wrapper .button', function( event ) {
    event.preventDefault();
    var href = '';
    var t    = jQuery(this);
    var form = t.parents('form'),
    l = window.location,
    shop_uri = l.origin + l.pathname,
    is_filtered = shop_uri != l.href,
    search = l.search,
    min_price = jQuery('.price_slider_amount #min_price').val(),
    max_price = jQuery('.price_slider_amount #max_price').val(),
    regex_min = new RegExp('^min_price', 'i'),
    regex_max = new RegExp('^max_price', 'i');
    href = l.href;

    if (is_filtered == true) {
        href = prk_RemoveParameterFromUrl(href, 'min_price');
        href = prk_RemoveParameterFromUrl(href, 'max_price');
    }

    var concat = shop_uri == href  ? '?' : '&';

    href = href + concat + jQuery.param(
        {
          min_price: min_price,
          max_price: max_price
        }
    );

    jQuery('html, body').animate({scrollTop:0},700);
    jQuery(".onliner_main_loading").addClass('stm-sms-load');
    jQuery('.constiky').load(href + ' .constiky', function(responseTxt, statusTxt, xhr){
        jQuery(".onliner_main_loading").removeClass('stm-sms-load');
				jQuery("html").removeClass('remodal-is-locked');
        if(statusTxt == "success"){
          prk_product_filters();
				
		    window.history.pushState({path:href},'',href);
		    fix_price_filter();
        }
        if(statusTxt == "error"){
            alert("Error: " + xhr.status + ": " + xhr.statusText);
        }
    });
});

function prk_RemoveParameterFromUrl(url, parameter) {
    return url
    .replace(new RegExp('[?&]' + parameter + '=[^&#]*(#.*)?$'), '$1')
    .replace(new RegExp('([?&])' + parameter + '=[^&]*&'), '$1');
}

function fix_price_filter(){

    jQuery( function( $ ) {

	// woocommerce_price_slidr_params is required to continue ajax
	if ( typeof woocommerce_price_slider_params === 'undefined' ) {
		return false;
	}

	$( document.body ).bind( 'price_slider_create price_slider_slide', function( event, min, max ) {

		$( '.price_slider_amount span.from' ).html( accounting.formatMoney( min, {
			symbol:    woocommerce_price_slider_params.currency_format_symbol,
			decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
			thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
			precision: woocommerce_price_slider_params.currency_format_num_decimals,
			format:    woocommerce_price_slider_params.currency_format
		} ) );

		$( '.price_slider_amount span.to' ).html( accounting.formatMoney( max, {
			symbol:    woocommerce_price_slider_params.currency_format_symbol,
			decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
			thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
			precision: woocommerce_price_slider_params.currency_format_num_decimals,
			format:    woocommerce_price_slider_params.currency_format
		} ) );

		$( document.body ).trigger( 'price_slider_updated', [ min, max ] );
	});

	function init_price_filter() {
		$( 'input#min_price, input#max_price' ).hide();
		$( '.price_slider, .price_label' ).show();

		var min_price       = $( '.price_slider_amount #min_price' ).data( 'min' ),
			max_price         = $( '.price_slider_amount #max_price' ).data( 'max' ),
			step              = $( '.price_slider_amount' ).data( 'step' ) || 1,
			current_min_price = $( '.price_slider_amount #min_price' ).val(),
			current_max_price = $( '.price_slider_amount #max_price' ).val();

		$( '.price_slider:not(.ui-slider)' ).slider({
			range: true,
			animate: true,
			min: min_price,
			max: max_price,
			step: step,
			values: [ current_min_price, current_max_price ],
			create: function() {

				$( '.price_slider_amount #min_price' ).val( current_min_price );
				$( '.price_slider_amount #max_price' ).val( current_max_price );

				$( document.body ).trigger( 'price_slider_create', [ current_min_price, current_max_price ] );
			},
			slide: function( event, ui ) {

				$( 'input#min_price' ).val( ui.values[0] );
				$( 'input#max_price' ).val( ui.values[1] );

				$( document.body ).trigger( 'price_slider_slide', [ ui.values[0], ui.values[1] ] );
			},
			change: function( event, ui ) {

				$( document.body ).trigger( 'price_slider_change', [ ui.values[0], ui.values[1] ] );
			}
		});
	}

	init_price_filter();

	var hasSelectiveRefresh = (
		'undefined' !== typeof wp &&
		wp.customize &&
		wp.customize.selectiveRefresh &&
		wp.customize.widgetsPreview &&
		wp.customize.widgetsPreview.WidgetPartial
	);
	if ( hasSelectiveRefresh ) {
		wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function() {
			init_price_filter();
		} );
	}
});
}// end of price filter fixed
