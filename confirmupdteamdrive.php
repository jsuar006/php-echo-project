<?php
  include ("functions.php"); //includes global functions
  // initializes variable being imported from a form.
  $teamID = $_POST["inpteamID"];
  $driverID = $_POST["inpdriverID"];
  trim($teamID);
  trim($driverID);


  session_start();
  $_SESSION['teamID'] = $teamID;
  //echo "variables have {$driverID} {$driverName} and {$driverDOB}"; //debugging only

  // *****************INPUT VALIDATION BELOW *********************

  // will check if there is any input on either fields if not will send an alert and return to the previous page
  if ($teamID==null && $driverID==null){
    session_start();
    $errorMsg = "<script>alert('Please enter a value on at least one of the fields to update.')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location: updatedriver.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs.
  }

  //will check if anthing was inputed.
  if (!$teamID == null){
    //validates the name field, that there is a value entered and that the value is 30 char or less
    if(is_numeric($teamID) == 0 || is_numeric($teamID)>30){
      session_start();
      $errorMsg = "<script>alert('Please enter a value')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location: updatedriver.php"); //used to return to previous page
      delete_everything();//used to confirm no other script from this page runs.
    };
  };

  // will check to see if there is a value passed to the field
  if (!$driverID == null){
    //validation of date input if not validated it will trigger an alert and return to the form.
    if(!is_numeric($driverID)){
      session_start();
      $errorMsg = "<script>alert('Please enter a value')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location: updatedriver.php"); //used to return to previous page
      delete_everything(); //used to confirm no other script from this page runs.
    };
  };

  // *****************INPUT VALIDATION ABOVE *********************

  //connect to db
  $dsn = "mysql:host=localhost;dbname=racingleague";
  $userName = "admin";
  $password = "Pa11word";

  try
  {
    $conn = new PDO($dsn,$userName,$password);
    //echo 'Connected to database<br>'; // only to confirm if connected
    // Prepare and execute the statement
    if (!$teamID == null && !$driverID==null) // Prepare statement only if there is valid input on both fields
    {
      $query = 'UPDATE teamdriver SET
                    TeamID = :teamID, DriverID =  :driverID
                  WHERE
                    TeamID = :teamID';
      $statement = $conn->prepare($query);
      $statement->bindValue(':teamID', $teamID);
      $statement->bindValue(':driverID', $driverID);


       $success = $statement->execute(); //executes the statement
    }else if (!$driverID==null) //Prepares statement only if there is a valid input on the DriverName field
    {
      $query = 'UPDATE teamdriver SET
                    DriverID = :driverID
                  WHERE
                  TeamID = :teamID';
      $statement = $conn->prepare($query);
      $statement->bindValue(':teamID', $driverName);
      $statement->bindValue(':driverId', $driverID);

       $success = $statement->execute(); //executes the statement
    }




    // for debuggin purposes only
    // if ($success) {
    //   echo "<p>Update inserted with this ID: $driverID and $driverName and $driverDOB</p>";
    // } else {
    //   echo "<p>No rows were inserted.</p>";
    // }


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Information updated</title>
    <meta charset="utf-8">
    <link href="stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <h1>Information Updated</h1>
    <?php // this will confirm to the user if a value was updated or not.
     if ($success) {
      echo "<p>Below is the information updated for Team Driver ID: $teamID.</p>";
    } else {
      echo "<p>Error, no values were updated, please try again.</p>";
    }

    ?>
    <table>
      <tr>
        <td>Team ID: </td>
        <td>  <?php echo ($teamID==null) ?  "No Change" :  $teamID ;?></td>
      </tr>
      <tr>
        <td>Driver ID: </td>
        <td><?php echo ($driverID==null)? "No Change" : $driverID ?></td>
      </tr>
    </table>
    <button type='button' onclick='location.href="teamdriverinfo.php"'>Return to Driver Info</button>
  </body>
</html>

<?php

  }
  catch(PDOException $e)
  {
    echo $e->getMessage(); //error message if connection fails
  }

  $conn=null; // close the connection
?>
