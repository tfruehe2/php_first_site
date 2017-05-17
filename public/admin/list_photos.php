<?php require_once("../../includes/initialize.php"); ?>
<?php
session_start();
$session = Session::getInstance();
if ($session->is_logged_in() == false) { redirect_to("login.php"); }
?>
<?php
  // Find all the photos
  $photos = Photograph::find_all();

?>
<?php include_layout_template('admin_header.php'); ?>

<h2>Photographs</h2>

<?php echo output_message($session->message()); ?>
<table class="bordered">
  <tr>
    <th>Image</th>
    <th>Filename</th>
    <th>Caption</th>
    <th>Size</th>
    <th>Type</th>
    <th>Comments</th>
    <th>&nbsp;</th>
  </tr>
<?php foreach($photos as $photo) { ?>
  <tr>
    <td><img src="../<?php echo $photo->image_path(); ?>" width="100" /></td>
    <td><?php echo scrub_output($photo->filename); ?></td>
    <td><?php echo scrub_output($photo->caption); ?></td>
    <td><?php echo $photo->size_as_text(); ?></td>
    <td><?php echo scrub_output($photo->type); ?></td>
    <td><a href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a></td>
    <td>
      <a href="comments.php?id=<?php echo $photo->id; ?>">
      &nbsp;  <?php echo $photo->comment_count(); ?> &nbsp;
      </a>
    </td>
  </tr>
<?php } ?>
</table>
<br />
<a href="photo_upload.php">Upload a new photograph</a>

<?php include_layout_template('admin_footer.php'); ?>
