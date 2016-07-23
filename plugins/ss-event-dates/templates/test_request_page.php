<?php

echo "<pre>";
echo "REQUEST";
print_r($_REQUEST);
echo "</pre>";

echo "<pre>";
echo "POST";
print_r($_POST);
echo "</pre>";

echo "<pre>";
echo "GET";
print_r($_GET);
echo "</pre>";


echo "<pre>";
echo "FILES";
print_r($_FILES);

print_r($_FILES['abstrak']);
print_r($_FILES['poster']);
print_r($_FILES['paper']);
print_r($_FILES['file']['abstrak']);
echo "</pre>";




function upload_user_file( $file = array() ) {
	
		require_once( ABSPATH . 'wp-admin/includes/admin.php' );
	    
	  	$file_return = wp_handle_upload( $file, array('test_form' => false ) );
	  	if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
	  
	      	return false;
	  
	  	} else {
	  
	      	$filename = $file_return['file'];
	      	$attachment = array(
	          	'post_mime_type' => $file_return['type'],
	          	'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
	          	'post_content' => '',
	          	'post_status' => 'inherit',
	          	'guid' => $file_return['url']
	      	);
	  
	      	$attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
	      	require_once(ABSPATH . 'wp-admin/includes/image.php');
	      	$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
	      	wp_update_attachment_metadata( $attachment_id, $attachment_data );
	      	if( 0 < intval( $attachment_id ) ) {
	      		return $attachment_id;
	      	}
	  	}
	  	return false;
	}
$items = array();	
$items[] = $_POST['poster'];

$get_id = upload_user_file($_POST['poster']);
print_r($items);
echo $get_id;
// echo $_POST['poster'];
// echo $_POST['abstrak'];
// echo $_POST['paper'];


if( ! empty( $_FILES ) ) {
  foreach( $_FILES as $file ) {
    if( is_array( $file ) ) {
      $attachment_id = upload_user_file( $file );
      echo $attachment_id;
    }
  }
}
?>