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
});
