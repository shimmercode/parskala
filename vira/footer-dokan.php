<?php if ( class_exists('Dokan_Pro') && prk_option('dokan_pro_active') ):?>
<footer id="footer">
  <div class="sp_panel_footer">
    <div class="sp_footer_color">
    <div class="sp_top_footer">
       <div class="sp_contact_us">
         <ul>

           <?php
            $items = prk_option('menu-items-footer-panel-dokan', 'option');
            if( ! empty($items) )
              foreach ($items as $item) {
                if ($item['icon']) {
                  $icon = '<i class="'.$item['icon'].'"></i>';
                }else {
                  $icon = '';
                }
                echo '<a href="'.$item['url'].'"><li>'.$icon.''.$item['title'].'</li></a>';
              }
           ?>

         </ul>
       </div>

       <div class="sp_footer_logo">
         <img src="<?= $logo = prk_option('dash_page_logo_foot')['url'] ? prk_option('dash_page_logo_foot')['url'] : prk_option('logo')['url'];?>">
       </div>

    </div>
    </div>
    <div class="sp_footer_color2">
    <div class="sp_bottom_footer">
      <p><?= prk_option('copyright-en-panel-dokan') ?></p>
    <?= prk_option('copyright-panel-dokan') ?>
    </div>
    </div>
  </div>
</footer>

<script>

jQuery(document).ready(function ($){

//var $a= $.noConflict(true);

    $("#icon_menu_bar") .click(function(){
      $(".sp_menu_bar").toggleClass("show");
      $("#header").toggleClass("hide");
      $("#main").toggleClass("hide");
      $("#footer").toggleClass("hide");
  });

  $("#menu-icon").click(function(){
    $(".sp_menu_bar").removeClass("show");
    $("#header").removeClass("hide");
    $("#main").removeClass("hide");
    $("#footer").removeClass("hide");

});

$(".sp_Condition li.reject_doc") .click(function(){
  $(".sp_interactive_status_message").toggleClass("show");
    $(".sp_interactive1").removeClass("show");
      $(".sp_interactive2").removeClass("show");
});
$(".sp_Condition li:nth-child(2)") .click(function(){
  $(".sp_interactive1").toggleClass("show");
});
$(".sp_Condition li:nth-child(3)") .click(function(){
  $(".sp_interactive2").toggleClass("show");
});

$(".sp_header_Records span") .click(function(){
  $(".sp_dropdown_daily").toggleClass("show");
  $(".sp_header_Records .fa-angle-up").toggleClass("show");
  $(".sp_header_Records .fa-angle-down").toggleClass("hide");
});

$(".sp_dropdown_daily li").click(function(){
  var name = $(this).text();
  $(".sp_header_Records span").text(name);
});

});

</script>
<?php wp_footer();?>
<?php endif; ?>
</body>

</html>
