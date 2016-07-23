<?php
if(isset($_GET['step']) && $_GET['step']=="free"){
	$post_url=get_permalink()."?step=detail_profil";
}else{
	$post_url="";
}
?>

<div class="container">
<h3>Free Account</h3>
<div class="box-info">
  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure blanditiis dolor dolores. Eligendi, eius a dicta esse nostrum, eum adipisci et possimus dolor debitis modi distinctio, fugiat! Omnis porro, ullam?

</div>
<form action="<?php echo $post_url; ?>" method="post">
  <div>
      <button id="btnval" type="submit" name="submit" class="btn btn-default pull-right" value="detail_profil">Edit Profile</button>
  </div>
</form>
</div>