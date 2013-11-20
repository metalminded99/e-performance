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
                            <?php 
                                } 
                                
                                if( $step > 1 ) {
                                    $main_cat = strtolower( str_replace(' ', '_', $cat['main_category_name'] ) );
                            ?>
                            <h3>Step <?=$step?>: <?=$cat['main_category_name']?></h3>
                            <div class="btn-toolbar">
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
                                            <input type="text" value="<?=$sub['sub_category_name']?>" class="sub_cat validate[required]" name="<?=$main_cat?>_sub_<?=$sub['sub_category_id']?>_<?=$cat['main_category_id']?>[]"/>
                                        </td>
                                        <?php } else { ?>
                                        <td></td>
                                        <?php } ?>
                                        <td>
                                            <textarea name="<?=$main_cat?>_sub_<?=$sub['sub_category_id']?>_question_<?=$cat['main_category_id']?>[]" style="resize:none;width: 350px;height: 40px;" class="validate[groupRequired[sub_<?=$sub['sub_category_id']?>_question_<?=$cat['main_category_id']?>]]"><?=$sub['question']?></textarea>
                                        </td>

                                        <?php if( $old != $sub['sub_category_name'] ) { ?>
                                        <td>
                                            <?php if( $cnt > 1 ) { ?>
                                            <a title="Add question" class="optlnk" href="javascript:void(0);" role="button" onclick="addQuestion('<?=@$main_cat?>_sub_<?=$sub['sub_category_id']?>_question_<?=@$cat['main_category_id']?>',$(this).parent().parent().index());"><i class="icon-plus-sign"></i></a>&nbsp;

                                            <a title="Remove" class="optlnk" href="javascript:void(0);" role="button" onclick="remove_quest($(this).parent().parent().index(), 1);"><i class="icon-remove"></i></a>
                                            <?php } else { ?>
                                            <a title="Add question" class="optlnk" href="javascript:void(0);" role="button" onclick="addQuestion('<?=$main_cat?>_sub_<?=$sub['sub_category_id']?>_question_<?=$cat['main_category_id']?>',$(this).parent().parent().index());"><i class="icon-plus-sign"></i></a>
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
                                            <input type="text" value="" class="sub_cat validate[required]" name="<?=$main_cat?>_sub_1_<?=$cat['main_category_id']?>[]" placeholder="New Sub Category"/>
                                        </td>
                                        <td>
                                            <textarea name="<?=$main_cat?>_sub_1_question_<?=$cat['main_category_id']?>[]" style="resize:none;width: 350px;height: 40px;" class="validate[groupRequired[sub_1_question_<?=$cat['main_category_id']?>]]"></textarea>
                                        </td>
                                        <td>
                                            <a title="Add question" class="optlnk" href="javascript:void(0);" role="button" onclick="addQuestion('<?=$main_cat?>_sub_1_question_<?=$cat['main_category_id']?>',$(this).parent().parent().index());"><i class="icon-plus-sign"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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

        function addSubCategory( ){
            console.log($('table tr').find('td.sub_row:eq').index());
            var i = $('table tr').length;
            var _i = i;
            i--;
            var txt_htm = '<tr><td class="sub_row"><input type="text" value="" class="sub_cat validate[required]" name="<?=@$main_cat?>_sub_'+_i+'_<?=@$cat['main_category_id']?>[]" placeholder="New Sub Category"/></td><td><textarea name="<?=@$main_cat?>_sub_'+_i+'_question_<?=@$cat['main_category_id']?>[]" style="resize:none;width: 350px;height: 40px;" class="validate[groupRequired[sub_'+_i+'_question_<?=@$cat['main_category_id']?>]]"></textarea></td><td><a title="Add question" class="optlnk" href="javascript:void(0);" role="button" onclick="addQuestion(\'<?=@$main_cat?>_sub_'+_i+'_question_<?=@$cat['main_category_id']?>\',$(this).parent().parent().index());"><i class="icon-plus-sign"></i></a>&nbsp;<a title="Remove" class="optlnk" href="javascript:void(0);" role="button" onclick="remove_quest($(this).parent().parent().index(), 1);"><i class="icon-remove"></i></a></td></tr>';

            $( txt_htm ).insertAfter( "table tr:eq("+i+")" );
            $('.optlnk').tooltip();
        }

        function addQuestion( e_name, parent ){
            parent++;
            var txt_htm = '<tr><td></td><td><textarea name="'+e_name+'[]" class="questions validate[groupRequired['+e_name+']]" style="resize:none;width: 350px;height: 40px;"></textarea></td><td><a title="Remove" class="optlnk" href="javascript:void(0);" role="button" onclick="remove_quest($(this).parent().parent().index(), 0);"><i class="icon-remove-sign"></i></a></td></tr>';

            $( txt_htm ).insertAfter( "table tr:eq("+parent+")" );

            $('.optlnk').tooltip();
        }

        function remove_quest( parent, sub ){
            var ans = confirm('Remove this item?');
            parent++;
            if( ans ){
                if( sub ){
                    var l = $('table tr').length - 1;
                    if( parent != l ){
                        var _diff = 0;
                        for (var i = parent; i <= l; i++) {
                            if( i != parent ){
                                _diff++;
                                if( $('table tr:eq('+i+') td:eq(0)').attr('class') == 'sub_row' )
                                    break;
                            }
                        }

                        for (var d = _diff - 1; d >= 0; d--) {
                            $('table tr:eq('+parent+')').remove();
                        };
                    }else{
                        $('table tr:eq('+parent+')').remove();
                    }
                } else {
                    $('table tr:eq('+parent+')').remove();
                }
            }
        }

        function cancel() {
            var ans = confirm('Are you sure you want to cancel?');

            if( ans )
                window.location='<?=base_url()?>appraisal';
        }
    </script>