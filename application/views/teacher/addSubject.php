<section class="content">

  <div class="container-fluid">
    <div class="row clearfix">
      <div class="block-header" align="center">

          <h2>Add New <?php echo ($this->session->userdata('usertype')=='teacher')?'Subject':'Project'; ?></h2>
      </div>


      <head>
        <!-- <script

  src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
  integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
  crossorigin="anonymous"></script> -->
<style>
@keyframes showSweetAlert {
  0% {
    transform: scale(0.7);
  }
  45% {
    transform: scale(1.05);
  }
  80% {
    transform: scale(0.95);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes hideSweetAlert {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0.5);
  }
}
@keyframes slideFromTop {
  0% {
    top: 0%;
  }
  100% {
    top: 50%;
  }
}
@keyframes slideToTop {
  0% {
    top: 50%;
  }
  100% {
    top: 0%;
  }
}
@keyframes slideFromBottom {
  0% {
    top: 70%;
  }
  100% {
    top: 50%;
  }
}
@keyframes slideToBottom {
  0% {
    top: 50%;
  }
  100% {
    top: 70%;
  }
}
.showSweetAlert {
  animation: showSweetAlert 0.3s;
}
.showSweetAlert[data-animation=none] {
  animation: none;
}
.showSweetAlert[data-animation=slide-from-top] {
  animation: slideFromTop 0.3s;
}
.showSweetAlert[data-animation=slide-from-bottom] {
  animation: slideFromBottom 0.3s;
}
.hideSweetAlert {
  animation: hideSweetAlert 0.3s;
}
.hideSweetAlert[data-animation=none] {
  animation: none;
}
.hideSweetAlert[data-animation=slide-from-top] {
  animation: slideToTop 0.3s;
}
.hideSweetAlert[data-animation=slide-from-bottom] {
  animation: slideToBottom 0.3s;
}
@keyframes animateSuccessTip {
  0% {
    width: 0;
    left: 1px;
    top: 19px;
  }
  54% {
    width: 0;
    left: 1px;
    top: 19px;
  }
  70% {
    width: 50px;
    left: -8px;
    top: 37px;
  }
  84% {
    width: 17px;
    left: 21px;
    top: 48px;
  }
  100% {
    width: 25px;
    left: 14px;
    top: 45px;
  }
}
@keyframes animateSuccessLong {
  0% {
    width: 0;
    right: 46px;
    top: 54px;
  }
  65% {
    width: 0;
    right: 46px;
    top: 54px;
  }
  84% {
    width: 55px;
    right: 0px;
    top: 35px;
  }
  100% {
    width: 47px;
    right: 8px;
    top: 38px;
  }
}
@keyframes rotatePlaceholder {
  0% {
    transform: rotate(-45deg);
  }
  5% {
    transform: rotate(-45deg);
  }
  12% {
    transform: rotate(-405deg);
  }
  100% {
    transform: rotate(-405deg);
  }
}
.animateSuccessTip {
  animation: animateSuccessTip 0.75s;
}
.animateSuccessLong {
  animation: animateSuccessLong 0.75s;
}
.sa-icon.sa-success.animate::after {
  animation: rotatePlaceholder 4.25s ease-in;
}
@keyframes animateErrorIcon {
  0% {
    transform: rotateX(100deg);
    opacity: 0;
  }
  100% {
    transform: rotateX(0deg);
    opacity: 1;
  }
}
.animateErrorIcon {
  animation: animateErrorIcon 0.5s;
}
@keyframes animateXMark {
  0% {
    transform: scale(0.4);
    margin-top: 26px;
    opacity: 0;
  }
  50% {
    transform: scale(0.4);
    margin-top: 26px;
    opacity: 0;
  }
  80% {
    transform: scale(1.15);
    margin-top: -6px;
  }
  100% {
    transform: scale(1);
    margin-top: 0;
    opacity: 1;
  }
}
.animateXMark {
  animation: animateXMark 0.5s;
}
@keyframes pulseWarning {
  0% {
    border-color: #F8D486;
  }
  100% {
    border-color: #F8BB86;
  }
}
.pulseWarning {
  animation: pulseWarning 0.75s infinite alternate;
}
@keyframes pulseWarningIns {
  0% {
    background-color: #F8D486;
  }
  100% {
    background-color: #F8BB86;
  }
}
.pulseWarningIns {
  animation: pulseWarningIns 0.75s infinite alternate;
}
@keyframes rotate-loading {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
body.stop-scrolling {
  height: 100%;
  overflow: hidden;
}
.sweet-overlay {
  background-color: rgba(0, 0, 0, 0.4);
  position: fixed;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  display: none;
  z-index: 1040;
}
.sweet-alert {
  background-color: #ffffff;
  width: 478px;
  padding: 17px;
  border-radius: 5px;
  text-align: center;
  position: fixed;
  left: 50%;
  top: 50%;
  margin-left: -256px;
  margin-top: -200px;
  overflow: hidden;
  display: none;
  z-index: 2000;
}
@media all and (max-width: 767px) {
  .sweet-alert {
    width: auto;
    margin-left: 0;
    margin-right: 0;
    left: 15px;
    right: 15px;
  }
}
.sweet-alert .form-group {
  display: none;
}
.sweet-alert .form-group .sa-input-error {
  display: none;
}
.sweet-alert.show-input .form-group {
  display: block;
}
.sweet-alert .sa-confirm-button-container {
  display: inline-block;
  position: relative;
}
.sweet-alert .la-ball-fall {
  position: absolute;
  left: 50%;
  top: 50%;
  margin-left: -27px;
  margin-top: -9px;
  opacity: 0;
  visibility: hidden;
}
.sweet-alert button[disabled] {
  opacity: .6;
  cursor: default;
}
.sweet-alert button.confirm[disabled] {
  color: transparent;
}
.sweet-alert button.confirm[disabled] ~ .la-ball-fall {
  opacity: 1;
  visibility: visible;
  transition-delay: 0s;
}
.sweet-alert .sa-icon {
  width: 80px;
  height: 80px;
  border: 4px solid gray;
  border-radius: 50%;
  margin: 20px auto;
  position: relative;
  box-sizing: content-box;
}
.sweet-alert .sa-icon.sa-error {
  border-color: #d43f3a;
}
.sweet-alert .sa-icon.sa-error .sa-x-mark {
  position: relative;
  display: block;
}
.sweet-alert .sa-icon.sa-error .sa-line {
  position: absolute;
  height: 5px;
  width: 47px;
  background-color: #d9534f;
  display: block;
  top: 37px;
  border-radius: 2px;
}
.sweet-alert .sa-icon.sa-error .sa-line.sa-left {
  transform: rotate(45deg);
  left: 17px;
}
.sweet-alert .sa-icon.sa-error .sa-line.sa-right {
  transform: rotate(-45deg);
  right: 16px;
}
.sweet-alert .sa-icon.sa-warning {
  border-color: #eea236;
}
.sweet-alert .sa-icon.sa-warning .sa-body {
  position: absolute;
  width: 5px;
  height: 47px;
  left: 50%;
  top: 10px;
  border-radius: 2px;
  margin-left: -2px;
  background-color: #f0ad4e;
}
.sweet-alert .sa-icon.sa-warning .sa-dot {
  position: absolute;
  width: 7px;
  height: 7px;
  border-radius: 50%;
  margin-left: -3px;
  left: 50%;
  bottom: 10px;
  background-color: #f0ad4e;
}
.sweet-alert .sa-icon.sa-info {
  border-color: #46b8da;
}
.sweet-alert .sa-icon.sa-info::before {
  content: "";
  position: absolute;
  width: 5px;
  height: 29px;
  left: 50%;
  bottom: 17px;
  border-radius: 2px;
  margin-left: -2px;
  background-color: #5bc0de;
}
.sweet-alert .sa-icon.sa-info::after {
  content: "";
  position: absolute;
  width: 7px;
  height: 7px;
  border-radius: 50%;
  margin-left: -3px;
  top: 19px;
  background-color: #5bc0de;
}
.sweet-alert .sa-icon.sa-success {
  border-color: #4cae4c;
}
.sweet-alert .sa-icon.sa-success::before,
.sweet-alert .sa-icon.sa-success::after {
  content: '';
  border-radius: 50%;
  position: absolute;
  width: 60px;
  height: 120px;
  background: #ffffff;
  transform: rotate(45deg);
}
.sweet-alert .sa-icon.sa-success::before {
  border-radius: 120px 0 0 120px;
  top: -7px;
  left: -33px;
  transform: rotate(-45deg);
  transform-origin: 60px 60px;
}
.sweet-alert .sa-icon.sa-success::after {
  border-radius: 0 120px 120px 0;
  top: -11px;
  left: 30px;
  transform: rotate(-45deg);
  transform-origin: 0px 60px;
}
.sweet-alert .sa-icon.sa-success .sa-placeholder {
  width: 80px;
  height: 80px;
  border: 4px solid rgba(92, 184, 92, 0.2);
  border-radius: 50%;
  box-sizing: content-box;
  position: absolute;
  left: -4px;
  top: -4px;
  z-index: 2;
}
.sweet-alert .sa-icon.sa-success .sa-fix {
  width: 5px;
  height: 90px;
  background-color: #ffffff;
  position: absolute;
  left: 28px;
  top: 8px;
  z-index: 1;
  transform: rotate(-45deg);
}
.sweet-alert .sa-icon.sa-success .sa-line {
  height: 5px;
  background-color: #5cb85c;
  display: block;
  border-radius: 2px;
  position: absolute;
  z-index: 2;
}
.sweet-alert .sa-icon.sa-success .sa-line.sa-tip {
  width: 25px;
  left: 14px;
  top: 46px;
  transform: rotate(45deg);
}
.sweet-alert .sa-icon.sa-success .sa-line.sa-long {
  width: 47px;
  right: 8px;
  top: 38px;
  transform: rotate(-45deg);
}
.sweet-alert .sa-icon.sa-custom {
  background-size: contain;
  border-radius: 0;
  border: none;
  background-position: center center;
  background-repeat: no-repeat;
}
.sweet-alert .btn-default:focus {
  border-color: #cccccc;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(204, 204, 204, 0.6);
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(204, 204, 204, 0.6);
}
.sweet-alert .btn-success:focus {
  border-color: #4cae4c;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(76, 174, 76, 0.6);
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(76, 174, 76, 0.6);
}
.sweet-alert .btn-info:focus {
  border-color: #46b8da;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(70, 184, 218, 0.6);
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(70, 184, 218, 0.6);
}
.sweet-alert .btn-danger:focus {
  border-color: #d43f3a;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(212, 63, 58, 0.6);
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(212, 63, 58, 0.6);
}
.sweet-alert .btn-warning:focus {
  border-color: #eea236;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(238, 162, 54, 0.6);
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(238, 162, 54, 0.6);
}
.sweet-alert button::-moz-focus-inner {
  border: 0;
}
/*!
 * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)
 * Copyright 2015 Daniel Cardoso <@DanielCardoso>
 * Licensed under MIT
 */
.la-ball-fall,
.la-ball-fall > div {
  position: relative;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
.la-ball-fall {
  display: block;
  font-size: 0;
  color: #fff;
}
.la-ball-fall.la-dark {
  color: #333;
}
.la-ball-fall > div {
  display: inline-block;
  float: none;
  background-color: currentColor;
  border: 0 solid currentColor;
}
.la-ball-fall {
  width: 54px;
  height: 18px;
}
.la-ball-fall > div {
  width: 10px;
  height: 10px;
  margin: 4px;
  border-radius: 100%;
  opacity: 0;
  -webkit-animation: ball-fall 1s ease-in-out infinite;
  -moz-animation: ball-fall 1s ease-in-out infinite;
  -o-animation: ball-fall 1s ease-in-out infinite;
  animation: ball-fall 1s ease-in-out infinite;
}
.la-ball-fall > div:nth-child(1) {
  -webkit-animation-delay: -200ms;
  -moz-animation-delay: -200ms;
  -o-animation-delay: -200ms;
  animation-delay: -200ms;
}
.la-ball-fall > div:nth-child(2) {
  -webkit-animation-delay: -100ms;
  -moz-animation-delay: -100ms;
  -o-animation-delay: -100ms;
  animation-delay: -100ms;
}
.la-ball-fall > div:nth-child(3) {
  -webkit-animation-delay: 0ms;
  -moz-animation-delay: 0ms;
  -o-animation-delay: 0ms;
  animation-delay: 0ms;
}
.la-ball-fall.la-sm {
  width: 26px;
  height: 8px;
}
.la-ball-fall.la-sm > div {
  width: 4px;
  height: 4px;
  margin: 2px;
}
.la-ball-fall.la-2x {
  width: 108px;
  height: 36px;
}
.la-ball-fall.la-2x > div {
  width: 20px;
  height: 20px;
  margin: 8px;
}
.la-ball-fall.la-3x {
  width: 162px;
  height: 54px;
}
.la-ball-fall.la-3x > div {
  width: 30px;
  height: 30px;
  margin: 12px;
}
/*
 * Animation
 */
@-webkit-keyframes ball-fall {
  0% {
    opacity: 0;
    -webkit-transform: translateY(-145%);
    transform: translateY(-145%);
  }
  10% {
    opacity: .5;
  }
  20% {
    opacity: 1;
    -webkit-transform: translateY(0);
    transform: translateY(0);
  }
  80% {
    opacity: 1;
    -webkit-transform: translateY(0);
    transform: translateY(0);
  }
  90% {
    opacity: .5;
  }
  100% {
    opacity: 0;
    -webkit-transform: translateY(145%);
    transform: translateY(145%);
  }
}
@-moz-keyframes ball-fall {
  0% {
    opacity: 0;
    -moz-transform: translateY(-145%);
    transform: translateY(-145%);
  }
  10% {
    opacity: .5;
  }
  20% {
    opacity: 1;
    -moz-transform: translateY(0);
    transform: translateY(0);
  }
  80% {
    opacity: 1;
    -moz-transform: translateY(0);
    transform: translateY(0);
  }
  90% {
    opacity: .5;
  }
  100% {
    opacity: 0;
    -moz-transform: translateY(145%);
    transform: translateY(145%);
  }
}
@-o-keyframes ball-fall {
  0% {
    opacity: 0;
    -o-transform: translateY(-145%);
    transform: translateY(-145%);
  }
  10% {
    opacity: .5;
  }
  20% {
    opacity: 1;
    -o-transform: translateY(0);
    transform: translateY(0);
  }
  80% {
    opacity: 1;
    -o-transform: translateY(0);
    transform: translateY(0);
  }
  90% {
    opacity: .5;
  }
  100% {
    opacity: 0;
    -o-transform: translateY(145%);
    transform: translateY(145%);
  }
}
@keyframes ball-fall {
  0% {
    opacity: 0;
    -webkit-transform: translateY(-145%);
    -moz-transform: translateY(-145%);
    -o-transform: translateY(-145%);
    transform: translateY(-145%);
  }
  10% {
    opacity: .5;
  }
  20% {
    opacity: 1;
    -webkit-transform: translateY(0);
    -moz-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }
  80% {
    opacity: 1;
    -webkit-transform: translateY(0);
    -moz-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }
  90% {
    opacity: .5;
  }
  100% {
    opacity: 0;
    -webkit-transform: translateY(145%);
    -moz-transform: translateY(145%);
    -o-transform: translateY(145%);
    transform: translateY(145%);
  }
}

</style>
<script>;(function(window, document, undefined) {
"use strict";

(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
var defaultParams = {
  title: '',
  text: '',
  type: null,
  allowOutsideClick: false,
  showConfirmButton: true,
  showCancelButton: false,
  closeOnConfirm: true,
  closeOnCancel: true,
  confirmButtonText: 'OK',
  confirmButtonClass: 'btn-primary',
  cancelButtonText: 'Cancel',
  cancelButtonClass: 'btn-default',
  containerClass: '',
  titleClass: '',
  textClass: '',
  imageUrl: null,
  imageSize: null,
  timer: null,
  customClass: '',
  html: false,
  animation: true,
  allowEscapeKey: true,
  inputType: 'text',
  inputPlaceholder: '',
  inputValue: '',
  showLoaderOnConfirm: false
};

exports.default = defaultParams;

},{}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.handleCancel = exports.handleConfirm = exports.handleButton = undefined;

var _handleSwalDom = require('./handle-swal-dom');

var _handleDom = require('./handle-dom');

/*
 * User clicked on "Confirm"/"OK" or "Cancel"
 */
var handleButton = function handleButton(event, params, modal) {
  var e = event || window.event;
  var target = e.target || e.srcElement;

  var targetedConfirm = target.className.indexOf('confirm') !== -1;
  var targetedOverlay = target.className.indexOf('sweet-overlay') !== -1;
  var modalIsVisible = (0, _handleDom.hasClass)(modal, 'visible');
  var doneFunctionExists = params.doneFunction && modal.getAttribute('data-has-done-function') === 'true';

  // Since the user can change the background-color of the confirm button programmatically,
  // we must calculate what the color should be on hover/active
  var normalColor, hoverColor, activeColor;
  if (targetedConfirm && params.confirmButtonColor) {
    normalColor = params.confirmButtonColor;
    hoverColor = colorLuminance(normalColor, -0.04);
    activeColor = colorLuminance(normalColor, -0.14);
  }

  function shouldSetConfirmButtonColor(color) {
    if (targetedConfirm && params.confirmButtonColor) {
      target.style.backgroundColor = color;
    }
  }

  switch (e.type) {
    case 'click':
      var clickedOnModal = modal === target;
      var clickedOnModalChild = (0, _handleDom.isDescendant)(modal, target);

      // Ignore click outside if allowOutsideClick is false
      if (!clickedOnModal && !clickedOnModalChild && modalIsVisible && !params.allowOutsideClick) {
        break;
      }

      if (targetedConfirm && doneFunctionExists && modalIsVisible) {
        handleConfirm(modal, params);
      } else if (doneFunctionExists && modalIsVisible || targetedOverlay) {
        handleCancel(modal, params);
      } else if ((0, _handleDom.isDescendant)(modal, target) && target.tagName === 'BUTTON') {
        sweetAlert.close();
      }
      break;
  }
};

/*
 *  User clicked on "Confirm"/"OK"
 */
var handleConfirm = function handleConfirm(modal, params) {
  var callbackValue = true;

  if ((0, _handleDom.hasClass)(modal, 'show-input')) {
    callbackValue = modal.querySelector('input').value;

    if (!callbackValue) {
      callbackValue = '';
    }
  }

  params.doneFunction(callbackValue);

  if (params.closeOnConfirm) {
    sweetAlert.close();
  }
  // Disable cancel and confirm button if the parameter is true
  if (params.showLoaderOnConfirm) {
    sweetAlert.disableButtons();
  }
};

/*
 *  User clicked on "Cancel"
 */
var handleCancel = function handleCancel(modal, params) {
  // Check if callback function expects a parameter (to track cancel actions)
  var functionAsStr = String(params.doneFunction).replace(/\s/g, '');
  var functionHandlesCancel = functionAsStr.substring(0, 9) === 'function(' && functionAsStr.substring(9, 10) !== ')';

  if (functionHandlesCancel) {
    params.doneFunction(false);
  }

  if (params.closeOnCancel) {
    sweetAlert.close();
  }
};

exports.handleButton = handleButton;
exports.handleConfirm = handleConfirm;
exports.handleCancel = handleCancel;

},{"./handle-dom":3,"./handle-swal-dom":5}],3:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
var hasClass = function hasClass(elem, className) {
  return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
};

var addClass = function addClass(elem, className) {
  if (!hasClass(elem, className)) {
    elem.className += ' ' + className;
  }
};

var removeClass = function removeClass(elem, className) {
  var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, ' ') + ' ';
  if (hasClass(elem, className)) {
    while (newClass.indexOf(' ' + className + ' ') >= 0) {
      newClass = newClass.replace(' ' + className + ' ', ' ');
    }
    elem.className = newClass.replace(/^\s+|\s+$/g, '');
  }
};

var escapeHtml = function escapeHtml(str) {
  var div = document.createElement('div');
  div.appendChild(document.createTextNode(str));
  return div.innerHTML;
};

var _show = function _show(elem) {
  elem.style.opacity = '';
  elem.style.display = 'block';
};

var show = function show(elems) {
  if (elems && !elems.length) {
    return _show(elems);
  }
  for (var i = 0; i < elems.length; ++i) {
    _show(elems[i]);
  }
};

var _hide = function _hide(elem) {
  elem.style.opacity = '';
  elem.style.display = 'none';
};

var hide = function hide(elems) {
  if (elems && !elems.length) {
    return _hide(elems);
  }
  for (var i = 0; i < elems.length; ++i) {
    _hide(elems[i]);
  }
};

var isDescendant = function isDescendant(parent, child) {
  var node = child.parentNode;
  while (node !== null) {
    if (node === parent) {
      return true;
    }
    node = node.parentNode;
  }
  return false;
};

var getTopMargin = function getTopMargin(elem) {
  elem.style.left = '-9999px';
  elem.style.display = 'block';

  var height = elem.clientHeight,
      padding;
  if (typeof getComputedStyle !== "undefined") {
    // IE 8
    padding = parseInt(getComputedStyle(elem).getPropertyValue('padding-top'), 10);
  } else {
    padding = parseInt(elem.currentStyle.padding);
  }

  elem.style.left = '';
  elem.style.display = 'none';
  return '-' + parseInt((height + padding) / 2) + 'px';
};

var fadeIn = function fadeIn(elem, interval) {
  if (+elem.style.opacity < 1) {
    interval = interval || 16;
    elem.style.opacity = 0;
    elem.style.display = 'block';
    var last = +new Date();
    var tick = function tick() {
      elem.style.opacity = +elem.style.opacity + (new Date() - last) / 100;
      last = +new Date();

      if (+elem.style.opacity < 1) {
        setTimeout(tick, interval);
      }
    };
    tick();
  }
  elem.style.display = 'block'; //fallback IE8
};

var fadeOut = function fadeOut(elem, interval) {
  interval = interval || 16;
  elem.style.opacity = 1;
  var last = +new Date();
  var tick = function tick() {
    elem.style.opacity = +elem.style.opacity - (new Date() - last) / 100;
    last = +new Date();

    if (+elem.style.opacity > 0) {
      setTimeout(tick, interval);
    } else {
      elem.style.display = 'none';
    }
  };
  tick();
};

var fireClick = function fireClick(node) {
  // Taken from http://www.nonobtrusive.com/2011/11/29/programatically-fire-crossbrowser-click-event-with-javascript/
  // Then fixed for today's Chrome browser.
  if (typeof MouseEvent === 'function') {
    // Up-to-date approach
    var mevt = new MouseEvent('click', {
      view: window,
      bubbles: false,
      cancelable: true
    });
    node.dispatchEvent(mevt);
  } else if (document.createEvent) {
    // Fallback
    var evt = document.createEvent('MouseEvents');
    evt.initEvent('click', false, false);
    node.dispatchEvent(evt);
  } else if (document.createEventObject) {
    node.fireEvent('onclick');
  } else if (typeof node.onclick === 'function') {
    node.onclick();
  }
};

var stopEventPropagation = function stopEventPropagation(e) {
  // In particular, make sure the space bar doesn't scroll the main window.
  if (typeof e.stopPropagation === 'function') {
    e.stopPropagation();
    e.preventDefault();
  } else if (window.event && window.event.hasOwnProperty('cancelBubble')) {
    window.event.cancelBubble = true;
  }
};

exports.hasClass = hasClass;
exports.addClass = addClass;
exports.removeClass = removeClass;
exports.escapeHtml = escapeHtml;
exports._show = _show;
exports.show = show;
exports._hide = _hide;
exports.hide = hide;
exports.isDescendant = isDescendant;
exports.getTopMargin = getTopMargin;
exports.fadeIn = fadeIn;
exports.fadeOut = fadeOut;
exports.fireClick = fireClick;
exports.stopEventPropagation = stopEventPropagation;

},{}],4:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _handleDom = require('./handle-dom');

var _handleSwalDom = require('./handle-swal-dom');

var handleKeyDown = function handleKeyDown(event, params, modal) {
  var e = event || window.event;
  var keyCode = e.keyCode || e.which;

  var $okButton = modal.querySelector('button.confirm');
  var $cancelButton = modal.querySelector('button.cancel');
  var $modalButtons = modal.querySelectorAll('button[tabindex]');

  if ([9, 13, 32, 27].indexOf(keyCode) === -1) {
    // Don't do work on keys we don't care about.
    return;
  }

  var $targetElement = e.target || e.srcElement;

  var btnIndex = -1; // Find the button - note, this is a nodelist, not an array.
  for (var i = 0; i < $modalButtons.length; i++) {
    if ($targetElement === $modalButtons[i]) {
      btnIndex = i;
      break;
    }
  }

  if (keyCode === 9) {
    // TAB
    if (btnIndex === -1) {
      // No button focused. Jump to the confirm button.
      $targetElement = $okButton;
    } else {
      // Cycle to the next button
      if (btnIndex === $modalButtons.length - 1) {
        $targetElement = $modalButtons[0];
      } else {
        $targetElement = $modalButtons[btnIndex + 1];
      }
    }

    (0, _handleDom.stopEventPropagation)(e);
    $targetElement.focus();

    if (params.confirmButtonColor) {
      (0, _handleSwalDom.setFocusStyle)($targetElement, params.confirmButtonColor);
    }
  } else {
    if (keyCode === 13) {
      if ($targetElement.tagName === 'INPUT') {
        $targetElement = $okButton;
        $okButton.focus();
      }

      if (btnIndex === -1) {
        // ENTER/SPACE clicked outside of a button.
        $targetElement = $okButton;
      } else {
        // Do nothing - let the browser handle it.
        $targetElement = undefined;
      }
    } else if (keyCode === 27 && params.allowEscapeKey === true) {
      $targetElement = $cancelButton;
      (0, _handleDom.fireClick)($targetElement, e);
    } else {
      // Fallback - let the browser handle it.
      $targetElement = undefined;
    }
  }
};

exports.default = handleKeyDown;

},{"./handle-dom":3,"./handle-swal-dom":5}],5:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.fixVerticalPosition = exports.resetInputError = exports.resetInput = exports.openModal = exports.getInput = exports.getOverlay = exports.getModal = exports.sweetAlertInitialize = undefined;

var _handleDom = require('./handle-dom');

var _defaultParams = require('./default-params');

var _defaultParams2 = _interopRequireDefault(_defaultParams);

var _injectedHtml = require('./injected-html');

var _injectedHtml2 = _interopRequireDefault(_injectedHtml);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var modalClass = '.sweet-alert';
var overlayClass = '.sweet-overlay';

/*
 * Add modal + overlay to DOM
 */


var sweetAlertInitialize = function sweetAlertInitialize() {
  var sweetWrap = document.createElement('div');
  sweetWrap.innerHTML = _injectedHtml2.default;

  // Append elements to body
  while (sweetWrap.firstChild) {
    document.body.appendChild(sweetWrap.firstChild);
  }
};

/*
 * Get DOM element of modal
 */
var getModal = function getModal() {
  var $modal = document.querySelector(modalClass);

  if (!$modal) {
    sweetAlertInitialize();
    $modal = getModal();
  }

  return $modal;
};

/*
 * Get DOM element of input (in modal)
 */
var getInput = function getInput() {
  var $modal = getModal();
  if ($modal) {
    return $modal.querySelector('input');
  }
};

/*
 * Get DOM element of overlay
 */
var getOverlay = function getOverlay() {
  return document.querySelector(overlayClass);
};

/*
 * Animation when opening modal
 */
var openModal = function openModal(callback) {
  var $modal = getModal();
  (0, _handleDom.fadeIn)(getOverlay(), 10);
  (0, _handleDom.show)($modal);
  (0, _handleDom.addClass)($modal, 'showSweetAlert');
  (0, _handleDom.removeClass)($modal, 'hideSweetAlert');

  window.previousActiveElement = document.activeElement;
  var $okButton = $modal.querySelector('button.confirm');
  $okButton.focus();

  setTimeout(function () {
    (0, _handleDom.addClass)($modal, 'visible');
  }, 500);

  var timer = $modal.getAttribute('data-timer');

  if (timer !== 'null' && timer !== '') {
    var timerCallback = callback;
    $modal.timeout = setTimeout(function () {
      var doneFunctionExists = (timerCallback || null) && $modal.getAttribute('data-has-done-function') === 'true';
      if (doneFunctionExists) {
        timerCallback(null);
      } else {
        sweetAlert.close();
      }
    }, timer);
  }
};

/*
 * Reset the styling of the input
 * (for example if errors have been shown)
 */
var resetInput = function resetInput() {
  var $modal = getModal();
  var $input = getInput();

  (0, _handleDom.removeClass)($modal, 'show-input');
  $input.value = _defaultParams2.default.inputValue;
  $input.setAttribute('type', _defaultParams2.default.inputType);
  $input.setAttribute('placeholder', _defaultParams2.default.inputPlaceholder);

  resetInputError();
};

var resetInputError = function resetInputError(event) {
  // If press enter => ignore
  if (event && event.keyCode === 13) {
    return false;
  }

  var $modal = getModal();

  var $errorIcon = $modal.querySelector('.sa-input-error');
  (0, _handleDom.removeClass)($errorIcon, 'show');

  var $errorContainer = $modal.querySelector('.form-group');
  (0, _handleDom.removeClass)($errorContainer, 'has-error');
};

/*
 * Set "margin-top"-property on modal based on its computed height
 */
var fixVerticalPosition = function fixVerticalPosition() {
  var $modal = getModal();
  $modal.style.marginTop = (0, _handleDom.getTopMargin)(getModal());
};

exports.sweetAlertInitialize = sweetAlertInitialize;
exports.getModal = getModal;
exports.getOverlay = getOverlay;
exports.getInput = getInput;
exports.openModal = openModal;
exports.resetInput = resetInput;
exports.resetInputError = resetInputError;
exports.fixVerticalPosition = fixVerticalPosition;

},{"./default-params":1,"./handle-dom":3,"./injected-html":6}],6:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
var injectedHTML =

// Dark overlay
"<div class=\"sweet-overlay\" tabIndex=\"-1\"></div>" +

// Modal
"<div class=\"sweet-alert\" tabIndex=\"-1\">" +

// Error icon
"<div class=\"sa-icon sa-error\">\n      <span class=\"sa-x-mark\">\n        <span class=\"sa-line sa-left\"></span>\n        <span class=\"sa-line sa-right\"></span>\n      </span>\n    </div>" +

// Warning icon
"<div class=\"sa-icon sa-warning\">\n      <span class=\"sa-body\"></span>\n      <span class=\"sa-dot\"></span>\n    </div>" +

// Info icon
"<div class=\"sa-icon sa-info\"></div>" +

// Success icon
"<div class=\"sa-icon sa-success\">\n      <span class=\"sa-line sa-tip\"></span>\n      <span class=\"sa-line sa-long\"></span>\n\n      <div class=\"sa-placeholder\"></div>\n      <div class=\"sa-fix\"></div>\n    </div>" + "<div class=\"sa-icon sa-custom\"></div>" +

// Title, text and input
"<h2>Title</h2>\n    <p class=\"lead text-muted\">Text</p>\n    <div class=\"form-group\">\n      <input type=\"text\" class=\"form-control\" tabIndex=\"3\" />\n      <span class=\"sa-input-error help-block\">\n        <span class=\"glyphicon glyphicon-exclamation-sign\"></span> <span class=\"sa-help-text\">Not valid</span>\n      </span>\n    </div>" +

// Cancel and confirm buttons
"<div class=\"sa-button-container\">\n      <button class=\"cancel btn btn-lg\" tabIndex=\"2\">Cancel</button>\n      <div class=\"sa-confirm-button-container\">\n        <button class=\"confirm btn btn-lg\" tabIndex=\"1\">OK</button>" +

// Loading animation
"<div class=\"la-ball-fall\">\n          <div></div>\n          <div></div>\n          <div></div>\n        </div>\n      </div>\n    </div>" +

// End of modal
"</div>";

exports.default = injectedHTML;

},{}],7:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; };

var _utils = require('./utils');

var _handleSwalDom = require('./handle-swal-dom');

var _handleDom = require('./handle-dom');

var alertTypes = ['error', 'warning', 'info', 'success', 'input', 'prompt'];

/*
 * Set type, text and actions on modal
 */
var setParameters = function setParameters(params) {
  var modal = (0, _handleSwalDom.getModal)();

  var $title = modal.querySelector('h2');
  var $text = modal.querySelector('p');
  var $cancelBtn = modal.querySelector('button.cancel');
  var $confirmBtn = modal.querySelector('button.confirm');

  /*
   * Title
   */
  $title.innerHTML = params.html ? params.title : (0, _handleDom.escapeHtml)(params.title).split('\n').join('<br>');

  /*
   * Text
   */
  $text.innerHTML = params.html ? params.text : (0, _handleDom.escapeHtml)(params.text || '').split('\n').join('<br>');
  if (params.text) (0, _handleDom.show)($text);

  /*
   * Custom class
   */
  if (params.customClass) {
    (0, _handleDom.addClass)(modal, params.customClass);
    modal.setAttribute('data-custom-class', params.customClass);
  } else {
    // Find previously set classes and remove them
    var customClass = modal.getAttribute('data-custom-class');
    (0, _handleDom.removeClass)(modal, customClass);
    modal.setAttribute('data-custom-class', '');
  }

  /*
   * Icon
   */
  (0, _handleDom.hide)(modal.querySelectorAll('.sa-icon'));

  if (params.type && !(0, _utils.isIE8)()) {
    var _ret = function () {

      var validType = false;

      for (var i = 0; i < alertTypes.length; i++) {
        if (params.type === alertTypes[i]) {
          validType = true;
          break;
        }
      }

      if (!validType) {
        logStr('Unknown alert type: ' + params.type);
        return {
          v: false
        };
      }

      var typesWithIcons = ['success', 'error', 'warning', 'info'];
      var $icon = void 0;

      if (typesWithIcons.indexOf(params.type) !== -1) {
        $icon = modal.querySelector('.sa-icon.' + 'sa-' + params.type);
        (0, _handleDom.show)($icon);
      }

      var $input = (0, _handleSwalDom.getInput)();

      // Animate icon
      switch (params.type) {

        case 'success':
          (0, _handleDom.addClass)($icon, 'window.location.href="/teachers"');
          (0, _handleDom.addClass)($icon.querySelector('.sa-tip'), 'animateSuccessTip');
          (0, _handleDom.addClass)($icon.querySelector('.sa-long'), 'animateSuccessLong');
          break;

        case 'error':
          (0, _handleDom.addClass)($icon, 'animateErrorIcon');
          (0, _handleDom.addClass)($icon.querySelector('.sa-x-mark'), 'animateXMark');
          break;

        case 'warning':
          (0, _handleDom.addClass)($icon, 'pulseWarning');
          (0, _handleDom.addClass)($icon.querySelector('.sa-body'), 'pulseWarningIns');
          (0, _handleDom.addClass)($icon.querySelector('.sa-dot'), 'pulseWarningIns');
          break;

        case 'input':
        case 'prompt':
          $input.setAttribute('type', params.inputType);
          $input.value = params.inputValue;
          $input.setAttribute('placeholder', params.inputPlaceholder);
          (0, _handleDom.addClass)(modal, 'show-input');
          setTimeout(function () {
            $input.focus();
            $input.addEventListener('keyup', swal.resetInputError);
          }, 400);
          break;
      }
    }();

    if ((typeof _ret === 'undefined' ? 'undefined' : _typeof(_ret)) === "object") return _ret.v;
  }

  /*
   * Custom image
   */
  if (params.imageUrl) {
    var $customIcon = modal.querySelector('.sa-icon.sa-custom');

    $customIcon.style.backgroundImage = 'url(' + params.imageUrl + ')';
    (0, _handleDom.show)($customIcon);

    var _imgWidth = 80;
    var _imgHeight = 80;

    if (params.imageSize) {
      var dimensions = params.imageSize.toString().split('x');
      var imgWidth = dimensions[0];
      var imgHeight = dimensions[1];

      if (!imgWidth || !imgHeight) {
        logStr('Parameter imageSize expects value with format WIDTHxHEIGHT, got ' + params.imageSize);
      } else {
        _imgWidth = imgWidth;
        _imgHeight = imgHeight;
      }
    }

    $customIcon.setAttribute('style', $customIcon.getAttribute('style') + 'width:' + _imgWidth + 'px; height:' + _imgHeight + 'px');
  }

  /*
   * Show cancel button?
   */
  modal.setAttribute('data-has-cancel-button', params.showCancelButton);
  if (params.showCancelButton) {
    $cancelBtn.style.display = 'inline-block';
    //params.showCancelButton.onclick='myFunction()';
   // alert('welcome');
   $cancelBtn.onclick='myFunction()';
  } else {
    (0, _handleDom.hide)($cancelBtn);
  }

  /*
   * Show confirm button?
   */
  modal.setAttribute('data-has-confirm-button', params.showConfirmButton);
  if (params.showConfirmButton) {
    $confirmBtn.style.display = 'inline-block';
    //alert('welcome');
     //window.open('/teacher');
  } else {
    (0, _handleDom.hide)($confirmBtn);
  }

  /*
   * Custom text on cancel/confirm buttons
   */
  if (params.cancelButtonText) {
    $cancelBtn.innerHTML = (0, _handleDom.escapeHtml)(params.cancelButtonText);
  }
  if (params.confirmButtonText) {
    $confirmBtn.innerHTML = (0, _handleDom.escapeHtml)(params.confirmButtonText);
   // alert('welcome');
   // $confirmBtn.onclick='myFunction()';
  }

  /*
   * Reset confirm buttons to default class (Ugly fix)
   */
  $confirmBtn.className = 'confirm btn btn-lg';

  /*
   * Attach selected class to the sweet alert modal
   */
  (0, _handleDom.addClass)(modal, params.containerClass);

  /*
   * Set confirm button to selected class
   */
  (0, _handleDom.addClass)($confirmBtn, params.confirmButtonClass);

  /*
   * Set cancel button to selected class
   */
  (0, _handleDom.addClass)($cancelBtn, params.cancelButtonClass);

  /*
   * Set title to selected class
   */
  (0, _handleDom.addClass)($title, params.titleClass);

  /*
   * Set text to selected class
   */
  (0, _handleDom.addClass)($text, params.textClass);

  /*
   * Allow outside click
   */
  modal.setAttribute('data-allow-outside-click', params.allowOutsideClick);

  /*
   * Callback function
   */
  var hasDoneFunction = params.doneFunction ? true : false;
  modal.setAttribute('data-has-done-function', hasDoneFunction);

  /*
   * Animation
   */
  if (!params.animation) {
    modal.setAttribute('data-animation', 'none');
  } else if (typeof params.animation === 'string') {
    modal.setAttribute('data-animation', params.animation); // Custom animation
  } else {
      modal.setAttribute('data-animation', 'pop');
    }

  /*
   * Timer
   */
  modal.setAttribute('data-timer', params.timer);
};

exports.default = setParameters;

},{"./handle-dom":3,"./handle-swal-dom":5,"./utils":8}],8:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
/*
 * Allow user to pass their own params
 */
var extend = function extend(a, b) {
  for (var key in b) {
    if (b.hasOwnProperty(key)) {
      a[key] = b[key];
    }
  }
  return a;
};

/*
 * Check if the user is using Internet Explorer 8 (for fallbacks)
 */
var isIE8 = function isIE8() {
  return window.attachEvent && !window.addEventListener;
};

/*
 * IE compatible logging for developers
 */
var logStr = function logStr(string) {
  if (window.console) {
    // IE...
    window.console.log('SweetAlert: ' + string);
  }
};

exports.extend = extend;
exports.isIE8 = isIE8;
exports.logStr = logStr;

},{}],9:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; }; // SweetAlert
// 2014-2015 (c) - Tristan Edwards
// github.com/t4t5/sweetalert

/*
 * jQuery-like functions for manipulating the DOM
 */


/*
 * Handy utilities
 */


/*
 *  Handle sweetAlert's DOM elements
 */


// Handle button events and keyboard events


// Default values


var _handleDom = require('./modules/handle-dom');

var _utils = require('./modules/utils');

var _handleSwalDom = require('./modules/handle-swal-dom');

var _handleClick = require('./modules/handle-click');

var _handleKey = require('./modules/handle-key');

var _handleKey2 = _interopRequireDefault(_handleKey);

var _defaultParams = require('./modules/default-params');

var _defaultParams2 = _interopRequireDefault(_defaultParams);

var _setParams = require('./modules/set-params');

var _setParams2 = _interopRequireDefault(_setParams);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/*
 * Remember state in cases where opening and handling a modal will fiddle with it.
 * (We also use window.previousActiveElement as a global variable)
 */
var previousWindowKeyDown;
var lastFocusedButton;

/*
 * Global sweetAlert function
 * (this is what the user calls)
 */
var sweetAlert, _swal;

exports.default = sweetAlert = _swal = function swal() {
  var customizations = arguments[0];

  (0, _handleDom.addClass)(document.body, 'stop-scrolling');
  (0, _handleSwalDom.resetInput)();

  /*
   * Use argument if defined or default value from params object otherwise.
   * Supports the case where a default value is boolean true and should be
   * overridden by a corresponding explicit argument which is boolean false.
   */
  function argumentOrDefault(key) {
    var args = customizations;
    return args[key] === undefined ? _defaultParams2.default[key] : args[key];
  }

  if (customizations === undefined) {
    (0, _utils.logStr)('SweetAlert expects at least 1 attribute!');
    return false;
  }

  var params = (0, _utils.extend)({}, _defaultParams2.default);

  switch (typeof customizations === 'undefined' ? 'undefined' : _typeof(customizations)) {

    // Ex: swal("Hello", "Just testing", "info");
    case 'string':
      params.title = customizations;
      params.text = arguments[1] || '';
      params.type = arguments[2] || '';
      break;

    // Ex: swal({ title:"Hello", text: "Just testing", type: "info" });
    case 'object':
      if (customizations.title === undefined) {
        (0, _utils.logStr)('Missing "title" argument!');
        return false;
      }

      params.title = customizations.title;

      for (var customName in _defaultParams2.default) {
        params[customName] = argumentOrDefault(customName);
      }

      // Show "Confirm" instead of "OK" if cancel button is visible
      params.confirmButtonText = params.showCancelButton ? 'Confirm' : _defaultParams2.default.confirmButtonText;
      params.confirmButtonText = argumentOrDefault('confirmButtonText');

      // Callback function when clicking on "OK"/"Cancel"
      // params.doneFunction = onclick(function1(){

      //  window.location.href = "/teacher";

      // });
      params.doneFunction = arguments[1] || null;

      break;

    default:
      (0, _utils.logStr)('Unexpected type of argument! Expected "string" or "object", got ' + (typeof customizations === 'undefined' ? 'undefined' : _typeof(customizations)));
      return false;

  }

  (0, _setParams2.default)(params);
  (0, _handleSwalDom.fixVerticalPosition)();
  (0, _handleSwalDom.openModal)(arguments[1]);

  // Modal interactions
  var modal = (0, _handleSwalDom.getModal)();

  /*
   * Make sure all modal buttons respond to all events
   */
  var $buttons = modal.querySelectorAll('button');
  var buttonEvents = ['onclick'];
  var onButtonEvent = function onButtonEvent(e) {
    return (0, _handleClick.handleButton)(e, params, modal);
  };

  for (var btnIndex = 0; btnIndex < $buttons.length; btnIndex++) {
    for (var evtIndex = 0; evtIndex < buttonEvents.length; evtIndex++) {
      var btnEvt = buttonEvents[evtIndex];
      $buttons[btnIndex][btnEvt] = onButtonEvent;
    }
  }

  // Clicking outside the modal dismisses it (if allowed by user)
  (0, _handleSwalDom.getOverlay)().onclick = onButtonEvent;

  previousWindowKeyDown = window.onkeydown;

  var onKeyEvent = function onKeyEvent(e) {
    return (0, _handleKey2.default)(e, params, modal);
  };
  window.onkeydown = onKeyEvent;

  window.onfocus = function () {
    // When the user has focused away and focused back from the whole window.
    setTimeout(function () {
      // Put in a timeout to jump out of the event sequence.
      // Calling focus() in the event sequence confuses things.
      if (lastFocusedButton !== undefined) {
        lastFocusedButton.focus();
        lastFocusedButton = undefined;
       // alert('welcome');
      }
    }, 0);
  };

  // Show alert with enabled buttons always
  _swal.enableButtons();
};

/*
 * Set default params for each popup
 * @param {Object} userParams
 */


sweetAlert.setDefaults = _swal.setDefaults = function (userParams) {
  if (!userParams) {
    throw new Error('userParams is required');
  }
  if ((typeof userParams === 'undefined' ? 'undefined' : _typeof(userParams)) !== 'object') {
    throw new Error('userParams has to be a object');
  }

  (0, _utils.extend)(_defaultParams2.default, userParams);
};

/*
 * Animation when closing modal
 */
sweetAlert.close = _swal.close = function () {
  var modal = (0, _handleSwalDom.getModal)();

  (0, _handleDom.fadeOut)((0, _handleSwalDom.getOverlay)(), 5);
  (0, _handleDom.fadeOut)(modal, 5);
  (0, _handleDom.removeClass)(modal, 'showSweetAlert');
  (0, _handleDom.addClass)(modal, 'hideSweetAlert');
  (0, _handleDom.removeClass)(modal, 'visible');

  /*
   * Reset icon animations
   */
  var $successIcon = modal.querySelector('.sa-icon.sa-success');
  (0, _handleDom.removeClass)($successIcon, 'animate');
  (0, _handleDom.removeClass)($successIcon.querySelector('.sa-tip'), 'alert("sucess")');
  (0, _handleDom.removeClass)($successIcon.querySelector('.sa-long'), 'alert("sucess")');

  var $errorIcon = modal.querySelector('.sa-icon.sa-error');
  (0, _handleDom.removeClass)($errorIcon, 'animateErrorIcon');
  (0, _handleDom.removeClass)($errorIcon.querySelector('.sa-x-mark'), 'animateXMark');

  var $warningIcon = modal.querySelector('.sa-icon.sa-warning');
  (0, _handleDom.removeClass)($warningIcon, 'pulseWarning');
  (0, _handleDom.removeClass)($warningIcon.querySelector('.sa-body'), 'pulseWarningIns');
  (0, _handleDom.removeClass)($warningIcon.querySelector('.sa-dot'), 'pulseWarningIns');

  // Reset custom class (delay so that UI changes aren't visible)
  setTimeout(function () {
    var customClass = modal.getAttribute('data-custom-class');
    (0, _handleDom.removeClass)(modal, customClass);
  }, 300);

  // Make page scrollable again
  (0, _handleDom.removeClass)(document.body, 'stop-scrolling');

  // Reset the page to its previous state
  window.onkeydown = previousWindowKeyDown;
  if (window.previousActiveElement) {
    window.previousActiveElement.focus();
  }
  lastFocusedButton = undefined;
  clearTimeout(modal.timeout);

  return true;
};

/*
 * Validation of the input field is done by user
 * If something is wrong => call showInputError with errorMessage
 */
sweetAlert.showInputError = _swal.showInputError = function (errorMessage) {
  var modal = (0, _handleSwalDom.getModal)();

  var $errorIcon = modal.querySelector('.sa-input-error');
  (0, _handleDom.addClass)($errorIcon, 'show');

  var $errorContainer = modal.querySelector('.form-group');
  (0, _handleDom.addClass)($errorContainer, 'has-error');

  $errorContainer.querySelector('.sa-help-text').innerHTML = errorMessage;

  setTimeout(function () {
    sweetAlert.enableButtons();
  }, 1);

  modal.querySelector('input').focus();
};

/*
 * Reset input error DOM elements
 */
sweetAlert.resetInputError = _swal.resetInputError = function (event) {
  // If press enter => ignore
  if (event && event.keyCode === 13) {
    return false;
  }

  var $modal = (0, _handleSwalDom.getModal)();

  var $errorIcon = $modal.querySelector('.sa-input-error');
  (0, _handleDom.removeClass)($errorIcon, 'show');

  var $errorContainer = $modal.querySelector('.form-group');
  (0, _handleDom.removeClass)($errorContainer, 'has-error');
};

/*
 * Disable confirm and cancel buttons
 */
sweetAlert.disableButtons = _swal.disableButtons = function (event) {
  var modal = (0, _handleSwalDom.getModal)();
  var $confirmButton = modal.querySelector('button.confirm');
  var $cancelButton = modal.querySelector('button.cancel');
  $confirmButton.disabled = true;

  $cancelButton.disabled = true;
};

/*
 * Enable confirm and cancel buttons
 */
sweetAlert.enableButtons = _swal.enableButtons = function (event) {
  var modal = (0, _handleSwalDom.getModal)();
  var $confirmButton = modal.querySelector('button.confirm');
  var $cancelButton = modal.querySelector('button.cancel');
  $confirmButton.disabled = false;
  $cancelButton.disabled = false;
};

if (typeof window !== 'undefined') {
  // The 'handle-click' module requires
  // that 'sweetAlert' was set as global.
  window.sweetAlert = window.swal = sweetAlert;
} else {
  (0, _utils.logStr)('SweetAlert is a frontend module!');
}

},{"./modules/default-params":1,"./modules/handle-click":2,"./modules/handle-dom":3,"./modules/handle-key":4,"./modules/handle-swal-dom":5,"./modules/set-params":7,"./modules/utils":8}]},{},[9]);

/*
 * Use SweetAlert with RequireJS
 */

if (typeof define === 'function' && define.amd) {
  define(function () {
    return sweetAlert;
   // alert('welcome');
  });
} else if (typeof module !== 'undefined' && module.exports) {
  module.exports = sweetAlert;
}

})(window, document);


     </script>

        <script>
          document.getElementById("otheract").className += " active";
          document.getElementById("addsub1").className += " active";
        </script>
        <script>
       function myFunction() {
         window.location.href="/teachers/sendemail";
       }
        function myFunction1() {
         window.location.href="/teachers";
       }
     </script>


      </head>
      <?php 
      
      foreach($subjectcount as $count){
        echo $count->$count;}
      //echo $subjectcount;
      if($subjectcount=='0') {
        echo "<script>

        swal({
          title: 'No School-Subject found! Please contact your Admin/HOD/Principal to configure the Smart cookie portal',
          
          showCancelButton: true,
          confirmButtonClass: 'btn-danger',
          confirmButtonText: 'Send email',
          cancelButtonText: 'Cancel',
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm){
            swal.onclick = myFunction()('', '', 'success');
          } else {
            swal.onclick = myFunction1()('', '', 'error');
          }
        });


      
</script>";

    // window.location.href='http://localhost.smartcookie.in/teachers';
     } else {



         } ?>
      <div class="panel panel-default">
        <label> If your Subject is not listed, Please contact your Admin/HOD/Principal to configure the School-Subject-Master on Smart cookie portal. </label>
           <button type="button" name="mail" class="btn btn-primary" value="mail" onclick="return myFunction();">Send e-mail</button>

        <div class="panel-body">
          <form method="POST" action="">


            <label class="control-label col-sm-3" for="mysubject">Select <?php echo ($this->session->userdata('usertype')=='teacher')?'Subject':'Project'; ?>:
            </label>
            <div class="col-sm-9"> 

            <!--Below code updated by Rutuja for fetching Ext ID for Semester, Academic Year, Division, Department & Branch for SMC-5068 on 29-12-2020-->
              <select class="form-control" id="mysubject" name="mysubject" >
                
                <option value="">Select <?php echo ($this->session->userdata('usertype')=='teacher')?'Subject':'Project'; ?>
                  
                </option>


              <?php foreach($getallsubject as $subject){?>
              <!-- '@' in below line(for subject code and name) by Sayali and Rutuja for bug SMC-3857 on 
              18/05/2019 -->
                <option value="<?php echo $subject->subject.'@'.$subject->Subject_Code.'@'.$subject->ExtSchoolSubjectId?>"><?php echo $subject->subject?>(<?php echo $subject->Subject_Code?>)
                
                  
                </option>
              <?php } ?>

              </select>
              <?php echo form_error('mysubject', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
            
            </div>
            <br><br><br>
            <label class="control-label col-sm-3" for="courseLevel">Select <?php echo ($this->session->userdata('usertype')=='teacher')?'Course':'Employee'; ?> Level:</label>

            <div class="col-sm-9"> 
              <select class="form-control" id="courseLevel" name="courseLevel" >
                <option value="">Select Level</option>
              <?php foreach($getCourselevel as $level){?>
                <option value="<?php echo $level->CourseLevel;?>"><?php echo $level->CourseLevel;?></option>
              <?php } ?>
              </select>
              <?php echo form_error('courseLevel', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
            </div><br><br><br>
            <label class="control-label col-sm-3" for="department">Select Department:</label>
            <div class="col-sm-9"> 
              <select class="form-control" id="department" name="department" >
                <option value="">Select Department</option>
              <?php foreach($getalldepartment as $dept){?>
                <option value="<?php echo $dept->Dept_Name;?>,<?php echo $dept->ExtDeptId;?>"><?php echo $dept->Dept_Name;?></option>
              <?php } ?>
              </select>
              <?php echo form_error('department', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
            </div>
            <br><br><br>
            <label class="control-label col-sm-3" for="branch">Select <?php echo ($this->session->userdata('usertype')=='teacher')?'Branch':'Section'; ?>:</label>
            <div class="col-sm-9"> 
              <select class="form-control" id="branch" name="branch" >
                <option value="">Select <?php echo ($this->session->userdata('usertype')=='teacher')?'Branch':'Section'; ?></option>

              <?php print_r($getallbranch);
              foreach($getallbranch as $branch){
                echo  $branch->branch_Name;?>
                <option value="<?php echo $branch->branch_Name;?>,<?php echo $branch->ExtBranchId;?>"><?php echo $branch->branch_Name;?></option>
              <?php } ?>
              </select>
              <?php echo form_error('branch', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
            </div>
            <br><br><br>
            <label class="control-label col-sm-3" for="semester">Select <?php echo ($this->session->userdata('usertype')=='teacher')?'Semester':'Default Duration'; ?>:</label>
            <div class="col-sm-9"> 
              <select class="form-control" id="semester" name="semester" >
                <option value="">Select <?php echo ($this->session->userdata('usertype')=='teacher')?'Semester':'Default Duration'; ?></option>

              <?php foreach($getallsemester as $semester){?>
                <option value="<?php echo $semester->Semester_Name;?>,<?php echo $semester->ExtSemesterId;?>"><?php echo $semester->Semester_Name;?> </option>
              <?php } ?>
              </select>
              <?php echo form_error('semester', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
            </div><br><br><br>
            <label class="control-label col-sm-3" for="year">Select Year:</label>
            <div class="col-sm-9"> 
              <select class="form-control" id="year" name="year" >
                <option value="">Select Year</option>
              <?php foreach($getAcademicYear as $year){?>
                <option value="<?php echo $year->Academic_Year;?>,<?php echo $year->ExtYearID;?>"><?php echo $year->Academic_Year;?></option>
              <?php } ?>
              </select>
              <?php echo form_error('year', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
            </div>
            <br><br><br>
            <label class="control-label col-sm-3" for="division">Select <?php echo ($this->session->userdata('usertype')=='teacher')?'Division':'Location'; ?>:</label>
            <div class="col-sm-9"> 
              <select class="form-control" id="division" name="division" >
                <option value="">Select <?php echo ($this->session->userdata('usertype')=='teacher')?'Division':'Location'; ?></option>

              <?php foreach($getDivision as $division){?>
                <option value="<?php echo $division->DivisionName;?>,<?php echo $division->ExtDivisionID;?>"><?php echo $division->DivisionName;?></option>
              <?php } ?>
              </select>
              <?php echo form_error('division', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
            </div>
            <br><br><br>   
            <div class="col-sm-offset-3 col-sm-9">
              <button type="submit" name="submit" class="myButton form2" value="Submit" onclick="return addSubject();">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</section>
<!--Below script added by Rutuja for fetching branch depending on Course level and Department and fetching Semester depending on Branch for SMC-5068 on 31-12-2020-->
<script type="text/javascript">
   $(document).ready(function(){
      $('#department').change(function() {
        var courseLevel = document.getElementById("courseLevel").value;
        var department1 = document.getElementById("department").value;
        var d= department1.split(",");
        var department = d[0];
       // alert(department);alert(courseLevel);
        sleep(100);
      var value = $(this).val();
         
            var base_url1 = window.location.origin;
      $.ajax({
          type: "POST",
          url: base_url1 + '/Sub_values_addsubject/subbranchlist',
          data: { 
                              course : courseLevel,
                              department : department
                          },  
          success: function(data) {
                        // alert(data);
                        console.log(data);
                        
              $('#branch').html(data);
            }   
        });
    });

      $('#branch').change(function() {
        
      var value = $(this).val();
      var b= value.split(",");
          var branch = b[0];
         var branch1 = b[1];
         //alert(branch);
            var base_url1 = window.location.origin;
          sleep(100);
      $.ajax({
          type: "POST",
          url: base_url1 + '/Sub_values_addsubject/subsemesterlist',
          data: { 
                              branch : branch
                          },  
          success: function(data) {
                      //  alert(data);
                        console.log(data);
                        
                        
        sleep(100);
              $('#semester').html(data);
            }   
        });
    });


   });


</script>

<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>