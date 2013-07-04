<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
	$( document ).ready( function(){
		$( "#frm_ability" ).validationEngine();

		$('.cancel').bind('click', function(e) {
			var ans = confirm( 'Are you sure you want to quit?' );
			
			if( ans ){
				window.location = "<?=base_url()?>control_panel/manage_abilities";
			}

			return false;
	   	});
	});

</script>
<div class="full_w">
	<div class="h_title">Abilities Form</div>
	<form id="frm_ability" action="" method="post">
		<?=isset( $abilities['ability_id'] ) ? form_hidden( 'ability_id', $abilities['ability_id'] ) : ''?>

		<div class="element">
			<label for="ability_code">Ability code <span class="red">(required)</span></label>
			<input id="ability_code" name="ability_code" class="text validate[required]" maxlength="5" value="<?=isset( $abilities['ability_code'] ) ? $abilities['ability_code'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="ability_name">Ability name <span class="red">(required)</span></label>
			<input id="ability_name" name="ability_name" class="text validate[required]" value="<?=isset( $abilities['ability_name'] ) ? $abilities['ability_name'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="ability_desc">Ability description <span class="red">(required)</span></label>
			<input id="ability_desc" name="ability_desc" class="text validate[required]" value="<?=isset( $abilities['ability_desc'] ) ? $abilities['ability_desc'] : '' ?>"/>
		<div class="entry">
			<button type="submit" class="add">Save</button> 
			<button type="button" class="cancel">Cancel</button>
		</div>
	</form>
</div>
