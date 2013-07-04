<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript">
    $( document ).ready( function(){
        $( "#frm_acct" ).validationEngine();
        $( "#frm_contacts" ).validationEngine();
    });

</script>
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
                        <p><?=$this->session->userdata( 'fname' ) ? ucwords( $this->session->userdata( 'fname' ) ) : '' ?></p>
                        <label class="label label-info">Middle Name</label>
                        <p><?=$this->session->userdata( 'lname' ) ? ucwords( $this->session->userdata( 'lname' ) ) : '' ?></p>
                        <label class="label label-info">Last Name</label>
                        <p><?=$this->session->userdata( 'mname' ) ? ucwords( $this->session->userdata( 'mname' ) ) : '' ?></p>
                        <label class="label label-info">Birth Date</label>
                        <p><?=$this->session->userdata( 'birthday' ) ? $this->template_library->format_mysql_date( $this->session->userdata( 'birthday' ), 'F d, Y' ) : '' ?></p>
                        <label class="label label-info">Gender</label>
                        <p><?=$this->session->userdata( 'gender' ) ? $this->session->userdata( 'gender' ) : '' ?></p>
                        <label class="label label-info">T.I.N #</label>
                        <p><?=$this->session->userdata( 'tin_id' ) ? $this->session->userdata( 'tin_id' ) : 'N/A' ?></p>
                        <label class="label label-info">S.S.S. ID.</label>
                        <p><?=$this->session->userdata( 'sss_id' ) ? $this->session->userdata( 'sss_id' ) : 'N/A' ?></p>
                        <label class="label label-info">PAGIBIG ID.</label>
                        <p><?=$this->session->userdata( 'pagibig_id' ) ? $this->session->userdata( 'pagibig_id' ) : 'N/A' ?></p>
                        <label class="label label-info">PhilHealth ID.</label>
                        <p><?=$this->session->userdata( 'philhealth_id' ) ? $this->session->userdata( 'philhealth_id' ) : 'N/A' ?></p>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="block span6">
                    <div class="block-heading" data-target="#widget2container">
                        Contact Details
                    </div>
                    <div id="widget2container" class="block-body">
                        <form id="frm_contacts" action="<?=base_url()?>acct_setting/update_contact" method="POST">
                            <label class="label label-info">Email Address</label>
                            <div class="clearfix"></div>
                            <input type="text" name="email" id="email" class="span9 validate[required, custom[email]]" value="<?=$this->session->userdata( 'email' ) ? $this->session->userdata( 'email' ) : '' ?>">
                            <div class="clearfix"></div>
                            <label class="label label-info">Home Phone #</label>
                            <div class="clearfix"></div>
                            <input type="text" name="home_phone" id="home_phone" class="span9 validate[required, custom[number]]" value="<?=$this->session->userdata( 'home_phone' ) ? $this->session->userdata( 'home_phone' ) : '' ?>" >
                            <div class="clearfix"></div>
                            <label class="label label-info">Mobile Phone #</label>
                            <div class="clearfix"></div>
                            <input type="text" name="mobile_phone" id="mobile_phone" class="span9 validate[required, custom[number]]" value="<?=$this->session->userdata( 'mobile_phone' ) ? $this->session->userdata( 'mobile_phone' ) : '' ?>" >
                            <div class="clearfix"></div>
                            <label class="label label-info">Home Address</label>
                            <div class="clearfix"></div>
                            <textarea rows="5" class="span9 validate[required]" style="resize: none;" name="home_address" id="home_address"><?=$this->session->userdata( 'home_address' ) ? $this->session->userdata( 'home_address' ) : '' ?></textarea>
                            <div class="clearfix"></div>
                            <label class="label label-info">Emergency Contact Name</label>
                            <div class="clearfix"></div>
                            <input type="text" name="emergency_contact" id="emergency_contact" class="span9 validate[required, custom[onlyLetterSp]]" value="<?=$this->session->userdata( 'emergency_contact' ) ? ucwords( $this->session->userdata( 'emergency_contact' ) ) : '' ?>">
                            <div class="clearfix"></div>
                            <label class="label label-info">Emergency Contact #</label>
                            <div class="clearfix"></div>
                            <input type="text" name="emergency_phone" id="emergency_phone" class="span9 validate[required, custom[number]]" value="<?=$this->session->userdata( 'emergency_phone' ) ? $this->session->userdata( 'emergency_phone' ) : '' ?>">
                            <div class="clearfix"></div>
                            <button class="btn btn-primary" data-dismiss="modal" onclick="$('#frm_contacts').submit()">Update</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="block span6">
                    <div class="block-heading" data-target="#widget3container">
                        Employment Details
                    </div>
                    <div id="widget3container" class="block-body">
                        <label class="label label-info">Job Title</label>
                        <p><?=$this->session->userdata( 'job_title' ) ? ucwords( $this->session->userdata( 'job_title' ) ) : '' ?></p>
                        <label class="label label-info">Job Description</label>
                        <p><?=$this->session->userdata( 'job_desc' ) ? ucwords( $this->session->userdata( 'job_desc' ) ) : '' ?></p>
                        <label class="label label-info">Department</label>
                        <p><?=$this->session->userdata( 'dept_name' ) ? ucwords( $this->session->userdata( 'dept_name' ) ) : '' ?></p>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="block span6">
                    <div class="block-heading" data-target="#widget4container">
                        Account Details
                    </div>
                    <div id="widget4container" class="block-body">                        
                        <form id="frm_acct" action="<?=base_url()?>acct_setting/change_password" method="POST">
                            <label class="label label-info">Username</label>
                            <p><?=$this->session->userdata( 'uname' ) ? ucwords( $this->session->userdata( 'uname' ) ) : '' ?></p>
                            <label class="label label-info">Old Password</label>
                            <div class="clearfix"></div>
                            <input type="password" name="oldpword" id="oldpword" class="span9 text validate[required]">
                            <div class="clearfix"></div>
                            <label class="label label-info">New Password</label>
                            <div class="clearfix"></div>
                            <input type="password" name="newpword" id="newpword" class="span9 text validate[required, equals[repword]]">
                            <div class="clearfix"></div>
                            <label class="label label-info">Re-type Password</label>
                            <div class="clearfix"></div>
                            <input type="password" name="repword" id="repword" class="span9 text validate[required, equals[newpword]]">
                            <div class="clearfix"></div>
                            <button class="btn btn-primary" data-dismiss="modal" onclick="$('#frm_acct').submit()">Update</button>

                            <div class="clearfix"></div>
                        </form>                        
                    </div>
                </div>
            </div>
            <div class="row-fluid">
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
            </div>
            <div class="row-fluid">
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
                <div class="block span6">
                    <div class="block-heading" data-target="#widget8container">
                        Activities Info
                    </div>
                    <div id="widget8container" class="block-body">
                        <?php 
                            if( isset( $activities ) ){
                                if( count( $activities ) ){
                                    for ($a = 0; $a < count( $activities ); $a++) { 
                        ?>
                        <label class="label label-info"><?=$activities[ $a ]['activity_code']?> - <?=$activities[ $a ]['activity_name']?></label>
                        <p><?=$activities[ $a ]['activity_desc']?></p>
                        <?php
                                    }
                                }else{
                        ?>
                        <label class="label">No activities available</label>
                        <?php
                                }
                            }
                        ?>
                        <div class="clearfix"></div>                     
                    </div>
                </div>
            </div>
        </div>