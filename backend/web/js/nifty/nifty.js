! function(n) {
    "use strict";
    window.nifty = {
        container: n("#container"),
        contentContainer: n("#content-container"),
        navbar: n("#navbar"),
        mainNav: n("#mainnav-container"),
        aside: n("#aside-container"),
        footer: n("#footer"),
        scrollTop: n("#scroll-top"),
        window: n(window),
        body: n("body"),
        bodyHtml: n("body, html"),
        document: n(document),
        screenSize: "",
        isMobile: function() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
        }(),
        randomInt: function(n, t) {
            return Math.floor(Math.random() * (t - n + 1) + n)
        },
        transition: function() {
            var n = document.body || document.documentElement,
                t = n.style,
                e = void 0 !== t.transition || void 0 !== t.WebkitTransition;
            return e
        }()
    }, nifty.window.on("load", function() {
        var t = n(".add-tooltip");
        t.length && t.tooltip();
        var e = n(".add-popover");
        e.length && e.popover();
        var i = n(".nano");
        i.length && i.nanoScroller({
            preventPageScrolling: !0
        }), n("#navbar-container .navbar-top-links").on("shown.bs.dropdown", ".dropdown", function() {
            n(this).find(".nano").nanoScroller({
                preventPageScrolling: !0
            })
        }), nifty.body.addClass("nifty-ready")
    })
}(jQuery),

! function(n) {
    "use strict";
    var t = null,
        e = function(n) {
            {
                var t = n.find(".mega-dropdown-toggle");
                n.find(".mega-dropdown-menu")
            }
            t.on("click", function(t) {
                t.preventDefault(), n.toggleClass("open")
            })
        }, i = {
            toggle: function() {
                return this.toggleClass("open"), null
            },
            show: function() {
                return this.addClass("open"), null
            },
            hide: function() {
                return this.removeClass("open"), null
            }
        };
    n.fn.niftyMega = function(t) {
        var a = !1;
        return this.each(function() {
            i[t] ? a = i[t].apply(n(this).find("input"), Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t || e(n(this))
        }), a
    }, nifty.window.on("load", function() {
        t = n(".mega-dropdown"), t.length && t.niftyMega(), n("html").on("click", function(e) {
            t.length && (n(e.target).closest(".mega-dropdown").length || t.removeClass("open"))
        })
    })
}(jQuery), ! function(n) {
    "use strict";
    nifty.window.on("load", function() {
        var t = n('[data-dismiss="panel"]');
        t.length && t.one("click", function(t) {
            t.preventDefault();
            var e = n(this).parents(".panel");
            e.addClass("remove").on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(n) {
                "opacity" == n.originalEvent.propertyName && e.remove()
            })
        })
    })
}(jQuery), ! function() {
    "use strict";
    nifty.window.one("load", function() {
        if (nifty.scrollTop.length && !nifty.isMobile) {
            var n = !0,
                t = 250;
            nifty.window.scroll(function() {
                nifty.window.scrollTop() > t && !n ? (nifty.navbar.addClass("shadow"), nifty.scrollTop.addClass("in"), n = !0) : nifty.window.scrollTop() < t && n && (nifty.navbar.removeClass("shadow"), nifty.scrollTop.removeClass("in"), n = !1)
            }), nifty.scrollTop.on("click", function(n) {
                n.preventDefault(), nifty.bodyHtml.animate({
                    scrollTop: 0
                }, 500)
            })
        }
    })
}(jQuery), ! function(n) {
    "use strict";
    var t = {
        displayIcon: !0,
        iconColor: "text-dark",
        iconClass: "fa fa-refresh fa-spin fa-2x",
        title: "",
        desc: ""
    }, e = function() {
        return (65536 * (1 + Math.random()) | 0).toString(16).substring(1)
    }, i = {
        show: function(t) {
            var i = n(t.attr("data-target")),
                a = "nifty-overlay-" + e() + e() + "-" + e(),
                o = n('<div id="' + a + '" class="panel-overlay"></div>');
            return t.prop("disabled", !0).data("niftyOverlay", a), i.addClass("panel-overlay-wrap"), o.appendTo(i).html(t.data("overlayTemplate")), null
        },
        hide: function(t) {
            var e = n(t.attr("data-target")),
                i = n("#" + t.data("niftyOverlay"));
            return i.length && (t.prop("disabled", !1), e.removeClass("panel-overlay-wrap"), i.hide().remove()), null
        }
    }, a = function(e, i) {
        if (e.data("overlayTemplate")) return null;
        var a = n.extend({}, t, i),
            o = a.displayIcon ? '<span class="panel-overlay-icon ' + a.iconColor + '"><i class="' + a.iconClass + '"></i></span>' : "";
        return e.data("overlayTemplate", '<div class="panel-overlay-content pad-all unselectable">' + o + '<h4 class="panel-overlay-title">' + a.title + "</h4><p>" + a.desc + "</p></div>"), null
    };
    n.fn.niftyOverlay = function(t) {
        return i[t] ? i[t](this) : "object" != typeof t && t ? null : this.each(function() {
            a(n(this), t)
        })
    }
}(jQuery), ! function(n) {
    "use strict";
    var t, e, i = {}, a = !1;
    n.niftyNoty = function(o) {
        {
            var s, l = {
                    type: "primary",
                    icon: "",
                    title: "",
                    message: "",
                    closeBtn: !0,
                    container: "page",
                    floating: {
                        position: "top-right",
                        animationIn: "jellyIn",
                        animationOut: "fadeOut"
                    },
                    html: null,
                    focus: !0,
                    timer: 0
                }, r = n.extend({}, l, o),
                c = n('<div class="alert-wrap"></div>'),
                f = function() {
                    var n = "";
                    return o && o.icon && (n = '<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon"><i class="' + r.icon + '"></i></span></div>'), n
                }, d = function() {
                    var n = r.closeBtn ? '<button class="close" type="button"><i class="fa fa-times-circle"></i></button>' : "",
                        t = '<div class="alert alert-' + r.type + '" role="alert">' + n + '<div class="media">';
                    return r.html ? t + r.html + "</div></div>" : t + f() + '<div class="media-body"><h4 class="alert-title">' + r.title + '</h4><p class="alert-message">' + r.message + "</p></div></div>"
                }(),
                u = function() {
                    return "floating" === r.container && r.floating.animationOut && (c.removeClass(r.floating.animationIn).addClass(r.floating.animationOut), nifty.transition || c.remove()), c.removeClass("in").on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(n) {
                        "max-height" == n.originalEvent.propertyName && c.remove()
                    }), clearInterval(s), null
                }, v = function(n) {
                    nifty.bodyHtml.animate({
                        scrollTop: n
                    }, 300, function() {
                        c.addClass("in")
                    })
                };
            ! function() {
                if ("page" === r.container) t || (t = n('<div id="page-alert"></div>'), nifty.contentContainer.prepend(t)), e = t, r.focus && v(0);
                else if ("floating" === r.container) i[r.floating.position] || (i[r.floating.position] = n('<div id="floating-' + r.floating.position + '" class="floating-container"></div>'), nifty.container.append(i[r.floating.position])), e = i[r.floating.position], r.floating.animationIn && c.addClass("in animated " + r.floating.animationIn), r.focus = !1;
                else {
                    var o = n(r.container),
                        s = o.children(".panel-alert"),
                        l = o.children(".panel-heading");
                    if (!o.length) return a = !1, !1;
                    s.length ? e = s : (e = n('<div class="panel-alert"></div>'), l.length ? l.after(e) : o.prepend(e)), r.focus && v(o.offset().top - 30)
                }
                return a = !0, !1
            }()
        }
        if (a && (e.append(c.html(d)), c.find('[data-dismiss="noty"]').one("click", u), r.closeBtn && c.find(".close").one("click", u), r.timer > 0 && (s = setInterval(u, r.timer)), !r.focus)) var m = setInterval(function() {
            c.addClass("in"), clearInterval(m)
        }, 200)
    }
}(jQuery), ! function(n) {
    "use strict";
    var t, e = function(t) {
        if (!t.data("nifty-check")) {
            t.data("nifty-check", !0), t.text().trim().length ? t.addClass("form-text") : t.removeClass("form-text");
            var e = t.find("input[type='radio']")[0] || t.find("input[type='checkbox']")[0],
                i = e.name,
                a = function() {
                    return "radio" == e.type && i ? n(".form-radio").not(t).find("input").filter("input[name=" + i + "]").parent() : !1
                }(),
                o = function() {
                    "radio" == e.type && a.length && a.each(function() {
                        var t = n(this);
                        t.hasClass("active") && t.trigger("nifty.ch.unchecked"), t.removeClass("active")
                    }), e.checked ? t.addClass("active").trigger("nifty.ch.checked") : t.removeClass("active").trigger("nifty.ch.unchecked")
                };
            e.checked ? t.addClass("active") : t.removeClass("active"), n(e).on("change", o)
        }
    }, i = {
        isChecked: function() {
            return this[0].checked
        },
        toggle: function() {
            return this[0].checked = !this[0].checked, this.trigger("change"), null
        },
        toggleOn: function() {
            return this[0].checked || (this[0].checked = !0, this.trigger("change")), null
        },
        toggleOff: function() {
            return this[0].checked && "checkbox" == this[0].type && (this[0].checked = !1, this.trigger("change")), null
        }
    };
    n.fn.niftyCheck = function(t) {
        var a = !1;
        return this.each(function() {
            i[t] ? a = i[t].apply(n(this).find("input"), Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t || e(n(this))
        }), a
    }, nifty.document.ready(function() {
        t = n(".form-checkbox, .form-radio"), t.length && t.niftyCheck()
    }), nifty.document.on("change", ".btn-file :file", function() {
        var t = n(this),
            e = t.get(0).files ? t.get(0).files.length : 1,
            i = t.val().replace(/\\/g, "/").replace(/.*\//, ""),
            a = function() {
                try {
                    return t[0].files[0].size
                } catch (n) {
                    return "Nan"
                }
            }(),
            o = function() {
                if ("Nan" == a) return "Unknown";
                var n = Math.floor(Math.log(a) / Math.log(1024));
                return 1 * (a / Math.pow(1024, n)).toFixed(2) + " " + ["B", "kB", "MB", "GB", "TB"][n]
            }();
        t.trigger("fileselect", [e, i, o])
    })
}(jQuery), ! function(n) {
    nifty.window.on("load", function() {
        var t = n("#mainnav-shortcut");
        t.length && t.find("li").each(function() {
            var t = n(this);
            t.popover({
                animation: !1,
                trigger: "hover focus",
                placement: "bottom",
                container: "#mainnav-container",
                template: '<div class="popover mainnav-shortcut"><div class="arrow"></div><div class="popover-content"></div>'
            })
        })
    })
}(jQuery), ! function(n, t) {
    var e = {};
    e.eventName = "resizeEnd", e.delay = 250, e.poll = function() {
        var i = n(this),
            a = i.data(e.eventName);
        a.timeoutId && t.clearTimeout(a.timeoutId), a.timeoutId = t.setTimeout(function() {
            i.trigger(e.eventName)
        }, e.delay)
    }, n.event.special[e.eventName] = {
        setup: function() {
            var t = n(this);
            t.data(e.eventName, {}), t.on("resize", e.poll)
        },
        teardown: function() {
            var i = n(this),
                a = i.data(e.eventName);
            a.timeoutId && t.clearTimeout(a.timeoutId), i.removeData(e.eventName), i.off("resize", e.poll)
        }
    }, n.fn[e.eventName] = function(n, t) {
        return arguments.length > 0 ? this.on(e.eventName, null, n, t) : this.trigger(e.eventName)
    }
}(jQuery, this), ! function(n) {
    "use strict";
    var t = n('#mainnav-menu > li > a, #mainnav-menu-wrap .mainnav-widget a[data-toggle="menu-widget"]'),
        e = n("#mainnav").height(),
        i = null,
        a = !1,
        o = !1,
        s = null,
        l = function() {
            var e;
            t.each(function() {
                var i = n(this),
                    a = i.children(".menu-title"),
                    o = i.siblings(".collapse"),
                    s = n(i.attr("data-target")),
                    l = s.length ? s.parent() : null,
                    r = null,
                    c = null,
                    f = null,
                    d = null,
                    u = (i.outerHeight() - i.height() / 4, function() {
                        return s.length && i.on("click", function(n) {
                            n.preventDefault()
                        }), o.length ? (i.on("click", function(n) {
                            n.preventDefault()
                        }).parent("li").removeClass("active"), !0) : !1
                    }()),
                    v = null,
                    m = function(n) {
                        clearInterval(v), v = setInterval(function() {
                            n.nanoScroller({
                                preventPageScrolling: !0,
                                alwaysVisible: !0
                            }), clearInterval(v)
                        }, 700)
                    };
                n(document).click(function(t) {
                    n(t.target).closest("#mainnav-container").length || i.removeClass("hover").popover("hide")
                }), n("#mainnav-menu-wrap > .nano").on("update", function() {
                    i.removeClass("hover").popover("hide")
                }), i.popover({
                    animation: !1,
                    trigger: "manual",
                    container: "#mainnav",
                    viewport: i,
                    html: !0,
                    title: function() {
                        return u ? a.html() : null
                    },
                    content: function() {
                        var t;
                        return u ? (t = n('<div class="sub-menu"></div>'), o.addClass("pop-in").wrap('<div class="nano-content"></div>').parent().appendTo(t)) : s.length ? (t = n('<div class="sidebar-widget-popover"></div>'), s.wrap('<div class="nano-content"></div>').parent().appendTo(t)) : t = '<span class="single-content">' + a.html() + "</span>", t
                    },
                    template: '<div class="popover menu-popover"><h4 class="popover-title"></h4><div class="popover-content"></div></div>'
                }).on("show.bs.popover", function() {
                    if (!r) {
                        if (r = i.data("bs.popover").tip(), c = r.find(".popover-title"), f = r.children(".popover-content"), !u && 0 == s.length) return;
                        d = f.children(".sub-menu")
                    }!u && 0 == s.length
                }).on("shown.bs.popover", function() {
                    if (!u && 0 == s.length) {
                        var t = 0 - .5 * i.outerHeight();
                        return void f.css({
                            "margin-top": t + "px",
                            width: "auto"
                        })
                    }
                    var e = parseInt(r.css("top")),
                        a = i.outerHeight(),
                        o = function() {
                            return nifty.container.hasClass("mainnav-fixed") ? n(window).outerHeight() - e - a : n(document).height() - e - a
                        }(),
                        l = f.find(".nano-content").children().css("height", "auto").outerHeight();
                    f.find(".nano-content").children().css("height", ""), e > o ? (c.length && !c.is(":visible") && (a = Math.round(0 - .5 * a)), e -= 5, f.css({
                        top: "",
                        bottom: a + "px",
                        height: e
                    }).children().addClass("nano").css({
                        width: "100%"
                    }).nanoScroller({
                        preventPageScrolling: !0
                    }), m(f.find(".nano"))) : (!nifty.container.hasClass("navbar-fixed") && nifty.mainNav.hasClass("affix-top") && (o -= 50), l > o ? ((nifty.container.hasClass("navbar-fixed") || nifty.mainNav.hasClass("affix-top")) && (o -= a + 5), o -= 5, f.css({
                        top: a + "px",
                        bottom: "",
                        height: o
                    }).children().addClass("nano").css({
                        width: "100%"
                    }).nanoScroller({
                        preventPageScrolling: !0
                    }), m(f.find(".nano"))) : (c.length && !c.is(":visible") && (a = Math.round(0 - .5 * a)), f.css({
                        top: a + "px",
                        bottom: "",
                        height: "auto"
                    }))), c.length && c.css("height", i.outerHeight()), f.on("click", function() {
                        f.find(".nano-pane").hide(), m(f.find(".nano"))
                    })
                }).on("hidden.bs.popover", function() {
                    i.removeClass("hover"), u ? o.removeAttr("style").appendTo(i.parent()) : s.length && s.appendTo(l), clearInterval(e)
                }).on("click", function() {
                    nifty.container.hasClass("mainnav-sm") && (t.popover("hide"), i.addClass("hover").popover("show"))
                }).hover(function() {
                    t.popover("hide"), i.addClass("hover").popover("show")
                }, function() {
                    clearInterval(e), e = setInterval(function() {
                        r && (r.one("mouseleave", function() {
                            i.removeClass("hover").popover("hide")
                        }), r.is(":hover") || i.removeClass("hover").popover("hide")), clearInterval(e)
                    }, 500)
                })
            }), o = !0
        }, r = function() {
            var e = n("#mainnav-menu").find(".collapse");
            e.length && e.each(function() {
                var t = n(this);
                t.hasClass("in") ? t.parent("li").addClass("active") : t.parent("li").removeClass("active")
            }), null != i && i.length && i.nanoScroller({
                stop: !0
            }), t.popover("destroy").unbind("mouseenter mouseleave"), o = !1
        }, c = function() {
            var t, e = nifty.container.width();
            t = 740 >= e ? "xs" : e > 740 && 992 > e ? "sm" : e >= 992 && 1200 >= e ? "md" : "lg", s != t && (s = t, nifty.screenSize = t, "sm" == nifty.screenSize && nifty.container.hasClass("mainnav-lg") && n.niftyNav("collapse"))
        }, f = function() {
            return nifty.mainNav.niftyAffix("update"), r(), c(), ("collapse" == a || nifty.container.hasClass("mainnav-sm")) && (nifty.container.removeClass("mainnav-in mainnav-out mainnav-lg"), l()), e = n("#mainnav").height(), a = !1, null
        }, d = {
            revealToggle: function() {
                nifty.container.hasClass("reveal") || nifty.container.addClass("reveal"), nifty.container.toggleClass("mainnav-in mainnav-out").removeClass("mainnav-lg mainnav-sm"), o && r()
            },
            revealIn: function() {
                nifty.container.hasClass("reveal") || nifty.container.addClass("reveal"), nifty.container.addClass("mainnav-in").removeClass("mainnav-out mainnav-lg mainnav-sm"), o && r()
            },
            revealOut: function() {
                nifty.container.hasClass("reveal") || nifty.container.addClass("reveal"), nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"), o && r()
            },
            slideToggle: function() {
                nifty.container.hasClass("slide") || nifty.container.addClass("slide"), nifty.container.toggleClass("mainnav-in mainnav-out").removeClass("mainnav-lg mainnav-sm"), o && r()
            },
            slideIn: function() {
                nifty.container.hasClass("slide") || nifty.container.addClass("slide"), nifty.container.addClass("mainnav-in").removeClass("mainnav-out mainnav-lg mainnav-sm"), o && r()
            },
            slideOut: function() {
                nifty.container.hasClass("slide") || nifty.container.addClass("slide"), nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"), o && r()
            },
            pushToggle: function() {
                nifty.container.toggleClass("mainnav-in mainnav-out").removeClass("mainnav-lg mainnav-sm"), nifty.container.hasClass("mainnav-in mainnav-out") && nifty.container.removeClass("mainnav-in"), o && r()
            },
            pushIn: function() {
                nifty.container.addClass("mainnav-in").removeClass("mainnav-out mainnav-lg mainnav-sm"), o && r()
            },
            pushOut: function() {
                nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"), o && r()
            },
            colExpToggle: function() {
                return nifty.container.hasClass("mainnav-lg mainnav-sm") && nifty.container.removeClass("mainnav-lg"), nifty.container.toggleClass("mainnav-lg mainnav-sm").removeClass("mainnav-in mainnav-out"), nifty.window.trigger("resize")
            },
            collapse: function() {
                return nifty.container.addClass("mainnav-sm").removeClass("mainnav-lg mainnav-in mainnav-out"), a = "collapse", nifty.window.trigger("resize")
            },
            expand: function() {
                return nifty.container.removeClass("mainnav-sm mainnav-in mainnav-out").addClass("mainnav-lg"), nifty.window.trigger("resize")
            },
            togglePosition: function() {
                nifty.container.toggleClass("mainnav-fixed"), nifty.mainNav.niftyAffix("update")
            },
            fixedPosition: function() {
                nifty.container.addClass("mainnav-fixed"), nifty.mainNav.niftyAffix("update")
            },
            staticPosition: function() {
                nifty.container.removeClass("mainnav-fixed"), nifty.mainNav.niftyAffix("update")
            },
            update: f,
            forceUpdate: c,
            getScreenSize: function() {
                return s
            }
        };
    n.niftyNav = function(n, t) {
        if (d[n]) {
            ("colExpToggle" == n || "expand" == n || "collapse" == n) && ("xs" == nifty.screenSize && "collapse" == n ? n = "pushOut" : "xs" != nifty.screenSize && "sm" != nifty.screenSize || "colExpToggle" != n && "expand" != n || !nifty.container.hasClass("mainnav-sm") || (n = "pushIn"));
            var e = d[n].apply(this, Array.prototype.slice.call(arguments, 1));
            if (t) return t();
            if (e) return e
        }
        return null
    }, n.fn.isOnScreen = function() {
        var n = {
            top: nifty.window.scrollTop(),
            left: nifty.window.scrollLeft()
        };
        n.right = n.left + nifty.window.width(), n.bottom = n.top + nifty.window.height();
        var t = this.offset();
        return t.right = t.left + this.outerWidth(), t.bottom = t.top + this.outerHeight(), !(n.right < t.left || n.left > t.right || n.bottom < t.bottom || n.top > t.top)
    }, nifty.window.on("resizeEnd", f).trigger("resize"), nifty.window.on("load", function() {
        var t = n(".mainnav-toggle");
        t.length && t.on("click", function(e) {
            e.preventDefault(), n.niftyNav(t.hasClass("push") ? "pushToggle" : t.hasClass("slide") ? "slideToggle" : t.hasClass("reveal") ? "revealToggle" : "colExpToggle")
        });
        var e = n("#mainnav-menu");
        e.length && (n("#mainnav-menu").metisMenu({
            toggle: !0
        }), i = nifty.mainNav.find(".nano"), i.length && i.nanoScroller({
            preventPageScrolling: !0
        }))
    })
}(jQuery), ! function(n) {
    "use strict";
    var t = {
        toggleHideShow: function() {
            nifty.container.toggleClass("aside-in"), nifty.window.trigger("resize"), nifty.container.hasClass("aside-in") && e()
        },
        show: function() {
            nifty.container.addClass("aside-in"), nifty.window.trigger("resize"), e()
        },
        hide: function() {
            nifty.container.removeClass("aside-in"), nifty.window.trigger("resize")
        },
        toggleAlign: function() {
            nifty.container.toggleClass("aside-left"), nifty.aside.niftyAffix("update")
        },
        alignLeft: function() {
            nifty.container.addClass("aside-left"), nifty.aside.niftyAffix("update")
        },
        alignRight: function() {
            nifty.container.removeClass("aside-left"), nifty.aside.niftyAffix("update")
        },
        togglePosition: function() {
            nifty.container.toggleClass("aside-fixed"), nifty.aside.niftyAffix("update")
        },
        fixedPosition: function() {
            nifty.container.addClass("aside-fixed"), nifty.aside.niftyAffix("update")
        },
        staticPosition: function() {
            nifty.container.removeClass("aside-fixed"), nifty.aside.niftyAffix("update")
        },
        toggleTheme: function() {
            nifty.container.toggleClass("aside-bright")
        },
        brightTheme: function() {
            nifty.container.addClass("aside-bright")
        },
        darkTheme: function() {
            nifty.container.removeClass("aside-bright")
        }
    }, e = function() {
        nifty.container.hasClass("mainnav-in") && "xs" != nifty.screenSize && ("sm" == nifty.screenSize ? n.niftyNav("collapse") : nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"))
    };
    n.niftyAside = function(n, e) {
        return t[n] && (t[n].apply(this, Array.prototype.slice.call(arguments, 1)), e) ? e() : null
    }, nifty.window.on("load", function() {
        if (nifty.aside.length) {
            nifty.aside.find(".nano").nanoScroller({
                preventPageScrolling: !0,
                alwaysVisible: !1
            });
            var t = n(".aside-toggle");
            t.length && t.on("click", function() {
                n.niftyAside("toggleHideShow")
            })
        }
    })
}(jQuery), ! function(n) {
    "use strict";
    var t = {
        dynamicMode: !0,
        selectedOn: null,
        onChange: null
    }, e = function(e, i) {
        var a = n.extend({}, t, i),
            o = e.find(".lang-selected"),
            s = o.parent(".lang-selector").siblings(".dropdown-menu"),
            l = s.find("a"),
            r = l.filter(".active").find(".lang-id").text(),
            c = l.filter(".active").find(".lang-name").text(),
            f = function(n) {
                l.removeClass("active"), n.addClass("active"), o.html(n.html()), r = n.find(".lang-id").text(), c = n.find(".lang-name").text(), e.trigger("onChange", [{
                    id: r,
                    name: c
                }]), "function" == typeof a.onChange && a.onChange.call(this, {
                    id: r,
                    name: c
                })
            };
        l.on("click", function(t) {
            a.dynamicMode && (t.preventDefault(), t.stopPropagation()), e.dropdown("toggle"), f(n(this))
        }), a.selectedOn && f(n(a.selectedOn))
    }, i = {
        getSelectedID: function() {
            return n(this).find(".lang-id").text()
        },
        getSelectedName: function() {
            return n(this).find(".lang-name").text()
        },
        getSelected: function() {
            var t = n(this);
            return {
                id: t.find(".lang-id").text(),
                name: t.find(".lang-name").text()
            }
        },
        setDisable: function() {
            return n(this).addClass("disabled"), null
        },
        setEnable: function() {
            return n(this).removeClass("disabled"), null
        }
    };
    n.fn.niftyLanguage = function(t) {
        var a = !1;
        return this.each(function() {
            i[t] ? a = i[t].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t || e(n(this), t)
        }), a
    }
}(jQuery), ! function(n) {
    "use strict";
    n.fn.niftyAffix = function(t) {
        return this.each(function() {
            var e, i = n(this);
            "object" != typeof t && t ? "update" == t && (e = i.data("nifty.af.class")) : (e = t.className, i.data("nifty.af.class", t.className)), nifty.container.hasClass(e) && !nifty.container.hasClass("navbar-fixed") ? i.affix({
                offset: {
                    top: n("#navbar").outerHeight()
                }
            }) : (!nifty.container.hasClass(e) || nifty.container.hasClass("navbar-fixed")) && (nifty.window.off(i.attr("id") + ".affix"), i.removeClass("affix affix-top affix-bottom").removeData("bs.affix"))
        })
    }, nifty.window.on("load", function() {
        nifty.mainNav.length && nifty.mainNav.niftyAffix({
            className: "mainnav-fixed"
        }), nifty.aside.length && nifty.aside.niftyAffix({
            className: "aside-fixed"
        })
    })
}(jQuery);

$(document).ready(function () {
    $("#toggle-aside").on("click", function (e) {
        e.preventDefault();
        nifty.container.hasClass("aside-in") ? ($.niftyAside("hide")) : ($.niftyAside("show"))
    });
    $.niftyAside("fixedPosition");
});
