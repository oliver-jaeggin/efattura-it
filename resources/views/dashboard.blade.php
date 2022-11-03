@section('title', '')
@extends('layout')

@section('content')
  @if(auth()->user()->name == '')

    <?php echo '<script>window.location = "/users/'. auth()->user()->id .'/edit";</script>'; ?>

  @else
    <h1>Bacheca</h1>
    <p class="sp-y-l">Benvenuto <strong>{{ auth()->user()->name ?? '' }}</strong> nel tuo portale di e<em>Fattura</em></p>
    <h2>Azioni</h2>
    <div class="flex flex--gap-col-m sp-y-l">
      <a href="/invoices/create" class="btn" title="Creare nuova fattura">Creare nuova fattura</a>
      <a href="/clients/create" class="btn btn--sec-color" title="Aggiungere nuovo cliente">Aggiungere nuovo cliente</a>
    </div>
    <h2>Liste delle ultime fatture</h2>
    <div class="sp-y-l">
      <div class="table-wrapper sp-y-s">

        @if(count($invoices) <= 0)
          <p>Nessuna fattura trovata.</p>
        @else
          <?php $invQuery = $invoices; ?>

          @include('includes.table_invoices')
        @endif
            
      </div>
      <a href="/invoices" class="btn" title="Vedi tutte le fatture">Vedi tutte le fatture</a>
    </div>
    <h2>Lista di clienti</h2>
    <div class="sp-y-m">
      <div class="table-wrapper sp-y-s">

        @if(count($clients) <= 0)
          <p>Nessuna cliente trovata.</p>
        @else
          @include('includes.table_clients')
        @endif
        
      </div>
      <a href="/clients" class="btn" title="Vedi tutti i clienti">Vedi tutti i clienti</a>
    </div>
  @endif
@endsection