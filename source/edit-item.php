<?php
include 'inc/db_connect.php';
$action = $_GET['action'];
$type = $_GET['type'];
$id = $_GET['id'];

if($action == 'delete') {
  $sql = "DELETE FROM items WHERE id_item='$id'";
  $res = $mysqli->query($sql);
  if($res) {
    echo 'Prodotto/servizio cancellato con successo';
  }
  else {
    echo 'Errore durante cancellazione';
  }
}