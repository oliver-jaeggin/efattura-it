<?php
$title = 'Tutti i clienti';
$description = '';
$slug = 'clienti';
include 'header.php';
?>

    <section>
      <div class="content gid">
        <h1><?php echo $title; ?></h1>
        <div class="flex sp-y-l">
          <?php include 'view/table-clients.php'; ?>
        </div>
        <div class="flex sp-y-s">
          <a href="create-client.php" class="btn">Creare nuovo cliente</a>
          <a href="create-invoice.php" class="btn btn--sec-color">Creare nuova fattura</a>
        </div>
      </div>
    </section>

<?php include 'footer.php' ?>


