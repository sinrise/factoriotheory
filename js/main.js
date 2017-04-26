$(function() {
    $('[title!=""]').qtip({
        position: {
            target: "mouse",
            adjust: {
                x: 15,
                y: 15
            }
        },
        style: {
            tip: {
                corner: !1
            }
        }
    }), $(".item").each(function(e) {
        $(this).qtip({
            content: $(this).next(".tip"),
            position: {
                target: "mouse",
                adjust: {
                    x: 15,
                    y: 15
                }
            },
            style: {
                tip: {
                    corner: !1
                }
            }
        });
    });
}), $(function() {
    $(".tab-head a").on("click", function(e) {
        e.preventDefault();
        var tar = $(this).data("target");
        $(".tab-head a").removeClass("active"), $(".tab").removeClass("active"), $(this).addClass("active"), 
        $(tar).addClass("active"), $("#tab_name").html($(this).attr("title"));
    });
});