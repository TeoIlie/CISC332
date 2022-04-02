<?php
  include 'connect_covid_db.php';
  if(isset($_POST['submit'])){
    // Fetching variables of the form which travels in URL
    $OHIP_Number = $_POST['OHIP'];
    $query = 'SELECT OHIP_Number FROM Patient WHERE OHIP_Number = "' . $OHIP_Number .'" ';
    $result=$connection->query($query);
    $row=$result->fetch();
    $OHIP_found = $row["OHIP_Number"];

    if ($OHIP_Number == "") {
      echo "<h3>Error</h3><body> No value was entered. Try again.</body>";
    }
    // check the entered number is the right length.
    elseif (strlen($OHIP_Number) != 10) {
      echo "<h3>Error</h3><body> OHIP Number was not 10 characters long. Try again.</body>";
    }

    // redirect to add new patient
    elseif ($OHIP_found == "") {
      header("Location:http://localhost/add_patient_page.php?OHIP=".$OHIP_Number);
    }

    // redirect to add record page for existing patient
    else {
      header("Location:http://localhost/add_record_page.php?OHIP=".$OHIP_Number);
    }
  }
?>
