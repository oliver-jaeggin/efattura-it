<?php
include 'inc/db_connect.php';
$action = $_GET['action'];
$type = $_GET['type'];
$client_id = $_GET['cl_id'];

if($action == 'delete') {
  $sql = "DELETE FROM clients WHERE id_client='$client_id'";
  $res = $mysqli->query($sql);
  if($res) {
    echo 'Cliente cancellato con successo';
  }
  else {
    echo 'Errore durante cancellazione';
  }
}