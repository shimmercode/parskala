/*
    A simple jQuery storymodal (http://github.com/kylefox/jquery-storymodal)
    Version 0.9.2
*/

(function (factory) {
    // Making your jQuery plugin work better with npm tools
    // http://blog.npmjs.org/post/112712169830/making-your-jquery-plugin-work-better-with-npm
    if (typeof module === 'object' && typeof module.exports === 'object') {
        factory(require('jquery'), window, document);
    } else {
        factory(jQuery, window, document);
    }
})(function ($, window, document, undefined) {
    var storymodals = [],
        getCurrent = function () {
            return storymodals.length
                ? storymodals[storymodals.length - 1]
                : null;
        },
        selectCurrent = function () {
            var i,
                selected = false;
            for (i = storymodals.length - 1; i >= 0; i--) {
                if (storymodals[i].$blocker) {
                    storymodals[i].$blocker
                        .toggleClass('current', !selected)
                        .toggleClass('behind', selected);
                    selected = true;
                }
            }
        };

    $.storymodal = function (el, options) {
        var remove, target;
        this.$body = $('body');
        this.options = $.extend({}, $.storymodal.defaults, options);
        this.options.doFade = !isNaN(parseInt(this.options.fadeDuration, 10));
        this.$blocker = null;
        if (this.options.closeExisting)
            while ($.storymodal.isActive()) $.storymodal.close(); // Close any open storymodals.
        storymodals.push(this);
        if (el.is('a')) {
            target = el.attr('href');
            this.anchor = el;
            //Select element by id from href
            if (/^#/.test(target)) {
                this.$elm = $(target);
                if (this.$elm.length !== 1) return null;
                this.$body.append(this.$elm);
                this.open();
                //AJAX
            } else {
                this.$elm = $('<div>');
                this.$body.append(this.$elm);
                remove = function (event, storymodal) {
                    storymodal.elm.remove();
                };
                this.showSpinner();
                el.trigger($.storymodal.AJAX_SEND);
                $.get(target)
                    .done(function (html) {
                        if (!$.storymodal.isActive()) return;
                        el.trigger($.storymodal.AJAX_SUCCESS);
                        var current = getCurrent();
                        current.$elm
                            .empty()
                            .append(html)
                            .on($.storymodal.CLOSE, remove);
                        current.hideSpinner();
                        current.open();
                        el.trigger($.storymodal.AJAX_COMPLETE);
                    })
                    .fail(function () {
                        el.trigger($.storymodal.AJAX_FAIL);
                        var current = getCurrent();
                        current.hideSpinner();
                        storymodals.pop(); // remove expected storymodal from the list
                        el.trigger($.storymodal.AJAX_COMPLETE);
                    });
            }
        } else {
            this.$elm = el;
            this.anchor = el;
            this.$body.append(this.$elm);
            this.open();
        }
    };

    $.storymodal.prototype = {
        constructor: $.storymodal,

        open: function () {
            var m = this;
            this.block();
            this.anchor.blur();
            if (this.options.doFade) {
                setTimeout(function () {
                    m.show();
                }, this.options.fadeDuration * this.options.fadeDelay);
            } else {
                this.show();
            }
            $(document)
                .off('keydown.storymodal')
                .on('keydown.storymodal', function (event) {
                    var current = getCurrent();
                    if (event.which === 27 && current.options.escapeClose)
                        current.close();
                });
            if (this.options.clickClose)
                this.$blocker.click(function (e) {
                    if (e.target === this) $.storymodal.close();
                });
        },

        close: function () {
            storymodals.pop();
            this.unblock();
            this.hide();
            if (!$.storymodal.isActive()) $(document).off('keydown.storymodal');
        },

        block: function () {
            this.$elm.trigger($.storymodal.BEFORE_BLOCK, [this._ctx()]);
            this.$body.css('overflow', 'hidden');
            this.$blocker = $(
                '<div class="' +
                    this.options.blockerClass +
                    ' blocker current"></div>'
            ).appendTo(this.$body);
            selectCurrent();
            if (this.options.doFade) {
                this.$blocker
                    .css('opacity', 0)
                    .animate({ opacity: 1 }, this.options.fadeDuration);
            }
            this.$elm.trigger($.storymodal.BLOCK, [this._ctx()]);
        },

        unblock: function (now) {
            if (!now && this.options.doFade)
                this.$blocker.fadeOut(
                    this.options.fadeDuration,
                    this.unblock.bind(this, true)
                );
            else {
                this.$blocker.children().appendTo(this.$body);
                this.$blocker.remove();
                this.$blocker = null;
                selectCurrent();
                if (!$.storymodal.isActive()) this.$body.css('overflow', '');
            }
        },

        show: function () {
            this.$elm.trigger($.storymodal.BEFORE_OPEN, [this._ctx()]);
            if (this.options.showClose) {
                this.closeButton = $(
                    '<a href="#close-storymodal" rel="storymodal:close" class="close-storymodal ' +
                        this.options.closeClass +
                        '">' +
                        this.options.closeText +
                        '</a>'
                );
                this.$elm.append(this.closeButton);
            }
            this.$elm.addClass(this.options.modalClass).appendTo(this.$blocker);
            if (this.options.doFade) {
                this.$elm
                    .css({ opacity: 0, display: 'inline-block' })
                    .animate({ opacity: 1 }, this.options.fadeDuration);
            } else {
                this.$elm.css('display', 'inline-block');
            }
            this.$elm.trigger($.storymodal.OPEN, [this._ctx()]);
        },

        hide: function () {
            this.$elm.trigger($.storymodal.BEFORE_CLOSE, [this._ctx()]);
            if (this.closeButton) this.closeButton.remove();
            var _this = this;
            if (this.options.doFade) {
                this.$elm.fadeOut(this.options.fadeDuration, function () {
                    _this.$elm.trigger($.storymodal.AFTER_CLOSE, [
                        _this._ctx(),
                    ]);
                });
            } else {
                this.$elm.hide(0, function () {
                    _this.$elm.trigger($.storymodal.AFTER_CLOSE, [
                        _this._ctx(),
                    ]);
                });
            }
            this.$elm.trigger($.storymodal.CLOSE, [this._ctx()]);
        },

        showSpinner: function () {
            if (!this.options.showSpinner) return;
            this.spinner =
                this.spinner ||
                $(
                    '<div class="' +
                        this.options.storymodalClass +
                        '-spinner"></div>'
                ).append(this.options.spinnerHtml);
            this.$body.append(this.spinner);
            this.spinner.show();
        },

        hideSpinner: function () {
            if (this.spinner) this.spinner.remove();
        },

        //Return context for custom events
        _ctx: function () {
            return {
                elm: this.$elm,
                $elm: this.$elm,
                $blocker: this.$blocker,
                options: this.options,
                $anchor: this.anchor,
            };
        },
    };

    $.storymodal.close = function (event) {
        if (!$.storymodal.isActive()) return;
        if (event) event.preventDefault();
        var current = getCurrent();
        current.close();
        return current.$elm;
    };

    // Returns if there currently is an active storymodal
    $.storymodal.isActive = function () {
        return storymodals.length > 0;
    };

    $.storymodal.getCurrent = getCurrent;

    $.storymodal.defaults = {
        closeExisting: true,
        escapeClose: true,
        clickClose: true,
        closeText: 'Close',
        closeClass: '',
        storymodalClass: 'storymodal',
        blockerClass: 'jquery-storymodal',
        spinnerHtml:
            '<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div>',
        showSpinner: true,
        showClose: true,
        fadeDuration: null, // Number of milliseconds the fade animation takes.
        fadeDelay: 1.0, // Point during the overlay's fade-in that the storymodal begins to fade in (.5 = 50%, 1.5 = 150%, etc.)
    };

    // Event constants
    $.storymodal.BEFORE_BLOCK = 'storymodal:before-block';
    $.storymodal.BLOCK = 'storymodal:block';
    $.storymodal.BEFORE_OPEN = 'storymodal:before-open';
    $.storymodal.OPEN = 'storymodal:open';
    $.storymodal.BEFORE_CLOSE = 'storymodal:before-close';
    $.storymodal.CLOSE = 'storymodal:close';
    $.storymodal.AFTER_CLOSE = 'storymodal:after-close';
    $.storymodal.AJAX_SEND = 'storymodal:ajax:send';
    $.storymodal.AJAX_SUCCESS = 'storymodal:ajax:success';
    $.storymodal.AJAX_FAIL = 'storymodal:ajax:fail';
    $.storymodal.AJAX_COMPLETE = 'storymodal:ajax:complete';

    $.fn.storymodal = function (options) {
        if (this.length === 1) {
            new $.storymodal(this, options);
        }
        return this;
    };

    // Automatically bind links with rel="storymodal:close" to, well, close the storymodal.
    $(document).on(
        'click.storymodal',
        'a[rel~="storymodal:close"]',
        $.storymodal.close
    );
    $(document).on(
        'click.storymodal',
        'a[rel~="storymodal:open"]',
        function (event) {
            event.preventDefault();
            $(this).storymodal();
        }
    );
});
