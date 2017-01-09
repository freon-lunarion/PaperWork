<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">User Access</h4>
</div>

<?php echo form_open('user_management/access/processAdd')?>
  <div class="modal-body">
    <div class="form-group">
      <label for="">Username</label>
      <?php
        echo form_dropdown('slc_user',$optUser, '', 'id="slc_user" class="form-control"' );
      ?>
    </div>

    <div class="form-group">
      <label for="">Role</label>
      <?php
        echo form_dropdown('slc_role',$optRole, '', 'id="slc_role" class="form-control"' );
      ?>
    </div>

    <div class="form-group">
      <label for="">Area</label>
      <?php
        echo form_dropdown('slc_area',$optArea, '', 'id="slc_area" class="form-control"' );
      ?>
    </div>

  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save </button>
  </div>
</form>
