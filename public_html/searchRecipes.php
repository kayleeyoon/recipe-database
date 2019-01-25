<html>
<head>
  <title>Kaylee's Recipe Database</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>

<body>
  <h1>Search Recipes</h1>

  <?php
  $con = pg_connect("user=kyoon password=0559089");
  if (!$con) {
    echo "<script>alert('Error connecting to database');</script>";
    exit;
  }
  ?>

  <div class="page">
    <!--search form...when it is submitted, the user is redirected to the next page-->
    <form action="searchRecipes2.php" method="post">
      <label for="recipeNameForSearch">Recipe Name</label>
      <input type="text" id="recipeNameForSearch" name="recipeNameForSearch"/>
      <label for="sourceNameForSearch">Source Name</label>
      <input type="text" id="sourceNameForSearch" name="sourceNameForSearch"/>
      <label for="maxTimeForSearch">Maximum Time</label>
      <input type="number" id="maxTimeForSearch" name="maxTimeForSearch"/>
      <label for="cuisineType">Cuisine Type</label>
      <input type="text" id="cuisineType" name="cuisineType"/>
      <label for="minRating">Minimum Rating</label>
      <input type="number" id="minRating" name="minRating"/>
      <input type="submit" name="searchButton" value="Search"/>
    </form>
  </div>
</body>
</html>
