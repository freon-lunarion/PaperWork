<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">Role</h4>
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
      <label for="">Status</label>

      <label class="checkbox-inline">
        <input type="radio" id="rd_status1" value="1" name="rd_status" {rdStatus1}> Active
      </label>
      <label class="checkbox-inline">
        <input type="radio" id="rdStatus0" value="0" name="rd_status" {rdStatus0}> Inactive
      </label>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th rowspan="2">Module Name</th>
          <th ><i class="fa fa-user"></i> Self</th>
          <th ><i class="fa fa-group"></i> Group</th>
          <th ><i class="fa fa-sitemap"></i> Sub</th>

        </tr>

      </thead>
      <tbody>
        {module}
          <tr>
            <td>{moduleName}</td>
            <td>
              <select name="slc_self_{moduleCode}" id="slc_self_{moduleCode}" class="form-control">
                <option value="0">No Access</option>
                <option value="1">Read Only</option>
                <option value="2">Write Only</option>
                <option value="3">Read and Write</option>
              </select>
            </td>

            <td>
              <select name="slc_group_{moduleCode}" id="slc_group_{moduleCode}" class="form-control">
                <option value="0">No Access</option>
                <option value="1">Read Only</option>
                <option value="2">Write Only</option>
                <option value="3">Read and Write</option>
              </select>
            </td>
            <td>
              <select name="slc_sub_{moduleCode}" id="slc_sub_{moduleCode}" class="form-control">
                <option value="0">No Access</option>
                <option value="1">Read Only</option>
                <option value="2">Write Only</option>
                <option value="3">Read and Write</option>
              </select>
            </td>
            <script>
              $('#slc_self_{moduleCode}').val({self});
              $('#slc_group_{moduleCode}').val({group});
              $('#slc_sub_{moduleCode}').val({sub});
            </script>
          </tr>
        {/module}
      </tbody>
    </table>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save </button>
  </div>
</form>
