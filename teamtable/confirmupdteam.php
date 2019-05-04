<?php
  include ("../functions.php"); //includes global functions
  // initializes variable being imported from a form.
  $teamID= $_POST["teamId"]
  $teamName = $_POST["teamName"];
  $teamManager = $_POST["teamManager"];
  trim($teamID);
  trim($teamName);
  trim($teamManager);

  session_start();
  $_SESSION['teamId'] = $teamID;
  //echo "variables have {$driverID} {$driverName} and {$driverDOB}"; //debugging only

  // *****************INPUT VALIDATION BELOW *********************

  // will check if there is any input on either fields if not will send an alert and return to the previous page
  if ($teamName==null && $teamManager==null){
    session_start();
    $errorMsg = "<script>alert('Please enter a value on at least one of the fields to update.')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location: updateteam.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs.
  }

  //will check if anthing was inputed.
  if (!$teamName == null){
    //validates the name field, that there is a value entered and that the value is 30 char or less
    if(strlen($teamName) == 0 || strlen($teamName)>30){
      session_start();
      $errorMsg = "<script>alert('Name entered must have at least one character with a maximum of 30')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location: updateteam.php"); //used to return to previous page
      delete_everything();//used to confirm no other script from this page runs.
    };
  };

  // will check to see if there is a value passed to the field
  if (!$teamManager == null){
    //validates the name field, that there is a value entered and that the value is 30 char or less
    if(strlen($teamManager) == 0 || strlen($teamManager)>30){
      session_start();
      $errorMsg = "<script>alert('Name entered must have at least one character with a maximum of 30')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location: updateteam.php"); //used to return to previous page
      delete_everything();//used to confirm no other script from this page runs.
    };
  }

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
    if(!$teamName==null && $teamManager==null) // Prepare statement only if there is valid input on both fields
    {
      $query = 'UPDATE team SET
                    TeamID = :teamID, TeamName=  :teamName, TeamManager = :teamManager
                  WHERE
                    TeamID= :teamId';
      $statement = $conn->prepare($query);
      $statement->bindValue(':teamName', $teamID);
      $statement->bindValue(':teamManager', $teamManager);


       $success = $statement->execute(); //executes the statement
    }else if (!$teamName==null) //Prepares statement only if there is a valid input on the DriverName field
    {
      $query = 'UPDATE team SET
                    TeamName=  :teamName
                  WHERE
                    TeamID= :teamId';
      $statement = $conn->prepare($query);
      $statement->bindValue(':teamName', $teamID);
      $statement->bindValue(':teamManager', $teamManager);


       $success = $statement->execute(); //executes the statement
    }else if (!$teamManager==null) // Prepares statement only if there is a valid input on the DriverDOB field
    {

        $query = 'UPDATE team SET
                      TeamManager=  :teamManager
                    WHERE
                      TeamID= :teamId';
        $statement = $conn->prepare($query);
        $statement->bindValue(':teamName', $teamID);
        $statement->bindValue(':teamManager', $teamManager);

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
    <title>Team Information updated</title>
    <meta charset="utf-8">
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <h1>Team Information Updated</h1>
    <?php // this will confirm to the user if a value was updated or not.
     if ($success) {
      echo "<p>Below is the information updated for Team: $teamID.</p>";
    } else {
      echo "<p>Error, no values were updated, please try again.</p>";
    }

    ?>
    <table>
      <tr>
        <td>Team Name: </td>
        <td>  <?php echo ($teamName==null) ?  "No Change" :  $teamName ;?></td>
      </tr>
      <tr>
        <td>Team Managert: </td>
        <td><?php echo ($teamManager==null)? "No Change" : $teamManager ?></td>
      </tr>
    </table>
    <button type='button' onclick='location.href="../teaminfo.php"'>Return to Team Info</button>
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
