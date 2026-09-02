
<?php
    
	//check if can login again
	if(isset($_SESSION['attempt_again'])){
		$now = time();
        $remaining_time_limit = $_SESSION['attempt_again'] - $now;
        $text_limit = "شما محدود شدید تا :";
		if($now >= $_SESSION['attempt_again']){

			unset($_SESSION['attempt']);
			unset($_SESSION['attempt_again']);
		}
	}


?>

<div id="stm-sms-form-holder">

<form method="post" id="stm-form-sms" class="login form-login" novalidate="novalidate">
  <div class="title-loginbox">
     <span>ورود / عضویت</span>
  </div>
    <p class="stm-sms-holder form-row">


        <label class="login-sms-message"><?=$login_method_text ?> خود را وارد نمایید.</label>

         <label class="phone-loginbox">

           <input name="login[email_phone]" type="text" placeholder="" value=""
              class="woocommerce-Input woocommerce-Input--text input-text form-control stm-user-type js-input-field w-100" autofocus>

        </label>
    </p>

    <div id="email_phone_error" style="display: none">شماره موبایل یا ایمیل نامعتبر است</div>

    <div>

        <?php
        // اگر IP فعلی بلاک موقت است، تایمر را نشان بده
        if ( class_exists('PRK_OTP_Firewall') ) {
            $remain_ip = PRK_OTP_Firewall::temp_remaining_current_ip();
            if ($remain_ip > 0) {
            echo PRK_OTP_Firewall::render_timer_html($remain_ip, 'login-limit-counter', 'شما محدود شدید تا :');
            }
        }
        ?>


        <button type="submit" class="stm-login-sms-btn">
            ورود / عضویت

        </button>
    </div>

</form>
<script>
  (function($){
    var el = document.getElementById('login-limit-counter');
    if (el) { limit_login_counter_timer(parseInt(el.dataset.countdownSeconds||'0',10),'login-limit-counter'); }
  })(jQuery);
</script>
</div>

