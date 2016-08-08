<?php
if (isset($_GET['step']) && $_GET['step'] == "payment") {
    $post_url = get_permalink() . "?step=paynow";
} else {
    $post_url = "";
}

// Get Rupiah Rates
$app_id = '242fb9ae64974346985dcec68f9986e8';
$oxr_url = "https://openexchangerates.org/api/latest.json?app_id=" . $app_id;

// Open CURL session:
$ch = curl_init($oxr_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Get the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$latest_price = json_decode($json);
$idr_rates = $latest_price->rates->IDR;
$idr_good = round($idr_rates);
echo "Rates ID:".$idr_rates." Dibulatkan: ".$idr_good;
// get Get User Login
global $current_user;
wp_get_current_user();
$euser_email = $current_user->user_email;

//get user data
global $wpdb;
$query       = "SELECT * FROM wp_ss_event_user_detail WHERE euser_email = '{$euser_email}'";
$user_detail = $wpdb->get_row($query, ARRAY_A);

// mid conf
if (isset($user_detail['euser_addon_mid'])) {

    if ($user_detail['euser_addon_mid'] == "gunung-kidul") {
        $string_mid_conf = "Gunung Kidul";
        $price_mid_conf  = 0;
    } elseif ($user_detail['euser_addon_mid'] == "klaten") {
        $string_mid_conf = "Klaten";
        $price_mid_conf  = 0;
    } elseif ($user_detail['euser_addon_mid'] == "mount-merapi") {
        $string_mid_conf = "Mount Merapi";
        $price_mid_conf  = 0;
    } else {
        $string_mid_conf = " - ";
        $price_mid_conf  = 0;
    }

} else {
    $string_mid_conf = " - ";
    $price_mid_conf == 0;
}

// post conf
if (isset($user_detail['euser_addon_post'])) {
    // Pricing Post Conference
    if ($user_detail['euser_addon_post'] == "pacitan") {
        $string_post_conf = "Pacitan ( USD 250 )";
        $price_post_conf  = 250;
    } elseif ($user_detail['euser_addon_post'] == "pekanbaru_shared") {
        $string_post_conf = "Pekanbaru | Shared Room ( USD 475 )";
        $price_post_conf  = 475;
    } elseif ($user_detail['euser_addon_post'] == "pekanbaru_single") {
        $string_post_conf = "Pekanbaru | Single Room ( USD 510 )";
        $price_post_conf  = 510;
    } else {
        $string_post_conf = " - ";
        $price_post_conf  = 0;
    }
} else {
    $string_post_conf = " - ";
    $price_post_conf  = 0;
}

if (isset($user_detail['euser_addon_dinner'])) {
    if ($user_detail['euser_addon_dinner'] == "Yes") {
        $string_dinner = " Yes ";
    } elseif ($user_detail['euser_addon_dinner'] == "No") {
        $string_dinner = " No ";
    } else {
        $string_dinner = "-";
    }
}

// Payment Dates Earlybird
$paymentDate    = date('Y-m-d');
$paymentDate    = date('Y-m-d', strtotime($paymentDate));
$earlyBirdBegin = date('Y-m-d', strtotime("01/1/2016"));
$earlyBirdEnd   = date('Y-m-d', strtotime("04/30/2017"));

if ($user_detail['euser_type'] == "local student") {
    $user_string = "Local | Students";
    $total_price = $price_post_conf + 20;
    $user_price  = 20;
} elseif ($user_detail['euser_type'] == "local regular") {
    // Early Bird Conf
    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
        $user_string = "Local | Regular ( Early Bird Rates )";
        $total_price = $price_post_conf + 23;
        $user_price  = 23;
    } else {
        $user_string = "Local | Regular ( Regular Rates )";
        $total_price = $price_post_conf + 39;
        $user_price  = 39;
    }
} elseif ($user_detail['euser_type'] == "foreigner") {

    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
        $user_string = "Foreign ( Early Bird Rates )";
        $total_price = $price_post_conf + 350;
        $user_price  = 350;
    } else {
        $user_string = "Foreign ( Regular Rates )";
        $total_price = $price_post_conf + 400;
        $user_price  = 400;
    }

} else {
    $total_price = 0;
}

?>

<div class="container">
<h3>Summaries</h3>
<div class="payment-info">
<p>Here you can see the details of your transaction activity.</p>
<hr>
<div class="row">
<div class="col-md-6">

</div>
<?php if ($user_detail['euser_meta_type'] != "participant_type") {
    ?>
<div class="col-md-6">
<h5>Your Documents</h5>
<?php
//Abstract URL
    $abstract_download = wp_get_attachment_url($user_detail['euser_abstrak']);
    $paper_download    = wp_get_attachment_url($user_detail['euser_paper']);
    $poster_download   = wp_get_attachment_url($user_detail['euser_poster']);
    if (!empty($abstract_download)) {
        ?>
<dl class="dl-horizontal">
  <dt>Abstract</dt>
  <dd><a href="<?php echo $abstract_download; ?>">Download</a></dd>
</dl>
<?php
}
    if (!empty($paper_download)) {
        ?>
<dl class="dl-horizontal">
  <dt>Paper</dt>
  <dd><a href="<?php echo $paper_download; ?>">Download</a></dd>
</dl>
<?php
}
    if (!empty($poster_download)) {
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
<?php }?>
<div class="col-md-12">
<table class="table table-bordered">
    <thead>
      <tr class="success">
        <th>No</th>
        <th>Name</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1 </td>
        <td>
<dl class="dl-horizontal">
  <dt>Membership</dt>
  <dd><?php echo $user_string; ?>  </dd>
</dl>
        </td>
        <td>US$ <?php echo $user_price; ?></td>
      </tr>
      <tr>
        <td>2</td>
        <td>
<dl class="dl-horizontal">
  <dt>Mid Conference Trip</dt>
  <dd><?php echo $string_mid_conf; ?>  </dd>
</dl>
        </td>
        <td>Free</td>
      </tr>
      <tr>
        <td>3</td>
        <td>
<dl class="dl-horizontal">
  <dt>Post Conference Trip</dt>
  <dd><?php echo $string_post_conf; ?> </dd>
</dl>

        </td>
        <td>US$ <?php echo $price_post_conf; ?></td>
      </tr>
      <tr>
        <td>4</td>
        <td>
<dl class="dl-horizontal">
  <dt>Dinner Conference</dt>
  <dd><?php echo $string_dinner; ?></dd>
</dl>
        </td>
        <td> Free </td>
      </tr>
    </tbody>
    <tfoot>
    <tr class="success">
      <td colspan="2" > Net Total </td>
      <td>US$ <?php echo $total_price; ?> | IDR <?php
        $idr_total = $idr_rates * $total_price; 
        echo $idr_total;
       ?></td>
    </tr>
  </tfoot>
  </table>

</div>
<hr>
<?php if ($user_detail['euser_meta_type'] == "author_type" && $user_detail['euser_doc_status'] !== null || $user_detail['euser_meta_type'] == "author_type" && $user_detail['euser_doc_status'] == 'accepted') {?>
<div class="well payment-alert">
  You may continue to the payment after your document has been approved by us.
</div>
<?php }?>
</div><!-- row -->

</div>

<form action="<?php echo get_permalink() . "?step=paynow"; ?>" method="post">
<input type="hidden" name="total_amount" value="<?php echo $total_price; ?>">
<input type="hidden" name="ebarcode" value="<?php echo $user_detail['euser_barcode']; ?>">
<input type="hidden" name="payname" value="IAC2017-<?php echo $user_detail['euser_barcode']; ?>">
<div>
    <a href="<?php echo get_permalink() . "?step=addon"; ?>" class="btn btn-default pull-left">Back</a>
<?php if ($user_detail['euser_meta_type'] == "author_type" && $user_detail['euser_doc_status'] !== null || $user_detail['euser_meta_type'] == "participant_type" || $user_detail['euser_meta_type'] == "author_type" && $user_detail['euser_doc_status'] == 'accepted') {?>
    <button type="submit" name="submit" class="btn btn-default pull-right" value="payment">Pay Now</button>
    <a href="<?php echo get_permalink(); ?>?step=pay_later" class="btn btn-default pull-right">Pay Later</a>
<?php }?>
</div>
</form>
</div>