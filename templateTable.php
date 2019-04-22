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
          <li><a href="#" id="current">Home</a></li>
          <li><a href="#">Race Info</a></li>
          <li><a href="#">Race Participants Info</a></li>
          <li><a href="#">Driver Info</a></li>
          <li><a href="#">Team Info</a></li>
          <li><a href="#">TeamDriver Info</a></li>
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
        $sql = "SELECT * FROM driver"; // input correct SQL sintax
        echo "<table><tr><th>Driver ID</th><th>Driver Name</th><th>Date of Birth</th><th>Update</th><th>Delete</th></tr>";
        
        foreach ($conn->query($sql) as $row) // will cycle through every row of the SELECT statement
        {
            $rowId = $row['DriverID']; // sets the row ID in order to use it as a value for the buttons for update and delete
            print 
            '<tr>
              <td>
                '.$row['DriverID'] .'
              </td>
              <td>
                '.$row['DriverName'].'
              </td>
              <td>
                '.$row['DriverDob']."
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