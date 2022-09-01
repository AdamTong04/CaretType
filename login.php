<?php
  // Start the session for session variables
  session_start();
?>
<html>
<head>
  <!-- Tab name, Icon image, Font Link and link to stylesheet -->
  <meta name="viewport" content="width=device-width">
  <title>Login Page</title>
  <link rel="icon" href="images/icon.png">
  <link href='https://fonts.googleapis.com/css?family=Lexend Deca' rel='stylesheet'>
  <link rel="stylesheet" href="teststyles.css">
</head>

<body>
  <?php
    // include the link to the database connection
    require("db_connection.php");
    // condition for checking whether the submit button for the login was pressed (F4)
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
      // assign the values for username and password in the form will be saved into PHP variables
      $username = ($_POST["Uname"]);
      $password = ($_POST["Pword"]);

      // SQL query for checking if there is a match for the username and password in the login database (F3)(F4)
      $query = "SELECT userID FROM login WHERE username = '$username' and password = '$password'";;

      // saving the result of the SQL query into the PHP variable $result
      $result = mysqli_query($conn,$query) or die(mysqli_error($conn));

      // if condition for a match in username and password is met then save the username in a session variable and take the user to the main page (F5)
      if (mysqli_num_rows($result) > 0) {
        $_SESSION["username"] = $username;
        header ("Location: mainPage.php");
        exit;
      } else {
      // if condition is not met (invalid login details) display the invalid message saying invalid login
        echo '<style type="text/css">
              #invalidLogin {
                display: block !important;
              }
              </style>';
      }
    }
  ?>
  <header>
    <!-- Create 3 different div/spans for the flex tag, so that the header is space equally. -->
    <span id = "invisible"></span>
    <!-- Display image banner -->
    <div id = "logo-container"><img id="banner" src="images/logoFinal.png"></div>
    <!-- Display link to sign up page (F5) -->
    <div id = "link-container"><a id = "signupLink" href = "signup.php"> Sign Up </a></div>
  </header>
  <main id = "PageMain">
    <!-- Div with an id for the flex tag, so that the main is space equally -->
    <div id = "formInput">
      <!-- Form for the login displayed on the webpage, action linking to the PHP at the top this file, with method post -->
      <form action = "" method = "post">
        <!-- username input -->
        <u><label>Username</label></u><br>
        <input type="text" name="Uname" size="20" placeholder="Username"><br><br><br>
        <!-- password input -->
        <u><label>Password</label></u><br>
        <input type="password" name="Pword" size="20" placeholder="Password"><br>
        <!-- login error (hidden from the screen until invalid login) -->
        <p class = "invalid" id = "invalidLogin">Invalid Login</p><br>
        <!-- Login button -->
        <input id="submit" name="submit" type="submit" value="Login">
      </form>
    </div>
    <!-- Div with an id for the flex tag, so that the main is space equally -->
    <div id = "image">
      <!-- image of a keycap switch -->
      <img id="keycap" src="images/wavekey.png">
    </div>
  </main>
</body>
</html>
