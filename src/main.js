import Nav from './nav';

((w, $) => {
  'use strict';

  const ready = () => {
    Nav();

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