<div class="full_w">
	<div class="h_title"><?=$h_title?></div>
	<table>
		<thead>
			<tr>
				<th scope="col">#</th>
				<?php for($h = 0; $h < count( $th ); $h++) { ?>
				<th scope="col"><?=$th[ $h ]?></th>
				<?php } ?>
				<th scope="col" style="width: 65px;">Action</th>
			</tr>
		</thead>
			
		<tbody>
			<?php 
				if( count($department_list) ): 
					$ctr = 0;
					foreach( $department_list as $department ):
						$ctr++;
			?>
			
			<tr>
				<td class="align-center"> <?=$ctr?> </td>
				<td> <?=ucwords( $department['dept_name'] )?> </td>
				<td> <?=$department['dept_desc']?> </td>
				<td align = "center">
					<a href="#" class="table-icon edit" title="Edit"></a>
					<a href="#" class="table-icon delete" title="Delete"></a>
				</td>
			</tr>

			<?php 
					endforeach; 
				else:
			?>
			
			<tr>
				<td colspan="7" align="center">
					<strong>No users record found!</strong>
				</td>
			</tr>

			<?php endif; ?>
		</tbody>
	</table>
	<div class="entry">
		<div class="sep"></div>
		<a class="button add" href="<?=base_url()?>control_panel/manage_user/new_department">Add new department</a>
	</div>
</div>