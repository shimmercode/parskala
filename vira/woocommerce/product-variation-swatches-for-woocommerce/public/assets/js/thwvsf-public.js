var thwvsf_public_base = (function($, window, document) {
	'use strict';
	
	
	function isEmpty(val){
		return (val === undefined || val == null || val.length <= 0) ? true : false;
	}
	
	/********************************************
	***** CHARACTER COUNT FUNCTIONS - START *****
	********************************************/
	function display_char_count(elm, isCount){
		var fid = elm.prop('id');
        var len = elm.val().length;
		var displayElm = $('#'+fid+"-char-count");
		
		if(isCount){
			displayElm.text('('+len+' characters)');
		}else{
			var maxLen = elm.prop('maxlength');
			var left = maxLen-len;
			displayElm.text('('+left+' characters left)');
			if(rem < 0){
				displayElm.css('color', 'red');
			}
		}
	}
    /******************************************
	***** CHARACTER COUNT FUNCTIONS - END *****
	******************************************/
	
	function set_field_value_by_elm(elm, type, value){
		switch(type){
			case 'radio':
				elm.val([value]);
				break;
			case 'checkbox':
				if(elm.data('multiple') == 1){
					value = value ? value : [];
					elm.val([value]);
				}else{
					console.log(value);
					elm.val([value]);
				}
				break;
			case 'select':
				if(elm.prop('multiple')){
					elm.val(value);
				}else{
					elm.val([value]);
				}
				break;
			case 'country':
				elm.val([value]).change();
				break;
			case 'state':
				elm.val([value]).change();
				break;
			case 'multiselect':
			
				if(elm.prop('multiple')){
					if(typeof(value) != "undefined"){
						elm.val(value.split(',')).change();
					}
				}else{
					elm.val([value]);
				}
				break;
			default:
				elm.val(value);
				break;
		}
	}
	
	function get_field_value(type, elm, name){
		var value = '';
		switch(type){
			case 'radio':
				value = $("input[type=radio][name="+name+"]:checked").val();
				break;
			case 'checkbox':
				if(elm.data('multiple') == 1){
					var valueArr = [];
					$("input[type=checkbox][name='"+name+"[]']:checked").each(function(){
					   valueArr.push($(this).val());
					});
					value = valueArr;//.toString();
				}else{
					value = $("input[type=checkbox][name="+name+"]:checked").val();
				}
				break;
			case 'select':
				value = elm.val();
				break;
			case 'multiselect':
				value = elm.val();
				break;
			default:
				value = elm.val();
				break;
		}
		return value;
	}
	
	return {
		
		display_char_count : display_char_count,
		set_field_value_by_elm : set_field_value_by_elm,
		get_field_value : get_field_value,
	};
}(window.jQuery, window, document));

var thwvsf_public = (function($){
	'use strict';
	
	function initialize_thwvsf(){

		var enable_stock_alert = thwvsf_public_var.enable_stock_alert,
			min_value_stock = thwvsf_public_var.min_value_stock,
			clear_on_reselect = thwvsf_public_var.clear_on_reselect,
			out_of_stock = thwvsf_public_var.out_of_stock;
			//show_item_on_label = thwvsf_public_var.show_item_on_label;

			var swatches_form = function( $form ) {
				var self = this;

				self.$form                = $form;
				this.variationData        = $form.data( 'product_variations' );
				this.$attributeFields     = $form.find( '.variations select' );
				self.$singleVariation     = $form.find( '.single_variation' );
				self.$singleVariationWrap = $form.find( '.single_variation_wrap' );

				$form.on( 'click.thwvsf_variation_form', '.thwvsf-checkbox', { swatches_form : this }, this.onselect );
				$form.on( 'check_variations.thwvsf_variation_form', { swatches_form : this }, this.onFindVariation );

				$form.on(
					'woocommerce_update_variation_values.thwvsf_variation_form woocommerce_variation_has_changed.thwvsf_variation_form found_variation.thwvsf_variation_form reset_data.thwvsf_variation_form',
					{ swatches_form: this },
					this.onFindVariation
				);

				$form.on( 'click.thwvsf_variation_form', '.reset_variations', { swatches_form: this }, this.onReset );

				setTimeout(function () {
					refreshSwatchesState(self);
				}, 50);

				setTimeout(function () {
					refreshSwatchesState(self);
				}, 300);
			};

		swatches_form.prototype.onReset = function( event ) {

			var form = event.data.swatches_form;
			var $clickedItem = $(this);

			if ($clickedItem.hasClass('deactive') || $clickedItem.hasClass('out_of_stock')) {
				event.preventDefault();
				return false;
			}

			$('.thwvsf_fields .thwvsf-checkbox').removeClass( 'thwvsf-selected' );
			$('.thwvsf_fields > span').removeClass( 'selected' );
			$('.thwvsf_fields .thwvsf-checkbox').removeClass( 'deactive');
			$('.thwvsf_fields .thwvsf-checkbox').removeClass( 'out_of_stock');
			$('.thwvsf-rad').attr('checked',false);
			$('.thwvsf-rad-li > label').removeClass( 'thwvsf-selected' );
			var $element = $( this );
			
			var $button = $element.parents('.variations_form').siblings('.thwvsf_add_to_cart_button');	
			active_and_deactive_variation(form);
			disable_out_of_stock_variation(form);			
		};

		swatches_form.prototype.onselect = function( event ) {
			
			var form = event.data.swatches_form;
			var $element = $( this ),
				$select = $element.closest( '.thwvsf_fields' ).find( 'select' ),
				attribute_name = $select.data( 'attribute_name' ) || $select.attr( 'name' ),
				value = $element.data( 'value' ),
				clicked = attribute_name;
			selected.push(attribute_name);

			if ( ! $select.find( 'option[value="' + value + '"]' ).length ) {
				$element.siblings( '.thwvsf-checkbox' ).removeClass( 'thwvsf-selected' );
				$select.val( '' ).change();
				alert('No combination');
				return false;
			}

			if ( $element.hasClass('thwvsf-selected') ) {
				if(clear_on_reselect != 'yes'){
					return false;
				}

				$select.val( '' );
				$element.removeClass('thwvsf-selected');
			} else {
				$element.addClass('thwvsf-selected').siblings('.thwvsf-selected').removeClass('thwvsf-selected');
				$select.val( value );
			}

			$select.change();

			if(  $("BODY.post-type-archive").length > 0){
				// shop_page_add_to_cart_funtion(form);
			}

			active_and_deactive_variation(form);
			disable_out_of_stock_variation(form);

			/*if(show_item_on_label == 'yes'){
				show_selected_attribute_item($element);
			}*/	
			
		}

		swatches_form.prototype.onselectradio = function( event ) {

			var form = event.data.swatches_form;
			var $element = $( this ),
				$select = $element.closest( '.thwvsf_fields' ).find( 'select' ),
				attribute_name = $select.data( 'attribute_name' ) || $select.attr( 'name' ),
				value = $element.data( 'value' );
			clicked = attribute_name;
			selected.push(attribute_name);	
			
			$select.val( value );
			$select.change();
			
		}

		function escCss(sel){
		if ($.escapeSelector) return $.escapeSelector(sel);
		return String(sel).replace(/([ !"#$%&'()*+,./:;<=>?@[\\\]^`{|}~])/g,'\\$1');
		}

		function getSwatchItems(form, attrName) {
			return form.$form.find('.thwvsf-checkbox').filter(function () {
				return String($(this).attr('data-attribute_name')) === String(attrName);
			});
		}

		function getSwatchItem(form, attrName, attrValue) {
			return getSwatchItems(form, attrName).filter(function () {
				return String($(this).attr('data-value')) === String(attrValue);
			});
		}

		function refreshSwatchesState(form) {
			active_and_deactive_variation(form);
			disable_out_of_stock_variation(form);
		}

		function active_and_deactive_variation(form) {

			var $attributeFields = form.$attributeFields;

			$attributeFields.each(function (index, el) {

				var current_attr_select = $(el),
					current_attr_name = current_attr_select.data('attribute_name') || current_attr_select.attr('name');

				var $current_attr = getSwatchItems(form, current_attr_name);

				$current_attr.addClass('deactive');

				current_attr_select.children('option').each(function (i, option) {
					var opt_val = option.value;

					if (opt_val !== '') {
						getSwatchItem(form, current_attr_name, opt_val).removeClass('deactive');
					}
				});
			});
		}

		function disable_out_of_stock_variation(form){
			var attributeFields = form.$attributeFields;
		
			if(attributeFields.length == 1){
				var variations  = form.variationData || [];

				for ( var i = 0; i < variations.length; i++ ) {
					var variation = variations[i] || {};
					var variation_attributes = variation.attributes || {};

					var attribute_key = Object.keys(variation_attributes);
					var attr_item_name = attribute_key[0];

					if (!attr_item_name) {
						continue;
					}

					var attribute_value = variation_attributes[attr_item_name];

					if (attribute_value === undefined || attribute_value === null || attribute_value === '') {
						continue;
					}
	 
					var is_in_stock = variation.is_in_stock;
					var $swatchItem = getSwatchItem(form, attr_item_name, attribute_value);

					if (!$swatchItem.length) {
						continue;
					}

					if (!is_in_stock && out_of_stock != 'default') {
						$swatchItem.addClass('out_of_stock');
						$swatchItem.trigger('out_of_stock', [is_in_stock, attr_item_name]);
					} else {
						$swatchItem.removeClass('out_of_stock');
					}
				}
			}else{
				disable_out_of_stock_variation_multiple(form, attributeFields);
			}
		}
		function disable_out_of_stock_variation_multiple(form, attributeFields){
			var total_attributes = attributeFields.length;

			var count = 0;
			var selected_terms = [];
			var selected_term_names = [];

			// Configure selected attributes
			attributeFields.each(function(index, element){
				var current_attr_select     = $(this);
				var current_attr_name       = current_attr_select.data( 'attribute_name' ) || current_attr_select.attr( 'name' );
				var selected_attribute_val =  current_attr_select.val();

				if(selected_attribute_val != ''){
					count = ++count;
					selected_terms[current_attr_name] = selected_attribute_val;
					selected_term_names[count] = current_attr_name;  
				}
			});

			// Remove out_of_stock for no selected terms
			if(count == 0  || count < total_attributes-1){
				$('.thwvsf_fields .thwvsf-checkbox').removeClass( 'out_of_stock');
			}
			// Total variation
			var variations  = form.variationData;
			// Check the last item is remaining to select.
			if(count == total_attributes-1){

				// Itrate on each variations
				for ( var i = 0; i < variations.length; i++ ) {

					// Assign each variation
					var variation = variations[i];
					var variation_attributes = variation.attributes;

					var q = 0;
					$.each(variation_attributes, function(attr_item_name, attribute_value){

						// Check selected variation and avaialble varaiton are same
						if(variation_attributes[attr_item_name] == selected_terms[attr_item_name]){
							++q;

							// Check for last item is iterating
							if(q == total_attributes-1){

								// Again taking the current variation which is to be shown in the page.
								var current_variation = variation;
								var current_attributes = current_variation.attributes;

								for (var current_attr_name in current_attributes){
									if(jQuery.inArray(current_attr_name,selected_term_names) == -1){

										var current_attr_val = variation_attributes[current_attr_name];
										var attr_item_name_class = current_attr_name.replace(/[^a-z0-9_-]/gi, "");
										var attribute_value_class = current_attr_val.replace(/[^a-z0-9_-]/gi, "");

										var is_in_stock = variation.is_in_stock;
										var $swatchItem = getSwatchItem(form, current_attr_name, current_attr_val);

										if (!is_in_stock && out_of_stock != 'default') {
											$swatchItem.addClass('out_of_stock');
											$swatchItem.trigger('out_of_stock', [is_in_stock, current_attr_name]);
										} else {
											$swatchItem.removeClass('out_of_stock');
										}

									}
								}
							}
						}
					});
				}
			}
		}
		
		$.fn.wc_set_variation_attr = function( attr, value ) {
			if ( undefined === this.attr( 'data-o_' + attr ) ) {
				this.attr( 'data-o_' + attr, ( ! this.attr( attr ) ) ? '' : this.attr( attr ) );
			}
			if ( false === value ) {
				this.removeAttr( attr );
			} else {
				this.attr( attr, value );
			}
		};

		swatches_form.prototype.onFindVariation = function( event ) {
			
			var form = event.data.swatches_form;
			
			var $attributeFields = form.$attributeFields;

			
			active_and_deactive_variation(form);
			disable_out_of_stock_variation(form);
		}

		$.fn.thwvsf_variation_form = function() {
			
			new swatches_form( this );
			
			return this;
		};

		$(function() {
			if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
				$( '.variations_form' ).each( function() {
					
					$( this ).thwvsf_variation_form();
				});
			}
		});
			
		var clicked = null,
			selected = [];
	}

	/*function show_selected_attribute_item(elm){

		var default_label = elm.closest('tr').find('.label').find('label'),
			new_label_text = elm.data('new-label');

		default_label.text(new_label_text);
	}*/

	function remove_selected_attribute_item($element){

		var default_label = $element.closest('tr').find('.thwvsf-wrapper-ul').data('default-label');
		$element.closest('tr').find('label').text(default_label);
		var attrbute_uls = $element.closest('tr').siblings('tr');

		attrbute_uls.each( function( index, el ) {

			var elm = $(el),
				default_label = elm.find('.thwvsf-wrapper-ul').data('default-label');
			
			elm.find('label').text(default_label);
		});
	}

 	initialize_thwvsf(), "flatsome" == thwvsf_public_var.is_quick_view ? $(document).on("mfpOpen", function() {
        initialize_thwvsf()
    }) : "yith" == thwvsf_public_var.is_quick_view && $(document).on("qv_loader_stop", function() {
        initialize_thwvsf()
    })

    $(document).on('click', '.owp-quick-view', function(e) {
		var check = function(){
	    	var html = $('html');
	      	if(html.hasClass('owp-qv-open')){
	        	init_thwvsf();
	      	}else {
	        	setTimeout(check, 1000);
	      	}
	    }
	    check();
	});

    return {
		initialize_thwvsf : initialize_thwvsf,
	};

})(jQuery);

function init_thwvsf(){
	thwvsf_public.initialize_thwvsf();
}

