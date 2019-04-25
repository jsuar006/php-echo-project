<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Race Report</title>
    <meta charset="utf-8">
    <link href="stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <header>
      <h1>Team Driver Information</h1>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="raceinfo.php">Race Info</a></li>
          <li><a href="raceparticipant.php">Race Participants Info</a></li>
          <li><a href="driverinfo.php">Driver Info</a></li>
          <li><a href="teaminfo.php">Team Info</a></li>
          <li><a href="teamdriverinfo.php">TeamDriver Info</a></li>
          <li><a href="report.php" id="current">Race Report</a></li>
        </ul>
      </nav>
      </header>
      <main>
	    <h1>Race Report</h1>
		<form action = "report.php" method = "POST">
		  Enter Race: <input type = "text" name = "entRaceTxt"/>
		  <button name = "submitBtn">Submit</button>
		</form>
		
		<!-- Using php to pull the data related to the requested race. -->
		<?php
		  if(isset($_POST["submitBtn"])) {
			//variables needed to login to the database.
		    $dsn = "mysql:host=localhost;dbname=racingleague";
            $userName = "admin";
            $password = "Pa11word";
		  
		    //connecting to the database.
		    try {
			  $conn = new PDO($dsn, $username, $password);
		    }
		    catch(PDOException $e) {
			  echo "Connection failed! ".$e->getMessage();
		    }
		  
		    //SElECT statement to pull from DB.
		    $sql = "SELECT * FROM team, raceparticipant, driver, race";
			
			//Creating table to display the information.
			echo "<table>
			<tr>
			<th>pos</th>
			<th>driver</th>
			<th>team name</th>
			<th>team manager</th>
			</tr>";
			
			//pulling from the database.
			foreach($conn->query($sql) as $row) {
				
			}
		  }
		?>
		
      </main>
      <footer>

      </footer>

    </body>
  </html>
