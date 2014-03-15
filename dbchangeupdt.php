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

 mysql_select_db($database_imerida, $imerida);
$countSQLekp="SELECT COUNT(*) FROM symmetexontes where ekpaideytikos =1 and epibebaiosi = 1";

$Result2=mysql_query($countSQLekp, $imerida) or die(mysql_error());
$num_sql = mysql_fetch_array($Result2);
$count_num_ekp = $num_sql[0];
//epitheto=".$_POST['epitheto'].
 $countSQLdioik="SELECT COUNT(*) FROM symmetexontes where ekpaideytikos =0 and epibebaiosi = 1";

$Result2=mysql_query($countSQLdioik, $imerida) or die(mysql_error());
$num_sql = mysql_fetch_array($Result2);
$count_num_dioik = $num_sql[0]; 
  
  /*************************************************************/
  /*************************************************************/
  /*************************************************************/
  
  $aitiseisA=$count_num_ekp;
 $aitiseisB=$count_num_dioik;
 
 $temp1=0;
 $emp2=0;

/* $plithos=0; 
 $dioik=0;*/
 $epilogiA=0;
 $epilogiB=0;

if ($mono_mia_omada ==0) //an thelo dio katigories symmetexonton
{
if ($aitiseisB >= $omadaB)

{
	
	if ($aitiseisA >= $omadaA)
      {   
	      $epilogiA = $omadaA ; 
		  $epilogiB = $omadaB;
		   
		    }	
	else  //aitiseisA < omadaA
	
	   {   $epilogiA = $aitiseisA ; 
	        $epilogiB = $synolo -$aitiseisA ;
				   
		   }
	
	
	}

else 

{
	if ($aitiseisA >= $omadaA)
	{
			$epilogiA = $omadaA +($omadaB-$aitiseisB); ; 
		    $epilogiB = $aitiseisB;
			}
	else 
	{
		$epilogiA = $omadaA ; 
		  $epilogiB = $omadaB;
		
		
		
		}
	
	
	
	
	}
}
else   // Συμμετέχουν μονο οσοι κανουν αιτηση απο τη μια ομάδα μεχρί το μεγιστο αριθμο synolo που εκφράζει το σύνολο των αιτούντων που μπορεί να συμμετέχουν

{    
	
			$epilogiA = $omadaA ; 
		    $epilogiB = 0;
			
	
	
	
	}

  $updatesql= " UPDATE symmetexontes SET epilogi=0 where ekpaideytikos=1";
  
 $Result3=mysql_query($updatesql, $imerida) or die(mysql_error());

$updatesql= " UPDATE symmetexontes SET epilogi=1
     WHERE id IN (
         SELECT id FROM (
             SELECT id FROM symmetexontes where ekpaideytikos=1 and epibebaiosi = 1
             ORDER BY regtime ASC  
             LIMIT 0, $epilogiA
         ) tmp
     )";
  
 $Result3=mysql_query($updatesql, $imerida) or die(mysql_error());
 
  $updatesql= " UPDATE symmetexontes SET  epilogi=0  where ekpaideytikos=0";
	 $Result4=mysql_query($updatesql, $imerida) or die(mysql_error());
 
  $updatesql= " UPDATE symmetexontes SET  epilogi=1
     WHERE id IN (
         SELECT id FROM (
             SELECT id FROM symmetexontes  where ekpaideytikos=0 and epibebaiosi = 1
             ORDER BY regtime ASC
             LIMIT 0, $epilogiB
         ) tmp
     )";
	 $Result4=mysql_query($updatesql, $imerida) or die(mysql_error());
 

 
 



?>