@section('title', 'Fatture')
@extends('layout')

@section('content')
  <h1>@yield('title')</h1>
  <div class="table-wrapper sp-y-s">

    @if(count($invoices) <= 0)
      <p>Nessuna fattura trovata.</p>
    @else
      <?php $invQuery = $invoices ?>

      @include('includes.table_invoices')
    @endif

  </div>

  @if($invoices->links()->paginator->hasPages())
    <div class="pagination">

      {{ $invoices->links() }}

    </div>
  @endif

  <div class="flex flex--gap-col-m sp-y-m">
    <a href="invoices/create" class="btn" title="Creare nuova fattura">Creare nuova fattura</a>
    <a href="clients/create" class="btn btn--sec-color" title="Aggiungere nuovo cliente">Aggiungere nuovo cliente</a>
  </div>
@endsection
