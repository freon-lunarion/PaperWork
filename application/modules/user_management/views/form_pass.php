<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">User - Reset Password</h4>
</div>

<form id="form-area" action="{actionUrl}" class="form">
  <input type="hidden" id="id" name="id" placeholder="" value="{hdnId}">
  <div class="modal-body">
    <div class="form-group">
      <label for="">New Password</label>
      <input type="password" class="form-control" id="pass_new" name="pass_new" placeholder="" value="">
      <p class="help-block"></p>
    </div>

    <div class="form-group">
      <label for="">Confirm Password</label>
      <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" placeholder="" value="">
      <p class="help-block"></p>
    </div>

  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save </button>
  </div>
</form>
