<?php
$account_url = get_permalink( get_option('woocommerce_myaccount_page_id') );
$redirect = false;

 ?>
<div class="modal micromodal-slide" id="loginmodal" aria-hidden="true">
  <div class="modal__overlay" data-micromodal-close>
    <div  class="modal__container" style="width: 31%;max-width: 500px;">
      <!-- دکمه بستن مدال -->
      <div class="header-login">
        <span><?php esc_html_e( 'sign in to site', 'vira' ); ?></span>
        <button data-micromodal-close="modalvidoe" class="close-box"></button>
     </div>
      <div class="continer-login">
        <div class="woocommerce">
          <form class="woocommerce-form woocommerce-form-login login" method="post" action="<?php echo esc_url( $account_link ); ?>" >

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
               <label class="users" for="username"><?php esc_html_e( 'user name', 'vira' ); ?>&nbsp;<span class="required">*</span></label>
               <input placeholder="<?php esc_html_e( 'Enter your username.', 'vira' ); ?>" type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
               <label class="passwords" for="password"><?php esc_html_e( 'password', 'vira' ); ?>&nbsp;<span class="required">*</span></label>
               <a class="forgat" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
               <input placeholder="<?php esc_html_e( 'Enter your password.', 'vira' ); ?>"  class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
            </p>

            <p class="form-row">

              <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
              </label>

              <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
              <?php if ( $redirect ): ?>
                 <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
              <?php endif ?>
              <input type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_html_e( 'sign in to site', 'vira' ); ?>" />
            </p>

          </form>
        </div>
      </div>

      <div class="footer-login">
        <span><?php esc_html_e( 'Havent registered on the site before?', 'vira' ); ?></span>
        <a href="<?php echo $account_url;?>"> <?php esc_html_e( 'Register on the site', 'vira' ); ?> </a>
      </div>
    </div>
  </div>
</div>
