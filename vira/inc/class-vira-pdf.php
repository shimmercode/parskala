<?php
/**
 * Minimal PDF writer (real PDF bytes, no fake HTML print). PHP 7.4.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vira_Pdf {
	/**
	 * @param string $title
	 * @param array  $lines
	 * @return string PDF binary
	 */
	public static function from_lines( $title, $lines ) {
		$content = $title . "\n\n" . implode( "\n", $lines );
		$content = self::latinize( $content );
		$stream  = $content;
		$len     = strlen( $stream );
		$objects = array();
		$objects[] = '<< /Type /Catalog /Pages 2 0 R >>';
		$objects[] = '<< /Type /Pages /Kids [3 0 R] /Count 1 >>';
		$objects[] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>';
		$objects[] = '<< /Length ' . $len . " >>\nstream\nBT /F1 11 Tf 40 800 Td " . self::escape_tj( $stream ) . " Tj ET\nendstream";
		$objects[] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';

		$out  = "%PDF-1.4\n";
		$offs = array( 0 );
		foreach ( $objects as $i => $obj ) {
			$offs[] = strlen( $out );
			$out   .= ( $i + 1 ) . " 0 obj\n" . $obj . "\nendobj\n";
		}
		$xref = strlen( $out );
		$out .= 'xref\n0 ' . ( count( $objects ) + 1 ) . "\n";
		$out .= "0000000000 65535 f \n";
		for ( $i = 1; $i <= count( $objects ); $i++ ) {
			$out .= sprintf( "%010d 00000 n \n", $offs[ $i ] );
		}
		$out .= 'trailer << /Size ' . ( count( $objects ) + 1 ) . ' /Root 1 0 R >>\nstartxref\n' . $xref . "\n%%EOF";
		return $out;
	}

	private static function escape_tj( $text ) {
		$text = str_replace( array( '\\', '(', ')' ), array( '\\\\', '\\(', '\\)' ), $text );
		return '(' . $text . ')';
	}

	/**
	 * Helvetica cannot draw Persian; transliterate digits and keep ASCII labels.
	 */
	private static function latinize( $text ) {
		$map = array(
			'۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
			'۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
		);
		$text = strtr( $text, $map );
		if ( function_exists( 'iconv' ) ) {
			$conv = @iconv( 'UTF-8', 'ASCII//TRANSLIT//IGNORE', $text );
			if ( is_string( $conv ) && $conv !== '' ) {
				return $conv;
			}
		}
		return preg_replace( '/[^\x09\x0A\x0D\x20-\x7E]/', '?', $text );
	}
}
