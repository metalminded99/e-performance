<div class="row-fluid">
  <div class="block span6">
    <?php $news_cnt = count( @$news ); ?>
    <div class="block-heading" data-target="#tablewidget">News <?php if( $news_cnt > 0 ) { ?> <span class="label label-warning">+<?=$news_cnt?></span> <?php } ?></div>
    <div id="tablewidget" class="block-body">
      <table class="table">
        <tbody>
          <?php             
            if( $news_cnt > 0 ):
              foreach( $news as $news_list ): 
          ?>
          <tr>
            <td>
              <h4><?=$news_list['news_title']?> <small><?=$news_list['date_posted']?></small></h4>
              <p><?=$this->template_library->shorten_words( $news_list['news_content'], 15 )?></p>
            </td>
          </tr>
          <?php 
              endforeach; 
            else:
          ?>
          <tr>
            <td>
              <h3>No news available.</h3>
            </td>
          </tr>
          <?php 
              endif;
          ?>
        </tbody>
      </table>
      <?php if( $news_cnt > 5 ) { ?><p><a href="<?=base_url()?>">More...</a></p><?php } ?>
    </div>
  </div>
  <div class="block span6">
    <div class="block-heading" data-target="#widget1container">History</div>
    <div id="tablewidget" class="block-body">
      <table class="table">
        <?php
          $log_count = count( $history );
          if( $log_count > 0 ):
        ?>
        <thead>
          <tr>
            <th>Action</th>
            <th>Date</th>
          </tr>
        </thead>
        <?php
            foreach ($history as $logs):
        ?>
        <tr>
          <td>
            <?=$logs['history']?>
          </td>
          <td>
            <small><?=$this->template_library->format_mysql_date( $logs['date_done'], 'M d, Y h:i a' )?></small>
          </td>
        </tr>
        <?php
            endforeach;
          else:
        ?>
        <tr>
          <td>
            <h3>No history available.</h3>
          </td>
        </tr>
        <?php
          endif;
        ?>
      </table>
    </div>
  </div>
</div>