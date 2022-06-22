// global functions
const xhr = new XMLHttpRequest();
const globalFun = {
  //function to toggle modal
  toggleModal(modal) {
    let targetModal = document.querySelector(modal);
    let curModalState = targetModal.getAttribute('data-state');
    if(curModalState == 'is-closed') {
      targetModal.showModal();
      targetModal.setAttribute('data-state', 'is-opened');
    }
    else {
      targetModal.close();
      targetModal.setAttribute('data-state', 'is-closed');
    }
  },
  // function to round a numeric value
  roundValue(value, digits=2) {
    return Math.round(value * Math.pow(10, digits)) / Math.pow(10, digits);
  },
  // escape a string from special characters
  escapeHtml(string) {
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
  },
  // function to split up country code and country name
  splitCountryCode(inputVal) {
    if(inputVal > '') {
      var countryCode = inputVal.substr(0, 2);
      var countryName = inputVal.substr(5);
      return [countryCode, countryName];
    }
  },  
  // function to delete a item from the invoice
  deleteItem(e) {
    e.preventDefault();
    let linkTarget = e.target.getAttribute('href');
    let tableRow = e.target.parentElement.parentElement;
    let table = e.target.closest('.table');
    xhr.open(
      'GET',
      linkTarget,
      true
    );
    xhr.send();
    xhr.onload = () => {
      if(xhr.status === 200) {
        let resp = xhr.responseText;
        if(resp) {
          if(tableRow.parentElement.children[1].nodeName == 'TR') {
            tableRow.parentElement.removeChild(tableRow);
          }
          else {
            table.parentElement.innerHTML = '<div class="msg"><p>Nessun prodotto o servizio allegato.</p></div>';
            table.parentElement.removeChild(table);
          }
        }
      }
    }
  },
  // function to calculate totals
  calcInvTotals(itemSubtotal, discount=0, provision=0) {
    if(!isNaN(itemSubtotal) && itemSubtotal > 0) {
      // set subtotal to the input field
      document.querySelector('#invoice-subtotal').value = globalFun.roundValue(itemSubtotal);
      // calc discount value
      let invValDiscount = parseFloat(itemSubtotal / 100 * discount);
      let invSubtotalDiscount = parseFloat(itemSubtotal) - invValDiscount;
      document.querySelector('.invoice-discount-value').textContent = globalFun.roundValue(invValDiscount);
      // calc provision value
      let invValProvision = parseFloat(invSubtotalDiscount / 100 * provision);
      let invSubtotalProvision = invSubtotalDiscount + invValProvision;
      document.querySelector('.invoice-provision-value').textContent = globalFun.roundValue(invValProvision);
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
      document.querySelector('#invoice-total').value = globalFun.roundValue(itemsTotal);
      document.querySelector('#invoice-total-rounded').value = globalFun.roundValue(itemsTotal, 0);
      // calculate value in EUR if currencie is not EUR
      let invCurreny = document.querySelector('#invoice-currency');
      let exchangeRate = document.querySelector('#invoice-exchange-rate');
      let invTotalEur = document.querySelector('#invoice-total-eur');
      if(invCurreny != 'EUR') {
        invTotalEur.value = globalFun.roundValue(parseFloat(itemsTotal * exchangeRate.value), 0);  
      }
      else {
        exchangeRate.value = '';
        invTotalEur.value = '';
      }
    }
    else {
      alert('Errore durante la calcolazione degli importi totale. I valori non sono numerici.');
    }
  }
}

window.addEventListener('DOMContentLoaded', () => {
  const header = document.querySelector('#header');
  const toggleBtn = header.querySelector('.btn--toggle');
  const modalNav = document.querySelector('.modal--nav');

  // scroll events for header
  window.addEventListener('scroll', () => {
    var scrollPos = window.scrollY;
    // set classes for header relativ to scroll position
    if(scrollPos > 2) {
      header.classList.add('shadow-light', 'bg-header');
    }
    if(scrollPos <= 2) {
      header.classList.remove('shadow-light', 'bg-header');
    }
  });

  // toggle button for menu
  function ojToggleMenu(state) {
    let curState = state;
    if(curState === 'is-closed') {
      toggleBtn.setAttribute('data-state', 'is-opened');
      modalNav.setAttribute('data-state', 'is-opened');
    }
    else if(curState === 'is-opened') {
      toggleBtn.setAttribute('data-state', 'is-closed');
      modalNav.setAttribute('data-state', 'is-closed');
    }
  }
  
  header.addEventListener('click', e => {
    let targetEl = e.target.getAttribute('data-btn');
    let targetState = e.target.getAttribute('data-state');
    if(targetEl == 'menu') {
      if(targetState == 'is-closed') {
        ojToggleMenu('is-closed');
      }
      else if(targetState == 'is-opened') {
        ojToggleMenu('is-opened');
      }
    }
    else if(targetEl == 'close') {
      ojToggleMenu('is-opened');
    }
  });

  document.addEventListener('keyup', e => {
    let key = e.key;
    if(key === 'Escape') {
      ojToggleMenu('is-opened');
    }
  });
});