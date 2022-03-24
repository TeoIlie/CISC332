<!-- Website to display vaccine site availability by selected vaccine type. -->

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Vaccine availability</title>
  <link rel="stylesheet" href="covid_style.css">
</head>
<body>
<?php
include 'connect_covid_db.php';
?>
<h1>Vaccine availability</h1>
<hr>

<!-- Back to homepage button -->
<form action="covid.php" method="post">

  <input type="submit" value="Back to homepage">
</form>

<!-- List sites -->
<table>
<?php
   $which_type= $_POST["vaccine_type"];
   echo "<h2>Selected vaccine type: " . $which_type . "</h2>";
   echo "<p>Note: Sorted in descending order by number of doses available.</p>";

   $query = 'SELECT Site_name AS "Site name", SUM(Number_doses) AS "Available doses" FROM Vaccine_lot WHERE Producer_name = "' . $which_type . '" GROUP BY Site_name ORDER BY Number_doses';
   $result=$connection->query($query);
    while ($row=$result->fetch()) {
	     echo "<tr><td>" .$row["Site name"]."</td><td>".$row["Available doses"]."</td></tr>";
    }

?>
</table>
<?php
   $connection = NULL;
?>
</body>
</html>
