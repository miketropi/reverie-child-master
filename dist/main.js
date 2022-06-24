/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/main.js":
/*!*********************!*\
  !*** ./src/main.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _nav__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./nav */ "./src/nav.js");


(function (w, $) {
  'use strict';

  var fixPriceWholesaleSingleProduct = function fixPriceWholesaleSingleProduct() {
    var currentPrice = '';
    $('.variations_form').on('found_variation', function (e, variation) {
      // console.log('---', variation, variation['price_html']);
      currentPrice = variation['price_html'];
      console.log(variation['price_html']);
    }); // $(document).ajaxComplete((event, xhr, settings) => {
    //      console.log([event, xhr, settings]) 
    //     // if (!settings.data.search) return; 
    //     if (settings.data.search('action=get_price_product_with_bulk_table') != -1) {
    //         $('.woocommerce-variation .woocommerce-variation-price').html(currentPrice)
    //     }
    // })
  };

  var spinButtonQuanlityProduct = function spinButtonQuanlityProduct() {
    $(document).on("click", ".input-spin-button.outer-spin-button", function () {
      var $this = $(this);
      var inputVal = $this.parent().find('input').val();
      var newVal = parseInt(inputVal) + 1;
      $this.parent().find("input").val(newVal);
    });
    $(document).on("click", ".input-spin-button.inner-spin-button", function () {
      var $this = $(this);
      var inputVal = $this.parent().find('input').val();
      if (parseInt(inputVal) == 1) return;
      var newVal = parseInt(inputVal) - 1;
      $this.parent().find("input").val(newVal);
    });
  };

  var replaceRegisterFormWholeSaler = function replaceRegisterFormWholeSaler() {
    $('.wwp_wholesaler_registration_form h2').each(function () {
      var txtHeading = $(this).text();
      var newHeading = txtHeading.substring(9, txtHeading.length);
      $(this).text(newHeading);
    });
    $('.wwp_wholesaler_registration_form input[type="checkbox"]').prop("checked", true).trigger("change");
    var labelCopyBilling = $('label[for="wwp_wholesaler_copy_billing_address"]');
    var newLabelCopyBilling = 'Uncheck this box if you like to enter a different shipping address.';
    labelCopyBilling.text(newLabelCopyBilling);
    var wrapperCheckbox = labelCopyBilling.parent();
    var inputCheckbox = labelCopyBilling.parent().find('input');
    wrapperCheckbox.addClass('wrap-checkbox-billing');
    inputCheckbox.insertBefore(labelCopyBilling);
  };

  var checkTableBulkDeal = function checkTableBulkDeal() {
    if (!$('.wdp_bulk_table_content').children().length) {
      $('.single_variation_wrap').addClass('hide-variation-price');
    }
  };

  var ready = function ready() {
    (0,_nav__WEBPACK_IMPORTED_MODULE_0__["default"])(); //fixPriceWholesaleSingleProduct();

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
  };
  /**
   * DOM Ready
   */


  $(ready);
})(window, jQuery);

/***/ }),

/***/ "./src/nav.js":
/*!********************!*\
  !*** ./src/nav.js ***!
  \********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function () {
  var $nav = jQuery('ul.site-main-menu');
  var arrowSVG = "<svg width=\"8\" height=\"7\" viewBox=\"0 0 8 7\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"> <path d=\"M0.611328 0.0117302L0.611328 3.46627L4.12447 7L7.61133 3.4956L7.61133 0L4.10695 3.51906L0.611328 0.0117302Z\" fill=\"#E4752E\"/> </svg>";
  var $btnToggleMobileMenu = jQuery('.header-tool__item.__mobi-toggle-button');
  var $mobileMenuOffcanvas = jQuery('.mobile-menu-offcanvas');

  var appendArrowHasSub = function appendArrowHasSub() {
    $nav.find('li.menu-item-has-children > a').append("<span class=\"__arrow-nav-item\">".concat(arrowSVG, "</span>"));
  };

  var MobileMenuHandle = function MobileMenuHandle() {
    $btnToggleMobileMenu.on('click', function (e) {
      document.body.classList.toggle('__mobile-menu-active');
    });
    $mobileMenuOffcanvas.find('.mobile-menu-offcanvas__close').on('click', function (e) {
      e.preventDefault();
      document.body.classList.remove('__mobile-menu-active');
    });
    $mobileMenuOffcanvas.find('li.menu-item-has-children > a').on('click', function (e) {
      e.preventDefault();
      var $a = jQuery(this);
      var $parentLi = jQuery(this).closest('li');

      var _status = $a.data('__is-open');

      if (_status == false) {
        $parentLi.children('ul.sub-menu').slideDown();
        $a.data('__is-open', true);
      } else {
        $parentLi.children('ul.sub-menu').slideUp();
        $a.data('__is-open', false);
      }
    });
  };

  appendArrowHasSub();
  MobileMenuHandle();
});

/***/ }),

/***/ "./src/scss/main.scss":
/*!****************************!*\
  !*** ./src/scss/main.scss ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/main": 0,
/******/ 			"css/main": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkreverie_child_master"] = self["webpackChunkreverie_child_master"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/main"], () => (__webpack_require__("./src/main.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/main"], () => (__webpack_require__("./src/scss/main.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;