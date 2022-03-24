<!-- Form to display vaccine types. -->

<?php
   $query = "SELECT * FROM Pharmaceutical_company";
   $result = $connection->query($query);
   echo "<h3>Select vaccine type </h3>";
   while ($row = $result->fetch()) {
        echo '<input type="radio" name="vaccine_type" value="';
        echo $row["Name"];
        echo '">' . $row["Name"] . "<br>";
   }
?>
