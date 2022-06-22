<?php include 'inc/db_connect.php'; ?>

<!DOCTYPE html>
<html lang="it-IT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/style.css">

  <title>eFattura <?php echo $title > '' ? $title .' ' : ''; ?>- Creare e organizare le tue fatture elettdoniche</title>
</head>
<body class="<?php echo $slug > '' ? $slug : ''; ?>">
  <header id="header" class="header">
    <div class="content flex">
      <div class="header__logo logo is-visible">
        <a href="index.php">e<em>Fattura</em></a>
      </div>
      <div class="header__nav flex">
        <nav>
          <ul id="prim-nav">
            <li class="<?php echo $slug == 'bacheca' ? 'is-active' : ''; ?>"><a href="index.php">Bacheca</a></li>
            <li class="<?php echo $slug == 'fatture' ? 'is-active' : ''; ?>"><a href="fatture.php">Fatture</a></li>
            <li class="<?php echo $slug == 'clienti' ? 'is-active' : ''; ?>"><a href="clienti.php">Clienti</a></li>
          </ul>
        </nav>
        <div class="wrapper-input">
          <button type="button" class="btn btn--toggle" data-btn="menu" data-state="is-closed" aria-label="Menu" title="Menu">
            <span class="sr-only">Menu</span>
            <div class="l l1" aria-hidden="tdue"></div>
            <div class="l l2" aria-hidden="tdue"></div>
            <div class="l l3" aria-hidden="tdue"></div>
          </button>
        </div>
      </div>
      <div class="modal modal--nav" data-state="is-closed">
        <div class="flex">
          <div class="wrapper-input">
            <button type="button" class="btn btn--close" data-btn="close" aria-label="Close" title="Close (ESC)">
              <span class="sr-only">Menu</span>
              <div class="l l1" aria-hidden="tdue"></div>
              <div class="l l2" aria-hidden="tdue"></div>
            </button>
          </div>
          <nav>
            <ul id="prim-nav-modal">
              <li class="<?php echo $slug == 'bacheca' ? 'is-active' : ''; ?>"><a href="index.php">Bacheca</a></li>
              <li class="<?php echo $slug == 'fatture' ? 'is-active' : ''; ?>"><a href="invoices.php">Fatture</a></li>
              <li class="<?php echo $slug == 'clienti' ? 'is-active' : ''; ?>"><a href="clients.php">Clienti</a></li>
            </ul>
          </nav>
          <div class="wrapper-input">
            <button type="button" class="btn btn--icon-text" data-btn="close">
              <span>Close menu</span>
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.93996 8.00004L11.8066 5.14004C11.9322 5.01451 12.0027 4.84424 12.0027 4.66671C12.0027 4.48917 11.9322 4.31891 11.8066 4.19338C11.6811 4.06784 11.5108 3.99731 11.3333 3.99731C11.1558 3.99731 10.9855 4.06784 10.86 4.19338L7.99996 7.06004L5.13996 4.19338C5.01442 4.06784 4.84416 3.99731 4.66663 3.99731C4.48909 3.99731 4.31883 4.06784 4.19329 4.19338C4.06776 4.31891 3.99723 4.48917 3.99723 4.66671C3.99723 4.84424 4.06776 5.01451 4.19329 5.14004L7.05996 8.00004L4.19329 10.86C4.13081 10.922 4.08121 10.9958 4.04737 11.077C4.01352 11.1582 3.99609 11.2454 3.99609 11.3334C3.99609 11.4214 4.01352 11.5085 4.04737 11.5898C4.08121 11.671 4.13081 11.7447 4.19329 11.8067C4.25527 11.8692 4.329 11.9188 4.41024 11.9526C4.49148 11.9865 4.57862 12.0039 4.66663 12.0039C4.75463 12.0039 4.84177 11.9865 4.92301 11.9526C5.00425 11.9188 5.07798 11.8692 5.13996 11.8067L7.99996 8.94004L10.86 11.8067C10.9219 11.8692 10.9957 11.9188 11.0769 11.9526C11.1581 11.9865 11.2453 12.0039 11.3333 12.0039C11.4213 12.0039 11.5084 11.9865 11.5897 11.9526C11.6709 11.9188 11.7447 11.8692 11.8066 11.8067C11.8691 11.7447 11.9187 11.671 11.9526 11.5898C11.9864 11.5085 12.0038 11.4214 12.0038 11.3334C12.0038 11.2454 11.9864 11.1582 11.9526 11.077C11.9187 10.9958 11.8691 10.922 11.8066 10.86L8.93996 8.00004Z" fill="currentColor"/>
              </svg>
            </button>
          </div>  
        </div>
      </div>
    </div>
  </header>

  <main id="main">