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
          <IdPaese><?php echo USER_COUNTRY_CODE; ?></IdPaese>
          <IdCodice><?php echo USER_VAT_NR; ?></IdCodice>
        </IdFiscaleIVA>
        <CodiceFiscale><?php echo USER_CF; ?></CodiceFiscale>
        <Anagrafica>
          <Nome><?php echo USER_NAME; ?></Nome>
          <Cognome><?php echo USER_SURNAME; ?></Cognome>
        </Anagrafica>
        <RegimeFiscale>RF19</RegimeFiscale>
      </DatiAnagrafici>
      <Sede>
        <Indirizzo><?php echo USER_STREET; ?></Indirizzo>
        <NumeroCivico><?php echo USER_STREET_NR; ?></NumeroCivico>
        <CAP><?php echo USER_CAP; ?></CAP>
        <Comune><?php echo USER_CITY;?></Comune>
        <Provincia><?php echo USER_STATE;?></Provincia>
        <Nazione><?php echo USER_COUNTRY_CODE;?></Nazione>
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
        <TipoDocumento><?php echo INV_DOC_TYPE; ?></TipoDocumento>
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
      $multiple_tax = count(ITEMS_QUERY_TOTAL) > 1 ? 'true' : 'false';
      $i = 0;
      ?>
      @foreach($invoice->items as $item)
        <?php $i =+ 1; ?>
        <DettaglioLinee>
          <NumeroLinea><?php echo $i; ?></NumeroLinea>
          <Descrizione>{{ $item->description }}</Descrizione>
          @if($item->qty > 1) <Quantita>{{ $item->qty }}</Quantita> @endif
          <PrezzoUnitario>{{ number_format($item->price, 2, '.', '') }}</PrezzoUnitario>
          <PrezzoTotale>{{ number_format($item->total_item, 2, '.', '') }}</PrezzoTotale>
          <AliquotaIVA>{{ number_format($item->tax, 2, '.', '') }}</AliquotaIVA>
          <?php echo $item->tax <= 0 ? '<Natura>N2.2</Natura>' : ''; ?>
        </DettaglioLinee>
      @endforeach

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
        <?php if(USER_BANK_IBAN > '' && INV_DOC_TYPE !== 'TD04'): ?>
          <IstitutoFinanziario><?php echo USER_BANK_NAME; ?></IstitutoFinanziario>
          <IBAN><?php echo str_replace(' ', '', USER_BANK_IBAN); ?></IBAN>
          <BIC><?php echo USER_BANK_BIC; ?></BIC>
        <?php endif; ?>
      </DettaglioPagamento>
    </DatiPagamento>
  </FatturaElettronicaBody>
</ns2:FatturaElettronica>