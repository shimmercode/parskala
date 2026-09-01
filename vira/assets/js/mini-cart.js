var _confetti_run = false;

/**
 * Init Shipping free notification
 * 
 * @param {type} $
 * @returns {undefined}
 */

function init_shipping_free_notification($, confetti) {
    if (jQuery('.nasa-total-condition').length) {
        
        var _confetti = typeof confetti !== 'undefined' ? confetti : false;
       
        if (jQuery('form.nasa-shopping-cart-form').length && jQuery('#cart-sidebar .nasa-total-condition').length) {
            jQuery('#cart-sidebar .nasa-total-condition').remove();
        }

        if (jQuery('.ns-cart-popup').length && jQuery('.ns-cart-popup').parents('.mfp-container').find('#nasa-confetti').length <=0) {
            if(jQuery('#cart-sidebar').find('#nasa-confetti').length) {
                jQuery('.ns-cart-popup').parents('.mfp-container').append('<canvas id="nasa-confetti" style="display: none;">');
            }
        }

  
        jQuery('.nasa-total-condition').each(function() {
          if (!jQuery(this).hasClass('nasa-active') ) {
  
                jQuery(this).addClass('nasa-active');
                var _per = jQuery(this).attr('data-per');
                jQuery(this).find('.nasa-subtotal-condition').css({'width': _per + '%'});
                
                if (_per >= 100) {
                    jQuery(this).parents('.nasa-total-condition-wrap').addClass('free');
                    
                    if (!_confetti_run) {
                        _confetti_run = true;
                        if (_confetti) {
                            jQuery('body').trigger('nasa_confetti_init');
                            jQuery('#nasa-confetti').each(function(){
                               jQuery('body').trigger('nasa_confetti_restart', [2500]);
                            });
                        }
                    }
                } else {
                    _confetti_run = false;
                }
          }
        });
  
    }
  
  }
  

  
  
/**
 * Fragments Refreshed
 */
jQuery('body').on('wc_fragments_refreshed', function() {
    /**
     * notification free shipping
     */
    init_shipping_free_notification($, true);
    
    if (jQuery('#cart-sidebar').length) {
      jQuery('#cart-sidebar').find('.nasa-loader').remove();
    }
  });

  
  jQuery(document).ready(function($){




     /**
     * Update Quantity mini cart
     */
     $('body').on('change', '.mini-cart-item .qty', function(e) {
        if (
            typeof woocommerce_params !== 'undefined' &&
            typeof woocommerce_params.wc_ajax_url !== 'undefined'
        ) {
            var _urlAjax = woocommerce_params .wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_quantity_mini_cart');
            var _input = $(this);
            var _wrap = $(_input).parents('.mini-cart-item');
            var _hash = $(_input).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
            var _max = parseFloat($(_input).attr('max'));
            if (!_max) {
                _max = false;
            }
            
            var _quantity = parseFloat($(_input).val());
            
            var _old_val = parseFloat($(_input).attr('data-old'));
            if (!_old_val) {
                _old_val = _quantity;
            }
            
            if (_max > 0 && _quantity > _max) {
                $(_input).val(_max);
                _quantity = _max;
            }
            
            if (_old_val !== _quantity) {
                var _confirm = true;
                
                if (_quantity <= 0) {
                    var _confirm_text = $('input[name="nasa_change_value_0"]').length ? $('input[name="nasa_change_value_0"]').val() : 'Are you sure you want to remove it?';
                    _confirm = confirm(_confirm_text);
                }
                
                if (_confirm) {
                    $.ajax({
                        url: _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        data: {
                            hash: _hash,
                            quantity: _quantity
                        },
                        beforeSend: function () {
                            if (!$(_wrap).hasClass('nasa-loading')) {
                                $(_wrap).addClass('nasa-loading');
                            }
      
                            if ($(_wrap).find('nasa-loader').length <= 0) {
                                $(_wrap).append('<div class="nasa-loader"></div>');
                            }
                        },
                        success: function (data) {
                           
                            // setTimeout(function() {
                            //     init_shipping_free_notification($, true);
                            // }, 100);
                                                    
                            if (data && data.fragments) {
      
                                $.each(data.fragments, function(key, value) {
                                    if ($(key).length) {
                                        $(key).replaceWith(value);
                                    }
                                });
      
                                // $('body').trigger('added_to_cart', [data.fragments, data.cart_hash, _input]);
                                $('body').trigger('wc_fragments_refreshed');
                                $('body').trigger('updated_data_mini_cart');
                            }
      
                            $('#cart-sidebar').find('.nasa-loader').remove();
      
                        },
                        error: function () {
                            $(document.body).trigger('wc_fragments_ajax_error');
                            $('#cart-sidebar').find('.nasa-loader').remove();
                            $('#cart-sidebar').find('.nasa-loading').removeClass('nasa-loading');
                        }
                    });
                } else {
                    $(_input).val(_old_val);
                }
            }
        }
       
        e.preventDefault();
      });


  
    // Target quantity inputs on product pages
    $('body').find('input.qty:not(.product-quantity input.qty)').each(function() {
      var min = parseFloat($(this).attr('min'));
      if (min && min > 0 && parseFloat($(this).val()) < min) {
          $(this).val(min);
      }
    });
    
    $('body').on('click', '.plus, .minus', function() {
      // Get values
      var $qty = $(this).parents('.quantity').find('.qty'),
          form = $(this).parents('.cart'),
          button_add = $(form).length ? $(form).find('.single_add_to_cart_button') : false,
          currentVal = parseFloat($qty.val()),
          max = parseFloat($qty.attr('max')),
          min = parseFloat($qty.attr('min')),
          step = $qty.attr('step');
          
      var _old_val = $qty.val();
      $qty.attr('data-old', _old_val);
          
      // Format values
      currentVal = !currentVal ? 0 : currentVal;
      max = !max ? '' : max;
      min = !min ? 0 : min;
      
      if (
          step === 'any' ||
          step === '' ||
          typeof step === 'undefined' ||
          parseFloat(step) === 'NaN'
      ) {
          step = 1;
      }
      
      // Change the value Plus
      if ($(this).hasClass('plus')) {
          if (max && (max == currentVal || currentVal > max)) {
              $qty.val(max);
              if (button_add && button_add.length) {
                  button_add.attr('data-quantity', max);
              }
          } else {
              $qty.val(currentVal + parseFloat(step));
              if (button_add && button_add.length) {
                  button_add.attr('data-quantity', currentVal + parseFloat(step));
              }
          }
      }
      
      // Change the value Minus
      else {
          if (min && (min == currentVal || currentVal < min)) {
              $qty.val(min);
              if (button_add && button_add.length) {
                  button_add.attr('data-quantity', min);
              }
          } else if (currentVal > 0) {
              $qty.val(currentVal - parseFloat(step));
              if (button_add && button_add.length) {
                  button_add.attr('data-quantity', currentVal - parseFloat(step));
              }
          }
      }
      
      // Trigger change event
      $qty.trigger('change');
    });
    
        /**
         * After remove cart item in mini cart
         */
        $('body').on('wc_fragments_loaded', function(e) {
          if ($('#cart-sidebar .nasa-minicart-items').length <= 0) {
              _confetti_run = false;
              init_shipping_free_notification($);
    
          }
          
          e.preventDefault();
        })
    
    
    
    
            /**
         * Fragments Ajax Error
         */
        var _fragments_ajax_error_callback = false;
        $('body').on('wc_fragments_ajax_error', function() {
            if (!_fragments_ajax_error_callback) {
                _fragments_ajax_error_callback = true;
    
                if ($('.widget_shopping_cart_content').find('>*').length <= 0) {
                    $('#cart-sidebar').append('<div class="nasa-loader"></div>');
                    $('body').trigger('wc_fragment_refresh');
                }
            }
        });
    
    
    
        /**
         * init shipping free notification
         */
        $('body').on('nasa_init_shipping_free_notification', function() {
            init_shipping_free_notification($);
        });
    
        $('body').on('updated_wc_div', function(e) {
          /**
           * notification free shipping
           */
          init_shipping_free_notification($, true);
          
          
          e.preventDefault();
      });
    
      $('body').on('added_to_cart', function(ev, fragments, cart_hash, _button) {
        /**
         * Close quick-view
         */
        $.magnificPopup.close();
        
        var _event_add = $('input[name="nasa-event-after-add-to-cart"]').length && $('input[name="nasa-event-after-add-to-cart"]').val() ? $('input[name="nasa-event-after-add-to-cart"]').val() : 'sidebar';
        
        /**
         * Not _button
         */
        if (typeof _button === 'undefined') {
            _event_add = 'sidebar';
        }
        
        /**
         * Only show Notice in cart or checkout page
         */
        if ($('form.woocommerce-cart-form').length || $('form.woocommerce-checkout').length) {
            _event_add = 'notice';
        }
 
       
        /**
         * Show Mini Cart Sidebar
         */
        if (_event_add === 'sidebar') {
            
            setTimeout(function() {
                
      
                
                
                if ($('#cart-sidebar').length && !$('#cart-sidebar').hasClass('nasa-active')) {
                    $('#cart-sidebar').addClass('nasa-active');
                    $('.prk_open_mini_cart ').addClass('close');
                }
                
                $('body').trigger('nasa_opened_cart_sidebar');
                
                /**
                 * notification free shipping
                 */
                init_shipping_free_notification($, true);
            }, 200);
        }
        
        /**
         * Show notice
         */
        if (_event_add === 'notice' && typeof fragments['.woocommerce-message'] !== 'undefined') {
            if ($('.nasa-close-notice').length) {
                $('.nasa-close-notice').trigger('click');
            }
            
            set_nasa_notice($, fragments['.woocommerce-message']);
            
            if (typeof _nasa_clear_added_to_cart !== 'undefined') {
                clearTimeout(_nasa_clear_added_to_cart);
            }
            
            _nasa_clear_added_to_cart = setTimeout(function() {
                if ($('.nasa-close-notice').length) {
                    $('.nasa-close-notice').trigger('click');
                }
            }, 5000);
        }
        
        ev.preventDefault();
    });
    
    
      /**
       * Removed from cart
       */
      $('body').on('removed_from_cart', function(ev, fragments, cart_hash, _button) {

      
        /**
         * notification free shipping
         */
        init_shipping_free_notification($);
                        
        ev.preventDefault();
      });
    
    
    
});


    


/**
 * Show mini Cart sidebar
 */
jQuery('body').on('click', '.cart-link', function() {
    /**
     * For Checkout Page
     */
    if (jQuery('body').hasClass('woocommerce-checkout') || jQuery('form.woocommerce-checkout').length) {
        var _href = jQuery(this).attr('href');
        window.location.href = _href;
        
        return false;
    }
    
    /**
     * For Others Page - Not Cart Page
     */
    if (!jQuery('body').hasClass('woocommerce-cart') && jQuery('form.woocommerce-cart-form').length <= 0) {
        
  
        if (jQuery('#cart-sidebar').length && !jQuery('#cart-sidebar').hasClass('nasa-active')) {
            jQuery('#cart-sidebar').addClass('nasa-active');
            jQuery('.prk_open_mini_cart ').addClass('close');
            jQuery(".navigation-overlay").fadeIn(100);
            if (jQuery('#cart-sidebar').find('input[name="nasa-mini-cart-empty-content"]').length) {
                jQuery('#cart-sidebar').append('<div class="nasa-loader"></div>');
                jQuery('body').trigger('wc_fragment_refresh');
            }
            
            /**
             * notification free shipping
             */
            else {
                init_shipping_free_notification($);
            }
        }
        
        jQuery('body').trigger('nasa_opened_cart_sidebar');
        
        if (jQuery('.nasa-close-notice').length) {
            jQuery('.nasa-close-notice').trigger('click');
        }
    }
    
    return false;
  });
  
  /**
   * Close by fog window
   */
  jQuery('body').on('click', '.prk-sidebar-close', function() {
    
    
    jQuery(".navigation-overlay").fadeOut(100);
    jQuery("html").removeClass("inner_hidden");
    if (jQuery('.prk_open_mini_cart').length) {
      jQuery(".prk_open_mini_cart").removeClass("close");
    }
    if (jQuery('.prk-static-sidebar').length) {
      jQuery('.prk-static-sidebar').removeClass('nasa-active');
    }
  
  });
  
  
  

  
  
  /**
 * notification free shipping
 */
if (jQuery('.nasa-total-condition').length) {
    setTimeout(function() {
        init_shipping_free_notification($);
    }, 1000);
}