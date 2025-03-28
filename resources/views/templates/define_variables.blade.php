<?php
if($user->id > 0) {
  // set variables for user
  define('USER_COUNTRY_CODE', $user->country_code > '' ? $user->country_code : '');
  define('USER_VAT_NR', $user->vat_nr > '' ? $user->vat_nr : '');
  define('USER_CF', $user->cf > '' ? $user->cf : '');
  define('USER_NAME', $user->name > '' ? $user->name : '');
  define('USER_SURNAME', $user->surname > '' ? $user->surname : '');
  define('USER_DISPLAY_NAME', $user->company_name > '' ? $user->company_name : $user->name .' '. $user->surname);
  define('USER_STREET', $user->street > '' ? $user->street : '');
  define('USER_STREET_NR', $user->street_nr > '' ? $user->street_nr : '');
  define('USER_CAP', $user->cap > '' ? $user->cap : '');
  define('USER_CITY', $user->city > '' ? $user->city : '');
  define('USER_STATE', $user->state > '' ? $user->state : '');
  define('USER_POSTAL_ADDRESS', $user->street .' '. $user->street_nr .', '. $user->cap .' '. $user->city);
  define('USER_EMAIL', $user->email > '' ? $user->email : '');
  define('USER_PEC', $user->pec > '' ? $user->pec : '');
  define('USER_TEL', $user->tel > '' ? $user->tel : '');
  define('USER_WEB', $user->web > '' ? $user->web : '');
  define('USER_BANK_IBAN', $user->bank_iban > '' ? $user->bank_iban : '');
  define('USER_BANK_BIC', $user->bank_bic > '' ? $user->bank_bic : '');
  define('USER_BANK_NAME', $user->bank_name > '' ? $user->bank_name : '');
}
if($invoice->id > 0) {
  // set variables for client
  define('CLIENT_COUNTRY_CODE', $invoice->client->country_code > '' ? $invoice->client->country_code : '');
  define('CLIENT_PEC', $invoice->client->pec > '' ? $invoice->client->pec : '');
  define('CLIENT_VAT_NR', $invoice->client->vat_nr > '' ? $invoice->client->vat_nr : '');
  define('CLIENT_CF', $invoice->client->cf > '' ? $invoice->client->cf : '');
  define('CLIENT_DESTINATION_CODE', $invoice->client->destination_code > '' ? $invoice->client->destination_code : '');
  define('CLIENT_DISPLAY_NAME', $invoice->client->display_name > '' ? $invoice->client->display_name : '');
  define('CLIENT_STREET', $invoice->client->street > '' ? $invoice->client->street : '');
  define('CLIENT_STREET_NR', $invoice->client->street_nr > '' ? $invoice->client->street_nr : '');
  define('CLIENT_CAP', $invoice->client->cap > '' ? $invoice->client->cap : '');
  define('CLIENT_CITY', $invoice->client->city > '' ? $invoice->client->city : '');
  define('CLIENT_STATE', $invoice->client->state > '' ? $invoice->client->state : '');
  define('CLIENT_POSTAL_ADDRESS', $invoice->client->street .' '. $invoice->client->street_nr .', '. $invoice->client->cap .' '. $invoice->client->city);
  define('CLIENT_TEMPLATE', $invoice->client->template > '' ? $invoice->client->template : '');
  
  
  // set variables for invoice
  define('INV_COUNTER', $invoice->id > '' ? $invoice->id : '');
  define('INV_DOC_TYPE', $invoice->doc_type > '' ? $invoice->doc_type : 'TD06');
  define('INV_CURRENCY', $invoice->currency > '' ? $invoice->currency : '');
  define('INV_DATE', $invoice->date > '' ? $invoice->date : '');
  define('INV_NUMBER', $invoice->number > '' ? $invoice->number : '');
  define('INV_SUBTOTAL', $invoice->subtotal > '' ? $invoice->subtotal : 0);
  define('INV_STAMP', $invoice->stamp > '' ? $invoice->stamp : 0);
  define('INV_PROVISION', $invoice->provision > '' ? $invoice->provision : 0);
  define('INV_DISCOUNT', $invoice->discount > '' ? $invoice->discount : 0);
  define('INV_TOTAL', $invoice->total > '' ? $invoice->total : 0);
  define('INV_TOTAL_ROUNDED', $invoice->total_rounded > '' ? $invoice->total_rounded : 0);
  define('INV_EXCHANGE_RATE', $invoice->exchange_rate > '' ? $invoice->exchange_rate : 0);
  define('INV_TOTAL_EUR', $invoice->total_eur > '' ? $invoice->total_eur : 0);
}

$all_items_total = 0;
foreach($invoice->items as $invoiceItem) {
  $all_items_total += $invoiceItem->total_item;
  $item_per_tax[$invoiceItem->tax] = 0;
}
if(count($item_per_tax) >= 0) {
  foreach($item_per_tax as $key => $val) {
    $query_items_per_tax = DB::table('items')->where([
                            ['invoice_id', $invoice->id],
                            ['tax', $key],
                          ])->get();
    $sum = 0;
    foreach($query_items_per_tax as $val) {
      $sum += $val->total_item;
    }
    $item_per_tax[$key] = $sum;
  }
}
define('ITEMS_QUERY_TOTAL', $item_per_tax);
?>
