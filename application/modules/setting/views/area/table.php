<div class="row">
  <div class="col-lg-12">
    <button type="button" class="btn btn-default btn-add  pull-right" data-id="{parentId}" >
      <i class="fa fa-plus"></i>
    </button>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Area Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        {rows}
        <tr>
          <td>{area_id}</td>
          <td>{area_title}</td>
          <td>
            <button type="button" class="btn btn-default btn-in" data-id="{area_id}" >
              <i class="fa fa-chevron-right"></i>
            </button>
            <button type="button" class="btn btn-default btn-edit" data-id="{area_id}" >
              <i class="fa fa-edit"></i>
            </button>
            <button type="button" class="btn btn-default btn-remove" data-id="{area_id}" >
              <i class="fa fa-trash"></i>
            </button>
          </td>
        </tr>
        {/rows}
      </tbody>
    </table>
  </div>
</div>
