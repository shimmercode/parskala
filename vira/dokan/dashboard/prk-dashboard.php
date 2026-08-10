<?php
$user_id = get_current_user_id();
$profile_info = get_user_meta( $user_id, 'dokan_profile_settings', true );
$selling = get_user_meta( $user_id, 'dokan_enable_selling', true );
?>
<main id="main">
<div class="sp_panel_body">

<?php get_sidebar('dokan'); ?>

 <div class="sp_body_status">
  <div class="sp_Condition">
     <ul>
       <li class="<?php echo $status = $selling == 'yes' ? 'active' : 'reject_doc' ?>" >
         <a href="javascript:void()">
        <p>
          <?php echo __('وضعیت حساب', 'vira'); ?>
          <i class="fa fa-angle-down" aria-hidden="true"></i>
        </p>
        <span><?php echo $status = $selling == 'yes' ? __('فعال شده', 'vira') : __('غیره فعال', 'vira') ?></span>
         </a>
         <div class="sp_interactive_status_message">
           <div class="sp_interactive_status_message-fade"></div>
             <div class="sp_interactive-status__message-description">
                 <?php  __( 'شما در صف انتظار تایید توسط مدیر سایت هستید. پس از تایید اطلاع رسانی خواهد شد.', 'vira' ); ?>
                 <?= prk_option('message_disable_seller') ?>
				 <h2>
                   <a href="<?= prk_option('des_more_disable_seller') ?>" >

                  <span><?= prk_option('des_more_disable_seller_btn') ?></span>

                   </a>
                 </h2>

             </div>
         </div>
       </li>
	   <?php
	   $has_methods = $profile_info['payment']['bank'] ? true : false ;
	   ?>
       <li class="<?php if ( $has_methods ) echo 'active'; ?>" >
         <a href="<?php echo dokan_get_navigation_url( 'settings/payment' ); ?>">
        <p>
          <?php echo __('تنظیمات پرداخت', 'vira')?>
          <i class="fa fa-angle-down" aria-hidden="true"></i>
        </p>
        <span><?php echo $status = $has_methods ? __('درج شده', 'vira') : __('درج نشده', 'vira') ?></span>
        </a>
		<!--
        <div class="sp_interactive_status_message sp_interactive1">
          <div class="sp_interactive_status_message-fade"></div>
            <div class="sp_interactive-status__message-description">
               توضیحات در اینجا
                <h2>
                  <a href="#">
                 <span>بارگذاری مدارک</span>
                  </a>
                </h2>
            </div>
        </div>
		-->
       </li>
	   <!--
       <li>
         <a href="#">
        <p>
          وضعیت قرارداد
        </p>
        <span>پذیرفته شده</span>
        </a>
        <div class="sp_interactive_status_message sp_interactive2">
          <div class="sp_interactive_status_message-fade"></div>
            <div class="sp_interactive-status__message-description">
                توضیحات در اینجا
                <h2>
                  <a href="#">
                 <span>بارگذاری مدارک</span>
                  </a>
                </h2>
            </div>
        </div>
       </li>
	   -->
     </ul>
  </div>
  <div class="sp_dashboard_status">
    <ul>
      <li>
        <a <?php echo $link = $selling == 'yes' ? 'href="'.dokan_get_navigation_url( 'new-product' ).'"' : '' ; ?> >
        <p><?php echo __('افزودن محصول جدید', 'vira'); ?> <?php echo $link = $selling == 'yes' ? '' : '<span style="color:red;margin-right: 7px;"> '.__('(غیره فعال)', 'vira').' </span>' ; ?></p>
        <div class="sp_plus">
          <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
          		<path d="m492 236h-216v-216c0-11.046-8.954-20-20-20s-20 8.954-20 20v216h-216c-11.046 0-20 8.954-20 20s8.954 20 20 20h216v216c0 11.046 8.954 20 20 20s20-8.954 20-20v-216h216c11.046 0 20-8.954 20-20s-8.954-20-20-20z"/>
          </svg>
        </div>
       </a>
      </li>
      <li>
        <a href="<?php echo dokan_get_navigation_url( 'orders' ); ?>?order_status=wc-processing">
        <p><?php echo __('سفارشات در حال انجام', 'vira'); ?>
        </p>
        <span>
          <p><?php
		  $orders_counts        = dokan_count_orders( dokan_get_current_user_id() );
		  /*
		  $user_orders  = dokan()->vendor->get( $user_id )->get_orders( [
                    'customer_id' => null,
                    'status'      => 'wc-processing',
                    'paged'       => 1,
                    'limit'       => 100,
                    'date'        => NULL
                ] );
				echo count($user_orders);
				*/
				echo $orders_counts->{'wc-processing'};
		  ?></p>
          <i class="ri-arrow-left-s-line" aria-hidden="true"></i>
        </span>
       </a>
      </li>
      <li>
        <a href="<?php echo dokan_get_navigation_url( 'withdraw' ); ?>">
        <p>
          <?php echo __('موجودی', 'vira'); ?>
          <small><?php echo dokan_get_seller_balance($user_id , true); ?></small>
        </p>
        <div class="sp_plus">  <i class="prk-wallet-check"></i> </div>

       </a>
      </li>
    </ul>
  </div>
  <div class="sp_body_Management">
     <div class="sp_Inventory_stock">
        <div class="sp_header_Inventory_stock">
          <?php echo __('مدیریت موجودی انبار', 'vira'); ?>
        </div>
        <ul class="sp_body_Inventory_stock">
          <li>
            <a href="#">
              <p>
                <?php echo __('محصولات ناموجود', 'vira'); ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>
			  <?php
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'author' => $user_id,
				'tax_query' => array(
					array(
						'taxonomy' => 'product_visibility',
						'field' => 'slug',
						'terms' => 'outofstock',
					)
				),
			);
			$wp_query = new WP_Query();
			$wp_query->query( $args );
			  ?>
            <strong><?php echo $wp_query->found_posts; wp_reset_query(); ?></strong>
            </a>
          </li>
          <li>
            <a href="#">
              <p>
                <?php echo __('محصولات در حال اتمام', 'vira'); ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>
			  <?php

			$count_low_stock_amount_products = 0;
			if ( $low_stock_amount = get_option('woocommerce_notify_low_stock_amount') ){

				$args = array(
					'post_type' => 'product',
					'posts_per_page' => -1,
					'author' => $user_id,
					'meta_key'     => '_stock',
					'meta_value'   => $low_stock_amount,
					'meta_compare' => '<=',
				);
				$wp_query = new WP_Query();
				$wp_query->query( $args );

				$count_low_stock_amount_products = $wp_query->found_posts;
				wp_reset_query();
			}
			  ?>
            <strong><?php echo $count_low_stock_amount_products; ?></strong>
            </a>
          </li>
        </ul>


<div class="sp_header_Inventory_stock">
          <?php echo __('وضعیت کلی از ابتدای فعالیت', 'vira'); ?>
        </div>
        <ul class="sp_body_Inventory_stock">
          <li>
            <a href="#">
              <p>
                <?php esc_html_e( 'فروش کلی شما', 'vira' ); ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>

            <strong><?php echo wp_kses_post( wc_price(dokan_author_total_sales( $user_id ) ) ); ?></strong>
            </a>
          </li>
          <li>
            <a href="#">
              <p>
                <?php esc_html_e( 'درآمد شما', 'vira' ); ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>
            <strong><?php echo wp_kses_post( dokan_get_seller_earnings( $user_id ) ); ?></strong>
            </a>
          </li>
          <li>
            <a href="#">
              <p>
                <?php esc_html_e( 'صفحات نمایش داده شده', 'vira' ); ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>

            <strong><?php echo esc_html( dokan_number_format( esc_attr( dokan_author_pageviews($user_id) ) ) ); ?></strong>
            </a>
          </li>
          <li>
            <a href="#">
              <p>
                <?php esc_html_e( 'سفارشات معتبر', 'vira' ); ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>
            <strong><?php
			$orders_count = dokan_count_orders($user_id);
                $status = dokan_withdraw_get_active_order_status();
                $total = 0;
                foreach ( $status as $order_status ){
                    $total += $orders_count->$order_status;
                }
                echo esc_html( number_format_i18n( $total, 0 ) );
			?></strong>
            </a>
          </li>
        </ul>


     </div>
     <div class="sp_Inventory_stock">
        <div class="sp_header_Inventory_stock">
        <?php echo __('مدیریت سفارشات', 'vira'); ?>
        </div>
		<?php $orders_url = dokan_get_navigation_url( 'orders' ); ?>
        <ul class="sp_body_Inventory_stock">
          <li>
            <a href="<?php echo $orders_url; ?>">
              <p>
                <?php echo __('همه سفارشات', 'vira'); ?>
				<i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>
            <strong><?php echo  $orders_counts->total; ?></strong>
            </a>
          </li>
          <li>
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-completed' ), $orders_url ) ); ?>">
              <p>
                <?php echo __('تکمیل شده', 'vira'); ?>
				<i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>
            <strong><?php echo  $orders_counts->{'wc-completed'}; ?></strong>
            </a>
          </li>
          <li>
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-on-hold' ), $orders_url ) ); ?>">
              <p>
                <?php echo __('در انتظار پرداخت', 'vira'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>
            <strong><?php echo  $orders_counts->{'wc-on-hold'}; ?></strong>
            </a>
          </li>
          <li>
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-pending' ), $orders_url ) ); ?>">
              <p>
                <?php echo __('در انتظار بررسی', 'vira'); ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>
            <strong><?php echo  $orders_counts->{'wc-pending'}; ?></strong>
            </a>
          </li>
          <li>
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-cancelled' ), $orders_url ) ); ?>">
              <p>
                <?php echo __('لغو شده', 'vira'); ?>
				<i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>
            <strong><?php echo  $orders_counts->{'wc-cancelled'}; ?></strong>

            </a>
          </li>
          <li>
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-refunded' ), $orders_url ) ); ?>">
              <p>
                <?php echo __('سفارشات مرجوعی', 'vira'); ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>
            <strong><?php echo  $orders_counts->{'wc-refunded'}; ?></strong>
            </a>
          </li>
          <li>
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-failed' ), $orders_url ) ); ?>">
              <p>
                <?php echo __('سفارشات ناموفق', 'vira'); ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </p>
            <strong><?php echo  $orders_counts->{'wc-failed'}; ?></strong>
            </a>
          </li>
        </ul>
     </div>
     <div class="sp_Inventory_stock">
        <div class="sp_header_Inventory_stock">
        <?php echo __('وضعیت فروش ماه', 'vira'); ?> <?php echo date_i18n( 'F', false, false ); ?>
        </div>
        <ul class="sp_body_Inventory_stock">
		<?php


		use Morilog\Jalali\Jalalian;
		if( function_exists('PW') ){
			if ( PW()->get_options( 'enable_jalali_datepicker' ) == 'yes' ){

				$shamsi_date = date_i18n( 'Y-m-01', false, false );
				$jDate = Jalalian::fromFormat( 'Y-m-d', $shamsi_date );
				$start_date = date( 'Y-m-d', $jDate->toCarbon()->timestamp );
			}
		} else {
			$start_date = date( 'Y-m-01');
		}

		$items = prk_dokan_report_sales_overview( $start_date, current_time( 'mysql' ) );

		foreach($items as $key => $value)
			echo '<li><a><p>'.$key.'</p><strong>'.$value.'</strong></a></li>';

		?>

        </ul>
     </div>
  </div>

  <?php
	if( $src =  prk_option( 'dash_page_banner')['url'] ){
	?>
    <div class="sp_baner">
       <a href="<?php echo prk_option( 'dash_page_banner_banner') ?>"><img src="<?= $src; ?>"></a>
    </div>
	<?php } ?>



   <?php
  $products = dokan_count_posts( 'product', $user_id );
  $products_url = dokan_get_navigation_url('products')
  ?>

    <div class="sp_Product_management">
        <div class="sp_header_Inventory_stock">
          <?php echo __('مدیریت محصولات', 'vira'); ?>
        </div>
        <div class="sp_body_Product_management">
            <ul>
              <div>
              <a href="<?php echo esc_url( $products_url ); ?>">
              <li>
                <strong><?php echo $products->total ; ?></strong>
                <?php echo __('کالا های درج شده', 'vira'); ?>
              </li>
              </a>
              <a href="<?php echo esc_url( add_query_arg( array( 'post_status' => 'publish' ), $products_url ) ); ?>">
              <li>
                <strong><?php echo $products->publish ; ?></strong>
              <?php echo __('کالاهای تأیید شده', 'vira'); ?>
              </li>
              </a>

              <a href="<?php echo esc_url( add_query_arg( array( 'post_status' => 'pending' ), $products_url ) ); ?>">
              <li>
                <strong><?php echo $products->pending ; ?></strong>
              <?php echo __('کالاهای در انتظار تأیید', 'vira'); ?>
              </li>
              </a>
              <a href="<?php echo esc_url( add_query_arg( array( 'post_status' => 'draft' ), $products_url ) ); ?>">
              <li>
                <strong><?php echo $products->draft ; ?></strong>
              <?php echo __('پیش نویس', 'vira'); ?>
              </li>
              </a>
              </div>
            </ul>
        </div>
    </div>



 </div>
</div>

<?php if(0){ ?>
<div class="sp_panel_body2">
       <div class="sp_Records">
          <div class="sp_header_Records">
            <?php echo __('سوابق فروش', 'vira'); ?>
            <a href="#">
          <span><?php echo __('روزانه', 'vira'); ?>
            <i class="fa fa-angle-down" aria-hidden="true"></i>
          </span>
          </a>
          </div>
          <div class="sp_body_Records">
		  <?php

		if( function_exists('PW') ){
			if ( PW()->get_options( 'enable_jalali_datepicker' ) == 'yes' ){

				$shamsi_date = date_i18n( 'Y-m-01', false, false );
				$jDate = Jalalian::fromFormat( 'Y-m-d', $shamsi_date );
				$start_date = date( 'Y-m-d', $jDate->toCarbon()->timestamp );
			}
		} else {
			$start_date = date( 'Y-m-01');
		}
		$end_date   = date( 'Y-m-d', strtotime( 'midnight', current_time( 'timestamp' ) ) );

    dokan_sales_overview_chart_data( $start_date, $end_date, 'day' );
		  ?>
          </div>
       </div>
   </div>
<?php } ?>
</main>
