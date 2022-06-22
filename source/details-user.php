<?php
$title = 'Modifica dati utente';
$description = '';
$slug = 'details-user';
include 'header.php';
?>
<?php if(isset($_POST['user-submit'])): ?>
  <?php
  // get values from form "create-user"
  $u_id = addslashes($_POST['user-id']);
  $u_company_name = addslashes($_POST['user-company-name']);
  $u_name = addslashes($_POST['user-name']);
  $u_surname = addslashes($_POST['user-surname']);
  $u_street = addslashes($_POST['user-street']);
  $u_street_nr = addslashes($_POST['user-street-nr']);
  $u_country_code_input = addslashes($_POST['user-country-code']);
  $u_country_code = substr($u_country_code_input, 0, 2);
  $u_country = substr($u_country_code_input, 5);
  $u_cap = addslashes($_POST['user-cap']);
  $u_city = addslashes($_POST['user-city']);
  $u_state = addslashes($_POST['user-state']);
  $u_vat_nr = addslashes($_POST['user-vat-number']);
  $u_cf = addslashes($_POST['user-cf']);
  $u_email = addslashes($_POST['user-email']);
  $u_pec = addslashes($_POST['user-pec']);
  $u_tel = addslashes($_POST['user-tel']);
  $u_web = addslashes($_POST['user-web']);
  $u_username = $u_email;
  $u_psw = '1234';

  // valid form inputs
  if($u_name <= '' && $u_surname <= '') {
    $msg_error = 'Non è stata compiilato il campo del nome o/e cognome.';
  }
  else if($u_country_code <= '') {
    $msg_error = 'Non è stata compiilato il campo nazione.';
  }
  else if($u_country_code != 'IT') {
    $msg_error = 'Hai scelto una nazione estero. Questo applicazione sopporto soltanto soggeti con la partita IVA e la residenza italiana.';
  }
  else if($u_vat_nr == '' || $u_cf == '') {
    $msg_error = 'Non è stato compilato il campo partita IVA o il campo codice fiscale. Entrambe devono essere compilati.';
  }
  else if($u_vat_nr != '' && (strlen($u_vat_nr) < 11 || strlen($u_vat_nr) > 11)) {
    $msg_error = 'Il valore della partita IVA non corrisponde con una partita IVA italiana con 11 numeri.';
  }
  else {
    $sql_update = "UPDATE user SET
                  username='$u_username',
                  psw='$u_psw',
                  u_country_code='$u_country_code',
                  u_country='$u_country',
                  u_state='$u_state',
                  u_cap='$u_cap',
                  u_city='$u_city',
                  u_street='$u_street',
                  u_street_nr='$u_street_nr',
                  u_vat_nr='$u_vat_nr',
                  u_cf='$u_cf',
                  u_company_name='$u_company_name',
                  u_name='$u_name',
                  u_surname='$u_surname',
                  u_email='$u_email',
                  u_pec='$u_pec',
                  u_tel='$u_tel',
                  u_web='$u_web'
                  WHERE id_user=$u_id";
    $res_update = $mysqli->query($sql_update);
    if($res_update){
      $msg_success = 'Aggiornato i tuoi dati con successo.';
    }
    else {
      $msg_error = $mysqli->error;
    }
  }
  ?>
<?php endif; ?>
<section>
  <div class="content gid">
    <h1><?php echo $title; ?></h1>
    <div>
      <?php if(isset($_POST['user-submit'])): ?>
        <div class="msg msg-<?php echo $msg_success > '' ? 'success' : 'error'; ?> sp-y-s">
          <p><?php echo $msg_success . $msg_error; ?></p>
        </div>
      <?php endif; ?>
      <form id="create-user" name="create-user" action="details-user.php" method="POST">

        <?php include 'view/form-create-user.php'; ?>

        <div class="field-group flex flex--pos-x-start flex--gap-col-m">
          <button type="submit" name="user-submit" value="user-submit">Salva e aggiorna i tuoi dati</button>
          <a href="index.php" class="btn btn--sec-color">Ritorna alla bacheca</a>
        </div>
      </form>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>