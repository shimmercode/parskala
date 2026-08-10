<form class="stm-sms-confirm" method="post" id="authConfirm_password" data-phone-number="<?=$key?>" novalidate="novalidate">
    <div class="title-loginbox">
        <span><?=$txt_title;?></span>
    </div>
    <span class="stm-change-email back-arrow">
        <i class="ri-arrow-right-line"></i>
    </span>
    <div class="stm-sms-confirm--title">
        <?=$text_title;?>
        <span class="js-otp-phone-number" id="stm-otp-phone-number"><?=$key?></span>
    </div>

    <div class="stm-sms-confirm--input">
        <input name="login[code]" type="password" style="letter-spacing: 2px;" class="stm-sms-confirm--code">
    </div>

    <div class="stm-sms-confirm--bottom d-flex justify-content-between">
        <?=$reset_pass;?>
    </div>
    <button type="submit" class="stm-sms-confirm--submit">
        ادامه
    </button>
</form>