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
                            <input type = "hidden" name = "step" value = "<?=isset($step) ? $step : '1' ?>">
                            <input type = "hidden" name = "module" value = "<?=isset($cat['main_category_id']) ? $cat['main_category_id'] : 'title' ?>">

                            <?php if( $step == 1 ) { ?>
                            <div class="element">
                                <label for="appraisal_title">Title <span class="red">(required)</span></label>
                                <input id="appraisal_title" name="appraisal_title" class="span9 text validate[required]" value="<?=isset( $appraisal[0]['appraisal_title'] ) ? $appraisal[0]['appraisal_title'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="appraisal_desc">Description <span class="red">(required)</span></label>
                                <textarea id="appraisal_desc" name="appraisal_desc" row="10" class="span9 text validate[required]" style="resize:none;"/><?=isset( $appraisal[0]['appraisal_desc'] ) ? $appraisal[0]['appraisal_desc'] : '' ?></textarea>
                            </div>
                            <?php } ?>

                            <?php 
                                if( $step > 1 ) {
                            ?>
                                    <h3>Step <?=$step?>: <?=$cat['main_category_name']?></h3>
                            <?php
                                    $sub_cat = $this->appraisal_model->getAppraisalSubCategories( array( 'main_cat_id' => $cat['main_category_id'] ) );
                                    if( count( $sub_cat ) > 0 ) {
                            ?>
                                        <div class="row-fluid">
                            <?php
                                        foreach ($sub_cat as $sub) {
                                            if( preg_match('/update/', current_url()) ){
                                                $questions = $this->appraisal_model->getAppraisalQuestion(
                                                                                                             $this->uri->segment(3)
                                                                                                            ,$cat['main_category_id']
                                                                                                            ,$sub['sub_category_id']
                                                                                                        );
                                            }
                                            $sub_input_name = 'question_'. $cat['main_category_id'] .'_'. $sub['sub_category_id'];
                            ?>
                                            <div class="block span6">
                                                <div class="block-heading" data-target="#widget2container">
                                                    <?=ucwords( $sub['sub_category_name'] )?>
                                                </div>
                                                <div id="widget2container" class="block-body">
                                                    <div id="<?=$sub_input_name?>">
                                                        <?php if( !isset( $questions ) || count( $questions ) == 0 ){ ?>
                                                        <div class="q_box">
                                                            <textarea name="<?=$sub_input_name?>[]" class="span9 questions validate[groupRequired[core_v]]" style="resize:none;width: 100%;"></textarea>
                                                        </div>
                                                        <?php 
                                                            } else { 
                                                                for ( $c = 0; $c < count( $questions ); $c++ ) {
                                                        ?>
                                                        <div class="q_box">
                                                            <?php if( $c > 0 ) { ?> <span title="Delete" class="pull-right"><i class="icon-remove-sign"></i></span> <? } ?>
                                                            <textarea name="<?=$sub_input_name?>[]" class="span9 questions validate[groupRequired[core_v]]" style="resize:none;width: 100%;"><?=$questions[ $c ]['question']?></textarea>
                                                        </div>
                                                        <?php 
                                                                }
                                                            } 
                                                        ?>
                                                        <a href="javascript:void(0)" class="btn btn-mini btn-primary" onclick="addQuestion( '<?=$sub_input_name?>' );"><i class="icon-plus-sign"></i> Add more</a> 
                                                    </div>
                                                </div>
                                            </div>
                            <?php
                                        }
                            ?>
                                         </div>
                            <?php
                                    } else {
                            ?>
                                        <div class="alert alert-block">
                                            <h4>Notice!</h4>
                                            There's no sub category for <strong><?=$cat['main_category_name']?></strong>.
                                            <p>
                                                <a href="<?=base_url()?>appraisal/categories" target="_blank">Manage your sub category here</a>
                                            </p>
                                        </div>
                            <?php
                                    }
                                } 
                            ?>
                            <div class="modal-footer">
                                <div class="pull-right">
                                    <button class="btn btn-mini btn-primary" type="button" onclick="cancel();">
                                        <i class="icon-trash"></i> Cancel
                                    </button>
                                    <button class="btn btn-mini btn-primary">
                                        Next <i class="icon-arrow-right"></i>
                                    </button>
                                </div>
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
            var txt_htm = '<div class="q_box"><div class="input_box_header"><span title="Delete" class="pull-right"><i class="icon-remove-sign"></i></span></div><textarea name="'+e_name+'[]" class="span9 questions validate[groupRequired['+e_name+']]" style="resize:none;width: 100%;"></textarea></div>';
            var e_index = $("#" +e_name+ " .q_box").length;

            $( txt_htm ).insertAfter( "#"+e_name+" .q_box:nth-child("+e_index+")" );

            $('#'+ e_name +' .q_box span').live('click',function() {
                var index = $(this).index(this) + 1;
                
                $("#"+ e_name +" .q_box").eq( index ).remove();
            });
        }

        function cancel() {
            var ans = confirm('Are you sure you want to cancel?');

            if( ans )
                window.location='<?=base_url()?>appraisal';
        }
    </script>