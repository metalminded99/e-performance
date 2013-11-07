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
				<th scope="col" <?=preg_match('/Description/', $th[ $h ]) ? 'style="width: 240px;"' : ''?>><?=$th[ $h ]?></th>
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
						if( !preg_match( '/id/', $result_keys[ $k ] ) ){
				?>
				
				<td> <?=$result[ $result_keys[ $k ] ]?> </td>

				<?php 
						}else{
							$id = $result[ $result_keys[ $k ] ];
						} 
					}
				 ?>
				<td align = "center">
					<a href="<?=base_url()?>control_panel/<?=$u_uri?>/<?=$id?>" class="table-icon edit" title="View/Edit"></a>
					<a href="javascript:void(0);" onclick="delete_list('<?=$id?>');" class="table-icon delete" title="Delete"></a>
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
