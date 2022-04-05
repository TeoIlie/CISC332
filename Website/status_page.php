<!-- Website to display patient vaccination status. -->

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Patient Status</title>
  <link rel="stylesheet" href="covid_style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Roboto:wght@100&display=swap" rel="stylesheet">
</head>
<body>
<?php
include 'connect_covid_db.php';
?>
<h1>Patient Status</h1>
<hr>

<!-- Back to homepage button -->
<form action="covid.php" method="post">
  <input type="submit" value="Back to homepage">
</form>

<!-- List patient info -->
<table>
<?php
   $patient_OHIP_val = "";
   $which_patient= $_POST["patient_name"];

   // in the case that the site is reached from add_vaccine_record.php, the value is retrieved from GET not POST
   if (empty($which_patient)){
     $which_patient= $_GET["patient_name"];
   }

   echo "<h2> Selected patient: " . $which_patient . "</h2>";
   echo "<h3> Patient information: </h3>";
   echo "<tr><th> First name </th><th> Last name </th><th> OHIP Number </th><th> Birthdate </th></tr>";

   $query = 'SELECT * FROM `Patient` WHERE CONCAT(First_name, " ", Last_name) = "' . $which_patient . '"';
   $result=$connection->query($query);

    while ($row=$result->fetch()) {
	     echo "<tr><td>" .$row["First_name"]."</td><td>".$row["Last_name"]."</td><td>".$row["OHIP_Number"]."</td><td>".$row["Birthdate"]."</td></tr>";
       $patient_OHIP_val = $row["OHIP_Number"];
    }
?>
</table>

<table>
<?php
// List vaccine info for patient in new table

  echo "<h3> Patient vaccinations records: </h3>";

  $query = 'SELECT Vaccination_date, Producer_name FROM Recieves_vaccine as r, Vaccine_lot as v WHERE r.Lot_number = v.Lot_number and Patient_OHIP = "' . $patient_OHIP_val . '" ORDER BY Vaccination_date DESC';
  $result=$connection->query($query);

  if ($result->rowCount() == 0) {
    echo "No matching records found.";
  }
  else {
    echo "<tr><th> Vaccination date </th><th> Vaccine type </th></tr>";
    while ($row=$result->fetch()) {
      echo "<tr><td>" .$row["Vaccination_date"]."</td><td>".$row["Producer_name"]."</td></tr>";
    }
  }

?>
</table>
<p> Note: Most recent immunizations are shown first. </p>

<?php
   $connection = NULL;
?>
</body>
<hr>
<div class="footer">By: Teodor Ilie </div>
</html>
