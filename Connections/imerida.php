<?php
//Τοποθετείστε τα στοιχεία που θα βρείτε στο control panel του λογαριασμού σας στο ΠΣΔ


$hostname_imerida = "xxxxxxxx";
$database_imerida = "xxxxxxxx";
$username_imerida = "xxxxxxxx";
$password_imerida = "xxxxxxxx";
$imerida = mysql_pconnect($hostname_imerida, $username_imerida, $password_imerida) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_set_charset('utf8',$imerida);

date_default_timezone_set('Europe/Athens');

$dateSrc =date( '2014-02-19 07:50:10'); // Ωρα ανοίγματος συνδέσμου Συμμετέχοντες Εκπαιδευτικοί 
 
$end=strtotime("$dateSrc");


//
//ΠΡΟΣΟΧΗ: ΣΕ ΠΕΡΙΠΤΩΣΗ ΠΟΥ ΥΠΑΡΧΟΥΝ ΔΥΟ ΚΑΤΗΓΟΡΙΕΣ ΣΥΜΜΕΤΕΧΟΝΤΩΝ ΚΑΙ ΥΠΑΡΞΕΙ ΕΛΛΕΙΨΗ ΥΠΟΨΗΦΙΩΝ ΑΠΟ ΤΗ ΜΙΑ ΚΑΤΗΓΟΡΙΑ ΚΑΙ ΠΛΕΟΝΑΣΜΑ 
//ΑΠΟ ΤΗΝ ΑΛΛΗ ΣΥΜΠΛΗΡΩΝΕΤΑΙ Ο ΑΡΙΘΜΟΣ ΤΩΝ ΣΥΜΜΕΤΕΧΟΝΤΩΝ ΑΠΟ ΤΗΝ ΔΕΥΤΕΡΗ ΚΑΤΗΓΟΡΙΑ 
//
//
$mono_mia_omada=0; // (0) δυο ομάδες --- (1) μονο μια ομάδα - ΠΡΟΣΟΧΗ : ΟΙ ΜΕΤΑΒΛΗΤΕΣ $synolo και $omadaA πρέπει να ταυτίζονται όταν επιλέγεις 1 για αυτή την μεταβλητή

//ΠΡΟΣΟΧΗ ΠΡΟΣΟΧΗ ΠΡΟΣΟΧΗ :Η ΜΕΤΑΒΛΗΤΗ $mono_mia_omada  ΑΝ ΔΕΝ ΟΡΙΣΤΕΙ ΑΠΟ ΤΗΝ ΑΡΧΗ  ΚΑΙ ΠΡΙΝ ΤΗΝ ΚΑΤΑΧΩΡΗΣΗ ΟΝΟΜΑΤΩΝ ΣΥΜΜΕΤΕΧΟΝΤΩΝ, 
// ΘΑ ΟΔΗΓΗΣΕΙ ΣΤΟ ΝΑ ΕΜΦΑΝΙΣΤΟΥΝ ΠΡΟΒΛΗΜΑΤΑ ΣΤΗΝ ΛΕΙΤΟΥΡΓΙΑ ΤΗΣ ΕΦΑΡΜΟΓΗΣ - 
$synolo = 10; // Αριθμός Συμμετεχόντων 
$omadaA= 8;  //ΟΜΑΔΑ Α - ΕΚΠΑΙΔΕΥΤΙΚΩΝ (η οτιδηποτε άλλο)
$omadaB=$synolo-$omadaA; // ΟΜΑΔΑ Β - ΔΙΟΙΚΗΤΙΚΩΝ   (η οτιδηποτε άλλο)
//ΣΕ ΚΑΘΕ ΑΛΛΑΓΗ ΤΩΝ ΠΑΡΑΚΑΤΩ ΑΡΙΘΜΩΝ ΚΑΙ ΕΦΟΣΟΝ ΕΧΕΤΕ ΗΔΗ ΔΕΧΤΕΙ ΑΙΤΗΣΕΙΣ ΘΑ ΠΡΕΠΕΙ ΝΑ ΠΑΤΗΣΕΤΕ ΤΟ ΚΟΥΜΠΙ ΕΝΗΜΕΡΩΣΗ ΒΑΣΗΣ ΔΕΔΟΜΕΝΩΝ ΣΤΗΝ ΙΣΤΟΣΕΛΙΔΑ attendants.php - Συμμετέχοντες Εκπαιδευτικo;i 
//
$maximum_arithos_probolis=100;
?>