<?php
require_once("../../includes/initialize.php");
session_start();
if (!$_SESSION['logged_in']) { redirect_to("login.php"); }
?>
<?php
  $max_file_size = 1048576;
  if (isset($_POST['submit'])) {
    $photo = new Photograph();
    $photo->caption = $_POST['caption'];
    $photo->attach_file($_FILES['file_upload']);

    if($photo->save()) {
      $session->message("Photograph uploaded successfully.");
      redirect_to('list_photos.php');
    } else {
      $message = join("<br />", $photo->errors);
    }
  }
?>

<?php include('../layouts/admin_header.php'); ?>

  <h2>Photo Upload</h2>
  <?php echo output_message($message); ?>
  <form action="photo_upload.php" enctype="multipart/form-data" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
    <p><input type="file" name="file_upload" /></p>
    <p>Caption: <input type="text" name="caption" value="" /></p>
    <input type="submit" name="submit" value="Upload" />
  </form>


<?php include('../layouts/admin_footer.php'); ?>
