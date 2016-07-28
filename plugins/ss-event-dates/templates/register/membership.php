<?php
if(isset($_GET['step']) && $_GET['step']=="membership"){
	$post_url=get_permalink()."?step=addon";
}else{
	$post_url="";
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
						 	<label><input type="radio" name="account" value="local"> <i class="fa fa-user" aria-hidden="true"></i> Local</label> <span class="pull-right">Detail <i class="fa fa-question-circle" aria-hidden="true"></i></span>
						</h2>
					</div>
					<div id="local" class="panel-collapse collapse">
						<div class="panel-body">
Registration fee for local :<br>
- Early bird registration (1st January - 30th April 2017) : USD 23<br>
- Regular registration (1st May - 24th July 2017) : USD 39<br>
- Student : USD 20<br><br>

Also has the ability to choose the available field trip that we provide (there will be extra charge for each field trip).<br><br>

The payable fee covers registration for the Conference, welcome reception, banquet conference dinner, conference bag and souvenir, mid-conference tour, and tea/coffee and lunch.<br><br>

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
							<label><input type="radio" name="account" value="foreign"> <i class="fa fa-user" aria-hidden="true"></i> Foreinger </label> <span class="pull-right">Detail <i class="fa fa-question-circle" aria-hidden="true"></i></span>
						</h2>
					</div>
					<div id="foreign" class="panel-collapse collapse in">
						<div class="panel-body">
Registration fee for foreigner :<br>
- Early bird registration (1st January - 30th April 2017) : USD 350<br>
- Regular registration (1st May - 24th July 2017) : USD 400<br><br>

Also has the ability to choose the available field trip that we provide (there will be extra charge for each field trip).<br><br>

The payable fee covers registration for the Conference, welcome reception, banquet conference dinner, conference bag and souvenir, mid-conference tour, and tea/coffee and lunch.<br>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
	  	<div>
	  		<?php /*<button type="submit" class="btn btn-default pull-left">Previous</button>*/ ?>
	  		<button type="submit" name="submit" value="membership" class="btn btn-default pull-right">Next</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	// jQuery('#form-membership').on('change', function() {
	//    if(jQuery('input[name=local]:checked', '#form-membership').val()=="regular"){
	//    		jQuery( "#std-card" ).addClass( "hidden" );
	//    }
	//    if(jQuery('input[name=local]:checked', '#form-membership').val()=="student"){
	//    		jQuery( "#std-card" ).removeClass( "hidden" );
	//    }  
	// });

	// jQuery("#form-membership").submit(function(e){
	// 	// alert('please upload your student card');
	// 	if(jQuery('input[name=local]:checked', '#form-membership').val()=="student"){
	//    		if (jQuery('#input-card').val()==''){
	// 			alert('please upload your student card');
	// 			e.preventDefault(e);
	// 		}	
	//    	}  	
 //    });
	jQuery('#form-membership button').click(function() {
	   if(jQuery('input[name=account]:checked').val()=="local"){
	   		// Run Second code
			   if(jQuery('input[name=local]:checked').val()=="regular"){
			   		jQuery( "#std-card" ).addClass( "hidden" );
			   }

			   if(jQuery('input[name=local]:checked').val()=="student"){
			   		jQuery( "#std-card" ).removeClass( "hidden" );

			   		if (jQuery('#input-card').val() !==''){
						jQuery("#form-membership").submit();
			   		} else {
			   			alert("student card is empty")
			   		}
			   }  

	   } else {
	   		jQuery( "#std-card" ).removeClass( "hidden" );
	   		jQuery('input[name=local]').prop('checked', false);
	   }  
	   return false;
	});








// var makeRadiosDeselectableByName = function(name){
//     $('input[name=' + name + ']').click(function() {
//         if($(this).attr('previousValue') == 'true'){
//             $(this).attr('checked', false)
//         } else {
//             $('input[name=' + name + ']').attr('previousValue', false);
//         }

//         $(this).attr('previousValue', $(this).attr('checked'));
//     });
// };




</script>

