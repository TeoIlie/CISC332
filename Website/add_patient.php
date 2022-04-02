<!-- Website to add a new patient to the database-->

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Adding New Patient</title>
  <link rel="stylesheet" href="covid_style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Roboto:wght@100&display=swap" rel="stylesheet">
</head>
<h1>Adding New Patient...</h1>
<hr>

<?php
  $OHIP_number = $_POST['OHIP'];
?>

<!-- Back to homepage button -->
<h3>Error</h3><body> The data was entered incorrectly. </body>
<form action="add_patient_page.php" method="get">
  <input type="submit" value="Return">
  <input type="hidden" name="OHIP" value="<?=$OHIP_number?>">
</form>

<body>
<?php
  include 'connect_covid_db.php';
  $OHIP_Number = $_POST['OHIP'];
  $First_name = $_POST['first_name'];
  $Last_name = $_POST['last_name'];
  $Birthdate = $_POST['birthdate'];
  $query = 'INSERT INTO Patient values("'.$First_name.'","'.$Last_name.'","'.$OHIP_Number.'","'.$Birthdate.'")';
  $result = $connection->exec($query);
  $connection = NULL;
  header("Location:http://localhost/add_record_page.php?OHIP=".$OHIP_Number);
?>
</body>
</html>
