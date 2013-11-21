<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <?php 
                echo $emp_menu;
                if( $this->session->flashdata( 'message' ) ): 
                    $msg = $this->session->flashdata( 'message' );
            ?>
                <div class="alert alert-<?=$msg['class']?>">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=$msg['str']?>
                </div>
            <?php 
                endif; 
                $no_image = base_url().IMG.'no-image.png';
                if( !empty( $user_detais->avatar ) )
                    $img_url = $this->template_library->check_image_exist( base_url().UPLOADS.$this->session->userdata( 'avatar' ), $no_image );
                else
                    $img_url = $no_image;
            ?>            
            <div class="row-fluid">           
                <div class="block span6">
                    <div class="block-heading" data-target="#widget1container">
                        Personal Details
                    </div>
                    <div id="widget1container" class="block-body">
                        <img src="<?=$img_url?>" width="120px" height="110px" style="float:right;">
                        <label class="label label-info">First Name</label>
                        <p><?=isset( $employee[ 'fname' ] ) ? ucwords( $employee[ 'fname' ] ) : '' ?></p>
                        <label class="label label-info">Middle Name</label>
                        <p><?=isset( $employee[ 'mname' ] ) ? ucwords( $employee[ 'mname' ] ) : '' ?></p>
                        <label class="label label-info">Last Name</label>
                        <p><?=isset( $employee[ 'lname' ] ) ? ucwords( $employee[ 'lname' ] ) : '' ?></p>
                        <label class="label label-info">Birth Date</label>
                        <p><?=isset( $employee[ 'birthday' ] ) ? $this->template_library->format_mysql_date( $employee[ 'birthday' ], 'F d, Y' ) : '' ?></p>
                        <label class="label label-info">Gender</label>
                        <p><?=isset( $employee[ 'gender' ] ) ? ucwords( $employee[ 'gender' ] ) : '' ?></p>
                        <label class="label label-info">T.I.N #</label>
                        <p><?=isset( $employee[ 'tin_id' ] ) && !empty( $employee[ 'tin_id' ] ) ? $employee[ 'tin_id' ] : 'N/A' ?></p>
                        <label class="label label-info">S.S.S. ID.</label>
                        <p><?=isset( $employee[ 'sss_id' ] ) && !empty( $employee[ 'sss_id' ] ) ? $employee[ 'sss_id' ] : 'N/A' ?></p>
                        <label class="label label-info">PAGIBIG ID.</label>
                        <p><?=isset( $employee[ 'pagibig_id' ] ) && !empty( $employee[ 'pagibig_id' ] ) ? $employee[ 'pagibig_id' ] : 'N/A' ?></p>
                        <label class="label label-info">PhilHealth ID.</label>
                        <p><?=isset( $employee[ 'philhealth_id' ] ) && !empty( $employee[ 'philhealth_id' ] ) ? $employee[ 'philhealth_id' ] : 'N/A' ?></p>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="block span6">
                    <div class="block-heading" data-target="#widget2container">
                        Contact Details
                    </div>
                    <div id="widget2container" class="block-body">
                        <label class="label label-info">Email Address</label>
                        <p><?=isset( $employee[ 'email' ] ) && !empty( $employee[ 'email' ] ) ? $employee[ 'email' ] : 'N/A' ?></p>
                        <label class="label label-info">Home Phone #</label>
                        <p><?=isset( $employee[ 'home_phone' ] ) && !empty( $employee[ 'home_phone' ] ) ? $employee[ 'home_phone' ] : 'N/A' ?></p>
                        <label class="label label-info">Mobile Phone #</label>
                        <p><?=isset( $employee[ 'mobile_phone' ] ) && !empty( $employee[ 'mobile_phone' ] ) ? $employee[ 'mobile_phone' ] : 'N/A' ?></p>
                        <label class="label label-info">Home Address</label>
                        <p><?=isset( $employee[ 'home_address' ] ) && !empty( $employee[ 'home_address' ] ) ? $employee[ 'home_address' ] : 'N/A' ?></p>
                        <label class="label label-info">Emergency Contact Name</label>
                        <p><?=isset( $employee[ 'emergency_contact' ] ) && !empty( $employee[ 'emergency_contact' ] ) ? $employee[ 'emergency_contact' ] : 'N/A' ?></p>
                        <label class="label label-info">Emergency Contact #</label>
                        <p><?=isset( $employee[ 'emergency_phone' ] ) && !empty( $employee[ 'emergency_phone' ] ) ? $employee[ 'emergency_phone' ] : 'N/A' ?></p>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="block span6">
                    <div class="block-heading" data-target="#widget8container">
                        Succession Planning
                    </div>
                    <div id="widget8container" class="block-body">
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

                            $potential = '<option value="">----------------</option>';
                            $timing = '<option value="">----------------</option>';
                            $risk = '<option value="">----------------</option>';
                            $reason = '<option value="">----------------</option>';
                            foreach ($succ_cat as $sc) {
                                switch ($sc['type']) {
                                    case 'potential':
                                        if( @$succ_plan[0]['potential'] == $sc['id'] )
                                            $selected = 'selected="true"';
                                        else
                                            $selected = '';

                                        $potential .= '<option value="'.$sc['id'].'" '.$selected.'>'.$sc['desc'].'</option>';
                                        break;
                                    
                                    case 'timing':
                                        if( @$succ_plan[0]['timing'] == $sc['id'] )
                                            $selected = 'selected="true"';
                                        else
                                            $selected = '';

                                        $timing .= '<option value="'.$sc['id'].'" '.$selected.'>'.$sc['desc'].'</option>';
                                        break;
                                    
                                    case 'risk':
                                        if( @$succ_plan[0]['risk_of_leaving'] == $sc['id'] )
                                            $selected = 'selected="true"';
                                        else
                                            $selected = '';

                                        $risk .= '<option value="'.$sc['id'].'" '.$selected.'>'.$sc['desc'].'</option>';
                                        break;
                                    
                                    case 'reason':
                                        if( @$succ_plan[0]['reason_for_leaving'] == $sc['id'] )
                                            $selected = 'selected="true"';
                                        else
                                            $selected = '';

                                        $reason .= '<option value="'.$sc['id'].'" '.$selected.'>'.$sc['desc'].'</option>';
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }
                            }
                        ?>
                        <form id="succ_plan" action="" method="POST" onsubmit="return:false;">
                            <label class="label label-info">Potential for promotion:</label>
                            <p>
                                <select name="potential" class="span12 validate[required]">
                                    <?=$potential?>
                                </select>
                            </p>
                            <label class="label label-info">Timing of next promotion:</label>
                            <p>
                                <select name="timing" class="span12 validate[required]">
                                    <?=$timing?>
                                </select>
                            </p>
                            <label class="label label-info">Risk of leaving:</label>
                            <p>
                                <select name="risk_of_leaving" class="span12 validate[required]">
                                    <?=$risk?>
                                </select>
                            </p>
                            <label class="label label-info">Reason for leaving:</label>
                            <p>
                                <select name="reason_for_leaving" class="span12 validate[required]">
                                    <?=$reason?>
                                </select>
                            </p>

                            <div class="pull-right">
                                <button class="btn btn-small btn-primary" type="submit">Save</button>
                            </div>
                        </form>
                        <script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
                        <script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
                        <script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
                        <script type="text/javascript">
                            $( document ).ready( function(){
                                $( "#succ_plan" ).validationEngine();
                            });
                        </script>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="block span6">
                    <div class="block-heading" data-target="#widget5container">
                        Skills Info
                    </div>
                    <div id="widget5container" class="block-body">
                        <?php 
                            if( isset( $skills ) ){
                                if( count( $skills ) ){
                                    for ($s = 0; $s < count( $skills ); $s++) { 
                        ?>
                        <label class="label label-info"><?=$skills[ $s ]['skill_code']?> - <?=$skills[ $s ]['skill_name']?></label>
                        <p><?=$skills[ $s ]['skill_desc']?></p>
                        <?php
                                    }
                                }else{
                        ?>
                        <label class="label">No skills available</label>
                        <?php
                                }
                            }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>                
            </div>
            <div class="row-fluid">
                <div class="block span6">
                    <div class="block-heading" data-target="#widget6container">
                        Abilities Info
                    </div>
                    <div id="widget6container" class="block-body">
                        <?php 
                            if( isset( $abilities ) ){
                                if( count( $abilities ) ){
                                    for ($a = 0; $a < count( $abilities ); $a++) { 
                        ?>
                        <label class="label label-info"><?=$abilities[ $a ]['ability_code']?> - <?=$abilities[ $a ]['ability_name']?></label>
                        <p><?=$abilities[ $a ]['ability_desc']?></p>
                        <?php
                                    }
                                }else{
                        ?>
                        <label class="label">No abilities available</label>
                        <?php
                                }
                            }
                        ?>
                        <div class="clearfix"></div>                
                    </div>
                </div>
                <div class="block span6">
                    <div class="block-heading" data-target="#widget7container">
                        Duties &amp; Responsibilities Info
                    </div>
                    <div id="widget7container" class="block-body">
                        <?php 
                            if( isset( $duties ) ){
                                if( count( $duties ) ){
                                    for ($d = 0; $d < count( $duties ); $d++) { 
                        ?>
                        <label class="label label-info"><?=$duties[ $d ]['duty_code']?> - <?=$duties[ $d ]['duty_name']?></label>
                        <p><?=$duties[ $d ]['duty_desc']?></p>
                        <?php
                                    }
                                }else{
                        ?>
                        <label class="label">No duties &amp; responsible available</label>
                        <?php
                                }
                            }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>