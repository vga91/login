<?php
session_start();
if (!isset($_SESSION["id_utente"])) {
  die("Accesso vietato");
}
 ?>
