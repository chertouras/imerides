<?php 

if (!isset($_SESSION)) {
  session_start();

}
  error_reporting(0);
          if ($_SESSION['MM_Username'] == 'admin') {
      echo  "<p id=\"hiddenlink\">&nbsp;&nbsp;<a href='manage.php'><span style=\"color:#F00; font-size:80%\">&#9632;</span>Διαχείριση Αιτήσεων</a> <br />
      </p>";
	  echo  "<p id=\"maillink\">&nbsp;&nbsp;<a href='mailmanage.php'><span style=\"color:#F00; font-size:80%\">&#9632;</span>Αποστολή email</a> <br />
      </p>"; 
	  
	  	  echo  "<p id=\"parousiologio\">&nbsp;&nbsp;<a href='parousiologio.php'><span style=\"color:#F00; font-size:80%\">&#9632;</span>Παρουσιολόγιο</a> <br />
      </p>"; 
	    echo  "<p id=\"bebaiosis\">&nbsp;&nbsp;<a href='bebaiosis.php'><span style=\"color:#F00; font-size:80%\">&#9632;</span>Βεβαιώσεις Συμμετοχής</a> <br />
      </p>"; 
	  
	    echo  "<p id=\"ektyposeis\">&nbsp;&nbsp;<a href='arxeia.php'><span style=\"color:#F00; font-size:80%\">&#9632;</span>Αρχεία Βεβαιώσεων</a> <br />
      </p>"; 
	  }
	  
	  

?>