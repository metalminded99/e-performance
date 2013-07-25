<div class="full_w">
	<div class="h_title"><?=$h_title?></div>
	
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
				<?php for($h = 0; $h < count( $th ); $h++) { ?>
				<th scope="col"><?=$th[ $h ]?></th>
				<?php } ?>
				<th scope="col" style="width: 65px;">Action</th>
			</tr>
		</thead>
			
		<tbody>
			<?php 
				if( count($listing) ): 
					$ctr = isset($counter) ? $counter : 0;
					foreach( $listing as $result ):
						$result_keys = array_keys( $result );
						$ctr++;
			?>
			
			<tr>
				<td class="align-center"> <?=$ctr?> </td>
				<?php 
					for( $k = 0; $k < count( $result_keys ); $k++ ){ 
						$id = '';
						if( $result_keys[ $k ] != 'job_id' && $result_keys[ $k ] != 'dept_id' ){
				?>
				
				<td> <?=$this->template_library->shorten_words($result[ $result_keys[ $k ] ])?> </td>

				<?php 
						}
					}
				 ?>
				<td align = "center">
					<a id="edit_<?=$result['job_id']?>" href="#" class="table-icon edit" title="View/Edit"></a>
					<a id="delete_<?=$result['job_id']?>" href="#" class="table-icon delete" title="Delete"></a>
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
		<?=isset( $add_button ) ? $add_button : ''?>
	</div>
</div>

<script type="text/javascript">
	$( '.table-icon' ).click(function(){
		var raw_id = $(this).prop('id');
		var id = raw_id.split('_')
		
		if( id[0] == 'delete' ){
			delete_list( id[1] );
		}

		if( id[0] == 'edit' ){
			window.location = "http://localhost/e-performance/control_panel/<?=$u_uri?>/" + id[1];
		}
		
	});

	function delete_list( id ) {
		var ans = confirm( 'Are you sure you want to delete this list?' );

		if( ans ){
			$.ajax({
                type: "POST"
                ,url: "http://localhost/e-performance/control_panel/<?=$d_uri?>"
                ,data: { 'id' : id },
                success: function( data ) {
	                alert( data );
	                location.reload(); 
                }
            });
		}
	}
</script>
