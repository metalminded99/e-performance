<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <h1 class="page-title"><?=$heading?></h1>
			<div class="btn-toolbar">
				<a href="#addModal" class="btn btn-primary" data-toggle="modal"><i class="icon-plus"></i><?=$add_link_text?></a>
				<div id="action" class="btn-group" style="display:none;">
					<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="#" onclick="activate();">Activate</a></li>
						<li><a href="#" onclick="deactivate();">Deactivate</a></li>
						<li class="divider"></li>
						<li><a href="#" onclick="remove();">Remove</a></li>
					</ul>
				</div>
				<div class="btn-group"></div>
			</div>
			<div class="well">
				<?php 
					if( $this->session->flashdata( 'message' ) ): 
						$msg = $this->session->flashdata( 'message' );
				?>
                <div class="alert alert-<?=$msg['class']?>">
                	<button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=$msg['str']?>
                </div>
                <?php endif; ?>
			    <table class="table" id="job_attr">
			      <thead>
			        <tr>
						<th><?php if( count( $attributes ) > 0 ){ ?><input type="checkbox" id="select_all" selected="false" > <?php } ?></th>
						<?php
							$th_cnt = count( $table_heading );
							for( $th = 0; $th < $th_cnt; $th++ ){ 
						?>
						<th><?=$table_heading[ $th ]?></th>
						<? } ?>
						<th style="width: 26px;"></th>
			        </tr>
			      </thead>
			      <tbody>
			      	<?php 
			      		if( count( $attributes ) > 0 ){ 
			      			$ctr = 0;
			      			foreach ($attributes as $attribute) {
			      				$attr_keys = array_keys( $attribute );
			      				$ctr++;
			      	?>
			        <tr>
			          	<td><?=form_checkbox( 'attr[]', $attribute[ $key ] )?></td>
			          	<?php 
							for( $k = 0; $k < count( $attr_keys ); $k++ ){ 
								if( !preg_match( '/id/', $attr_keys[ $k ] ) ){
									$list_data = $this->template_library->shorten_words( $attribute[ $attr_keys[ $k ] ] );
						?>
						
						<td> <?=$list_data?> </td>

						<?php 
								}else{
									if( $attr_keys[ $k ] != 'job_id' )
										$id = $attribute[ $attr_keys[ $k ] ];
								} 
							}
					 	?>
			          <td>
			              <a id="<?=$id?>" title="remove" class="del_btn" href="#deleteModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
			          </td>
			        </tr>
			        <? 
			        		}
			    		} else { 
			    	?>
			        <tr>
			          <td colspan="<?=$th_cnt + 2?>"><center><span class="label label-invert" style="font-size:15px;">No records found!</span></center></td>
			        </tr>
			        <? } ?>
			      </tbody>
			    </table>
			</div>
			
			<div class="pagination">
			    <ul>
			        <?=$pagination?>
			    </ul>
			</div>

			<div class="modal small hide fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			        <h3 id="myModalLabel">Delete Confirmation</h3>
			    </div>
			    <div class="modal-body">
			        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete this item?</p>
			    </div>
			    <div class="modal-footer">
			        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
			        <button class="btn btn-danger" data-dismiss="modal" onclick="delete_item();">Delete</button>
			    </div>
			</div>

			<div class="modal hide fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			        <h3 id="myModalLabel">Select item to add</h3>
			    </div>
			    <div class="modal-body">
		        	<?=isset($attr_selection) ? $attr_selection : 'No items to select'?>
			    </div>
			    <div class="modal-footer">
			        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
			        <button class="btn btn-primary" data-dismiss="modal" onclick="$('#frm_item_list').submit();">Save</button>
			    </div>
			</div>
    	</div>

    	<script type="text/javascript">
    		var item_id;

    		$( document ).ready( function() {
    			init();
    		});

    		function init(){
    			$('#job_attr tr td input[type=checkbox]').each( function() {
    				$(this).prop('checked', false);
    			});
    		}

    		$('.del_btn').click( function() {
    			item_id = $(this).prop('id');	
    		});

    		function delete_item() {
    			$.ajax({
				    type: "POST"
				    ,url: "<?=$delete_url?>"
				    ,data: { 'item' : item_id },
				    success: function( data ) {
				    	window.location = data;
				    }
				});
    		}

    		$('#select_all').click( function() {
				var all = $(this).prop('checked');
				toggle_checkbox( $('#job_attr tr td input[type=checkbox]'), all );
				if( all ){
					$('#action').show();
				}else{
					$('#action').hide();
				}
			});

			$('#job_attr tr td input[type=checkbox]').click( function() {
				if( $(this).prop( 'checked' ) ){
					$('#action').show();
				}else{
					$('#action').hide();
				}
			});

    		function deactivate() {
    			change_status( 'No' );
    		}

    		function activate() {
    			change_status( 'Yes' );
    		}

    		function change_status( status ){
    			var arr = [];
    			$( '#job_attr tr td input[type=checkbox]' ).each( function() {
    				if( $(this).prop( 'checked' ) ) {
    					arr.push( $(this).val() );
    				}
    			});

    			$.post( '<?=$update_url?>', { item : arr, state : status }, function(data) {
			  		window.location = data;
				});
    		}

    		function remove() {
    			var arr = [];
    			$( '#job_attr tr td input[type=checkbox]' ).each( function() {
    				if( $(this).prop( 'checked' ) ) {
    					arr.push( $(this).val() );
    				}    				
    			});

    			$.post( '<?=$delete_url?>', { item : arr }, function(data) {
			  		window.location = data;
				});
    		}
    	</script>