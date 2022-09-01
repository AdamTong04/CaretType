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
 ?>
 <?php
  // taking the session variable for time limit from the previous page and inserting it into the javascript
  echo "<script>var sec = " . $_SESSION["typingTime"] . ";</script>";
  // include the link to the database connection
  require("db_connection.php");
  // PHP condition to check whether the hidden form for the typing has been submitted
  if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit-btn"])) {
    // save the wpm into a PHP variable
    $wpm = $_POST["wpm"];
    //  save the wpm into a session variable
    $_SESSION["wpm"] = $wpm;
    // set the session username into a local variable
    $username = $_SESSION["username"];
    // SQL query to get the primary key (userID) from the login database for the specific user
    $query = 'SELECT userID FROM login WHERE username LIKE "%'.$username.'%"';
    // save the value from the SQL query into $result
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    // save the userID into the PHP variable $userID
    $userID = mysqli_fetch_array($result)['userID'];
    // SQL insert query to insert the wpm of the current user to the stats database (F8)
    $query2 = "INSERT INTO stats(userID,WPM) VALUES ('$userID','$wpm')";
    // condition to check whether the query has been carried out successfully
    if (mysqli_query($conn, $query2)) {
      // take the user to the results page (F5)
      header ("Location: results.php");
      exit;
    }
   }
  ?>
<html>
  <head>
    <!-- Tab name, Icon image, Font Link and link to stylesheet -->
    <meta name="viewport" content="width=device-width">
    <title>Typing Page</title>
    <link rel="icon" href="images/icon.png">
    <link href='https://fonts.googleapis.com/css?family=Lexend Deca' rel='stylesheet'>
    <link rel="stylesheet" href="teststyles.css">
    <script src="testjava.js"></script>
  </head>

  <!-- main display of the page -->
  <body onload = "create()">
    <header>
      <!-- Create 3 different divs for the flex tag, so that the header is space equally -->
      <!-- Display an anchor tag to link the user back to the main page (F5) -->
      <div id = "menuDiv"><a id="menu"href="mainPage.php">M E N U</a></div>
      <!-- Display image banner -->
      <div id = "logo-container"><img id="banner" src="images/logoFinal.png"></div>
      <!-- Display log out button (F5)-->
      <div id = "link-container">
        <form id ="logout" action = "" method = "post">
          <input id = "logoutButton" type="submit" name="submit" value="Log out">
        </form>
      </div>
    </header>
    <main id="centreType">
      <!-- display prompt for the user to type -->
      <div id="prompt"><p>Start typing to begin the test</p></div>
      <!-- space the text to be typed to display -->
      <!-- One span to colour the correctly typed words, one to colour the incorrect ones, and a final one to colour the untyped ones -->
      <p id="spacing"><span id="typed"></span><span id="incorrect"></span><span id="untyped"></span></p>
      <!-- hidden error message for when the user inputs and incorrect value -->
      <p id = "error">Wrong Character</p>
      <br>
      <!-- display countdown -->
      <div id = "countdown">You have <span id="timer"></span> seconds left!</div>
      <!-- invisible form to store the words per minute of the current test -->
      <form class = "wordsPerMinute" name = "wordsPerMinute" action="" method="post">
        <input type="hidden" name="wpm" value="0" id = "wpm">
        <!-- invisible submit button which will be enter automatically using javascript -->
        <input type = "submit" style = "display: none;" id = "submit-btn" name = "submit-btn">
      </form>
    </main>
  </body>
</html>
