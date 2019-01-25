<html>
<head>
  <title>Kaylee's Recipe Database</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>

<body>
  <h1>Choose Which Tool You Want to Update</h1>

  <?php
  $con = pg_connect("user=kyoon password=0559089");
  if (!$con) {
    echo "<script>alert('Error connecting to database');</script>";
    exit;
  }
  if (isset($_POST['searchToolButton'])) {
    //Query the tools that match the tool name entered on the previous page
    $query = "SELECT name, description, price FROM tools WHERE LOWER(name) = LOWER('$_POST[toolName]')";
    $result = pg_query($con, $query);
    if (!$result) {
      $error = pg_last_error($con);
      echo "<script>alert('ERROR!');</script>";
      echo "<div class='error'>'$error'</div>";
      exit;
    }
    //Display the results in a table
    echo "<table align='center' cellpadding='8'>";
    echo "<tr><th></th><th>Name</th><th>Description</th></tr>";
    while($row = pg_fetch_row($result)) {
      $name = $row[0];
      $description = $row[1];
      $price = $row[2];
      echo "<form action='updateTool3.php' method='post'>";
      echo "<tr>";
      echo "<td><input type='hidden' value='" . $name . "' name='toolName' id='toolName'/>";
      echo "<input type='hidden' value='" . $description . "' name='toolDescription' id='toolDescription'/>";
      echo "<input type='hidden' value='" . $price . "' name='toolPrice' id='toolPrice'/>";
      //When the tool is chosen, the user is directed to the next page
      echo "<input type='submit' alt='Choose' value='' id='chooseToolButton'/></td>";
      echo "<td>" . $name . "</td>";
      echo "<td>" . $description . "</td>";
      echo "</tr>";
      echo "</form>";
    }
    echo "</table>";
  }
  ?>

</body>
</html>
