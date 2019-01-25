<html>
<head>
  <title>Kaylee's Recipe Database</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>

<body>
  <h1>Recipe</h1>

  <?php
  $con = pg_connect("user=kyoon password=0559089");
  if (!$con) {
    echo "<script>alert('Error connecting to database');</script>";
    exit;
  }

  //Gets the information from the recipe that was chosen
  $recipeName = $_POST['recipeName'];
  $recipeInstructions = $_POST['recipeInstructions'];

  //Query to get the chosen recipe's ingredient information
  $query = "SELECT ingredientName, units, amountNeeded FROM usedIn WHERE recipeName='$recipeName' AND instructions='$recipeInstructions'";
  $result = pg_query($con, $query);
  if (!$result) {
    $error = pg_last_error($con);
    echo "<script>alert('ERROR!');</script>";
    echo "<div class='error'>'$error'</div>";
    exit;
  }

  //Add the ingredients to a stirng
  while($row = pg_fetch_row($result)) {
    $ingredientList[] = $row[2] . " ". $row[1] . " " . $row[0];
  }
  $ingredients = implode(", ", $ingredientList);

  //Table to display the info
  echo "<table class='recipeTable' align='center' cellpadding='8'>";
  echo "<tr><th>Name</th><th>Ingredients</th><th>Instructions</th></tr>";
  echo "<tr>";
  echo "<td style='min-width:115px'>" . $recipeName . "</td>";
  echo "<td style='min-width:175px'>" . $ingredients . "</td>";
  echo "<td>" . $recipeInstructions . "</td>";
  echo "</tr>";
  echo "</table";
  //Display a home button that takes the user back to the home page
  echo "<div style='text-align:center;'>";
  echo "<input type='image' style='margin:0px auto; display:block;' src='home.png' alt='Home' width='30' height='30' onclick='location.href=\"home.php\"'/>";
  echo "<div>";
  ?>

</body>
</html>
