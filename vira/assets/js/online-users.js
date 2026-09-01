jQuery(document).ready(function($) {
    function updateOnlineUsers() {
        $.post(prkOnlineUsers.ajax_url, {
            action: 'prk_get_online_users',
            product_id: prkOnlineUsers.product_id
        }, function(response) {
            if (response.success) {
                $('#prk-online-users').text(response.data.count + ' نفر در حال مشاهده این محصول هستند!');
            }
        });
    }
    
    // Update every 10 seconds
    setInterval(updateOnlineUsers, 10000);
    updateOnlineUsers(); // Initial call
});