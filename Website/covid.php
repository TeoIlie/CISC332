<!-- This is the homepage for the Covid database website. -->
<!DOCTYPE html>
<html>
<!-- The header information -->
<head>
  <meta charset="utf-8">
  <title>COVID Database</title>
  <link rel="stylesheet" href="covid_style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Roboto:wght@100&display=swap" rel="stylesheet">
</head>

<!-- The body information -->
<div class="homepage">
<body>
  <h1>🦠 Covid Database</h1>
  <hr>
  <!-- Connect to the covid database -->
  <?php
  include 'connect_covid_db.php';
  ?>

  <div class="row">
    <div class="column">
      <!-- Enter information for a new or existing patient vaccination -->
      <h2>Add vaccination record</h2>
      <form action="covid.php" id="#form" method="post" name="#form">
        <label><h3>Enter OHIP Number:<h3></label>
        <input id="OHIP" name="OHIP" placeholder='OHIP' type='text' value="">
        <input id='btn' name="submit" type='submit' value='Submit'>

        <?php
        include "redirect.php";
        ?>

      </form>
    </div>

    <div class="column">
      <!-- Show vaccine status of a patient -->
      <h2>Search vaccination status by patient name</h2>
      <form action="status_page.php" method="post">

        <?php
        include 'get_patient_data.php';
        ?>

        <input type="submit" value="Get vaccination status">
      </form>
    </div>
  </div>
  <hr>

  <div class="row">
    <div class="column">
      <!-- Find workers by vaccine site -->
      <h2>Search workers by vaccine site</h2>
      <form action="workers_page.php" method="post">

        <?php
        include 'get_site_data.php';
        ?>

        <input type="submit" value="List health workers">
      </form>
    </div>

    <div class="column">
      <!-- Find vaccine sites by vaccine type -->
      <h2>Search vaccine sites by vaccine type</h2>
      <form action="sites_page.php" method="post">

        <?php
        include 'get_vaccine_data.php';
        ?>

        <input type="submit" value="List vaccine sites">
      </form>
    </div>
  </div>
  <hr>

  <?php
  $connection =- NULL;
  ?>

</body>
</div>
</html>
