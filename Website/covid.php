<!DOCTYPE html>
<html>
<!-- The header information -->
<head>
  <meta charset="utf-8">
  <title>COVID Database</title>
  <link rel="stylesheet" href="covid_style.css">
</head>

<!-- The body information -->
<body>
  <h1>Covid Database</h1>
  <hr>
  <!-- Connect to the covid database -->
  <?php
  include 'connect_covid_db.php';
  ?>

  <!-- Find workers by vaccine site -->
  <h2>Search workers by vaccine site</h2>

  <form action="get_workers.php" method="post">

    <?php
    include 'get_site_data.php';
    ?>

    <input type="submit" value="List health workers">
  </form>

  <hr>

  <?php
  $connection =- NULL;
  ?>

</body>
</html>
