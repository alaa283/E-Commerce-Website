/*!
 * Duplicate Variations for WooCommerce v1.0.4 
 * 
 * Author: Emran Ahmed ( emran.bd.08@gmail.com ) 
 * Date: 5/4/2021, 12:25:43 AM
 * Released under the GPLv3 license.
 */
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/variation-duplicator-for-woocommerce.js":
/*!********************************************************!*\
  !*** ./src/js/variation-duplicator-for-woocommerce.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/* global wp, WooVariationDuplicator, woocommerce_admin_meta_boxes_variations, woocommerce_admin, wc_meta_boxes_product_variations_pagenav */
jQuery(function ($) {
  'use strict'; // Variation Image Clone

  var Woo_Variation_Image_Clone = /*#__PURE__*/function () {
    function Woo_Variation_Image_Clone() {
      _classCallCheck(this, Woo_Variation_Image_Clone);
    }

    _createClass(Woo_Variation_Image_Clone, null, [{
      key: "init",
      value: function init() {
        this.setOption();
        this.events();
        $('#woocommerce-product-data').on('woocommerce_variations_loaded', function () {
          Woo_Variation_Image_Clone.setCloneWrapper(); // Woo_Variation_Image_Clone.setOption()
          // Woo_Variation_Image_Clone.events()
        });
        $('#variable_product_options').on('woocommerce_variations_added', function () {
          Woo_Variation_Image_Clone.setCloneWrapper();
          Woo_Variation_Image_Clone.setOption();
          Woo_Variation_Image_Clone.events();
        });
      }
    }, {
      key: "setCloneWrapper",
      value: function setCloneWrapper() {
        $('.woocommerce_variation').each(function () {
          var optionsWrapper = $(this).find('.options:first');
          var chooseVariationsIdWrapper = $(this).find('.woo-variable-image-duplicator-wrapper');
          chooseVariationsIdWrapper.insertBefore(optionsWrapper);
        });
      }
    }, {
      key: "setOption",
      value: function setOption() {
        var $select = $('#field_to_edit');
        var actionsWrapper = $select.find('option:first');
        $select.find('option.woo_variation_duplicate_option').insertAfter(actionsWrapper);
      }
    }, {
      key: "events",
      value: function events() {
        $('#variable_product_options').on('click', 'input.variable-image-duplicate-type', this.chooseType).on('click', 'button.select_all_variations', this.selectAll).on('click', 'button.select_no_variations', this.selectNone);
      }
    }, {
      key: "chooseType",
      value: function chooseType(event) {
        var type = $(this).val();
        $(this).closest('.woo-variable-image-duplicator-wrapper').find('.variable-list').removeClass('show');
        $(this).closest('.woo-variable-image-duplicator-wrapper').find('.variable-image-duplicate-' + type).addClass('show');
      }
    }, {
      key: "selectAll",
      value: function selectAll(event) {
        event.preventDefault();
        $(this).closest('p').find('select > option').prop('selected', true);
        $(this).closest('p').find('select').trigger('change');
      }
    }, {
      key: "selectNone",
      value: function selectNone(event) {
        event.preventDefault();
        $(this).closest('p').find('select > option').prop('selected', false);
        $(this).closest('p').find('select').trigger('change');
      }
    }]);

    return Woo_Variation_Image_Clone;
  }(); // Variation Clone


  var Woo_Variation_Clone = /*#__PURE__*/function () {
    function Woo_Variation_Clone() {
      _classCallCheck(this, Woo_Variation_Clone);
    }

    _createClass(Woo_Variation_Clone, null, [{
      key: "init",
      value: function init() {
        this.setHowTo();
        $(document).on('click', 'input.variation_is_cloneable', Woo_Variation_Clone.cloneableClick);
        $(document).on('change', 'input.variation_is_cloneable', Woo_Variation_Clone.cloneableChange);
        $('select.variation_actions').on('woo_variation_duplicate_ajax_data', Woo_Variation_Clone.ajaxData);
        $(document).on('woocommerce_variations_added', '#variable_product_options', Woo_Variation_Clone.clean);
        $(document).on('woocommerce_variations_removed', '#woocommerce-product-data', Woo_Variation_Clone.clean);

        var events = $._data(document.body, 'events')['change'];

        var input_change_callback = events.filter(function (event) {
          return event.selector === '#variable_product_options .woocommerce_variations :input';
        })[0]; // @todo: We should add namespace support on event also

        $(document.body).off('change', '#variable_product_options .woocommerce_variations :input');
        $(document.body).on('change', '#variable_product_options .woocommerce_variations :input:not(.no-track-change)', input_change_callback.handler); // Re Init

        $('#variable_product_options').on('woocommerce_variations_added', function () {
          Woo_Variation_Clone.setHowTo();
          $('select.variation_actions').off('woo_variation_duplicate_ajax_data').on('woo_variation_duplicate_ajax_data', Woo_Variation_Clone.ajaxData);
        }).on('woocommerce_variations_input_changed', function (event) {
          var _this = this;

          // We wait for attaching out event for no change track
          _.delay(function () {
            $(_this).find('.variation-needs-update input.variation_is_cloneable').prop('checked', false);
          }, 1);
        });
      }
    }, {
      key: "setHowTo",
      value: function setHowTo() {
        var actionsWrapper = $('#variable_product_options_inner .toolbar-top').find('.do_variation_action');
        $('#variable_product_options_inner').find('.variation-duplicator-for-woocommerce-works').insertAfter(actionsWrapper);
        $('select#field_to_edit').on('change', function () {
          if ($(this).val() === 'woo_variation_duplicate') {
            $('#variable_product_options_inner').find('.variation-duplicator-for-woocommerce-works').addClass('show');
          } else {
            $('#variable_product_options_inner').find('.variation-duplicator-for-woocommerce-works').removeClass('show');
          }
        });
      }
    }, {
      key: "clean",
      value: function clean() {
        $('.woocommerce-notice-invalid-variation, .woo-variation-duplicator-notice').remove();
      }
    }, {
      key: "ajaxData",
      value: function ajaxData(data) {
        var clone = {
          items: [],
          times: 1,
          exceed: false
        };
        $('input.variation_is_cloneable:checked').each(function () {
          clone.items.push($(this).val());
        });

        if (clone.items.length > 0) {
          var times = Number(window.prompt(WooVariationDuplicator.limitText, 1));

          if (isNaN(times)) {
            return data['clone'] = {};
          } else {
            clone.times = times > Number(WooVariationDuplicator.limit) ? 1 : times;
            clone.exceed = times > Number(WooVariationDuplicator.limit);
          }
        } else {
          return data['clone'] = {};
        }

        var total = clone.times * clone.items.length;

        for (var $i = 0; $i < total; $i++) {
          $('#variable_product_options').trigger('woocommerce_variations_added', 1);
        }

        return data['clone'] = clone;
      }
    }, {
      key: "cloneableClick",
      value: function cloneableClick(event) {
        if ($(this).is(':checked')) {
          $('select#field_to_edit').val('woo_variation_duplicate').trigger('change');
          $(this).closest('label.clone-checkbox').addClass('checked');
          $('#variable_product_options_inner').find('.variation-duplicator-for-woocommerce-works').addClass('show');
        } else {
          if ($('input.variation_is_cloneable:checked').length < 1) {
            $('#variable_product_options_inner').find('.variation-duplicator-for-woocommerce-works').removeClass('show');
            $('select#field_to_edit').val('add_variation').trigger('change');
          }

          $(this).closest('label.clone-checkbox').removeClass('checked');
        }
      }
    }, {
      key: "cloneableChange",
      value: function cloneableChange(event) {
        $(this).closest('.wc-metaboxes-wrapper').find('.wc-metabox > .wc-metabox-content').hide();
        $(this).closest('.woocommerce_variations').find('.woocommerce_variation.open').removeClass('open').addClass('closed');
      }
    }]);

    return Woo_Variation_Clone;
  }();

  Woo_Variation_Image_Clone.init();
  Woo_Variation_Clone.init();
});

/***/ }),

/***/ "./src/scss/variation-duplicator-for-woocommerce.scss":
/*!************************************************************!*\
  !*** ./src/scss/variation-duplicator-for-woocommerce.scss ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*******************************************************************************************************************!*\
  !*** multi ./src/js/variation-duplicator-for-woocommerce.js ./src/scss/variation-duplicator-for-woocommerce.scss ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/emran/Sites/variation-duplicator-for-woocommerce/wp-content/plugins/variation-duplicator-for-woocommerce/src/js/variation-duplicator-for-woocommerce.js */"./src/js/variation-duplicator-for-woocommerce.js");
module.exports = __webpack_require__(/*! /Users/emran/Sites/variation-duplicator-for-woocommerce/wp-content/plugins/variation-duplicator-for-woocommerce/src/scss/variation-duplicator-for-woocommerce.scss */"./src/scss/variation-duplicator-for-woocommerce.scss");


/***/ })

/******/ });