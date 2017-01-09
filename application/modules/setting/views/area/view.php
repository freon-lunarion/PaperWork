<?php
  $this->load->view('template/top');
  $this->load->view('template/nav_bar');
?>
<div class="container-fluid">
  <div class="row">
    <?php $this->load->view('sidebar');?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h1 class="page-header">Setting <small>Area</small></h1>
      <ol class="breadcrumb">
        <li class="active">ROOT</li>
      </ol>
      <div class="row" style="margin-bottom:10px">
        <input type="hidden" id="hdn_parent" value="0"/>
        <div class="col-lg-12">
          <button type="button" class="btn btn-default btn-add  pull-right">
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
                <th>Area Name</th>
                <th>Action</th>
              </tr>
            </thead>

          </table>
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
  var actionSet      = ['open','edit','remove'];
  var jsonBreadcrumb = "setting/area/jsonBreadcrumb/";
  var jsonList       = "setting/area/jsonList";
  var formAdd        = "setting/area/formAdd";
  var formEdit       = "setting/area/formEdit";
  var procRemove     = "setting/area/processRemove";
  var selTable       = '#tbl';
  var elParent       = $('#hdn_parent');
  var elModal        = $('#modal-form');
  var elContent      = elModal.children('.modal-dialog').children('.modal-content');


</script>
<script type='text/javascript' src="<?php echo base_url(); ?>js/datatables.crud.js"></script>
