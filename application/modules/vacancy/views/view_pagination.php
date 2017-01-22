<nav aria-label="Page navigation">
  <ul class="pagination" style="margin-top:0px;margin-bottom:0px;">
    <li class="page-first">
      <a href="#" aria-label="First">
        <span aria-hidden="true">&lsaquo; First</span>
      </a>
    </li>
    <li class="page-prev">
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&lt;</span>
      </a>
    </li>
    <?php
      $start = (($page - 5) > 0) ? ($page - 4) : 1;
      $end   = (($page + 5) < $total ) ? $page + 5 : $total;

      for ($i=$start ; $i <= $end; $i++) {
        if ($i == $page) {
          echo '<li class="page-num active"><a href="#">'.$i.'</a></li>';
        } else {
          echo '<li class="page-num"><a href="#">'.$i.'</a></li>';

        }
      }
    ?>

    <li class="page-next">
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&gt;</span>
      </a>
    </li>
    <li class="page-last">
      <a href="#" aria-label="Last" data-last="<?php echo $total ?>">
        <span aria-hidden="true">Last &rsaquo;</span>
      </a>
    </li>
  </ul>
</nav>
