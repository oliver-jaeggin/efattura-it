@section('title', 'Clienti')
@extends('layout')

@section('content')
  <h1>@yield('title')</h1>
  <div class="table-wrapper sp-y-s">

    @if(count($clients) <= 0)
      <p>Nessuna cliente trovata.</p>
    @else
      @include('includes.table_clients')
    @endif

  </div>

  @if ($clients->links()->paginator->hasPages())
    <div class="pagination">

      {{ $clients->links() }}

    </div>
  @endif

  <div class="flex flex--gap-col-m sp-y-m">
    <a href="clients/create" class="btn" title="Aggiungere nuovo cliente">Aggiungere nuovo cliente</a>
    <a href="invoices/create" class="btn btn--sec-color" title="Creare nuova fattura">Creare nuova fattura</a>
  </div>
@endsection