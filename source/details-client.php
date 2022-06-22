<?php
$title = 'Modifica cliente';
$description = '';
$slug = 'details-client';
include 'header.php';
$cl_id = $_GET['cl_id'];
?>
<?php if(isset($_POST['client-submit'])): ?>
  <?php
  // get values from form "create-client"
  $cl_destination_code = addslashes($_POST['client-destination-code']);
  $cl_company_name = addslashes($_POST['client-company-name']);
  $cl_name = addslashes($_POST['client-name']);
  $cl_surname = addslashes($_POST['client-surname']);
  $cl_display_name = addslashes($_POST['client-display-name']);
  $cl_street = addslashes($_POST['client-street']);
  $cl_street_nr = addslashes($_POST['client-street-nr']);
  $cl_country_code_input = addslashes($_POST['client-country-code']);
  $cl_country_code = substr($cl_country_code_input, 0, 2);
  $cl_country = substr($cl_country_code_input, 5);
  $cl_cap = addslashes($_POST['client-cap']);
  $cl_city = addslashes($_POST['client-city']);
  $cl_state = addslashes($_POST['client-state']);
  $cl_email = addslashes($_POST['client-email']);
  $cl_pec = addslashes($_POST['client-pec']);
  $cl_vat_nr = addslashes($_POST['client-vat-number']);
  $cl_cf = addslashes($_POST['client-cf']);
  $cl_template = addslashes($_POST['client-template']);

  // valid form inputs
  if($cl_display_name <= '') {
    $msg_error = 'Non è stata compiilato il campo denominazione o nome e cognome del cliente.';
  }
  else if($cl_country_code <= '') {
    $msg_error = 'Non è stata compiilato il campo nazione.';
  }
  else if($cl_country_code == 'IT' && $cl_state <= '') {
    $msg_error = 'Hai scelto come nazione Italia pero non compilato il campo provincia.';
  }
  else if($cl_country_code == 'IT' && ($cl_vat_nr == '' && $cl_cf == '')) {
    $msg_error = 'Hai scelto come nazione Italia pero non è stato compilato il campo partita IVA ni il campo codice fiscale. Uno di quello deve essere compilato.';
  }
  else if($cl_country_code == 'IT' && $cl_vat_nr != '' && (strlen($cl_vat_nr) < 11 || strlen($cl_vat_nr) > 11)) {
    $msg_error = 'Hai scelto come nazione Italia pero il valore della partita IVA non corrisponde con una partita IVA italiana con 11 numeri.';
  }
  else {
    $sql_update = "UPDATE clients SET
                  cl_destination_code='$cl_destination_code',
                  cl_country_code='$cl_country_code',
                  cl_country='$cl_country',
                  cl_state='$cl_state',
                  cl_cap='$cl_cap',
                  cl_city='$cl_city',
                  cl_street='$cl_street',
                  cl_street_nr='$cl_street_nr',
                  cl_vat_nr='$cl_vat_nr',
                  cl_cf='$cl_cf',
                  cl_company_name='$cl_company_name',
                  cl_name='$cl_name',
                  cl_surname='$cl_surname',
                  cl_display_name='$cl_display_name',
                  cl_email='$cl_email',
                  cl_pec='$cl_pec',
                  cl_template='$cl_template'
                  WHERE id_client=$cl_id";
    $res_update = $mysqli->query($sql_update);
    if($res_update){
      $msg_success = 'Aggiornato il cliente con successo.';
    }
    else {
      $msg_error = $mysqli->error;
    }
  }
  ?>
<?php endif; ?>
<section>
  <div class="content gid">
  <?php
  $sql_cl = "SELECT * FROM clients WHERE id_client='$cl_id' ORDER BY cl_display_name DESC";
  $res_cl = $mysqli->query($sql_cl);
  if($res_cl && $res_cl->num_rows > 0):
    $row_cl = $res_cl->fetch_array(MYSQLI_ASSOC);
    ?>
    <h1><?php echo $title .' '. $row_cl['cl_display_name']; ?></h1>
    <div>
      <?php if(isset($_POST['client-submit'])): ?>
        <div class="msg msg-<?php echo $msg_success > '' ? 'success' : 'error'; ?> sp-y-s">
          <p><?php echo $msg_success . $msg_error; ?></p>
        </div>
      <?php endif; ?>
        <form id="create-client" name="create-client" action="details-client.php?cl_id=<?php echo $cl_id; ?>" method="POST">

          <?php include 'view/form-create-client.php'; ?>
            
          <div class="field-group flex flex--pos-x-start flex--gap-col-m">
            <button type="submit" name="client-submit" value="client-submit">Salva e aggiorna il cliente</button>
            <a href="index.php" class="btn btn--sec-color">Ritorna alla bacheca</a>
          </div>
        </form>
      </div>

    <?php else: ?>
      <h1><?php echo $title; ?></h1>
      <div class="msg">
        <p class="sp-y-m">Non stato trovato il cliente richiesta!</p>
        <div class="flex sp-y-m">
          <a href="index.php" class="btn">Ritorna alla Baceccha</a>
          <a href="create-client.php" class="btn btn--sec-color">Aggiungi un nuovo cliente</a>
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php include 'footer.php'; ?>