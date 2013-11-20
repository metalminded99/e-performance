<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=isset( $left_side_nav ) ? $left_side_nav : '' ?>
        <!-- left side nav END -->
        
        <div class="span9">
            <?php if( isset( $heading ) ) { ?>
            <h1 class="page-title"><?=$heading?></h1>
            <?php 
                }
                echo isset( $emp_menu ) ? $emp_menu : '' ;
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
            <div class="btn-toolbar">
                <?php if( $this->session->userdata( 'lvl' ) == 2 ) { ?>
                <a id="add_btn" href="#addModal" class="btn btn-primary" data-toggle="modal" data-backdrop="static" data-keyboard="false"><i class="icon-plus"></i>Add Training</a>
                <? } ?>
                <div class="btn-group"></div>
            </div>
            <div class="row-fluid">
                <div class="block span12">
                    <div class="block-heading" data-target="#widget1container">
                        Development Plans
                    </div>
                    <div id="widget1container" class="block-body">
                        <table id="tbl_dev_plans" class="table">
                            <thead>
                                <th width="2%">#</th>
                                <th width="20%">Training Title</th>
                                <th width="40%">Description</th>
                                <th width="10%">Start Date</th>
                                <th width="10%">End Date</th>
                                <th width="10%">Status</th>
                                <th width="8%"></th>
                            </thead>
                            <tbody>
                                <?php
                                    if( count( $dev_plans ) > 0 ){
                                        $cnt = $this->uri->segment(5) != '' ? $this->uri->segment(5) : 0;
                                        foreach ( $dev_plans as $dev_plan ) {
                                            $cnt++;
                                ?>
                                <tr>
                                    <td><?=$cnt?></td>
                                    <td><?=$dev_plan['training_title']?></td>
                                    <td><?=$dev_plan['training_desc']?></td>
                                    <td><?=!is_null($dev_plan['date_start']) ? $this->template_library->format_mysql_date( $dev_plan['date_start'], 'F d, Y' ) : ''?></td>
                                    <td><?=$this->template_library->format_mysql_date( $dev_plan['date_end'], 'F d, Y' )?></td>
                                    <td><?=$dev_plan['status']?></td>

                                    <?php if( $this->session->userdata( 'lvl' ) == 2 ) { ?>
                                    <td>
                                        <a id="<?=$dev_plan['training_id']?>" title="Update" class="update_btn optlnk" href="#addModal" role="button" data-toggle="modal"><i class="icon-edit"></i></a>&nbsp;
                                        <a id="<?=$dev_plan['training_id']?>" title="Remove" class="del_btn optlnk" href="#deleteModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                                    </td>
                                    <? } ?>

                                    <?php if( $this->session->userdata( 'lvl' ) == 3 ) { ?>
                                    <td>
                                        <a id="<?=$dev_plan['training_id']?>" title="View details" class="view_btn optlnk" href="#viewModal" role="button" data-toggle="modal"><i class="icon-zoom-in"></i></a>
                                    </td>
                                    <? } ?>

                                </tr>
                                <?php
                                        }
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="6">
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

                <?php if( $this->session->userdata( 'lvl' ) == 2 ){ ?>
                <div class="modal small hide fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Delete Confirmation</h3>
                    </div>
                    <div class="modal-body">
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete this training?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="btn btn-danger" data-dismiss="modal" onclick="delete_dev_plan();">Delete</button>
                    </div>
                </div>

                <script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
                <script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
                <script type="text/javascript" src="<?=base_url().JS?>bootstrap-datetimepicker.min.js"></script>
                <div class="modal hide fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="AddModalLabel" aria-hidden="true">
                     <form id="frm_dev_plan" action="" method="POST">
                        <input type="hidden" name="user_id" value="<?=$user_id?>">
                        <input type="hidden" name="t_id" value="">
                        <div class="modal-header">
                            <button type="button" class="close cancel" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="AddModalLabel">Add Trainings</h3>
                        </div>
                        <div class="modal-body">
                            <label class="label label-info">Trainings</label>
                            <div class="clearfix"></div>                       
                            <select id="trainings" name="training_id" class="validate[required]">
                                <option value="">----------------</option>
                            </select>
                            <div id="details" style="display:none;">
                                <div class="clearfix"></div>
                                <label class="label label-info">Description</label>
                                <p id="desc" class="muted"></p>
                                <div class="clearfix"></div>
                                <label class="label label-info">Start Date</label>
                                <div id="date_starttimepicker" class="input-append date">
                                    <input data-format="yyyy-mm-dd" class="span5 validate[required]" type="text" name="date_start" id="date_start" readonly>
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                                <label class="label label-info">End Date</label>
                                <div id="end_datetimepicker" class="input-append date">
                                    <input data-format="yyyy-mm-dd" class="span5 validate[required]" type="text" name="date_end" id="end_date" readonly>
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                                <label class="label label-info">Included Skills</label>
                                <table class="table table-condensed" id="included_skills">
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                                <label class="label label-info">Included Abilities</label>
                                <table class="table table-condensed" id="included_abilities">
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn cancel" data-dismiss="modal" aria-hidden="true">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <? } if( $this->session->userdata( 'lvl' ) == 3 ){ ?>

                <div class="modal hide fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="viewModalLabel">Training Details</h3>
                    </div>
                    <div class="modal-body">
                        <label class="label label-info">Trainings</label>
                        <div class="clearfix"></div>                       
                        <select id="trainings" name="training_id" disabled>
                        </select>
                        <div id="details">
                            <div class="clearfix"></div>
                            <label class="label label-info">Description</label>
                            <p id="desc" class="muted"></p>
                            <div class="clearfix"></div>
                            <label class="label label-info">Start Date</label>
                            <p id="date_start" class="muted"></p>
                            <div class="clearfix"></div>
                            <label class="label label-info">End Date</label>
                            <p id="date_end" class="muted"></p>
                            <div class="clearfix"></div>
                            <label class="label label-info">Included Skills</label>
                            <table class="table table-condensed" id="included_skills">
                                <tbody>
                                </tbody>
                            </table>
                            <div id="included_skills"></div>
                            <div class="clearfix"></div>
                            <label class="label label-info">Included Abilities</label>
                            <table class="table table-condensed" id="included_abilities">
                                <tbody>
                                </tbody>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Back</button>
                    </div>
                </div>
                <? } ?>
            </div>
        </div>
        <script type="text/javascript">
            var item_id;
            var json_dev_plans = <?=json_encode( $dev_plans )?>;
            var json_trainings = <?=$trainings?>;

            $( document ).ready( function() {                
                $('.optlnk').tooltip();

                <?php if(isset($save_url)) { ?> 
                $( "#frm_dev_plan" ).validationEngine(); 

                $( '#date_starttimepicker' ).datetimepicker( 
                                                                {
                                                                    format: 'yyyy-MM-dd'
                                                                    ,startDate: 0
                                                                    ,pickTime: false
                                                                    ,endDate: Infinity
                                                                } 
                                                            );
                $( '#end_datetimepicker' ).datetimepicker( 
                                                            {
                                                                format: 'yyyy-MM-dd'
                                                                ,startDate: 0
                                                                ,pickTime: false
                                                                ,endDate: Infinity
                                                            } 
                                                        );
                <? } ?>

                $('.cancel').bind('click', function(e) {
                    var ans = confirm( 'Are you sure you want to quit?' );
                    
                    if( ans ){
                        init();
                        return true;
                    }
                    return false;
                });

                function init(){
                    $('select#trainings').val('');
                    $('#date_start').val('');
                    $('#details').hide();
                }

                generate_trainings( );
                init();
            });

            $('.del_btn').click( function() {
                item_id = $(this).prop('id');
            });

            <?php if( isset( $delete_url ) ) { ?>
            function delete_dev_plan(){
                $.post( '<?=$delete_url?>', { training_id : item_id, user : <?=$user_id?> }, function(data) {
                    window.location = data;
                });
            }
            <? } ?>

            <?php if( isset( $user_id ) ){ ?>
            function do_action( action ){
                var arr = [];
                $( '#tbl_dev_plans tr td input[type=checkbox]' ).each( function() {
                    if( $(this).prop( 'checked' ) ) {
                        arr.push( $(this).val() );
                    }
                });
                
                $.post( '<?=$action_url?>', { item : arr, state : action, user : '<?=$user_id?>' }, function(data) {
                    window.location = data;
                });
            }
            <? } ?>           
    
            $('.update_btn').click( function( ){
                var t_id = $(this).prop( 'id' );

                if( t_id != '' ){
                    $('#AddModalLabel').text( 'Update Training Detail' );
                    $('#trainings').val( t_id ).change();
                    $('#trainings').prop( 'disabled', true );
                    $('#frm_dev_plan').prop( 'action', '<?=$update_url?>' );
                    $('#frm_dev_plan input[name=t_id]').val( t_id );

                    $.each( json_dev_plans, function( i, l ) {
                        if( json_dev_plans[i].training_id === t_id ){
                            $('#frm_dev_plan input[name=date_start]').val( json_dev_plans[i].date_start );
                            $('#frm_dev_plan input[name=date_end]').val( json_dev_plans[i].date_end );

                            $( '#included_skills tbody' ).html('');
                            $( '#included_abilities tbody' ).html('');

                            var t_skill_result = '';
                            var t_ability_result = '';
                            var t_s = json_dev_plans[i].t_skills;
                            var t_a = json_dev_plans[i].t_abilities;
                            $.each( t_s, function (i , l) {
                                if (i != 0 && i % 3 == 0) {
                                    t_skill_result = t_skill_result + '<tr>';
                                }

                                t_skill_result = t_skill_result + '<td>' + t_s[i].skill_name + '</td>';

                                if (i != 0 && i % 3 == 0) {
                                    t_skill_result = t_skill_result + '</tr>';
                                }
                            });
                            $.each( t_a, function (i , l) {
                                if (i != 0 && i % 3 == 0) {
                                    t_ability_result = t_ability_result + '<tr>';
                                }

                                t_ability_result = t_ability_result + '<td>' + t_a[i].ability_name + '</td>';

                                if (i != 0 && i % 3 == 0) {
                                    t_ability_result = t_ability_result + '</tr>';
                                }
                            });

                            $( t_skill_result ).appendTo( "#included_skills tbody" );
                            $( t_ability_result ).appendTo( "#included_abilities tbody" );
                        }
                    });
                    $('#details').slideDown( 'fast' );
                }else{
                    $('#viewModal').modal({ show: false });
                }
            });
            
            function generate_trainings( ){
                var select = $('#trainings');
                $.each( json_trainings, function( i, l ) {
                    select.append( $('<option></option>').attr( 'value', json_trainings[i].training_id ).text( json_trainings[i].training_title ) );
                });
            }

            $('#trainings').change( function( ){
                var t_id = $(this).val();
                if( t_id != '' ){
                    $.each( json_trainings, function( i, l ) {
                        if( json_trainings[i].training_id === t_id ){
                            if( $('#frm_dev_plan input[name=t_id]').length )
                                $('#frm_dev_plan input[name=t_id]').val( json_trainings[i].training_id );
                            
                            $('p#desc').text( json_trainings[i].training_desc );

                            $( '#included_skills tbody' ).html('');
                            $( '#included_abilities tbody' ).html('');

                            var t_skill_result = '';
                            var t_ability_result = '';
                            var t_s = json_trainings[i].t_skills;
                            var t_a = json_trainings[i].t_abilities;
                            $.each( t_s, function (i , l) {
                                if (i != 0 && i % 3 == 0) {
                                    t_skill_result = t_skill_result + '<tr>';
                                }

                                t_skill_result = t_skill_result + '<td>' + t_s[i].skill_name + '</td>';

                                if (i != 0 && i % 3 == 0) {
                                    t_skill_result = t_skill_result + '</tr>';
                                }
                            });
                            $.each( t_a, function (i , l) {
                                if (i != 0 && i % 3 == 0) {
                                    t_ability_result = t_ability_result + '<tr>';
                                }

                                t_ability_result = t_ability_result + '<td>' + t_a[i].ability_name + '</td>';

                                if (i != 0 && i % 3 == 0) {
                                    t_ability_result = t_ability_result + '</tr>';
                                }
                            });

                            $( t_skill_result ).appendTo( "#included_skills tbody" );
                            $( t_ability_result ).appendTo( "#included_abilities tbody" );
                        }
                    });
                    $('#details').slideDown( 'fast' );
                }else{
                    $('#details').slideUp();
                }

                return true;
            });

            $('.view_btn').click( function() {
                var t_id = $(this).prop('id');

                if( t_id != '' ){
                    $('#trainings').val( t_id ).change();

                    $.each( json_dev_plans, function( i, l ) {
                        if( json_dev_plans[i].training_id === t_id ){
                            $('p#date_start').text( json_dev_plans[i].date_start );
                            $('p#date_end').text( json_dev_plans[i].date_end );
                        }
                    });
                    $('#details').slideDown();
                } else{
                    $('#addModal').modal({ show: false });
                }
            });

            <?php if(isset($save_url)) { ?>
            $('#add_btn').click( function() {
                $('#AddModalLabel').text( 'Add Training' );
                $( '#trainings' ).prop( 'disabled', false );
                $('#frm_dev_plan').prop( 'action', '<?=$save_url?>' );
            });
            <? } ?>
        </script>