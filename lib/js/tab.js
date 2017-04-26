$(function(){
  $(".tab-head a").on("click", function(e) {
    e.preventDefault();
    var tar = $(this).data("target");
    $(".tab-head a").removeClass("active");
    $(".tab").removeClass("active");
    $(this).addClass("active");
    $(tar).addClass("active");
  });
});