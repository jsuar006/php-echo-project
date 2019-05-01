<?php
  include ("../functions.php"); //includes global functions
  $rowID = $_POST['rowID'];
  $tableName = $_POST['tableName'];
  $tableRow = $_POST['tableRow'];

  //function deleteRow is called and returns a true or false value as confirmation.
  $delRow = deleteRow($rowID,$tableName,$tableRow);

  if(!$delRow){
    session_start();
    $errorMsg = "<script>alert('Error could not delete record! contact your adminitrator')</script>";
    $_SESSION['dateError'] = $errorMsg;
    header("Location:raceinfo.php"); //used to return to previous page
    delete_everything();//used to confirm no other script from this page runs.
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Information Deleted</title>
    <meta charset="utf-8">
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <h1>Information Deleted</h1>
    <p>Below information has been deleted from the table "Race Info".</p>
    <table>
      <tr>
        <td>Row ID</td>
        <td><?php echo $_POST["rowID"]?></td>
      </tr>
      <tr>
        <td>Table</td>
        <td><?php echo $_POST["tableName"]?></td>
      </tr>
      <tr>
        <td>Table Column</td>
        <td><?php echo $_POST["tableRow"]?></td>
      </tr>
    </table>
    <button type='button' onclick='location.href="../raceinfo.php"'>Return to Race Info</button>
  </body>
</html>
