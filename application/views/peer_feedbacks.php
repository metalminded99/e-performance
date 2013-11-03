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
                        Peer Feedback
                    </div>
                    <div id="widget1container" class="block-body">                        
                        <table id="tbl_feedbacks" class="table">
                            <thead>
                                <th>#</th>
                                <th>Feedback Title</th>
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
                                    <td><?=$feedback['appraisal_title']?></td>
                                    <td><?=$feedback['status']?></td>
                                    <td><?=$this->template_library->format_mysql_date( $feedback['date_assigned'], 'F d, Y' )?></td>
                                    <td>
                                        <?php if($feedback['status'] == 'Pending' ){ ?> 
                                        <a href="<?=base_url()?>feedbacks/peer_feedback/<?=$feedback['app_id']?>/<?=$feedback['assign_id']?>" title="Evaluate" class="optlnk"><i class="icon-edit"></i></a> 
                                        <?php } else { ?>
                                        <a href="javascript:void(0)" title="View Result" onclick="get_summary('<?=$feedback['app_id']?>');" class="optlnk"><i class="icon-file"></i></a>
                                        <?php } ?>
                                    </td>
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
                
                <div class="modal small hide fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Feedback Summary</h3>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>Core</th>
                                <th>Performance Output</th>
                                <th>Abilities</th>
                                <th>Skills</th>
                            </thead>
                            <tbody>
                                <tr class="success">
                                    <td id="core"></td>
                                    <td id="perf"></td>
                                    <td id="abl"></td>
                                    <td id="skills"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Back</button>
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
            $( document ).ready( function(){
                $( "#frm_feedback" ).validationEngine();
                $('.optlnk').tooltip();
            });

            function get_summary( app_id ){
                $.post( '<?=base_url()?>feedbacks/get_feedback_summary', { 'app_id' : app_id, 'cat' : '<?=$category?>'  }, function(data) {
                    generate_summary(data);
                },
                    'json'
                );
            }

            function generate_summary( result ) {
                $.each( result, function( i ) {
                    $( 'td#' + result[i].category ).html( '' );
                    $( 'td#' + result[i].category ).html( result[i].ave );
                });
                $('#summaryModal').modal('show')
            }
        </script>