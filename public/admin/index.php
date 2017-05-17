<?php
require_once('../../includes/initialize.php');
session_start();
$session = Session::getInstance();
if ($session->is_logged_in() == false) { redirect_to("login.php"); }

?>
<?php include('../layouts/admin_header.php'); ?>

	<h2>Menu</h2>
	<?php echo output_message($session->message()); ?>
  <br />
  <ul>
		<li><a href="new_user.php">Create New User</a></li>
    <li><a href="logfile.php">View Log File</a></li>
		<li><a href="list_photos.php">Photo List</a></li>
		<li><a href="photo_upload.php">Upload Photo</a></li>
    <li><a href="logout.php">Logout</a></li>

<?php include('../layouts/admin_footer.php'); ?>
