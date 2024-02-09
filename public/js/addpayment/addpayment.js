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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports) {


var attachPayment = $('#attachPayment');
var attachContent = '\t<div class="form-group">\n\t\t<div class="col-sm-6">\n\t\t\t<label class="col-sm-2 col-sm-offset-2 control-label">Rate\n\t\t\t</label>\t\t\t\t\t\t\t\t\t\t\t\n\t\t\t\t<div class="col-sm-7">\n\t\t\t\t\t<div class="input-group">\n\t\t\t\t\t\t<span class="input-group-addon">\n\t\t\t\t\t\t\t<i class="fa fa-clock-o"></i>\n\t\t\t\t\t\t</span>\n\t\t\t\t\t\t<input type="number" min="1" max="100" name="rate[]" class="form-control" placeholder="e.g 100" value ="{{ (null == $contract) ? old(\'rate\') : $contract->rate}}" required/>\n\t\t\t\t\t</div>\n\t\t\t\t\t@if($errors->has(\'rate\'))\n\t\t\t\t\t<span class="text-danger"> {{$errors->first(\'rate\')}}</span>\n\t\t\t\t\t@endif\n\t\t\t\t</div>\t\t\t\t\t\t\t\t\t\t\t\t\t\n\t\t</div>\n\t\t<div class="col-sm-6">\n\t\t\t<label class="col-sm-2 control-label">Date\n\t\t\t</label>\t\t\t\t\t\t\t\t\t\t\t\n\t\t\t\t<div class="col-sm-7">\n\t\t\t\t\t<div class="input-group">\n\t\t\t\t\t\t<span class="input-group-addon">\n\t\t\t\t\t\t\t<i class="fa fa-calendar"></i>\n\t\t\t\t\t\t</span>\n\t\t\t\t\t\t<input type="text" data-plugin-datepicker name="paydate[]" class="form-control" placeholder="pay before" value ="{{ (null == $contract) ? old(\'paydate\') : $contract->paydate}}" required/>\n\t\t\t\t\t</div>\n\t\t\t\t\t@if($errors->has(\'amount\'))\n\t\t\t\t\t<span class="text-danger"> {{$errors->first(\'amount\')}}</span>\n\t\t\t\t\t@endif\n\t\t\t\t</div>\t\t\t\t\t\t\t\t\t\t\t\t\t\n\t\t</div>\n';
$('#addpayment').click(function () {
	attachPayment.append(attachContent);
});

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);