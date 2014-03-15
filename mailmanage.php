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

$maxRows_managers = 10;
$pageNum_managers = 0;
if (isset($_GET['pageNum_managers'])) {
  $pageNum_managers = $_GET['pageNum_managers'];
}
$startRow_managers = $pageNum_managers * $maxRows_managers;

mysql_select_db($database_imerida, $imerida);
$query_managers = "SELECT id, onoma, epitheto, sxoleio, tel_sxoleioy, email, regtime, epilogi , enimerothike FROM symmetexontes ORDER BY epilogi DESC, id ASC, regtime ASC";
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
<title>Ειδοποίηση με email</title>
<script src="jquery-2.0.0.min.js"></script>

<script type="text/javascript" src="jquery.blockUI.js"></script>
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


.formfield * {
    vertical-align: top;resize: none;
}


div#rightcolumn {background-image:none} 
.hover { background-color:yellow; }
.actualgradient
{
background: -moz-linear-gradient(left, rgba(30,87,153,1) 0%, rgba(124,184,231,1) 99%, rgba(125,185,232,0) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(30,87,153,1)), color-stop(99%,rgba(124,184,231,1)), color-stop(100%,rgba(125,185,232,0))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(left, rgba(30,87,153,1) 0%,rgba(124,184,231,1) 99%,rgba(125,185,232,0) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(left, rgba(30,87,153,1) 0%,rgba(124,184,231,1) 99%,rgba(125,185,232,0) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(left, rgba(30,87,153,1) 0%,rgba(124,184,231,1) 99%,rgba(125,185,232,0) 100%); /* IE10+ */
background: linear-gradient(to right, rgba(30,87,153,1) 0%,rgba(124,184,231,1) 99%,rgba(125,185,232,0) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e5799', endColorstr='#007db9e8',GradientType=1 ); /* IE6-9 */
}


.actualgradient2
{
    
    /* IE10 Consumer Preview */ 
  background: rgb(255,26,0); /* Old browsers */
background: -moz-linear-gradient(left, rgba(255,26,0,1) 50%, rgba(0,32,214,1) 50%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, right top, color-stop(50%,rgba(255,26,0,1)), color-stop(50%,rgba(0,32,214,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(left, rgba(255,26,0,1) 50%,rgba(0,32,214,1) 50%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(left, rgba(255,26,0,1) 50%,rgba(0,32,214,1) 50%); /* Opera 11.10+ */
background: -ms-linear-gradient(left, rgba(255,26,0,1) 50%,rgba(0,32,214,1) 50%); /* IE10+ */
background: linear-gradient(to right, rgba(255,26,0,1) 50%,rgba(0,32,214,1) 50%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff1a00', endColorstr='#0020d6',GradientType=1 ); /* IE6-9 */
    

}

.hide{

display: none;

}


#resultstab  tr.even:hover, #resultstab tr.even td.highlighted {
	background-color: #ECFFB3;
}
   #resultstab  tr.odd:hover, #resultstab tr.odd td.highlighted {
	background-color: #ECFFB3;
}
   
  
#resultstab >  thead >tr  {background: #0F0}

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
 
  $(':checkbox').each(function() {
            $(this).prop('checked',localStorage.getItem(this.name) == 'checked').closest("tr").css("background-color", this.checked ? "red" : "");	
        });
 ShowHide();

$(".chkbCsm").on("click", function() {
    
	
	 var name = this.name;
      var value = this.value;

         if($(this).is(':checked')){
            
             //shorthand to check that localStorage exists
             localStorage && localStorage.setItem(this.name,'checked');

          } else {
   
             //shorthand to check that localStorage exists
             localStorage && localStorage.removeItem(this.name);
          }
	
	
	$(this).closest("tr").css("background-color", this.checked ? "red" : "");
	
	});




//SUBMIT FORM  AND EMAIL

$("#apostoli").click(function(e){
    e.preventDefault();
    var keyArray = new Array();	
   for (var key in localStorage){
   keyArray.push(key);
   
   }
   keyArray=JSON.stringify(keyArray);
 
  
   var data = {
	   
    subject: $("#subject").val(),
    email: keyArray,
    message: $("#keimeno").val()
};
   $.ajax({
    type: "POST",
    url: "mailphp.php",
    data: data,
    
	    beforeSend: function() {
           
			 
			},
            complete: function() {
        
			},
	
	success: function(data){
      $("#rightcolumn").html(data);
    }
});

localStorage.clear();

   }); //end click

$('#resultstab tr').not(':first').hover(function() {
    $(this).addClass('hover');
	
}, function() {
    $(this).removeClass('hover');
});

});

            



$(document).ready(function() { 
    //$.blockUI.defaults.css = {};
	
    $(document).ajaxStart(function() { 
        $("#rightcolumn").block({ message: 'Αποστολή email...',
                css: { border: '3px solid #a00' } }); 
		
		                               });           

  
  $(document).ajaxStop(function(){ $("#rightcolumn").unblock();});
  
  
   
  
   });
$(document).ready(function() {
 
$('#resultstab tr').each(function() {

var value = parseInt($(this).find("td:eq(7)").html());  
var valuenim = parseInt($(this).find("td:eq(8)").html()); 
 if (value == 1){
	 
	 if (valuenim==0)
	 
	 $(this).find('td:eq(0),td:gt(0)').addClass("actualgradient");
	 else 
	  $(this).find('td:eq(0),td:gt(0)').css('background-color', ' red');

}
});


$('#resultstab').dataTable({"aLengthMenu":  [[10], [10]],"aaSorting": [],
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



$( window ).unload(function() {
localStorage.clear(); 
});

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
    <div id='loader' style=" display:none"><img src="ajax-loader.gif"/> </div>
 <!--  <div id="refresh" style=" color:#000; width:870px; height:580px; float:left; margin-left:20px">-->
    <div id="rightcolumn" style=" color:#000; width:890px; height:857px; float:left; margin-left:0px; font-size:11px">
    <span id="hid">  <br />   
      <h2>Ειδοποίηση με email</h2> 
      <span style="color:#000">
      </span><br />   <br />
   
Παρακαλώ επιλέξτε με &#10004 τους εκπαιδευτικούς που θέλετε να ενημερώσετε μέσω E-mail <br />
σχετικά με την συμμετοχή τους στην εκδήλωση
<p style=" margin-bottom:10px"></p>
<table id="resultstab" border="1" cellpadding="1" cellspacing="0" style="border-collapse:collapse; width:100%" class="display" ><thead>
  <tr>
    <th>A/A</th>
    <th>Όνομα</th>
    <th>Επίθετο</th>
    <th>Σχολείο</th>
    <th>Τηλέφωνο Σχολείου</th>
    <th>Ημερομηνία Εγγραφής</th>
    <th>email</th>
    <th class="hide">Προκρίθηκε?</th>
        <th class="hide">Eνημερώθηκε?</th>
    <th>&#10004 </th> 
  </tr></thead>
  <?php do { ?>
    <tr align="center">
      <td ><?php echo $row_managers['id']; ?></td>
      <td><?php echo $row_managers['onoma']; ?></td>
      <td><?php echo $row_managers['epitheto']; ?></td>
      <td><?php echo $row_managers['sxoleio']; ?></td>
      <td><?php echo $row_managers['tel_sxoleioy']; ?></td>
      <td><?php echo $row_managers['regtime']; ?></td>
      <td><?php echo $row_managers['email']; ?></td>
        <td  class="hide"><?php echo $row_managers['epilogi']; ?></td>
          <td class="hide"><?php echo $row_managers['enimerothike']; ?></td>
      <td align="center"> <input type="checkbox" class ="chkbCsm" name="<?php echo $row_managers['email']; ?>" value="<?php echo $row_managers['email']; ?>" /></td>
     <!--mailCB[]-->
    </tr>
    <?php } while ($row_managers = mysql_fetch_assoc($managers)); ?>
</table><br /><br />
 <div style="border: 1px solid #ccc; float: left; width: 25px; height: 12px; margin: 2px;" class="actualgradient" ></div> 
 Επιλέγχθηκαν / Δεν ειδοποιήθηκαν<br />  <br /><div style="float: left;border: 1px solid #ccc;  width: 25px; height: 12px; margin: 2px; background-color:red" > </div>
 Επιλέγχθηκαν / Eιδοποιήθηκαν (<strong>ΠΡΟΣΟΧΗ: </strong>Το ΠΣΔ δεν υποστηρίζει λειτουργίες επιβεβαίωσης λήψης του email)
 <br /> 

<p>&nbsp;</p>
<p>&nbsp;</p>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <p>
    <label for="subject">Θέμα</label>
    :   &nbsp;	
    <input name="subject" type="text" id="subject" size="80" />
  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p class="formfield" style="position: relative;  display: inline-block;" >
    <label for="keimeno">Κείμενο:</label>
    <textarea name="keimeno" id="keimeno" cols="75" rows="6"></textarea><br />
  <input id="apostoli" name="apostoli" type="submit" lang="el" value="Αποστολή" style="float: left; margin-left:54px" />
  <input type="button" value="Καθαρισμός Φόρμας" id="btn_click" onClick="this.form.reset();localStorage.clear();  location.reload(); " />
  (θα γίνει επαναφόρτωση της σελίδας)
 </p>
  
     

  <p class="formfield" >&nbsp;</p>
  <p class="formfield" >&nbsp;</p>
</form>
<p>&nbsp;</p></span>
    </div>
    
<!--  </div> -->
    
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="clear">Έχετε εισέλθει ως : <span style="background-color:#F00;"><?php echo $_SESSION['MM_Username']; ?></span></div>
  </div>	   
         <!-- End Faux Columns --> 
        <!-- Begin Footer -->
             <div id="footer" style="font-family:Verdana, Geneva, sans-serif; width:1080px ">Δημιουργία πληροφοριακού συστήματος :
     <span style="color:#009; letter-spacing:-1px; font-family:Verdana, Geneva, sans-serif;"><span style="color:#cf4d3f;font-size:80%">&#9632;</span>Χερτούρας Κωνσταντίνος</span>
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
