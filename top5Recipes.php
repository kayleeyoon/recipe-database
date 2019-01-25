<html>
<head>
  <title>Kaylee's Recipe Database</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>

<body>
  <h1>Top 5 Recipes</h1>

  <?php
  $con = pg_connect("user=kyoon password=0559089");
  if (!$con) {
    echo "<script>alert('Error connecting to database');</script>";
    exit;
  }

  //Query the top 5 recipes, ranked by their rating
  $result = pg_query($con,
  "SELECT recipes.name, recipes.instructions, avg(rating)
  FROM reviews, recipes
  WHERE reviews.name = recipes.name
  AND reviews.instructions = recipes.instructions
  GROUP BY recipes.name, recipes.instructions
  ORDER BY avg(rating) DESC
  LIMIT 5;");
  if (!$result) {
    echo "<script>alert('Error querying the chosen recipe data!');</script>";
    $error = pg_last_error($con);
    echo "<div class='error'>'$error'</div>";
    exit;
  }
  $index = 1;
  //Displays a table with the data
  echo "<table class='topReviewsTable' align='center' cellpadding='8'>";
  echo "<tr><th>#</th><th>Recipe Name</th><th>Average Rating</th></tr>";
  while($row = pg_fetch_row($result)) {
    $recipeName = $row[0];
    $instructions = $row[1];
    $rating = round($row[2], 2);

    echo "<form action='top5Recipes2.php' method='post'>";
    echo "<tr>";
    echo "<td>" . $index . "</td>";
    echo "<td><input type='hidden' value='" . $recipeName . "' name='recipeName' id='recipeName'/>";
    echo "<input type='hidden' value='" . $instructions . "' name='recipeInstructions' id='recipeInstructions'/>";
    //When the recipe name is clicked, the user is directed to the next page
    echo "<input type='submit' alt='Choose' value='$recipeName' id='linkButton'/></td>";
    echo "<td>" . $rating . "</td>";
    echo "</tr>";
    echo "</form>";

    $index++;
  }
  echo "</table>";
  ?>

</body>
</html>
