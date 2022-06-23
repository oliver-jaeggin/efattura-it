<?php
$title = 'Tutte le fatture';
$description = '';
$slug = 'fatture';
include 'header.php';
?>

    <section>
      <div class="content gid">
        <h1><?php echo $title; ?></h1>
        <div class="flex sp-y-l">
          <?php
          $num_displayed_rows = 99999;
          include 'view/table-invoices.php';
          ?>
        </div>
        <div class="flex sp-y-m">
          <a href="create-invoice.php" class="btn">Creare nuova fattura</a>
          <a href="create-client.php" class="btn btn--sec-color">Creare nuovo cliente</a>
        </div>
      </div>
    </section>

<?php include 'footer.php'; ?>