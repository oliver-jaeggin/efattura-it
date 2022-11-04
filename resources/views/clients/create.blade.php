@section('title', 'Aggiungi un nuovo cliente')
@extends('layout')

@section('content')
  <h1>@yield('title')</h1>
  <div>
  <form id="create-client" name="create-client" action="{{ route('clients.store') }}" method="POST">
    @csrf

    @if ($errors->any())
      <div class="msg msg--error text-code sp-y-s" role="alert">
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <div class="field-group flex flex--gap-col-s">
      <div class="field-wrapper">
        <label for="destination_code">Codice destinatario (opzionale)</label>
        <input type="number" name="destination_code" id="destination_code" @error('destination_code') class="is-invalid" @enderror maxlength="7" value="{{ old('destination_code') }}" autofocus>
      </div>
      <div class="field-wrapper">
        <label for="company_name">Denominazione</label>
        <input type="text" name="company_name" id="company_name" class="input-client-name @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}">
      </div>
    </div>

    <div class="field-group flex flex--gap-col-s">
      <div class="field-wrapper">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" class="input-client-name @error('name') is-invalid @enderror" value="{{ old('name') }}">
      </div>
      <div class="field-wrapper">
        <label for="surname">Cognome</label>
        <input type="text" name="surname" id="surname" class="input-client-name @error('surname') is-invalid @enderror" value="{{ old('surname') }}">
      </div>
    </div>

    <input type="hidden" name="display_name" id="display_name" value="{{ old('display_name') }}">

    <div class="field-group flex flex--gap-col-s">
      <div class="field-wrapper">
        <label for="street">Indirizzo</label>
        <input type="text" name="street" id="street" @error('street') class="is-invalid" @enderror value="{{ old('street') }}" required>
      </div>
      <div class="field-wrapper">
        <label for="street_nr">Numero civico</label>
        <input type="text" name="street_nr" id="street_nr" @error('street_nr') class="is-invalid" @enderror value="{{ old('street_nr') }}" required>
      </div>
    </div>

    <div class="field-group flex flex--gap-col-s">
      <div class="field-wrapper">
        <label for="country_select">Nazione</label>
        <input type="text" list="list-countries" name="country_select" id="country_select" @error('country_code', 'country') class="is-invalid" @enderror value="{{ old('country_select') ?? 'IT - Italia'}}" placeholder="IT - Italia" autocomplete="off" required>
        <datalist id="list-countries">
          <?php
          $json_countries = file_get_contents('inc/list-countries.json');
          $arr_countries = json_decode($json_countries, true);
          foreach($arr_countries['countries'] as $key => $val):
            ?>
            <option value="<?php echo $key .' - '. $val; ?>"><?php echo $key .' - '. $val; ?></option>
          <?php endforeach; ?>
        </datalist>
        <input type="hidden" name="country_code" id="country_code" value="{{ old('country_code') }}">
        <input type="hidden" name="country" id="country" value="{{ old('country') }}">
      </div>
      <div class="field-wrapper">
        <label for="cap">CAP</label>
        <input type="text" name="cap" id="cap" @error('cap') class="is-invalid" @enderror size="6"  value="{{ old('cap') }}" required>
      </div>
      <div class="field-wrapper">
        <label for="city">Comune</label>
        <input type="text" name="city" id="city" @error('city') class="is-invalid" @enderror value="{{ old('city') }}" required>
      </div>
      <div class="field-wrapper" data-state="is-opened">
        <label for="state">Provincia</label>
        <input type="text" list="list-states" name="state" id="state" @error('state') class="is-invalid" minlength="2" maxlength="2" size="4" @enderror value="{{ old('state') }}" placeholder="AA" autocomplete="off">
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

    <div class="field-group flex flex--gap-col-s">
      <div class="field-wrapper">
        <label for="vat_nr">Partita IVA</label>
        <input type="text" name="vat_nr" id="vat_nr" @error('vat_nr') class="is-invalid" @enderror minlength="11" maxlength="11" value="{{ old('vat_nr') }}">
      </div>
      <div class="field-wrapper" data-state="is-opened">
        <label for="cf">Codice fiscale</label>
        <input type="text" name="cf" id="cf" @error('cf') class="is-invalid" minlength="16" maxlength="16" @enderror value="{{ old('cf') }}">
      </div>
    </div>

    <div class="field-group flex flex--gap-col-s">
      <div class="field-wrapper">
        <label for="email">Email (opzionale)</label>
        <input type="email" name="email" id="email" @error('email') class="is-invalid" @enderror value="{{ old('email') }}">
      </div>
      <div class="field-wrapper" data-state="is-opened">
        <label for="pec">PEC (opzionale)</label>
        <input type="email" name="pec" id="pec" @error('pec') class="is-invalid" @enderror value="{{ old('pec') }}">
      </div>
    </div>

    <div class="field-wrapper sp-y-m">
      <label for="template">Modello della fattura (opzionale)</label>
      <input type="text" list="list-templates" name="template" id="template" @error('template') class="is-invalid" @enderror value="{{ old('template') }}" title="Scrivi il nome della sotto cartella dove se trovi il template">
      <datalist id="list-templates">
        <?php
        //$dir_templates = scandir('../templates');
        //$arr_templates = [];
        //foreach($dir_templates as $val):
          ?>
          <?php //if(str_contains($val, '.') == false): ?>
            <option value="<?php //echo $val; ?>"><?php //echo $val; ?></option>
          <?php //endif; ?>
        <?php //endforeach; ?>
      </datalist>
    </div>
          
    <div class="field-group flex flex--wrap flex--pos-x-start flex--gap-row-m flex--gap-col-m">
      <button type="submit" name="submit" class="btn" value="submit" title="Salva e aggiungi il cliente">Salva e aggiungi il cliente</button>
      <button type="reset" class="btn btn--icon-text" onclick="window.location.href='<?php echo 'http:/'.'/'. $_SERVER['HTTP_HOST'] . '/'; ?>';" title="Annula e ritorna alla baccheca">
        <span>Annula</span>
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8.93996 8.00004L11.8066 5.14004C11.9322 5.01451 12.0027 4.84424 12.0027 4.66671C12.0027 4.48917 11.9322 4.31891 11.8066 4.19338C11.6811 4.06784 11.5108 3.99731 11.3333 3.99731C11.1558 3.99731 10.9855 4.06784 10.86 4.19338L7.99996 7.06004L5.13996 4.19338C5.01442 4.06784 4.84416 3.99731 4.66663 3.99731C4.48909 3.99731 4.31883 4.06784 4.19329 4.19338C4.06776 4.31891 3.99723 4.48917 3.99723 4.66671C3.99723 4.84424 4.06776 5.01451 4.19329 5.14004L7.05996 8.00004L4.19329 10.86C4.13081 10.922 4.08121 10.9958 4.04737 11.077C4.01352 11.1582 3.99609 11.2454 3.99609 11.3334C3.99609 11.4214 4.01352 11.5085 4.04737 11.5898C4.08121 11.671 4.13081 11.7447 4.19329 11.8067C4.25527 11.8692 4.329 11.9188 4.41024 11.9526C4.49148 11.9865 4.57862 12.0039 4.66663 12.0039C4.75463 12.0039 4.84177 11.9865 4.92301 11.9526C5.00425 11.9188 5.07798 11.8692 5.13996 11.8067L7.99996 8.94004L10.86 11.8067C10.9219 11.8692 10.9957 11.9188 11.0769 11.9526C11.1581 11.9865 11.2453 12.0039 11.3333 12.0039C11.4213 12.0039 11.5084 11.9865 11.5897 11.9526C11.6709 11.9188 11.7447 11.8692 11.8066 11.8067C11.8691 11.7447 11.9187 11.671 11.9526 11.5898C11.9864 11.5085 12.0038 11.4214 12.0038 11.3334C12.0038 11.2454 11.9864 11.1582 11.9526 11.077C11.9187 10.9958 11.8691 10.922 11.8066 10.86L8.93996 8.00004Z" fill="currentColor"/>
        </svg>
      </button>
    </div>
  </form>    
@endsection