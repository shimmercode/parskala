
// jQuery(document).ready(function ($) {
//     $('#convert-point-btn').on('click', function () {
//         const amount = parseInt($('#convert-points-input').val());
//         $.ajax({
//             type: 'POST',
//             url: prk_ajax_data.ajax_url,
//             data: {
//                 action: 'prk_convert_points_to_coupon',
//                 nonce: prk_ajax_data.nonce,
//                 amount: amount
//             },
//             success: function (res) {
//                 $('#convert-point-result').html(res.message);
//                 $('#prk-coupon-history').html(res.history);
//             },
//             error: function () {
//                 $('#convert-point-result').html('❌ خطایی رخ داده است.');
//             }
//         });
//     });
// });