
// Load Table Data
var load_items = () => {
  $(document).gmLoadPage({
    url: 'management/load_items',
    load_on: '#load_items'
  });
}

var load_supplier = () => {
  $(document).gmLoadPage({
    url: 'management/load_suppliers',
    load_on: '#load_suppliers'
  });
}

var load_units = () => {
  $(document).gmLoadPage({
    url: 'management/load_units',
    load_on: '#load_units'
  });
}

// Dynamic Drop Down Loading (No Page Refresh Required)
var load_items_drop_down = () => {
  $(document).gmLoadPage({
    url: 'management/load_items_drop_down',
    load_on: '#items_drop_down'
  });
}

var load_unit_drop_down = () => {
  $(document).gmLoadPage({
    url: 'management/load_unit_drop_down',
    load_on: '#unit_drop_down'
  });
}

var load_supplier_drop_down = () => {
  $(document).gmLoadPage({
    url: 'management/load_supplier_drop_down',
    load_on: '#supplier_drop_down'
  });
}

var load_user = () => {
  $(document).gmLoadPage({
    url: 'management/load_user',
    load_on: '#load_user'
  });
}

var load_buyers = () => {
  $(document).gmLoadPage({
    url: 'management/load_buyers',
    load_on: '#load_buyers'
  });
}

var load_clients = () => {
  $(document).gmLoadPage({
    url: 'management/load_clients',
    load_on: '#load_clients'
  });
}

$(document).ready(function () {
  load_items();
  load_user();
  load_supplier();
  load_units();
  load_clients();

  load_items_drop_down();
  load_supplier_drop_down();
  load_unit_drop_down();
});


// <<=========================================>>ITEM MANAGEMENT<<=========================================>>

$('#save_item').click(function () {
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to save item details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/save_list',
            data: {
              item_name: $('#item_name').val(),
              item_code: $('#code').val(),
              short_name: $('#short_name').val(),
              description: $('#item_description').val(),
              category: $('#Category').val(),
              status: $('#item_status').val(),
              // w: $('#item_expiry_date').val(),
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
                load_items();
                load_items_drop_down();

                $('#item_name').val("");
                $('#code').val("");
                $('#short_name').val("");
                $('#item_status').val("1");
                $('#item_description').val("");
                $('#Category').val("");
                // setTimeout(function () {
                //   window.location.reload();
                // }, 2000);
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

$('#update_item').click(function () {
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to update item details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/update_item',
            // selector: '.form-control',
            data: {
              id: $('#item_id').val(),
              item_name: $('#item_name').val(),
              item_code: $('#code').val(),
              short_name: $('#short_name').val(),
              description: $('#item_description').val(),
              status: $('#item_status').val(),
              category: $('#Category').val(),
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (e.has_error == false) {
                toastr.success(e.message);
                load_items();
                load_items_drop_down();

                $('#item_name').val("");
                $('#code').val("");
                $('#short_name').val("");
                $('#item_status').val("1");
                $('#item_description').val("");
                $('#Category').val("");
                setTimeout(function () {
                  window.location.reload();
                }, 500);
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          })
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

var editItem = (data) => {
  // console.log(data.getAttribute('data-id'));
  $('#item_id').val(data.getAttribute('data-id'));

  $('#item_name').val(data.getAttribute('data-item_name'));
  $('#code').val(data.getAttribute('data-item_code'));
  $('#short_name').val(data.getAttribute('data-short_name'));
  $('#item_status').val(data.getAttribute('data-status'));
  $('#item_description').val(data.getAttribute('data-description'));
  $('#Category').val(data.getAttribute('data-category'));


  $('#save_item').hide();
  $('#update_item').show();
}

// <<=========================================>>UNIT MANAGEMENT<<=========================================>>

var deletUnit = (data) => {
  // alert(data.getAttribute('data-id'));
  $('#unit_id').val(data.getAttribute('data-id'));
  $('#unit').val(data.getAttribute('data-item_name'));

  $('#save_unit').hide();
  $('#delete_unit').show();
}

$('#save_unit').click(function () {
  // alert($('#unit').val());
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to save this unit?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/save_unit',
            data: {
              unit: $('#unit').val(),
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
                load_units();
                load_unit_drop_down();

                $('#unit').val("");
                // setTimeout(function () {
                //   window.location.reload();
                // }, 2000);
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

$('#delete_unit').click(function () {
  // alert($('#unit').val());
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to delete this unit?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/delete_unit',
            data: {
              id: $('#unit_id').val(),
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
                load_units();
                load_unit_drop_down();

                $('#unit').val("");
                setTimeout(function () {
                  window.location.reload();
                }, 500);
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

// <<=========================================>>SUPPLIER MANAGEMENT<<=========================================>>

var editSupplier = (data) => {
  // console.log(data.getAttribute('data-id'));
  $('#supplier_id').val(data.getAttribute('data-id'));

  $('#supplier_name').val(data.getAttribute('data-supplier_name'));
  $('#supplier_address').val(data.getAttribute('data-address'));
  $('#contact_person').val(data.getAttribute('data-contact_person'));
  $('#cn_1').val(data.getAttribute('data-contact_number_1'));
  $('#cn_2').val(data.getAttribute('data-contact_number_2'));
  $('#supplier_email').val(data.getAttribute('data-email'));
  $('#supplier_status').val(data.getAttribute('data-active'));



  $('#save_supplier').hide();
  $('#update_supplier').show();
}

$('#save_supplier').click(function () {
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to save supplier details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/save_supplier',
            data: {
              supplier_name: $('#supplier_name').val(),
              supplier_address: $('#supplier_address').val(),
              contact_person: $('#contact_person').val(),
              contact_number_1: $('#cn_1').val(),
              contact_number_2: $('#cn_2').val(),
              supplier_email: $('#supplier_email').val(),
              supplier_status: $('#supplier_status').val(),
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
                load_supplier();
                load_supplier_drop_down();

                $('#supplier_name').val("");
                $('#supplier_address').val("");
                $('#contact_person').val("");
                $('#cn_1').val("");
                $('#cn_2').val("");
                $('#supplier_email').val("");
                $('#supplier_status').val("1");

                // setTimeout(function () {
                //   window.location.reload();
                // }, 2000);
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

$('#update_supplier').click(function () {
  // alert($('#supplier_id').val());
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to update supplier details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/update_supplier',
            data: {
              id: $('#supplier_id').val(),
              supplier_name: $('#supplier_name').val(),
              supplier_address: $('#supplier_address').val(),
              contact_person: $('#contact_person').val(),
              contact_number_1: $('#cn_1').val(),
              contact_number_2: $('#cn_2').val(),
              supplier_email: $('#supplier_email').val(),
              supplier_status: $('#supplier_status').val(),
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
                load_supplier();
                load_supplier_drop_down();

                $('#supplier_name').val("");
                $('#supplier_address').val("");
                $('#contact_person').val("");
                $('#cn_1').val("");
                $('#cn_2').val("");
                $('#supplier_email').val("");
                $('#supplier_status').val("1");
                setTimeout(function () {
                  window.location.reload();
                }, 500);
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

// <<=========================================>>USER MANAGEMENT<<=========================================>>
let global_user_id = null;
var editFunction = (x) => {
  global_user_id = x;
  $.post({
    url: 'management/get_user_details',
    // selector: '.form-control',
    data: {
      user_id: x,
    },
    success: function (e) {
      var e = JSON.parse(e);
      $('#LName').val(e.LName);
      $('#FName').val(e.FName);
      $('#UName').val(e.Username);
      $('#Role').val(e.Role);
      // $('#Branch').val(e.Branch);
      $('#Update').val(e.U_ID);
      $('#delete_user').val(e.U_ID);
      $('#reset_pass').val(e.U_ID);

      $('#Save').css('display', 'none');
      $('#Update').css('display', 'inline');
      $('#Reset').css('display', 'inline');
      $('#Delete').css('display', 'inline');
    },
  })
}

// SAVE USER DETAILS
$('#save_user').click(function () {
  $.post({
    url: 'service/Management_service/save_user',
    // selector: '.form-control',
    data: {
      FName: $('#FName').val(),
      LName: $('#LName').val(),
      Username: $('#UName').val(),
      // Branch: $('#Branch').val(),
      Role: $('#Role').find(':selected').data('id'),
      Role_name: $('#Role').find(':selected').data('role')

    },
    success: function (e) {
      var e = JSON.parse(e);
      if (e.has_error == false) {
        $('#modal-default').modal('hide');
        toastr.success(e.message);
        load_user();
        setTimeout(function () {
          window.location.reload();
        }, 2000);

      } else {
        $('#LName').attr('class', 'form-control inpt is-invalid');
        $('#FName').attr('class', 'form-control inpt is-invalid');
        $('#UName').attr('class', 'form-control inpt is-invalid');
        $('#modal-default').modal('hide');
        toastr.error(e.message);
      }
    },
  })
});

$('#Update').click(function () {
  // alert(global_user_id);

  $.post({
    url: 'service/Management_service/update_user',
    // selector: '.form-control',
    data: {
      user_id: global_user_id,
      FName: $('#FName').val(),
      LName: $('#LName').val(),
      Username: $('#UName').val(),
      // Branch: $('#Branch').val(),
      Role: $('#Role').find(':selected').data('id'),
      Role_name: $('#Role').find(':selected').data('role')

    },
    success: function (e) {
      var e = JSON.parse(e);
      if (e.has_error == false) {
        $('#modal-default').modal('hide');
        toastr.success(e.message);
        load_user();
        setTimeout(function () {
          window.location.reload();
        }, 2000);

      } else {
        $('#LName').attr('class', 'form-control inpt is-invalid');
        $('#FName').attr('class', 'form-control inpt is-invalid');
        $('#UName').attr('class', 'form-control inpt is-invalid');
        $('#modal-default').modal('hide');
        toastr.error(e.message);
      }
    },
  })
});


$('#delete_user').click(function () {
  $.post({
    url: 'service/Management_service/delete_user',
    // selector: '.form-control',
    data: {
      U_ID: $(this).val(),

    },
    success: function (e) {
      var e = JSON.parse(e);
      if (e.has_error == false) {
        $('#modal-default').modal('hide');
        toastr.success(e.message);
        load_user();
        setTimeout(function () {
          window.location.reload();
        }, 2000);

      }
    },
  })
});

$('#reset_pass').click(function () {
  $.post({
    url: 'service/Management_service/reset',
    // selector: '.form-control',
    data: {
      U_ID: $(this).val(),
    },
    success: function (e) {
      var e = JSON.parse(e);
      if (e.has_error == false) {
        $('#modal-default').modal('hide');
        toastr.success(e.message);
        load_user();
        setTimeout(function () {
          window.location.reload();
        }, 2000);

      } else {
        $('#LName').attr('class', 'form-control inpt is-invalid');
        $('#FName').attr('class', 'form-control inpt is-invalid');
        $('#UName').attr('class', 'form-control inpt is-invalid');
        $('#modal-default').modal('hide');
        toastr.error(e.message);
      }
    },
  })
});

// client management

// Save Client
$('#save_client').click(function () {
  // basic required-field check
  if ($.trim($('#client-name').val()) === '') {
    $('#client-name').addClass('is-invalid');
    return toastr.error('Client Name is required.');
  }

  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to save client details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/save_client',
            data: {
              client_name: $.trim($('#client-name').val()),
              client_company_aff: $.trim($('#client-company-aff').val()),
              contact_number: $.trim($('#client-cn').val()),
              client_email: $.trim($('#client-email').val()),
              client_status: $('#client_status').val()
            },
            success: function (res) {
              let e;
              try {
                e = (typeof res === 'object') ? res : JSON.parse(res);
              } catch (err) {
                toastr.error('Invalid server response.');
                return;
              }

              if (!e.has_error) {
                toastr.success(e.message);

                // try all probable refresh functions if present (won't throw if absent)
                // if (typeof load_supplier === 'function') load_supplier();
                // if (typeof load_suppliers === 'function') load_suppliers();
                if (typeof load_clients === 'function') load_clients();

                // reset form
                $('#client-name').val('').removeClass('is-invalid');
                $('#client-company-aff').val('');
                $('#client-cn').val('');
                $('#client-email').val('');
                $('#client_status').val('1');

                // ensure buttons back to initial state
                $('#update_client').hide();
                $('#save_client').show();
              } else {
                $('#client-name').addClass('is-invalid');
                toastr.error(e.message);
              }
            },
            error: function () {
              toastr.error("Something went wrong while saving client.");
            }
          });
        }
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {}
      }
    }
  });
});


// Update Client
$('#update_client').click(function () {
  // You need a hidden input #client_id for updating (e.g. <input type="hidden" id="client_id" />)
  // if ($('#client_id').length === 0 || $.trim($('#client_id').val()) === '') {
  //   return toastr.error('No client selected to update. Make sure #client_id exists and contains the record id.');
  // }

  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to update client details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/update_client',
            data: {
              id: $.trim($('#client_id').val()),
              client_name: $.trim($('#client-name').val()),
              client_company_aff: $.trim($('#client-company-aff').val()),
              contact_number: $.trim($('#client-cn').val()),
              client_email: $.trim($('#client-email').val()),
              client_status: $('#client_status').val()
            },
            success: function (res) {
              let e;
              try {
                e = (typeof res === 'object') ? res : JSON.parse(res);
              } catch (err) {
                toastr.error('Invalid server response.');
                return;
              }

              if (!e.has_error) {
                toastr.success(e.message);

                if (typeof load_clients === 'function') load_clients();
                // if (typeof load_client_dd === 'function') load_client_dd();

                // reset form
                $('#client-name').val('').removeClass('is-invalid');
                $('#client-company-aff').val('');
                $('#client-cn').val('');
                $('#client-email').val('');
                $('#client_status').val('1');

                // optional: hide update button & show save button
                $('#update_client').hide();
                $('#save_client').show();

                // refresh the page shortly to ensure table state (matches your previous behavior)
                // setTimeout(function () {
                //   window.location.reload();
                // }, 500);
              } else {
                $('#client-name').addClass('is-invalid');
                toastr.error(e.message);
              }
            },
            error: function () {
              toastr.error("Something went wrong while updating client.");
            }
          });
        }
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {}
      }
    }
  });
});

var editClient = (data) => {
  // console.log(data.getAttribute('data-id'));
  $('#client_id').val(data.getAttribute('data-id'));

  $('#client-name').val(data.getAttribute('data-name'));
  $('#client-company-aff').val(data.getAttribute('data-affiliate'));
  $('#client-cn').val(data.getAttribute('data-cnum'));
  $('#client-email').val(data.getAttribute('data-email'));
  $('#client_status').val(data.getAttribute('data-status'));

  $('#save_client').hide();
  $('#update_client').show();
}
