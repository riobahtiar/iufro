<?php

// Response from Paypal
    // read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    foreach ($_POST as $key => $value) {
        $value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
        $req .= "&$key=$value";
    }

    // assign posted variables to local variables
    $data['item_name']          = $_POST['item_name'];
    $data['item_number']        = $_POST['item_number'];
    $data['payment_status']     = $_POST['payment_status'];
    $data['payment_amount']     = $_POST['mc_gross'];
    $data['payment_currency']   = $_POST['mc_currency'];
    $data['txn_id']             = $_POST['txn_id'];
    $data['receiver_email']     = $_POST['receiver_email'];
    $data['payer_email']        = $_POST['payer_email'];
    $data['custom']             = $_POST['custom'];
    $data['invoice']            = $_POST['invoice'];
    $data['paypallog']          = $req;

    // post back to PayPal system to validate
    $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
    $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); 

    if (!$fp) {
        // HTTP ERROR
    } else {    


        fputs ($fp, $header . $req);
        while (!feof($fp)) {
            ////mail('riob@softwareseni.com','Step 9','Step 9');        
            $res = fgets ($fp, 1024);
            if (true || strcmp($res, "VERIFIED") == 0) {
                ////mail('riob@softwareseni.com','PAYMENT VALID','PAYMENT VALID');  

            // Validate payment (Check unique txnid & correct price)
            $valid_txnid = check_txnid($data['txn_id']);
            $valid_price = check_price($data['payment_amount'], $data['item_number']);
            // PAYMENT VALIDATED & VERIFIED!
            if($valid_txnid && $valid_price){               
            //----------------- INSERT RECORDS TO DATABASE-------------------------------------
            if ($data['invoice']=='basic') {
                $price = 39;
            } else { 
                $price = 159;
            }
            $this->user_model->update_user(
                array(
                    'id' => $data['custom'],
                    'user_status' => 1,
                    'payment_date' => date("Y-m-d H:i:s",time()),
                    'next_payment_date' => date('Y-m-d', strtotime('+32 days')),
                    'user_package' => $data['invoice'],
                    'package_price' => $price
                )
            );
            $data2 = array('id' => '',
            'txn_id' => $data['txn_id'],
            'amount' => $data['payment_amount'],
            'mode ' => $data['payment_status'],
            'paypal_log' => $data['paypallog'],
            'user_id' => $data['custom'],
            'created_at' => date('Y-m-d H:i:s',time())

            );
            $this->db->insert('tbl_paypal_log', $data2);
            //----------------- INSERT RECORDS TO DATABASE-------------------------------------
            }else{                  
            // Payment made but data has been changed
            // E-mail admin or alert user
            }                       

        } elseif ($res=='INVALID') {

                // PAYMENT INVALID & INVESTIGATE MANUALY! 
                // E-mail admin or alert user
                ////mail('riob@softwareseni.com','PAYMENT INVALID AND INVESTIGATE MANUALY','PAYMENT INVALID AND INVESTIGATE MANUALY');  

        }       
        }       
    fclose ($fp);
    }   






    // ==== IPN ==== //

    <?php

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
//curl_setopt($ch, CURLOPT_CAINFO, $cert);

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

    // assign posted variables to local variables
    //$item_name = $_POST['item_name'];
    //$item_number = $_POST['item_number'];
    //$payment_status = $_POST['payment_status'];
    //$payment_amount = $_POST['mc_gross'];
    //$payment_currency = $_POST['mc_currency'];
    //$txn_id = $_POST['txn_id'];
    //$receiver_email = $_POST['receiver_email'];
    //$payer_email = $_POST['payer_email'];

    // assign posted variables to local variables
    $item_name         = $_POST['item_name'];
    $item_number       = $_POST['item_number'];
    $payment_status    = $_POST['payment_status'];
    $payment_amount    = $_POST['mc_gross'];
    $payment_currency  = $_POST['mc_currency'];
    $txn_id            = $_POST['txn_id'];
    $receiver_email    = $_POST['receiver_email'];
    $payer_email       = $_POST['payer_email'];
    $custom            = $_POST['custom'];
    $invoice           = $_POST['invoice'];




    if(DEBUG == true) {
        error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
    }
} else if (strcmp ($res, "INVALID") == 0) {
    // log for manual investigation
    // Add business logic here which deals with invalid IPN messages
    if(DEBUG == true) {
        error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
    }
}

?>