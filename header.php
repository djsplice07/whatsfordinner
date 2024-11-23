	<p align="center"><img src="images/restaurant_logo.png" width="150" align="middle"></src></p>
    <h1>Restaurant Picker</h1>
<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and display the appropriate link
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    echo '
<table border="0">
  <tbody>
    <tr>
      <td width="103"><a href="index.php">Home</a></td>
	  <td width="180"><a href="admin_portal.php">Add Restaurants</a></td>
	  <td width="208"><a href="manage.php">Manage Restaurants</a></td>
	  <td width="208"><a href="usradm.php">Manage Users</a></td>
	  <td width="208"><a href="logout.php">Log Out</a></td>
  </tbody>
</table>';
} else {
    echo '<p align="right"><a href="admin_login.php">Admin</a></p>';
}
?>
<br />