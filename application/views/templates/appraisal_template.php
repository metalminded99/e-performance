<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <h1 class="page-title">Job Appraisal for <i><?=$this->session->userdata( 'job_title' )?></i></h1>
			<div class="btn-toolbar">
				<a href="<?=base_url()?>appraisal/add" class="btn btn-primary" data-toggle="modal"><i class="icon-plus"></i>Add new appraisal</a>
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
						<th>#</th>
						<th>Appraisal Title</th>
						<th>Description</th>
						<th>Date Created</th>
						<th></th>
			        </tr>
			      </thead>
			      <tbody>
			      	<?php 
			      		if( count( $appraisals ) > 0 ){ 
			      			foreach ($appraisals as $appraisal) {
			      				$counter++;
			      	?>
			        <tr>
			          	<td><?=$counter?></td>
			          	<td><?=$this->template_library->shorten_words( $appraisal['appraisal_title'] )?></td>
			          	<td><?=$this->template_library->shorten_words( $appraisal['appraisal_desc'] )?></td>
			          	<td><?=$appraisal['date_created']?></td>
						<td>
							<a title="update" class="up_btn" href="<?=base_url()?>appraisal/update/<?=$appraisal['appraisal_id']?>" role="button"><i class="icon-edit"></i></a>
							<a id="<?=$appraisal['appraisal_id']?>" title="remove" class="del_btn" href="#deleteModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
						</td>
			        </tr>
			        <? 
			        		}
			    		} else { 
			    	?>
			        <tr>
			          <td colspan="5"><center><span class="label label-invert" style="font-size:15px;">No records found!</span></center></td>
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
    	</div>

    	<script type="text/javascript">
    		var item_id;

    		$('.del_btn').click( function() {
    			item_id = $(this).prop('id');	
    		});

    		function delete_item() {
    			$.ajax({
				    type: "POST"
				    ,url: "<?=base_url()?>appraisal/delete"
				    ,data: { 'item' : item_id },
				    success: function( data ) {
				    	window.location = data;
				    }
				});
    		}

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
    	</script>