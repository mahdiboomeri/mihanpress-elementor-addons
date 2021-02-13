// elementor dynamic carousel
function mp_dynamic_carousel() {
    var mp_dynamic_carousel = document.getElementsByClassName('mp-dynamic-carousel');

    for (var i = 0; i < mp_dynamic_carousel.length; i++) {
        mp_dynamic_carousel[i].classList.add('mp-dynamic-carousel-' + i);

        var carousel_data = JSON.parse(document.querySelector('.mp-dynamic-carousel-' + i).getAttribute("data-carousel"));
        var elem = document.querySelector('.mp-dynamic-carousel-' + i);
        var flkty = new Flickity(elem, {
            // options
            contain: carousel_data["loop"],
            wrapAround: carousel_data["loop"],
            autoPlay: parseInt(carousel_data["duration"]),
            pauseAutoPlayOnHover: true,
            groupCells: false,
            pageDots: carousel_data["dots"],
            prevNextButtons: carousel_data["nav_btn"],
            imagesLoaded: true,
            cellAlign: carousel_data["align"],
        });


    }
}
function mp_masonry_posts() {
    for (var i = 0; i < document.getElementsByClassName("elementor-masonry-grid").length; i++) {
        var item = document.getElementsByClassName("elementor-masonry-grid")[i];
        item.classList.add('elementor-masonry-grid-' + i);
        var data_column = parseInt(item.getAttribute("data-column"));
        var data_column_tablet = parseInt(item.getAttribute("data-column-tablet"));
        var data_column_mobile = parseInt(item.getAttribute("data-column-mobile"));

        var masonry = new Macy({
            container: '.elementor-masonry-grid-' + i,
            trueOrder: false,
            waitForImages: false,
            useOwnImageLoader: false,
            debug: true,
            mobileFirst: true,
            columns: data_column_mobile,
            breakAt: {
                1200: data_column,
                940: data_column_tablet,
                520: data_column_mobile,
            },
        });
    }
}
jQuery(window).on('elementor/frontend/init', function () {

    elementorFrontend.hooks.addAction('frontend/element_ready/mp_dynamic_carousel.default', function ($scope, $) {
        mp_dynamic_carousel();
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/mp_testimonial_carousel.default', function ($scope, $) {
        mp_dynamic_carousel();
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/mp_portfolio_filter.default', function ($scope, $) {
        for (var i = 0; i < document.getElementsByClassName("mixportfolio").length; i++) {
            document.getElementsByClassName("mixportfolio")[i].parentNode.className += ' mixportfolio-' + i;
            var containerEl = document.querySelector(".mixportfolio-" + i);
            var mixer = mixitup(containerEl, {
                controls: {
                    scope: 'local'
                }
            });
        }
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/mp-collapsible.default', function ($scope, $) {
        for (var i = 0; i < document.getElementsByClassName('mp-elementor-collapsible').length; i++) {
            document.getElementsByClassName('mp-elementor-collapsible')[i].className += ' collapsible-' + i;
            t = document.querySelectorAll(".collapsible-" + i)
            if (t[0].classList.contains('is_accordion')) { var is_accordion = true } else { var is_accordion = false }
            M.Collapsible.init(t, options = {
                accordion: is_accordion,
            });
        }

    });

    elementorFrontend.hooks.addAction('frontend/element_ready/mp_posts.default', function ($scope, $) {
        mp_masonry_posts();
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/mp_static_posts.default', function ($scope, $) {
        mp_masonry_posts();
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/mp-type-effect.default', function ($scope, $) {

        var elements = document.getElementsByClassName('typewrite');
        for (var i = 0; i < elements.length; i++) {
            elements[i].classList.add('typewrite-' + i)
            var the_element = document.getElementsByClassName('typewrite-' + i)[0];
            var toRotate = the_element.getAttribute('data-type');
            var period = the_element.getAttribute('data-period');
            if (toRotate) {
                new TxtType(the_element, JSON.parse(toRotate), period);
            }
        }
    });

    elementorFrontend.hooks.addAction('frontend/element_ready/mp-countdown.default', function ($scope, $) {
        for (var i = 0; i < document.getElementsByClassName("mp-countdown").length; i++) {
            var item = document.getElementsByClassName("mp-countdown")[i];
            item.classList.add('mp-countdown-' + i);

            var countdown_data = JSON.parse(item.getAttribute("data-countdown"));
            new TimezZ('.mp-countdown-' + i, {
                date: countdown_data["date"],
                text: {
                    days: countdown_data["labels"]["days"],
                    hours: countdown_data["labels"]["hours"],
                    minutes: countdown_data["labels"]["minutes"],
                    seconds: countdown_data["labels"]["seconds"]
                },
                template: '<div class="mp-countdown-item mb-2"><div class="mp-countdown-inner d-flex flex-column align-items-center"><span class="mp-countdown-digits">NUMBER</span><span class="mp-countdown-label">LETTER</span></div></div>',
                finished() {
                    if (countdown_data["redirect"]["enable"] == true) {
                        window.location.href = countdown_data["redirect"]["url"];
                    }
                    if (countdown_data["message"]["enable"] == true) {
                        item.insertAdjacentHTML("afterend", "<div class='mp-countdown__message'>" + countdown_data["message"]["content"] + "</div>");

                    }
                    if (countdown_data["hide"]["enable"] == true) {
                        item.classList.remove("d-flex");
                        item.classList.add("d-none");
                    }
                },
            });
        }
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/mp-pie-chart.default', function ($scope, $) {

        function isElementInViewport(el) {
            var rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        var elements = document.querySelectorAll(".chart-hidden");
        var random_number;
        var elem_json;

        function addClassOnScroll() {
            elements.forEach(element => {
                if (isElementInViewport(element)) {

                    random_number = Math.floor(1000 + Math.random() * 9000);
                    element.classList.replace("chart-hidden", "chart-" + random_number);
                    Add_Pie_Chart(document.querySelector(".chart-" + random_number));
                }
            });

        }

        window.addEventListener("load", addClassOnScroll);
        window.addEventListener("scroll", addClassOnScroll, { passive: true });

        function Add_Pie_Chart(element) {
            if (element && element.classList.contains("chart-added") === false) {
                element.classList.add("chart-added");
                elem_json = JSON.parse(element.getAttribute("data-chart"));

                new EasyPieChart(element, {
                    barColor: function (percent) {
                        var ctx = this.renderer.getCtx();
                        var canvas = this.renderer.getCanvas();
                        var gradient = ctx.createLinearGradient(0, 0, canvas.width, 0);
                        gradient.addColorStop(0, elem_json.color_a);
                        gradient.addColorStop(1, elem_json.color_b);
                        return gradient;
                    },
                    lineWidth: elem_json.linewidth,
                    scaleColor: elem_json.scalecolor,
                    size: elem_json.size
                });
            }
        }

    });
    elementorFrontend.hooks.addAction('frontend/element_ready/section', function ($scope, $) {
        var skew_items = document.querySelectorAll("*[data-skew-header]");
        var wave_items = document.querySelectorAll("*[data-waves-header]");
        var particles_items = document.querySelectorAll(".mp-particles-js");


        if (skew_items.length > 0) {
            var skew_html = '<div class="skew-bg mp-shape-bg">\n<div class="skew-bg--gradient-primary">\n<span class="skew-bg--shadow-main"></span>\n</div>\n<div class="skew-bg--gradient-secondary"></div>\n<span class="skew-bg--shadow-right"></span>\n<span class="skew-bg--shadow-left"></span>\n</div>';
            skew_items.forEach(element => {
                if (!element.querySelector(".skew-bg")) {
                    element.insertAdjacentHTML("afterbegin", skew_html);
                }
            });
        } else if (wave_items.length > 0) {
            var wave_html = '<div class="waves-container mp-shape-bg">\n<div class="wave-wrapper">\n<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">\n<defs>\n<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />\n</defs>\n<g class="parallax">\n<use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />\n<use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />\n<use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />\n<use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />\n</g>\n</svg>\n</div>\n</div>';
            wave_items.forEach(element => {
                if (!element.querySelector(".waves-container")) {
                    element.insertAdjacentHTML("afterbegin", wave_html);

                }
            });
        }

        if (particles_items.length > 0) {
            var random_num;
            particles_items.forEach(element => {
                random_num = Math.floor(Math.random() * 100);
                if (!element.querySelector(".mp-particle-container")) {
                    if (element.querySelector(".mp-shape-bg")) {
                        element.querySelector(".mp-shape-bg").insertAdjacentHTML("afterend", "<div class='mp-particle-container' id='particles-js-" + random_num + "'></div>")
                    } else {
                        element.insertAdjacentHTML("afterbegin", "<div class='mp-particle-container' id='particles-js-" + random_num + "'></div>");
                    }
                    particlesJS("particles-js-" + random_num, JSON.parse(element.getAttribute("data-particles")));

                    var i = 0;
                    var resize_calulate = setInterval(function () {
                        i++;
                        window.dispatchEvent(new Event('resize'));

                        if (i == 3) {
                            clearInterval(resize_calulate);
                        }
                    }, 1000)


                }
            });

        }
    });

});
