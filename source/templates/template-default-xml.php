<ns2:FatturaElettronica versione="FPR12" xmlns:ns2="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2">
  <FatturaElettronicaHeader>
    <!-- parte profilo -->
    <DatiTrasmissione>
      <IdTrasmittente>
        <IdPaese><?php echo USER_COUNTRY_CODE; ?></IdPaese>
        <IdCodice><?php echo USER_CF; ?></IdCodice>
      </IdTrasmittente>
      <!-- database id as continius counter -->
      <ProgressivoInvio><?php echo INV_COUNTER; ?></ProgressivoInvio>
      <FormatoTrasmissione>FPR12</FormatoTrasmissione>
      <?php
      if(CLIENT_COUNTRY_CODE == 'IT') {
        $calc_destination_code = CLIENT_DESTINATION_CODE > '' ? CLIENT_DESTINATION_CODE : '0000000';
      }
      else {
        $calc_destination_code = 'XXXXXXX';
      }
      ?>
      <CodiceDestinatario><?php echo $calc_destination_code; ?></CodiceDestinatario>
    </DatiTrasmissione>
    <CedentePrestatore>
      <DatiAnagrafici>
        <IdFiscaleIVA>
          <IdPaese>IT</IdPaese>
          <IdCodice>04313230247</IdCodice>
        </IdFiscaleIVA>
        <CodiceFiscale>JGGLRD83M27Z133C</CodiceFiscale>
        <Anagrafica>
          <Nome>Oliver Adrian</Nome>
          <Cognome>Jaeggin</Cognome>
        </Anagrafica>
        <RegimeFiscale>RF19</RegimeFiscale>
      </DatiAnagrafici>
      <Sede>
        <Indirizzo>via Raffaele Cadorna</Indirizzo>
        <NumeroCivico>15</NumeroCivico>
        <CAP>36100</CAP>
        <Comune>Vicenza</Comune>
        <Provincia>VI</Provincia>
        <Nazione>IT</Nazione>
      </Sede>
    </CedentePrestatore>
    <!-- parte cliente -->
    <CessionarioCommittente>
      <DatiAnagrafici>
        <IdFiscaleIVA>
          <IdPaese><?php echo CLIENT_COUNTRY_CODE == 'IT' ? CLIENT_COUNTRY_CODE : 'EE'; ?></IdPaese>
          <IdCodice><?php echo CLIENT_COUNTRY_CODE == 'IT' ? CLIENT_VAT_NR : '99999999999'; ?></IdCodice>
        </IdFiscaleIVA>
        <?php echo CLIENT_CF > '' ? '<CodiceFiscale>'. CLIENT_CF .'</CodiceFiscale>' : ''; ?>
        <Anagrafica>
          <Denominazione><?php echo CLIENT_DISPLAY_NAME; ?></Denominazione>
        </Anagrafica>
      </DatiAnagrafici>
      <Sede>
        <Indirizzo><?php echo CLIENT_COUNTRY_CODE == 'IT' ? CLIENT_STREET : CLIENT_POSTAL_ADDRESS; ?></Indirizzo>
        <?php echo CLIENT_COUNTRY_CODE == 'IT' ? '<NumeroCivico>'. CLIENT_STREET_NR .'</NumeroCivico>' : ''; ?>
        <CAP><?php echo CLIENT_COUNTRY_CODE == 'IT' ? CLIENT_CAP : '00000'; ?></CAP>
        <Comune><?php echo CLIENT_CITY; ?></Comune>
        <?php echo CLIENT_COUNTRY_CODE == 'IT' ? '<Provincia>'. CLIENT_STATE .'</Provincia>' : ''; ?>
        <Nazione><?php echo CLIENT_COUNTRY_CODE; ?></Nazione>
      </Sede>
    </CessionarioCommittente>
  </FatturaElettronicaHeader>
  <!-- dati fattura -->
  <FatturaElettronicaBody>
    <DatiGenerali>
      <DatiGeneraliDocumento>
        <TipoDocumento>TD06</TipoDocumento>
        <Divisa><?php echo INV_CURRENCY; ?></Divisa>
        <Data><?php echo INV_DATE; ?></Data>
        <Numero><?php echo INV_NUMBER; ?></Numero>
        <?php if(INV_STAMP > ''): ?>
          <DatiBollo>
            <BolloVirtuale>SI</BolloVirtuale>
            <ImportoBollo><?php echo number_format(INV_STAMP, 2, '.', ''); ?></ImportoBollo>
          </DatiBollo>
        <?php endif; ?>
        <?php if(INV_PROVISION > ''): ?>
          <?php foreach(ITEMS_QUERY_TOTAL as $key => $val): ?>
            <DatiCassaPrevidenziale>
              <TipoCassa>TC22</TipoCassa>
              <AlCassa><?php echo number_format(INV_PROVISION, 2, '.', ''); ?></AlCassa>
              <ImportoContributoCassa><?php echo number_format(($val / 100 * INV_PROVISION), 2, '.', ''); ?></ImportoContributoCassa>
              <AliquotaIVA><?php echo number_format($key, 2, '.', ''); ?></AliquotaIVA>
              <Natura>N2.2</Natura>
            </DatiCassaPrevidenziale>
          <?php endforeach; ?>
        <?php endif; ?>
        <ImportoTotaleDocumento><?php echo number_format(INV_TOTAL, 2, '.', ''); ?></ImportoTotaleDocumento>
        <Arrotondamento><?php echo number_format(INV_TOTAL_ROUNDED, 2, '.', ''); ?></Arrotondamento>
      </DatiGeneraliDocumento>
    </DatiGenerali>
    <DatiBeniServizi>
      <!-- list of items -->
      <?php
      $i = 0;
      while($i < count(ITEMS_QUERY)):
        $i = $i + 1;
        $item_query = ITEMS_QUERY[$i-1];
        ?>
        <DettaglioLinee>
          <NumeroLinea><?php echo $i; ?></NumeroLinea>
          <Descrizione><?php echo $item_query['item_description']; ?></Descrizione>
          <Quantita><?php echo number_format($item_query['item_qty'], 2, '.', ''); ?></Quantita>
          <PrezzoUnitario><?php echo number_format($item_query['item_price'], 2, '.', ''); ?></PrezzoUnitario>
          <PrezzoTotale><?php echo number_format($item_query['item_total'], 2, '.', ''); ?></PrezzoTotale>
          <AliquotaIVA><?php echo number_format($item_query['item_tax'], 2, '.', ''); ?></AliquotaIVA>
          <?php echo $item_query['item_tax'] <= 0 ? '<Natura>N2.2</Natura>' : ''; ?>
        </DettaglioLinee>
      <?php endwhile; ?>
      <!-- the total for every tax value -->
      <?php foreach(ITEMS_QUERY_TOTAL as $key => $val): ?>
        <DatiRiepilogo>
          <AliquotaIVA><?php echo number_format($key, 2, '.', ''); ?></AliquotaIVA>
          <?php
          echo $key <= 0 ? '<Natura>N2.2</Natura>' : '';
          if(INV_PROVISION > '') {
            $val_provision = $val / 100 * INV_PROVISION;
          }
          else {
            $val_provision = $val;
          }
          ?>
          <ImponibileImporto><?php echo number_format(($val + $val_provision), 2, '.', ''); ?></ImponibileImporto>
          <Imposta><?php echo number_format((($val + $val_provision) / 100 * $key), 2, '.', ''); ?></Imposta>
        </DatiRiepilogo>
      <?php endforeach; ?>
    </DatiBeniServizi>
    <DatiPagamento>
      <CondizioniPagamento>TP02</CondizioniPagamento>
      <DettaglioPagamento>
        <ModalitaPagamento>MP05</ModalitaPagamento>
        <DataRiferimentoTerminiPagamento><?php echo INV_DATE; ?></DataRiferimentoTerminiPagamento>
        <ImportoPagamento><?php echo number_format(INV_TOTAL_ROUNDED, 2, '.', ''); ?></ImportoPagamento>
        <IstitutoFinanziario>Banca popolare etica</IstitutoFinanziario>
        <IBAN>IT34P0501811800000017081209</IBAN>
        <BIC>CCRTIT2T84A</BIC>
      </DettaglioPagamento>
    </DatiPagamento>
  </FatturaElettronicaBody>
</ns2:FatturaElettronica>