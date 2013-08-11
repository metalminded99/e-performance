<div class="container-fluid">
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
                            <?=$header?>
                        </div>
                        <div id="widget1container" class="block-body">
                            <table id="tbl_questions" class="table">
                                <thead>
                                    <th width="5%">#</th>
                                    <th width="70%">Description</th>
                                    <th width="25%">Ratings</th>
                                </thead>
                                <tbody>
                                    <?php for ($i=0; $i < count( $questions ); $i++) { ?>
                                    <tr>
                                        <td><?=($i + 1)?></td>
                                        <td><?=$questions[ $i ]['question']?></td>
                                        <td>
                                            <span class="badge badge-inverse">1&nbsp;<input type="radio" name="question_<?=$questions[ $i ]['question_id']?>" id="question_<?=$questions[ $i ]['question_id']?>" value="1" class="validate[required] radio"></span>
                                            <span class="badge badge-important">2&nbsp;<input type="radio" name="question_<?=$questions[ $i ]['question_id']?>" id="question_<?=$questions[ $i ]['question_id']?>" value="2" class="validate[required] radio"></span>
                                            <span class="badge badge-warning">3&nbsp;<input type="radio" name="question_<?=$questions[ $i ]['question_id']?>" id="question_<?=$questions[ $i ]['question_id']?>" value="3" class="validate[required] radio"></span>
                                            <span class="badge badge-info">4&nbsp;<input type="radio" name="question_<?=$questions[ $i ]['question_id']?>" id="question_<?=$questions[ $i ]['question_id']?>" value="4" class="validate[required] radio"></span>
                                            <span class="badge badge-success">5&nbsp;<input type="radio" name="question_<?=$questions[ $i ]['question_id']?>" id="question_<?=$questions[ $i ]['question_id']?>" value="5" class="validate[required] radio"></span>
                                        </td>
                                    </tr>
                                    <?php } ?>
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

        </script>