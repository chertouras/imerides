<?php require_once('Connections/imerida.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE symmetexontes SET onoma=%s, epitheto=%s, sxoleio=%s, tel_sxoleioy=%s, mobile=%s, email=%s, foritos_yparxei=%s, ekpaideytikos=%s,epibebaiosi=%s WHERE id=%s",
                       GetSQLValueString($_POST['onoma'], "text"),
                       GetSQLValueString($_POST['epitheto'], "text"),
                       GetSQLValueString($_POST['sxoleio'], "text"),
                       GetSQLValueString($_POST['tel_sxoleioy'], "text"),
                       GetSQLValueString($_POST['mobile'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString(isset($_POST['foritos_yparxei']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ekpaideytikos']) ? "true" : "", "defined","1","0"), GetSQLValueString(isset($_POST['epibebaiosi']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_imerida, $imerida);
  $Result1 = mysql_query($updateSQL, $imerida) or die(mysql_error());

$countSQLekp="SELECT COUNT(*) FROM symmetexontes where ekpaideytikos =1 and epibebaiosi = 1";

$Result2=mysql_query($countSQLekp, $imerida) or die(mysql_error());
$num_sql = mysql_fetch_array($Result2);
$count_num_ekp = $num_sql[0];

 $countSQLdioik="SELECT COUNT(*) FROM symmetexontes where ekpaideytikos =0 and epibebaiosi = 1";

$Result2=mysql_query($countSQLdioik, $imerida) or die(mysql_error());
$num_sql = mysql_fetch_array($Result2);
$count_num_dioik = $num_sql[0]; 
  
  /*************************************************************/
  /*************************************************************/
  /*************************************************************/
  
  $aitiseisA=$count_num_ekp;
 $aitiseisB=$count_num_dioik;
 

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
 

 
  /*************************************************************/
 /*************************************************************/
  /*************************************************************/


  $updateGoTo = "manage.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_updaters = "-1";
if (isset($_GET['id'])) {
  $colname_updaters = $_GET['id'];
}
mysql_select_db($database_imerida, $imerida);
$query_updaters = sprintf("SELECT * FROM symmetexontes WHERE id = %s", GetSQLValueString($colname_updaters, "int"));
$updaters = mysql_query($query_updaters, $imerida) or die(mysql_error());
$row_updaters = mysql_fetch_assoc($updaters);
$totalRows_updaters = mysql_num_rows($updaters);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ενημέρωση στοιχείων συμμετοχής</title>

<script src="jquery-2.0.0.min.js">




</script>
<link type="text/css" href="main.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="style.css"/>
<style type="text/css">

body {font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
}
p, h1, form, button{border:0; margin:0; padding:0;}
.spacer{clear:both; height:1px;}



div#rightcolumn {background-image:none} 

</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />


</style>



<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<script type="text/javascript">
function ShowHide()
{

  
var today= <?php  date_default_timezone_set('Europe/Athens');
$res=date('Y-m-d H:i:s');
$today=strtotime("$res");
echo  strtotime("$res");

 ?>;

  <?php 
  if ( $end < $today ) 
  {
      echo ' $("#auto").hide();';
 echo '$("#linkshow").attr("href", "attendants.php");';
  }
  ?>
}

$(document).ready(function(){

    ShowHide();
$(".inputf").bind("keyup",function(){
        this.value= this.value.toUpperCase();
});
});

</script>

</head>

<body>

<div id="wrapper">

  <div id="header">
    <p><span style="color:#000000; letter-spacing:-2px; font:bold 24px/14px Arial, Helvetica, sans-serif;">1o WORKSHOP ΠΛΗΡΟΦΟΡΙΚΗΣ</span><br />
      <span style="color:#ff0000; letter-spacing:10px; font:14px/16px Arial, Helvetica, sans-serif;">ΕΠΑΛ ΡΟΔΟΠΟΛΗΣ</span></p>
  </div>
 
<div id="navigation">
  <center>
    <span style="color:#333; letter-spacing:5px; font:14px/16px Arial, Helvetica, sans-serif; font-weight: bolder; ">ΕΠΑΛ ΡΟΔΟΠΟΛΗΣ _ ΡΟΔΟΠΟΛΗ 62055 _ 2327022020 _ epal-rodop at sch.gr</span></p></center>
</div> <!--ΝΑΩΙΓΑΤΙΟΝ ΕND-->
<div id="faux">
		 
		       <!-- Begin Left Column -->
    <span id="leftcolumn" style="float:left">
		           
    <p>&nbsp;</p>
      <p>&nbsp;&nbsp;<a href="managepub.php"><span style="color:#F00; font-size:80%">&#9632;</span>Αρχική Σελίδα</a>    </p>
      <p>&nbsp;&nbsp;<a href="add_new.php"><span style="color:#F00; font-size:80%">&#9632;</span>Νέα Αίτηση Συμμετοχής </a> </p>
    <p>&nbsp;&nbsp;<a href="participants.php"><span style="color:#F00; font-size:80%">&#9632;</span>Προβολή Αιτήσεων </a> </p>
<p>&nbsp;&nbsp;<a id="linkshow"><span style="color:#F00; font-size:80%">&#9632;</span>Συμμετέχοντες Εκπαιδευτικοί </a> <br />
     <span id="auto"> (Αυτόματα ενεργό από ΧΧ/ΧΧ/ΧΧ και μετά)</span> 
     <?php    if ($_SESSION['MM_Username'] == 'admin')
	 {
			  echo " 
	  <script type=\"text/javascript\">
	  $(document).ready(function(){
$('#auto').hide();
$('#linkshow').attr('href', 'attendants.php');
$('#faux').css('background','#cf9');

$('#rightcolumn').css('background','#9c9 ');
});
</script> ";
		 
		
	
		 
		 }
	 
	 ?>
     
    </p>
             <?php 
          include 'menouadmin.php';
	   ?>
            </p>
  <p>&nbsp;&nbsp;<a href="<?php echo $logoutAction ?>"><span style="color:#F00; font-size:80%">&#9632;</span>Log out</a><br/>
  </p>
    <p>&nbsp;</p></span>
		       <!-- End Left Column -->
		       <!-- Begin Right Column --><span id="rightcolumn" style="color:#960;margin-left:10px; margin-top:0px; width:500px; height:490px; float:left">
		       <div id="two-column">
		         <div id="left" >
		         <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <p style="margin-top:6px">    <label for="epitheto">Επίθετο &nbsp;</label>
    <span id="sprytextfield1">
    <input name="epitheto" type="text" class="inputf" id="epitheto" value="<?php echo $row_updaters['epitheto']; ?>" size="50" maxlength="50" /><br />
    <span class="textfieldRequiredMsg">Απαραίτητη Τιμή</span></span></p> 
  <p><label for="onoma">Όνομα &nbsp;</label>
    <span id="sprytextfield2">
    <input name="onoma" type="text" class="inputf" id="onoma" value="<?php echo $row_updaters['onoma']; ?>" size="50" maxlength="50" /><br />
    <span class="textfieldRequiredMsg">Απαραίτητη Τιμή</span></span></p>
  <p>
    <label for="sxoleio">Σχολείο ή Υπηρεσία </label>
    <span id="sprytextfield3">
    <input name="sxoleio" type="text" class="inputf" id="sxoleio" value="<?php echo $row_updaters['sxoleio']; ?>" size="60" maxlength="60" />
   <br /> <span class="textfieldRequiredMsg">Απαραίτητη Τιμή</span></span></p>
  <p>
    <label for="tel_sxoleioy">Τηλέφωνο Σχολείου</label>
    <span id="sprytextfield4">
    <input name="tel_sxoleioy" type="text" class="inputf" id="tel_sxoleioy" value="<?php echo $row_updaters['tel_sxoleioy']; ?>" size="10" maxlength="10" />
    <br />
    <span class="textfieldRequiredMsg">Απαραίτητη Τιμή</span><span class="textfieldMinCharsMsg">Απαιτούνται 10 αριθμοί</span><span class="textfieldInvalidFormatMsg">Μόνο αριθμοί</span></span></p>
  <p>
    <label for="mobile">Κινητό Τηλέφωνο</label>
    <span id="sprytextfield5">
    <input name="mobile" type="text" class="inputf" id="mobile" value="<?php echo $row_updaters['mobile']; ?>" size="10" maxlength="10" />
    <br />
    <span class="textfieldRequiredMsg">Απαραίτητη Τιμή</span> <span class="textfieldMinCharsMsg">Απαιτούνται 10 αριθμοί</span> <span class="textfieldMaxCharsMsg">Μόνον 10 αριθμοί</span> <span class="textfieldInvalidFormatMsg">Μόνο αριθμοί</span></span></p> 
  <p>  <label for="email">E-mail &nbsp;</label>
    <span id="sprytextfield6">
    <input name="email" type="text" id="email" value="<?php echo $row_updaters['email']; ?>" />
    <span class="textfieldRequiredMsg">Απαραίτητη Τιμή</span><span class="textfieldInvalidFormatMsg">Λάθος Διεύθυνση</span></span></p>
  <p>
    <label for="ekpaideytikos" <?php if ($mono_mia_omada==1) echo "hidden" ?>>Εκπαιδευτικός ?</label>
    
      <input <?php if ($mono_mia_omada==1) echo "hidden" ?> <?php if (!(strcmp($row_updaters['ekpaideytikos'],1))) {echo "checked=\"checked\"";} ?> name="ekpaideytikos" type="checkbox" id="ekpaideytikos"  />
    <span>Επιβεβαίωση ? <input <?php if (!(strcmp($row_updaters['epibebaiosi'],1))) {echo "checked=\"checked\"";} ?> name="epibebaiosi" type="checkbox" value="" /></span> </p>
  <p>  <label for="foritos_yparxei">Υπάρχει Φορητός?</label>
    <input <?php if (!(strcmp($row_updaters['foritos_yparxei'],1))) {echo "checked=\"checked\"";} ?> name="foritos_yparxei" type="checkbox" id="foritos_yparxei" value="<?php echo $row_updaters['foritos_yparxei']; ?>" />
  
  </p>
  
  <p>Ημερομηνία: <?php 
  date_default_timezone_set('Europe/Athens');
  echo date('d/m/Y h:i:s a', (time()));?></p>
    <input type="button" id="back" value="Ακύρωση" onclick="window.location.href = 'manage.php'; "/>
    <input type="submit" name="button" id="button" value="Ενημέρωση"  />


  <input name="id" type="hidden" value="<?php echo $row_updaters['id']; ?>" />
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />

                 </form></div></div>

</span>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="clear">Έχετε εισέλθει ως : <span style="background-color:#F00"><?php echo $_SESSION['MM_Username']; ?></span></div>
  </div>	   
         <!-- End Faux Columns --> 
        <!-- Begin Footer -->
         <div id="footer" style="font-family:Verdana, Geneva, sans-serif; ">Δημιουργία πληροφοριακού συστήματος :
     <span style="color:#009; letter-spacing:-1px; font:14px Georgia,"Times New Roman", Times, serif;"><span style="color:#cf4d3f;font-size:80%">&#9632;</span>Χερτούρας</span>
     <span style="color:#009; letter-spacing:-1px; font:14px Georgia,"Times New Roman", Times, serif;">Κωνσταντίνος</span>
     <span style="color:#009; letter-spacing:-1px; font:14px Georgia,"Times New Roman", Times, serif;"><span style="color:#cf4d3f;font-size:80%">&#9632;</span> Καθηγητής Πληροφορικής</span>
     <span style="color:#009; letter-spacing:-1px; font:14px Georgia,"Times New Roman", Times, serif;"><span style="color:#F00; font-size:80%">&#9632;</span>chertour at sch.gr</span>
      <!-- End Footer --></div>
<p>&nbsp;</p>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {validateOn:["blur"], minChars:10});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "integer", {minChars:10, validateOn:["blur"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "email", {validateOn:["blur"]});
</script>
</body>


</html>
<?php
mysql_free_result($updaters);
?>
