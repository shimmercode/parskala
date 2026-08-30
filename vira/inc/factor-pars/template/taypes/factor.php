<?php

// نمایش فاکتور
if ($taypes == 'print_bill'){
// settings and options
$pager = "A4";
$dokan_info = $store_name = $order_state = $state = "";
$show_logo = prk_show_logo();
$factor_title = prk_option('f_title' );
$getfactor = prk_option('f_getfactor');
$dokan_info = prk_option('dokan_info');
$show_sign = prk_option('f_show_sign' );
$show_barcode = prk_barcode();

$factor_crater = get_post_meta( $order->get_id(), 'getmyfactor', true );

$order_number = $order->get_order_number();
$dato   = strtotime($order->get_date_created()) ;
$miladi = prk_factor_jdates("Y/m/d", $dato);
$ncode_meta = prk_option('prk_ncode_factor_meta');
// لوگو فروشگاه
$factor_logo = $factor_titler = "";
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
$prk_fsub_name = prk_option('fsub_name');
if ($prk_fsub_name) {
  $fsub_class = 'fsub_name';
}else {
  $fsub_class = '';
}
// عنوان فاکتور (مرحله سفارش)
if ($factor_title) {
		if($order->get_status() == 'on-hold'){
		  $factor_titler = '<span class="status on-hold">پیش فاکتور</span>';
		}
		if ($order->get_status() == 'processing') {
		  $factor_titler = '<span class="status on-processing">فاکتور</span>';
		}
		if ($order->get_status() == 'completed') {
			$factor_titler = '<span class="status on-completed">فاکتور</span>';
		}
}
else{
		$factor_titler = '<span class="status on-completed">'.factor_titles().'</span>';
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
 $address       = $store_info['address'];
 $store_address = $store_info['address']['street_1'];
 $store_zip     = $store_info['address']['zip'];
 $store_city    = $store_info['address']['city'];

 if(perchecker($address['state']) == 1){
  $state = $address['state'];
 }
 else {

 if(is_numeric($address['state'])){
    global $wpdb;
    $s =$address['state'];
    $getstate = $wpdb->get_row( "SELECT * FROM $wpdb->terms WHERE term_id = $s", ARRAY_A );
    $state = $getstate['name'];
 }else {
    if($address['state']=='TE'){
      $state='تهران';
    }
    if($address['state']=='THR'){
      $state='تهران';
    }
    if($address['state']=='KZ'){
      $state='خوزستان';
    }
    if($address['state']=='KHZ'){
      $state='خوزستان';
    }
    if($address['state']=='AL'){
      $state='البرز';
    }
    if($address['state']=='ABZ'){
      $state='البرز';
    }
    if($address['state']=='Al'){
      $state='اردبیل';
    }
    if($address['state']=='ADL'){
      $state='اردبیل';
    }
    if($address['state']=='AE'){
      $state='آذربایجان شرقی';
    }
    if($address['state']=='EAZ'){
      $state='آذربایجان شرقی';
    }
    if($address['state']=='AW'){
      $state='آذربایجان غربی';
    }
    if($address['state']=='WAZ'){
      $state='آذربایجان غربی';
    }
    if($address['state']=='BU'){
      $state='بوشهر';
    }
    if($address['state']=='BHR'){
      $state='بوشهر';
    }
    if($address['state']=='CM'){
      $state='چهارمحال و بختیاری';
    }
    if($address['state']=='CHB'){
      $state='چهارمحال و بختیاری';
    }
    if($address['state']=='FA'){
      $state='فارس';
    }
    if($address['state']=='FRS'){
      $state='فارس';
    }
    if($address['state']=='GI'){
      $state='گیلان';
    }
    if($address['state']=='GIL'){
      $state='گیلان';
    }
    if($address['state']=='GO'){
      $state='گلستان';
    }
    if($address['state']=='GLS'){
      $state='گلستان';
    }
    if($address['state']=='HD'){
      $state='همدان';
    }
    if($address['state']=='HDN'){
      $state='همدان';
    }
    if($address['state']=='HG'){
      $state='هرمزگان';
    }
    if($address['state']=='HRZ'){
      $state='هرمزگان';
    }
    if($address['state']=='IL'){
      $state='ایلام';
    }
    if($address['state']=='ILM'){
      $state='ایلام';
    }
    if($address['state']=='IS'){
      $state='اصفهان';
    }
    if($address['state']=='ESF'){
      $state='اصفهان';
    }
    if($address['state']=='KE'){
      $state='کرمان';
    }
    if($address['state']=='KRN'){
      $state='کرمان';
    }
    if($address['state']=='BK'){
      $state='کرمانشاه';
    }
    if($address['state']=='KRH'){
      $state='کرمانشاه';
    }
    if($address['state']=='KS'){
      $state='خراسان شمالی';
    }
    if($address['state']=='NKH'){
      $state='خراسان شمالی';
    }
    if($address['state']=='KV'){
      $state='خراسان رضوی';
    }
    if($address['state']=='RKH'){
      $state='خراسان رضوی';
    }
    if($address['state']=='KJ'){
      $state='خراسان جنوبی';
    }
    if($address['state']=='SKH'){
      $state='خراسان جنوبی';
    }
    if($address['state']=='KB'){
      $state='کهگیلویه و بویراحمد';
    }
    if($address['state']=='KBD'){
      $state='کهگیلویه و بویراحمد';
    }
    if($address['state']=='KD'){
      $state='کردستان';
    }
    if($address['state']=='KRD'){
      $state='کردستان';
    }
    if($address['state']=='LO'){
      $state='لرستان';
    }
    if($address['state']=='LRS'){
      $state='لرستان';
    }
    if($address['state']=='MK'){
      $state='مرکزی';
    }
    if($address['state']=='MKZ'){
      $state='مرکزی';
    }
    if($address['state']=='MN'){
      $state='مازندران';
    }
    if($address['state']=='MZN'){
      $state='مازندران';
    }
    if($address['state']=='QZ'){
      $state='قزوین';
    }
    if($address['state']=='GZN'){
      $state='قزوین';
    }
    if($address['state']=='QM'){
      $state='قم';
    }
    if($address['state']=='QHM'){
      $state='قم';
    }
    if($address['state']=='SM'){
      $state='سمنان';
    }
    if($address['state']=='SMN'){
      $state='سمنان';
    }
    if($address['state']=='YA'){
      $state='یزد';
    }
    if($address['state']=='YZD'){
      $state='یزد';
    }
    if($address['state']=='ZA'){
      $state='زنجان';
    }
    if($address['state']=='ZJN'){
      $state='زنجان';
    }
    if($address['state']=='SB'){
      $state='سیستان و بلوچستان';
    }
    if($address['state']=='SBN'){
      $state='سیستان و بلوچستان';
    }
  }
}

// وگرنه : متغییر های ثابت تنظیمات فاکتور را نمایش بده !
}else{
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

// جمع به حروف سفارش
$prk_Letters = prk_Letters();
$numes = $order->get_total();
if(get_woocommerce_currency() == "IRT"){
    $currency = "تومان";
}
if(get_woocommerce_currency() == "IRHT"){
    $currency = "تومان";
}
if(get_woocommerce_currency() == "IRR"){
    $currency = "ریال";
}
if(get_woocommerce_currency() == "IRHR"){
    $currency = "ریال";
}

// تنظیمات فوتر فاکتور
$seller_stamp = prk_seller_stamp();
$seller_sgn = prk_seller_sgn();
$order_sgn = prk_order_sgn();


$shipping_address = $order->get_address( 'shipping' );

$billing_first_name = $billing_first_name = $order->get_shipping_first_name() ? $order->get_shipping_first_name() : $order->get_billing_first_name();
$billing_last_name = $order->get_shipping_last_name() ? $order->get_shipping_last_name() : $order->get_billing_last_name();
$billing_company = $order->get_shipping_company() ? $order->get_shipping_company() : $order->get_billing_company();
$billing_address_1 = $order->get_shipping_address_1() ? $order->get_shipping_address_1() : $order->get_billing_address_1();
$billing_address_2 = $order->get_shipping_address_2() ? $order->get_shipping_address_2() : $order->get_billing_address_2();
$billing_city = $order->get_shipping_city() ? $order->get_shipping_city() : $order->get_billing_city();
$billing_state = $order->get_shipping_state() ? $order->get_shipping_state() : $order->get_billing_state();
$billing_postcode = $order->get_shipping_postcode() ? $order->get_shipping_postcode() : $order->get_billing_postcode();
$billing_country = $order->get_shipping_country() ? $order->get_shipping_country() : $order->get_billing_country();
$billing_phone = $order->get_shipping_phone() ? $order->get_shipping_phone() : $order->get_billing_phone();





?>



<!-- هدربار برگه فاکتور -->
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
	<?php
	if ($getfactor && $factor_crater){
		echo '<div class="create-fact"><i class="ri-checkbox-circle-fill"></i>درخواست صدور فاکتور</div>';
	}elseif($getfactor){
		echo '<div class="no-fact"><i class="ri-error-warning-fill"></i>عدم درخواست صدور فاکتور</div>';
	}
	?>
</div>

<!-- شروع برگه فاکتور -->

<page size="<?php echo $pager?>">

<div id="factors" class="min-factor" dir="rtl">

<header class="header-factor">
<div class="flex-center">

<!-- نمایش لوگو -->
<?php if ($show_logo): ?>
<div class="factor-logo">
 <img src="<?php echo esc_url($img_logo);?>" alt="logo">
</div>
<?php endif; ?>

<!-- نمایش عنوان فاکتور -->
<?php if ($taypes == 'print_bill'): ?>
<div class="factor-title">
<?php echo $factor_titler;?>
</div>
<?php endif; ?>

<!-- نمایش تاریخ و بارکد -->
<div class="factor-dates">

<span class="factor-number">
<?php _e('شماره فاکتور: ', 'woocommerce-factor'); ?>
<span><?php echo $order_number; ?></span>
</span>

<?php if ($show_barcode): ?>
<span class="factor-barcode">
<img alt="<?php echo $order_number; ?>" src="<?php echo THEME_URI ?>/inc/factor-pars/template/factor-barcode.php?text=<?php echo $order_number; ?>" />
</span>
<?php endif; ?>

<span class="factor-date_times">
تاریخ سفارش: <i><?php echo $miladi;?></i>
</span>

</div>

</div>
</header>

<main>
	<section class="main-factor">

    <div class="order-seller">
    <table class="tab-order">
      <?php if ($prk_fsub_name): ?>
          <style media="screen">
            .tab-head.seller.<?= $fsub_class?>::before{
              content: '<?= $prk_fsub_name?>';
              position: absolute;
              font-size: 13px;
              right: 2px;
              transform: rotate(272deg);
              font-weight: 600;
              color: #1f1f1f;
            }
            .order-seller th.tab-head{
              padding: 13px;
            }
          </style>
      <?php endif; ?>
     <!-- هدر برگه -->
			<tr>
				<th class="tab-head seller <?= $fsub_class?>">فروشنده</th>
				<th class="tab-head shoper">خریدار</th>
			</tr>

			<tr>

        <!-- فروشنده -->
				<th class="tab-main seller">
					<?php
					if ($store_name){
						echo '<span class="mleft"><i>فروشنده:</i> '.$store_name.'</span>';
					}
					if ($state){
						echo '<span><i>استان:</i> '.$state.'</span>';
					}
					if ($store_city) {
						echo '<span><i>شهر:</i> '.$store_city.'</span>';
					}
					if ($store_zip) {
						echo '<span><i>کد پستی:</i> '.$store_zip.'</span>';
					}
					if ($store_phone) {
						echo '<span><i>تلفن:</i> '.$store_phone.'</span>';
					}
					if (! $dokan_info && $company_code) {
					  echo '<span><i>کد اقتصادی:</i> '.$company_code.'</span>';
					}
					if (! $dokan_info && $codesabt) {
						echo '<span><i>شماره ثبت:</i> '.$codesabt.'</span>';
					}
					if ($store_address) {
						echo '<span class="bloked"><i>نشانی:</i> '.$store_address.'</span>';
					}?>
				</th>

        <!-- خریدار-->
				<th class="tab-main shoper">
          <span class="mleft"><i>خریدار:</i> <?php echo $billing_first_name;?> <?php echo $billing_last_name;?></span>
					<span><i>استان:</i> <?php echo $order_state; ?></span>
					<span><i>شهر:</i> <?php echo $billing_city; ?></span>
					<span><i>کد پستی:</i> <?php echo $billing_postcode; ?></span>
					<span><i>شماره تماس:</i> <?php echo $billing_phone; ?></span>
          <?php if (get_post_meta( $order->get_id(), $ncode_meta, true ) ): ?>
            <span><i>کد ملی:</i> <?php echo get_post_meta( $order->get_id(), $ncode_meta, true ); ?></span>
          <?php endif; ?>


					<span><i>ایمیل:</i> <?php echo $order->get_billing_email(); ?></span>
					<span class="bloked"><i>نشانی:</i> <?php echo esc_html( $billing_address_1 ?: $billing_address_2 ); ?></span>

          <?php if ( prk_option('prk_billing_customer_note') == 1 &&  !empty($order->get_customer_note()) ): ?>
            <span class="bloked"><i>یادداشت:</i> <?php echo $order->get_customer_note();?></span>
          <?php endif; ?>


				</th>

			</tr>
    </table>
		<table class="order-dates">
			<tr class="head-dates">
				<th width="7%">ردیف</th>
				<th width="9%"> کد کالا</th>
				<th width="">شرح کالا یا خدمات</th>
				<th width="7%">تعداد</th>
				<th width="12%">مبلغ واحد</th>
				<th width="9%">مبلغ کل</th>
			</tr>

			<?php
$counter = 0;

foreach ($order->get_items() as $item_id => $item) {
    $_variation_names = '';

    if (isset($_GET['type'])) {
        $action = $_GET['type'];
    }
    $return = '';
    $context = 'view';
    $counter++;

    // به جای گرفتن محصول زنده، اطلاعات خود آیتم رو می‌گیریم
    $product_id = $item->get_product_id();
    $variation_id = $item->get_variation_id();
    $product_name = $item->get_name(); // اسم محصول در لحظه‌ی ثبت سفارش
    $item_quantity = $item->get_quantity();
    $item_subtotal = $item->get_subtotal(); // جمع قیمت بدون مالیات
    $item_total = $item->get_total(); // جمع قیمت نهایی با تخفیف
    $currency_symbol = get_woocommerce_currency_symbol();

    $hidden_order_itemmeta = apply_filters(
        'woocommerce_hidden_order_itemmeta',
        array(
            '_qty',
            '_tax_class',
            '_product_id',
            '_variation_id',
            '_line_subtotal',
            '_line_subtotal_tax',
            '_line_total',
            '_line_tax',
            'method_id',
            'cost',
            '_reduced_stock',
            '_restock_refunded_items',
        )
    );

    // خواندن ویژگی‌های متغیر محصول (مثلاً رنگ، سایز)
    $variation_names = array();
    $meta_data = $item->get_all_formatted_meta_data('');
    if ($meta_data) {
        foreach ($meta_data as $meta_id => $meta) {
            if (in_array($meta->key, $hidden_order_itemmeta, true)) {
                continue;
            }
            $variation_value = wp_kses_post(force_balance_tags($meta->display_value));
            $variation_names[] = $variation_value;
        }
        $_variation_names = implode(" - ", $variation_names);
    }

    echo '<tr class="head-dates while">';
    echo '<th width="7%">' . $counter . '</th>';

 
    // چون محصول ممکنه حذف شده باشه، SKU رو چک میکنیم
	$product = $variation_id ? wc_get_product($variation_id) : wc_get_product($product_id);
	if ($product && is_object($product)) {
		$sku = $product->get_sku();
	} else {
		$sku = 'محصول حذف شده';
	}
	echo '<th width="9%">' . $sku . '</th>';


    // تصویر محصول از متای ذخیره شده پیدا میشه یا خالی میذاریم
    $image_tag = '';
    $thumbnail_id = get_post_thumbnail_id($product_id);
    if ($thumbnail_id) {
        $image_url = wp_get_attachment_image_url($thumbnail_id, 'shop_catalog');
        if (prk_option('f_imgproduct') == 1 && $image_url) {
            $image_tag = '<img src="' . esc_url($image_url) . '" width="30" style="margin-left:10px;" />';
        }
    }

    echo '<th class="alin-right">
        <div class="flexed_start">
            ' . $image_tag . $product_name . '
        </div>
        <div class="variation_item">' . $_variation_names . '</div>
    </th>';

    echo '<th width="7%">' . $item_quantity . '</th>';

// ===== مبلغ واحد (همان ستون) =====
$qty = max(1, (int) $item_quantity);

$unit_regular = (float) $item_subtotal / $qty; // قبل تخفیف
$unit_final   = (float) $item_total    / $qty; // بعد تخفیف

$percentage = 0;
if ($unit_regular > 0 && $unit_final >= 0 && $unit_final < $unit_regular) {
  $percentage = (int) round(100 - (($unit_final / $unit_regular) * 100));
}

if (prk_option('f_discount_percent')) {

  if ($percentage > 0) {
    $return .= '<th class="item-vs prk-price">
      <span class="index-discount-pro">' . esc_html($percentage) . '% تخفیف</span>
      <div class="index-prices-pro">
        <div class="price_onsale_ar" style="text-decoration:line-through;">' . wc_price($unit_regular) . '</div>
        <div class="price_onsale_ar">' . wc_price($unit_final) . '</div>
      </div>
    </th>';
  } else {
    $return .= '<th class="item-vs prk-price">
      <div class="index-prices-pro">
        <div class="price_onsale_ar">' . wc_price($unit_final) . '</div>
      </div>
    </th>';
  }

} else {
  $return .= '<th class="item-vs prk-price">' . wc_price($unit_final) . '</th>';
}

    echo $return;

    // قیمت کل ردیف
    echo '<th width="9%">' . wc_price($item_subtotal) . '</th>';

    echo '</tr>';
}

?>
   <tr class="head-dates while">
		 <th colspan="2">حمل و نقل:</th>
 		 <th colspan="1"><?php echo $order->get_shipping_to_display();?></th>
		 <th colspan="2">روش پرداخت:</th>
		 <th colspan="1"><?php echo ucwords($order->get_payment_method_title());?></th>
	 </tr>

		<tr class="head-dates grye">
			 <th colspan="3">مبلغ کل:</th>
			 <th colspan="3"><?php echo wc_price($order->get_total()); ?></th>
		</tr>

    <!-- جمع کل به حروف -->
    <?php if ($prk_Letters): ?>
		<tr class="head-dates while Letters">
			 <th colspan="6"><strong>جمع کل به حروف:</strong> <?php echo prk_persain_letters($numes) ." " .$currency; ?></th>

		</tr>
    <?php endif; ?>

		</table>
  <div class="factor-note">
  <?php echo prk_note_footer();?>
  </div>

   <!-- مهر و امضای فروشگاه و فروشنده -->
   <?php if ($show_sign):?>
    <div class="factor-sign">
		 <?php
		 if ($seller_sgn){
      echo '<article class="order-sign">';
			echo '<div class="">'.$seller_sgn.'</div>';
				if ($seller_stamp['url']) {
					 echo '<img class="sing-img" src="'.$seller_stamp['url'].'" alt="sign" width="64px">';
				}
	    echo '</article>';
	   }
		 if ($order_sgn){
      echo '<article class="order-sign">';
			echo '<div class="">'.$order_sgn.'</div>';
	    echo '</article>';
	   }
		 ?>
    </div>
	 <?php endif;?>
    </div>
	</section>
</main>



  </div>
</page>
<?php
}
