<?php
  include ("../functions.php"); //includes global functions
  $teamName = $_POST["teamName"];
  $teamManager = $_POST["teamManager"];
  trim($teamName);
  trim($teamManager);
  //echo "variables have {$driverName} and {$driverDOB}" //debugging only

  //validates the name field, that there is a value entered and that the value is 30 char or less
  if(strlen($teamName) == 0 || strlen($teamManager)>30){
    session_start();
    $errorMsg = "<script>alert('Name entered must have at least one character with a maximum of 30')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location:formadddriver.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs.
  };
  //validation of date input if not validated it will trigger an alert and return to the form.

  //connect to db
  $dsn = "mysql:host=localhost;dbname=racingleague";
  $userName = "admin";
  $password = "Pa11word";
  try
  {
    $conn = new PDO($dsn,$userName,$password);
    //echo 'Connected to database<br>'; // only to confirm if connected
    // Prepare and execute the statement
  $query = 'INSERT INTO team
                (TeamName, TeamManger)
              VALUES
                (:teamName, :teamManager)';
  $statement = $conn->prepare($query);
  $statement->bindValue(':teamName', $teamName);
  $statement->bindValue(':teamManager', $teamManager);
  $success = $statement->execute();
  $row_count = $statement->rowCount();
  $statement->closeCursor();

  // Get the last product ID that was generated
  $table_id = $conn->lastInsertId();

  //// used for debugging
  // if ($success) {
  //   echo "<p>$row_count row(s) was inserted with this ID: $table_id</p>";
  // } else {
  //   echo "<p>No rows were inserted.</p>";
  // }
  }
  catch(PDOException $e)
  {
    echo $e->getMessage(); //error message if connection fails
  }


  $conn=null; // close the connection
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Information updated</title>
    <meta charset="utf-8">
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <h1>Information Added</h1>
    <p>Below was the information succesfully added.</p>
    <table>
      <tr>
        <td>Team Name</td>
        <td><?php echo $_POST["teamName"]?></td>
      </tr>
      <tr>
        <td>Team Manager</td>
        <td><?php echo $_POST["teamManager"]?></td>
      </tr>
    </table>
    <button type='button' onclick='location.href="../teaminfo.php"'>Return to Team Info</button>
  </body>
</html>
