(function ($) {
  'use strict';

  function pad(n) { return n < 10 ? '0' + n : '' + n; }

  function tickTimers() {
    $('.dk-timer[data-end]').each(function () {
      var end = parseInt($(this).attr('data-end'), 10) * 1000;
      var d = end - Date.now();
      if (d <= 0) { $(this).text('۰۰:۰۰:۰۰'); return; }
      var h = Math.floor(d / 3600000);
      var m = Math.floor((d % 3600000) / 60000);
      var s = Math.floor((d % 60000) / 1000);
      $(this).text(pad(h) + ':' + pad(m) + ':' + pad(s));
    });
    $('.dk-clock').each(function () {
      var $el = $(this);
      if (!$el.data('t0')) { $el.data('t0', Date.now() + 8 * 3600000); }
      var d = $el.data('t0') - Date.now();
      if (d < 0) d = 0;
      var h = Math.floor(d / 3600000);
      var m = Math.floor((d % 3600000) / 60000);
      var s = Math.floor((d % 60000) / 1000);
      $el.find('em').eq(0).text(pad(h));
      $el.find('em').eq(1).text(pad(m));
      $el.find('em').eq(2).text(pad(s));
    });
  }
  setInterval(tickTimers, 1000);
  tickTimers();

  var $slides = $('#dkSlider .dk-slide');
  var idx = 0;
  function show(i) {
    if (!$slides.length) return;
    idx = (i + $slides.length) % $slides.length;
    $slides.removeClass('is-on').eq(idx).addClass('is-on');
  }
  $('.dk-next').on('click', function () { show(idx + 1); });
  $('.dk-prev').on('click', function () { show(idx - 1); });
  setInterval(function () { show(idx + 1); }, 5000);

  var $drop = $('#dkSearchDrop');
  var timer;
  function bindSearch() {
    var $inp = $('.prk_input_serach, .search-section input[type=text], .vira-search-input, header input[name=s]').first();
    if (!$inp.length) return;
    $inp.attr('autocomplete', 'off');
    $inp.on('focus input', function () {
      clearTimeout(timer);
      var q = $(this).val();
      var off = $inp.offset();
      $drop.css({ top: off.top + $inp.outerHeight() + 6, left: off.left, width: Math.max(280, $inp.outerWidth()) });
      timer = setTimeout(function () {
        if (typeof viraDk === 'undefined') return;
        $.get(viraDk.ajax, { action: 'vira_dk_search', nonce: viraDk.nonce, q: q }, function (res) {
          if (!res || !res.success) return;
          var d = res.data;
          var html = '';
          (d.suggestions || []).forEach(function (s) { html += '<div class="dk-sg">🔍 ' + s + '</div>'; });
          (d.cats || []).forEach(function (c) { html += '<a href="' + c.url + '">📂 ' + c.title + '</a>'; });
          (d.products || []).forEach(function (p) {
            html += '<a href="' + p.url + '">' + (p.img ? '<img src="' + p.img + '">' : '') + '<span>' + p.title + '<br><small>' + p.price + '</small></span></a>';
          });
          $drop.html(html || '<div class="dk-sg">نتیجه‌ای نیست</div>').prop('hidden', false);
        });
      }, 220);
    });
    $(document).on('click', function (e) {
      if (!$(e.target).closest('#dkSearchDrop, .prk_input_serach, header input').length) {
        $drop.prop('hidden', true);
      }
    });
  }
  bindSearch();

  $('.top-nav, .prk_mega_menu').on('mouseenter', function () {
    $('#dkMega').prop('hidden', false);
  });
  $('#dkMega').on('mouseleave', function () { $(this).prop('hidden', true); });

  $('#dkRevFilters button').on('click', function () {
    var f = $(this).data('f');
    $('.dk-rev').each(function () {
      var $r = $(this).closest('.comment') ;
      if (!$r.length) $r = $(this);
      if (f === 'all') { $r.show(); }
      else if (f === 'photo') { $r.toggle($(this).hasClass('has-photo')); }
      else if (f === 'buyer') { $r.toggle($(this).hasClass('is-buyer')); }
    });
  });

  var KEY = 'vira_dk_next';
  function nextList() {
    try { return JSON.parse(localStorage.getItem(KEY) || '[]'); } catch (e) { return []; }
  }
  function renderNext() {
    var $box = $('#dkNextList');
    if (!$box.length) return;
    var items = nextList();
    if (!items.length) { $box.html('<small>لیست خرید بعدی خالی است. از صفحه محصول «بعداً بخر» را بزنید.</small>'); return; }
    $box.html(items.map(function (it) {
      return '<div>' + it.title + ' <button type="button" class="dk-rm-next" data-id="' + it.id + '">حذف</button></div>';
    }).join(''));
  }
  $(document).on('click', '.dk-save-next', function () {
    var items = nextList();
    items.push({ id: $(this).data('id'), title: $(this).data('title') });
    localStorage.setItem(KEY, JSON.stringify(items));
    $(this).text('به خرید بعدی اضافه شد');
  });
  $(document).on('click', '.dk-rm-next', function () {
    var id = String($(this).data('id'));
    localStorage.setItem(KEY, JSON.stringify(nextList().filter(function (x) { return String(x.id) !== id; })));
    renderNext();
  });
  $('.dk-next-open').on('click', renderNext);
  renderNext();

  if ($('body.single-product').length && !$('.dk-save-next').length) {
    var title = $('h1.product_title').text();
    var id = $('button.single_add_to_cart_button').val() || '';
    $('.summary, .product-seller-info, .vira-single-product').first().append(
      '<p><button type="button" class="dk-save-next" data-id="' + id + '" data-title="' + $('<div>').text(title).html() + '">افزودن به خرید بعدی</button></p>'
    );
  }
})(jQuery);
