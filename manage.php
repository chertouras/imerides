<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
//  $_SESSION["id"]=0;
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

mysql_select_db($database_imerida, $imerida);
$query_managers = "SELECT * FROM symmetexontes";
$managers = mysql_query($query_managers, $imerida) or die(mysql_error());
$row_managers = mysql_fetch_assoc($managers);
$totalRows_managers = mysql_num_rows($managers);

$maxRows_managers = 10;
$pageNum_managers = 0;
if (isset($_GET['pageNum_managers'])) {
  $pageNum_managers = $_GET['pageNum_managers'];
}
$startRow_managers = $pageNum_managers * $maxRows_managers;

mysql_select_db($database_imerida, $imerida);
$query_managers = "SELECT id, onoma, epitheto, sxoleio, tel_sxoleioy, regtime, email FROM symmetexontes ORDER BY epitheto ASC";
/*$query_limit_managers = sprintf("%s LIMIT %d, %d", $query_managers, $startRow_managers, $maxRows_managers);*/
$managers = mysql_query($query_managers, $imerida) or die(mysql_error());
$row_managers = mysql_fetch_assoc($managers);

$countSQL="SELECT COUNT(*) FROM symmetexontes ";

$Result2=mysql_query($countSQL, $imerida) or die(mysql_error());
$num_sql = mysql_fetch_array($Result2);
$count = $num_sql[0];


if (isset($_GET['totalRows_managers'])) {
  $totalRows_managers = $_GET['totalRows_managers'];
} else {
  $all_managers = mysql_query($query_managers);
  $totalRows_managers = mysql_num_rows($all_managers);
}
$totalPages_managers = ceil($totalRows_managers/$maxRows_managers)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Διαχείριση Αιτούντων</title>
<script src="jquery-2.0.0.min.js"></script>

<script type="text/javascript" src="DataTables-1.9.4/media/js/jquery.dataTables.min.js"></script>
<link type="text/css" href="main.css" rel="stylesheet"/>
<style type="text/css" title="currentStyle">
    @import "DataTables-1.9.4/media/css/demo_table.css";
</style>
<style type="text/css">
body {font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
}
p, h1, form, button{border:0; margin:0; padding:0;}
.spacer{clear:both; height:1px;}
.hover { background-color:yellow; }
div#rightcolumn {background-image:none} 
#resulttab  tr.even:hover, #resultstab tr.even td.highlighted {
	background-color: #ECFFB3;
}
   #resulttab  tr.odd:hover, #resultstab tr.odd td.highlighted {
	background-color: #ECFFB3;
}
   
  
#resulttab >  thead >tr  {background: #0F0}
table.dataTable tr.odd { background-color:  #FFF; }
table.dataTable tr.even { background-color: #CCC;}



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
var  globalid=0;
var parent;
$("#details").hide(); 
    ShowHide();
$('a[href^="delete.php"]').click(function(e){
	parent = $(this).closest('tr');

	e.preventDefault();


	var href1=new String (this);
		var id = parseInt(href1.split(/=/)[1]);
 
 
 globalid=id; 	
	$.post("deleterow.php",{id:id}, function( data ) {

$("#details").html(data).show();

});//post
 

  
	});
 
$("#rightcolumn").on("click","#cancel",function(){

	$("#details").hide();
	$("#details").hide();});

$("#rightcolumn").on("click","#delete",function(){
		$.post("delete.php",{id:globalid}, function( data ) {
console.log(parent);
	$("#details").hide();
	
	parent.fadeOut(400,function(){ 
// var tr=$(this).parent();
 var pos =  $('#resulttab').dataTable().fnGetPosition(this);
                     $('#resulttab').dataTable().fnDeleteRow(pos);
					
						
                       
					   
					    }); 

});//post
	
	

	});

$('#resulttab').dataTable({"aLengthMenu":  [[10], [10]],
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

$("#hid").replaceWith('<br><br><br><h3> &nbsp;&nbsp; Δεν υπάρχουν αιτήσεις συμμετοχής </h3><br><br>');}



});
</script>




</head>

<body>

<div id="wrapper">

  <div id="header" style="width:1080px">
    <p><span style="color:#000000; letter-spacing:-2px; font:bold 24px/14px Arial, Helvetica, sans-serif;">1o WORKSHOP ΠΛΗΡΟΦΟΡΙΚΗΣ</span><br />
      <span style="color:#ff0000; letter-spacing:10px; font:14px/16px Arial, Helvetica, sans-serif;">ΕΠΑΛ ΡΟΔΟΠΟΛΗΣ</span></p>
  </div>
 
<div id="navigation" style="width:1100px">
  <center>
    <span style="color:#333; letter-spacing:5px; font:14px/16px Arial, Helvetica, sans-serif; font-weight: bolder; ">ΕΠΑΛ ΡΟΔΟΠΟΛΗΣ _ ΡΟΔΟΠΟΛΗ 62055 _ 2327022020 _ epal-rodop at sch.gr</span></p></center>
</div> <!--ΝΑΩΙΓΑΤΙΟΝ ΕND-->
<div id="faux" style="width:1100px">
		 
		       <!-- Begin Left Column -->
    <div id="leftcolumn " style="width:200px; float:left" >
    <p>&nbsp;</p>
    <p>&nbsp;&nbsp;<a href="managepub.php"><span style="color:#F00; font-size:80%">&#9632;</span>Αρχική Σελίδα</a>    
    </p>
    <p>&nbsp;&nbsp;<a href="add_new.php"><span style="color:   #F00; font-size:80%">&#9632;</span>Νέα Αίτηση Συμμετοχής </a></p>
    <p>&nbsp;&nbsp;<a href="participants.php"><span style="color:#F00; font-size:80%">&#9632;</span>Προβολή Αιτήσεων </a></p>  
    <p>&nbsp;&nbsp;<a id="linkshow"><span style="color: #F00; font-size:80%">&#9632;</span>Συμμετέχοντες Εκπαιδευτικοί </a> <br />
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

	  include 'menouadmin.php';
	   ?>
           
    <p>&nbsp;&nbsp;<a href="<?php echo $logoutAction ?>"><span style="color:#F00; font-size:80%">&#9632;</span>Log out</a></p></div>
    <div id="rightcolumn" style=" color:#000; width:900px; height:580px; float:left; margin-left:00px; font-size:10px"><br /><br />
   <span id="hid">   <p> 
      <h3>Διαχείριση Αιτούντων</h3> </p>
      <span style="color:#000"><br />
      </span>
      <p><br/>
</p>

<table id="resulttab" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; width:100%"  class="display">
 <thead> <tr>
    <th>A/A</th>
    <th>Επίθετο</th>
    <th>Όνομα</th>
    
    <th>Σχολείο</th>
    <th>Τηλ. Σχολείου</th>
    <th>Ημερομηνία Εγγραφής</th>
    <th>email</th>
    <th>&nbsp;</th> <th>&nbsp;</th>
  </tr></thead>
  <?php do { ?>
    <tr align="center">
      <td><?php echo $row_managers['id']; ?></td>
      <td><?php echo $row_managers['epitheto']; ?></td> 
      <td><?php echo $row_managers['onoma']; ?></td>
     
      <td><?php echo $row_managers['sxoleio']; ?></td>
      <td><?php echo $row_managers['tel_sxoleioy']; ?></td>
      <td><?php echo $row_managers['regtime']; ?></td>
      <td><?php echo $row_managers['email']; ?></td>
      <td><a href="update.php?id=<?php echo $row_managers['id']; ?>">Επεξεργασία</a></td>
      <td><a href="delete.php?id=<?php echo $row_managers['id']; ?>">Διαγραφή</a></td>
    </tr>
    <?php } while ($row_managers = mysql_fetch_assoc($managers)); ?>
</table>
<br /><br />
<p id="details">
</p>
</span>
</div>




<p>&nbsp;</p>
<div class="clear">Έχετε εισέλθει ως : <span style="background-color:#F00; font-size:12px"><?php echo $_SESSION['MM_Username']; ?></span></div>
  </div>	   
         <!-- End Faux Columns --> 
        <!-- Begin Footer -->
             <div id="footer" style="font-family:Verdana, Geneva, sans-serif; width:1080px ">Δημιουργία πληροφοριακού συστήματος :
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
