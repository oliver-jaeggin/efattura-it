<?php
include('inc/db_connect.php');
$item_invoice_id = $_GET['item-invoice-id'] ? $_GET['item-invoice-id'] : $call_invoice_id;
$sql_items = "SELECT * FROM items WHERE item_id_inv=$item_invoice_id";
$res_items = $mysqli->query($sql_items);
if($res_items && $res_items->num_rows > 0):
  ?>
  <table class="table sp-y-s">
    <thead>
      <tr>
        <th>No.</th>
        <th>Descrizione prestazione</th>
        <th>Quantità</th>
        <th>Prezzo</th>
        <th>Aliquota IVA</th>
        <th>Importo</th>
        <th>Azzione</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $i = 0;
    $all_items_total = 0;
    $all_items_total_tax = 0;
    while($row_items = $res_items->fetch_array(MYSQLI_ASSOC)):
      $i = $i +1;
      $all_items_total += $row_items['item_total'];
      $item_query_per_tax[$row_items['item_tax']] += $row_items['item_total'];
      ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row_items['item_description']; ?></td>
        <td><?php echo $row_items['item_qty']; ?> ore</td>
        <td><span class="prefix-currency"><?php echo $row_inv['inv_currency'] != '' ? $row_inv['inv_currency'] : ''; ?></span> <?php echo $row_items['item_price']; ?></td>
        <td><?php echo $row_items['item_tax']; ?>%</td>
        <td><span class="prefix-currency"><?php echo $row_inv['inv_currency'] != '' ? $row_inv['inv_currency'] : ''; ?></span> <?php echo $row_items['item_total']; ?></span></td>
        <td>
          <a href="edit-item.php?action=delete&type=items&id=<?php echo $row_items['id_item']; ?>" class="delete-item" onclick="globalFun.deleteItem(event);">Delete</a>
        </td>
        <input type="hidden" name="item-id-<?php echo $i; ?>" id="item-id-<?php echo $i; ?>" value="<?php echo $row_items['id_item']; ?>">
        <input type="hidden" name="item-total-1" id="item-total-1" class="input-item-total" value="<?php echo $row_items['item_total']; ?>">
      </tr>                        
    <?php endwhile; ?>
      <?php if(count($item_query_per_tax) >= 0): ?>
        <?php foreach($item_query_per_tax as $key => $val): ?>
          <input type="hidden" name="item-tax-<?php echo $key; ?>-subtotal" id="item-tax-<?php echo $key; ?>-subtotal" data-tax-value="<?php echo $key; ?>" class="item-tax-subtotals" value="<?php echo $val; ?>">
        <?php endforeach; ?>
      <?php endif; ?>
      <input type="hidden" name="all-items-total" id="all-items-total" value="<?php echo $all_items_total; ?>">
    </tbody>
  </table>
<?php else: ?>
  <div class="msg">
    <p>Nessun prodotto o servizio allegato.</p>
  </div>
<?php endif; ?>           
