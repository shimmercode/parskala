(function ($) {
  'use strict';
  if (typeof viraCr === 'undefined') {
    return;
  }
  function post(data) {
    data.security = viraCr.nonce;
    return $.post(viraCr.ajax, data);
  }
  if (viraCr.pid) {
    post({ action: 'vira_view_ping', product_id: viraCr.pid }).done(function (r) {
      if (r.success && r.data && r.data.views != null) {
        $('.js-vira-views').text(r.data.views);
      }
    });
  }
  $(document).on('submit', '.vira-waitlist-form', function (e) {
    e.preventDefault();
    var $f = $(this);
    post({ action: 'vira_waitlist', product_id: $f.data('pid'), mobile: $f.find('[name=mobile]').val() }).done(function (r) {
      alert(r.data && r.data.message ? r.data.message : 'ثبت شد');
    });
  });
  $(document).on('submit', '#vira-qa-form', function (e) {
    e.preventDefault();
    post({ action: 'vira_qa_ask', product_id: $(this).data('pid'), q: $(this).find('[name=q]').val() }).done(function (r) {
      alert(r.data && r.data.message ? r.data.message : 'ثبت شد');
      if (r.success) location.reload();
    });
  });
  $(document).on('submit', '.vira-qa-ans', function (e) {
    e.preventDefault();
    post({ action: 'vira_qa_answer', product_id: $(this).data('pid'), i: $(this).data('i'), a: $(this).find('[name=a]').val() }).done(function (r) {
      if (r.success) location.reload();
    });
  });
  $(document).on('click', '.js-vira-return', function () {
    post({ action: 'vira_return_req', order_id: $(this).data('id') }).done(function (r) {
      alert(r.data && r.data.message ? r.data.message : '');
      if (r.success) location.reload();
    });
  });
  $(document).on('submit', '.vira-cart-sms', function (e) {
    e.preventDefault();
    post({ action: 'vira_cart_sms', mobile: $(this).find('[name=mobile]').val() }).done(function (r) {
      alert(r.data && r.data.message ? r.data.message : '');
    });
  });
  $(document).on('change', '[name=vira_use_wallet]', function () {
    if (typeof wc_checkout_params !== 'undefined') {
      $(document.body).trigger('update_checkout');
    }
  });
  $(document).on('click', '.js-vira-speak', function () {
    var t = $.trim($('.woocommerce-product-details__short-description, .product .summary').first().text());
    if (!t || !window.speechSynthesis) {
      alert('خواندن در این مرورگر پشتیبانی نمی‌شود.');
      return;
    }
    var u = new SpeechSynthesisUtterance(t.slice(0, 1200));
    u.lang = 'fa-IR';
    window.speechSynthesis.cancel();
    window.speechSynthesis.speak(u);
  });
  $(document).on('click', '.vira-story-atc', function () {
    var id = $(this).data('pid');
    if (!id) return;
    post({ action: 'vira_story_atc', product_id: id }).done(function (r) {
      if (r.success) window.location.href = r.data.cart;
    });
  });
  var _show = window.showStory;
  $(document).on('click', '.js-vira-story', function () {
    setTimeout(function () {
      if (!window.viraStories) return;
      var it = window.viraStories[window.storyIndex || 0] || window.viraStories[0];
      var $b = $('.vira-story-atc');
      if (it && it.product_id) {
        $b.removeAttr('hidden').data('pid', it.product_id);
      } else {
        $b.attr('hidden', true);
      }
    }, 50);
  });
})(jQuery);
