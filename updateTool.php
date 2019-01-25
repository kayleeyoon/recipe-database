<html>
<head>
  <title>Kaylee's Recipe Database</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>

<body>
  <h1>Update Tool Price</h1>

  <?php
  $con = pg_connect("user=kyoon password=0559089");
  if (!$con) {
    echo "<script>alert('Error connecting to database');</script>";
    exit;
  }
  ?>

  <div class="page">
    <!--form to search for the tool to update-->
    <form action="updateTool2.php" method="post">
      <label for="toolName">Tool Name</label>
      <input type="text" id="toolName" name="toolName"/>
      <input type="submit" name="searchToolButton" value="Search"/>
    </form>
  </div>

</body>
</html>
