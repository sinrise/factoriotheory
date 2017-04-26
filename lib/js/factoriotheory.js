$(function(){
  //console.log("jQuery loaded");
  $('[title!=""]').qtip({
    position: {
      target: 'mouse', // Track the mouse as the positioning target
      adjust: { x: 15, y: 15 } // Offset it slightly from under the mouse
    },
    style: {
      tip: {
        corner: false
      }
    }
  });
  $(".item").each(function(e) {
    $(this).qtip({
      content: $(this).next(".tip"),
      position: {
        target: 'mouse', // Track the mouse as the positioning target
        adjust: { x: 15, y: 15 } // Offset it slightly from under the mouse
      },
      style: {
        tip: {
          corner: false
        }
      }
    });
  });
})