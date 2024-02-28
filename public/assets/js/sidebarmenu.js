/*
Template Name: Admin Template
Author: Wrappixel

File: js
*/
// ==============================================================
// Auto select left navbar
// ==============================================================
$(function () {
    var controller = window.location.href
        .split(window.location.origin + "/")[1]
        .split("/")[0];
    classname = window.location.href
        .split(window.location.origin + "/")[1]
        .split("/")[1];

    var url = window.location;
    var element = $("ul#sidebarnav a")
        .filter(function () {
            // console.log("this location href : " + this.href);
            // console.log("this current location href : " + url);
            // console.log(this.href == url);

            if (
                this.href == window.location.origin + "/" &&
                controller == "dashboard"
            ) {
                return this.href == window.location.origin + "/";
            }

            if (this.href == url) {
                console.log(this.href == url);
                return this.href == url;
            }

            if (this.href != url) {
                // console.log(
                //     this.href == window.location.origin + "/" + controller &&
                //         classname == "update"
                // );
                if (
                    this.href == window.location.origin + "/" + controller &&
                    classname == "update"
                ) {
                    return (
                        this.href == window.location.origin + "/" + controller
                    );
                }
            }
        })
        .addClass("active")
        .parent()
        .addClass("active");

    while (true) {
        if (element.is("li")) {
            element = element
                .parent()
                .addClass("in")
                .parent()
                .addClass("active")
                .children("a")
                .addClass("active");
        } else {
            break;
        }
    }
    $("#sidebarnav a").on("click", function (e) {
        if (!$(this).hasClass("active")) {
            // hide any open menus and remove all other classes
            $("ul", $(this).parents("ul:first")).removeClass("in");
            $("a", $(this).parents("ul:first")).removeClass("active");

            // open our new menu and add the open class
            $(this).next("ul").addClass("in");
            $(this).addClass("active");
        } else if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(this).parents("ul:first").removeClass("active");
            $(this).next("ul").removeClass("in");
        }
    });
    $("#sidebarnav >li >a.has-arrow").on("click", function (e) {
        e.preventDefault();
    });
});
