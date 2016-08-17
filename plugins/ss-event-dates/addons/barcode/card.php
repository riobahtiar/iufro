<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';
$euser_barcode = $_GET['brcd'];
global $wpdb;
$query       = "SELECT * FROM wp_ss_event_user_detail WHERE euser_barcode = '{$euser_barcode}'";
$user_detail = $wpdb->
    get_row($query, ARRAY_A);

include('src/BarcodeGenerator.php');
include('src/BarcodeGeneratorPNG.php');
$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Card Copy</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <style type="text/css">
    body{
    	font-family: 'Open Sans', sans-serif;
    	margin: 0;
    	padding: 0;
    }
	.card {
	    width: 9.5cm;
	    height: 13.5cm;
	    background: #dedede;
	    position: absolute;
	    border-color: #928c8c;
	    border-width: thin;
	    border-style: solid;
	}
	.name {
    	width: 80%;
    	margin-top: 1cm;
    	margin-left: auto;
    	margin-right: auto;
    	text-align: center;
    	text-transform: capitalize;
    	padding: 0.1cm;
	}
	.name p{
		font-size: 10pt;
    	margin: 0;
    	margin-top: -7px;
	}
	h4{
		margin-bottom: 0;
		margin-top: 0;
		font-size: 13pt;
		text-transform: capitalize;
	}

    </style>
 </head>
<body>
<div class="card">
<div class="name">
<h4> <?php echo "Prof. rio bahtiar"; ?> </h4>
<?php
echo '<img height="auto" width="200px" src="data:image/png;base64,' . base64_encode($generator->getBarcode('04563897', $generator::TYPE_CODE_128_B)) . '">';
echo "<p>8565656565665</p>";
  ?>
</div>
</div>
</body>
</html>