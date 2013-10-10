<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <h1 class="page-title">Process Lists</h1>
            <?php
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
                        Process
                    </div>
                    <div id="widget1container" class="block-body">
                        <table id="tbl_process" class="table">
                            <thead>
                                <th>#</th>
                                <th>Process Title</th>
                                <th>Description</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Date Assigned</th>
                                <th>Status</th>
                                <th>Options</th>
                            </thead>
                            <tbody>
                                <?php
                                    if( count( $process ) > 0 ){
                                        $cnt = $this->uri->segment(2) != '' ? $this->uri->segment(2) : 0;
                                        foreach ( $process as $proc ) {
                                            $cnt++;
                                ?>
                                <tr>
                                    <td><?=$cnt?></td>
                                    <td><?=$this->template_library->shorten_words( $proc['proc_title'] )?></td>
                                    <td><?=$this->template_library->shorten_words( $proc['proc_desc'] )?></td>
                                    <td><?=$this->template_library->format_mysql_date($proc['start_date'], 'M d, Y')?></td>
                                    <td><?=$this->template_library->format_mysql_date($proc['end_date'], 'M d, Y')?></td>
                                    <td><?=$this->template_library->format_mysql_date($proc['date_assigned'], 'M d, Y')?></td>
                                    <td><?=$proc['status']?></td>
                                    <td>
                                        <a id="<?=$proc['proc_id']?>" title="View details" class="view_btn optlnk" href="#detailModal" role="button" data-toggle="modal"><i class="icon-zoom-in"></i></a>&nbsp;
                                        <?php if( $proc['status'] == 'Pending' ){ ?>
                                        <a id="<?=$proc['proc_id']?>" title="Start" class="optlnk" href="#" role="button"><i class="icon-play"></i></a>&nbsp;
                                        <?php } elseif( $proc['status'] == 'On-going' ) { ?>
                                        <a id="<?=$proc['proc_id']?>" title="Completed" class="optlnk" href="#" role="button"><i class="icon-ok"></i></a>
                                        <?php } ?>
                                        <a id="<?=$proc['proc_id']?>" title="Reject"class="optlnk" href="#" role="button"><i class="icon-exclamation-sign"></i></a>&nbsp;
                                    </td>
                                </tr>
                                <?php
                                        }
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="5">
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
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete this process?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="btn btn-danger" data-dismiss="modal" onclick="delete_process();">Delete</button>
                    </div>
                </div>

                <div class="modal small hide fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">process Details</h3>
                    </div>
                    <div class="modal-body">
                         <div class="element">
                            <label for="days_to_remind">Days to Remind</label>
                            <p class="label label-info" id="days_to_remind"></p>
                        </div>
                        <div class="element">
                            <label for="deliverables">Deliverables</label>
                            <p class="label label-info" id="deliverables"></p>
                        </div>
                        <div class="element">
                            <label for="success_measure">Measure of success</label>
                            <p class="label label-info" id="success_measure"></p>
                        </div>
                        <div class="element">
                            <label for="status">Status</label>
                            <p class="label label-info" id="status"></p>
                        </div>
                        <div class="element">
                            <label for="percentage">Percentage</label>
                            <p class="label label-info" id="percentage"></p>
                        </div>
                        <div class="element">
                            <label for="date_approved">Date Approved</label>
                            <p class="label label-info" id="date_approved"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Back</button>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            var item_id;
            var json_process = <?=json_encode( $process )?>;

            $( document ).ready( function() {
                $('.optlnk').tooltip();
            });

            $('.view_btn').click( function() {
                proc_id = $(this).prop('id');

                $.each( json_process, function( i, l ) {
                    if( proc_id === json_process[ i ].proc_id  ){
                        $.each( l, function( key, val ) {
                            if( $( '#'+key ).length ){
                                var rval = val;

                                if( key == 'percentage' )
                                    rval = val + '%';

                                if( val == null )
                                    rval = 'N/A';

                                $( '#'+key ).text( rval );
                            }
                        });
                        return true;
                    }
                });

                return true;
            });

            $('.del_btn').click( function() {
                item_id = $(this).prop('id');
            });

            <?php if( isset( $delete_url ) ) { ?>
            function delete_process(){
                $.post( '<?=$delete_url?>', { proc_id : item_id }, function(data) {
                    window.location = data;
                });
            }
            <? } ?>

            <?php if( isset( $user_id ) ){ ?>
            function do_action( action ){
                var arr = [];
                $( '#tbl_process tr td input[type=checkbox]' ).each( function() {
                    if( $(this).prop( 'checked' ) ) {
                        arr.push( $(this).val() );
                    }
                });
                
                $.post( '<?=base_url()?>/employees/info/process/update', { item : arr, state : action, user : '<?=$user_id?>' }, function(data) {
                    window.location = data;
                    // console.log( data );
                });
            }
            <? } ?>
        </script>