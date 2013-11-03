<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <h2 class="page-title">Job Appraisal Categories for <i><?=$this->session->userdata( 'job_title' )?></i></h2>
            <ul class="nav nav-pills">
                <li <?=$this->uri->segment(1) == 'appraisal' && $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                    <a href="<?=base_url()?>appraisal">Appraisals</a>
                </li>
                <li <?=$this->uri->segment(2) == 'categories' ? 'class="active"' : '' ?>>
                    <a href="<?=base_url()?>appraisal/categories">Categories</a>
                </li>
            </ul>
            <div class="btn-toolbar">
				<a href="javascript:void(0);" class="btn btn-primary" onclick="show_modal('add_main');$('#add_modal').validationEngine();"><i class="icon-plus"></i> Add Main Category</a>
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
			    <table class="table table-hover" id="job_attr">
			      <thead>
			        <tr>
						<th>#</th>
						<th>Main Category</th>
						<th>Sub Category</th>
						<th></th>
			        </tr>
			      </thead>
			      <tbody>
			      	<?php 
			      		if( count( $main_cat ) > 0 ){ 
			      			$counter = 0;
			      			foreach ($main_cat as $main) {
			      				$counter++;
			      	?>
			        <tr>
			      		<td style="background-color:#F5F583;"><?=$counter?></td>
			          	<td colspan="2" style="background-color:#F5F583;">
			          		<em><?=ucwords($main['main_category_name'])?></em>
		          		</td>
		          		<td style="background-color:#F5F583;">
							<a title="Add sub category" class="optlnk" href="javascript:void(0);" role="button" onclick="show_modal('add','<?=$main['main_category_name']?>','<?=$main['main_category_id']?>');$('#add_modal').validationEngine();"><i class="icon-plus-sign"></i></a>
							&nbsp;
							<a title="Edit main category" class="optlnk" href="javascript:void(0);" role="button" onclick="show_modal('main_edit', '<?=$main['main_category_name']?>', '<?=$main['main_category_id']?>');$('#add_modal').validationEngine();"><i class="icon-edit"></i></a>
							&nbsp;
							<a title="Remove main category" class="optlnk" href="javascript:void(0);" role="button" onclick="remove_main_cat('<?=$main['main_category_id']?>');"><i class="icon-remove"></i></a>
						</td>
		          	</tr>
			        <?php
				        		$sub_cat = $this->appraisal_model->getAppraisalSubCategories( array( 'main_cat_id' => $main['main_category_id'] ) );
				        		if( count( $sub_cat ) > 0 ){ 
				      				foreach ($sub_cat as $sub) {
				      ?>
					<tr>
						<td></td>
						<td></td>
						<td>
							<?=ucwords($sub['sub_category_name'])?>
						</td>
						<td>
							<a title="Edit sub category" class="optlnk" href="javascript:void(0);" role="button" onclick="show_modal('sub_edit', '<?=$sub['sub_category_name']?>', '<?=$sub['sub_category_id']?>');$('#add_modal').validationEngine();"><i class="icon-edit"></i></a>
							&nbsp;
							<a title="Remove sub category" class="optlnk" href="javascript:void(0);" role="button" onclick="remove_sub_cat('<?=$sub['sub_category_id']?>');"><i class="icon-remove"></i></a>
						</td>
					</tr>
			      	<?php
				      				}
				      			} else {
				    ?>
				    <tr>
				    	<td colspan="5"><span class="label label-info">No sub category available.</span></td>
				    </tr>
				    <?php
				      			}
			        		}
			    		} else { 
			    	?>
			        <tr>
			          <td colspan="4"><center><span class="label label-invert" style="font-size:15px;">No records found!</span></center></td>
			        </tr>
			        <? } ?>
			      </tbody>
			    </table>
			</div>

			<div class="modal small hide fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addLabel" aria-hidden="true">
				<form id="add_modal" onsubmit="return false;">
					<input type="hidden" name="main_id" value="">
				    <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				        <h3 id="addLabel"></h3>
				    </div>
				    <div class="modal-body">
			          	<label>Category:</label>
						<input type="text" id="sub_cat" class="validate[required]" name="sub_cat" placeholder="Enter Category..">
				    </div>
				    <div class="modal-footer">
				        <button class="btn" type="button" onclick="init_add();" aria-hidden="true">Cancel</button>
				        <button id="add_main" class="btn btn-danger" onclick="add_main_cat();" style="display:none;">Add</button>
				        <button id="add_sub" class="btn btn-danger" onclick="add_sub_cat();" style="display:none;">Add</button>
				        <button id="update_sub" class="btn btn-danger" onclick="update_sub_cat();" style="display:none;">Update</button>
				        <button id="update_main" class="btn btn-danger" onclick="update_main_cat();" style="display:none;">Update</button>
				    </div>
			    </form>
			</div>
    	</div>

    	<script type="text/javascript">
    		var item_id;

    		$( document ).ready( function() {
                $('.optlnk').tooltip();
            });

            function show_modal( action, label, item_id ) {
            	var lbl;
            	if( action == 'add_main' ) {
            		lbl = 'Add New Main Category';
            		$('#addModal #add_main').show();
            		$('#addModal #add_sub').hide();
            		$('#addModal #update_sub').hide();
            		$('#addModal #update_main').hide();
            	}
            	if( action == 'add' ) {
            		lbl = 'Add New Sub Category for '+label;
            		$('#addModal #add_main').hide();
            		$('#addModal #add_sub').show();
            		$('#addModal #update_sub').hide();
            		$('#addModal #update_main').hide();
            	}
            	if( action == 'sub_edit' ) {
            		lbl = 'Update Sub Category';
            		$('#addModal #add_main').hide();
            		$('#addModal #add_sub').hide();
            		$('#addModal #update_sub').show();
            		$('#addModal #update_main').hide();
            		$('#addModal #sub_cat').val( label );
            	}
            	if( action == 'main_edit' ) {
            		lbl = 'Update main Category';
            		$('#addModal #add_main').hide();
            		$('#addModal #add_sub').hide();
            		$('#addModal #update_sub').hide();
            		$('#addModal #update_main').show();
            		$('#addModal #sub_cat').val( label );
            	}

            	$('#addModal #addLabel').text( lbl );
        		$('#addModal input[name=main_id]').val( item_id );
        		$('#addModal').modal({
        								 'show'		: true
        								,'backdrop' : 'static'
        								,'keyboard' : false
        							});
            }

            function add_main_cat(){
            	if( $('#add_modal #sub_cat').val() === '' )
            		return false;

            	$.ajax({
                        type: "POST"
                        ,url: "<?=base_url();?>appraisal/ajax_request"
                        ,data: $('#add_modal').serialize() + '&action=add_main_cat',
                        success: function( data ) {
                            if( data ) {
                            	location.reload();
                            }
                        }
                    });
            }

            function add_sub_cat(){
            	if( $('#add_modal #sub_cat').val() === '' )
            		return false;

            	$.ajax({
                        type: "POST"
                        ,url: "<?=base_url();?>appraisal/ajax_request"
                        ,data: $('#add_modal').serialize() + '&action=add_sub_cat',
                        success: function( data ) {
                            if( data ) {
                            	location.reload();
                            }
                        }
                    });
            }

            function update_sub_cat(){
            	if( $('#add_modal #sub_cat').val() === '' )
            		return false;

            	$.ajax({
                        type: "POST"
                        ,url: "<?=base_url();?>appraisal/ajax_request"
                        ,data: { action : 'update_sub_cat', item_id : $('#add_modal input[type="hidden"]').val(), item : $('#add_modal #sub_cat').val() },
                        success: function( data ) {
                        	location.reload();
                        }
                    });
            }

            function update_main_cat(){
            	if( $('#add_modal #sub_cat').val() === '' )
            		return false;

            	$.ajax({
                        type: "POST"
                        ,url: "<?=base_url();?>appraisal/ajax_request"
                        ,data: { action : 'update_main_cat', item_id : $('#add_modal input[type="hidden"]').val(), item : $('#add_modal #sub_cat').val() },
                        success: function( data ) {
                        	location.reload();
                        }
                    });
            }

            function remove_main_cat( item_id ){
            	var ans = confirm('Are you sure you want to delete this main category?');
            	if( ans ){
	            	$.ajax({
	                        type: "POST"
	                        ,url: "<?=base_url();?>appraisal/ajax_request"
	                        ,data: { action : 'remove_main_cat', item_id : item_id },
	                        success: function( data ) {
                            	location.reload();
	                        }
	                    });
	            }
            }

            function remove_sub_cat( item_id ){
            	var ans = confirm('Are you sure you want to delete this sub category?');
            	if( ans ){
	            	$.ajax({
	                        type: "POST"
	                        ,url: "<?=base_url();?>appraisal/ajax_request"
	                        ,data: { action : 'remove_sub_cat', item_id : item_id },
	                        success: function( data ) {
                            	location.reload();
	                        }
	                    });
	            }
            }

            function init_add(){
            	$('#add_modal input[type="text"]').val('');
            	$('#addModal').modal('hide');
            }
    	</script>