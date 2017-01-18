<?php
  $this->load->view('template/top');
  $this->load->view('template/nav_bar');
?>
<div class="container-fluid">
  <div class="row">
    <?php $this->load->view('sidebar');?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h1 class="page-header">Vacancy <small></small></h1>

      <div class="row" style="margin-bottom:10px">
        <div class="col-xs-6 col-sm-6 col-lg-3">
          <input type="date" class="form-control" placeholder="" value="2010-01-01">
        </div>
        <div class="col-xs-6 col-sm-6 col-lg-3">
          <input type="date" class="form-control" placeholder="" value="9999-12-31">
        </div>
        <div class="col-sm-12 col-lg-4">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for title or code">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
            </span>
          </div><!-- /input-group -->

        </div>
      </div>
      <div class="row" >
        <div class="col-xs-11 col-md-6 col-lg-6">
          <nav aria-label="Page navigation">
            <ul class="pagination" style="margin-top:0px;margin-bottom:0px;">
              <li>
                <a href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li class="active"><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li>
                <a href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>

        <div class="col-xs-1 col-md-6 col-lg-6 ">
          <?php echo anchor('vacancy/formAdd','<i class="fa fa-plus"></i>' ,'class="btn btn-default pull-right"')?>


        </div>
      </div>

      <?php for ($i=0; $i < 10 ; $i++) { ?>
      <div class="row">
        <div class="col-xs-12 ">
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">
                Job Title
                <a class="btn-edit pull-right"><i class="fa fa-pencil"></i></a>

              </h3>
            </div>
            <div class="panel-body" style="padding:0px">
              <ul class="nav nav-pills nav-justified thumbnail" style="margin-bottom:0px">
                <li><a href="#">
                  <h4 class="list-group-item-heading">CV Screen</h4>
                  <p class="list-group-item-text">99 Candidate(s)</p>
                </a></li>
                <li ><a href="#">
                  <h4 class="list-group-item-heading">Process 1</h4>
                  <p class="list-group-item-text">99 Candidate(s)</p>
                </a></li>
                <li ><a href="#">
                  <h4 class="list-group-item-heading">Process 2</h4>
                  <p class="list-group-item-text">99 Candidate(s)</p>
                </a></li>
                <li ><a href="#">
                  <h4 class="list-group-item-heading">Process 3</h4>
                  <p class="list-group-item-text">99 Candidate(s)</p>
                </a></li>
                <li ><a href="#">
                  <h4 class="list-group-item-heading">Process 4</h4>
                  <p class="list-group-item-text">99 Candidate(s)</p>
                </a></li>
                <li><a href="#">
                  <h4 class="list-group-item-heading">Sign Contract</h4>
                  <p class="list-group-item-text">99 Candidate(s)</p>
                </a></li>
                <li><a href="#">
                  <h4 class="list-group-item-heading">Hired/ Rejected</h4>
                  <p class="list-group-item-text">99/99 Candidate(s)</p>
                </a></li>
              </ul>
            </div>
            <!-- <div class="panel-footer">

            </div> -->
          </div>


        </div>
      </div>
      <?php } ?>

      <div class="row" >
        <div class="col-xs-11 col-md-6 col-lg-6 ">
          <nav aria-label="Page navigation">
            <ul class="pagination" style="margin-top:0px;margin-bottom:0px;">
              <li>
                <a href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li class="active"><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li>
                <a href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>

        <div class="col-xs-1 col-md-6 col-lg-6 ">
          <button class="btn btn-default pull-right">Back to Top</button>

        </div>
      </div>
    </div>
  </div>
</div>

<?php
  echo $this->load->view('template/bot');
?>
<script>
  function getList() {
    $.ajax({
      url: baseUrl+'vacancy/vacancy/jsonList',
      type: 'POST',
      dataType: 'jsonList',
      data: {param1: 'value1'}
    })
    .done(function(respond) {
      console.log("success");
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });

  }
</script>
