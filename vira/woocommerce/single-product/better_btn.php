<?php

	$better_product = prk_option('better_product');

if ($better_product){
	if ( is_user_logged_in() ){
	  echo '<span class="better-btn show" data-remodal-target="modal-better" >' .__ ('Do you know a better price?','parskala'). '<i class="prk-notification-bing"></i> </span>';
	  echo '<span class="better-btn thanks">سپاسگزاریم، گزارش شما ثبت شد.</span>';
	}else{
		echo '<span class="better-btn show" data-custom-open="loginmodal" >' .__ ('Do you know a better price?','parskala'). '<i class="prk-notification-bing"></i> </span>';
	}
}
?>
