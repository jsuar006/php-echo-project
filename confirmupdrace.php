<?php
  include ("../functions.php"); //includes global functions
  // initializes variable being imported from a form.
  $raceID = $_POST["inpRaceID"];
  $raceName = $_POST["inpRaceName"];
  $raceLocation = $_POST["inpRaceLocation"];
  $raceDate = $_POST["inpRaceDate"];
  trim($raceName);
  trim($raceLocation);
  trim($raceDate);

  session_start();
  $_SESSION['raceID'] = $raceID;
  //echo "variables have {$raceID} {$raceName} and {$raceLocation}"; //debugging only

  // *****************INPUT VALIDATION BELOW *********************

  // will check if there is any input on either fields if not will send an alert and return to the previous page
  if ($raceName==null && $raceLocation==null && $raceDate==null){
    session_start();
    $errorMsg = "<script>alert('Please enter a value on at least one of the fields to update.')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location:updatedrace.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs.
  }

  //will check if anthing was inputed.
  if (!$raceName == null){
    //validates the name field, that there is a value entered and that the value is 30 char or less
    if(strlen($raceName) == 0 || strlen($raceName)>30){
      session_start();
      $errorMsg = "<script>alert('Name entered must have at least one character with a maximum of 30')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location:updaterace.php"); //used to return to previous page
      delete_everything();//used to confirm no other script from this page runs.
    };
  };

  // will check to see if there is a value passed to the field
  if (!$raceLocation == null){
    //validates the name field, that there is a value entered and that the value is 30 char or less
    if(strlen($raceLocation) == 0 || strlen($raceLocation)>30){
      session_start();
      $errorMsg = "<script>alert('Location entered must have at least one character with a maximum of 30')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location:updaterace.php"); //used to return to previous page
      delete_everything();//used to confirm no other script from this page runs.
    };
  };

  if (!$raceDate == null){
    //validation of date input if not validated it will trigger an alert and return to the form.
    if(!validateDate($raceDate)){
      session_start();
      $errorMsg = "<script>alert('The date inputed is not in the proper format MM/DD/YYYY. Please input correct format')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location:updaterace.php"); //used to return to previous page
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
    if (!$raceName == null && !$raceLocation==null && !$raceDate==null ) // Prepare statement only if there is valid input on both fields
    {
      $query = 'UPDATE race SET
                    RaceName = :raceName, RaceLocation = :raceLocation, RaceDate =  :raceDate
                  WHERE
                    RaceID = :raceID';
      $statement = $conn->prepare($query);
      $statement->bindValue(':raceName', $raceName);
      $statement->bindValue(':raceLocation', $raceLocation);
      $statement->bindValue(':raceDate', $raceDate);
      $statement->bindValue(':raceID', $raceID);

     $success = $statement->execute(); //executes the statement
    }else if (!$raceName==null) //Prepares statement only if there is a valid input on the DriverName field
    {
      $query = 'UPDATE race SET
                    RaceName = :raceName,
                  WHERE
                    RaceID = :raceID';
      $statement = $conn->prepare($query);
      $statement->bindValue(':raceName', $raceName);
      $statement->bindValue(':raceID', $raceID);

      $success = $statement->execute(); //executes the statement
    }else if (!$raceLocation==null) // Prepares statement only if there is a valid input on the DriverDOB field
    {
      $query = 'UPDATE race SET
                    RaceLocation = :raceLocation,
                  WHERE
                    RaceID = :raceID';
      $statement = $conn->prepare($query);
      $statement->bindValue(':raceLocation', $raceLocation);
      $statement->bindValue(':raceID', $raceID);

      $success = $statement->execute(); //executes the statement
    }else if (!$raceDate==null) // Prepares statement only if there is a valid input on the DriverDOB field
    {
      $query = 'UPDATE race SET
                    RaceDate = :raceDate,
                  WHERE
                    RaceID = :raceID';
      $statement = $conn->prepare($query);
      $statement->bindValue(':raceDate', $raceDate);
      $statement->bindValue(':raceID', $raceID);

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
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <h1>Information Updated</h1>
    <?php // this will confirm to the user if a value was updated or not.
     if ($success) {
      echo "<p>Below is the information updated for Race ID: $raceID.</p>";
    } else {
      echo "<p>Error, no values were updated, please try again.</p>";
    }

    ?>
    <table>
      <tr>
        <td>Race ID: </td>
        <td>  <?php echo ($raceID==null) ?  "No Change" :  $raceID ;?></td>
      </tr>
      <tr>
        <td>Race Name: </td>
        <td><?php echo ($raceName==null)? "No Change" : $raceName ?></td>
      </tr>
      <tr>
        <td>Race Location: </td>
        <td><?php echo ($raceLocation==null)? "No Change" : $raceLocation ?></td>
      </tr>
      <tr>
        <td>Race Date: </td>
        <td><?php echo ($raceDate==null)? "No Change" : $raceDate ?></td>
      </tr>

    </table>
    <button type='button' onclick='location.href="../raceinfo.php"'>Return to Race Info</button>
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
