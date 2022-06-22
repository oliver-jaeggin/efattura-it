window.addEventListener('DOMContentLoaded', () => {
  // create invoice (form validation and caluclation)
  const formCreateInvoice = document.querySelector('#create-invoice');
  const invCurreny = formCreateInvoice.querySelector('#invoice-currency');
  const invSubtotal = formCreateInvoice.querySelector('#invoice-subtotal');
  const invProvision = formCreateInvoice.querySelector('#invoice-provision');
  const invDiscount = formCreateInvoice.querySelector('#invoice-discount');
  const invTotal = formCreateInvoice.querySelector('#invoice-total');
  const invTotalRounded = formCreateInvoice.querySelector('#invoice-total-rounded');
  const invExchangeRate = formCreateInvoice.querySelector('#invoice-exchange-rate');
  const invTotalEur = formCreateInvoice.querySelector('#invoice-total-eur');
  const prefixCurrency = document.querySelectorAll('.prefix-currency');
  const exchangeRate = formCreateInvoice.querySelector('.no-eur-only');
  const checkboxToggle = formCreateInvoice.querySelectorAll('input[type="checkbox"]');

  // provide currency and toggle exchange-rate fields
  invCurreny.addEventListener('change', (e) => {
    let inputValue = e.target.value;
    prefixCurrency.forEach(el => {
      el.innerHTML = inputValue;
    });
    if(inputValue != 'EUR') {
      exchangeRate.setAttribute('data-visible', 'true');
    }
    else {
      exchangeRate.setAttribute('data-visible', 'false');
    }
  });

  // create item
  const outputCreateItem = document.querySelector('#invoice-items .invoice-items-list');
  const formCreateItem = document.querySelector('#create-item');
  const itemInvoiceId = formCreateItem.querySelector('#item-invoice-id');
  const itemDescription = formCreateItem.querySelector('#item-description');
  const itemQty = formCreateItem.querySelector('#item-qty');
  const itemPrice = formCreateItem.querySelector('#item-price');
  const itemTax = formCreateItem.querySelector('#item-tax');
  const totalItem = formCreateItem.querySelector('#item-total');
  const totalItemTax = formCreateItem.querySelector('#item-total-tax');

  formCreateItem.querySelectorAll('input[type="number"]').forEach(inputField => {
    inputField.addEventListener('change', () => {
      let valueTotalItem = parseFloat(itemQty.value * itemPrice.value);
      totalItem.value = globalFun.roundValue(valueTotalItem);
    });
  });

  formCreateItem.addEventListener('submit', (e) => {
    e.preventDefault();    
    xhr.open(
      'GET',
      'create-item.php?item-invoice-id=' + itemInvoiceId.value + '&item-description=' + globalFun.escapeHtml(itemDescription.value) + '&item-qty=' + itemQty.value + '&item-price=' + itemPrice.value + '&item-tax=' + itemTax.value + '&item-total=' + totalItem.value, true);
    xhr.send();
    xhr.onload = () => {
      if(xhr.status === 200) {
        let resp = xhr.responseText;
        if(resp) {
          outputCreateItem.innerHTML = resp;
          globalFun.toggleModal('#dialog-create-item');
          formCreateItem.reset();
          // calculate subtotal
          let allItemsTotal = document.querySelector('#all-items-total').value;
          if(allItemsTotal > 0) {
            globalFun.calcInvTotals(allItemsTotal, invDiscount.value, invProvision.value);
          }
        }
      }
    }
  });

  // toggle input fields with checkbox
  checkboxToggle.forEach(inputField => {
    inputField.addEventListener('change', (e) => {
      let inputToggle = e.target;
      let targetToggle = inputToggle.parentElement.parentElement.nextElementSibling;
      if(inputToggle.checked) {
        targetToggle.setAttribute('data-state', 'is-opened');
        targetToggle.querySelector('input').removeAttribute('tabindex');
      }
      else {
        targetToggle.setAttribute('data-state', 'is-closed');
        targetToggle.querySelector('input').value = '';
        targetToggle.querySelector('input').setAttribute('tabindex', '-1');
        globalFun.calcInvTotals(document.querySelector('#all-items-total').value, invDiscount.value, invProvision.value);
      }
    });
  });

  // calculate discount
  invDiscount.addEventListener('change', (e) => {
    let inputValue = e.target.value;
    globalFun.calcInvTotals(document.querySelector('#all-items-total').value, inputValue, invProvision.value);
  });

  // calculate provision
  invProvision.addEventListener('change', (e) => {
    let inputValue = e.target.value;
    globalFun.calcInvTotals(document.querySelector('#all-items-total').value, invDiscount.value, inputValue);
  });

  // calculate price in eur with exchange rate
  invExchangeRate.addEventListener('change', (e) => {
    let inputValue = e.target.value;
    let totalRoundedEur = parseFloat(invTotalRounded.value * inputValue);
    invTotalEur.value = globalFun.roundValue(totalRoundedEur, 0);
  });
});