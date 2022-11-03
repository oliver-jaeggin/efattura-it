<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

  @include('includes.head')

</head>
<body @if(request()->path() != '/') class="{{ request()->path() }}" @else class="dashboard" @endif>
  <header id="header" class="header">

    @include('includes.header')

  </header>

  <main id="main">
    <section>
      <div class="content">

          @yield('content')
        
      </div>
    </section>
  </main>

  <footer id="footer" class="footer">
  
    @include('includes.footer')

  </footer>
  <script src="{{ asset('js/app.js') }}"></script>
  <?php echo str_contains(request()->path(), 'invoices') && (str_contains(request()->path(), 'edit') || str_contains(request()->path(), 'create')) ? '<script src="/js/calc-invoice.js"></script>' : ''; ?>
  <?php echo (str_contains(request()->path(), 'invoices') || str_contains(request()->path(), 'items')) && str_contains(request()->path(), 'edit') ? '<script src="/js/calc-item.js"></script>' : ''; ?>
  <?php echo str_contains(request()->path(), 'clients') && (str_contains(request()->path(), 'edit') || str_contains(request()->path(), 'create')) ? '<script src="/js/calc-client.js"></script>' : ''; ?>
  <?php echo str_contains(request()->path(), 'users') ? '<script src="/js/calc-user.js"></script>' : ''; ?>
</body>
</html>