<?php
include('inc/db_connect.php');
$sql = "SELECT * FROM clients ORDER BY cl_company_name DESC";
$res = $mysqli->query($sql);
if($res && $res->num_rows > 0):
  ?>
  <table class="table">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Indirizzo</th>
        <th>Paese</th>
        <th>Partita IVA</th>
        <th>Azioni</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $res->fetch_array(MYSQLI_ASSOC)): ?>
      <tr>
        <?php $client_display_name = $row['cl_company_name'] > '' ? $row['cl_company_name'] : $row['cl_name'] .' '. $row['cl_surname']; ?>
        <td><?php echo $client_display_name; ?></td>
        <td><?php echo $row['cl_street'] .' '. $row['cl_street_nr'] .'<br>'. $row['cl_cap'] .' '. $row['cl_city']; ?></td>
        <td><?php echo $row['cl_country_code']; ?></td>
        <td><?php echo $row['cl_vat_nr']; ?></td>
        <td>
          <a href="details-client.php?cl_id=<?php echo $row['id_client']; ?>">Apri</a>
          <a href="edit-client.php?cl_id=<?php echo $row['id_client']; ?>&action=delete" class="delete-client" onclick="globalFun.deleteItem(event);">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
<?php else: ?>
  <div class="msg">
    <p>Nessuna cliente trovata.</p>
  </div>
<?php endif; ?>
