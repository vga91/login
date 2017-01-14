<?php
session_start();
if (!isset($_POST["username"]) || !isset($_POST["password"])  ) {
  die("Errore! Parametri mancanti");
}
$formato_campi= array("username"=>"/^[a-zA-Z_\-]{5,20}$/" ,
                      "password"=> "/^[\w\W\s]{5,20}$/");

$valido = true;
foreach ($formato_campi as $campo => $formato) {
  if (trim($_POST[$campo]) == "") {
    echo "Compilare il campo $campo";
    $valido = false;
  } elseif (!preg_match($formato,$_POST[$campo])) {
    echo "Formato non corretto per il campo $campo";
    $valido = false;
  }
}

if ($valido) {
  $link = mysqli_connect("localhost","root","","login")
    or die("Attenzione! Errore in fase di connessione al database: " . mysqli_error($link));
  mysqli_set_charset($link,"utf8");
  $sql= " SELECT * FROM utenti
          WHERE username = '$_POST[username]'
          AND password = MD5('$_POST[password]') ";
  $risultato = mysqli_query($link, $sql)
    or die("Attenzione, errore in fase di estrazione dati: " . mysqli_error($link));
    if ($riga = mysqli_fetch_assoc($risultato)) {
      $_SESSION["id_utente"] = $riga["id"];
      $_SESSION["username"] = $riga["username"];
      header("Location: area-riservata.php");
    } else{
      header("Location: login.php");
    }
}

 ?>
