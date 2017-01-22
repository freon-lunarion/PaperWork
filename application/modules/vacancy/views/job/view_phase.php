<table class="table table-hover">
  <thead>
    <th>Order</th>
    <th>Phase Name</th>
  </thead>
  <tbody>

    <?php
      $count = 1;
      foreach ($phase as $row) {
        echo '<tr>';
        echo '<td>'.$count.'</td>';
        echo '<td>'.$row->phase_name.'</td>';
        echo '</tr>';
        $count++;
      }

    ?>


  </tbody>
</table>
