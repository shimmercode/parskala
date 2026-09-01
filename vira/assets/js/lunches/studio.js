jQuery(document).ready(function($){
    $(document).on('click', '.ahura-filter-tabs a', function(e){
        e.preventDefault();
        let btn = $(this),
            tabs = btn.parent().parent(),
            activeTabs = tabs.children('.active'),
            filterValue = btn.attr('data-filter');
  
        activeTabs.removeClass('active');
        btn.parent().addClass('active');

        $('.filter-item').fadeOut();
        $(filterValue).fadeIn();
    });

    let all_items = $('.ahura-studio-filter-tab-items .filter-item'),
        item, demo_url, demo_cover, demo_loader, load_demo;

    if(all_items.length){
        setTimeout(function(){
            $.each(all_items, function(i, el){
                setTimeout(function(){ 
                    item = $(el);
                    demo_cover = item.find('.filter-item-cover');
                    demo_url = demo_cover.data('demo-preview-url');
                    demo_loader = demo_cover.find('.filter-item-cover-loading');
                    if(demo_url.length){
                        demo_cover.append(
                            $('<img/>', {'src': demo_url, 'width': '100%'}).hide()
                        );
						demo_cover.find('img').fadeIn();
                        demo_loader.hide();
                    }
                }, i * 100);
            });
        }, 2000);
    }

    $(document).on('click', '.show-demo-options', function(e){
        e.preventDefault();
        let btn = $(this),
            options = btn.parent().parent().find('.filter-item-options');
        if(options.length){
            options.toggleClass('show-options');
        }
    });
});

function ahura_is_json(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function ahura_timeout_message(title, type = 'success', time = 3000){
    Swal.fire({
        position: 'center-center',
        icon: type,
        title: title,
        showConfirmButton: false,
        timer: 3000
    })
}