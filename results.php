<?php
  // Start the session for session variables
  session_start();
  // checking for whether the current user has logged onto the website (F6)
  if (empty($_SESSION["username"])){
    // if not, take the user to the login page (F5)
    header ("Location: login.php");
    exit;
  }
  // detecting whether the logout button has been pressed
  if(isset($_POST["submit"])) {
    // if button pressed, clear current user session id, and take the user to the login page (F5)
    session_destroy();
    echo "<script>window.location = 'login.php'</script>";
  }

  // Code for selecting top 5 typing results of all time
  // connect to the database
  require("db_connection.php");
  // SQL query to select the all the words per minute from the database in descending order
  $query = 'SELECT WPM FROM stats ORDER BY WPM DESC';
  // save the query results into PHP variable $result
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  // format the results into a 2D array
  $top = mysqli_fetch_all($result,MYSQLI_NUM);

  // Code for returning to typing page (F5)
  if(isset($_POST["re-try"])) {
    echo "<script>window.location = 'test.php'</script>";
  }

  // Code for returning to the main page (F5)
  if(isset($_POST["change"])) {
    echo "<script>window.location = 'mainPage.php'</script>";
  }
 ?>
<html>
<head>
  <!-- Tab name, Icon image, Font Link and link to stylesheet -->
  <meta name="viewport" content="width=device-width">
  <title>Results Page</title>
  <link rel="icon" href="images/icon.png">
  <link href='https://fonts.googleapis.com/css?family=Lexend Deca' rel='stylesheet'>
  <link rel="stylesheet" href="teststyles.css">
</head>

<body>
  <header>
    <!-- Create 3 different div/spans for the flex tag, so that the header is space equally. -->
    <span id = "invisible"></span>
    <!-- Display image banner -->
    <div id = "logo-container"><img id="banner" src="images/logoFinal.png"></div>
    <!-- Display log out button (F5)-->
    <div id = "link-container">
      <form id ="logout" action = "" method = "post">
        <input id = "logoutButton" type="submit" name="submit" value="Log out">
      </form>
    </div>
  </header>
  <main id = "resultsFormat">
    <!-- Code for displaying the data from the latest speed type test -->
    <div id="left">
      <u><h1>WPM</h1></u>
      <?php
        // inserts the most recent words per minute onto the html page (F8)
        echo "<h2 class='title'>";
        echo round($_SESSION["wpm"]);
        echo "</h2>";
       ?>
    </div>
    <!-- Code for displaying options for the next speed test or for returning to the menu -->
    <div id="middle">
      <!-- title for results segment -->
      <u><h1>Results</h1></u>
        <!-- display buttons for re-trying the test or changing the time limit -->
        <form action = "" method = "post"><br><br>
          <input id="resultButton" name="re-try" type="submit" value="Re-Try">
          <br><br><br><br>
          <input id="resultButton" name="change" type="submit" value="Change the time limit">
        </form>
    </div>
    <!-- Code for displaying the top 5 highest speeds in the database so far -->
    <div id="right">
      <!-- title for the top 5 values in the database -->
      <u><h1>Top 5 WPM</h1></u>
      <?php
        // loop 5 times
        for ($i=0;$i<5;$i++) {
          // save the variables from a 2D array to a 1D array
          $temp = $top[$i];
          // echo the currection loop position's words per minute to the screen (F8)
          echo "<h2 class = 'topScore'>".($i + 1). ": ".round($temp[0])."</h2>";
        }
       ?>
    </div>
  </main>
</body>
</html>
