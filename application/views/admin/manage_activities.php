<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
	$( document ).ready( function(){
		$( "#frm_skill" ).validationEngine();

		$('.cancel').bind('click', function(e) {
			var ans = confirm( 'Are you sure you want to quit?' );
			
			if( ans ){
				window.location = "<?=base_url()?>control_panel/manage_activities";
			}

			return false;
	   	});
	});

</script>
<div class="full_w">
	<div class="h_title">Activitys Form</div>
	<form id="frm_skill" action="" method="post">
		<?=isset( $activities['activity_id'] ) ? form_hidden( 'activity_id', $activities['activity_id'] ) : ''?>

		<div class="element">
			<label for="activity_code">Activity code <span class="red">(required)</span></label>
			<input id="activity_code" name="activity_code" class="text validate[required]" maxlength="5" value="<?=isset( $activities['activity_code'] ) ? $activities['activity_code'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="activity_name">Activity name <span class="red">(required)</span></label>
			<input id="activity_name" name="activity_name" class="text validate[required]" value="<?=isset( $activities['activity_name'] ) ? $activities['activity_name'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="activity_desc">Activity description <span class="red">(required)</span></label>
			<input id="activity_desc" name="activity_desc" class="text validate[required]" value="<?=isset( $activities['activity_desc'] ) ? $activities['activity_desc'] : '' ?>"/>
		</div>
		<div class="entry">
			<button type="submit" class="add">Save</button> 
			<button type="button" class="cancel">Cancel</button>
		</div>
	</form>
</div>
