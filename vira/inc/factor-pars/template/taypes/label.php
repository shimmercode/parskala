<?php
if ($taypes == 'print_label') {
// opt settings
$pager = "A4";

$show_logo = prk_option('f_show_logo' );
$dokan_info = prk_option('dokan_info');

$web_url = get_bloginfo('url');
$factor_crater = get_post_meta( $order->get_id(), 'getmyfactor', true );
$order_number = $order->get_order_number();
$dato   = strtotime($order->get_date_created()) ;
$miladi = prk_factor_jdates("Y/m/d", $dato);

// لوگو فروشگاه
$factor_logo = $factor_titler = $order_state = $state = "";
$logo = get_parent_theme_file_uri('assets/img/logo-web.png' );
$logo_uploaded = prk_option('logo');
if(isset($logo_uploaded['url']) && $logo_uploaded['url'] != '') { $logo = $logo_uploaded['url']; }
$f_logo = prk_option('f_logo');
if(isset($f_logo['url']) && $f_logo['url'] != '') { $factor_logo = $f_logo['url']; }

if ($factor_logo) {
   $img_logo = $factor_logo;
}else {
	 $img_logo = $logo;
}










// اطلاعات استان ها
if(perchecker($order->get_billing_state()) == 1){
	$order_state = $order->get_billing_state();
   }
   
   
   
   else {
	if(is_numeric($order->get_billing_state())){
			global $wpdb;
			$getstate = $wpdb->get_row( "SELECT * FROM $wpdb->terms WHERE term_id = $order->get_billing_state()", ARRAY_A );
			$order_state = $getstate['name'];
	} else {
		if($order->get_billing_state()=='TE'){
			$order_state='تهران';
		}
		if($order->get_billing_state()=='THR'){
			$order_state='تهران';
		}
		if($order->get_billing_state()=='KZ'){
			$order_state='خوزستان';
		}
		if($order->get_billing_state()=='KHZ'){
			$order_state='خوزستان';
		}
		if($order->get_billing_state()=='AL'){
			$order_state='البرز';
		}
		if($order->get_billing_state()=='ABZ'){
			$order_state='البرز';
		}
		if($order->get_billing_state()=='Al'){
			$order_state='اردبیل';
		}
		if($order->get_billing_state()=='ADL'){
			$order_state='اردبیل';
		}
		if($order->get_billing_state()=='AE'){
			$order_state='آذربایجان شرقی';
		}
		if($order->get_billing_state()=='EAZ'){
			$order_state='آذربایجان شرقی';
		}
		if($order->get_billing_state()=='AW'){
			$order_state='آذربایجان غربی';
		}
		if($order->get_billing_state()=='WAZ'){
			$order_state='آذربایجان غربی';
		}
		if($order->get_billing_state()=='BU'){
			$order_state='بوشهر';
		}
		if($order->get_billing_state()=='BHR'){
			$order_state='بوشهر';
		}
		if($order->get_billing_state()=='CM'){
			$order_state='چهارمحال و بختیاری';
		}
		if($order->get_billing_state()=='CHB'){
			$order_state='چهارمحال و بختیاری';
		}
		if($order->get_billing_state()=='FA'){
			$order_state='فارس';
		}
		if($order->get_billing_state()=='FRS'){
			$order_state='فارس';
		}
		if($order->get_billing_state()=='GI'){
			$order_state='گیلان';
		}
		if($order->get_billing_state()=='GIL'){
			$order_state='گیلان';
		}
		if($order->get_billing_state()=='GO'){
			$order_state='گلستان';
		}
		if($order->get_billing_state()=='GLS'){
			$order_state='گلستان';
		}
		if($order->get_billing_state()=='HD'){
			$order_state='همدان';
		}
		if($order->get_billing_state()=='HDN'){
			$order_state='همدان';
		}
		if($order->get_billing_state()=='HG'){
			$order_state='هرمزگان';
		}
		if($order->get_billing_state()=='HRZ'){
			$order_state='هرمزگان';
		}
		if($order->get_billing_state()=='IL'){
			$order_state='ایلام';
		}
		if($order->get_billing_state()=='ILM'){
			$order_state='ایلام';
		}
		if($order->get_billing_state()=='IS'){
			$order_state='اصفهان';
		}
		if($order->get_billing_state()=='ESF'){
			$order_state='اصفهان';
		}
		if($order->get_billing_state()=='KE'){
			$order_state='کرمان';
		}
		if($order->get_billing_state()=='KRN'){
			$order_state='کرمان';
		}
		if($order->get_billing_state()=='BK'){
			$order_state='کرمانشاه';
		}
		if($order->get_billing_state()=='KRH'){
			$order_state='کرمانشاه';
		}
		if($order->get_billing_state()=='KS'){
			$order_state='خراسان شمالی';
		}
		if($order->get_billing_state()=='NKH'){
			$order_state='خراسان شمالی';
		}
		if($order->get_billing_state()=='KV'){
			$order_state='خراسان رضوی';
		}
		if($order->get_billing_state()=='RKH'){
			$order_state='خراسان رضوی';
		}
		if($order->get_billing_state()=='KJ'){
			$order_state='خراسان جنوبی';
		}
		if($order->get_billing_state()=='SKH'){
			$order_state='خراسان جنوبی';
		}
		if($order->get_billing_state()=='KB'){
			$order_state='کهگیلویه و بویراحمد';
		}
		if($order->get_billing_state()=='KBD'){
			$order_state='کهگیلویه و بویراحمد';
		}
		if($order->get_billing_state()=='KD'){
			$order_state='کردستان';
		}
		if($order->get_billing_state()=='KRD'){
			$order_state='کردستان';
		}
		if($order->get_billing_state()=='LO'){
			$order_state='لرستان';
		}
		if($order->get_billing_state()=='LRS'){
			$order_state='لرستان';
		}
		if($order->get_billing_state()=='MK'){
			$order_state='مرکزی';
		}
		if($order->get_billing_state()=='MKZ'){
			$order_state='مرکزی';
		}
		if($order->get_billing_state()=='MN'){
			$order_state='مازندران';
		}
		if($order->get_billing_state()=='MZN'){
			$order_state='مازندران';
		}
		if($order->get_billing_state()=='QZ'){
			$order_state='قزوین';
		}
		if($order->get_billing_state()=='GZN'){
			$order_state='قزوین';
		}
		if($order->get_billing_state()=='QM'){
			$order_state='قم';
		}
		if($order->get_billing_state()=='QHM'){
			$order_state='قم';
		}
		if($order->get_billing_state()=='SM'){
			$order_state='سمنان';
		}
		if($order->get_billing_state()=='SMN'){
			$order_state='سمنان';
		}
		if($order->get_billing_state()=='YA'){
			$order_state='یزد';
		}
		if($order->get_billing_state()=='YZD'){
			$order_state='یزد';
		}
		if($order->get_billing_state()=='ZA'){
			$order_state='زنجان';
		}
		if($order->get_billing_state()=='ZJN'){
			$order_state='زنجان';
		}
		if($order->get_billing_state()=='SB'){
			$order_state='سیستان و بلوچستان';
		}
		if($order->get_billing_state()=='SBN'){
			$order_state='سیستان و بلوچستان';
		}
	   }
	}
   
   
   
   // اطلاعات استان های حمل و نقل
   if(perchecker($order->get_shipping_state()) == 1){
	   $order_state = $order->get_shipping_state();
	  }
	  
	  
	  
	  else {
	   if(is_numeric($order->get_shipping_state())){
			   global $wpdb;
			   $getstate = $wpdb->get_row( "SELECT * FROM $wpdb->terms WHERE term_id = $order->get_shipping_state()", ARRAY_A );
			   $order_state = $getstate['name'];
	   } else {
		   if($order->get_shipping_state()=='TE'){
			   $order_state='تهران';
		   }
		   if($order->get_shipping_state()=='THR'){
			   $order_state='تهران';
		   }
		   if($order->get_shipping_state()=='KZ'){
			   $order_state='خوزستان';
		   }
		   if($order->get_shipping_state()=='KHZ'){
			   $order_state='خوزستان';
		   }
		   if($order->get_shipping_state()=='AL'){
			   $order_state='البرز';
		   }
		   if($order->get_shipping_state()=='ABZ'){
			   $order_state='البرز';
		   }
		   if($order->get_shipping_state()=='Al'){
			   $order_state='اردبیل';
		   }
		   if($order->get_shipping_state()=='ADL'){
			   $order_state='اردبیل';
		   }
		   if($order->get_shipping_state()=='AE'){
			   $order_state='آذربایجان شرقی';
		   }
		   if($order->get_shipping_state()=='EAZ'){
			   $order_state='آذربایجان شرقی';
		   }
		   if($order->get_shipping_state()=='AW'){
			   $order_state='آذربایجان غربی';
		   }
		   if($order->get_shipping_state()=='WAZ'){
			   $order_state='آذربایجان غربی';
		   }
		   if($order->get_shipping_state()=='BU'){
			   $order_state='بوشهر';
		   }
		   if($order->get_shipping_state()=='BHR'){
			   $order_state='بوشهر';
		   }
		   if($order->get_shipping_state()=='CM'){
			   $order_state='چهارمحال و بختیاری';
		   }
		   if($order->get_shipping_state()=='CHB'){
			   $order_state='چهارمحال و بختیاری';
		   }
		   if($order->get_shipping_state()=='FA'){
			   $order_state='فارس';
		   }
		   if($order->get_shipping_state()=='FRS'){
			   $order_state='فارس';
		   }
		   if($order->get_shipping_state()=='GI'){
			   $order_state='گیلان';
		   }
		   if($order->get_shipping_state()=='GIL'){
			   $order_state='گیلان';
		   }
		   if($order->get_shipping_state()=='GO'){
			   $order_state='گلستان';
		   }
		   if($order->get_shipping_state()=='GLS'){
			   $order_state='گلستان';
		   }
		   if($order->get_shipping_state()=='HD'){
			   $order_state='همدان';
		   }
		   if($order->get_shipping_state()=='HDN'){
			   $order_state='همدان';
		   }
		   if($order->get_shipping_state()=='HG'){
			   $order_state='هرمزگان';
		   }
		   if($order->get_shipping_state()=='HRZ'){
			   $order_state='هرمزگان';
		   }
		   if($order->get_shipping_state()=='IL'){
			   $order_state='ایلام';
		   }
		   if($order->get_shipping_state()=='ILM'){
			   $order_state='ایلام';
		   }
		   if($order->get_shipping_state()=='IS'){
			   $order_state='اصفهان';
		   }
		   if($order->get_shipping_state()=='ESF'){
			   $order_state='اصفهان';
		   }
		   if($order->get_shipping_state()=='KE'){
			   $order_state='کرمان';
		   }
		   if($order->get_shipping_state()=='KRN'){
			   $order_state='کرمان';
		   }
		   if($order->get_shipping_state()=='BK'){
			   $order_state='کرمانشاه';
		   }
		   if($order->get_shipping_state()=='KRH'){
			   $order_state='کرمانشاه';
		   }
		   if($order->get_shipping_state()=='KS'){
			   $order_state='خراسان شمالی';
		   }
		   if($order->get_shipping_state()=='NKH'){
			   $order_state='خراسان شمالی';
		   }
		   if($order->get_shipping_state()=='KV'){
			   $order_state='خراسان رضوی';
		   }
		   if($order->get_shipping_state()=='RKH'){
			   $order_state='خراسان رضوی';
		   }
		   if($order->get_shipping_state()=='KJ'){
			   $order_state='خراسان جنوبی';
		   }
		   if($order->get_shipping_state()=='SKH'){
			   $order_state='خراسان جنوبی';
		   }
		   if($order->get_shipping_state()=='KB'){
			   $order_state='کهگیلویه و بویراحمد';
		   }
		   if($order->get_shipping_state()=='KBD'){
			   $order_state='کهگیلویه و بویراحمد';
		   }
		   if($order->get_shipping_state()=='KD'){
			   $order_state='کردستان';
		   }
		   if($order->get_shipping_state()=='KRD'){
			   $order_state='کردستان';
		   }
		   if($order->get_shipping_state()=='LO'){
			   $order_state='لرستان';
		   }
		   if($order->get_shipping_state()=='LRS'){
			   $order_state='لرستان';
		   }
		   if($order->get_shipping_state()=='MK'){
			   $order_state='مرکزی';
		   }
		   if($order->get_shipping_state()=='MKZ'){
			   $order_state='مرکزی';
		   }
		   if($order->get_shipping_state()=='MN'){
			   $order_state='مازندران';
		   }
		   if($order->get_shipping_state()=='MZN'){
			   $order_state='مازندران';
		   }
		   if($order->get_shipping_state()=='QZ'){
			   $order_state='قزوین';
		   }
		   if($order->get_shipping_state()=='GZN'){
			   $order_state='قزوین';
		   }
		   if($order->get_shipping_state()=='QM'){
			   $order_state='قم';
		   }
		   if($order->get_shipping_state()=='QHM'){
			   $order_state='قم';
		   }
		   if($order->get_shipping_state()=='SM'){
			   $order_state='سمنان';
		   }
		   if($order->get_shipping_state()=='SMN'){
			   $order_state='سمنان';
		   }
		   if($order->get_shipping_state()=='YA'){
			   $order_state='یزد';
		   }
		   if($order->get_shipping_state()=='YZD'){
			   $order_state='یزد';
		   }
		   if($order->get_shipping_state()=='ZA'){
			   $order_state='زنجان';
		   }
		   if($order->get_shipping_state()=='ZJN'){
			   $order_state='زنجان';
		   }
		   if($order->get_shipping_state()=='SB'){
			   $order_state='سیستان و بلوچستان';
		   }
		   if($order->get_shipping_state()=='SBN'){
			   $order_state='سیستان و بلوچستان';
		   }
		  }
	   }











   // اطلاعات فروشنده
  // شرط: اگر فروشنده دکان باشد !
 if ($dokan_info && class_exists('WeDevs_Dokan')) {
   $vendor_id     = dokan_get_seller_id_by_order( $order->get_id());
   $vendor        = dokan()->vendor->get( $vendor_id );
   $store_info    = dokan_get_store_info($vendor_id);
   $store_name    = $vendor->get_shop_name();
   $store_email   = $vendor->get_email();
   $store_phone   = $vendor->get_phone();
   $store_address = $store_info['address']['street_1'];
   $store_city    = $store_info['address']['city'];
   $state         = $store_info['address']['state'];
   $store_zip     = $store_info['address']['zip'];

 }
  // وگرنه : متغییر های ثابت تنظیمات فاکتور را نمایش بده !
 else{
   	$store_name = prk_factor_name();
   	$state      = prk_factor_states();
   	$store_city = prk_factor_citys();
    $store_zip = prk_factor_zipcode();
    $store_email = prk_company_email();
   	$store_phone = prk_factor_number();
   	$company_code = prk_factor_company_code();
   	$codesabt = prk_factor_codesabt();
   	$store_address = prk_factor_address();
 }


 $shipping_address = $order->get_address( 'shipping' );


 $billing_first_name = $order->shipping_first_name ? $order->shipping_first_name : $order->billing_first_name;
 $billing_last_name = $order->shipping_last_name ? $order->shipping_last_name : $order->billing_last_name;
 $billing_company = $order->shipping_company ? $order->shipping_company : $order->billing_company;
 $billing_address_1 = $order->shipping_address_1 ? $order->shipping_address_1 : $order->billing_address_1;
 $billing_address_2 = $order->shipping_address_2 ? $order->shipping_address_2 : $order->billing_address_2;
 $billing_city = $order->shipping_city ? $order->shipping_city : $order->billing_city;
 $billing_state = $order->shipping_state ? $order->shipping_state : $order->billing_state;
 $billing_postcode = $order->shipping_postcode ? $order->shipping_postcode : $order->billing_postcode;
 $billing_country = $order->shipping_country ? $order->shipping_country : $order->billing_country;
 $billing_phone = $order->shipping_phone ? $order->shipping_phone : $order->billing_phone;
 
 
 


?>




<!-- هدربار برچسب -->
<div class="factor_navtop">
	<div class="flex-content">
			<a class="factor_print" href="#" onclick="window.print()"><i class="ri-printer-line icon"></i></a>
			<div class="save-factor">
				<i class="ri-save-3-fill icon saver">
					<i class="ri-arrow-down-s-fill"></i>
				</i>
			<ul class="factor_list">
				<li class="list_item" data-dropdown-value="angular">
					<i class="ri-image-2-line"></i>
					<a href="#" class="img" id="img_saver">JPG</a>
				</li>
				<li class="list_item" data-dropdown-value="backbone">
					<i class="ri-file-pdf-line"></i>
					<a href="#" class="img" id="pdf_saver">PDF</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<!-- برچسب فاکتور -->

<page size="<?php echo $pager?>">

    <div id="factors" class="min-factor" dir="rtl">
     <main>
       <section class="prk-label">
        <div class="order-label">
           <table class="table-label">
             <tr>
               <td class="label-dates">

                 <div class="label-shoper shoper">

                      <?php
						$addr_join = implode('، ', array_filter([ trim($billing_address_1), trim($billing_address_2) ], 'strlen'));
						$parts = array_filter([ trim($order_state), trim($billing_city), $addr_join ], 'strlen');
						?>
						<span><i>گیرنده:</i> <?php echo esc_html(implode(' - ', $parts)); ?></span>

                      <span><i>نام کامل:</i> <?= $billing_first_name;?> <?= $billing_last_name;?></span>
                      <span><i>کد پستی:</i> <?= $billing_postcode;?></span>
                      <span><i>تلفن:</i> <?= $billing_phone;?></span>
                      <span><i>تاریخ سفارش:</i> <?php echo $miladi;?></span>
					  <?php if ( prk_option('prk_billing_customer_note_label') == 1 &&  !empty($order->get_customer_note()) ): ?>
                          <span ><i>یاداشت:</i> <?php echo $order->get_customer_note();?></span>
                      <?php endif; ?>
                      <span class="align-senter barcode"><img alt="<?php echo $order_number;?>" src="<?php echo THEME_URI ?>/inc/factor-pars/template/factor-barcode.php?text=<?php echo $order_number; ?>" /></span>

                 </div>

               </td>
               <td class="label-dates">
                <div class="label-shoper seller">
                    <?php
                     if (prk_label_logo()) {
                       echo '<span class="label-logo"><img src="'.esc_url($img_logo).'" width="132px" alt="logo"></span>';
                     }
                     ;
                     if ($store_name) {
                       echo '<h2>'.$store_name .'</h2>';
                     }
                     if (prk_label_address() && $store_address) {
                       echo '<span><i>آدرس:</i>'.$store_address.'</span>';
                     }
                     if ($store_zip) {
                       echo '<span><i>کد پستی:</i> '.$store_zip.'</span>';
                     }
                     if ($store_phone) {
                       echo '<span><i>تلفن:</i> '.$store_phone.'</span>';
                     }

                     if ($store_email) {
                       echo '<span><i>ایمیل:</i> '.$store_email.'</span>';
                     }
                     if (prk_label_website() && $store_address) {
                       echo '<span><i>وبسایت</i> '.$web_url.'</span>';
                     }
                    ?>

                </div>
               </td>
             </tr>
             <tr>
               <?php if( prk_label_send_order() || prk_label_Pmethod() || prk_label_order_number() || prk_label_date_print() || prk_label_order_number() ):?>
               <td class="label-orders" colspan="2">
                <div class="flex-labels">
                  <?php

                   if (prk_label_send_order()) {
                     echo '<span><i>روش حمل ونقل:</i> '.$order->get_shipping_to_display().'</span>';
                   }

                   if (prk_label_Pmethod()){
                     echo '<span><i>روش پرداخت:</i> '.ucwords($order->get_payment_method_title()).'</span>';
                   }
                   if ( prk_label_order_number() ) {
                     echo '<span><i>شناسه سفارش:</i> '.$order_number.'</span>';
                   }

                   if (prk_label_date_print()){
                   echo '<span><i>تاریخ چاپ:</i> '.$miladi.'</span>';
                   }

                  ?>
                </div>
               </td>
             <?php endif;?>
             </tr>
           </table>
        </div>
       </section>
     </main>
    <div>

</page>
<?php

}
