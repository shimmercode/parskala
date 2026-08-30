
    //add row & column highlighting on Size Display Table

    var $tables = jQuery('.prk-table-hovers');

    $tables.each(function () {
        var $cells = $(this).find("td, th");

        $cells
            .on("mouseover", function () {
                var $this = jQuery(this),
                    $pos = $this.index();
                $this.parent().parent().addClass('prk-table-hovered');
                $this.parent().find("th, td").addClass("prk-table-hover");
                $cells.filter(":nth-child(" + ($pos + 1) + ")").addClass("prk-table-hover");
                $this.addClass("prk-table-cursor");
            })
            .on("mouseout", function () {
                var $this = jQuery(this);
                $cells.removeClass("prk-table-hover");
                $this.parent().parent().removeClass('prk-table-hovered');
                jQuery(this).removeClass("prk-table-cursor");
            });
    });
    jQuery('.sizeGuideTabs .tab').on('click', function(){
        jQuery('.sizeGuideTabs .tab').removeClass('active');
        jQuery('.sizeGuideTabContents .content').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.sizeGuideTabContents .content[tab-key=' + $(this).attr('tab-key') + ']').addClass('active')
    })
