<!-- Form to display vaccine types. -->

<p>
<!-- Vaccine site dropdown -->
<h3>Select patient </h3>
<select name="patient_name">
  <option value="">Select...</option>
  <?php
     $query = "SELECT First_name, Last_name FROM Patient";
     $result = $connection->query($query);
     while ($row = $result->fetch()) {
          echo '<option value="';
          echo $row["First_name"]. " " . $row["Last_name"];
          echo '">' . $row["First_name"] . " " . $row["Last_name"] . "<br>";
     }
  ?>
</select>
</p>
