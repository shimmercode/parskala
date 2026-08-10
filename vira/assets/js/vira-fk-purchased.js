/* Document ready */
jQuery(document).ready(function($) {
"use strict";
    if (
        $('#ns-sale-notification-tml').length &&
        typeof ns_fkp !== 'undefined' &&
        ns_fkp &&
        typeof ns_fkp_count !== 'undefined' &&
        ns_fkp_count
    ) {
        /**
         * Boot Sale vitual
         */
        if (!$('body').hasClass('nasa-in-mobile')) {
            var kb = 0;
            
            var _intival = setInterval(function () {
                nasa_boot_sale_intival($, ns_fkp[kb]);
                kb = kb >= ns_fkp_count-1 ? 0 : kb + 1;
            }, 16000);

            $('body').on('click', '.close-noti', function () {
                clearInterval(_intival);
                $('.call_box.right_p').removeClass('prk-go-up');
                $('.ns-sale-notification').removeClass('nasa-active');
                
                kb = kb >= ns_fkp_count-1 ? 0 : kb + 1;

                _intival = setInterval(function () {
                    nasa_boot_sale_intival($, ns_fkp[kb]);
                    kb = kb >= ns_fkp_count-1 ? 0 : kb + 1;
                }, 16000);
            });
        }
    }
});
/* End Document Ready */

function nasa_boot_sale_intival($, fkb) {
    
    if ($('.ns-sale-notification').length <= 0) {

     
        $('body').append('<div class="ns-sale-notification tip-right"></div>');
        
    }
    
    if (typeof fkb !== 'undefined') {
        var _content = $('#ns-sale-notification-tml').html();

        _content = _content.replace(/{{p_name}}/g, fkb['p_name']);
        _content = _content.replace(/{{src_img}}/g, fkb['src_img']);
        _content = _content.replace(/{{customer}}/g, fkb['customer']);
        _content = _content.replace(/{{Verified}}/g, fkb['Verified']);
        _content = _content.replace(/{{p_url}}/g, fkb['p_url']);
        _content = _content.replace(/{{time_purchase}}/g, fkb['time_purchase']);

        $('.ns-sale-notification').html(_content);





        if ($(".ns-sale-notification").hasClass("tip-right")) {

            setTimeout(function () {
                $('.call_box.right_p').addClass('prk-go-up');
                $('.ns-sale-notification').addClass('nasa-active');
            }, 100);

        }else{
            
            setTimeout(function () {
                $('.ns-sale-notification').addClass('nasa-active');
            }, 100);

        }
        

        setTimeout(function () {
            $('.ns-sale-notification').removeClass('nasa-active');
            $('.call_box.right_p').removeClass('prk-go-up');
        }, 8000);
    }
}
