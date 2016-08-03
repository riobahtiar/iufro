<?php


if (isset($_GET['auth_code'])) {
    $barcodeno = $_GET['auth_code'];

// Include wp-load
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once( $parse_uri[0] . 'wp-load.php' );
$upload_dir = wp_upload_dir();


//get user data
global $wpdb;
$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_barcode = '{$barcodeno}'";
$user_detail = $wpdb->get_row( $query, ARRAY_A );

if(isset($user_detail['euser_addon_mid'] )){

        if ( $user_detail['euser_addon_mid'] == "gunung-kidul" ) {
          $string_mid_conf="Gunung Kidul";
          $price_mid_conf = 0;
        }elseif ( $user_detail['euser_addon_mid'] == "klaten" ) {
          $string_mid_conf="Klaten";
          $price_mid_conf = 0;
        }else{
          $string_mid_conf=" - ";
          $price_mid_conf = 0;
        } 

}else{
  $string_mid_conf=" - ";
  $price_mid_conf == 0;
}

// post conf
if(isset($user_detail['euser_addon_post'])){
    // Pricing Post Conference
        if ( $user_detail['euser_addon_post'] == "pacitan" ) {
          $string_post_conf="Pacitan ( US$ 250 )";
          $price_post_conf = 250;
        }elseif ( $user_detail['euser_addon_post'] == "pekanbaru_shared" ) {
          $string_post_conf="Pekanbaru | Shared Room ( US$ 475 )";
          $price_post_conf = 475;
        }elseif ( $user_detail['euser_addon_post'] == "pekanbaru_single" ) {
          $string_post_conf="Pekanbaru | Single Room ( US$ 510 )";
          $price_post_conf = 510;
        }else{
          $string_post_conf=" - ";
          $price_post_conf = 0;
        }
}else{
  $string_post_conf=" - ";
  $price_post_conf = 0;
}

if(isset($user_detail['euser_addon_dinner'])){
  $string_dinner=" Yes ";
}else{
  $string_dinner=" No ";
}

if ($user_detail['euser_type']=="local student") {
  $user_string = "Local | Students ( Rates apply US$ 20 )";
  $total_price=$price_post_conf+20;
}elseif ($user_detail['euser_type']=="local regular") {
  $user_string = "Local | Regular ( Rates apply US$ 30 )";
  $total_price=$price_post_conf+30;
}elseif ($user_detail['euser_type']=="foreigner") {
  $user_string = "Foreign   ( Rates apply US$ 400 )";
  $total_price=$price_post_conf+400;
}else{
  $total_price=0;
}















}
// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
// Set this to 0 once you go live or don't require logging.
define("DEBUG", 1);

// Set to 0 once you're ready to go live
define("USE_SANDBOX", 1);


define("LOG_FILE", "./ipn.log");




// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}

// Post IPN data back to PayPal to validate the IPN data is genuine
// Without this step anyone can fake IPN data

if(USE_SANDBOX == true) {
	$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
	$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}

$ch = curl_init($paypal_url);
if ($ch == FALSE) {
	return FALSE;
}

curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

if(DEBUG == true) {
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}

// CONFIG: Optional proxy configuration
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

// Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below. Ensure the file is readable by the webserver.
// This is mandatory for some environments.

//$cert = __DIR__ . "./cacert.pem";
$cert = $upload_dir['basedir']."/xpathvy/cacert.pem";
curl_setopt($ch, CURLOPT_CAINFO, $cert);

$res = curl_exec($ch);
if (curl_errno($ch) != 0) // cURL error
	{
	if(DEBUG == true) {	
		error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
	}
	curl_close($ch);
	exit;

} else {
		// Log the entire HTTP response if debug is switched on.
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
			error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
		}
		curl_close($ch);
}

// Inspect IPN validation result and act accordingly

// Split response headers and payload, a better way for strcmp
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));

if (strcmp ($res, "VERIFIED") == 0) {
	// check whether the payment_status is Completed
	// check that txn_id has not been previously processed
	// check that receiver_email is your PayPal email
	// check that payment_amount/payment_currency are correct
	// process payment and mark item as paid.

	//assign posted variables to local variables
	$item_name = $_POST['item_name'];
	$item_number = $_POST['item_number'];
	$payment_status = $_POST['payment_status'];
	$payment_amount = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$txn_id = $_POST['txn_id'];
	$receiver_email = $_POST['receiver_email'];
	$payer_email = $_POST['payer_email'];

	$packlogs = "item_name >".$item_name."| item_number >".$item_number."| payment_status >".$payment_status."| payment_amount >".$payment_amount."| payment_currency >".$payment_currency."| txn_id >".$txn_id."| receiver_email >".$receiver_email."| payer_email >".$payer_email;

	    global $wpdb; 
		$wpdb->update( 
			'wp_ss_event_user_detail', 
			array( 
				'euser_payment_status' => $payment_status,	// string
				'euser_payment_meta' => $packlogs	// integer (number) 
			), 
			array( 'euser_barcode' => $barcodeno ), 
			array( 
				'%s',	
				'%s'	
			), 
			array( '%s' ) 
		);

	if( $wpdb->update(
			'wp_ss_event_user_detail', 
			array( 
				'euser_payment_status' => $payment_status,	// string
				'euser_payment_meta' => $packlogs	// integer (number) 
			), 
			array( 'euser_barcode' => $barcodeno ), 
			array( 
				'%s',	
				'%s'	
			), 
			array( '%s' )) === FALSE){

// === SEND USER EMAIL if FAILED=== //
$to = 'akhibahtiar@gmail.com';
$subject = 'Payment Failed and not updated';
$body = $packlogs;
$body .= 'payment failed one';
$headers[] = 'Content-Type: text/html; charset=UTF-8';
$headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
$headers[] = 'Cc: Rio Bahtiar <riob@softwareseni.com>'; 
wp_mail( $to, $subject, $body, $headers );
// === SEND USER EMAIL === //


	}else{
// === SEND USER EMAIL if Success //
$to = 'akhibahtiar@gmail.com';
$subject = 'Payment Success and updated';
$body = $packlogs;
$body .= 'payment failed one';
$headers[] = 'Content-Type: text/html; charset=UTF-8';
$headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
$headers[] = 'Cc: Rio Bahtiar <riob@softwareseni.com>'; 
wp_mail( $to, $subject, $body, $headers );
// === SEND USER EMAIL === //
	}
   

	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
	}
} else if (strcmp ($res, "INVALID") == 0) {
	// log for manual investigation
	// Add business logic here which deals with invalid IPN messages
	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
	}
	// === SEND USER EMAIL if Success //
$to = 'akhibahtiar@gmail.com';
$subject = 'Payment error last invalid';
$body = $packlogs;
$body .= 'Payment error last invalid';
$headers[] = 'Content-Type: text/html; charset=UTF-8';
$headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
$headers[] = 'Cc: Rio Bahtiar <riob@softwareseni.com>'; 
wp_mail( $to, $subject, $body, $headers );
// === SEND USER EMAIL === //
}

?>