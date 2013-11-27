<style type="text/css">
    .mc-controls{
        position: relative;
        top: -41px;
        width: 120px;
        height: 5px;
        left: 63%;
    }

    .sc-controls{
        position: relative;
        top: -41px;
        width: 120px;
        height: 5px;
        left: 63%;
    }

    .q-controls{
        position: relative;
        top: -97px;
        width: 12px;
        height: 10px;
        left: 64.7%;
    }

    .q-input{
        height:70px;
        resize:none;
    }
</style>
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

                            <?php if( $step == 1 ) { ?>
                            <div class="element">
                                <label for="appraisal_title">Title <span class="red">(required)</span></label>
                                <input id="appraisal_title" name="appraisal_title" class="span9 text validate[required]" value="<?=isset( $appraisal[0]['appraisal_title'] ) ? $appraisal[0]['appraisal_title'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="appraisal_desc">Description <span class="red">(required)</span></label>
                                <textarea id="appraisal_desc" name="appraisal_desc" row="10" class="span9 text validate[required]" style="resize:none;"/><?=isset( $appraisal[0]['appraisal_desc'] ) ? $appraisal[0]['appraisal_desc'] : '' ?></textarea>
                            </div>
                            <?php 
                                } 
                                
                                if( $step > 1 ) {
                            ?>
                            <h3>
                                Step <?=$step?>: Creating questions
                            </h3>
                            <!-- <div class="btn-toolbar">
                                <a href="javascript:void(0);" onclick="addSubCategory();" class="btn btn-primary btn-small">
                                    <i class="icon-plus"></i> Add Sub Category
                                </a>
                                <div class="btn-group"></div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <th>Sub Category</th>
                                    <th>Questions</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php 
                                        if( count( @$subs ) > 0 ){ 
                                            $old = '';
                                            $cnt = 0;
                                            foreach ($subs as $sub) {
                                    ?>
                                    <tr>
                                        <?php if( $old != $sub['sub_category_name'] ) { $cnt++; ?>
                                        <td class="sub_row">
                                            <input type="text" value="<?=$sub['sub_category_name']?>" class="sub_cat validate[required]" name="_sub_<?=$sub['sub_category_id']?>[]"/>
                                        </td>                                        
                                        <?php } else { ?>
                                        <td></td>
                                        <?php } ?>
                                        <td>
                                            <textarea name="_sub_<?=$sub['sub_category_id']?>_question_[]" style="resize:none;width: 350px;height: 40px;" class="validate[groupRequired[sub_<?=$sub['sub_category_id']?>_question_]]"><?=$sub['question']?></textarea>
                                        </td>
                                        <?php if( $old != $sub['sub_category_name'] ) { ?>
                                        <td>
                                            <?php if( $cnt > 1 ) { ?>
                                            <a title="Add question" class="optlnk" href="javascript:void(0);" role="button" onclick="addQuestion('_sub_<?=$sub['sub_category_id']?>_question_',$(this).parent().parent().index());"><i class="icon-plus-sign"></i></a>&nbsp;

                                            <a title="Remove" class="optlnk" href="javascript:void(0);" role="button" onclick="remove_quest($(this).parent().parent().index(), 1);"><i class="icon-remove"></i></a>
                                            <?php } else { ?>
                                            <a title="Add question" class="optlnk" href="javascript:void(0);" role="button" onclick="addQuestion('_sub_<?=$sub['sub_category_id']?>_question_',$(this).parent().parent().index());"><i class="icon-plus-sign"></i></a>
                                            <?php } ?>
                                        </td>
                                        <?php } else { ?>
                                        <td>
                                            <a title="Remove" class="optlnk" href="javascript:void(0);" role="button" onclick="remove_quest($(this).parent().parent().index(), 0);"><i class="icon-remove-sign"></i></a>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php $old = $sub['sub_category_name']; } } else { ?>
                                    <tr>
                                        <td class="sub_row">
                                            <input type="text" value="" class="sub_cat validate[required]" name="_sub_1_[]" placeholder="New Sub Category"/>
                                        </td>
                                        <td>
                                            <textarea name="_sub_1_question_[]" style="resize:none;width: 350px;height: 40px;" class="validate[groupRequired[sub_1_question_]]"></textarea>
                                        </td>
                                        <td>
                                            <a title="Add question" class="optlnk" href="javascript:void(0);" role="button" onclick="addQuestion('_sub_1_question_',$(this).parent().parent().index());"><i class="icon-plus-sign"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table> -->

                            <div id="container">
                                <button class="btn btn-small btn-primary" type="button" onclick="addMainCategory();"><i class="icon-plus-sign"></i> Add Main Category</button>
                                <br/>
                                <div class="form-container">
                                    <div class="mc-container">
                                        <div class="mc-form">
                                            <label style="font-weight">Main Category</label>
                                            <input type="text" name="training_mc[]" class="span6 mc-input validate[required]">
                                            &nbsp;
                                            <select name="percentage[]" style="width:77px;" class="validate[required]">
                                                <option value="">------</option>
                                                <?php
                                                    $perc = range(5, 100, 5);

                                                    for( $i = 0; $i < count( $perc ); $i++ ){
                                                ?>
                                                <option value="<?=$perc[$i]?>"><?=$perc[$i]?>%</option>
                                                <?php } ?>
                                            </select>
                                            <div class="mc-controls">
                                                <a href="javascript:void(0)" onclick="addSubCategory($(this).parent().parent().parent().parent().index());" class="btn optlnk" title="Add sub category"><i class="icon-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sc-container">
                                        <div class="sc-form">
                                            <label style="font-weight">Sub Category</label>
                                            <input type="text" name="sub_c_1_1[]" class="span7 sc-input validate[required]">
                                            <div class="sc-controls">
                                                <a href="javascript:void(0)" onclick="addQuestion($(this).parent().parent().parent().parent().index(), $(this).parent().parent().parent().index());" class="btn optlnk" title="Add question"><i class="icon-plus-sign"></i></a>
                                            </div>
                                        </div>
                                        <div class="q-container">
                                            <label style="font-weight">Questions</label>
                                            <div class="q-form">
                                                <div class="question">
                                                    <textarea name="quest_1_1[]" class="span8 q-input validate[required]"></textarea>
                                                    <div class="q-controls">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
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
            
            $('.optlnk').tooltip();

            $('.slider').slider({
                 min            : 0
                ,max            : 100
                ,orientation    : 'horizontal'
                ,step           : 5
            });

            $( "#tabs" ).tabs();

            $('.cancel').bind('click', function(e) {
                var ans = confirm( 'Are you sure you want to quit?' );
                
                if( ans ){
                    window.location = "<?=base_url()?>appraisal";
                }

                return false;
            });

            $('.sub_cat').focus();
        });

        function addMainCategory( ){
            var sq_index = $( ".form-container:last .sc-container:last" ).index() + 1;
            var sc_htm = '<div class="form-container"><hr><div class="mc-container"><div class="mc-form"><label style="font-weight">Main Category</label><input type="text" name="training_mc[]" class="span6 mc-input validate[required]">&nbsp;<select name="percentage[]" style="width:77px;" class="validate[required]"><option value="">------</option><?php $perc = range(5, 100, 5);for( $i = 0; $i < count( $perc ); $i++ ){?><option value="<?=$perc[$i]?>"><?=$perc[$i]?>%</option><?php } ?></select><div class="mc-controls"><a href="javascript:void(0)" onclick="addSubCategory($(this).parent().parent().parent().parent().index());" class="btn optlnk" title="Add sub category"><i class="icon-plus"></i></a> &nbsp; <a href="javascript:void(0)" onclick="removeMain( $(this).parent().parent().parent().parent().index() );" class="btn optlnk" title="Remove"><i class="icon-trash"></i></a></div></div></div><div class="sc-container"><div class="sc-form"><label style="font-weight">Sub Category</label><input type="text" name="sub_c_'+sq_index+'_1[]" class="span7 sc-input validate[required]"><div class="sc-controls"><a href="javascript:void(0)" onclick="addQuestion($(this).parent().parent().parent().parent().index(), $(this).parent().parent().parent().index());" class="btn optlnk" title="Add question"><i class="icon-plus-sign"></i></a></div></div><div class="q-container"><label style="font-weight">Questions</label><div class="q-form"><div class="question"><textarea name="quest_'+sq_index+'_1[]" class="span8 q-input validate[required]"></textarea><div class="q-controls">&nbsp;</div></div></div></div></div></div>';

            $( sc_htm ).insertAfter( ".form-container:last" );
            $('.optlnk').tooltip();
        }

        function addSubCategory( parent ){
            parent -= 2;
            var sq_index = $( ".form-container:eq("+parent+") .sc-container:last" ).index();
            var s_index = $('.form-container:eq('+parent+') .sc-container').length + 1;
            var sc_htm = '<div class="sc-container"><div class="sc-form"><label style="font-weight">Sub Category</label><input type="text" name="sub_c_'+sq_index+'_'+s_index+'[]" class="span7 sc-input validate[required]"><div class="sc-controls"><a href="javascript:void(0)" onclick="addQuestion($(this).parent().parent().parent().parent().index(), $(this).parent().parent().parent().index());" class="btn optlnk" title="Add question"><i class="icon-plus-sign"></i></a> &nbsp; <a href="javascript:void(0)" onclick="removeSub( $(this).parent().parent().parent().index() );" class="btn optlnk" title="Remove"><i class="icon-trash"></i></a></div></div><div class="q-container"><label style="font-weight">Questions</label><div class="q-form"><div class="question"><textarea name="quest_'+sq_index+'_'+s_index+'[]" class="span8 q-input validate[required]"></textarea><div class="q-controls">&nbsp;</div></div></div></div></div>';

            $( sc_htm ).insertAfter( ".form-container:eq("+parent+") .sc-container:last" );
            $('.optlnk').tooltip();
        }

        function addQuestion(parent, q_parent){
            parent -= 2;
            if( parent > 0 )
                q_parent -= 2;
            else
                q_parent--;
            var sq_index = $( ".form-container:eq("+parent+") .sc-container:last" ).index();
            var s_index = $('.form-container:eq('+parent+') .sc-container').length;
            var q_htm = '<div class="question"><textarea name="quest_'+sq_index+'_'+s_index+'[]" class="span8 q-input validate[required]"></textarea><div class="q-controls"><a title="Remove" class="optlnk" href="javascript:void(0);" role="button" onclick="remove_quest( $(this).parent().parent().parent().parent().parent().index(), $(this).index() );"><i class="icon-remove-sign"></i></a></div></div>';

            $( q_htm ).insertAfter( ".form-container:eq("+parent+") .q-form:eq("+q_parent+") .question:last" );

            $('.optlnk').tooltip();
        }

        function remove_quest( parent, q_index ){
            parent--;
            q_index++;
            
            var ans = confirm('Delete this question?');
            if( ans )
                $('.sc-container:eq('+parent+') .q-container .q-form .question:eq('+q_index+')').remove();
        }

        function removeSub(index) {
            index--;
            var ans = confirm('Deleting sub category will also delete the question under it. Proceed?');
            if( ans ){
                $('.sc-container:eq('+index+')').remove();
            }
        }

        function removeMain(index) {
            index -= 2;

            var ans = confirm('Deleting main category will also delete the sub category and question under it. Proceed?');
            if( ans ){
                $('.form-container:eq('+index+')').remove();
            }
        }

        function cancel() {
            var ans = confirm('Are you sure you want to cancel?');

            if( ans )
                window.location='<?=base_url()?>appraisal';
        }
    </script>