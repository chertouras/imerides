<?php

require_once('Connections/imerida.php'); 



/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).



require_once('../../tcpdf/tcpdf.php');

// create new PDF document
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
      //  $image_file =	'mainlogo_p8.png';
   //    $this->Image($image_file, 10, 10, 15, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
     //   $this->SetFont('dejavusans', 'B', 20);
        // Title
       // $this->Cell(0, 15, '1o Workshop Πληροφορικής ΕΠΑΛ Ροδόπολης', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
		 $this->SetX(+15);
        // Set font
        $this->SetFont('dejavusans', 'B', 10);
        // Page number
        $this->Cell(0, 10, '1o Workshop Πληροφορικής ΕΠΑΛ Ροδόπολης ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
/*$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('K.Chertouras');
$pdf->SetTitle('Βεβαιώση Συμμετοχής');
$pdf->SetSubject('1o WorkShop Πληροφορικής');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$pdf->setFontSubsetting(true);
// set font
$pdf->SetFont('dejavusans', '', 14, '', true);
*/
// add a page


$parontes = json_decode(stripslashes($_POST['parousia']));
mysql_select_db($database_imerida, $imerida);

echo '<br><br/> <br/>';
echo	"<style>


   
#resulttab >  thead >tr  {background: #0F0}
#resulttab tr:nth-child(odd) td { background: #FFF; }
#resulttab tr:nth-child(even) td { background: #CCC;	 }
 #resulttab  tr:hover td { background: #F00}

	</style>	";
	echo '<h3> Για τους παρακάτω συμμετέχοντες δημιουργήθηκαν βεβαιώσεις συμμετοχής </h3><br><br>';
	echo '<table  align="center" width="100%" id="resulttab" border="1" cellpadding="1" cellspacing="0" style="border-collapse:collapse; text-align:center; "><thead><tr>
    <th>A/A</th>
    <th>Όνομα</th>
    <th>Επίθετο</th>
    <th>Σχολείο</th>
  
    <th>Τηλέφωνο</th>
    <th>email</th>

  </tr></thead><tbody>';
	




foreach($parontes as $key => $paron)
{
   
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('K.Chertouras');
$pdf->SetTitle('Βεβαιώση Συμμετοχής');
$pdf->SetSubject('1o WorkShop Πληροφορικής');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$pdf->setFontSubsetting(true);
// set font
$pdf->SetFont('dejavusans', '', 14, '', true);
   $sent = "Select *from  symmetexontes WHERE id ='$paron'"; 
   $Result1 = mysql_query($sent, $imerida) or die(mysql_error());
   $row_bebaiosi = mysql_fetch_assoc($Result1);



$pdf->AddPage('L', 'A4');
$epitheto =$row_bebaiosi["epitheto"];
$onoma=$row_bebaiosi["onoma"];

$grammtit1='ΒΕΒΑΙΩΣΗ ΣΥΜΜΕΤΟΧΗΣ στο';
$grammtit2='1 WORKSHOP ΠΛΗΡΟΦΟΡΙΚΗΣ του ΕΠΑΛ ΡΟΔΟΠΟΛΗΣ ';

$grammi1='«Δημιουργία ενός δυναμικού δικτυακού τόπου διαχείρισης βάσης δεδομένων MySQL ';
$grammi2='(Create Read Update Delete) με τη χρήση του πακέτου Abode Dreamweaver και εγκατάστασή της στο Πανελλήνιο Σχολικό Δίκτυο»&nbsp;';

// set some text to print
$html ='<table   border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td ><img src="mainlogo_p8.png" width="425" height="46" /></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>ΕΠΑΛ ΡΟΔΟΠΟΛΗΣ</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>ΡΟΔΟΠΟΛΗ 62055</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" style=" font-size:24px">'.$grammtit1.' </td>
  </tr>
  <tr>
    <td colspan="3" align="center"><span style=" font-size:24px">'.$grammtit2.'</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">Βεβαιώνεται ότι ο εκπαιδευτικός '.$epitheto.' '. $onoma.'</td>
  </tr>
  <tr>
    <td colspan="3" align="center">παρακολούθησε την ημερίδα που διεξήχθησε στο σχολείο μας στις 14-02-2014 με θέμα</td>
  </tr><tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr><tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">'.$grammi1.'</td>
  </tr>
  <tr>
    <td colspan="3" align="center">'.$grammi2.'</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O Εισηγητής </td><td>Ο Διευθυντής</td>
  </tr>
</table>';






 /*<<<EOF

Βεβαιώνεται οτι ο εκπαιδευτικός <br> <br>  $epitheto &nbsp; &nbsp; $onoma  <center><br> 
Δημιουργία με CRUD εφαρμογής με την χρήση των Server Behaviours του Adobe Dreamweaver CS6

test

Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
EOF;
*/
// print a block of text using Write()
$pdf->writeHTML($html, true, false, true, false, '');
//ob_end_clean();

/*$filename= "{$membership->id}.pdf"; 
         $filelocation = "D:\\wamp\\www\\project\\custom";//windows
              $filelocation = "/var/www/project/custom"; //Linux

        $fileNL = $filelocation."\\".$filename;//Windows
            $fileNL = $filelocation."/".$filename; //Linux

        $this->pdf->Output($fileNL,'F');*/
   $pdf->lastPage();

$filelocation = ".\\bebaiosis";
$fileNL=$filelocation."\\".$row_bebaiosi ["email"].'.pdf';
$pdf->Output($fileNL,'F');
//	$pdf->Output('example_001.pdf', 'I');



//echo "<li style=\"font-size:18px;\"> $epitheto </li>";
	echo "<tr><td>".$row_bebaiosi['id']."</td> 
		
		
		
		<td>".$row_bebaiosi['onoma']."</td> 
		<td>".$row_bebaiosi['epitheto']."</td> 
		<td>".$row_bebaiosi['sxoleio']."</td> 
		<td>".$row_bebaiosi ["mobile"]."</td> 
			<td>".$row_bebaiosi ["email"]."</td> 
			</tr>";
		
		
	
	



}
	echo "<tbody></table>";
//echo "</ol>";



//$mail->AddAddress("chertour@sch.gr");
//$mail->Subject = "1 WorkShop Πληροφορικης";
//$mail->Body = "Hi,This system is working perfectly.";
/*mysql_select_db($database_imerida, $imerida);
foreach($mailaddresses as $key => $address)
{
   $mail->AddAddress($address);
 //$address=  str_replace('"', "", $address);
   $sent = "UPDATE symmetexontes SET sentdate = now(), enimerothike = '1' WHERE email ='$address'"; 
   $Result1 = mysql_query($sent, $imerida) or die(mysql_error());

}
// Αποστολή μηνύματος

$mail -> Send();
$mail->SmtpClose();




if(!$mail->Send())
echo "Το μήνυμα δεν απεστάλει : " . $mail->ErrorInfo;
else
echo "<h3>Το μήνυμα απεστάλει </h3>";
echo "<br/>";
echo "<br/>";
echo "<br/>";

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

mysql_close($imerida);*/


?>
