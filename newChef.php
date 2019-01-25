<html>
<head>
  <title>Kaylee's Recipe Database</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>

<body>
  <h1>New Chef</h1>

  <?php
  $con = pg_connect("user=kyoon password=0559089");
  if (!$con) {
    echo "<script>alert('Error connecting to database');</script>";
    exit;
  }
  ?>

  <div class="page">
    <!--Form to insert a chef-->
    <form name="chefForm" id="chefForm" method="post">
      <label for="chefName">Chef Name</label>
      <input type="text" id="chefName" name="chefName"/>
      <label for="birthdate">Birthday</label>
      <input type="date" id="birthdate" name="birthdate"/>
      <label for="careerInfo">Career Info</label>
      <textarea rows="4" id="careerInfo" name="careerInfo" form="chefForm"></textarea>
      <input type="submit" name="insertChefButton" value="Insert Chef"/>
    </form>

    <?php
    if (isset($_POST['insertChefButton'])) {
      $careerInfo = htmlspecialchars($_POST['careerInfo']);
      //Inserts the query
      $insert = "INSERT INTO chefs VALUES ('$_POST[chefName]', '$_POST[birthdate]', '$careerInfo')";
      $result = pg_query($con, $insert);
      if (!$result) {
        $error = pg_last_error($con);
        echo "<script>alert('ERROR!');</script>";
        echo "<div class='error'>'$error'</div>";
        exit;
      }
      echo "<script>alert('Success!')</script>";
      //Display a home button that takes the user back to the home page
      echo "<input type='image' src='home.png' alt='Home' width='30' height='30' onclick='location.href=\"home.php\"'/>";
    }
    ?>
  </div>
</body>
</html>
