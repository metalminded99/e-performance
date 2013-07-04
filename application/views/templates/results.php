<div class="full_w">
	<div class="h_title">Manage Users</div>
	
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
				<th scope="col">Username</th>
				<th scope="col">Full Name</th>
				<th scope="col">Job Title</th>
				<th scope="col">Department</th>
				<th scope="col">Activated</th>
				<th scope="col" style="width: 65px;">Action</th>
			</tr>
		</thead>
			
		<tbody>
			<?php 
				if( count($users_list) ): 
					$ctr = $counter;
					foreach( $users_list as $user ):
						$ctr++;
			?>
			
			<tr>
				<td class="align-center"><?=$ctr?></td>
				<td><?=$user['uname']?></td>
				<td><?=ucfirst( $user['fname'] ) . ' ' . strtoupper( substr( $user['mname'], 0, 1 ) ) . '. ' . ucfirst( $user['lname'] )?></td>
				<td><?=$user['job_title']?></td>
				<td><?=$user['dept_name']?></td>
				<td align="center"><?=is_null($user['last_login']) ? 'No' : 'Yes'?></td>
				<td align = "center">
					<a id="edit_<?=$user['user_id']?>" href="#" class="table-icon edit" title="View/Edit"></a>
					<a id="delete_<?=$user['user_id']?>" href="#" class="table-icon delete" title="Delete"></a>
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
		<?=$pagination?>
		<div class="sep"></div>
		<a class="button add" href="<?=base_url()?>control_panel/manage_user/new_user">Add new user</a>
	</div>
</div>
