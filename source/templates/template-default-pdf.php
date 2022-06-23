<!DOCTYPE html>
<html lang="de-CH">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="templates/style.css">

  <title>eFattura - Prevista fattura <?php echo INV_NUMBER; ?></title>
</head>
<body>
  
<a href="index.php" class="btn">Ritorna</a>
<div class="content">
  <div class="sender sp-y-s">
    <p class="sender__postal-address">
      <?php echo USER_DISPLAY_NAME .'<br>'. USER_STREET .', '. USER_STREET_NR .'<br>'. USER_CAP .' '. USER_CITY .'('. USER_STATE .')'; ?>
    </p>
    <p class="sender__contact">
      <?php echo USER_TEL .'<br>'. USER_EMAIL; ?>
    </p>
    <div class="sender__tax-number flex flex--pos-x-start">
      <p class="col2">
        Partita IVA:<br>
        Codice Fiscale:
      </p>
      <p>
        <?php echo USER_VAT_NR .'<br>'. USER_CF; ?>
      </p>
    </div>
  </div>
  <div class="recipient sp-y-s">
    <p class="recipient__postal-address">
      <strong><?php echo CLIENT_DISPLAY_NAME; ?></strong><br>
      <?php echo CLIENT_STREET .' '. CLIENT_STREET_NR; ?><br>
      <?php echo CLIENT_COUNTRY_CODE .' - '. CLIENT_CAP .' '. CLIENT_CITY; ?>
    </p>
    <p class="recipient__tax-number">
      C.F.: <?php echo CLIENT_CF; ?><br>
      P.IVA: <?php echo CLIENT_VAT_NR; ?>
    </p>
  </div>
  <div class="invoice">
    <div class="invoice__date flex flex--pos-x-start">
      <p class="col2">
        Data:
      </p>
      <p>
        <?php echo date('d.m.Y', strtotime(INV_DATE)); ?>
      </p>
    </div>
    <div class="invoice__number flex flex--pos-x-start sp-y-s">
      <p class="col2">
      Fattura:
      </p>
      <p>
        <?php echo INV_NUMBER; ?>
      </p>
    </div>
    <div class="invoice__content">
      <h1>Fattura</h1>
      <table class="table sp-y-m">
        <thead>
          <tr>
            <th colspan="2" align="left">Descrizione prestazione</th>
            <th align="right">Importo</th>
          </tr>
        </thead>
        <tbody>
          <!-- list of items -->
          <?php
          $multiple_tax = count(ITEMS_QUERY_TOTAL) > 1 ? 'true' : 'false';
          $i = 0;
          while($i < count(ITEMS_QUERY)):
            $i = $i + 1;
            $item_query = ITEMS_QUERY[$i-1];
            ?>
            <tr>
              <td <?php echo $multiple_tax == 'false' ? 'colspan="2"' : '';?>><?php echo $item_query['item_description']; ?></td>
              <?php echo $multiple_tax == 'true' ? '<td>'. $item_query['item_tax'] .'%</td>' : '';?>
              <td align="right"><?php echo INV_CURRENCY .' '. number_format($item_query['item_total'], 2, '.', ''); ?></td>
            </tr>
          <?php endwhile; ?>
          <tr class="sp-row-1">
            <td colspan="2">Imponibile</td>
            <td align="right" class="border-bottom"><?php echo INV_CURRENCY .' '. number_format(INV_SUBTOTAL, 2, '.', ''); ?></td>
          </tr>
          <?php if(INV_PROVISION > 0): ?>
            <tr class="sp-row-05">
              <td>Rivalsa INPS</td>
              <td><?php echo INV_PROVISION .'%'; ?></td>
              <td align="right"><?php echo INV_CURRENCY .' '. number_format((INV_SUBTOTAL / 100 * INV_PROVISION), 2, '.', ''); ?></td>
            </tr>
          <?php endif; ?>
          <?php foreach(ITEMS_QUERY_TOTAL as $key => $val): ?>
            <?php if($key > 0): ?>
              <?php
              if(INV_PROVISION > '') {
                $val_provision = $val / 100 * INV_PROVISION;
              }
              else {
                $val_provision = $val;
              }
              ?>              
              <tr class="sp-row-05">
                <td>Imposta</td>
                <td><?php echo $key .'%'; ?></td>
                <td align="right"><?php echo INV_CURRENCY .' '. number_format((($val + $val_provision) / 100 * $key), 2, '.', ''); ?></td>
              </tr>
            <?php endif; ?>
          <?php endforeach; ?>
          <?php if(INV_DISCOUNT > 0): ?>
            <tr class="sp-row-05">
              <td>Sconto</td>
              <td><?php echo INV_DISCOUNT .'%'; ?></td>
              <td align="right"><?php echo INV_CURRENCY .' '. number_format(((INV_SUBTOTAL + (INV_SUBTOTAL / 100 * INV_PROVISION))  / 100 * INV_DISCOUNT), 2, '.', ''); ?></td>
            </tr>
          <?php endif; ?>
          <tr class="sp-row-05">
            <td colspan="2"><strong>L'importo totale</strong></td>
            <td align="right" class="border-bottom-double"><strong><?php echo INV_CURRENCY .' '. number_format(INV_TOTAL_ROUNDED, 0, '.', ''); ?></strong></td>
          </tr>
        </tbody>
      </table>

      <?php if(USER_BANK_IBAN > ''): ?>
        <div class="invoice__payment sp-y-m">
          <p>Bonifico bancario su IBAN: <?php echo USER_BANK_IBAN; ?> (<?php echo USER_BANK_NAME; ?>)</p>
        </div>
      <?php endif; ?>

      <div class="invoice__regime">
        <div class="msg msg--grey">
          <p class="text-center">Operazione in franchigia da Iva art. 1 cc. 54-89 L. 190/2014 – Non soggetta a ritenuta d&apos;acconto ai sensi del c. 67 L. 190/2014</p>
        </div>
      </div>
    </div>
  </div>
  <footer class="flex">
    <p class="text-grey text-small"><?php echo USER_DISPLAY_NAME .' // '. USER_STREET .', '. USER_STREET_NR .' // '. USER_CAP .' '. USER_CITY .' // '. USER_TEL .' // '. USER_EMAIL .' // '. USER_WEB; ?></p>
    <p><span data-page="cur">1</span>/<span data-page="total">1</span></p>
  </footer>
</div>
</body>
</html>