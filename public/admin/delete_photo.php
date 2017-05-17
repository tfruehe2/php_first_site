<?php
require_once('../../includes/initialize.php');
session_start();
$session = Session::getInstance();
if ($session->is_logged_in() == false) { redirect_to("login.php"); } ?>

<?php
  if (empty($_GET['id'])) {
    $session->message("No photograph ID was provided.");
    redirect_to('index.php');
  }

  $photo = Photograph::find_by_id($_GET['id']);
  if($photo && $photo->destroy()) {
    $session->message("The photo {$photo->filename} deleted.");
    redirect_to('list_photos.php');
  } else {
    $session->message("The photo could not be deleted.");
    redirect_to('list_photos.php');
  }
?>
<?php if(isset($db)) {$db->close(); } ?>
