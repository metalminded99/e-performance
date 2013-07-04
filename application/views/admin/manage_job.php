<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
	$( document ).ready( function(){
		$( "#frm_job" ).validationEngine();

		$('.cancel').bind('click', function(e) {
			var ans = confirm( 'Are you sure you want to quit?' );
			
			if( ans ){
				window.location = "<?=base_url()?>control_panel/manage_job";
			}

			return false;
	   	});
	});

</script>
<div class="full_w">
	<div class="h_title">Job Form</div>
	<form id="frm_job" action="" method="post">
		<?=isset( $job->job_id ) ? form_hidden( 'job_id', $job->job_id ) : ''?>
		
		<div class="element">
			<label for="dept_id">Department <span class="red">(required)</span></label>
			<select name="dept_id" id="dept_id" class="validate[required]">
				<?php if( !isset( $job->dept_id ) ){ ?> <option value="">-- Select Department</option> <? } ?>
				<?php foreach ($departments as $dept): ?>
				<option value="<?=$dept['dept_id']?>" <?=isset( $job->dept_id ) && $job->dept_id == $dept['dept_id'] ? 'selected="selected"' : ''?> ><?=$dept['dept_name']?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="element">
			<label for="job_title">Job name <span class="red">(required)</span></label>
			<input id="job_title" name="job_title" class="text validate[required, custom[onlyLetterSp]]" value="<?=isset($job->job_title) ? $job->job_title : '' ?>"/>
		</div>
		<div class="element">
			<label for="job_desc">Job description <span class="red">(required)</span></label>
			<input id="job_desc" name="job_desc" class="text validate[required, custom[onlyLetterSp]]" value="<?=isset($job->job_desc) ? $job->job_desc : '' ?>"/>
		<div class="entry">
			<button type="submit" class="add">Save</button> 
			<button type="button" class="cancel">Cancel</button>
		</div>
	</form>
</div>
