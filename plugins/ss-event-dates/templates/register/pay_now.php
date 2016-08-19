<?php

?>

<div class="container">
<div class="row">
<div class="col-md-12">
	<h3>Payment System</h3>
</div>
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

<form action="<?php echo get_site_url().'/wp-content/plugins/ss-event-dates/templates/register/ipaymu.php'; ?>" method="post">
<input type="hidden" name="item_name" value="<?php echo $_POST['payname']; ?>">
<input type="hidden" name="amount" value="<?php echo $_POST['total_idr_amount']; ?>">
<input type="hidden" name="ebarcode" value="<?php echo $_POST['ebarcode']; ?>">
<input type="image" src="<?php echo get_site_url()."/wp-content/plugins/ss-event-dates/assets/ipaymu-btn.png"; ?>" border="0" name="submit" alt="PROCESS WITH IPAYMU">
</form>
	</div>
<div class="col-md-12">
<div class="alert alert-success">
<h4>Before Continuing, please read this</h4>
<p>
<ol>
	<li>We do not save your debit or credit card credential on our server. We only need your personal account for registration purpose. We will keep your account confidentiality.</li>
	<li>All payment processes are safely forwarded into payment gateaway provider.</li>
	<li>Before continue the payment transaction, make sure your payment address come from https://www.paypal.com (for paypal) or https://my.ipaymu.com (for iPaymu) domain, started with https.</li>
	<li>Make sure your account has enough balance to do the payment transaction.</li>
	<li>Pay the correct amount according to the total amount that already given by our system.</li>
</ol>
</p>
</div>
	</div><!-- row -->
</div>