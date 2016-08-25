<?php
if (isset($_GET['step']) && $_GET['step'] == "payment") {
    $post_url = get_permalink() . "?step=paynow";
} else {
    $post_url = "";
}



// Decode JSON response:
$latest_price = json_decode($json);
$idr_rates    = getCurrencyRate('USD','IDR');
$idr_good     = round($idr_rates);
//echo "Rates ID:".$idr_rates." Dibulatkan: ".$idr_good;
// get Get User Login
global $current_user;
wp_get_current_user();
$euser_email = $current_user->user_email;

//get user data
global $wpdb;
global $ss_theme_opt; 
$query       = "SELECT * FROM wp_ss_event_user_detail WHERE euser_email = '{$euser_email}'";
$user_detail = $wpdb->get_row($query, ARRAY_A);

// ======== Start Payment Conditional Block ======== //

// mid conf
if (isset($user_detail['euser_addon_mid'])) {

    if ($user_detail['euser_addon_mid'] == "gunung-kidul") {
        $string_mid_conf = "Gunung Kidul";
        $price_mid_conf  = 0;
        $product_mc      = "MC1";
    } elseif ($user_detail['euser_addon_mid'] == "klaten") {
        $string_mid_conf = "Klaten";
        $price_mid_conf  = 0;
        $product_mc      = "MC2";
    } elseif ($user_detail['euser_addon_mid'] == "mount-merapi") {
        $string_mid_conf = "Mount Merapi";
        $price_mid_conf  = 0;
        $product_mc      = "MC3";
    } else {
        $string_mid_conf = " - ";
        $price_mid_conf  = 0;
        $product_mc      = "MC0";
    }

} else {
    $string_mid_conf = " - ";
    $price_mid_conf == 0;
    $product_mc = "MC0";
}

// post conf
if (isset($user_detail['euser_addon_post'])) {
    // Pricing Post Conference
    if ($user_detail['euser_addon_post'] == "pacitan") {
        $string_post_conf = "Pacitan ( US$ 250 )";
        $price_post_conf  = 250;
        $product_pc       = "PC1";
    } elseif ($user_detail['euser_addon_post'] == "pekanbaru_shared") {
        $string_post_conf = "Pekanbaru | Shared Room ( US$ 475 )";
        $price_post_conf  = 475;
        $product_pc       = "PC2";
    } elseif ($user_detail['euser_addon_post'] == "pekanbaru_single") {
        $string_post_conf = "Pekanbaru | Single Room ( US$ 510 )";
        $price_post_conf  = 510;
        $product_pc       = "PC3";
    } else {
        $string_post_conf = " - ";
        $price_post_conf  = 0;
        $product_pc       = "PC0";
    }
} else {
    $string_post_conf = " - ";
    $price_post_conf  = 0;
    $product_pc       = "PC0";
}

if (isset($user_detail['euser_addon_dinner'])) {
    if ($user_detail['euser_addon_dinner'] == "Yes") {
        $string_dinner = " Yes ";
        $product_d     = "D1";
    } elseif ($user_detail['euser_addon_dinner'] == "No") {
        $string_dinner = " No ";
        $product_d     = "D2";
    } else {
        $string_dinner = "-";
        $product_d     = "D0";
    }
}

// Payment Dates Earlybird
$paymentDate    = date('Y-m-d');
$paymentDate    = date('Y-m-d', strtotime($paymentDate));
$earlyBirdBegin = date('Y-m-d', strtotime($ss_theme_opt['date_earlybird_start']));
$earlyBirdEnd   = date('Y-m-d', strtotime($ss_theme_opt['date_earlybird_end']));

if ($user_detail['euser_type'] == "local student") {
    $user_string = "Local | Students";
    $total_price = $price_post_conf + 20;
    $user_price  = 20;
    $product_usr = "LS";
} elseif ($user_detail['euser_type'] == "local regular") {
    // Early Bird Conf
    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
        $user_string = "Local | Regular ( Early Bird Rates )";
        $total_price = $price_post_conf + 23;
        $user_price  = 23;
        $product_usr = "LR-EBR";
    } else {
        $user_string = "Local | Regular ( Regular Rates )";
        $total_price = $price_post_conf + 39;
        $user_price  = 39;
        $product_usr = "LR-RR";
    }
} elseif ($user_detail['euser_type'] == "foreigner") {

    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
        $user_string = "Foreign ( Early Bird Rates )";
        $total_price = $price_post_conf + 350;
        $user_price  = 350;
        $product_usr = "F-EBR";
    } else {
        $user_string = "Foreign ( Regular Rates )";
        $total_price = $price_post_conf + 400;
        $user_price  = 400;
        $product_usr = "F-RR";
    }

} else {
    $total_price = 0;
}

// Assemble Product Name

$product_name = $product_usr . $product_mc . $product_pc . $product_d . date('md');

// ======== End of Payment Conditional Block ======== //

?>

<div class="container">
<h3>Summaries</h3>
<div class="payment-info">
<p>Here you can see the details of your transaction activity.</p>
<hr>
<div class="row">

<?php if ($user_detail['euser_meta_type'] != "participant_type") {
    ?>
<div class="col-md-12">
<h5>Your Documents</h5>
<div class="row">
<?php
//Abstract URL
    $abstract_download = wp_get_attachment_url($user_detail['euser_abstrak']);
    $paper_download    = wp_get_attachment_url($user_detail['euser_paper']);
    $poster_download   = wp_get_attachment_url($user_detail['euser_poster']);
    if (!empty($abstract_download)) {
        ?>
<div class="col-md-9">
<?php echo 'Abstract Title: &nbsp;'.$user_detail['euser_abstract_title']; ?>
</div>
<div class="col-md-3">
<a class="btn btn-view" href="<?php echo $abstract_download; ?>" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;">View</a>

</div>
<?php
}
    if (!empty($paper_download)) {
        ?>

<div class="col-md-9">
<?php echo 'Full Paper'; ?>
</div>

<div class="col-md-3">
<a class="btn btn-view" href="<?php echo $paper_download; ?>" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;">View</a>

</div>

<?php
}
    if (!empty($poster_download)) {
        //var_dump($poster_download);
        ?>
<div class="col-md-9">
<?php echo 'Poster'; ?>
</div>

<div class="col-md-3">
<a class="btn btn-view" href="<?php echo $poster_download; ?>" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;">View</a>
</div>
<?php
}
    ?>

</div>
<?php }?>
</div>
<div class="col-md-12">
<hr>
<br>
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
        <td>
<?php
if ($string_mid_conf == 0){
    echo "-";
}else{
 echo 'Free';
} 
?>
        </td>
      </tr>
      <tr>
        <td>3</td>
        <td>
<dl class="dl-horizontal">
  <dt>Post Conference Trip</dt>
  <dd><?php echo $string_post_conf; ?> </dd>
</dl>

        </td>
        <td>
<?php
if ($price_post_conf == 0){
    echo "-";
}else{
 echo 'US$ '.$price_post_conf;
} 
?>
</td>
      </tr>
      <tr>
        <td>4</td>
        <td>
<dl class="dl-horizontal">
  <dt>Conference Dinner</dt>
  <dd><?php
if ($string_dinner!=='Yes'){
    echo "-";
}else{
 echo 'Yes';
} 
?></dd>
</dl>
        </td>
        <td> <?php
if ($string_dinner!=='Yes'){
    echo "-";
}else{
 echo 'Free';
} 
?></td>
      </tr>
    </tbody>
    <tfoot>
    <tr class="success">
      <td colspan="2" > Net Total </td>
      <td>US$ <?php echo $total_price; ?> | IDR <?php
$idr_total = $idr_good * $total_price;
echo number_format($idr_total, 0, ".", ".");

echo "&nbsp;*<br><hr><p>";
echo "*Current IDR Rates US$1 = IDR " . $idr_good . "<br> Source : <a href='http://openexchangerates.org' onclick='window.open(this.href); return false;' onkeypress='window.open(this.href); return false;'>www.openexchangerates.org</a> </p>";
?></td>
    </tr>
  </tfoot>
  </table>
<?php if ($user_detail['euser_meta_type'] == "author_type" && $user_detail['euser_doc_status'] !== null || $user_detail['euser_meta_type'] == "participant_type" || $user_detail['euser_meta_type'] == "author_type" && $user_detail['euser_doc_status'] == 'accepted') {} else {?>
  <div class="well payment-alert">
  You may continue to the payment after your abstract has been approved by us!
</div>
<?php }?>
</div>
<hr>

</div><!-- row -->

</div>

<form action="<?php echo get_permalink() . "?step=paynow"; ?>" method="post">
<input type="hidden" name="total_idr_amount" value="<?php echo $idr_total; ?>">
<input type="hidden" name="total_amount" value="<?php echo $total_price; ?>">
<input type="hidden" name="ebarcode" value="<?php echo $user_detail['euser_barcode']; ?>">
<input type="hidden" name="payname" value="IAC17-<?php echo $product_name ?>">
<div>
    <a href="<?php echo get_permalink() . "?step=addon"; ?>" class="btn btn-default pull-left">Back</a>
<?php if ($user_detail['euser_meta_type'] == "author_type" && $user_detail['euser_doc_status'] !== null || $user_detail['euser_meta_type'] == "participant_type" || $user_detail['euser_meta_type'] == "author_type" && $user_detail['euser_doc_status'] == 'accepted') {
$today  = strtotime(date('Y-m-d'));
$closed = strtotime($ss_theme_opt['date_close']);
// Check if Payment Done or Onsite
 if ( $user_detail['euser_payment_status'] !== 'onsite-payment' || $user_detail['euser_payment_status'] !== 'berhasil-iPaymu' || $user_detail['euser_payment_status'] !== 'Completed-Paypal' ||  $closed > $today ) { ?>

    <button type="submit" name="submit" class="btn btn-default pull-right" value="payment">Pay Now</button>
    <a href="<?php echo get_permalink(); ?>?step=pay_later" class="btn btn-default pull-right">Pay Later</a>
<?php } } ?>
</div>
</form>
</div>
<script type="text/javascript">

</script>