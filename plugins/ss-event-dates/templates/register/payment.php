<?php
if(isset($_GET['step']) && $_GET['step']=="payment"){
	$post_url=get_permalink()."?step=paynow";
}else{
	$post_url="";
}




// get Get User Login
global $current_user;
wp_get_current_user();
$euser_email = $current_user->user_email;

//get user data
global $wpdb;
$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_email = '{$euser_email}'";
$user_detail = $wpdb->get_row( $query, ARRAY_A );

// Get Event Package Details
$mid_conf_q="SELECT * FROM wp_ss_event_package 
WHERE package_user = '{$euser_email}' 
AND package_item = 'Mid Conference'";

$post_conf_q="SELECT * FROM wp_ss_event_package 
WHERE package_user = '{$euser_email}' 
AND package_item = 'Post Conference'";

$mid_conf_var = $wpdb->get_row( $mid_conf_q, ARRAY_A );
$post_conf_var = $wpdb->get_row( $post_conf_q, ARRAY_A );

// mid conf
if(isset($mid_conf_var['package_detail'])){

        if ( $mid_conf_var['package_detail'] == "gunung-kidul" ) {
          $string_mid_conf="Gunung Kidul";
          $price_mid_conf = 0;
        }elseif ( $mid_conf_var['package_detail'] == "klaten" ) {
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
if(isset($post_conf_var['package_detail'])){
    // Pricing Post Conference
        if ( $post_conf_var['package_detail'] == "pacitan" ) {
          $string_post_conf="Pacitan ( USD 250 )";
          $price_post_conf = 250;
        }elseif ( $post_conf_var['package_detail'] == "pekanbaru_shared" ) {
          $string_post_conf="Pekanbaru | Shared Room ( USD 475 )";
          $price_post_conf = 475;
        }elseif ( $post_conf_var['package_detail'] == "pekanbaru_single" ) {
          $string_post_conf="Pekanbaru | Single Room ( USD 510 )";
          $price_post_conf = 510;
        }else{
          $string_post_conf=" - ";
          $price_post_conf = 0;
        }
}else{
  $string_post_conf=" - ";
  $price_post_conf = 0;
}

    // Paymen Dates Earlybird
    $paymentDate = date('Y-m-d');
    $paymentDate=date('Y-m-d', strtotime($paymentDate));
    $earlyBirdBegin = date('Y-m-d', strtotime("01/1/2016"));
    $earlyBirdEnd = date('Y-m-d', strtotime("04/30/2017"));


if ($user_detail['euser_type']=="local student") {
  $user_string = "Local | Students ( Rates apply USD 20 )";
  $total_price=$price_post_conf+20;
}elseif ($user_detail['euser_type']=="local regular") {
  // Early Bird Conf
    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd))
    {
        $user_string = "Local | Regular ( Early Bird rates apply USD 23 )";
        $total_price=$price_post_conf+23;
    } else {
        $user_string = "Local | Regular ( Rates apply USD 39 )";
        $total_price=$price_post_conf+39;
    }
}elseif ($user_detail['euser_type']=="foreigner") {

    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd))
    {
        $user_string = "Foreign ( Early Bird rates apply USD 350 )";
        $total_price=$price_post_conf+350;
    } else {
        $user_string = "Foreign ( Rates apply USD 400 )";
        $total_price=$price_post_conf+400;
    }

}else{
  $total_price=0;
}

  // Get Redux Settings
  global $ss_theme_opt; 
  
  //-----------PAGE HEADER-------------------
  if(isset($ss_theme_opt['datatest'])){
      echo "<div class='well'>".$user_detail['euser_type']." Redux Settings OK".$ss_theme_opt['datatest']." </div>";
  }

?>

<div class="container">
<h3>Summaries</h3>
<div class="payment-info">
<p>Here you can see the details of your transaction activity.</p>
<h4>Type of Membership</h4>
<p>you are choose <?php echo $user_string; ?></p>
<hr>
<h4>Add On Facilities</h4>
<div class="row">
<div class="col-md-6">
<h5>Field Trip</h5>
<dl class="dl-horizontal">
  <dt>Mid Conference Trip</dt>
  <dd><?php echo $string_mid_conf;   ?>  </dd>
</dl>
<dl class="dl-horizontal">
  <dt>Post Conference Trip</dt>
  <dd><?php echo $string_post_conf;   ?> </dd>
</dl>
<dl class="dl-horizontal">
  <dt>Dinner Conference</dt>
  <dd>Yes</dd>
</dl>
</div>
<div class="col-md-6">
<h5>Your Documents</h5>
<?php 
//Abstract URL
$abstract_download = wp_get_attachment_url( $user_detail['euser_abstrak'] );
$paper_download = wp_get_attachment_url( $user_detail['euser_paper']  );
$poster_download = wp_get_attachment_url( $user_detail['euser_poster']  );
if(!empty($abstract_download)){
 ?>
<dl class="dl-horizontal">
  <dt>Abstract</dt>
  <dd><a href="<?php echo $abstract_download; ?>">Download</a></dd>
</dl>
<?php
}
if(!empty($paper_download)){
?>
<dl class="dl-horizontal">
  <dt>Paper</dt>
  <dd><a href="<?php echo $paper_download; ?>">Download</a></dd>
</dl>
<?php
}
if(!empty($poster_download)){
  //var_dump($poster_download); 
?>
<dl class="dl-horizontal">
  <dt>Poster</dt>
  <dd><a href="<?php echo $poster_download; ?>">Download</a></dd>
</dl>
<?php
}
?>
</div>
<div class="col-md-12">
<br><br><br>
<hr>
<div>
  You may continue to the payment after your document has been Approved by us. 
</div>

<dl class="dl-horizontal">
  <dt>NET Total</dt>
  <dd><h3>USD <?php echo $total_price; ?></h3></dd>
</dl>
</div>
</div><!-- row -->

</div>
<?php

 ?>
<form action="<?php echo $post_url; ?>" method="post">
<input type="hidden" name="total_amount" value="<?php echo $total_price; ?>">
<input type="hidden" name="payname" value="IUFRO PY-<?php echo date('Ymd') ?>">
<div>
  	<a href="<?php echo get_permalink()."?step=addon"; ?>" class="btn btn-default pull-left">Back</a>
  	<button type="submit" name="submit" class="btn btn-default pull-right" value="payment">Pay Now</button>

  	<a href="<?php echo get_permalink(); ?>?step=pay_later" class="btn btn-default pull-right">Pay Later</a>
</div>
</form>
</div>