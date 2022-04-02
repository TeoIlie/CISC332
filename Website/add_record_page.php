<!-- Website to add patient vaccination record data. -->

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Vaccination Record</title>
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
  <h1>Add Vaccination Record</h1>
  <hr>

  <!-- Back to homepage button -->
  <form action="covid.php" method="post">
    <input type="submit" value="Back to homepage">
  </form>

  <!-- Add record to existing patient, or create new patient -->
  <?php
    $OHIP_number = $_GET['OHIP'];

    // Display patient name
    echo "<h3>You entered: " . $OHIP_number . "</h3>";
    $query = 'SELECT * FROM Patient WHERE OHIP_Number = "' . $OHIP_number . '"';
    $result=$connection->query($query);
    $row=$result->fetch();
    echo "<body>This OHIP number corresponds to: <b>" . $row["First_name"] . " " . $row["Last_name"] .  ". </b><br>";
    echo "Enter information below to add a vaccination record for this patient.</body>";
  ?>

  <!-- Add vaccination record for patient -->
  <form action="add_vaccine_record.php" method="post">

    <p>
    <!-- Lot number dropdown -->
    Lot Number:
    <select name="Lot_number">
      <option value="">Select...</option>
      <?php
         $query = "SELECT * FROM Vaccine_lot";
         $result = $connection->query($query);
         while ($row = $result->fetch()) {
              echo '<option value="'.$row["Lot_number"];
              echo '">' . $row["Lot_number"] . "<br>";
         }
      ?>
    </select>
    </p>

    <p>
    <!-- Vaccine site dropdown -->
    Vaccine site:
    <select name="Vaccine_site">
      <option value="">Select...</option>
      <?php
         $query = "SELECT * FROM Vaccine_site";
         $result = $connection->query($query);
         while ($row = $result->fetch()) {
              echo '<option value="'.$row["Name"];
              echo '">' . $row["Name"] . "<br>";
         }
      ?>
    </select>
    </p>

    <!-- Vax info -->
    <p>
    Vaccine date (YYYY-MM-DD): <input type="text" name="Vax_date" value=""><br>
    </p>
    <p>
    Vaccine time (HH:MM:SS): <input type="text" name="Vax_time" value=""><br>
    </p>

    <input type="hidden" name="OHIP" value="<?=$OHIP_number?>">
    <input type="submit" value="Add vaccination">
  </form>

  <?php
     $connection = NULL;
  ?>
</body>
</html>
