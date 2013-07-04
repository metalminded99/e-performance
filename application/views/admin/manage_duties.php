<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
	$( document ).ready( function(){
		$( "#frm_ability" ).validationEngine();

		$('.cancel').bind('click', function(e) {
			var ans = confirm( 'Are you sure you want to quit?' );
			
			if( ans ){
				window.location = "<?=base_url()?>control_panel/manage_duties";
			}

			return false;
	   	});
	});

</script>
<div class="full_w">
	<div class="h_title">Abilities Form</div>
	<form id="frm_ability" action="" method="post">
		<?=isset( $duties['duty_id'] ) ? form_hidden( 'duty_id', $duties['duty_id'] ) : ''?>

		<div class="element">
			<label for="duty_code">Duty code <span class="red">(required)</span></label>
			<input id="duty_code" name="duty_code" class="text validate[required]" maxlength="5" value="<?=isset( $duties['duty_code'] ) ? $duties['duty_code'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="duty_name">Duty name <span class="red">(required)</span></label>
			<input id="duty_name" name="duty_name" class="text validate[required]" value="<?=isset( $duties['duty_name'] ) ? $duties['duty_name'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="duty_desc">Duty description <span class="red">(required)</span></label>
			<input id="duty_desc" name="duty_desc" class="text validate[required]" value="<?=isset( $duties['duty_desc'] ) ? $duties['duty_desc'] : '' ?>"/>
		<div class="entry">
			<button type="submit" class="add">Save</button> 
			<button type="button" class="cancel">Cancel</button>
		</div>
	</form>
</div>
