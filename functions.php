<?php
  //function to validate date format only need to pass date
  function validateDate ($date) {
    $date_regex = '/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/';// Regular Expresion that checks for format, month, date and year input(year input is checked for 1900 - 2099)
    trim($date);// removes any possible spaces before and after the input

    if (preg_match($date_regex,$date)){
      return TRUE;
    }else {
      return FALSE;
    }
  };

  /* DeleteRow function used to delete a specific row from a table
  must pass the rowID you want to delete, then the Table you want to delete ID from, and finally the colomn in that table which the rowID will be matched to. 
  */
  function deleteRow($rowId,$tableName,$tableRow){
    $dsn = "mysql:host=localhost;dbname=racingleague";
    $userName = "admin";
    $password = "Pa11word";

    try
    {
      $conn = new PDO($dsn,$userName,$password);
      //echo 'Connected to database<br>'; // only to confirm if connected
      $query = "DELETE FROM $tableName WHERE $tableRow = :rowId";
      
      $statement = $conn->prepare($query);
      $statement->bindValue(':rowId',$rowId,PDO::PARAM_INT);
      $success = $statement->execute();
      $row_count = $statement->rowCount();

    }
    catch(PDOException $e)
    {
      echo $e->getMessage(); //error message if connection fails
    }

    // $query = "DELETE FROM {$tableName} WHERE {$tableRow} = {$rowId}";
 
    // $delete_count = $conn->exec($query);

    if($success){
      echo "success {$row_count}";
      $conn=NULL; // close the connection
      return TRUE;
    }else
    {
      echo "success failed {$row_count}";
      $conn=NULL;
      return FALSE;
    }
  }
?>