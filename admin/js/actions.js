var server_url = "http://localhost:8000/factoriotheory/";

// function login_user(data) {
//   $.ajax({
//     type: "POST",
//     url: server_url+"admin_login_process.php",
//     data: data,
//     cache: false,
//     dataType: 'json',
//     success: function(html) {
//       console.log(html.username+": logged in successfully");
//       admin_refresh_status(x=html.username, y=1);
//       admin_refresh();
//       log_refresh();
//     },
//     error: function(html) {
//       console.log("error logging in user");
//       show_admin_msg("There was an error attempting to log in.");
//       //admin_refresh_status(x="error", y=0);
//     }
//   });
// }

// function logout_user() {
//   $.ajax({
//     type: "POST",
//     url: server_url+"admin_logout_process.php",
//     cache: false,
//     dataType: 'json',
//     success: function() {
//       show_admin_msg("You have been successfully logged out.");
//       admin_refresh_status(x="logout", y=0);
//       admin_refresh();
//       log_refresh();
//     },
//     error: function() {
//       show_admin_msg("There was an error logging out");
//     }
//   });
// }

// function show_admin_msg(msg) {
//   var adminMsg = $("<p>").text(msg);
//   $("#admin_msg").append(adminMsg);
//   $(adminMsg).fadeIn().delay(5000).fadeOut('fast', function(){
//     $(this).remove();
//   });
// }

// // function admin_refresh(loc) {
// //   $.ajax({
// //     url: server_url+"admin_check_login.php",
// //     success: function(html) {
// //       $("#admin_data").load("view.php");
// //       console.log("authenticated");
// //     },
// //     error: function(html) {
// //       $("#admin_data").load("/saillotus/admin/admin_login_form.php");
// //       console.log("not authenticated");
// //     }
// //   });
// // } 

// function admin_refresh() {
//   $("#admin_data").load("view.php");
// }

// function log_refresh() {
//   var dest = server_url+"load_log.php";
//   $("#admin_log").load(dest);
// }

// function admin_refresh_status(x="username", y=0) {
//   if(y == 1) {
//     var logged_status_string = "Logged in as<span class='username'>"+x+"</span><a href='admin_logout_process.php' id='logout'>log out</a>";
//   } else {
//     var logged_status_string = "<a href='#' id='login_link'>Login</a>";
//   }
//   $("#admin_status").html(logged_status_string);
// }

// // data: can be anything the action will accept.
// // action: desitnation processor file (ex: save.php)
// // successMsg: content of message to be displayed.
// function admin_save(data, action, successMsg) {
//   $.ajax({
//     type: "POST",
//     url: action,
//     data: data,
//     cache: false,
//     success: function(data) {
//       show_admin_msg(successMsg);
//     }
//   });
//   admin_refresh();
//   log_refresh();
// }

// // actions
// $('#refresh').on("click", function(e) {
//   e.preventDefault();
//   admin_refresh();
//   log_refresh();
//   //admin_refresh_status();
// });

// admin actions that are loaded in view.php should be targeted via a container. see jQuery delegation
$("#admin")
//   .on("click", "#login_link", function(e) {
//     e.preventDefault();
//     $("#admin_data").load("admin_login_form.php");
//   })
//   .on("click", "#login", function() {
//     console.log("login button clicked");
//     var data = $("#admin_login").serialize();
//     login_user(data);      
//   })
//   .on("click", "#logout", function(e) {
//     e.preventDefault();
//     console.log("logout button clicked");
//     logout_user();
//   })
//   // save, edit, delete actions (save.php, etc...) should act upon the folder the table refrences.
//   .on("click", "#admin_add", function(e) {
//     e.preventDefault();
//     var data = $("#admin_data_new").serialize();
//     admin_save(data, "save.php", "Record Successfully Added.");      
//   })
//   .on("click", ".admin_edit", function(e) {
//     e.preventDefault();
//     var table = $(this).closest("table");
//     table.addClass("editing"); 
//   })
//   .on("click", ".admin_save", function(e) {
//     e.preventDefault();
//     var form_id = $(this).data("id");
//     var data = $("#admin_edit_"+form_id).serialize();
//     admin_save(data, "save.php", "Record Successfully Saved.");
//     var table = $(this).closest("table");
//     table.removeClass("editing");
//   })
//   .on("click", ".admin_delete", function(e) {
//     e.preventDefault();
//     // data should be prepared before passing to admin_save.
//     // Concatenation within the function call seems to break jQuery.
//     var data1 = $(this).data("id");
//     var data = "id="+data1;
//     admin_save(data, "delete.php", "Record Successfully Deleted.");
//   })
//   .on("click", ".admin_cancel", function(e) {
//     e.preventDefault();
//     var table = $(this).closest("table");
//     table.removeClass("editing");      
//   })
//   ;

// // thinker
// $(document).on({
//   ajaxStart: function() { $("#thinker").fadeIn("fast"); },
//   ajaxStop: function() { $("#thinker").fadeOut("fast"); }
// })

// qTips
.on("mouseover", ".has_tooltip", function(event) {
  $(this).qtip({
    hide: {
      //delay: 60000
    },
    overwrite: false,
    show: {
      event: event.type,
      ready: true
    },
    content: {
      text: $(this).next("div")
    },
    style: {
      classes: "qtip-lotus"
    },
    position: {
      my: 'right center',
      at: 'left center',
      target: $(this)
    }
  }, event);
})
.each(function(i) {
  $.attr($(this), "oldtitle", $.attr($(this), "title"));
  $(this).removeAttr("title");
})
;

function update_clock() {
  var ct = new Date();
  var ch = ct.getHours();
  var cm = ct.getMinutes();
  var cs = ct.getSeconds();
  cm = (cm < 10 ? "0" : "") + cm;
  cs = (cs < 10 ? "0" : "") + cs;
  var cts = ch + ":" + cm + ":" + cs;
  $("#time").html(cts);
}

// docready
$(function(){
  // admin_refresh();
  // log_refresh();
  setInterval('update_clock()', 1000);
});