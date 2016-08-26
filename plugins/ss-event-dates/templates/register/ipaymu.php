<?php
// Open CURL session:
$ch = curl_init($oxr_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Get the data:
$json = curl_exec($ch);
curl_close($ch);
$oxr_latest = json_decode($json);

// URL Payment IPAYMU
$url = 'https://my.ipaymu.com/payment.htm';




// Prepare Parameters
$params = array(
            'key'      => 'qy8HHvRg1j1HD1F5WG80wLSy0TTzY1', // API Key Merchant / Penjual
            'action'   => 'payment',
            'product'  => $_POST['item_name'],
            'price'    => 10212, // Total Harga
            'quantity' => 1,
            'comments' => 'Extra Details = Product Name: '.$_POST['item_name'].' - Barcode: '.$_POST['ebarcode'].' - Amount: '.$_POST['amount'].' - Time: '.date('Y-m-d H:i:s'), // Optional           
            'ureturn'  =>   'http://www.iufroacacia2017.com//login/user_dashboard?step=paypal_success&trxname='.$_POST['item_name'],
            'unotify'  =>   'http://www.iufroacacia2017.com/wp-content/plugins/ss-event-dates/ajax/ipaymu_notify.php?auth_code='.$_POST['ebarcode'],
            'ucancel'  =>   'http://www.iufroacacia2017.com/login/user_dashboard?step=paypal_cancel',
            'format'   => 'json' // Format: xml / json. Default: xml 
        );

$params_string = http_build_query($params);

//open connection
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($params));
curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

//execute post
$request = curl_exec($ch);

if ( $request === false ) {
    echo 'Curl Error: ' . curl_error($ch);
} else {
    
    $result = json_decode($request, true);

    if( isset($result['url']) )
        header('location: '. $result['url']);
    else {
        echo "Request Error ". $result['Status'] .": ". $result['Keterangan'];
    }
}

//close connection
curl_close($ch);

?>