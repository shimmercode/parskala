<?php

/**
 * adds the 'edit table' meta box
 */
class prkSizeGuideTable
{
    /**
     * Init object
     */

    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'editSizeGuideTable'));
        add_action('add_meta_boxes', array($this, 'editSizeGuideSettings'));
        add_action('save_post_prk_size_guide', array($this, 'saveSizeGuideTable'));
        add_action('edit_post_prk_size_guide', array($this, 'saveSizeGuideTable'));
    }

    /**
     * Add meta box for size guide
     */

    public function editSizeGuideTable()
    {
        add_meta_box('prk_sizeguidetable', __('Create/modify size guide table', 'parskala'), array(
            $this,
            'renderSizeGuideTableMetaBox'
        ), 'prk_size_guide', 'normal', 'high');
    }

    /**
     * Size Guide Meta box
     *
     * @param $post
     */

    public function renderSizeGuideTableMetaBox($post)
    {
        wp_nonce_field('size_guide_meta_box', 'size_guide_meta_box_nonce');

        $current = get_current_screen()->action;

        $newpost = ($current == 'add');

        $defaultTable = array(
            array('سایز', 'نیم‌تنه', 'دور کمر', 'باسن'),
            array('XS', '32', '25', '35'),
            array('S', '34', '27', '37'),
            array('M', '36', '29', '39'),
            array('L', '39', '31', '41'),
            array('XL', '41', '35', '44'),
        );
        $defaultTitle = __( 'Table title', 'parskala' );
        $defaultCaption = __( 'Table caption', 'parskala' );

        if (!$newpost) {
            $post_id = $post->ID;
            $meta_table = get_post_meta($post_id, '_prk_sizeguide');
            $meta_table = $meta_table[0];
        } else {
            $meta_table[0] = array(
                'title' => $defaultTitle,
                'table' => $defaultTable,
                'caption' => $defaultCaption
            );
        }

        foreach ($meta_table as $key => $table) {

            if ( empty( $table['table'] ) ) {
                continue;
            }
	        $this->sizeGuideTablePreTemplate( $table, $key, '' );
	        $this->sizeGuideTableTemplate($table, $key, '');

        }

	    $this->sizeGuideTablePostTemplate( $meta_table[0], 0, '' );
    }

    public function sizeGuideTablePreTemplate($table, $key, $class = ''){

        if ( 0 == $key ) {
	        echo '<div class="prk_single_size_table' . ($class ? ' ' . $class : '') . '">';
        }

	    echo '<p class="sg-sizeGuide-title-above"><strong>' . __('Text above table', 'parskala') . '</strong></p>';

	    $args_title = array(
		    'textarea_name' => 'prk_size_guide[' . $key . '][title]',
		    'textarea_rows' => 2
	    );

	    $title = isset( $table['title'] ) ? $table['title'] : '';
	    wp_editor( $title, 'size_table_caption' . $key, $args_title);
    }

    public function sizeGuideTablePostTemplate($table, $key, $class = ''){

        echo '<div id="prk-sizeGuide-tableControl">';
        echo    '<button type="button" class="button prk-addTable">' . __( 'Add Table', 'parskala' ) . '</button>';
        echo    '<button type="button" class="button prk-delTable"><i class="free free-uniE905" aria-hidden="true"></i>' . __( 'Remove Table', 'parskala' ) . '</button>';
        echo '</div>';

	    echo '<p class="sg-sizeGuide-title-below"><strong>' . __('Table caption', 'parskala') . '</strong></p>';

	    $args_caption = array(
		    'textarea_name' => 'prk_size_guide[' . $key . '][caption]',
		    'textarea_rows' => 2
	    );

	    wp_editor($table['caption'], 'size_table_title' . $key, $args_caption);
	    echo '</div>';
    }

	/**
	 * Render table
	 *
	 * @param $table
	 * @param $key
	 * @param string $class
	 */
	public function sizeGuideTableTemplate($table, $key, $class = '')
    {
        echo '<br>';

        echo '<textarea class="prk_edit_table" name="prk_size_guide[' . $key . '][table]" style="display:none">';
        $table_array = json_encode($table['table']);
        echo $table_array;
        echo '</textarea>';
    }

    /**
     * Add size guide metabox settings
     */

    public function editSizeGuideSettings()
    {
        add_meta_box('prk_sizeguidesettings', __('Size guide settings', 'parskala'), array($this, 'renderSizeGuideSettingsMetaBox'), 'prk_size_guide', 'normal', 'high');
    }

    /**
     * Meta box
     *
     * @param $post
     */

    public function renderSizeGuideSettingsMetaBox($post)
    {
        $current = get_current_screen()->action;

        $newpost = ($current == 'add');

        if (!$newpost) {
            $post_id = $post->ID;
        } else {
            $post_id = 'new';
        }

        wp_nonce_field('size_guide_settings_meta_box', 'size_guide_settings_meta_box_nonce');

        ?>
        <div class="sg-single-setting">
            <label><?php echo __('Open guide with:', 'parskala'); ?></label>
            <select name="size_guide_settings[wc_size_guide_button_style]" class="chosen_select">
                <option value="global" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_style', 'global'); ?> ><?php echo __('Use global settings', 'parskala'); ?></option>
                <option value="prk-trigger-link" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_style', 'prk-trigger-link'); ?> > <?php echo __('Link', 'parskala'); ?></option>
                <option value="prk-trigger-button" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_style', 'prk-trigger-button'); ?> ><?php echo __('Button', 'parskala'); ?></option>
            </select>
            <small><?php echo __('Chose whether to display a simple link or a button to open the size guide.', 'parskala'); ?></small>
        </div>

        <div class="sg-single-setting">
            <label><?php echo __('Button/link position:', 'parskala'); ?></label>
            <select name="size_guide_settings[wc_size_guide_button_position]" class="chosen_select">
                <option value="global" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_position', 'global');?> ><?php echo __('Use global settings', 'parskala'); ?></option>
                <option value="prk-position-price" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_position', 'prk-position-price'); ?> ><?php echo __('Under Price', 'parskala'); ?></option>
                <option value="prk-position-summary" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_position', 'prk-position-summary'); ?>  ><?php echo __('Above the product summary tabs', 'parskala'); ?></option>
                <option value="prk-position-add-to-cart" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_position', 'prk-position-add-to-cart'); ?>  ><?php echo __('After Add To Cart button', 'parskala'); ?></option>
                <option value="prk-position-info" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_position', 'prk-position-info'); ?>  ><?php echo __('After Product Info', 'parskala'); ?></option>
                <option value="prk-position-tab" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_position', 'prk-position-tab'); ?>  ><?php echo __('Make it a tab', 'parskala'); ?></option>
                <option value="prk-position-shortcode" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_position', 'prk-position-shortcode'); ?>  ><?php echo __('Embed manually (shortcode)', 'parskala'); ?></option>
            </select>
            <small><?php echo __('For manual embed, [prk_size_guide] shortcode can be placed anywhere you want.', 'parskala'); ?></small>
        </div>

        <div>
            <div class="sg-single-setting">
                <label><?php echo __('Button/link hook priority:', 'parskala'); ?></label>
                <select name="size_guide_settings[wc_size_guide_button_priority_dropdown]" class="chosen_select" id="wc_size_guide_button_priority_dropdown">
                    <option value="global" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_priority_dropdown', 'global'); ?> ><?php echo __('Use global settings', 'parskala'); ?></option>
                    <option value="individual_priority" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_priority_dropdown', 'individual_priority'); ?> ><?php echo __('Use individual settings', 'parskala'); ?></option>
                </select>
                <small><?php echo __('Chose whether to use global or individual option to set priority of the action that outputs the button/link. Using this you can adjust the position.', 'parskala'); ?></small>
            </div>

            <script>
                ( function ( $ ) {
                    'use strict';
                    $(document).ready(function () {

                        $("#wc_size_guide_button_priority_dropdown option:selected").each(function () {
                            var selected = $(this).val();
                            if (selected == 'individual_priority') {
                                $("#individual_priority_chosen").css({"display": "block"});
                                var input = $("#individual_priority").val();
                                if (input == 'global') {
                                    $("#individual_priority").val('');
                                }
                            } else {
                                $("#individual_priority_chosen").css({"display": "none"});
                                $("#individual_priority").val('global');
                            }
                        });

                        $("#wc_size_guide_button_priority_dropdown").change(function () {
                            var selected = $(this).val();
                            if (selected == 'individual_priority') {
                                $("#individual_priority_chosen").css({"display": "block"});
                                var input = $("#individual_priority").val();
                                if (input == 'global') {
                                    $("#individual_priority").val('');
                                }
                            } else {
                                $("#individual_priority_chosen").css({"display": "none"});
                                $("#individual_priority").val('global');
                            }
                        });
                    });
                } ( jQuery ) );
            </script>

            <div class="sg-single-setting" id="individual_priority_chosen" style="display:none">
                <label><?php echo __('Individual priority:', 'parskala'); ?></label>
                <input
                    id="individual_priority"
                    value="<?php echo $this->getNumberValue($post_id, 'wc_size_guide_button_priority', 'global'); ?>"
                    name="size_guide_settings[wc_size_guide_button_priority]"
                    class="chosen_input"
                    type="text"
                />
                <small><?php echo __('Type individual priority.', 'parskala'); ?></small>
            </div>
        </div>

        <div class="sg-single-setting">
            <label><?php echo __('Tab Multiple Table:', 'parskala'); ?></label>
            <select name="size_guide_settings[wc_size_guide_tab_multiple_table]" class="chosen_select">
                <option value="global" <?php echo $this->getSelected($post_id, 'wc_size_guide_tab_multiple_table', 'global');?> ><?php echo __('Use global settings', 'parskala'); ?></option>
                <option value="yes" <?php echo $this->getSelected($post_id, 'wc_size_guide_tab_multiple_table', 'yes'); ?> ><?php echo __('Yes', 'parskala'); ?></option>
                <option value="no" <?php echo $this->getSelected($post_id, 'wc_size_guide_tab_multiple_table', 'no'); ?> ><?php echo __('No', 'parskala'); ?></option>
            </select>
            <small><?php echo __('Display content as tabs. Each table will be a separate tab. Use \'###[Tab Title]\' to mark when a text description should be broken into a new tab', 'parskala'); ?></small>
        </div>

        <div>
            <div class="sg-single-setting">
                <label><?php echo __('Button/link label:', 'parskala'); ?> </label>
                <select name="size_guide_settings[wc_size_guide_button_label_dropdown]" class="chosen_select" id="wc_size_guide_button_label_dropdown">
                    <option value="global" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_label_dropdown', 'global'); ?> ><?php echo __('Use global settings', 'parskala'); ?> </option>
                    <option value="individual_label" <?php echo $this->getSelected($post_id, 'wc_size_guide_button_label_dropdown', 'individual_label'); ?> ><?php echo __('Use individual settings', 'parskala'); ?> </option>
                </select>
                <small> <?php echo __("Chose whether to use global or individual option to display name of the size guide button/link's label.", 'parskala'); ?> </small>
            </div>


            <script>
                ( function ( $ ) {
                    'use strict';
                    $(document).ready(function () {

                        $("#wc_size_guide_button_label_dropdown option:selected").each(function () {
                            var selected = $(this).val();
                            if (selected == 'individual_label') {
                                $("#individual_label_chosen").css({"display": "block"});
                                var input = $("#individual_label").val();
                                if (input == 'global') {
                                    $("#individual_label").val('');
                                }
                            } else {
                                $("#individual_label_chosen").css({"display": "none"});
                                $("#individual_label").val('global');
                            }
                        });

                        $("#wc_size_guide_button_label_dropdown").change(function () {
                            var selected = $(this).val();
                            if (selected == 'individual_label') {
                                $("#individual_label_chosen").css({"display": "block"});
                                var input = $("#individual_label").val();
                                if (input == 'global') {
                                    $("#individual_label").val('');
                                }
                            } else {
                                $("#individual_label_chosen").css({"display": "none"});
                                $("#individual_label").val('global');
                            }
                        });
                    });
                } ( jQuery ) );
            </script>

            <?php
            echo '
            <div class="sg-single-setting" id="individual_label_chosen" style="display:none"><label>' . __('Individual label:', 'parskala') . '</label>
            <input type="text" name="size_guide_settings[wc_size_guide_button_label]" value="' . $this->getNumberValue($post_id, 'wc_size_guide_button_label', 'global') . '" class="chosen_input" id="individual_label">
            <small>' . __('Type button/link label.', 'parskala') . ' </small></div>'; ?>
        </div>

        <?php
        echo '<div class="sg-single-setting"><label>' . __('Button/link align:', 'parskala') . '</label> <select name="size_guide_settings[wc_size_guide_button_align]" class="chosen_select">
                    <option value="global" ' . $this->getSelected($post_id, 'wc_size_guide_button_align', 'global') . '>' . __('Use global settings', 'parskala') . '</option>
                    <option value="left" ' . $this->getSelected($post_id, 'wc_size_guide_button_align', 'left') . '>' . __('Left', 'parskala') . '</option>
                    <option value="right" ' . $this->getSelected($post_id, 'wc_size_guide_button_align', 'right') . '>' . __('Right', 'parskala') . '</option>
               </select></div>';

        echo '<div class="sg-single-setting"><label>' . __('Button/link clearing:', 'parskala') . '</label> <select name="size_guide_settings[wc_size_guide_button_clear]" class="chosen_select">
                    <option value="global" ' . $this->getSelected($post_id, 'wc_size_guide_button_clear', 'global') . '>' . __('Use global settings', 'parskala') . '</option>
                    <option value="yes" ' . $this->getSelected($post_id, 'wc_size_guide_button_clear', 'yes') . '>' . __('Yes', 'parskala') . '</option>
                    <option value="no" ' . $this->getSelected($post_id, 'wc_size_guide_button_clear', 'no') . '>' . __('No', 'parskala') . '</option>
               </select><small>   ' . __('Allow floating elements on the sides of the link/button?', 'parskala') . '</small></div>';

        ?>
        <div>
            <?php
            echo '<div class="sg-single-setting"><label>' . __('Button class:', 'parskala') . '</label>
                    <select name="size_guide_settings[wc_size_guide_button_class_dropdown]" class="chosen_select" id="wc_size_guide_button_class_dropdown">
                        <option value="global" ' . $this->getSelected($post_id, 'wc_size_guide_button_class_dropdown', 'global') . '>' . __('Use global settings', 'parskala') . '</option>
                        <option value="individual_class" ' . $this->getSelected($post_id, 'wc_size_guide_button_class_dropdown', 'individual_class') . '>' . __('Use individual settings', 'parskala') . '</option>
                    </select>
                    <small>' . __("Chose whether to use global or individual option to set custom class of the size guide button.", 'parskala') . '</small></div>'; ?>

            <script>
                ( function ( $ ) {
                    'use strict';
                    $(document).ready(function () {

                        $("#wc_size_guide_button_class_dropdown option:selected").each(function () {
                            var selected = $(this).val();
                            if (selected == 'individual_class') {
                                $("#individual_class_chosen").css({"display": "block"});
                                var input = $("#individual_class").val();
                                if (input == 'global') {
                                    $("#individual_class").val('');
                                }

                            } else {
                                $("#individual_class_chosen").css({"display": "none"});
                                $("#individual_class").val('global');
                            }
                        });

                        $("#wc_size_guide_button_class_dropdown").change(function () {
                            var selected = $(this).val();
                            if (selected == 'individual_class') {
                                $("#individual_class_chosen").css({"display": "block"});
                                var input = $("#individual_class").val();
                                if (input == 'global') {
                                    $("#individual_class").val('');
                                }
                            } else {
                                $("#individual_class_chosen").css({"display": "none"});
                                $("#individual_class").val('global');
                            }
                        });
                    });
                } ( jQuery ) );
            </script>

            <?php
            echo '
                    <div class="sg-single-setting" id="individual_class_chosen" style="display:none"><label>' . __('Individual class:', 'parskala') . '</label>
                    <input type="text" name="size_guide_settings[wc_size_guide_button_class]" value="' . $this->getNumberValue($post_id, 'wc_size_guide_button_class', 'global') . '" class="chosen_input" id="individual_class">
                    <small>' . __('Add a custom class to the button. Default class which we use is button_sg', 'parskala') . '</small></div>'; ?>
        </div>
        <?php

        ?>
        <div>
            <?php
            echo '<div class="sg-single-setting"><label>' . __('Margins of the link/button:', 'parskala') . '</label>
            <select name="size_guide_settings[wc_size_guide_button_margins_dropdown]" class="chosen_select" id="wc_size_guide_button_margins_dropdown">
                   <option value="global" ' . $this->getSelected($post_id, 'wc_size_guide_button_margins_dropdown', 'global') . '>' . __('Use global settings', 'parskala') . '</option>
                   <option value="individual_margins" ' . $this->getSelected($post_id, 'wc_size_guide_button_margins_dropdown', 'individual_margins') . '>' . __('Use individual settings', 'parskala') . '</option>
                   </select>
                   <small>' . __("Chose whether to use global or individual option to set button/link margins.", 'parskala') . '</small></div>'; ?>
            <script>
                ( function ( $ ) {
                    'use strict';
                    $(document).ready(function () {

                        $("#wc_size_guide_button_margins_dropdown option:selected").each(function () {
                            var selected = $(this).val();
                            if (selected == 'individual_margins') {
                                $("#individual_margins_chosen").css({"display": "block"});
                                var input_left = $("#individual_margins_left").val();

                                if (input_left == 'global') {
                                    $("#individual_margins_left").val('');
                                    $("#individual_margins_top").val('');
                                    $("#individual_margins_right").val('');
                                    $("#individual_margins_bottom").val('');
                                }
                            } else {
                                $("#individual_margins_chosen").css({"display": "none"});
                                $("#individual_margins_left").val('global');
                                $("#individual_margins_top").val('global');
                                $("#individual_margins_right").val('global');
                                $("#individual_margins_bottom").val('global');
                            }
                        });

                        $("#wc_size_guide_button_margins_dropdown").change(function () {
                            var selected = $(this).val();

                            if (selected == 'individual_margins') {
                                $("#individual_margins_chosen").css({"display": "block"});
                                var input_left = $("#individual_margin_left").val();
                                if (input_left == 'global') {
                                    $("#individual_margin_left").val('');
                                    $("#individual_margin_top").val('');
                                    $("#individual_margin_right").val('');
                                    $("#individual_margin_bottom").val('');
                                }
                            } else {
                                $("#individual_margins_chosen").css({"display": "none"});
                                $("#individual_margin_left").val('global');
                                $("#individual_margin_top").val('global');
                                $("#individual_margin_right").val('global');
                                $("#individual_margin_bottom").val('global');
                            }
                        });
                    });
                } ( jQuery ) );
            </script>

            <?php
            echo '
               <div class="sg-single-setting" id="individual_margins_chosen" style="display:none">

               <div class="prk-number-input"><input type="text" value="' . $this->getNumberValue($post_id, 'wc_size_guide_button_margin_left', 'global') . '" name="size_guide_settings[wc_size_guide_button_margin_left]" class="chosen_input" id="individual_margin_left" placeholder="0"><span>' . __('Margin left', 'parskala') . '</span></div>
               <div class="prk-number-input"><input type="text" value="' . $this->getNumberValue($post_id, 'wc_size_guide_button_margin_top', 'global') . '" name="size_guide_settings[wc_size_guide_button_margin_top]" class="chosen_input" id="individual_margin_top" placeholder="0"><span>' . __('Margin top', 'parskala') . '</span></div>
               <div class="prk-number-input"><input type="text" value="' . $this->getNumberValue($post_id, 'wc_size_guide_button_margin_right', 'global') . '" name="size_guide_settings[wc_size_guide_button_margin_right]" class="chosen_input" id="individual_margin_right" placeholder="0"><span>' . __('Margin right', 'parskala') . '</span></div>
               <div class="prk-number-input"><input type="text" value="' . $this->getNumberValue($post_id, 'wc_size_guide_button_margin_bottom', 'global') . '" name="size_guide_settings[wc_size_guide_button_margin_bottom]" class="chosen_input" id="individual_margin_bottom" placeholder="0"><span>' . __('Margin bottom', 'parskala') . '</span></div>
               <div>&nbsp;</div></div>';
            ?>
        </div>
        <?php
        //If there is not changed color, it takes global color which is black.
        // $globalColor = new prkSizeGuideSettings();
        // $globalColor = $globalColor->wcSizeGuidePopupOverlayColorGlobal();
        // echo '<div class="sg-single-setting"><label>' . __('Popup overlay color:', 'parskala') . '</label><input type="text" name="size_guide_settings[wc_size_guide_overlay_color]" class="prk-sg-color" value="' . $this->getNumberValue($post_id, 'wc_size_guide_overlay_color', $globalColor) . '"><small>' . __('Click to pick the color of the popup background overlay. Get global option by clicking clear and update', 'parskala') . '</small></div>';

        ?>
        <div>
            <?php
            echo '<div class="sg-single-setting"><label>' . __('Popup window content paddings:', 'parskala') . '</label>
        <select name="size_guide_settings[wc_size_guide_modal_padding_dropdown]" class="chosen_select" id="wc_size_guide_modal_padding_dropdown">
                 <option value="global" ' . $this->getSelected($post_id, 'wc_size_guide_modal_padding_dropdown', 'global') . '>' . __('Use global settings', 'parskala') . '</option>
                 <option value="individual_paddings" ' . $this->getSelected($post_id, 'wc_size_guide_modal_padding_dropdown', 'individual_paddings') . '>' . __('Use individual settings', 'parskala') . '</option>
                 </select>
                 <small>' . __("Chose whether to use global or individual option to set popup window content paddings.", 'parskala') . '</small></div>'; ?>

            <script>
                ( function ( $ ) {
                    'use strict';
                    $(document).ready(function () {

                        $("#wc_size_guide_modal_padding_dropdown option:selected").each(function () {
                            var selected = $(this).val();
                            if (selected == 'individual_paddings') {
                                $("#individual_paddings_chosen").css({"display": "block"});
                                var input_left;
                                input_left = $("#individual_padding_left").val();
                                if (input_left == 'global') {
                                    $("#individual_padding_left").val('');
                                    $("#individual_padding_top").val('');
                                    $("#individual_padding_right").val('');
                                    $("#individual_padding_bottom").val('');
                                }
                            } else {
                                $("#individual_paddings_chosen").css({"display": "none"});
                                $("#individual_padding_left").val('global');
                                $("#individual_padding_top").val('global');
                                $("#individual_padding_right").val('global');
                                $("#individual_padding_bottom").val('global');
                            }
                        });

                        $("#wc_size_guide_modal_padding_dropdown").change(function () {
                            var selected = $(this).val();

                            if (selected == 'individual_paddings') {
                                $("#individual_paddings_chosen").css({"display": "block"});
                                var input_left;
                                input_left = $("#individual_padding_left").val();
                                if (input_left == 'global') {
                                    $("#individual_padding_left").val('');
                                    $("#individual_padding_top").val('');
                                    $("#individual_padding_right").val('');
                                    $("#individual_padding_bottom").val('');
                                }
                            } else {
                                $("#individual_paddings_chosen").css({"display": "none"});
                                $("#individual_padding_left").val('global');
                                $("#individual_padding_top").val('global');
                                $("#individual_padding_right").val('global');
                                $("#individual_padding_bottom").val('global');
                            }
                        });
                    });
                } ( jQuery ) );
            </script>

            <?php
            echo '
        <div class="sg-single-setting" id="individual_paddings_chosen" style="display:none">
        <div class="prk-number-input"><input type="text" value="' . $this->getNumberValue($post_id, 'wc_size_guide_modal_padding_left', 'global') . '" name="size_guide_settings[wc_size_guide_modal_padding_left]" class="chosen_input" id="individual_padding_left"><span>' . __('Padding left', 'parskala') . '</span></div>
        <div class="prk-number-input"><input type="text" value="' . $this->getNumberValue($post_id, 'wc_size_guide_modal_padding_top', 'global') . '" name="size_guide_settings[wc_size_guide_modal_padding_top]" class="chosen_input" id="individual_padding_top"><span>' . __('Padding top', 'parskala') . '</span></div>
        <div class="prk-number-input"><input type="text" value="' . $this->getNumberValue($post_id, 'wc_size_guide_modal_padding_right', 'global') . '" name="size_guide_settings[wc_size_guide_modal_padding_right]" class="chosen_input" id="individual_padding_right"><span>' . __('Padding right', 'parskala') . '</span></div>
        <div class="prk-number-input"><input type="text" value="' . $this->getNumberValue($post_id, 'wc_size_guide_modal_padding_bottom', 'global') . '" name="size_guide_settings[wc_size_guide_modal_padding_bottom]" class="chosen_input" id="individual_padding_bottom"><span>' . __('Padding bottom', 'parskala') . '</span></div>
        <div>&nbsp;</div></div>';
            ?>

        </div>

        <?php
    }

    /**
     * Gets the post - size guide's settings input values if there was selected individual option. If the post - size guide, is a new one, then it takes values from global options
     * @param $id - post/size guide's id
     * @param $opt - key name - option
     * @param string $default - default value - now it is global option from Woocommerce Settings
     * @return mixed|string|void
     */

    protected function getNumberValue($id, $opt, $default = 'null')
    {
        if ($id != 'new') {
            $val = get_post_meta($id, '_prk_sizeguidesettings');

            if ($val === '' || !isset($val[0])) {           //If settings are empty or are not set, every option takes global value
                $val = get_option($opt, $default);
            } else {                                        //Option takes inputed value
                $val = $val[0];
                $val = $val[$opt];

                if ($val == "" || !isset($val)) {
                    $val = $default;
                    if ($default == 'global') {
                        $val = get_option($opt, $default);
                    }
                }
            }
        } else {                                            //If it's new post - size guide, it takes default value
            $val = get_option($opt, $default);
        }

        return $val;
    }

    /**
     * Gets the post - size guide's settings. Checkes whether selected options of size guides are global or individual.
     * @param $id - post/size guide's id
     * @param $opt - key name - option
     * @param $val - value of selected option
     * @return string - 'selected="selected"' or empty string
     */

    protected function getSelected($id, $opt, $val)
    {
        $selected = ''; //Default $selected is empty
        if ($id != 'new') {
            $a = get_post_meta($id, '_prk_sizeguidesettings');
            if (!isset($a[0])) { //If there is no value in key, it returns empty string
                return '';
            }
            $a = $a[0];
            @$a = $a[$opt]; //$a[0][$opt] ex. a[0]['wc_size_guide_button_label'] => string 'Size Guide' or 'global'

            if ($a == $val) { //If $a ex. 'wc_size_guide_button_label' == third value from called method, means that this option is selected
                $selected = 'selected="selected"';
            }

        } else { //If it is new post - size guide, checks whether third value from called method == 'global', if yes, means that this option is selected
            if ($val == 'global') {
                $selected = 'selected="selected"';
            }
        }
        return $selected;
    }

    /**
     * Store data
     *
     * @param $post_id
     */

    public function saveSizeGuideTable($post_id)
    {
        if (!isset($_POST['size_guide_meta_box_nonce']) || !isset($_POST['size_guide_settings_meta_box_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['size_guide_meta_box_nonce'], 'size_guide_meta_box') || !wp_verify_nonce($_POST['size_guide_settings_meta_box_nonce'], 'size_guide_settings_meta_box')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['size_guide']) && 'page' == $_POST['size_guide']) {

            if (!current_user_can('edit_page', $post_id)) {
                return;
            }

        } else {

            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }

        if (!isset($_POST['prk_size_guide'])) {
            return;
        }

        $sizeguide = $_POST['prk_size_guide'];
        $sgsettings = $_POST['size_guide_settings'];

	    foreach ( $sizeguide as $key => $val ) {
		    $sizeguide[$key]['table'] = json_decode(stripslashes($sizeguide[$key]['table']));
	    }

	    update_post_meta($post_id, '_prk_sizeguide', $sizeguide);
        update_post_meta($post_id, '_prk_sizeguidesettings', $sgsettings);
    }
}

new prkSizeGuideTable();
