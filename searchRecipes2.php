<html>
<head>
  <title>Kaylee's Recipe Database</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>

<body>
  <h1>Search Results</h1>

  <?php
  $con = pg_connect("user=kyoon password=0559089");
  if (!$con) {
    echo "<script>alert('Error connecting to database');</script>";
    exit;
  }

  //Gets the information from the search form on the previous page
  $searchName = $_POST[recipeNameForSearch];
  $searchSource = $_POST[sourceNameForSearch];
  $searchTime = $_POST[maxTimeForSearch];
  $searchCuisineType = $_POST[cuisineType];
  $searchRating = $_POST[minRating];

  //Part of the query that gets some recipe information and the average rating. More is added to the query below.
  $query = "SELECT recipes.name, recipes.instructions, recipes.cuisineType, recipes.cookTime, recipes.prepTime, recipes.sourceName, avg(rating)
  FROM reviews, recipes
  WHERE reviews.name = recipes.name
  AND reviews.instructions = recipes.instructions";

  //Add where statements if the information was filled in
  if($searchName) {
    $where[] = "LOWER(recipes.name) LIKE LOWER('%$searchName%') ";
  }
  if($searchSource) {
    $where[] = "LOWER(recipes.sourceName) = LOWER('$searchSource') ";
  }
  if($searchTime) {
    $where[] = "recipes.cookTime + recipes.prepTime <= '$searchTime' ";
  }
  if($searchCuisineType) {
    $where[] = "LOWER(recipes.cuisineType) = LOWER('$searchCuisineType') ";
  }

  if(!empty($where)) {
    $query .= ' AND ' . implode(' AND ', $where);
  }

  //Add the group by information
  $query .= " GROUP BY recipes.name, recipes.instructions";

  //If the user wants to have min rating, add the having clause
  if($searchRating) {
    $query .= " HAVING avg(rating) >= '$searchRating'";
  }

  $result = pg_query($con, $query);
  if (!$result) {
    echo "<script>alert('Error searching for the recipe!');</script>";
    $error = pg_last_error($con);
    echo "<div class='error'>'$error'</div>";
    exit;
  }

  //Create the table to display the results
  echo "<table class='recipesTable' align='center' cellpadding='8'>";
  echo "<tr><th>Recipe Name</th><th>Cuisine Type</th><th>Cook Time</th><th>Prep Time</th><th>Total Time</th><th>Source Name</th><th>Rating</th></tr>";
  while($row = pg_fetch_row($result)) {
    $recipeName = $row[0];
    $instructions = $row[1];
    $cuisineType = $row[2];
    $cookTime = $row[3];
    $prepTime = $row[4];
    $totalTime = $cookTime + $prepTime;
    $sourceName = $row[5];
    $rating = round($row[6], 2);

    echo "<form action='searchRecipes3.php' method='post'>";
    echo "<tr>";
    echo "<td><input type='hidden' value='" . $instructions . "' name='recipeInstructions' id='recipeInstructions'/>";
    echo "<input type='hidden' value='" . $recipeName . "' name='recipeName' id='recipeName'/>";
    //When the recipe name is clicked, the user is directed to the next page
    echo "<input type='submit' alt='Choose' value='$recipeName' id='linkButton'/></td>";
    echo "<td>" . $cuisineType . "</td>";
    echo "<td>" . $cookTime . "</td>";
    echo "<td>" . $prepTime . "</td>";
    echo "<td>" . $totalTime . "</td>";
    echo "<td>" . $sourceName . "</td>";
    echo "<td>" . $rating . "</td>";
    echo "</tr>";
    echo "</form>";
  }
  echo "</table>";
  ?>

</body>
</html>
