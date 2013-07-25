<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
    $( document ).ready( function(){
        $( "#frm_journal" ).validationEngine();

        $('.cancel').bind('click', function(e) {
            var ans = confirm( 'Are you sure you want to quit?' );
            
            if( ans ){
                window.location = "<?=base_url()?>journals";
            }

            return false;
        });
    });
</script>
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
                        <form id="frm_journal" action="" method="POST">
                            <div class="element">                                
                                <label for="journal_title">Title <span class="red">(required)</span></label>
                                <input id="journal_title" name="journal_title" class="span9 text validate[required]" value="<?=isset( $journals['journal_title'] ) ? $journals['journal_title'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="journal_desc">Description <span class="red">(required)</span></label>
                                <textarea id="journal_desc" name="journal_desc" class="span9 text validate[required]" style="resize:none;" rows="15"/><?=isset( $journals['journal_desc'] ) ? $journals['journal_desc'] : '' ?></textarea>
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