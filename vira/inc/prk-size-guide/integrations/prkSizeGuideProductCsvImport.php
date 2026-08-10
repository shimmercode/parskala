<?php

/**
 * Size guide import - WooCommerce Product CSV Import Suite
 */
class prkSizeGuideProductCsvImport
{
	/**
	 * prkSizeGuideProductCsvImport constructor
	 */
	public function __construct()
    {
	    // export
	    add_filter('woocommerce_csv_product_post_columns', array($this, 'filterCsvProductPostColumns'));

	    // import
	    add_filter('woocommerce_csv_product_postmeta_defaults', array($this, 'filterCsvProductPostmetaDefaults'));
    }

	/**
	 * @param $columns
	 *
	 * @return mixed
	 */
	public function filterCsvProductPostColumns( $columns )
    {
	    // adds "_prk_selectsizeguide" column key to be searched for
	    // "meta:_prk_selectsizeguide" is desired column key in output file
	    $columns['_prk_selectsizeguide'] = 'meta:_prk_selectsizeguide';
	    return $columns;
    }

	/**
	 * @param $postmeta
	 */
	public function filterCsvProductPostmetaDefaults( $postmeta )
	{
		// adds "prk_selectsizeguide" key to be searched for
		$postmeta['_prk_selectsizeguide'] =  '';
    }
}

new prkSizeGuideProductCsvImport();