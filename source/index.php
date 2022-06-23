<?php if(!file_exists('inc/db_connect.php')): ?>

  <?php header('Location: http://'. $_SERVER['HTTP_HOST'] .'/setup.php'); ?>

<?php elseif(file_exists('inc/db_connect.php')): ?>

  <?php
  include 'inc/db_connect.php';
  $database = DB_NAME;
  $sql_check = "SHOW TABLE STATUS FROM $database WHERE Name='user'";
  $res_check = $mysqli->query($sql_check);

  // check if user data are already present
  if($res_check && $res_check->num_rows > 0) {
    $row_check = $res_check->fetch_array(MYSQLI_ASSOC);
  }
  if($row_check['Auto_increment'] <= 1): ?>
    <?php header('Location: http://'. $_SERVER['HTTP_HOST'] .'/setup.php'); ?>

  <?php else: ?>

    <?php
    $title = 'Bacheca';
    $description = '';
    $slug = 'bacheca';
    include 'header.php';
    ?>

    <section>
      <div class="content gid">
        <h1><?php echo $title; ?></h1>
        <p>Benvenuto nel tuo portale di eFattura</p>
        <h2>Azioni</h2>
        <div class="flex sp-y-l">
          <a href="create-invoice.php" class="btn">Creare nuova fattura</a>
          <a href="create-client.php" class="btn">Creare nuovo cliente</a>
        </div>
        <h2>Liste delle ultime fatture</h2>
        <div class="sp-y-l">
          <div class="sp-y-s">
            <?php
            $num_displayed_rows = 5;
            include 'view/table-invoices.php';
            ?>
          </div>
          <a href="fatture.php" class="btn">Vedi tutte le fatture</a>
        </div>
        <h2>Lista di clienti</h2>
        <div class="sp-y-m">
          <div class="sp-y-s">

            <?php include 'view/table-clients.php'; ?>

          </div>
          <a href="clienti.php" class="btn">Vedi tutti i clienti</a>
        </div>
      </div>
    </section>

    <?php include 'footer.php'; ?>

  <?php endif; ?>

<?php endif; ?>