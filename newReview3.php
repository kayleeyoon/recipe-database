<html>
<head>
  <title>Kaylee's Recipe Database</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>

<body>
  <h1>Submit Your Review</h1>

  <div class="page">
    <?php
    $con = pg_connect("user=kyoon password=0559089");
    if (!$con) {
      echo "<script>alert('Error connecting to database');</script>";
      exit;
    }
    $recipeName = $_POST['recipeName'];
    $recipeInstructions = $_POST['recipeInstructions'];
    //Gets the number of reviews already on written for that recipe
    $result = pg_query($con,
    "SELECT count(DISTINCT number) AS reviewCount
    FROM reviews
    WHERE name='$recipeName'
    AND instructions='$recipeInstructions'");
    if(!$result) {
      $error = pg_last_error($con);
      echo "<script>alert('ERROR!');</script>";
      echo "<div class='error'>'$error'</div>";
      exit;
    }
    $recipeNumber = intval(pg_fetch_result($result, reviewCount)) + 1;
    //Form to enter the review information
    echo "<form name='newReviewForm' id='newReviewForm' method='post'>";
    echo "<input type='hidden' id='name' name='name' value='" . $recipeName . "'/>";
    echo "<input type='hidden' id='instructions' name='instructions' value='" . $recipeInstructions . "'/>";
    echo "<input type='hidden' id='number' name='number' value='" . $recipeNumber . "'/>";
    echo "<label for='rating'>Rating</label>";
    echo "<input type='number' id='rating' name='rating'/>";
    echo "<label for='comments'>Comments</label>";
    echo "<textarea rows='4' id='comments' name='comments' form='newReviewForm'></textarea>";
    echo "<input type='submit' name='submitReviewButton' value='Submit Review'/>";
    echo "</form>";

    if (isset($_POST['submitReviewButton'])) {
      $date = date("Y-m-d");
      $comments = htmlspecialchars($_POST['comments']);
      //Inserts the review
      $insert = "INSERT INTO reviews VALUES ('$_POST[rating]', '$date', '$comments', '$_POST[number]', '$_POST[name]', '$_POST[instructions]')";
      $insertResult = pg_query($con, $insert);
      if (!$insertResult) {
        $insertError = pg_last_error($con);
        echo "<script>alert('ERROR!');</script>";
        echo "<div class='error'>'$insertError'</div>";
        exit;
      }
      echo "<script>alert('Success!')</script>";
      //Display a home button that takes the user back to the home page
      echo "<input type='image' src='home.png' alt='Home' width='30' height='30' onclick='location.href=\"home.php\"'/>";
    }
    ?>

  </div>
  </html>
