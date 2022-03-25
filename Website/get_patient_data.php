<!-- Form to display vaccine types. -->

<?php
   $query = "SELECT First_name, Last_name FROM Patient";
   $result = $connection->query($query);
   echo "<h3>Select patient </h3>";
   while ($row = $result->fetch()) {
        echo '<input type="radio" name="patient_name" value="';
        echo $row["First_name"]. " " . $row["Last_name"];
        echo '">' . $row["First_name"] . " " . $row["Last_name"] . "<br>";
   }
?>
