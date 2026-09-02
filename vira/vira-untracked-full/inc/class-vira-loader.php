<?php
/**
 * Explicit file + class loader (no Composer PSR-4 in this theme).
 *
 * @package Vira
 */

namespace Vira;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Loader {
	/**
	 * Require a theme-relative PHP file if readable.
	 *
	 * @param string $relative Path under theme root, starting with /.
	 * @return bool
	 */
	public static function require_file( $relative ) {
		$base = defined( 'VIRA_THEME_DIR' ) ? VIRA_THEME_DIR : get_template_directory();
		$path = $base . $relative;
		if ( ! is_readable( $path ) ) {
			return false;
		}
		require_once $path;
		return true;
	}

	/**
	 * Call a method on a fully-qualified class after it is loaded.
	 *
	 * @param string $class  Leading-backslash class name.
	 * @param string $method Static method.
	 * @return bool
	 */
	public static function boot( $class, $method = 'init' ) {
		$fq = '\\' . ltrim( $class, '\\' );
		if ( ! class_exists( $fq, false ) ) {
			return false;
		}
		if ( ! method_exists( $fq, $method ) ) {
			return false;
		}
		call_user_func( array( $fq, $method ) );
		return true;
	}
}
