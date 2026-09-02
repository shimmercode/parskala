<?php
/**
 * Geocoding abstraction. Nominatim only if explicitly enabled. No fake addresses.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ViraGeocodingProviderInterface {
	/**
	 * @param float $lat
	 * @param float $lng
	 * @return array|WP_Error
	 */
	public function reverse( $lat, $lng );
}

class Vira_Geocoding_Nominatim implements ViraGeocodingProviderInterface {
	public function reverse( $lat, $lng ) {
		if ( ! get_option( 'vira_geocoding_enable' ) ) {
			return new WP_Error( 'geo_disabled', 'Geocoding provider not configured' );
		}
		$url  = add_query_arg(
			array(
				'format'         => 'jsonv2',
				'lat'            => $lat,
				'lon'            => $lng,
				'accept-language'=> 'fa',
			),
			'https://nominatim.openstreetmap.org/reverse'
		);
		$resp = wp_remote_get(
			$url,
			array(
				'timeout' => 12,
				'headers' => array( 'User-Agent' => 'ViraTheme/1.3 (WordPress)' ),
			)
		);
		if ( is_wp_error( $resp ) ) {
			return $resp;
		}
		$code = wp_remote_retrieve_response_code( $resp );
		if ( $code < 200 || $code >= 300 ) {
			return new WP_Error( 'geo_http', 'Geocoding HTTP ' . $code );
		}
		$data = json_decode( wp_remote_retrieve_body( $resp ), true );
		if ( ! is_array( $data ) ) {
			return new WP_Error( 'geo_parse', 'Invalid geocoding response' );
		}
		$addr = isset( $data['address'] ) ? $data['address'] : array();
		return array(
			'display'  => isset( $data['display_name'] ) ? $data['display_name'] : '',
			'province' => isset( $addr['state'] ) ? $addr['state'] : '',
			'city'     => isset( $addr['city'] ) ? $addr['city'] : ( isset( $addr['town'] ) ? $addr['town'] : '' ),
			'address'  => isset( $data['display_name'] ) ? $data['display_name'] : '',
			'postcode' => isset( $addr['postcode'] ) ? $addr['postcode'] : '',
		);
	}
}
