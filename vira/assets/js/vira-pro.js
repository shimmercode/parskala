(function ($) {
  'use strict';
  var page = 1, ob = 'date';
  $('#viraShopBar button[data-ob]').on('click', function () {
    ob = $(this).data('ob');
    page = 1;
    $('#viraShopBar button[data-ob]').removeClass('is-on');
    $(this).addClass('is-on');
    load(true);
  });
  $('#viraLoadMore').on('click', function () { page += 1; load(false); });
  function load(replace) {
    if (typeof viraPro === 'undefined') return;
    $.post(viraPro.ajax, { action: 'vira_pro_shop', nonce: viraPro.nonce, page: page, orderby: ob }, function (res) {
      if (!res || !res.success) return;
      var $ul = $('ul.products').first();
      if (!$ul.length) return;
      if (replace) { $ul.html(res.data.html); }
      else { $ul.append(res.data.html); }
    });
  }
  $(document).on('click', '.vira-qv', function () {
    var id = $(this).data('id');
    $.post(viraPro.ajax, { action: 'vira_pro_qv', nonce: viraPro.nonce, id: id }, function (res) {
      if (!res || !res.success) return;
      $('#viraQv .vira-qv-body').html(res.data.html);
      $('#viraQv').prop('hidden', false);
    });
  });
  $(document).on('click', '.vira-qv-x, #viraQv', function (e) {
    if (e.target === this) $('#viraQv').prop('hidden', true);
  });
  $('#vira-filter-form').on('submit', function (e) {
    e.preventDefault();
    var data = $(this).serialize() + '&action=vira_ajax_filter&security=' + (window.viraVars && viraVars.nonce ? viraVars.nonce : '') + '&nonce=' + (viraPro ? viraPro.nonce : '');
    $.post((window.viraPro && viraPro.ajax) || (window.viraDk && viraDk.ajax), $(this).serialize() + '&action=vira_ajax_filter&security=' + (window.viraVars ? viraVars.nonce : ''), function (res) {
      if (res && res.success && res.data.html) {
        var $ul = $('ul.products').first();
        if ($ul.length) $ul.replaceWith(res.data.html);
      }
    });
  });
  $('.js-toggle-filter').on('click', function () { $('#vira-filter-form').toggleClass('open').toggle(); });
})(jQuery);
