;(function ($, window, document, undefined) {
    'use strict';

    let LATMMO = window.LATMMO || {};

    let $body = $('body');
    let $window = $(window);

    LATMMO.AddLoading = function () {
        $('<div class="latmmo-loading"><span></span></div>').appendTo($body);
    }

    LATMMO.AddButtonImportProductList = function () {
        $('.latmmo-product-list').each(function () {
            let $this = $(this);
            let addnew_btn = $this.find('.csf-cloneable-add');

            addnew_btn.after('<a name="' + latmmo_script.popup_name + '" class="button button-primary latmmo-import-product thickbox" href="#TB_inline?&width=600&height=550&inlineId=latmmoModalImportProduct">' + latmmo_script.import_btn + '</a>');
        });
    }

    LATMMO.SearchProductinPopup = function() {
        $('.latmmo-btn-search').on('click', function () {
            let $this   = $(this);
            let wrapper = $this.parent('.latmmo-search-form');
            let output  = wrapper.siblings('.latmmo-search-content');
            let val     = wrapper.find('input').val();

            let data = {
                'action': 'latmmo_product_search_ajax',
                's': val,
            }

            $.ajax({
                method: 'POST',
                url: latmmo_script.ajax_url,
                data: data,
                dataType: 'json',
                beforeSend: function () {
                    $('.latmmo-loading').addClass('open');
                },
                success: function (response) {
                    $('.latmmo-loading').removeClass('open');

                    output.empty();
                    output.append(response);
                    LATMMO.SubmitGetProductInModal();
                }
            })
        })
    }

    LATMMO.SubmitGetProductInModal = function () {
        $('.item-btn-sumbit').unbind('click').bind('click', function () {
            let $this = $(this);
            let items = $this.siblings('.item-products');

            var data = new Array();

            items.find('.item-check').each(function () {
                if ($(this).is(':checked')) {
                    data.push($(this).siblings('.item-val').val());
                }
            });

            let data_ajax = {
                'action': 'latmmo_import_product_to_table_ajax',
                'data': data,
                'l': $('.latmmo-product-list').find('.csf-cloneable-item').length
            }

            $.ajax({
                method: 'POST',
                url: latmmo_script.ajax_url,
                data: data_ajax,
                dataType: 'json',
                beforeSend: function () {
                    $('.latmmo-loading').addClass('open');
                },
                success: function (response) {
                    $('.latmmo-loading').removeClass('open');
                    $('.latmmo-product-list .csf-cloneable-wrapper').append(response);
                    $('#publish').click();
                }
            })

        });
    }

    LATMMO.UpdateInfoWhenSelectProductDb = function () {
        $('.select-product-db select').on('change', function () {
            let $this    = $(this);
            let pid      = $this.val();
            let wrap     = $this.parents('.select-product-db');

            let data = {
                'action': 'latmmo_table_update_info_when_change_product',
                'p': pid
            }

            $.ajax({
                method: 'POST',
                url: latmmo_script.ajax_url,
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $('.latmmo-loading').addClass('open');
                },
                success: function(response) {
                    $('.latmmo-loading').removeClass('open');

                    wrap.siblings('.product-image').find('input').val(response.img);
                    wrap.siblings('.product-image').find('img').attr('src', response.img);

                    wrap.siblings('.product-asin').find('input').val(response.asin);
                    wrap.siblings('.product-asin').find('a').attr('href', 'https://amazon.com/dp/' + response.asin);

                    wrap.siblings('.product-score').find('input').val(response.rate);
                    wrap.siblings('.product-price').find('input').val(response.price);
                    wrap.siblings('.product-review-count').find('input').val(response.rc);

                    LATMMO.CustomTalbeProductTitle();
                }
            });
        });

    };

    LATMMO.ProductUpdateInfo = function () {
        $('.product-asin').each(function () {
            $(this).find('a').attr('href', 'https://amazon.com/dp/' + $(this).find('input').val());
        });

        $('.product-image').each(function () {
            $(this).find('img').attr('src', $(this).find('input').val());
        });
    }

    LATMMO.CustomTalbeProductTitle = function () {
        $('.latmmo-product-list').find('.csf-cloneable-item').each(function () {
            let $this   = $(this);
            let title   = $this.find('.select-product-db select option:selected').html();
            let asin    = $this.find('.product-asin input').val();

            $this.find('.csf-cloneable-text .csf-cloneable-value').html(title + '. ' + asin);
        });
    };

    $(document).ready(function () {
        LATMMO.AddLoading();
        LATMMO.AddButtonImportProductList();
        LATMMO.SearchProductinPopup();
        LATMMO.UpdateInfoWhenSelectProductDb();
        LATMMO.ProductUpdateInfo();
        LATMMO.CustomTalbeProductTitle();
    });

})(jQuery, window, document);