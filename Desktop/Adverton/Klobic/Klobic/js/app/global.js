!function(e) {
    function t(i) {
        if (n[i])
            return n[i].exports;
        var a = n[i] = {
            exports: {},
            id: i,
            loaded: !1
        };
        return e[i].call(a.exports, a, a.exports, t),
        a.loaded = !0,
        a.exports
    }
    var n = {};
    return t.m = e,
    t.c = n,
    t.p = "",
    t(0)
}([
    function(e, t, n) {
        e.exports = n(12)
    },
    function(e, t, n) {
        "use strict";
        function i(e) {
            return e && e.__esModule
                ? e
                : {
                    default: e
                }
        }
        function a(e, t, n) {
            return t in e
                ? Object.defineProperty(e, t, {
                    value: n,
                    enumerable: !0,
                    configurable: !0,
                    writable: !0
                })
                : e[t] = n,
            e
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var o,
            r = n(20),
            s = i(r),
            l = function(e) {
                return new s.default(e)
            },
            d = function(e) {
                return e.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;")
            };
        s.default.prototype = (o = {
            length: 0,
            find: function(e) {
                for (var t = new s.default, n = void 0, i = 0; i < this.length; i++) {
                    n = new s.default(e, this[i]);
                    for (var a = 0; a < n.length; a++)
                        t[t.length++] = n[a]
                }
                return t
            },
            addClass: function(e) {
                for (var t = 0; t < this.length; t++)
                    this[t].classList.contains(e) !== !0 && this[t].classList.add(e);
                return this
            },
            hasClass: function(e) {
                for (var t = !1, n = 0; n < this.length; n++)
                    if (this[n].classList.contains(e) === !0) {
                        t = !0;
                        break
                    }
                return t
            },
            removeClass: function(e) {
                for (var t = this.length - 1; t >= 0; t--)
                    this[t].classList.contains(e) === !0 && this[t].classList.remove(e);
                return this
            },
            toggleClass: function(e) {
                for (var t = 0; t < this.length; t++)
                    this[t].classList.toggle(e);
                return this
            },
            remove: function() {
                for (var e = this.length - 1; e >= 0; e--)
                    this[e].parentNode && this[e].parentNode.removeChild(this[e]);
                return this
            },
            get: function(e) {
                return 1 === this.length
                    ? null
                    : (this[0] = this[e], this.length = 1, "undefined" == typeof this[0]
                        ? null
                        : this)
            },
            data: function(e) {
                return this[0].getAttribute("data-" + e)
            },
            css: function(e) {
                for (var t = 0; t < this.length; t++) {
                    var n = !0,
                        i = !1,
                        a = void 0;
                    try {
                        for (var o, r = Object.keys(e)[Symbol.iterator](); !(n = (o = r.next()).done); n = !0) {
                            var s = o.value;
                            this[t].style[s] = e[s]
                        }
                    } catch (e) {
                        i = !0,
                        a = e
                    } finally {
                        try {
                            !n && r.return && r.return ()
                        } finally {
                            if (i)
                                throw a
                        }
                    }
                }
                return this
            },
            val: function() {
                return this[0] && this[0].value || ""
            },
            text: function(e) {
                return this.html(d(e))
            },
            html: function(e) {
                for (var t = 0; t < this.length; t++)
                    this[t].innerHTML = e;
                return this
            },
            height: function() {
                return this[0]
                    ? this[0].offsetHeight
                    : null
            },
            width: function() {
                return this[0]
                    ? this[0].offsetWidth
                    : null
            },
            on: function(e, t, n) {
                if (this.length)
                    for (var i = 0; i < this.length; i++)
                        this[i].addEventListener(e, t, n)
            },
            appendChild: function(e) {
                if (this.length)
                    for (var t = 0; t < this.length; t++)
                        for (var n = 0; n < e.length; n++)
                            this[t].appendChild(e[n])
            },
            innerHTML: function(e) {
                if (this.length)
                    for (var t = 0; t < this.length; t++)
                        this[t].innerHTML = e
            }
        }, a(o, "appendChild", function(e) {
            if (this.length)
                for (var t = 0; t < this.length; t++)
                    for (var n = 0; n < e.length; n++)
                        this[t].appendChild(e[n])
        }), a(o, "innerHTML", function(e) {
            if (this.length)
                for (var t = 0; t < this.length; t++)
                    this[t].innerHTML = e
        }), a(o, "attr", function(e) {
            var t = arguments.length > 1 && void 0 !== arguments[1]
                ? arguments[1]
                : null;
            if (this.length) {
                if (t)
                    for (var n = 0; n < this.length; n++)
                        this[n].setAttribute(e, t);
            return this[0].getAttribute(e)
            }
            return null
        }), a(o, "append", function(e) {
            this.length && this[0].appendChild(e)
        }), a(o, "innerHTML", function(e) {
            if (this.length)
                for (var t = 0; t < this.length; t++)
                    this[t].innerHTML = e
        }), a(o, "css", function(e) {
            if (this.length)
                for (var t = 0; t < this.length; t++)
                    for (var n in e)
                        ({}).hasOwnProperty.call(e, n) && (this[t].style[n] = e[n])
        }), o),
        t.default = l
    },
    function(e, t, n) {
        "use strict";
        function i(e) {
            return e && e.__esModule
                ? e
                : {
                    default: e
                }
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        }),
        t.trackGAEvents = t.initTooltips = t.verticalScrollTo = t.deferImages = t.elementIsVisible = t.getWindowScrollTop = t.objToQueryString = t.onDocumentReady = t.resolutionBreakpoints = void 0;
        var a = n(1),
            o = i(a),
            r = n(19),
            s = i(r),
            l = n(18),
            d = i(l),
            c = (t.resolutionBreakpoints = function() {
                var e = {},
                    t = {
                        xs: 576,
                        sm: 768,
                        md: 992,
                        lg: 1200
                    };
                for (var n in t)
                    ({}).hasOwnProperty.call(t, n) && (e[n] = [
                        t[n] - 1,
                        t[n]
                    ]);
                return e
            },
            t.onDocumentReady = function(e) {
                "complete" === document.readyState || "interactive" === document.readyState
                    ? e.call()
                    : document.addEventListener("DOMContentLoaded", function() {
                        e.call()
                    })
            },
            t.objToQueryString = function(e) {
                var t = [],
                    n = !0,
                    i = !1,
                    a = void 0;
                try {
                    for (var o, r = Object.keys(e)[Symbol.iterator](); !(n = (o = r.next()).done); n = !0) {
                        var s = o.value;
                        t.push(encodeURIComponent(s) + "=" + encodeURIComponent(e[s]))
                    }
                } catch (e) {
                    i = !0,
                    a = e
                } finally {
                    try {
                        !n && r.return && r.return ()
                    } finally {
                        if (i)
                            throw a
                    }
                }
                return t.join("&")
            },
            t.getWindowScrollTop = function() {
                return window.pageYOffset
                    ? window.pageYOffset
                    : document.documentElement.clientHeight
                        ? document.documentElement.scrollTop
                        : document.body.scrollTop
            });
        t.elementIsVisible = function(e) {
            var t = e.getBoundingClientRect(),
                n = t.top,
                i = t.height,
                a = e.parentNode;
            do
                {
                    if(t = a.getBoundingClientRect(), !(n <= t.bottom))
                        return !1;
            if (n + i <= t.top)
                    return !1;
                a = a.parentNode
            } while (a !== document.body);
            return n <= document.documentElement.clientHeight - i / 2
        },
        t.deferImages = function() {
            for (var e = document.getElementsByTagName("img"), t = 0; t < e.length; t++)
                e[t].getAttribute("data-src") && e[t].setAttribute("src", e[t].getAttribute("data-src"))
        },
        t.verticalScrollTo = function(e, t, n) {
            var i = arguments.length > 3 && void 0 !== arguments[3]
                    ? arguments[3]
                    : "easeInOutQuad",
                a = e,
                o = document.body === a
                    ? c()
                    : a.scrollTop,
                r = "number" == typeof t && Math.floor(t) === t
                    ? t - o
                    : t.getBoundingClientRect().top,
                l = 0,
                d = 20,
                u = function e() {
                    l += d,
                    document.body === a
                        ? window.scrollTo(0, s.default[i](l, o, r, n))
                        : a.scrollTop = s.default[i](l, o, r, n),
                    l < n && setTimeout(e, d)
                };
            u()
        },
        t.initTooltips = function() {
            for (var e = arguments.length > 0 && void 0 !== arguments[0]
                ? arguments[0]
                : '[data-toggle="tooltip"]', t = arguments.length > 1 && void 0 !== arguments[1]
                ? arguments[1]
                : {
                    animation: !0,
                    placement: "top",
                    duration: 150,
                    delay: 100
                }, n = 0; n <= (0, o.default)(e).length - 1; n++) {
                var i = new d.default;
                i.init((0, o.default)(e)[n], t)
            }
        },
        t.trackGAEvents = function(e, t, n) {
            window.ga("b.send", "event", e, t, n)
        }
    },
    function(e, t, n) {
        "use strict";
        function i(e) {
            return e && e.__esModule
                ? e
                : {
                    default: e
                }
        }
        var a = n(1),
            o = i(a),
            r = n(17),
            s = i(r),
            l = n(2),
            d = function() {
                var e = (0, o.default)('.home [data-gatrack="1"]');
                e.on("click", function(e) {
                    window.ga("b.send", "event", "Homepage", "Click", (0, o.default)(e.currentTarget).data("gatrack-name"))
                })
            },
            c = function(e, t, n) {
                var i = arguments.length > 3 && void 0 !== arguments[3]
                        ? arguments[3]
                        : null,
                    a = (0, o.default)(e),
                    r = a.find(t),
                    s = a.find(n);
                r.on("click", function(e) {
                    var r = (0, o.default)(t + ".selected"),
                        l = (0, o.default)(e.currentTarget);
                    if (!l.hasClass("selected")) {
                        var d = l.data("number"),
                            c = a.find(n + d);
                        if (i) {
                            var u = a.find(".visible"),
                                f = l.data("bg"),
                                h = (0, o.default)(i + "." + f);
                            u[0] !== h[0] && (h.addClass("visible"), u.removeClass("visible"))
                        }
                        s.addClass("fade-out"),
                        r.removeClass("selected"),
                        l.addClass("selected"),
                        c.removeClass("fade-out")
                    }
                })
            },
            u = function() {
                window.innerWidth > (0, l.resolutionBreakpoints)().md[0] && (0, l.verticalScrollTo)(document.body, (0, o.default)(".how-klobic-works")[0],
                300)
            },
            f = function() {
                var e = (0, o.default)(".slider");
                if (navigator.msMaxTouchPoints)
                    e.addClass("ms-touch"),
                    e.on("scroll", function() {
                        (0, o.default)(".slide-image")[0].style.transform = "translate3d(-" + (100 - this.scrollLeft / 6) + "'px, 0, 0)"
                    });
                else {
                    var t = new s.default;
                    t.bindUIEvents()
                }
            };
        window.initNewHDPage = function() {
            d(),
            f(),
            $('[data-toggle="tooltip"]').tooltip(),
            (0, o.default)(".home .discover").on("click", u),
            c(".everything-you-need", ".no-coding-skills", ".image-container"),
            c(".responsive-and-animated", ".get-more-clicks", ".image-container"),
            c(".social-media-visuals", ".social-media-strategy", ".image-container", ".background"),
            "complete" === document.readyState
                ? (0, l.deferImages)()
                : document.onreadystatechange = function() {
                    "complete" === document.readyState && (0, l.deferImages)()
                }
        }
    },
    function(e, t, n) {
        "use strict";
        var i = n(2),
            a = {
                settings: {},
                trackEvent: function(e, t) {
                    var n = t || null;
                    //window.Intercom("trackEvent", e, n)
                },
                boot: function(e) {
                    e && this.setUserData(e),
                    //window.Intercom("boot", this.settings),
                    localStorage.getItem("intercomBooted") || (this.trackEvent("Sign in"), localStorage.setItem("intercomBooted", !0))
                },
                shutdown: function() {
                    //window.Intercom("shutdown"),
                    localStorage.removeItem("intercomBooted")
                },
                update: function(e) {
                    //window.Intercom("update", e),
                    this.setUserData(e)
                },
                init: function(e) {
                    this.setUserData(e),
                    window.intercomSettings = e;
                    var t = window,
                        n = t.Intercom;
                    if ("function" == typeof n)
                        n("reattach_activator"),
                        n("update", window.intercomSettings);
                    else {
                        var i = function() {
                                var t = a.createElement("script");
                                t.type = "text/javascript",
                                t.async = !0,
                                t.src = "https://widget.intercom.io/widget/" + e.app_id;
                                var n = a.getElementsByTagName("script")[0];
                                n.parentNode.insertBefore(t, n)
                            },
                            a = document,
                            o = function e() {
                                e.c(arguments)
                            };
                        o.q = [],
                        o.c = function(e) {
                            o.q.push(e)
                        },
                        t.Intercom = o,
                        t.attachEvent
                            ? t.attachEvent("onload", i)
                            : t.addEventListener("load", i, !1)
                    }
                    "undefined" != typeof window.router && window.router && window.router.onChangeRoute(function() {
                        this.boot()
                    }.bind(this), !0)
                },
                setUserData: function(e) {
                    for (var t in e)
                        e.hasOwnProperty(t) && ("company_id" === t
                            ? this.settings.companies = [
                                {
                                    company_id: e[t],
                                    name: "Company_" + e[t]
                                }
                            ]
                            : this.settings[t] = e[t]);
                    this.settings.last_login = this.getDate()
                },
                getDate: function() {
                    var e = new Date,
                        t = [
                            "January",
                            "February",
                            "March",
                            "April",
                            "May",
                            "June",
                            "July",
                            "August",
                            "September",
                            "October",
                            "November",
                            "December"
                        ];
                    return e.getDate() + "-" + t[e.getMonth()] + "-" + e.getFullYear()
                },
                getHotjarId: function() {
                    try {
                        return window.hj.pageVisit.property.get("userId").split("-").shift()
                    } catch (e) {
                        return null
                    }
                }
            };
        //window.IntercomScript = a;
        try {
            var o = !window.WL_DOMAIN && !window.IS_BLOG && window.intercomConfig;
            o && !function() {
                a.init(window.intercomConfig);
                var e = new Date,
                    t = setInterval(function() {
                        var n = new Date - e,
                            i = a.getHotjarId();
                        i && a.update({hotjar_id: i}),
                        (i || n > 5e3) && clearInterval(t)
                    }, 100)
            }()
        } catch (e) {
            console.log("Intercom error:" + e)
        }
        (0, i.onDocumentReady)(function() {
            window.intercomUserData && a.boot(window.intercomUserData)
        })
    },
    function(e, t) {
        "use strict";
        window.LoaderHover = function(e, t) {
            var n = $('<div class="loader-hover">    <div class="loader-overlay"></div>    <svg preserveAspectRatio="none" version="1.1" width="32px" height="32px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" fill="#fff" viewBox="0 0 51 51" style="">        <defs>            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">                <stop offset="0%"></stop>                <stop offset="100%"></stop>            </linearGradient>        </defs>        <path d="M25.5,4C37.4,4,47,13.6,47,25.5S37.4,47,25.5,47S4,37.4,4,25.5S13.6,4,25.5,4 M25.5,0C11.4,0,0,11.4,0,25.5C0,39.6,11.4,51,25.5,51C39.6,51,51,39.6,51,25.5C51,11.4,39.6,0,25.5,0L25.5,0z" fill="url(#grad1)"></path>        <path class="actionMask" fill="transparent" fill-rule="evenodd" clip-rule="evenodd" d="M25.5,0C39.6,0,51,11.4,51,25.5S39.6,51,25.5,51S0,39.6,0,25.5S11.4,0,25.5,0z"></path>    </svg></div>');
            this.loader = n;
            var i = {
                fadeTo: .15
            };
            if (t = t || {}, t = $.extend(i, t), e.length) {
                this.hoverElement = e,
                this.footer = $("body").find(".footer");
                var a = e.offset(),
                    o = e.outerWidth(),
                    r = e.outerHeight(),
                    s = $(window);
                if (n.css({
                    left: a.left + "px",
                    top: a.top + "px",
                    height: r,
                    width: o
                }), r > s.height()) {
                    n.addClass("fixed");
                    var l = Math.min(o, s.width()) / 2 + a.left;
                    n.find("svg").css({
                        left: l + "px",
                        position: "fixed"
                    })
                }
                if (this.originalOpacity = 1, e.hasClass("save-group")) {
                    e.fadeTo(100, 0);
                    var d = n.find("svg");
                    d.css("left", 115),
                    d.find('stop[offset="100%"]').css({"stop-color": "rgb(58, 161, 93)"})
                } else
                    e.fadeTo(100, t.fadeTo),
                    this.footer.animate({
                        opacity: t.fadeTo
                    }, 100);
                $("body").append(n);
                var c = this;
                this.offsetInterval = setInterval(function() {
                    if (!e.closest("html").length)
                        return c.remove(),
                        !1;
                    var t = e.offset(),
                        i = e.outerWidth(),
                        l = e.outerHeight();
                    if (t.top !== a.top || t.left !== a.left || l !== r || i !== o)
                        if (n.css({
                            left: t.left + "px",
                            top: t.top + "px",
                            height: l,
                            width: i
                        }), a = t, o = i, r = l, r > $(window).height()) {
                            n.addClass("fixed");
                            var d = Math.min(o, s.width()) / 2 + a.left;
                            n.find("img").css({
                                left: d + "px",
                                position: "fixed"
                            })
                        } else
                            n.removeClass("fixed")
                }, 100)
            }
        },
        LoaderHover.prototype = {
            setSmallSize: function(e) {
                e
                    ? this.loader.addClass("small")
                    : this.loader.removeClass("small")
            },
            setMediumSize: function(e) {
                e
                    ? this.loader.addClass("medium")
                    : this.loader.removeClass("medium")
            },
            setTransparent: function(e) {
                e
                    ? this.loader.addClass("transparent")
                    : this.loader.removeClass("transparent")
            },
            setZIndex: function(e) {
                this.loader.css("z-index", e)
            },
            setOriginalOpacity: function(e) {
                this.originalOpacity = e
            },
            remove: function() {
                clearInterval(this.offsetInterval),
                this.hoverElement && (this.hoverElement.stop().fadeTo(100, this.originalOpacity), this.footer.animate({
                    opacity: this.originalOpacity
                }, 100)),
                this.loader.remove()
            }
        }
    },
    function(e, t) {
        "use strict";
        window.MakeBannerPopin = function() {
            return WL_DOMAIN
                ? (WL_DATA.banner_count_limit <= WL_DATA.user_banners_this_cycle && WL_DATA.banner_count_limit != -1
                    ? router.routeTo("/banner-maker/html5/")
                    : (BSModal({
                        title: "Can't create more banners",
                        htmlContent: "You have reached the maximum number of banners!",
                        buttons: {
                            okButton: !1
                        }
                    }), location.href = "#_"), !1)
                : void this.init()
        },
        window.MakeBannerPopin.prototype = {
            init: function() {
                var e = this,
                    t = "Choose banner type",
                    n = '<div class="modal fade large make-banner-popin" tabindex="-1" role="dialog" >   <div class="modal-dialog">       <div class="modal-content">           <div class="modal-header">               <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>               <h4 class="modal-title">' + t + '</h4>           </div>           <div class="modal-body">' + e.getBodyHtml() + "</div>       </div>   </div></div>",
                    i = $(n);
                e.modal = i.modal();
                var a = function() {
                    i.modal("hide")
                };
                "#make-a-banner" == location.hash && window.addEventListener("hashchange", a, !1),
                i.on("hidden.bs.modal", function() {
                    window.removeEventListener("hashchange", a, !1),
                    i.remove(),
                    "#make-a-banner" == location.hash && (location.hash = "#_")
                }),
                router && router.parseNavLinks(i),
                e.buttonsClickHandler()
            },
            getBodyHtml: function() {
                var e = "";
                hasFlash() || (e = "disabled");
                var t = langPre + (WL_DOMAIN
                        ? "/banner-maker/html5/"
                        : "/banner-creator/"),
                    n = '<div class="row text-center">     <div class="col col-xs-5 html5-app">         <a class="nav-link" data-gatrack="1" data-gatrack-name="Create HTML5 banner - image" href="' + t + '">             <div class="col-xs-12 img"></div>         </a>         <p class="col-xs-12 editor-type">             <span class="new-editor">New editor</span>         </p>         <a class="btn btn-default btn-sm nav-link" data-gatrack="1" data-gatrack-name="Create HTML5 banner - button" href="' + t + '">HTML5 banner</a>         <p>             Download HTML5, JPG, PNG, GIF             <br>             Embed HTML5 (full)         </p>     </div>     <div class="col col-xs-2 mid-or">or</div>     <div class="col col-xs-5 flash-app flash-' + e + '">         <a class="nav-link" data-gatrack="1" data-gatrack-name="Create Flash banner - image" href="' + langPre + '/banner-maker/software/">             <div class="col-xs-12 img"></div>         </a>         <p class="col-xs-12 editor-type">             Classic editor             <span>(Flash based)</span>         </p>         <a class="btn btn-default btn-sm nav-link ' + e + '" data-gatrack="1" data-gatrack-name="Create Flash banner - button" href="' + langPre + '/banner-maker/software/">Flash banner</a>         <p>             Download SWF (Flash), JPG, PNG, GIF, MP4             <br>             Embed Flash/HTML5 (limited)         </p>     </div></div>';
                return n
            },
            buttonsClickHandler: function() {
                var e = this;
                e.modal.find("a").on("click", function() {
                    location.hash = "#_",
                    e.buttonsEventTracking(this)
                })
            },
            buttonsEventTracking: function(e) {
                var t = $(e);
                "1" == t.attr("data-gatrack") && ga("b.send", "event", "Choose banner type", "Click", t.attr("data-gatrack-name"))
            }
        }
    },
    function(e, t) {
        "use strict";
        window.getIeVersion = function() {
            var e = window.navigator.userAgent,
                t = e.indexOf("MSIE ");
            if (t > 0)
                return parseInt(e.substring(t + 5, e.indexOf(".", t)), 10);
            var n = e.indexOf("Trident/");
            if (n > 0) {
                var i = e.indexOf("rv:");
                return parseInt(e.substring(i + 3, e.indexOf(".", i)), 10)
            }
            var a = e.indexOf("Edge/");
            return a > 0 && parseInt(e.substring(a + 5, e.indexOf(".", a)), 10)
        },
        window.displayIEMessage = function(e) {
            var t = $("<div class='browser-support-ie'><h2>" + getTxt("browser_not_supported") + "</h2><p>" + getTxt("browser_not_supported_message") + "</p><img src='/public/images/main/browser_not_supported.png'></div>");
            e.html(t)
        },
        window.displayIEPopin = function() {
            BSModal({
                title: "Please upgrade your browser to use Klobic.com",
                htmlContent: "<p>We noticed you were using an older or a no longer supported version of Internet Explorer. To fully enjoy what Klobic has to offer, we strongly recommend you to upgrade your current browser or use a different one.</p>",
                buttons: {
                    okButton: !1
                }
            }),
            $.userApi.cookie("IEshowPopin", !0, {path: "/"})
        },
        $(function() {
            WL_DOMAIN || setTimeout(function() {
                var e = getIeVersion();
                e && e <= 11 && !$.userApi.cookie("IEshowPopin") && displayIEPopin()
            }, 1e3)
        })
    },
    function(e, t) {
        "use strict";
        jQuery.fn.customInput = function() {
            return $(this).each(function(e) {
                var t = this;
                if ($(this).is("[type=checkbox],[type=radio]")) {
                    var n = $(this),
                        i = n.is("[type=checkbox]")
                            ? "checkbox"
                            : "radio",
                        a = $("<span />").addClass("custom-input custom-" + i);
                    n.css("float") && a.css("float", n.css("float")),
                    a.insertBefore(n).append(n);
                    try {
                        if ("function" == typeof MutationObserver) {
                            var o;
                            !function() {
                                var e = function(e) {
                                    "disabled" === e.attributeName && (n.is(":disabled")
                                        ? a.addClass("disabled")
                                        : a.removeClass("disabled"))
                                };
                                o = new MutationObserver(function(t) {
                                    t.forEach(e)
                                }),
                                o.observe(t, {
                                    attributes: !0,
                                    subtree: !1
                                })
                            }()
                        }
                    } catch (e) {
                        console.log(e)
                    }
                    n.bind("updateState", function() {
                        var e = n.is(":checkbox"),
                            t = n.is(":checked"),
                            i = n.is(":disabled");
                        if (t) {
                            if (!e) {
                                var o = $("input[name=" + n.attr("name") + "]");
                                o.each(function() {
                                    $(this).parent().removeClass("checked")
                                })
                            }
                            a.addClass("checked")
                        } else
                            a.removeClass("checked checkedHover checkedFocus");
                        i
                            ? a.addClass("disabled")
                            : a.removeClass("disabled")
                    }).trigger("updateState").change(function(e) {
                        $(this).trigger("updateState")
                    }).focus(function() {
                        a.addClass("focus"),
                        "checkbox" == i && n.is(":checked") && $(this).addClass("checkedFocus")
                    }).blur(function() {
                        a.removeClass("focus checkedFocus")
                    })
                }
            })
        }
    },
    function(e, t) {
        "use strict";/*!
	 * fakeSelect v0.1
	 *
	 * Copyright 2014
	 * http://takien.com
	 *
	 * Licensed under the MIT License
	 * http://en.wikipedia.org/wiki/MIT_License
	 *
	 */
        !function(e) {
            e.fn.fakeSelect = function(t) {
                var n = e.extend({}, e.fn.fakeSelect.defaultOptions, t);
                return this.each(function(t) {
                    var i = this,
                        a = e(this),
                        o = void 0 == a.attr("id")
                            ? "fake-select-" + t
                            : a.attr("id"),
                        r = a.find('option[value="' + a.val() + '"]').text() || a.find("option").first().text();
                    n = e.extend({}, n, a.data());
                    var s = a.is(":disabled");
                    a.wrap('<div class="fake-select-wrap" style="display:inline-block;position:relative"/>'),
                    a.before('<span class="fake-select-mask" id="' + o + '-mask"><button type="button" class="btn ' + n.btnStyle + " " + n.btnSize + (s
                        ? " disabled"
                        : "") + ' dropdown-toggle" data-toggle="dropdown"><span class="fake-selected">' + r + '</span> <span class="caret"></span></button><ul class="dropdown-menu"></ul></span>');
                    var l = a.prev(".fake-select-mask");
                    a.find("option").each(function() {
                        var t = e(this).text();
                        l.find(".dropdown-menu").append('<li><a data-val="' + e(this).val() + '" href="#">' + t + "</a></li>")
                    });
                    try {
                        if ("function" == typeof MutationObserver) {
                            var d;
                            !function() {
                                var e = function(e) {
                                    if ("disabled" === e.attributeName) {
                                        var t = l.find(">button");
                                        a.is(":disabled")
                                            ? t.attr("disabled", !0)
                                            : t.attr("disabled", !1)
                                    }
                                };
                                d = new MutationObserver(function(t) {
                                    t.forEach(e)
                                }),
                                d.observe(i, {
                                    attributes: !0,
                                    subtree: !1
                                })
                            }()
                        }
                    } catch (e) {
                        console.log(e)
                    }
                    l.attr("title", a.attr("title") || ""),
                    l.find(".dropdown-menu li a").each(function() {
                        e(this).click(function(t) {
                            a.val() !== e(this).data("val") && (a.val(e(this).data("val")).change(), l.find(".fake-selected").text(e(this).text())),
                            t.preventDefault()
                        })
                    }),
                    a.hide(),
                    a.on("change", function() {
                        l.find(".fake-selected").text(a.find('option[value="' + a.val() + '"]').text())
                    })
                })
            },
            e.fn.fakeSelect.defaultOptions = {
                btnSize: "",
                btnStyle: "btn-default"
            }
        }(jQuery)
    },
    function(e, t, n) {
        "use strict";
        function i(e) {
            return e && e.__esModule
                ? e
                : {
                    default: e
                }
        }
        var a = n(1),
            o = i(a),
            r = window.NO_FOOTER_PAGES,
            s = function() {
                var e = (0, o.default)("footer.BS-footer");
                e.find('[data-gatrack="1"]').on("click", function(e) {
                    var t = (0, o.default)(e.target);
                    window.ga("b.send", "event", "Footer", "Click", t.data("gatrack-name"))
                })
            },
            l = function() {
                var e = window.location.pathname.split("/"),
                    t = window.location.search,
                    n = window.location.hash;
                e.splice(0, 1),
                e[0].length <= 4 && "faq" !== e[0] && "edu" !== e[0] && e.splice(0, 1);
                var i = "/" + e.join("/");
                i += t + n;
                var a = (0, o.default)("div.langDropdown .langList");
                a.innerHTML("");
                for (var r = window.LANGUAGES || [], s = window.CURRENT_LANGUAGE, l = function(e) {
                    var t = r[e];
                    if (t.lang !== s) {
                        var n = document.createElement("a");
                        n.href = ("en" === t.lang
                            ? ""
                            : "/" + t.dc) + i,
                        n.className = "link";
                        var l = (0, o.default)(n);
                        l.on("click", function() {
                            $.userApi.cookie("lang", t.lang, {
                                expires: 365,
                                path: "/"
                            }),
                            $.userApi.cookie("country", t.dc, {
                                expires: 365,
                                path: "/"
                            })
                        }),
                        l.innerHTML(t.langName),
                        a.appendChild(l)
                    } else
                        window.CURRENT_LANGUAGE_NAME = t.langName
                },
                d = 0; d < r.length; d += 1)
                    l(d);
                var c = document.createElement("div");
                c.className = "link currentLanguage",
                c.innerHTML = window.CURRENT_LANGUAGE_NAME,
                a.appendChild((0, o.default)(c))
            },
            d = function() {
                var e = arguments.length > 0 && void 0 !== arguments[0]
                        ? arguments[0]
                        : location.pathname,
                    t = (0, o.default)("footer.BS-footer");
                if (t.length) {
                    for (var n = !1, i = 0; i < r.length; i += 1)
                        0 === e.toLowerCase().indexOf(window.langPre + r[i]) && (n = !0);
                    n && "not-found" !== window.PAGE
                        ? t.addClass("hidden")
                        : t.removeClass("hidden")
                }
                l()
            },
            c = function() {
                if (window.IS_BLOG || (d(), window.router && window.router.onChangeRoute(d, !0)), s(), "undefined" != typeof window.LANGUAGES) {
                    l();
                    var e = (0, o.default)(".footerLang");
                    e.find(".currentLanguage").innerHTML(window.CURRENT_LANGUAGE_NAME)
                }
            };
        $(function() {
            c()
        })
    },
    function(e, t, n) {
        "use strict";
        function i(e) {
            return e && e.__esModule
                ? e
                : {
                    default: e
                }
        }
        var a = n(1),
            o = i(a),
            r = n(2),
            s = window.NO_HEADER_PAGES || [],
            l = [
                "/analytics",
                "/campaigns",
                "/banner-rotator",
                "/mac-banner-maker",
                "/search-retargeting",
                "/banner-maker-pro",
                "/my-banners/",
                "/my-rotators/",
                "/account-options/",
                "/white-label/",
                "/session-inactive",
                "/direct-pay",
                "/payment-success",
                "/messages/",
                "/banner-maker/html5/",
                "/banner-maker/gif-output",
                "/campaign-pages/"
            ];
        window.getIeVersion()
            ? l.push("/banner-creator/")
            : s.push("/banner-creator/");
        var d = function() {
                var e = arguments.length > 0 && void 0 !== arguments[0]
                        ? arguments[0]
                        : location.pathname,
                    t = (0, o.default)("header.BS-header");
                if (t.length) {
                    for (var n = !1, i = 0; i < s.length; i++)
                        0 === e.toLowerCase().indexOf(window.langPre + s[i]) && (n = !0);
                    n && "not-found" !== window.PAGE
                        ? t.addClass("hidden")
                        : t.removeClass("hidden");
                    var a = !1;
                    if ("not-found" === window.PAGE)
                        a = !0;
                    else
                        for (var r = 0; r < l.length; r++)
                            0 === e.toLowerCase().indexOf(window.langPre + l[r]) && (a = !0);
                a
                        ? t.addClass("grey")
                        : t.removeClass("grey"),
                    t.removeClass("btn-only")
                }
            },
            c = function() {
                var e = (0, o.default)("header.BS-header");
                e.find('[data-gatrack="1"]').on("click", function(e) {
                    var t = (0, o.default)(e.currentTarget);
                    window.ga("b.send", "event", "Header", "Click", t.data("gatrack-name"))
                })
            },
            u = function() {
                function e() {
                    var e = (0, o.default)(this);
                    return e.hasClass("open")
                        ? void e.removeClass("open")
                        : (l.removeClass("open"), void e.addClass("open"))
                }
                function t() {
                    n.removeClass("btn-only")
                }
                var n = (0, o.default)("header.BS-header"),
                    i = 0,
                    a = n.height(),
                    s = 420 - a,
                    l = n.find("nav > .dropdown"),
                    u = (0, o.default)(".menu-mobile-ico"),
                    f = function() {},
                    h = function() {
                        window.innerWidth >= 768 && f()
                    };
                f = function() {
                    n.removeClass("mobile-visible"),
                    window.removeEventListener("resize", h),
                    (0, o.default)("body")[0].style.overflow = "auto"
                };
                var p = function() {
                    n.addClass("mobile-visible"),
                    window.addEventListener("resize", h),
                    (0, o.default)("body")[0].style.overflow = "hidden"
                };
                u.on("click", function() {
                    n.hasClass("mobile-visible")
                        ? f()
                        : p()
                }),
                l.on("click", e),
                l.find(".dropdown-content").on("click", function(e) {
                    e.stopPropagation()
                }),
                n.find(".nav-link, a").on("click", function() {
                    f()
                }),
                window.addEventListener("scroll", function() {
                    var e = (0, r.getWindowScrollTop)();
                    e > 10
                        ? n.addClass("scrolled")
                        : n.removeClass("scrolled"),
                    e > s && (e > i
                        ? n.addClass("btn-only")
                        : e !== i && n.removeClass("btn-only"), i = e)
                }),
                (0, r.getWindowScrollTop)() > 10 && n.addClass("scrolled"),
                window.addEventListener("resize", t),
                d(),
                window.router && window.router.onChangeRoute(d, !0),
                c()
            };
        $(function() {
            u()
        })
    },
    function(e, t, n) {
        "use strict";
        n(15),
        n(4),
        n(22),
        n(5),
        n(13),
        n(9),
        n(8),
        n(6),
        n(7),
        n(11),
        n(16),
        n(10),
        n(14),
        n(3),
        n(3)
    },
    function(e, t) {
        "use strict";
        var n = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
            ? function(e) {
                return typeof e
            }
            : function(e) {
                return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype
                    ? "symbol"
                    : typeof e
            };
        window.json_encode = function(e) {
            var t,
                i = window.JSON;
            try {
                if ("object" === ("undefined" == typeof i
                    ? "undefined"
                    : n(i)) && "function" == typeof i.stringify) {
                    if (t = i.stringify(e), void 0 === t)
                        throw new SyntaxError("json_encode");
                    return t
                }
                var a = e,
                    o = function(e) {
                        var t = /[\\\"\u0000-\u001f\u007f-\u009f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
                            n = {
                                "\b": "\\b",
                                "\t": "\\t",
                                "\n": "\\n",
                                "\f": "\\f",
                                "\r": "\\r",
                                '"': '\\"',
                                "\\": "\\\\"
                            };
                        return t.lastIndex = 0,
                        t.test(e)
                            ? '"' + e.replace(t, function(e) {
                                var t = n[e];
                                return "string" == typeof t
                                    ? t
                                    : "\\u" + ("0000" + e.charCodeAt(0).toString(16)).slice(-4)
                            }) + '"'
                            : '"' + e + '"'
                    },
                    r = function e(t, i) {
                        var a = "",
                            r = "    ",
                            s = 0,
                            l = "",
                            d = "",
                            c = 0,
                            u = a,
                            f = [],
                            h = i[t];
                        switch (h && "object" === ("undefined" == typeof h
                            ? "undefined"
                            : n(h)) && "function" == typeof h.toJSON && (h = h.toJSON(t)), "undefined" == typeof h
                            ? "undefined"
                            : n(h)) {
                            case "string":
                                return o(h);
                            case "number":
                                return isFinite(h)
                                    ? String(h)
                                    : "null";
                            case "boolean":
                            case "null":
                                return String(h);
                            case "object":
                                if (!h)
                                    return "null";
                                if (this.PHPJS_Resource && h instanceof this.PHPJS_Resource || window.PHPJS_Resource && h instanceof window.PHPJS_Resource)
                                    throw new SyntaxError("json_encode");
                                if (a += r, f = [], "[object Array]" === Object.prototype.toString.apply(h)) {
                                    for (c = h.length, s = 0; s < c; s += 1)
                                        f[s] = e(s, h) || "null";
                                    return d = 0 === f.length
                                        ? "[]"
                                        : a
                                            ? "[\n" + a + f.join(",\n" + a) + "\n" + u + "]"
                                            : "[" + f.join(",") + "]",
                                    a = u,
                                    d
                                }
                                for (l in h)
                                    Object.hasOwnProperty.call(h, l) && (d = e(l, h), d && f.push(o(l) + (a
                                        ? ": "
                                        : ":") + d));
                                return d = 0 === f.length
                                    ? "{}"
                                    : a
                                        ? "{\n" + a + f.join(",\n" + a) + "\n" + u + "}"
                                        : "{" + f.join(",") + "}",
                                a = u,
                                d;
                            case "undefined":
                            case "function":
                            default:
                                throw new SyntaxError("json_encode")
                        }
                    };
                return r("", {"": a})
            } catch (e) {
                if (!(e instanceof SyntaxError))
                    throw new Error("Unexpected error type in json_encode()");
                return this.php_js = this.php_js || {},
                this.php_js.last_error_json = 4,
                null
            }
        }
    },
    function(e, n, i) {
        "use strict";
        function a(e) {
            return e && e.__esModule
                ? e
                : {
                    default: e
                }
        }
        var o = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                ? function(e) {
                    return typeof e
                }
                : function(e) {
                    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype
                        ? "symbol"
                        : typeof e
                },
            r = i(1),
            s = a(r);
        "undefined" == typeof window.PAGE && (window.PAGE = null),
        window.router = window.router || null,
        window.WL_DOMAIN = window.WL_DOMAIN || !1,
        window.isHomePage = "home" === PAGE;
        "ontouchstart" in window || window.navigator.msMaxTouchPoints;
        window.BSAlert = function(e, t) {
            var n = {
                type: "danger",
                onClose: function() {}
            };
            t && $.extend(n, t);
            var i = $('<div class="modal fade" id="bs-alert-modal" tabindex="-1" role="dialog" aria-labelledby="bs-alert-modal" aria-hidden="true"><div class="modal-dialog"><div class="modal-content alert"></div></div></div>'),
                a = "alert-" + n.type;
            i.find(".modal-content").addClass(a).html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><span class="ht-content">' + e + "</span>"),
            i.modal(),
            i.on("hidden.bs.modal", function() {
                i.remove(),
                "function" == typeof n.onClose && n.onClose()
            })
        };
        var d = $("<div>");
        window.htmlText = function(e) {
            return d.html(e).html()
        },
        window.getAlert = function(e, t, n) {
            var i = '<div class="alert alert-' + e + (n
                ? " alert-dismissible"
                : "") + '" role="alert">' + (n
                ? '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                : "") + t + "</div>";
            return i
        },
        window.isObject = function(e) {
            return "object" === ("undefined" == typeof e
                ? "undefined"
                : o(e)) && null !== e
        },
        window.BSConfirm = function(e, t, n) {
            var i = null;
            isObject(e) && (i = e.title, e = e.content);
            var a = $('<div class="modal fade" id="bs-confirm-modal" tabindex="-1" role="dialog" aria-labelledby="bs-confirm-modal" aria-hidden="true"><div class="modal-dialog"><div class="modal-content">' + (i
                ? '<div class="modal-header"><h4 class="modal-title"></h4></div>'
                : "") + '<div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary">' + getTxt("ok") + '</button><button type="button" class="btn btn-default">' + getTxt("cancel") + "</button></div></div></div></div>");
            return a.find(".modal-body").html(e),
            i && a.find(".modal-header h4").text(i),
            a.modal(),
            a.find(".btn-primary").on("click", function() {
                a.modal("hide"),
                t && "function" == typeof t && t()
            }),
            a.find(".btn-default").on("click", function() {
                a.modal("hide"),
                n && "function" == typeof n && n()
            }),
            a.on("hidden.bs.modal", function() {
                a.remove()
            }),
            a
        },
        window.BSModal = function(e) {
            var t = {
                title: "",
                htmlContent: "",
                xButton: !0,
                buttons: {
                    okButton: {
                        text: "function" == typeof getTxt && "" !== getTxt("ok")
                            ? getTxt("ok")
                            : "Ok",
                        className: "btn-primary",
                        onBtnClick: function() {}
                    },
                    cancelButton: {
                        text: "function" == typeof getTxt && "" !== getTxt("close")
                            ? getTxt("close")
                            : "Close",
                        className: "btn-default",
                        onBtnClick: function() {
                            n.modal("hide")
                        }
                    }
                }
            };
            e && $.extend(!0, t, e);
            var n = $('<div class="modal fade" id="bs-modal" tabindex="-1" role="dialog" aria-labelledby="bs-modal" aria-hidden="true"><div class="modal-dialog"><div class="modal-content">' + (t.title
                ? '<div class="modal-header">' + (t.xButton
                    ? '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'
                    : "") + '<h4 class="modal-title">' + t.title + "</h4></div>"
                : "") + '<div class="modal-body"></div><div class="modal-footer">' + (t.buttons.okButton
                ? '<button type="button" class="btn ' + t.buttons.okButton.className + '">' + t.buttons.okButton.text + "</button>"
                : "") + (t.buttons.cancelButton
                ? '<button type="button" class="btn ' + t.buttons.cancelButton.className + '">' + t.buttons.cancelButton.text + "</button>"
                : "") + "</div></div></div></div>");
            return n.find(".modal-body").html(t.htmlContent),
            n.modal(),
            n.find("." + t.buttons.okButton.className).on("click", function() {
                t.buttons.okButton.onBtnClick()
            }),
            n.find("." + t.buttons.cancelButton.className).on("click", function() {
                t.buttons.cancelButton.onBtnClick()
            }),
            n.on("hidden.bs.modal", function() {
                n.remove()
            }),
            n
        },
        window.formatNumber = function(e, t) {
            if (e = parseFloat(e), isNaN(e))
                return "0";
            var n = "\\d(?=(\\d{3})+" + (t > 0
                ? "\\."
                : "$") + ")";
            return e.toFixed(Math.max(0, ~~ t)).replace(new RegExp(n, "g"), "$&,")
        },
        $(document).ready(function() {
            function e() {
                if ("undefined" != typeof notifyBarWidget) {
                    a = !0;
                    var e = function() {
                        $(window).scrollTop() > 45
                            ? o.addClass("headerFixed")
                            : o.removeClass("headerFixed")
                    };
                    $(window).scroll(function() {
                        e()
                    }),
                    e(),
                    clearInterval(n)
                }
                50 === i && clearInterval(n),
                i++
            }
            function t(e, t) {
                var n = !1;
                t === location.hash && (n = !0),
                location.href = t,
                e.preventDefault(),
                n && homePagesHashChange(t.substr(1))
            }
            $("a.make_a_banner_link").click(tellToLoginIfNotLogged),
            $("#inlineMessages a.close").click(function() {
                return hideInlineMessage(),
                !1
            }),
            $.ajaxSetup({
                url: "/ajax.php",
                global: !1,
                type: "get",
                dataType: "json",
                cache: !0
            }),
            window.SHOW_CAMPAIGNS = "undefined" != typeof window.SHOW_CAMPAIGNS && window.SHOW_CAMPAIGNS;
            var n,
                i = 0,
                a = !1,
                o = $("#UA-container"),
                r = o.hasClass("headerFixed");
            r && (n = setInterval(e, 100), e());
            var s = $("#UA-header");
            "custom-design-banners" === PAGE && (s.find(".header-cb-prices-link").on("click", function(e) {
                t(e, "#prices")
            }), s.find(".header-cb-about").on("click", function(e) {
                pageScrollTo($("#UA-container")),
                t(e, "#")
            }), location.hash && homePagesHashChange(location.hash.substr(1))),
            (isHomePage || "go-premium" == PAGE) && $(".fw-container sup.help").tooltip({
                html: !0
            }),
            bsHashChange()
        }),
        window.updateHeaderUnreadMessage = function() {
            $.ajax({
                data: {
                    page: "messages/unread-messages-counter"
                },
                success: function(e) {
                    if (20 === e.code) {
                        var t = $(".UA-ico-messages");
                        t.find(".unread-messages-number").remove(),
                        e.res > 0 && t.append('<div class="unread-messages-number">' + e.res + "</div>")
                    }
                }
            })
        },
        window.showLoginError = function(e, n) {
            $("#tlerr").remove(),
            lf = $("#st-login-form"),
            c = $("<div />").addClass("im").attr({id: "tlerr"}),
            l = lf.position().left,
            t = lf.position().top + lf.innerHeight() + 5,
            "undefined" == typeof n && (n = "red"),
            c.css({
                position: "absolute",
                top: t + "px",
                left: l + "px",
                color: n,
                width: "220px"
            }),
            c.html(e).hide(),
            lf.after(c),
            c.fadeIn("fast")
        },
        window.getLoadingImage = function() {
            var e = $("<img />").attr({
                src: window.CDNPATH + "/images/loading.gif"
            });
            return e
        },
        window.getLoadingSvg = function() {
            var e = '<svg preserveAspectRatio="none" version="1.1" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" fill="#fff" viewBox="0 0 51 51" style="">    <defs>        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">            <stop offset="0%"></stop>            <stop offset="100%"></stop>        </linearGradient>    </defs>    <path d="M25.5,4C37.4,4,47,13.6,47,25.5S37.4,47,25.5,47S4,37.4,4,25.5S13.6,4,25.5,4 M25.5,0C11.4,0,0,11.4,0,25.5C0,39.6,11.4,51,25.5,51C39.6,51,51,39.6,51,25.5C51,11.4,39.6,0,25.5,0L25.5,0z" fill="url(#grad1)"></path>    <path class="actionMask" fill="transparent" fill-rule="evenodd" clip-rule="evenodd" d="M25.5,0C39.6,0,51,11.4,51,25.5S39.6,51,25.5,51S0,39.6,0,25.5S11.4,0,25.5,0z"></path></svg>',
                t = $(e);
            return t
        },
        window.handleErrors = function(e, t) {
            showErrorMessage(t)
        };
        var u = void 0,
            f = !1;
        window.showInlineMessage = function(e, t, n, i, a) {
            f || (initMessages(), f = !0);
            var r,
                s = $("#inlineMessages");
            if ("err" == t)
                r = s.find(".err");
            else if (r = s.find(".not"), $.userApi.cookie("ignallguidlines"))
                return;
            clearTimeout(u),
            r.find("div.right").html(n),
            r.find("div.left").html(e),
            "object" == ("undefined" == typeof e
                ? "undefined"
                : o(e))
                ? (r.find("div.left").html(e), e.show())
                : r.find("div.left").html(e),
            "none" == r.css("display") && r.slideDown(200),
            r.find("a.close").click(_closeInlineMessage),
            1 == r.find("a.ignore_all").length && r.find("a.ignore_all").click(_ignoreAllGuidlines),
            parseInt(i) > 0 && (u = setTimeout("hideInlineMessage()", i)),
            $(window).scrollTop() > s.offset().top && $("html, body").animate({
                scrollTop: s.offset().top - 100
            }, 200),
            "function" == typeof a && a(s)
        },
        window._ignoreAllGuidlines = function() {
            return $.userApi.cookie("ignallguidlines", !0, {
                expires: 3650,
                path: "/"
            }),
            hideInlineMessage($(this).parent().parent().parent().attr("class"), !0),
            !1
        },
        window._closeInlineMessage = function() {
            return hideInlineMessage($(this).parent().parent().parent().attr("class"), !0),
            !1
        },
        window.initMessages = function() {
            $("#inlineMessages").length >= 1
                ? im = $("#inlineMessages")
                : (im = $("<div />").attr({id: "inlineMessages"}), $("#master").before(im)),
            cont = $("<div />").addClass("cont"),
            cont.append($("<div />").addClass("left")),
            cont.append($("<div />").addClass("right")),
            cont.append($("<br />").addClass("clear")),
            contErr = cont.clone(),
            not = $("<div />").addClass("not").append(cont),
            err = $("<div />").addClass("err").append(contErr),
            im.html(""),
            im.append(not).append(err)
        },
        window.hideInlineMessage = function(e, t) {
            var n = void 0;
            e && "not" == e
                ? "function" == typeof onGuidlineClose
                    ? (n = onGuidlineClose($("#inlineMessages .not"), t), 1 == n && $("#inlineMessages .not").slideUp(200))
                    : $("#inlineMessages .not").slideUp(200)
                : "function" == typeof onNoticeClose
                    ? (n = onNoticeClose($("#inlineMessages .not"), t), 1 == n && $("#inlineMessages .not").slideUp(200))
                    : $("#inlineMessages .err").slideUp(200)
        },
        window.hideGuidline = function() {
            hideInlineMessage("not")
        },
        window.showNotice = function(e, t, n) {
            showErrorMessage(e, t, n)
        },
        window.hideNotice = function() {
            hideInlineMessage("err")
        },
        window.hideAllMessages = function() {
            hideInlineMessage("not"),
            hideInlineMessage("err")
        },
        "undefined" == typeof window.TEXTS && (window.TEXTS = {}),
        "undefined" == typeof window.langTexts && (window.langTexts = {}),
        "undefined" == typeof window.texts && (window.texts = {}),
        window.showErrorMessage = function(e, t, n) {
            var i = "Ã—";
            right = $("<a>").addClass("close").text(i).attr({href: "#"}),
            showInlineMessage(e, "err", right, t, n)
        },
        window.showMessage = function(e, t, n) {
            var i = "Ã—",
                a = langTexts.notice_ignore_all || texts.notice_ignore_all || TEXTS.notice_ignore_all || "Ignore all",
                o = '<a href="#" class="close">' + i + '</a> <span style="color: #D2D2D2">|</span> <a href="#" class="ignore_all">' + a + "</a>";
            showInlineMessage(e, "not", o, t, n)
        },
        window.validEmail = function(e) {
            var t = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            return !!t.test(e)
        },
        window.validScreenName = function(e) {
            var t = /^[0-9A-Za-z_\- ]+$/;
            return !!t.test(e)
        },
        window.openSTUrl = function(e) {
            window.LOGGED
                ? location.href = e
                : location.href = $.userApi.loginPage + "?next=" + encodeURIComponent(location.pathname + e)
        },
        window.bsHashChange = function() {
            switch (location.hash) {
                case "#bs-add-funds":
                    window.LOGGED && ("undefined" == typeof CampaignFunds
                        ? router
                            ? router.routeTo(langPre + "/campaigns/?re=add-funds#bs-add-funds")
                            : window.location.href = langPre + "/campaigns/?re=add-funds#bs-add-funds"
                        : CampaignFunds.openPopin());
                    break;
                case "#bs-manage-clients":
                    "undefined" != typeof AgencyManageClients && AgencyManageClients.openPopin();
                    break;
                case "#bs-manage-users":
                    "undefined" != typeof ManageUsers && new ManageUsers;
                    break;
                case "#make-a-banner":
                    new MakeBannerPopin
            }
            if (0 === location.hash.indexOf("#st-buy-points")) {
                var e = location.hash.split("&");
                e.shift(),
                location.href = "#_";
                var t = "";
                e.length && (t = "?" + e.join("&")),
                router.routeTo(window.langPre + "/go-premium/" + t)
            }
            "home" !== PAGE && "custom-design-banners" !== PAGE || homePagesHashChange(location.hash.substr(1)),
            "function" == typeof checkIfShowFlashOnExamples && checkIfShowFlashOnExamples()
        },
        window.addEventListener
            ? window.addEventListener("hashchange", bsHashChange, !1)
            : window.attachEvent && window.attachEvent("onhashchange", bsHashChange),
        window.homePagesHashChange = function(e, t) {
            if (e.indexOf("&") === -1) {
                var n = $("#hashchange-" + e),
                    i = 0;
                if ("custom-design-banners" === PAGE)
                    switch (e) {
                        case "prices":
                            i = -45
                    }
                if (n.length && (pageScrollTo(n, i), t))
                    var a = $(".section.content-38"),
                        o = a.height(),
                        r = 200,
                        s = 0,
                        l = setInterval(function() {
                            o !== a.height() && (pageScrollTo(n), o = a.height()),
                            s >= 4e3 && clearInterval(l),
                            s += r
                        }, r)
                }
        },
        window.pageScrollTo = function(e, t) {
            t || (t = 0),
            $("body,html").animate({
                scrollTop: e.offset().top + t
            }, 300)
        },
        window.UA_ifLogged = function(e) {
            UA_onLogin(e)
        },
        window.tellToLoginIfNotLogged = function() {
            if (!window.LOGGED)
                return location.href = $.userApi.loginPage + "?next=" + $(this).attr("href"),
                !1
        },
        window.doActionOnBuyPoints = function() {
            $.userApi.buyPoints()
        },
        window.hasFlash = function() {
            var e = navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]
                ? navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin
                : 0;
            if (e)
                return !0;
            try {
                var t = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
                if (t)
                    return !0
            } catch (e) {}
            return !1
        },
        window.htmlChars = function(e) {
            return e
                ? e.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;")
                : ""
        },
        window.gTrack = function(e, t, n, i) {
            try {
                var a = {
                    hitType: "event",
                    eventCategory: e,
                    eventAction: t
                };
                n && (a.eventLabel = t + ":" + n),
                i
                    ? setTimeout(function() {
                        ga("send", a)
                    }, i)
                    : ga("send", a)
            } catch (e) {}
        },
        $.userApi = $.userApi || {},
        $.userApi.cookie = function(e, t, n) {
            if ("undefined" == typeof t) {
                var i = null;
                if (document.cookie && "" != document.cookie)
                    for (var a = document.cookie.split(";"), o = 0; o < a.length; o++) {
                        var r = jQuery.trim(a[o]);
                        if (r.substring(0, e.length + 1) == e + "=") {
                            i = decodeURIComponent(r.substring(e.length + 1));
                            break
                        }
                    }
                return i
            }
            n = n || {},
            null === t && (t = "", n.expires = -1);
            var s = "";
            if (n.expires && ("number" == typeof n.expires || n.expires.toUTCString)) {
                var l;
                "number" == typeof n.expires
                    ? (l = new Date, l.setTime(l.getTime() + 24 * n.expires * 60 * 60 * 1e3))
                    : l = n.expires,
                s = "; expires=" + l.toUTCString()
            }
            var d = n.path
                    ? "; path=" + n.path
                    : "",
                c = n.domain
                    ? "; domain=" + n.domain
                    : "",
                u = n.secure
                    ? "; secure"
                    : "";
            document.cookie = [
                encodeURIComponent(e),
                "=",
                encodeURIComponent(t),
                s,
                d,
                c,
                u
            ].join("")
        },
        window.initTooltips = function() {
            $("[data-toggle='tooltip']").tooltip()
        },
        window.headerEventTrackingNotLogged = function() {
            var e = $(".header-container");
            e.find('[data-gatrack="1"]').on("click", function() {
                $("body").hasClass("blog") || window.ga("b.send", "event", "Menu - not logged in", "Click", $(this).attr("data-gatrack-name"))
            })
        },
        window.initHeader = function() {
            headerEventTrackingNotLogged()
        },
        window.initHomeTabs = function() {
            var e,
                t,
                n,
                i = "",
                a = "#for-",
                o = ".tab.for-",
                r = document.getElementById("first-youtube-video-container"),
                s = r.getElementsByTagName("iframe")[0].contentWindow,
                l = document.getElementById("last-youtube-video-container"),
                d = l.getElementsByTagName("iframe")[0].contentWindow;
            e = function(e, t) {
                a = "#for-" + e,
                o = ".tab.for-" + e,
                $(".current-option").text(t),
                $(o).addClass("active-tab"),
                $(a).addClass("active-quarter").fadeIn(200),
                setTimeout(function() {
                    $(".tabs-contents").height("auto")
                }, 220)
            },
            $(".for-btn").on("click", function() {
                $(this).hasClass("active-tab") || (t = $(".active-tab"), n = $(".active-quarter"), i = $(this), t.hasClass("for-designers") && s.postMessage('{"event":"command","func":"stopVideo","args":""}', "*"), t.hasClass("for-business") && d.postMessage('{"event":"command","func":"stopVideo","args":""}', "*"), $(".for-btn").removeClass("active-tab"), i.addClass("active-tab"), $(".tabs-contents").animate({
                    height: n.height() + 160
                }, 200), n.removeClass("active-quarter").fadeOut(200, function() {
                    if (i.hasClass("for-designers"))
                        switch (window.ga("b.send", "event", "Homepage", "Click", "For designers"), $.userApi.lang) {
                            case "bp":
                                e("designers", "para designers");
                                break;
                            case "de":
                                e("designers", "fÃ¼r Designer");
                                break;
                            case "es":
                                e("designers", "para diseÃ±adores");
                                break;
                            case "fr":
                                e("designers", "pour les concepteurs");
                                break;
                            case "hu":
                                e("designers", "designereknek");
                                break;
                            case "it":
                                e("designers", "per designer");
                                break;
                            case "ja":
                                e("designers", "ãƒ‡ã‚¶ã‚¤ãƒŠãƒ¼æ§˜å‘ã‘");
                                break;
                            case "ro":
                                e("designers", "pentru designer");
                                break;
                            default:
                                e("designers", "for designers")
                        }
                    else if (i.hasClass("for-marketers"))
                        switch (window.ga("b.send", "event", "Homepage", "Click", "For marketers"), $.userApi.lang) {
                            case "bp":
                                e("marketers", "para comerciantes");
                                break;
                            case "de":
                                e("marketers", "fÃ¼r Vermarkter");
                                break;
                            case "es":
                                e("marketers", "para comerciantes");
                                break;
                            case "fr":
                                e("marketers", "pour les spÃ©cialistes du marketing");
                                break;
                            case "hu":
                                e("marketers", "marketing szakÃ©rtÅ‘knek");
                                break;
                            case "it":
                                e("marketers", "per pubblicitari");
                                break;
                            case "ja":
                                e("marketers", "ãƒžãƒ¼ã‚±ãƒ†ã‚£ãƒ³ã‚°æ‹…å½“è€…æ§˜å‘ã‘");
                                break;
                            case "ro":
                                e("marketers", "pentru marketeri");
                                break;
                            default:
                                e("marketers", "for marketers")
                        }
                    else if (i.hasClass("for-agencies"))
                        switch (window.ga("b.send", "event", "Homepage", "Click", "For agencies"), $.userApi.lang) {
                            case "bp":
                                e("agencies", "para agÃªncias");
                                break;
                            case "de":
                                e("agencies", "fÃ¼r Agenturen");
                                break;
                            case "es":
                                e("agencies", "para agencias");
                                break;
                            case "fr":
                                e("agencies", "pour les agences");
                                break;
                            case "hu":
                                e("agencies", "Ã¼gynÃ¶ksÃ©geknek");
                                break;
                            case "it":
                                e("agencies", "per agenzie");
                                break;
                            case "ja":
                                e("agencies", "ä»£ç†åº—æ§˜å‘ã‘");
                                break;
                            case "ro":
                                e("agencies", "pentru agenÈ›ii");
                                break;
                            default:
                                e("agencies", "for agencies")
                        }
                    else if (i.hasClass("for-business"))
                        switch (window.ga("b.send", "event", "Homepage", "Click", "For startups"), $.userApi.lang) {
                            case "bp":
                                e("business", "para pequenas empresas");
                                break;
                            case "de":
                                e("business", "fÃ¼r Kleinunternehmen");
                                break;
                            case "es":
                                e("business", "para pequeÃ±os negocios");
                                break;
                            case "fr":
                                e("business", "pour les petites entreprises");
                                break;
                            case "hu":
                                e("business", "kisvÃ¡llalkozÃ¡soknak");
                                break;
                            case "it":
                                e("business", "per piccole aziende");
                                break;
                            case "ja":
                                e("business", "ã‚¹ãƒ¢ãƒ¼ãƒ«ãƒ“ã‚¸ãƒã‚¹å‘ã‘");
                                break;
                            case "ro":
                                e("business", "pentru mici intreprinzÄƒtori");
                                break;
                            default:
                                e("business", "for startups")
                        }
                    n = $(".active-quarter"),
                    $(".tabs-contents").animate({
                        height: n.height() + 160
                    }, 200)
                }))
            })
        },
        window.homePageEventTracking = function() {
            var e = $("body").find(".page-home");
            e.find('[data-gatrack="1"]').on("click", function() {
                window.ga("b.send", "event", "Homepage", "Click", $(this).attr("data-gatrack-name"))
            })
        },
        window.initHomePage = function() {
            homePageEventTracking(),
            initHomeTabs(),
            initTooltips()
        },
        window.getTxt = function(e) {
            return ""
        },
        window.getTxtDecoded = function(e) {
            return ""
        };
        var h = window.PAGE;
        window.router.onChangeRoute(function() {
            var e = window.PAGE;
            if (e !== h) {
                var t = (0, s.default)("body");
                t.removeClass("page-" + h).addClass("page-" + e),
                h = e
            }
        }, !0)
    },
    function(e, t) {
        "use strict";
        window.router = null,
        function() {
            var e = function() {
                this.init()
            };
            e.prototype = {
                init: function() {
                    this.routes = {};
                    var e = this;
                    window.onpopstate = function(t) {
                        if (t.state && t.state.route)
                            e.routeTo(t.state.route, !0);
                        else {
                            var n = e._lastHref.replace(/#.*$/, ""),
                                i = location.href.replace(/#.*$/, "");
                            n != i && e.routeTo(e.getRouteFromUrl(location.href), !0)
                        }
                    },
                    this._lastHref = location.href,
                    $(function() {
                        window.IS_BLOG || e.parseNavLinks($(".app-page-content, footer, header"))
                    })
                },
                add: function(e, t) {
                    this.routes[e] = t
                },
                _lastHref: null,
                routeTo: function(e, t) {
                    var n = !(arguments.length > 2 && void 0 !== arguments[2]) || arguments[2];
                    if (!this._callBeforeChangeRoute(e, this._lastHref, t))
                        return this._lastHref = location.href,
                        !1;
                    if (!this.supportHistory())
                        return void(location.href = e);
                    this.request && this.request.abort();
                    var i = e.split("/");
                    i[0] || i.splice(0, 1);
                    var a = i[0];
                    "/" + a == langPre && (a = i[1] || ""),
                    a = a.split("?"),
                    a = a[0];
                    var o = this;
                    if (a && this.routes[a])
                        return t || this._pushRoute(e, ""),
                        this._lastHref = location.href,
                        this.gTrack(),
                        o._callOnChangeRoute(),
                        void this.routes[a].apply(this, [e]);
                    var r = $(".app-page-content"),
                        s = null;
                    n && (s = new LoaderHover(r));
                    var l = !0;
                    try {
                        this.request = $.ajax({
                            type: "GET",
                            url: e,
                            complete: function() {
                                s && l && s.remove()
                            },
                            success: function(n) {
                                var i = n.res;
                                if (i.redirectTo)
                                    return location.href = i.redirectTo,
                                    void(l = !1);
                                var a;
                                if (!t) {
                                    a = i.url
                                        ? i.url
                                        : e;
                                    var s = e.indexOf("#");
                                    s >= 0 && (a += e.substr(s)),
                                    o._pushRoute(a, i.title)
                                }
                                o._lastHref = location.href,
                                document.title = i.title,
                                i.page && (window.PAGE = i.page),
                                o._callOnNewRouteRequest(a),
                                o.gTrack(),
                                o._callOnChangeRoute(),
                                window.scrollTo(0, 0),
                                r.html(i.content),
                                o.parseNavLinks(r)
                            }
                        })
                    } catch (e) {
                        s && s.remove(),
                        console.log("Request js error: " + e.message)
                    }
                    this.routes = {}
                },
                onNewRouteRequest: function(e) {
                    this._onNewRouteRequestData.push(e)
                },
                _onNewRouteRequestData: [],
                _callOnNewRouteRequest: function(e) {
                    for (var t = 0; t < this._onNewRouteRequestData.length; t++)
                        this._onNewRouteRequestData[t].call(this, e);
                    this._onNewRouteRequestData = []
                },
                _pushRoute: function(e, t) {
                    history.pushState({
                        route: e
                    }, t, e)
                },
                beforeChangeRoute: function(e, t) {
                    this._beforeChangeRouteData.push({callback: e, isPersistent: t})
                },
                _beforeChangeRouteData: [],
                beforeChangeRouteRemove: function(e) {
                    for (var t = 0; t < this._beforeChangeRouteData.length; t++)
                        if (this._beforeChangeRouteData[t].callback === e) {
                            this._beforeChangeRouteData.splice(t, 1);
                            break
                        }
                    },
                _callBeforeChangeRoute: function(e, t, n) {
                    for (var i = 0; i < this._beforeChangeRouteData.length; i++) {
                        var a = this._beforeChangeRouteData[i];
                        if (a.callback.call(this, e, t, n) === !1)
                            return !1;
                        a.isPersistent || (this._beforeChangeRouteData.splice(i, 1), i--)
                    }
                    return !0
                },
                onChangeRoute: function(e, t) {
                    this._onChangeRouteData.push({callback: e, isPersistent: t})
                },
                _onChangeRouteData: [],
                onChangeRouteRemove: function(e) {
                    for (var t = 0; t < this._onChangeRouteData.length; t++)
                        if (this._onChangeRouteData[t].callback === e) {
                            this._onChangeRouteData.splice(t, 1);
                            break
                        }
                    },
                _callOnChangeRoute: function() {
                    for (var e = 0; e < this._onChangeRouteData.length; e++) {
                        var t = this._onChangeRouteData[e];
                        t.callback.call(this),
                        t.isPersistent || (this._onChangeRouteData.splice(e, 1), e--)
                    }
                },
                gTrack: function() {
                    var e = {
                        page: location.href,
                        title: document.title
                    };
                    ga("send", "pageview", e),
                    ga("b.send", "pageview", e)
                },
                supportHistory: function() {
                    return !(!window.history || !window.history.pushState)
                },
                parseNavLinks: function(e) {
                    var t = this;
                    e.find("a.nav-link").on("click", function(e) {
                        var n = t.getRouteFromUrl($(this).prop("href"));
                        if (e.preventDefault(), t.routeTo(n) === !1)
                            return e.stopImmediatePropagation(),
                            !1
                    })
                },
                getRouteFromUrl: function(e) {
                    return e.replace(/^.*\/\/[^\/]+/, "")
                },
                isEditorPage: function() {
                    console.log(langPre);  
                    return 0 === location.pathname.indexOf(langPre + "/banner-maker/html5/editor/") || !(0 !== location.pathname.indexOf(langPre + "/banner-maker/software/") || !(location.search.indexOf("item=") >= 0 || location.search.indexOf("new=1")))
                }
            },
            window.router = new e
        }()
    },
    function(e, t, n) {
        "use strict";
        function i(e) {
            return e && e.__esModule
                ? e
                : {
                    default: e
                }
        }
        var a = n(23),
            o = i(a),
            r = n(1),
            s = i(r),
            l = n(21),
            d = i(l),
            c = n(2),
            u = null,
            f = void 0,
            h = null,
            p = function() {
                return (0, s.default)("#quickSignUp")
            },
            g = function(e) {
                (0, s.default)(".quick-sign-up div.signup-error").html(e).css({opacity: 1})
            },
            m = function() {
                (0, s.default)(".quick-sign-up div.signup-error").css({opacity: 0})
            },
            v = function(e) {
                (0, s.default)(".quick-sign-up input[name=" + e + "]").addClass("error")
            },
            w = function(e) {
                e && (0, s.default)(".quick-sign-up input[name=" + e + "]").removeClass("error")
            },
            b = function() {
                f = new window.LoaderHover($("#quickSignUp")),
                f.setTransparent(!0),
                f.loader.css("position", "absolute")
            },
            y = function() {
                f.remove()
            },
            k = function(e) {
                g(e),
                y(),
                window.grecaptcha.reset(u)
            },
            C = function(e) {
                var t = (0, c.objToQueryString)({page: "auth/login", sessionId: e});
                fetch("/ajax.php?" + t, {credentials: "same-origin"}).then(function(e) {
                    return e.json()
                }).then(function(e) {
                    20 === e.code
                        ? location.href = window.langPre + "/auth/user-occupation/"
                        : k(e.res)
                }).catch(function() {
                    k("Internal server error! Try again later.")
                })
            },
            x = function(e) {
                m(),
                b(),
                fetch("/ajax.php?page=" + encodeURIComponent("auth/sign-up"), {
                    method: "post",
                    credentials: "same-origin",
                    body: new FormData(e)
                }).then(function(e) {
                    return e.json()
                }).then(function(e) {
                    20 === e.code
                        ? C(e.res.PHPSESSID)
                        : k(e.res)
                }).catch(function(e) {
                    throw k("Internal server error! Try again later."),
                    e
                })
            },
            T = function() {
                var e = arguments.length > 0 && void 0 !== arguments[0]
                        ? arguments[0]
                        : location.pathname,
                    t = window.NO_FOOTER_PAGES.slice(0);
                t.push("/legal-information/", "/contact");
                var n = (0, s.default)(".quick-sign-up");
                if (n.length) {
                    for (var i = !1, a = 0; a < t.length; a += 1)
                        0 === e.toLowerCase().indexOf(window.langPre + t[a]) && (i = !0);
                    i || "not-found" === window.PAGE
                        ? n.addClass("hidden")
                        : n.removeClass("hidden")
                }
            },
            I = function() {
                var e = (0, s.default)("#quickSignUp");
                x(e[0])
            },
            _ = function() {
                return "undefined" != typeof window && "undefined" != typeof window.grecaptcha
            },
            E = function e() {
                _()
                    ? (u = window.grecaptcha.render("g-recaptcha-quick", {
                        sitekey: "" + window.googleCaptchaSiteKey,
                        size: "invisible",
                        callback: I
                    }), h && clearInterval(h))
                    : h || (h = setInterval(function() {
                        e()
                    }, 1e3))
            },
            M = function(e) {
                return !/\S/.test(e)
            },
            S = [],
            A = function(e) {
                if (S.indexOf(e) >= 0)
                    return v("e"),
                    void(0, d.default)("emailExistsError", "auth").then(function(e) {
                        g(e)
                    });
                var t = (0, c.objToQueryString)({page: "auth/email-exists", email: e});
                fetch("/ajax.php?" + t, {credentials: "same-origin"}).then(function(e) {
                    return e.json()
                }).then(function(t) {
                    20 === t.code && t.res.exists
                        ? (v("e"), (0, d.default)("emailExistsError", "auth").then(function(e) {
                            g(e)
                        }),
                        S.push(e))
                        : (w("e"), m())
                }).catch(function() {
                    w("e"),
                    m()
                })
            },
            P = function(e) {
                var t = arguments.length > 1 && void 0 !== arguments[1] && arguments[1],
                    n = e.name,
                    i = e.value,
                    a = !1;
                switch (n) {
                    case "screenname":
                        i.length && !M(i) || (a = !0);
                        break;
                    case "e":
                        if (o.default.validate(i))
                            return t
                                ? (w(n), A(i))
                                : !(0, s.default)(e).hasClass("error");
                        a = !0;
                        break;
                    case "p":
                        i.length < 4 && (a = !0)
                }
                return a
                    ? (v(n), !1)
                    : (w(n), !0)
            },
            O = function() {
                var e = p(),
                    t = e.find("input.error");
                t.addClass("shake"),
                setTimeout(function() {
                    t.removeClass("shake")
                }, 300)
            },
            R = function() {
                for (var e = p(), t = [
                    "screenname", "e", "p"
                ], n = 0; n < t.length; n++) {
                    var i = e.find("input[name=" + t[n] + "]");
                    if (!P(i[0]))
                        return O(),
                        !1
                }
                return !0
            },
            L = !1,
            N = function() {
                (0, c.onDocumentReady)(function() {
                    T(),
                    window.router && window.router.onChangeRoute(T, !0);
                    var e = p(),
                        t = e.find("input");
                    t.on("blur", function(e) {
                        L || ("e" === e.target.name && m(), P(e.target, !0))
                    }),
                    t.on("keyup", function(e) {
                        "e" === e.target.name && 13 !== e.keyCode && (m(), w("e"))
                    }),
                    E(),
                    e.on("submit", function(e) {
                        e.preventDefault(),
                        (0, c.trackGAEvents)("QuickRegister", "Click", "Sign up"),
                        R() && null !== u && (window.grecaptcha.execute(u), L = !0, setTimeout(function() {
                            L = !1
                        }, 100))
                    });
                    var n = (0, s.default)(".quick-sign-up").find(".quickSignUpNote a");
                    n.on("click", function() {
                        (0, c.trackGAEvents)("QuickRegister", "Click", "Terms of Service")
                    })
                })
            };
        window.initFooterSignup = N
    },
    function(e, t, n) {
        "use strict";
        function i(e) {
            return e && e.__esModule
                ? e
                : {
                    default: e
                }
        }
        function a(e, t) {
            if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function")
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var o = function() {
                function e(e, t) {
                    for (var n = 0; n < t.length; n++) {
                        var i = t[n];
                        i.enumerable = i.enumerable || !1,
                        i.configurable = !0,
                        "value" in i && (i.writable = !0),
                        Object.defineProperty(e, i.key, i)
                    }
                }
                return function(t, n, i) {
                    return n && e(t.prototype, n),
                    i && e(t, i),
                    t
                }
            }(),
            r = n(1),
            s = i(r),
            l = n(2),
            d = function() {
                function e() {
                    a(this, e),
                    this.el = {
                        holder: (0, s.default)(".holder"),
                        slideContent: (0, s.default)(".slide-content"),
                        circle: (0, s.default)(".circle")
                    },
                    this.slideWidth = (0, s.default)(".slider").width(),
                    this.touchstartx = void 0,
                    this.touchmovex = void 0,
                    this.movex = void 0,
                    this.index = 0,
                    this.longTouch = void 0,
                    this.onWindowResize = this.onWindowResize.bind(this),
                    this.start = this.start.bind(this),
                    this.move = this.move.bind(this),
                    this.end = this.end.bind(this),
                    this.click = this.click.bind(this)
                }
                return o(e, [
                    {
                        key: "bindUIEvents",
                        value: function() {
                            var e = this;
                            this.el.holder.on("touchstart", this.start),
                            this.el.holder.on("touchmove", this.move),
                            this.el.holder.on("touchend", this.end),
                            this.el.circle.on("click", this.click),
                            window.addEventListener("resize", this.onWindowResize),
                            window.router && window.router.onChangeRoute(function() {
                                window.removeEventListener("resize", e.onWindowResize)
                            }, !1)
                        }
                    }, {
                        key: "onWindowResize",
                        value: function() {
                            this.slideWidth !== (0, s.default)(".slider").width() && (this.slideWidth = (0, s.default)(".slider").width(),
                            this.index = 0,
                            this.changeSlideAnimation())
                        }
                    }, {
                        key: "start",
                        value: function(e) {
                            var t = this;
                            this.longTouch = !1,
                            setTimeout(function() {
                                t.longTouch = !0
                            }, 250),
                            this.touchstartx = e.touches[0].pageX,
                            (0, s.default)(".animate").removeClass("animate")
                        }
                    }, {
                        key: "move",
                        value: function(e) {
                            this.touchmovex = e.touches[0].pageX,
                            this.movex = this.index * this.slideWidth + (this.touchstartx - this.touchmovex);
                            var t = 100 - this.movex / 6;
                            this.movex < this.el.holder.width() && this.el.holder.css({
                                transform: "translate3d(-" + this.movex + "px, 0, 0)"
                            }),
                            t < 100 && this.el.slideContent.css({transform: "translate3d(0, 0, 0)"})
                        }
                    }, {
                        key: "end",
                        value: function() {
                            var e = window.innerWidth < (0, l.resolutionBreakpoints)().sm[1]
                                    ? this.el.slideContent.length - 1
                                    : Math.floor((this.el.slideContent.length - 1) / 2),
                                t = Math.abs(this.index * this.slideWidth - this.movex);
                            (t > this.slideWidth / 2 || this.longTouch === !1) && (this.movex > this.index * this.slideWidth && this.index < e
                                ? this.index ++: this.movex < this.index * this.slideWidth && this.index > 0 && this.index--),
                            this.changeSlideAnimation()
                        }
                    }, {
                        key: "click",
                        value: function(e) {
                            this.circleIndex = Array.prototype.indexOf.call(this.el.circle, e.target),
                            this.index = window.innerWidth < (0, l.resolutionBreakpoints)().sm[1]
                                ? this.circleIndex
                                : Math.floor(this.circleIndex / 2),
                            this.changeSlideAnimation()
                        }
                    }, {
                        key: "changeSlideAnimation",
                        value: function() {
                            this.el.holder.addClass("animate"),
                            this.el.holder.css({
                                transform: "translate3d(-" + this.index * this.slideWidth + "px, 0, 0)"
                            }),
                            this.el.slideContent.addClass("animate"),
                            this.el.slideContent.css({transform: "translate3d(0, 0, 0)"}),
                            this.setSelectedCircle()
                        }
                    }, {
                        key: "setSelectedCircle",
                        value: function() {
                            (0, s.default)(".circles .selected").removeClass("selected"),
                            this.circleIndex = window.innerWidth < (0, l.resolutionBreakpoints)().sm[1]
                                ? this.index
                                : 2 * this.index,
                            (0, s.default)(this.el.circle[this.circleIndex]).addClass("selected")
                        }
                    }
                ]),
                e
            }();
        t.default = d
    },
    function(e, t) {
        "use strict";
        function n(e, t) {
            if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function")
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var i = function() {
                function e(e, t) {
                    for (var n = 0; n < t.length; n++) {
                        var i = t[n];
                        i.enumerable = i.enumerable || !1,
                        i.configurable = !0,
                        "value" in i && (i.writable = !0),
                        Object.defineProperty(e, i.key, i)
                    }
                }
                return function(t, n, i) {
                    return n && e(t.prototype, n),
                    i && e(t, i),
                    t
                }
            }(),
            a = function() {
                function e() {
                    n(this, e)
                }
                return i(e, [
                    {
                        key: "init",
                        value: function(e, t) {
                            var n = this;
                            this.element = e,
                            this.options = {
                                animation: t.animation || !0,
                                placement: this.element.getAttribute("data-placement") || t.placement || "top",
                                duration: this.element.getAttribute("data-duration") || t.duration || 150,
                                delay: this.element.getAttribute("data-delay") || t.delay || 100
                            },
                            this.container = this.element.parentNode,
                            this.title = this.element.getAttribute("data-title"),
                            this.tooltip = null,
                            this.timer = 0,
                            this.title && (this.element.addEventListener("mouseenter", function() {
                                n.show()
                            }), this.element.addEventListener("mouseleave", function() {
                                n.hide()
                            }))
                        }
                    }, {
                        key: "createTooltip",
                        value: function() {
                            this.title = this.element.getAttribute("data-title"),
                            this.tooltip = document.createElement("div"),
                            this.tooltip.setAttribute("role", "tooltip");
                            var e = document.createElement("div");
                            e.className = "tooltip-arrow",
                            this.tooltip.appendChild(e);
                            var t = document.createElement("div");
                            t.className = "tooltip-inner",
                            this.tooltip.appendChild(t),
                            t.innerHTML = this.title,
                            this.container.appendChild(this.tooltip),
                            this.tooltip.className = "tooltip " + this.options.placement + (this.options.animation
                                ? " fade"
                                : "")
                        }
                    }, {
                        key: "positionTooltip",
                        value: function() {
                            var e = {
                                    height: this.element.getBoundingClientRect().height,
                                    left: this.element.offsetLeft,
                                    top: this.element.offsetTop,
                                    width: this.element.getBoundingClientRect().width
                                },
                                t = this.tooltip.getBoundingClientRect(),
                                n = void 0,
                                i = void 0;
                            switch (this.options.placement) {
                                case "left":
                                    n = e.top - t.height / 2 + e.height / 2,
                                    i = e.left - t.width;
                                    break;
                                case "right":
                                    n = e.top - t.height / 2 + e.height / 2,
                                    i = e.left + e.width;
                                    break;
                                case "bottom":
                                    n = e.top + e.height,
                                    i = e.left - t.width / 2 + e.width / 2;
                                    break;
                                case "top":
                                default:
                                    n = e.top - t.height,
                                    i = e.left - t.width / 2 + e.width / 2
                            }
                            this.tooltip.style.top = n + "px",
                            this.tooltip.style.left = i + "px"
                        }
                    }, {
                        key: "showTooltip",
                        value: function() {
                            this.tooltip.className += " in"
                        }
                    }, {
                        key: "removeTooltip",
                        value: function() {
                            this.container.removeChild(this.tooltip),
                            this.tooltip = null,
                            this.timer = 0
                        }
                    }, {
                        key: "show",
                        value: function() {
                            var e = this;
                            clearTimeout(this.timer),
                            this.timer = setTimeout(function() {
                                e.tooltip || (e.createTooltip(), e.positionTooltip(), e.showTooltip())
                            }, 20)
                        }
                    }, {
                        key: "hide",
                        value: function() {
                            var e = this;
                            clearTimeout(this.timer),
                            this.timer = setTimeout(function() {
                                e.tooltip && (e.tooltip.className = e.tooltip.className.replace(/\bin\b/, ""), setTimeout(function() {
                                    e.removeTooltip()
                                }, e.options.duration))
                            }, this.options.delay)
                        }
                    }
                ]),
                e
            }();
        t.default = a
    },
    function(e, t) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var n = {
            easeInQuad: function(e, t, n, i) {
                return n * (e /= i) * e + t
            },
            easeOutQuad: function(e, t, n, i) {
                return -n * (e /= i) * (e - 2) + t
            },
            easeInOutQuad: function(e, t, n, i) {
                return (e /= i / 2) < 1
                    ? n / 2 * e * e + t
                    : -n / 2 * (--e * (e - 2) - 1) + t
            },
            easeInCubic: function(e, t, n, i) {
                return n * (e /= i) * e * e + t
            },
            easeOutCubic: function(e, t, n, i) {
                return n * ((e = e / i - 1) * e * e + 1) + t
            },
            easeInOutCubic: function(e, t, n, i) {
                return (e /= i / 2) < 1
                    ? n / 2 * e * e * e + t
                    : n / 2 * ((e -= 2) * e * e + 2) + t
            },
            easeInQuart: function(e, t, n, i) {
                return n * (e /= i) * e * e * e + t
            },
            easeOutQuart: function(e, t, n, i) {
                return -n * ((e = e / i - 1) * e * e * e - 1) + t
            },
            easeInOutQuart: function(e, t, n, i) {
                return (e /= i / 2) < 1
                    ? n / 2 * e * e * e * e + t
                    : -n / 2 * ((e -= 2) * e * e * e - 2) + t
            },
            easeInQuint: function(e, t, n, i) {
                return n * (e /= i) * e * e * e * e + t
            },
            easeOutQuint: function(e, t, n, i) {
                return n * ((e = e / i - 1) * e * e * e * e + 1) + t
            },
            easeInOutQuint: function(e, t, n, i) {
                return (e /= i / 2) < 1
                    ? n / 2 * e * e * e * e * e + t
                    : n / 2 * ((e -= 2) * e * e * e * e + 2) + t
            },
            easeInSine: function(e, t, n, i) {
                return -n * Math.cos(e / i * (Math.PI / 2)) + n + t
            },
            easeOutSine: function(e, t, n, i) {
                return n * Math.sin(e / i * (Math.PI / 2)) + t
            },
            easeInOutSine: function(e, t, n, i) {
                return -n / 2 * (Math.cos(Math.PI * e / i) - 1) + t
            },
            easeInExpo: function(e, t, n, i) {
                return 0 == e
                    ? t
                    : n * Math.pow(2, 10 * (e / i - 1)) + t
            },
            easeOutExpo: function(e, t, n, i) {
                return e == i
                    ? t + n
                    : n * (-Math.pow(2, -10 * e / i) + 1) + t
            },
            easeInOutExpo: function(e, t, n, i) {
                return 0 == e
                    ? t
                    : e == i
                        ? t + n
                        : (e /= i / 2) < 1
                            ? n / 2 * Math.pow(2, 10 * (e - 1)) + t
                            : n / 2 * (-Math.pow(2, -10 * --e) + 2) + t
            },
            easeInCirc: function(e, t, n, i) {
                return -n * (Math.sqrt(1 - (e /= i) * e) - 1) + t
            },
            easeOutCirc: function(e, t, n, i) {
                return n * Math.sqrt(1 - (e = e / i - 1) * e) + t
            },
            easeInOutCirc: function(e, t, n, i) {
                return (e /= i / 2) < 1
                    ? -n / 2 * (Math.sqrt(1 - e * e) - 1) + t
                    : n / 2 * (Math.sqrt(1 - (e -= 2) * e) + 1) + t
            },
            easeInElastic: function(e, t, n, i) {
                var a = 1.70158,
                    o = 0,
                    r = n;
                return 0 == e
                    ? t
                    : 1 == (e /= i)
                        ? t + n
                        : (o || (o = .3 * i), r < Math.abs(n)
                            ? (r = n, a = o / 4)
                            : a = o / (2 * Math.PI) * Math.asin(n / r), -(r * Math.pow(2, 10 * (e -= 1)) * Math.sin((e * i - a) * (2 * Math.PI) / o)) + t)
            },
            easeOutElastic: function(e, t, n, i) {
                var a = 1.70158,
                    o = 0,
                    r = n;
                return 0 == e
                    ? t
                    : 1 == (e /= i)
                        ? t + n
                        : (o || (o = .3 * i), r < Math.abs(n)
                            ? (r = n, a = o / 4)
                            : a = o / (2 * Math.PI) * Math.asin(n / r), r * Math.pow(2, -10 * e) * Math.sin((e * i - a) * (2 * Math.PI) / o) + n + t)
            },
            easeInOutElastic: function(e, t, n, i) {
                var a = 1.70158,
                    o = 0,
                    r = n;
                return 0 == e
                    ? t
                    : 2 == (e /= i / 2)
                        ? t + n
                        : (o || (o = i * (.3 * 1.5)), r < Math.abs(n)
                            ? (r = n, a = o / 4)
                            : a = o / (2 * Math.PI) * Math.asin(n / r), e < 1
                            ? -.5 * (r * Math.pow(2, 10 * (e -= 1)) * Math.sin((e * i - a) * (2 * Math.PI) / o)) + t
                            : r * Math.pow(2, -10 * (e -= 1)) * Math.sin((e * i - a) * (2 * Math.PI) / o) * .5 + n + t)
            },
            easeInBack: function(e, t, n, i, a) {
                return void 0 == a && (a = 1.70158),
                n * (e /= i) * e * ((a + 1) * e - a) + t
            },
            easeOutBack: function(e, t, n, i, a) {
                return void 0 == a && (a = 1.70158),
                n * ((e = e / i - 1) * e * ((a + 1) * e + a) + 1) + t
            },
            easeInOutBack: function(e, t, n, i, a) {
                return void 0 == a && (a = 1.70158),
                (e /= i / 2) < 1
                    ? n / 2 * (e * e * (((a *= 1.525) + 1) * e - a)) + t
                    : n / 2 * ((e -= 2) * e * (((a *= 1.525) + 1) * e + a) + 2) + t
            },
            easeOutBounce: function(e, t, n, i) {
                return (e /= i) < 1 / 2.75
                    ? n * (7.5625 * e * e) + t
                    : e < 2 / 2.75
                        ? n * (7.5625 * (e -= 1.5 / 2.75) * e + .75) + t
                        : e < 2.5 / 2.75
                            ? n * (7.5625 * (e -= 2.25 / 2.75) * e + .9375) + t
                            : n * (7.5625 * (e -= 2.625 / 2.75) * e + .984375) + t
            },
            easeInBounce: function(e, t, i, a) {
                return i - n.easeOutBounce(a - e, 0, i, a) + t
            },
            easeInOutBounce: function(e, t, i, a) {
                return e < a / 2
                    ? .5 * n.easeInBounce(2 * e, 0, i, a) + t
                    : .5 * n.easeOutBounce(2 * e - a, 0, i, a) + .5 * i + t
            }
        };
        t.default = n
    },
    function(e, t) {
        "use strict";
        function n(e, t) {
            if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function")
        }
        function i(e) {
            return /^[a-z0-9-_]+$/i.test(e)
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var a = function e(t) {
            var a = arguments.length > 1 && void 0 !== arguments[1]
                ? arguments[1]
                : document;
            if (n(this, e), "undefined" == typeof t || "" === t)
                return this;
            if ("undefined" != typeof t.nodeType)
                return this[0] = t,
                this.length = 1,
                this;
            if ("body" === t && document.body)
                return this[0] = document.getElementsByTagName("body")[0],
                this.length = 1,
                this;
            if ("string" != typeof t)
                return this[0] = t,
                this.length = 1,
                this;
            var o = void 0;
            if ("." === t[0] && i(t.substr(1)))
                o = a.getElementsByClassName(t.substr(1));
            else if ("#" === t[0] && i(t.substr(1))) {
                var r = a.getElementById(t.substr(1));
                o = r
                    ? [r]
                    : []
            } else
                o = i(t)
                    ? a.getElementsByTagName(t)
                    : a.querySelectorAll(t);
            var s = o.length,
                l = void 0;
            for (l = 0; l < s; l++)
                this[l] = o[l];
            return this.length = o.length,
            this
        };
        t.default = a
    },
    function(e, t) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var n = function(e) {
            var t = arguments.length > 1 && void 0 !== arguments[1]
                ? arguments[1]
                : "general";
            return new Promise(function(n, i) {
                if (void 0 !== window.bsTexts)
                    window.bsTexts[t] && window.bsTexts[t][e]
                        ? n(window.bsTexts[t][e])
                        : i("Text not found");
                else {
                    var a = document.createElement("script");
                    a.type = "text/javascript",
                    a.async = !0,
                    a.src = window.translationsJsFilePath;
                    var o = document.getElementsByTagName("script")[0];
                    o.parentNode.insertBefore(a, o),
                    a.addEventListener("load", function() {
                        window.bsTexts[t] && window.bsTexts[t][e]
                            ? n(window.bsTexts[t][e])
                            : i("Text not found")
                    }),
                    a.addEventListener("error", function() {
                        i("Error loading texts file.")
                    })
                }
            })
        };
        t.default = n
    },
    function(e, t) {
        "use strict";
        window.youtubeScriptTag = document.createElement("script"),
        youtubeScriptTag.src = "https://www.youtube.com/iframe_api",
        window.firstScriptTag = document.getElementsByTagName("script")[0],
        firstScriptTag.parentNode.insertBefore(youtubeScriptTag, firstScriptTag),
        window.onYouTubeIframeAPIReady = function() {
            window.youTubeIframeAPIReady = !0
        },
        window.embedYouTubeIframePlayer = function(e) {
            var t = {
                elementId: "youtubeVideo",
                trackOrigin: "mybanners",
                playerConfig: {
                    wmode: "opaque",
                    allowfullscreen: "true",
                    videoId: "OUTEUJrzcaU",
                    width: "100%",
                    height: "100%",
                    playerVars: {
                        wmode: "opaque",
                        enablejsapi: 1,
                        rel: 0
                    },
                    events: {
                        onStateChange: onYoutubeVideoStateChange
                    }
                }
            };
            e && $.extend(!0, t, e),
            window.youTubeIframeAPIReady
                ? window.ExplainerVideoTracking = {
                    player: new YT.Player(t.elementId, t.playerConfig),
                    origin: t.trackOrigin,
                    stateFlag: -1,
                    videoId: t.playerConfig.videoId
                }
                : setTimeout(function() {
                    embedYouTubeIframePlayer(t)
                }, 50)
        },
        window.embedYouTubeIframePlayerWithIframe = function(e, t, n) {
            window.youTubeIframeAPIReady
                ? window.ExplainerVideoTracking = {
                    player: new YT.Player(e, {
                        events: {
                            onStateChange: onYoutubeVideoStateChange
                        }
                    }),
                    origin: n,
                    stateFlag: -1,
                    videoId: t
                }
                : setTimeout(function() {
                    embedYouTubeIframePlayerWithIframe(e, t, n)
                }, 50)
        },
        window.onYoutubeVideoStateChange = function(e) {
            var t = "",
                n = window.ExplainerVideoTracking;
            switch (e.data) {
                case 1:
                    t = "Play campaign video - ";
                    break;
                case 2:
                    t = "Pause campaign video - ";
                    break;
                case 0:
                    t = "End campaign video - "
            }
            "" != t && e.data != n.stateFlag && (gTrack("Explainer video - " + n.origin, t + n.origin, "Banner advertising. The snack way! | " + n.videoId), window.ExplainerVideoTracking.stateFlag = e.data)
        }
    },
    function(e, t) {
        "use strict";
        function n(e) {
            if (!e)
                return !1;
            if (e.length > 254)
                return !1;
            var t = o.test(e);
            if (!t)
                return !1;
            var n = e.split("@");
            if (n[0].length > 64)
                return !1;
            var i = n[1].split(".");
            return !i.some(function(e) {
                return e.length > 63
            })
        }
        function i(e, t) {
            var n = !1;
            try {
                n = a.validate(e),
                t(null, n)
            } catch (e) {
                t(e, n)
            }
        }
        var a = {},
            o = /^[-!#$%&'*+\/0-9=?A-Z^_a-z{|}~](\.?[-!#$%&'*+\/0-9=?A-Z^_a-z`{|}~])*@[a-zA-Z0-9](-?\.?[a-zA-Z0-9])*\.[a-zA-Z](-?[a-zA-Z0-9])+$/;
        a.validate = n,
        a.validate_async = i,
        e.exports = a
    }
]);
