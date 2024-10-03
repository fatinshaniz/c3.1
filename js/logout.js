$("#logout").on("click", function (e) {
  $.ajax({
    url: "./process/logout.php",
    type: "GET",
    datatype: "json",
    cache: false,
    success: function (data) {
      var obj = JSON.parse(data);
      if (obj.status == true && obj.msg == "logout") {
        console.log("logout");
        window.location.replace("./index.php");
      }
    },
  });
});
