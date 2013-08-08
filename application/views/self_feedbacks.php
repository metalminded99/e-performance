<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <?php 
                echo isset( $app_menu ) ? $app_menu : '' ;
                if( $this->session->flashdata( 'message' ) ): 
                    $msg = $this->session->flashdata( 'message' );
            ?>
                <div class="alert alert-<?=$msg['class']?>">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=$msg['str']?>
                </div>
            <?php 
                endif;
            ?>
            <div class="row-fluid">
                <div class="block span12">
                    <div class="block-heading" data-target="#widget1container">
                        Self Feedback
                    </div>
                    <div id="widget1container" class="block-body">                        
                        <table id="tbl_feedbacks" class="table">
                            <thead>
                                <th>#</th>
                                <th>Feedback Name</th>
                                <th>Status</th>
                                <th>Date Assigned</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    if( count( $feedbacks ) > 0 ){
                                        $cnt = isset( $counter ) ? $counter : 0;
                                        foreach ( $feedbacks as $feedback ) {
                                            $cnt++;
                                ?>
                                <tr>
                                    <td><?=$cnt?></td>
                                    <td><?=$feedback['full_name']?></td>
                                    <td><?=$feedback['status']?></td>
                                    <td><?=$this->template_library->format_mysql_date( $feedback['date_assigned'], 'F d, Y' )?></td>
                                    <td><?php if($feedback['status'] == 'Pending' ){ ?> <a id="<?=$feedback['app_id']?>" title="Remove" class="del_btn" href="#deleteModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a> <?php } ?></td>
                                </tr>
                                <?php
                                        }
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="4">
                                        <center>
                                            <span class="label">No records found</label>
                                        </center>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="modal small hide fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Delete Confirmation</h3>
                    </div>
                    <div class="modal-body">
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete this appraisal assignment?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="btn btn-danger" data-dismiss="modal" onclick="delete_feedback();">Delete</button>
                    </div>
                </div>
                
                <div class="pagination">
                    <ul>
                        <?=$pagination?>
                    </ul>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>

        <script type="text/javascript">
            var item_id;
            var json_feedbacks = <?=json_encode( $feedbacks )?>;

            $( document ).ready( function(){
                $( "#frm_feedback" ).validationEngine();
            });

            $('.del_btn').click( function() {
                item_id = $(this).prop('id');
            });

            function delete_feedback(){
                $.post( '<?=base_url()?>employees/info/360_feedback/delete', { 'app_id' : item_id, 'user_id' : '<?=isset( $user_id ) ? $user_id : 0 ?>'  }, function(data) {
                    window.location = data;
                });
            }
        </script>