<?php
  //checks if error message exist and if so alerts user
  session_start();
  if (isset($_SESSION['dateError'])){
    echo "{$_SESSION['dateError']}";
    session_destroy(); // close session so the values are erased.
  }
  //checks if there is a session open for driverId in order to bring back the value used from the original selection, from the return page.
   if(isset($_SESSION['raceId'])){
    $raceID = $_SESSION['raceId'];
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
    $query = "SELECT * FROM race WHERE RaceID = {$raceID}";

    foreach ($conn->query($query) as $val)
    {

      $raceID = $val['RaceID'];
      $raceName = $val['RaceName'];
      $raceLocation = $val['RaceLocation'];
      $raceDate = $val['RaceDate'];

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
    <title>Update Race Information</title>
    <meta charset="utf-8">
    <link href="stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <h1>Update Race Information</h1>
    <p>Please enter the information you wish to update below and Submit.</p>
    <table>
      <tr>
        <th>Race ID</th>
        <th>Race Name</th>
        <th>Race Location</th>
        <th>Race Date</th>
      </tr>
      <tr>
        <!-- <td><?php echo $raceID; ?></td> -->
        <td><?php echo $raceID;?></td>
        <td><?php echo $raceName;?></td>
        <td><?php echo $raceLocation;?></td>
          <td><?php echo $raceDate;?></td>
      </tr>
      <tr>
        <!-- form used to pass information to the confirmupddriver page for varification and update of the database.  -->
        <form id="frmUpdate" action="confirmupdrace.php" method="post">
          <td><input type="hidden" name="inpRaceID" value="<?php echo $raceID ?>">New Values: </td>
          <td><input type="text" name="inpRaceName" placeholder="Name of the Race" form="frmUpdate"></td>
          <td><input type="text" name="inpRaceLocation" placeholder="Location for Race" form="frmUpdate"></td>
          <td><input type="text" name="inpRaceDate" placeholder="MM/DD/YYYY" form="frmUpdate"></td>
        </form>
      </tr>
    </table>
    <input type="submit" form="frmUpdate">
    <button type='button' onclick='location.href="../raceinfo.php"'>Return to Race Info</button>
  </body>
</html>
