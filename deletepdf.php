<?php
if (!isset($_SESSION)) {
  session_start();
}

?>
<?php require_once('Connections/imerida.php'); ?>
<?php   if ($_SESSION['MM_Username'] == 'admin') {
$filelocation = ".\\bebaiosis";
$file=$filelocation."\\".$_POST['email'].'.pdf';

if (!unlink($file))
  {
  echo ("Δεν διαγράφηκε το αρχείο $file");
  }
else
  {
  echo ("Το αρχείο $file διαγράφηκε");
  }}
?>