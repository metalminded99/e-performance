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
                endif;
            ?>            
            <div class="row-fluid">           
                <div class="block span12">
                    <div class="block-heading" data-target="#widget1container">
                        Department Goals Report
                    </div>
                    <div id="widget1container" class="block-body">
                        
                    </div>
                </div>
            </div>
        </div>