$(document).ready(function () {
  // Login modal from index page
  $(document).on("click", "#showloginmodal, #login-btn", function (e) {
    e.preventDefault();
    $.ajax({
      url: "content/loginfrom.php",
      type: "post",
      success: function (data) {
        $("body").append(data); // Add the login modal to the body
        $("#loginmodal").modal("show"); // Show the login modal
        $("#registermodal").modal("hide"); // Hide the register modal (if open)
        $("#loginmodal").on("hidden.bs.modal", function () {
          $(this).remove(); // Remove the modal from the body when hidden
        });
      },
      error: function () {
        alert("Sorry for the technical issue!");
      },
    });
  });
  

  // Register modal from login modal
  $(document).on("click", "#registerbtn", function (e) {
    e.preventDefault();
    $.ajax({
      url: "content/registerform.php",
      type: "post",
      success: function (data) {
        $("body").append(data); // Add the register modal to the body
        $("#registermodal").modal("show"); // Show the register modal
        $("#loginmodal").modal("hide"); // Hide the login modal
        $("#registermodal").on("hidden.bs.modal", function () {
          $(this).remove(); // Remove the modal from the body when hidden
        });
      },
      error: function () {
        alert("Sorry for the technical issue!");
      },
    });
  });

  // handle login
  $(document).on("submit", "#login-form", function (e) {
    console.log("Login");
    e.preventDefault();
    var formData = new FormData(this);
    console.log(formData);
    $.ajax({
      url: "content/_loginhandle.php",
      type: "post",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        
        // Handle the response from the server
        if (response.status === "success") {
          $('#loginmodal').modal('hide');
          window.location.href = "home.php";
          
        } else if (response.status === "error") {
          // Show error messages
          alert(response.errors.join("\n"));
        }
      },
      error: function (data) {
        // Handle AJAX failure (optional)
        console.log(data);
        alert("Sorry for the technical issue!");
      },
    });
  });

  //Handle registration
  $(document).on("submit", "#register-form", function (e) {
    console.log("Register");
    e.preventDefault();
    var formData = new FormData(this);
    console.log(formData);
    $.ajax({
      url: "content/_registerhandle.php",
      type: "post",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        //Handle the response from the server
        if (response.status === "success") {
          $('#registermodal').modal('hide');
          // Redirect to home.php and pass age as a parameter
          window.location.href = "home.php";
        } else if (response.status === "error") {
          // Show error messages
          alert(response.errors.join("\n"));
        }
      },
      error: function () {
        // Handle AJAX failure (optional)
        alert("Sorry for the technical issue!");
      },
    });
  });
  // logout
  $(document).on("click", "#logout", function (e) {
    e.preventDefault();
    $.ajax({
      url: "content/_logouthandle.php",
      type: "post",
      success: function (response) {
        console.log(response);
        // Handle the response from the server
        if (response.status === "success") {
          // Redirect to home.php and pass age as a parameter
          window.location.href = "index.php";
        } else if (response.status === "error") {
          // Show error messages
          alert(response.errors.join("\n"));
        }
      },
      error: function (data) {
        console.log(data);
        // Handle AJAX failure (optional)
        alert("Sorry for the technical issue!");
      },
    });
  });

 
// home click


  // user current balance
  function getUserBalance() {
    $.ajax({
      url: "content/get_balance.php", 
      type: "POST",
      success: function(data) {
        $(".user_info").html(data);
      },
      error: function(data) {
        console.log(data);
        // alert("An error occurred while fetching the balance.");
      }
    });
  }
 
  // load table of contents
  function loadtable() {
    $.ajax({
      url: "content/load_data.php",
      type: "post",
      success: function(data) {
        $(".table").html(data);
        getUserBalance();
      },
      error: function() {
        alert("Failed to load table data.");
      }
    });
  }
  var currentPage = window.location.pathname.split("/").pop(); // Get the current page filename

  if (currentPage === "home.php") {
    loadtable();
  } else if (currentPage === "history.php") {
    loadhistory();
  }
  else if (currentPage === "analysis1.php") {
    getUserBalance();
  } else if (currentPage === "analysis2.php") {
    getUserBalance();
  } else if (currentPage === "contact.php") {
    getUserBalance();
  }

  function check_savings() {
    console.log("Checking savings...");
  
    $.ajax({
      url: "content/update_monthly_balance.php", // The PHP file that handles the salary check
      type: "POST", // Using POST method
      dataType: "json", // Expecting JSON response
      success: function(response) {
        if (response.status === 'success') {
          console.log("Message: " + response.message);
        } else if (response.status === 'error') {
          console.log("Message: " + response.message);
        }
      },
      error: function(error) {
        console.error("AJAX error: " + error);
      }
    });
  }
  
  check_savings();

  // Attach event listener to dynamically update the amount when purpose is selected
  $(document).on('change', '.purpose-dropdown', function() {
    console.log("ok");
    // Get the selected option's data-price attribute
    var selectedPrice = $(this).find(':selected').data('price');
    console.log("Selected price: " + selectedPrice); 

    // Get the associated amount field for this row
    var amountElement = $(this).closest('tr').find('.amount');
    console.log(amountElement);

    // Update the amount field with the selected price
    amountElement.text(selectedPrice);
});
      
  // spending form submit
  $(document).on("click", "#add", function (e) {
    e.preventDefault();
    console.log("Spending");
    var purpose = $('#purpose').val();
    var amount = $('#amount').val();
    var date = $('#mydate').val();
    var category = $('#category').val();

    if (!purpose || !amount || !date) {
        alert("All fields are required");
        return;
    }
    if (!category) {
      alert("please selete a catagory");
      return;
  }
    

    console.log(purpose, amount, date,category);

    $.ajax({
        url: "content/_spendinghandle.php",
        type: "post",
        data: {purpose: purpose, amount: amount, date: date,category:category},
        success: function (response) {
          console.log(response);
            if (response.status === "success") {
                $('#purpose').val('');
                $('#amount').val('');
                $('#mydate').val('');
                $('#category').prop('selectedIndex', 0); 
                loadtable();
            } else if (response.status === "error") {
                alert(response.errors);
                $('#purpose').val('');
                $('#amount').val('');
                $('#mydate').val('');
                $('#category').prop('selectedIndex', 0); 
                loadtable();
            }
        },
        error: function (data) {
          console.log(data);
            alert("Sorry for the technical issue!");
        }
    });
});
//opeing monthly wallet
$(document).on("click", "#wallet,#monthly-btn", function (e) {
  console.log("clicked");
  e.preventDefault();
  $.ajax({
    url: "content/monthlyWallet.php",
    type: "post",
    success: function (data) {
      $("body").append(data); // Add the login modal to the body
      $("#monthlyWallet").modal("show"); // Show the login modal
      $("#manualWallet").modal("hide");
      $("#monthlyWallet").on("hidden.bs.modal", function () {
        $(this).remove(); // Remove the modal from the body when hidden
      });
    },
    error: function () {
      alert("Sorry for the technical issue!");
    },
  });
});
//submit monthly wallet 
$(document).on("submit", "#monthly-form", function (e) {
  e.preventDefault(); // Prevent the default form submission
  $.ajax({
    url: "content/_submitmonthly.php", // Point to the PHP script for form processing
    type: "post",
    data: $(this).serialize(), // Serialize form data
    success: function (response,data) {
      console.log("Form submitted successfully");
      console.log(data);
      if (response.status === "success") {
        
        // Redirect to home.php and pass age as a parameter
        $.ajax({
          url: "content/ajaxhome.php",
          type: "get",
          success: function(homeContent) {
            // Assuming you have a div with id="content" to load home.php
            $("#monthlyWallet").modal("hide");
            $(".masthead").html(homeContent);
            loadtable();
            console.log("Home page loaded via AJAX");
          },
          error: function() {
            alert("Failed to load home page content.");
          }
        });
      } else if (response.status === "error") {
        // Show error messages
        alert(response.message);
      }
    },
    error: function () {
      alert("Sorry for the technical issue!");
    }
  });
});
//opening manual wallet 
$(document).on("click","#manual-btn", function (e) {
  console.log("clicked");
  e.preventDefault();
  $.ajax({
    url: "content/manualWallet.php",
    type: "post",
    success: function (data) {
      $("body").append(data); // Add the login modal to the body
      $("#manualWallet").modal("show"); // Show the login modal
      $("#monthlyWallet").modal("hide");
      $("#manualWallet").on("hidden.bs.modal", function () {
        $(this).remove(); // Remove the modal from the body when hidden
      });
    },
    error: function () {
      alert("Sorry for the technical issue!");
    },
  });
});

//submit manual wallet 
$(document).on("submit", "#manual-form", function (e) {
  e.preventDefault(); // Prevent the default form submission
  $.ajax({
    url: "content/_submitmanual.php", // Point to the PHP script for form processing
    type: "post",
    data: $(this).serialize(), // Serialize form data
    success: function (response) {
      console.log("Form submitted successfully");
      if (response.status === "success") {
        $("#manualWallet").modal("hide");
        // Redirect to home.php and pass age as a parameter
        $.ajax({
          url: "content/ajaxhome.php",
          type: "get",
          success: function(homeContent) {
            // Assuming you have a div with id="content" to load home.php
            $(".masthead").html(homeContent);
            loadtable();
            console.log("Home page loaded via AJAX");
          },
          error: function() {
            alert("Failed to load home page content.");
          }
        });
      } else if (response.status === "error") {
        // Show error messages
        console.log(response);
      }
    },
    error: function (data) {
      console.log(data);
    }
  });
});
//check monthly 
function checkmonthly() {
  console.log("Checking monthly salary...");

  $.ajax({
    url: "content/check_monthly.php", // The PHP file that handles the salary check
    type: "POST", // Using POST method
    dataType: "json", // Expecting JSON response
    success: function(response) {
      if (response.status === 'success') {
        // console.log("Message: " + response.message);
      } else if (response.status === 'error') {     
        // console.log("Message: " + response.message);
      }
    },
    error: function(error) {
      console.error(error);
    }
  });
}

checkmonthly();
//edit monthy
$(document).on("click", ".monthly_edit_btn", function (e) {
  e.preventDefault();
  console.log(" monthlyclicked");

  var rowId = $(this).data('id');
  var sourceCell = $('.source[data-id="' + rowId + '"]');
  var amountCell = $('.amount[data-id="' + rowId + '"]');

  var currentSource = sourceCell.text();
  var currentAmount = amountCell.text();

  // Replace the text with input fields
  sourceCell.html('<input type="text" class="form-control" value="' + currentSource + '" />');
  amountCell.html('<input type="number" class="form-control" value="' + currentAmount + '" />');

  // Change the edit icon to save icon
  $(this).html('<i class="bi bi-check-square"></i>').removeClass('monthly_edit_btn').addClass('monthly_edit_save');
});

$(document).on("click", ".monthly_edit_save", function (e) {
  e.preventDefault();
  console.log("Save clicked");

  var rowId = $(this).data('id'); // Retrieve the row ID from the button
  var row = $(this).closest('tr');
  
  var newSource = row.find('input[type="text"]').val();  // Get the new source value
  var newAmount = row.find('input[type="number"]').val();  // Get the new amount value


  // Send the updated data via AJAX
  $.ajax({
    url: "content/_updateMonthly.php", // The PHP script to handle the update
    type: "POST",
    data: { id: rowId, source: newSource, amount: newAmount }, // Data to be sent
    success: function (response) {
      if (response.status === "success") {
          // Update the table cells with new values
          row.find('.source').html(newSource);
          row.find('.amount').html(newAmount);
  
          // Change the save icon back to edit icon
          $('.monthly_edit_save[data-id="' + rowId + '"]').html('<i class="bi bi-pencil-square"></i>').removeClass('monthly_edit_save').addClass('monthly_edit_btn');
      } else if (response.status === "error") {
          // Check if errors exist before attempting to join them
          if (Array.isArray(response.errors)) {
              alert(response.errors.join("\n"));
          } else {
              alert(response.message || "An unknown error occurred.");
          }
      }
  },
  
    error: function (data) {
      console.log(data);
      alert("Sorry for the technical issue!");
    }
  });
});
// monthly delete 
$(document).on("click", ".monthly_dlt_btn", function (e) {
  e.preventDefault();

  // Get the ID of the row to delete
  var rowId = $(this).data('id');
  var row = $(this).closest('tr'); // Find the row containing the button

  // Confirm before deletion
  if (confirm("Are you sure you want to delete this entry?")) {
      // Send AJAX request to the server for soft delete
      $.ajax({
          url: "content/_deleteMonthly.php", // The PHP script to handle deletion
          type: "POST",
          data: { id: rowId },
          success: function (response) {
              if (response.status === "success") {
                  // Remove the row from the table
                  row.remove();
              } else {
                  alert(response.message || "Failed to delete entry.");
              }
          },
          error: function (data) {
              alert("An error occurred. Please try again.");
              console.log(data);
          }
      });
  }
});

//edit manual

$(document).on("click", ".manual_edit_btn", function (e) {
  e.preventDefault();
  console.log(" manualclicked");

  var rowId = $(this).data('id');
  var sourceCell = $('.source[data-id="' + rowId + '"]');
  var amountCell = $('.amount[data-id="' + rowId + '"]');

  var currentSource = sourceCell.text();
  var currentAmount = amountCell.text();

  // Replace the text with input fields
  sourceCell.html('<input type="text" class="form-control" value="' + currentSource + '" />');
  amountCell.html('<input type="number" class="form-control" value="' + currentAmount + '" />');

  // Change the edit icon to save icon
  $(this).html('<i class="bi bi-check-square"></i>').removeClass('manual_edit_btn').addClass('manual_edit_save');
});

$(document).on("click", ".manual_edit_save", function (e) {
  e.preventDefault();
  console.log("Save clicked");

  var rowId = $(this).data('id'); // Retrieve the row ID from the button
  var row = $(this).closest('tr');
  
  var newSource = row.find('input[type="text"]').val();  // Get the new source value
  var newAmount = row.find('input[type="number"]').val();  // Get the new amount value


  // Send the updated data via AJAX
  $.ajax({
    url: "content/_updateManual.php", // The PHP script to handle the update
    type: "POST",
    data: { id: rowId, source: newSource, amount: newAmount }, // Data to be sent
    success: function (response) {
      if (response.status === "success") {
          // Update the table cells with new values
          row.find('.source').html(newSource);
          row.find('.amount').html(newAmount);
  
          // Change the save icon back to edit icon
          $('.manual_edit_save[data-id="' + rowId + '"]').html('<i class="bi bi-pencil-square"></i>').removeClass('manual_edit_save').addClass('manual_edit_btn');
      } else if (response.status === "error") {
          // Check if errors exist before attempting to join them
          if (Array.isArray(response.errors)) {
              alert(response.errors.join("\n"));
          } else {
              alert(response.message || "An unknown error occurred.");
          }
      }
  },
  
    error: function (data) {
      console.log(data);
      alert("Sorry for the technical issue!");
    }
  });
});

// manual delete 
$(document).on("click", ".manual_dlt_btn", function (e) {
  e.preventDefault();

  // Get the ID of the row to delete
  var rowId = $(this).data('id');
  var row = $(this).closest('tr'); // Find the row containing the button

  // Confirm before deletion
  if (confirm("Are you sure you want to delete this entry?")) {
      // Send AJAX request to the server for soft delete
      $.ajax({
          url: "content/_deleteManual.php", // The PHP script to handle deletion
          type: "POST",
          data: { id: rowId },
          success: function (response) {
              if (response.status === "success") {
                  // Remove the row from the table
                  row.remove();
              } else {
                  alert(response.message || "Failed to delete entry.");
              }
          },
          error: function (data) {
              alert("An error occurred. Please try again.");
              console.log(data);
          }
      });
  }
});
// update spending

$(document).on("click", ".edit_btn", function (e) {
  e.preventDefault();
  
  var row = $(this).closest('tr');
  var date = row.find('.date-column').text().trim();  // Get the current date in 'dd-mm-yyyy' format
  var formattedDate = date.split('-').reverse().join('-'); // Change to 'yyyy-mm-dd' format
  var selectedOption = row.find('.purpose-dropdown').find('option:selected');
  var currentPurpose = selectedOption.val();
  window.parposeg = currentPurpose;
  var currentPrice = selectedOption.data('price');
  var purposeId = selectedOption.data('id'); // Renamed variable for consistency
      // Store the original values for restoration in case of errors
      originalDate = date;
      originalPurpose = currentPurpose;
      originalPrice = currentPrice;
  

  // Replace the current date, purpose dropdown, and price with input fields
  row.find('.date-column').html('<input type="date" class="form-control date-edit" value="' + formattedDate + '" style="color: white;">');
  row.find('.purpose-dropdown').replaceWith('<input type="text" class="form-control purpose-edit" value="' + currentPurpose + '" style="color: white;">');
  row.find('.amount').html('<input type="number" class="form-control price-edit" value="' + currentPrice + '" style="color: white;">');

  // Change the edit icon to save icon for the clicked button
  $(this).html('<i class="bi bi-check-square"></i>').removeClass('bi bi-pencil-square edit_btn').addClass('edit_save').data('id', purposeId); // Store purposeId in the button
  console.log("id : " + currentPrice );
});

$(document).on("click", ".edit_save", function (e) {
  e.preventDefault();

  var row = $(this).closest('tr');
  var newDate = row.find('.date-edit').val();  // Get the new date value
  var newPurpose = row.find('.purpose-edit').val();
  var newPrice = row.find('.price-edit').val();
  var purposeId = $(this).data('id'); // Retrieve purposeId correctly from the button
  var oldperpose=window.parposeg;
  console.log("id : " + oldperpose);
  // Send the updated data via AJAX to the PHP script
  $.ajax({
      url: "content/_updateSpending.php",  // PHP script for updating data
      type: "POST",
      data: { id: purposeId, date: newDate, purpose: newPurpose, price: newPrice,oldperpose:oldperpose},  // Send the new data
      success: function (response) {
        console.log(response);
          if (response.status === "success") {
             console.log("edit successfull");
             loadtable();
          } else {
            
              alert(response.errors);
             loadtable();
          }
      }.bind(this), // Bind 'this' for proper context
      error: function (data) {
          alert("An error occurred. Please try again.");
          console.log(data);
      }
  });
});
// delete data
$(document).on('click', '.delete-btn', function() {
  var date = $(this).data('date'); // Get the date from the data attribute
  var row = $(this).closest('tr');  // Reference to the row

  if (confirm("Are you sure you want to delete records for this date?")) {
      $.ajax({
          url: 'content/delete_record.php', // PHP script to handle the deletion
          type: 'POST',
          data: {date: date}, // Send the date to be deleted
          success: function(response) {
              // Handle success response
              if (response.status === 'success') {
                  row.remove(); // Remove the row from the table
                  loadtable();
              } else {
                  alert(response.message || 'Failed to delete record.');
              }
          },
          error: function(error) {
              // Handle error response
              console.error(error);
              alert('An error occurred while deleting the record.');
          }
      });
  }
});
// history
  // load  history table contents
  function loadhistory() {
    $.ajax({
      url: "content/load_history.php",
      type: "post",
      success: function(data) {
        $("#history").html(data);
        getUserBalance();
      },
      error: function() {
        alert("Failed to load table data.");
      }
    });
  }
// load history table

// edit history table
$(document).on("click", ".edit_btn_history", function (e) {
  e.preventDefault();
  
  var row = $(this).closest('tr');
  var date = row.find('.date-column').text().trim();  // Get the current date in 'dd-mm-yyyy' format
  var formattedDate = date.split('-').reverse().join('-'); // Change to 'yyyy-mm-dd' format
  var selectedOption = row.find('.purpose-dropdown').find('option:selected');
  var currentPurpose = selectedOption.val();
  window.historyparposeg = currentPurpose;
  var currentPrice = selectedOption.data('price');
  var purposeId = selectedOption.data('id'); // Renamed variable for consistency
      // Store the original values for restoration in case of errors
      originalDate = date;
      originalPurpose = currentPurpose;
      originalPrice = currentPrice;
  

  // Replace the current date, purpose dropdown, and price with input fields
  row.find('.date-column').html('<input type="date" class="form-control date-edit" value="' + formattedDate + '" style="color: white;">');
  row.find('.purpose-dropdown').replaceWith('<input type="text" class="form-control purpose-edit" value="' + currentPurpose + '" style="color: white;">');
  row.find('.amount').html('<input type="number" class="form-control price-edit" value="' + currentPrice + '" style="color: white;">');

  // Change the edit icon to save icon for the clicked button
  $(this).html('<i class="bi bi-check-square"></i>').removeClass('bi bi-pencil-square edit_btn_history').addClass('edit_save_history').data('id', purposeId); // Store purposeId in the button
  console.log("date: " +date);
});

$(document).on("click", ".edit_save_history", function (e) {
  e.preventDefault();

  var row = $(this).closest('tr');
  var newDate = row.find('.date-edit').val();  // Get the new date value
  var newPurpose = row.find('.purpose-edit').val();
  var newPrice = row.find('.price-edit').val();
  var purposeId = $(this).data('id'); // Retrieve purposeId correctly from the button
  var oldperpose=window.historyparposeg;
  console.log("id : " + oldperpose);
  // Send the updated data via AJAX to the PHP script
  $.ajax({
      url: "content/_updateSpending.php",  // PHP script for updating data
      type: "POST",
      data: { id: purposeId, date: newDate, purpose: newPurpose, price: newPrice,oldperpose:oldperpose},  // Send the new data
      success: function (response) {
        console.log(response);
          if (response.status === "success") {
             console.log("edit successfull");
             loadhistory();
          } else {
            
              alert(response.errors);
             loadhistory();
          }
      }.bind(this), // Bind 'this' for proper context
      error: function (data) {
          alert("An error occurred. Please try again.");
          console.log(data);
      }
  });
});

// delete history record
$(document).on('click', '.delete-btn_history', function() {
  var date = $(this).data('date'); // Get the date from the data attribute
  var row = $(this).closest('tr');  // Reference to the row

  if (confirm("Are you sure you want to delete records for this date?")) {
      $.ajax({
          url: 'content/delete_record.php', // PHP script to handle the deletion
          type: 'POST',
          data: {date: date}, // Send the date to be deleted
          success: function(response) {
              // Handle success response
              if (response.status === 'success') {
                  row.remove(); // Remove the row from the table
                  loadhistory();
              } else {
                  alert(response.message || 'Failed to delete record.');
              }
          },
          error: function(error) {
              // Handle error response
              console.error(error);
              alert('An error occurred while deleting the record.');
          }
      });
  }
});

});
