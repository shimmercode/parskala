/**
 * Vira interactive modules.
 */
(function ($) {
	'use strict';
	if (typeof viraVars === 'undefined') {
		return;
	}

	function ajax(data) {
		data.security = viraVars.nonce;
		return $.post(viraVars.ajaxUrl, data);
	}

	$(document).on('click', '.js-open-otp-modal', function (e) {
		e.preventDefault();
		$('#vira-otp-modal').addClass('active');
	});
	$(document).on('click', '.js-close-otp, #vira-otp-modal', function (e) {
		if (e.target === this || $(e.target).hasClass('js-close-otp')) {
			$('#vira-otp-modal').removeClass('active');
		}
	});

	$(document).on('click', '.vira-sticky-add-btn', function () {
		var $bar = $(this).closest('.vira-sticky-purchase-bar');
		var $form = $('form.cart').first();
		if ($form.length) {
			$form.find('input.qty').val($bar.find('.vira-sticky-qty').val() || 1);
			$form.find('button[type=submit], .single_add_to_cart_button').trigger('click');
			return;
		}
		ajax({ action: 'woocommerce_add_to_cart', product_id: $bar.data('product-id'), quantity: $bar.find('.vira-sticky-qty').val() || 1 }).done(function () {
			window.location.href = (typeof wc_add_to_cart_params !== 'undefined' && wc_add_to_cart_params.cart_url) ? wc_add_to_cart_params.cart_url : '/cart';
		});
	});

	$(document).on('submit', '#vira-otp-form', function (e) {
		e.preventDefault();
		var $form = $(this);
		var mobile = $form.find('[name="mobile"]').val();
		if ($form.data('step') === 'verify') {
			ajax({ action: 'vira_verify_otp', mobile: mobile, code: $form.find('[name="code"]').val() }).done(function (res) {
				if (res.success) {
					window.location.href = res.data.redirect || '/';
				} else {
					alert(res.data && res.data.message ? res.data.message : 'خطا');
				}
			});
			return;
		}
		ajax({ action: 'vira_send_otp', mobile: mobile }).done(function (res) {
			if (res.success) {
				$form.data('step', 'verify');
				$form.find('[name="mobile"]').prop('readonly', true);
				if (!$form.find('[name="code"]').length) {
					$form.find('.button').before('<input type="text" name="code" placeholder="کد ۵ رقمی" required>');
				}
				$form.find('.button').text('تایید کد');
			} else {
				alert(res.data && res.data.message ? res.data.message : 'ارسال ناموفق');
			}
		});
	});

	$(document).on('click', '.vira-instant-buy-btn', function (e) {
		e.preventDefault();
		ajax({ action: 'vira_instant_buy', product_id: $(this).data('product-id'), qty: $('input.qty').val() || 1 }).done(function (res) {
			if (res.success) {
				window.location.href = res.data.redirect;
			} else {
				alert(res.data && res.data.message ? res.data.message : 'خطا در خرید فوری');
			}
		});
	});

	$(document).on('submit', '#vira-filter-form', function (e) {
		e.preventDefault();
		var payload = $(this).serializeArray();
		var data = { action: 'vira_ajax_filter', security: viraVars.nonce };
		payload.forEach(function (f) {
			if (f.name === 'cats[]') {
				if (!data.cats) {
					data.cats = [];
				}
				data.cats.push(f.value);
			} else {
				data[f.name] = f.value;
			}
		});
		$.post(viraVars.ajaxUrl, data).done(function (res) {
			if (res.success) {
				var $ul = $('ul.products').first();
				if ($ul.length) {
					$ul.replaceWith(res.data.html);
				} else {
					$('.woocommerce-products-header').after(res.data.html);
				}
			}
		});
	});

	$(document).on('click', '.js-toggle-filter', function () {
		$('#vira-filter-form').toggleClass('open');
	});

	$(document).on('click', '.vira-add-bundle', function () {
		ajax({ action: 'vira_add_bundle', ids: $(this).data('ids') }).done(function (res) {
			if (res.success) {
				window.location.href = res.data.redirect;
			}
		});
	});

	function tickTimers() {
		$('.vira-stock-timer').each(function () {
			var end = parseInt($(this).data('end'), 10) * 1000;
			var d = Math.max(0, end - Date.now());
			var h = Math.floor(d / 3600000);
			var m = Math.floor((d % 3600000) / 60000);
			var s = Math.floor((d % 60000) / 1000);
			$(this).find('.t-h').text(('0' + h).slice(-2));
			$(this).find('.t-m').text(('0' + m).slice(-2));
			$(this).find('.t-s').text(('0' + s).slice(-2));
		});
	}
	setInterval(tickTimers, 1000);
	tickTimers();

	$(document).on('click', '.vira-compare-btn', function () {
		ajax({ action: 'vira_compare_toggle', id: $(this).data('id') }).done(function (res) {
			if (res.success) {
				window.location.reload();
			}
		});
	});

	$(document).on('submit', '.vira-price-alert-form', function (e) {
		e.preventDefault();
		ajax({ action: 'vira_price_alert', product_id: $(this).data('product'), mobile: $(this).find('[name="mobile"]').val(), target: $(this).find('[name="target"]').val() }).done(function (res) {
			alert(res.data && res.data.message ? res.data.message : (res.success ? 'ثبت شد' : 'خطا'));
		});
	});

	$(document).on('click', '.vira-save-later', function () {
		ajax({ action: 'vira_save_later', key: $(this).data('key'), id: $(this).data('id') }).done(function () {
			window.location.reload();
		});
	});

	$(document).on('click', '.vira-size-guide-open', function (e) {
		e.preventDefault();
		$('#vira-size-guide-modal').addClass('active');
	});

	$(document).on('submit', '.vira-guest-track-form', function (e) {
		e.preventDefault();
		var $f = $(this);
		ajax({ action: 'vira_guest_track_order', order_id: $f.find('[name="order_id"]').val(), mobile: $f.find('[name="mobile"]').val() }).done(function (res) {
			if (!res.success) {
				$f.find('.vira-track-result').text(res.data.message || 'یافت نشد');
				return;
			}
			var items = (res.data.items || []).join('، ');
			var tr = res.data.tracking ? ' — کد: ' + res.data.tracking : '';
			$f.find('.vira-track-result').text('وضعیت: ' + res.data.status + ' — ' + res.data.total + ' — ' + items + tr);
		});
	});

	$('.comment-form, #commentform').attr('enctype', 'multipart/form-data');

	var searchTimer;
	var searchHi = -1;
	var $live = $('#vira-live-search');
	var $res = $('#vira-live-search-results');
	function searchItems() {
		return $res.find('a');
	}
	$live.on('input', function () {
		var q = $.trim($live.val());
		clearTimeout(searchTimer);
		searchHi = -1;
		if (q.length < 2) {
			$res.attr('hidden', true).empty();
			return;
		}
		$res.removeAttr('hidden').text('...');
		searchTimer = setTimeout(function () {
			$.get(viraVars.ajaxUrl, { action: 'vira_smart_search', security: viraVars.nonce, q: q }).done(function (res) {
				var d = res.data || {};
				var list = Array.isArray(d) ? d : [].concat(d.products || [], d.cats || [], d.brands || []);
				if (!res.success || !list.length) {
					$res.html('<div class="empty">نتیجه‌ای نیست</div>');
					return;
				}
				var html = '<ul>';
				list.forEach(function (item) {
					html += '<li><a href="' + item.url + '">' + (item.type && item.type !== 'product' ? '[' + item.type + '] ' : '') + item.title + '</a></li>';
				});
				html += '</ul>';
				$res.html(html);
			});
		}, 300);
	});
	$live.on('keydown', function (e) {
		var $a = searchItems();
		if (e.key === 'Escape') {
			$res.attr('hidden', true);
		}
		if (e.key === 'ArrowDown') {
			e.preventDefault();
			searchHi = Math.min(searchHi + 1, $a.length - 1);
			$a.removeClass('is-active').eq(searchHi).addClass('is-active').focus();
		}
		if (e.key === 'ArrowUp') {
			e.preventDefault();
			searchHi = Math.max(searchHi - 1, 0);
			$a.removeClass('is-active').eq(searchHi).addClass('is-active').focus();
		}
		if (e.key === 'Enter' && searchHi >= 0 && $a.eq(searchHi).length) {
			e.preventDefault();
			window.location.href = $a.eq(searchHi).attr('href');
		}
	});

	$(document).on('click', '.vira-quick-view', function () {
		ajax({ action: 'vira_quick_view', id: $(this).data('id') }).done(function (res) {
			if (res.success) {
				var $m = $('#vira-qv-modal');
				if (!$m.length) {
					$m = $('<div id="vira-qv-modal" class="vira-modal-overlay active"><div class="vira-modal-box"><button type="button" class="vira-modal-close">&times;</button><div class="vira-modal-body"></div></div></div>');
					$('body').append($m);
				}
				$m.addClass('active').find('.vira-modal-body').html(res.data.html);
			}
		});
	});
	$(document).on('click', '.vira-qv-add', function () {
		var $q = $('.vira-qv');
		var attrs = {};
		$q.find('.vira-qv-attr').each(function () {
			attrs[$(this).attr('name')] = $(this).val();
		});
		var vid = 0;
		var $json = $q.find('.vira-qv-vars');
		if ($json.length) {
			try {
				JSON.parse($json.text()).forEach(function (v) {
					var ok = true;
					Object.keys(v.attrs).forEach(function (k) {
						if (v.attrs[k] && attrs[k] !== v.attrs[k]) {
							ok = false;
						}
					});
					if (ok) {
						vid = v.id;
					}
				});
			} catch (e) {}
		}
		ajax({ action: 'vira_qv_add', product_id: $q.data('id'), variation_id: vid, qty: $q.find('.vira-qv-qty').val() || 1 }).done(function (res) {
			if (res.success) {
				window.location.href = res.data.cart;
			} else {
				alert(res.data && res.data.message ? res.data.message : 'خطا');
			}
		});
	});

	if ($('#vira-checkout-map').length && typeof L !== 'undefined') {
		var map = L.map('vira-checkout-map').setView([35.6892, 51.389], 11);
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
		var marker;
		map.on('click', function (ev) {
			if (marker) {
				marker.setLatLng(ev.latlng);
			} else {
				marker = L.marker(ev.latlng).addTo(map);
			}
			$('#vira_lat').val(ev.latlng.lat);
			$('#vira_lng').val(ev.latlng.lng);
			ajax({ action: 'vira_reverse_geo', lat: ev.latlng.lat, lng: ev.latlng.lng }).done(function (res) {
				if (res.success && res.data.address) {
					$('[name="vira_manual_address"]').val(res.data.address);
				}
			});
		});
	}

	var storyIndex = 0;
	var storyTimer;
	function showStory(i) {
		if (!window.viraStories || !window.viraStories.length) {
			return;
		}
		storyIndex = (i + window.viraStories.length) % window.viraStories.length;
		var it = window.viraStories[storyIndex];
		var $p = $('#vira-story-player').removeAttr('hidden');
		var media = it.type === 'video'
			? '<video src="' + it.media + '" autoplay playsinline></video>'
			: '<img src="' + it.media + '" alt="">';
		$p.find('.vira-story-media').html(media);
		$p.find('.vira-story-cta').attr('href', it.cta || '#').toggle(!!it.cta);
		var $atc = $p.find('.vira-story-atc');
		if (it.product_id) {
			$atc.removeAttr('hidden').data('pid', it.product_id);
		} else {
			$atc.attr('hidden', true);
		}
		clearTimeout(storyTimer);
		storyTimer = setTimeout(function () { showStory(storyIndex + 1); }, (it.duration || 5) * 1000);
	}
	$(document).on('click', '.js-vira-story', function () {
		showStory(parseInt($(this).data('index'), 10) || 0);
	});
	$(document).on('click', '.vira-story-close', function () {
		clearTimeout(storyTimer);
		$('#vira-story-player').attr('hidden', true);
	});
	$(document).on('click', '.vira-story-mute', function () {
		var v = $('#vira-story-player video')[0];
		if (v) {
			v.muted = !v.muted;
		}
	});
	$(document).on('click', '#vira-story-player .vira-story-media', function (e) {
		if (e.clientX > window.innerWidth / 2) {
			showStory(storyIndex + 1);
		} else {
			showStory(storyIndex - 1);
		}
	});
})(jQuery);
