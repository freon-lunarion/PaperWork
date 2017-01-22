<table class="table table-hover">
  <thead>
    <th>Phase Name</th>
    <th>Select</th>
    <th>Order</th>
  </thead>
  <tbody>
    <tr>
      <td>
        Screening CV
      </td>
      <td>
        <input type="checkbox" value="" checked="checked" disabled>
      </td>
      <td>
        Begin (1)
      </td>
    </tr >
    <?php
      $count = 2;
      foreach ($phase as $row) {
        echo '<tr>';
        echo '<td>'.$row->title.'</td>';
        echo '<td>'.form_checkbox('chk_phase[]',$row->code,'','class="chk_phase" id="chk_phase_'.$row->code.'"').'</td>';
        echo '<td>'.form_number('nm_order_'.$row->code,$count,'min=2 max=98 class="form-control nm_order" data-code="'.$row->code.'"').'</td>';
        echo '</tr>';
        $count++;
      }

    ?>
    <tr>
      <td>
        Sign Contract
      </td>
      <td>
        <input type="checkbox" value="" checked="checked" disabled>
      </td>
      <td>
        End (<?php echo $count; ?>)
      </td>
    </tr>


  </tbody>
</table>
