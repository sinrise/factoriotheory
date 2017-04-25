$(function(){
  var tot = 0;
  $.each($('th'), function(i, v) {
    var w = $(this).attr("width");
    console.log($(this).text()+": "+w);
    tot += parseFloat(w);
  });
  console.log("total: "+tot+"%");
});