import Nav from './nav';

((w, $) => {
    'use strict';

    const fixPriceWholesaleSingleProduct = () => {
        let currentPrice = '';
        $('.variations_form').on(
            'found_variation',
            (e, variation) => {
                // console.log('---', variation, variation['price_html']);
                currentPrice = variation['price_html'];
                console.log(variation['price_html'])
            }
        );

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
        //fixPriceWholesaleSingleProduct();
        spinButtonQuanlityProduct();
        replaceRegisterFormWholeSaler();
        checkTableBulkDeal();
        $('form.variations_form').on('found_variation', function (e, variation) {
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