/**
 * Vira Theme Checkout & Instant Buy JavaScript Handler ([VIRA-06], [VIRA-08], [VIRA-16])
 *
 * @package Vira
 * @since   1.0.0
 */

(function($) {
    'use strict';

    window.ViraCheckout = {
        init: function() {
            this.initInstantBuy();
            this.initInstallmentCalculator();
        },

        initInstantBuy: function() {
            // [VIRA-08] Instant One-Click Express Buy Button handler
            $(document).on('click', '.vira-instant-buy-btn', function(e) {
                e.preventDefault();
                var $btn      = $(this);
                var productId = $btn.data('product-id');
                var qty       = $('input[name="quantity"]').val() || 1;

                $btn.addClass('loading').prop('disabled', true);

                $.ajax({
                    url: viraVars.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'vira_instant_buy',
                        security: viraVars.nonce,
                        product_id: productId,
                        qty: qty
                    },
                    success: function(res) {
                        if ( res.success && res.data.redirect ) {
                            window.location.href = res.data.redirect;
                        } else {
                            alert(res.data.message || 'خطا در افزودن به سبد خرید');
                            $btn.removeClass('loading').prop('disabled', false);
                        }
                    },
                    error: function() {
                        $btn.removeClass('loading').prop('disabled', false);
                    }
                });
            });
        },

        initInstallmentCalculator: function() {
            // [VIRA-06] Real-time installment calculator update when variation price changes
            $(document).on('found_variation', 'form.variations_form', function(event, variation) {
                if ( variation && variation.display_price ) {
                    $.ajax({
                        url: viraVars.ajaxUrl,
                        type: 'GET',
                        data: {
                            action: 'vira_calc_installments',
                            price: variation.display_price
                        },
                        success: function(res) {
                            if ( res.success ) {
                                $('.vira-installment-snapp-val').html(res.data.snapp_4);
                                $('.vira-installment-tara-val').html(res.data.tara_6);
                                $('.vira-installment-digi-val').html(res.data.digi_12);
                            }
                        }
                    });
                }
            });
        }
    };

    $(document).ready(function() {
        ViraCheckout.init();
    });

})(jQuery);


