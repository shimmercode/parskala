jQuery(window).on('elementor/frontend/init', () => {
    // const loadMore = wp.template('theme-widget-load-more');
    // const notFound = wp.template('theme-widget-not-found');
    elementorFrontend.hooks.addAction('frontend/element_ready/product-carosel.default', function ($scope, $) {
      prk_ajax_innerjs_run($scope);
     
    let carouseloff = $scope.find('.article-off');

    carouseloff.on('changed.owl.carousel', function(e) {

    var total = parseInt(e.item.count - e.page.size);
    var current = parseInt(e.item.index);
  
    let tabOffset = carouseloff.attr('data-offset') ?? 1;
      if(total >= 0 && current >=0 ){
        var loader_exist = carouseloff.find('.item-pro').is("#scroll-more-ajax");
        var is_ajax = carouseloff.is(".loadmore_ajax");
        // console.log(is_ajax);
        if(current == total){
          if($scope.find('.prk-ajax-list-header-wrapper').length){

         
         if(! loader_exist && is_ajax){
             carouseloff.owlCarousel('add', '<div id="scroll-more-ajax" class="item-pro"><p> <div class="ajax-loader"></div> </p><div class="title">درحال بارگذاری...</div></div>').owlCarousel('update');
             let tabKey = jQuery(this).attr('tab-id');
             getscrollproductsbyajax(tabKey,e)
         }
        }else{
          if(! loader_exist && is_ajax){
            carouseloff.owlCarousel('add', '<div id="scroll-more-ajax" class="item-pro"><p> <div class="ajax-loader"></div> </p><div class="title">درحال بارگذاری...</div></div>').owlCarousel('update');
            getscrollproductsbyajax_no_header_tab(e)
          }
        }
        }
      }

  });
})
})


function getscrollproductsbyajax_no_header_tab(owlCarousel) {
  var lengthItems= owlCarousel.item.count;


  opt_carousel_string = owlCarousel.currentTarget.closest('.col-product').getAttribute("opt_carousel")
  opt_carousel = JSON.parse(opt_carousel_string);

      tabContent =  jQuery(owlCarousel.currentTarget);
      let tabOffset = tabContent.attr('data-offset') ?? 1;
  jQuery.ajax({
      url: ajaxurl,
      method: "post",
      cache: !1,
      data: {
          action: "prk_ajax_product_list",
          offset: tabOffset,
          eventH:"scroll_no_tab",
          number: opt_carousel.number,
          stock: opt_carousel.instock,
          group_ids:opt_carousel.group,
          group:opt_carousel.type,
          type:opt_carousel.sortby
      },
      error: function(e) {
        console.log("Ajax Error: from prk_ajax_product_list")
      },
      beforeSend: function(e) {
        // jQuery(".onliner_main_loading").addClass('stm-sms-load');
    },
      success: function(e) {
     
        tabContent.trigger('remove.owl.carousel', [lengthItems])

        if(e != ''){

          tabOffset++;
          tabContent.attr('data-offset', tabOffset);

          var doc = new DOMParser().parseFromString(e, "text/html");
          jQuery(doc).find('.item-pro').each(function( index ,element) {
            tabContent.owlCarousel('add', element).owlCarousel('update');
          });
        }
        tabContent.trigger('refresh.owl.carousel');
    
      }
  })
}



function getscrollproductsbyajax(tabKey,owlCarousel) {
  var lengthItems= owlCarousel.item.count;

  var elementtab = jQuery(".widget-tabs").find('[cat="' + tabKey + '"]').get(0);
  var tab_selector = jQuery(".widget-tabs").find('[cat="' + tabKey + '"]');
  console.log(elementtab.getAttribute("cat"));
  var e, t, s, r, i, o, l, a = elementtab.getAttribute("cat"),
      n = elementtab.getAttribute("number"),
      _ = elementtab.getAttribute("stock"),
      p = elementtab.getAttribute("type"),
      u = elementtab.getAttribute("seeallcat"),
      w = elementtab.getAttribute("auth"),
      b = elementtab.getAttribute("bgchanger"),
      d = "";
      let tabsParent = tab_selector.parents('.right-product');
      tabContent =  tabsParent.find(".article-off");
      tabItem =  tabsParent.find(".items-pro");
      let tabOffset = tabContent.attr('data-offset') ?? 1;

  "yes" == u && (null != elementtab.getAttribute("seeallcat_bgcolor") && null != elementtab.getAttribute("seeallcat_bgcolor") ? e = elementtab.getAttribute("seeallcat_bgcolor") : t = elementtab.getAttribute("seeallcat_bgwalp"), null != elementtab.getAttribute("seeallcat_link") && null != elementtab.getAttribute("seeallcat_link") && (s = elementtab.getAttribute("seeallcat_link"), r = elementtab.getAttribute("seeallcat_link_ext"), i = elementtab.getAttribute("seeallcat_link_follow")), null != elementtab.getAttribute("seeallcat_title") && null != elementtab.getAttribute("seeallcat_title") && (o = elementtab.getAttribute("seeallcat_title")), null != elementtab.getAttribute("seeallcat_titlecolor") && null != elementtab.getAttribute("seeallcat_titlecolor") && (l = elementtab.getAttribute("seeallcat_titlecolor"))), "yes" == b && null != elementtab.getAttribute("bgchanger_color") && null != elementtab.getAttribute("bgchanger_color") && (d = elementtab.getAttribute("bgchanger_color"));
  var c = elementtab,
      g = elementtab.parentNode,
      m = g.parentNode.nextElementSibling,
      y = m.firstElementChild,
      f = m.parentNode,
      h = g.children,
      v = m.getAttribute("backtofirstslide"),
      A = m.getAttribute("is-automover"),
      k = m.getAttribute("dont-swipe-onmobile");
  jQuery.ajax({
      url: ajaxurl,
      method: "post",
      cache: !1,
      data: {
          action: "prk_ajax_product_list",
          offset: tabOffset,
          eventH:"scroll",
          cat: a,
          number: n,
          stock: _,
          seeallcat: u,
          type: p,
          seeallcat_bgcolor: e,
          seeallcat_bgwalp: t,
          seeallcat_link: s,
          seeallcat_link_ext: r,
          seeallcat_link_follow: i,
          seeallcat_title: o,
          seeallcat_titlecolor: l,
          auth: w
      },
      error: function(e) {
        console.log("Ajax Error: from prk_ajax_product_list")
      },
      beforeSend: function(e) {
        // jQuery(".onliner_main_loading").addClass('stm-sms-load');
    },
      success: function(e) {
     
        tabContent.trigger('remove.owl.carousel', [lengthItems])

        if(e != ''){

          tabOffset++;
          tabContent.attr('data-offset', tabOffset);

          var doc = new DOMParser().parseFromString(e, "text/html");
          jQuery(doc).find('.item-pro').each(function( index ,element) {
            tabContent.owlCarousel('add', element).owlCarousel('update');
          });
        }
        tabContent.trigger('refresh.owl.carousel');
    
      }
  })
}

function getproductsbyajax() {
  var e, t, s, r, i, o, l, a = this.getAttribute("cat"),
      n = this.getAttribute("number"),
      _ = this.getAttribute("stock"),
      p = this.getAttribute("type"),
      u = this.getAttribute("seeallcat"),
      w = this.getAttribute("auth"),
      b = this.getAttribute("bgchanger"),
      d = "";
      let tabsParent = jQuery(this).parents('.right-product');
      tabContent =  tabsParent.find(".article-off");
      tabContent.removeAttr('data-offset');
  "yes" == u && (null != this.getAttribute("seeallcat_bgcolor") && null != this.getAttribute("seeallcat_bgcolor") ? e = this.getAttribute("seeallcat_bgcolor") : t = this.getAttribute("seeallcat_bgwalp"), null != this.getAttribute("seeallcat_link") && null != this.getAttribute("seeallcat_link") && (s = this.getAttribute("seeallcat_link"), r = this.getAttribute("seeallcat_link_ext"), i = this.getAttribute("seeallcat_link_follow")), null != this.getAttribute("seeallcat_title") && null != this.getAttribute("seeallcat_title") && (o = this.getAttribute("seeallcat_title")), null != this.getAttribute("seeallcat_titlecolor") && null != this.getAttribute("seeallcat_titlecolor") && (l = this.getAttribute("seeallcat_titlecolor"))), "yes" == b && null != this.getAttribute("bgchanger_color") && null != this.getAttribute("bgchanger_color") && (d = this.getAttribute("bgchanger_color"));
  var c = this,
      g = this.parentNode,
      m = g.parentNode.nextElementSibling,
      y = m.firstElementChild,
      f = m.parentNode,
      h = g.children,
      v = m.getAttribute("backtofirstslide"),
      A = m.getAttribute("is-automover"),
      k = m.getAttribute("dont-swipe-onmobile");
  jQuery.ajax({
      url: ajaxurl,
      method: "post",
      cache: !1,
      data: {
          action: "prk_ajax_product_list",
          eventH:"tab",
          cat: a,
          number: n,
          stock: _,
          seeallcat: u,
          type: p,
          seeallcat_bgcolor: e,
          seeallcat_bgwalp: t,
          seeallcat_link: s,
          seeallcat_link_ext: r,
          seeallcat_link_follow: i,
          seeallcat_title: o,
          seeallcat_titlecolor: l,
          auth: w
      },
      error: function(e) {
          console.log("Ajax Error: from prk_ajax_product_list")
      },
      beforeSend: function(e) {
          // jQuery(".onliner_main_loading").addClass('stm-sms-load');
          jQuery(tabsParent).addClass('element-loading');
          jQuery(tabsParent.find(".items-pro")).addClass('loading');
          
      },
      success: function(e) {
          
          y.innerHTML = "", y.innerHTML = e;
          for (var t = 0; t < h.length; t++) h[t].classList.remove("prk-header-divs-active");
          c.classList.add("prk-header-divs-active"), "yes" == b && (f.firstElementChild.style.backgroundColor = d);
        
          // jQuery(".article-off").removeAttr("settings-slider");
          tabContent.trigger('destroy.owl.carousel');
          tabContent.attr("tab-id",a);
// داینامیک سازی اتریبیوتیک کاروسل های محصولات
setInterval(function(){
  if (tabContent.length) {
    var carousel = tabContent.each(function () {

      var settings = JSON.parse(jQuery(this).attr("settings-slider"));

      jQuery(this).owlCarousel({
              items: settings.item,
              loop: settings.loop == "true" ? true : false,
        margin: settings.margins,
        stagePadding: settings.Paddings,
            autoplayTimeout: settings.delay,
            autoplay: settings.autoplay == "true" ? true : false,
            nav: settings.nav == "true" ? true : false,
            navText:'',
              rtl:true,
            navElement:'span class="far fa-chevron-left"',
            responsiveClass:true,
            dots:false,
            responsive:{
                1310:{
                    items: settings.item,
                              nav: settings.nav == "true" ? true : false,
                margin: settings.margins,
                  },
              1150:{
                  items: 5,
                  nav: settings.nav == "true" ? true : false,
                  margin: settings.margins,
                },
              1024:{
                  items: 5,
                  nav: settings.nav == "true" ? true : false,
                  margin: settings.margins,
                },
              780:{
                  items:4,
                  autoplay: settings.autoplay == "true" ? true : false,
                  nav: false,
                  margin: settings.margins_mob,

             },
                   570:{
                       items:2,
                       autoplay: settings.autoplay == "true" ? true : false,
                                   nav: false,
                   margin: settings.margins_mob,
                   stagePadding: 30,
                  },
              470:{
                  items:2,
                  autoplay: settings.autoplay == "true" ? true : false,
                  nav: false,
                  margin: settings.margins_mob,
                  stagePadding: 10,
             },
              400:{
                  items:2,
                  autoplay: settings.autoplay == "true" ? true : false,
                  nav: false,
                  margin: settings.margins_mob,
                 stagePadding: 10,
             },
             340:{
                 items:1,
                 autoplay: settings.autoplay == "true" ? true : false,
                 nav: false,
                 margin: settings.margins_mob,
                stagePadding: 70,
            },
             0:{
                 items:1,
                 autoplay: settings.autoplay == "true" ? true : false,
                 nav: false,
                 margin: settings.margins_mob,
                 stagePadding: 55,
            },

              }



      });
    });
 }
});
// jQuery(".onliner_main_loading").removeClass('stm-sms-load'); 
jQuery(tabsParent).removeClass('element-loading');
jQuery(tabsParent.find(".items-pro")).removeClass('loading');

      }
  })
}



function prk_ajax_innerjs_run($scope) {
  $scope.find('.widget-tabs .tab-item:not([no-btn])').on('click', getproductsbyajax)
}
