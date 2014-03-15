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

$currentPage = $_SERVER["PHP_SELF"];


if ($mono_mia_omada==1) 
                                   
$maxRows_managers = 10000;
else 
$maxRows_managers = 10;

$pageNum_managers = 0;
if (isset($_GET['pageNum_managers'])) {
  $pageNum_managers = $_GET['pageNum_managers'];
}
$startRow_managers = $pageNum_managers * $maxRows_managers;

mysql_select_db($database_imerida, $imerida);


$query_managers = "SELECT id, onoma, epitheto, sxoleio, tel_sxoleioy, regtime, email,ekpaideytikos FROM symmetexontes WHERE ekpaideytikos =1 and epibebaiosi = 1 ORDER BY regtime ASC ";
$query_limit_managers = sprintf("%s LIMIT %d, %d", $query_managers, $startRow_managers, $maxRows_managers);
$managers = mysql_query($query_limit_managers, $imerida) or die(mysql_error());
$row_managers = mysql_fetch_assoc($managers);




if (isset($_GET['totalRows_managers'])) {
  $totalRows_managers = $_GET['totalRows_managers'];
} else {
  $all_managers = mysql_query($query_managers);
  $totalRows_managers = mysql_num_rows($all_managers);
}
$totalPages_managers = ceil($totalRows_managers/$maxRows_managers)-1;

$maxRows_managedioik = 10;
$pageNum_managedioik = 0;
if (isset($_GET['pageNum_managedioik'])) {
  $pageNum_managedioik = $_GET['pageNum_managedioik'];
}
$startRow_managedioik = $pageNum_managedioik * $maxRows_managedioik;

mysql_select_db($database_imerida, $imerida);
$query_managedioik = "SELECT * FROM symmetexontes WHERE ekpaideytikos = 0 and epibebaiosi = 1 ORDER BY regtime ASC";
$query_limit_managedioik = sprintf("%s LIMIT %d, %d", $query_managedioik, $startRow_managedioik, $maxRows_managedioik);
$managedioik = mysql_query($query_limit_managedioik, $imerida) or die(mysql_error());
$row_managedioik = mysql_fetch_assoc($managedioik);

if (isset($_GET['totalRows_managedioik'])) {
  $totalRows_managedioik = $_GET['totalRows_managedioik'];
} else {
  $all_managedioik = mysql_query($query_managedioik);
  $totalRows_managedioik = mysql_num_rows($all_managedioik);
}
$totalPages_managedioik = ceil($totalRows_managedioik/$maxRows_managedioik)-1;
$pageNum_managers = 0;
if (isset($_GET['pageNum_managers'])) {
  $pageNum_managers = $_GET['pageNum_managers'];
}
$startRow_managers = $pageNum_managers * $maxRows_managers;

$queryString_managers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_managers") == false && 
        stristr($param, "totalRows_managers") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_managers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_managers = sprintf("&totalRows_managers=%d%s", $totalRows_managers, $queryString_managers);

$queryString_managedioik = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_managedioik") == false && 
        stristr($param, "totalRows_managedioik") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_managedioik = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_managedioik = sprintf("&totalRows_managedioik=%d%s", $totalRows_managedioik, $queryString_managedioik);


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
  
  $countekp=$count_num_ekp;
 $countdioik=$count_num_dioik;


$countSQL="SELECT COUNT(*) FROM symmetexontes ";

$Result2=mysql_query($countSQL, $imerida) or die(mysql_error());
$num_sql = mysql_fetch_array($Result2);
$count = $num_sql[0];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Συμμετέχοντες στο Σεμινάριο</title>

<script src="jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="jquery.blockUI.js"></script>
<link type="text/css" href="main.css" rel="stylesheet"/>

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
legend { list-style: none; }
.legend li { float: left; margin-right: 10px; }
.legend span { border: 1px solid #ccc; float: left; width: 25px; height: 12px; margin: 2px; }
/* your colors */
.legend .ekpaideytikos { background-color: red; }
.legend .dioikitikos { background-color: green; }
.loadinggif {
    background: url(ajax-loaderbtn.gif) no-repeat right center;
}
</style>

<script type="text/javascript">

function ShowHide()
{

  
var today= <?php  date_default_timezone_set('Europe/Athens');
$res=date('Y-m-d H:i:s');
$today=strtotime("$res");
echo  strtotime("$res");
//echo (strtotime("now"));
 ?>;

  <?php 
  if ( $end < $today ) 
  {//alert("in");
      echo ' $("#auto").hide();';
 echo '$("#linkshow").attr("href", "attendants.php");';
  }
  ?>
}

$(document).ready(function(){

    ShowHide();

});

</script>



<script type="text/javascript">





var countekp=<?php echo $countekp; ?>;
var countdioik=<?php echo $countdioik; ?>;
var temp1=0;
var temp2=0;
var synolo = <?php echo $synolo ?>;
var aitiseisA =countekp;
var aitiseisB =countdioik;
var epilogiA=0;
var epilogiB=0;
var omadaA = <?php echo $omadaA ?>;
var omadaB = <?php echo $omadaB ?>;
var mono_mia_omada=<?php echo $mono_mia_omada ?>;

$(document).ready(function() {

var count= <?php echo $count; ?>;
if (count == 0 ){
	
	//$("#rightcolumn").
	$("#rightcolumn").removeAttr('style');
	$("#rightcolumn").css('width','650px');
$("#tohide").replaceWith('<br><br><h3> &nbsp;&nbsp; Δεν υπάρχουν αιτήσεις συμμετοχής </h3><br>');}


$("#update").click(function (e){

	e.preventDefault();
	
	$("#update").addClass('loadinggif');
	$.ajax({
   cache: false,
    url: "dbchangeupdt.php",   
}).done(function(){
	
	$( "#update" ).prop('disabled', true);
	$("#update").removeClass('loadinggif');
	$( "#update" ).prop('value', "Ενημερώθηκε");
	
	});

	
	});




$( "#allattendants" ).click(function(e) {
e.preventDefault();
$.ajax({
   cache: false,
    url: "allattendants.php",   
}).done(function(html){
	
	$( "#rightcolumn" ).replaceWith(html).css('margin-bottom','20px');
	
	
	
	});


});


if (mono_mia_omada ==0) //an thelo dio katigories symmetexonton
{

if (aitiseisB >= omadaB)

{
	
	if (aitiseisA >= omadaA)
      {   
	      epilogiA = omadaA ; 
		  epilogiB = omadaB;
		   
		    }	
	else  //aitiseisA < omadaA
	
	   {   epilogiA = aitiseisA ; 
	        epilogiB = synolo -aitiseisA ;
				   
		   }
	
	
	}

else 

{
	if (aitiseisA >= omadaA)
	{
			epilogiA = omadaA +(omadaB-aitiseisB); 
		    epilogiB = aitiseisB;
			}
	else 
	{
		epilogiA = omadaA ; 
		  epilogiB = omadaB;
		
		
		
		}
	
	
	
	
	}

}//if mono mia omada 

else   // Συμμετέχουν μονο οσοι κανουν αιτηση απο τη μια ομάδα μεχρί το μεγιστο αριθμο synolo που εκφράζει το σύνολο των αιτούντων που μπορεί να συμμετέχουν

{    
	
			epilogiA = omadaA ; 
		    epilogiB = 0;
			
	
	
	
	}










$('#table1 tr td:last-child ').each(function(){

	   $(this).filter(function(){
	
		if ( temp1 < epilogiA ){
			temp1++;
			
		return ($(this).text()=="1"); 
		}
		}).parent('tr').css('background-color','red');
		 }); 
		


$('#table2 tr td:last-child ').each(function(){

	   $(this).filter(function(){
		
		if ( temp2 < epilogiB ){
			temp2++;
		
		return ($(this).text()=="0"); 
		}
		}).parent('tr').css('background-color','green'); }); 
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
    <div id="leftcolumn" >
		          <span id="leftcolumn" style="float:left">
		           
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
           </p>
  <p>&nbsp;&nbsp;<a href="<?php echo $logoutAction ?>"><span style="color:#F00; font-size:80%">&#9632;</span>Log out</a><br/>
  </p></span>Έχετε εισέλθει ως : <span style="background-color:#F00"><?php echo $_SESSION['MM_Username']; ?></span></div>
		       <!-- End Left Column -->
		       <!-- Begin Right Column -->
<div id="rightcolumn" style="color:#960; margin-bottom:20px; height:600px">
  <p>&nbsp;</p> <span id="tohide">
<h2 style="color:#000">Συμμετέχοντες Εκπαιδευτικοί <span style=" background-color: red">(με κόκκινο χρώμα)</span>:</h2>
<h3>&nbsp;</h3>
<table id="table1" width="950px" height="61" border="1" class="currentPage" style=" color:#000" >
  <tr align="center">
    <th >A/A</th> 
     <th>Επίθετο</th>
    <th>Όνομα</th>
  
    <td>Σχολείο / Υπηρεσία</th>
    <td>Τηλέφωνο Σχολείου</th>
    <th >Ημερομηνία Εγγραφής</th>
    <th>Ε-mail</th>
    <th style=" display: none;"></th> <th style=" display: none;"></th>
  </tr>
  <tbody>
  <?php do { ?>
    
    <tr align="center">
      <td  ><?php echo $row_managers['id']; ?></td>
            <td><?php echo $row_managers['epitheto']; ?></td>
      <td><?php echo $row_managers['onoma']; ?></td>

      <td><?php echo $row_managers['sxoleio']; ?></td>
      <td ><?php echo $row_managers['tel_sxoleioy']; ?></td>
      <td ><?php echo $row_managers['regtime']; ?></td>
      <td><?php echo $row_managers['email']; ?></td>
    
          <td name="epilogi" style=" display: none; margin:0;padding:0"><?php  echo $row_managedioik['epilogi']; ?></td> <td name="idiotita" style=" display: none; margin:0;padding:0"><?php  echo $row_managers['ekpaideytikos']; ?></td>
    </tr>
    <?php } while ($row_managers = mysql_fetch_assoc($managers)); ?>
</table></tbody>

<p><br />
  <span style="font-family:Verdana, Geneva, sans-serif; color:#003; font-weight:bolder">Εμφανίζονται οι πρώτοι <?php echo min($startRow_managers + $maxRows_managers, $totalRows_managers) ?> αιτούντες από συνολικά <?php echo $totalRows_managers ?> που δήλωσαν συμμετοχή και μπορούν να συμμετέχουν</span><br />
</p>
<p>&nbsp;</p>
 <?php    if ($_SESSION['MM_Username'] == 'admin'){
echo '<p style="float:right"><input id="update" name="update" type="button" value="        Ενημέρωση Βάσης Δεδομένων       " />&nbsp;</p>';} ?>

<p>&nbsp;</p>
<h2 <?php if ($mono_mia_omada==1) echo "hidden" ?> style="color:#000">Συμμετέχοντες Διοικητικοί <span style=" background-color: green">(με πράσινο χρώμα)</span>:</h2>
<h3>&nbsp;</h3>
<table <?php if ($mono_mia_omada==1) echo "hidden" ?> id="table2" width="950px" height="61" border="1" class="currentPage" style=" color:#000" >
  <tr align="center">
    <th  >A/A</th> 
     <th>Επίθετο</th>
    <th>Όνομα</th>
  
    <td>Σχολείο / Υπηρεσία</th>
    <td>Τηλέφωνο Σχολείου</th>
    <th  >Ημερομηνία Εγγραφής</th>
    <th>Ε-mail</th>
  <th style=" display: none;"></th> <th style=" display: none;"></th>
  </tr>
  <tbody>
  <?php do { ?>
    
    <tr align="center">
      <td  ><?php echo $row_managedioik['id']; ?></td>
            <td><?php echo $row_managedioik['epitheto']; ?></td>
      <td><?php echo $row_managedioik['onoma']; ?></td>

      <td><?php echo $row_managedioik['sxoleio']; ?></td>
      <td ><?php echo $row_managedioik['tel_sxoleioy']; ?></td>
      <td ><?php echo $row_managedioik['regtime']; ?></td>
      <td><?php echo $row_managedioik['email']; ?></td>
    
  
         <td name="epilogi" style=" display: none; margin:0;padding:0"><?php  echo $row_managedioik['epilogi']; ?></td>      <td name="idiotita" style=" display: none; margin:0;padding:0"><?php  echo $row_managedioik['ekpaideytikos']; ?></td>
    </tr>
    <?php } while ($row_managedioik = mysql_fetch_assoc($managedioik)); ?>
</table></tbody>

<p><br />
  <span <?php if ($mono_mia_omada==1) echo "hidden" ?> style="font-family:Verdana, Geneva, sans-serif; color:#003; font-weight:bolder">Εμφανίζονται οι πρώτοι <?php echo min($startRow_managedioik + $maxRows_managedioik, $totalRows_managedioik) ?> από συνολικά <?php echo $totalRows_managedioik ?> που δήλωσαν συμμετοχή και μπορούν να συμμετέχουν<br /><br />
  Για την εμφάνιση του σύνολου των αιτούντων εκπαιδευτικών/διοικητικών υπαλλήλων με το σύνολο των στοιχείων της κάθε αίτησης παρακαλώ πατήστε <a href="#" id="allattendants">εδώ</a></span><br />
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><span class="currentPage" style="float: none; margin-left:610px">Επιλεγέντες</span><br />
</p>
<ul class="legend" style="float:right; margin-bottom:19px">
  <li style="list-style:none;<?php if ($mono_mia_omada==1) 
                                    echo 'margin-left:-240px;"';
                                  else
                                    echo '"'; 
  
  ?>><span class="ekpaideytikos"></span> Εκπαιδευτικός</li>
    <li <?php if ($mono_mia_omada==1) echo "hidden" ?> style="list-style:none"><span  class="dioikitikos"></span>Διοικητικός</li>
    
</ul>
<br /></span>
</div>

<div class="clear"></div>
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

mysql_free_result($managedioik);
?>
