<?php

// افزودن جدول اطلاعات ارسال در صفحه سفارش ووکامرس
add_action('add_meta_boxes', 'send_order_add_box');

function send_order_add_box() {
    add_meta_box('prk-send-box', __('زمان ارسال سفارش', 'prk-send'), 'prk_send_create_box_order_page', 'shop_order', 'side', 'default');
}

function prk_send_create_box_order_page(){
  global $post_id;
  $days_send = get_post_meta($post_id,'order_time_send', true);
  $times_send = get_post_meta($post_id,'order_timer_send', true);
  if ($days_send){
    echo '<span><i class="ri-mail-send-line"></i>'.$days_send.'</span>';
  }else {
    echo '<span>کاربر تاریخ ارسالی تعیین نکرده است !</span>';
  }
  if ($times_send){
    echo '<span><i class="ri-map-pin-time-line"></i>'.$times_send.'</span>';
  }else {
    echo '<spanمشتری زمان ارسال را تعیین نکرده است !</span>';
  }

}
