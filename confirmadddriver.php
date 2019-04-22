<?php 
  include ("functions.php"); //includes global functions
  $driverName = $_POST["driverName"];
  $driverDOB = $_POST["driverDOB"];
  trim($driverName);
  trim($driverDOB);
  //echo "variables have {$driverName} and {$driverDOB}" //debugging only
  
  //validates the name field, that there is a value entered and that the value is 30 char or less
  if(strlen($driverName) == 0 || strlen($driverName)>30){
    session_start();
    $errorMsg = "<script>alert('Name entered must have at least one character with a maximum of 30')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location:formadddriver.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs. 
  };
  //validation of date input if not validated it will trigger an alert and return to the form.
  if(!validateDate($driverDOB)){
    session_start();
    $errorMsg = "<script>alert('The date inputed is not in the proper format MM/DD/YYYY. Please input correct format')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location:formadddriver.php"); //used to return to previous page
    delete_everything(); //used to confirm no other script from this page runs. 
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
  $query = 'INSERT INTO driver
                (DriverName, DriverDob)
              VALUES
                (:driverName, :driverDOB)';
  $statement = $conn->prepare($query);
  $statement->bindValue(':driverName', $driverName);
  $statement->bindValue(':driverDOB', $driverDOB);
  $success = $statement->execute();
  $row_count = $statement->rowCount();
  $statement->closeCursor();
     
  // Get the last product ID that was generated
  $table_id = $conn->lastInsertId();
 
  // Display a message to the user
  if ($success) {
    echo "<p>$row_count row(s) was inserted with this ID: $table_id</p>";
  } else {
    echo "<p>No rows were inserted.</p>";
  }

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
    <h1>Information Updated</h1>
    <p>Below was the information succesfully added.</p>
    <table>
      <tr>
        <td>Driver Name</td>
        <td><?php echo $_POST["driverName"]?></td>
      </tr>
      <tr>
        <td>Driver DOB</td>
        <td><?php echo $_POST["driverDOB"]?></td>
      </tr>
    </table>
    <button type='button' onclick='location.href="driverinfo.php"'>Return to Driver Info</button>
  </body>
</html>