<html>
<head>
  <title>Kaylee's Recipe Database</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>

<body>
  <h1>Edit Tool Information</h1>

  <div class="page">
    <?php
    $con = pg_connect("user=kyoon password=0559089");
    if (!$con) {
      echo "<script>alert('Error connecting to database');</script>";
      exit;
    }

    if (isset($_POST['toolName'])) {
      //Gets the information from the tool that was chosen
      $toolName = $_POST['toolName'];
      $toolDescription = $_POST['toolDescription'];
      $toolPrice = $_POST['toolPrice'];

      //Form to enter the new tool price
      echo "<form name='updateToolForm' id='updateToolForm' method='post'>";
      echo "<input type='hidden' value='" . $toolName . "' name='toolName' id='toolName'/>";
      echo "<input type='hidden' value='" . $toolDescription . "' name='toolDescription' id='toolDescription'/>";
      echo "<label for='price'>Price</label>";
      echo "<input type='number' step='0.01' value='" . $toolPrice . "' name='toolPrice' id='toolPrice'/>";
      echo "<input type='submit' name='submitToolUpdate' value='Submit'/>";
      echo "</form>";

      if (isset($_POST['submitToolUpdate'])) {
        //Update the tool
        $update = "UPDATE tools
        SET price = '$_POST[toolPrice]'
        WHERE name = '$_POST[toolName]'
        AND description = '$_POST[toolDescription]'";
        $updateResult = pg_query($con, $update);
        if (!$updateResult) {
          $updateError = pg_last_error($con);
          echo "<script>alert('ERROR!');</script>";
          echo "<div class='error'>'$updateError'</div>";
          exit;
        }
        echo "<script>alert('Success!')</script>";
        //Display a home button that takes the user back to the home page
        echo "<input type='image' src='home.png' alt='Home' width='30' height='30' onclick='location.href=\"home.php\"'/>";
      }
    }
    ?>
  </div>

</body>
</html>
