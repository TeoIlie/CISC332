<!-- Website to add a new vaccine record to the database-->

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Adding New Vaccine Record</title>
  <link rel="stylesheet" href="covid_style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Roboto:wght@100&display=swap" rel="stylesheet">
</head>
<h1>Error Adding New Vaccine Record...</h1>
<hr>

<?php
  $OHIP_number = $_POST['OHIP'];
?>

<!-- Back to homepage button -->
<h3>Error</h3><body> The data was entered incorrectly. </body>
<form action="add_record_page.php" method="get">
  <input type="submit" value="Return">
  <input type="hidden" name="OHIP" value="<?=$OHIP_number?>">
</form>

<body>
<?php
  include 'connect_covid_db.php';
  $OHIP_Number = $_POST['OHIP'];
  $Lot_number = $_POST['Lot_number'];
  $Vaccine_site = $_POST['Vaccine_site'];
  $Vax_date = $_POST['Vax_date'];
  $Vax_time = $_POST['Vax_time'];
  $query = 'INSERT INTO Recieves_vaccine values("'.$Lot_number.'","'.$Vaccine_site.'","'.$OHIP_Number.'","'.$Vax_date.'","'.$Vax_time.'")';
  $result = $connection->exec($query);

  // get patients full name using OHIP to pass to status page
  $patient_name = "Teodor Ilie";
  echo $patient_name;
  $query2 = 'SELECT First_name, Last_name FROM Patient WHERE OHIP_Number = "' . $OHIP_Number . '"';
  $result2 = $connection->query($query2);
  while ($row=$result2->fetch()) {
      $patient_name = $row["First_name"] . " " . $row["Last_name"];
  }
  echo $patient_name;
  $connection = NULL;

  // redirect to status page, and send the patient name as you would from the homepage
  header("Location:http://localhost/status_page.php?patient_name=".$patient_name);
?>
</body>
</html>
