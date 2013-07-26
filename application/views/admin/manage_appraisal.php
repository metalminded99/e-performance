<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
	$( document ).ready( function(){
		$( "#frm_appraisal" ).validationEngine();

		$( "#tabs" ).tabs();

		$('.cancel').bind('click', function(e) {
			var ans = confirm( 'Are you sure you want to quit?' );
			
			if( ans ){
				window.location = "<?=base_url()?>control_panel/manage_appraisal";
			}

			return false;
	   	});

	});

   	function addQuestion( e_name ){
		var txt_htm = '<div class="q_box"><div class="input_box_header"><span title="Delete" >X</span></div><textarea name="'+e_name+'[]" class="questions"></textarea></div>';

		$('#'+e_name+' .q_box').append(txt_htm);

		return false;
	}

	$('#core .q_box span').live('click',function(e){
		var index = $(this).index(this) + 1;
		console.log('asd'+index);
		$('#core .q_box').eq(index).remove();
	})
	$('#perf .q_box span').live('click',function(e){

	})
	$('#skills .q_box span').live('click',function(e){

	})
	$('#abl .q_box span').live('click',function(e){

	})

</script>
<div class="full_w">
	<div class="h_title">Appraisal Form</div>
	<form id="frm_appraisal" action="" method="post">
		<?=isset( $appraisal['appraisal_id'] ) ? form_hidden( 'appraisal_id', $appraisal['appraisal_id'] ) : ''?>

		<div class="element">
			<label for="appraisal_title">Appraisal title <span class="red">(required)</span></label>
			<input id="appraisal_title" name="appraisal_title" class="text validate[required]" value="<?=isset( $appraisal['appraisal_title'] ) ? $appraisal['appraisal_title'] : '' ?>"/>
		</div>
		<div class="element">
			<label for="appraisal_desc">Appraisal description <span class="red">(required)</span></label>
			<input id="appraisal_desc" name="appraisal_desc" class="text validate[required]" value="<?=isset( $appraisal['appraisal_desc'] ) ? $appraisal['appraisal_desc'] : '' ?>"/>
		</div>

		<div class="element">
			<div id="tabs">
				<ul style="margin-left:0;">
					<li><a href="#core">Core Competencies</a></li>
					<li><a href="#perf">Performance Output</a></li>
					<li><a href="#skills">Skills</a></li>
					<li><a href="#abl">Abilities</a></li>
				</ul>
				<div id="core">
					<div class="q_box">
						<textarea name="'core[]" class="questions"></textarea>
					</div>
					<a href="javascript:void(0)" style="color:#12c; font-size:15px;" onclick="addQuestion( 'core' );">Add more</a> 
				</div>
				<div id="perf">
					<div class="q_box">
						<textarea name="'perf[]" class="questions"></textarea>
					</div>
					<a href="javascript:void(0)" style="color:#12c; font-size:15px;" onclick="addQuestion( 'perf' );">Add more</a> 
				</div>
				<div id="skills">
					<div class="q_box">
						<textarea name="'skills[]" class="questions"></textarea>
					</div>
					<a href="javascript:void(0)" style="color:#12c; font-size:15px;" onclick="addQuestion( 'skills' );">Add more</a> 
				</div>
				<div id="abl">
					<div class="q_box">
						<textarea name="'abl[]" class="questions"></textarea>
					</div>
					<a href="javascript:void(0)" style="color:#12c; font-size:15px;" onclick="addQuestion( 'abl' );">Add more</a> 
				</div>
			</div>
		</div>

		<div class="entry">
			<button type="submit" class="save">Save</button> 
			<button type="button" class="cancel">Cancel</button>
		</div>
	</form>
</div>
