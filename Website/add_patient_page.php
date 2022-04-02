<!-- Website to get new patient data -->

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add New Patient</title>
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
  <h1>Add New Patient</h1>
  <hr>

  <!-- Back to homepage button -->
  <form action="covid.php" method="post">
    <input type="submit" value="Back to homepage">
  </form>

  <?php
    $OHIP_number = $_GET['OHIP'];
    echo "<h3>You entered: " . $OHIP_number . "</h3>";
    echo "<body>Enter information below to add a new record for this patient.</body>";
    $connection = NULL;
  ?>

  <form action="add_patient.php" method="post">

    First name: <input type="text" name="first_name">
    Last name: <input type="text" name="last_name">
    <br>
    Birthday (YYYY-MM-DD): <input type="text" name="birthdate">

    <input type="hidden" name="OHIP" value="<?=$OHIP_number?>">
    <br>
    <input type="submit" value="Add patient">
  </form>

</body>
</html>
