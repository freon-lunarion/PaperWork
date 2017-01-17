<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">Module</h4>
</div>

<form id="form-area" action="{actionUrl}" class="form">
  <input type="hidden" id="id" name="id" placeholder="" value="{hdnId}">

  <div class="modal-body">
    <div class="form-group">
      <label for="">Name</label>
      <input type="text" class="form-control" id="txt_name" name="txt_name" placeholder="" value="{txtName}">
      <p class="help-block">2-250 Characters</p>
    </div>
    <div class="form-group">
      <label for="">Mandatory</label>
      <label class="checkbox-inline">
        <input type="radio" id="rdMandatory0" value="0" name="rd_mandatory" {rdMandatory0}> No
      </label>
      <label class="checkbox-inline">
        <input type="radio" id="rdMandatory1" value="1" name="rd_mandatory" {rdMandatory1}> Yes
      </label>
    </div>

    <div class="form-group">
      <label for="">Schedule</label>
      <label class="checkbox-inline">
        <input type="radio" id="rdSchedule0" value="0" name="rd_schedule" {rdSchedule0}> No
      </label>
      <label class="checkbox-inline">
        <input type="radio" id="rdSchedule1" value="1" name="rd_schedule" {rdSchedule1}> Yes
      </label>
    </div>

  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save </button>
  </div>
</form>
