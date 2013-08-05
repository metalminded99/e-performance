<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <div class="row-fluid">
                <div class="block span12">
                    <div class="block-heading" data-target="#widget1container">
                        360&deg; Feedback
                    </div>
                    <div id="widget1container" class="block-body">
                        <form id="frm_feedback" action = "" method = "POST" >
                            <input type="hidden" id="user_id" name="user_id" value="<?=isset( $user_id ) ? $user_id : '' ?>" >
                            <div class="element">
                                <label for = "peers">Peer to conduct the feedback <span class="red">(required)</span></label>
                                <select id="peers" name="peers">
                                    <option value="">---------- Select Peer ----------</option>
                                    <?php 
                                        if ( count( $peers ) > 0 ) {
                                            foreach ( $peers as $peer ) {
                                    ?>
                                    <option value="<?=$peer['user_id']?>"><?=$peer['fname']?> <?=$peer['lname']?></option>
                                    <?php
                                            }
                                        } 
                                    ?>
                                </select>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="block span12">
                    <div class="block-heading" data-target="#widget1container">
                        History
                    </div>
                    <div id="widget1container" class="block-body">                        
                        <table id="tbl_feedback_history" class="table">
                            <thead>
                                <th>#</th>
                                <th>Peer Name</th>
                                <th>Status</th>
                                <th>Date Assigned</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    if( count( $feedback_history ) > 0 ){
                                        $cnt = isset( $counter ) ? $counter : 0;
                                        foreach ( $feedback_history as $feedback ) {
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
        <script type="text/javascript">
            var item_id;
            var json_feedback_history = <?=json_encode( $feedback_history )?>;

            $('.del_btn').click( function() {
                item_id = $(this).prop('id');
            });

            function delete_feedback(){
                $.post( '<?=base_url()?>employees/info/360_feedback/delete', { 'app_id' : item_id, 'user_id' : '<?=isset( $user_id ) ? $user_id : 0 ?>'  }, function(data) {
                    window.location = data;
                });
            }
        </script>