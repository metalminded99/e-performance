<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        <div class="span9">
            <div class="row-fluid">
                <div class="block span12">
                    <div class="block-heading" data-target="#widget2container">
                        <?=$action?>
                    </div>
                    <div id="widget2container" class="block-body">
                        <form id="frm_appraisal" action="" method="POST">
                            <input type = "hidden" name = "job_id" value = "<?=$this->session->userdata( 'job_id' )?>">
                            <div class="element">
                                <label for="appraisal_title">Title <span class="red">(required)</span></label>
                                <input id="appraisal_title" name="appraisal_title" class="span9 text validate[required]" value="<?=isset( $appraisal[0]['appraisal_title'] ) ? $appraisal[0]['appraisal_title'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="appraisal_desc">Description <span class="red">(required)</span></label>
                                <textarea id="appraisal_desc" name="appraisal_desc" row="10" class="span9 text validate[required]" style="resize:none;"/><?=isset( $appraisal[0]['appraisal_desc'] ) ? $appraisal[0]['appraisal_desc'] : '' ?></textarea>
                            </div>
                            <div class="element">
                                <div id="tabs">
                                    <ul style="margin-left:0;">
                                        <li><a href="#core">Core Competencies</a></li>
                                        <li><a href="#perf">Performance Output</a></li>
                                        <li><a href="#skills">Skills</a></li>
                                        <li><a href="#abl">Abilities</a></li>
                                    </ul>
                                    <div id="core">
                                        <?php if( !isset( $core ) || count( $core ) == 0 ){ ?>
                                        <div class="q_box">
                                            <textarea name="core[]" class="span9 questions validate[groupRequired[core_v]]" style="resize:none;width: 80%;"></textarea>
                                        </div>
                                        <?php 
                                            } else { 
                                                for ( $c = 0; $c < count( $core ); $c++ ) {
                                        ?>
                                        <div class="q_box">
                                            <?php if( $c > 0 ) { ?> <div class="input_box_header"><span title="Delete" >X</span></div> <? } ?>
                                            <textarea name="core[]" class="span9 questions validate[groupRequired[core_v]]" style="resize:none;width: 80%;"><?=$core[ $c ]['question']?></textarea>
                                        </div>
                                        <?php 
                                                }
                                            } 
                                        ?>
                                        <a href="javascript:void(0)" style="color:#12c; font-size:15px;" onclick="addQuestion( 'core' );">Add more</a> 
                                    </div>
                                    <div id="perf">
                                        <?php if( !isset( $perf ) ||  count( $perf ) == 0 ){ ?>
                                        <div class="q_box">
                                            <textarea name="perf[]" class="span9 questions validate[groupRequired[perf_v]]" style="resize:none;width: 80%;"></textarea>
                                        </div>
                                        <?php 
                                            } else { 
                                                for ( $f = 0; $f < count( $perf ); $f++ ) {
                                        ?>
                                        <div class="q_box">
                                            <?php if( $f > 0 ) { ?> <div class="input_box_header"><span title="Delete" >X</span></div> <? } ?>
                                            <textarea name="perf[]" class="span9 questions validate[groupRequired[perf_v]]" style="resize:none;width: 80%;"><?=$perf[ $f ]['question']?></textarea>
                                        </div>
                                        <?php 
                                                }
                                            } 
                                        ?>
                                        <a href="javascript:void(0)" style="color:#12c; font-size:15px;" onclick="addQuestion( 'perf' );">Add more</a> 
                                    </div>
                                    <div id="skills">
                                        <?php if( !isset( $skills ) ||  count( $skills ) == 0 ){ ?>
                                        <div class="q_box">
                                            <textarea name="skills[]" class="span9 questions validate[groupRequired[skills_v]]" style="resize:none;width: 80%;"></textarea>
                                        </div>
                                        <?php 
                                            } else { 
                                                for ( $s = 0; $s < count( $skills ); $s++ ) {
                                        ?>
                                        <div class="q_box">
                                            <?php if( $s > 0 ) { ?> <div class="input_box_header"><span title="Delete" >X</span></div> <? } ?>
                                            <textarea name="skills[]" class="span9 questions validate[groupRequired[skills_v]]" style="resize:none;width: 80%;"><?=$skills[ $s ]['question']?></textarea>
                                        </div>
                                        <?php 
                                                }
                                            } 
                                        ?>
                                        <a href="javascript:void(0)" style="color:#12c; font-size:15px;" onclick="addQuestion( 'skills' );">Add more</a> 
                                    </div>
                                    <div id="abl">
                                        <?php if( !isset( $abl ) ||  count( $abl ) == 0 ){ ?>
                                        <div class="q_box">
                                            <textarea name="abl[]" class="span9 questions validate[groupRequired[abl_v]]" style="resize:none;width: 80%;"></textarea>
                                        </div>
                                        <?php 
                                            } else { 
                                                for ( $s = 0; $s < count( $abl ); $s++ ) {
                                        ?>
                                        <div class="q_box">
                                            <?php if( $s > 0 ) { ?> <div class="input_box_header"><span title="Delete" >X</span></div> <? } ?>
                                            <textarea name="abl[]" class="span9 questions validate[groupRequired[abl_v]]" style="resize:none;width: 80%;"><?=$abl[ $s ]['question']?></textarea>
                                        </div>
                                        <?php 
                                                }
                                            } 
                                        ?>
                                        <a href="javascript:void(0)" style="color:#12c; font-size:15px;" onclick="addQuestion( 'abl' );">Add more</a> 
                                    </div>
                                </div>
                            </div>                            

                            <div class="modal-footer">
                                <button type="button" class="btn cancel" data-dismiss="modal" aria-hidden="true">Cancel</button>
                                <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="">Save</button>
                            </div>

                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
    <script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
    <script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
    <script type="text/javascript">
        $( document ).ready( function(){
            $( "#frm_appraisal" ).validationEngine();

            $( "#tabs" ).tabs();

            $('.cancel').bind('click', function(e) {
                var ans = confirm( 'Are you sure you want to quit?' );
                
                if( ans ){
                    window.location = "<?=base_url()?>appraisal";
                }

                return false;
            });
        });

        function addQuestion( e_name ){
            var txt_htm = '<div class="q_box"><div class="input_box_header"><span title="Delete" >X</span></div><textarea name="'+e_name+'[]" class="span9 questions validate[groupRequired['+e_name+']]" style="resize:none;width: 80%;"></textarea></div>';
            var e_index = $("#" +e_name+ " .q_box").length;

            $( txt_htm ).insertAfter( "#"+e_name+" .q_box:nth-child("+e_index+")" );
        }

        $('#core .q_box span').live('click',function( e ) {
            var index = $('#core .q_box span').index(this) + 1;
            
            $("#core .q_box").eq( index ).remove();
        });

        $('#perf .q_box span').live('click',function(e){
            var index = $('#perf .q_box span').index(this) + 1;
            
            $("#perf .q_box").eq( index ).remove();
        });

        $('#skills .q_box span').live('click',function(e){
            var index = $('#skills .q_box span').index(this) + 1;
            
            $("#skills .q_box").eq( index ).remove();
        });

        $('#abl .q_box span').live('click',function(e){
            var index = $('#abl .q_box span').index(this) + 1;
            
            $("#abl .q_box").eq( index ).remove();
        });
    </script>