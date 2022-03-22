<?php
   $query = "SELECT * FROM Vaccine_site";
   $result = $connection->query($query);
   echo "Select vaccination site </br>";
   while ($row = $result->fetch()) {
        echo '<input type="radio" name="vaccine_site" value="';
        echo $row["Name"];
        echo '">' . $row["Name"] . ", " . $row["City"] .  "<br>";
   }
?>
