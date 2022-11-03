<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<title>
  @if(Request::path() == '/')
    eFattura: Crea e organiza le tue fatture elettroniche
  @else
    @yield('title') - eFattura: Crea e organiza le tue fatture elettroniche
  @endif
</title>
