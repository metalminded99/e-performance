	<!-- Content Start -->
	<div id="content">
		<?php if( isset( $sidebar ) ) { ?>
		<!-- Side bar menu -->
		<?=$sidebar?>
		<!-- Side bar menu End -->
		<? } ?>

		<div id="main">
			<!-- Statistics -->
			<?=$users_list?>
			<!-- Statistics End -->
		</div>

	</div>
	<!-- Content End -->

	<script type="text/javascript">
		$( '.table-icon' ).click(function(){
			var raw_id = $(this).prop('id');
			var id = raw_id.split('_')
			
			if( id[0] == 'delete' ){
				delete_user( id[1] );
			}

			if( id[0] == 'edit' ){
				window.location = "<?=base_url()?>control_panel/manage_user/update_user/" + id[1];
			}
			
		});

		function delete_user( uid ) {
			var ans = confirm( 'Delete this user?' );

			if( ans ){
				$.ajax({
	                type: "POST"
	                ,url: "<?=base_url();?>control_panel/manage_user/delete_user"
	                ,data: { 'user_id' : uid },
	                success: function( data ) {
		                alert( data );
		                location.reload(); 
	                }
	            });
			}
		}
	</script>
