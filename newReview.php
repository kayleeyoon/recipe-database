<html>
<head>
  <title>Kaylee's Recipe Database</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>

<body>
  <h1>New Review</h1>

  <?php
  $con = pg_connect("user=kyoon password=0559089");
  if (!$con) {
    echo "<script>alert('Error connecting to database');</script>";
    exit;
  }
  ?>

  <div class="page">
    <!--form to search for the recipe to insert a new review-->
    <form action="newReview2.php" method="post">
      <label for="recipeNameForReview">Recipe Name</label>
      <input type="text" id="recipeNameForReview" name="recipeNameForReview">
      <input type="submit" name="searchRecipeButton" value="Search">
    </form>
  </div>

  </html>
