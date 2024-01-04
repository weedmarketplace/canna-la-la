/*!
    * Start Bootstrap - SB Admin Pro v1.3.0 (https://shop.startbootstrap.com/product/sb-admin-pro)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under SEE_LICENSE (https://github.com/StartBootstrap/sb-admin-pro/blob/master/LICENSE)
    */
    (function ($) {
    "use strict";

    // Enable Bootstrap tooltips via data-attributes globally
    $('[data-toggle="tooltip"]').tooltip();

    // Enable Bootstrap popovers via data-attributes globally
    // $('[data-toggle="popover"]').popover();

    // $(".popover-dismiss").popover({
    //     trigger: "focus"
    // });

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    $("#layoutSidenav_nav .sidenav a.nav-link").each(function () {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("sidenav-toggled");
    });

    // Activate Feather icons
    feather.replace();

    $(".group-checkable").on("change", function (e) {
        var set = $('tbody > tr > td:nth-child(1) input[type="checkbox"]', "#dataTable");
        var checked = $(this).is(":checked");
        $(set).each(function () {
            $(this).attr("checked", checked);
            $(this).attr("value", checked);
            $(this).trigger('change');
        });
    });

    // console.log('vvvvvv')
    // $(".group-checkable").on("click", function (e) {
    //     $(this).parents('tr').toggleClass("active");
    // });

    // Activate Bootstrap scrollspy for the sticky nav component
    $("body").scrollspy({
        target: "#stickyNav",
        offset: 82
    });

    // Scrolls to an offset anchor when a sticky nav link is clicked
    $('.nav-sticky a.nav-link[href*="#"]:not([href="#"])').click(function () {
        if (
            location.pathname.replace(/^\//, "") ==
            this.pathname.replace(/^\//, "") &&
            location.hostname == this.hostname
        ) {
            var target = $(this.hash);
            target = target.length ? target : $("[name=" + this.hash.slice(1) + "]");
            if (target.length) {
                $("html, body").animate({
                        scrollTop: target.offset().top - 81
                    },
                    200
                );
                return false;
            }
        }
    });

    // Click to collapse responsive sidebar
    $("#layoutSidenav_content").click(function () {
        const BOOTSTRAP_LG_WIDTH = 992;
        if (window.innerWidth >= 992) {
            return;
        }
        if ($("body").hasClass("sidenav-toggled")) {
            $("body").toggleClass("sidenav-toggled");
        }
    });

    // Init sidebar
    let activatedPath = window.location.pathname.match(/([\w-]+\.html)/, '$1');

    if (activatedPath) {
        activatedPath = activatedPath[0];
    } else {
        activatedPath = 'index.html';
    }

    let targetAnchor = $('[href="' + activatedPath + '"]');
    let collapseAncestors = targetAnchor.parents('.collapse');

    targetAnchor.addClass('active');

    collapseAncestors.each(function () {
        $(this).addClass('show');
        $('[data-target="#' + this.id + '"]').removeClass('collapsed');

    })

})(jQuery);

(function($) {
    $.fn.serializeFormJSON = function() {

        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
})(jQuery);

(function(){
    var Loading = function Loading() {
        this.el = false;
        this.add = function(el) {
            el.addClass('loading');
        }
        this.remove = function(el) {
            el.removeClass('loading');
        }
    };
  window.Loading = new Loading();
})(window);

function initTinymce() {
    tinymce.init({
        selector: '.wysihtml5',  // change this value according to your HTML
        plugins: 'image code link',
        a11y_advanced_options: true,
        // images_upload_handler: example_image_upload_handler,
        height: 400,
        image_class_list: [
            {title: 'None', value: ''},
            {title: 'Left', value: 'alignleft'},
            {title: 'Right', value: 'alignright'},
            {title: 'Center', value: 'alignnone size-full'}
        ]
    });
}

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + "").replace(",", "").replace(" ", "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}
function formatCurrency(value) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    }).format(value);
}