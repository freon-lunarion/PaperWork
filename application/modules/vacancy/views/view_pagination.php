<nav aria-label="Page navigation">
  <ul class="pagination" style="margin-top:0px;margin-bottom:0px;">
    <li class="page-arrow">
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <?php
      for ($i=1; $i <= $total ; $i++) {
        if ($i == $page) {
          echo '<li class="page-num active"><a href="#">'.$i.'</a></li>';
        } else {
          echo '<li class="page-num"><a href="#">'.$i.'</a></li>';

        }
      }
    ?>

    <li class="page-arrow">
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
