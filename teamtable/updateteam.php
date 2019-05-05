<?php
  //checks if error message exist and if so alerts user
  session_start();
  if (isset($_SESSION['dateError'])){
    echo "{$_SESSION['dateError']}";
    session_destroy(); // close session so the values are erased.
  }
  //checks if there is a session open for driverId in order to bring back the value used from the original selection, from the return page.
   if(isset($_SESSION['teamId'])){
    $teamID = $_SESSION['teamId'];
  };

  include ("../functions.php"); //includes global functions
  if(isset ($_POST["rowID"])) $teamID = $_POST["rowID"];
  //echo "variables have {$rowID}"; //debugging only
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Update Team Information</title>
    <meta charset="utf-8">
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <header>
      <h1>Update Team Information</h1>
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
      <?php
        //connect to db
        $dsn = "mysql:host=localhost;dbname=racingleague";
        $userName = "admin";
        $password = "Pa11word";

        try {
          $conn = new PDO($dsn, $userName, $password);
          //echo 'Connected to database<br>'; // only to confirm if connected

          // Prepare and execute the statement
          if (isset($teamID)) {
            $query = "SELECT * FROM team WHERE TeamID = {$teamID}";

            foreach ($conn->query($query) as $val) {
              $rowID = $val['TeamID'];
              $teamName = $val['TeamName'];
              $teamManager = $val['TeamManager'];
             // echo "<p>ID: {$rowID} - Driver Name: {$driverName} -  DriverDOB {$driverDob}</p>"; // to test input from database

             echo "<p>Please enter the information you wish to update below and Submit.</p>
                 <table>
                   <tr>
                     <th>Team ID</th>
                     <th>Team Name</th>
                     <th>Team Manager</th>
                   </tr>
                   <tr>
                     <td><?php echo $rowID; ?></td>
                     <td><?php echo $teamName;?></td>
                     <td><?php echo $teamManager;?></td>
                   </tr>
                   <tr>
                     <!-- form used to pass information to the confirmupdteam page for varification and update of the database.  -->
                     <form id=\"frmUpdate\" action=\"confirmupdteam.php\" method=\"post\">
                       <td>
                         <input type=\"hidden\" name=\"TeamID\" value=\"$rowID\">New Values:
                       </td>
                       <td>
                         <input type=\"text\" name=\"TeamName\" placeholder=\"Team Name\" form=\"frmUpdate\" />
                       </td>
                       <td>
                         <input type=\"text\" name=\"TeamManager\" placeholder=\"Team Manager\" form=\"frmUpdate\" />
                       </td>
                     </form>
                   </tr>
                 </table>
             <input type=\"submit\" form=\"frmUpdate\">
             <button type=\"button\" onclick='location.href=\"../teaminfo.php\"'>Return to Team Info</button>";
            }
          } else {
            echo "<p>No Record Selected.</p>";
            echo "<button type='button' onclick='location.href=\"../teaminfo.php\"'>Return to Team Info</button>";
          }
        } catch(PDOException $e) {
            echo "<p>Connection Failed: " . $e->getMessage() . "</p>"; //error message if connection fails
          }

        $conn=null; // close the connection

      ?>
    </main>
  </body>
</html>
