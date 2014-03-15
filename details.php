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
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
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
<?php require_once('Connections/imerida.php'); ?>
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


 //$epitheto = ($_GET['epitheto']);
  $mobile = ($_GET['mobile']);
 $email = ($_GET['email']);
 //var_dump($email);
  mysql_select_db($database_imerida, $imerida); 
   $selectSQL = "select * from symmetexontes where mobile=$mobile and email='$email'";  
                  
					//  '%s' GetSQLValueString($mobile, "int"));
  $Result1 = mysql_query($selectSQL, $imerida) or die(mysql_error());




$row_updaters = mysql_fetch_assoc($Result1);
$details = mysql_num_rows($Result1);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Αποδεικτικό Καταχώρησης</title>


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
<script src="jquery-2.0.0.min.js">




</script>
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
      <p>&nbsp;&nbsp;<a href="managepub.php"><span style="color:#F00; font-size:80%">&#9632;</span>Αρχική Σελίδα</a>    </p> <p>&nbsp;&nbsp;<a href="add_new.php"><span style="color:#F00; font-size:80%">&#9632;</span>Νέα Αίτηση Συμμετοχής </a> </p>
    <p>&nbsp;&nbsp;<a href="participants.php"><span style="color:#F00; font-size:80%">&#9632;</span>Προβολή Αιτήσεων </a> </p>
<p>&nbsp;&nbsp;<a id="linkshow"><span style="color:#F00; font-size:80%">&#9632;</span>Συμμετέχοντες Εκπαιδευτικοί </a> <br />
     <!-- <span id="auto"> (Αυτόματα ενεργό από ΧΧ/ΧΧ/ΧΧ και μετά)</span> -->
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
          include 'menouadmin.php'; ?>
            </p>
  <p>&nbsp;&nbsp;<a href="<?php echo $logoutAction ?>"><span style="color:#F00; font-size:80%">&#9632;</span>Log out</a><br/>
  </p>
    <p>&nbsp;</p></span>
		       <!-- End Left Column -->
		       <!-- Begin Right Column --><span id="rightcolumn" style="color:#960;margin-left:10px; margin-top:0px; width:500px; height:490px; float:left">
		       <div id="two-column">
		         <div id="left" >
		         <form  style=" color:#000">
 <br /> <p><strong>Τα παρακάτω στοιχεία καταχωρήθηκαν με επιτυχία.</strong></p>
  <table width="303" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr>
      <td width="99"><strong>Επίθετο: </strong></td>
      <td width="185"><strong><?php echo $row_updaters['epitheto']; ?> </strong></td>
    </tr>
    <tr>
      <td><strong>Όνομα</strong></td>
      <td><strong><?php echo $row_updaters['onoma']; ?></strong></td>
    </tr>
    <tr>
      <td><strong>Σχολείο ή Υπηρεσία</strong></td>
      <td><strong><?php echo $row_updaters['sxoleio']; ?></strong></td>
    </tr>
    <tr>
      <td><strong>
        <label for="tel_sxoleioy2">Τηλέφωνο Σχολείου</label>
      </strong></td>
      <td><strong><?php echo $row_updaters['tel_sxoleioy'];?></strong></td>
    </tr>
    <tr>
      <td><strong>
        <label for="mobile2">Κινητό Τηλέφωνο</label>
      </strong></td>
      <td><strong><?php echo $row_updaters['mobile'];?></strong></td>
    </tr>
    <tr>
      <td><strong>E-mail</strong></td>
      <td><strong><?php echo $row_updaters['email'];?></strong></td>
    </tr>
    <tr>
      <td><strong>Ημερομηνία</strong></td>
      <td><strong>
        <?php  echo $row_updaters['regtime'];
  ?>
      </strong></td>
    </tr>
    
     <tr>
      <td><strong>Φορητός </strong></td>
      <td><strong>
        <?php  
		
		if ($row_updaters['foritos_yparxei']==1)
		echo 'Ναί';
		else
		echo 'Όχι';
  ?>
      </strong></td>
    </tr>
    <tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <p><strong>
    <label for="onoma">&nbsp;</label>
  </strong></p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <p>  <strong>
    <label for="email">&nbsp;</label>
  </strong></p>
  <p><strong>:

  </strong>  </p>
  <p>&nbsp;</p>
  
</form></div></div>

</span>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="clear">Έχετε εισέλθει ως : <span style="background-color:#F00"><?php echo $_SESSION['MM_Username']; ?></span></div>
  </div>	   
         <!-- End Faux Columns --> 
        <!-- Begin Footer -->
          <div id="footer" style="font-family:Verdana, Geneva, sans-serif; ">Δημιουργία πληροφοριακού συστήματος :
     <span style="color:#009; letter-spacing:-1px; font-family:Verdana, Geneva, sans-serif;"><span style="color:#cf4d3f;font-size:80%">&#9632;</span>Χερτούρας</span>
     <span style="color:#009; letter-spacing:-1px; font-family:Verdana, Geneva, sans-serif;">Κωνσταντίνος</span>
     <span style="color:#009; letter-spacing:-1px; font-family:Verdana, Geneva, sans-serif;"><span style="color:#cf4d3f;font-size:80%">&#9632;</span> Καθηγητής Πληροφορικής</span>
     <span style="color:#009; letter-spacing:-1px; font-family:Verdana, Geneva, sans-serif;"><span style="color:#F00; font-size:80%">&#9632;</span>chertour at sch.gr</span>
      <!-- End Footer --></div>
<p>&nbsp;</p>
</div>
</body>


</html>