<?php
if(!function_exists('addFieldPriceChartPro')) {
/**
 *--------------------------------------------------------------------------
 * simple product
 *--------------------------------------------------------------------------
 */
    // Display Fields
    add_action( 'woocommerce_product_options_general_product_data', 'addFieldPriceChartPro', 99999 );
    function addFieldPriceChartPro() {
        global $woocommerce, $post;
        echo '<div class="simpleChart_options_group options_group" id="options_group'.$post->ID.'">';
        echo '<h5>'.__('نمودار قیمت','parskala').'</h5>';
        echo '<div class="childsField">';

        $value25 = get_post_meta( $post->ID, '_simplePriceChart',true) ;
        $DateValues = get_post_meta( $post->ID, '_simplePriceChartDate',true) ;
        $value = explode('|',$value25);
        $DateValues = explode('|',$DateValues);
        $img_handler = get_bloginfo('template_url').'/images/sorthandel-1.png';
        if($value[0]) {
            $i = 0;
            foreach ($value as $item) {
                if($i == 0){$class= 'first';}else{$class= '';}
                echo '<p class="'.$class.' form-field _priceChart[' . $post->ID . ']_field ">


                <input type="text" class="short shortPrice" style="" name="_simplePriceChart[' . $post->ID . '][]" id="_priceChart[' . $post->ID . ']" value="' . intval($item) . '" placeholder="قیمت" step="any" min="0">
                <input type="text" class="short shortDate" style="" name="_simplePriceChartDate[' . $post->ID . '][]" id="_priceChartDate[' . $post->ID . ']" value="' . $DateValues[$i] . '" placeholder="'.__('تاریخ','parskala').'" readonly >
                 <button class="deletation button"><span >X</span></button>
                 </p>';
                $i++;
            }
        }


        echo '</div>';
        echo '<button class="button addPriceCharter" id="addPriceChart' . $post->ID . '"><span>+</span></button>';
        echo '</div>'; ?>

		<script>
		// html tag
		var html_chart_fields<?php echo $post->ID; ?> = '<?php echo '<p class="form-field _priceChart[' . $post->ID . ']_field "><input type="text" class="short" style="" name="_simplePriceChart[' . $post->ID . '][]" id="_priceChart[' . $post->ID . ']" placeholder="قیمت" step="any" min="0"><input type="text" class="short shortDate" style="" name="_simplePriceChartDate[' . $post->ID . '][]" id="_priceChartDate[' . $post->ID . ']" placeholder="'.__('تاریخ','parskala').'" readonly ><button class="deletation button"><span >X</span></button> </p>'; ?>';
		</script>

		<?php
        echo "<script type='text/javascript'>
         jQuery(document).ready(function($) {
            $('#addPriceChart".$post->ID."').unbind('click').bind('click', function (e) {
                e.preventDefault();
                var elm = $( '#options_group{$post->ID} .childsField' ).append(html_chart_fields{$post->ID})
                .find('.deletation').click(function() {
                  $(this).parent().remove();
                  return false;
                });

                $('.shortDate').each(function() {
                  $(this).persianDatepicker({formatDate: 'YYYY-MM-DD'});
                });


                return false;
            });
            $( \".deletation\" ).on( \"click\", function() {
                $(this).parent().remove();
                return false;
            });
            $( '#product-type' ).change( function() {
                    var selected = $( '#product-type' ).find(':selected').val();
                    $( '.simpleChart_options_group' ).hide();
                    if ( selected == 'variable' ) {
                        $( '.simpleChart_options_group' ).hide();
                    }else {
                        $( '.simpleChart_options_group' ).show();
                    }
                });
                $( '#product-type' ).trigger( 'change' );


           $('.shortDate').each(function() {
                $(this).persianDatepicker({formatDate: 'YYYY-MM-DD'});
            });

               $('.childsField').sortable();
               $('.childsField').disableSelection();

        });
      </script>";
    }

    // Save Fields
    add_action( 'save_post_product', 'SaveFieldPriceChartPro', 10, 3 );


    function SaveFieldPriceChartPro( $post_id , $post, $update){
      $price = get_post_meta( get_the_ID(), '_regular_price', true);
      if ($price && isset($_POST['_simplePriceChart'][$post_id],$_POST['_simplePriceChartDate'][$post_id]) ){
        // Text Field
        $simplearrayPrice = $_POST['_simplePriceChart'][$post_id];
        $simplearrayPriceDate = $_POST['_simplePriceChartDate'][$post_id];


		// array maker
		$i = 0;
		$date_and_price_chart = array();

		if ( $simplearrayPrice[0] ){
			foreach( $simplearrayPrice as $x ) {

				$date_and_price_chart[$simplearrayPriceDate[$i]] = $simplearrayPrice[$i];
				$i++;
			}
		}

		// save array
		if ( $simplearrayPrice[0] )
			update_post_meta( $post_id, 'simple_date_and_price_chart', $date_and_price_chart );
		else
			update_post_meta( $post_id, 'simple_date_and_price_chart', '' );


        if( $simplearrayPrice[0] )
			update_post_meta( $post_id, '_simplePriceChart', esc_attr( implode('|',$simplearrayPrice) ) );
		else
			update_post_meta( $post_id, '_simplePriceChart', '' );

		if( $simplearrayPriceDate[0] )
			update_post_meta( $post_id, '_simplePriceChartDate', esc_attr( implode('|',$simplearrayPriceDate) ) );
		else
			update_post_meta( $post_id, '_simplePriceChartDate', '' );
      }
   }

/**
 *--------------------------------------------------------------------------
 * variable products
 *--------------------------------------------------------------------------
 */
    // Add Variation Settings
    add_action( 'woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3 );
    function variation_settings_fields( $loop, $variation_data, $variation ) {
        echo '<div class="options_group varitionChart_options_group" id="options_group'.$variation->ID.'">';
        echo '<h5>'.__('نمودار قیمت - محصولات متغیر','parskala').'</h5>';
        echo '<div class="childsField">';
        $value25 = get_post_meta( $variation->ID, '_priceChart',true) ;
        $DateValues = get_post_meta( $variation->ID, '_priceChartDate',true) ;
        $value = explode('|',$value25);
        $DateValues = explode('|',$DateValues);
        $img_handler = get_bloginfo('template_url').'/images/sorthandel-1.png';
        if( $value[0] ) {
            $i = 0;
            foreach ($value as $item) {
                if($i == 0){$class= 'first';}else{$class= '';}
                echo '<p class="'.$class.' form-field _priceChart[' . $variation->ID . ']_field ">

                <input type="text" class="short" style="" name="_priceChart[' . $variation->ID . '][]" id="_priceChart[' . $variation->ID . ']" value="' . intval($item) . '" placeholder="قیمت" step="any" min="0">
                <input type="text" class="short shortDate" style="" name="_priceChartDate[' . $variation->ID . '][]" id="_priceChartDate[' . $variation->ID . ']" value="' . $DateValues[$i] . '" placeholder="'.__('تاریخ','parskala').'" readonly >
                 <button class="deletation button"><span>X</span></button>
                 </p>';
                $i++;
            }
        }
        echo '</div>';
        echo '<button class="button addPriceCharter" id="addPriceChart' . $variation->ID . '"><span>+</span></button>';
        echo '</div>'; ?>

		<script>
		// html adder
		var html_chart_fields<?php echo $variation->ID; ?> = '<p class="form-field _priceChart[<?php echo $variation->ID; ?>]_field "><label for="_priceChart[<?php echo $post->ID; ?>]"><img src="<?php echo $img_handler; ?>" class="sort_handler" alt=""> <span>قیمت</span> </label><input type="text" class="short" style="" name="_priceChart[<?php echo $variation->ID; ?>][]" id="_priceChart[<?php echo $variation->ID; ?>]" placeholder="<?php _e('قیمت','parskala') ?> step="any" min="0"><input type="text" class="short shortDate" style="" name="_priceChartDate[<?php echo $variation->ID; ?>][]" id="_priceChartDate[<?php echo $variation->ID; ?>]" placeholder="<?php _e('تاریخ','parskala') ?>" readonly ><button class="deletation button"><span>X</span></button> </p>';
		</script>

        <?php
		echo "<script type='text/javascript'>
        jQuery(document).ready(function($) {
            $('#addPriceChart".$variation->ID."').unbind('click').bind('click', function (e) {
                e.preventDefault();
                var elm = $( '#options_group{$variation->ID} .childsField' ).append(html_chart_fields{$variation->ID})
                .find('.deletation').click(function() {
                  $(this).parent().remove();
                  return false;
                });

                $('.shortDate').each(function() {
                  $(this).persianDatepicker({formatDate: 'YYYY-MM-DD'});
                });

                return false;
            });

            $( \".deletation\" ).on( \"click\", function() {
                $(this).parent().remove();
                return false;
            });

           $('.shortDate').each(function() {
                $(this).persianDatepicker({formatDate: 'YYYY-MM-DD'});
            });

           $('.childsField').sortable();
               $('.childsField').disableSelection();

			jQuery('.varitionChart_options_group, .deletation span').on( 'click', function(){
				$(this).parents('.woocommerce_variation').addClass('variation-needs-update');
			});
        });
        </script>";
    }
    // Save Variation Settings
    add_action( 'woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2 );

    function save_variation_settings_fields( $post_id ) {

        // get postmetas
        $number_field = $_POST['_priceChart'][$post_id];
        $Date_field = $_POST['_priceChartDate'][$post_id];

		// args maker
		$i = 0;
		$date_and_price_chart = array();
		foreach( $number_field as $x ) {

			$date_and_price_chart[$Date_field[$i]] = $number_field[$i];
			$i++;
		}
		// saves args
		if ( $number_field[0] )
			update_post_meta( $post_id, 'date_and_price_chart', $date_and_price_chart );
		else
			update_post_meta( $post_id, 'date_and_price_chart', '' );

		// field saver
		if ( $number_field[0] )
			update_post_meta( $post_id, '_priceChart', esc_attr( implode('|',$number_field) ) );
		else
			update_post_meta( $post_id, '_priceChart', '' );


		if ( $Date_field[0] )
			update_post_meta( $post_id, '_priceChartDate', esc_attr( implode('|',$Date_field) ) );
        else
			update_post_meta( $post_id, '_priceChartDate', '' );

    }
/**
 *--------------------------------------------------------------------------
 * Custom fonts
 *--------------------------------------------------------------------------
 */
    add_action('admin_head', 'parskala_custom_styles_admin');
    function parskala_custom_styles_admin() {
        ?>
        <style>
            .woocommerce_variable_attributes wc-metabox-content { height: auto !important; }
            .simpleChart_options_group , varitionChart_options_group {
                padding-bottom: 30px;
            }
            .simpleChart_options_group h5 , .varitionChart_options_group h5 {
                color: #535353;
                border-top: 2px solid #eeee;
                padding-top: 15px;
                padding-right: 10px;
            }
            ._priceChart {
                cursor: pointer !important;
            }
            .childsField p:nth-child(odd) {
                background-color: whitesmoke;
            }
            .childsField .form-field .deletation {
                color: #ef4556;
                width: 30px;
                height: 26px;
                font-size: 18px;
                padding: 0;
                border: 0;
            }
            .childsField .form-field .deletation span {
                position: relative;
                top: -2px;
                right: -1px;
            }
            .addPriceCharter {
                  width: 15%;
                  background-color: #ef4556 !important;
                  color: white !important;
                  border: none !important;
                  outline: none !important;
                  margin-right: 10px !important;
            }
            .sort_handler {
                width: 10px;
                height: 10px;
                vertical-align: sub;
            }
            .childsField .form-field input[type=text]{
                width: 26.7%;
                margin-left: 10px;
            }
      .childsField.ui-sortable p.form-field {
     padding-right: 9px !important
      }
        </style>
        <script>
            jQuery(document).ready(function($) {
                $('#product-type').change( function() {
                    var selected = $(this).find(':selected').val();
                    if (selected == 'variable') {
                        $('#inventory_product_data').css('display','block');
                        $('.inventory_tab').addClass('active');
                        $('.general_tab , #general_product_data').hide();
                    }
                });
            });
            /*
            $('#product-type').change( function() {
                var selected = $( '#product-type' ).find(':selected').val();
                console.log(selected)
                if (selected == 'variable') {
                    $('.general_tab').hide();
                }
            });

            */
        </script>
        <?php
    }



}
