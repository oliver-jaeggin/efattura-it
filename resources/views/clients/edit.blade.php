@section('title', 'Modifica cliente')
@extends('layout')

@section('content')
  <h1>@yield('title') {{ $client->display_name ?? '' }}</h1>
  <div>
  <form id="create-client" name="create-client" action="{{ route('clients.update', $client->id) }}" method="POST">
    @csrf
    @method('PATCH')

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
        <input type="number" name="destination_code" id="destination_code" @error('destination_code') class="is-invalid" @enderror maxlength="7" value="{{ $client->destination_code ?? '' }}" autofocus>
      </div>
      <div class="field-wrapper">
        <label for="company_name">Denominazione</label>
        <input type="text" name="company_name" id="company_name" class="input-client-name @error('company_name') is-invalid @enderror" value="{{ $client->company_name ?? '' }}">
      </div>
    </div>

    <div class="field-group flex flex--gap-col-s">
      <div class="field-wrapper">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" class="input-client-name @error('name') is-invalid @enderror" value="{{ $client->name ?? '' }}">
      </div>
      <div class="field-wrapper">
        <label for="surname">Cognome</label>
        <input type="text" name="surname" id="surname" class="input-client-name @error('surname') is-invalid @enderror" value="{{ $client->surname ?? '' }}">
      </div>
    </div>

    <input type="hidden" name="display_name" id="display_name" @error('display_name') class="is-invalid" @enderror value="{{ $client->display_name ?? '' }}">

    <div class="field-group flex flex--gap-col-s">
      <div class="field-wrapper">
        <label for="street">Indirizzo</label>
        <input type="text" name="street" id="street" @error('street') class="is-invalid" @enderror value="{{ $client->street ?? '' }}" required>
      </div>
      <div class="field-wrapper">
        <label for="street_nr">Numero civico</label>
        <input type="text" name="street_nr" id="street_nr" @error('street_nr') class="is-invalid" @enderror value="{{ $client->street_nr ?? '' }}" required>
      </div>
    </div>

    <div class="field-group flex flex--gap-col-s">
      <div class="field-wrapper">
        <label for="country_select">Nazione</label>
        <input type="text" list="list-countries" name="country_select" id="country_select" @error('country_code', 'country') class="is-invalid" @enderror value="{{ $client->country_code }} - {{ $client->country }}" placeholder="IT - Italia" autocomplete="off" required>
        <datalist id="list-countries">
          <?php
          $json_countries = file_get_contents('inc/list-countries.json');
          $arr_countries = json_decode($json_countries, true);
          foreach($arr_countries['countries'] as $key => $val):
            ?>
            <option value="<?php echo $key .' - '. $val; ?>"><?php echo $key .' - '. $val; ?></option>
          <?php endforeach; ?>
        </datalist>
        <input type="hidden" name="country_code" id="country_code"  value="{{ $client->country_code ?? '' }}">
        <input type="hidden" name="country" id="country" value="{{ $client->country ?? '' }}">
      </div>
      <div class="field-wrapper">
        <label for="cap">CAP</label>
        <input type="text" name="cap" id="cap" @error('cap') class="is-invalid" @enderror size="6" value="{{ $client->cap ?? '' }}" required>
      </div>
      <div class="field-wrapper">
        <label for="city">Comune</label>
        <input type="text" name="city" id="city" @error('city') class="is-invalid" @enderror value="{{ $client->city ?? '' }}" required>
      </div>
      <div class="field-wrapper" @if($client->state > 0 || $client->country_code === 'IT') data-state="is-opened" @else data-state="is-closed" @endif>
        <label for="state">Provincia</label>
        <input type="text" list="list-states" name="state" id="state" @error('state') class="is-invalid" @enderror minlength="2" maxlength="2" size="4" value="{{ $client->state ?? '' }}" placeholder="AA" autocomplete="off">
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
        <input type="text" name="vat_nr" id="vat_nr" @error('vat_nr') class="is-invalid" @enderror minlength="11" maxlength="11" value="{{ $client->vat_nr ?? '' }}">
      </div>
      <div class="field-wrapper" data-state="is-opened">
        <label for="cf">Codice fiscale</label>
        <input type="text" name="cf" id="cf" @error('cf') class="is-invalid" @enderror minlength="16" maxlength="16" value="{{ $client->cf ?? '' }}">
      </div>
    </div>

    <div class="field-group flex flex--gap-col-s">
      <div class="field-wrapper">
        <label for="email">Email (opzionale)</label>
        <input type="email" name="email" id="email" @error('email') class="is-invalid" @enderror value="{{ $client->email ?? '' }}">
      </div>
      <div class="field-wrapper" data-state="is-opened">
        <label for="pec">PEC (opzionale)</label>
        <input type="email" name="pec" id="pec" @error('pec') class="is-invalid" @enderror value="{{ $client->pec ?? '' }}">
      </div>
    </div>

    <div class="field-wrapper sp-y-m">
      <label for="template">Modello della fattura (opzionale)</label>
      <input type="text" list="list-templates" name="template" id="template" @error('template') class="is-invalid" @enderror value="{{ $client->template ?? '' }}" title="Scrivi il nome della sotto cartella dove se trovi il template">
      <datalist id="list-templates">
        <?php
        // causes security problems on a real server
        //$dir_templates = scandir('templates');
        //$arr_templates = [];
        //foreach($dir_templates as $val):
          ?>
          <?php //if(!str_contains($val, '.')): ?>
            <option value="<?php //echo $val; ?>"><?php //echo $val; ?></option>
          <?php //endif; ?>
        <?php //endforeach; ?>
      </datalist>
    </div>
          
    <div class="field-group flex flex--wrap flex--pos-x-start flex--gap-row-m flex--gap-col-m">
      <button type="submit" name="client-submit" class="btn" value="client-submit" title="Salva e aggiorna il cliente">Salva e aggiorna il cliente</button>
      <a href="{{ route('clients.index') }}" class="btn btn--sec-color" title="Ritorna alla pagina Clienti">Ritorna alla pagina Clienti</a>  
    </div>
  </form>    
@endsection