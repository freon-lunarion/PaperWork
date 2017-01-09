<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">User</h4>
</div>

<form id="form-area" action="{actionUrl}" class="form">
  <input type="hidden" id="id" name="id" placeholder="" value="{hdnId}">
  <div class="modal-body">
    <div class="form-group">
      <label for="">Username</label>
      <input type="text" class="form-control" id="txt_username" name="txt_username" placeholder="" value="{txtUsername}">
      <p class="help-block">2-250 Characters. Must be unique</p>
    </div>

    <div class="form-group">
      <label for="">Firstname</label>
      <input type="text" class="form-control" id="txt_firstname" name="txt_firstname" placeholder="" value="{txtFirstname}">
      <p class="help-block">2-250 Characters</p>
    </div>

    <div class="form-group">
      <label for="">Lastname</label>
      <input type="text" class="form-control" id="txt_lastname" name="txt_lastname" placeholder="" value="{txtLastname}">
      <p class="help-block">2-250 Characters. Rewrite Firstname, if you don't have Lastname</p>
    </div>

    <div class="form-group">
      <label for="">Nickname</label>
      <input type="text" class="form-control" id="txt_nickname" name="txt_nickname" placeholder="" value="{txtNickname}">
      <p class="help-block">2-250 Characters</p>
    </div>

    <div class="form-group">
      <label for="">Email</label>
      <input type="email" class="form-control" id="txt_email" name="txt_email" placeholder="" value="{txtEmail}">
      <p class="help-block">Must be unique</p>
    </div>


    <div class="form-group">
      <label for="">Status</label>

      <label class="checkbox-inline">
        <input type="radio" id="rd_status1" value="1" name="rd_status" {rdStatus1}> Active
      </label>
      <label class="checkbox-inline">
        <input type="radio" id="rdStatus0" value="0" name="rd_status" {rdStatus0}> Inactive
      </label>
    </div>

  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save </button>
  </div>
</form>
