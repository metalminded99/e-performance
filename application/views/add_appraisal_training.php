<style type="text/css">
    .form-container:hover {
        background: #F0F0F0;
    }

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
                            <div class="element">
                                <label for="appraisal_title">Training <span class="red">(required)</span></label>
                                <select name="training" id="training" class="span9 validate[required]">
                                    <option value=""></option>
                                    <?php 
                                        if( count($trainings) > 0 ){
                                            foreach ($trainings as $training) {
                                    ?>
                                    <option value="<?=$training['training_id']?>"><?=$training['training_title']?></option>
                                    <?php
                                            }
                                        } 
                                    ?>
                                </select>
                            </div>
                            <div class="element">
                                <label for="appraisal_title">Title <span class="red">(required)</span></label>
                                <input id="appraisal_title" name="appraisal_title" class="span9 validate[required]" value="<?=isset( $appraisal[0]['appraisal_title'] ) ? $appraisal[0]['appraisal_title'] : '' ?>">
                            </div>
                            <div class="element">
                                <label for="appraisal_desc">Description <span class="red">(required)</span></label>
                                <textarea id="appraisal_desc" name="appraisal_desc" row="10" class="span9 text validate[required]" style="resize:none;"/><?=isset( $appraisal[0]['appraisal_desc'] ) ? $appraisal[0]['appraisal_desc'] : '' ?></textarea>
                            </div>

                            <div id="container">
                                <button class="btn btn-small btn-primary" type="button" onclick="addMainCategory();"><i class="icon-plus-sign"></i> Add Main Category</button>
                                <br/>
                                <div id="1" class="form-container">
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
                                                <a href="javascript:void(0)" onclick="addSubCategory($(this).parent().parent().parent().parent().attr('id'));" class="btn optlnk" title="Add sub category"><i class="icon-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sc-container" id="1_1">
                                        <div class="sc-form">
                                            <label style="font-weight">Sub Category</label>
                                            <input type="text" name="sub_c_1_1[]" class="span7 sc-input validate[required]">
                                            <div class="sc-controls">
                                                <a href="javascript:void(0)" onclick="addQuestion( $(this) );" class="btn optlnk" title="Add question"><i class="icon-plus-sign"></i></a>
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
                            <div class="modal-footer">
                                <div class="pull-right">
                                    <button class="btn btn-mini btn-primary" type="button" onclick="cancel();">
                                        <i class="icon-trash"></i> Cancel
                                    </button>
                                    <button class="btn btn-mini btn-primary">
                                        <i class="icon-hdd"></i> Save
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
q_parent
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

            $('#frm_appraisal').on('submit', function(e){
                e.preventDefault();
                var ans = confirm( 'Save changes?' );

                if( ans )
                    return;
            });
        });

        function addMainCategory( ){
            var sq_index = $( ".form-container" ).length + 1;
            var sc_htm = '<div id="'+sq_index+'" class="form-container"><hr><div class="mc-container"><div class="mc-form"><label style="font-weight">Main Category</label><input type="text" name="training_mc[]" class="span6 mc-input validate[required]">&nbsp;<select name="percentage[]" style="width:77px;" class="validate[required]"><option value="">------</option><?php $perc = range(5, 100, 5);for( $i = 0; $i < count( $perc ); $i++ ){?><option value="<?=$perc[$i]?>"><?=$perc[$i]?>%</option><?php } ?></select><div class="mc-controls"><a href="javascript:void(0)" onclick="addSubCategory($(this).parent().parent().parent().parent().attr(\'id\'));" class="btn optlnk" title="Add sub category"><i class="icon-plus"></i></a> &nbsp; <a href="javascript:void(0)" onclick="removeMain( $(this).parent().parent().parent().parent().index() );" class="btn optlnk" title="Remove"><i class="icon-trash"></i></a></div></div></div><div class="sc-container" id="'+sq_index+'_1"><div class="sc-form"><label style="font-weight">Sub Category</label><input type="text" name="sub_c_'+sq_index+'_1[]" class="span7 sc-input validate[required]"><div class="sc-controls"><a href="javascript:void(0)" onclick="addQuestion( $(this) );" class="btn optlnk" title="Add question"><i class="icon-plus-sign"></i></a></div></div><div class="q-container"><label style="font-weight">Questions</label><div class="q-form"><div class="question"><textarea name="quest_'+sq_index+'_1[]" class="span8 q-input validate[required]"></textarea><div class="q-controls">&nbsp;</div></div></div></div></div></div>';

            $( sc_htm ).hide().insertAfter( ".form-container:last" ).fadeIn("slow");
            $('.optlnk').tooltip();
        }

        function addSubCategory( parent ){
            var s_index = $('#'+parent+' .sc-container').length + 1;
            var sc_htm = '<div class="sc-container" id="'+parent+'_'+s_index+'"><div class="sc-form"><label style="font-weight">Sub Category</label><input type="text" name="sub_c_'+parent+'_'+s_index+'[]" class="span7 sc-input validate[required]"><div class="sc-controls"><a href="javascript:void(0)" onclick="addQuestion( $(this) );" class="btn optlnk" title="Add question"><i class="icon-plus-sign"></i></a> &nbsp; <a href="javascript:void(0)" onclick="removeSub( $(this).parent().parent().parent().index() );" class="btn optlnk" title="Remove"><i class="icon-trash"></i></a></div></div><div class="q-container"><label style="font-weight">Questions</label><div class="q-form"><div class="question"><textarea name="quest_'+parent+'_'+s_index+'[]" class="span8 q-input validate[required]"></textarea><div class="q-controls">&nbsp;</div></div></div></div></div>';

            $( sc_htm ).hide().insertAfter( "#"+parent+" .sc-container:last" ).fadeIn("slow");
            $('.optlnk').tooltip();
        }

        function addQuestion( src ){
            var p_id     = src.parent().parent().parent().parent().attr('id');
            var sc_id    = src.parent().parent().parent().attr('id');
            var _sc      = sc_id.split('_');
            var s_id     = parseInt(_sc.splice(1));

            var q_htm = '<div class="question"><textarea name="quest_'+p_id+'_'+s_id+'[]" class="span8 q-input validate[required]"></textarea><div class="q-controls"><a title="Remove" class="optlnk" href="javascript:void(0);" role="button" onclick="remove_quest( '+sc_id+', $(this).index() );"><i class="icon-remove-sign"></i></a></div></div>';

            $( q_htm ).hide().insertAfter( "#"+sc_id+" .q-container .q-form .question:last" ).fadeIn("slow");

            $('.optlnk').tooltip();
        }

        function remove_quest( parent, q_index ){
            var ans = confirm('Delete this question?');
            if( ans )
                $('#'+parent+' .q-container .q-form .question:eq('+q_index+')').fadeOut("slow").remove();
        }

        function removeSub(index) {
            index--;
            var ans = confirm('Deleting sub category will also delete the question under it. Proceed?');
            if( ans ){
                $('.sc-container:eq('+index+')').fadeOut("slow").remove();
            }
        }

        function removeMain(index) {
            index -= 2;

            var ans = confirm('Deleting main category will also delete the sub category and question under it. Proceed?');
            if( ans ){
                $('.form-container:eq('+index+')').fadeOut("slow").remove();
            }
        }

        function cancel() {
            var ans = confirm('Are you sure you want to cancel?');

            if( ans )
                window.location='<?=base_url()?>appraisal';
        }
    </script>