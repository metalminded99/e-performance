<?php
	$curr_date = date('m-d-Y');
	$from_date = strtotime($curr_date.' -60 year');
	$to_date = strtotime($curr_date.' -18 year');
	$from_date = date('Y', $from_date);
	$to_date = date('Y', $to_date);
?>
<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
	$( document ).ready( function(){
		$( "#frm_new_user_detais" ).validationEngine();

		$( '#birthday' ).datepicker(
										{ 
											dateFormat: 'yy-mm-dd'
											,changeMonth: true
											,changeYear: true 
											,yearRange: "<?=$from_date?>:<?=$to_date?>" 
										}
									);

		$( 'select[name=dept]' ).change( function() {
			$.ajax({
				    type: "POST"
				    ,url: "<?=base_url();?>control_panel/manage_user/get_job"
				    ,dataType: 'json'
				    ,data: { 'dept' : $(this).val() },
				    success: function( data ) {
				    	$( 'select[name=job]' ).html( '<option value="">-- Select Job</option>' );
				    	var job; 
				        for (var i = data.length - 1; i >= 0; i--) {
				        	job = data[i]['job_id'] == '<?=isset($user_detais->job_id) ? $user_detais->job_id : '' ?>' ? 'selected="selected"' : '';
				        	$( 'select[name=job]' ).append( '<option value='+ data[i]['job_id'] + ' ' + job + '>' + data[i]['job_title'] + '</option>' );
						};
				    }
			});
		});

		$('.cancel').bind('click', function(e) {
			var ans = confirm( 'Are you sure you want to quit?' );
			
			if( ans ){
				window.location = "<?=base_url()?>control_panel/manage_user";
			}

			return false;
	   	});
	});
</script>
<div class="full_w">	
	<div class="h_title">User Form</div>
	<form id="frm_new_user_detais" action="" method="post" enctype="multipart/form-data">
		<?php 
			if ( isset( $user_detais->user_id ) ) {
				$no_image = base_url().IMG.'no-image.png';
				if( !empty( $user_detais->avatar ) )
					$img_url = $this->template_library->check_image_exist( base_url().UPLOADS.$user_detais->avatar, $no_image );
				else
					$img_url = $no_image;
		?>
		<div id="user_avatar" style="float:right;">
			<img src="<?=$img_url?>" width="120px" height="110px">
		</div>
		<?php
				echo form_hidden( 'user_id', $user_detais->user_id );
			}
		?>
		<div class="element">
			<label for="fname">First name <span class="red">(required)</span></label>
			<input id="fname" name="fname" class="text validate[required, custom[onlyLetterSp]]" value="<?=isset( $user_detais->fname ) ? $user_detais->fname : '' ?>"/>
		</div>
		<div class="element">
			<label for="mname">Middle name <span class="red">(required)</span></label>
			<input id="mname" name="mname" class="text validate[required, custom[onlyLetterSp]]"  value="<?=isset( $user_detais->mname ) ? $user_detais->mname : '' ?>"/>
		</div>
		<div class="element">
			<label for="lname">Last name <span class="red">(required)</span></label>
			<input id="lname" name="lname" class="text validate[required, custom[onlyLetterSp]]"  value="<?=isset( $user_detais->lname ) ? $user_detais->lname : '' ?>"/>
		</div>
		<div class="element">
			<label for="uname">Username <span class="red">(required)</span></label>
			<input id="uname" name="uname" class="text validate[required, custom[onlyLetterNumber]]" autocomplete="off" value="<?=isset( $user_detais->uname ) ? $user_detais->uname : '' ?>"/>
		</div>
		<div class="element">
			<label for="pword">Password <span class="red">(required)</span></label>
			<input type="password" id="pword" name="pword" <?php if( $this->uri->segment( 3 ) != 'update_user' ) { ?>class="text validate[required]" <? } ?> autocomplete="off"/>
		</div>

		<div class="element">
			<label for="lvl">User Access Level <span class="red">(required)</span></label>
			<select name="lvl" id="lvl" class=" validate[required]">
				<?php if( !isset( $user_detais->lvl ) ){ ?> <option value="">-- Select Level</option> <? } ?>
				<option value="2" <?=isset( $user_detais->lvl ) && $user_detais->lvl == '2' ? 'selected="selected"' : ''?> >Manager</option>
				<option value="3" <?=isset( $user_detais->lvl ) && $user_detais->lvl == '3' ? 'selected="selected"' : ''?> >Employee</option>
			</select>
		</div>
		<div class="element">
			<label for="dept">Department <span class="red">(required)</span></label>
			<select name="dept" id="dept" class="validate[required]">
				<?php if( !isset( $user_detais->department_id ) ){ ?> <option value="">-- Select Department</option> <? } ?>
				<?php foreach ($departments as $dept): ?>
				<option value="<?=$dept['dept_id']?>" <?=isset( $user_detais->department_id ) && $user_detais->department_id == $dept['dept_id'] ? 'selected="selected"' : ''?> ><?=$dept['dept_name']?></option>
				<?php endforeach; ?>
			</select>
			<?php if( isset( $user_detais->department_id ) ){ ?> 
			<script type="text/javascript">
				$(document).ready( function(){
					$('#dept').trigger('change');
				});
			</script>
			<?php } ?>
		</div>
		<div class="element">
			<label for="job">Job Title <span class="red">(required)</span></label>
			<select name="job" id="job" class="validate[required]">
				<option value="">-- Select Job</option>
			</select>
		</div>
		<div class="element">
			<label for="gender">Gender <span class="red">(required)</span></label>
			<select name="gender" id="gender" class=" validate[required]">
				<?php if( !isset( $user_detais->gender ) ){ ?> <option value="">-- Select Gender</option> <? } ?>
				<option value="Male" <?=isset( $user_detais->gender ) && $user_detais->gender == 'Male' ? 'selected="selected"' : ''?>>Male</option>
				<option value="Female" <?=isset( $user_detais->gender ) && $user_detais->gender == 'Female' ? 'selected="selected"' : ''?>>Female</option>
			</select>
		</div>
		<div class="element">
			<label for="birthday">Birth date <span class="red">(required)</span></label>
			<input id="birthday" name="birthday" class="validate[required] datepicker" value="<?=isset( $user_detais->birthday ) ? $user_detais->birthday : '' ?>"/>
		</div>
		<div class="element">
			<label for="address">Home Address <span class="red">(required)</span></label>
			<textarea name="address" class="textarea validate[required]" rows="10"> <?=isset( $user_detais->home_address ) ? $user_detais->home_address : '' ?> </textarea>
		</div>
		<div class="element">
			<label for="email">E-mail Address <span class="red">(required)</span></label>
			<input id="email" name="email" class="text validate[required, custom[email]]" value="<?=isset( $user_detais->email ) ? $user_detais->email : '' ?>"/>
		</div>
		<div class="element">
			<label for="mobile_phone">Mobile Phone <span class="red">(required)</span></label>
			<input id="mobile_phone" name="mobile_phone" class="validate[required, custom[number]]" value="<?=isset( $user_detais->mobile_phone ) ? $user_detais->mobile_phone : ''?>"/>
		</div>
		<div class="element">
			<label for="home_phone">Home Phone</label>
			<input id="home_phone" name="home_phone" class=" validate[required, custom[number]]" value="<?=isset( $user_detais->home_phone ) ? $user_detais->home_phone : '' ?>"/>
		</div>
		<div class="element">
			<label for="emergency_contact">Emergency Contact <span class="red">(required)</span></label>
			<input id="emergency_contact" name="emergency_contact" class="text validate[required, custom[onlyLetterSp]]" value="<?=isset( $user_detais->emergency_contact ) ? $user_detais->emergency_contact : '' ?>" />
		</div>
		<div class="element">
			<label for="emergency_phone">Emergency Phone <span class="red">(required)</span></label>
			<input id="emergency_phone" name="emergency_phone" class=" validate[required, custom[number]]" value="<?=isset( $user_detais->emergency_phone ) ? $user_detais->emergency_phone : '' ?>" />
		</div>
		<div class="element">
			<label for="tin_id">T.I.N #</label>
			<input id="tin_id" name="tin_id" class=" validate[custom[number]]" value="<?=isset( $user_detais->tin_id ) ? $user_detais->tin_id : '' ?>" />
		</div>
		<div class="element">
			<label for="sss_id">S.S.S. ID.</label>
			<input id="sss_id" name="sss_id" class=" validate[custom[number]]" value="<?=isset( $user_detais->sss_id ) ? $user_detais->sss_id : '' ?>" />
		</div>
		<div class="element">
			<label for="philhealth_id">PhilHealth ID.</label>
			<input id="philhealth_id" name="philhealth_id" class=" validate[custom[number]]" value="<?=isset( $user_detais->philhealth_id ) ? $user_detais->philhealth_id : '' ?>" />
		</div>
		<div class="element">
			<label for="pagibig_id">PAGIBIG ID.</label>
			<input id="pagibig_id" name="pagibig_id" class=" validate[custom[number]]" value="<?=isset( $user_detais->pagibig_id ) ? $user_detais->pagibig_id : '' ?>" />
		</div>
		<div class="element">
			<label for="avatar">Photo</label>
			<input type="file" name="avatar" id="avatar" />
		</div>
		<div class="entry">
			<button type="submit" class="add">Save</button> 
			<button type="button" class="cancel">Cancel</button>
		</div>
	</form>
</div>
