<?php
include('inc/db_connect.php');
if(!$num_displayed_rows) {
  $num_displayed_rows = 10;
}
$sql = "SELECT invoices.*, clients.cl_display_name, clients.id_client
        FROM invoices
        INNER JOIN clients ON invoices.inv_client_id=clients.id_client
        ORDER BY invoices.id_inv DESC
        LIMIT $num_displayed_rows";
$res = $mysqli->query($sql);
if($res && $res->num_rows > 0):
  ?>
  <table class="table">
    <thead>
      <tr>
        <th>No.</th>
        <th>Data</th>
        <th>Cliente</th>
        <th>Importo</th>
        <th>Pagato</th>
        <th>Azioni</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $res->fetch_array(MYSQLI_ASSOC)): ?>
      <tr class="<?php echo $row['paid'] == 0 ? '' : 'success'; ?>">
        <td><?php echo $row['inv_number']; ?></td>
        <td><?php echo date('Y/m/d', strtotime($row['inv_date'])); ?></td>
        <td><?php echo substr($row['cl_display_name'], 0, 30); ?></td>
        <td><?php echo $row['inv_currency'] .' '. $row['total_rounded']; ?></td>
        <td><?php echo $row['paid'] == 0 ? 'No' : 'Si'; ?></td>
        <td>
          <a href="details-invoice.php?id=<?php echo $row['id_inv']; ?>">Apri</a>
          <a href="export-invoice.php?id=<?php echo $row['id_inv']; ?>&exp_type=xml">XML</a>
          <a href="export-invoice.php?id=<?php echo $row['id_inv']; ?>&exp_type=pdf">PDF</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
<?php else: ?>
  <div class="msg">
    <p>Nessuna fattura trovata.</p>
  </div>
<?php endif; ?>
