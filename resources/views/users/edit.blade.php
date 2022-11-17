@section('title', 'I tuoi dati')
@extends('layout')

@section('content')
  <h1>@yield('title')</h1>
  <div>
    <form id="create-user" name="create-user" action="{{ route('users.update', $user->id) }}" method="POST">
      @csrf
      @method('PATCH')

      @if ($errors->any())
        <div class="msg msg--error text-code sp-y-s" role="alert">
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif
  
      <div class="field-wrapper">
        <label for="company_name">Denominazione (opzionale)</label>
        <input type="text" name="company_name" id="company_name" @error('company_name') class="is-invalid" @enderror value="{{ $user->company_name ?? old('company_name') }}">
      </div>
    
      <div class="field-group flex flex--gap-col-s">
        <div class="field-wrapper">
          <label for="name">Nome</label>
          <input type="text" name="name" id="name" @error('name') class="is-invalid" @enderror value="{{ $user->name ?? old('name') }}" required>
        </div>
        <div class="field-wrapper">
          <label for="surname">Cognome</label>
          <input type="text" name="surname" id="surname" @error('surname') class="is-invalid" @enderror value="{{ $user->surname ?? old('surname') }}" required>
        </div>
      </div>
    
      <div class="field-group flex flex--gap-col-s sp-y-s">
        <div class="field-wrapper">
          <label for="street">Indirizzo</label>
          <input type="text" name="street" id="street" @error('street') class="is-invalid" @enderror value="{{ $user->street ?? old('street') }}" required>
        </div>
        <div class="field-wrapper">
          <label for="street_nr">Numero civico</label>
          <input type="text" name="street_nr" id="street_nr" @error('street_nr') class="is-invalid" @enderror value="{{ $user->street_nr ?? old('street_nr') }}" required>
        </div>
      </div>
    
      <div class="field-group flex flex--gap-col-s">
        <div class="field-wrapper">
          <label for="country_select">Nazione</label>
          <input type="text" list="list-countries" name="country_select" id="country_select" @error('country_code', 'country') class="is-invalid" @enderror @if($user->country_code > '') value="{{ $user->country_code }} - {{ $user->country }}" @else value="IT - Italia" @endif placeholder="IT - Italia" autocomplete="off" required>
          <datalist id="list-countries">
            <?php
            $json_countries = file_get_contents('inc/list-countries.json');
            $arr_countries = json_decode($json_countries, true);
            foreach($arr_countries['countries'] as $key => $val):
              ?>
              <option value="<?php echo $key .' - '. $val; ?>"><?php echo $key .' - '. $val; ?></option>
            <?php endforeach; ?>
          </datalist>
          <input type="hidden" name="country_code" id="country_code"  value="{{ $user->country_code ?? old('country_code') }}">
          <input type="hidden" name="country" id="country" value="{{ $user->country ?? old('country') }}">
        </div>
  
        <div class="field-wrapper">
          <label for="cap">CAP</label>
          <input type="text" name="cap" id="cap" @error('cap') class="is-invalid" @enderror size="6" value="{{ $user->cap ?? old('cap') }}" required>
        </div>
        <div class="field-wrapper">
          <label for="city">Comune</label>
          <input type="text" name="city" id="city" @error('city') class="is-invalid" @enderror value="{{ $user->city ?? old('city') }}" required>
        </div>
        <div class="field-wrapper">
          <label for="state">Provincia</label>
          <input type="text" list="list-states" name="state" id="state" @error('state') class="is-invalid" @enderror minlength="2" maxlength="2" size="4" autocomplete="off" value="{{ $user->state ?? old('state') }}" placeholder="AA" required>
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
          <input type="text" name="vat_nr" id="vat_nr" @error('vat_nr') class="is-invalid" @enderror minlength="11" maxlength="11" value="{{ $user->vat_nr ?? old('vat_nr') }}" placeholder="00000000000" required>
        </div>
        <div class="field-wrapper">
          <label for="cf">Codice fiscale</label>
          <input type="text" name="cf" id="cf" @error('cf') class="is-invalid" @enderror minlength="16" maxlength="16" value="{{ $user->cf ?? old('cf') }}" required>
        </div>
      </div>
    
      <h2>Contatto</h2>
    
      <div class="field-group flex flex--gap-col-s">
        <div class="field-wrapper">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" @error('email') class="is-invalid" @enderror value="{{ $user->email ?? old('email') }}" required>
        </div>
        <div class="field-wrapper">
          <label for="pec">PEC (opzionale)</label>
          <input type="email" name="pec" id="pec" @error('pec') class="is-invalid" @enderror value="{{ $user->pec ?? old('pec') }}">
        </div>
      </div>
    
      <div class="field-group flex flex--gap-col-s">
        <div class="field-wrapper">
          <label for="tel">Telefono (opzionale)</label>
          <input type="tel" name="tel" id="tel" @error('tel') class="is-invalid" @enderror value="{{ $user->tel ?? old('tel') }}">
        </div>
        <div class="field-wrapper">
          <label for="web">Sito web (opzionale)</label>
          <input type="text" name="web" id="web" @error('web') class="is-invalid" @enderror value="{{ $user->web ?? '' }}" placeholder="https://">
        </div>
      </div>
    
      <h2>Informazione pagamento</h2>
    
      <div class="field-wrapper">
        <label for="bank_iban">IBAN</label>
        <input type="text" name="bank_iban" id="bank_iban" @error('bank_iban') class="is-invalid" @enderror minlength="27" maxlength="33" placeholder="IT00 0000 0000 0000 0000 0000 000" value="{{ $user->bank_iban ?? old('bank_iban') }}" required>
      </div>
    
      <div class="field-group flex flex--gap-col-s">
        <div class="field-wrapper">
          <label for="bank_bic">BIC</label>
          <input type="text" name="bank_bic" id="bank_bic" @error('bank_bic') class="is-invalid" @enderror minlength="11" maxlength="11" placeholder="AAAAITBBCCC" value="{{ $user->bank_bic ?? old('bank_bic') }}" required>
        </div>
        <div class="field-wrapper">
          <label for="bank_name">Nome della banca</label>
          <input type="text" name="bank_name" id="bank_name" @error('bank_name') class="is-invalid" @enderror value="{{ $user->bank_name ?? old('bank_name') }}" required>
        </div>
      </div>

      <div class="field-group flex flex--wrap flex--pos-x-start flex--gap-row-m flex--gap-col-m">
        <button type="submit" name="user-submit" value="user-submit" title="Salva i tuoi dati">Salva i tuoi dati</button>
        <a href="/password/reset" class="btn btn--sec-color" title="Cambia password">Cambia password</a>
      </div>
    </form>
  </div>
@endsection