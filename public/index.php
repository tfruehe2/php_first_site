<?php require_once("../includes/initialize.php"); ?>
<?php

	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	$per_page = 2;
	$total_count = Photograph::count_all();

	// Find all photos
	//$photos = Photograph::find_all();
	$pagination = new Pagination($page, $per_page, $total_count);
	$sql = "SELECT * FROM photographs ";
	$sql .= "LIMIT {$per_page} ";
	$sql .= "OFFSET {$pagination->offset()}";
	$photos = Photograph::find_by_sql($sql);

?>

<?php include_layout_template('header.php'); ?>
<?php echo output_message($session->message()); ?>

<?php foreach($photos as $photo): ?>
  <div style="float: left; margin-left: 20px;">
		<a href="photo.php?id=<?php echo $photo->id; ?>">
			<img src="<?php echo $photo->image_path(); ?>" width="200" />
		</a>
    <p><?php echo scrub_output($photo->caption); ?></p>
  </div>
<?php endforeach; ?>

<div id="pagination" style="clear: both;">
<?php
	if($pagination->total_pages() > 1) {

		if ($prev_page = $pagination->previous_page()) {
			echo " <a href=\"index.php?page={$prev_page}\">&laquo; Prev</a>";
		}

		for($i=1; $i <= $pagination->total_pages(); $i++) {
			if($i == $page) {
				echo " <span class=\"selected\">{$i}</span> ";
			} else {
			echo " <a href=\"index.php?page={$i}\">{$i}</a> ";
			}
		}

		if ($next_page = $pagination->next_page()) {
			echo " <a href=\"index.php?page={$next_page}\">Next &raquo;</a>";
		}
	}

?>
</div>

<?php include_layout_template('footer.php'); ?>
