<?php
if(isset($_GET['step']) && $_GET['step']=="payment"){
	$post_url=get_permalink()."?step=detail_profil";
}else{
	$post_url="";
}

// mid conf
if(isset($_POST['mid-conf']) && $_POST['mid-conf']=="on" ){
  $mid_conf=$_POST['mid-conf'];
    // Pricing Post Conference
        if ( $_POST["mid-conf-child"] == "gunung-kidul" ) {
          $price_mid_conf = 0;
        }elseif ( $_POST["mid-conf-child"] == "klaten" ) {
          $price_mid_conf = 0;
        }else{
          $price_mid_conf = 0;
        } 

}else{
  $price_mid_conf == 0;
}

// post conf
if(isset($_POST['post-conf']) && $_POST['post-conf']=="on" ){
  $post_conf=$_POST['post-conf'];
    // Pricing Post Conference
        if ( $_POST["post-conf-child"] == "pekanbaru" ) {
          $price_post_conf = 300;
        }elseif ( $_POST["post-conf-child"] == "pacitan" ) {
          $price_post_conf = 500;
        }else{
          $price_post_conf = 0;
        }
}else{
  $price_post_conf = 0;
}

if ($user_detail['euser_type']=="author_type") {
 $total_price=$price_post_conf+400;
}elseif ($user_detail['euser_type']=="local regular") {
 $total_price=$price_post_conf+300;
}else{
  $total_price=0;
}



?>

<div class="container">
<h3>Summaries</h3>
<div class="payment-info">
<p>Here you can see the details of your transaction activity.</p>
<h4>Type of Membership</h4>
<p>you are choose LOCAL PARTICIPANT ( Regular )</p>
<hr>
<h4>Add On Facilities</h4>
<div class="row">
<div class="col-md-6">
<h5>Field Trip</h5>
<dl class="dl-horizontal">
  <dt>Mid Conference Trip</dt>
  <dd>Gunung Kidul</dd>
</dl>
<dl class="dl-horizontal">
  <dt>Post Conference Trip</dt>
  <dd>Pekanbaru(Shared Room)</dd>
</dl>
<dl class="dl-horizontal">
  <dt>Dinner Conference</dt>
  <dd>Yes</dd>
</dl>
</div>
<div class="col-md-6">
<h5>Your Documents</h5>
<dl class="dl-horizontal">
  <dt>Abstract</dt>
  <dd><a href="#">Download</a></dd>
</dl>
<dl class="dl-horizontal">
  <dt>Paper</dt>
  <dd><a href="#">Download</a></dd>
</dl>
<dl class="dl-horizontal">
  <dt>Poster</dt>
  <dd><a href="#">Download</a></dd>
</dl>
</div>
<div class="col-md-12">
<br><br><br>
<hr>
<?php
echo "Testting<br>";
// Calculation for all transaction
?>
<dl class="dl-horizontal">
<?php
echo "<br>price_mid_conf:".$price_mid_conf;
echo "<br>price_post_conf:".$price_post_conf;
echo "<br>mid-conf:".$mid_conf;
echo "<br>post-conf:".$post_conf;
?>
  <dt>NET Total</dt>
  <dd><h3>$ 200 USD</h3></dd>
</dl>
</div>
</div><!-- row -->

</div>
<form action="<?php echo $post_url; ?>" method="post">
<div>
  	<a href="<?php echo get_permalink(); ?>?step=addon" class="btn btn-default pull-left">Back</a>
  	<button type="submit" name="submit" class="btn btn-default pull-right" value="payment">Pay Later</button>
  	<a href="<?php echo get_permalink(); ?>?step=paynow&$total_price=<?php echo $total_price; ?>&price_post_conf=<?php echo $price_post_conf; ?>&payment=paypal" class="btn btn-default pull-right">Pay Now</a>
</div>
</form>
</div>