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
    <title> Add Race info</title>
    <meta charset="utf-8">
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <header>
      <h1>New Race Info</h1>
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
      <p>Please enter the New driver information requested below</p>
      <form action="confirmraceadd.php" method="post">
        Race Name: <input type="text" name="raceName"  placeholder="Race Name"><br>
        Race Location: <input type="text" name="raceLocation"  placeholder="Race Location"><br>
        Race Date: <input type="text" name="raceDate" placeholder="MM/DD/YYYY"><br>
        <input type="submit" name="addrecordsubmit" value="Submit">
      </form>

    </main>
    <footer>

    </footer>

  </body>
</html>
