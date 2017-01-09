// jQuery(document).ready(function($) {
  if (typeof selTable === "undefined"){
    selTable = '#tbl';
  }

  if (typeof elParent === "undefined"){
    elParent = $('#hdn_parent');
  }

  if (typeof elModal === "undefined"){
    elModal = $('#modal-form');
  }

  if (typeof elContent === "undefined"){
    elContent = elModal.children('.modal-dialog').children('.modal-content');
  }

  function getParentVal() {
    if (typeof elParent === "undefined"){
      return 0;
    } else {
      return elParent.val();
    }
  }

  function breadcrumb() {
    var parentID = getParentVal();
    var elBreadcrumb = $('ol.breadcrumb');
    $.ajax({
      url: baseUrl+ jsonBreadcrumb+parentID,
      type: 'GET',
      dataType: 'json',

    })
    .done(function(respond) {
      elBreadcrumb.html('');
      $.each(respond,function(index, el) {
        if (index < respond.length - 1) {
          elBreadcrumb.append('<li><a data-id="'+el.id+'">'+el.name+'</a></li>');
        } else {
          elBreadcrumb.append('<li class="active">'+el.name+'</li>');
        }
      });
    });

  }
  var buttonSet = '';
  $.each(actionSet,function(index, value) {
    if (value === 'open') {
      buttonSet += '<button class="btn btn-default btn-in"><i class="fa fa-arrow-right"></i></button> ';
    } else if (value === 'resetPass') {
      buttonSet += '<button class="btn btn-default btn-pass" title="reset password"><i class="fa fa-key"></i></button> ';
    } else if (value === 'edit') {
      buttonSet += '<button class="btn btn-default btn-edit"><i class="fa fa-pencil"></i></button> ';
    } else if (value === 'remove') {
      buttonSet += '<button class="btn btn-default btn-remove"><i class="fa fa-trash"></i></button> ';
    }
  });

  var elTable = $(selTable).DataTable({
    "processing" : true,
    "serverSide" : true,
    'rowId'      : 'id',
    "ajax"       : {
      'url'  : baseUrl+jsonList,
      'type' :'POST',
      'data' : {
        'parent': getParentVal
      }
    },
    "columnDefs": [
      {
        "targets"        : -1,
        "className"      : 'action',
        "orderable"      : false,
        "data"           : null,
        "defaultContent" : buttonSet,
      }
    ],
  });

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

  $('.breadcrumb').on('click', 'li>a', function(event) {
    event.preventDefault();
    // TODO run breadcrumb
    var id = $(this).data('id');
    $('#hdn_parent').val(id);
    elTable.ajax.reload();
    breadcrumb();
  });

  elTable.on('click', 'td.action .btn-in', function () {
    // TODO run breadcrumb
    var tr   = $(this).closest('tr');
    var id   = elTable.row(tr).id();
    $('#hdn_parent').val(id);
    elTable.ajax.reload();
    breadcrumb();

  });

  //  event listener for edit / update button
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

  // event listener for reset password button
  elTable.on('click', 'td.action .btn-pass', function () {
    var tr   = $(this).closest('tr');
    var id   = elTable.row(tr).id();
    $.ajax({
      url: baseUrl+formPass,
      type: 'POST',
      dataType: 'html',
      data: {id: id}
    })
    .done(function(respond) {
      elContent.html(respond);
      elModal.modal('show');
    });
  } );

  // event listener for remove / delete button
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
    .done(function() {
      elTable.ajax.reload();
      elModal.modal('hide');

    });
  });


// });
