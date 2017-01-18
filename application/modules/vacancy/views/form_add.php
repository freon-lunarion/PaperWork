<?php
  $this->load->view('template/top');
  $this->load->view('template/nav_bar');
?>
<div class="container-fluid">
  <div class="row">
    <?php $this->load->view('sidebar');?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h1 class="page-header">Vacancy <small>Add</small></h1>

      <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            <label for="">Vacancy Code</label>
            <?php echo form_input('txt_code',''); ?>
            <p class="help-block">2-10 Characters</p>

          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label for="">Vacancy Name</label>
            <?php echo form_input('txt_name',''); ?>
            <p class="help-block">2-250 Characters</p>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <label for="">Quantity</label>
            <?php echo form_number('nm_qty',1,'min=0'); ?>

          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6 col-lg-3">
          <div class="form-group">
            <label for="">Area</label>
            <?php echo form_dropdown('slc_area',$optArea,'');?>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="form-group">
            <label for="">Job Type</label>
            <?php echo form_dropdown('slc_jobType',$optJobType,'');?>
            </select>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="form-group">
            <label for="">Job Function</label>
            <?php echo form_dropdown('slc_jobFunc',$optJobFunc,'');?>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="form-group">
            <label for="">Job Level</label>
            <?php echo form_dropdown('slc_jobLevel',$optJobLevel,'');?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="">Open Date</label>
            <?php echo form_date('dt_open',''); ?>

          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label for="">Close Date</label>
            <?php echo form_date('dt_close',''); ?>
          </div>
        </div>


      </div>



      <div class="form-group">
        <label for="">Description</label>
        <?php echo form_textarea('txt_desc',''); ?>

      </div>

      <div class="form-group">
        <label for="">Requirement</label>
        <p class="help-block">Optional</p>
        <?php echo form_textarea('txt_req',''); ?>


      </div>

      <div class="form-group">
        <label for="">Benefit</label>
        <p class="help-block">Optional</p>
        <?php echo form_textarea('txt_benefit',''); ?>

      </div>
      <hr />
      <h2>Phase</h2>
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
            foreach ($phase as $row) {
              echo '<tr>';
              echo '<td>'.$row->title.'</td>';
              echo '<td>'.form_checkbox('chk_phase',$row->code).'</td>';
              echo '<td>'.form_number('nm_order','','min=2 max=98').'</td>';
              echo '</tr>';
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
              End (99)
            </td>
          </tr>


        </tbody>
      </table>

      <hr />
      
      <hr />

      <div class="row" >
        <div class="col-xs-12 col-md-6">
          <a class="btn btn-default btn-lg btn-block">Cancel</a>

        </div>
        <div class="col-xs-12 col-md-6">
          <button type="submit" class="btn btn-lg btn-primary btn-block">Save</button>

        </div>
      </div>

    </div>
  </div>
</div>

<?php
  echo $this->load->view('template/bot');
?>
