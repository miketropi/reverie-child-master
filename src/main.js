import Nav from './nav';

((w, $) => {
  'use strict';

  const ready = () => {
    Nav();
  }

  /**
   * DOM Ready
   */
  $(ready);
})(window, jQuery)