$(document).ready(function() {
  $("#wrapper").addClass("toggled");
  $(".sidebar-i").addClass("hide");
});

$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
  $(".sidebar-i").toggleClass("hide");
});