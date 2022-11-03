@include('templates.define_variables')

<?php
$xml_file = fopen("export-invoice.xml", "w") or die("Unable to open file!");
$xml_header = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
fwrite($xml_file, $xml_header);
ob_start();
?>

  @include('templates.default_xml')

<?php
$xml_content = ob_get_clean();
$arr_umlaut = ['ä', 'ö', 'ü'];
$arr_esc_umlaut = ['ae', 'oe', 'ue'];
$xml_content_esc = str_replace($arr_umlaut, $arr_esc_umlaut, $xml_content);
$xml_content_min = preg_replace('/\>[\s]*\</', '><', $xml_content_esc);
fwrite($xml_file, $xml_content_min);
fclose($xml_file);
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="{{ asset('css/template_default.css') }}" rel="stylesheet">
  @if($invoice->client->template > '')
    <link href="{{ asset('css/template_'. $invoice->client->template .'.css') }}" rel="stylesheet">
  @endif
  

  <title>eFattura - Prevista fattura <?php echo INV_NUMBER; ?></title>
</head>
<body>
  <header class="header">
    <div>
      <nav>
        <a href="/export-invoice.xml" download="<?php echo date('ymd', strtotime(INV_DATE)) .'_'. str_replace(' ', '_', CLIENT_DISPLAY_NAME) .'.xml'; ?>" class="btn" title="Scarica XML">Scarica XML</a>
        <a href="javascript:window.print()" class="btn" title="Stampa PDF">Stampa PDF</a>
        <a href="/" title="Ritorna alla baccheca">Ritorna</a>
      </nav>
    </div>
  </header>
  <div class="content">
    <div class="paper-a4">

      @if($invoice->client->template > '')

        @include('templates.'. $invoice->client->template .'.template')

      @else

        @include('templates.default_pdf')

      @endif
    </div>
  </div>
</body>
</html>