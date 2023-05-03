$(function () {
    "use strict";

    $(".preloader").fadeOut();
    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").on("click", function () {
        $("#main-wrapper").toggleClass("show-sidebar");
    });
    $(".search-box a, .search-box .app-search .srh-btn").on("click", function () {
        $(".app-search").toggle(200);
        $(".app-search input").focus();
    });

    // ==============================================================
    // Resize all elements
    // ==============================================================
    $("body, .page-wrapper").trigger("resize");
    $(".page-wrapper").delay(20).show();

    //****************************
    /* This is for the mini-sidebar if width is less then 1170*/
    //****************************
    var setsidebartype = function () {
        // var width = window.innerWidth > 0 ? window.innerWidth : this.screen.width;
        // if (width < 1170) {
        //     $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
        // } else {
        //     $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
        // }
        if (localStorage.getItem("data_sidebartype") !== null) {
            //localStorage.setItem("name", "GeeksforGeeks");
            $("#main-wrapper").attr("data-sidebartype", localStorage.getItem("data_sidebartype"));
        }
    };
    $(window).ready(setsidebartype);
    // $(window).on("resize", setsidebartype);
    $(document).on('click', '.sidebartoggler', function (e) {
        e.preventDefault()

        if (localStorage.getItem("data_sidebartype") == "mini-sidebar") {
            localStorage.setItem("data_sidebartype", "full");
        } else {
            localStorage.setItem("data_sidebartype", "mini-sidebar");
        }
        setsidebartype();
    });
});
