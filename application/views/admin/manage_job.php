<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
	$( document ).ready( function(){
		$( "#frm_job" ).validationEngine();
		$( "#frm_job_skills" ).validationEngine();
		$( "#frm_job_abilities" ).validationEngine();
		$( "#frm_job_act" ).validationEngine();
		$( "#frm_job_duties" ).validationEngine();

		$( "#tabs" ).tabs();

		$('.cancel').bind('click', function(e) {
			var ans = confirm( 'Are you sure you want to quit?' );
			
			if( ans ){
				window.location = "<?=base_url()?>control_panel/manage_job";
			}

			return false;
	   	});
	});

	if(document.location.hash!='') {
	    //get the index from URL hash
	    tabSelect = document.location.hash.substr(1,document.location.hash.length);
	    $("#tabs").tabs('select',tabSelect-1);
	}

</script>
<div class="full_w">
	<div class="h_title">Job Details</div>

	<?php if( $this->session->flashdata( 'message' ) ) { ?>
	<div class="n_ok">
		<p>
			<?php 
				$msg = $this->session->flashdata( 'message' );
				echo is_array( $msg ) ? $msg['str'] : $msg;
			?>
		</p>
	</div>
	<?php } ?>

	<div id="tabs">
		<ul style="margin-left:0;">
			<li><a href="#info">Basic Info</a></li>
			<?php 
				$new = $this->uri->segment(3, 0);
				if( $new != 'new_job' ) { 
			?>
			<li><a href="#dandr">Duties &amp; Responsibilty</a></li>
			<li><a href="#act">Activities</a></li>
			<li><a href="#skills">Skills</a></li>
			<li><a href="#abl">Abilities</a></li>
			<?php } ?>
		</ul>
		<div id="info">
			<form id="frm_job" action="" method="post">
				<?=isset( $job['job_id'] ) ? form_hidden( 'job_id', $job['job_id'] ) : ''?>
				
				<div class="element">
					<label for="dept_id">Department <span class="red">(required)</span></label>
					<select name="dept_id" id="dept_id" class="validate[required]">
						<?php if( !isset( $job['dept_id'] ) ){ ?> <option value="">-- Select Department</option> <? } ?>
						<?php foreach ($departments as $dept): ?>
						<option value="<?=$dept['dept_id']?>" <?=isset( $job['dept_id'] ) && $job['dept_id'] == $dept['dept_id'] ? 'selected="selected"' : ''?> ><?=$dept['dept_name']?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="element">
					<label for="job_title">Job name <span class="red">(required)</span></label>
					<input id="job_title" name="job_title" class="text validate[required, custom[onlyLetterSp]]" value="<?=isset( $job['job_title'] ) ? $job['job_title'] : '' ?>"/>
				</div>
				<div class="element">
					<label for="job_desc">Job description <span class="red">(required)</span></label>
					<input id="job_desc" name="job_desc" class="text validate[required, custom[onlyLetterSp]]" value="<?=isset($job['job_desc']) ? $job['job_desc'] : '' ?>"/>
				</div>
				<div class="entry">
					<button type="submit" class="add">Save</button> 
					<button type="button" class="cancel">Cancel</button>
				</div>
			</form>
		</div>
		<?php 
			if( $new != 'new_job' ) { 
		?>
		<div id="dandr">
			<div class="element">
				<form id="frm_job_duties" action="<?=base_url()?>control_panel/manage_job/update_duties" method="post">
					<?=isset( $job['job_id'] ) ? form_hidden( 'job_id', $job['job_id'] ) : ''?>
					<?php 
						if( isset( $duties ) && count( $duties ) > 0 ) {
					?>
					<table id="tbl_duties" style="width:100%;margin-left:0;table-layout: fixed;">
						<tr>
							<th align="left" style="width: 3%">
								<input type="checkbox" id="select_all_duties">
							</th>
							<th align="left" style="width: 25%">
								Duty Name
							</th>
							<th align="left">
								Description
							</th>
						</tr>
					<?php
							foreach ( $duties as $duty ) {								
								if( $this->template_library->check_array_value_exist( $duties_attributes, $duty['duty_id'] ) )
									$s_check = "checked";
								else
									$s_check = "";

								echo '<tr>
									  <td>
										<input type="checkbox" class="validate[minCheckbox[1]]" value="'.$duty['duty_id'].'" name="duties[]" id="'.$duty['duty_id'].'" '.$s_check.'>
									  </td>
									  <td v-align="top">'
									  .$duty['duty_name']. 
									  '</td>
									  <td style="word-wrap: break-word">'
									  .$duty['duty_desc'].
									'</td>
								</tr>';
							}
					?>
					</table>
					<script type="text/javascript">
						$('#select_all_duties').click( function() {
							var all = $(this).prop('checked');
							toggle_checkbox( $('#tbl_duties input[type=checkbox]'), all );
						});
					</script>
					
					<div class="entry">
						<button type="submit" class="add">Save</button> 
						<button type="button" class="cancel">Cancel</button>
					</div>
					<?php
						} else { 
					?>
						<div class="n_warning">
							<p>No skills available. Manage skills <a href="<?=base_url()?>control_panel/manage_skills">here</a></p>
						</div>
					<?php } ?>					
				</form>
			</div>
		</div>
		<div id="act">
			<div class="element">
				<form id="frm_job_act" action="<?=base_url()?>control_panel/manage_job/update_act" method="post">
					<?=isset( $job['job_id'] ) ? form_hidden( 'job_id', $job['job_id'] ) : ''?>
					<?php 
						if( isset( $activities ) && count( $activities ) > 0 ) {
					?>
					<table id="tbl_activities" style="width:100%;margin-left:0;table-layout: fixed;">
						<tr>
							<th align="left" style="width: 3%">
								<input type="checkbox" id="select_all_activities">
							</th>
							<th align="left" style="width: 25%">
								Activity Name
							</th>
							<th align="left">
								Description
							</th>
						</tr>
					<?php
							foreach ( $activities as $activity ) {								
								if( $this->template_library->check_array_value_exist( $act_attributes, $activity['activity_id'] ) )
									$s_check = "checked";
								else
									$s_check = "";

								echo '<tr>
									  <td>
										<input type="checkbox" class="validate[minCheckbox[1]]" value="'.$activity['activity_id'].'" name="activities[]" id="'.$activity['activity_id'].'" '.$s_check.'>
									  </td>
									  <td v-align="top">'
									  .$activity['activity_name']. 
									  '</td>
									  <td style="word-wrap: break-word">'
									  .$activity['activity_desc'].
									'</td>
								</tr>';
							}
					?>
					</table>
					<script type="text/javascript">
						$('#select_all_activities').click( function() {
							var all = $(this).prop('checked');
							toggle_checkbox( $('#tbl_activities input[type=checkbox]'), all );
						});
					</script>
					
					<div class="entry">
						<button type="submit" class="add">Save</button> 
						<button type="button" class="cancel">Cancel</button>
					</div>
					<?php
						} else { 
					?>
						<div class="n_warning">
							<p>No skills available. Manage skills <a href="<?=base_url()?>control_panel/manage_skills">here</a></p>
						</div>
					<?php } ?>					
				</form>
			</div>
		</div>
		<div id="skills">
			<div class="element">
				<form id="frm_job_skills" action="<?=base_url()?>control_panel/manage_job/update_skills" method="post">
					<?=isset( $job['job_id'] ) ? form_hidden( 'job_id', $job['job_id'] ) : ''?>
					<?php 
						if( isset( $skills ) && count( $skills ) > 0 ) {
					?>
					<table id="tbl_skills" style="width:100%;margin-left:0;">
						<tr>
							<th colspan="4" align="left">
								<input type="checkbox" id="select_all_skills"> &nbsp;Select All Skills
							</th>
						</tr>
					<?php
							$s_ctr = 0;
							foreach ($skills as $skill) {
								if( $s_ctr > 3 ) $s_ctr = 0;
								
								if( $s_ctr == 0 ) echo "<tr>";
								
								if( $this->template_library->check_array_value_exist( $skill_attributes, $skill['skill_id'] ) )
									$s_check = "checked";
								else
									$s_check = "";

								echo '<td>
										<input type="checkbox" class="validate[minCheckbox[1]]" value="'.$skill['skill_id'].'" name="skills[]" id="'.$skill['skill_id'].'" '.$s_check.'>&nbsp;'.$skill['skill_name'].'
									</td>';
								if( $s_ctr > 2 ) echo "</tr>";

								$s_ctr++;
							}
					?>
					</table>
					<script type="text/javascript">
						$('#select_all_skills').click( function() {
							var all = $(this).prop('checked');
							toggle_checkbox( $('#tbl_skills input[type=checkbox]'), all );
						});
					</script>

					<div class="entry">
						<button type="submit" class="add">Save</button> 
						<button type="button" class="cancel">Cancel</button>
					</div>
					<?php
						} else { 
					?>
						<div class="n_warning">
							<p>No skills available. Manage skills <a href="<?=base_url()?>control_panel/manage_skills">here</a></p>
						</div>
					<?php } ?>					
				</form>
			</div>
		</div>
		<div id="abl">
			<div class="element">
				<form id="frm_job_abilities" action="<?=base_url()?>control_panel/manage_job/update_abilities" method="post">
					<?=isset( $job['job_id'] ) ? form_hidden( 'job_id', $job['job_id'] ) : ''?>
					<?php 
						if( isset( $abilities ) && count( $abilities ) > 0 ) {
					?>
					<table id="tbl_abilities" style="width:100%;margin-left:0;">
						<tr>
							<th colspan="4" align="left">
								<input type="checkbox" id="select_all_abilities"> &nbsp;Select All Abilities
							</th>
						</tr>
					<?php
							$a_ctr = 0;
							foreach ($abilities as $ability) {
								if( $a_ctr > 3 ) $a_ctr = 0;
								
								if( $a_ctr == 0 ) echo "<tr>";
								if( $this->template_library->check_array_value_exist( $abilities_attributes, $ability['ability_id'] ) )
									$a_check = "checked";
								else
									$a_check = "";

								echo '<td>
										<input type="checkbox" class="validate[minCheckbox[1]]" value="'.$ability['ability_id'].'" name="abilities[]" id="'.$ability['ability_id'].'" '.$a_check.'>&nbsp;'.$ability['ability_name'].'
									</td>';
								if( $a_ctr > 2 ) echo "</tr>";

								$a_ctr++;
							}
					?>
					</table>
					<script type="text/javascript">
						$('#select_all_abilities').click( function() {
							var all = $(this).prop('checked');
							toggle_checkbox( $('#tbl_abilities input[type=checkbox]'), all );
						});
					</script>

					<div class="entry">
						<button type="submit" class="add">Save</button> 
						<button type="button" class="cancel">Cancel</button>
					</div>
					<?php
						} else { 
					?>
						<div class="n_warning">
							<p>No abilities available. Manage skills <a href="<?=base_url()?>control_panel/manage_abilities">here</a></p>
						</div>
					<?php } ?>					
				</form>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
