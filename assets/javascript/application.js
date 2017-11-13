$(function () {
    mobileMenu.init();
});

var mobileMenu = {
    init: function () {
        $(".menu").on("click", function () {
            $("header .right").toggleClass("active");
        });
    }
}
