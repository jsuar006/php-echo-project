<?php
  include ("../functions.php"); //includes global functions
  $teamName = $_POST["TeamName"];
  $teamManager = $_POST["TeamManager"];
  trim($teamName);
  trim($teamManager);

  //validates the name field, that there is a value entered and that the value is 30 char or less
  if(strlen($teamName) == 0 || strlen($teamName)>30){
    session_start();
    $errorMsg = "<script>alert('Name entered must have at least one character with a maximum of 30')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location: addteam.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs.
  };

  //validation of date input if not validated it will trigger an alert and return to the form.
  if(strlen($teamManager) == 0 || strlen($teamManager)>30){
    session_start();
    $errorMsg = "<script>alert('Name entered must have at least one character with a maximum of 30')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location: addteam.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs.
  };

  //connect to db
  $dsn = "mysql:host=localhost;dbname=racingleague";
  $userName = "admin";
  $password = "Pa11word";

  try {
    $conn = new PDO($dsn, $userName, $password);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Allow Exceptions
    //echo 'Connected to database';

    // Prepare and execute SQL statement
    $query = 'INSERT INTO team
                  (TeamName, TeamManager)
                VALUES
                  (:teamName, :teamManager)';
    try {
      $statement = $conn->prepare($query);
      $statement->bindValue(':teamName', $teamName);
      $statement->bindValue(':teamManager', $teamManager);
      $success = $statement->execute();
      $row_count = $statement->rowCount();
      $statement->closeCursor();
    } catch(PDOException $error) {
      echo "<p>Query Failed: " . $error->getMessage() . "</p>";
      }

    // Get the last product ID that was generated
    $table_id = $conn->lastInsertId();

    //// used for debugging
    // if ($success) {
    //   echo "<p>$row_count row(s) was inserted with this ID: $table_id</p>";
    // } else {
    //   echo "<p>No rows were inserted.</p>";
    // }

  } catch(PDOException $e) {
      echo "<p>Connection Failed: " . $e->getMessage() . "</p>"; //error message if connection fails
    }

  $conn=null; // close the connection
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Team Information Updated</title>
    <meta charset="utf-8">
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>

  <body>
    <main>
      <h1>Team Information Added</h1>
      <p>Below was the information succesfully added.</p>
      <table>
        <tr>
          <td>Team Name</td>
          <td><?php echo $_POST["TeamName"]?></td>
        </tr>
        <tr>
          <td> Team Manager</td>
          <td><?php echo $_POST["TeamManager"]?></td>
        </tr>
      </table>
      <br />
      <button type='button' onclick='location.href="../teaminfo.php"'>Return to Team Info</button>
    </body>
  </main>

</html>
