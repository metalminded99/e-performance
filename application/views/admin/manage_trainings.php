<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
	$( document ).ready( function(){
		$( "#frm_trainings" ).validationEngine();

		$('.cancel').bind('click', function(e) {
			var ans = confirm( 'Are you sure you want to quit?' );
			
			if( ans ){
				window.location = "<?=base_url()?>control_panel/manage_trainings";
			}

			return false;
	   	});
	});

</script>
<div class="full_w">
	<div class="h_title">Training Form</div>
	<form id="frm_trainings" action="" method="post">
		<?=isset( $trainings['training_id'] ) ? form_hidden( 'training_id', $trainings['training_id'] ) : ''?>

		<div class="element">
			<label for="training_title">Training title <span class="red">(required)</span></label>
			<input id="training_title" name="training_title" class="text validate[required]" value="<?=isset( $trainings['training_title'] ) ? $trainings['training_title'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="training_desc">Training description <span class="red">(required)</span></label>
			<input id="training_desc" name="training_desc" class="text validate[required]" value="<?=isset( $trainings['training_desc'] ) ? $trainings['training_desc'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="duration">Duration <span class="red">(required)</span></label>
			<input id="duration" name="duration" style="width:5%;" class="text validate[required, custom[onlyNumber]]" value="<?=isset( $trainings['duration'] ) ? $trainings['duration'] : '' ?>" maxlength="3"/> hour/s
		</div>
		<div class="element">
			<label for="skills">Skills to be acquired <span class="red">(required)</span></label>
			<?php 
				if( isset( $skills ) && count( $skills ) > 0 ) {
			?>
			<table id="tbl_skills" style="width:100%;">
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
						
						if( $this->template_library->check_array_value_exist( $t_skills, $skill['skill_id'] ) )
							$s_check = "checked";
						else
							$s_check = "";

						echo '<td>
								<input type="checkbox" value="'.$skill['skill_id'].'" name="skills[]" id="'.$skill['skill_id'].'" '.$s_check.'>&nbsp;'.$skill['skill_name'].'
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
			<?php
				} else { 
			?>
				<div class="n_warning">
					<p>No skills available. Manage skills <a href="<?=base_url()?>control_panel/manage_skills">here</a></p>
				</div>
			<?php } ?>
		</div>
		<div class="element">
			<label for="abilities">Abilities to be acquired <span class="red">(required)</span></label>
			<?php 
				if( isset( $abilities ) && count( $abilities ) > 0 ) {
			?>
			<table id="tbl_abilities" style="width:100%;">
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
						if( $this->template_library->check_array_value_exist( $t_abilities, $ability['ability_id'] ) )
							$a_check = "checked";
						else
							$a_check = "";

						echo '<td>
								<input type="checkbox" value="'.$ability['ability_id'].'" name="abilities[]" id="'.$ability['ability_id'].'" '.$a_check.'>&nbsp;'.$ability['ability_name'].'
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
			<?php
				} else { 
			?>
				<div class="n_warning">
					<p>No abilities available. Manage skills <a href="<?=base_url()?>control_panel/manage_abilities">here</a></p>
				</div>
			<?php } ?>
		</div>
		<div class="entry">
			<button type="submit" class="add">Save</button> 
			<button type="button" class="cancel">Cancel</button>
		</div>
	</form>
</div>
