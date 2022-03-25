<!-- Webpage to display health workers by selected vaccine site. -->

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Site Workers</title>
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
<h1>Site Workers</h1>
<hr>

<!-- Back to homepage button -->
<form action="covid.php" method="post">

  <input type="submit" value="Back to homepage">
</form>

<!-- List doctors -->
<table>
<?php
   $which_site= $_POST["vaccine_site"];
   echo "<h2>Selected site: " . $which_site . "</h2>";
   echo "<tr><th> First name </th><th> Last name </th></tr>";

   echo "<h3>Doctors:</h3>";
   $query = 'SELECT First_name, Last_name FROM Doctor as d, Doctor_staffs as ds, Vaccine_site as v WHERE d.Unique_ID = ds.Doctor_ID and ds.Vaccine_site_name = v.Name and v.Name = "' . $which_site . '"';
   $result=$connection->query($query);
    while ($row=$result->fetch()) {
	     echo "<tr><td>" .$row["First_name"]."</td><td>".$row["Last_name"]."</td></tr>";
    }

?>
</table>

<!-- List nurses -->
<table>
<?php
   $which_site= $_POST["vaccine_site"];

   echo "<h3>Nurses:</h3>";
   echo "<tr><th> First name </th><th> Last name </th></tr>";
   $query = 'SELECT First_name, Last_name FROM Nurse as n, Nurse_staffs as ns, Vaccine_site as v WHERE n.Unique_ID = ns.Nurse_ID and ns.Vaccine_site_name = v.Name and v.Name = "' . $which_site . '"';
   $result=$connection->query($query);
    while ($row=$result->fetch()) {
	     echo "<tr><td>" .$row["First_name"]."</td><td>".$row["Last_name"]."</td></tr>";
    }

?>
</table>
<?php
   $connection = NULL;
?>
</body>
</html>
