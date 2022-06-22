<?php
$title = 'Crea una nuova fattura';
$description = '';
$slug = 'create-invoice';
include 'header.php';
?>
<?php
// get the next ID of table "invoices"
$database = DB_NAME;
$sql_inv_check = "SHOW TABLE STATUS FROM $database WHERE Name='invoices'";
$res_inv_check = $mysqli->query($sql_inv_check);
if($res_inv_check && $res_inv_check->num_rows > 0) {
  $row_inv_check = $res_inv_check->fetch_array(MYSQLI_ASSOC);
  if($row_inv_check['Auto_increment'] <= '') {
    $next_invoice_id = 1;
  }
  else {
    $next_invoice_id = $row_inv_check['Auto_increment'];
  }
}
else {
  $next_invoice_id = 1;
}
// get the last invoice number
$sql_inv = "SELECT * FROM invoices ORDER BY id_inv DESC";
$res_inv = $mysqli->query($sql_inv);
if($res_inv && $res_inv->num_rows > 0) {
  $row_inv = $res_inv->fetch_array(MYSQLI_ASSOC);
  $last_invoice_num = $row_inv['inv_number'];
  $next_invoice_num = $last_invoice_num > '' ? sprintf('%02d', substr($last_invoice_num, 0, 2) +1) .'/'. date('y') : '01/'. date('y');
}
// used first for the first invoice with emtpy database
else {
  $next_invoice_num = '01/'. date('y');
}
$call_invoice_id = $next_invoice_id;
?>
    <section>
      <div class="content gid">
        <h1><?php echo $title; ?></h1>
        <div>
          <?php if(isset($_POST['invoice-submit'])): ?>
            <?php
            // get values from form "create-invoice"
            $invoice_client = addslashes($_POST['invoice-client']);
            $invoice_client_id = substr($invoice_client, 0, strpos($invoice_client, ' - '));
            $invoice_num = $_POST['invoice-num'] > '' ? addslashes($_POST['invoice-num']) : '';
            $invoice_date = addslashes($_POST['invoice-date']);
            $invoice_currency = addslashes($_POST['invoice-currency']);
            $item_ids = [];
            $_POST['item-id-1'] ? $item_ids[] = $_POST['item-id-1'] : '';
            $_POST['item-id-2'] ? $item_ids[] = $_POST['item-id-2'] : '';
            $_POST['item-id-3'] ? $item_ids[] = $_POST['item-id-3'] : '';
            $_POST['item-id-4'] ? $item_ids[] = $_POST['item-id-4'] : '';
            $_POST['item-id-5'] ? $item_ids[] = $_POST['item-id-5'] : '';
            $_POST['item-id-6'] ? $item_ids[] = $_POST['item-id-6'] : '';
            $invoice_subtotal = addslashes($_POST['invoice-subtotal']);
            $invoice_stamp_check = $_POST['invoice-stamp-check'];
            $invoice_stamp = addslashes($_POST['invoice-stamp']);
            $invoice_provision_check = $_POST['invoice-provision-check'];
            $invoice_provision = addslashes($_POST['invoice-provision']);
            $invoice_discount_check = $_POST['invoice-discount-check'];
            $invoice_discount = $_POST['invoice-discount'] > 0 ? addslashes($_POST['invoice-discount']) : '';
            $invoice_total = addslashes($_POST['invoice-total']);
            $invoice_total_rounded = addslashes($_POST['invoice-total-rounded']);
            $invoice_exchange_rate = addslashes($_POST['invoice-exchange-rate']);
            $invoice_total_eur = addslashes($_POST['invoice-total-eur']);
            $invoice_paid = 0;

            // valid form inputs
            if(!is_numeric($invoice_client_id) && !$invoice_client_id > 0) {
              $msg_error = 'Cliente non trovato';
            }
            else if($invoice_num == '') {
              $msg_error = 'Nummereo della fattura è vuoto';
            }
            else if($invoice_stamp_check == '1' && $invoice_stamp <= '') {
              $msg_error = 'Hai attivato il campo "Marca di bollo" ma non hai inserito un importo o l\'importo è uguale zero';
            }
            else if($invoice_provision_check == '1' && $invoice_provision <= '') {
              $msg_error = 'Hai attivato il campo "Cassa previdenziale (INPS)" ma non hai inserito un\'aliquota o l\'aliquota è uguale zero';
            }
            else if($invoice_discount_check == '1' && $invoice_discount <= '') {
              $msg_error = 'Hai attivato il campo "Sconto" ma non hai inserito un valore o il valore è uguale zero';
            }
            else {
              if($item_ids > '') {
                $item_ids = implode(',', $item_ids);
              }
              $query = $mysqli->prepare("INSERT INTO invoices (inv_number, inv_date, inv_currency, inv_client_id, id_items, subtotal, stamp, provision, discount, total, total_rounded, exchange_rate, total_eur, paid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
              $query->bind_param('sssisssssssssi', $invoice_num, $invoice_date, $invoice_currency, $invoice_client_id, $item_ids, $invoice_subtotal, $invoice_stamp, $invoice_provision, $invoice_discount, $invoice_total, $invoice_total_rounded, $invoice_exchange_rate, $invoice_total_eur, $invoice_paid);
              $res_w_inv = $query->execute();
              if($res_w_inv){
                $msg_success = 'Creato la fattura con successo';             
              }
              else {
                $msg_error = $mysqli->error;
              }
            }
            $invoice_date = strtotime($invoice_date);            
            ?>
            <div class="msg msg-<?php echo $msg_success > '' ? 'success' : 'error'; ?> sp-y-s">
              <p><?php echo $msg_success . $msg_error; ?></p>
            </div>
            <div class="flex sp-y-m">
              <a href="index.php" class="btn">Ritorna alla bacheca</a>
              <a href="create-invoice.php" class="btn btn--sec-color">Creare un'altra fattura</a>
            </div>
          <?php else: ?>
            <form id="create-invoice" name="create-invoice" action="#" method="POST">
              <div class="field-group flex flex--gap-col-s">
                <div class="field-wrapper flex__grow-2">
                  <label for="invoice-client">Scegli il cliente</label>
                  <input type="text" list="list-clients" name="invoice-client" id="invoice-client" autocomplete="off" required>
                  <datalist id="list-clients">
                    <?php
                    $sql_client = "SELECT clients.id_client, clients.cl_display_name FROM clients";
                    $res_client = $mysqli->query($sql_client);
                    while($row_client = $res_client->fetch_array(MYSQLI_ASSOC)) {
                      $client_id = $row_client['id_client'];
                      $client_display_name = $row_client['cl_display_name'];
                      echo '<option value="'. $client_id .' - '. $client_display_name .'">';
                    }
                    ?>
                  </datalist>
                </div>
                <a href="create-client.php" class="btn">Crea un nuovo cliente</a>
              </div>
              <div id="invoice-base" class="field-group flex flex--gap-col-s">
                <div class="field-wrapper">
                  <label for="invoice-num">Nummero della fattura</label>
                  <input type="text" id="invoice-num" name="invoice-num" value="<?php echo $next_invoice_num ? $next_invoice_num : ''; ?>" placeholder="00/YY" require>
                </div>
                <div class="field-wrapper">
                  <label for="invoice-date">Data</label>
                  <input type="date" id="invoice-date" name="invoice-date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="field-wrapper">
                  <label for="invoice-currency">Divisa</label>
                  <div class="flex">
                    <input type="text" list="list-currency" id="invoice-currency" name="invoice-currency" minlength="3" maxlength="3" size="6" autocomplete="off" required>
                    <datalist id="list-currency">
                      <?php
                      $json_currencies = file_get_contents('inc/list-currencies.json');
                      $arr_currencies = json_decode($json_currencies, true);
                      foreach($arr_currencies['currencies'] as $val):
                        ?>
                        <option value="<?php echo $val; ?>">
                      <?php endforeach; ?>
                    </datalist>
                    <span class="tooltip">
                      <button type="button" class="tooltip__btn" data-btn="toggle">
                        <span class="sr-only">Aiuto</span>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M9.40836 12.7417C9.37252 12.7813 9.33912 12.8231 9.30836 12.8667C9.27682 12.9132 9.2516 12.9636 9.23336 13.0167C9.20933 13.064 9.19248 13.1145 9.18336 13.1667C9.17927 13.2222 9.17927 13.2779 9.18336 13.3334C9.18054 13.4427 9.20337 13.5512 9.25002 13.6501C9.28745 13.7535 9.34716 13.8474 9.42493 13.9252C9.50269 14.0029 9.59661 14.0627 9.70002 14.1001C9.79977 14.1442 9.90763 14.1669 10.0167 14.1669C10.1258 14.1669 10.2336 14.1442 10.3334 14.1001C10.4368 14.0627 10.5307 14.0029 10.6085 13.9252C10.6862 13.8474 10.7459 13.7535 10.7834 13.6501C10.8204 13.5488 10.8373 13.4412 10.8334 13.3334C10.834 13.2237 10.813 13.115 10.7715 13.0135C10.73 12.912 10.6689 12.8196 10.5917 12.7417C10.5142 12.6636 10.4221 12.6016 10.3205 12.5593C10.219 12.517 10.11 12.4952 10 12.4952C9.89001 12.4952 9.78109 12.517 9.67954 12.5593C9.57799 12.6016 9.48583 12.6636 9.40836 12.7417V12.7417ZM10 1.66675C8.35185 1.66675 6.74068 2.15549 5.37027 3.07117C3.99986 3.98685 2.93176 5.28834 2.30103 6.81105C1.6703 8.33377 1.50527 10.0093 1.82681 11.6258C2.14836 13.2423 2.94203 14.7272 4.10747 15.8926C5.27291 17.0581 6.75776 17.8518 8.37427 18.1733C9.99078 18.4948 11.6663 18.3298 13.1891 17.6991C14.7118 17.0683 16.0133 16.0002 16.9289 14.6298C17.8446 13.2594 18.3334 11.6483 18.3334 10.0001C18.3334 8.90573 18.1178 7.8221 17.699 6.81105C17.2802 5.80001 16.6664 4.88135 15.8926 4.10752C15.1188 3.3337 14.2001 2.71987 13.1891 2.30109C12.178 1.8823 11.0944 1.66675 10 1.66675V1.66675ZM10 16.6667C8.68148 16.6667 7.39255 16.2758 6.29622 15.5432C5.19989 14.8107 4.34541 13.7695 3.84083 12.5513C3.33624 11.3331 3.20422 9.99269 3.46146 8.69948C3.71869 7.40627 4.35363 6.21839 5.28598 5.28604C6.21833 4.35369 7.40622 3.71875 8.69942 3.46151C9.99263 3.20428 11.3331 3.3363 12.5512 3.84088C13.7694 4.34547 14.8106 5.19995 15.5432 6.29628C16.2757 7.39261 16.6667 8.68154 16.6667 10.0001C16.6667 11.7682 15.9643 13.4639 14.7141 14.7141C13.4638 15.9644 11.7681 16.6667 10 16.6667V16.6667ZM10 5.83341C9.56091 5.83313 9.12947 5.94852 8.74911 6.16795C8.36876 6.38739 8.05291 6.70313 7.83336 7.08341C7.77306 7.17826 7.73258 7.28433 7.71434 7.39523C7.69609 7.50613 7.70048 7.61957 7.72721 7.72874C7.75395 7.8379 7.8025 7.94053 7.86993 8.03044C7.93736 8.12036 8.02228 8.19571 8.11958 8.25195C8.21689 8.3082 8.32456 8.34418 8.43613 8.35773C8.54771 8.37128 8.66087 8.36213 8.76881 8.33081C8.87675 8.2995 8.97724 8.24667 9.06423 8.17551C9.15123 8.10436 9.22293 8.01634 9.27502 7.91675C9.34844 7.78958 9.45416 7.68407 9.58148 7.6109C9.70879 7.53773 9.85318 7.4995 10 7.50008C10.221 7.50008 10.433 7.58788 10.5893 7.74416C10.7456 7.90044 10.8334 8.1124 10.8334 8.33342C10.8334 8.55443 10.7456 8.76639 10.5893 8.92267C10.433 9.07895 10.221 9.16675 10 9.16675C9.77901 9.16675 9.56705 9.25455 9.41077 9.41083C9.25449 9.56711 9.16669 9.77907 9.16669 10.0001V10.8334C9.16669 11.0544 9.25449 11.2664 9.41077 11.4227C9.56705 11.579 9.77901 11.6667 10 11.6667C10.221 11.6667 10.433 11.579 10.5893 11.4227C10.7456 11.2664 10.8334 11.0544 10.8334 10.8334V10.6834C11.3845 10.4834 11.8478 10.0961 12.1423 9.58914C12.4368 9.08217 12.5438 8.48782 12.4445 7.90999C12.3452 7.33216 12.046 6.8076 11.5992 6.42801C11.1523 6.04843 10.5863 5.83796 10 5.83341V5.83341Z" fill="currentColor"/>
                        </svg>
                      </button>
                      <dialog class="tooltip__modal">
                        <p>Scrivi la diviso nel formate ISO composto di 3 caratteri. Trovi una lista completto su <a href="https://it.wikipedia.org/wiki/ISO_4217" target="_blank" class="flex flex--inline flex--pos-y-start">
                          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 9.01675C14.779 9.01675 14.567 9.10455 14.4108 9.26083C14.2545 9.41711 14.1667 9.62907 14.1667 9.85008V15.8334C14.1667 16.0544 14.0789 16.2664 13.9226 16.4227C13.7663 16.579 13.5544 16.6667 13.3334 16.6667H4.16669C3.94567 16.6667 3.73371 16.579 3.57743 16.4227C3.42115 16.2664 3.33335 16.0544 3.33335 15.8334V6.66675C3.33335 6.44573 3.42115 6.23377 3.57743 6.07749C3.73371 5.92121 3.94567 5.83341 4.16669 5.83341H10.15C10.371 5.83341 10.583 5.74562 10.7393 5.58934C10.8956 5.43306 10.9834 5.2211 10.9834 5.00008C10.9834 4.77907 10.8956 4.56711 10.7393 4.41083C10.583 4.25455 10.371 4.16675 10.15 4.16675H4.16669C3.50365 4.16675 2.86776 4.43014 2.39892 4.89898C1.93008 5.36782 1.66669 6.00371 1.66669 6.66675V15.8334C1.66669 16.4965 1.93008 17.1323 2.39892 17.6012C2.86776 18.07 3.50365 18.3334 4.16669 18.3334H13.3334C13.9964 18.3334 14.6323 18.07 15.1011 17.6012C15.57 17.1323 15.8334 16.4965 15.8334 15.8334V9.85008C15.8334 9.62907 15.7456 9.41711 15.5893 9.26083C15.433 9.10455 15.221 9.01675 15 9.01675ZM18.2667 2.18341C18.1821 1.97979 18.0203 1.81798 17.8167 1.73341C17.7165 1.69071 17.6089 1.66806 17.5 1.66675H12.5C12.279 1.66675 12.067 1.75455 11.9108 1.91083C11.7545 2.06711 11.6667 2.27907 11.6667 2.50008C11.6667 2.7211 11.7545 2.93306 11.9108 3.08934C12.067 3.24562 12.279 3.33341 12.5 3.33341H15.4917L6.90835 11.9084C6.83025 11.9859 6.76825 12.0781 6.72594 12.1796C6.68364 12.2811 6.66185 12.3901 6.66185 12.5001C6.66185 12.6101 6.68364 12.719 6.72594 12.8206C6.76825 12.9221 6.83025 13.0143 6.90835 13.0917C6.98582 13.1699 7.07799 13.2318 7.17954 13.2742C7.28109 13.3165 7.39001 13.3382 7.50002 13.3382C7.61003 13.3382 7.71895 13.3165 7.8205 13.2742C7.92205 13.2318 8.01422 13.1699 8.09169 13.0917L16.6667 4.50841V7.50008C16.6667 7.72109 16.7545 7.93306 16.9108 8.08934C17.067 8.24562 17.279 8.33341 17.5 8.33341C17.721 8.33341 17.933 8.24562 18.0893 8.08934C18.2456 7.93306 18.3334 7.72109 18.3334 7.50008V2.50008C18.332 2.39118 18.3094 2.2836 18.2667 2.18341V2.18341Z" fill="currentColor"/>
                          </svg>
                          Wikipedia
                        </a>.</p>
                        <p>Essempio: EUR per Euro.</p>
                        <button type="button" class="btn btn--icon-text" data-btn="toggle">
                          <span>Chiudi</span>
                          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.93996 8.00004L11.8066 5.14004C11.9322 5.01451 12.0027 4.84424 12.0027 4.66671C12.0027 4.48917 11.9322 4.31891 11.8066 4.19338C11.6811 4.06784 11.5108 3.99731 11.3333 3.99731C11.1558 3.99731 10.9855 4.06784 10.86 4.19338L7.99996 7.06004L5.13996 4.19338C5.01442 4.06784 4.84416 3.99731 4.66663 3.99731C4.48909 3.99731 4.31883 4.06784 4.19329 4.19338C4.06776 4.31891 3.99723 4.48917 3.99723 4.66671C3.99723 4.84424 4.06776 5.01451 4.19329 5.14004L7.05996 8.00004L4.19329 10.86C4.13081 10.922 4.08121 10.9958 4.04737 11.077C4.01352 11.1582 3.99609 11.2454 3.99609 11.3334C3.99609 11.4214 4.01352 11.5085 4.04737 11.5898C4.08121 11.671 4.13081 11.7447 4.19329 11.8067C4.25527 11.8692 4.329 11.9188 4.41024 11.9526C4.49148 11.9865 4.57862 12.0039 4.66663 12.0039C4.75463 12.0039 4.84177 11.9865 4.92301 11.9526C5.00425 11.9188 5.07798 11.8692 5.13996 11.8067L7.99996 8.94004L10.86 11.8067C10.9219 11.8692 10.9957 11.9188 11.0769 11.9526C11.1581 11.9865 11.2453 12.0039 11.3333 12.0039C11.4213 12.0039 11.5084 11.9865 11.5897 11.9526C11.6709 11.9188 11.7447 11.8692 11.8066 11.8067C11.8691 11.7447 11.9187 11.671 11.9526 11.5898C11.9864 11.5085 12.0038 11.4214 12.0038 11.3334C12.0038 11.2454 11.9864 11.1582 11.9526 11.077C11.9187 10.9958 11.8691 10.922 11.8066 10.86L8.93996 8.00004Z" fill="currentColor"/>
                          </svg>
                        </button>
                      </dialog>
                    </span>
                  </div>
                </div>
              </div>

              <div id="invoice-items" class="sp-y-m">
                <h2>Prodotti o servizi</h2>
                <div class="invoice-items-list">

                  <?php include 'view/table-items.php'; ?>

                </div>
                <div class="field-group flex flex--gap-col-s sp-y-m">
                  <button type="button" class="button" onclick="globalFun.toggleModal('#dialog-create-item')">
                    Aggiungi un prodotto o un servizio
                  </button>
                  <div class="field-wrapper">
                    <label for="invoice-subtotal">Imponibile [<span class="prefix-currency"></span>]</label>
                    <span class="input-prefix prefix-currency"></span>
                    <input type="number" name="invoice-subtotal" id="invoice-subtotal" data-unit="" readonly tabindex="-1">
                  </div>
                </div>
              </div>

              <div id="invoice-summary">
                <div class="field-group flex flex--gap-col-s sp-y-m">
                  <div class="field-wrapper">
                    <label for="invoice-discount-check" class="flex flex--pos-x-start sp-y-s">
                      <input type="checkbox" name="invoice-discount-check" id="invoice-discount-check" value="1">
                      <p>Sconto</p>
                    </label>
                  </div>
                  <div class="field-wrapper" data-state="is-closed">
                    <label for="invoice-discount">Sconto (opzionale)</label>
                    <span class="input-prefix">&nbsp;&nbsp;%</span>
                    <input type="number" name="invoice-discount" id="invoice-discount" data-unit="%" tabindex="-1">
                    <p class="text-grey">Importo: <span class="invoice-discount-value">Non ancora calcolato</span></p>
                  </div>
                </div>

                <div class="field-group flex flex--gap-col-s">
                  <div class="field-wrapper">
                    <label for="invoice-stamp-check" class="flex flex--pos-x-start sp-y-s">
                      <input type="checkbox" name="invoice-stamp-check" id="invoice-stamp-check" checked value="1">
                      <p>Marca di bollo</p>
                    </label>
                  </div>
                  <div class="field-wrapper" data-state="is-opened">
                    <label for="invoice-provision">Importo bollo [EUR]</label>
                    <span class="input-prefix">EUR</span>
                    <input type="number" name="invoice-stamp" id="invoice-stamp" data-unit="EUR" value="2">
                  </div>
                </div>

                <div class="field-group flex flex--gap-col-s">
                  <div class="field-wrapper">
                    <label for="invoice-provision-check" class="flex flex--pos-x-start sp-y-s">
                      <input type="checkbox" name="invoice-provision-check" id="invoice-provision-check" checked value="1">
                      <p>Cassa previdenziale (INPS)</p>
                    </label>
                  </div>
                  <div class="field-wrapper" data-state="is-opened">
                    <label for="invoice-provision">Aliquota INPS</label>
                    <span class="input-prefix">&nbsp;&nbsp;%</span>
                    <input type="number" name="invoice-provision" id="invoice-provision" data-unit="%" value="4">
                    <p class="text-grey">Importo: <span class="invoice-provision-value">Non ancora calcolato</span></p>
                  </div>
                </div>

                <div class="field-group flex flex--gap-col-s flex--pos-y-start">
                  <div class="field-wrapper">
                    <label for="invoice-total">Importo totale [<span class="prefix-currency"></span>]</label>
                    <span class="input-prefix prefix-currency"></span>
                    <input type="number" id="invoice-total" name="invoice-total" data-unit="" readonly tabindex="-1">
                  </div>
                  <div class="field-wrapper">
                    <label for="invoice-total-rounded">Importo arrotondato [<span class="prefix-currency"></span>]</label>
                    <span class="input-prefix prefix-currency"></span>
                    <input type="number" id="invoice-total-rounded" name="invoice-total-rounded" data-unit="">
                  </div>
                </div>

                <div class=" field-groupd flex no-eur-only sp-y-m" data-visible="false">
                  <div class="field-wrapper">
                    <label for="invoice-exchange-rate">Tasso di cambio <span class="prefix-currency"></span> &gt; EUR</label>
                    <input type="number" name="invoice-exchange-rate" id="invoice-exchange-rate" step="0.00000001">
                    <p><a href="https://www.xe.com/currencyconverter/convert/?Amount=1&From=CHF&To=EUR" target="_blank" title="Apri sito xe.com per calcolare il tasso attuali">Tasso di cambio attuale</a></p>
                  </div>
                  <div class="field-wrapper">
                    <label for="invoice-total-eur">Importo totale [EUR]</label>
                    <span class="input-prefix">EUR</span>
                    <input type="number" name="invoice-total-eur" id="invoice-total-eur" data-unit="eur" readonly tabindex="-1">
                    <p>&nbsp;</p>
                  </div>
                </div>
                
                <div class="field-group flex flex--pos-x-start flex--gap-col-m">
                  <button type="submit" name="invoice-submit" value="invoice-submit">Salva e crea la fattura</button>
                  <button type="reset" class="btn btn--icon-text" onclick="window.location.href='<?php echo 'http:/'.'/'. $_SERVER['HTTP_HOST'] .'/index.php'; ?>';">
                    <span>Annula</span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.93996 8.00004L11.8066 5.14004C11.9322 5.01451 12.0027 4.84424 12.0027 4.66671C12.0027 4.48917 11.9322 4.31891 11.8066 4.19338C11.6811 4.06784 11.5108 3.99731 11.3333 3.99731C11.1558 3.99731 10.9855 4.06784 10.86 4.19338L7.99996 7.06004L5.13996 4.19338C5.01442 4.06784 4.84416 3.99731 4.66663 3.99731C4.48909 3.99731 4.31883 4.06784 4.19329 4.19338C4.06776 4.31891 3.99723 4.48917 3.99723 4.66671C3.99723 4.84424 4.06776 5.01451 4.19329 5.14004L7.05996 8.00004L4.19329 10.86C4.13081 10.922 4.08121 10.9958 4.04737 11.077C4.01352 11.1582 3.99609 11.2454 3.99609 11.3334C3.99609 11.4214 4.01352 11.5085 4.04737 11.5898C4.08121 11.671 4.13081 11.7447 4.19329 11.8067C4.25527 11.8692 4.329 11.9188 4.41024 11.9526C4.49148 11.9865 4.57862 12.0039 4.66663 12.0039C4.75463 12.0039 4.84177 11.9865 4.92301 11.9526C5.00425 11.9188 5.07798 11.8692 5.13996 11.8067L7.99996 8.94004L10.86 11.8067C10.9219 11.8692 10.9957 11.9188 11.0769 11.9526C11.1581 11.9865 11.2453 12.0039 11.3333 12.0039C11.4213 12.0039 11.5084 11.9865 11.5897 11.9526C11.6709 11.9188 11.7447 11.8692 11.8066 11.8067C11.8691 11.7447 11.9187 11.671 11.9526 11.5898C11.9864 11.5085 12.0038 11.4214 12.0038 11.3334C12.0038 11.2454 11.9864 11.1582 11.9526 11.077C11.9187 10.9958 11.8691 10.922 11.8066 10.86L8.93996 8.00004Z" fill="currentColor"/>
                    </svg>
                  </button>
                </div>            
              </div>
            </form>

            <?php include 'view/form-create-item.php'; ?>
        
          <?php endif; ?>
        </div>
      </div>
    </section>

<?php include 'footer.php'; ?>