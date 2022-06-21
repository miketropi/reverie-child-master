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
			}
		);

    $(document).ajaxComplete((event, xhr, settings) => {
      // console.log([event, xhr, settings])
      if(!settings.data.search) return;
      if(settings.data.search('action=get_price_product_with_bulk_table') != -1) {
        $('.woocommerce-variation .woocommerce-variation-price').html(currentPrice)
      }
    })
  }

  const ready = () => {
    Nav();
    fixPriceWholesaleSingleProduct();

    $(document).on("click", ".input-spin-button.outer-spin-button", function () {
      let $this = $(this);
      let inputVal = $this.parent().find('input').val()
      let newVal = parseInt(inputVal) + 1
      $this.parent().find("input").val(newVal);
    });

    $(document).on("click", ".input-spin-button.inner-spin-button", function () {
      let $this = $(this);
      let inputVal = $this.parent().find('input').val()
      let newVal = parseInt(inputVal) - 1
      $this.parent().find("input").val(newVal);
    });
  }

  /**
   * DOM Ready
   */
  $(ready);
})(window, jQuery)