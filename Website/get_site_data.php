<!-- Form to display vaccine site options. -->

<?php
   $query = "SELECT * FROM Vaccine_site";
   $result = $connection->query($query);
   echo "<h3>Select vaccination site </h3>";
   while ($row = $result->fetch()) {
        echo '<input type="radio" name="vaccine_site" value="';
        echo $row["Name"];
        echo '">' . $row["Name"] . ", " . $row["City"] .  "<br>";
   }
?>
