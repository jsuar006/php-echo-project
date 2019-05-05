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
    <title>Add Team Information</title>
    <meta charset="utf-8">
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <header>
      <h1>New Team Info</h1>
      <nav>
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="../raceinfo.php">Race Info</a></li>
          <li><a href="../raceparticipant.php">Race Participants Info</a></li>
          <li><a href="../driverinfo.php">Driver Info</a></li>
          <li><a href="../teaminfo.php">Team Info</a></li>
          <li><a href="../teamdriverinfo.php">TeamDriver Info</a></li>
          <li><a href="../report.php">Race Report</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <p>Please enter the New Team information</p>
      <form action="confirmaddteam.php" method="post">
        <label for="TeamName">Enter Team Name:</label>
        <input type="text" name="TeamName" id="TeamName"  placeholder="Baby Got Track" maxlength="30" size="30" required />

        <label for="TeamManager">Enter Team Manager:</label>
        <input type="text" name="TeamManager" id="TeamManager" placeholder="Chuck Norris" maxlength="30" size="30" required />

        <input type="submit" name="formSubmit" value="Submit">
      </form>

    </main>
    <footer>
      
    </footer>

  </body>
</html>
