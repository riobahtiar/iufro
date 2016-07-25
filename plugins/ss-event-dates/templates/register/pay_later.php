<?php

$to = 'riob@softwareseni.com';
$subject = 'Yoww Laa Testing Pay Later';
$body = 'From Rio Bahtiar IUFRO, Paylater Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi dolores dolore, earum doloribus, veritatis reiciendis qui numquam consequuntur nihil nostrum maiores, quas mollitia accusantium iure et. Laboriosam rem, aspernatur sit! <br> <strong>Is Bold text</strong>';
$headers[] = 'Content-Type: text/html; charset=UTF-8';
$headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
$headers[] = 'Cc: Gamma Aieska <gamma@softwareseni.com>';
$headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>'; // note you can just use a simple email address
wp_mail( $to, $subject, $body, $headers );
echo "Check Your Email";
?>