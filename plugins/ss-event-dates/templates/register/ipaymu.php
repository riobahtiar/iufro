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
            'product'  => $_POST['payname'],
            'price'    => $_POST['amount'], // Total Harga
            'quantity' => 1,
            'comments' => 'Extra Details = Product Name: '.$_POST['payname'].' - Barcode: '.$_POST['ebarcode'].' - Amount: '.$_POST['amount'].' - Time: '.date('Y-m-d H:i:s'), // Optional           
            'ureturn'  =>   get_site_url().'/login/user_dashboard?step=paypal_cancel',
            'unotify'  =>   get_site_url().'/wp-content/plugins/ss-event-dates/ajax/pyipn_v2.php?auth_code='.$_POST['ebarcode'],
            'ucancel'  =>   get_site_url().'/login/user_dashboard?step=paypal_cancel',
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