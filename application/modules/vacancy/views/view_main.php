<?php
  $this->load->view('template/top');
  $this->load->view('template/nav_bar');
?>
<div class="container-fluid">
  <div class="row">
    <?php $this->load->view('sidebar');?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h1 class="page-header">Vacancy <small></small></h1>
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
        .panel-title>a {
          margin-left: 10px;
        }
      </style>
      <form class="form-inline">
        <div class="form-group">
          <label for="">Start</label>
          <?php echo form_date('dt_start',date('Y-m-d'));?>
        </div>
        <div class="form-group">
          <label for="">End</label>
          <?php echo form_date('dt_end',date('Y-m-d'));?>
        </div>
        <div class="form-group">
          <label for="">Status</label>
          <select class="form-control" id="slc_status" name="slc_status">
            <option value="all">All</option>
            <option value="publish">Publish</option>
            <option value="unpublish">Unpublish</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Keyword</label>
          <div class="input-group">
            <input type="text" name="txt_keyword" id="txt_keyword" class="form-control" placeholder="Search for title or code">
            <span class="input-group-btn">
              <button class="btn btn-default" id="btn-search" type="button" title="search"><i class="fa fa-search"></i></button>
            </span>
          </div><!-- /input-group -->
        </div>

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
              <li class="page-num"><a href="#">2</a></li>
              <li class="page-num"><a href="#">3</a></li>
              <li class="page-num"><a href="#">4</a></li>
              <li class="page-num"><a href="#">5</a></li>
              <li class="page-next">
                <a href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>

        <div class="col-xs-1 col-md-6 col-lg-6 ">
          <?php echo anchor('vacancy/formAdd','Add' ,'class="btn btn-default pull-right"')?>

        </div>
      </div>

      <div id="area-list"></div>


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
              <li class="page-num"><a href="#">2</a></li>
              <li class="page-num"><a href="#">3</a></li>
              <li class="page-num"><a href="#">4</a></li>
              <li class="page-num"><a href="#">5</a></li>
              <li class="page-next">
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
  function getPage(page) {
    $.ajax({
      url: baseUrl+'vacancy/vacancy/showPage',
      type: 'POST',
      dataType: 'html',
      data: {
        keyword: $('#txt_keyword').val(),
        status: $('#slc_status').val(),
        start: $('#dt_start').val(),
        end: $('#dt_end').val(),
        page:page,
      }
    })
    .done(function(respond) {
      $('.area-page').html(respond);
      console.log("success");
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }

  function getList(page) {
    $.ajax({
      url: baseUrl+'vacancy/vacancy/showList',
      type: 'POST',
      dataType: 'html',
      data: {
        keyword: $('#txt_keyword').val(),
        status: $('#slc_status').val(),
        start: $('#dt_start').val(),
        end: $('#dt_end').val(),
        page:page,
      }
    })
    .done(function(respond) {
      $('#area-list').html(respond);

      console.log("success");
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });

  }
  getList(1);
  getPage(1);

  $('.pagination>li.page-num>a').click(function(event) {
    /* Act on the event */

    $('.pagination>li.page-num').attr('class', 'page-num');
    $(this).parent().attr('class', 'page-num active');
  });

  $('.pagination>li.page-next>a').click(function(event) {
    /* Act on the event */
    page = $('.pagination>li.active>a').html();

  });

  $('#btn-search').click(function(event) {
    /* Act on the event */
    getList(1);
    getPage(1);
  });
</script>
<script>
  $('#area-list').on('click', '.btn-publish', function(event) {
    event.preventDefault();
    page = $('.pagination>li.active>a').html();

    swal({
      title: "Are you sure?",
      text: "Do you want to Publish this vacancy",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      showLoaderOnConfirm: true,
      closeOnConfirm: false,
      closeOnCancel: true
    },
    function(isConfirm){
      if (isConfirm) {
        $.ajax({
          url: $(this).attr('href'),
          type: 'POST',
          dataType: 'json',
          data: {id: id}
        })
        .done(function(respond) {
          swal("Success", "Vacancy Published", "success");
          getList(page);
        })
        .fail(function() {

        })
        .always(function() {

        });
      } else {

      }
    });
  });
</script>
