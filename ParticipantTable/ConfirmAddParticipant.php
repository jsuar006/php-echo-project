<?php
  include ("../functions.php"); //includes global functions
  $raceID = $_POST['inpRaceID'];
  $teamID = $_POST['inpTeamID'];
  $driverID = $_POST['inpDriverID'];
  $positionFinished = $_POST['inpPositionFinished'];
  trim($raceID);
  trim($teamID);
  trim($driverID);
  trim($positionFinished);
  //echo "variables have {$driverName} and {$driverDOB}" //debugging only

  //validates the name field, that there is a value entered and that the value is 30 char or less
  if ($teamID==null && $driverID==null && $positionFinished==null){
    session_start();
    $errorMsg = "<script>alert('Please enter a value on at least one of the fields to update.')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location:AddParticipant.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs.
  }

  //will check if anthing was inputed.
  if (!$teamID == null){
    //validates the name field, that there is a value entered and that the value is 30 char or less
    if(strlen($teamID) == 0 || strlen($teamID)>30){
      session_start();
      $errorMsg = "<script>alert('Please enter a value')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location:AddParticipant.php"); //used to return to previous page
      delete_everything();//used to confirm no other script from this page runs.
    };
  };

  // will check to see if there is a value passed to the field
  if (!$driverID == null){
    //validates the name field, that there is a value entered and that the value is 30 char or less
    if(strlen($driverID) == 0 || strlen($driverID)>30){
      session_start();
      $errorMsg = "<script>alert('Please enter a value')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location:AddParticipant.php"); //used to return to previous page
      delete_everything();//used to confirm no other script from this page runs.
    };
  };

  if (!$positionFinished == null){
    //validation of date input if not validated it will trigger an alert and return to the form.
    if(strlen($positionFinished) == 0 || strlen($positionFinished)>30){
      session_start();
      $errorMsg = "<script>alert('Please enter a value')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location:AddParticipant.php"); //used to return to previous page
      delete_everything(); //used to confirm no other script from this page runs.
    };
  };

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
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <h1>Information Added</h1>
    <p>Below was the information succesfully added.</p>
    <table>
      <tr>
        <td>Team ID</td>
        <td><?php echo $_POST["teamID"]?></td>
      </tr>
      <td> Driver ID</td>
      <td><?php echo $_POST["driverID"]?></td>
      <tr>
        <td>Position Finished</td>
        <td><?php echo $_POST["positionFinished"]?></td>
      </tr>
    </table>
    <button type='button' onclick='location.href="../raceparticipant.php"'>Return to Race Participant Info</button>
  </body>
</html>
