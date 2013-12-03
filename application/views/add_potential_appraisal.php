<div class="container-fluid">
    <?php if( $this->uri->segment(2) != 'thank_you' ) { ?>
    <div class="alert alert-block alert-warning fade in">
        <h5 class="alert-heading">Rating Guidelines</h5>
        <p>
            <dl style="font-size:11px;">
                <dt>Exceptional (5)</dt>
                <dd>Consistently exceeds all relevant performance standards. Provides leadership, fosters teamwork, is highly productive, innovative, responsive and generates top quality work.</dd>
            </dl>
            <dl style="font-size:11px;">
                <dt>Exceeds Expectations (4)</dt>
                <dd>Consistently meets and often exceeds all relevant performance standards. Shows initiative and versatility. Works collaboratively. Has strong technical and interpersonal skills or has achieved significant improvement in these areas.</dd>
            </dl>
            <dl style="font-size:11px;">
                <dt>Meets Expectations (3)</dt>
                <dd>Meets all relevant performance standards. Seldom exceeds or falls short of desired results or objectives.</dd>
            </dl>
            <dl style="font-size:11px;">
                <dt>Below Expectations (2)</dt>
                <dd>Sometimes meets the performance standards. Seldom exceeds and often falls short of desired results. Performance has declined significantly or employee has not sustained adequate improvement as required since the last performance review.</dd>
            </dl>
            <dl style="font-size:11px;">
                <dt>Needs Improvement (1)</dt>
                <dd>Consistently falls short of performance standards.</dd>
            </dl>
        </p>
    </div>
    <?php } ?>
    <div class="row-fluid">
        <div class="span12">
            <?php
                if( isset( $invalid ) ): 
            ?>
                <div class="alert alert-<?=$invalid['class']?>">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=$invalid['str']?>
                </div>
            <?php 
                else:
            ?>
            <div class="row-fluid">
                <div class="block span12">
                    <?php if( isset( $questions ) ): ?>
                    <form action="" method="POST" id="frm_feedback">
                        <div class="block-heading" data-target="#widget1container">
                            Add Employees Potential Promotion
                        </div>
                        <div id="widget1container" class="block-body">
                            <p>
                                <label class="label label-info">Name:</label>
                                <select id="employee" name="employee" class="span6 validate[required]">
                                    <option value=""></option>
                                    <?php foreach ($employees as $employee) { ?>
                                    <option value="<?=$employee['user_id']?>"><?=ucwords($employee['fname'])?> <?=ucwords($employee['lname'])?></option>
                                    <?php } ?>
                                </select>
                            </p>
                            <table id="tbl_questions" class="table">
                                <thead>
                                    <th width="5%">#</th>
                                    <th width="70%">Question</th>
                                    <th width="25%">Ratings</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        $cnt = 0;
                                        foreach ($questions as $question) {
                                            $cnt++;
                                    ?>
                                    <tr>
                                        <td><?=$cnt?></td>
                                        <td><?=$question['question']?></td>
                                        <td>
                                            <span class="badge badge-inverse">1&nbsp;<input type="radio" name="question_<?=$question['question_id']?>" id="question_<?=$question['question_id']?>" value="1" class="validate[required] radio"></span>
                                            <span class="badge badge-important">2&nbsp;<input type="radio" name="question_<?=$question['question_id']?>" id="question_<?=$question['question_id']?>" value="2" class="validate[required] radio"></span>
                                            <span class="badge badge-warning">3&nbsp;<input type="radio" name="question_<?=$question['question_id']?>" id="question_<?=$question['question_id']?>" value="3" class="validate[required] radio"></span>
                                            <span class="badge badge-info">4&nbsp;<input type="radio" name="question_<?=$question['question_id']?>" id="question_<?=$question['question_id']?>" value="4" class="validate[required] radio"></span>
                                            <span class="badge badge-success">5&nbsp;<input type="radio" name="question_<?=$question['question_id']?>" id="question_<?=$question['question_id']?>" value="5" class="validate[required] radio"></span>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Next <i class="icon-forward"></i></button>
                        </div>
                    </form>
                    <?php else: ?>
                    <div class="block-heading" data-target="#widget1container">
                        <?=$header?>
                    </div>
                    <div id="widget1container" class="block-body">
                        <p class="lead">Thank you for answering the appraisal form. <a href="<?=base_url()?>">Click here to return to home. </a></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php 
                endif;
            ?>
        </div>
        <script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>

        <script type="text/javascript">
            $( document ).ready( function(){
                $( "#frm_feedback" ).validationEngine();
            });

            function disableSubCat( _class, flag ) {
                if( flag == 'checked' ){
                    $('.'+_class).attr('disabled', true);
                    $('.'+_class).attr('checked', false);
                }
                else
                    $('.'+_class).attr('disabled', false);

                return;
            }
        </script>