<html>
  <body>
    <?php
    // initialise variables for database connection
      $host="localhost";
      $DBusername="123123123";
      $DBpassword="123123123";
      $database="typing database";

      // connection attempt using initialised variables
      $conn = mysqli_connect("$host","$DBusername","$DBpassword","$database");

      // display error message if unable to connect to database
      if (!$conn) {
        mysqli_close($conn);
      }
    ?>
  </body>
<html>
