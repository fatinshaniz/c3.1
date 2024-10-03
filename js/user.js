var users = new Array();
staffID = $("#staff_ID").val();
staffPass = "";
$("#addUserComponent").show();
$("#deleteUserComponent").hide();
$("#updateAccessComponent").hide();
//start ajax block

$(document).ready(function () {
  $.ajax({
    url: "./process/display_user.php",
    type: "POST",
    async: false,
    cache: false,
    data: {
      staffID: staffID,
    },
    success: function (res) {
      var result = JSON.parse(res);
      $("#staff_Name").val(result.data[1].staff_Name);
      $("#staff_Email").val(result.data[1].staff_Email);
      staffPass = result.data[1].staff_Password;
      //   $("#staff_Dept").val(result.data[1].staff_Department).change();
      $(
        "#staff_Dept option[value='" + result.data[1].staff_Department + "'"
      ).attr("selected", "selected");
    },
    error: function (res) {
      alert(res.data);
    },
  }); //end ajax block
});

$("#updateDetailBtn").click(function () {
  staffName = $("#staff_Name").val();
  staffDept = $("#staff_Dept").val();
  staffEmail = $("#staff_Email").val();
  $.ajax({
    url: "./process/update_detail.php",
    type: "POST",
    async: false,
    cache: false,
    data: {
      staffID: staffID,
      staffName: staffName,
      staffDept: staffDept,
      staffEmail: staffEmail,
    },
    success: function (res) {
      var result = JSON.parse(res);
      //   console.log(result);
      if (result.msg == "success") {
        Swal.fire({
          title: "Success",
          text: "Details updated!",
          toast: true,
          position: "top-end",
          icon: "success",
          color: "#ffff",
          background: "#9CCC65",
          iconColor: "white",
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
        });
        setTimeout(function () {
          location.reload();
        }, 3500);
      }
    },
    error: function (res) {
      alert(res.data);
    },
  }); //end ajax block
});

$("#changePassBtn").click(function (e) {
  e.preventDefault();
  currentPass = $("#current_password").val();
  newPass = $("#new_password").val();
  confPass = $("#confirm_password").val();

  $.ajax({
    url: "./process/update_pass.php",
    type: "POST",
    async: false,
    cache: false,
    data: {
      staffID: staffID,
      staffPass: staffPass,
      currentPass: currentPass,
      newPass: newPass,
      confPass: confPass,
    },
    success: function (res) {
      var result = JSON.parse(res);
      console.log(result);
      if (result.msg == "success") {
        Swal.fire({
          title: "Success",
          text: "Password updated!",
          toast: true,
          position: "top-end",
          icon: "success",
          color: "#ffff",
          background: "#9CCC65",
          iconColor: "white",
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
        });
        setTimeout(function () {
          location.reload();
        }, 3500);
      } else if (result.msg == "currNotSame") {
        console.log(result.data);
        Swal.fire({
          title: "Error",
          text: '"Current Password" is not correct !',
          toast: true,
          position: "top-end",
          icon: "error",
          color: "#ffff",
          background: "#E91E63",
          iconColor: "white",
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
        });
      } else if (result.msg == "passNotSame") {
        Swal.fire({
          title: "Error",
          text: '"New Password" and "Confirm Password" should be same !',
          toast: true,
          position: "top-end",
          icon: "error",
          color: "#ffff",
          background: "#E91E63",
          iconColor: "white",
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
        });
      }
    },
    error: function (res) {
      alert(res.data);
    },
  }); //end ajax block
  // } else if ($("#current_password").val() != staffPass) {
  //   Swal.fire({
  //     title: "Error",
  //     text: '"Current Password" is not correct !',
  //     toast: true,
  //     position: "top-end",
  //     icon: "error",
  //     color: "#ffff",
  //     background: "#E91E63",
  //     iconColor: "white",
  //     showConfirmButton: false,
  //     timer: 3500,
  //     timerProgressBar: true,
  //   });
  // } else if ($("#confirm_password").val() != $("#new_password").val()) {
  //   Swal.fire({
  //     title: "Error",
  //     text: '"New Password" and "Confirm Password" should be same !',
  //     toast: true,
  //     position: "top-end",
  //     icon: "error",
  //     color: "#ffff",
  //     background: "#E91E63",
  //     iconColor: "white",
  //     showConfirmButton: false,
  //     timer: 3500,
  //     timerProgressBar: true,
  //   });
  // }
});

$("#addUserBtn").click(function (e) {
  staffName = $("#add_Staff_Name").val();
  staffDept = $("#add_Staff_Dept").val();
  staffEmail = $("#add_Staff_Email").val();
  staffID = $("#add_Staff_ID").val();
  staffPass = $("#add_New_Password").val();
  if ($("#add_Admin_Access").prop("checked") == true) {
    staffAccess = 1;
  } else {
    staffAccess = 0;
  }
  $.ajax({
    url: "./process/add_user.php",
    type: "POST",
    async: false,
    cache: false,
    data: {
      staffID: staffID,
      staffName: staffName,
      staffDept: staffDept,
      staffEmail: staffEmail,
      staffPass: staffPass,
      staffAccess: staffAccess,
    },
    success: function (res) {
      var result = JSON.parse(res);
      if (result.status == true) {
        Swal.fire({
          title: "Success",
          text: "User added !",
          toast: true,
          position: "top-end",
          icon: "success",
          color: "#ffff",
          background: "#9CCC65",
          iconColor: "white",
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
        });
        setTimeout(function () {
          location.reload();
        }, 3500);
      } else if (result.status == false) {
        Swal.fire({
          title: "Error",
          text: "Staff ID already exist !",
          toast: true,
          position: "top-end",
          icon: "eroor",
          color: "#ffff",
          background: "#E91E63",
          iconColor: "white",
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
        });
      }
    },
    error: function (res) {
      alert(res.data);
    },
  }); //end ajax block
});

$("#rstPassBtn").click(function () {
  staffID = $("#rst_Staff_ID").val();
  staffPass = $("#rst_New_Password").val();
  $.ajax({
    url: "./process/reset_pass.php",
    type: "POST",
    async: false,
    cache: false,
    data: {
      staffID: staffID,
      staffPass: staffPass,
    },
    success: function (res) {
      var result = JSON.parse(res);
      console.log("Ress~: " + result.status);
      if (result.status == true) {
        Swal.fire({
          title: "Success",
          text: "Password resetted !",
          toast: true,
          position: "top-end",
          icon: "success",
          color: "#ffff",
          background: "#9CCC65",
          iconColor: "white",
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
        });
        setTimeout(function () {
          location.reload();
        }, 3500);
      } else if (result.status == false) {
        Swal.fire({
          title: "Error",
          text: "Staff ID not exist !",
          toast: true,
          position: "top-end",
          icon: "eroor",
          color: "#ffff",
          background: "#E91E63",
          iconColor: "white",
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
        });
      }
    },
  }); //end ajax block
});

$("#delUserBtn").click(function () {
  staffID = $("#del_Staff_ID").val();
  Swal.fire({
    title: "Are you sure you want to delete the user?",
    showDenyButton: true,
    // showCancelButton: true,
    confirmButtonText: "No",
    denyButtonText: `Yes`,
  }).then((result) => {
    if (result.isConfirmed) {
    } else if (result.isDenied) {
      $.ajax({
        url: "./process/delete_user.php",
        type: "POST",
        async: false,
        cache: false,
        data: {
          staffID: staffID,
        },
        success: function (res) {
          var result = JSON.parse(res);
          console.log("Ress~: " + result.status);
          if (result.status == true) {
            Swal.fire({
              title: "Success",
              text: "User deleted !",
              toast: true,
              position: "top-end",
              icon: "success",
              color: "#ffff",
              background: "#9CCC65",
              iconColor: "white",
              showConfirmButton: false,
              timer: 3500,
              timerProgressBar: true,
            });
          } else if (result.status == false) {
            Swal.fire({
              title: "Error",
              text: "Staff ID not exist !",
              toast: true,
              position: "top-end",
              icon: "eroor",
              color: "#ffff",
              background: "#E91E63",
              iconColor: "white",
              showConfirmButton: false,
              timer: 3500,
              timerProgressBar: true,
            });
          }
        },
      }); //end ajax block
    }
  });
});

$("#updateAccessBtn").click(function () {
  staffID = $("#acc_Staff_ID").val();
  adminAccess = $("#acc_Admin").val();
  console.log(adminAccess);

  $.ajax({
    url: "./process/access_user.php",
    type: "POST",
    async: false,
    cache: false,
    data: {
      staffID: staffID,
      adminAccess: adminAccess,
    },
    success: function (res) {
      var result = JSON.parse(res);
      console.log("Ress~: " + result.status);
      if (result.status == true) {
        Swal.fire({
          title: "Success",
          text: "Admin access status changed !",
          toast: true,
          position: "top-end",
          icon: "success",
          color: "#ffff",
          background: "#9CCC65",
          iconColor: "white",
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
        });
      } else if (result.status == false) {
        Swal.fire({
          title: "Error",
          text: "Staff ID not exist !",
          toast: true,
          position: "top-end",
          icon: "eroor",
          color: "#ffff",
          background: "#E91E63",
          iconColor: "white",
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
        });
      }
    },
  }); //end ajax block
});

function showPassAdd() {
  var x = document.getElementById("add_New_Password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function showPassRst() {
  var x = document.getElementById("rst_New_Password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

// console.log($("input[type='radio']:checked").val());

$("#mainManage input").on("change", function () {
  if ($("input[name=flexRadioDefault]:checked", "#mainManage").val() == 1) {
    $("#addUserComponent").show();
    $("#deleteUserComponent").hide();
    $("#updateAccessComponent").hide();
  } else if (
    $("input[name=flexRadioDefault]:checked", "#mainManage").val() == 2
  ) {
    $("#addUserComponent").hide();
    $("#deleteUserComponent").show();
    $("#updateAccessComponent").hide();
  } else if (
    $("input[name=flexRadioDefault]:checked", "#mainManage").val() == 3
  ) {
    $("#addUserComponent").hide();
    $("#deleteUserComponent").hide();
    $("#updateAccessComponent").show();
  }
});
