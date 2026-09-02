/**
 * Vira Theme Core JavaScript Handlers & AJAX Engine
 *
 * @package Vira
 * @since   1.0.0
 */

(function($) {
    'use strict';

    window.Vira = {
        init: function() {
            this.initPersianDigits();
            this.initLocationSelector();
            this.initStickyPurchaseBar();
        },

        initPersianDigits: function() {
            // Convert numbers in specific price elements to Persian digits if needed
            $('.vira-persian-num').each(function() {
                var txt = $(this).text();
                var fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                txt = txt.replace(/[0-9]/g, function(w) { return fa[+w]; });
                $(this).text(txt);
            });
        },

        initLocationSelector: function() {
            $(document).on('click', '.js-open-location-modal', function(e) {
                e.preventDefault();
                $('#vira-location-modal').addClass('active');
            });
        },

        initStickyPurchaseBar: function() {
            var $bar = $('.vira-sticky-purchase-bar');
            if ( ! $bar.length ) return;

            var $mainBtn = $('.single_add_to_cart_button').first();
            if ( ! $mainBtn.length ) return;

            $(window).on('scroll', function() {
                var offset = $mainBtn.offset().top + $mainBtn.outerHeight();
                if ( $(window).scrollTop() > offset ) {
                    $bar.addClass('visible');
                } else {
                    $bar.removeClass('visible');
                }
            });

            $(document).on('click', '.vira-sticky-add-btn', function(e) {
                e.preventDefault();
                $mainBtn.trigger('click');
            });
        }
    };

    $(document).ready(function() {
        Vira.init();
    });

})(jQuery);


