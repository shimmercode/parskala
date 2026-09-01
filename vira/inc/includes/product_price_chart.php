<?php
	add_action( 'wp_ajax_product_price_chart', 'get_product_price_chart' );
	add_action( 'wp_ajax_nopriv_product_price_chart', 'get_product_price_chart' );

	function get_product_price_chart(){
global $product;
		if ( empty( $_POST['product_id'] ) ) return;

		$product = wc_get_product( $_POST['product_id'] );


		?>

		<script type="text/javascript">
		jQuery(document).ready(function($){

			jQuery('#productchartprice').highcharts({

				title: {
					text: '<?php _e('نمودار قیمت محصول','parskala'); ?>',
					style: {
						color: '#6a6a6a',
						fontSize: '18px',
            fontFamily: "prk-font",
						whiteSpace: 'nowrap'
					},
				},

				subtitle: {
					text: '<?php _e('تخفیف‌ها و قیمت جشنواره‌ها در قیمت فروش در نظر گرفته نمی‌شود','parskala') ?>',
					style: {
						color: '#6a6a6a',
						fontSize: '12px',
            fontFamily: "prk-font",
						whiteSpace: 'nowrap'
					},
				},



				legend: {
					backgroundColor: "#F5F6F8",
					align: "right",
					verticalAlign: "bottom",
					borderWidth: 0,
					rtl: true,
					useHTML: true,
					margin: 30,
					width: 560,
					itemDistance: 50,
					itemMarginBottom: 10,
					itemStyle: {
						fontWeight: "normal",
            fontFamily: "prk-font",
						fontSize: "12px",
						color: "#777"
					},
				},

				plotOptions: {
					line: {
					connectNulls: true,
						marker: {
							enabled: true,
							fillColor: '#FFFFFF',
							lineWidth: 2,
							lineColor: null, // inherit from series
							radius: 4,
							symbol: "circle",
							width: 900,
							states: {
								hover: {
									enabled: false
								}
							}
						}
					}
				},

				tooltip: {
					valueSuffix: ' <?php echo get_woocommerce_currency_symbol(); ?>',
					rtl: true,
					crosshairs: {
						width: 1,
						color: 'gray',
						dashStyle: 'Dot'
					},
					style: {
          fontFamily: "prk-font",
						padding: '20px'
					},
					backgroundColor: "#fcfeff",
					borderColor: "#e6e7e8",
					borderRadius: 2,
					borderWidth: 1,
					followPointer: false,
					shared: false,
					useHTML: true,
				},

				series: [
		<?php
		if( $product->is_type('variable') ){

			$product_name   = $product->get_name();
			$product_childs = $product->get_children();

			$child_names = array();

			$childs_date = array();

			$vartion_ids = array();

			foreach($product->get_available_variations() as $variation ){


				$vartion_ids[] = $variation['variation_id'];

				// Attributes
				$attributes = array();
				foreach( $variation['attributes'] as $key => $value ){
					$taxonomy = str_replace('attribute_', '', $key );
					$taxonomy_label = get_taxonomy( $taxonomy )->labels->singular_name;
					$term_name = get_term_by( 'slug', $value, $taxonomy )->name;
					$attributes[] = $taxonomy_label.': '.$term_name;
				}
				$child_names[] =  $product_name.': '.implode( ' | ', $attributes );



				if ( ! empty( $dates = get_post_meta($variation['variation_id'],'date_and_price_chart',true) ) ) {

					foreach( $dates as $date => $price ){

						$childs_date[] = substr($date, 2);

					}
				}
			}

			function date_sort($a, $b) {
				return strtotime($a) - strtotime($b);
			}
			usort($childs_date, "date_sort");
			$first_end_date = array_unique($childs_date);

			$i = 0;

			foreach( $vartion_ids as $vartion_id ){



				echo '{';

					echo 'name: "'.$child_names[$i].'",';
					echo 'data: [';

						$date_price_variation = get_post_meta($vartion_id,'date_and_price_chart',true);


						foreach( $first_end_date as $date ){

							//$full_date = '13'.$date;
							$full_date =  $date > 96 ? '13'.$date : '14'.$date ;

							if ( ! empty( $date_price_variation[$full_date] ) ){

								echo $date_price_variation[$full_date].', ';

							}  else { echo 'null, '; }
						}
					echo ']';

				echo '},';
			$i++;
			}
		} else if ( $product->is_type('simple') ){

			$simplePriceChartDate = get_post_meta( $product->get_id(), 'simple_date_and_price_chart', true );

				echo '{';

					echo 'name: "'.$product->get_name().'",';
					echo 'data: [';

						foreach( $simplePriceChartDate as $date => $price ) echo $price.', ';

					echo ']';

				echo '},';
		}
		?>],

				xAxis: {
				categories: [<?php
				if( $product->is_type('variable') )
					foreach( $first_end_date as $date ) echo $date = $date > 96 ? '"13'.$date.'", ' : '"14'.$date.'",' ;

				else if ( $product->is_type('simple') )
					foreach( $simplePriceChartDate as $date => $price ) echo '"'.$date.'", ';
				?>],
					labels: {
						enabled: true,
						rtl: true,
						y: 25,
						x: 0,
						align: 'center',
						style: {
							color: '#979797',
							fontSize: '12px',
              fontFamily: "prk-font",
							whiteSpace: 'nowrap'
						},
						formatter: function () {
							return this.value;
						}
					}
				},

				yAxis: {
					title: {
						text: '<?php _e('تغییرات قیمت','parskala'); ?>',
						x: -15, //center
						style: {
							fontWeight: "normal",
              fontFamily: "prk-font",
							fontSize: "14px",
							direction: "rtl",
							color: "#777777"
						}
					},
					gridLineDashStyle: "Dot",

					labels: {
						x: -50,
						style: {
							color: '#4c4c4c',
							fontSize: '16px',
              fontFamily: "prk-font",
						},
						formatter: function () {
							return this.value;
						}
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: "#808080"
					}]
				},

				responsive: {
					rules: [{
						condition: {
							maxWidth: 900
						},
						chartOptions: {
							legend: {
								layout: 'horizontal',
								align: 'center',
								verticalAlign: 'bottom'
							}
						}
					}]
				}

			});
		});
		</script>


        <style>
            .highcharts-legend-item {
                direction: rtl;
            }
            .highcharts-tooltip span:first-child {
                float: right;
                font-size: 10pt !important;
            }
            .highcharts-tooltip span:nth-child(2) {
                float: right;
                direction: rtl;
                text-align: right;
            }
            .highcharts-tooltip span b{
                float: right;
                direction: ltr;
                text-align: left;
            }
        </style>


		<?php

		wp_die();
	}
