<?php
if (isset($_GET['step']) && $_GET['step'] == "membership") {
    $post_url = get_permalink() . "?step=addon";
} else {
    $post_url = "";
}

?>
<div class="col-md-12">
	<h3>Type of Membership</h3>
</div>
<br>
<br>
<div class="container">
	<form action="<?php echo $post_url; ?>" enctype="multipart/form-data" method="POST" id="form-membership">
		<div class="priority-lists">
			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#local">
					 	<h2 class="panel-title accordion-toggle">
						 	<label><input type="radio" name="account" value="local" checked> <i class="fa fa-user" aria-hidden="true"></i> Local</label> <span class="pull-right">Detail <i class="fa fa-question-circle" aria-hidden="true"></i></span>
						</h2>
					</div>
					<div id="local" class="panel-collapse collapse in">
						<div class="panel-body">
Registration fee for local :<br>
- Early bird registration (From Now - 30th April 2017) : US$ 23<br>
- Regular registration (1st May 2017 - 24th July 2017) : US$ 39<br>
- Student : US$ 20<br><br>

The payable fee covers registration for the Conference, welcome reception, conference bag, mid-conference tour, and tea/coffee and lunch.<br><br>

Please choose your local type:<br>
							<label><input type="radio" name="local" value="regular" checked>Regular</label>
							<label><input type="radio" name="local" value="student">Student</label>
							<label id="std-card" class="hidden"> Please upload your student card<input id="input-card" type="file" name="student_card"></label>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#foreign">
					 	<h2 class="panel-title accordion-toggle">
							<label><input type="radio" name="account" value="foreign"> <i class="fa fa-user" aria-hidden="true"></i> Foreigner </label> <span class="pull-right">Detail <i class="fa fa-question-circle" aria-hidden="true"></i></span>
						</h2>
					</div>
					<div id="foreign" class="panel-collapse collapse">
						<div class="panel-body">
Registration fee for foreigner :<br>
- Early bird registration (From Now - 30th April 2017) : US$ 350<br>
- Regular registration (1st May 2017 - 24th July 2017) : US$ 400<br><br>

The payable fee covers registration for the Conference, welcome reception, conference bag, mid-conference tour, and tea/coffee and lunch.<br>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
	  	<div>
	  		<?php /*<button type="submit" class="btn btn-default pull-left">Previous</button>*/?>
	  		<button type="submit" name="submit" value="membership" class="btn btn-default pull-right">Next</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	jQuery('#form-membership').on("change", function(){
		if(jQuery('input[name=account]:checked').val()=="local"){
	   		// Run Second code
			   if(jQuery('input[name=local]:checked').val()=="regular"){
			   		jQuery( "#std-card" ).addClass( "hidden" );
			   }

			   if(jQuery('input[name=local]:checked').val()=="student"){
			   		jQuery( "#std-card" ).removeClass( "hidden" );
			   }

	   } else {
	   		jQuery( "#std-card" ).removeClass( "hidden" );
	   		jQuery('input[name=local]').prop('checked', false);
	   }
	})

	jQuery('#form-membership button').click(function() {
	   if(jQuery('input[name=account]:checked').val()=="local"){
			   if(jQuery('input[name=local]:checked').val()=="student"){
			   		if (jQuery('#input-card').val() !==''){
						jQuery("#form-membership").submit();
			   		} else {
			   			alert("student card is empty");
			   			return false;
			   		}
			   }else if(jQuery('input[name=account]:checked').val()=="local" && jQuery('input[name=local]').prop('checked') == false){
	   				alert("Please choose one of Local Account type");
					return false;
	   			}else{

	   			}

	   }else if(jQuery('input[name=account]:checked').val()=="foreign"){

	   }else{
	   		alert("Please choose one of membership type");
			return false;
	   }


	});

</script>

