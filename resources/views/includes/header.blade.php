<div class="content flex">
  <!-- skip navigation for screenreaders -->
  <a href="#main" tabindex="1" class="sr-only">Skip to content</a>
  <div class="header__logo logo is-visible">
    <a href="/" title="Vai alla baccheca">e<em>Fattura</em></a>
  </div>
  <div class="header__nav flex">
    @auth
      <nav id="main-nav"></nav>

      <div class="wrapper-input">
        <button type="button" class="btn btn--burger" data-toggle="open" title="Menu" aria-expanded="false" aria-label="Menu" aria-controls="menu-modal">
          <span class="sr-only">Menu</span>
          <div class="l l1" aria-hidden="tdue"></div>
          <div class="l l2" aria-hidden="tdue"></div>
          <div class="l l3" aria-hidden="tdue"></div>
        </button>
      </div>
    </div>

    <div id="menu-modal" class="modal modal--nav flex" data-state="is-closed">
      <div class="flex">
        <div class="wrapper-input">
          <button type="button" class="btn btn--close" data-toggle="close" aria-label="Close" title="Chiudi (ESC)">
            <span class="sr-only">Chiudi (ESC)</span>
            <div class="l l1" aria-hidden="tdue"></div>
            <div class="l l2" aria-hidden="tdue"></div>
          </button>
        </div>
  
        <nav id="main-nav-mobile"></nav>
  
      </div>
    </div>
  @endauth
</div>

<template id="template-main-nav">
  <ul>
    <li role="menuitem"><a href="/" @if(request()->path() == '/') aria-current="page" @endif>Bacheca</a></li>
    <li role="menuitem"><a href="/invoices" @if(str_contains(request()->path(), 'invoices') === true) aria-current="page" @endif>Fatture</a></li>
    <li role="menuitem"><a href="/clients" @if(str_contains(request()->path(), 'clients') === true) aria-current="page" @endif>Clienti</a></li>
    <li role="menuitem"><a href="/users/{{ auth()->user()->id ?? '' }}/edit" @if(str_contains(request()->path(), 'users') === true) aria-current="page" @endif>Utente</a></li>
    <li role="menuitem">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn" title="Esci">Logout</button>
      </form>
    </li>
  </ul>
</template>