<?php
  // Start the session for session variables
  session_start();
 ?>
<html>
<head>
  <!-- Tab name, Icon image, Font Link and link to stylesheet -->
  <meta name="viewport" content="width=device-width">
  <title>Sign Up Page</title>
  <link rel="icon" href="images/icon.png">
  <link href='https://fonts.googleapis.com/css?family=Lexend Deca' rel='stylesheet'>
  <link rel="stylesheet" href="teststyles.css">
</head>

<body>
  <?php
    // include the link to the database connection
    require("db_connection.php");
    // condition for checking whether the submit button for the sign up was pressed(F4)
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
      // assign the values for username, password and re-entered in the form will be saved into PHP variables
      $username = ($_POST["Uname"]);
      $password = ($_POST["Pword"]);
      $password2 = ($_POST["Pcheck"]);

      //checking if the password matches the re-entered password(F4)
      $passwordCheck = false;
      if($password == $password2) {
        $passwordCheck = true;
      }

      //checking the username for at least one number (F2a)(F4)
      $NumValid = false;
      foreach(str_split($username) as $char) {
        if(is_numeric($char)){
          $NumValid = true;
        }
      }

      //checking the password for between 4 and 12 characters (F2b)(F4)
      $LenValid = false;
      $length = strlen($password);
      if($length >= 4 and $length <= 12) {
        $LenValid = true;
      }

      //checking the password for at least one number (F2b)(F4)
      $NumValidP = false;
      foreach(str_split($password) as $charP) {
        if(is_numeric($charP)){
          $NumValidP = true;
        }
      }


      //checking to see if all the validations are correct
      if ($passwordCheck && $NumValid && $LenValid && $NumValidP) {
        // SQL query for inserting the valid username and password into the login database (F1)
        $sql = "INSERT INTO login (username,password) VALUES ('$username','$password')";
        // condition for when the data is inserted
        if (mysqli_query($conn, $sql)) {
          // set the username as a session variable to be used else where in the website
          $_SESSION["username"] = $username;
          // take the user to the main page of the website (F5)
          header ("Location: mainPage.php");
          exit;
        } else {
          // data can't be connected then display an error on the website
          "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
      }

      // if the re-entered password isn't valid then display error message on the screen
      if ($passwordCheck == false) {
        echo '<style type="text/css">
              #invalidMatch {
                display: block !important;
              }
              </style>';
      }

      // if the username isn't valid then display error message on the screen
      if ($NumValid == false) {
        echo '<style type="text/css">
              #invalidUsername {
                display: block !important;
              }
              </style>';
      }

      // if the password length isn't valid then display error message on the screen
      if ($LenValid == false) {
        echo '<style type="text/css">
              #invalidLength {
                display: block !important;
              }
              </style>';
      }

      // if the password doesn't contain a number then display error message on the screen
      if ($NumValidP == false) {
        echo '<style type="text/css">
              #invalidNumber {
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
    <!-- Display link to sign up page (F5)-->
    <div id = "link-container"><a id = "loginLink" href = "login.php"> Login </a></div>
  </header>
  <main id = "PageMain">
    <!-- Div with an id for the flex tag, so that the main is space equally -->
    <div id = "formInput">
      <!-- Form for the signup displayed on the webpage, action linking to the PHP at the top this file, with method post -->
      <form action = "" method = "post">
        <!-- username input -->
        <label>Username</label><br>
        <input type="text" name="Uname" size="20" maxlength="20" placeholder="Username"><br><br>
        <!-- password input -->
        <label>Password</label><br>
        <input type="password" name="Pword" size="20" maxlength="12" placeholder="Password"><br><br>
        <!-- re-entered password input -->
        <label>Re-Enter Password</label><br>
        <input type="password" name="Pcheck" size="20" maxlength="12" placeholder="Re-Enter Password"><br><br>
        <!-- singup errors (hidden from the screen until invalid signup) -->
        <p class = "invalid" id = "invalidMatch">Password doesn't match re-entered password</p>
        <p class = "invalid" id = "invalidNumber">Password requires at least one number</p>
        <p class = "invalid" id = "invalidLength">Password must be between 4 and 20 characters</p>
        <p class = "invalid" id = "invalidUsername">Username requires at least one number</p>
        <!-- singup button -->
        <input id="submit" name="submit" type="submit" value="Sign-up">
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
