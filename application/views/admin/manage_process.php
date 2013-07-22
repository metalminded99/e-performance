<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
	$( document ).ready( function(){
		$( "#frm_process" ).validationEngine();

		$( '#start_date' ).datepicker(
										{ 
											dateFormat: 'yy-mm-dd'
											,changeMonth: true
											,changeYear: true 
										}
									);

		$( '#end_date' ).datepicker(
										{ 
											dateFormat: 'yy-mm-dd'
											,changeMonth: true
											,changeYear: true 
										}
									);

		$('.cancel').bind('click', function(e) {
			var ans = confirm( 'Are you sure you want to quit?' );
			
			if( ans ){
				window.location = "<?=base_url()?>control_panel/manage_process";
			}

			return false;
	   	});

	   	$('#select_all').click( function() {
            var all = $(this).prop('checked');
            toggle_checkbox( $('#frm_process input[type=checkbox]'), all );

        });
	});

</script>
<div class="full_w">
	<div class="h_title">Process Form</div>
	<form id="frm_process" action="" method="post">
		<?=isset( $process['process_id'] ) ? form_hidden( 'process_id', $process['process_id'] ) : ''?>

		<div class="element">
			<label for="proc_title">Process title <span class="red">(required)</span></label>
			<input id="proc_title" name="proc_title" class="text validate[required]" value="<?=isset( $process['proc_title'] ) ? $process['proc_title'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="proc_desc">Process description <span class="red">(required)</span></label>
			<input id="proc_desc" name="proc_desc" class="text validate[required]" value="<?=isset( $process['proc_desc'] ) ? $process['proc_desc'] : '' ?>"/>
		</div>		
		<div class="element">
			<label for="start_date">Start date <span class="red">(required)</span></label>
			<input id="start_date" name="start_date" class="validate[required] datepicker" value="<?=isset( $process['start_date'] ) ? $process['start_date'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="end_date">End date <span class="red">(required)</span></label>
			<input id="end_date" name="end_date" class="validate[required] datepicker" value="<?=isset( $process['end_date'] ) ? $process['end_date'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="end_date">Select employee</label>
			<table style="width:600px;">
				<thead>
					<th><input type="checkbox" id="select_all"></th>
					<th>Full Name</th>
					<th>Job Title</th>
					<th>Department</th>
				</thead>
				<tbody>
					<?php 
						if ( count( $users_list > 0 ) ){
							foreach ( $users_list as $employee ) {
					?>

					<tr>
						<td align="center"><input type="checkbox" name="emp[]" class="emp" value="<?=$employee['user_id']?>" <?=$this->template_library->check_array_value_exist( $emp_process, $employee['user_id'] ) ? 'checked="true"' : ''?> ></td>
						<td><?=ucwords( $employee['lname'].', '.$employee['fname'].' '.$employee['mname'] )?></td>
						<td><?=ucwords( $employee['job_title'])?></td>
						<td><?=ucwords( $employee['dept_name'])?></td>
					</tr>

					<?php 
							}
						}
					?>
				</tbody>
			</table>
		</div>

		<div class="entry">
			<button type="submit" class="add">Save</button> 
			<button type="button" class="cancel">Cancel</button>
		</div>
	</form>
</div>
