(function($) {

	jQuery('.prk-tracking-from form').on('submit', function() {
		var OrderNumber = jQuery('.prk-tracking-form-field input#order_number').val();
		var PhoneNumber = jQuery('.prk-tracking-form-field input#phone').val();
		var cbwctNonce = jQuery('.prk-tracking-form-field input#_wpnonce').val();

		jQuery.ajax({
			type: 'post',
			url:parskala_values.ajax_url,
			data: {
				action:'prk_wc_order_tracking_result',
				order_number:OrderNumber,
				phone_number:PhoneNumber,
				Ali_nonce:cbwctNonce,
			},
			beforeSend:function() {
				jQuery(".onliner_main_loading").css("display", "block");
			},
			success: function(data) {
				jQuery('.prk-traking-form-result').html(data);
				jQuery(".onliner_main_loading").css("display", "none");
			}
		});

		return false;
	});

})(jQuery);
