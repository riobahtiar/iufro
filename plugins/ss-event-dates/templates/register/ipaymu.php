<?php


// https://openexchangerates.org/ convert pricing 
$app_id = '242fb9ae64974346985dcec68f9986e8';
$oxr_url = "https://openexchangerates.org/api/latest.json?app_id=" . $app_id;

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
            'product'  => 'Nama Produk',
            'price'    => '101000', // Total Harga
            'quantity' => 1,
            'comments' => 'Keterangan Produk', // Optional           
            'ureturn'  => 'http://iufroacacia2017.com/login/_dashboard?step=ipaymu',
            'unotify'  => 'http://iufroacacia2017.com/login/_dashboard?step=ipaymu',
            'ucancel'  => 'http://iufroacacia2017.com/login/_dashboard?step=ipaymu',
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