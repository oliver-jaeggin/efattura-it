// global functions

const { error } = require("laravel-mix/src/Log");
const { isNull } = require("lodash");

// function to round a numeric value
window.roundValue = function(value, digits=2) {
  return Math.round(value * Math.pow(10, digits)) / Math.pow(10, digits);
}

// function to set currency
window.setCurrency = function(value) {
  const prefixCurrency = document.querySelectorAll('.prefix-currency');
  const exchangeRate = document.querySelector('.no-eur-only');

  prefixCurrency.forEach(el => {
    el.innerHTML = value;
  });
  if(value != 'EUR') {
    if(exchangeRate) {
      exchangeRate.setAttribute('data-visible', 'true');
    }
  }
  else {
    if(exchangeRate) {
      exchangeRate.setAttribute('data-visible', 'false');
    }
  }  
}

// escape a string from special characters
window.escapeHtml = function(string) {
  if((string === null) || (string === '')) {
    return false;
  }
  else {
    string = string.toString();
    var map = {
      ' ': '%20',
      '"': '%22',
      '#': '%23',
      '&': '%26',
      "'": '%27',
      '/': '%2F',
      '<': '%3C',
      '>': '%3E'
    };
    return string.replace(/[\s"#&'\/<>]/g, (m) => { return map[m]; });
  }
}

// function to split up country code and country name
window.splitCountryCode = function(selectedCountry, fieldCountryCode, fieldCountry) {
  if(selectedCountry > '') {
    if(fieldCountryCode.nodeName === 'INPUT' && fieldCountry.nodeName === 'INPUT') {
      fieldCountryCode.value = selectedCountry.substr(0, 2);
      fieldCountry.value = selectedCountry.substr(5);
    }
  }
  else {
    return error;
  }
}

// function to calculate totals
window.calcInvTotals = function(itemSubtotal=defaultSubtotal, discount=0, provision=0) {
  if(!isNaN(itemSubtotal) && itemSubtotal > 0) {
    // set subtotal to the input field
    document.querySelector('#subtotal').value = window.roundValue(itemSubtotal);
    // calc discount value
    let invValDiscount = parseFloat(itemSubtotal / 100 * discount);
    let invSubtotalDiscount = parseFloat(itemSubtotal) - invValDiscount;
    document.querySelector('.invoice-discount-value').textContent = window.roundValue(invValDiscount);
    // calc provision value
    let invValProvision = parseFloat(invSubtotalDiscount / 100 * provision);
    //let invSubtotalProvision = invSubtotalDiscount + invValProvision;
    document.querySelector('.invoice-provision-value').textContent = window.roundValue(invValProvision);
    // set totals
    var itemsTotal = 0;
    document.querySelectorAll('.item-tax-subtotals').forEach(el => {
      var itemTax = el.getAttribute('data-tax-value');
      var itemTaxVal = el.value;
      // total items per tax - discount + provision + tax
      let itemValDiscount = parseFloat(itemTaxVal - (itemTaxVal / 100 * discount));
      let itemValProvision = parseFloat(itemValDiscount + (itemValDiscount / 100 * provision));
      let itemValTax = parseFloat(itemValProvision + (itemValProvision / 100 * itemTax));
      itemsTotal += itemValTax;
    });
    document.querySelector('#total').value = window.roundValue(itemsTotal);
    document.querySelector('#total_rounded').value = window.roundValue(itemsTotal, 0);
    // calculate value in EUR if currencie is not EUR
    let invCurrency = document.querySelector('#currency');
    let exchangeRate = document.querySelector('#exchange_rate');
    let invTotalEur = document.querySelector('#total_eur');
    if(invCurrency.value != 'EUR') {
      invTotalEur.value = window.roundValue(parseFloat(itemsTotal * exchangeRate.value), 0);  
    }
    else {
      exchangeRate.value = '';
      invTotalEur.value = window.roundValue(itemsTotal);
    }
  }
  else {
    alert('Errore durante la calcolazione degli importi totale. I valori non sono numerici.');
  }
}


window.addEventListener('DOMContentLoaded', () => {
  const body = document.querySelector('body');
  const header = document.querySelector('#header');
  const nav = header.querySelector('#main-nav');
  const modalNav = header.querySelector('.modal--nav');
  const toggleButtons = document.querySelectorAll('[data-toggle]');

  // clone template for navigation
  if(nav) {
    nav.insertBefore(document.querySelector('#template-main-nav').content.cloneNode(true), null);
    modalNav.querySelector('nav').insertBefore(document.querySelector('#template-main-nav').content.cloneNode(true), null);  
  }

  // scroll events for header
  function setHeaderClass(scrollPos) {
    if(scrollPos > 2) {
      header.classList.add('shadow-light', 'bg-header');
    }
    if(scrollPos <= 2) {
      header.classList.remove('shadow-light', 'bg-header');
    }
  }
  setHeaderClass(body.scrollTop);
  body.addEventListener('scroll', () => {
    setHeaderClass(body.scrollTop);
  });

  // toggle button for dialog/modal
  toggleButtons.forEach(toggleBtn => {
    toggleBtn.addEventListener('click', (e) => {
      let clickedElement = e.target;
      let clickedElementType = clickedElement.getAttribute('data-toggle');

      if(clickedElementType == 'open') {  
        let targetElementName = clickedElement.getAttribute('aria-controls');
        let targetElement = document.querySelector('#' + targetElementName);
        let targetAction = clickedElement.getAttribute('rel');
        let targetActionElement = targetElement.querySelector('form');
        let targetActionName = clickedElement.value;
        let targetActionNameElement = targetElement.querySelector('.modal-content-name');

        // check if target is a <dialog> element or not
        if(targetElement.nodeName === 'DIALOG') {
          let targetState = targetElement.getAttribute('open');

          if(clickedElement.getAttribute('data-toggle') == 'open' && targetState == null) {
            targetElement.showModal();
            clickedElement.setAttribute('aria-expanded', 'true');
            if(targetAction > '') {
              targetActionElement.setAttribute('action', targetAction);
              targetActionNameElement.textContent = targetActionName;
            }
          }
          else {
            targetElement.close();
            clickedElement.setAttribute('aria-expanded', 'false');
          }  
        }
        else {
          let targetState = targetElement.getAttribute('data-state');

          if(clickedElement.getAttribute('data-toggle') == 'open' && targetState == 'is-closed') {
            targetElement.setAttribute('data-state', 'is-opened');
            clickedElement.setAttribute('aria-expanded', 'true');
            if(targetAction > '') {
              targetActionElement.setAttribute('action', targetAction);
              targetActionNameElement.textContent = targetActionName;
            }
          }
          else {
            targetElement.setAttribute('data-state', 'is-closed');
            clickedElement.setAttribute('aria-expanded', 'false');
          }  
        }
      }
      else if(clickedElementType == 'close') {
        if(isNull(clickedElement.closest('dialog'))) {
          var closestModal = clickedElement.closest('.modal');          
          closestModal.setAttribute('data-state', 'is-closed');
        }
        else {
          var closestModal = clickedElement.closest('dialog');
          closestModal.close();
        }
        
        let relatedToggleButtons = document.querySelectorAll('[aria-controls="' + closestModal.getAttribute('id') + '"]');
        relatedToggleButtons.forEach(btn => {
          btn.setAttribute('aria-expanded', 'false');
        });
      }
    });
  });
  
  // close modal which are non <dialog> element with ESC key
  document.addEventListener('keyup', e => {
    let key = e.key;
    let openModals = document.querySelectorAll('[data-state="is-opened"]');

    if(key === 'Escape') {
      openModals.forEach(modal => {
        modal.setAttribute('data-state', 'is-closed');
        let relatedToggleButtons = document.querySelectorAll('[aria-controls="' + modal.getAttribute('id') + '"]');
        relatedToggleButtons.forEach(btn => {
          btn.setAttribute('aria-expanded', 'false');
        });
      });
    }
  });
});

//require('./bootstrap');
//require('./calc-client.js');
