jQuery(document).ready(function($){
    let is_customizer = document.querySelector('.wp-customizer'),
        customizer_tab_name = ahuraGetQueryVarByName('tab'),
        customizer_sidebar = $('.wp-full-overlay-sidebar-content'),
        customizer_is_loaded_sidebar;

    if(is_customizer && customizer_tab_name){
        let target_tab = $(`#accordion-section-${customizer_tab_name} h3`);
        if(typeof target_tab !== "undefined" && target_tab.is(':visible')){
            let customizer_set_tab_inval = setInterval(() => {
                customizer_is_loaded_sidebar = customizer_sidebar.html().length;
                if(customizer_is_loaded_sidebar > 30){
                    target_tab.trigger('click');
                    clearInterval(customizer_set_tab_inval);
                }
            }, 100);
        }
    }

    $(document).on('click', 'body', function (e) {
        let fonticons_wrap = $('.font-icons-list-wrap'), fonticons_wrap_list;
        if (!$(e.target).closest(fonticons_wrap).length) {
            fonticons_wrap_list = fonticons_wrap.find('.font-icons-list-content');
            fonticons_wrap_list.slideUp();
            fonticons_wrap_list.find('input').val('');
            fonticons_wrap_list.find('li').show();
        }
    });

    $(document).on('click', '.ahura-font-upload', function(e){
        e.preventDefault();
        let mw_this = $(this);
        let media_uploader = wp.media({
            title: ahura_data.translate.select_font,
            button: {
                'text' : ahura_data.translate.select
            },
            multiple: false
        });
        media_uploader.on('select', function(){
            let media_attachment = media_uploader.state().get('selection').first().toJSON(),
                wrapper = mw_this.parent().find('input'),
                url = media_attachment.url;
            if(url !== undefined){
                wrapper.val(url);
                mw_this.removeClass('error').addClass('success');
                mw_this.parent().find('.empty-var-field').show();
            } else {
                wrapper.val('');
                mw_this.removeClass('success').addClass('error');
                mw_this.parent().find('.empty-var-field').hide();
            }
        });
        media_uploader.open();
    });

    // add new font variation
    $(document).on('click', '.add-font-variation', function(e){
        e.preventDefault();
        let $this = $(this),
            lastVarItem = $('.var-item:last-child'),
            fileTypes = ['woff', 'woff2', 'ttf', 'svg', 'eot'],
            num = (lastVarItem.data('num') === undefined) ? 1: parseInt(lastVarItem.data('num')) + 1;

        $('#variations').append($('<div/>', {'class': `var-item var-item-${num}`, 'data-num': num}).append(
            $('<div/>', {'class': 'head'}).append(
                $('<div/>', {'class': 'opt'}).append(
                    $('<label/>', {'for': `font_face[${num}][font_weight]`, text: ahura_data.translate.weight}),
                    $('<select/>', {'name': `font_face[${num}][font_weight]`}).append(
                        $('<option/>', {'value': 'normal', text: ahura_data.translate.normal}),
                        $('<option/>', {'value': 'bold', text: ahura_data.translate.bold}),
                        $('<option/>', {'value': 100, text: 100}),
                        $('<option/>', {'value': 200, text: 200}),
                        $('<option/>', {'value': 300, text: 300}),
                        $('<option/>', {'value': 400, text: 400}),
                        $('<option/>', {'value': 500, text: 500}),
                        $('<option/>', {'value': 600, text: 600}),
                        $('<option/>', {'value': 700, text: 700}),
                        $('<option/>', {'value': 800, text: 800}),
                        $('<option/>', {'value': 900, text: 900}),
                    ),
                ),
                $('<div/>', {'class': 'btns'}).append(
                    $('<a/>', {'href': '#','class': 'var-action', 'data-type': 'edit', text: ahura_data.translate.edit}).append(
                        $('<span/>', {'class': 'dashicons dashicons-edit'}),
                    ),
                    $('<a/>', {'href': '#','class': 'var-action var-delete', 'data-type': 'delete', text: ahura_data.translate.delete}).append(
                        $('<span/>', {'class': 'dashicons dashicons-trash'}),
                    ),
                ),
            ),
            $('<div/>', {'class': 'vars-list'}).append($('<div/>', {'class': 'vars'})),
        ));

        $.each(fileTypes, function(i, v){
            $(`.var-item-${num} .vars`).append(
                $('<div/>', {'class': 'item'}).append(
                    $('<input/>', {'type': 'hidden', 'name': `font_face[${num}][${v}][url]`}),
                    $('<span/>', {'class': 'dashicons dashicons-no-alt empty-var-field'}),
                    $('<button/>', {'type': 'button', 'class': 'ahura-font-upload', text: ahura_data.translate[`select_${v}_file`]}),
                ),
            );
        });
    });

    $(document).on('click', '.var-action', function(e){
        e.preventDefault();
        let $this = $(this),
            type = $this.data('type'),
            elParent = $this.parent().parent().parent();
        if(type === 'delete'){
            if(confirm(ahura_data.translate.are_you_sure)){
                elParent.remove();
            }
        } else if(type === 'edit'){
            elParent.find('.vars-list').slideToggle();
        }
    });

    $(document).on('click', '.empty-var-field', function(e){
        e.preventDefault();
        let $this = $(this),
            parentWrap = $this.parent();
        parentWrap.find('.success').removeClass('success');
        parentWrap.find('input').val('');
        $this.hide();
    });

    $(document).on('click', '.gallery-remove-item', function(e){
        e.preventDefault();
        let btn = $(this),
            id = btn.parent().data('id'),
            type = btn.parent().data('type'),
            wrapper = (type == 'image') ? $('.gallery-images') : $('.gallery-videos'),
            input = wrapper.find('input'),
            inputVal = input.val(),
            inputVals = inputVal.split(','),
            newData;
        if(inputVals.length > 0){
            newData = inputVals.filter(function(v) {return v != id});
            input.val(newData.join(','));
        }
    });

    $(document).on('click', '.remove-item', function(e){
        e.preventDefault();
        let btn = $(this);
        btn.parent().remove();
    });

    $(document).on('click', '.ahura-gallery-upload', function(e){
        e.preventDefault();
        let btn = $(this),
            type = btn.data('type');
        let media_uploader = wp.media({
            title: ahura_data.translate.select_file,
            button: {
                'text' : ahura_data.translate.select
            },
            multiple: true,
            library: {
                type: [type]
            },
        });
        media_uploader.on('select', function(){
            let media_attachment = media_uploader.state().get('selection').toJSON(), 
                wrapper = (type == 'image') ? $('.gallery-images') : $('.gallery-videos'), urls = '',
                input = wrapper.find('input');
            if(media_attachment.length > 0){
                $.each(media_attachment, function(key, value){
                    if(value.id !== undefined){
                        if(!wrapper.find('.gallery-item-' + value.id).length){
                            if(type == 'image'){
                                wrapper.find('.items').append(
                                    $('<div/>', {'class': 'gallery-item gallery-image-item gallery-item-' + value.id, 'data-id': value.id, 'data-type': 'image'}).append(
                                        $('<div/>', {'class': 'remove-item gallery-remove-item'}).append(
                                            $('<i/>', {'class': 'dashicons dashicons-no-alt'})
                                        ),
                                        $('<img/>', {src: value.url})
                                    )
                                );
                            } else if(type == 'video'){
                                wrapper.find('.items').append(
                                    $('<div/>', {'class': 'gallery-item gallery-video-item gallery-item-' + value.id, 'data-id': value.id, 'data-type': 'video'}).append(
                                        $('<div/>', {'class': 'remove-item gallery-remove-item'}).append(
                                            $('<i/>', {'class': 'dashicons dashicons-no-alt'})
                                        ),
                                        $('<video/>').append(
                                            $('<source/>', {src: value.url})
                                        )
                                    )
                                );
                            }
        
                            urls += value.id + ',';
                        }
                    }
                });

                if(urls){
                    urls = urls.slice(0, -1);
                    if(input.val()){
                        urls = input.val() + ',' + urls;
                    }
                    input.val(urls);
                }
            }
        });
        media_uploader.open();
    });

    if($('.color-field').length > 0){
        $('.color-field').wpColorPicker();
    }

    $(document).on('click', '.mw-fonticon-selector-btn', function(e){
        e.preventDefault();
        let btn = $(this),
            list = btn.parent().children('.font-icons-list-content'),
            searchInput = list.find('input');
        if(list.is(':visible')){
            searchInput.val('');
            list.find('li').show();
            list.slideUp();
        } else {
            list.slideDown();
        }
    });

    $(document).on('click', '.mw-fonticon-selector-wrap .font-icons-list-wrap .font-icons-list-content li', function(e){
        e.preventDefault();
        let btn = $(this),
            icon = btn.data('icon'),
            wrap = btn.parent().parent().parent().parent(),
            list = btn.parent(),
            input = wrap.children('input'),
            selectorBtn = wrap.find('.mw-fonticon-selector-btn');

        if(btn.hasClass('selected')){
            btn.removeClass('selected');
            input.val('');
            selectorBtn.html(`<i class="dashicons dashicons-arrow-down-alt2"></i>`);
        } else {
            list.find('.selected').removeClass('selected');
            btn.addClass('selected');
            input.val(icon);
            selectorBtn.html(`<i class="${icon}"></i>`);
        }
    });

    $(document).on('keyup', '.mw-fonticon-selector-wrap input.fonticons-search-input', function(e){
        e.preventDefault();
        let input = $(this),
            param = input.val(),
            items = input.parent().find('li'), item, str;
        if(param.length >= 2){
            items.each(function(i){
                item = $(this).children('i');
                str = item.attr('class');
                if(str.search(param) >= 0){
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        } else {
            items.show();
        }
    });

    $(document).on('click', '.mw-popup-fonticon-selector-btn', function(e){
        e.preventDefault();
        let btn = $(this),
            box = $('body').find('.ahura-popup-icons-box'),
            list = box.children('.font-icons-list-content'),
            searchInput = list.find('input');
        $('body').find('.mw-popup-fonticon-selector-btn.active').removeClass('active');
        if(box.is(':visible')){
            searchInput.val('');
            list.find('li').show();
            box.fadeOut();
        } else {
            btn.addClass('active');
            box.fadeIn();
        }
    });

    $(document).on('click', '.ahura-popup-icons-box .font-icons-list-content li', function(e){
        e.preventDefault();
        let btn = $(this),
            icon = btn.data('icon'),
            wrap = $('body').find('.mw-popup-fonticon-selector-btn.active').parent(),
            list = btn.parent(),
            input = wrap.children('input.icon-field'),
            selectorBtn = wrap.find('.mw-popup-fonticon-selector-btn');

        if(btn.hasClass('selected')){
            btn.removeClass('selected');
            input.val('');
            selectorBtn.html(`<i class="dashicons dashicons-arrow-down-alt2"></i>`);
        } else {
            list.find('.selected').removeClass('selected');
            btn.addClass('selected');
            input.val(icon);
            selectorBtn.html(`<i class="${icon}"></i>`);
        }
    });

    $(document).on('click', '.team-add-new-option', function(e){
        e.preventDefault();
        let btn = $(this),
            wrap = btn.parent().find('.team-options'),
            items = wrap.find('.team-meta-option'),
            lastItem = items.last(),
            lastID = items.length ? parseInt(lastItem.data('id')) + 1 : 0;
        wrap.append(
            $('<div/>', {'class': 'team-meta-option', 'data-id': lastID}).append(
                $('<a/>', {'href': '#', 'class': 'mw-popup-fonticon-selector-btn primary-selector-btn'}).append(
                    $('<i/>', {'class': 'dashicons dashicons-arrow-down-alt2'})
                ),
                $('<input/>', {'type': 'hidden', 'class': 'icon-field', 'name': `_team_options[${lastID}][icon]`}),
                $('<input/>', {'type': 'text', 'name': `_team_options[${lastID}][label]`}),
                $('<a/>', {'href': '#', 'class': 'team-remove-option'}).append(
                    $('<i/>', {'class': 'dashicons dashicons-no-alt'})
                ),
            )
        );
    });

    $(document).on('click', '.team-remove-option', function(e){
        e.preventDefault();
        let btn = $(this);
        btn.parent().remove();
    });
});