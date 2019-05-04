<?php
  include ("../functions.php"); //includes global functions

  $teamID = $_POST["teamID"];
  $driverID = $_POST["driverID"];
  $positionFinished =$_POST["positionFinished"];

  trim($teamID);
  trim($driverID);
  trim($positionFinished);
  //echo "variables have {$driverName} and {$driverDOB}" //debugging only

  //validates the name field, that there is a value entered and that the value is 30 char or less


  if(is_numeric($teamID) == 0 || is_numeric($teamID)<0){
    session_start();
    $errorMsg = "<script>alert('Name entered must have at least one character with a maximum of 30')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location: AddParticipant.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs.
  };

  if(is_numeric($driverID) == 0 || is_numeric($driverID)<0){
    session_start();
    $errorMsg = "<script>alert('Name entered must have at least one character with a maximum of 30')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location:AddParticipant.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs.
  };

  if(is_numeric($positionFinished) == 0 || is_numeric($positionFinished)<0){
    session_start();
    $errorMsg = "<script>alert('Name entered must have at least one character with a maximum of 30')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location:AddParticipant.php"); //used to return to previous page
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
  $query = 'INSERT INTO raceparticipants
                (TeamID, DriverID, PositionFinished)
              VALUES
                (:teamID, :driverID, :positionFinished)';
  $statement = $conn->prepare($query);
  $statement->bindValue(':teamID', $teamID);
  $statement->bindValue(':driverID', $driverID);
  $statement->bindValue(':positionFinished', $positionFinished);
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
    <link href="stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <h1>Information Added</h1>
    <p>Below was the information succesfully added.</p>
    <table>
      <tr>
        <td>Team ID</td>
        <td><?php echo $_POST["teamID"]?></td>
      </tr>
      <tr>
        <td>Driver ID</td>
        <td><?php echo $_POST["driverID"]?></td>
      </tr>
      <tr>
        <td>Positions Finished</td>
        <td><?php echo $_POST["positionFinished"]?></td>
      </tr>
    </table>
    <button type='button' onclick='location.href="raceparticipant.php"'>Return to Driver Info</button>
  </body>
</html>
