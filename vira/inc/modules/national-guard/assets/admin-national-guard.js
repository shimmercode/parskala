(function ($, window, document) {
  'use strict';

  window.PrkModal = window.PrkModal || {};

  window.PrkModal.openById = window.PrkModal.openById || function (id) {
    var $modal = $('#' + id);
    $modal.addClass('is-open').attr('aria-hidden', 'false');
    $('body').addClass('prk-ng-modal-open');
  };

  window.PrkModal.closeById = window.PrkModal.closeById || function (id) {
    var $modal = $('#' + id);
    $modal.removeClass('is-open').attr('aria-hidden', 'true');
    $('body').removeClass('prk-ng-modal-open');
  };

  var state = {
    timer: null,
    busy: false,
    live: false
  };

  function config() {
    return window.PRK_NG_ADMIN || {};
  }

  function ajax(action, data) {
    data = data || {};
    data.action = action;
    data.nonce = config().nonce;

    return $.ajax({
      url: config().ajax_url,
      method: 'POST',
      dataType: 'json',
      data: data
    });
  }

  function updatePanel(payload) {
    if (!payload) {
      return;
    }

    if (payload.table_html) {
      $('[data-prk-ng-table-wrap]').html(payload.table_html);
    }

    if (payload.summary) {
      $('[data-prk-ng-total]').text(payload.summary.total || 0);
      $('[data-prk-ng-blocked]').text(payload.summary.blocked || 0);
      $('[data-prk-ng-errors]').text(payload.summary.errors || 0);
      $('[data-prk-ng-hosts]').text(payload.summary.hosts || 0);
    }
  }

  function setScanResult(html) {
    var $box = $('[data-prk-ng-scan-result]');
    if (!html) {
      $box.removeClass('is-visible').empty();
      return;
    }
    $box.addClass('is-visible').html(html);
  }

  function i18n(key, fallback) {
    return config().i18n && config().i18n[key] ? config().i18n[key] : fallback;
  }

  function setLiveState(active, text) {
    state.live = !!active;
    var $panel = $('[data-prk-ng-panel]');
    $panel.toggleClass('is-live-scanning', state.live);
    $('[data-prk-ng-live-status]').text(text || (state.live ? i18n('live_on', 'اسکن زنده فعال است؛ این جدول در همین تب بروزرسانی می‌شود.') : i18n('live_off', 'اسکن زنده متوقف شد.')));
  }

  function refreshLogs() {
    if (state.busy) {
      return;
    }

    state.busy = true;
    if (state.live) {
      setLiveState(true, i18n('live_tick', 'در حال بروزرسانی گزارش زنده...'));
    }
    ajax('prk_ng_get_logs')
      .done(function (response) {
        if (response && response.success) {
          updatePanel(response.data);
        }
      })
      .always(function () {
        state.busy = false;
        if (state.live) {
          setLiveState(true);
        }
      });
  }

  function clearLogs() {
    ajax('prk_ng_clear_logs')
      .done(function (response) {
        if (response && response.success) {
          updatePanel(response.data);
          setScanResult('<strong>' + (config().i18n && config().i18n.clear_done ? config().i18n.clear_done : 'گزارش پاک شد.') + '</strong>');
        }
      });
  }

  function runScan() {
    var $btn = $('.prk-ng-run-scan');
    $btn.prop('disabled', true).text(config().i18n && config().i18n.scan ? config().i18n.scan : 'در حال اجرای اسکن...');
    setScanResult('در حال اجرای اسکن صفحات منتخب...');

    ajax('prk_ng_run_scan', { clear: 1 })
      .done(function (response) {
        if (!response || !response.success) {
          setScanResult('اسکن با خطا روبرو شد.');
          return;
        }

        updatePanel(response.data);

        var html = '<strong>اسکن انجام شد.</strong>';
        if (response.data.scan_results && response.data.scan_results.length) {
          html += '<ul>';
          response.data.scan_results.forEach(function (item) {
            html += '<li>' + item.status + ' / ' + item.time_ms + 'ms - ' + $('<div>').text(item.url).html() + '</li>';
          });
          html += '</ul>';
        }
        setScanResult(html);
      })
      .fail(function () {
        setScanResult(config().i18n && config().i18n.error ? config().i18n.error : 'خطا در پردازش درخواست.');
      })
      .always(function () {
        $btn.prop('disabled', false).text('اجرای اسکن صفحات منتخب');
      });
  }

  function addRule(host, list) {
    if (!host) {
      return;
    }

    ajax('prk_ng_add_rule', { host: host, list: list })
      .done(function (response) {
        if (response && response.success) {
          updatePanel(response.data);
          setScanResult('<strong>' + host + '</strong> به لیست ' + (list === 'allow' ? 'مستثنی' : 'بلاک') + ' اضافه شد. برای اعمال کامل، تنظیمات را ذخیره کنید.');
        }
      });
  }

  function startAutoRefresh() {
    stopAutoRefresh(false);
    setLiveState(true);
    state.timer = window.setInterval(function () {
      if ($('.prk-ng-auto-refresh').is(':checked') && $('#prk-ng-scanner-modal').hasClass('is-open')) {
        refreshLogs();
      }
    }, 3500);
  }

  function stopAutoRefresh(updateState) {
    if (state.timer) {
      window.clearInterval(state.timer);
      state.timer = null;
    }

    if (updateState !== false) {
      setLiveState(false);
    }
  }

  $(document)
    .on('click', '.prk-ng-open-scanner', function () {
      PrkModal.openById('prk-ng-scanner-modal');
      refreshLogs();
      startAutoRefresh();
    })
    .on('click', '[data-prk-ng-close], .prk-ng-close-modal', function () {
      PrkModal.closeById('prk-ng-scanner-modal');
      stopAutoRefresh();
    })
    .on('keydown', function (event) {
      if (event.key === 'Escape' && $('#prk-ng-scanner-modal').hasClass('is-open')) {
        PrkModal.closeById('prk-ng-scanner-modal');
        stopAutoRefresh();
      }
    })
    .on('click', '.prk-ng-refresh', function () {
      refreshLogs();
    })
    .on('click', '.prk-ng-clear', function () {
      clearLogs();
    })
    .on('click', '.prk-ng-run-scan', function () {
      runScan();
    })
    .on('click', '.prk-ng-add-block', function () {
      addRule($(this).data('host'), 'block');
    })
    .on('click', '.prk-ng-add-allow', function () {
      addRule($(this).data('host'), 'allow');
    })
    .on('click', '.prk-ng-export', function () {
      var url = config().ajax_url + '?action=prk_ng_export_logs&nonce=' + encodeURIComponent(config().nonce || '');
      window.location.href = url;
    });
})(jQuery, window, document);
