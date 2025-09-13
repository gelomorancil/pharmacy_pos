$('#create_quotation').click(function () {
    window.location.href = base_url + "/quotation/create";
})

var fill_in_item = (data) => {
    let selectedValue = data.value;
    $.post({
        url: base_url + 'inventory/Inventory/fill_in_item',
        data: {
            item_ID: selectedValue
        },
        success: function (e) {
            let response = JSON.parse(e);
            // let response = JSON.parse(res);

            // Fill Unit of Measure (select)
            $("#modal_specs").val(response.unit_id).trigger('change');

            // Fill Item Description
            $("#modal_desc").val(response.description);

            if (response.unit_of_measure.toLowerCase() === "box") {
                $("#modal_pcs").prop("disabled", false);
            } else {
                $("#modal_pcs").prop("disabled", true).val("");
            }

            console.log("Auto-filled:", response);
        },
        error: function () {
            toastr.error("Something went wrong.");
        }
    });
}

function view_q(row) {
    ID = $(row).data('id');
    window.location.href = base_url + 'Quotation/view?qID=' + ID;
}

function delete_q(row) {
    const ID = $(row).data('id');

    $.confirm({
        title: 'Confirmation',
        icon: 'fa fa-question-circle',
        content: 'Are you sure you want to delete the quotation?',
        buttons: {
            confirm: {
                text: 'Confirm',
                btnClass: 'btn-success',
                action: function () {
                    $.ajax({
                        url: 'quotation/delete_quotation',
                        type: 'POST',
                        dataType: 'json',
                        data: { ID: ID },
                        success: function (res) {
                            if (res.success) {
                                toastr.success(res.message);
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                toastr.error(res.message || "Failed to delete quotation.");
                            }
                        },
                        error: function () {
                            toastr.error("Something went wrong while deleting quotation.");
                        }
                    });
                }
            },
            cancel: {
                text: 'Cancel',
                btnClass: 'btn-danger'
            }
        }
    });
}

function approve_q(row) {
    const ID = $(row).data('id');

    $.confirm({
        title: 'Approval of Quotation to Purchase Order',
        icon: 'fa fa-question-circle',
        content: 'Are you sure you want to <b>APPROVE</b> the quotation?',
        buttons: {
            confirm: {
                text: 'Confirm',
                btnClass: 'btn-success',
                action: function () {
                    $.ajax({
                        url: 'quotation/approve_quotation',
                        type: 'POST',
                        dataType: 'json',
                        data: { ID: ID },
                        success: function (res) {
                            if (res.success) {
                                toastr.success(res.message);
                                setTimeout(() => location.reload(), 2000);
                            } else {
                                toastr.error(res.message || "Failed to approve quotation.");
                            }
                        },
                        error: function () {
                            toastr.error("Something went wrong while approving quotation.");
                        }
                    });
                }
            },
            cancel: {
                text: 'Cancel',
                btnClass: 'btn-danger'
            }
        }
    });
}