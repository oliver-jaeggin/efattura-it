@section('title', 'Modifica fattura')
@extends('layout')

@section('content')
  <h1>@yield('title') No. {{ $invoice->number }}</h1>
  <div>
    <form id="create-invoice" name="create-invoice" action="{{ route('invoices.update', $invoice->id) }}" method="POST">
      @csrf
      @method('PATCH')

      @if ($errors->any())
        <div class="msg msg--error text-code sp-y-s" role="alert">
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif

      <div class="flex flex--pos-x-start flex--gap-col-m sp-y-s">
        <?php
        $selected_doc_type = isset($_GET['doc_type']) ? $_GET['doc_type'] : $invoice->doc_type;
        // get document types from JSON
        $json_document_types = file_get_contents('inc/list-document-types.json');
        $document_types = json_decode($json_document_types, true);
        ?>
        <p><span class="selected_doc_type"><?php echo $document_types['doc_types'][$selected_doc_type]; ?></span></p>
        <p><a href="#dialog-select-doc-type" data-toggle="open" aria-label="dialog" aria-controls="dialog-select-doc-type" title="Cambia tipo di documento">» Cambia tipo di documento</a></p>
        <input type="hidden" name="doc_type" id="doc_type" value="<?php echo $selected_doc_type; ?>">
      </div>


      <div class="field-group flex flex--wrap flex--gap-col-s">
        <div class="field-wrapper flex__grow-2">
          <label for="client_select">Scegli il cliente</label>
          <input type="text" list="list-clients" name="client_select" id="client_select" @error('client_id') class="is-invalid" @enderror autocomplete="off" value="{{ $invoice->client->id }} - {{ $invoice->client->display_name }}" required>
          <datalist id="list-clients">
            @foreach($clients as $client)
              <option value="{{ $client->id }} - {{ $client->display_name }}">
            @endforeach
          </datalist>
          <input type="hidden" name="client_id" id="client_id" value="{{ $invoice->client_id }}">
        </div>
        <a href="/clients/create" class="btn" title="Aggiungere nuovo cliente">Aggiungere nuovo cliente</a>
      </div>
      <div id="invoice-base" class="field-group flex flex--wrap flex--gap-col-s">
        <div class="field-wrapper">
          <label for="number">Nummero della fattura</label>
          <input type="text" id="number" name="number" @error('number') class="is-invalid" @enderror value="{{ $invoice->number }}" placeholder="00/YY" required>
        </div>
        <div class="field-wrapper">
          <label for="date">Data</label>
          <input type="date" id="date" name="date" @error('date') class="is-invalid" @enderror value="{{ \Carbon\Carbon::parse($invoice->date)->format('Y-m-d') }}" required>
        </div>
        <div class="field-wrapper">
          <label for="currency">Divisa</label>
          <div class="flex">
            <input type="text" list="list-currency" id="currency" name="currency" @error('currency') class="is-invalid" @enderror minlength="3" maxlength="3" size="6" value="{{ $invoice->currency }}" autocomplete="off" required>
            <datalist id="list-currency">
              <?php
              $json_currencies = file_get_contents('inc/list-currencies.json');
              $arr_currencies = json_decode($json_currencies, true);
              foreach($arr_currencies['currencies'] as $val):
                ?>
                <option value="<?php echo $val; ?>">
              <?php endforeach; ?>
            </datalist>
          </div>
        </div>
      </div>

      <div id="invoice-items" class="sp-y-m">
        <h2>Servizi e prodotti</h2>
        <div class="invoice-items-list table-wrapper sp-y-s">

          @include('includes/table_items')

        </div>
        <div class="field-group flex flex--wrap flex--gap-row-s flex--gap-col-s sp-y-m">
          <button type="button" class="btn" data-toggle="open" @if(count($invoice->items) > 0) aria-expanded="false" @else aria-expanded="true" @endif aria-label="dialog" aria-controls="dialog-create-item" @if(count($invoice->items) > 0) autofocus @endif title="Aggiungi servizio/prodotto">
            Aggiungi servizio/prodotto
          </button>
          <div class="field-wrapper">
            <label for="subtotal">Imponibile [<span class="prefix-currency"></span>]</label>
            <span class="input-prefix prefix-currency"></span>
            <input type="number" name="subtotal" id="subtotal" @error('subtotal') class="is-invalid" @enderror data-unit="" value="{{ $invoice->subtotal ?? '' }}" readonly tabindex="-1">
          </div>
        </div>
      </div>

      <div id="invoice-summary" hidden>
        <h2>Riassunto fattura</h2>
        <div class="field-group flex flex--gap-col-s sp-y-m">
          <div class="field-wrapper">
            <label for="discount_check" class="flex flex--pos-x-start sp-y-s">
              <input type="checkbox" name="discount_check" id="discount_check" @error('discount_check') class="is-invalid" @enderror @if($invoice->discount !== null || $invoice->discount > 0) checked @endif value="1">
              <p>Sconto</p>
            </label>
          </div>
          <div class="field-wrapper" @if($invoice->discount === null || $invoice->discount === 0) data-state="is-closed" @else data-state="is-opened" @endif>
            <label for="discount">Sconto (opzionale)</label>
            <span class="input-prefix">&nbsp;&nbsp;%</span>
            <input type="number" name="discount" id="discount" @error('discount') class="is-invalid" @enderror data-unit="%" value="{{ $invoice->discount ?? '' }}" tabindex="-1">
            <p class="text-grey">Importo: <span class="invoice-discount-value">Non ancora calcolato</span></p>
          </div>
        </div>

        <div class="field-group flex flex--gap-col-s">
          <div class="field-wrapper">
            <label for="stamp_check" class="flex flex--pos-x-start sp-y-s">
              <input type="checkbox" name="stamp_check" id="stamp_check" @error('stamp_check') class="is-invalid" @enderror value="1" @if($invoice->stamp === null || $invoice->stamp > 0) checked @endif>
              <p>Marca di bollo</p>
            </label>
          </div>
          <div class="field-wrapper" @if($invoice->stamp === null || $invoice->stamp > 0) data-state="is-opened" @else data-state="is-closed" @endif>
            <label for="stamp">Importo bollo [EUR]</label>
            <span class="input-prefix">EUR</span>
            <input type="number" name="stamp" id="stamp" @error('stamp') class="is-invalid" @enderror data-unit="EUR" value="{{ $invoice->stamp ?? '2' }}">
          </div>
        </div>

        <div class="field-group flex flex--gap-col-s">
          <div class="field-wrapper">
            <label for="provision_check" class="flex flex--pos-x-start sp-y-s">
              <input type="checkbox" name="provision_check" id="provision_check" @error('provision_check') class="is-invalid" @enderror value="1" @if($invoice->provision === null || $invoice->provision > 0) checked @endif>
              <p>Cassa previdenziale (INPS)</p>
            </label>
          </div>
          <div class="field-wrapper" @if($invoice->provision === null || $invoice->provision > 0) data-state="is-opened" @else data-state="is-closed" @endif>
            <label for="provision">Aliquota INPS</label>
            <span class="input-prefix">&nbsp;&nbsp;%</span>
            <input type="number" name="provision" id="provision" @error('provision') class="is-invalid" @enderror data-unit="%" value="{{ $invoice->provision ?? '4' }}">
            <p class="text-grey">Importo: <span class="invoice-provision-value">Non ancora calcolato</span></p>
          </div>
        </div>

        <div class="field-group flex flex--gap-col-s flex--pos-y-start">
          <div class="field-wrapper">
            <label for="total">Importo totale [<span class="prefix-currency"></span>]</label>
            <span class="input-prefix prefix-currency"></span>
            <input type="number" name="total" id="total" @error('total') class="is-invalid" @enderror data-unit="" value="{{ $invoice->total ?? '' }}" readonly tabindex="-1">
          </div>
          <div class="field-wrapper">
            <label for="total_rounded">Importo arrotondato [<span class="prefix-currency"></span>]</label>
            <span class="input-prefix prefix-currency"></span>
            <input type="number" name="total_rounded" id="total_rounded" @error('total_rounded') class="is-invalid" @enderror data-unit="" value="{{ $invoice->total_rounded ?? '' }}">
          </div>
        </div>

        <div class="field-group flex no-eur-only sp-y-m" data-visible="false">
          <div class="field-wrapper">
            <label for="exchange_rate">Tasso di cambio <span class="prefix-currency"></span> &gt; EUR</label>
            <input type="number" name="exchange_rate" id="exchange_rate" @error('exchange_rate') class="is-invalid" @enderror step="0.00000001" value="{{ $invoice->exchange_rate ?? '' }}">
            <p><a href="https://www.xe.com/currencyconverter/convert/?Amount=1&From=CHF&To=EUR" target="_blank" title="Apri sito xe.com per calcolare il tasso attuali">Tasso di cambio attuale</a></p>
          </div>
          <div class="field-wrapper">
            <label for="total_eur">Importo totale [EUR]</label>
            <span class="input-prefix">EUR</span>
            <input type="number" name="total_eur" id="total_eur" @error('total_eur') class="is-invalid" @enderror data-unit="eur" value="{{ $invoice->total_eur }}" readonly tabindex="-1">
            <p>&nbsp;</p>
          </div>
        </div>

        <div class="field-group flex flex--gap-col-m flex--pos-x-start">
          <div class="field-wrapper">
            <label for="paid" class="flex flex--pos-x-start sp-y-s">
              <input type="checkbox" name="paid_check" id="paid_check" @error('paid') class="is-invalid" @enderror value="1" @if($invoice->paid == 1) checked @endif>
              <p>Fattura pagato</p>
            </label>
            <input type="hidden" name="paid" id="paid" @if($invoice->paid == '1') value="{{ $invoice->paid }}" @endif>
          </div>
          <div class="field-wrapper">
            <label for="upload_xml" class="flex flex--pos-x-start sp-y-s">
              <input type="checkbox" name="upload_xml_check" id="upload_xml_check" @error('upload_xml') class="is-invalid" @enderror value="1" @if($invoice->upload_xml == 1) checked @endif>
              <p>XML trasmesso</p>
            </label>
            <input type="hidden" name="upload_xml" id="upload_xml" @if($invoice->upload_xml == '1') value="{{ $invoice->upload_xml }}" @endif>
          </div>  
        </div>
        
        <div class="field-group flex flex--wrap flex--gap-row-m flex--pos-x-start flex--gap-col-m">
          <button type="submit" name="invoice-submit" value="invoice-submit" title="Salva fattura">Salva fattura</button>
          <a href="/" class="btn btn--sec-color" title="Ritorna alla bacheca">Ritorna alla bacheca</a>
          <button type="button" class="btn btn--icon-text" onclick="window.calcInvTotals(<?php echo $invoice->subtotal > 0 ? $invoice->subtotal : 0; echo $invoice->discount > 0 ? ', '. $invoice->discount : ', 0'; echo $invoice->provision > 0 ? ', '. $invoice->provision : ', 0'; ?>);" title="Aggiorna valori">
            <span>Aggiorna valori</span>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M8.93996 8.00004L11.8066 5.14004C11.9322 5.01451 12.0027 4.84424 12.0027 4.66671C12.0027 4.48917 11.9322 4.31891 11.8066 4.19338C11.6811 4.06784 11.5108 3.99731 11.3333 3.99731C11.1558 3.99731 10.9855 4.06784 10.86 4.19338L7.99996 7.06004L5.13996 4.19338C5.01442 4.06784 4.84416 3.99731 4.66663 3.99731C4.48909 3.99731 4.31883 4.06784 4.19329 4.19338C4.06776 4.31891 3.99723 4.48917 3.99723 4.66671C3.99723 4.84424 4.06776 5.01451 4.19329 5.14004L7.05996 8.00004L4.19329 10.86C4.13081 10.922 4.08121 10.9958 4.04737 11.077C4.01352 11.1582 3.99609 11.2454 3.99609 11.3334C3.99609 11.4214 4.01352 11.5085 4.04737 11.5898C4.08121 11.671 4.13081 11.7447 4.19329 11.8067C4.25527 11.8692 4.329 11.9188 4.41024 11.9526C4.49148 11.9865 4.57862 12.0039 4.66663 12.0039C4.75463 12.0039 4.84177 11.9865 4.92301 11.9526C5.00425 11.9188 5.07798 11.8692 5.13996 11.8067L7.99996 8.94004L10.86 11.8067C10.9219 11.8692 10.9957 11.9188 11.0769 11.9526C11.1581 11.9865 11.2453 12.0039 11.3333 12.0039C11.4213 12.0039 11.5084 11.9865 11.5897 11.9526C11.6709 11.9188 11.7447 11.8692 11.8066 11.8067C11.8691 11.7447 11.9187 11.671 11.9526 11.5898C11.9864 11.5085 12.0038 11.4214 12.0038 11.3334C12.0038 11.2454 11.9864 11.1582 11.9526 11.077C11.9187 10.9958 11.8691 10.922 11.8066 10.86L8.93996 8.00004Z" fill="currentColor"/>
            </svg>
          </button>
        </div>
      </div>
    </form>

    <!-- Form to add a new item -->
    <dialog id="dialog-create-item" @if(count($invoice->items) <= 0) open @endif>
      <div class="wrapper-input">
        <button type="button" class="btn btn--close" data-toggle="close" aria-label="Close" title="Chiudi (ESC)">
          <span class="sr-only">Chiudi (ESC)</span>
          <div class="l l1" aria-hidden="tdue"></div>
          <div class="l l2" aria-hidden="tdue"></div>
        </button>
      </div>
      <h2>Aggiungi un servizio/prodotto</h2>
      <form id="create-item" action="{{ route('items.store') }}" method="POST">
        @csrf

        @if ($errors->any())
          <div class="msg msg--error text-code sp-y-s" role="alert">
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif

        <input type="hidden" name="invoice_id" id="invoice_id" value="{{ $invoice->id }}">
        <div class="field-wrapper">
          <label for="description">Descrizione prestazione</label>
          <input type="text" id="description" name="description" @error('description') class="is-invalid" @enderror @if(count($invoice->items) <= 0) autofocus @endif required>
        </div>
        <div class="field-group flex flex--gap-col-s">
          <div class="field-wrapper">
            <label for="qty">Quantità</label>
            <input type="number" name="qty" id="qty" @error('qty') class="is-invalid" @enderror step="0.01" required>
          </div>
          <div class="field-wrapper">
            <label for="price">Prezzo</label>
            <span class="input-prefix prefix-currency">{{ $invoice->currency ?? '' }}</span>
            <input type="number" name="price" id="price" @error('price') class="is-invalid" @enderror data-unit="" step="0.01" required>
          </div>
          <div class="field-wrapper">
            <label for="tax">Aliquota IVA</label>
            <span class="input-prefix">&nbsp;&nbsp;%</span>
            <input type="number" list="tax-list" name="tax" id="tax" @error('tax') class="is-invalid" @enderror data-unit="%">
            <datalist id="tax-list">
              <option value="0">
              <option value="4">
              <option value="22">
            </datalist>
          </div>
        </div>
        <div class="field-wrapper sp-y-s">
          <label for="total_item">Importo</label>
          <span class="input-prefix prefix-currency">{{ $invoice->currency ?? '' }}</span>
          <input type="text" name="total_item" id="total_item" @error('total_item') class="is-invalid" @enderror data-unit="" readonly tabindex="-1">
        </div>
        <div class="field-group flex flex--wrap flex--pos-x-start flex--gap-row-m flex--gap-col-m">
          <button type="submit" name="item-submit" id="item-submit" class="btn" title="Salva servizio/prodotto">Salva servizio/prodotto</button>
          <button type="reset" class="btn btn--icon-text" data-toggle="close" title="Annula e chiudi">
            <span>Annula</span>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M8.93996 8.00004L11.8066 5.14004C11.9322 5.01451 12.0027 4.84424 12.0027 4.66671C12.0027 4.48917 11.9322 4.31891 11.8066 4.19338C11.6811 4.06784 11.5108 3.99731 11.3333 3.99731C11.1558 3.99731 10.9855 4.06784 10.86 4.19338L7.99996 7.06004L5.13996 4.19338C5.01442 4.06784 4.84416 3.99731 4.66663 3.99731C4.48909 3.99731 4.31883 4.06784 4.19329 4.19338C4.06776 4.31891 3.99723 4.48917 3.99723 4.66671C3.99723 4.84424 4.06776 5.01451 4.19329 5.14004L7.05996 8.00004L4.19329 10.86C4.13081 10.922 4.08121 10.9958 4.04737 11.077C4.01352 11.1582 3.99609 11.2454 3.99609 11.3334C3.99609 11.4214 4.01352 11.5085 4.04737 11.5898C4.08121 11.671 4.13081 11.7447 4.19329 11.8067C4.25527 11.8692 4.329 11.9188 4.41024 11.9526C4.49148 11.9865 4.57862 12.0039 4.66663 12.0039C4.75463 12.0039 4.84177 11.9865 4.92301 11.9526C5.00425 11.9188 5.07798 11.8692 5.13996 11.8067L7.99996 8.94004L10.86 11.8067C10.9219 11.8692 10.9957 11.9188 11.0769 11.9526C11.1581 11.9865 11.2453 12.0039 11.3333 12.0039C11.4213 12.0039 11.5084 11.9865 11.5897 11.9526C11.6709 11.9188 11.7447 11.8692 11.8066 11.8067C11.8691 11.7447 11.9187 11.671 11.9526 11.5898C11.9864 11.5085 12.0038 11.4214 12.0038 11.3334C12.0038 11.2454 11.9864 11.1582 11.9526 11.077C11.9187 10.9958 11.8691 10.922 11.8066 10.86L8.93996 8.00004Z" fill="currentColor"/>
            </svg>
          </button>
        </div>
      </form>
    </dialog>

    <!-- Change type of document -->
    <dialog id="dialog-select-doc-type">
      <div class="wrapper-input">
        <button type="button" class="btn btn--close" data-toggle="close" aria-label="Close" title="Chiudi (ESC)">
          <span class="sr-only">Chiudi (ESC)</span>
          <div class="l l1" aria-hidden="tdue"></div>
          <div class="l l2" aria-hidden="tdue"></div>
        </button>
      </div>
      <h2>Scegli il tipo di documento</h2>
      <form id="select-doc-type" action="{{ route('invoices.edit', ['invoice' => $invoice]) }}" method="GET">
        @csrf

        @if ($errors->any())
          <div class="msg msg--error text-code sp-y-s" role="alert">
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif


        <div class="field-wrapper sp-y-m">
          <?php
          $i = 0;
          foreach($document_types['doc_types'] as $key => $val):
            $i += 1;
          ?>
            <label <?php echo 'for="doc_type_'. $i .'"'; ?>>
              <input type="radio" name="doc_type" <?php echo 'id="doc_type_'. $i .'"'; ?> value="<?php echo $key; ?>" <?php echo $key === 'TD06' ? 'checked' : ''; ?>>
              <p><?php echo $val .' ('. $key .')'; ?></p>
            </label>
          <?php endforeach; ?>
        </div>

        <div class="field-group flex flex--wrap flex--pos-x-start flex--gap-row-m flex--gap-col-m">
          <button type="submit" name="item-submit" id="item-submit" class="btn" title="Salva e continua">Salva e continua</button>
          <button type="reset" class="btn btn--icon-text" data-toggle="close" title="Annula e chiudi">
            <span>Annula</span>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M8.93996 8.00004L11.8066 5.14004C11.9322 5.01451 12.0027 4.84424 12.0027 4.66671C12.0027 4.48917 11.9322 4.31891 11.8066 4.19338C11.6811 4.06784 11.5108 3.99731 11.3333 3.99731C11.1558 3.99731 10.9855 4.06784 10.86 4.19338L7.99996 7.06004L5.13996 4.19338C5.01442 4.06784 4.84416 3.99731 4.66663 3.99731C4.48909 3.99731 4.31883 4.06784 4.19329 4.19338C4.06776 4.31891 3.99723 4.48917 3.99723 4.66671C3.99723 4.84424 4.06776 5.01451 4.19329 5.14004L7.05996 8.00004L4.19329 10.86C4.13081 10.922 4.08121 10.9958 4.04737 11.077C4.01352 11.1582 3.99609 11.2454 3.99609 11.3334C3.99609 11.4214 4.01352 11.5085 4.04737 11.5898C4.08121 11.671 4.13081 11.7447 4.19329 11.8067C4.25527 11.8692 4.329 11.9188 4.41024 11.9526C4.49148 11.9865 4.57862 12.0039 4.66663 12.0039C4.75463 12.0039 4.84177 11.9865 4.92301 11.9526C5.00425 11.9188 5.07798 11.8692 5.13996 11.8067L7.99996 8.94004L10.86 11.8067C10.9219 11.8692 10.9957 11.9188 11.0769 11.9526C11.1581 11.9865 11.2453 12.0039 11.3333 12.0039C11.4213 12.0039 11.5084 11.9865 11.5897 11.9526C11.6709 11.9188 11.7447 11.8692 11.8066 11.8067C11.8691 11.7447 11.9187 11.671 11.9526 11.5898C11.9864 11.5085 12.0038 11.4214 12.0038 11.3334C12.0038 11.2454 11.9864 11.1582 11.9526 11.077C11.9187 10.9958 11.8691 10.922 11.8066 10.86L8.93996 8.00004Z" fill="currentColor"/>
            </svg>
          </button>
        </div>
      </form>
    </dialog>


    <!-- Dialog to remove an item -->
    <dialog id="dialog-delete-item">
      <div class="wrapper-input">
        <button type="button" class="btn btn--close" data-toggle="close" aria-label="Close" title="Chiudi (ESC)">
          <span class="sr-only">Chiudi (ESC)</span>
          <div class="l l1" aria-hidden="tdue"></div>
          <div class="l l2" aria-hidden="tdue"></div>
        </button>
      </div>
      <p>Cancella servizio/prodotto "<strong><span class="modal-content-name"></span></strong>"?</p>
      <form id="delete-item" name="delete-item" action="#" method="POST">
        @csrf
        @method('DELETE')
        <div class="flex flex--pos-x-start flex--gap-col-m">
          <button type="submit" class="btn" title="Cancella servizio/prodotto">Cancella</button>
          <button type="reset" class="btn btn--icon-text" data-toggle="close" title="Annula e chiudi">
            <span>Annula</span>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M8.93996 8.00004L11.8066 5.14004C11.9322 5.01451 12.0027 4.84424 12.0027 4.66671C12.0027 4.48917 11.9322 4.31891 11.8066 4.19338C11.6811 4.06784 11.5108 3.99731 11.3333 3.99731C11.1558 3.99731 10.9855 4.06784 10.86 4.19338L7.99996 7.06004L5.13996 4.19338C5.01442 4.06784 4.84416 3.99731 4.66663 3.99731C4.48909 3.99731 4.31883 4.06784 4.19329 4.19338C4.06776 4.31891 3.99723 4.48917 3.99723 4.66671C3.99723 4.84424 4.06776 5.01451 4.19329 5.14004L7.05996 8.00004L4.19329 10.86C4.13081 10.922 4.08121 10.9958 4.04737 11.077C4.01352 11.1582 3.99609 11.2454 3.99609 11.3334C3.99609 11.4214 4.01352 11.5085 4.04737 11.5898C4.08121 11.671 4.13081 11.7447 4.19329 11.8067C4.25527 11.8692 4.329 11.9188 4.41024 11.9526C4.49148 11.9865 4.57862 12.0039 4.66663 12.0039C4.75463 12.0039 4.84177 11.9865 4.92301 11.9526C5.00425 11.9188 5.07798 11.8692 5.13996 11.8067L7.99996 8.94004L10.86 11.8067C10.9219 11.8692 10.9957 11.9188 11.0769 11.9526C11.1581 11.9865 11.2453 12.0039 11.3333 12.0039C11.4213 12.0039 11.5084 11.9865 11.5897 11.9526C11.6709 11.9188 11.7447 11.8692 11.8066 11.8067C11.8691 11.7447 11.9187 11.671 11.9526 11.5898C11.9864 11.5085 12.0038 11.4214 12.0038 11.3334C12.0038 11.2454 11.9864 11.1582 11.9526 11.077C11.9187 10.9958 11.8691 10.922 11.8066 10.86L8.93996 8.00004Z" fill="currentColor"/>
            </svg>
          </button>
        </div>
      </form>
    </dialog>

  </div>
@endsection