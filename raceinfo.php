<!DOCTYPE html>
<html lang="en">
  <head>
    <title> Update Info Template</title>
    <meta charset="utf-8">
    <link href="stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <header>
      <h1>Page Title</h1>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="raceinfo.php" id="current">Race Info</a></li>
          <li><a href="raceparticipant.php">Race Participants Info</a></li>
          <li><a href="driverinfo.php">Driver Info</a></li>
          <li><a href="teaminfo.php">Team Info</a></li>
          <li><a href="teamdriverinfo.php">TeamDriver Info</a></li>
          <li><a href="report.php" >Race Report</a></li>
        </ul>
      </nav>
    </header>
    <main>

      <!-- hidden form used to pass the deleteRow JS onclick event to a PHP page -->
            <form id='frmDelete' action='racetable/deleterace.php' method='post'>
              <input id='delRow' type='hidden' name='rowID' value=''>
              <input id='delTable' type='hidden' name='tableName' value=''>
              <input id='delTRow' type='hidden' name='tableRow' value=''>
            </form>

            <!-- hidden form used to pass the updateRow JS onclick event to a PHP page -->
            <form id='frmUpdate' action='racetable/updaterace.php' method='post'>
              <input id='uptRow' type='hidden' name='rowID' value=''>
              <!-- <input id='uptTable' type='hidden' name='tableName' value=''>
              <input id='uptTRow' type='hidden' name='tableCol' value=''> -->
            </form>

      <?php // connect to database
        $dsn = "mysql:dbname=racingleague";
        $userName = "admin";
        $password = "Pa11word";

        try
        {
          $conn = new PDO($dsn,$userName,$password);
          //echo 'Connected to database<br>'; // only to confirm if connected
        }
        catch(PDOException $e)
        {
          echo $e->getMessage(); //error message if connection fails
        }

        //SElECT statement to pull from DB
        $sql = "SELECT * FROM race"; // input correct SQL sintax
        echo "<table><tr><th>Race ID</th><th>Race Name</th><th>Race Location</th><th>Race Date</th><th>Update</th><th>Delete</th></tr>";

        foreach ($conn->query($sql) as $row) // will cycle through every row of the SELECT statement
        {
            $rowId = $row['RaceID']; // sets the row ID in order to use it as a value for the buttons for update and delete
            print
            "<tr>
              <td>
                {$row['RaceID']}
              </td>
              <td>
                {$row['RaceName']}
              </td>
              <td>
                {$row['RaceLocation']}
              </td>
              <td>
                {$row['RaceDate']}
              </td>

              <td>
                <button value='btnUpd{$rowId}' onclick=\"updateRow('{$rowId}','race','RaceID')\">Update</button>
              </td>
              <td>
              <button value='btnDel{$rowId}' onclick=\"deleteRow('{$rowId}','race','RaceID')\">Delete</button>
              </td>

            </tr>";
        };

        echo "</table>";
        echo "<br> <button type='button' onclick='location.href=\"racetable/addrace.php\"'>Add Record</button>";



   $conn =null; // close the connection


?>


    </main>
    <footer>

    </footer>

    <script> // needed to add this JS in order to use onclick eventhandler for delete.
        function deleteRow (rowID,tableName,tableRow){
          document.getElementById('delRow').value=rowID;
          document.getElementById('delTable').value=tableName;
          document.getElementById('delTRow').value=tableRow;
          document.getElementById('frmDelete').submit();
      };

        function updateRow (rowID,tableName,tableRow){
           document.getElementById('uptRow').value=rowID;
          // document.getElementById('uptTable').value=tableName;
          // document.getElementById('uptTRow').value=tableRow;
          document.getElementById('frmUpdate').submit();
        }
    </script>

  </body>
</html>
