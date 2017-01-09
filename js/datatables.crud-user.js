// jQuery(document).ready(function($) {
  if (typeof parentId === "undefined"){
    parentId = 0;
  }
  var elTable = $(selTable).DataTable({
    "processing" : true,
    "serverSide" : true,
    'rowId'      : 'id',
    "ajax"       : {
      'url'  : baseUrl+jsonList,
      'type' :'POST',
      'data' : {
        'parent': parentId
      }
    },
    "columnDefs": [
      {
        "targets"        : -1,
        "className"      : 'action',
        "orderable"      : false,
        "data"           : null,
        "defaultContent" : '<button class="btn btn-default btn-pass" title="reset password"><i class="fa fa-key"></i></button> <button class="btn btn-default btn-edit"><i class="fa fa-pencil"></i></button>',
      }
    ],
  });

  // add / insert button
  $('.btn-add').click(function(event) {
    /* Act on the event */
    $.ajax({
      url: baseUrl+formAdd,
      dataType: 'html',
    })
    .done(function(respond) {
      elContent.html(respond);
      elModal.modal('show');
    });

  });


  //  event listener for edit/update button
  elTable.on('click', 'td.action .btn-edit', function () {
    var tr   = $(this).closest('tr');
    var id   = elTable.row(tr).id();
    $.ajax({
      url: baseUrl+formEdit,
      type: 'POST',
      dataType: 'html',
      data: {id: id}
    })
    .done(function(respond) {
      elContent.html(respond);
      elModal.modal('show');
    });
  } );

  //  event listener for reset password button
  elTable.on('click', 'td.action .btn-pass', function () {
    var tr   = $(this).closest('tr');
    var id   = elTable.row(tr).id();
    $.ajax({
      url: baseUrl+formEdit,
      type: 'POST',
      dataType: 'html',
      data: {id: id}
    })
    .done(function(respond) {
      elContent.html(respond);
      elModal.modal('show');
    });
  } );

  // event listener for remove button
  elTable.on('click', 'td.action .btn-remove', function () {
    var tr   = $(this).closest('tr');
    var id   = elTable.row( tr ).id();
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover record!",
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
          url: baseUrl+procRemove,
          type: 'POST',
          dataType: 'json',
          data: {id: id}
        })
        .done(function(respond) {
          swal("Success", "Data removed", "success");
          elTable.ajax.reload();
        })
        .fail(function() {

        })
        .always(function() {

        });
      } else {

      }
    });
  } );

  // event listener for submit button
  elContent.on('click', 'button[type="submit"]', function(event) {
    event.preventDefault();
    /* Act on the event */
    var elForm = elContent.children('form');
    $.ajax({
      url: elForm.attr('action'),
      type: 'POST',
      dataType: 'json',
      data: elForm.serialize()
    })
    .done(function(respond) {
      elTable.ajax.reload();
      elModal.modal('hide');
      if (respond.status === 'ERROR') {
        alert('ERROR');
      }
    });
  });



// });
