<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">User</h4>
</div>

<form id="form-area" action="{actionUrl}" class="form">

  <div class="modal-body">
    <div class="form-group">
      <label for="">Vacancy Code</label>
      <input type="text" class="form-control" id="txt_code" name="txt_code" placeholder="">
    </div>

    <div class="form-group">
      <label for="">Vacancy Name</label>
      <input type="text" class="form-control" id="txt_name" name="txt_name" placeholder="">
      <p class="help-block">2-250 Characters</p>
    </div>
    <div class="form-group">
      <label for="">Area</label>
      <select class="form-control" name="slc_area" id="slc_area">

      </select>
    </div>
    
    <div class="form-group">
      <label for="">Job Type</label>
      <select class="form-control" name="slc_jobType" id="slc_jobType">

      </select>
    </div>

    <div class="form-group">
      <label for="">Job Function</label>
      <select class="form-control" name="slc_jobFunc" id="slc_jobFunc">

      </select>
    </div>

    <div class="form-group">
      <label for="">Job Level</label>
      <select class="form-control" name="slc_jobLevel" id="slc_jobLevel">

      </select>
    </div>

    <div class="form-group">
      <label for="">Open Date</label>
      <input type="date" class="form-control" id="dt_open" name="dt_open" placeholder="" value="">
    </div>
    <div class="form-group">
      <label for="">Close Date</label>
      <input type="date" class="form-control" id="dt_close" name="dt_close" placeholder="" value="">
    </div>

    <div class="form-group">
      <label for="">Quantity</label>
      <input type="number" class="form-control" id="nm_qty" name="nm_qty" placeholder="" value="">
    </div>

    <div class="form-group">
      <label for="">Description</label>
      <textarea class="form-control" name="txt_desc" id="txt_desc"></textarea>
    </div>

    <div class="form-group">
      <label for="">Requirement</label>
      <textarea class="form-control" name="txt_req" id="txt_req"></textarea>
    </div>

    <div class="form-group">
      <label for="">Benefit</label>
      <textarea class="form-control" name="txt_benefit" id="txt_benefit"></textarea>
    </div>






  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save </button>
  </div>
</form>
