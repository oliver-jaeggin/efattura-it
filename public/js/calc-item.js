window.addEventListener('DOMContentLoaded', () => {
  // create item
  const formCreateItem = document.querySelector('#create-item');
  const itemQty = formCreateItem.querySelector('#qty');
  const itemPrice = formCreateItem.querySelector('#price');
  const totalItem = formCreateItem.querySelector('#total_item');

  formCreateItem.querySelectorAll('input[type="number"]').forEach(inputField => {
    inputField.addEventListener('change', () => {
      // fix quantity to two digits after comma
      itemQty.value = parseFloat(itemQty.value).toFixed(2);
      let valueTotalItem = parseFloat(itemQty.value * itemPrice.value);
      totalItem.value = window.roundValue(valueTotalItem);
    });
  });
});