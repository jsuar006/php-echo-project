<?php 
  //checks if error message exist and if so alerts user
  session_start();
  if (isset($_SESSION['dateError'])){
    echo "{$_SESSION['dateError']}";
    session_destroy(); // close session so the values are erased.
  }
  //checks if there is a session open for driverId in order to bring back the value used from the original selection, from the return page. 
   if(isset($_SESSION['driverId'])){
    $driverID = $_SESSION['driverId'];
  };

  include ("../functions.php"); //includes global functions  
  if(isset ($_POST["rowID"])) $driverID = $_POST["rowID"];
  //echo "variables have {$rowID}"; //debugging only
  

  //connect to db
  $dsn = "mysql:host=localhost;dbname=racingleague";
  $userName = "admin"; 
  $password = "Pa11word";

  try
  {
    $conn = new PDO($dsn,$userName,$password);
    echo 'Connected to database<br>'; // only to confirm if connected
    // Prepare and execute the statement
    $query = "SELECT * FROM driver WHERE DriverID = {$driverID}";
      
    foreach ($conn->query($query) as $val) 
    {

      $rowID = $val['DriverID'];
      $driverName = $val['DriverName'];
      $driverDob = $val['DriverDob'];

    };

    echo "<p>ID: {$rowID} - Driver Name: {$driverName} -  DriverDOB {$driverDob}</p>"; // to test input from database

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
    <title>Update Driver Record</title>
    <meta charset="utf-8">
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <h1>Update Driver Record</h1>
    <p>Please enter the information you wish to update below and Submit.</p>
    <table>
      <tr>
        <th>ID</th>
        <th>Driver Name</th>
        <th>Date of Birth</th>
      </tr>
      <tr>
        <td><?php echo $rowID; ?></td>
        <td><?php echo $driverName;?></td>
        <td><?php echo $driverDob;?></td>
      </tr>
      <tr>
        <form id="frmUpdate" action="confirmupddriver.php" method="post">
          <td><input type="hidden" name="inpdriverId" value="<?php echo $driverID ?>"> </td>
          <td><input type="text" name="inpDriverName" placeholder="First and Last Name" form="frmUpdate"></td>
          <td><input type="text" name="inpDriverDob" placeholder="MM/DD/YYYY" form="frmUpdate"></td>
        </form>
      </tr>
    </table>
    <input type="submit" form="frmUpdate">  
    <button type='button' onclick='location.href="../driverinfo.php"'>Return to Driver Info</button>
  </body>
</html>