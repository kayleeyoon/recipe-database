<html>
<head>
  <title>Kaylee's Recipe Database</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>

<body>
  <h1>Choose the Recipe You Want to Review</h1>

  <?php
  $con = pg_connect("user=kyoon password=0559089");
  if (!$con) {
    echo "<script>alert('Error connecting to database');</script>";
    exit;
  }
  if (isset($_POST['searchRecipeButton'])) {
    //Query the recipes that match the recipe name entered on the previous page
    $query = "SELECT name, instructions FROM recipes WHERE LOWER(name) LIKE LOWER('%$_POST[recipeNameForReview]%')";
    $result = pg_query($con, $query);
    if (!$result) {
      $error = pg_last_error($con);
      echo "<script>alert('ERROR!');</script>";
      echo "<div class='error'>'$error'</div>";
      exit;
    }
    //Display the results in a table
    echo "<table class='recipeTable' align='center' cellpadding='8'>";
    echo "<tr><th></th><th>Name</th><th>Instructions</th></tr>";
    while($row = pg_fetch_row($result)) {
      $recipeName = $row[0];
      $instructions = $row[1];
      echo "<form action='newReview3.php' method='post'>";
      echo "<tr>";
      echo "<td><input type='hidden' value='" . $recipeName . "' name='recipeName' id='recipeName'/>";
      echo "<input type='hidden' value='" . $instructions . "' name='recipeInstructions' id='recipeInstructions'/>";
      //When the recipe is chosen, the user is directed to the next page
      echo "<input type='submit' alt='Choose' value='' id='chooseRecipeButton'/></td>";
      echo "<td style='min-width:125px'>" . $recipeName . "</td>";
      echo "<td>" . $instructions . "</td>";
      echo "</tr>";
      echo "</form>";
    }
    echo "</table>";
  }
  ?>

  </html>
