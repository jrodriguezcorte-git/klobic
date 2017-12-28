function confirmLeaveEditorPage(a) {
    return confirm(getTxt("leave_app_page_confirm"))
        ? (a && (location.href = a), !0)
        : ("#bs-add-funds" === location.hash && (location.hash = "#_"), !1)
}
function confirmLeaveEditorPageRouter(a, b, c) {
    return ignoreNextRouter
        ? (ignoreNextRouter = !1, !1)
        : !!confirmLeaveEditorPage() || (c && (ignoreNextRouter = !0, history.forward(), setTimeout(function() {
            ignoreNextRouter = !1
        }, 100)), !1)
}
function newBannerPopin(a) {
    a = a || {};
    var b = {
        type: "new_banner"
    };
    a = $.extend(b, a);
    var c = function() {
            var b = '<div class="new-banner-popin">';
            switch (a.type) {
                case "new_banner":
                case "duplicate_banner":
                    b += "<p>You have reached the maximum number of banners you can create.</p>",
                    b += "<p>Please upgrade your plan to create more banners.</p>";
                    break;
                case "edit_banner":
                    b += "<p>You have reached the maximum number of banners you can create.</p>",
                    b += "<p>Please upgrade your plan to create more banners.</p>";
                    break;
                case "new_rotator":
                    b += "<p>You have reached the maximum number of free rotators.</p>",
                    b += "<p>Please upgrade your plan to create more rotators</p>";
                    break;
                case "edit_rotator":
                    b += "<p>You have reached the maximum number of free rotators.</p>",
                    b += "<p>Please upgrade your plan to create more rotators</p>"
            }
            return b += "</div>"
        },
        d = function() {
            switch (a.type) {
                case "new_banner":
                case "duplicate_banner":
                    return "You are not allowed to create more banners";
                case "new_rotator":
                    return "You are not allowed to create more rotators";
                case "edit_banner":
                    return "You are not allowed to edit the banner";
                case "edit_rotator":
                    return "You are not allowed to edit the rotator";
                default:
                    return !1
            }
        },
        e = '<div class="modal fade large free-cant" tabindex="-1" role="dialog" >   <div class="modal-dialog">       <div class="modal-content">           <div class="modal-header">               <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>               <h4 class="modal-title">' + d() + '</h4>           </div>           <div class="modal-body">' + c() + '</div>           <div class="modal-footer">               <button type="button" class="btn btn-default" data-dismiss="modal">Dismiss</button>               <button type="button" class="btn btn-primary see-premium-plans">Upgrade</button>           </div>       </div>   </div></div>',
        f = $(e).modal();
    f.on("hidden.bs.modal", function() {
        f.remove()
    }),
    f.find(".see-premium-plans").on("click", function() {
        window.open(langPre + "/go-premium/?from=new-banner-popin", "_blank"),
        loggedUser.setNewTimeout(3),
        f.modal("hide")
    })
}
var BSLimitationPopinRedirect = function() {
        window.open(langPre + "/go-premium/", "_blank")
    },
    BSLimitationPopin = function(a, b) {
        b || (b = "");
        var c = "",
            d = [
                "heatmap",
                "tags",
                "score",
                "download-html5-swf",
                "flash",
                "download-mp4",
                "br_advanced_rotation_settings"
            ];
        d.indexOf(a) === -1 && (c = "<p>For the existing premium elements in your banner we've disabled the Edit and Customize options.</p>");
        var e = loggedUser && loggedUser.serviceType
            ? loggedUser.serviceType
            : "free";
        e = e.charAt(0).toUpperCase() + e.slice(1);
        var f = $('<div id="limitation-popin-' + a + '" class="modal fade limitation-popin"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button><p>This feature is not available in the ' + e + ' Plan</p></div><div class="modal-body">' + b + c + '<p>You can get access to this feature by upgrading your membership.</p></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Dismiss</button><button type="button" class="btn btn-primary see-premium-plans">Upgrade</button></div></div></div></div>');
        f.modal("show"),
        f.on("hidden.bs.modal", function() {
            f.remove()
        }),
        f.find(".see-premium-plans").on("click", function() {
            BSLimitationPopinRedirect(),
            loggedUser.setNewTimeout(3);
            var a = window.limitation && window.limitation.activateControlsMenuItems;
            a && window.limitation.activateControlsMenuItems(),
            f.modal("hide")
        })
    },
    bsBuyPoints = function(a) {
        function b(a) {
            if (a)
                for (var b in a)
                    this[b] = a[b]
        }
        function c(a) {
            if (a)
                for (var b in a)
                    this[b] = a[b]
        }
        function d(a) {
            if (a) {
                for (var b in a)
                    this[b] = a[b];
                this.upgradeDiscountValue = parseFloat(this.upgradeDiscountValue) || 0,
                this.value = parseFloat(this.value) || 0
            }
        }
        var e,
            f,
            g,
            h,
            i,
            j,
            k,
            l,
            m,
            n,
            o = $.userApi,
            p = null,
            q = 4,
            r = 8,
            s = "snack-vip-yearly",
            t = "vip-extended-yearly",
            u = null,
            v = {},
            w = null,
            x = "";
        a = a || {};
        var y = null,
            z = function() {
                o.buyPointsModal && o.buyPointsModal.is(":visible") && o.buyPointsModal.modal("hide"),
                p = $('<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="buy-points" aria-hidden="true" id="buyPointsModal"><div class="modal-dialog modal-buy-points" style="width: 100%; max-width: 900px;"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Loading...</h4></div><div class="modal-body" style="min-height: 500px"></div></div></div></div>'),
                p.on("shown.bs.modal", B),
                p.on("hidden.bs.modal", C),
                p.modal("show"),
                a.methodBuy || (a.methodBuy = 2),
                o.buyPointsModal = p,
                A()
            },
            A = function() {
                $.ajax({
                    url: "/ajax.php",
                    data: {
                        page: "go-premium-user-info"
                    },
                    error: function() {
                        p.modal("hide")
                    },
                    success: function(a) {
                        20 === a.code
                            ? y = a.res.userInfo
                            : (BSAlert(a.res), p.modal("hide"))
                    }
                })
            },
            B = function() {
                IntercomScript.trackEvent("Viewed go premium pop-in"),
                F(),
                $("html").css("overflow", "hidden")
            },
            C = function() {
                p.detach(),
                o.buyPointsModal === p && (location.hash = "#_"),
                p = null,
                $("html").css("overflow", "auto")
            },
            D = function(b) {
                p.find(".modal-title").text("Error");
                var c = p.find(".modal-body");
                c.html("<div>" + b + "<div>");
                var d = $('<a href="#">Try again</a>');
                d.click(function() {
                    p.modal("hide"),
                    o._buyPointsBS(a)
                }),
                c.append("<br>", d)
            },
            E = function(a, b) {
                return a.price - b.getDiscount(a) <= 0
            },
            F = function() {
                var b,
                    c,
                    d = [
                        "service",
                        "coupon",
                        "methodBuy",
                        "views",
                        "type",
                        "pug",
                        "upgrade",
                        "hm",
                        "users",
                        "users_agency",
                        "users_business",
                        "views_agency",
                        "views_business"
                    ],
                    e = {
                        page: "buy-points-bs"
                    };
                for (b = 0; c = d[b]; b++)
                    a[c] && (e[c] = a[c]);
                o.isAgencyManager && (e.isAgencyManager = 1);
                var f = new LoaderHover(p.find(".modal-body"));
                f.setZIndex(1040),
                o.ajax({
                    data: e,
                    error: function(a) {
                        D("Internal server error")
                    },
                    success: J,
                    complete: function() {
                        f.remove()
                    }
                })
            },
            G = function(a) {
                if (a) {
                    var b = 0;
                    u.flags & r
                        ? b = parseFloat(u.campaigns_budget)
                        : u.flags & q && (b = parseFloat(v.price - u.getDiscount(v)), (!b || b < 0) && (b = 0)),
                    E(v, u) || w || ("snack-vip-yearly" === v.hash && b < 100
                        ? b = 100
                        : "vip-extended-yearly" === v.hash && b < 200 && (b = 200)),
                    a = a.replace("{amount}", parseFloat(b.toFixed(2))),
                    u && u.isTypeUpgrade() && (a = a.replace("%s", formatNumber(u.getDiscount(v), 2)))
                }
                var c = i.find("div.msg");
                c.removeClass("cerr").addClass("cnot").html(a),
                c.fadeIn("fast")
            },
            H = function() {
                i.find("div.msg").hide()
            },
            I = function(b, c) {
                var d = b.price;
                if (c || v.hash != b.hash || v.price != b.price) {
                    if (v = b, !v.hash)
                        return;
                    j.find('input[name="serv"]').val(v.hash),
                    j.find('input[name="views"]').val(v.views || 0),
                    j.find('input[name="users"]').val(v.users || 0);
                    var g = p.find("select[name=users]").closest(".feature");
                    v.users && 1 != v.users
                        ? g.addClass("plural").removeClass("singular")
                        : g.addClass("singular").removeClass("plural"),
                    e || (k.find(".details").text(v.name), k.find(".price").text("$" + v.price.toFixed(2)), k.find(".desc").html(v.description), l.hide(), p.find(".plans-container,.plans-type,.pconthelper").hide(), k.show());
                    var h = p.find(".paymethods"),
                        q = p.find(".fulldiscountinfo");
                    if (u) {
                        var r = u.getDiscount(v);
                        m.find(".discount").text("$" + formatNumber(r.toFixed(2), 2));
                        var w = b.price - r;
                        if (w < 0 && (w = 0), d = w, m.find(".total").text("$" + formatNumber(w.toFixed(2), 2)), m.show(), 0 === w
                            ? (h.hide(), q.show().find("input[name=method_buy]").attr("checked", !0))
                            : (q.hide(), h.show().find("input[name=method_buy][value=" + a.methodBuy + "]").attr("checked", !0)), u.isUpgradeCoupon()
                            ? i.addClass("upgrade")
                            : i.removeClass("upgrade"), w > 0 && v.recursive) {
                            var y = 0;
                            y = u.isSubscriptionProcentual()
                                ? v.price * parseFloat(u.subscription_value) / 100
                                : parseFloat(u.subscription_value);
                            var z = b.price - y,
                                A = "",
                                B = ["initial_payment", "recurrent", "recurrent_monthly", "recurrent_yearly"];
                            o.getMultipleTexts(JSON.stringify(B), function(a) {
                                var b = JSON.parse(a),
                                    c = b.initial_payment,
                                    d = b.recurrent,
                                    e = b.recurrent_monthly,
                                    f = b.recurrent_yearly;
                                switch (c = c.replace("%s", formatNumber(w, 2)), d = d.replace("%s", formatNumber(z, 2)), f = f.replace("%s", v.months.toString()), f = f.replace("%s", v.months.toString()), A = c + ". " + d, v.months) {
                                    case 1:
                                        A += " " + e;
                                        break;
                                    default:
                                        A += " " + f
                                }
                                n.html(A).show()
                            })
                        } else
                            n.hide();

                        !v.recursive && u.isUpgradeCoupon()
                            ? H()
                            : G(x);
                        var C = i.find("input[name=coupon]");
                        u.number != C.val() && C.val(u.number)
                    } else
                        q.hide(),
                        h.show().find("input[name=method_buy][value=" + a.methodBuy + "]").attr("checked", !0),
                        m.hide();
                    var D = j.find(".noteValidLicence");
                    f && v.recursive
                        ? D.show()
                        : D.hide(),
                    D = j.find(".note-campaigns-bonus"),
                    v.hash !== s && v.hash !== t && "banner-business-yearly" !== v.hash && "banner-agency-yearly" !== v.hash
                        ? D.hide()
                        : D.show();
                    var E,
                        F;
                    if (d > __maxPayflowProAmount) {
                        if (E = p.find(".paymethod.method6,.paymethod.method8"), F = E.find("input[name=method_buy]"), 6 == a.methodBuy || 8 == a.methodBuy) {
                            var I = p.find(".paymethod.method2 input[name=method_buy]");
                            I.attr("checked", !0),
                            I.triggerHandler("click"),
                            a.methodBuy = 2
                        }
                        F.attr("disabled", !0),
                        E.addClass("disabled")
                    } else
                        E = p.find(".paymethod.method6,.paymethod.method8"),
                        F = E.find("input[name=method_buy]"),
                        E.removeClass("disabled"),
                        F.attr("disabled", !1)
                }
            },
            J = function(d) {
                if (200 !== d.code)
                    return 300 == d.code
                        ? void o.goToLogin()
                        : void D(d.data);
                if (p) {
                    if (p.find(".modal-content").html(d.data.content), d.data.upgradeCoupon && (a.coupon = d.data.upgradeCoupon, h = new b(d.data.upgradeService)), w = d.data.alreadyReceivedCampaignsBonus, i = p.find("div.couponCont"), j = p.find("form.paymentForm"), e = d.data.isSelectedServiceInList, k = p.find(".serviceInfo"), l = p.find(".plans div.plan"), m = i.find("div.discountInfo"), n = i.find("div.couponDescription"), f = d.data.haveActiveRecurringProfile || !1, g = d.data.selectedServiceHash, "UPGRADEBS2015" === a.coupon) {
                        var q = p.find(".plan.plan-pro");
                        q.hide(),
                        "banner-pro-yearly" === g && (g = "banner-business-yearly")
                    }
                    var r = new c(d.data.selectedService) || null;
                    l.length
                        ? P(l)
                        : r && r.hash
                            ? I(r, !0)
                            : k.html("Invalid product").show(),
                    K(a);
                    var s = p.find(".paymethods input[name=method_buy]");
                    s.each(function() {
                        var b = $(this);
                        b.click(function() {
                            a.methodBuy = $(this).val();
                            var b = 6 === a.methodBuy || 8 === a.methodBuy;
                            j.attr("target", b
                                ? "_self"
                                : "_blank")
                        }),
                        b.val() == a.methodBuy && (b.prop("checked", !0), b.triggerHandler("click"))
                    }),
                    o.referralHash && j.find("input[name=referralHash]").val(o.referralHash),
                    j.submit(O),
                    a.userClick !== !1 && "undefined" != typeof dataLayerForGoogleTagManager && (dataLayerForGoogleTagManager.push({event: "open_gopremium_popin"}), "undefined" != typeof dataLayerForGoogleTagManager2 && dataLayerForGoogleTagManager2.push({event: "open_gopremium_popin"})),
                    N(),
                    p.find("select[name=users]").change(function() {
                        var a = $(this),
                            b = a.closest(".feature");
                        1 == a.val()
                            ? b.addClass("singular").removeClass("plural")
                            : b.addClass("plural").removeClass("singular")
                    }),
                    p.find("sup.help").each(function() {
                        $(this).tooltip({
                            html: !0
                        })
                    }),
                    p.find("select.users").fakeSelect(),
                    p.find("select.servviews").fakeSelect()
                }
            },
            K = function(a) {
                var b = p.find(".couponHref");
                b.click(function(a) {
                    i.is(":visible")
                        ? (a.isTrigger || ga("b.send", "event", "Popin go premium", "Click", "Close discount"), i.slideUp("fast"))
                        : (a.isTrigger || ga("b.send", "event", "Popin go premium", "Click", "I have a discount"), i.slideDown("fast"));
                    var b = $(this),
                        c = $(this).html();
                    return b.html(b.data("alttext")).data("alttext", c),
                    !1
                });
                var c = i.find("input[name=coupon]"),
                    d = i.find("a.applycoupon");
                c.keypress(function(a) {
                    if (13 == a.keyCode)
                        return d.triggerHandler("click"),
                        ga("b.send", "event", "Popin go premium", "Enter", "Apply coupon"),
                        !1
                }),
                d.click(function(a) {
                    return M(c.val()),
                    a.isTrigger || ga("b.send", "event", "Popin go premium", "Click", "Apply coupon"),
                    !1
                }),
                a.coupon && (b.triggerHandler("click"), c.val(a.coupon), d.triggerHandler("click"), ga("b.send", "event", "Popin go premium", "Load", "Coupon automatically applied"))
            },
            L = !1,
            M = function(a) {
                if (!L) {
                    L = !0;
                    var b = i.find("div.msg");
                    b.hide(),
                    n.hide();
                    var f = function(a) {
                        b.removeClass("cnot").addClass("cerr").html(a),
                        b.fadeIn("fast")
                    };
                    if (!a)
                        return o.getText("complete_your_coupon", function(a) {
                            f(a)
                        }),
                        L = !1,
                        !1;
                    var g = {
                        page: "check-coupon",
                        coupon: a
                    };
                    o.isAgencyManager && (g.isAgencyManager = 1);
                    var h = new LoaderHover(p.find(".paywith"));
                    h.setZIndex(1040),
                    o.ajax({
                        data: g,
                        complete: function() {
                            h.remove(),
                            L = !1
                        },
                        success: function(a) {
                            if (200 === a.code) {
                                var b = a.data;
                                u = new d(b.coupon),
                                j.find("input[name=coupon]").val(u.number),
                                a.data.service
                                    ? (e = !1, I(new c(a.data.service), !0))
                                    : I(v, !0),
                                x = b.message,
                                G(x),
                                p.find(".couponHref").hide()
                            } else
                                f(a.data),
                                u = null,
                                x = null,
                                I(v, !0)
                        }
                    })
                }
            },
            N = function() {
                var a = p.find(".plans-type"),
                    b = a.find("a"),
                    c = p.find(".plans"),
                    d = a.find(".onoffswitch-popin-checkbox"),
                    e = function() {
                        c.removeClass("col1 col2 col3").addClass("col" + c.find(".plan:visible").length)
                    };
                d.change(function() {
                    "checked" === $(this).attr("checked")
                        ? p.find(".plans-type a.yearly").trigger("click")
                        : p.find(".plans-type a.monthly").trigger("click")
                }),
                b.on("click", function() {
                    if ($(this).hasClass("selected"))
                        return !1;
                    var a = $(this).hasClass("monthly")
                            ? 1
                            : 12,
                        f = !1;
                    p.find("select[name=add_serv]").each(function() {
                        var b = $(this),
                            c = b.find("option[data-months=" + a + "]"),
                            d = b.closest(".plan");
                        if (c.length) {
                            b.val(c.val());
                            var e = !(d.hasClass("selected") || f);
                            b.triggerHandler("change", e),
                            f = !1,
                            d.show()
                        } else
                            d.hide(),
                            d.hasClass("selected") && (f = !0)
                    }),
                    b.removeClass("selected"),
                    $(this).addClass("selected");
                    var g = p.find(".price-yearly-info.active");
                    return 12 == a
                        ? (ga("b.send", "event", "Popin go premium", "Click", "Yearly plan"), c.addClass("yearly").removeClass("monthly"), g.css("visibility", "visible"), d.attr("checked", !0))
                        : (ga("b.send", "event", "Popin go premium", "Click", "Monthly plan"), c.addClass("monthly").removeClass("yearly"), g.css("visibility", "hidden"), d.attr("checked", !1)),
                    e(),
                    !1
                }),
                e(),
                v.recursive && 1 == v.months && a.find("a.monthly").triggerHandler("click")
            },
            O = function(a, b) {
                if (!y)
                    return !1;
                var c = new LoaderHover(p.find(".modal-body"));
                if (c.setZIndex(1040), ga("b.send", "event", "Popin go premium", "Click", "Post your order"), b !== !0) {
                    if (u && (u.isUpgradeCoupon() || u.isTypeUpgrade()) && v.recursive) {
                        var d = v.price - u.getDiscount(v);
                        if (d < 1)
                            return o.getTexts([
                                "bs_cant_upgrade_downgrade", "bs_cant_upgrade_downgrade_content"
                            ], function(a) {
                                c.remove(),
                                BSAlert("<strong>" + a.bs_cant_upgrade_downgrade + "</strong><br><br>" + a.bs_cant_upgrade_downgrade_content)
                            }, {
                                raw: !0
                            }),
                            !1
                    }
                    if (v.users && y.hasUsedFunds && !o.isAgencyManager)
                        return o.getTexts(["bs_user_has_funds_history_err"], function(a) {
                            c.remove(),
                            BSAlert(a.bs_user_has_funds_history_err)
                        }, {
                            raw: !0
                        }),
                        !1;
                    if (Q(function() {
                        j.triggerHandler("submit", !0),
                        c.remove()
                    }, function() {
                        c.remove()
                    }))
                        return !1
                }
                o.onBuyPoints();
                var e = j.attr("action") + "?" + j.serialize();
                return "_blank" === j.attr("target")
                    ? (p.modal("hide"), window.open(e))
                    : location.href = e,
                c.remove(),
                !1
            },
            P = function(a) {
                a.each(function() {
                    var b = this,
                        d = $(this),
                        e = d;
                    if (!d.hasClass("free")) {
                        var f = d.find('select[name="add_serv"]'),
                            h = d.find('select[name="views"]'),
                            i = d.find('select[name="users"]'),
                            j = !!f.data("recursive");
                        d.click(function(b) {
                            b.isTrigger || (e.hasClass("plan-basic")
                                ? ga("b.send", "event", "Popin go premium", "Click", "Basic")
                                : e.hasClass("plan-pro")
                                    ? ga("b.send", "event", "Popin go premium", "Click", "Pro")
                                    : ga("b.send", "event", "Popin go premium", "Click", "Business")),
                            a.removeClass("selected"),
                            e.addClass("selected"),
                            e.find('input[name="selservice"]').attr("checked", !0);
                            var g = f.find("option:selected"),
                                k = new c({
                                    months: parseInt(g.data("months")) || 0,
                                    recursive: j,
                                    price: parseFloat(g.data("price")),
                                    hash: g.val(),
                                    views: parseInt(h.val()) || 0,
                                    users: null
                                });
                            i.length && (k.users = parseInt(i.val())),
                            (k.users || k.views) && (k.price = k.price * (k.users || 1) * ((k.views || 1e5) / 1e5)),
                            I(k),
                            k.hash === s || k.hash === t
                                ? d.find(".inf .bonus-campaigns").show()
                                : d.find(".inf .bonus-campaigns").hide()
                        });
                        var k = !!e.data("showPricePerPoint");
                        f.change(function(a, c) {
                            var d = f.find("option:selected"),
                                g = d.data("months"),
                                j = d.data("price"),
                                l = $(b).find("div.price"),
                                m = g
                                    ? j / g
                                    : k
                                        ? j / d.data("points")
                                        : j;
                            (h.length || i.length) && (m = m * (i.val() || 1) * ((h.val() || 1e5) / 1e5)),
                            12 == d.data("months") && (e.find(".price-yearly-info em").text(formatNumber(12 * m)), e.find(".price-fake b").text(formatNumber(m))),
                            l.find("strong").text(formatNumber(m)),
                            c || e.triggerHandler("click")
                        }),
                        o.isAgencyManager && BSC.agencyManagersCount > 1 && i.find("option").each(function() {
                            $(this).val() < BSC.agencyManagersCount && $(this).remove()
                        }),
                        h.add(i).on("change", function() {
                            f.triggerHandler("change", !0),
                            e.triggerHandler("click")
                        }),
                        f.find('option[value="' + g + '"]').length && (f.val(g), d.triggerHandler("click")),
                        f.triggerHandler("change", !0)
                    }
                })
            },
            Q = function(a, b) {
                var c = !1,
                    d = !1,
                    e = null,
                    f = u && u.isUpgradeCoupon(),
                    g = ["bs_do_you_want_to_continue", "bs_upgrade_note_yes", "bs_upgrade_note_no", "bs_important_note"];
                return v.recursive && (g.push("bs_important_upgrade_note", "bs_existing_subscription_used_as_discount"), h && (h.isFromBannersnack()
                    ? h.haveUsers() && v.users && (h._users == v.users && h.views == v.views || (g.push("bs_bannersnack_license_will_be_changed_to"), e = "bs_bannersnack_license_will_be_changed_to"))
                    : (g.push("bs_upgrade_changing_your_license_to"), e = "bs_upgrade_changing_your_license_to")), (e || f) && (c = !0, d = !0)),
                v.users && !o.isAgencyManager && (y.hasCampaigns || y.hasAudiences) && (g.push("bs_note_has_campaigns"), d = !0),
                d && o.getTexts(g, function(d) {
                    var g = "";
                    if (c && (f && (g = d.bs_existing_subscription_used_as_discount), e))
                        switch (e) {
                            case "bs_upgrade_changing_your_license_to":
                                d[e] = d[e].replace(/{license}/g, v.getPlanName()),
                                g && (g = "<br><br>" + g),
                                g = d[e] + g;
                                break;
                            case "bs_bannersnack_license_will_be_changed_to":
                                d[e] = d[e].replace("{users}", v.users),
                                d[e] = d[e].replace("{views}", formatNumber(v.views)),
                                g = d[e] + " " + g
                        }
                    d.bs_note_has_campaigns && (g && (g += "<br><br>"), g += d.bs_note_has_campaigns);
                    var h = $('<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="bs-upgrade-note-modal" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">' + (c && u && u.isUpgradeCoupon()
                            ? d.bs_important_upgrade_note
                            : d.bs_important_note) + '</h4></div><div class="modal-body">' + g + '</div><div class="modal-footer"><strong style="margin-right: 30px">' + d.bs_do_you_want_to_continue + '</strong><button type="button" class="btn btn-primary">' + d.bs_upgrade_note_yes + '</button><button type="button" class="btn btn-default">' + d.bs_upgrade_note_no + "</button></div></div></div></div>"),
                        i = !1;
                    h.on("hidden.bs.modal", function() {
                        h.remove(),
                        i || b.apply(h)
                    }),
                    h.modal(),
                    h.find(".btn-primary").on("click", function() {
                        h.modal("hide"),
                        a && "function" == typeof a && (i = !0, a.apply())
                    }),
                    h.find(".btn-default").on("click", function() {
                        h.modal("hide"),
                        b && "function" == typeof b && (i = !0, b.apply())
                    })
                }, {
                    raw: !0
                }),
                d
            };
        b.prototype = {
            isFromBannersnack: function() {
                return "bannersnack" === this.terminal
            },
            haveUsers: function() {
                return !!(this._users && this._users > 0)
            }
        },
        c.prototype = {
            getPlanName: function() {
                return 0 === this.hash.indexOf("banner-agency")
                    ? "Bannersnack Agency"
                    : 0 === this.hash.indexOf("banner-business")
                        ? "Bannersnack Business"
                        : 0 === this.hash.indexOf("banner-vip-membership") || 0 === this.hash.indexOf("banner-pro")
                            ? "Bannersnack Pro"
                            : 0 === this.hash.indexOf("banner-basic")
                                ? "Bannersnack Basic"
                                : "Bannersnack"
            }
        },
        d.prototype = {
            getDiscount: function(a) {
                var b = 0;
                return this.isUpgradeCoupon() && !a.recursive
                    ? 0
                    : (b = this.isProcentual()
                        ? a.price * parseFloat(this.value) / 100
                        : this.isTypeUpgrade()
                            ? (a.price - this.upgradeDiscountValue) * this.value / 100 + this.upgradeDiscountValue
                            : parseFloat(this.value), b = Math.round(100 * b) / 100)
            },
            isUpgradeCoupon: function() {
                return !!(32 & this.flags)
            },
            isTypeUpgrade: function() {
                return this.type === this.COUPON_TYPE_UPGRADE
            },
            isProcentual: function() {
                return this.type == this.COUPON_TYPE_PROCENTUAL
            },
            isSubscriptionProcentual: function() {
                return this.subscription_type == this.COUPON_TYPE_PROCENTUAL
            },
            COUPON_TYPE_PROCENTUAL: "procentual",
            COUPON_TYPE_UPGRADE: "upgrade"
        },
        z()
    },
    CancelSubscriptionPopin = function(a) {
        this.init(),
        this.cancelSubscription = a
    };
CancelSubscriptionPopin.prototype = {
    init: function() {
        var a = this,
            b = this.loadOptions();
        b = a.shuffleOptions(b);
        var c = '<div class="modal fade large cancel-subscription-popin" tabindex="-1" role="dialog" >   <div class="modal-dialog">       <div class="modal-content">           <div class="modal-header">' + a.getHeaderHtml() + '</div>           <div class="modal-body">' + a.getBodyHtml(b) + "</div>       </div>   </div></div>",
            d = $(c);
        a.modal = d.modal(),
        a.customizeRadioInput(),
        a.buttonsClickHandler(),
        a.optionsClickHandler(),
        a.otherOptionClickHandler()
    },
    getBodyHtml: function(a) {
        for (var b = "", c = 0; c < a.length; c++)
            b += '<div class="radio"><label><input type="radio" name="reason" id="option-' + c + '"value="' + a[c].value + '">' + a[c].translation + "</label></div>";
        var d = "<p>" + getTxt("tell_us_why_cancel") + '</p><div class="options container">' + b + '<div class="radio"><label><input type="radio" name="reason" id="option-other" value="other">' + getTxt("other_reason") + ':</label></div><textarea class="form-control option-other-text" style="display: none" maxlength="500"></textarea><a class="btn btn-default" id="cancel_subscription" disabled>' + getTxt("cancel_subscription") + '</a><a class="btn btn-success" id="keep_subscription">' + getTxt("keep_subscription") + "</a></div>";
        return d
    },
    getHeaderHtml: function() {
        var a = "<h1>" + getTxt("we_miss_you_already") + "</h1><span>" + getTxt("access_to_premium_options") + "</span>";
        return a
    },
    buttonsClickHandler: function() {
        var a = this;
        a.modal.find("a").on("click", function(b) {
            if ("cancel_subscription" === b.target.id) {
                var c = a.checkCancelSubscriptionReason();
                c && (a.cancelSubscription(c), a.modal.modal("hide"))
            } else
                a.modal.modal("hide")
        })
    },
    optionsClickHandler: function() {
        var a = this;
        a.modal.find("input[type=radio]").on("click", function(b) {
            "option-other" === b.target.id
                ? a.modal.find("textarea.option-other-text").removeClass("has-error").slideDown("fast", function() {
                    $(this).focus().css("overflow", "auto")
                })
                : a.modal.find("textarea.option-other-text").slideUp("fast");
            var c = a.modal.find("#cancel_subscription");
            c.attr("disabled", !1)
        })
    },
    otherOptionClickHandler: function() {
        this.modal.find("textarea.option-other-text").on("click", function() {
            $(this).removeClass("has-error")
        })
    },
    checkCancelSubscriptionReason: function() {
        var a = this,
            b = a.modal.find("span.checked input[type=radio]");
        if ("option-other" !== b[0].id)
            return b.val();
        var c = a.modal.find("textarea.option-other-text");
        return $.trim(c.val()).length < 1
            ? (c.addClass("has-error"), !1)
            : a.modal.find("textarea.option-other-text").val()
    },
    shuffleOptions: function(a) {
        for (var b = a.length - 1; b > 0; b--) {
            var c = Math.floor(Math.random() * (b + 1)),
                d = a[b];
            a[b] = a[c],
            a[c] = d
        }
        return a
    },
    customizeRadioInput: function() {
        this.modal.find("input[type=radio]").customInput().parent().css("float", "none")
    },
    loadOptions: function() {
        for (var a = [
            {
                value: "I don’t need it anymore",
                translation: "no_need_anymore"
            }, {
                value: "It’s too expensive",
                translation: "too_expensive"
            }, {
                value: "It’s not what I expected",
                translation: "not_what_expected"
            }, {
                value: "I’m not using the product enough",
                translation: "not_using_the_product"
            }, {
                value: "It’s too complicated",
                translation: "too_complicated"
            }
        ], b = 0; b < a.length; b++)
            a[b].translation = getTxt(a[b].translation);
        return a
    }
};
var LoggedUser = function(a) {
    this.setUserData(a),
    this.premium && (this._reloadInterval = 15),
    this._setReloadTimeout()
};
LoggedUser.prototype = {
    setUserData: function(a) {
        for (var b in a)
            a.hasOwnProperty(b) && (this[b] = a[b])
    },
    setNewTimeout: function(a) {
        this._reloadInterval = a,
        this.reload()
    },
    reload: function() {
        var a = this;
        this._rt && clearTimeout(this._rt),
        a._setReloadTimeout(),
        $.ajax({
            data: {
                page: "get-user-info"
            },
            success: function(b) {
                20 === b.code
                    ? (window.userData = b.res.data, a.setUserData(userData), b.res.wl_data && (window.WL_DATA = b.res.wl_data))
                    : 500 === b.code && a.setUserData({
                        sessionExpired: !0
                    })
            }
        })
    },
    _reloadInterval: 10,
    _rt: null,
    _setReloadTimeout: function() {
        this._rt = setTimeout(function() {
            this.reload()
        }.bind(this), 1e3 * this._reloadInterval)
    }
};
var loggedUser;
$(function() {
    loggedUser = new LoggedUser(userData)
});
var ignoreNextRouter = !1,
    getLoader = function(a) {
        var b = '<div class="loader-hover custom-banners-loader">    <div class="loader-overlay"></div>    <svg preserveAspectRatio="none" version="1.1" width="28px" height="28px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" fill="#fff" viewBox="0 0 51 51" style="">        <defs>            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">                <stop offset="0%"></stop>                <stop offset="100%"></stop>            </linearGradient>        </defs>        <path d="M25.5,4C37.4,4,47,13.6,47,25.5S37.4,47,25.5,47S4,37.4,4,25.5S13.6,4,25.5,4 M25.5,0C11.4,0,0,11.4,0,25.5C0,39.6,11.4,51,25.5,51C39.6,51,51,39.6,51,25.5C51,11.4,39.6,0,25.5,0L25.5,0z" fill="url(#grad1)"></path>        <path class="actionMask" fill="transparent" fill-rule="evenodd" clip-rule="evenodd" d="M25.5,0C39.6,0,51,11.4,51,25.5S39.6,51,25.5,51S0,39.6,0,25.5S11.4,0,25.5,0z"></path>    </svg></div>';
        return $(b).addClass("loader" + (a
            ? " " + a
            : ""))
    },
    getTxt = function(a) {
        return "object" == typeof langTextsJs && "undefined" != typeof langTextsJs[a] && langTextsJs[a]
            ? langTextsJs[a]
            : ""
    },
    getTxtDecoded = function(a) {
        return "object" == typeof langTextsJs && "undefined" != typeof langTextsJs[a] && langTextsJs[a]
            ? $("<div/>").html(langTextsJs[a]).text()
            : ""
    };
$(document).ready(function() {
    var a;
    setInterval(function() {
        ga("b.send", "event", "KeepAlive", "KeepAlive ", "", 0, {
            nonInteraction: !0
        })
    }, 3e5),
    a = $(window),
    a.bind("orientationchange", function() {
        var a = $("meta[name=viewport]");
        screen.width >= 768
            ? a.prop("content", "width=device-width, initial-scale=1")
            : a.prop("content", "width=768")
    })
});
var SidebarNav = function() {
    this.checkWidth()
};
SidebarNav.prototype = {
    init: function() {
        this.headerEventTrackingLogged(),
        this.addConfirmBeforeUnload(),
        this.container = $(".app-sidebar-nav");
        var a = this,
            b = $("body"); 
        router.parseNavLinks(this.container),
        this.lis = this.container.find(".height-helper").children("ul").children("li"),
        this.navLinks = this.container.find("a.nav-link"),
        this.menuItems = this.container.find("a.menu-item"),
        this._isSmallWidth = this.isSmallWidth(),
        this.isSmallWidth() && this.container.addClass("small-width"),
        isTouchDevice || this.lis.on("hover", function(c) {
            var d = b.hasClass("small-sidebar"),
                e = $(this).hasClass("account");
            (d || e) && ($(window).triggerHandler("click.navmenu"), a.handleLiClick(this, !1, c, !1))
        }),
        this.lis.on("click", function(b) {
            a.handleLiClick(this, !1, b, !0)
        }),
        a.navLinks.on("click", function(b) {
            a.deselectLinks(),
            $(this).addClass("selected"),
            b.preventDefault()
        }),
        $(window).bind("resize.sidebarNav", function() {
            a.onWindowResize()
        }),
        this.checkScroll(),
        router.onChangeRoute(function() {
            a.checkCurrentUrl()
        }, !0),
        window.localStorage && localStorage.getItem("bsUseOldMyBanners") && this.container.find("a.my-banners-link").attr("href", langPre + "/my-banners/?re=menu"),
        this.checkCurrentUrl(),
        this.initLanguageSelect(),
        this.initCollapse()
    },
    headerEventTrackingLogged: function() {
        var a = $(".app-sidebar-nav");
        a.find("*").on("click", function() {
            ($(this).hasClass("will-expand") && !$(this).hasClass("selected") && !$(this).hasClass("account") || "1" == $(this).attr("data-gatrack")) && ga("b.send", "event", "Menu - logged in", "Click", $(this).attr("data-gatrack-name"))
        })
    },
    deselectLinks: function() {
        this.navLinks.removeClass("selected"),
        this.menuItems.removeClass("selected")
    },
    checkCurrentUrl: function() {
        var a = this,
            b = function(a) {
                return a.replace(/^.*\/\/[^\/]+/, "")
            },
            c = b(location.href),
            d = function(c) {
                if (!c)
                    return null;
                var d = null;
                return a.navLinks.each(function() {
                    var a = b($(this).prop("href"));
                    if (0 === a.indexOf(c))
                        return d = $(this),
                        !1
                }),
                d
            },
            e = [c];
        c.indexOf("#") >= 0 && e.push(c.substr(0, c.indexOf("#"))),
        c.indexOf("?") >= 0 && e.push(c.substr(0, c.indexOf("?")));
        for (var f, g = 0; g < e.length && !(f = d(e[g])); g++)
        ;
        if (f && !f.hasClass("selected") && !f.hasClass("create-rotator-link")) {
            var h = f.closest("li");
            this.navLinks.removeClass("selected"),
            f.addClass("selected"),
            this.handleLiClick(h, !0)
        }
    },
    openLI: function(a) {
        var b = this;
        this.lis && this.lis.each(function() {
            if ($(this).data("for") == a)
                return b.handleLiClick($(this), !0),
                !1
        })
    },
    handleLiClick: function(a, b, c, d) {
        var e = this,
            f = $(window),
            a = $(a),
            g = a.hasClass("account");
        if (a.hasClass("selected") || a.hasClass("not-selectable")) {
            var h = $("body"),
                i = h.hasClass("small-sidebar");
            return void((!d && a.hasClass("single") || isTouchDevice && i) && a.removeClass("selected"))
        }
        if (e.isSmallWidth() || !g
            ? this.lis.removeClass("selected")
            : e.lis.each(function() {
                $(this).is(".selected.single") && $(this).removeClass("selected")
            }), b && (g || this.isSmallWidth()) || a.addClass("selected"), (this.isSmallWidth() || g) && a.hasClass("will-expand") && !b) {
            var j = a.find(".sidebar-nav-expanded");
            j.data("prev", j.prev()),
            j.addClass("right-side"),
            $("body").append(j);
            var k = function() {
                e.positionMenu(j, a)
            };
            k();
            var l = function() {
                    f.unbind("scroll resize", k),
                    e.container.unbind("scroll", k),
                    f.unbind("click.navmenu", l),
                    j.removeClass("right-side"),
                    j.data("prev").after(j),
                    a.removeClass("selected"),
                    j.find(".language-holder.expanded").removeClass("expanded"),
                    a.unbind("mouseleave", m),
                    j.unbind("mouseleave", m)
                },
                m = function() {
                    var b = !0;
                    j.bind("mouseenter", function() {
                        b = !1
                    }),
                    a.bind("mouseenter", function() {
                        b = !1
                    }),
                    setTimeout(function() {
                        b && l()
                    }, 1)
                };
            f.bind("scroll resize", k),
            e.container.bind("scroll", k),
            setTimeout(function() {
                d && f.bind("click.navmenu", l)
            }, 1),
            d || (a.bind("mouseleave", m), j.bind("mouseleave", m))
        }
        e.checkScroll()
    },
    positionMenu: function(a, b) {
        var c = b.offset(),
            d = b.width();
        a.css({
            top: c.top - $(window).scrollTop() + "px",
            left: c.left + d - $(window).scrollLeft() + "px"
        }),
        a.find(">.hide-border").height(b.height() - 1)
    },
    onWindowResize: function() {
        this.checkWidth();
        var a = this.isSmallWidth();
        this._isSmallWidth != a && ($(window).triggerHandler("click"), a
            ? this.container.addClass("small-width")
            : this.container.removeClass("small-width")),
        this.checkScroll(),
        this._isSmallWidth = a
    },
    checkScroll: function() {
        var a = this.container.find(".height-helper").height();
        a + 43 > $(window).height() - $(".logo").height()
            ? this.container.addClass("with-scroll")
            : this.container.removeClass("with-scroll"),
        this.container.addClass("js-loaded")
    },
    isSmallWidth: function() {
        return this.container.width() < 100
    },
    initLanguageSelect: function() {
        var a = this.container.find(".languages-link"),
            b = a.closest(".language-holder"),
            c = b.find(".language-expanded"),
            d = function(a) {
                var b = location.pathname.split("/");
                b.splice(0, 1),
                b[0].length <= 4 && "faq" != b[0] && b.splice(0, 1);
                var c = "/" + b.join("/") + location.search + location.hash,
                    d = $(this).data("lang");
                "en" != d.lang && (c = "/" + d.dc + c),
                $.userApi.cookie("lang", d.lang, {
                    expires: 365,
                    path: "/"
                }),
                $.userApi.cookie("country", d.dc, {
                    expires: 365,
                    path: "/"
                }),
                a.preventDefault(),
                location.href = c
            };
        if ("object" == typeof LANGUAGES) {
            var e,
                f,
                g,
                h;
            for (f = 0; e = LANGUAGES[f]; f++)
                e.lang != CURRENT_LANGUAGE && (g = 1 & !parseInt(e.flags), h = $('<a href="#" class="menu-item">' + e.langName + (g
                    ? " (" + htmlChars(e.langNamePartially) + ")"
                    : "") + "</a>"), h.data("lang", e), h.on("click", d), c.append(h))
            }
        a.on("click", function(a) {
            a.preventDefault(),
            a.stopPropagation()
        });
        var i = function() {
            c.hide()
        };
        b.hover(function() {
            c.show()
        }, function() {
            i()
        }),
        isTouchDevice && (b.on("touchend", function(a) {
            a.stopPropagation()
        }), $("body").on("touchend", function(a) {
            i()
        }))
    },
    reload: function() {
        $.ajax({
            data: {
                page: "reload-sidebar"
            },
            success: function(a) {
                20 == a.code && (this.container.html(a.res.content), this.init())
            }.bind(this)
        })
    },
    getCollapseWidth: function() {
        return router.isEditorPage()
            ? 1400
            : 1024
    },
    _firstChecked: !1,
    checkWidth: function() {
        var a = "undefined" != typeof sessionStorage && "undefined" != typeof sessionStorage.sidebarNavCollapse;
        if (!a || !this._firstChecked) {
            var b = $(window),
                c = $("body");
            if (c.length)
                this._firstChecked = !0,
                a
                    ? this.collapse(JSON.parse(sessionStorage.sidebarNavCollapse))
                    : b.width() <= this.getCollapseWidth()
                        ? this.collapse(!0)
                        : this.collapse(!1);
            else {
                var d = this;
                setTimeout(function() {
                    d.checkWidth()
                }, 30)
            }
        }
    },
    collapse: function(a, b) {
        var c,
            d = $("body"),
            e = this,
            f = 250;
        if (a)
            if (b)
                d.addClass("no-sidebar"),
                c = this.container,
                setTimeout(function() {
                    d.removeClass("no-sidebar").addClass("small-sidebar"),
                    c && c.find(".will-expand").removeClass("selected"),
                    e.checkScroll(),
                    $(window).trigger("resize")
                }, f),
                ga("b.send", "event", "Menu - logged in", "Click", "Collapse");
            else {
                var e = this;
                $(function() {
                    c = e.container,
                    d.addClass("small-sidebar"),
                    c && c.find(".will-expand").removeClass("selected")
                })
            } else
                b
                    ? (d.addClass("no-sidebar"), setTimeout(function() {
                        d.removeClass("small-sidebar no-sidebar"),
                        $(".nav-link.selected, .create-rotator-link.selected").closest(".will-expand:not(.account)").addClass("selected"),
                        e.checkScroll(),
                        $(window).trigger("resize");
                    }, f), ga("b.send", "event", "Menu - logged in", "Click", "Expand"))
                    : (d.removeClass("small-sidebar"), $(".nav-link.selected, .create-rotator-link.selected").closest(".will-expand:not(.account)").addClass("selected"));
        if ($(window).trigger("sidebarCollapse"), b)
            try {
                sessionStorage.sidebarNavCollapse = a
            } catch (g) {}
        },
    addConfirmBeforeUnload: function() {
        var a = this,
            b = !0;
        window.addEventListener("beforeunload", function(c) {
            if (a.isInEditor() && b) {
                b = !1;
                var d = getTxt("leave_app_page_confirm");
                return c.returnValue = d,
                setTimeout(function() {
                    b = !0
                }, 150),
                d
            }
        })
    },
    initCollapse: function() {
        this.container.find(".col-ex").on("click", function() {
            this.collapse(!$("body").hasClass("small-sidebar"), !0)
        }.bind(this))
    },
    isInEditor: function() {
        return $("#editorContainer").length && !$("#bannerCreatorApp").length || $("#flashContentContainer").length && $("#flashContentContainer").is(":visible") || $("#rotator-edit").length > 0
    }
};
var s = new SidebarNav,
    sidebarNav = {
        openLI: function(a) {
            this._openLi = a
        }
    };
sidebarNav.init = function() {
    s.init(),
    this._openLi && this.openLI(this._openLi)
},
sidebarNav.openLI = function(a) {
    s.openLI(a)
},
sidebarNav.deselectLinks = function() {
    s.deselectLinks()
},
sidebarNav.reload = function() {
    s.reload()
},
sidebarNav.checkWidth = function() {
    s.checkWidth()
},
sidebarNav.isSmallWidth = function() {
    return s.isSmallWidth()
},
sidebarNav.isInEditor = function() {
    return s.isInEditor()
};
