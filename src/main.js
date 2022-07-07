import Nav from './nav';

((w, $) => {
    'use strict';

    const fixPriceWholesaleSingleProduct = () => {
        if (!$('.wwp-wholesale-pricing-details').length) return;

        $('body').addClass('has-wholesale');

        let $price_df = $('.wwp-wholesale-pricing-details p:nth-child(2)').html();
        $('.wwp-wholesale-pricing-details').data('price-df', $price_df);

        $('.variations_form').on(
            'found_variation',
            (e, variation) => {
                $('.wwp-wholesale-pricing-details p:nth-child(2)').html(variation['price_html']);
                $('.wwp-wholesale-pricing-details p:nth-child(2)').addClass('price-changed');
            }
        );

        $(".variations_form").on("woocommerce_variation_select_change", function (variation) {
            let pa_size = $('#pa_size').val()
            let pa_colour = $('#pa_colour').val()
            if (pa_size == '' || pa_colour == '') {
                $('.wwp-wholesale-pricing-details p:nth-child(2)').html($('.wwp-wholesale-pricing-details').data('price-df'));
                $('.wwp-wholesale-pricing-details p:nth-child(2)').removeClass('price-changed');
            }
        });

        // $(document).ajaxComplete((event, xhr, settings) => {
        //      console.log([event, xhr, settings]) 
        //     // if (!settings.data.search) return; 
        //     if (settings.data.search('action=get_price_product_with_bulk_table') != -1) {
        //         $('.woocommerce-variation .woocommerce-variation-price').html(currentPrice)
        //     }
        // })
    }

    const spinButtonQuanlityProduct = () => {
        $(document).on("click", ".input-spin-button.outer-spin-button", function () {
            let $this = $(this);
            let inputVal = $this.parent().find('input').val()
            let newVal = parseInt(inputVal) + 1
            $this.parent().find("input").val(newVal);
        });

        $(document).on("click", ".input-spin-button.inner-spin-button", function () {
            let $this = $(this);
            let inputVal = $this.parent().find('input').val()
            if (parseInt(inputVal) == 1) return
            let newVal = parseInt(inputVal) - 1

            $this.parent().find("input").val(newVal);
        });
    }

    const replaceRegisterFormWholeSaler = () => {

        $('.wwp_wholesaler_registration_form h2').each(function () {
            let txtHeading = $(this).text();
            let newHeading = txtHeading.substring(9, txtHeading.length);
            $(this).text(newHeading);
        })

        $('.wwp_wholesaler_registration_form input[type="checkbox"]').prop("checked", true).trigger("change");

        const labelCopyBilling = $('label[for="wwp_wholesaler_copy_billing_address"]');
        const newLabelCopyBilling = 'Uncheck this box if you like to enter a different shipping address.';
        labelCopyBilling.text(newLabelCopyBilling);
        const wrapperCheckbox = labelCopyBilling.parent();
        const inputCheckbox = labelCopyBilling.parent().find('input');
        wrapperCheckbox.addClass('wrap-checkbox-billing')
        inputCheckbox.insertBefore(labelCopyBilling);
    }

    const checkTableBulkDeal = () => {
        if (!$('.wdp_bulk_table_content').children().length) {
            $('.single_variation_wrap').addClass('hide-variation-price');
        }
    }

    const equalHeight = (item) => {
        $('.wrap-item').each(function () {
            let tallest = 0;
            let title = $(this).find(item);
            title.each(function () {
                let thisHeight = $(this).height();
                if (thisHeight > tallest) {
                    tallest = thisHeight;
                }
            })
            title.height(tallest);
        });
    }



    const ready = () => {
        Nav();
        fixPriceWholesaleSingleProduct();
        spinButtonQuanlityProduct();
        replaceRegisterFormWholeSaler();
        checkTableBulkDeal();
        $('form.variations_form').on('found_variation', function (e, variation) {
            if ($('.wwp-wholesale-pricing-details').length) return;
            if ($('.wdp_bulk_table_content').children().length) {
                $('.single_variation_wrap .price').hide();

            } else {
                $('.single_variation_wrap .woocommerce-variation-price').hide();
            }

        });
        equalHeight($(".woocommerce-loop-product__title"));
        equalHeight($(".product-description"));
        
    }

    /**
     * DOM Ready
     */
    $(ready);
    

})(window, jQuery)