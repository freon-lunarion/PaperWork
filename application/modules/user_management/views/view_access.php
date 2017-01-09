<?php
  $this->load->view('template/top');
  $this->load->view('template/nav_bar');
?>
<div class="container-fluid">
  <div class="row">
    <?php $this->load->view('sidebar');?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h1 class="page-header">User Management <small>Access</small></h1>

      <input type="hidden" id="hdn_parent" value="0"/>
      <div id="table-data">
        <div class="row" style="margin-bottom:10px">
          <div class="col-lg-12">
            <button type="button" class="btn btn-default btn-add  pull-right" >
              <i class="fa fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <table class="table" id="tbl">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Username</th>
                  <th>Role Name</th>
                  <th>Area</th>
                  <th>Action</th>

                </tr>
              </thead>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

    </div>
  </div>
</div>
<?php
  echo $this->load->view('template/bot');
?>

<script>
  // Initialization variable before run crud.js
  var actionSet  = ['remove'];
  var jsonList   = "user_management/access/jsonList";
  var formAdd    = "user_management/access/formAdd";
  var procRemove = "user_management/access/processRemove";
  var selTable   = '#tbl';
  var elModal    = $('#modal-form');
  var elContent  = elModal.children('.modal-dialog').children('.modal-content');
</script>
<script type='text/javascript' src="<?php echo base_url(); ?>js/datatables.crud.js"></script>
