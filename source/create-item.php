<?php
include 'inc/db_connect.php';
if(isset($_GET['item-invoice-id']) && $_GET['item-description'] > ''):
 ?>
  <?php
  // get values from form "create-item"
  $item_invoice_id = addslashes($_GET['item-invoice-id']);
  $item_description = addslashes($_GET['item-description']);
  $item_qty = addslashes($_GET['item-qty']);
  $item_price = addslashes($_GET['item-price']);
  $item_tax = addslashes($_GET['item-tax']);
  $item_total = addslashes($_GET['item-total']);
  $item_total_tax = addslashes($_GET['item-total-tax']);

  $query_w_item = $mysqli->prepare("INSERT INTO items (item_id_inv, item_description, item_qty, item_price, item_tax, item_total) VALUES (?, ?, ?, ?, ?, ?)");
  $query_w_item->bind_param('isssss', $item_invoice_id, $item_description, $item_qty, $item_price, $item_tax, $item_total);
  $res_w_item = $query_w_item->execute();
  if($res_w_item):
    ?>

    <?php include 'view/table-items.php'; ?>

  <?php else: ?>
    $msg_error = 'Problemi di inserire il prodotto/servizio nella database!<br>'. $mysqli->error;
  <?php endif; ?>
<?php else: ?>
  <div class="msg msg-error sp-y-s">
    <p><?php echo $msg_error; ?></p>
  </div>
<?php endif; ?>




