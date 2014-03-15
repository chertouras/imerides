<?php

require_once('Connections/imerida.php'); 


try {

require("phpmailer/class.phpmailer.php");
$mailaddresses = json_decode(stripslashes($_POST['email']));
$Subject=$_POST['subject'];
$keimeno =$_POST['message']; 
if (isset($_POST['flag'])){
$flag=$_POST['flag'];}
$mail=new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth=true;

//ΣΥΜΠΛΗΡΩΣΤΕ ΜΕ ΤΑ ΣΤΟΙΧΕΙΑ ΤΟΥ ΛΟΓΑΡΙΑΣΜΟΥ ΣΑΣ ΣΤΟ ΠΣΔ ΣΤΗΝ ΕΝΟΤΗΤΑ PHPMAILER

$mail->Host = "XXXXXXXX";
$mail->Username = "XXXXXXXX";
$mail->Password = "XXXXXXXX";



$mail->SMTPDebug   =0; // 2 to enable SMTP debug information
$mail->do_debug = 0;
$mail->From     = "xxxxx@xxxxxxxxxxxxxxxxxxxxxxxxx";
$mail->FromName = "Ειδοποίηση για το 1ο WorkShop Πληροφορικής του ΕΠΑΛ Ροδόπολης";
$mail->Sender = "xxxxxxxxxxxxxxxxxxxxxxxxxxx@xxxxxxxxxxxxxxxxxxxxxxxxxx";
$mail ->CharSet = "UTF-8";
$mail->WordWrap = 50;
$mail->IsHTML(true);
$mail->Subject  = $Subject;
$mail->Body     =  $keimeno;
$mail->AltBody  =  "This is the text-only body";

$count=0;
mysql_select_db($database_imerida, $imerida);
foreach($mailaddresses as $key => $address)
{
$count++;

 $mail->AddAddress($address);

if (isset ($flag) ){
	 $attachment="bebaiosis/".$address.".pdf";
$mail->AddAttachment($attachment);      // attachment
	
	
	}

   $sent = "UPDATE symmetexontes SET sentdate = now(), enimerothike = '1' WHERE email ='$address'"; 
   $Result1 = mysql_query($sent, $imerida) or die(mysql_error());
 


}
if(!$mail->Send())
echo "Το μήνυμα δεν απεστάλει : " . $mail->ErrorInfo;
else
{echo "<br/>";
echo "<h3>Έχετε ήδη επικοινωνήσει με τους παρακάτω ενδιαφερόμενους </h3>";}
echo "<br/>";
echo "<br/>";


$mail->ClearAddresses();
$mail->ClearAttachments();

}



catch (phpmailerException $e ) {

echo '';

}



$emailssent = "select * from  symmetexontes WHERE enimerothike =1"; 
$Result = mysql_query($emailssent, $imerida) or die(mysql_error());


   echo "<table  width='750px' height='61' border='1' class='currentPage' style=' color:#000; margin-bottom:20px;margin-left:25px'>";

 echo "<tr align='center'><td> A / A </td><td> Επίθετο </td><td> Όνομα </td><td> Σχολείο</td><td>Email</td><td>Ημερομηνία</td></tr>";
 while($row = mysql_fetch_array($Result))
          {
 echo "<tr align='center'><td>" . $row['id'] . "</td><td>" . $row['epitheto'] . "</td><td> " . $row['onoma'] . "</td><td>" . $row['sxoleio'] . "</td>
		  <td>" . $row['email'] . "</td> <td>" . $row['sentdate'] . "</td> 
		  
		  </tr>" ; 

          }
 echo "</table>";

mysql_close($imerida);


?>
