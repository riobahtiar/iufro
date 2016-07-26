<?php

?>

<div class="container">
	<div class="col-md-6">
	<h4>Pay with paypal</h4>

<form name="_xclick" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="riob-facilitator@softwareseni.com">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="item_name" value="<?php echo $_POST['payname']; ?>">
<input type="hidden" name="amount" value="<?php echo $_POST['total_amount']; ?>">
<input type="hidden" name="return" value="http://softwareseni.com/return" />
<input type="hidden" name="notify_url" value="http://softwareseni.com/notify" />
<input type="hidden" name="cancel_return" value="http://softwareseni.com/cancel" />
<input type="image" src="http://iufroacacia2017.com/wp-content/uploads/paynow.png" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>

<!-- end of pay -->
	</div>
	<hr>
	<div class="col-md-6">
	<h4>Pay with IPAYMU</h4>
		<div><label><input type="radio" name="paytype" value="ipaymu"> IPAYMU</label></div>
	</div>
</div>