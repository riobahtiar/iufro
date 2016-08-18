<?php 
/*
* Form registration in frontend
*/
?>
<link rel="stylesheet" href="<?php echo get_site_url() .'/wp-content/plugins/ss-event-dates/addons/intl-tel/build/css/intlTelInput.css'; ?>">


<div class="container">
	<div class="col-md-12">
		<h2>Your Identity</h2>
	</div>
	<form id="registration" action="" method="post">
		  	<div class="form-group">
	    	<label for="user_type">Register as (<a data-toggle="modal" data-target="#registerInfo">Learn more.</a>)</label>
	    	<select class="form-control" name="user_type" id="user_type">
	    		<option value="">== Select Account ==</option>
  				<option value="free_type">Free Account</option>
  				<option value="author_type">Author</option>
  				<option value="participant_type">Participant</option>
			</select>
			<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="registerInfo" tabindex="-1" role="dialog" aria-labelledby="registerInfoLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <h2>Account types :</h2>
<h3>Free Account</h3>
<p>Free account will not participate on the conference. Free account user able to login into website and read papers that created by our author, but will not able to download it.
Free account user can upgrade his membership type (into author or participant) later.</p>
<h3>Author :</h3>
<p>Will participate on the conference as the author. There's registration fee for Author.
To be an author, user need to submit document (abstract, paper, and poster) on the form after finishing registration phase.
Author also able to join extra field trip during the conference (extra charge will be applied).</p>
<h3>Participant :</h3>
<p>Will participate on the conference as the participant. There's registration fee for Participant.  No need to upload any file.
Paticipant also able to join extra field trip during the conference (extra charge will be applied).</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
	  	</div>
	  	<br>
		<div class="row">
		  	<div class="form-group col-md-6">
		    	<label for="salutation">Salutation</label>
		    	<select id="salutation" name="salutation" class="form-control">
		    		<option value="Mr." <?php isset( $_POST['salutation'] ) ? 'checked' : null?> >Mr.</option>
		    		<option value="Mrs." <?php isset( $_POST['salutation'] ) ? 'checked' : null?> >Mrs.</option>
		    	</select>
		  	</div>
		  	<div class="form-group form-group col-md-6">
		    	<label for="title">Title</label>
		    	<input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php if(isset( $_POST['title'] ))  echo $_POST['title']; else echo null; ?>">
		  	</div>
	  	</div>
	  	<div class="form-group">
	    	<label for="fullname">Full Name</label>
	    	<input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value="<?php if(isset( $_POST['fullname'] ))  echo $_POST['fullname']; else echo null;?>">
	  	</div>
	  	<div class="row">
		  	<div class="form-group col-md-6">
		    	<label for="email">Email</label>
		    	<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php if(isset( $_POST['email'] ))  echo $_POST['email']; else echo null; ?>">
		  	</div>

		  	<div class="form-group form-group col-md-6">
		    	<label for="phone">Phone number</label>
		    	<input type="text" class="form-control" name="phone" id="phone">
		  	</div>
	  	</div>
	  	<div class="row">
		  	<div class="form-group col-md-6">
		    	<label for="password">Password</label>
		    	<input type="password" class="form-control" name="password" id="password" placeholder="Password">
		  	</div>
		  	<div class="form-group form-group col-md-6">
		    	<label for="c_password">Confirm Password</label>
		    	<input type="password" class="form-control" name="c_password" id="c_password" placeholder="Confirm Password">
		  	</div>
	  	</div>
	  	<div class="form-group">
	    	<label for="address">Address</label>
	    	<textarea class="form-control" name="address" id="address" placeholder="Address"><?php if(isset( $_POST['address'] ))  echo $_POST['address']; else echo null; ?></textarea>
	  	</div>
	  	<div class="row">
		  	<div class="form-group col-md-6">
		    	<label for="zip">Zip Code</label>
		    	<input type="text" class="form-control" name="zip" id="zip" placeholder="Zip Code" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php if(isset( $_POST['zip'] ))  echo $_POST['zip']; else echo null; ?>">
		  	</div>
		  	<div class="form-group form-group col-md-6">
		    	<label for="city">City</label>
		    	<input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php if(isset( $_POST['city'] ))  echo $_POST['city']; else echo null; ?>">
		  	</div>
	  	</div>
	  	<div class="row">
		  	<div class="form-group col-md-6">
		    	<label for="state">Country</label>
		    	<select name="country" class="form-control countries" id="countryId">
<option>Select Country</option>
				</select>
		  	</div>
		  	<div class="form-group form-group col-md-6">
		    	<label for="country">State/Province</label>
		    	<select name="state" class="form-control states" id="stateId">
<option>Select State</option>
			</select>
		  	</div>
	  	</div>
	  	<hr>
	  	<div>
	  		<button type="submit" name="submit" class="btn btn-default pull-right" value="Register">Register</button>
		</div>
	</form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.min.js"></script>
<script src="http://lab.iamrohit.in/js/location.js"></script>
<script src="<?php echo get_site_url() .'/wp-content/plugins/ss-event-dates/addons/intl-tel/build/js/intlTelInput.min.js'; ?>"></script>

  <script>
    $("#phone").intlTelInput({
       allowDropdown: true,
       //autoHideDialCode: true,
      // autoPlaceholder: false,
      // dropdownContainer: "body",
      // excludeCountries: ["us"],
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      // initialCountry: "auto",
       nationalMode: false,
      // numberType: "MOBILE",
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
       preferredCountries: ['id'],
      // separateDialCode: true,
      utilsScript: "<?php echo get_site_url() .'/wp-content/plugins/ss-event-dates/addons/intl-tel/build/js/utils.js'; ?>"
    });
// Jquery Validation
jQuery( "#registration" ).validate();




  </script>