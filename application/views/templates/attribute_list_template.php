<form id="frm_item_list" action="<?=$save_url?>" method="POST">
	<?=isset( $hidden_id ) ? form_hidden( 'user_id', $hidden_id ) : '' ?>
	<table class="table">
		<thead>
			<th colspan="5"> 
				<label class="checkbox">
					Select All <input type="checkbox" id="item_all"> 
				</label>
			</th>
		</thead>
		<tbody>
	  	<?php 
	  		if( count( $attr_list ) > 0 ){ 
	  			$ctr = 0;
	  			foreach ($attr_list as $attr) {
	  				if( $ctr > 4 ) $ctr = 0;
	  				$attr_keys = array_keys( $attr );

					for( $k = 0; $k < count( $attr_keys ); $k++ ){ 
						if( preg_match( '/name/', $attr_keys[ $k ] ) ){
							$list_data = $attr[ $attr_keys[ $k ] ];
						}

						if( preg_match( '/title/', $attr_keys[ $k ] ) ){
							$list_data = $attr[ $attr_keys[ $k ] ];
						}

						if( preg_match( '/id/', $attr_keys[ $k ] ) ){
							if( $attr_keys[ $k ] != 'job_id' )
								$id = $attr[ $attr_keys[ $k ] ];
						} 

						if( $attr_keys[ $k ] == 'duration' )
							echo form_hidden( 'duration[]', $attr[ $attr_keys[ $k ] ].'|'.$id );
					}

					if( $ctr == 0 ) echo "<tr>";
					echo '<td>
							<label class="checkbox">
								<input type="checkbox" value="'.$id.'" name="item[]" id="item_'.$id.'">'.$list_data.'
							</label>
						</td>';
					if( $ctr > 3 ) echo "</tr>";

					$ctr++;
	    		}
	    	}
		?>
	  	</tbody>
	</table>
</form>
<script type="text/javascript">
	$('#item_all').click( function() {
		var all = $(this).prop('checked');
		toggle_checkbox( $('#frm_item_list table tr td input[type=checkbox]'), all );
	});
</script>