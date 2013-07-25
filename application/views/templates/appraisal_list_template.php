<div class="full_w">
	<div class="h_title">Manage Appraisal</div>
	
	<?php 
		# system message
		if( $this->session->flashdata('message') ) : 
			$msg = $this->session->flashdata('message');
	?>
	<div class="<?=$msg['class']?>">
		<p><?=$msg['str']?></p>
	</div>
	<?php endif; ?>

	<table>
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Appraisal Title</th>
				<th scope="col">Description</th>
				<th scope="col">Date Created</th>
				<th scope="col" style="width: 65px;">Action</th>
			</tr>
		</thead>
			
		<tbody>
			<?php 
				if( count($appraisal) ): 
					$ctr = isset($counter) ? $counter : 0;
					foreach( $appraisal as $result ):
			?>
			
			<tr>
				<td class="align-center"> <?=$ctr?> </td>
				<td> <?=$result[ 'appraisal_title' ]?> </td>
				<td> <?=$this->template_library->shorten_words( $result[ 'appraisal_desc' ]) ?> </td>
				<td> <?=$this->template_library->format_mysql_date( $result[ 'date_created' ], 'M d, Y' )?> </td>
				<td align = "center">
					<a href="<?=base_url()?>control_panel/manage_appraisal/update/<?=$result[ 'appraisal_id' ]?>" class="table-icon edit" title="View/Edit"></a>
					<a href="<?=base_url()?>control_panel/manage_appraisal/delete/<?=$result[ 'appraisal_id' ]?>" class="table-icon delete" title="Delete" onclick = "return confirm( 'Are you sure you want to delete this list?' );"></a>
				</td>
			</tr>

			<?php 
					endforeach; 
				else:
			?>
			
			<tr>
				<td colspan="7" align="center">
					<strong>No records found!</strong>
				</td>
			</tr>

			<?php endif; ?>
		</tbody>
	</table>
	<div class="entry">
		<?=$pagination?>
		<div class="sep"></div>
		<a class="button add" href="<?=base_url()?>control_panel/manage_appraisal/add">Add new appraisal</a>
	</div>
</div>
