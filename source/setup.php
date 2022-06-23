<?php
$title = 'Setup eFattura';
$description = '';
$slug = 'setup';
include 'header.php';

file_exists('inc/db_connect.php') ? include 'inc/db_connect.php' : '';

// check if database credentials are submitet
if(isset($_POST['db-submit'])) {
  $setup_state = '1';
}
// check if database credentials are already present
else if(defined('DB_NAME')) {
  include 'inc/db_setup.php';
  
  $sql_check = "SELECT * FROM user";
  $res_check = $mysqli->query($sql_check);

  // check if user data are already present
  if($res_check && $res_check->num_rows > 0) {
    $row_check = $res_check->fetch_array(MYSQLI_ASSOC);
    $setup_state = '4';
  }
  else if(isset($_POST['user-submit'])) {
    $setup_state = '3';
  }
  else {
    $setup_state = '2';
  }
}
else {
  $setup_state = isset($_GET['s']) ? $_GET['s'] : '0';
}
?>

<section>
  <div class="content gid">
    <h1>Setup e<em>Fattura</em></h1>
    <?php if($setup_state === '0'): ?>
      <!-- add database credentials and connect to db -->
      <h2>Credenziali database</h2>
      <p>Crea un nuovo database MySQL sul server e compila questa formulario con le credenziali del database.</p>
      <form action="#" method="POST">
        <div class="field-group flex flex--gap-col-s">
          <div class="field-wrapper">
            <label for="db-name">Nome del database</label>
            <input type="text" name="db-name" id="db-name" maxlength="100" required>
          </div>
          <div class="field-wrapper">
            <label for="db-user">Utente del database</label>
            <input type="text" name="db-user" id="db-user" maxlength="100" required>
          </div>
        </div>

        <div class="field-group flex flex--gap-col-s">
          <div class="field-wrapper">
            <label for="db-psw">Password del database</label>
            <input type="text" name="db-psw" id="db-psw" maxlength="100" required>
          </div>
          <div class="field-wrapper">
            <label for="db-host">Hostname del database</label>
            <input type="text" name="db-host" id="db-host" maxlength="100" value="localhost" required>
          </div>
        </div>

        <div class="field-group flex flex--pos-x-start flex--gap-col-m">
          <button type="submit" name="db-submit" value="db-submit">Salva e verifica connessione database</button>
        </div>            

      </form>

    <?php elseif($setup_state === '1'): ?>
      <?php
      // verifiy database credentials
      $db_name = isset($_POST['db-name']) ? addslashes($_POST['db-name']) : '';
      $db_user = isset($_POST['db-user']) ? addslashes($_POST['db-user']) : '';
      $db_psw = isset($_POST['db-psw']) ? addslashes($_POST['db-psw']) : '';
      $db_host = isset($_POST['db-host']) ? addslashes($_POST['db-host']) : 'localhost';

      if($db_name && $db_user && $db_psw) {
        $mysqli_test = new mysqli($db_host, $db_user, $db_psw, $db_name);

        if($mysqli_test->errno) {
          $con_db = false;
          $msg = 'Errore di connessione al DB:'. $mysqli_test->error;
          exit();
        }
        else {
          $mysqli_test->set_charset('utf8');
          $con_db = true;
          $msg = 'Connesso al database con successo.';

          $file_db_connect = __DIR__ .'/inc/db_connect.php';
          $handle = fopen($file_db_connect, 'a');
          $data = 
            "<?php\n// definition of database credentials\ndefine('DB_NAME', '". $db_name ."');\ndefine('DB_USER', '". $db_user ."');\ndefine('DB_PASS', '". $db_psw ."');\ndefine('DB_HOST', '". $db_host ."');\n\n";
          fwrite($handle, $data);
          $data = "// create database connection\n" . '$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);' . "\n// verify if connection to database works\n" . 'if($mysqli->errno) {echo "Errore di connessione al DB:". $mysqli->error;exit();' . "\n}\nelse {" . '$mysqli->set_charset("utf8");}';
          fwrite($handle, $data);
        }  
      }
      ?>
      <h2>Verifica accesso al database</h2>
      <p class="sp-y-s"><?php echo $msg; ?></p>
      <?php if($con_db == true): ?>
        <a href="<?php echo 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] .'?s=2'; ?>" class="btn sp-y-l">Crea il tuo profilo</a>
      <?php else: ?>
        <p>Controlla manualmente se le credenziali dentro <code>/inc/db_connect.php</code> sono corretti e verifica da nuovo.</p>
        <a href="<?php echo 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] .'?s=1'; ?>" class="btn sp-y-l">Verifica connessione database</a>
      <?php endif; ?>

    <?php elseif($setup_state === '2'): ?>
      <!-- insert user data -->
      <h2>I tuoi dati</h2>
      <p>Compila il formulario con i tuoi dati che vengono usati per le fatture.</p>
      <form id="create-user" name="create-user" action="#" method="POST">

        <?php include 'view/form-create-user.php'; ?>

        <div class="field-group flex flex--pos-x-start flex--gap-col-m">
          <button type="submit" name="user-submit" value="user-submit">Salva i tuoi dati e continua</button>
        </div>            
      </form>

    <?php elseif($setup_state === '3'): ?>
      <?php
      // write user data to database and finish setup
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
        $query = $mysqli->prepare("INSERT INTO user (username, psw, u_country_code, u_country, u_state, u_cap, u_city, u_street, u_street_nr, u_vat_nr, u_cf, u_company_name, u_name, u_surname, u_email, u_pec, u_tel, u_web) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param('ssssssssssssssssss', $u_username, $u_psw, $u_country_code, $u_country, $u_state, $u_cap, $u_city, $u_street, $u_street_nr, $u_vat_nr, $u_cf, $u_company_name, $u_name, $u_surname, $u_email, $u_pec, $u_tel, $u_web);
        $res_w_u = $query->execute();
        if($res_w_u){
          $msg_success = 'Aggiunto il cliente con successo.';
        }
        else {
          $msg_error = $mysqli->error;
        }
      }
      ?>
      <h2>Salvare i tuoi dati</h2>
      <div class="msg msg-<?php echo $msg_success > '' ? 'success' : 'error'; ?> sp-y-s">
        <p><?php echo $msg_success . $msg_error; ?></p>
      </div>
      <div class="flex sp-y-m">
        <a href="index.php" class="btn sp-y-l">Ritorna alla bacheca</a>
      </div>

    <?php elseif($setup_state === '4'): ?>
      <!-- notification if setup is already completed -->
      <h2>Congratullazione🎉</h2>
      <p>Il tuo eFattura è stata già installato con successo.</p>
      <a href="details-user.php" class="btn sp-y-l">Cambia i tuoi dati</a>
    <?php endif; ?>

  </div>
</section>

<?php include 'footer.php'; ?>