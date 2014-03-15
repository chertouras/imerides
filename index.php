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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "role";
  $MM_redirectLoginSuccess = "managepub.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_imerida, $imerida);
  	
  $LoginRS__query=sprintf("SELECT username, password, role FROM users WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $imerida) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'role');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>1ο WORKSHOP ΠΛΗΡΟΦΟΡΙΚΗΣ</title>



<link type="text/css" href="main.css" rel="stylesheet"/>

<style type="text/css">

body {font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
}
p, h1, form, button{border:0; margin:0; padding:0;}
.spacer{clear:both; height:1px;}


.myform{
	width: 400px;
	padding: 30px;
	margin-top: 30px;
	margin-right: auto;
	margin-bottom: 0;
	margin-left: auto;
}


/* ----------- stylized ----------- */
#stylized{
border:solid 2px #b7ddf2;
background:#ebf4fb;
}
#stylized h1 {
font-size:14px;
font-weight:bold;
margin-bottom:8px;
}
#stylized p{
font-size:11px;
color:#666666;
margin-bottom:20px;
border-bottom:solid 1px #b7ddf2;
padding-bottom:10px;
}
#stylized label{
display:block;
font-weight:bold;
text-align:right;
width:140px;
float:left;
}
#stylized .small{
color:#666666;
display:block;
font-size:11px;
font-weight:normal;
text-align:right;
width:140px;
}
#stylized input{
float:left;
font-size:12px;
padding:4px 2px;
border:solid 1px #aacfe4;
width:200px;
margin:2px 0 20px 10px;
}
#stylized button{
clear:both;
margin-left:100px;
width:125px;
height:31px;
background:#666666 ;
text-align:center;
line-height:31px;
color:#FFFFFF;
font-size:11px;
font-weight:bold;
}




</style>


<script>
/*  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2507314-2', 'sch.gr');
  ga('send', 'pageview');*/

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
    <div id="leftcolumn">
		           <p>&nbsp;</p>
    <p>&nbsp;</p></div>
		       <!-- End Left Column -->
		       <!-- Begin Right Column -->
<div id="rightcolumn" style="color:#960; height:500px; width:900px">
		        <div id="stylized" class="myform" style="margin-left:320px; margin-top:10px; margin-bottom:20px" ><!-- End Right Column -->
			      <center>
<h1>ΚΑΛΩΣ ΗΡΘΑΤΕ </h1>
<h1>ΣΕΛΙΔΑ ΑΙΤΗΣΗΣ ΣΥΜΜΕΤΟΧΗΣ ΣΤΟ 1ο WORKSHOP ΠΛΗΡΟΦΟΡΙΚΗΣ ΤΟΥ ΕΠΑΛ ΡΟΔΟΠΟΛΗΣ</h1>
<H3>&nbsp;</H3>
<H3>&nbsp;</H3>

<form action="<?php echo $loginFormAction; ?>" method="POST" name="login_form" id="login_form">
  
    <label for="username">Όνομα Χρήστη: <span style="color:#900">user</span></label>
    <input type="text" name="username" id="username" />
        <label for="username">Password: <span style="color:#900">user</span></label>
    <input type="password" name="password" id="password" />
    <button	 type="submit"/>"Είσοδος" </button>
<span id="msgbox" style="display:none"></span><br />
<div class="spacer"></div>

</form>
			      
<h4>Παρακαλώ εισάγετε και στα δύο πεδία τη λέξη user για πρόσβαση στο σύστημα</h4>
<p>&nbsp;</p>
			      </center>
		        </div>
		        <span style="margin-left:30px; font:Verdana, Geneva, sans-serif; font-style:oblique; font-weight: bold">ΣΥΝΙΣΤΑΤΑΙ Η ΧΡΗΣΗ FIREFOX ή CHROMΕ. Ο INTERNET EXPLORER ΜΠΟΡΕΙ ΝΑ ΔΗΜΙΟΥΡΓΗΣΕΙ ΠΡΟΒΛΗΜΑΤΑ ΣΤΗΝ ΠΛΟΗΓΗΣΗ</span></div>
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