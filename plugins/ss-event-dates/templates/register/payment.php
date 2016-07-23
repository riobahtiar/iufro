<?php
if(isset($_GET['step']) && $_GET['step']=="payment"){
	$post_url=get_permalink()."?step=detail_profil";
}else{
	$post_url="";
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
 $midtrip = $_POST["mid-conf-trip"];
 $posttrip = $_POST["post-conf-trip"];
echo "Mid Conf-".$midtrip."<br>";
echo "Post Conf-".$posttrip."<br>";
?>
<dl class="dl-horizontal">
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
  	<a href="<?php echo get_permalink(); ?>?step=paynow" class="btn btn-default pull-right">Pay Now</a>
</div>
</form>
</div>