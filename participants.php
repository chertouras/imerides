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

$maxRows_managers = 10;
$pageNum_managers = 0;
if (isset($_GET['pageNum_managers'])) {
  $pageNum_managers = $_GET['pageNum_managers'];
}
$startRow_managers = $pageNum_managers * $maxRows_managers;

mysql_select_db($database_imerida, $imerida);
$query_managers = "SELECT id, onoma, epitheto, sxoleio, tel_sxoleioy, regtime, email,ekpaideytikos FROM symmetexontes ORDER BY ekpaideytikos DESC, epitheto ASC ";

$managers = mysql_query($query_managers, $imerida) or die(mysql_error());
$row_managers = mysql_fetch_assoc($managers);
$countSQL="SELECT COUNT(*) FROM symmetexontes ";

$Result2=mysql_query($countSQL, $imerida) or die(mysql_error());
$num_sql = mysql_fetch_array($Result2);
$count = $num_sql[0];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Υποβληθείσες Αιτήσεις</title>

<script src="jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="DataTables-1.9.4/media/js/jquery.dataTables.min.js"></script>

<link type="text/css" href="main.css" rel="stylesheet"/>
<style type="text/css" title="currentStyle">
    @import "DataTables-1.9.4/media/css/demo_table.css";
</style>
<style type="text/css">

body {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size: 12px;
}
p, h1, form, button{border:0; margin:0; padding:0;}
.spacer{clear:both; height:1px;}



.first{
    color:red;
}
table
{
border-collapse:collapse;
}
table, td, th
{
border:1px solid black;
}

div#rightcolumn {background-image:none} 
#tblSearch tr:nth-child(odd) td { background: #CCC}
#tblSearch tr:nth-child(even) td { background: #FFF }
 #tblSearch  tr:hover td { background: #F00}


</style>




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
$('#tblSearch').dataTable({
	"aLengthMenu":  [[10], [10]],
            "oLanguage": {
                
    "sProcessing":   "Επεξεργασία...",
    "sLengthMenu":   "Δείξε _MENU_ εγγραφές",
    "sZeroRecords":  "Δεν βρέθηκαν εγγραφές που να ταιριάζουν",
    "sInfo":         "Δείχνοντας _START_ εως _END_ από _TOTAL_ εγγραφές",
    "sInfoEmpty":    "Δείχνοντας 0 εως 0 από 0 εγγραφές",
    "sInfoFiltered": "(φιλτραρισμένες από _MAX_ συνολικά εγγραφές)",
    "sInfoPostFix":  "",
    "sSearch":       "Αναζήτηση:",
    "sUrl":          "",
    "oPaginate": {
        "sFirst":    "Πρώτη",
        "sPrevious": "Προηγούμενη",
        "sNext":     "Επόμενη",
        "sLast":     "Τελευταία"
    
                       }
					  
		   
					   
            }
        } );


var count= <?php echo $count; ?>;
if (count == 0 ){
$("#tblSearch_wrapper").hide();
$("#tblSearch_wrapper").replaceWith('<br><br><br><h3> &nbsp;&nbsp; Δεν υπάρχουν αιτήσεις συμμετοχής </h3><br><br>');}

});
 



 
</script>

</head>

<body>

<div id="wrapper">

  <div id="header">

    <p><span style="color:#000000; letter-spacing:-2px; font:bold 24px/14px Arial, Helvetica, sans-serif;">1 WORKSHOP ΠΛΗΡΟΦΟΡΙΚΗΣ</span><br />
    <span style="color:#ff0000; letter-spacing:10px; font:14px/16px Arial, Helvetica, sans-serif;">ΕΠΑΛ ΡΟΔΟΠΟΛΗΣ</span></p>
  </div>
 
<div id="navigation">
  <center>
    <span style="color:#333; letter-spacing:5px; font:14px/16px Arial, Helvetica, sans-serif; font-weight: bolder; ">ΕΠΑΛ ΡΟΔΟΠΟΛΗΣ _ ΡΟΔΟΠΟΛΗ 62055 _ 2327022020 _ epal-rodop at sch.gr</span></p></center>
</div> <!--ΝΑΩΙΓΑΤΙΟΝ ΕND-->
<div id="faux"  >
		 
		       <!-- Begin Left Column -->
    <div id="leftcolumn" style="width:193px; float:left;" >
		         
		           
      <p>&nbsp;</p>
      <p>&nbsp;&nbsp;<a href="managepub.php"><span style="color:#F00; font-size:80%">&#9632;</span>Αρχική Σελίδα</a>    </p> <p>&nbsp;&nbsp;<a href="add_new.php"><span style="color:#F00; font-size:80%">&#9632;</span>Νέα Αίτηση Συμμετοχής </a> </p>
    <p>&nbsp;&nbsp;<a href="participants.php"><span style="color:#F00; font-size:80%">&#9632;</span>Προβολή Αιτήσεων </a> </p>
<p>&nbsp;&nbsp;<a id="linkshow"><span style="color:#F00; font-size:80%">&#9632;</span>Συμμετέχοντες Εκπαιδευτικοί </a> <br />
     <!--<span id="auto"> (Αυτόματα ενεργό από ΧΧ/ΧΧ/ΧΧ και μετά)</span> -->
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
           
  <p>&nbsp;&nbsp;<a href="<?php echo $logoutAction ?>"><span style="color:#F00; font-size:80%">&#9632;</span>Log out</a><br/>
  </p></div>
		       <!-- End Left Column -->
		       <!-- Begin Right Column -->
<div id="rightcolumn" style=" width:775px; height:550px ;color: #333 ; float:left; margin-left:5px">
  <p>&nbsp;</p>
<h2 style="font-family:Verdana, Geneva, sans-serif; color:#000;margin-left:10px">Αιτήσεις Συμμετοχής</h2><br/>
 <br />
 <h3>&nbsp;</h3>
<table id="tblSearch" width="793" height="61" border="1" class="display" style=" margin-left:00px; color:#000" ><thead>
  <tr align="center" style="background-color:#0F0;">
     <th width="156">Επίθετο</th>
    <th width="143">Όνομα</th>
  
    <th width="162">Σχολείο / Υπηρεσία</th>
    <th width="183">Τηλέφωνο Σχολείου</th>

    <th width="169">Ε-mail</th>

  </tr></thead>
  <tbody>
  <?php do { ?>
    
    <tr align="center">
  
            <td><?php echo $row_managers['epitheto']; ?></td>
      <td><?php echo $row_managers['onoma']; ?></td>

      <td><?php echo $row_managers['sxoleio']; ?></td>
      <td ><?php echo $row_managers['tel_sxoleioy']; ?></td>
     
      <td><?php echo $row_managers['email']; ?></td>
  
    </tr>
    <?php } while ($row_managers = mysql_fetch_assoc($managers)); ?></tbody>
</table>





</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<h3>&nbsp;</h3>
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
<?php
mysql_free_result($managers);
?>
