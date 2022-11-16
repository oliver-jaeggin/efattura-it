window.addEventListener('DOMContentLoaded', () => {
  // create invoice (form validation and caluclation)
  const formCreateInvoice = document.querySelector('#create-invoice');
  const invClientSelect = formCreateInvoice.querySelector('#client_select');
  const invClientId = formCreateInvoice.querySelector('#client_id')
  const invCurrency = formCreateInvoice.querySelector('#currency');
  const invSubtotal = formCreateInvoice.querySelector('#subtotal');
  const invSummary = formCreateInvoice.querySelector('#invoice-summary');
  const invProvision = formCreateInvoice.querySelector('#provision');
  const invDiscount = formCreateInvoice.querySelector('#discount');
  const invTotalRounded = formCreateInvoice.querySelector('#total_rounded');
  const invExchangeRate = formCreateInvoice.querySelector('#exchange_rate');
  const invTotalEur = formCreateInvoice.querySelector('#total_eur');
  const checkboxToggle = formCreateInvoice.querySelectorAll('input[type="checkbox"]');


  // set client-id in hidden field
  invClientSelect.addEventListener('change', (e) => {
    let inputValue = e.target.value;
    invClientId.value = inputValue.split(' - ', 1);
  });

  // provide currency and toggle exchange-rate fields
  if(invCurrency.value > '') {
    window.setCurrency(invCurrency.value);
  }
  invCurrency.addEventListener('change', (e) => {
    inputVal = e.target.value;
    window.setCurrency(inputVal);
  });

  // set subtotal of all items to the input-field of the invoice
  if(document.querySelector('#all-items-total')) {
    var allItemsTotal = document.querySelector('#all-items-total');
    if(allItemsTotal.value > '') {
      invSummary.removeAttribute('hidden');
      invSubtotal.value = allItemsTotal.value;
      // refresh all values
      window.calcInvTotals(invSubtotal.value, invDiscount.value, invProvision.value);  
    }
  }
  else if(!document.querySelector('#all-items-total') && invSummary) {
    invSummary.setAttribute('hidden', '');
  }

  // toggle input fields with checkbox
  checkboxToggle.forEach(inputField => {
    inputField.addEventListener('change', (e) => {
      let inputToggle = e.target;
      let targetToggle = inputToggle.parentElement.parentElement.nextElementSibling;
      if(inputToggle.id != 'paid_check' && inputToggle.id != 'upload_xml_check') {
        if(inputToggle.checked) {
          targetToggle.setAttribute('data-state', 'is-opened');
          targetToggle.querySelector('input').removeAttribute('tabindex');
        }
        else {
          targetToggle.setAttribute('data-state', 'is-closed');
          targetToggle.querySelector('input').value = 0;
          targetToggle.querySelector('input').setAttribute('tabindex', '-1');
          window.calcInvTotals(document.querySelector('#all-items-total').value, invDiscount.value, invProvision.value);
        }  
      }
      else if(inputToggle.id == 'paid_check' || inputToggle.id == 'upload_xml_check') {
        let targetToggle = inputToggle.parentElement.nextElementSibling;
        console.log(targetToggle.nodeName);
        if(inputToggle.checked) {
          targetToggle.value = '1';
        }
        else {
          targetToggle.value = '';
        }
      }
    });
  });

  // calculate discount
  if(invDiscount) {
    invDiscount.addEventListener('change', (e) => {
      let inputValue = e.target.value;
      window.calcInvTotals(document.querySelector('#all-items-total').value, inputValue, invProvision.value);
    });
  }

  // calculate provision
  if(invProvision) {
    invProvision.addEventListener('change', (e) => {
      let inputValue = e.target.value;
      window.calcInvTotals(document.querySelector('#all-items-total').value, invDiscount.value, inputValue);
    });
  }

  // calculate price in eur with exchange rate
  if(invExchangeRate) {
    invExchangeRate.addEventListener('change', (e) => {
      let inputValue = e.target.value;
      let totalRoundedEur = parseFloat(invTotalRounded.value * inputValue);
      invTotalEur.value = window.roundValue(totalRoundedEur, 0);
    });
  }
});