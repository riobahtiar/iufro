<?php
	$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
	require_once( $parse_uri[0] . 'wp-load.php' );
	$euser_barcode=$_GET['brcd'];
	global $wpdb;
	$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_barcode = '{$euser_barcode}'";
	$user_detail = $wpdb->get_row( $query, ARRAY_A );
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>
  <body style="padding: 10px">
<!-- User Changer -->
<p class="bg-primary">
<form action="<?php echo plugins_url('ss-event-dates').'/ajax/admin/member_process.php'; ?>" type="post">
<h4>Change User Type to </h4>
User Type Changer
<input type="hidden" name="do_model" value="do_membership">
<input type="hidden" name="barcode" value="<?php echo $euser_barcode; ?>">
<div class="form-group">
  <label for="user_type">User Type</label>
<select name="user_type" class="form-control">
  <option value="free_type">Free</option>
  <option value="participant_type">Participant</option>
  <option value="author_type">Author</option>
</select>
  </div>
  <button type="submit" class="btn btn-default">Change</button>
</form>
</p>
<!-- User Changer -->
<p class="bg-success">
<form action="<?php echo plugins_url('ss-event-dates').'/ajax/admin/member_process.php'; ?>" type="post">
<h4>Change User Type to </h4>
User Type Changer
<input type="hidden" name="do_model" value="do_membership">
<input type="hidden" name="barcode" value="<?php echo $euser_barcode; ?>">
<div class="form-group">
  <label for="user_type">User Type</label>
<select name="user_type" class="form-control">
  <option value="free_type">Free</option>
  <option value="participant_type">Participant</option>
  <option value="author_type">Author</option>
</select>
  </div>
  <button type="submit" class="btn btn-default">Change</button>
</form>
</p>
<!-- User Changer -->






  </body>
</html>

