$(document).ready(function () {
    load_expenses();
})

//load expenses table/grid
var load_expenses = () => {
    $(document).gmLoadPage({
       url: 'expense/get_expenses',
       load_on: '#load_expenses'
   });
  }

//compute balance onchange
$(document).on('keyup', '#aexp', function () {
    var money = $('#aamount').val();
    var expense = $('#aexp').val();
    var balance = 0;

    balance = money-expense;
    $("#balance").val(balance.toFixed(2));
}); 


$(document).on('click', '.edit_exp', function () {
  $('.act_exp').css('display','inline');
  $('.act_balance').css('display','inline');
  $('.act_image').css('display','inline');
  editFunction($(this).val(), $(this).data('edit'));
}); 

var editFunction = (x,y) => {
  $.post({
    url: 'expense/get_expense_details',
    // selector: '.form-control',
    data: {
        exp_id : x,
    },
    success:function(e)
        {
            var e = JSON.parse(e);
            $('#date_exp').val(e.Date);
            $('#desc').val(e.Descr);
            $('#aamount').val(e.Actual_Money);
            $('#aexp').val(e.expense);
            $('#balance').val(e.Balance);
            $('#ID').val(e.ID);
            $('#image_2').val(e.Image);
            
            $('#expbtn').css('display','none');
            
             if(e.Editted == 1 && y != ''){
              $('#expedit').css('display','none');
            } else {
              $('#expedit').css('display','inline');
            }
            
            $('#add_image').css('display','inline');
            // $('#Reset').css('display','inline');
    },
  })
}

$("#expbtn").click(function () {
    // $('.toprint').printThis();
    // Get the values from the form inputs
    var date = $("#date_exp").val();
    var description = $("#desc").val();
    var actualMoney = $("#aamount").val();
    var incharge = $("#incharge").val();
    var actualExpenses = $("#aexp").val();
    var balance = $("#balance").val(); // Since it's disabled, you may not want to include this here
    var branch = $("#Branch").val();
    // var image_2 = $("#image_2").val();
    
  
    // Get the uploaded image file
    var imageFile = $("#image")[0].files[0]; // This will get the first selected file (you can add validation if needed)
  
    // Create a FormData object to send both form data and the image
    var formData = new FormData();
    formData.append("Date_added", date);
    formData.append("Desc", description);
    formData.append("Actual_money", actualMoney);
    formData.append("Incharge", incharge);
    formData.append("Actual_Expenses", actualExpenses);
    formData.append("Balance", balance);
    formData.append("Branch", branch);
    // formData.append("image_2", image_2);
    formData.append("image", imageFile);
  
    // Use AJAX to send the form data and image to the server
    $.ajax({
      type: "POST",
      url: "expense/service/Expense_service/save",
      data: formData,
      processData: false, // Prevent jQuery from processing the data (important for file uploads)
      contentType: false, // Prevent jQuery from automatically setting the Content-Type header
      success: function (response) {
        var e = JSON.parse(response);
        if (e.has_error == false) {
          toastr.success(e.message);
        } else {
          toastr.error(e.message);
        }
        setTimeout(function() {
          window.location.reload();
      }, 2000);
      },
      error: function () {
        toastr.error("An error occurred during the upload.");
      },
    });
  });

  $("#expedit").click(function () {
  //  $('.toprint').printThis();
    // Get the values from the form inputs
    var date = $("#date_exp").val();
    var description = $("#desc").val();
    var actualMoney = $("#aamount").val();
    var incharge = $("#incharge").val();
    var actualExpenses = $("#aexp").val();
    var balance = $("#balance").val(); // Since it's disabled, you may not want to include this here
    var branch = $("#Branch").val();
    var ID = $("#ID").val();
    var image_2 = $("#image_2").val();
  
    // Get the uploaded image file
    var imageFile = $("#image")[0].files[0]; // This will get the first selected file (you can add validation if needed)
  
    // Create a FormData object to send both form data and the image
    var formData = new FormData();
    formData.append("image_2", image_2);
    formData.append("ID", ID);
    formData.append("Date_added", date);
    formData.append("Desc", description);
    formData.append("Actual_money", actualMoney);
    formData.append("Incharge", incharge);
    formData.append("Actual_Expenses", actualExpenses);
    formData.append("Balance", balance);
    formData.append("Branch", branch);
    formData.append("image", imageFile);
  
    // Use AJAX to send the form data and image to the server
    $.ajax({
      type: "POST",
      url: base_url + "expense/service/Expense_service/edit",
      data: formData,
      processData: false, // Prevent jQuery from processing the data (important for file uploads)
      contentType: false, // Prevent jQuery from automatically setting the Content-Type header
      success: function (response) {
        var e = JSON.parse(response);
        if (e.has_error == false) {
          toastr.success(e.message);
        } else {
          toastr.error(e.message);
        }
        setTimeout(function() {
          window.location.reload();
      }, 2000);
      },
      error: function () {
        toastr.error("An error occurred during the upload.");
      },
    });
  });
  
  $("#add_image").click(function () {
    var ID = $("#ID").val();
    var image_2 = $("#image_2").val();
    
    // Get the uploaded image file
    var imageFile = $("#image")[0].files[0]; // This will get the first selected file (you can add validation if needed)
  
    // Create a FormData object to send both form data and the image
    var formData = new FormData();
    formData.append("image_2", image_2);
    formData.append("ID", ID);
    formData.append("image", imageFile);
   
    // Use AJAX to send the form data and image to the server
    $.ajax({
      type: "POST",
      url: base_url + "expense/service/Expense_service/add_image",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        var e = JSON.parse(response);
        if (e.has_error == false) {
          toastr.success(e.message);
        } else {
          toastr.error(e.message);
        }
        setTimeout(function() {
          window.location.reload();
      }, 2000);
      },
      error: function () {
        toastr.error("An error occurred during the upload.");
      },
    });
  });
  
  // SINGLE RETURN OF IMAGE
//   $(document).on('click', '.clickable-row', function() {
//      var img = $(this).data('img');
//      console.log(img);
//      var imgTag = '<img id="paymentProofImage" src="'+base_url+'assets/uploaded/proofs/'+ img +'" alt="Proof of Receipt" class="img-fluid">';
//      $('.modal-body').html(imgTag);
//      $('#paymentProofModal').modal('show');
//      // alert();
//   });

  // MULTIPLE RETURN OF IMAGE
  $(document).on('click', '.clickable-row', function() {
    var img = $(this).data('img');
    separatedArray = img.split(', ');
    console.log(separatedArray);
    // Get a reference to the modal and the container within it
    const modal = document.getElementById('paymentProofModal');
    const container = document.getElementById('image-container');

    // Loop through the array and create <img> tags with src attributes
    for (let i = 0; i < separatedArray.length; i++) {
      const img = document.createElement('img');
      img.src = base_url+'assets/uploaded/proofs/'+separatedArray[i];
      img.classList.add('img-fluid');
      container.appendChild(img);
    }

    // Close the modal when the close button (×) is clicked
      const closeButton = document.getElementsByClassName('close')[0];
      closeButton.addEventListener('click', function() {
        // Clear all child elements within the container
        while (container.firstChild) {
          container.removeChild(container.firstChild);
        }
        modal.style.display = 'none';
      });
      // Close the modal when the user clicks outside of it
      window.addEventListener('click', function(event) {
        if (event.target === modal) {
           // Clear all child elements within the container
        while (container.firstChild) {
          container.removeChild(container.firstChild);
        }
          modal.style.display = 'none';
        }
      });
  });

  function sampleFunction(e,x){
    // window.location.href = base_url+"point_of_sale/payment/?custid="+x+'&oid='+e;
    // alert();
}

$(document).on('click', '.btn_void_exp', function() {
  if (confirm("Are you sure you want to void this expense?") == true) {
    $.post({
      url: base_url+'expense/service/Expense_service/void',
      data: {
          Expense_id: $(this).val(),
      },
      success: function(e) {
          var e = JSON.parse(e);
          if (e.has_error == false) {
              toastr.success(e.message);
              setTimeout(function() {
                window.location.reload();
            }, 2000);
          } else {
              toastr.error(e.message);
          }
      },
  })
  } else {
    return;
  }
  
});


$(document).on('click', '#submit_date_exp', function() {
  // console.log($('#d_from').val() + " "+ $('#d_to').val());
  $(document).gmLoadPage({
      url:  base_url+'expense/get_expenses',
      data: {
          d_from: $('#d_from').val(),
          d_to: $('#d_to').val(),
          branch: $('#branch_filter').val(),
      },
      load_on: "#load_expenses",
  })

});