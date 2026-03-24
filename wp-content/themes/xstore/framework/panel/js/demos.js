/**
 * Panel Import Demos page scripts
 *
 * @version 1.0.0
 * @since 8.0.5
 */

window.et_panel = window.et_panel || {};
!function($) {

    var et_demos = {
        demos_engine_filter: function(_this,e){
            if ( _this.hasClass('active')) return;
            let engine_filter = _this.attr('data-filter'),
                versions_filter = $('.versions-filter.active').attr('data-filter');

            $('.engine-filter').removeClass('active');
            _this.addClass('active');
            $.each($('.version-preview'), function () {
                let __this = $(this),
                    button = __this.find('.button-preview');

                if ( button.attr('data-href')) {
                    let href = button.attr('href');
                    button.attr('href', button.attr('data-href')).attr('data-href', href);
                }
                __this.attr('data-active-filter', versions_filter + ' ' + engine_filter);
                if (__this.attr('data-filter').indexOf(engine_filter) != -1 && __this.attr('data-filter').indexOf(versions_filter) != -1) {
                    __this.removeClass('et-hide').removeClass('et-show');
                } else {
                    __this.removeClass('et-show').addClass('et-hide');
                }
            });
        },
        demos_version_filter: function(_this,e){
            let versions_filter = _this.attr('data-filter'),
                engine_filter = $('.engine-filter.active').attr('data-filter');

            $('.versions-filter').removeClass('active');
            _this.addClass('active');
            $.each($('.version-preview'), function () {
                let __this = $(this);
                __this.attr('data-active-filter', versions_filter + ' ' + engine_filter);
                if (__this.attr('data-filter').indexOf(versions_filter) != -1 && $(this).attr('data-filter').indexOf(engine_filter) != -1) {
                    __this.removeClass('et-hide').removeClass('et-show');
                } else {
                    __this.removeClass('et-show').addClass('et-hide');
                }
            });
            _this.parent().removeClass('active');
        },
        demos_filter_toggle: function(_this,e){
            _this.parent().find('ul').toggleClass('active');
        },
        // Remove it if no bug will found
        demos_onready_filters: function(_this,e){
            let engine_filter = $('.et-filter.engine-filter.active').attr('data-filter'),
                versions_filter = $('.versions-filter.active').attr('data-filter');
            $.each($('.version-preview'), function () {
                let __this = $(this);
                __this.attr('data-active-filter', versions_filter + ' ' + engine_filter);
                if (__this.attr('data-filter').indexOf(engine_filter) != -1 && __this.attr('data-filter').indexOf(versions_filter) != -1) {
                    __this.removeClass('et-hide').removeClass('et-show');
                } else {
                    __this.removeClass('et-show').addClass('et-hide');
                }
            });
        },
    };

    window.et_panel = Object.assign(window.et_panel,et_demos);

    var et_import_actions = {
        '1': {
            selector: '.engine-filter',
            type: 'click',
            callback : et_panel.demos_engine_filter
        },
        '2': {
            selector: '.versions-filter',
            type: 'click',
            callback : et_panel.demos_version_filter
        },
        '3': {
            selector: '.et-filter-toggle',
            type: 'click',
            callback : et_panel.demos_filter_toggle
        },
        //'4': { // Remove it if no bug will found
        //    selector: '',
        //    type: 'ready',
        //    callback : et_panel.demos_onready_filters
        //},
    }

    $.each(et_import_actions, function (i, t) {
        if (t.type == 'ready'){
            $(document).ready(function (e) {
                t.callback($(this),e);
            });
        } else {
            $(t.selector).on(t.type,function (e){
                t.callback($(this),e);
            });
        }
    });
}(jQuery,window.et_panel);