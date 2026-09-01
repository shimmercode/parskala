<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class
 *
 * @author 		parskala
 * @package 	WooCommerce/Templates
 * @version     9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $woocommerce_print_products_options;
$woocommerce_group_attributes_options = get_option('prk_option');
$divider = $woocommerce_group_attributes_options['attributeValueDivider'];
$accordionEnabled = !empty($woocommerce_group_attributes_options['enableAccordion'])?$woocommerce_group_attributes_options['enableAccordion']:null;

// better map it like on woo pdf catalog - small workaround but it just shows all attributes
if($product->is_type('variation')) {
	$product = wc_get_product($product->get_parent_id());
}

$has_row    = false;
$alt        = 1;
$alt2       = 1;
$attributes = apply_filters( 'woocommerce_display_product_attributes', $product->get_attributes(), $product);

// Reassmble the attributes variable
// Add the grouped attributes
$args = array( 'posts_per_page' => -1, 'post_type' => 'attribute_group', 'post_status' => 'publish', 'orderby' => 'menu_order', 'suppress_filters' => 0);

$attribute_groups = get_posts( $args );

$terms = get_the_terms( $product->get_id(), 'product_cat' );
if(!empty($terms)) {

	$productCategories = array();
	foreach ($terms as $term) {
	    $productCategories[] = $term->term_id;
	}

	foreach ($attribute_groups as $attribute_group_key => $attribute_group) {
		$attributeGroupsProductCategories = get_the_terms( $attribute_group->ID, 'product_cat' );
		if(empty($attributeGroupsProductCategories)) {
			continue;
		}
		$attributeGroupsProductCategoriesFlat = array();
		foreach ($attributeGroupsProductCategories as $attributeGroupsProductCategory) {
		    $attributeGroupsProductCategoriesFlat[] = $attributeGroupsProductCategory->term_id;
		}

		$check = array_intersect($productCategories, $attributeGroupsProductCategoriesFlat);
		if(empty($check)) {
			unset($attribute_groups[$attribute_group_key]);
		}
	}
}

$temp = array();
$haveGroup = array();
if(!empty($attribute_groups)){
	foreach ($attribute_groups as $attribute_group) {

		// Attribut Group Name
		$attribute_group_name = apply_filters( 'woocommerce_group_attributes_group_title', $attribute_group->post_title, $attribute_group, $product);

		// Accordion Open
		$accordion_open = get_post_meta($attribute_group->ID, 'woocommerce_group_attributes_accordion_open', true);

		// Attribut Group Image
		$attributeGroupImage = get_post_meta($attribute_group->ID, 'woocommerce_group_attributes_image' , true);
		$img = "";
		if(!empty($attributeGroupImage)){
			$img = '<i class="'.$attributeGroupImage.'"></i>';
		}else {
			$img = '<i class="ri-arrow-left-s-fill"></i>';
		}

		$attributes_in_group = get_post_meta($attribute_group->ID, 'woocommerce_group_attributes_attributes');
		if(empty($attributes_in_group)) {
			continue;
		}

		if(is_array($attributes_in_group[0])) {
			$attributes_in_group = $attributes_in_group[0];
		} else {
			$attributes_in_group = $attributes_in_group;
		}

		if(!empty($attributes_in_group)){
			foreach ($attributes_in_group as $attribute_in_group) {

				$attribute_in_group = wc_get_attribute($attribute_in_group);

				foreach ($attributes as $attribute) {

					if($attribute['is_visible'] == 0){
						continue;
					}

					if(is_object($attribute_in_group) && $attribute_in_group->slug == $attribute['name']){
						if($woocommerce_group_attributes_options['multipleAttributesInGroups'] !== "1") {
							unset($attributes[$attribute['name']]);
						}
						$temp[$attribute_group_name]['name'] = $attribute_group_name;
						$temp[$attribute_group_name]['img'] = $img;
						$temp[$attribute_group_name]['accordion_open'] = $accordion_open;
						$temp[$attribute_group_name]['attributes'][] = $attribute;
						$haveGroup[] = $attribute['name'];
					} else {
						$temp[$attribute['name']] = $attribute;
					}
				}
			}
		}
	}
} else {
	$temp = $attributes;
}

// Cleanup
foreach ($temp as $tempKey => $asd) {
	if(is_array($asd)) {
		continue;
	}
	$name = $asd->get_name();
	if(!in_array($name, $haveGroup)){
		$img = '<i class="ri-arrow-left-s-fill"></i>';

		$temp['other']['name'] = $woocommerce_group_attributes_options['moreText'];
    $temp['other']['img'] = $img;
		$temp['other']['attributes'][] = $asd;
	}
	unset($temp[$name]);
	unset($temp[$tempKey]);
}

if($woocommerce_group_attributes_options['showWeight'] == "1" && $product->has_weight()) {

	if(!isset($temp['other'])) {
		$temp['other'] = array(
			'name' => $woocommerce_group_attributes_options['moreText'],
			'img' => '',
			'attributes' => array()
		);
	}

    $attribute = new WC_Product_Attribute();
    $attribute->set_id( 0 );
    $attribute->set_name( __( 'Weight', 'woocommerce' ) );
    $attribute->set_options( array( esc_html( wc_format_weight( $product->get_weight() ) ) ) );
    $attribute->set_visible( true );
    $temp['other']['attributes'][] = $attribute;
}

if($woocommerce_group_attributes_options['showDimensions'] == "1" && $product->has_dimensions()) {

	if(!isset($temp['other'])) {
		$temp['other'] = array(
			'name' => $woocommerce_group_attributes_options['moreText'],
			'img' => '',
			'attributes' => array()
		);
	}

    $attribute = new WC_Product_Attribute();
    $attribute->set_id( 0 );
    $attribute->set_name( __( 'Dimensions', 'woocommerce' ) );
    $attribute->set_options( array( esc_html( wc_format_dimensions( $product->get_dimensions( false ) ) ) ) );
    $attribute->set_visible( true );
    $temp['other']['attributes'][] = $attribute;
}

if(!empty($woocommerce_print_products_options) && isset($woocommerce_print_products_options['showAttributesGroupHideMore']) && $woocommerce_print_products_options['showAttributesGroupHideMore'] == "1") {
	unset($temp['other']);
}

ob_start();

?>
<table class="shop_attributes woocommerce-group-attributes-layout-2">

	<?php
	foreach ($temp as $key => $attribute_group) :

		$alt2 = 1;

		?>
		<tr class="attribute_row<?php if ( ( $alt = $alt * -1 ) == 1 ) echo ' alt'; ?> attribute_row_<?php echo $key ?>">

		<?php

		if(!empty($woocommerce_print_products_options) && isset($woocommerce_print_products_options['showAttributesGroupHideGroupName']) && $woocommerce_print_products_options['showAttributesGroupHideGroupName'] == "1") {

		} else {

			if($accordionEnabled) {
				if(isset($attribute_group['accordion_open']) && $attribute_group['accordion_open'] == "1"){
					echo '<th class="attribute_group_name woocommerce-group-attributes-accordion-name woocommerce-group-attributes-accordion-name-open">';
				} else {
					echo '<th class="attribute_group_name woocommerce-group-attributes-accordion-name">';
				}
			} else {
				echo '<th class="attribute_group_name">';
			}


				if(isset($attribute_group['img']) && !empty($attribute_group['img'])){
					echo $attribute_group['img'];
				}
				echo $attribute_group['name'];

				if($accordionEnabled) {
					if(isset($attribute_group['accordion_open']) && $attribute_group['accordion_open'] == "1"){
						echo '<i class="fa fa-minus woocommerce-group-attributes-icon"></i>';
					} else {
						echo '<i class="fa fa-plus woocommerce-group-attributes-icon"></i>';
					}
				}

			echo '</th>';
		}

		echo '<td>';
			ksort($attribute_group['attributes']);

			if($accordionEnabled) {
				if(isset($attribute_group['accordion_open']) && $attribute_group['accordion_open'] == "1"){
					echo '<table class="attribute_name_values woocommerce-group-attributes-accordion-values woocommerce-group-attributes-accordion-values-open">';
				} else {
					echo '<table class="attribute_name_values woocommerce-group-attributes-accordion-values">';
				}
			} else {
				echo '<table class="attribute_name_values">';
			}


			foreach ( $attribute_group['attributes'] as $attribute ) {
				$alt = 1;
				if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
					continue;
				} else {
					$has_row = true;
				}

				// if ( ( $alt2 = $alt2 * -1 ) == 1 ){
				// 	echo ' <tr class="alt">'; }
				// else {
				//
				// }
				echo ' <tr>';
					$hasImage = apply_filters('woocommerce_attribute_name_image', wc_attribute_label( $attribute->get_name() ), $attribute->get_id());
					if($hasImage) {
						$attribute_name = $hasImage;
					} else {
						$attribute_name = wc_attribute_label( $attribute->get_name() );
					}

					$values = array();
					$color = '';
					if ( $attribute->is_taxonomy() ) {
						$attribute_taxonomy = $attribute->get_taxonomy_object();
						$attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

						foreach ( $attribute_values as $attribute_value ) {

							$hasImage = apply_filters('woocommerce_attribute_value_image', esc_html( $attribute_value->name ), $attribute_value->term_id);
							if(!empty($hasImage)) {
								$value_name = $hasImage;
							} else {
								$value_name = esc_html( $attribute_value->name );
							}

							// $value_name = esc_html($attribute_value->name);
							if ( $value_name == 'yes' ) {
								$divider = '<br>';
								$color = 'true';
								$value_name = '';
								$values[] = '<i class="ri-check-line green"></i>';
							} elseif ( $value_name == 'no' ) {
								$divider = '<br> ';
								$color = 'false';
								$value_name = '';
								$values[] = '<i class="ri-close-fill red"></i>';
							}

							if ( $attribute_taxonomy->attribute_public ) {
								$values[] = ' <a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tags">' . $value_name . '</a>';
							} else {
								$values[] = $value_name;
							}
						}
					} else {
						$values = $attribute->get_options();

						foreach ( $values as &$value ) {
							$value = make_clickable( esc_html( $value ) );
						}
					}

					if(!empty($values)) {
					echo '<td class="attribute_name">' . $attribute_name . '</td>';

					echo '<td class="attribute_value '.$color.'">';


							echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( $divider, $values ) ) ), $attribute, $values );


					echo '</td>';
					}

				echo '</tr>';
			}
		echo '</table>';
		echo '</td>';
		echo '</tr>';
	endforeach;
	?>

</table>
<?php
if ( $has_row ) {
	echo ob_get_clean();
} else {
	ob_end_clean();
}
