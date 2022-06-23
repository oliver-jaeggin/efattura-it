<?php
if(file_exists('inc/db_connect.php')):
  ?>

  <?php
  include('inc/db_connect.php');
  $sql_user = "SELECT * FROM user";
  $res_user = $mysqli->query($sql_user);
  if($res_user && $res_user->num_rows > 0) {
    $row_user = $res_user->fetch_array(MYSQLI_ASSOC);
  }
  $u_id = $row_user['id_user'];
  $u_company_name = $row_user['u_company_name'] > '' ? $row_user['u_company_name'] : '';
  $u_name = $row_user['u_name'] > '' ? $row_user['u_name'] : '';
  $u_surname = $row_user['u_surname'] > '' ? $row_user['u_surname'] : '';
  $u_street = $row_user['u_street'] > '' ? $row_user['u_street'] : '';
  $u_street_nr = $row_user['u_street_nr'] > '' ? $row_user['u_street_nr'] : '';
  $u_country_code = $row_user['u_country_code'] > '' ? $row_user['u_country_code'] : '';
  $u_country = $row_user['u_country'] > '' ? $row_user['u_country'] : '';
  $u_cap = $row_user['u_cap'] > '' ? $row_user['u_cap'] : '';
  $u_city = $row_user['u_city'] > '' ? $row_user['u_city'] : '';
  $u_state = $row_user['u_state'] > '' ? $row_user['u_state'] : '';
  $u_vat_nr = $row_user['u_vat_nr'] > '' ? $row_user['u_vat_nr'] : '';
  $u_cf = $row_user['u_cf'] > '' ? $row_user['u_cf'] : '';
  $u_email = $row_user['u_email'] > '' ? $row_user['u_email'] : '';
  $u_pec = $row_user['u_pec'] > '' ? $row_user['u_pec'] : '';
  $u_tel = $row_user['u_tel'] > '' ? $row_user['u_tel'] : '';
  $u_web = $row_user['u_web'] > '' ? $row_user['u_web'] : '';
  $u_bank_iban = $row_user['u_bank_iban'] > '' ? $row_user['u_bank_iban'] : '';
  $u_bank_bic = $row_user['u_bank_bic'] > '' ? $row_user['u_bank_bic'] : '';
  $u_bank_name = $row_user['u_bank_name'] > '' ? $row_user['u_bank_name'] : '';
  ?>

  <input type="hidden" name="user-id" id="user-id" value="<?php echo $u_id; ?>">
  
  <div class="field-wrapper">
    <label for="user-company-name">Denominazione</label>
    <input type="text" name="user-company-name" id="user-company-name" value="<?php echo $u_company_name; ?>">
  </div>

  <div class="field-group flex flex--gap-col-s">
    <div class="field-wrapper">
      <label for="user-name">Nome</label>
      <input type="text" name="user-name" id="user-name" value="<?php echo $u_name; ?>" required>
    </div>
    <div class="field-wrapper">
      <label for="user-surname">Cognome</label>
      <input type="text" name="user-surname" id="user-surname" value="<?php echo $u_surname; ?>" required>
    </div>
  </div>

  <div class="field-group flex flex--gap-col-s sp-y-s">
    <div class="field-wrapper">
      <label for="user-street">Indirizzo</label>
      <input type="text" name="user-street" id="user-street" value="<?php echo $u_street; ?>" required>
    </div>
    <div class="field-wrapper">
      <label for="user-street-nr">Numero civico</label>
      <input type="text" name="user-street-nr" id="user-street-nr" value="<?php echo $u_street_nr; ?>" required>
    </div>
  </div>

  <div class="field-group flex flex--gap-col-s">
    <div class="field-wrapper">
      <label for="user-country-code">Nazione</label>
      <input type="text" list="list-countries" name="user-country-code" id="user-country-code" autocomplete="off" <?php echo $u_country_code > '' ? 'value="'. $u_country_code .'"' : ''; ?> required>
      <datalist id="list-countries">
        <?php
        $json_countries = file_get_contents('list-countries.json');
        $arr_countries = json_decode($json_countries, true);
        foreach($arr_countries['coutries'] as $key => $val):
          ?>
          <option value="<?php echo $key .' - '. $val; ?>"><?php echo $key .' - '. $val; ?></option>
        <?php endforeach; ?>
      </datalist>
    </div>
    <div class="field-wrapper">
      <label for="user-cap">CAP</label>
      <input type="text" name="user-cap" id="user-cap" size="6" value="<?php echo $u_cap; ?>" required>
    </div>
    <div class="field-wrapper">
      <label for="user-city">Comune</label>
      <input type="text" name="user-city" id="user-city" value="<?php echo $u_city; ?>" required>
    </div>
    <div class="field-wrapper">
      <label for="user-state">Provincia</label>
      <input type="text" list="list-states" name="user-state" id="user-state" minlength="2" maxlength="2" size="4" autocomplete="off" value="<?php echo $u_state; ?>" required>
      <datalist id="list-states">
        <?php
        $json_states = file_get_contents('list-states.json');
        $arr_states = json_decode($json_states, true);
        foreach($arr_states['states'] as $key => $val):
          ?>
          <option value="<?php echo $key; ?>"><?php echo $val .' ('. $key .')'; ?></option>
        <?php endforeach; ?>
      </datalist>
    </div>
  </div>

  <input type="hidden" name="user-country" id="user-country" value="<?php echo $u_country; ?>">

  <div class="field-group flex flex--gap-col-s">
    <div class="field-wrapper">
      <label for="user-vat-number">Partita IVA</label>
      <input type="text" name="user-vat-number" id="user-vat-number" value="<?php echo $u_vat_nr; ?>" required>
    </div>
    <div class="field-wrapper">
      <label for="user-cf">Codice fiscale</label>
      <input type="text" name="user-cf" id="user-cf" minlength="16" maxlength="16" value="<?php echo $u_cf; ?>" required>
    </div>
  </div>

  <h2>Contatto</h2>

  <div class="field-group flex flex--gap-col-s">
    <div class="field-wrapper">
      <label for="user-email">Email</label>
      <input type="email" name="user-email" id="user-email" value="<?php echo $u_email; ?>" required>
    </div>
    <div class="field-wrapper">
      <label for="user-pec">PEC</label>
      <input type="email" name="user-pec" id="user-pec" value="<?php echo $u_pec; ?>">
    </div>
  </div>

  <div class="field-group flex flex--gap-col-s">
    <div class="field-wrapper">
      <label for="user-tel">Telefono (opzionale)</label>
      <input type="tel" name="user-tel" id="user-tel" value="<?php echo $u_tel; ?>">
    </div>
    <div class="field-wrapper">
      <label for="user-web">Sito web (opzionale)</label>
      <input type="text" name="user-web" id="user-web" value="<?php echo $u_web; ?>">
    </div>
  </div>

  <h2>Informazione pagamento</h2>

  <div class="field-wrapper">
    <label for="user-bank-iban">IBAN</label>
    <input type="text" name="user-bank-iban" id="user-bank-iban" minlength="27" maxlength="33" placeholder="IT00 0000 0000 0000 0000 0000 000" value="<?php echo $u_bank_iban; ?>" required>
  </div>

  <div class="field-group flex flex--gap-col-s">
    <div class="field-wrapper">
      <label for="user-bank-bic">BIC</label>
      <input type="text" name="user-bank-bic" id="user-bank-bic" minlength="11" maxlength="11" placeholder="AAAAITBBCCC" value="<?php echo $u_bank_bic; ?>">
    </div>
    <div class="field-wrapper">
      <label for="user-bank-name">Nome della banca</label>
      <input type="text" name="user-bank-name" id="user-bank-name" value="<?php echo $u_bank_name; ?>">
    </div>
  </div>


<?php endif; ?>