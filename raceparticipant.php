<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Race Participants</title>
    <meta charset="utf-8">
    <link href="stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <header>
      <h1>Race Participants</h1>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="raceinfo.php" >Race Info</a></li>
          <li><a href="#" id="current">Race Participants Info</a></li>
          <li><a href="driverinfo.php">Driver Info</a></li>
          <li><a href="teaminfo.php">Team Info</a></li>
          <li><a href="teamdriverinfo.php">TeamDriver Info</a></li>
          <li><a href="report.php" >Race Report</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <?php // connect to database
        $dsn = "mysql:host=localhost;dbname=racingleague";
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
        $sql = "SELECT * FROM raceparticipants"; // input correct SQL sintax
        echo "<table><tr><th>Race ID</th><th>Team ID</th><th>Driver ID</th><th>Position Finished</th><th>Update</th><th>Delete</th></tr>";

        foreach ($conn->query($sql) as $row) // will cycle through every row of the SELECT statement
        {
            $rowId = $row['RaceID']; // sets the row ID in order to use it as a value for the buttons for update and delete
            print
            '<tr>
              <td>
                '.$row['RaceID'] .'
              </td>
              <td>
                '.$row['TeamID'].'
              </td>
              <td>
                '.$row['DriverID'].'
              </td>
              <td>
                '.$row['PositionFinished']."
              </td>
              <td>
                <button value='btnUpd{$rowId}'>Update</button>
              </td>
              <td>
                <button value='btnDel{$rowId}'>Delete</button>
              </td>
            </tr>";
        }
        echo "</table>";
        echo "<br> <button>Add Record</button>";

        $conn =null; // close the connection
      ?>


    </main>
    <footer>

    </footer>

  </body>
</html>
