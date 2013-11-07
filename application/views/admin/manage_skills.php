<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
	$( document ).ready( function(){
		$( "#frm_skill" ).validationEngine();

		$('.cancel').bind('click', function(e) {
			var ans = confirm( 'Are you sure you want to quit?' );
			
			if( ans ){
				window.location = "<?=base_url()?>control_panel/manage_skills";
			}

			return false;
	   	});
	});

</script>
<div class="full_w">
	<div class="h_title">Skills Form</div>
	<form id="frm_skill" action="" method="post">
		<?=isset( $skills['skill_id'] ) ? form_hidden( 'skill_id', $skills['skill_id'] ) : ''?>

		<div class="element">
			<label for="skill_code">Skill code <span class="red">(required)</span></label>
			<input id="skill_code" name="skill_code" class="text validate[required]" maxlength="5" value="<?=isset( $skills['skill_code'] ) ? $skills['skill_code'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="skill_name">Skill name <span class="red">(required)</span></label>
			<input id="skill_name" name="skill_name" class="text validate[required]" maxlength="100" value="<?=isset( $skills['skill_name'] ) ? $skills['skill_name'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="skill_desc">Skill description <span class="red">(required)</span></label>
			<input id="skill_desc" name="skill_desc" class="text validate[required]" maxlength="100" value="<?=isset( $skills['skill_desc'] ) ? $skills['skill_desc'] : '' ?>"/>
		<div class="entry">
			<button type="submit" class="add">Save</button> 
			<button type="button" class="cancel">Cancel</button>
		</div>
	</form>
</div>
