<dialog id="dialog-create-item" data-state="is-closed">
  <h2>Aggiungi un prodotto/servizio</h2>
  <form id="create-item" action="#" method="POST">
    <input type="hidden" name="item-invoice-id" id="item-invoice-id" value="<?php echo $call_invoice_id; ?>">
    <div class="field-wrapper">
      <label for="item-description">Descrizione prestazione</label>
      <input type="text" id="item-description" name="item-description" required>
    </div>
    <div class="field-group flex flex--gap-col-s">
      <div class="field-wrapper">
        <label for="item-qty">Quantità</label>
        <input type="number" name="item-qty" id="item-qty" step="0.01" required>
      </div>
      <div class="field-wrapper">
        <label for="item-price">Prezzo</label>
        <span class="input-prefix prefix-currency"><?php echo $row_inv['inv_currency'] > '' ? $row_inv['inv_currency'] : ''; ?></span>
        <input type="number" name="item-price" id="item-price" data-unit="" step="0.01" required>
      </div>
      <div class="field-wrapper">
        <label for="item-tax">Aliquota IVA</label>
        <span class="input-prefix">&nbsp;&nbsp;%</span>
        <input type="number" list="tax-list" name="item-tax" id="item-tax" data-unit="%">
        <datalist id="tax-list">
          <option value="4">
          <option value="22">
        </datalist>
      </div>
    </div>
    <div class="field-wrapper">
      <label for="item-total">Importo</label>
      <span class="input-prefix prefix-currency"><?php echo $row_inv['inv_currency'] > '' ? $row_inv['inv_currency'] : ''; ?></span>
      <input type="text" name="item-total" id="item-total" data-unit="" readonly tabindex="-1">
    </div>
    <div class="field-group flex flex--pos-x-start flex--gap-col-m">
      <button type="submit" name="item-submit" id="item-submit">Salva prodotto/servizio</button>
      <button type="reset" class="btn btn--icon-text" onclick="globalFun.toggleModal('#dialog-create-item')">
        <span>Annula</span>
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8.93996 8.00004L11.8066 5.14004C11.9322 5.01451 12.0027 4.84424 12.0027 4.66671C12.0027 4.48917 11.9322 4.31891 11.8066 4.19338C11.6811 4.06784 11.5108 3.99731 11.3333 3.99731C11.1558 3.99731 10.9855 4.06784 10.86 4.19338L7.99996 7.06004L5.13996 4.19338C5.01442 4.06784 4.84416 3.99731 4.66663 3.99731C4.48909 3.99731 4.31883 4.06784 4.19329 4.19338C4.06776 4.31891 3.99723 4.48917 3.99723 4.66671C3.99723 4.84424 4.06776 5.01451 4.19329 5.14004L7.05996 8.00004L4.19329 10.86C4.13081 10.922 4.08121 10.9958 4.04737 11.077C4.01352 11.1582 3.99609 11.2454 3.99609 11.3334C3.99609 11.4214 4.01352 11.5085 4.04737 11.5898C4.08121 11.671 4.13081 11.7447 4.19329 11.8067C4.25527 11.8692 4.329 11.9188 4.41024 11.9526C4.49148 11.9865 4.57862 12.0039 4.66663 12.0039C4.75463 12.0039 4.84177 11.9865 4.92301 11.9526C5.00425 11.9188 5.07798 11.8692 5.13996 11.8067L7.99996 8.94004L10.86 11.8067C10.9219 11.8692 10.9957 11.9188 11.0769 11.9526C11.1581 11.9865 11.2453 12.0039 11.3333 12.0039C11.4213 12.0039 11.5084 11.9865 11.5897 11.9526C11.6709 11.9188 11.7447 11.8692 11.8066 11.8067C11.8691 11.7447 11.9187 11.671 11.9526 11.5898C11.9864 11.5085 12.0038 11.4214 12.0038 11.3334C12.0038 11.2454 11.9864 11.1582 11.9526 11.077C11.9187 10.9958 11.8691 10.922 11.8066 10.86L8.93996 8.00004Z" fill="currentColor"/>
        </svg>
      </button>
    </div>
  </form>
</dialog>
