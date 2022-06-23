<?php
include 'inc/db_connect.php';
$id_inv = $_GET['id'];
$exp_type = $_GET['exp_type'];

$sql_user = "SELECT * FROM user";
$res_user = $mysqli->query($sql_user);
if($res_user && $res_user->num_rows > 0) {
  $row_user = $res_user->fetch_array(MYSQLI_ASSOC);
  // set variables for user
  define('USER_COUNTRY_CODE', $row_user['u_country_code']);
  define('USER_VAT_NR', $row_user['u_vat_nr']);
  define('USER_CF', $row_user['u_cf']);
  define('USER_NAME', $row_user['u_name']);
  define('USER_SURNAME', $row_user['u_surname']);
  define('USER_DISPLAY_NAME', $row_user['u_company_name'] > '' ? $row_user['u_company_name'] : $row_user['u_name'] .' '. $row_user['u_surname']);
  define('USER_STREET', $row_user['u_street']);
  define('USER_STREET_NR', $row_user['u_street_nr']);
  define('USER_CAP', $row_user['u_cap']);
  define('USER_CITY', $row_user['u_city']);
  define('USER_STATE', $row_user['u_state']);
  define('USER_POSTAL_ADDRESS', $row_user['u_street'] .' '. $row_user['u_street_nr'] .', '. $row_user['u_cap'] .' '. $row_user['u_city']);
  define('USER_EMAIL', $row_user['u_email']);
  define('USER_PEC', $row_user['u_pec']);
  define('USER_TEL', $row_user['u_tel']);
  define('USER_WEB', $row_user['u_web']);
  define('USER_BANK_IBAN', $row_user['u_bank_iban']);
  define('USER_BANK_BIC', $row_user['u_bank_bic']);
  define('USER_BANK_NAME', $row_user['u_bank_name']);
}

$sql_inv = "SELECT inv.*, c.*, i.*
            FROM invoices AS inv
            INNER JOIN clients AS c ON inv.inv_client_id=c.id_client
            INNER JOIN items AS i ON inv.id_items=i.id_item
            WHERE inv.id_inv=$id_inv";
$res_inv = $mysqli->query($sql_inv);
if($res_inv && $res_inv->num_rows > 0):
  ?>
  <?php
  $row_inv = $res_inv->fetch_array(MYSQLI_ASSOC);
  // set variables for client
  define('CLIENT_COUNTRY_CODE', $row_inv['cl_country_code']);
  define('CLIENT_VAT_NR', $row_inv['cl_vat_nr']);
  define('CLIENT_CF', $row_inv['cl_cf']);
  define('CLIENT_DESTINATION_CODE', $row_inv['cl_destination_code']);
  define('CLIENT_DISPLAY_NAME', $row_inv['cl_display_name']);
  define('CLIENT_STREET', $row_inv['cl_street']);
  define('CLIENT_STREET_NR', $row_inv['cl_street_nr']);
  define('CLIENT_CAP', $row_inv['cl_cap']);
  define('CLIENT_CITY', $row_inv['cl_city']);
  define('CLIENT_STATE', $row_inv['cl_state']);
  define('CLIENT_POSTAL_ADDRESS', $row_inv['cl_street'] .' '. $row_inv['cl_street_nr'] .', '. $row_inv['cl_cap'] .' '. $row_inv['cl_city']);
  define('CLIENT_TEMPLATE', $row_inv['cl_template']);
  
  
  // set variables for invoice
  define('INV_COUNTER', $row_inv['id_inv']);
  define('INV_CURRENCY', $row_inv['inv_currency']);
  define('INV_DATE', $row_inv['inv_date']);
  define('INV_NUMBER', $row_inv['inv_number']);
  define('INV_SUBTOTAL', $row_inv['subtotal']);
  define('INV_STAMP', $row_inv['stamp']);
  define('INV_PROVISION', $row_inv['provision']);
  define('INV_DISCOUNT', $row_inv['discount']);
  define('INV_TOTAL', $row_inv['total']);
  define('INV_TOTAL_ROUNDED', $row_inv['total_rounded']);
  define('INV_EXCHANGE_RATE', $row_inv['exchange_rate']);
  define('INV_TOTAL_EUR', $row_inv['total_eur']);
  
  
  
  $sql_items = "SELECT * FROM items WHERE item_id_inv=$id_inv ORDER BY item_tax";
  $res_items = $mysqli->query($sql_items);
  if($res_items && $res_items->num_rows > 0):
    ?>
    <?php
    $items_query = [];
    $item_query_per_tax = [];
    while($row_items = $res_items->fetch_array(MYSQLI_ASSOC)) {
      $items_query[] = $row_items;
      $item_query_per_tax[$row_items['item_tax']] += $row_items['item_total'];
    }
    define('ITEMS_QUERY', $items_query);
    define('ITEMS_QUERY_TOTAL', $item_query_per_tax);
    
    if($exp_type == 'xml'):
      ?>
      <?php
      $xml_file = fopen("export-invoice.xml", "w") or die("Unable to open file!");
      $xml_header = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
      fwrite($xml_file, $xml_header);
      ob_start();

      include 'templates/template-default-xml.php';

      $xml_content = ob_get_clean();
      $arr_umlaut = ['ä', 'ö', 'ü'];
      $arr_esc_umlaut = ['ae', 'oe', 'ue'];
      $xml_content_esc = str_replace($arr_umlaut, $arr_esc_umlaut, $xml_content);
      $xml_content_min = preg_replace('/\>[\s]*\</', '><', $xml_content_esc);
      fwrite($xml_file, $xml_content_min);
      fclose($xml_file);
      ?>
      <?php include 'header.php'; ?>
        <section class="content">
          <h1>Download fattura in XML</h1>
          <p class="sp-y-l">XML della fattura <strong><?php echo INV_NUMBER; ?></strong> è stato generato con successo.</p>
          <div class="flex flex--pos-x-start flex--gap-col-m sp-y-m">
            <a href="export-invoice.xml" download="<?php echo date('ymd', strtotime(INV_DATE)) .'_'. str_replace(' ', '_', CLIENT_DISPLAY_NAME) .'.xml'; ?>" class="btn">Scarica XML</a>
            <a href="index.php" class="btn btn--sec-color">Ritorna</a>
          </div>
        </section>
      <?php include 'footer.php'; ?>
    <?php elseif($exp_type == 'pdf'): ?>
      <?php
      if(CLIENT_TEMPLATE != '') {
        $path_template = 'templates/'. CLIENT_TEMPLATE .'/template.php';
      }
      else {
        $path_template = 'templates/template-default-pdf.php';
      }
      include $path_template;
      ?>
    <?php else: ?>
      <div class="msg">
        <p>Non è definito un formato valido per l'esportazione!</p>
      </div>
    <?php endif; ?>
  <?php else: ?>
    <div class="msg">
      <p>Errore durante l'esportazione della fattura. La fattura non contiene un prodotto o servizio!</p>
    </div>
  <?php endif; ?>
<?php else: ?>
  <div class="msg">
    <p>Errore durante l'esportazione della fattura. La fattura richiesta non è stato trovato!</p>
  </div>
<?php endif; ?>