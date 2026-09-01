<?php



add_filter('pre_option_yith_woocompare_is_button', function(){ return 'link'; });
add_filter('pre_option_yith_woocompare_use_page_popup', function(){ return 'page'; });
add_filter('pre_option_yith_woocompare_auto_open', function(){ return 'no'; });
add_filter('pre_option_yith_woocompare_open_after_second', function(){ return 'no'; });


add_filter('pre_option_yith-woocompare-show-related', function(){ return 'no'; });
add_filter('pre_option_yith-woocompare-related-in-page', function(){ return 'no'; });


add_filter('pre_option_yith_woocompare_compare_button_in_product_page', function(){ return 'no'; });
add_filter('pre_option_yith_woocompare_use_category', function(){ return 'no'; });
add_filter('pre_option_yith_woocompare_excluded_category_inverse', function(){ return 'yes'; });



add_filter('pre_option_yith_woocompare_excluded_category', 'parskala_add_terms_for_campare');
	function parskala_add_terms_for_campare(){
		
	   $terms = get_terms("product_cat", array('fields' => 'all'));
	   $terms_for_campare = array();

	   foreach($terms as $term) {
		   
		  $term_children = get_term_children( $term->term_id, "product_cat" );
		  if ( empty($term_children) ) $terms_for_campare[] = $term->term_id; 
	   }	
		return $terms_for_campare;
	}
	






add_filter('yith_woocompare_general_settings', function($general){
	
		/*
		$general['search'][] =	array(
			'title' => 'جستجو در تیتر انگلیسی محصولات (اختصاصی قالب نیوکالا)',
			'type' => 'title',
			'desc' => '',
			'id' => 'yith_wcas_search_options'
		);
		$general['search'][] =	array(
			'title'    => 'جستجو در  تیتر انگلیسی محصولات',
			'id'       => 'parskala_search_in_subtitle',
			'default'  => 'no',
			'type'     => 'checkbox',
			'desc' 	   =>  '',
		);
		$general['search'][] =	array(
			'type'      => 'sectionend',
			'id'        => 'yith_wcas_search_options_end'
		);	
		*/
		
		unset( $general['general'][1] );
		unset( $general['general'][2] );
		unset( $general['general'][6] );
		unset( $general['general'][8] );
		unset( $general['general'][9] );
		unset( $general['general'][10] );
		unset( $general['general'][11] );
		unset( $general['general'][12] );
		

	return $general;
});






add_filter('yith_woocompare_admin_tabs', function($tabs){
	
	unset($tabs['related']);
	unset($tabs['share']);
	unset($tabs['style']);
	
	
	return $tabs;
});


