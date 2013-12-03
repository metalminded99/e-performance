<?php 
    $module = $this->uri->segment(1);
    $cnt = $this->uri->segment(5)!= '' ? $this->uri->segment(5) : 0;
    if( $module == 'employees' ){
        $uri = base_url().'employees/info/dev_plan/'.$this->uri->segment(4).'/';
        if( $this->uri->total_segments() == 5 )
            $cnt = $this->uri->segment(6) != '' ? $this->uri->segment(6) : 0;
    }
    else{
        $uri = base_url().'my_trainings/';
    }
?>
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
            <?php endif; ?>

            <div class="row-fluid">
                <div class="block span12">
                    <div id="widget1container" class="block-body">
                        <div class="">
                            <ul class="nav nav-tabs">
                                <li class="<?=$this->uri->total_segments() == 1 || $this->uri->total_segments() == 4 ? 'active' : ''?>">
                                    <a href="<?=$uri?>"><i class="icon-time"></i>&nbsp;Pending <span class="badge badge-info"><?=$p_cnt?></span></a>
                                </li>

                                <li class="<?=$this->uri->segment(2) == 'on_going' || $this->uri->segment(5) == 'on_going' ? 'active' : ''?>">
                                    <a href="<?=$uri?>on_going"><i class="icon-road"></i>&nbsp;On-going <span class="badge badge-info"><?=$og_cnt?></span></a>
                                </li>

                                <li class="<?=$this->uri->segment(2) == 'completed' || $this->uri->segment(5) == 'completed' ? 'active' : ''?>">
                                    <a href="<?=$uri?>completed"><i class="icon-check"></i>&nbsp;Completed <span class="badge badge-success"><?=$co_cnt?></span></a>
                                </li>

                                <?php if( $this->session->userdata( 'lvl' ) == 2 ) { ?>
                                <li class="pull-right">
                                    <a id="add_btn" href="#addModal"data-toggle="modal" data-backdrop="static" data-keyboard="false"><i class="icon-plus-sign"></i> New Training</a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <table id="tbl_dev_plans" class="table">
                            <thead>
                                <th width="2%">#</th>
                                <th width="20%">Training Title</th>
                                <th width="40%">Description</th>
                                <th width="10%">Status</th>
                                <th width="8%"></th>
                            </thead>
                            <tbody>
                                <?php
                                    if( count( $dev_plans ) > 0 ){
                                        foreach ( $dev_plans as $dev_plan ) {
                                            $cnt++;
                                ?>
                                <tr>
                                    <td><?=$cnt?></td>
                                    <td><?=$dev_plan['training_title']?></td>
                                    <td><?=$dev_plan['training_desc']?></td>
                                    <td><?=$dev_plan['status']?></td>

                                    <?php if( $this->session->userdata( 'lvl' ) == 2 ) { ?>
                                    <td>
                                        <a id="<?=$dev_plan['training_id']?>" title="View details" class="view_btn optlnk" href="#viewModal" role="button" data-toggle="modal"><i class="icon-zoom-in"></i></a>&nbsp;
                                        <?php if( $this->uri->segment( 5 ) == '' ) { ?>
                                        <a id="<?=$dev_plan['training_id']?>" title="Update" class="update_btn optlnk" href="#addModal" role="button" data-toggle="modal"><i class="icon-edit"></i></a>&nbsp;
                                        <a id="<?=$dev_plan['training_id']?>" title="Remove" class="del_btn optlnk" href="#deleteModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                                        <?php } ?>
                                    </td>
                                    <? } ?>

                                    <?php if( $this->session->userdata( 'lvl' ) == 3 ) { ?>
                                    <td>
                                        <a id="<?=$dev_plan['training_id']?>" title="View details" class="view_btn optlnk" href="#viewModal" role="button" data-toggle="modal"><i class="icon-zoom-in"></i></a>&nbsp;
                                        <?php if( $this->uri->segment( 2 ) == '' ) { ?>
                                        <a title="Accept" class="optlnk" href="javascript:void(0);" onclick="do_action( 'on_going', '<?=$dev_plan['training_id']?>' );"><i class="icon-chevron-right"></i></a>
                                        <?php } if( $this->uri->segment( 2 ) == 'on_going' ) { ?>
                                        <a title="Completed" class="optlnk" href="javascript:void(0);" onclick="do_action( 'completed', '<?=$dev_plan['training_id']?>' );"><i class="icon-ok"></i></a>
                                        <?php } ?>
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
                            <select id="trainings_add" name="training_id" class="span12 validate[required]">
                                <option value="">----------------</option>
                            </select>
                            <div id="details" style="display:none;">
                                <div class="clearfix"></div>
                                <label class="label label-info">Description</label>
                                <p id="desc" class="muted"></p>
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
                <?php } ?>

                <div class="modal hide fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="viewModalLabel">Training Details</h3>
                    </div>
                    <div class="modal-body">
                        <label class="label label-info">Trainings</label>
                        <div class="clearfix"></div>                       
                        <select id="trainings" name="training_id" class="span12" disabled>
                        </select>
                        <div id="details">
                            <div class="clearfix"></div>
                            <label class="label label-info">Description</label>
                            <p id="desc" class="muted"></p>
                            <div class="clearfix"></div>
                            <label class="label label-info">Included Skills</label>
                            <table class="table table-condensed" id="included_skills_v">
                                <tbody>
                                </tbody>
                            </table>
                            <div class="clearfix"></div>
                            <label class="label label-info">Included Abilities</label>
                            <table class="table table-condensed" id="included_abilities_v">
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
            function do_action( action, training ){
                $.post( '<?=base_url()?>my_trainings/ajax_request', { action : action, training : training }, function(data) {
                    window.location = '<?=isset($landing_page) ? $landing_page : base_url().uri_string() ?>';
                });
            }
            <? } ?>           
    
            $('.update_btn').click( function( ){
                var t_id = $(this).prop( 'id' );

                if( t_id != '' ){
                    $('#AddModalLabel').text( 'Update Training Detail' );
                    $('#trainings_add').val( t_id ).change();
                    $('#trainings_add').prop( 'disabled', true );
                    $('#frm_dev_plan').prop( 'action', '<?=$update_url?>' );
                    $('#frm_dev_plan input[name=t_id]').val( t_id );

                    $.each( json_dev_plans, function( i, l ) {
                        if( json_dev_plans[i].training_id === t_id ){
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
                var select      = $('#trainings');
                var select_add  = $('#trainings_add');
                $.each( json_trainings, function( i, l ) {
                    select.append( $('<option></option>').attr( 'value', json_trainings[i].training_id ).text( json_trainings[i].training_title ) );
                    select_add.append( $('<option></option>').attr( 'value', json_trainings[i].training_id ).text( json_trainings[i].training_title ) );
                });
            }

            $('#trainings_add').change( function( ){
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
                            $('p#desc').text( json_dev_plans[i].training_desc );

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

                            $( t_skill_result ).appendTo( "#included_skills_v tbody" );
                            $( t_ability_result ).appendTo( "#included_abilities_v tbody" );
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