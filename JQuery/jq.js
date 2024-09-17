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
          // Redirect to home.php and pass age as a parameter
          window.location.href = "home.php";
          console.log("Home");
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
  // load table of contents
  function loadtable() {
    $.ajax({
      url: "content/load_data.php",
      type: "post",
      success: function(data) {
        $(".table").html(data);
      },
      error: function() {
        alert("Failed to load table data.");
      }
    });
  }

  // Call loadtable on document ready
  loadtable();
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

    if (!purpose || !amount || !date) {
        alert("All fields are required");
        return;
    }

    console.log(purpose, amount, date);

    $.ajax({
        url: "content/_spendinghandle.php",
        type: "post",
        data: {purpose: purpose, amount: amount, date: date},
        success: function (response,data) {
          console.log(response,data);
            if (response.status === "success") {
                window.location.href = "home.php";
            } else if (response.status === "error") {
                alert(response.errors.join("\n"));
            }
        },
        error: function () {
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
    success: function (response) {
      console.log("Form submitted successfully");
      if (response.status === "success") {
        $("#monthlyWallet").modal("hide");
        // Redirect to home.php and pass age as a parameter
        window.location.href = "home.php";
      } else if (response.status === "error") {
        // Show error messages
        alert(response.errors.join("\n"));
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
        $("#monthlyWallet").modal("hide");
        // Redirect to home.php and pass age as a parameter
        window.location.href = "home.php";
      } else if (response.status === "error") {
        // Show error messages
        alert(response.errors.join("\n"));
      }
    },
    error: function () {
      alert("Sorry for the technical issue!");
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
        console.log("Response Status: " + response.status);
        console.log("Message: " + response.message);
      } else if (response.status === 'error') {
        console.log("Response Status: " + response.status);
        console.log("Error: " + response.message);
      }
    },
    error: function(xhr, status, error) {
      console.error("AJAX error: " + error);
    }
  });
}

checkmonthly();

});
