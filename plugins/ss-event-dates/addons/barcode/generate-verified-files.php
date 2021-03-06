<?php

include('src/BarcodeGenerator.php');
include('src/BarcodeGeneratorPNG.php');
include('src/BarcodeGeneratorSVG.php');
include('src/BarcodeGeneratorJPG.php');
include('src/BarcodeGeneratorHTML.php');

$generatorSVG = new Picqer\Barcode\BarcodeGeneratorSVG();
file_put_contents('tests/verified-files/081231723897-ean13.svg', $generatorSVG->getBarcode('081231723897', $generatorSVG::TYPE_EAN_13));

$generatorHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
file_put_contents('tests/verified-files/081231723897-code128.html', $generatorHTML->getBarcode('081231723897', $generatorHTML::TYPE_CODE_128));

$generatorSVG = new Picqer\Barcode\BarcodeGeneratorSVG();
file_put_contents('tests/verified-files/0049000004632-ean13.svg', $generatorSVG->getBarcode('0049000004632', $generatorSVG::TYPE_EAN_13));

$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
echo '<br><hr>TYPE_CODE_128<br><img height="auto" width="300px" src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128)) . '"><br><br><br><br>';
echo '<br><hr>TYPE_CODE_128_B<br><img height="auto" width="300px" src="data:image/png;base64,' . base64_encode($generator->getBarcode('04563897', $generator::TYPE_CODE_128_B)) . '"><br><br><br><br>';
echo '<br><hr>TYPE_CODABAR<br><img height="auto" width="300px" src="data:image/png;base64,' . base64_encode($generator->getBarcode('08145654697', $generator::TYPE_CODABAR)) . '"><br><br><br><br>';
echo '<br><hr>TYPE_RMS4CC<br><img height="auto" width="300px" src="data:image/png;base64,' . base64_encode($generator->getBarcode('084565465465497', $generator::TYPE_RMS4CC)) . '"><br><br><br><br>';
echo '<br><hr>TYPE_POSTNET<br><img height="auto" width="300px" src="data:image/png;base64,' . base64_encode($generator->getBarcode('08145654654697', $generator::TYPE_POSTNET)) . '"><br>';