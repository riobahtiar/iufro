<?php

?>

<div class="container">
	<div class="col-md-6">
	<h4>Pay with paypal</h4>
<div class="well">
Paypal suitable for Foreigner transaction. Support Credit Card and Paypal Credit
</div>
<form name="_xclick" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="riob-facilitator@softwareseni.com">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="item_name" value="<?php echo $_POST['payname']; ?>">
<input type="hidden" name="amount" value="<?php echo $_POST['total_amount']; ?>">
<input type="hidden" name="return" value="<?php echo get_site_url().'/login/user_dashboard?step=paypal_success&trxname='.$_POST['payname']; ?>" />
<input type="hidden" name="notify_url" value="<?php echo get_site_url()."/wp-content/plugins/ss-event-dates/ajax/pyipn_v2.php?auth_code=".$_POST['ebarcode']; ?>" />
<input type="hidden" name="cancel_return" value="<?php echo get_site_url()."/login/user_dashboard?step=paypal_cancel"; ?>" />
<input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png" border="0" name="submit" alt="Check out with PayPal">
</form>

<!-- end of pay -->
	</div>
	<hr>
	<div class="col-md-6">
	<h4>Pay with IPAYMU</h4>
<div class="well">
IPAYMU suitable for Local Transaction (Indonesia). Support Bank Transfer for various banks in indonesia.
</div>

<form action="<?php echo get_permalink() . "?step=ipaymu"; ?>" method="post">
<input type="hidden" name="item_name" value="<?php echo $_POST['payname']; ?>">
<input type="hidden" name="amount" value="<?php echo $_POST['total_idr_amount']; ?>">
<input type="hidden" name="ebarcode" value="<?php echo $_POST['ebarcode']; ?>">
<button type="submit" class="btn btn-primary btn-block">PROCESS WITH IPAYMU</button>
</form>
	</div>
</div>