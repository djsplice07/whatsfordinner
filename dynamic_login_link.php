<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and display the appropriate link
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    echo '
<table width="600" border="0">
  <tbody>
    <tr>
      <td width="103"><a href="index.php">Home</a></td>
	  <td width="163"><a href="admin_portal.php">Add Restaurants</a></td>
	  <td width="208"><a href="manage.php">Manage Restaurants</a></td>
  </tbody>
</table>';
} else {
    echo '<a href="admin_login.php">Login</a>';
}
?>