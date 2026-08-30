<?php

class WooCommerce_Group_Attributes_Post_Type  extends WooCommerce_Group_Attributes {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of this plugin.
	 */
	protected $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function init()
	{
		global $woocommerce_group_attributes_options;


		$this->options = get_option( 'prk_option' );


		$this->register_attribute_group();
		$this->register_attribute_group_taxonomy();
	}

	public function register_attribute_group()
	{
		$labels = array(
			'name'                => __( 'Attribute Groups', 'parskala' ),
			'singular_name'       => __( 'Attribute Group', 'parskala' ),
			'add_new'             => _x( 'Add New Attribute Group', 'parskala', 'parskala' ),
			'add_new_item'        => __( 'Add New Attribute Group', 'parskala' ),
			'edit_item'           => __( 'Edit Attribute Group', 'parskala' ),
			'new_item'            => __( 'New Attribute Group', 'parskala' ),
			'view_item'           => __( 'View Attribute Group', 'parskala' ),
			'search_items'        => __( 'Search Attribute Groups', 'parskala' ),
			'not_found'           => __( 'No Attribute Groups found', 'parskala' ),
			'not_found_in_trash'  => __( 'No Attribute Groups found in Trash', 'parskala' ),
			'parent_item_colon'   => __( 'Parent Attribute Group:', 'parskala' ),
			'menu_name'           => __( 'Attribute Groups', 'parskala' ),
		);

		$args = array(
	      'public' => false,
	      'labels' => $labels,
	      'show_ui' => true,
	      'supports' => array('title'),
	      'show_in_menu' => 'edit.php?post_type=product',
	      'supports' => array('title', 'page-attributes'),
	      'hierarchical' => false,
	      'taxonomies' => array('product_cat'),
	    );
		// if($this->get_option('enableAttributeGroupCategories')) {
		// 	$args['taxonomies'] = 'attribute_group_categories';
		// }

	    register_post_type( 'attribute_group', $args );
	}

	public function register_attribute_group_taxonomy()
	{
		if(!$this->get_option('enableAttributeGroupCategories')) {
			return;
		}

        $singular = __('Attribute Group Category', 'parskala');
        $plural = __('Attribute Group Categories', 'parskala');

        $labels = array(
            'name' => $plural,
            'singular_name' => $singular,
            'search_items' => sprintf(__('Search %s', 'parskala'), $plural),
            'all_items' => sprintf(__('All %s', 'parskala'), $plural),
            'parent_item' => sprintf(__('Parent %s', 'parskala'), $singular),
            'parent_item_colon' => sprintf(__('Parent %s:', 'parskala'), $singular),
            'edit_item' => sprintf(__('Edit %s', 'parskala'), $singular),
            'update_item' => sprintf(__('Update %s', 'parskala'), $singular),
            'add_new_item' => sprintf(__('Add New %s', 'parskala'), $singular),
            'new_item_name' => sprintf(__('New %s Name', 'parskala'), $singular),
            'menu_name' => $plural,
        );

        $args = array(
                'labels' => $labels,
                'public' => false,
                'hierarchical' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
        );

        register_taxonomy('attribute_group_categories', 'attribute_group', $args);
	}

	public function columns_head($columns){
		$output = array();

		$columns['menu_order'] = 'Order';

		foreach($columns as $column => $name){

			$output[$column] = $name;

			if($column === 'title'){
				$output['attributes'] = __('Attributes','parskala');
			}
		}
		return $output;
	}

	public function columns_content($column_name){
		global $post;

		if($column_name == 'menu_order'){
	      	$order = $post->menu_order;
     		echo $order;
		}

		if($column_name !== 'attributes'){
			return;
		}

		$argss = array('type' =>'select_advanced', 'multiple' => true);
		$attribute_groups = get_post_meta($post->ID, 'woocommerce_group_attributes_attributes');
		if(isset($attribute_groups[0]) && is_array($attribute_groups[0])) {
			$attribute_groups = $attribute_groups[0];
		} else {
			$attribute_groups = $attribute_groups;
		}

		$attribute_taxonomies = wc_get_attribute_taxonomies();

		foreach($attribute_groups as $attribute_group){
			$id = $attribute_group;

			$name = "";
			foreach ($attribute_taxonomies as $key => $value) {

				if($value->attribute_id == $id) {
					$name = $value->attribute_label . ' (ID: ' . $value->attribute_id . ')';
				}
			}

			echo "<strong>" . $name . '</strong></br>';
		}
	}

	public function attribute_group_order($query)
	{

		if('attribute_group' != $query->get( 'post_type' )) {
			return false;
		}

 		$query->set( 'orderby', 'menu_order');

	}

    /**
     * Add custom ticket metaboxes
     * @param   [type]                       $post_type [description]
     * @param   [type]                       $post      [description]
     */
    public function add_custom_metaboxes($post_type, $post)
    {
        add_meta_box('woocommerce-group-attributes-agent', 'ویژگی ها', array($this, 'attributes'), 'attribute_group', 'normal', 'high');
    }

    /**
     * Display Metabox Short Information
     * @return  [type]                       [description]
     */
    public function attributes()
    {
        global $post;

        wp_nonce_field(basename(__FILE__), 'woocommerce_group_attributes_meta_nonce');

        $prefix = 'woocommerce_group_attributes_';

		$image = get_post_meta($post->ID, $prefix . 'image', true);
		$accordion_open = get_post_meta($post->ID, $prefix . 'accordion_open', true);
		$accordion_compare_open = get_post_meta($post->ID, $prefix . 'accordion_compare_open', true);
        $attributes = get_post_meta($post->ID, $prefix . 'attributes');

        if(isset($attributes[0]) && !empty($attributes[0])) {
        	$attributes = $attributes[0];
        } else {
        	$attributes = array();
        }


        // $possibleAttributes = $this->get_possible_attributes();
        $possibleAttributes = wc_get_attribute_taxonomies();

        echo '<label for="' . $prefix . 'attributes">ویژگی ها:</label><br/>';
        $order = "";
        if(!empty($attributes)) {
        	$order = 'data-order="' . implode(',', $attributes) . '"';
        }

        echo '<select name="' . $prefix . 'attributes[]" multiple="multiple" style="height: 100%;" ' . $order . ' size=30>';

        foreach ($possibleAttributes as $possibleAttribute) {
        	$selected = "";
        	if(!empty($attributes)) {
        		foreach ($attributes as $attribute) {
        			echo $attribute;
        			if($attribute == $possibleAttribute->attribute_id) {
        				$selected = 'selected="selected"';
        			}
        		}
        	}
        	echo '<option ' . $selected . 'value="' . $possibleAttribute->attribute_id . '">' . $possibleAttribute->attribute_label . ' (ID: ' . $possibleAttribute->attribute_id . ')</option>';
        }
        echo '</select>';



        echo '<br/><br/><label for="' . $prefix . 'image">ایکن:</label><br/>';
        echo '<input name="' . $prefix . 'image" value="' . $image . '" type="text">';

    }

    /**
     * Save Custom Metaboxes
     * @param   [type]                       $post_id [description]
     * @param   [type]                       $post    [description]
     * @return  [type]                                [description]
     */
    public function save_custom_metaboxes($post_id, $post)
    {
    	global $woocommerce_group_attributes_options;

    	if($post->post_type !== "attribute_group") {
    		return false;
    	}

        // Is the user allowed to edit the post or page?
        if (!current_user_can('edit_post', $post->ID)) {
            return $post->ID;
        }

        if (!isset($_POST['woocommerce_group_attributes_meta_nonce']) || !wp_verify_nonce($_POST['woocommerce_group_attributes_meta_nonce'], basename(__FILE__))) {
            return false;
        }

        $prefix = 'woocommerce_group_attributes_';
        $attribute_group_meta[$prefix . 'attributes'] = isset($_POST[$prefix . 'attributes']) ? $_POST[$prefix . 'attributes'] : '';
        $attribute_group_meta[$prefix . 'accordion_open'] = isset($_POST[$prefix . 'accordion_open']) ? $_POST[$prefix . 'accordion_open'] : '';
        $attribute_group_meta[$prefix . 'accordion_compare_open'] = isset($_POST[$prefix . 'accordion_compare_open']) ? $_POST[$prefix . 'accordion_compare_open'] : '';
        $attribute_group_meta[$prefix . 'image'] = isset($_POST[$prefix . 'image']) ? $_POST[$prefix . 'image'] : '';

		if($this->options['multipleAttributesInGroups'] == "0"){

			$args = array( 'posts_per_page' => -1, 'post_type' => 'attribute_group', 'post_status' => 'publish', 'exclude' => $post_id);
			$attribute_groups = get_posts( $args );

			$already_grouped = array();
			foreach ($attribute_groups as $attribute_group) {
				$attributes_in_group = get_post_meta($attribute_group->ID, $prefix . 'attributes');
				foreach ($attributes_in_group as $attribute_in_group) {
					$already_grouped[] = $attribute_in_group;
				}
			}

			$temp = array();
			foreach ($attribute_group_meta[$prefix . 'attributes'] as $attribute) {

				if(!in_array($attribute, $already_grouped)){
					$temp[$attribute] = $attribute;
				}
			}

			 $attribute_group_meta[$prefix . 'attributes'] = $temp;
		}

        // Add values of $ticket_meta as custom fields
        foreach ($attribute_group_meta as $key => $value) {
            if ($post->post_type == 'revision') {
                return;
            }
            update_post_meta($post->ID, $key, $value);
        }
    }

    /**
     * [show_attribute_group_toolbar description]
     * @return  [type]                       [description]
     */
    public function show_attribute_group_toolbar()
    {
		add_thickbox();

		$attribute_groups = get_posts(array(
			'post_type' => 'attribute_group',
			'post_status' => 'publish',
			'posts_per_page' => -1
		));

		?>

		<p class="toolbar">
			<?php
			if($this->get_option('enableAttributeGroupCategories')) {
				$attribute_group_categories = get_terms( array(
					'taxonomy' => 'attribute_group_categories',
					'hide_empty' => true,
				) );

			?>
			<button type="button" id="load_attribute_group_category" class="button button-primary" style="float: right;margin: 0 0 0 6px;"><?php _e('Load','parskala'); ?></button>
			<select id="woocommerce_attribute_group_categories" name="woocommerce_attribute_group_categories" class="woocommerce_attribute_group_categories" style="float: right;margin: 0 0 0 6px;">
				<option value=""><?php _e('Attribute Groups Categories','parskala'); ?></option>
				<?php
				foreach ($attribute_group_categories as $attribute_group_category) {

					$attribute_groups_in_category = get_posts(
					    array(
					        'posts_per_page' => -1,
					        'post_type' => 'attribute_group',
					        'fields'        => 'ids',
					        'tax_query' => array(
					            array(
					                'taxonomy' => 'attribute_group_categories',
					                'field' => 'term_id',
					                'terms' => $attribute_group_category->term_id,
					            )
					        )
					    )
					);

					if(empty($attribute_groups_in_category)) {
						continue;
					}

					echo '<option value="' . $attribute_group_category->term_id . '" data-attribute-groups="' . implode(',', $attribute_groups_in_category) . '">' . $attribute_group_category->name . '</option>';
				}
				?>
			</select>

			<?php
			}
			?>

			<button type="button" id="load_attribute_group" class="button button-primary" style="float: right;margin: 0 0 0 6px;"><?php _e('Load','parskala'); ?></button>
			<select id="woocommerce_attribute_groups" name="woocommerce_attribute_groups" class="woocommerce_attribute_groups" style="float: right;margin: 0 0 0 6px;">
				<option value=""><?php _e('Attribute Groups','parskala'); ?></option>
				<?php
				foreach ($attribute_groups as $attribute_group) {
					echo '<option value="' . $attribute_group->ID . '">' . $attribute_group->post_title . '</option>';
				}
				?>
			</select>

		</p>
		<?php
    }

    public function get_attributes_by_attribute_group_id()
    {
		global $wpdb;

    	$attribute_group_id = (isset($_POST['attribute_group_id']) && !empty($_POST['attribute_group_id'])) ? $_POST['attribute_group_id'] : "";
    	if(empty($attribute_group_id)) {
    		die('no id given!');
    	}

    	$attributes = get_post_meta($attribute_group_id, 'woocommerce_group_attributes_attributes');
    	if(!empty($attributes)) {
    		$temp = array();
    		foreach ($attributes[0] as $attribute_id) {

    			$attribute = wc_get_attribute($attribute_id);

    			$temp[] = array(
    				'taxonomy' => $attribute->slug,
    				'i' => $attribute_id
    			);
    		}
    		$attributes = $temp;
    	}
    	die(json_encode($attributes));
    }



    function add_attribute_categories_menu() {
		    if($this->get_option('enableAttributeGroupCategories')) {
		    	// code...

		        add_submenu_page(
		            'edit.php?post_type=product',
		            __('Attribute Group Categories', 'parskala'),
		            __('Attribute Group Categories', 'parskala'),
		            'manage_options',
		            'edit-tags.php?taxonomy=attribute_group_categories&post_type=attribute_group'
		        );
		    }
		}
}
