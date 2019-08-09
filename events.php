<?php
include_once 'database.php';

if (!isset($_SESSION['name'])) {
  header('Location: login.php');
  exit;
}

$con=new mysqli($db_servername, $db_username, $db_password, $db_name);

if (mysqli_connect_errno()) {
  echo 'Failed to connect to MySQL:' . mysqli_connect_error();
}



if (!empty($_POST['contains'])) {
  $colname = $_POST['colname'];
  $name = $_POST['contains'];
  $squery = "SELECT * FROM tbl_events WHERE $colname LIKE '%$name%'";
} else {
  $squery = "SELECT * FROM tbl_events";
}

$result = mysqli_query($con, $squery);
if (!$result) print(mysqli_error($con));
$con->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <title>Events Page</title>
</head>

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li>
          <a href="events.php">
            <b>Events</b>
          </a>
        </li>
        <li>
          <a href="logout.php">
            <span class="glyphicon glyphicon-log-out"></span>
          </a>
        </li>
      </ul>
      <p id="user">Welcome, <?php print($_SESSION['name']) ?></p>
    </div>
  </nav>
  <div class="container">
    <h2>Events</h2>
    <table class="table" id="myFavTable">
      <thead>
        <tr>
          <th scope="col">Event Name</th>
          <th scope="col">Location</th>
          <th scope="col">Day</th>
          <th scope="col">Start Time</th>
          <th scope="col">End Time</th>
        </tr>
      </thead>
      <tbody>
        <?php
          while($row = mysqli_fetch_row($result)) {
            print("<tr>");
            print("<td>$row[1]</td>");
            print("<td>$row[2]</td>");
            print("<td>$row[3]</td>");
            print("<td>$row[4]</td>");
            print("<td>$row[5]</td>");
            print("</tr>");
          }
        ?>
      </tbody>
    </table>

    <form id="filter" action="events.php" method="post">

      <div class="form-group">
        <label for="colname">Column Name :</label>
        <select name="colname">
          <option value="event_name">Event Name</option>
          <option value="event_location">Location</option>
          <option value="event_day">Day</option>
          <option value="event_start_time">Start Time</option>
          <option value="event_end_time">End Time</option>
        </select>
      </div>

      <div class="form-group">
        <label for="contains">Contains :</label>
        <input class="form-control" type="text" name="contains" id="contains" placeholder="Enter keyword">
      </div>

      <input class="btn btn-primary btn-block" type="submit" value="Filter" id="submit">
    </form>
  </div>
</body>

</html>
