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

// Decode JSON response:
$latest_price = json_decode($json);

// You can now access the rates inside the parsed object, like so:
// printf(
//     "1 %s equals %s IDR at %s",
//     $oxr_latest->base,
//     $oxr_latest->rates->IDR,
//     date('H:i jS F, Y', $oxr_latest->timestamp)
// );
// -> eg. "1 USD equals: 0.656741 IDR at 11:11, 11th December 2015"