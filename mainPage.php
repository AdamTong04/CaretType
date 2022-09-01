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
    header ("Location: login.php");
  }

  // condition to check whether the start test button has been pressed
  if(isset($_POST["typingPage"])) {
    // save the time limit from the dropdown
    $typingTime = $_POST["time"];
    $_SESSION["typingTime"] = $typingTime;
    // take the user to the test page
    header ("Location: test.php");
  }
 ?>
<head>
  <!-- Tab name, Icon image, Font Link and link to stylesheet -->
  <meta name="viewport" content="width=device-width">
  <title>Home Page</title>
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
  <main id = "centre">
    <div id = "selectForm">
      <!-- display title for the page -->
      <u><h1>Main Page</h1></u><br>
      <label>Choose a time limit:</label><br><br><br>
      <!-- display dropdown with the time limits (15,30,60 seconds) (F7) -->
      <form action = "" method = "post">
        <select id="timeLimit" name="time">
          <option value="15">15 seconds</option>
          <option value="30">30 seconds</option>
          <option value="60">60 seconds</option>
        </select><br><br><br><br>
        <!-- display button for starting the test -->
        <input id = "startTest" type="submit" name="typingPage" value="Start Test">
      </form>
    </div>
  </main>
</body>
