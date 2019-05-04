<?php
  //checks if error message exist and if so alerts user
  session_start();
  if (isset($_SESSION['dateError'])){
    echo "{$_SESSION['dateError']}";
    session_destroy(); // close session so the values are erased.
  }
  //checks if there is a session open for driverId in order to bring back the value used from the original selection, from the return page.
   if(isset($_SESSION['raceID'])){
    $raceID = $_SESSION['raceID'];
  };

  include ("../functions.php"); //includes global functions
  if(isset ($_POST["rowID"])) $raceID = $_POST["rowID"];
  //echo "variables have {$rowID}"; //debugging only


  //connect to db
  $dsn = "mysql:host=localhost;dbname=racingleague";
  $userName = "admin";
  $password = "Pa11word";

  try
  {
    $conn = new PDO($dsn,$userName,$password);
    //echo 'Connected to database<br>'; // only to confirm if connected
    // Prepare and execute the statement
    $query = "SELECT * FROM raceparticipants WHERE RaceID = {$raceID}";

    foreach ($conn->query($query) as $val)
    {

      $raceID = $val['RaceID'];
      $teamID = $val['TeamID'];
      $driverID = $val['DriverID'];
      $positionFinished = $val['PositionFinished'];

    };

   // echo "<p>ID: {$rowID} - Driver Name: {$driverName} -  DriverDOB {$driverDob}</p>"; // to test input from database

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
    <title>Update Participant Information</title>
    <meta charset="utf-8">
    <link href="stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <h1>Update Participant Information</h1>
    <p>Please enter the information you wish to update below and Submit.</p>
    <table>
      <tr>
        <th>Race ID</th>
        <th>Team ID</th>
        <th>Driver ID</th>
        <th>Position Finished</th>
      </tr>
      <tr>
        <!-- <td><?php echo $raceID; ?></td> -->
        <td><?php echo $raceID;?></td>
        <td><?php echo $teamID;?></td>
        <td><?php echo $driverID;?></td>
          <td><?php echo $positionFinished;?></td>
      </tr>
      <tr>
        <!-- form used to pass information to the confirmupddriver page for varification and update of the database.  -->
        <form id="frmUpdate" action="confirmupdparticipant.php" method="post">
          <td><input type="hidden" name="inpRaceID" value="<?php echo $raceID ?>">New Values: </td>
          <td><input type="text" name="inpTeamID" placeholder="Team ID" form="frmUpdate"></td>
          <td><input type="text" name="inpDriverID" placeholder="Driver ID" form="frmUpdate"></td>
          <td><input type="text" name="inpPositionFinished" placeholder="Position Finished" form="frmUpdate"></td>
        </form>
      </tr>
    </table>
    <input type="submit" form="frmUpdate">
    <button type='button' onclick='location.href="../raceparticipant.php"'>Return to Race Participant</button>
  </body>
</html>
