<?php

// فرم پاپ آپ ورود پارس کالا
$form_login = prk_option('chose_form_login');



if (! is_user_logged_in() && ! is_account_page()) {

  if ($form_login == 'sms_form') {

  	get_template_part('inc/template/footer/sms_form');

  }
  else {

  	get_template_part('inc/template/footer/default_form');

  }

}

?>
