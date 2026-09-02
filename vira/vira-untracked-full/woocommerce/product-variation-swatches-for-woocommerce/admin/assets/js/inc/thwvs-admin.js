var thwvsf_settings = (function($, window, document) {
   
    'use strict';
    var mediaUploader;
  
    var MSG_INVALID_NAME = 'NAME/ID must begin with a lowercase letter ([a-z]) and may be followed by any number of lowercase letters, digits ([0-9]) and underscores ("_")';
      
    /*------------------------------------
    *---- ON-LOAD FUNCTIONS - SATRT ----- 
    *------------------------------------*/

    $(function() {

        $( document ).on( 'click', '.thwvsf-free-banner .notice-dismiss', function() {

            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: { 
                    security: thwvsf_var.ajax_banner_nonce, 
                    action: 'dismiss_thwvsf_upgrade_notice' },

                success: function (data) {
                    
                },
                error: function () {
                    alert("error");
                },
            });
        });

        var settings_div = $('#edittag'),
          add_tag_div = $('#addtag'),
          advanced_settings_div = $('#advanced_settings_form'),
          custom_attr_div = $('.thwvsf-custom-table'),
          design_settings_div = $('#thwvs_design_form');

        thwvsf_base.setupColorPicker(advanced_settings_div);
        thwvsf_base.setupColorPicker(settings_div);
        thwvsf_base.setupColorPicker(add_tag_div);
        thwvsf_base.setupColorPicker(custom_attr_div);
        thwvsf_base.setupColorPicker(design_settings_div);

        var tabs_wrapper = $('.thwvsadmin-wrapper');
        var last_active_tab = $('#last_active_tab').val();

        thwvsf_base.setup_form_side_popup();
    });


    function upload_icon_image(elm, e){
        
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
            text: 'Choose Image'
        },  multiple: false });
        // When a file is selected, grab the URL and set it as the text field's value
        var $image_div =  $(elm).parents('.thwvsf-upload-image'),
            $index_media_image = $image_div.find('.i_index_media_img'),
            $index_media = $image_div.find('.i_index_media'),
            $remove_button = $image_div.find('.thwvsf_remove_image_button');
        
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();      
            $index_media_image.attr('src', attachment.url);
            $index_media.val(attachment.id);
            $('.thwvsf_remove_uploaded').show();
            $remove_button.show();

        });

        mediaUploader.open();
    }

    var placeholder = thwvsf_var.placeholder_image;

    function remove_icon_image(elm,e){
        var $image_div =  $(elm).parents('.thwvsf-upload-image'),
            $index_media_image = $image_div.find('.i_index_media_img'),
            $index_media = $image_div.find('.i_index_media'),
            $remove_button = $image_div.find('.thwvsf_remove_image_button');

        $index_media_image.attr( 'src',placeholder);
        $index_media.val( '' );
        $remove_button.hide();
        return false;
    }

    function change_term_type(elm,e){
        var type = $(elm).val(),
            form = $(elm).closest('.thwvsf_custom_attribute');

        var custom_attr_div = $('.thwvsf-custom-table');
        thwvsf_base.setupColorPicker(custom_attr_div);

        if(type == 'select'){
            form.find($(".thwvsf-custom-table")).hide();
        }else{
            form.find($(".thwvsf-custom-table")).hide();
            form.find($(".thwvsf-custom-table-"+ type)).show();
            form.find($(".th-tooltip-row")).show();
        }

        if(type == 'select'){
            form.find($(".th-tooltip-row")).hide();
        }else{
            form.find($(".th-tooltip-row")).show();
        }
    }

    function open_term_body(elm, e){
        var element = $(elm);
        var parent = $(elm).closest('td');
        var parent_table = $(elm).closest('table');

        if(!element.hasClass('open')){
            parent_table.find('.thwvsf-local-body').hide();
            parent.find('.thwvsf-local-body').show('slow');

            parent_table.find('.thwvsf-local-head').removeClass('open');
            element.addClass('open');
        }else{
            element.removeClass('open');
            parent.find('.thwvsf-local-body').hide();
        }
    }

    var DESIGN_FORM_FIELDS = {

        design_name : {name : 'design_name', label : ' Design Name', type : 'text', value : ''},

        icon_height : {name : 'icon_height',  type : 'text', value : '45px'},
        icon_width  : {name : 'icon_height',  type : 'text', value : '45px'},
        icon_shape  : {name : 'icon_shape',type : 'select', value : '0px'},

        icon_label_height : {name : 'icon_height',  type : 'text', value : '45px'},
        icon_label_width  : {name : 'icon_height',  type : 'text', value : '45px'},
        label_size             : {name : 'label_size', type : 'text', value : '16px'},
        label_background_color : {name : 'label_background_color', type : 'colorpicker', value :'#fff'},
        label_text_color       : {name : 'label_text_color', type : 'colorpicker', value :'#000'},

        icon_border_color_hover    : {name : 'icon_border_color_hover', type : 'colorpicker', value :'#aaaaaa'},
        icon_border_color_selected : {name : 'icon_border_color_selected', type : 'colorpicker', value :'#827d7d'},

        tooltip_enable                : {name : 'tooltip_enable', type : 'checkbox', value :0},
        tooltip_text_background_color : {name : 'tooltip_text_background_color', type : 'colorpicker', value :'#000000'},
        tooltip_text_color            : {name : 'tooltip_text_color', type : 'colorpicker', value :'#ffffff'},  

    };


    $( document ).ajaxComplete( function( event, request, options ) {
        if ( request && 4 === request.readyState && 200 === request.status
        && options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

            var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
            if ( ! res || res.errors ) {
                return;
            }
            // Clear Thumbnail fields on submit
            $('.i_index_media_img' ).attr( 'src', placeholder);
            $('.i_index_media').val('');
            $('#product_cat_thumbnail_id' ).val( '' );
            $('.thwvsf_remove_image_button' ).hide();
            $('.thwvsf_settings_fields_form').find('.thpladmin-colorpickpreview').css('background-color','');
            return;
        }

        if ( request && 4 === request.readyState && 200 === request.status
        && options.data && 0 <= options.data.indexOf( 'action=woocommerce_save_attributes' ) ) {
            var this_page = window.location.toString();
            this_page = this_page.replace( 'post-new.php?', 'post.php?post=' + woocommerce_admin_meta_boxes.post_id + '&action=edit&' );
            var custom_attr_div = $('.thwvs-custom-table');

            $('#thwvs-product-attribute-settings').load(this_page+' #custom_variations_inner',function(){
                $('#thwvs-product-attribute-settings').trigger( 'reload' );
                thwvsf_base.setupColorPicker($('.th-custom-attr-color-td'));
                $('#thwvs-product-attribute-settings').trigger('init_tooltips');
            });
        }

    });

    function edit_design_form(elm, design_styles, design_id, des_title){

        open_design_form('edit', design_styles, design_id, elm, des_title);
    }

    function open_design_form(type, valueJson, design_id, elm, des_title ){

        des_title = $('<div/>').html(des_title).text();

        var container = $('#thwvs_design_form_pp'),
            form = $('#thwvs_design_form');

        populate_design_form(form,type, valueJson, container, des_title );
        form.find("input[name=thwvsf_design_id]").val(design_id);

        open_design_popup(elm, valueJson, design_id);
        form.find("input[name=i_design_name]").val(des_title);
    }

    function populate_design_form(form, type, valueJson, container, des_title){

        

        var title = (type === 'edit' &&  des_title) ? des_title : 'New Design Style';

        container.find('.pp-title').text(title);
        if(type === 'new'){

            set_form_field_values(form, DESIGN_FORM_FIELDS, false);
        }else{

            set_form_field_values(form, DESIGN_FORM_FIELDS, valueJson);
        }
    }


    function set_form_field_values(form, fields, valuesJson){

        var sname = valuesJson && valuesJson['name'] ? valuesJson['name'] : '';
        
        $.each( fields, function( name, field ) {
            var type     = field['type'],                                 
                value    = valuesJson && valuesJson[name] ? valuesJson[name] : field['value'],
                multiple = field['multiple'] ? field['multiple'] : 0;

            if(type === 'checkbox'){
                if(!valuesJson && field['checked']){
                    value = field['checked'];
                }
            }
            name = name;

            thwvsf_base.set_property_field_value(form, type, name, value, multiple);
        });


        form.find("select[name=i_attr_selection_style]").change();
    }

    function open_design_popup(elm, design_values, design_id){

        var popup = $("#thwvs_design_form_pp");

        if ($('.popup-wrapper').hasClass('dismiss')) {

           $('.popup-wrapper').removeClass('dismiss').addClass('selected').show();
        }

        $('.thwvs-template-preview-wrapper .thwvs-template-box').removeClass('design-active');

        $('.thwvs-design-templates.thwvs-template-popup').addClass('pop-active');
        $('.product_page_th_product_variation_swatches_for_woocommerce').addClass('thwvs-body-deactive');

        $(elm).closest('.thwvs-template-box').addClass('design-active');
        popup.find('ul.pp_nav_tabs li').first().click();
    }

    function close_design_popup(elm){
        if ($('.popup-wrapper').hasClass('selected')) {
            
            $('.popup-wrapper').removeClass('selected').addClass('dismiss');

            var container = $('#thwvs_design_form_container');
            container.css("display", "none");
        }

        $('.thwvs-design-templates.thwvs-template-popup').removeClass('pop-active');
        $('.product_page_th_product_variation_swatches_for_woocommerce').removeClass('thwvs-body-deactive');
        $('.thwvs-template-preview-wrapper .thwvs-template-box').removeClass('design-active');
    }

    function trigger_attribute_tab(elm){
        $('ul.wc-tabs .attribute_options.attribute_tab a').trigger('click');
    }

    return{

        upload_icon_image : upload_icon_image, 
        remove_icon_image : remove_icon_image,
        change_term_type  : change_term_type,
        open_term_body    : open_term_body,

        EditDesignForm    :  edit_design_form,
        CloseDesignPopup  : close_design_popup,
        TriggerAttributeTab : trigger_attribute_tab


    };

}(window.jQuery, window, document));  

function thwvsf_upload_icon_image(elm,e){
    thwvsf_settings.upload_icon_image(elm,e);
}
function thwvsf_remove_icon_image(elm,e){
    thwvsf_settings.remove_icon_image(elm,e);
}
function thwvsf_change_term_type(elm,e){
    thwvsf_settings.change_term_type(elm,e);
}
function thwvsf_open_body(elm,e){
    thwvsf_settings.open_term_body(elm,e);
}

function thwvsfEditDesignForm(elm, design_styles, design_id, des_title){
    thwvsf_settings.EditDesignForm(elm, design_styles, design_id, des_title);
}
function thwvsfCloseDesignPopup(elm){
    thwvsf_settings.CloseDesignPopup(elm);
}

function thwvsfTriggerAttributeTab(elm){
    thwvsf_settings.TriggerAttributeTab(elm);
}






