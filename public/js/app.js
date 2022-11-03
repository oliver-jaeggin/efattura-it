/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

eval("// global functions\nvar _require = __webpack_require__(/*! lodash */ \"./node_modules/lodash/lodash.js\"),\n    isNull = _require.isNull; // function to round a numeric value\n\n\nwindow.roundValue = function (value) {\n  var digits = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 2;\n  return Math.round(value * Math.pow(10, digits)) / Math.pow(10, digits);\n}; // function to set currency\n\n\nwindow.setCurrency = function (value) {\n  var prefixCurrency = document.querySelectorAll('.prefix-currency');\n  var exchangeRate = document.querySelector('.no-eur-only');\n  prefixCurrency.forEach(function (el) {\n    el.innerHTML = value;\n  });\n\n  if (value != 'EUR') {\n    if (exchangeRate) {\n      exchangeRate.setAttribute('data-visible', 'true');\n    }\n  } else {\n    if (exchangeRate) {\n      exchangeRate.setAttribute('data-visible', 'false');\n    }\n  }\n}; // escape a string from special characters\n\n\nwindow.escapeHtml = function (string) {\n  if (string === null || string === '') {\n    return false;\n  } else {\n    string = string.toString();\n    var map = {\n      ' ': '%20',\n      '\"': '%22',\n      '#': '%23',\n      '&': '%26',\n      \"'\": '%27',\n      '/': '%2F',\n      '<': '%3C',\n      '>': '%3E'\n    };\n    return string.replace(/[\\s\"#&'\\/<>]/g, function (m) {\n      return map[m];\n    });\n  }\n}; // function to split up country code and country name\n\n\nwindow.splitCountryCode = function (inputVal) {\n  if (inputVal > '') {\n    var countryCode = inputVal.substr(0, 2);\n    var countryName = inputVal.substr(5);\n    return [countryCode, countryName];\n  }\n}; // function to calculate totals\n\n\nwindow.calcInvTotals = function () {\n  var itemSubtotal = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : defaultSubtotal;\n  var discount = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;\n  var provision = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;\n\n  if (!isNaN(itemSubtotal) && itemSubtotal > 0) {\n    // set subtotal to the input field\n    document.querySelector('#subtotal').value = window.roundValue(itemSubtotal); // calc discount value\n\n    var invValDiscount = parseFloat(itemSubtotal / 100 * discount);\n    var invSubtotalDiscount = parseFloat(itemSubtotal) - invValDiscount;\n    document.querySelector('.invoice-discount-value').textContent = window.roundValue(invValDiscount); // calc provision value\n\n    var invValProvision = parseFloat(invSubtotalDiscount / 100 * provision); //let invSubtotalProvision = invSubtotalDiscount + invValProvision;\n\n    document.querySelector('.invoice-provision-value').textContent = window.roundValue(invValProvision); // set totals\n\n    var itemsTotal = 0;\n    document.querySelectorAll('.item-tax-subtotals').forEach(function (el) {\n      var itemTax = el.getAttribute('data-tax-value');\n      var itemTaxVal = el.value; // total items per tax - discount + provision + tax\n\n      var itemValDiscount = parseFloat(itemTaxVal - itemTaxVal / 100 * discount);\n      var itemValProvision = parseFloat(itemValDiscount + itemValDiscount / 100 * provision);\n      var itemValTax = parseFloat(itemValProvision + itemValProvision / 100 * itemTax);\n      itemsTotal += itemValTax;\n    });\n    document.querySelector('#total').value = window.roundValue(itemsTotal);\n    document.querySelector('#total_rounded').value = window.roundValue(itemsTotal, 0); // calculate value in EUR if currencie is not EUR\n\n    var invCurreny = document.querySelector('#currency');\n    var exchangeRate = document.querySelector('#exchange_rate');\n    var invTotalEur = document.querySelector('#total_eur');\n\n    if (invCurreny != 'EUR') {\n      invTotalEur.value = window.roundValue(parseFloat(itemsTotal * exchangeRate.value), 0);\n    } else {\n      exchangeRate.value = '';\n      invTotalEur.value = '';\n    }\n  } else {\n    alert('Errore durante la calcolazione degli importi totale. I valori non sono numerici.');\n  }\n};\n\nwindow.addEventListener('DOMContentLoaded', function () {\n  var body = document.querySelector('body');\n  var header = document.querySelector('#header');\n  var nav = header.querySelector('#main-nav');\n  var modalNav = header.querySelector('.modal--nav');\n  var toggleButtons = document.querySelectorAll('[data-toggle]'); // clone template for navigation\n\n  if (nav) {\n    nav.insertBefore(document.querySelector('#template-main-nav').content.cloneNode(true), null);\n    modalNav.querySelector('nav').insertBefore(document.querySelector('#template-main-nav').content.cloneNode(true), null);\n  } // scroll events for header\n\n\n  function setHeaderClass(scrollPos) {\n    if (scrollPos > 2) {\n      header.classList.add('shadow-light', 'bg-header');\n    }\n\n    if (scrollPos <= 2) {\n      header.classList.remove('shadow-light', 'bg-header');\n    }\n  }\n\n  setHeaderClass(body.scrollTop);\n  body.addEventListener('scroll', function () {\n    setHeaderClass(body.scrollTop);\n  }); // toggle button for dialog/modal\n\n  toggleButtons.forEach(function (toggleBtn) {\n    toggleBtn.addEventListener('click', function (e) {\n      var clickedElement = e.target;\n      var clickedElementType = clickedElement.getAttribute('data-toggle');\n\n      if (clickedElementType == 'open') {\n        var targetElementName = clickedElement.getAttribute('aria-controls');\n        var targetElement = document.querySelector('#' + targetElementName);\n        var targetAction = clickedElement.getAttribute('rel');\n        var targetActionElement = targetElement.querySelector('form');\n        var targetActionName = clickedElement.value;\n        var targetActionNameElement = targetElement.querySelector('.modal-content-name'); // check if target is a <dialog> element or not\n\n        if (targetElement.nodeName === 'DIALOG') {\n          var targetState = targetElement.getAttribute('open');\n\n          if (clickedElement.getAttribute('data-toggle') == 'open' && targetState == null) {\n            targetElement.showModal();\n            clickedElement.setAttribute('aria-expanded', 'true');\n\n            if (targetAction > '') {\n              targetActionElement.setAttribute('action', targetAction);\n              targetActionNameElement.textContent = targetActionName;\n            }\n          } else {\n            targetElement.close();\n            clickedElement.setAttribute('aria-expanded', 'false');\n          }\n        } else {\n          var _targetState = targetElement.getAttribute('data-state');\n\n          if (clickedElement.getAttribute('data-toggle') == 'open' && _targetState == 'is-closed') {\n            targetElement.setAttribute('data-state', 'is-opened');\n            clickedElement.setAttribute('aria-expanded', 'true');\n\n            if (targetAction > '') {\n              targetActionElement.setAttribute('action', targetAction);\n              targetActionNameElement.textContent = targetActionName;\n            }\n          } else {\n            targetElement.setAttribute('data-state', 'is-closed');\n            clickedElement.setAttribute('aria-expanded', 'false');\n          }\n        }\n      } else if (clickedElementType == 'close') {\n        if (isNull(clickedElement.closest('dialog'))) {\n          var closestModal = clickedElement.closest('.modal');\n          closestModal.setAttribute('data-state', 'is-closed');\n        } else {\n          var closestModal = clickedElement.closest('dialog');\n          closestModal.close();\n        }\n\n        var relatedToggleButtons = document.querySelectorAll('[aria-controls=\"' + closestModal.getAttribute('id') + '\"]');\n        relatedToggleButtons.forEach(function (btn) {\n          btn.setAttribute('aria-expanded', 'false');\n        });\n      }\n    });\n  }); // close modal which are non <dialog> element with ESC key\n\n  document.addEventListener('keyup', function (e) {\n    var key = e.key;\n    var openModals = document.querySelectorAll('[data-state=\"is-opened\"]');\n\n    if (key === 'Escape') {\n      openModals.forEach(function (modal) {\n        modal.setAttribute('data-state', 'is-closed');\n        var relatedToggleButtons = document.querySelectorAll('[aria-controls=\"' + modal.getAttribute('id') + '\"]');\n        relatedToggleButtons.forEach(function (btn) {\n          btn.setAttribute('aria-expanded', 'false');\n        });\n      });\n    }\n  });\n}); //require('./bootstrap');\n//require('./calc-client.js');//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,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Q0E1R0QsRSxDQThHQTtBQUNBIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL2FwcC5qcz9jZWQ2Il0sInNvdXJjZXNDb250ZW50IjpbIi8vIGdsb2JhbCBmdW5jdGlvbnNcblxuY29uc3QgeyBpc051bGwgfSA9IHJlcXVpcmUoXCJsb2Rhc2hcIik7XG5cbi8vIGZ1bmN0aW9uIHRvIHJvdW5kIGEgbnVtZXJpYyB2YWx1ZVxud2luZG93LnJvdW5kVmFsdWUgPSBmdW5jdGlvbih2YWx1ZSwgZGlnaXRzPTIpIHtcbiAgcmV0dXJuIE1hdGgucm91bmQodmFsdWUgKiBNYXRoLnBvdygxMCwgZGlnaXRzKSkgLyBNYXRoLnBvdygxMCwgZGlnaXRzKTtcbn1cblxuLy8gZnVuY3Rpb24gdG8gc2V0IGN1cnJlbmN5XG53aW5kb3cuc2V0Q3VycmVuY3kgPSBmdW5jdGlvbih2YWx1ZSkge1xuICBjb25zdCBwcmVmaXhDdXJyZW5jeSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5wcmVmaXgtY3VycmVuY3knKTtcbiAgY29uc3QgZXhjaGFuZ2VSYXRlID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLm5vLWV1ci1vbmx5Jyk7XG5cbiAgcHJlZml4Q3VycmVuY3kuZm9yRWFjaChlbCA9PiB7XG4gICAgZWwuaW5uZXJIVE1MID0gdmFsdWU7XG4gIH0pO1xuICBpZih2YWx1ZSAhPSAnRVVSJykge1xuICAgIGlmKGV4Y2hhbmdlUmF0ZSkge1xuICAgICAgZXhjaGFuZ2VSYXRlLnNldEF0dHJpYnV0ZSgnZGF0YS12aXNpYmxlJywgJ3RydWUnKTtcbiAgICB9XG4gIH1cbiAgZWxzZSB7XG4gICAgaWYoZXhjaGFuZ2VSYXRlKSB7XG4gICAgICBleGNoYW5nZVJhdGUuc2V0QXR0cmlidXRlKCdkYXRhLXZpc2libGUnLCAnZmFsc2UnKTtcbiAgICB9XG4gIH0gIFxufVxuXG4vLyBlc2NhcGUgYSBzdHJpbmcgZnJvbSBzcGVjaWFsIGNoYXJhY3RlcnNcbndpbmRvdy5lc2NhcGVIdG1sID0gZnVuY3Rpb24oc3RyaW5nKSB7XG4gIGlmKChzdHJpbmcgPT09IG51bGwpIHx8IChzdHJpbmcgPT09ICcnKSkge1xuICAgIHJldHVybiBmYWxzZTtcbiAgfVxuICBlbHNlIHtcbiAgICBzdHJpbmcgPSBzdHJpbmcudG9TdHJpbmcoKTtcbiAgICB2YXIgbWFwID0ge1xuICAgICAgJyAnOiAnJTIwJyxcbiAgICAgICdcIic6ICclMjInLFxuICAgICAgJyMnOiAnJTIzJyxcbiAgICAgICcmJzogJyUyNicsXG4gICAgICBcIidcIjogJyUyNycsXG4gICAgICAnLyc6ICclMkYnLFxuICAgICAgJzwnOiAnJTNDJyxcbiAgICAgICc+JzogJyUzRSdcbiAgICB9O1xuICAgIHJldHVybiBzdHJpbmcucmVwbGFjZSgvW1xcc1wiIyYnXFwvPD5dL2csIChtKSA9PiB7IHJldHVybiBtYXBbbV07IH0pO1xuICB9XG59XG5cbi8vIGZ1bmN0aW9uIHRvIHNwbGl0IHVwIGNvdW50cnkgY29kZSBhbmQgY291bnRyeSBuYW1lXG53aW5kb3cuc3BsaXRDb3VudHJ5Q29kZSA9IGZ1bmN0aW9uKGlucHV0VmFsKSB7XG4gIGlmKGlucHV0VmFsID4gJycpIHtcbiAgICB2YXIgY291bnRyeUNvZGUgPSBpbnB1dFZhbC5zdWJzdHIoMCwgMik7XG4gICAgdmFyIGNvdW50cnlOYW1lID0gaW5wdXRWYWwuc3Vic3RyKDUpO1xuICAgIHJldHVybiBbY291bnRyeUNvZGUsIGNvdW50cnlOYW1lXTtcbiAgfVxufVxuXG4vLyBmdW5jdGlvbiB0byBjYWxjdWxhdGUgdG90YWxzXG53aW5kb3cuY2FsY0ludlRvdGFscyA9IGZ1bmN0aW9uKGl0ZW1TdWJ0b3RhbD1kZWZhdWx0U3VidG90YWwsIGRpc2NvdW50PTAsIHByb3Zpc2lvbj0wKSB7XG4gIGlmKCFpc05hTihpdGVtU3VidG90YWwpICYmIGl0ZW1TdWJ0b3RhbCA+IDApIHtcbiAgICAvLyBzZXQgc3VidG90YWwgdG8gdGhlIGlucHV0IGZpZWxkXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI3N1YnRvdGFsJykudmFsdWUgPSB3aW5kb3cucm91bmRWYWx1ZShpdGVtU3VidG90YWwpO1xuICAgIC8vIGNhbGMgZGlzY291bnQgdmFsdWVcbiAgICBsZXQgaW52VmFsRGlzY291bnQgPSBwYXJzZUZsb2F0KGl0ZW1TdWJ0b3RhbCAvIDEwMCAqIGRpc2NvdW50KTtcbiAgICBsZXQgaW52U3VidG90YWxEaXNjb3VudCA9IHBhcnNlRmxvYXQoaXRlbVN1YnRvdGFsKSAtIGludlZhbERpc2NvdW50O1xuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5pbnZvaWNlLWRpc2NvdW50LXZhbHVlJykudGV4dENvbnRlbnQgPSB3aW5kb3cucm91bmRWYWx1ZShpbnZWYWxEaXNjb3VudCk7XG4gICAgLy8gY2FsYyBwcm92aXNpb24gdmFsdWVcbiAgICBsZXQgaW52VmFsUHJvdmlzaW9uID0gcGFyc2VGbG9hdChpbnZTdWJ0b3RhbERpc2NvdW50IC8gMTAwICogcHJvdmlzaW9uKTtcbiAgICAvL2xldCBpbnZTdWJ0b3RhbFByb3Zpc2lvbiA9IGludlN1YnRvdGFsRGlzY291bnQgKyBpbnZWYWxQcm92aXNpb247XG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmludm9pY2UtcHJvdmlzaW9uLXZhbHVlJykudGV4dENvbnRlbnQgPSB3aW5kb3cucm91bmRWYWx1ZShpbnZWYWxQcm92aXNpb24pO1xuICAgIC8vIHNldCB0b3RhbHNcbiAgICB2YXIgaXRlbXNUb3RhbCA9IDA7XG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLml0ZW0tdGF4LXN1YnRvdGFscycpLmZvckVhY2goZWwgPT4ge1xuICAgICAgdmFyIGl0ZW1UYXggPSBlbC5nZXRBdHRyaWJ1dGUoJ2RhdGEtdGF4LXZhbHVlJyk7XG4gICAgICB2YXIgaXRlbVRheFZhbCA9IGVsLnZhbHVlO1xuICAgICAgLy8gdG90YWwgaXRlbXMgcGVyIHRheCAtIGRpc2NvdW50ICsgcHJvdmlzaW9uICsgdGF4XG4gICAgICBsZXQgaXRlbVZhbERpc2NvdW50ID0gcGFyc2VGbG9hdChpdGVtVGF4VmFsIC0gKGl0ZW1UYXhWYWwgLyAxMDAgKiBkaXNjb3VudCkpO1xuICAgICAgbGV0IGl0ZW1WYWxQcm92aXNpb24gPSBwYXJzZUZsb2F0KGl0ZW1WYWxEaXNjb3VudCArIChpdGVtVmFsRGlzY291bnQgLyAxMDAgKiBwcm92aXNpb24pKTtcbiAgICAgIGxldCBpdGVtVmFsVGF4ID0gcGFyc2VGbG9hdChpdGVtVmFsUHJvdmlzaW9uICsgKGl0ZW1WYWxQcm92aXNpb24gLyAxMDAgKiBpdGVtVGF4KSk7XG4gICAgICBpdGVtc1RvdGFsICs9IGl0ZW1WYWxUYXg7XG4gICAgfSk7XG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI3RvdGFsJykudmFsdWUgPSB3aW5kb3cucm91bmRWYWx1ZShpdGVtc1RvdGFsKTtcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjdG90YWxfcm91bmRlZCcpLnZhbHVlID0gd2luZG93LnJvdW5kVmFsdWUoaXRlbXNUb3RhbCwgMCk7XG4gICAgLy8gY2FsY3VsYXRlIHZhbHVlIGluIEVVUiBpZiBjdXJyZW5jaWUgaXMgbm90IEVVUlxuICAgIGxldCBpbnZDdXJyZW55ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI2N1cnJlbmN5Jyk7XG4gICAgbGV0IGV4Y2hhbmdlUmF0ZSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJyNleGNoYW5nZV9yYXRlJyk7XG4gICAgbGV0IGludlRvdGFsRXVyID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI3RvdGFsX2V1cicpO1xuICAgIGlmKGludkN1cnJlbnkgIT0gJ0VVUicpIHtcbiAgICAgIGludlRvdGFsRXVyLnZhbHVlID0gd2luZG93LnJvdW5kVmFsdWUocGFyc2VGbG9hdChpdGVtc1RvdGFsICogZXhjaGFuZ2VSYXRlLnZhbHVlKSwgMCk7ICBcbiAgICB9XG4gICAgZWxzZSB7XG4gICAgICBleGNoYW5nZVJhdGUudmFsdWUgPSAnJztcbiAgICAgIGludlRvdGFsRXVyLnZhbHVlID0gJyc7XG4gICAgfVxuICB9XG4gIGVsc2Uge1xuICAgIGFsZXJ0KCdFcnJvcmUgZHVyYW50ZSBsYSBjYWxjb2xhemlvbmUgZGVnbGkgaW1wb3J0aSB0b3RhbGUuIEkgdmFsb3JpIG5vbiBzb25vIG51bWVyaWNpLicpO1xuICB9XG59XG5cblxud2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCAoKSA9PiB7XG4gIGNvbnN0IGJvZHkgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdib2R5Jyk7XG4gIGNvbnN0IGhlYWRlciA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJyNoZWFkZXInKTtcbiAgY29uc3QgbmF2ID0gaGVhZGVyLnF1ZXJ5U2VsZWN0b3IoJyNtYWluLW5hdicpO1xuICBjb25zdCBtb2RhbE5hdiA9IGhlYWRlci5xdWVyeVNlbGVjdG9yKCcubW9kYWwtLW5hdicpO1xuICBjb25zdCB0b2dnbGVCdXR0b25zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnW2RhdGEtdG9nZ2xlXScpO1xuXG4gIC8vIGNsb25lIHRlbXBsYXRlIGZvciBuYXZpZ2F0aW9uXG4gIGlmKG5hdikge1xuICAgIG5hdi5pbnNlcnRCZWZvcmUoZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI3RlbXBsYXRlLW1haW4tbmF2JykuY29udGVudC5jbG9uZU5vZGUodHJ1ZSksIG51bGwpO1xuICAgIG1vZGFsTmF2LnF1ZXJ5U2VsZWN0b3IoJ25hdicpLmluc2VydEJlZm9yZShkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjdGVtcGxhdGUtbWFpbi1uYXYnKS5jb250ZW50LmNsb25lTm9kZSh0cnVlKSwgbnVsbCk7ICBcbiAgfVxuXG4gIC8vIHNjcm9sbCBldmVudHMgZm9yIGhlYWRlclxuICBmdW5jdGlvbiBzZXRIZWFkZXJDbGFzcyhzY3JvbGxQb3MpIHtcbiAgICBpZihzY3JvbGxQb3MgPiAyKSB7XG4gICAgICBoZWFkZXIuY2xhc3NMaXN0LmFkZCgnc2hhZG93LWxpZ2h0JywgJ2JnLWhlYWRlcicpO1xuICAgIH1cbiAgICBpZihzY3JvbGxQb3MgPD0gMikge1xuICAgICAgaGVhZGVyLmNsYXNzTGlzdC5yZW1vdmUoJ3NoYWRvdy1saWdodCcsICdiZy1oZWFkZXInKTtcbiAgICB9XG4gIH1cbiAgc2V0SGVhZGVyQ2xhc3MoYm9keS5zY3JvbGxUb3ApO1xuICBib2R5LmFkZEV2ZW50TGlzdGVuZXIoJ3Njcm9sbCcsICgpID0+IHtcbiAgICBzZXRIZWFkZXJDbGFzcyhib2R5LnNjcm9sbFRvcCk7XG4gIH0pO1xuXG4gIC8vIHRvZ2dsZSBidXR0b24gZm9yIGRpYWxvZy9tb2RhbFxuICB0b2dnbGVCdXR0b25zLmZvckVhY2godG9nZ2xlQnRuID0+IHtcbiAgICB0b2dnbGVCdG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgbGV0IGNsaWNrZWRFbGVtZW50ID0gZS50YXJnZXQ7XG4gICAgICBsZXQgY2xpY2tlZEVsZW1lbnRUeXBlID0gY2xpY2tlZEVsZW1lbnQuZ2V0QXR0cmlidXRlKCdkYXRhLXRvZ2dsZScpO1xuXG4gICAgICBpZihjbGlja2VkRWxlbWVudFR5cGUgPT0gJ29wZW4nKSB7ICBcbiAgICAgICAgbGV0IHRhcmdldEVsZW1lbnROYW1lID0gY2xpY2tlZEVsZW1lbnQuZ2V0QXR0cmlidXRlKCdhcmlhLWNvbnRyb2xzJyk7XG4gICAgICAgIGxldCB0YXJnZXRFbGVtZW50ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignIycgKyB0YXJnZXRFbGVtZW50TmFtZSk7XG4gICAgICAgIGxldCB0YXJnZXRBY3Rpb24gPSBjbGlja2VkRWxlbWVudC5nZXRBdHRyaWJ1dGUoJ3JlbCcpO1xuICAgICAgICBsZXQgdGFyZ2V0QWN0aW9uRWxlbWVudCA9IHRhcmdldEVsZW1lbnQucXVlcnlTZWxlY3RvcignZm9ybScpO1xuICAgICAgICBsZXQgdGFyZ2V0QWN0aW9uTmFtZSA9IGNsaWNrZWRFbGVtZW50LnZhbHVlO1xuICAgICAgICBsZXQgdGFyZ2V0QWN0aW9uTmFtZUVsZW1lbnQgPSB0YXJnZXRFbGVtZW50LnF1ZXJ5U2VsZWN0b3IoJy5tb2RhbC1jb250ZW50LW5hbWUnKTtcblxuICAgICAgICAvLyBjaGVjayBpZiB0YXJnZXQgaXMgYSA8ZGlhbG9nPiBlbGVtZW50IG9yIG5vdFxuICAgICAgICBpZih0YXJnZXRFbGVtZW50Lm5vZGVOYW1lID09PSAnRElBTE9HJykge1xuICAgICAgICAgIGxldCB0YXJnZXRTdGF0ZSA9IHRhcmdldEVsZW1lbnQuZ2V0QXR0cmlidXRlKCdvcGVuJyk7XG5cbiAgICAgICAgICBpZihjbGlja2VkRWxlbWVudC5nZXRBdHRyaWJ1dGUoJ2RhdGEtdG9nZ2xlJykgPT0gJ29wZW4nICYmIHRhcmdldFN0YXRlID09IG51bGwpIHtcbiAgICAgICAgICAgIHRhcmdldEVsZW1lbnQuc2hvd01vZGFsKCk7XG4gICAgICAgICAgICBjbGlja2VkRWxlbWVudC5zZXRBdHRyaWJ1dGUoJ2FyaWEtZXhwYW5kZWQnLCAndHJ1ZScpO1xuICAgICAgICAgICAgaWYodGFyZ2V0QWN0aW9uID4gJycpIHtcbiAgICAgICAgICAgICAgdGFyZ2V0QWN0aW9uRWxlbWVudC5zZXRBdHRyaWJ1dGUoJ2FjdGlvbicsIHRhcmdldEFjdGlvbik7XG4gICAgICAgICAgICAgIHRhcmdldEFjdGlvbk5hbWVFbGVtZW50LnRleHRDb250ZW50ID0gdGFyZ2V0QWN0aW9uTmFtZTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9XG4gICAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICB0YXJnZXRFbGVtZW50LmNsb3NlKCk7XG4gICAgICAgICAgICBjbGlja2VkRWxlbWVudC5zZXRBdHRyaWJ1dGUoJ2FyaWEtZXhwYW5kZWQnLCAnZmFsc2UnKTtcbiAgICAgICAgICB9ICBcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICBsZXQgdGFyZ2V0U3RhdGUgPSB0YXJnZXRFbGVtZW50LmdldEF0dHJpYnV0ZSgnZGF0YS1zdGF0ZScpO1xuXG4gICAgICAgICAgaWYoY2xpY2tlZEVsZW1lbnQuZ2V0QXR0cmlidXRlKCdkYXRhLXRvZ2dsZScpID09ICdvcGVuJyAmJiB0YXJnZXRTdGF0ZSA9PSAnaXMtY2xvc2VkJykge1xuICAgICAgICAgICAgdGFyZ2V0RWxlbWVudC5zZXRBdHRyaWJ1dGUoJ2RhdGEtc3RhdGUnLCAnaXMtb3BlbmVkJyk7XG4gICAgICAgICAgICBjbGlja2VkRWxlbWVudC5zZXRBdHRyaWJ1dGUoJ2FyaWEtZXhwYW5kZWQnLCAndHJ1ZScpO1xuICAgICAgICAgICAgaWYodGFyZ2V0QWN0aW9uID4gJycpIHtcbiAgICAgICAgICAgICAgdGFyZ2V0QWN0aW9uRWxlbWVudC5zZXRBdHRyaWJ1dGUoJ2FjdGlvbicsIHRhcmdldEFjdGlvbik7XG4gICAgICAgICAgICAgIHRhcmdldEFjdGlvbk5hbWVFbGVtZW50LnRleHRDb250ZW50ID0gdGFyZ2V0QWN0aW9uTmFtZTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9XG4gICAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICB0YXJnZXRFbGVtZW50LnNldEF0dHJpYnV0ZSgnZGF0YS1zdGF0ZScsICdpcy1jbG9zZWQnKTtcbiAgICAgICAgICAgIGNsaWNrZWRFbGVtZW50LnNldEF0dHJpYnV0ZSgnYXJpYS1leHBhbmRlZCcsICdmYWxzZScpO1xuICAgICAgICAgIH0gIFxuICAgICAgICB9XG4gICAgICB9XG4gICAgICBlbHNlIGlmKGNsaWNrZWRFbGVtZW50VHlwZSA9PSAnY2xvc2UnKSB7XG4gICAgICAgIGlmKGlzTnVsbChjbGlja2VkRWxlbWVudC5jbG9zZXN0KCdkaWFsb2cnKSkpIHtcbiAgICAgICAgICB2YXIgY2xvc2VzdE1vZGFsID0gY2xpY2tlZEVsZW1lbnQuY2xvc2VzdCgnLm1vZGFsJyk7ICAgICAgICAgIFxuICAgICAgICAgIGNsb3Nlc3RNb2RhbC5zZXRBdHRyaWJ1dGUoJ2RhdGEtc3RhdGUnLCAnaXMtY2xvc2VkJyk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgdmFyIGNsb3Nlc3RNb2RhbCA9IGNsaWNrZWRFbGVtZW50LmNsb3Nlc3QoJ2RpYWxvZycpO1xuICAgICAgICAgIGNsb3Nlc3RNb2RhbC5jbG9zZSgpO1xuICAgICAgICB9XG4gICAgICAgIFxuICAgICAgICBsZXQgcmVsYXRlZFRvZ2dsZUJ1dHRvbnMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCdbYXJpYS1jb250cm9scz1cIicgKyBjbG9zZXN0TW9kYWwuZ2V0QXR0cmlidXRlKCdpZCcpICsgJ1wiXScpO1xuICAgICAgICByZWxhdGVkVG9nZ2xlQnV0dG9ucy5mb3JFYWNoKGJ0biA9PiB7XG4gICAgICAgICAgYnRuLnNldEF0dHJpYnV0ZSgnYXJpYS1leHBhbmRlZCcsICdmYWxzZScpO1xuICAgICAgICB9KTtcbiAgICAgIH1cbiAgICB9KTtcbiAgfSk7XG4gIFxuICAvLyBjbG9zZSBtb2RhbCB3aGljaCBhcmUgbm9uIDxkaWFsb2c+IGVsZW1lbnQgd2l0aCBFU0Mga2V5XG4gIGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2tleXVwJywgZSA9PiB7XG4gICAgbGV0IGtleSA9IGUua2V5O1xuICAgIGxldCBvcGVuTW9kYWxzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnW2RhdGEtc3RhdGU9XCJpcy1vcGVuZWRcIl0nKTtcblxuICAgIGlmKGtleSA9PT0gJ0VzY2FwZScpIHtcbiAgICAgIG9wZW5Nb2RhbHMuZm9yRWFjaChtb2RhbCA9PiB7XG4gICAgICAgIG1vZGFsLnNldEF0dHJpYnV0ZSgnZGF0YS1zdGF0ZScsICdpcy1jbG9zZWQnKTtcbiAgICAgICAgbGV0IHJlbGF0ZWRUb2dnbGVCdXR0b25zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnW2FyaWEtY29udHJvbHM9XCInICsgbW9kYWwuZ2V0QXR0cmlidXRlKCdpZCcpICsgJ1wiXScpO1xuICAgICAgICByZWxhdGVkVG9nZ2xlQnV0dG9ucy5mb3JFYWNoKGJ0biA9PiB7XG4gICAgICAgICAgYnRuLnNldEF0dHJpYnV0ZSgnYXJpYS1leHBhbmRlZCcsICdmYWxzZScpO1xuICAgICAgICB9KTtcbiAgICAgIH0pO1xuICAgIH1cbiAgfSk7XG59KTtcblxuLy9yZXF1aXJlKCcuL2Jvb3RzdHJhcCcpO1xuLy9yZXF1aXJlKCcuL2NhbGMtY2xpZW50LmpzJyk7XG4iXSwibmFtZXMiOlsicmVxdWlyZSIsImlzTnVsbCIsIndpbmRvdyIsInJvdW5kVmFsdWUiLCJ2YWx1ZSIsImRpZ2l0cyIsIk1hdGgiLCJyb3VuZCIsInBvdyIsInNldEN1cnJlbmN5IiwicHJlZml4Q3VycmVuY3kiLCJkb2N1bWVudCIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJleGNoYW5nZVJhdGUiLCJxdWVyeVNlbGVjdG9yIiwiZm9yRWFjaCIsImVsIiwiaW5uZXJIVE1MIiwic2V0QXR0cmlidXRlIiwiZXNjYXBlSHRtbCIsInN0cmluZyIsInRvU3RyaW5nIiwibWFwIiwicmVwbGFjZSIsIm0iLCJzcGxpdENvdW50cnlDb2RlIiwiaW5wdXRWYWwiLCJjb3VudHJ5Q29kZSIsInN1YnN0ciIsImNvdW50cnlOYW1lIiwiY2FsY0ludlRvdGFscyIsIml0ZW1TdWJ0b3RhbCIsImRlZmF1bHRTdWJ0b3RhbCIsImRpc2NvdW50IiwicHJvdmlzaW9uIiwiaXNOYU4iLCJpbnZWYWxEaXNjb3VudCIsInBhcnNlRmxvYXQiLCJpbnZTdWJ0b3RhbERpc2NvdW50IiwidGV4dENvbnRlbnQiLCJpbnZWYWxQcm92aXNpb24iLCJpdGVtc1RvdGFsIiwiaXRlbVRheCIsImdldEF0dHJpYnV0ZSIsIml0ZW1UYXhWYWwiLCJpdGVtVmFsRGlzY291bnQiLCJpdGVtVmFsUHJvdmlzaW9uIiwiaXRlbVZhbFRheCIsImludkN1cnJlbnkiLCJpbnZUb3RhbEV1ciIsImFsZXJ0IiwiYWRkRXZlbnRMaXN0ZW5lciIsImJvZHkiLCJoZWFkZXIiLCJuYXYiLCJtb2RhbE5hdiIsInRvZ2dsZUJ1dHRvbnMiLCJpbnNlcnRCZWZvcmUiLCJjb250ZW50IiwiY2xvbmVOb2RlIiwic2V0SGVhZGVyQ2xhc3MiLCJzY3JvbGxQb3MiLCJjbGFzc0xpc3QiLCJhZGQiLCJyZW1vdmUiLCJzY3JvbGxUb3AiLCJ0b2dnbGVCdG4iLCJlIiwiY2xpY2tlZEVsZW1lbnQiLCJ0YXJnZXQiLCJjbGlja2VkRWxlbWVudFR5cGUiLCJ0YXJnZXRFbGVtZW50TmFtZSIsInRhcmdldEVsZW1lbnQiLCJ0YXJnZXRBY3Rpb24iLCJ0YXJnZXRBY3Rpb25FbGVtZW50IiwidGFyZ2V0QWN0aW9uTmFtZSIsInRhcmdldEFjdGlvbk5hbWVFbGVtZW50Iiwibm9kZU5hbWUiLCJ0YXJnZXRTdGF0ZSIsInNob3dNb2RhbCIsImNsb3NlIiwiY2xvc2VzdCIsImNsb3Nlc3RNb2RhbCIsInJlbGF0ZWRUb2dnbGVCdXR0b25zIiwiYnRuIiwia2V5Iiwib3Blbk1vZGFscyIsIm1vZGFsIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/app.js\n");

/***/ }),

/***/ "./node_modules/lodash/lodash.js":
/*!***************************************!*\
  !*** ./node_modules/lodash/lodash.js ***!
  \***************************************/
/***/ (function(module, exports, __webpack_require__) {


/***/ }),

/***/ "./resources/scss/app.scss":
/*!*********************************!*\
  !*** ./resources/scss/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvc2Nzcy9hcHAuc2Nzcy5qcyIsIm1hcHBpbmdzIjoiO0FBQUEiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvc2Nzcy9hcHAuc2Nzcz9mMjE0Il0sInNvdXJjZXNDb250ZW50IjpbIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6W10sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/scss/app.scss\n");

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
/******/ 			id: moduleId,
/******/ 			loaded: false,
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
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
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
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
/******/ 	/* webpack/runtime/node module decorator */
/******/ 	(() => {
/******/ 		__webpack_require__.nmd = (module) => {
/******/ 			module.paths = [];
/******/ 			if (!module.children) module.children = [];
/******/ 			return module;
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
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
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
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/scss/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;