<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Race Report</title>
    <meta charset="utf-8">
    <link href="stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <header>
      <h1>Race Report</h1>
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
        <?php
          //$dsn (database source name) = string type:location;dbname
          $dsn = "mysql:host=localhost;dbname=racingleague";
          $user = "admin";
          $password = "Pa11word";

          try {
    			  $conn = new PDO($dsn, $user, $password);
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Allow Exceptions
            //echo 'Connected to database';

            $sql = "SELECT RaceID, RaceName FROM race";

            //If Records Exists
            if ($conn->query($sql)) {
              echo "<form action=\"report.php\" method=\"post\">
                      <label for=\"RaceID\">Select Race ID: </label><br />
                      <select name=\"RaceID\" id=\"RaceID\">";
              $rows = $conn->query($sql);
              //$row is each record as an array
              foreach($rows as $row) { ?>
                <option value="<?php echo $row['RaceID'] ?>"><?php echo $row['RaceName'] ?></option>
              <?php
            } echo "</select>
              <input type=\"submit\" name=\"formSubmit\" value=\"Get Report\" />
              </form>";
            } else {
              echo "<p>There are no records to display.";
            }
  		    } catch(PDOException $e) {
      			  echo "<p>Connection failed! ". $e->getMessage() . "</p>"; //getMessage() method of PDO exception object Returns Exception Message
  		    }
         ?>

    		<!-- Using php to pull the data related to the requested race. -->
    		<?php
    		  if(isset($_POST["formSubmit"])) {
            //$dsn (database source name) = string type:location;dbname
            $dsn = "mysql:host=localhost;dbname=racingleague";
            $user = "admin";
            $password = "Pa11word";

    		    try {
      			  $conn = new PDO($dsn, $user, $password);
              $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Allow Exceptions
              //echo 'Connected to database';

              //Send SQL Search Query
              $RaceID = $_POST['RaceID'];
              $sql = "SELECT race.RaceID, race.RaceName, driver.DriverName, raceparticipants.PositionFinished, team.TeamName, team.TeamManager FROM race, driver, raceparticipants, team WHERE race.RaceID = raceparticipants.RaceID AND raceparticipants.DriverID = driver.DriverID AND raceparticipants.TeamID = team.TeamID AND race.RaceID = :RaceID";

              try {
                $st = $conn->prepare($sql);
                $st->bindValue( ":RaceID", $RaceID, PDO::PARAM_INT);
                $st->execute();
              } catch(PDOException $e) {
                  header("Refresh:8; url=report.php");
                  echo "<p>Query Failed: " . $e->getMessage() . "</p>";
              }
    		    } catch(PDOException $e) {
        			  echo "<p>Connection failed: ". $e->getMessage() . "</p>"; //getMessage() method of PDO exception object Returns Exception Message
    		    }
            //Creating table to display the information.
      			echo "<table>
              			<tr>
                			<th>Race ID</th>
                			<th>Race Name</th>
                			<th>Driver Name</th>
                			<th>Position Finished</th>
                      <th>Team Name</th>
                      <th>Team Manager</th>
              			</tr>";
      			//pulling from the database.
      			foreach($st as $row) {
              echo "<tr>
                      <td>" . $row['RaceID'] . "</td>
                      <td>" . $row['RaceName'] . "</td>
                      <td>" . $row['DriverName'] . "</td>
                      <td>" . $row['PositionFinished'] . "</td>
                      <td>" . $row['TeamName'] . "</td>
                      <td>" . $row['TeamManager'] . "</td>
                    </tr>";
      			} echo "</table>";
    		  }
    		?>

      </main>
      <footer>

      </footer>

    </body>
  </html>
