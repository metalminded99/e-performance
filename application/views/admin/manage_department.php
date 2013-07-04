<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
	$( document ).ready( function(){
		$( "#frm_department" ).validationEngine();

		$('.cancel').bind('click', function(e) {
			var ans = confirm( 'Are you sure you want to quit?' );
			
			if( ans ){
				window.location = "<?=base_url()?>control_panel/manage_department";
			}

			return false;
	   	});
	});

</script>
<div class="full_w">
	<div class="h_title">Department Form</div>
	<form id="frm_department" action="" method="post">
		<?=isset( $dept['dept_id'] ) ? form_hidden( 'dept_id', $dept['dept_id'] ) : ''?>

		<div class="element">
			<label for="dept_name">Department name <span class="red">(required)</span></label>
			<input id="dept_name" name="dept_name" class="text validate[required, custom[onlyLetterSp]]" value="<?=isset($dept['dept_name']) ? $dept['dept_name'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="dept_desc">Department description <span class="red">(required)</span></label>
			<input id="dept_desc" name="dept_desc" class="text validate[required, custom[onlyLetterSp]]" value="<?=isset($dept['dept_desc']) ? $dept['dept_desc'] : '' ?>"/>
		<div class="entry">
			<button type="submit" class="add">Save</button> 
			<button type="button" class="cancel">Cancel</button>
		</div>
	</form>
</div>
