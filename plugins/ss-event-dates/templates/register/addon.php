<?php
if(isset($_GET['step']) && $_GET['step']=="addon"){
	$post_url=get_permalink()."?step=payment";
}else{
	$post_url="";
}

?>

<link href="<?php echo plugins_url(); ?>/ss-event-dates/assets/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="<?php echo plugins_url(); ?>/ss-event-dates/assets/js/bootstrap-toggle.min.js"></script>
<form id="form-addon" enctype="multipart/form-data" action="<?php echo $post_url; ?>" method="post">
<div class="container">
	<h3>Add On Facilities</h3>
	<div class="field-trip">
		<h4>Field Trip</h4>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-8"> Mid Conference Trip </div>
				<div class="col-md-4"><input class="switch-btn" data-on="Yes" data-off="No" type="checkbox" name="mid-conf" checked data-toggle="toggle"></div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<input type="radio" name="mid-conf-trip" value="gunung-kidul" checked>
				 	<div class = "thumbnail">
			         	<img src = "<?php echo site_url(); ?>/wp-content/uploads/2016/07/Gunungkidul.jpg" alt = "Gunungkidul">
			     	</div>
			      	Gunungkidul<br>
			    	<a href="<?php echo site_url(); ?>/field-trip/pacitan/" target="_blank">Learn more.</a> 
			    </div>
				<div class="col-md-6">
					<input type="radio" name="mid-conf-trip" value="klaten">
					<div class = "thumbnail">
			         	<img src = "<?php echo site_url(); ?>/wp-content/uploads/2016/07/Klaten.jpg" alt = "Klaten">
			     	</div>
			    	Klaten<br>
			    	<a href="<?php echo site_url(); ?>/field-trip/pacitan/" target="_blank">Learn more.</a> 
			    </div>
			</div>
		</div> 
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-8"> Post Conference Trip </div>
				<div class="col-md-4"><input class="switch-btn" data-on="Yes" data-off="No" type="checkbox" name="post-conf" checked data-toggle="toggle"></div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<input type="radio" name="post-conf" value="" id="radio-custom-toggle">
					<div class = "thumbnail">
			         	<img src = "<?php echo site_url(); ?>/wp-content/uploads/2016/07/Pekanbaru.jpg" alt = "Pekanbaru">
			     	</div>
			      	Pekanbaru
			    </div>
				<div class="col-md-6">
					<input type="radio" name="post-conf-trip" value="250">
					<div class = "thumbnail">
			         	<img src = "<?php echo site_url(); ?>/wp-content/uploads/2016/07/Pacitan.jpg" alt = "Pacitan">
			     	</div>
			    	Pacitan 
			    	<p class="item-price-x">USD. 250/pax<br>
			    	<a href="<?php echo site_url(); ?>/field-trip/pacitan/" target="_blank">Learn more.</a>
			    	</p>
			    </div>
			    <div class="col-md-12 pekanbaru-selected">
<div class="custom-toggle" id="custom-toggle">
<div class="well">
    <input type="radio" name="post-conf-trip" id="single-room" value="510">
    Single room = USD. 510/pax<br>
    <input type="radio" name="post-conf-trip" id="shared-room" value="475">
    Shared room = USD. 475/pax
</div>
</div>
			    </div>
			</div>
		</div>
	</div>
	<?php if ($user_detail['euser_type']!="foreigner") {?>
	<div class="field-trip">
		<div class="col-md-8"> <span>Dinner Conference<span> </div>
		<div class="col-md-4"><input class="switch-btn" data-on="Yes" data-off="No" type="checkbox" name="dinner-conf" checked data-toggle="toggle"></div>
	</div>
	<?php } ?>
<br>
<div class="well">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#paper" aria-controls="paper" role="tab" data-toggle="tab">Guidelines for Poster presentation</a></li>
    <li role="presentation"><a href="#abstract" aria-controls="abstract" role="tab" data-toggle="tab">
    	Guidelines for Abstract submission
    </a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="paper">
    <div class="paper-body">
    	Poster presentations are an excellent mechanism to facilitate the rapid communication of scientific ideas. Poster presentations should visually guide viewers through the basics of the study displayed on the poster board while the presenter focuses on explanation and clarification of the key elements of the work and answers viewer questions. The poster presentation format is less formal and more interactive than an oral presentation.Though posters must be displayed for the entire day, poster presenters are only required to be present at their poster board during the assigned time of their poster presentation.

During the sessions, presenters are expected to stand by their poster/exhibition in order to discuss their research/design project with the viewers. The poster presentations will be on continuous display throughout the conference

<strong>Poster Session and Schedule</strong>
Poster sessions will take place at various times throughout each day. All poster sessions will take place at the main hall. Posters are displayed for the entire day, although presenters are only required to be present at their board during their assigned presentation time.

Poster size: The poster should not exceed A0 format (841mm wide x 1189 mm deep or  33.11 inches wide x 46.81 inches deep) in portrait (vertical) layout only

<strong>Authors are encouraged to:</strong>
Include a photo of themselves on the poster so that they can be easily identified by the poster viewers.
Print several copies of their posters in A4 format and hang these up in an envelope on their designated poster board. This will make communication and future collaborations easier and more visible.

    </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="abstract">
    	
<div class="paper-body">Please set up your abstracts according to the given format at this website. You are also expected to send a brief biography together with the Abstract. If you have any technical issue or you need any further assistance in submitting your abstract, please contact: <a href="mailto:secretariat@iufroacacia2017.com">secretariat@iufroacacia2017.com</a></div>
<div class="paper-body"><strong>Author</strong></div>
<div class="paper-body"><strong>Abstract</strong></div>
<div class="paper-body">(Introduction) Recent research suggests that chemicals sent from roots in the transpiration stream could control leaf expansion, and that xylem sap from plants in dry and saline soil contain increased amounts of growth inhibitor, or decreased amounts of growth promoter. (Method) In order to test these possibilities, a bioassay that could detect the presence of growth regulators in xylem sap was developed using whole shoots of wheat and barley seedlings. (Result) The bioassay showed that xylem sap collected from intact, transpiring plants in a drying soil contained a strong growth inhibitor. (Result/Discussion) The inhibitory substance was not abscisic acid: while the concentration of abscisic acid in the sap rose as the soil dried, the highest concentration found, 4 × 10-8 M, was too low to inhibit leaf expansion. The identity of the new inhibitor is unknown.</div>
<div class="paper-body"><strong>Presenting author details</strong></div>
<div class="paper-body">Full name:</div>
<div class="paper-body">Affiliation/country:</div>
<div class="paper-body">Position/research interest:</div>
<div class="paper-body">Email:</div>
<div class="paper-body">Category: (Oral presentation/ Poster presentation)</div>
<div class="paper-body">

<strong>Don’t forget to specify:</strong>
<ul>
 	<li>The session you are submitting your abstract for. Also state your preference for oral or poster presentation.</li>
 	<li>Your "Registration Summary Reference", which you will find in the e-mail sent to you to following the registration procedure (pdf format).</li>
</ul>
Note: Each registered attendee may submit and present one abstract only.

<em>If your abstract is selected for a talk, registration and payment procedure should be completed for final validation (Acacia2017 registration) (IUFRO 2016 registration)</em>

<strong>Abstract recommendations</strong>
<ul>
 	<li>The abstract must be in English,</li>
 	<li>40 words maximum for title and 400 words maximum for main text.</li>
 	<li>For each author, last name, first and second name and affiliations are required.</li>
 	<li>The presenting author e-mail address is required.</li>
 	<li>Please use the format below to enter information about authors :
Author1 Aa, Author2 Bb* and Author3 Ca,b (presenting author with a star) aAffiliation for Author 1; b Affiliation for Author 2</li>
</ul>
<strong>Talk recommendations</strong>
<ul>
 	<li>The submitting author will receive all correspondence concerning the abstract. The submitting author is responsible for informing the other authors of the status of the abstract(s).</li>
 	<li>All oral presentations will be allocated a strict 15 minute presentation slot, including questions</li>
 	<li>All accepted abstracts will be published in the Conference Handbook, a copy of which (electronic format) will be available to all delegates attending the Conference.</li>
 	<li>Should you wish to use your own laptop or if your presentation requires any special equipment, please advise the Conference Manager</li>
 	<li>An audio visual technician will be available in each presentation room (both before and during each presentation) to assist with any questions</li>
</ul>
</div>

<!-- tabpanel -->
    </div>
  </div>
<!-- end-well -->
<hr>
<input id="okeread" type="checkbox" name="readme_ok" value="readme">&nbsp;I have read all the guidelines, and ready to upload
</div>




	<div class="field-trip col-md-4">
		<label> <span>Upload Abstract</span> <input id="mydoc1" name="abstrak" type="file" /></label>
	</div>
	<div class="field-trip col-md-4">
		<label>  <span>Upload Paper</span> <input id="mydoc2" name="paper" type="file" /></label>
	</div>
	<div class="field-trip col-md-4">
		<label> <span>Upload Poster</span> <input id="mydoc3" name="poster" type="file" /></label>
	</div>
	<div>
		<a href="<?php echo get_permalink(); ?>?step=membership" class="btn btn-default pull-left">Back</a>
	  	<button id="btnval" type="submit" name="submit" class="btn btn-default pull-right" value="addon" disabled>Next</button>
	</div>
</div>
</form>

<script type="text/javascript">
//validate all form upload
	jQuery('#form-addon').on('change', function() {
	   if(jQuery('input[name=readme_ok]:checked', '#form-addon').val()=="readme"){
	   		jQuery( "#btnval" ).removeAttr("disabled");
	   } else {
	   	jQuery( "#btnval" ).attr("disabled", "disabled");
	   }
	});

	jQuery("#form-addon").submit(function(e){
	   		if (jQuery('#mydoc1').val()==''){
				alert('please upload your Abstract');
				e.preventDefault(e);
			}
	   		if (jQuery('#mydoc2').val()==''){
				alert('please upload your Paper');
				e.preventDefault(e);
			}
			    
	});
</script>