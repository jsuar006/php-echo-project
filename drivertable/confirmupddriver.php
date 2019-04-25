<?php 
  include ("../functions.php"); //includes global functions
  // initializes variable being imported from a form.
  $driverID = $_POST["inpdriverId"];
  $driverName = $_POST["inpDriverName"];
  $driverDOB = $_POST["inpDriverDob"];
  trim($driverName);
  trim($driverDOB);

  session_start();
  $_SESSION['driverId'] = $driverID;
  //echo "variables have {$driverID} {$driverName} and {$driverDOB}"; //debugging only

  // *****************INPUT VALIDATION BELOW *********************

  // will check if there is any input on either fields if not will send an alert and return to the previous page 
  if ($driverName==null && $driverDOB==null){
    session_start();
    $errorMsg = "<script>alert('Please enter a value on at least one of the fields to update.')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location:updatedriver.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs. 
  }

  //will check if anthing was inputed. 
  if (!$driverName == null){
    //validates the name field, that there is a value entered and that the value is 30 char or less
    if(strlen($driverName) == 0 || strlen($driverName)>30){
      session_start();
      $errorMsg = "<script>alert('Name entered must have at least one character with a maximum of 30')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location:updatedriver.php"); //used to return to previous page
      delete_everything();//used to confirm no other script from this page runs. 
    };
  };
 
  // will check to see if there is a value passed to the field
  if (!$driverDOB == null){
    //validation of date input if not validated it will trigger an alert and return to the form.
    if(!validateDate($driverDOB)){
      session_start();
      $errorMsg = "<script>alert('The date inputed is not in the proper format MM/DD/YYYY. Please input correct format')</script>";
      $_SESSION['dateError'] = $errorMsg;
      header("Location:updatedriver.php"); //used to return to previous page
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
    if (!$driverName == null && !$driverDOB==null) // Prepare statement only if there is valid input on both fields
    {
      $query = 'UPDATE driver SET 
                    DriverName = :driverName, DriverDob =  :driverDob 
                  WHERE
                    DriverID = :driverId';
      $statement = $conn->prepare($query);
      $statement->bindValue(':driverName', $driverName);
      $statement->bindValue(':driverDob', $driverDOB);
      $statement->bindValue(':driverId', $driverID);

       $success = $statement->execute(); //executes the statement
    }else if (!$driverName==null) //Prepares statement only if there is a valid input on the DriverName field
    {
      $query = 'UPDATE driver SET 
                    DriverName = :driverName
                  WHERE
                    DriverID = :driverId';
      $statement = $conn->prepare($query);
      $statement->bindValue(':driverName', $driverName);
      $statement->bindValue(':driverId', $driverID);

       $success = $statement->execute(); //executes the statement
    }else if (!$driverDOB==null) // Prepares statement only if there is a valid input on the DriverDOB field
    {
      $query = 'UPDATE driver SET 
                    DriverDob =  :driverDob 
                  WHERE
                    DriverID = :driverId';
      $statement = $conn->prepare($query);
      $statement->bindValue(':driverDob', $driverDOB);
      $statement->bindValue(':driverId', $driverID);

       $success = $statement->execute(); //executes the statement
    }

   
  
    // for debuggin purposes only
    if ($success) {
      echo "<p>Update inserted with this ID: $driverID and $driverName and $driverDOB</p>";
    } else {
      echo "<p>No rows were inserted.</p>";
    }
    

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
      echo "<p>Below is the information updated for the ID: $driverID.</p>";
    } else {
      echo "<p>Error, no values were updated, please try again.</p>";
    }
    
    ?>
    <table>
      <tr>
        <td>Driver Name: </td>
        <td>  <?php echo ($driverName==null) ?  "No Change" :  $driverName ;?></td>
      </tr>
      <tr>
        <td>Driver DOB: </td>
        <td><?php echo ($driverDOB==null)? "No Change" : $driverDOB ?></td>
      </tr>
    </table>
    <button type='button' onclick='location.href="../driverinfo.php"'>Return to Driver Info</button>
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