<?php require_once('Connections/imerida.php'); ?>
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
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_deleters = "-1";
if (isset($_POST['id'])) {
  $colname_deleters = $_POST['id'];
}
mysql_select_db($database_imerida, $imerida);
$query_deleters = sprintf("SELECT * FROM symmetexontes WHERE id = %s", GetSQLValueString($colname_deleters, "int"));
$deleters = mysql_query($query_deleters, $imerida) or die(mysql_error());
$row_deleters = mysql_fetch_assoc($deleters);
$totalRows_deleters = mysql_num_rows($deleters);


echo "
<h3><span style=\"background-color:red\"> Είστε σίγουροι ότι θέλετε να διαγράψετε την αίτηση : </span></h3>
<table width='353px' cellspacing='0' border='1' style='border-collapse:collapse; background-color:#00FF66;'>
  <center> <tr><td><strong>Επίθετο: </strong></td><td><strong>".$row_deleters['epitheto']."</strong></td></tr><tr><td><strong>Όνομα</strong></td><td><strong>".$row_deleters['epitheto']."</strong></td></tr><tr><td><strong>Σχολείο / Υπηρεσία</strong></td><td><strong>".$row_deleters['sxoleio']."</strong></td></tr><tr><td><strong>Τηλέφωνο Σχολείου</strong></td><td><strong>".$row_deleters['tel_sxoleioy']."</strong></td></tr><tr><td><strong>E-mail</strong></td><td><strong>".$row_deleters['email']."</strong></td></tr></table>";
  
  echo '<input type="button" name="delete" id="delete" value="Διαγραφή" /><input type="button" name="cancel" id="cancel" value="Ακύρωση"/>';



mysql_free_result($deleters);
?>
