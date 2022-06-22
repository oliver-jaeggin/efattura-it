<?php
$title = 'Aggiungi un nuovo cliente';
$description = '';
$slug = 'create-client';
include 'header.php';
?>
<section>
  <div class="content gid">
    <h1><?php echo $title; ?></h1>
    <div>
      <?php if(isset($_POST['client-submit'])): ?>
        <?php
        // get values from form "create-client"
        $cl_destination_code = addslashes($_POST['client-destination_code']);
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
          $query = $mysqli->prepare("INSERT INTO clients (cl_destination_code, cl_country_code, cl_country, cl_state, cl_cap, cl_city, cl_street, cl_street_nr, cl_vat_nr, cl_cf, cl_company_name, cl_name, cl_surname, cl_display_name, cl_email, cl_pec, cl_template) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $query->bind_param('sssssssssssssssss', $cl_destination_code, $cl_country_code, $cl_country, $cl_state, $cl_cap, $cl_city, $cl_street, $cl_street_nr, $cl_vat_nr, $cl_cf, $cl_company_name, $cl_name, $cl_surname, $cl_display_name, $cl_email, $cl_pec, $cl_template);
          $res_w_cl = $query->execute();
          if($res_w_cl){
            $msg_success = 'Aggiunto il cliente con successo.';
          }
          else {
            $msg_error = $mysqli->error;
          }
        }
        ?>
        <div class="msg msg-<?php echo $msg_success > '' ? 'success' : 'error'; ?> sp-y-s">
          <p><?php echo $msg_success . $msg_error; ?></p>
        </div>
        <div class="flex sp-y-m">
          <a href="index.php" class="btn">Ritorna alla bacheca</a>
          <a href="create-client.php" class="btn btn--sec-color">Aggiungi un'altro cliente</a>
        </div>
      <?php else: ?>
        <form id="create-client" name="create-client" action="#" method="POST">

          <?php include 'form-create-client.php'; ?>
            
          <div class="field-group flex flex--pos-x-start flex--gap-col-m">
            <button type="submit" name="client-submit" value="client-submit">Salva e aggiungi il cliente</button>
            <button type="reset" class="btn btn--icon-text" onclick="window.location.href='<?php echo 'http:/'.'/'. $_SERVER['HTTP_HOST'] . '/index.php'; ?>';">
              <span>Annula</span>
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.93996 8.00004L11.8066 5.14004C11.9322 5.01451 12.0027 4.84424 12.0027 4.66671C12.0027 4.48917 11.9322 4.31891 11.8066 4.19338C11.6811 4.06784 11.5108 3.99731 11.3333 3.99731C11.1558 3.99731 10.9855 4.06784 10.86 4.19338L7.99996 7.06004L5.13996 4.19338C5.01442 4.06784 4.84416 3.99731 4.66663 3.99731C4.48909 3.99731 4.31883 4.06784 4.19329 4.19338C4.06776 4.31891 3.99723 4.48917 3.99723 4.66671C3.99723 4.84424 4.06776 5.01451 4.19329 5.14004L7.05996 8.00004L4.19329 10.86C4.13081 10.922 4.08121 10.9958 4.04737 11.077C4.01352 11.1582 3.99609 11.2454 3.99609 11.3334C3.99609 11.4214 4.01352 11.5085 4.04737 11.5898C4.08121 11.671 4.13081 11.7447 4.19329 11.8067C4.25527 11.8692 4.329 11.9188 4.41024 11.9526C4.49148 11.9865 4.57862 12.0039 4.66663 12.0039C4.75463 12.0039 4.84177 11.9865 4.92301 11.9526C5.00425 11.9188 5.07798 11.8692 5.13996 11.8067L7.99996 8.94004L10.86 11.8067C10.9219 11.8692 10.9957 11.9188 11.0769 11.9526C11.1581 11.9865 11.2453 12.0039 11.3333 12.0039C11.4213 12.0039 11.5084 11.9865 11.5897 11.9526C11.6709 11.9188 11.7447 11.8692 11.8066 11.8067C11.8691 11.7447 11.9187 11.671 11.9526 11.5898C11.9864 11.5085 12.0038 11.4214 12.0038 11.3334C12.0038 11.2454 11.9864 11.1582 11.9526 11.077C11.9187 10.9958 11.8691 10.922 11.8066 10.86L8.93996 8.00004Z" fill="currentColor"/>
              </svg>
            </button>
          </div>            
        </form>    
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>