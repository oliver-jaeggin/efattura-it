<?php
include 'inc/db_connect.php';

$sql_cl = "SELECT * FROM clients WHERE id_client='$client_id' ORDER BY cl_display_name DESC";
$res_cl = $mysqli->query($sql_cl);
if($res_cl && $res_cl->num_rows > 0) {
  $row_cl = $res_cl->fetch_array(MYSQLI_ASSOC);
}
$cl_destination_code = $row_cl['cl_destination_code'] > '' ? $row_cl['cl_destination_code'] : '';
$cl_company_name = $row_cl['cl_company_name'] > '' ? $row_cl['cl_company_name'] : '';
$cl_name = $row_cl['cl_name'] > '' ? $row_cl['cl_name'] : '';
$cl_surname = $row_cl['cl_surname'] > '' ? $row_cl['cl_surname'] : '';
$cl_display_name = $row_cl['cl_display_name'] > '' ? $row_cl['cl_display_name'] : '';
$cl_street = $row_cl['cl_street'] > '' ? $row_cl['cl_street'] : '';
$cl_street_nr = $row_cl['cl_street_nr'] > '' ? $row_cl['cl_street_nr'] : '';
$cl_country_code = $row_cl['cl_country_code'] > '' ? $row_cl['cl_country_code'] : '';
$cl_country = $row_cl['cl_country'] > '' ? $row_cl['cl_country'] : '';
$cl_cap = $row_cl['cl_cap'] > '' ? $row_cl['cl_cap'] : '';
$cl_city = $row_cl['cl_city'] > '' ? $row_cl['cl_city'] : '';
$cl_state = $row_cl['cl_state'] > '' ? $row_cl['cl_state'] : '';
$cl_email = $row_cl['cl_email'] > '' ? $row_cl['cl_email'] : '';
$cl_pec = $row_cl['cl_pec'] > '' ? $row_cl['cl_pec'] : '';
$cl_vat_nr = $row_cl['cl_vat_nr'] > '' ? $row_cl['cl_vat_nr'] : '';
$cl_cf = $row_cl['cl_cf'] > '' ? $row_cl['cl_cf'] : '';
$cl_template = $row_cl['cl_template'] > '' ? $row_cl['cl_template'] : '';
?>
<div class="field-group flex flex--gap-col-s">
  <div class="field-wrapper">
    <label for="client-destination-code">Codice destinatario</label>
    <input type="number" name="client-destination-code" id="client-destination-code" maxlength="7" value="<?php echo $cl_destination_code; ?>">
  </div>
  <div class="field-wrapper">
    <label for="client-company-name">Denominazione</label>
    <input type="text" name="client-company-name" id="client-company-name" class="input-client-name" value="<?php echo $cl_company_name; ?>">
  </div>
</div>

<div class="field-group flex flex--gap-col-s">
  <div class="field-wrapper">
    <label for="client-name">Nome</label>
    <input type="text" name="client-name" id="client-name" class="input-client-name" value="<?php echo $cl_name; ?>">
  </div>
  <div class="field-wrapper">
    <label for="client-surname">Cognome</label>
    <input type="text" name="client-surname" id="client-surname" class="input-client-name" value="<?php echo $cl_surname; ?>">
  </div>
</div>

<input type="hidden" name="client-display-name" id="client-display-name" value="<?php echo $cl_display_name; ?>">

<div class="field-group flex flex--gap-col-s">
  <div class="field-wrapper">
    <label for="client-street">Indirizzo</label>
    <input type="text" name="client-street" id="client-street" required value="<?php echo $cl_street; ?>">
  </div>
  <div class="field-wrapper">
    <label for="client-street-nr">Numero civico</label>
    <input type="text" name="client-street-nr" id="client-street-nr" required value="<?php echo $cl_street_nr; ?>">
  </div>
</div>

<div class="field-group flex flex--gap-col-s">
  <div class="field-wrapper">
    <label for="client-country-code">Nazione</label>
    <input type="text" list="list-countries" name="client-country-code" id="client-country-code" required value="<?php echo $cl_country_code > '' ? $cl_country_code .' - '. $cl_country : ''; ?>" autocomplete="off">
    <datalist id="list-countries">
      <?php
      $json_countries = file_get_contents('inc/list-countries.json');
      $arr_countries = json_decode($json_countries, true);
      foreach($arr_countries['coutries'] as $key => $val):
        ?>
        <option value="<?php echo $key .' - '. $val; ?>"><?php echo $key .' - '. $val; ?></option>
      <?php endforeach; ?>
    </datalist>
  </div>
  <div class="field-wrapper">
    <label for="client-cap">CAP</label>
    <input type="text" name="client-cap" id="client-cap" size="6" required value="<?php echo $cl_cap; ?>">
  </div>
  <div class="field-wrapper">
    <label for="client-city">Comune</label>
    <input type="text" name="client-city" id="client-city" required value="<?php echo $cl_city; ?>">
  </div>
  <div class="field-wrapper" data-state="<?php echo $cl_country_code == 'IT' ? 'is-opened' : 'is-closed'; ?>">
    <label for="client-state">Provincia</label>
    <input type="text" list="list-states" name="client-state" id="client-state" minlength="2" maxlength="2" size="4" value="<?php echo $cl_state; ?>" autocomplete="off">
    <datalist id="list-states">
      <?php
      $json_states = file_get_contents('inc/list-states.json');
      $arr_states = json_decode($json_states, true);
      foreach($arr_states['states'] as $key => $val):
        ?>
        <option value="<?php echo $key; ?>"><?php echo $val .' ('. $key .')'; ?></option>
      <?php endforeach; ?>
    </datalist>
  </div>
</div>

<input type="hidden" name="client-country" id="client-country" value="<?php echo $cl_country; ?>">

<div class="field-group flex flex--gap-col-s">
  <div class="field-wrapper">
    <label for="client-vat-number">Partita IVA</label>
    <input type="text" name="client-vat-number" id="client-vat-number" value="<?php echo $cl_vat_nr; ?>">
  </div>
  <div class="field-wrapper" data-state="<?php echo $cl_country_code == 'IT' ? 'is-opened' : 'is-closed'; ?>">
    <label for="client-cf">Codice fiscale</label>
    <input type="text" name="client-cf" id="client-cf" minlength="16" maxlength="16" value="<?php echo $cl_cf; ?>">
  </div>
</div>

<div class="field-group flex flex--gap-col-s">
  <div class="field-wrapper">
    <label for="client-email">Email</label>
    <input type="email" name="client-email" id="client-email" value="<?php echo $cl_email; ?>">
  </div>
  <div class="field-wrapper" data-state="<?php echo $cl_country_code == 'IT' ? 'is-opened' : 'is-closed'; ?>">
    <label for="client-pec">PEC</label>
    <input type="email" name="client-pec" id="client-pec" value="<?php echo $cl_pec; ?>">
  </div>
</div>

<div class="field-wrapper sp-y-m">
  <label for="client-template">Modello della fattura (opzionale)</label>
  <input type="text" list="list-templates" name="client-template" id="client-template" value="<?php echo $cl_template; ?>">
  <datalist id="list-templates">
    <?php
    $dir_templates = scandir('templates');
    $arr_templates = [];
    foreach($dir_templates as $val):
      ?>
      <?php if(str_contains($val, '.') == false): ?>
        <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
      <?php endif; ?>
    <?php endforeach; ?>
  </datalist>
</div>