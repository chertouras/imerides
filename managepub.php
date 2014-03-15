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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>1o WORKSHOP Πληροφορικής</title>


<link type="text/css" href="main.css" rel="stylesheet"/>
<style type="text/css">

body {font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
}
p, h1, form, button{border:0; margin:0; padding:0;}
.spacer{clear:both; height:1px;}

div#rightcolumn {background-image:none} 
ol li:nth-child(2n) {  
  background-color: #CF9;
}

ol li:nth-child(2n+1) {  
   background-color: red;
}


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
    <span id="leftcolumn " style=" margin-left:10px; float:left" >
    <p>&nbsp;</p>
    <p>&nbsp;&nbsp;<a href="managepub.php"><span style="color:#F00; font-size:80%">&#9632;</span>Αρχική Σελίδα</a>    
    </p>
    <p>&nbsp;&nbsp;<a href="add_new.php"><span style="color:#F00; font-size:80%">&#9632;</span>Νέα Αίτηση Συμμετοχής </a></p>
    <p>&nbsp;&nbsp;<a href="participants.php"><span style="color:#F00; font-size:80%">&#9632;</span>Προβολή Αιτήσεων </a></p>  
    <p>&nbsp;&nbsp;<a id="linkshow"><span style="color:#F00; font-size:80%">&#9632;</span>Συμμετέχοντες Εκπαιδευτικοί </a> <br />
     <!--<span id="auto"> (Αυτόματα ενεργό από <br /><?php echo $dateSrc; ?> <br /> και μετά)</span> -->
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
               <p>&nbsp;&nbsp;<a href="<?php echo $logoutAction ?>"><span style="color:#F00; font-size:80%">&#9632;</span>Log out</a></p></span>
    <div id="rightcolumn" style=" color:#000;margin-left:25px; width:690px; height:480px">
      <p> <h3> Καλώς ήρθατε στο σύστημα διαχείρισης αιτήσεων</h3> </p>
      <span style="color:#000"><br />
 Δείτε την πρόσκληση συμμετοχής </span><br/>
  </p>
  <p>&nbsp;</p>
  <p>Οδηγίες: </p>
  <p>&nbsp;</p>
  <ol>
  <li style="margin-left:20px; padding:7px"> Επιλέξτε το σύνδεσμο <strong>Νέα Αίτηση Συμμετοχής</strong> και συμπληρώστε τα στοιχεία σας. </li>
 
  <li style="margin-left:20px;padding:7px"> <strong>ΠΡΟΣΟΧΗ</strong>: Τo email και το κινητό σας τηλέφωνο πρέπει να είναι <strong>μοναδικά</strong> (μη χρησιμοποιείτε email ή κινητό που δεν είναι προσωπικά).</li>

  <li style="margin-left:20px;padding:7px"> Θα δείτε στην οθόνη τα στοιχεία που καταχωρήσατε ως επιβεβαίωση της αίτησής σας.</li>
  <li style="margin-left:20px;;padding:7px; background-color:#0F0"> Ο σύνδεσμος <strong>Συμμετέχοντες Εκπαιδευτικοί</strong> θα ανοίξει αυτόματα στις  <strong><?php echo $dateSrc; ?></strong>. Από εκεί θα ενημερωθείτε για τους συμμετέχοντες εκπαιδευτικούς / διοικητικούς.</li> 
  <li style="margin-left:20px;padding:7px"> Μετά από την ημερομηνία αυτή, παρακαλείσθε θερμά, αν υπάρξουν αλλαγές (αδυναμία προσέλευσης κάποιου ενδιαφερόμενου / ης), να με ενημερώσετε στο<strong> chertour@sch.gr</strong>. Ο επόμενος/η  στη σειρά θα ενημερωθεί μέσω email.</li>
  
  <li style="margin-left:20px;padding:7px"> To σύστημα θα δέχεται αιτήσεις συνεχώς και μέχρι την πραγματοποίηση της ημερίδας, ώστε στην περίπτωση επανάληψής της να συμμετέχουν οι επόμενοι στην σειρά,  μη επιλεγέντες, ενδιαφερόμενοι.</li>
 </ol> <p><br/>
  </p>


</div>
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