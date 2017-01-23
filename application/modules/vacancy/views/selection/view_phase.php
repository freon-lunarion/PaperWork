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
      </div> <!-- end of .row -->

      <div class="row">
        <div class="col-lg-12" id="list-pending">

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
  // function getPage(page) {
  //   $.ajax({
  //     url: baseUrl+'vacancy/vacancy/showPage',
  //     type: 'POST',
  //     dataType: 'html',
  //     data: {
  //       keyword: $('#txt_keyword').val(),
  //       status: $('#slc_status').val(),
  //       start: $('#dt_start').val(),
  //       end: $('#dt_end').val(),
  //       page:page,
  //     }
  //   })
  //   .done(function(respond) {
  //     $('.area-page').html(respond);
  //     console.log("success");
  //   })
  //   .fail(function() {
  //     console.log("error");
  //   })
  //   .always(function() {
  //     console.log("complete");
  //   });
  // }
  //
  // function getList(page) {
  //   $.ajax({
  //     url: baseUrl+'vacancy/job/showList',
  //     type: 'POST',
  //     dataType: 'html',
  //     data: {
  //       keyword: $('#txt_keyword').val(),
  //       status: $('#slc_status').val(),
  //       start: $('#dt_start').val(),
  //       end: $('#dt_end').val(),
  //       page:page,
  //     }
  //   })
  //   .done(function(respond) {
  //     $('#area-list').html(respond);
  //
  //     console.log("success");
  //   })
  //   .fail(function() {
  //     console.log("error");
  //   })
  //   .always(function() {
  //     console.log("complete");
  //   });
  //
  // }
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
