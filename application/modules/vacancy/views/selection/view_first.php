<?php
  $this->load->view('template/top');
  $this->load->view('template/nav_bar');
?>
<div class="container-fluid">
  <div class="row">
    <?php $this->load->view('sidebar');?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h1 class="page-header">Selection <small>{subtitle}</small></h1>

      <div class="row">
        <div class="col-xs-12 ">
          <div class="panel panel-default">
            <div class="panel-heading" >
              <h3 class="panel-title ">
                {vacCode} - {vacTitle} <small></small>
              </h3>
            </div>
            <div class="panel-body" style="padding:0px">
              <ul class="nav nav-pills nav-justified thumbnail" style="margin-bottom:0px">
                {phase}
                <li class={phaseActive}><a href="{selectUrl}" title="Click to selection">
                  <h4 class="list-group-item-heading">{phaseName}</h4>
                  <p class="list-group-item-text">{appNum} Candidate(s)</p>
                </a></li>
                {/phase}
                <li><a href="#">
                  <h4 class="list-group-item-heading">Hired/ Rejected</h4>
                  <p class="list-group-item-text"> {hiredNum} / {rejectNum} Candidate(s)</p>
                </a></li>
              </ul>
            </div>
          </div>
        </div>
      </div><!-- end of .row -->
      <style>
        .form-inline{
          margin-bottom: 10px;
        }
        .form-inline>.form-group{
          margin-right: 1em;
        }
        .form-inline>.form-group>label{
          margin-right: 0.25em;
        }
      </style>
      <form class="form-inline">
        <div class="form-group">
          <label for="">Min. Edu</label>
          <select class="form-control" id="slc_edu" name="slc_status">
            <option value="0">none</option>

            {optEdu}
              <option value="{score}">{title}</option>
            {/optEdu}

          </select>
        </div>
        <div class="form-group">
          <label for="">Min. Exp</label>
          <?php echo form_number('nm_expmin','0','style="width:80px"'); ?>
        </div>
        <div class="form-group">
          <label for="">Min. age</label>
          <?php echo form_number('nm_agemin','0','style="width:80px"'); ?>
        </div>
        <div class="form-group">
          <label for="">Max. age</label>
          <?php echo form_number('nm_agemax','99','style="width:80px"'); ?>
        </div>
        <div class="form-group">
          <label for="">Min. Salary</label>
          <?php echo form_number('nm_salarymin','0',' min=0'); ?>
        </div>
        <div class="form-group">
          <label for="">Max. Salary</label>
          <?php echo form_number('nm_salarymax','99900000',' min=0'); ?>
        </div>
        <div class="form-group">
          <label for="">Gender</label>
          <select class="form-control" id="slc_gender" name="slc_status">
              <option value="all">All</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
          </select>
        </div>
        <!-- <div class="form-group">
          <label for="">Criteria</label>
          <select class="form-control" id="slc_field" name="slc_status">
              <option value="eduInst">Education Institution</option>
              <option value="expComp">Company Name</option>
              <option value="expJob">Job Name</option>
          </select>
        </div> -->
        <!-- <div class="form-group">
          <label for="">Keyword</label>
          <div class="input-group">
            <input type="text" name="txt_keyword" id="txt_keyword" class="form-control" placeholder="Search for criteria">
            <span class="input-group-btn">
              <button class="btn btn-default" id="btn-search" type="button" title="search"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div> -->
        <button class="btn btn-default" id="btn-search" type="button" title="Search"><i class="fa fa-search"></i> Search</button>

      </form>
      <div class="row" >
        <div class="col-xs-11 col-md-6 col-lg-6 area-page">
          <nav aria-label="Page navigation">
            <ul class="pagination" style="margin-top:0px;margin-bottom:0px;">
              <li class="page-prev">
                <a href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li class="page-num active"><a href="#">1</a></li>
              <li class="page-next">
                <a href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>

        <div class="col-xs-1 col-md-6 col-lg-6 ">
          <a class="btn btn-default pull-right" title="Add Candidate">Add</a>
        </div>
      </div> <!-- end of .row -->

      <div class="row">
        <div class="col-lg-12" >
          <table class="table table-hover">
            <thead>
              <tr>
                <th>No.</th>
                <th>Fullname</th>
                <th>Exp</th>
                <th>Edu</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="list-pending">

            </tbody>
          </table>
        </div>
      </div> <!-- end of .row -->


      <div class="row" >
        <div class="col-xs-11 col-md-6 col-lg-6 area-page">
          <nav aria-label="Page navigation">
            <ul class="pagination" style="margin-top:0px;margin-bottom:0px;">
              <li class="page-prev">
                <a href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li class="page-num active"><a href="#">1</a></li>

              <li class="page-next">
                <a href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>

        <div class="col-xs-1 col-md-6 col-lg-6 ">
          <button class="btn btn-default btn-backToTop pull-right">Back to Top</button>

        </div>
      </div><!-- end of .row -->
    </div>
  </div>
</div>

<?php
  echo $this->load->view('template/bot');
?>
<script>
  getList(1);
  function getList(page) {
    $.ajax({
      url: baseUrl+'vacancy/selection/showCvList',
      type: 'POST',
      dataType: 'html',
      data: {
        eduMin:0,
        expMin:0,
        ageMin:0,
        ageMax:99,
        salMin:0,
        salMax:99990000,
        gender:'all',
        page:page,
      }
    })
    .done(function(respond) {
      // $('#area-list').html(respond);

      console.log("success");
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });

  }
  // getList(1);
  // getPage(1);


</script>
<script>
  $('.btn-backToTop').click(function(event) {
    /* Act on the event */
    event.preventDefault();
    // alert('AA');
    $('body,html').animate({
				scrollTop: 0
			}, 500);
		return false;
  });
</script>
<script>
  $('.area-page').on('click', '.pagination>li.page-first>a', function(event) {
    event.preventDefault();
    /* Act on the event */
    getList(1);
    getPage(1);
  });
  $('.area-page').on('click', '.pagination>li.page-last>a', function(event) {
    event.preventDefault();
    /* Act on the event */
    page = $(this).data('last');
    getList(page);
    getPage(page);
  });
  $('.area-page').on('click', '.pagination>li.page-num>a', function(event) {
    event.preventDefault();
    /* Act on the event */
    page = $(this).html();
    getList(page);
    getPage(page);
  });

  $('.area-page').on('click', '.pagination>li.page-next>a', function(event) {
    event.preventDefault();
    /* Act on the event */
    page = parseInt($('.pagination>li.active>a').html());
    last = parseInt($('.pagination>li.page-last>a').data('last'))

    if ((page + 1) > last) {

      page = last;
    } else {
      page = page+1;
    }
    getList(page);
    getPage(page);
  });

  $('.area-page').on('click', '.pagination>li.page-prev>a', function(event) {
    event.preventDefault();
    /* Act on the event */
    page = parseInt($('.pagination>li.active>a').html());

    if ((page - 1) < 1) {
      page = 1;
    } else {
      page = page - 1;
    }
    getList(page );
    getPage(page );
  });
</script>
