<?php
  include ("../functions.php"); //includes global functions
  $teamID = $_POST['inpTeamID'];
  $driverID = $_POST['inpDriverID'];
  trim($teamID);
  trim($driverID);

  //echo "variables have {$driverName} and {$driverDOB}" //debugging only

  //validates the name field, that there is a value entered and that the value is 30 char or less
  if ($teamID==null && $driverID==null){
    session_start();
    $errorMsg = "<script>alert('Please enter a value on at least one of the fields to update.')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location:addteamdrive.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs.
  }



  // will check to see if there is a value passed to the field
  if (!$driverID == null){
    //validates the name field, that there is a value entered and that the value is 30 char or less
    if(strlen($driverID) == 0 || strlen($driverID)>30){
      session_start();
      $errorMsg = "<script>alert('Please enter a value')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location:addteamdrive.php"); //used to return to previous page
      delete_everything();//used to confirm no other script from this page runs.
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
  $query = 'INSERT INTO teamdriver
                (TeamID, DriverID)
              VALUES
                (:teamID, :driverID)';
                $statement = $conn->prepare($query);
                $statement->bindValue(':teamID', $teamID);
                $statement->bindValue(':driverID', $driverID);


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

    </table>
    <button type='button' onclick='location.href="../teamdriverinfo.php"'>Return to Team Driver Info</button>
  </body>
</html>
