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
require_once('Connections/imeridasqli.php'); 

$connecDB=mysqli_connect($hostname_imerida, $username_imerida, $password_imerida,$database_imerida)or trigger_error(mysql_error(),E_USER_ERROR); 
	$connecDB->set_charset("utf8");
    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Αδυμαμία Σύνδεσης: " . mysqli_connect_error();
      }


$results = mysqli_query($connecDB,"SELECT COUNT(*) FROM symmetexontes");
$get_total_rows = mysqli_fetch_array($results);
$item_per_page=10;

$pages = ceil($get_total_rows[0]/$item_per_page);	


if($pages > 1)
{
	$pagination	= '';
	$pagination	.= '<ul class="paginate">';
	for($i = 1; $i<=$pages; $i++)
	{
		$pagination .= '<li><a href="#" class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
	}
	$pagination .= '</ul>';
}
else
$pagination	= '';

?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript" src="jquery-2.0.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#results").load("fetch_pages.php", {'page':0}, function() {$("#1-page").addClass('active');});  //initial page number to load
	
	$(".paginate_click").click(function (e) {
		
		$("#results").prepend('<div class="loading-indication"><img src="ajax-loader.gif" /> Φόρτωση Δεδομένων</div>');
		
		var clicked_id = $(this).attr("id").split("-");
		var page_num = parseInt(clicked_id[0]); 
		
		$('.paginate_click').removeClass('active'); 
		$("#results").load("fetch_pages.php", {'page':(page_num-1)}, function(){

		});

		$(this).addClass('active'); 
		
		return false; 
	});	

 

});
</script>
<link href="stylepg.css" rel="stylesheet" type="text/css">
</head>
<body>
<span id="results" style="height:500px;" ></span>
<?php echo $pagination; ?>
</body>
</html>
