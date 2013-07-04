<div class="row-fluid">
  <div class="block span6">
    <div class="block-heading" data-target="#tablewidget">News</div>
    <div id="tablewidget" class="block-body">
      <table class="table">
        <tbody>
          <?php 
            $news_cnt = count( $news );
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
              <h3>No news for today.</h3>
            </td>
          </tr>
          <?php 
              endif;
          ?>
        </tbody>
      </table>
      <?php if( $news_cnt > 5 ) { ?><p><a href="users.html">More...</a></p><?php } ?>
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
            <th>Log Date</th>
          </tr>
        </thead>
        <?php
            foreach ($history as $logs):
        ?>
        <tr>
          <td>
            <?=$logs['log']?>
          </td>
          <td>
            <?=$logs['date_log']?>
          </td>
        </tr>
        <?php
            endforeach;
          else:
        ?>
        <tr>
          <td>
            <h3>No history available</h3>
          </td>
        </tr>
        <?php
          endif;
        ?>
      </table>
    </div>
  </div>
</div>