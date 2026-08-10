<form class="stm-sms-confirm" method="post" id="authConfirm" data-phone-number="<?=$this->verify_key($key)->key_code; ?>" novalidate="novalidate">

        <div class="title-loginbox">
           <span><?=$text_title ?></span>
          </div>
          <span class="stm-change-email back-arrow">
            <i class="ri-arrow-right-line"></i>
           </span>
            <div class="stm-sms-confirm--title">
                <?=$text_title ?>
                <span class="js-otp-phone-number" id="stm-otp-phone-number"><?=$this->verify_key($key)->key_code; ?></span>
            </div>

            <div class="stm-sms-confirm--input">
                <input name="login[code]" id="stm-sms-count-confirm--code" type="text" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code"  placeholder="<?=$this->stm_dash_input();?>" class="stm-sms-confirm--code" maxlength="<?=$this->sms_count_code;?>">
            </div>



            <div class="stm-sms-confirm--bottom">
                <?php
                // اگر IP فعلی بلاک موقت است، تایمر را نشان بده
                if ( class_exists('PRK_OTP_Firewall') ) {
                    $remain_ip = PRK_OTP_Firewall::temp_remaining_current_ip();
                    if ($remain_ip > 0) {
                    echo PRK_OTP_Firewall::render_timer_html($remain_ip, 'login-limit-counter', 'شما محدود شدید تا :');
                    }
                }
                ?>

                <div class="stm-sms-confirm--timer-holder">
                    ارسال مجدد کد تا :
                    <span class="stm-sms-confirm---code-counter " id="stm-counter" data-countdown-seconds="<?=$this->verify_key($key)->expire; ?>"></span>
                </div>

                 <button type="button" class="stm-sms-confirm--retrieve" data-mode="login">
                      ارسال مجدد کد تأیید برای شما
                 </button>
            </div>
            <button type="submit" class="stm-sms-confirm--submit">
               ادامه
            </button>
        </form>
        <?php
        