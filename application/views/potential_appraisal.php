<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
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
            <a href="<?=base_url()?>potential_appraisal/add" class="btn btn-primary btn-small" type="button"><i class="icon-plus-sign"></i> Add Employee</a>
            <br/>
            <br/>
            <div class="row-fluid">
                <div class="block span12">
                    <div class="block-heading" data-target="#widget1container">
                        Potential Promotions Appraisal
                    </div>
                    <div id="widget1container" class="block-body">                        
                        <table id="tbl_feedbacks" class="table">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Percentage</th>
                                <th>Date Created</th>
                            </thead>
                            <tbody>
                                <?php 
                                    if( count( $potentials ) > 0 ) { 
                                        foreach ($potentials as $potential) {
                                            $counter++;
                                ?>
                                <tr>
                                    <td><?=$counter?></td>
                                    <td><?=$potential['full_name']?></td>
                                    <td><?=is_numeric($potential['ave']) ? number_format(($potential['ave'] / 5) * 100) . '%' : '-'?></td>
                                    <td><?=$potential['date_submit']?></td>
                                </tr>
                                <?php 
                                        }
                                    } else { 
                                ?> 
                                <tr>
                                    <td colspan="4">
                                        <center>
                                            <label class="label label-info">No records found!</label>
                                        </center>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div class="modal small hide fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: 780px;margin-left: -390px;margin-top: -290px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Feedback Summary</h3>
                    </div>
                    <div class="modal-body">
                    
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
                    $('#summaryModal .modal-body').html(data);
                    $('#summaryModal').modal('show');
                },
                    'html'
                );
            }
        </script>