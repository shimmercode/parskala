jQuery(document).ready(function($){
    let try_count = 0;

    $('body').on('click', '.ahura-section-select-ajax-load-options + .ajax-load', function(){
        let btn = $(this),
            select = btn.parent().find('select'),
            selectVal = select.val(),
            items, selected;
        $.ajax({
            url: ahura_data.au,
            data: {
                action: 'ahura_get_sections',
                nonce: ahura_data.nonce
            },
            beforeSend: function () {
                btn.addClass('spin');
                select.attr('disabled', true);
            },
            success: function(res){
                btn.removeClass('spin');
                select.attr('disabled', false);
                if(res.count > 0){
                    items = res.items;
                    select.empty();
                    select.append(`<option value=""></option>`);
                    $.each(items, function(key, value){
                        selected = selectVal == value.ID ? 'selected="selected"' : '';
                        select.append(`<option ${selected} value="${value.ID}">${value.post_title}</option>`);
                    });
                }
            },
            error: function () {
                btn.removeClass('spin');
                select.attr('disabled', false);
            }
        })
    });

    $('body').on('submit', '#ahura-change-license-status-form', function(e){
        e.preventDefault();
        let form = $(this),
            license_status = form.find('input[name="ahura_license_activate"]').length,
            response;
        
        $.ajax({
            url: ahura_data.au,
            data: "action=ahura_theme_change_license_status&" + form.serialize() + '&selected_status=' + license_status,
            timeout: 120000,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                form.addClass('blur-loading');
                if(!$('.swal2-container').length){
                    Swal.fire({
                        text: ahura_data.translate.request_is_progress,
                        timerProgressBar: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {},
                        allowOutsideClick: () => false
                    }).then((result) => {});
                }
            },
            complete: function(res){
                response = res.responseJSON;
                //console.log(response, try_count);
                if(response.status === 'success' || (try_count >= 2 && typeof response.log !== "undefined")){
                    Swal.fire({
                        position: 'center-center',
                        icon: response.status,
                        text: response.msg,
                        showConfirmButton: false,
                        showCancelButton: false,
                        timer: 4000
                    });
                    if(typeof response.log !== "undefined" && response.log === 'invalid'){
                        try_count = 0;
                        form.removeClass('blur-loading');
                    } else {
                        form.addClass('blur-loading');
                        location.reload();
                    }
                } else {
                    if(try_count <= 2){
                        form.submit();
                    } else {
                        try_count = 0;
                        form.removeClass('blur-loading');
                    }
                }
                try_count++;
            },
            error: function () {
                form.removeClass('blur-loading');
                Swal.fire({
                    position: 'center-center',
                    icon: 'error',
                    text: ahura_data.translate.unknown_error,
                    showConfirmButton: false,
                    showCancelButton: false,
                    timer: 4000
                })
            }
        })
    });
});