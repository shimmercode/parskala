<?php

/**
 *
 *
 * @category
 * @version    1.0.0
 * @since      1.0.0
 */

namespace Next_Shopping_List\Includes\Init;

/**
 * Class Checkout features
 *
 * @package ShopDesign\Features
 */
class Checkout {

	/**
	 * add checkout map fields
	 *
	 * @param array $fields
	 *
	 * @return array
	 */
	public function mapInputs (array $fields) : array {
		if ( prk_option('checkout-map', '1') !== '1' ) {
			return $fields;
		}

		$mapDefaultVal = prk_option('checkout-map-details');
		if ( is_array($mapDefaultVal) && isset($mapDefaultVal['latitude'], $mapDefaultVal['longitude']) ) {
			$mapDefaultVal = $mapDefaultVal['latitude'] . ',' . $mapDefaultVal['longitude'];
		} else {
			$mapDefaultVal = '';
		}

		$fields['billing']['billing_map_address'] = [
			'label'             => __('Map address', THEME_TEXTDOMAIN),
			'required'          => false,
			'class'             => ['address-field'],
			'input_class'       => ['input-has-map', 'uk-hidden'],
			'autocomplete'      => 'billing_map_address',
			'default'           => defined('SD_CUI') ? get_user_meta(SD_CUI, 'billing_map_address',
				true) : $mapDefaultVal,
			'priority'          => 200,
			'custom_attributes' => [
				'data-listen' => '#billing_city, #billing_state',
				'data-map'    => 'billing-map'
			]
		];

		$fields['shipping']['shipping_map_address'] = [
			'label'             => __('Map address', THEME_TEXTDOMAIN),
			'required'          => false,
			'class'             => ['address-field'],
			'input_class'       => ['input-has-map', 'uk-hidden'],
			'autocomplete'      => 'shipping_map_address',
			'default'           => defined('SD_CUI') ? get_user_meta(SD_CUI, 'shipping_map_address',
				true) : $mapDefaultVal,
			'priority'          => 200,
			'custom_attributes' => [
				'data-listen' => '#shipping_city, #shipping_state',
				'data-map'    => 'shipping-map'
			]
		];


		return $fields;
	}

	public static function getCartProductsMaximumDeliveryTime () : int {
		$items            = WC()->cart->get_cart();
		$productsDelivery = 0;
		if ( empty($items) ) {
			return $productsDelivery;
		}
		foreach ( $items as $cart_item ) {
			if ( $cart_item['data']->get_type() === 'variation' ) {
				$itemTime = get_post_meta($cart_item['data']->get_parent_id(), 'deliver-time', true);
				if ( !is_numeric($itemTime) ) {
					continue;
				}

				$productsDelivery = $productsDelivery > (int) $itemTime ? $productsDelivery : (int) $itemTime;
				continue;
			}
			$itemTime = get_post_meta($cart_item['product_id'], 'deliver-time', true);
			if ( !is_numeric($itemTime) ) {
				continue;
			}
			$productsDelivery = $productsDelivery > (int) $itemTime ? $productsDelivery : (int) $itemTime;
		}

		return $productsDelivery;
	}

	public static function getCartDeliveryTimes () : array {
		$productsDelivery = self::getCartProductsMaximumDeliveryTime();

		$allowedDays = prk_option('delivery-dates',
			['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday']);
		$deliveryMin = prk_option('delivery-min-time', 4);
		$deliveryMin = is_numeric($deliveryMin) ? (int) $deliveryMin : 4;

		$datesCount = prk_option('delivery-times-count', 5);
		$datesCount = is_numeric($datesCount) ? (int) $datesCount : 5;
		$datesCount += 7 - count($allowedDays);
		$results    = [];

		for ( $i = 0; $i < $datesCount; $i++ ) {
			$datetime = new DateTime();
			$datetime->modify('+' . ($productsDelivery + $i + $deliveryMin) . ' ' . ($productsDelivery + $i + $deliveryMin > 1 ? 'day' : 'days'));
			if ( !in_array(strtolower($datetime->format('l')), $allowedDays, false) ) {
				continue;
			}


			$results[] = [
				'dayName' => $datetime->format('l'),
				'date'    => $datetime->format('U')
			];
		}


		return $results;
	}


	public function deliveryInputs () : void {
		Theme::getTemplatePart(get_theme_file_path('woocommerce/checkout/delivery-times.php'), [
			'deliveryDates' => self::getCartDeliveryTimes()
		], true);
	}

	/**
	 * update order review event
	 *
	 * @param $data
	 */
	public function updateOrderReview ($data) : void {
		parse_str($data, $data);
		$data['billing_map_address']  = $data['billing_map_address'] ?? '';
		$data['shipping_map_address'] = $data['shipping_map_address'] ?? '';
		if ( defined('SD_CUI') ) {
			update_user_meta(SD_CUI, 'billing_map_address', $data['billing_map_address']);
			update_user_meta(SD_CUI, 'shipping_map_address', $data['shipping_map_address']);
		}
	}

	public function displayOrderBillingDetails ($order) : void {
		if ( prk_option('checkout-delivery', '1') === '1' ) {
			$delivery = $order->get_meta('delivery_time');
			if ( is_array($delivery) && isset($delivery['date']) ) {
				$delivery = date_i18n('Y-m-d', $delivery['date']);
			} else {
				$delivery = __('Undefined', THEME_TEXTDOMAIN);
			}
			echo '<p><strong>' . __('Delivery time:', THEME_TEXTDOMAIN) . '</strong> ' . $delivery . '</p>';
		}


		$mapLocation = $order->get_meta('billing_map_address');
		if ( !empty($mapLocation) ) {
			echo '<p>';
			echo '<strong>' . __('Map address:', THEME_TEXTDOMAIN) . '</strong> ';
			echo '<a href="https://www.google.com/maps/dir//' . $mapLocation . '" target="_blank">' . __('See on google map',
					THEME_TEXTDOMAIN) . '</a></p>';
		}
	}

	public function displayOrderShippingDetails ($order) : void {
		$mapLocation = $order->get_meta('shipping_map_address');
		if ( !empty($mapLocation) ) {
			echo '<p>';
			echo '<strong>' . __('Map address:', THEME_TEXTDOMAIN) . '</strong> ';
			echo '<a href="https://www.google.com/maps/dir//' . $mapLocation . '" target="_blank">' . __('See on google map',
					THEME_TEXTDOMAIN) . '</a></p>';
		}
	}


	public function checkoutProcess () : void {
		if ( prk_option('checkout-delivery', '1') === '1' ) {
			if ( !isset($_POST['delivery-time']) || !is_numeric($_POST['delivery-time']) ) {
				wc_add_notice(__('Delivery time is a required field!', THEME_TEXTDOMAIN), 'error');
			}
		}
	}


	/**
	 * update order meta event
	 *
	 * @param int $orderID
	 */
	public function updateOrderMeta ($orderID) : void {
		if ( isset($_POST['delivery-time']) && prk_option('checkout-delivery', '1') === '1' ) {
			$deliveryDates = self::getCartDeliveryTimes();
			$metaValue     = $deliveryDates[$_POST['delivery-time']] ?? '';
			update_post_meta($orderID, 'delivery_time', $metaValue);
		}

		if ( isset($_POST['billing_map_address']) ) {
			update_post_meta($orderID, 'billing_map_address', esc_sql($_POST['billing_map_address']));
		}

		if ( isset($_POST['shipping_map_address']) ) {
			update_post_meta($orderID, 'shipping_map_address', esc_sql($_POST['shipping_map_address']));
		}
	}

	public function orderTableHeader ($columns) : array {
		if ( prk_option('checkout-delivery', '1') === '1' ) {
			$columns['delivery_time'] = __('Delivery Time', THEME_TEXTDOMAIN);
		}

		return $columns;
	}

	public function orderTableColumn ($column) : void {
		global $post;
		if ( 'delivery_time' === $column ) {
			$order    = wc_get_order($post->ID);
			$delivery = $order->get_meta('delivery_time');
			if ( is_array($delivery) && isset($delivery['date']) ) {
				echo '<b>' . date_i18n('Y-m-d', $delivery['date']) . '</b>';
			} else {
				echo __('Undefined', THEME_TEXTDOMAIN);
			}
		}
	}

	/**
	 * init all hooks
	 */
	public static function init () : void {
		$class = new self();
		add_filter('woocommerce_checkout_fields', [$class, 'mapInputs']);
		add_action('woocommerce_checkout_before_order_review_heading', [$class, 'deliveryInputs']);
		add_action('woocommerce_checkout_update_order_review', [$class, 'updateOrderReview']);
		add_action('woocommerce_checkout_update_order_meta', [$class, 'updateOrderMeta']);
		add_action('woocommerce_admin_order_data_after_billing_address', [$class, 'displayOrderBillingDetails']);
		add_action('woocommerce_admin_order_data_after_shipping_address', [$class, 'displayOrderShippingDetails']);
		add_action('woocommerce_checkout_process', [$class, 'checkoutProcess']);
		add_filter('manage_edit-shop_order_columns', [$class, 'orderTableHeader']);
		add_action('manage_shop_order_posts_custom_column', [$class, 'orderTableColumn']);
	}
}
