<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php

require_once('Connections/imerida.php'); 

$parontes = json_decode(stripslashes($_POST['parousia']));


mysql_select_db($database_imerida, $imerida);

$sent = "UPDATE symmetexontes SET parousia =  '0' "; 
   $Result1 = mysql_query($sent, $imerida) or die(mysql_error());

if (is_array($parontes))
{
foreach($parontes as $key => $paron)
{
   

   $sent = "UPDATE symmetexontes SET parousia =  '1' WHERE id ='$paron'"; 
   $Result1 = mysql_query($sent, $imerida) or die(mysql_error());

}
}
else 

echo ("Αποτυχία Καταχώρησης. Παρακαλώ επικοινωνήστε με τον διαχειριστή");
echo "<br>";echo "<br>";echo "<br>";
echo " <h3> Το παρουσιολόγιο καταχωρήθηκε με επιτυχία </h3> "



?>