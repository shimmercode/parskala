/**
 * Vira Theme Modal Engine (Location, Price Chart, OTP SMS, Better Price)
 *
 * @package Vira
 * @since   1.0.0
 */

(function($) {
    'use strict';

    window.ViraModals = {
        init: function() {
            this.initModalClose();
            this.initLocationAjax();
            this.initPriceChartModal();
            this.initTrustReportAjax();
        },

        initModalClose: function() {
            $(document).on('click', '.vira-modal-close, .vira-modal-overlay', function(e) {
                if ( e.target === this ) {
                    $('.vira-modal-overlay').removeClass('active');
                }
            });
        },

        initLocationAjax: function() {
            $(document).on('change', '#vira-select-province', function() {
                var province = $(this).val();
                $.ajax({
                    url: viraVars.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'vira_get_cities',
                        security: viraVars.nonce,
                        province: province
                    },
                    success: function(res) {
                        if ( res.success && res.data.cities ) {
                            var $citySelect = $('#vira-select-city');
                            $citySelect.empty();
                            $.each(res.data.cities, function(i, city) {
                                $citySelect.append($('<option>', { value: city, text: city }));
                            });
                        }
                    }
                });
            });

            $(document).on('submit', '#vira-location-form', function(e) {
                e.preventDefault();
                var province = $('#vira-select-province').val();
                var city     = $('#vira-select-city').val();

                $.ajax({
                    url: viraVars.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'vira_save_location',
                        security: viraVars.nonce,
                        province: province,
                        city: city
                    },
                    success: function(res) {
                        if ( res.success ) {
                            $('.vira-header-location-pill .location-text').html('ارسال به: <strong>' + province + '، ' + city + '</strong>');
                            $('.vira-modal-overlay').removeClass('active');
                        }
                    }
                });
            });
        },

        initPriceChartModal: function() {
            // Lazy load Chart.js only when price chart button is clicked ([VIRA-19] Performance Rule)
            $(document).on('click', '.js-open-price-chart', function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                var $modal    = $('#vira-price-chart-modal');
                $modal.addClass('active');

                var loadChart = function() {
                    $.ajax({
                        url: viraVars.ajaxUrl,
                        type: 'GET',
                        data: {
                            action: 'vira_get_price_chart',
                            security: viraVars.nonce,
                            product_id: productId
                        },
                        success: function(res) {
                            if ( res.success ) {
                                var ctx = document.getElementById('vira-chart-canvas').getContext('2d');
                                if ( window.viraPriceChartInstance ) {
                                    window.viraPriceChartInstance.destroy();
                                }
                                window.viraPriceChartInstance = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: res.data.labels,
                                        datasets: [{
                                            label: 'قیمت محصول (تومان)',
                                            data: res.data.prices,
                                            borderColor: '#ef394e',
                                            backgroundColor: 'rgba(239, 57, 78, 0.1)',
                                            borderWidth: 2,
                                            fill: true,
                                            tension: 0.3
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false
                                    }
                                });
                            }
                        }
                    });
                };

                if ( typeof Chart === 'undefined' ) {
                    $.getScript('https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', loadChart);
                } else {
                    loadChart();
                }
            });
        },

        initTrustReportAjax: function() {
            $(document).on('click', '.js-open-better-price, .js-open-problem-report', function(e) {
                e.preventDefault();
                var $modal = $('#vira-trust-modal');
                $modal.find('input[name="product_id"]').val($(this).data('product-id'));
                $modal.find('input[name="type"]').val($(this).hasClass('js-open-better-price') ? 'better_price' : 'problem_report');
                $modal.addClass('active');
            });

            $(document).on('submit', '#vira-trust-form', function(e) {
                e.preventDefault();
                var $form = $(this);
                $.ajax({
                    url: viraVars.ajaxUrl,
                    type: 'POST',
                    data: $form.serialize() + '&action=vira_submit_trust_report&security=' + viraVars.nonce,
                    success: function(res) {
                        if ( res.success ) {
                            alert(res.data.message);
                            $('.vira-modal-overlay').removeClass('active');
                            $form[0].reset();
                        } else {
                            alert(res.data.message);
                        }
                    }
                });
            });
        }
    };

    $(document).ready(function() {
        ViraModals.init();
    });

})(jQuery);
```

