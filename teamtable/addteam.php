<?php //checks if error message exist and if so alerts user
  session_start();
  if (isset($_SESSION['dateError'])){
    echo "{$_SESSION['dateError']}";
    session_destroy(); // close session so the values are erased.
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title> Add Team Information</title>
    <meta charset="utf-8">
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <header>
      <h1>New Team Info</h1>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="raceinfo.php">Race Info</a></li>
          <li><a href="raceparticipant.php">Race Participants Info</a></li>
          <li><a href="driverinfo.php">Driver Info</a></li>
          <li><a href="teaminfo.php">Team Info</a></li>
          <li><a href="teamdriverinfo.php">TeamDriver Info</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <p>Please enter the New Team information</p>
      <form action="confirmaddteam.php" method="post">
        Team ID: <input type="text" name="teamID"  placeholder="Team ID"><br>
        Driver ID: <input type="text" name="teamName"  placeholder="Team Name"><br>
        Position Finished <input type="text" name="teamManager" placeholder="Team Manager"><br>
        <input type="submit" name="addrecordsubmit" value="Submit">
      </form>

    </main>
    <footer>

    </footer>

  </body>
</html>
