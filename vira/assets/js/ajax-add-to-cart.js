(function ($) {

    $(document).on('click', '.single_add_to_cart_button', function (e) {
        e.preventDefault();
        
        var $thisbutton = $(this),
            $form = $thisbutton.closest('form.cart'),
            product_id = $form.find('input[name="product_id"]').val(),
            variation_id = $form.find('input[name="variation_id"]').val() || 0, // بررسی ورژن محصول
            quantity = $form.find('input[name="quantity"]').val() || 1;

        // چک کردن چک‌باکس باندل
        var bundle_product_id = $('#bundle-product-checkbox').is(':checked') ? 2257 : null; // بررسی چک‌باکس باندل

        // ارسال درخواست Ajax به admin-ajax.php
        $.ajax({
            url: ajax_add_to_cart.url,
            type: 'POST',
            data: {
                action: 'add_to_cart',
                nonce: ajax_add_to_cart.nonce,
                product_id: product_id,
                variation_id: variation_id, // اضافه کردن آیدی ورژن محصول
                quantity: quantity,
                bundle_product_id: bundle_product_id // ارسال آیدی محصول باندل
            },
            success: function (response) {
                if (response.success) {
                    alert('محصول به سبد خرید اضافه شد');
                    
                    // بروزرسانی مینی کارت
                    $(document.body).trigger('added_to_cart');
                    
                    // درخواست برای بارگذاری محتوای جدید مینی کارت
                    $.ajax({
                        url: woocommerce_params.ajax_url,
                        type: 'GET',
                        data: {
                            action: 'woocommerce_get_refreshed_fragments'
                        },
                        success: function (response) {
                            if (response.fragments) {
                                $.each(response.fragments, function (key, value) {
                                    $(key).replaceWith(value); // جایگزینی محتوای مینی کارت با داده‌های جدید
                                });
                            }
                        }
                    });
                } else {
                    alert('خطا در افزودن محصول به سبد خرید');
                }
            }
        });

        return false; // جلوگیری از انجام عملیات پیش‌فرض
    });

})(jQuery);