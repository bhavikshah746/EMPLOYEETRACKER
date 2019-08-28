/*
 * jQuery throttle / debounce - v1.1 - 3/7/2010
 * http://benalman.com/projects/jquery-throttle-debounce-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function(b,c){var $=b.jQuery||b.Cowboy||(b.Cowboy={}),a;$.throttle=a=function(e,f,j,i){var h,d=0;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};$.debounce=function(d,e,f){return f===c?a(d,e,false):a(d,f,e!==false)}})(this);
/*!
 * Bootstrap v3.3.5 (http://getbootstrap.com)
 * Copyright 2011-2016 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

/*!
 * Generated using the Bootstrap Customizer (http://getbootstrap.com/customize/?id=865cc71ccfa02d31557b)
 * Config saved to config.json and https://gist.github.com/865cc71ccfa02d31557b
 */
if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(t){"use strict";var e=t.fn.jquery.split(" ")[0].split(".");if(e[0]<2&&e[1]<9||1==e[0]&&9==e[1]&&e[2]<1||e[0]>2)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher, but lower than version 3")}(jQuery),+function(t){"use strict";function e(e){return this.each(function(){var i=t(this),n=i.data("bs.alert");n||i.data("bs.alert",n=new o(this)),"string"==typeof e&&n[e].call(i)})}var i='[data-dismiss="alert"]',o=function(e){t(e).on("click",i,this.close)};o.VERSION="3.3.6",o.TRANSITION_DURATION=150,o.prototype.close=function(e){function i(){a.detach().trigger("closed.bs.alert").remove()}var n=t(this),s=n.attr("data-target");s||(s=n.attr("href"),s=s&&s.replace(/.*(?=#[^\s]*$)/,""));var a=t(s);e&&e.preventDefault(),a.length||(a=n.closest(".alert")),a.trigger(e=t.Event("close.bs.alert")),e.isDefaultPrevented()||(a.removeClass("in"),t.support.transition&&a.hasClass("fade")?a.one("bsTransitionEnd",i).emulateTransitionEnd(o.TRANSITION_DURATION):i())};var n=t.fn.alert;t.fn.alert=e,t.fn.alert.Constructor=o,t.fn.alert.noConflict=function(){return t.fn.alert=n,this},t(document).on("click.bs.alert.data-api",i,o.prototype.close)}(jQuery),+function(t){"use strict";function e(e){return this.each(function(){var o=t(this),n=o.data("bs.button"),s="object"==typeof e&&e;n||o.data("bs.button",n=new i(this,s)),"toggle"==e?n.toggle():e&&n.setState(e)})}var i=function(e,o){this.$element=t(e),this.options=t.extend({},i.DEFAULTS,o),this.isLoading=!1};i.VERSION="3.3.6",i.DEFAULTS={loadingText:"loading..."},i.prototype.setState=function(e){var i="disabled",o=this.$element,n=o.is("input")?"val":"html",s=o.data();e+="Text",null==s.resetText&&o.data("resetText",o[n]()),setTimeout(t.proxy(function(){o[n](null==s[e]?this.options[e]:s[e]),"loadingText"==e?(this.isLoading=!0,o.addClass(i).attr(i,i)):this.isLoading&&(this.isLoading=!1,o.removeClass(i).removeAttr(i))},this),0)},i.prototype.toggle=function(){var t=!0,e=this.$element.closest('[data-toggle="buttons"]');if(e.length){var i=this.$element.find("input");"radio"==i.prop("type")?(i.prop("checked")&&(t=!1),e.find(".active").removeClass("active"),this.$element.addClass("active")):"checkbox"==i.prop("type")&&(i.prop("checked")!==this.$element.hasClass("active")&&(t=!1),this.$element.toggleClass("active")),i.prop("checked",this.$element.hasClass("active")),t&&i.trigger("change")}else this.$element.attr("aria-pressed",!this.$element.hasClass("active")),this.$element.toggleClass("active")};var o=t.fn.button;t.fn.button=e,t.fn.button.Constructor=i,t.fn.button.noConflict=function(){return t.fn.button=o,this},t(document).on("click.bs.button.data-api",'[data-toggle^="button"]',function(i){var o=t(i.target);o.hasClass("btn")||(o=o.closest(".btn")),e.call(o,"toggle"),t(i.target).is('input[type="radio"]')||t(i.target).is('input[type="checkbox"]')||i.preventDefault()}).on("focus.bs.button.data-api blur.bs.button.data-api",'[data-toggle^="button"]',function(e){t(e.target).closest(".btn").toggleClass("focus",/^focus(in)?$/.test(e.type))})}(jQuery),+function(t){"use strict";function e(e){return this.each(function(){var o=t(this),n=o.data("bs.carousel"),s=t.extend({},i.DEFAULTS,o.data(),"object"==typeof e&&e),a="string"==typeof e?e:s.slide;n||o.data("bs.carousel",n=new i(this,s)),"number"==typeof e?n.to(e):a?n[a]():s.interval&&n.pause().cycle()})}var i=function(e,i){this.$element=t(e),this.$indicators=this.$element.find(".carousel-indicators"),this.options=i,this.paused=null,this.sliding=null,this.interval=null,this.$active=null,this.$items=null,this.options.keyboard&&this.$element.on("keydown.bs.carousel",t.proxy(this.keydown,this)),"hover"==this.options.pause&&!("ontouchstart"in document.documentElement)&&this.$element.on("mouseenter.bs.carousel",t.proxy(this.pause,this)).on("mouseleave.bs.carousel",t.proxy(this.cycle,this))};i.VERSION="3.3.6",i.TRANSITION_DURATION=600,i.DEFAULTS={interval:5e3,pause:"hover",wrap:!0,keyboard:!0},i.prototype.keydown=function(t){if(!/input|textarea/i.test(t.target.tagName)){switch(t.which){case 37:this.prev();break;case 39:this.next();break;default:return}t.preventDefault()}},i.prototype.cycle=function(e){return e||(this.paused=!1),this.interval&&clearInterval(this.interval),this.options.interval&&!this.paused&&(this.interval=setInterval(t.proxy(this.next,this),this.options.interval)),this},i.prototype.getItemIndex=function(t){return this.$items=t.parent().children(".item"),this.$items.index(t||this.$active)},i.prototype.getItemForDirection=function(t,e){var i=this.getItemIndex(e),o="prev"==t&&0===i||"next"==t&&i==this.$items.length-1;if(o&&!this.options.wrap)return e;var n="prev"==t?-1:1,s=(i+n)%this.$items.length;return this.$items.eq(s)},i.prototype.to=function(t){var e=this,i=this.getItemIndex(this.$active=this.$element.find(".item.active"));return t>this.$items.length-1||0>t?void 0:this.sliding?this.$element.one("slid.bs.carousel",function(){e.to(t)}):i==t?this.pause().cycle():this.slide(t>i?"next":"prev",this.$items.eq(t))},i.prototype.pause=function(e){return e||(this.paused=!0),this.$element.find(".next, .prev").length&&t.support.transition&&(this.$element.trigger(t.support.transition.end),this.cycle(!0)),this.interval=clearInterval(this.interval),this},i.prototype.next=function(){return this.sliding?void 0:this.slide("next")},i.prototype.prev=function(){return this.sliding?void 0:this.slide("prev")},i.prototype.slide=function(e,o){var n=this.$element.find(".item.active"),s=o||this.getItemForDirection(e,n),a=this.interval,r="next"==e?"left":"right",l=this;if(s.hasClass("active"))return this.sliding=!1;var h=s[0],d=t.Event("slide.bs.carousel",{relatedTarget:h,direction:r});if(this.$element.trigger(d),!d.isDefaultPrevented()){if(this.sliding=!0,a&&this.pause(),this.$indicators.length){this.$indicators.find(".active").removeClass("active");var p=t(this.$indicators.children()[this.getItemIndex(s)]);p&&p.addClass("active")}var c=t.Event("slid.bs.carousel",{relatedTarget:h,direction:r});return t.support.transition&&this.$element.hasClass("slide")?(s.addClass(e),s[0].offsetWidth,n.addClass(r),s.addClass(r),n.one("bsTransitionEnd",function(){s.removeClass([e,r].join(" ")).addClass("active"),n.removeClass(["active",r].join(" ")),l.sliding=!1,setTimeout(function(){l.$element.trigger(c)},0)}).emulateTransitionEnd(i.TRANSITION_DURATION)):(n.removeClass("active"),s.addClass("active"),this.sliding=!1,this.$element.trigger(c)),a&&this.cycle(),this}};var o=t.fn.carousel;t.fn.carousel=e,t.fn.carousel.Constructor=i,t.fn.carousel.noConflict=function(){return t.fn.carousel=o,this};var n=function(i){var o,n=t(this),s=t(n.attr("data-target")||(o=n.attr("href"))&&o.replace(/.*(?=#[^\s]+$)/,""));if(s.hasClass("carousel")){var a=t.extend({},s.data(),n.data()),r=n.attr("data-slide-to");r&&(a.interval=!1),e.call(s,a),r&&s.data("bs.carousel").to(r),i.preventDefault()}};t(document).on("click.bs.carousel.data-api","[data-slide]",n).on("click.bs.carousel.data-api","[data-slide-to]",n),t(window).on("load",function(){t('[data-ride="carousel"]').each(function(){var i=t(this);e.call(i,i.data())})})}(jQuery),+function(t){"use strict";function e(e){var i=e.attr("data-target");i||(i=e.attr("href"),i=i&&/#[A-Za-z]/.test(i)&&i.replace(/.*(?=#[^\s]*$)/,""));var o=i&&t(i);return o&&o.length?o:e.parent()}function i(i){i&&3===i.which||(t(n).remove(),t(s).each(function(){var o=t(this),n=e(o),s={relatedTarget:this};n.hasClass("open")&&(i&&"click"==i.type&&/input|textarea/i.test(i.target.tagName)&&t.contains(n[0],i.target)||(n.trigger(i=t.Event("hide.bs.dropdown",s)),i.isDefaultPrevented()||(o.attr("aria-expanded","false"),n.removeClass("open").trigger(t.Event("hidden.bs.dropdown",s)))))}))}function o(e){return this.each(function(){var i=t(this),o=i.data("bs.dropdown");o||i.data("bs.dropdown",o=new a(this)),"string"==typeof e&&o[e].call(i)})}var n=".dropdown-backdrop",s='[data-toggle="dropdown"]',a=function(e){t(e).on("click.bs.dropdown",this.toggle)};a.VERSION="3.3.6",a.prototype.toggle=function(o){var n=t(this);if(!n.is(".disabled, :disabled")){var s=e(n),a=s.hasClass("open");if(i(),!a){"ontouchstart"in document.documentElement&&!s.closest(".navbar-nav").length&&t(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(t(this)).on("click",i);var r={relatedTarget:this};if(s.trigger(o=t.Event("show.bs.dropdown",r)),o.isDefaultPrevented())return;n.trigger("focus").attr("aria-expanded","true"),s.toggleClass("open").trigger(t.Event("shown.bs.dropdown",r))}return!1}},a.prototype.keydown=function(i){if(/(38|40|27|32)/.test(i.which)&&!/input|textarea/i.test(i.target.tagName)){var o=t(this);if(i.preventDefault(),i.stopPropagation(),!o.is(".disabled, :disabled")){var n=e(o),a=n.hasClass("open");if(!a&&27!=i.which||a&&27==i.which)return 27==i.which&&n.find(s).trigger("focus"),o.trigger("click");var r=" li:not(.disabled):visible a",l=n.find(".dropdown-menu"+r);if(l.length){var h=l.index(i.target);38==i.which&&h>0&&h--,40==i.which&&h<l.length-1&&h++,~h||(h=0),l.eq(h).trigger("focus")}}}};var r=t.fn.dropdown;t.fn.dropdown=o,t.fn.dropdown.Constructor=a,t.fn.dropdown.noConflict=function(){return t.fn.dropdown=r,this},t(document).on("click.bs.dropdown.data-api",i).on("click.bs.dropdown.data-api",".dropdown form",function(t){t.stopPropagation()}).on("click.bs.dropdown.data-api",s,a.prototype.toggle).on("keydown.bs.dropdown.data-api",s,a.prototype.keydown).on("keydown.bs.dropdown.data-api",".dropdown-menu",a.prototype.keydown)}(jQuery),+function(t){"use strict";function e(e,o){return this.each(function(){var n=t(this),s=n.data("bs.modal"),a=t.extend({},i.DEFAULTS,n.data(),"object"==typeof e&&e);s||n.data("bs.modal",s=new i(this,a)),"string"==typeof e?s[e](o):a.show&&s.show(o)})}var i=function(e,i){this.options=i,this.$body=t(document.body),this.$element=t(e),this.$dialog=this.$element.find(".modal-dialog"),this.$backdrop=null,this.isShown=null,this.originalBodyPad=null,this.scrollbarWidth=0,this.ignoreBackdropClick=!1,this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,t.proxy(function(){this.$element.trigger("loaded.bs.modal")},this))};i.VERSION="3.3.6",i.TRANSITION_DURATION=300,i.BACKDROP_TRANSITION_DURATION=150,i.DEFAULTS={backdrop:!0,keyboard:!0,show:!0},i.prototype.toggle=function(t){return this.isShown?this.hide():this.show(t)},i.prototype.show=function(e){var o=this,n=t.Event("show.bs.modal",{relatedTarget:e});this.$element.trigger(n),this.isShown||n.isDefaultPrevented()||(this.isShown=!0,this.checkScrollbar(),this.setScrollbar(),this.$body.addClass("modal-open"),this.escape(),this.resize(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',t.proxy(this.hide,this)),this.$dialog.on("mousedown.dismiss.bs.modal",function(){o.$element.one("mouseup.dismiss.bs.modal",function(e){t(e.target).is(o.$element)&&(o.ignoreBackdropClick=!0)})}),this.backdrop(function(){var n=t.support.transition&&o.$element.hasClass("fade");o.$element.parent().length||o.$element.appendTo(o.$body),o.$element.show().scrollTop(0),o.adjustDialog(),n&&o.$element[0].offsetWidth,o.$element.addClass("in"),o.enforceFocus();var s=t.Event("shown.bs.modal",{relatedTarget:e});n?o.$dialog.one("bsTransitionEnd",function(){o.$element.trigger("focus").trigger(s)}).emulateTransitionEnd(i.TRANSITION_DURATION):o.$element.trigger("focus").trigger(s)}))},i.prototype.hide=function(e){e&&e.preventDefault(),e=t.Event("hide.bs.modal"),this.$element.trigger(e),this.isShown&&!e.isDefaultPrevented()&&(this.isShown=!1,this.escape(),this.resize(),t(document).off("focusin.bs.modal"),this.$element.removeClass("in").off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"),this.$dialog.off("mousedown.dismiss.bs.modal"),t.support.transition&&this.$element.hasClass("fade")?this.$element.one("bsTransitionEnd",t.proxy(this.hideModal,this)).emulateTransitionEnd(i.TRANSITION_DURATION):this.hideModal())},i.prototype.enforceFocus=function(){t(document).off("focusin.bs.modal").on("focusin.bs.modal",t.proxy(function(t){this.$element[0]===t.target||this.$element.has(t.target).length||this.$element.trigger("focus")},this))},i.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keydown.dismiss.bs.modal",t.proxy(function(t){27==t.which&&this.hide()},this)):this.isShown||this.$element.off("keydown.dismiss.bs.modal")},i.prototype.resize=function(){this.isShown?t(window).on("resize.bs.modal",t.proxy(this.handleUpdate,this)):t(window).off("resize.bs.modal")},i.prototype.hideModal=function(){var t=this;this.$element.hide(),this.backdrop(function(){t.$body.removeClass("modal-open"),t.resetAdjustments(),t.resetScrollbar(),t.$element.trigger("hidden.bs.modal")})},i.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},i.prototype.backdrop=function(e){var o=this,n=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var s=t.support.transition&&n;if(this.$backdrop=t(document.createElement("div")).addClass("modal-backdrop "+n).appendTo(this.$body),this.$element.on("click.dismiss.bs.modal",t.proxy(function(t){return this.ignoreBackdropClick?void(this.ignoreBackdropClick=!1):void(t.target===t.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus():this.hide()))},this)),s&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!e)return;s?this.$backdrop.one("bsTransitionEnd",e).emulateTransitionEnd(i.BACKDROP_TRANSITION_DURATION):e()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass("in");var a=function(){o.removeBackdrop(),e&&e()};t.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one("bsTransitionEnd",a).emulateTransitionEnd(i.BACKDROP_TRANSITION_DURATION):a()}else e&&e()},i.prototype.handleUpdate=function(){this.adjustDialog()},i.prototype.adjustDialog=function(){var t=this.$element[0].scrollHeight>document.documentElement.clientHeight;this.$element.css({paddingLeft:!this.bodyIsOverflowing&&t?this.scrollbarWidth:"",paddingRight:this.bodyIsOverflowing&&!t?this.scrollbarWidth:""})},i.prototype.resetAdjustments=function(){this.$element.css({paddingLeft:"",paddingRight:""})},i.prototype.checkScrollbar=function(){var t=window.innerWidth;if(!t){var e=document.documentElement.getBoundingClientRect();t=e.right-Math.abs(e.left)}this.bodyIsOverflowing=document.body.clientWidth<t,this.scrollbarWidth=this.measureScrollbar()},i.prototype.setScrollbar=function(){var t=parseInt(this.$body.css("padding-right")||0,10);this.originalBodyPad=document.body.style.paddingRight||"",this.bodyIsOverflowing&&this.$body.css("padding-right",t+this.scrollbarWidth)},i.prototype.resetScrollbar=function(){this.$body.css("padding-right",this.originalBodyPad)},i.prototype.measureScrollbar=function(){var t=document.createElement("div");t.className="modal-scrollbar-measure",this.$body.append(t);var e=t.offsetWidth-t.clientWidth;return this.$body[0].removeChild(t),e};var o=t.fn.modal;t.fn.modal=e,t.fn.modal.Constructor=i,t.fn.modal.noConflict=function(){return t.fn.modal=o,this},t(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(i){var o=t(this),n=o.attr("href"),s=t(o.attr("data-target")||n&&n.replace(/.*(?=#[^\s]+$)/,"")),a=s.data("bs.modal")?"toggle":t.extend({remote:!/#/.test(n)&&n},s.data(),o.data());o.is("a")&&i.preventDefault(),s.one("show.bs.modal",function(t){t.isDefaultPrevented()||s.one("hidden.bs.modal",function(){o.is(":visible")&&o.trigger("focus")})}),e.call(s,a,this)})}(jQuery),+function(t){"use strict";function e(e){return this.each(function(){var o=t(this),n=o.data("bs.tooltip"),s="object"==typeof e&&e;(n||!/destroy|hide/.test(e))&&(n||o.data("bs.tooltip",n=new i(this,s)),"string"==typeof e&&n[e]())})}var i=function(t,e){this.type=null,this.options=null,this.enabled=null,this.timeout=null,this.hoverState=null,this.$element=null,this.inState=null,this.init("tooltip",t,e)};i.VERSION="3.3.6",i.TRANSITION_DURATION=150,i.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1,viewport:{selector:"body",padding:0}},i.prototype.init=function(e,i,o){if(this.enabled=!0,this.type=e,this.$element=t(i),this.options=this.getOptions(o),this.$viewport=this.options.viewport&&t(t.isFunction(this.options.viewport)?this.options.viewport.call(this,this.$element):this.options.viewport.selector||this.options.viewport),this.inState={click:!1,hover:!1,focus:!1},this.$element[0]instanceof document.constructor&&!this.options.selector)throw new Error("`selector` option must be specified when initializing "+this.type+" on the window.document object!");for(var n=this.options.trigger.split(" "),s=n.length;s--;){var a=n[s];if("click"==a)this.$element.on("click."+this.type,this.options.selector,t.proxy(this.toggle,this));else if("manual"!=a){var r="hover"==a?"mouseenter":"focusin",l="hover"==a?"mouseleave":"focusout";this.$element.on(r+"."+this.type,this.options.selector,t.proxy(this.enter,this)),this.$element.on(l+"."+this.type,this.options.selector,t.proxy(this.leave,this))}}this.options.selector?this._options=t.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},i.prototype.getDefaults=function(){return i.DEFAULTS},i.prototype.getOptions=function(e){return e=t.extend({},this.getDefaults(),this.$element.data(),e),e.delay&&"number"==typeof e.delay&&(e.delay={show:e.delay,hide:e.delay}),e},i.prototype.getDelegateOptions=function(){var e={},i=this.getDefaults();return this._options&&t.each(this._options,function(t,o){i[t]!=o&&(e[t]=o)}),e},i.prototype.enter=function(e){var i=e instanceof this.constructor?e:t(e.currentTarget).data("bs."+this.type);return i||(i=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,i)),e instanceof t.Event&&(i.inState["focusin"==e.type?"focus":"hover"]=!0),i.tip().hasClass("in")||"in"==i.hoverState?void(i.hoverState="in"):(clearTimeout(i.timeout),i.hoverState="in",i.options.delay&&i.options.delay.show?void(i.timeout=setTimeout(function(){"in"==i.hoverState&&i.show()},i.options.delay.show)):i.show())},i.prototype.isInStateTrue=function(){for(var t in this.inState)if(this.inState[t])return!0;return!1},i.prototype.leave=function(e){var i=e instanceof this.constructor?e:t(e.currentTarget).data("bs."+this.type);return i||(i=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,i)),e instanceof t.Event&&(i.inState["focusout"==e.type?"focus":"hover"]=!1),i.isInStateTrue()?void 0:(clearTimeout(i.timeout),i.hoverState="out",i.options.delay&&i.options.delay.hide?void(i.timeout=setTimeout(function(){"out"==i.hoverState&&i.hide()},i.options.delay.hide)):i.hide())},i.prototype.show=function(){var e=t.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){this.$element.trigger(e);var o=t.contains(this.$element[0].ownerDocument.documentElement,this.$element[0]);if(e.isDefaultPrevented()||!o)return;var n=this,s=this.tip(),a=this.getUID(this.type);this.setContent(),s.attr("id",a),this.$element.attr("aria-describedby",a),this.options.animation&&s.addClass("fade");var r="function"==typeof this.options.placement?this.options.placement.call(this,s[0],this.$element[0]):this.options.placement,l=/\s?auto?\s?/i,h=l.test(r);h&&(r=r.replace(l,"")||"top"),s.detach().css({top:0,left:0,display:"block"}).addClass(r).data("bs."+this.type,this),this.options.container?s.appendTo(this.options.container):s.insertAfter(this.$element),this.$element.trigger("inserted.bs."+this.type);var d=this.getPosition(),p=s[0].offsetWidth,c=s[0].offsetHeight;if(h){var f=r,u=this.getPosition(this.$viewport);r="bottom"==r&&d.bottom+c>u.bottom?"top":"top"==r&&d.top-c<u.top?"bottom":"right"==r&&d.right+p>u.width?"left":"left"==r&&d.left-p<u.left?"right":r,s.removeClass(f).addClass(r)}var g=this.getCalculatedOffset(r,d,p,c);this.applyPlacement(g,r);var v=function(){var t=n.hoverState;n.$element.trigger("shown.bs."+n.type),n.hoverState=null,"out"==t&&n.leave(n)};t.support.transition&&this.$tip.hasClass("fade")?s.one("bsTransitionEnd",v).emulateTransitionEnd(i.TRANSITION_DURATION):v()}},i.prototype.applyPlacement=function(e,i){var o=this.tip(),n=o[0].offsetWidth,s=o[0].offsetHeight,a=parseInt(o.css("margin-top"),10),r=parseInt(o.css("margin-left"),10);isNaN(a)&&(a=0),isNaN(r)&&(r=0),e.top+=a,e.left+=r,t.offset.setOffset(o[0],t.extend({using:function(t){o.css({top:Math.round(t.top),left:Math.round(t.left)})}},e),0),o.addClass("in");var l=o[0].offsetWidth,h=o[0].offsetHeight;"top"==i&&h!=s&&(e.top=e.top+s-h);var d=this.getViewportAdjustedDelta(i,e,l,h);d.left?e.left+=d.left:e.top+=d.top;var p=/top|bottom/.test(i),c=p?2*d.left-n+l:2*d.top-s+h,f=p?"offsetWidth":"offsetHeight";o.offset(e),this.replaceArrow(c,o[0][f],p)},i.prototype.replaceArrow=function(t,e,i){this.arrow().css(i?"left":"top",50*(1-t/e)+"%").css(i?"top":"left","")},i.prototype.setContent=function(){var t=this.tip(),e=this.getTitle();t.find(".tooltip-inner")[this.options.html?"html":"text"](e),t.removeClass("fade in top bottom left right")},i.prototype.hide=function(e){function o(){"in"!=n.hoverState&&s.detach(),n.$element.removeAttr("aria-describedby").trigger("hidden.bs."+n.type),e&&e()}var n=this,s=t(this.$tip),a=t.Event("hide.bs."+this.type);return this.$element.trigger(a),a.isDefaultPrevented()?void 0:(s.removeClass("in"),t.support.transition&&s.hasClass("fade")?s.one("bsTransitionEnd",o).emulateTransitionEnd(i.TRANSITION_DURATION):o(),this.hoverState=null,this)},i.prototype.fixTitle=function(){var t=this.$element;(t.attr("title")||"string"!=typeof t.attr("data-original-title"))&&t.attr("data-original-title",t.attr("title")||"").attr("title","")},i.prototype.hasContent=function(){return this.getTitle()},i.prototype.getPosition=function(e){e=e||this.$element;var i=e[0],o="BODY"==i.tagName,n=i.getBoundingClientRect();null==n.width&&(n=t.extend({},n,{width:n.right-n.left,height:n.bottom-n.top}));var s=o?{top:0,left:0}:e.offset(),a={scroll:o?document.documentElement.scrollTop||document.body.scrollTop:e.scrollTop()},r=o?{width:t(window).width(),height:t(window).height()}:null;return t.extend({},n,a,r,s)},i.prototype.getCalculatedOffset=function(t,e,i,o){return"bottom"==t?{top:e.top+e.height,left:e.left+e.width/2-i/2}:"top"==t?{top:e.top-o,left:e.left+e.width/2-i/2}:"left"==t?{top:e.top+e.height/2-o/2,left:e.left-i}:{top:e.top+e.height/2-o/2,left:e.left+e.width}},i.prototype.getViewportAdjustedDelta=function(t,e,i,o){var n={top:0,left:0};if(!this.$viewport)return n;var s=this.options.viewport&&this.options.viewport.padding||0,a=this.getPosition(this.$viewport);if(/right|left/.test(t)){var r=e.top-s-a.scroll,l=e.top+s-a.scroll+o;r<a.top?n.top=a.top-r:l>a.top+a.height&&(n.top=a.top+a.height-l)}else{var h=e.left-s,d=e.left+s+i;h<a.left?n.left=a.left-h:d>a.right&&(n.left=a.left+a.width-d)}return n},i.prototype.getTitle=function(){var t,e=this.$element,i=this.options;return t=e.attr("data-original-title")||("function"==typeof i.title?i.title.call(e[0]):i.title)},i.prototype.getUID=function(t){do t+=~~(1e6*Math.random());while(document.getElementById(t));return t},i.prototype.tip=function(){if(!this.$tip&&(this.$tip=t(this.options.template),1!=this.$tip.length))throw new Error(this.type+" `template` option must consist of exactly 1 top-level element!");return this.$tip},i.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".tooltip-arrow")},i.prototype.enable=function(){this.enabled=!0},i.prototype.disable=function(){this.enabled=!1},i.prototype.toggleEnabled=function(){this.enabled=!this.enabled},i.prototype.toggle=function(e){var i=this;e&&(i=t(e.currentTarget).data("bs."+this.type),i||(i=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,i))),e?(i.inState.click=!i.inState.click,i.isInStateTrue()?i.enter(i):i.leave(i)):i.tip().hasClass("in")?i.leave(i):i.enter(i)},i.prototype.destroy=function(){var t=this;clearTimeout(this.timeout),this.hide(function(){t.$element.off("."+t.type).removeData("bs."+t.type),t.$tip&&t.$tip.detach(),t.$tip=null,t.$arrow=null,t.$viewport=null})};var o=t.fn.tooltip;t.fn.tooltip=e,t.fn.tooltip.Constructor=i,t.fn.tooltip.noConflict=function(){return t.fn.tooltip=o,this}}(jQuery),+function(t){"use strict";function e(e){return this.each(function(){var o=t(this),n=o.data("bs.popover"),s="object"==typeof e&&e;(n||!/destroy|hide/.test(e))&&(n||o.data("bs.popover",n=new i(this,s)),"string"==typeof e&&n[e]())})}var i=function(t,e){this.init("popover",t,e)};if(!t.fn.tooltip)throw new Error("Popover requires tooltip.js");i.VERSION="3.3.6",i.DEFAULTS=t.extend({},t.fn.tooltip.Constructor.DEFAULTS,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}),i.prototype=t.extend({},t.fn.tooltip.Constructor.prototype),i.prototype.constructor=i,i.prototype.getDefaults=function(){return i.DEFAULTS},i.prototype.setContent=function(){var t=this.tip(),e=this.getTitle(),i=this.getContent();t.find(".popover-title")[this.options.html?"html":"text"](e),t.find(".popover-content").children().detach().end()[this.options.html?"string"==typeof i?"html":"append":"text"](i),t.removeClass("fade top bottom left right in"),t.find(".popover-title").html()||t.find(".popover-title").hide()},i.prototype.hasContent=function(){return this.getTitle()||this.getContent()},i.prototype.getContent=function(){var t=this.$element,e=this.options;return t.attr("data-content")||("function"==typeof e.content?e.content.call(t[0]):e.content)},i.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")};var o=t.fn.popover;t.fn.popover=e,t.fn.popover.Constructor=i,t.fn.popover.noConflict=function(){return t.fn.popover=o,this}}(jQuery),+function(t){"use strict";function e(e){return this.each(function(){var o=t(this),n=o.data("bs.tab");n||o.data("bs.tab",n=new i(this)),"string"==typeof e&&n[e]()})}var i=function(e){this.element=t(e)};i.VERSION="3.3.6",i.TRANSITION_DURATION=150,i.prototype.show=function(){var e=this.element,i=e.closest("ul:not(.dropdown-menu)"),o=e.data("target");if(o||(o=e.attr("href"),o=o&&o.replace(/.*(?=#[^\s]*$)/,"")),!e.parent("li").hasClass("active")){var n=i.find(".active:last a"),s=t.Event("hide.bs.tab",{relatedTarget:e[0]}),a=t.Event("show.bs.tab",{relatedTarget:n[0]});if(n.trigger(s),e.trigger(a),!a.isDefaultPrevented()&&!s.isDefaultPrevented()){var r=t(o);this.activate(e.closest("li"),i),this.activate(r,r.parent(),function(){n.trigger({type:"hidden.bs.tab",relatedTarget:e[0]}),e.trigger({type:"shown.bs.tab",relatedTarget:n[0]})})}}},i.prototype.activate=function(e,o,n){function s(){a.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!1),e.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded",!0),r?(e[0].offsetWidth,e.addClass("in")):e.removeClass("fade"),e.parent(".dropdown-menu").length&&e.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!0),n&&n()}var a=o.find("> .active"),r=n&&t.support.transition&&(a.length&&a.hasClass("fade")||!!o.find("> .fade").length);a.length&&r?a.one("bsTransitionEnd",s).emulateTransitionEnd(i.TRANSITION_DURATION):s(),a.removeClass("in")};var o=t.fn.tab;t.fn.tab=e,t.fn.tab.Constructor=i,t.fn.tab.noConflict=function(){return t.fn.tab=o,this};var n=function(i){i.preventDefault(),e.call(t(this),"show")};t(document).on("click.bs.tab.data-api",'[data-toggle="tab"]',n).on("click.bs.tab.data-api",'[data-toggle="pill"]',n)}(jQuery),+function(t){"use strict";function e(e){return this.each(function(){var o=t(this),n=o.data("bs.affix"),s="object"==typeof e&&e;n||o.data("bs.affix",n=new i(this,s)),"string"==typeof e&&n[e]()})}var i=function(e,o){this.options=t.extend({},i.DEFAULTS,o),this.$target=t(this.options.target).on("scroll.bs.affix.data-api",t.proxy(this.checkPosition,this)).on("click.bs.affix.data-api",t.proxy(this.checkPositionWithEventLoop,this)),this.$element=t(e),this.affixed=null,this.unpin=null,this.pinnedOffset=null,this.checkPosition()};i.VERSION="3.3.6",i.RESET="affix affix-top affix-bottom",i.DEFAULTS={offset:0,target:window},i.prototype.getState=function(t,e,i,o){var n=this.$target.scrollTop(),s=this.$element.offset(),a=this.$target.height();if(null!=i&&"top"==this.affixed)return i>n?"top":!1;if("bottom"==this.affixed)return null!=i?n+this.unpin<=s.top?!1:"bottom":t-o>=n+a?!1:"bottom";var r=null==this.affixed,l=r?n:s.top,h=r?a:e;return null!=i&&i>=n?"top":null!=o&&l+h>=t-o?"bottom":!1},i.prototype.getPinnedOffset=function(){if(this.pinnedOffset)return this.pinnedOffset;this.$element.removeClass(i.RESET).addClass("affix");var t=this.$target.scrollTop(),e=this.$element.offset();return this.pinnedOffset=e.top-t},i.prototype.checkPositionWithEventLoop=function(){setTimeout(t.proxy(this.checkPosition,this),1)},i.prototype.checkPosition=function(){if(this.$element.is(":visible")){var e=this.$element.height(),o=this.options.offset,n=o.top,s=o.bottom,a=Math.max(t(document).height(),t(document.body).height());"object"!=typeof o&&(s=n=o),"function"==typeof n&&(n=o.top(this.$element)),"function"==typeof s&&(s=o.bottom(this.$element));var r=this.getState(a,e,n,s);if(this.affixed!=r){null!=this.unpin&&this.$element.css("top","");var l="affix"+(r?"-"+r:""),h=t.Event(l+".bs.affix");if(this.$element.trigger(h),h.isDefaultPrevented())return;this.affixed=r,this.unpin="bottom"==r?this.getPinnedOffset():null,this.$element.removeClass(i.RESET).addClass(l).trigger(l.replace("affix","affixed")+".bs.affix")}"bottom"==r&&this.$element.offset({top:a-e-s})}};var o=t.fn.affix;t.fn.affix=e,t.fn.affix.Constructor=i,t.fn.affix.noConflict=function(){return t.fn.affix=o,this},t(window).on("load",function(){t('[data-spy="affix"]').each(function(){var i=t(this),o=i.data();o.offset=o.offset||{},null!=o.offsetBottom&&(o.offset.bottom=o.offsetBottom),null!=o.offsetTop&&(o.offset.top=o.offsetTop),e.call(i,o)})})}(jQuery),+function(t){"use strict";function e(e){var i,o=e.attr("data-target")||(i=e.attr("href"))&&i.replace(/.*(?=#[^\s]+$)/,"");return t(o)}function i(e){return this.each(function(){var i=t(this),n=i.data("bs.collapse"),s=t.extend({},o.DEFAULTS,i.data(),"object"==typeof e&&e);!n&&s.toggle&&/show|hide/.test(e)&&(s.toggle=!1),n||i.data("bs.collapse",n=new o(this,s)),"string"==typeof e&&n[e]()})}var o=function(e,i){this.$element=t(e),this.options=t.extend({},o.DEFAULTS,i),this.$trigger=t('[data-toggle="collapse"][href="#'+e.id+'"],[data-toggle="collapse"][data-target="#'+e.id+'"]'),this.transitioning=null,this.options.parent?this.$parent=this.getParent():this.addAriaAndCollapsedClass(this.$element,this.$trigger),this.options.toggle&&this.toggle()};o.VERSION="3.3.6",o.TRANSITION_DURATION=350,o.DEFAULTS={toggle:!0},o.prototype.dimension=function(){var t=this.$element.hasClass("width");return t?"width":"height"},o.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var e,n=this.$parent&&this.$parent.children(".panel").children(".in, .collapsing");if(!(n&&n.length&&(e=n.data("bs.collapse"),e&&e.transitioning))){var s=t.Event("show.bs.collapse");if(this.$element.trigger(s),!s.isDefaultPrevented()){n&&n.length&&(i.call(n,"hide"),e||n.data("bs.collapse",null));var a=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[a](0).attr("aria-expanded",!0),this.$trigger.removeClass("collapsed").attr("aria-expanded",!0),this.transitioning=1;var r=function(){this.$element.removeClass("collapsing").addClass("collapse in")[a](""),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!t.support.transition)return r.call(this);var l=t.camelCase(["scroll",a].join("-"));this.$element.one("bsTransitionEnd",t.proxy(r,this)).emulateTransitionEnd(o.TRANSITION_DURATION)[a](this.$element[0][l]);
}}}},o.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var e=t.Event("hide.bs.collapse");if(this.$element.trigger(e),!e.isDefaultPrevented()){var i=this.dimension();this.$element[i](this.$element[i]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded",!1),this.$trigger.addClass("collapsed").attr("aria-expanded",!1),this.transitioning=1;var n=function(){this.transitioning=0,this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")};return t.support.transition?void this.$element[i](0).one("bsTransitionEnd",t.proxy(n,this)).emulateTransitionEnd(o.TRANSITION_DURATION):n.call(this)}}},o.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()},o.prototype.getParent=function(){return t(this.options.parent).find('[data-toggle="collapse"][data-parent="'+this.options.parent+'"]').each(t.proxy(function(i,o){var n=t(o);this.addAriaAndCollapsedClass(e(n),n)},this)).end()},o.prototype.addAriaAndCollapsedClass=function(t,e){var i=t.hasClass("in");t.attr("aria-expanded",i),e.toggleClass("collapsed",!i).attr("aria-expanded",i)};var n=t.fn.collapse;t.fn.collapse=i,t.fn.collapse.Constructor=o,t.fn.collapse.noConflict=function(){return t.fn.collapse=n,this},t(document).on("click.bs.collapse.data-api",'[data-toggle="collapse"]',function(o){var n=t(this);n.attr("data-target")||o.preventDefault();var s=e(n),a=s.data("bs.collapse"),r=a?"toggle":n.data();i.call(s,r)})}(jQuery),+function(t){"use strict";function e(i,o){this.$body=t(document.body),this.$scrollElement=t(t(i).is(document.body)?window:i),this.options=t.extend({},e.DEFAULTS,o),this.selector=(this.options.target||"")+" .nav li > a",this.offsets=[],this.targets=[],this.activeTarget=null,this.scrollHeight=0,this.$scrollElement.on("scroll.bs.scrollspy",t.proxy(this.process,this)),this.refresh(),this.process()}function i(i){return this.each(function(){var o=t(this),n=o.data("bs.scrollspy"),s="object"==typeof i&&i;n||o.data("bs.scrollspy",n=new e(this,s)),"string"==typeof i&&n[i]()})}e.VERSION="3.3.6",e.DEFAULTS={offset:10},e.prototype.getScrollHeight=function(){return this.$scrollElement[0].scrollHeight||Math.max(this.$body[0].scrollHeight,document.documentElement.scrollHeight)},e.prototype.refresh=function(){var e=this,i="offset",o=0;this.offsets=[],this.targets=[],this.scrollHeight=this.getScrollHeight(),t.isWindow(this.$scrollElement[0])||(i="position",o=this.$scrollElement.scrollTop()),this.$body.find(this.selector).map(function(){var e=t(this),n=e.data("target")||e.attr("href"),s=/^#./.test(n)&&t(n);return s&&s.length&&s.is(":visible")&&[[s[i]().top+o,n]]||null}).sort(function(t,e){return t[0]-e[0]}).each(function(){e.offsets.push(this[0]),e.targets.push(this[1])})},e.prototype.process=function(){var t,e=this.$scrollElement.scrollTop()+this.options.offset,i=this.getScrollHeight(),o=this.options.offset+i-this.$scrollElement.height(),n=this.offsets,s=this.targets,a=this.activeTarget;if(this.scrollHeight!=i&&this.refresh(),e>=o)return a!=(t=s[s.length-1])&&this.activate(t);if(a&&e<n[0])return this.activeTarget=null,this.clear();for(t=n.length;t--;)a!=s[t]&&e>=n[t]&&(void 0===n[t+1]||e<n[t+1])&&this.activate(s[t])},e.prototype.activate=function(e){this.activeTarget=e,this.clear();var i=this.selector+'[data-target="'+e+'"],'+this.selector+'[href="'+e+'"]',o=t(i).parents("li").addClass("active");o.parent(".dropdown-menu").length&&(o=o.closest("li.dropdown").addClass("active")),o.trigger("activate.bs.scrollspy")},e.prototype.clear=function(){t(this.selector).parentsUntil(this.options.target,".active").removeClass("active")};var o=t.fn.scrollspy;t.fn.scrollspy=i,t.fn.scrollspy.Constructor=e,t.fn.scrollspy.noConflict=function(){return t.fn.scrollspy=o,this},t(window).on("load.bs.scrollspy.data-api",function(){t('[data-spy="scroll"]').each(function(){var e=t(this);i.call(e,e.data())})})}(jQuery),+function(t){"use strict";function e(){var t=document.createElement("bootstrap"),e={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var i in e)if(void 0!==t.style[i])return{end:e[i]};return!1}t.fn.emulateTransitionEnd=function(e){var i=!1,o=this;t(this).one("bsTransitionEnd",function(){i=!0});var n=function(){i||t(o).trigger(t.support.transition.end)};return setTimeout(n,e),this},t(function(){t.support.transition=e(),t.support.transition&&(t.event.special.bsTransitionEnd={bindType:t.support.transition.end,delegateType:t.support.transition.end,handle:function(e){return t(e.target).is(this)?e.handleObj.handler.apply(this,arguments):void 0}})})}(jQuery);
jQuery.easing._dd_easing=function(d,a,i,s,e){return-s*((a=a/e-1)*a*a*a-1)+i},function(d){d.fn.dateDropper=function(a){return d(this).each(function(){if(d(this).is("input")&&"text"==d(this).attr("type")){var i,s,e,r,t=(new Date).getFullYear(),n=(new Date).getDate(),o=(new Date).getMonth(),l=d(".dd-w").length,u='<div class="dd-w dd-init" id="dd-w-'+l+'"><div class="dd-o"></div><div class="dd-c"><div class="dd-w-c"><div class="dd-b dd-m"><div class="dd-ul"><a class="dd-n dd-n-left"><i class="dd-icon-left" ></i></a><a class="dd-n dd-n-right"><i class="dd-icon-right" ></i></a><ul></ul></div></div><div class="dd-b dd-d"><div class="dd-ul"><a class="dd-n dd-n-left"><i class="dd-icon-left" ></i></a><a class="dd-n dd-n-right"><i class="dd-icon-right" ></i></a><ul></ul></div></div><div class="dd-b dd-y"><div class="dd-ul"><a class="dd-n dd-n-left"><i class="dd-icon-left" ></i></a><a class="dd-n dd-n-right"><i class="dd-icon-right" ></i></a><ul></ul></div></div><div class="dd-s-b dd-s-b-m dd-trans"><div class="dd-s-b-ul"><ul></ul></div></div><div class="dd-s-b dd-s-b-d dd-trans"><div class="dd-s-b-ul"><ul></ul></div></div><div class="dd-s-b dd-s-b-y dd-trans"><div class="dd-s-b-ul"><ul></ul></div></div><div class="dd-s-b dd-s-b-s-y dd-trans"><div class="dd-s-b-ul"><ul></ul></div></div><div class="dd-s-b-s"><i class="dd-icon-close" ></i></div><div class="dd-b dd-sub-y"><div class="dd-ul"><a class="dd-n dd-n-left"><i class="dd-icon-left" ></i></a><a class="dd-n dd-n-right"><i class="dd-icon-right" ></i></a><ul></ul></div></div><div class="dd-s"><a><i class="dd-icon-check" ></i></a></div></div></div></div>';d("body").append(u);var c=d(this),f=d("#dd-w-"+l),b=function(d){return!(d%4||!(d%100)&&d%400)},m=function(d){return 10>d?"0"+d:d},p=d.extend({animate:!0,init_animation:"fadein",format:"m/d/Y",lang:"en",lock:!1,maxYear:t,minYear:1970,yearsRange:10,dropPrimaryColor:"#01CEFF",dropTextColor:"#333333",dropBackgroundColor:"#FFFFFF",dropBorder:"1px solid #08C",dropBorderRadius:8,dropShadow:"0 0 10px 0 rgba(0, 136, 204, 0.45)",dropWidth:124,dropTextWeight:"bold"},a),h=null,v=!1,g=function(d,a){var i=!1;"#"==d[0]&&(d=d.slice(1),i=!0);var s=parseInt(d,16),e=(s>>16)+a;e>255?e=255:0>e&&(e=0);var r=(s>>8&255)+a;r>255?r=255:0>r&&(r=0);var t=(255&s)+a;return t>255?t=255:0>t&&(t=0),(i?"#":"")+(t|r<<8|e<<16).toString(16)};switch(d("<style>#dd-w-"+l+" { font-weight: "+p.dropTextWeight+"; } #dd-w-"+l+" .dd-w-c,#dd-w-"+l+" .dd-ul li,#dd-w-"+l+" .dd-s-b-ul ul { width:"+p.dropWidth+"px; } #dd-w-"+l+" .dd-w-c{color:"+p.dropTextColor+";background:"+p.dropBackgroundColor+";border:"+p.dropBorder+";box-shadow:"+p.dropShadow+";border-radius:"+p.dropBorderRadius+"px}#dd-w-"+l+" .dd-w-c,#dd-w-"+l+" .dd-s-b{background:"+p.dropBackgroundColor+"}#dd-w-"+l+" .dd-sun,#dd-w-"+l+" .dd-s-b-ul li.dd-on{color:"+p.dropPrimaryColor+"}#dd-w-"+l+" .dd-c .dd-s,#dd-w-"+l+" .dd-s-b-s,#dd-w-"+l+" .dd-s-b-sub-y,#dd-w-"+l+" .dd-sub-y{background:"+p.dropPrimaryColor+";color:"+p.dropBackgroundColor+"}#dd-w-"+l+" .dd-c .dd-s a,#dd-w-"+l+" .dd-c .dd-s a:hover{color:"+p.dropBackgroundColor+"}#dd-w-"+l+" .dd-c:after{border-left:"+p.dropBorder+";border-top:"+p.dropBorder+"}#dd-w-"+l+".dd-bottom .dd-c:after{background:"+p.dropBackgroundColor+"}#dd-w-"+l+".dd-top .dd-c:after{background:"+p.dropPrimaryColor+"}#dd-w-"+l+" .dd-n,#dd-w-"+l+" .dd-sun{color:"+p.dropPrimaryColor+"}#dd-w-"+l+" .dd-sub-y .dd-n{color:"+p.dropBackgroundColor+"} #dd-w-"+l+" .dd-c .dd-s:hover,#dd-w-"+l+" .dd-s-b-s:hover { background:"+g(p.dropPrimaryColor,-20)+"; }</style>").appendTo("head"),p.lang){case"ar":var y=["جانفي","فيفري","مارس","أفريل","ماي","جوان","جويلية","أوت","سبتمبر","أكتوبر","نوفمبر","ديسمبر"],k=["الأحد","الإثنين","الثلثاء","الأربعاء","الخميس","الجمعة","السبت"];break;case"it":var y=["Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre"],k=["Domenica","Lunedì","Martedì","Mercoledì","Giovedì","Venerdì","Sabato"];break;case"hu":var y=["január","február","március","április","május","június","július","augusztus","szeptember","október","november","december"],k=["vasárnap","hétfő","kedd","szerda","csütörtök","péntek","szombat"];break;case"gr":var y=["Ιανουάριος","Φεβρουάριος","Μάρτιος","Απρίλιος","Μάιος","Ιούνιος","Ιούλιος","Αύγουστος","Σεπτέμβριος","Οκτώβριος","Νοέμβριος","Δεκέμβριος"],k=["Κυριακή","Δευτέρα","Τρίτη","Τετάρτη","Πέμπτη","Παρασκευή","Σάββατο"];break;case"es":var y=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],k=["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];break;case"da":var y=["januar","februar","marts","april","maj","juni","juli","august","september","oktober","november","december"],k=["søndag","mandag","tirsdag","onsdag","torsdag","fredag","lørdag"];break;case"de":var y=["Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"],k=["Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag"];break;case"nl":var y=["januari","februari","maart","april","mei","juni","juli","augustus","september","oktober","november","december"],k=["zondag","maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag"];break;case"fr":var y=["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],k=["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"];break;case"pl":var y=["styczeń","luty","marzec","kwiecień","maj","czerwiec","lipiec","sierpień","wrzesień","październik","listopad","grudzień"],k=["niedziela","poniedziałek","wtorek","środa","czwartek","piątek","sobota"];break;case"pt":var y=["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],k=["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"];break;case"si":var y=["januar","februar","marec","april","maj","junij","julij","avgust","september","oktober","november","december"],k=["nedelja","ponedeljek","torek","sreda","četrtek","petek","sobota"];break;case"uk":var y=["січень","лютий","березень","квітень","травень","червень","липень","серпень","вересень","жовтень","листопад","грудень"],k=["неділя","понеділок","вівторок","середа","четвер","п'ятниця","субота"];break;case"ru":var y=["январь","февраль","март","апрель","май","июнь","июль","август","сентябрь","октябрь","ноябрь","декабрь"],k=["воскресенье","понедельник","вторник","среда","четверг","пятница","суббота"];break;case"tr":var y=["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"],k=["Pazar","Pazartesi","Sali","Çarşamba","Perşembe","Cuma","Cumartesi"];break;case"ko":var y=["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],k=["일요일","월요일","화요일","수요일","목요일","금요일","토요일"];break;case"fi":var y=["Tammikuu","Helmikuu","Maaliskuu","Huhtikuu","Toukokuu","Kesäkuu","Heinäkuu","Elokuu","Syyskuu","Lokakuu","Marraskuu","Joulukuu"],k=["Sunnuntai","Maanantai","Tiistai","Keskiviikko","Torstai","Perjantai","Lauantai"];break;default:var y=["January","February","March","April","May","June","July","August","September","October","November","December"],k=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]}var w=function(){f.find(".dd-d li,.dd-s-b li").show(),b(e)&&2==i?(f.find(".dd-d ul").width(29*p.dropWidth),(30==s||31==s)&&(s=29),f.find("li[data-id=30],li[data-id=31]").hide()):b(e)||2!=i?4==i||6==i||9==i||11==i?(f.find(".dd-d ul").width(30*p.dropWidth),31==s&&(s=30),f.find("li[data-id=31]").hide()):f.find(".dd-d ul").width(31*p.dropWidth):(f.find(".dd-d ul").width(28*p.dropWidth),(29==s||30==s||31==s)&&(s=28),f.find("li[data-id=29],li[data-id=30],li[data-id=31]").hide()),f.find(".dd-d li").each(function(a,s){var r=d(this).attr("data-id"),r=new Date(i+"/"+r+"/"+e),r=r.getDay();0==r||6==r?d(this).addClass("dd-sun"):d(this).removeClass("dd-sun"),d(this).find("span").html(k[r])}),f.find(".dd-s-b-d li").each(function(a,s){var r=d(this).attr("data-id"),r=new Date(i+"/"+r+"/"+e),r=r.getDay();0==r||6==r?d(this).addClass("dd-sun"):d(this).removeClass("dd-sun"),d(this).find("span").html(k[r].substr(0,3))}),f.find(".dd-s-b li").removeClass("dd-on"),f.find('.dd-s-b-d li[data-id="'+s+'"],.dd-s-b-m li[data-id="'+i+'"],.dd-s-b-s-y li[data-id="'+e+'"],.dd-s-b-y li[data-id="'+r+'"]').addClass("dd-on"),p.animate?f.hasClass("dd-init")?(f.find(".dd-m .dd-ul").animate({scrollLeft:f.find('.dd-m li[data-id="'+i+'"]').index()*p.dropWidth},1200,"swing"),setTimeout(function(){f.find(".dd-d .dd-ul").animate({scrollLeft:f.find('.dd-d li[data-id="'+s+'"]').index()*p.dropWidth},1200,"swing"),setTimeout(function(){f.find(".dd-y .dd-ul").animate({scrollLeft:f.find('.dd-y li[data-id="'+e+'"]').index()*p.dropWidth},1200,"swing",function(){v=!0,f.removeClass("dd-init")})},200)},400)):(f.find(".dd-d .dd-ul").stop().animate({scrollLeft:f.find('.dd-d li[data-id="'+s+'"]').index()*p.dropWidth},260),f.find(".dd-m .dd-ul").stop().animate({scrollLeft:f.find('.dd-m li[data-id="'+i+'"]').index()*p.dropWidth},260),f.find(".dd-y .dd-ul").stop().animate({scrollLeft:f.find('.dd-y li[data-id="'+e+'"]').index()*p.dropWidth},260),f.find(".dd-sub-y .dd-ul").stop().animate({scrollLeft:f.find('.dd-sub-y li[data-id="'+r+'"]').index()*p.dropWidth},260)):(setTimeout(function(){f.find(".dd-d .dd-ul").scrollLeft(f.find('.dd-d li[data-id="'+s+'"]').index()*p.dropWidth),f.find(".dd-m .dd-ul").scrollLeft(f.find('.dd-m li[data-id="'+i+'"]').index()*p.dropWidth),f.find(".dd-y .dd-ul").scrollLeft(f.find('.dd-y li[data-id="'+e+'"]').index()*p.dropWidth),f.find(".dd-sub-y .dd-ul").scrollLeft(f.find('.dd-sub-y li[data-id="'+r+'"]').index()*p.dropWidth)},1),f.hasClass("dd-init")&&(f.removeClass("dd-init"),v=!0)),D(r)},C=function(){f.addClass("dd-bottom"),f.find(".dd-c").css({top:c.offset().top+c.innerHeight()-6,left:c.offset().left+(c.innerWidth()/2-p.dropWidth/2)}).addClass("dd-"+p.init_animation)},M=function(){f.find(".dd-c").addClass("dd-alert").removeClass("dd-"+p.init_animation),setTimeout(function(){f.find(".dd-c").removeClass("dd-alert")},500)},x=function(){if(p.lock){var d=Date.parse(t+"-"+(o+1)+"-"+n)/1e3,a=Date.parse(e+"-"+i+"-"+s)/1e3;if("from"==p.lock){if(d>a)return M(),!1}else if(a>d)return M(),!1}var r=new Date(i+"/"+s+"/"+e),r=r.getDay(),l=p.format.replace(/\b(d)\b/g,m(s)).replace(/\b(m)\b/g,m(i)).replace(/\b(Y)\b/g,e).replace(/\b(D)\b/g,k[r].substr(0,3)).replace(/\b(l)\b/g,k[r]).replace(/\b(F)\b/g,y[i-1]).replace(/\b(M)\b/g,y[i-1].substr(0,3)).replace(/\b(n)\b/g,i).replace(/\b(j)\b/g,s);c.val(l),f.find(".dd-c").addClass("dd-fadeout").removeClass("dd-"+p.init_animation),h=setTimeout(function(){f.hide(),f.find(".dd-c").removeClass("dd-fadeout")},400),c.change()},D=function(a){f.find(".dd-s-b-s-y ul").empty();var i=parseInt(a),s=i+(p.yearsRange-1);s>p.maxYear&&(s=p.maxYear);for(var t=i;s>=t;t++){if(t%p.yearsRange==0)var n=t;f.find(".dd-s-b-s-y ul").append('<li data-id="'+t+'" data-filter="'+n+'">'+t+"</li>")}f.find(".dd-s-b-s-y ul").append('<div class="dd-clear"></div>'),r=parseInt(a),f.find(".dd-sub-y .dd-ul").scrollLeft(f.find('.dd-sub-y li[data-id="'+r+'"]').index()*p.dropWidth),f.find(".dd-s-b-s-y li").each(function(a,i){d(this).click(function(){f.find(".dd-s-b-s-y li").removeClass("dd-on"),d(this).addClass("dd-on"),e=parseInt(d(this).attr("data-id")),f.find(".dd-s-b-y,.dd-s-b-s-y").removeClass("dd-show"),f.find(".dd-s-b-s,.dd-sub-y").hide(),w()})})},j=function(){f.find(".dd-s-b").each(function(a,e){var r=d(this),t=0;if(r.hasClass("dd-s-b-m")||r.hasClass("dd-s-b-d")){if(r.hasClass("dd-s-b-m"))for(var n=12,o=t;n>o;o++)r.find("ul").append('<li data-id="'+(o+1)+'">'+y[o].substr(0,3)+"<span>"+m(o+1)+"</span></li>");if(r.hasClass("dd-s-b-d"))for(var n=31,o=t;n>o;o++)r.find("ul").append('<li data-id="'+(o+1)+'">'+m(o+1)+"<span></span></li>")}if(r.hasClass("dd-s-b-y"))for(var o=p.minYear;o<=p.maxYear;o++)o%p.yearsRange==0&&r.find("ul").append('<li data-id="'+o+'">'+o+"</li>");r.find("ul").append('<div class="dd-clear"></div>'),r.find("ul li").click(function(){(r.hasClass("dd-s-b-m")||r.hasClass("dd-s-b-d"))&&(r.hasClass("dd-s-b-m")&&(i=parseInt(d(this).attr("data-id"))),r.hasClass("dd-s-b-d")&&(s=parseInt(d(this).attr("data-id"))),w(),r.removeClass("dd-show"),f.find(".dd-s-b-s").hide()),r.hasClass("dd-s-b-y")&&(f.find(".dd-sub-y").show(),D(d(this).attr("data-id")),f.find(".dd-s-b-s-y").addClass("dd-show"))});var l=0,u=!1;r.on("mousewheel DOMMouseScroll",function(d){u=!0,(d.originalEvent.wheelDeltaY<0||d.originalEvent.detail>0)&&(l=r.scrollTop()+100),(d.originalEvent.wheelDeltaY>0||d.originalEvent.detail<0)&&(l=r.scrollTop()-100),r.stop().animate({scrollTop:l},600,"_dd_easing",function(){u=!1})}).on("scroll",function(){u||(l=r.scrollTop())})}),f.find(".dd-b").each(function(a,t){var n,o=d(this),l=0;if(o.hasClass("dd-m")){for(var u=0;12>u;u++)o.find("ul").append('<li data-id="'+(u+1)+'">'+y[u].substr(0,3)+"</li>");o.find("li").click(function(){return"m"==p.format||"n"==p.format||"F"==p.format||"M"==p.format?!1:void f.find(".dd-s-b-m").addClass("dd-show")})}if(o.hasClass("dd-d")){for(var u=1;31>=u;u++)o.find("ul").append('<li data-id="'+u+'"><strong>'+m(u)+"</strong><br><span></span></li>");o.find("li").click(function(){f.find(".dd-s-b-d").addClass("dd-show")})}if(o.hasClass("dd-y")){for(var u=p.minYear;u<=p.maxYear;u++){var c;u%p.yearsRange==0&&(c='data-filter="'+u+'"'),o.find("ul").append('<li data-id="'+u+'" '+c+">"+u+"</li>")}o.find("li").click(function(){return"Y"==p.format?!1:void f.find(".dd-s-b-y").addClass("dd-show")})}if(o.hasClass("dd-sub-y"))for(var u=p.minYear;u<=p.maxYear;u++)u%p.yearsRange==0&&o.find("ul").append('<li data-id="'+u+'">'+u+"</li>");o.find("ul").width(o.find("li").length*p.dropWidth),o.find(".dd-n").click(function(){clearInterval(n);var a,t,l;o.hasClass("dd-y")&&(t=e),o.hasClass("dd-m")&&(t=i),o.hasClass("dd-d")&&(t=s),o.hasClass("dd-sub-y")&&(t=r),d(this).hasClass("dd-n-left")?(a=o.find('li[data-id="'+t+'"]').prev("li"),l=a.length&&a.is(":visible")?parseInt(a.attr("data-id")):parseInt(o.find("li:visible:last").attr("data-id"))):(a=o.find('li[data-id="'+t+'"]').next("li"),l=a.length&&a.is(":visible")?parseInt(a.attr("data-id")):parseInt(o.find("li:first").attr("data-id"))),o.hasClass("dd-y")&&(e=l),o.hasClass("dd-m")&&(i=l),o.hasClass("dd-d")&&(s=l),o.hasClass("dd-sub-y")&&(r=l),w()});var b=function(){if(v){l=Math.round(o.find(".dd-ul").scrollLeft()/p.dropWidth);var d=parseInt(o.find("li").eq(l).attr("data-id"));o.hasClass("dd-y")&&(e=d),o.hasClass("dd-m")&&(i=d),o.hasClass("dd-d")&&(s=d),o.hasClass("dd-sub-y")&&(r=d)}};o.find(".dd-ul").on("scroll",function(){b()});var h=!1;o.find(".dd-ul").on("mousedown touchstart",function(){h||(h=!0),clearInterval(n),d(window).on("mouseup touchend touchmove",function(){h&&(clearInterval(n),n=setTimeout(function(){w(),h=!1},780))})}),"Y"==p.format&&f.find(".dd-m,.dd-d").hide(),("m"==p.format||"n"==p.format||"F"==p.format||"M"==p.format)&&f.find(".dd-y,.dd-d").hide()}),f.find(".dd-b li").click(function(){return"m"==p.format||"n"==p.format||"F"==p.format||"M"==p.format||"Y"==p.format?!1:void f.find(".dd-s-b-s").show()}),f.find(".dd-s-b-s").click(function(){f.find(".dd-s-b").removeClass("dd-show"),f.find(".dd-s-b-s").hide()}),f.find(".dd-s").click(function(){x()}),f.find(".dd-o").click(function(){f.find(".dd-c").addClass("dd-fadeout").removeClass("dd-"+p.init_animation),h=setTimeout(function(){f.hide(),f.find(".dd-c").removeClass("dd-fadeout")},400)}),w()},z=function(){clearInterval(h),f.hasClass("dd-init")&&(c.attr({readonly:"readonly"}).blur(),i=o+1,s=n,e=t,parseInt(c.attr("data-d"))&&parseInt(c.attr("data-d"))<=31&&(s=parseInt(c.attr("data-d"))),parseInt(c.attr("data-m"))&&parseInt(c.attr("data-m"))<=11&&(i=parseInt(c.attr("data-m"))+1),parseInt(c.attr("data-y"))&&4==c.attr("data-y").length&&(e=parseInt(c.attr("data-y"))),e>p.maxYear&&(p.maxYear=e),e<p.minYear&&(p.minYear=e),j()),f.show(),C()};c.click(function(){z()}),c.bind("focusin focus",function(d){d.preventDefault()}),d(window).resize(function(){C()})}})}}(jQuery);
;/*
|------------------------------------------------------------
| GLOBAL VARIABLES
|------------------------------------------------------------
*/

/*
|------------------------------------------------------------
| DOCUMENT READY
|------------------------------------------------------------
*/

$(document).ready(function() {

	//POPUP INIT
	popup.init();

	//DATE PICKER
	$( ".datedropper" ).dateDropper({
		animate:false,
		dropShadow:'none',
		dropBorderRadius:'0',
		dropBorder:'1px solid #dadada',
		dropPrimaryColor:'#8BC34A',
	});

	//TAKEAWAY TOGGLE ORDER
	$(document).on('click','.ta_view_orders',function(){
		$(this).parents('td').find('.ta_orders').slideToggle(200);
	});

});


/*
|------------------------------------------------------------
| ITEMS POPUP
|------------------------------------------------------------
*/
function timer(element,startWith){
	if(!startWith){
		startWith=0;
	}
	element.html('<span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span>');
	var timerInterval = setInterval(function(){
	    element.find(".seconds").text(pad(++startWith%60));
	    element.find(".minutes").text(pad(parseInt((startWith/60)%60,10)));
	    element.find(".hours").text(pad(parseInt((startWith/60)/60,10)));
			if(startWith>5){
				element.addClass('ss_danger');
			}
	},1000);
	function pad(val){
		return val>9 ? val:"0"+val;
	}
};

/*
|------------------------------------------------------------
| ITEMS POPUP
|------------------------------------------------------------
*/
$(function(){

	$(document).on('click','.ia_extra_toggle',function(){
		$(this).parents('.item_addons').find('.ia_extra').toggle();
	});

  $(document).on('click','.count_box button',function(){
    var box = $(this).parent();
    var boxText = box.find('.cb_count');
    if(!boxText.val()){
      boxText.val('0');
    }
    if($(this).hasClass('cb_plus')){
      boxText.val(parseInt(boxText.val())+1);
    }
    else if($(this).hasClass('cb_minus') && boxText.val()>1){
      boxText.val(parseInt(boxText.val())-1);
    }
  });

	var countKeys=[8,38,40,9,107,109,189,46];
	$(document).keydown(function(e){
		if($('.cb_count').is(":focus")){

				if((e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode >= 48 && e.keyCode <= 57)	|| countKeys.indexOf(e.keyCode)>-1){
					var boxText = $('.cb_count:focus');
					if(e.keyCode==38 || e.keyCode==107){
						e.preventDefault();
						boxText.val(parseInt(boxText.val())+1);
					}
					if(e.keyCode==40 || e.keyCode==109){
						e.preventDefault();
						if(boxText.val()>1){
							boxText.val(parseInt(boxText.val())-1);
						}
					}
				}
				else{
					e.preventDefault();
					return false;
			}
		}
	});
});

/*
|------------------------------------------------------------
| SIDEBAR
|------------------------------------------------------------
*/
$(function(){
  $(document).on('click','.s_nav_list li.has_sub_nav',function(){
      $(this).siblings().removeClass('open').find('.s_sub_nav_list').slideUp('fast');
      $(this).toggleClass('open').find('.s_sub_nav_list').slideToggle('fast');
  });
});


/*
|------------------------------------------------------------
| BUTTON LOADER
|------------------------------------------------------------
*/
var buttonLoader = {
  el:{
    loaderElement:'button_loader',
  },
  data:{
    loaderText:''
  },
  init:function(){
    buttonLoader.bindUIActions();
  },
  bindUIActions:function(){
  },
  on:function(settings){
    settings.button.addClass('on');
    settings.button.prop('disabled',true);
		buttonLoader.data.loaderText = settings.button.text();
    //BUTTON TEXT
    if(settings.text){
      settings.button.text(settings.text);
    }
  },
  off:function(settings){
    settings.button.removeClass('on');

    //BUTTON TEXT
    if(settings.text){
      settings.button.text(settings.text);
    }
    else{
      settings.button.text(buttonLoader.data.loaderText);
    }
    //IF DISABLE AFTER FIRST SUBMIT
    if(settings.disable){
      settings.button.prop('disabled',true);
    }
    else{
      settings.button.prop('disabled',false);
    }
  }
}

/*
|------------------------------------------------------------
| NOTIFICATION
|------------------------------------------------------------
*/
$(function(){
  notification.init();
});

var notification = {
	el:{
  },
  data:{
  },
  init:function(){
    this.bindUIActions();
  },
  bindUIActions:function(){
    var _this = this;
    $(document).on('click','.ss_notification .ssn_close',function(){
      _this.destroy();
    });
  },
  create:function(settings){
    var _this = this;

    //REMOVE PREV NOTIFICATION
    $('.ss_notification').remove();

    //NOTIFICATION TYPE
    var type='ss_info';
    if(settings.type){
      type='ss_'+settings.type;
    }

    //WIDTH
    var width='';
    if(settings.width){
      width = 'width:'+settings.width;
    }


    //CREATE
    html ='<div class="ss_notification '+type+'" style="'+width+'">';
    if(!(settings.icon || settings.icon==false)){
      html+=  '<div class="ssn_icon_wrap">';
      html+=    '<span class="ssn_icon"></span>';
      html+=  '</div>';
    }
    html+=  '<div class="ssn_text_wrap">';
    html+=    '<p class="ssn_text">';
    html+=      settings.text;
    html+=    '</p>';
    html+=  '</div>';
    html+=  '<div class="ssn_close_wrap">';
    html+=    '<button class="ssn_close">×</button>';
    html+=  '</div>';
    html+='</div>';


    //APPEND
    $('body').append(html);


    //ANIMATE
    setTimeout(function(){
      $('.ss_notification').addClass('open');
    },10);

    //AUTO HIDE
    if(settings.timeout){
      setTimeout(function(){
        _this.destroy();
      },settings.timeout);
    }

  },
  destroy:function(){
    $('.ss_notification').removeClass('open');
  }
};


/*
|------------------------------------------------------------
| LOADER
|------------------------------------------------------------
*/
var loader = {
  el:{
    loaderElement:'ss_loader',
    loaderText:'ss_loader_text',
  },
  data:{
    loaderText:'Please Wait'
  },
  init:function(){
    loader.bindUIActions();
  },
  bindUIActions:function(){
  },
  on:function(settings){
    $('.'+loader.el.loaderElement).addClass('open');
    if(settings){
      if(settings.text){
        $('.'+loader.el.loaderText).text(settings.text);
      }
    }
    else{
      $('.'+loader.el.loaderText).text(loader.data.loaderText);
    }
  },
  off:function(){
    $('.'+loader.el.loaderElement).removeClass('open');
  }
}

/*
|------------------------------------------------------------
| ACTION BOX
|------------------------------------------------------------
*/
var actionBox = {
	el:{
  },
  data:{
  },
  init:function(){
    actionBox.bindUIActions();
  },
  bindUIActions:function(){

  },
  create:function(settings){
    actionBox.destroy();
    var html='';
    html += '<div class="ss_action_box_overlay">';
    html +=   '<div class="ss_action_box">';
    html +=     '<div class="ss_ab_header">';
    html +=       settings.title;
    html +=     '</div>';
    html +=     '<div class="ss_ab_content">';
    html +=       settings.content;
    html +=     '</div>';
    html +=     '<div class="ss_ab_footer">';
                  for(var i=0; i<settings.buttons.length; i++){
                    var actionScript = settings.buttons[i].action;
                    html +=       '<button class="button" id="ssabb'+i+'">';
                    html +=         settings.buttons[i].name;
                    html +=       '</button>';
                    if(actionScript){
                      html +=       '<script type="text/javascript">';
                      html +=       '$(document).on("click","#ssabb'+i+'",';
                      html +=       actionScript;
                      html +=       ')';
                      html +=       '</script>';
                    }
                  }
    html +=     '</div>';
    html +=   '</div>';
    html += '</div>';
    $('body').append(html);
  },
  destroy:function(){
    $('.ss_action_box_overlay button').each(function(){
        $(document).off('click','#'+$(this).attr('id'));
    });
    $('.ss_action_box_overlay').remove();
  }
};

/*
|------------------------------------------------------------
| POPUP
|------------------------------------------------------------
*/
var popup = {
	el:{
  },
  data:{
		currentPopup:''
  },
  init:function(){
    popup.bindUIActions();
  },
  bindUIActions:function(){
    $(document).on("click",'.popup_open',function(){
			popup.open($(this).data('popup'));
		});
    $(document).on("click",'.popup_close',function(){
			popup.close($(this).parents('.popup').attr('id'));
		});
		$(document).mouseup(function(e){
		    var container = $('.popup_overlay');
		    if (container.is(e.target)){
		        popup.close(popup.data.currentPopup);
		    }
		});
		$(document).keyup(function(e){
		    if(e.keyCode==27){
					popup.close(popup.data.currentPopup);
				}
		});
  },
	open:function(popupID){
		popup.close(popup.data.currentPopup);
		popup.data.currentPopup=popupID;
		$('body').addClass('oh');
		$('#'+popupID).parents('.popup_overlay').addClass('open');
		$('#'+popupID).addClass('open');
		$('#'+popupID).find('.popup_focus').focus();
	},
	close:function(popupID){
		popup.data.currentPopup='';
		$('#'+popupID).parents('.popup_overlay').removeClass('open');
		$('#'+popupID).removeClass('open');
		$('body').removeClass('oh').focus();
	},
};

/*
|------------------------------------------------------------
| PAGE LOADED
|------------------------------------------------------------
*/

$(window).bind("load", function() {

});


/*
|------------------------------------------------------------
| DOCUMENT MOUSE UP
|------------------------------------------------------------
*/
$(document).mouseup(function(e){

    var container = $('.auto_close');
    var opener = $('.opener.auto_close');
    if (!container.is(e.target) && container.has(e.target).length === 0
       && !opener.is(e.target) && opener.has(e.target).length === 0
       ){
        container.removeClass('open');
        opener.removeClass('active');
        $('.overlay').removeClass('open');
    }
});


/*
|------------------------------------------------------------
| OPENER
|------------------------------------------------------------
*/

$(document).on('click','.opener',function(){
    $this = $(this);
    $this.toggleClass('active');
    $('.opener').not($this).removeClass('active');
    var toOpen = $('.'+$this.data('open'));
    toOpen.toggleClass('open').find('.open_focus').focus();
    $('.auto_close').not(toOpen).removeClass('open');
    if($this.data('overlay')){
      $('.overlay').toggleClass('open');
    }
});

/*
|------------------------------------------------------------
| LOG
|------------------------------------------------------------
*/
function log(input){
    console.log(input);
}

/*
|------------------------------------------------------------
| SS AJAX SEARCH
|------------------------------------------------------------
*/

var demoData = [
	{
		name:'Mango',
		id:'mango',
		cat:'Icecream'
	},
	{
		name:'Chocolate',
		id:'chocolate',
		cat:'Icecream'
	},
	{
		name:'Chikoo',
		id:'chikoo',
		cat:'Icecream'
	},
	{
		name:'Banana',
		id:'canana',
		cat:'Shakes'
	},
	{
		name:'Chocolate',
		id:'chocolate',
		cat:'Shakes'
	},
	{
		name:'Coffee',
		id:'coffee',
		cat:'Shakes'
	},
];

function ajaxSearch(ele,data){
	var ajaxSearchJson  = {
		el:{
			noResult:'',
			resultList:'',
			searchBox:'',
			searchWrap : '',
		},
		data:{
			isTyping:false,
			navKeys:[40,38,23,27],
			currentFocus:-1,
			matchingResults:0,
		},

		bindUIActions:function(){
			var _this=this;

			$(document).on('mouseup',function(e){
				if(!_this.el.searchBox.is(':focus') && !_this.el.resultList.find('li a:focus').length > 0){
					_this.reset(_this.el.searchWrap);
				}
			});
			$(document).on('keyup',function(e){
				if(_this.el.searchBox.is(':focus') || _this.el.resultList.find('li a:focus').length > 0){
					_this.typing(e);
				}
			});
			$(document).on('keydown',function(e){
				if(_this.el.searchBox.is(':focus') || _this.el.resultList.find('li a:focus').length > 0){
					_this.navigating(e);
				}
			});
		},

		init:function(ele,data){
			this.el.searchWrap = ele;
			this.el.searchBox = ele.find('.ss_as_text');
			this.create(data);
			this.bindUIActions();
		},

		create:function(data){
			var results='<ul class="ss_as_result">';
			for(var i=0; i<data.length; i++){
				results+='<li>\
					<a href="#nogo" data-id="'+data[i].id+'">\
						<p class="i_item_name">'+data[i].name+'</p>\
						<p class="i_item_cat">'+data[i].cat+'</p>\
					</a>\
				</li>';
			}
			results+='<li class="ss_as_no_result"><a href="#nogo" data-id="0">No Results Found !</a></li>';
			results+='</ul>';
			this.el.searchWrap.append(results);
			this.el.resultList = this.el.searchWrap.find('.ss_as_result');
			this.el.noResult = this.el.searchWrap.find('.ss_as_no_result');
		},

		navigating:function(e){
			var _this = this;
			switch(e.keyCode){

				//DOWN KEY
				case 40:
					if(_this.data.currentFocus == _this.data.matchingResults){
						_this.data.currentFocus=0;
					}
					else{
						_this.data.currentFocus++;
					}
					_this.el.resultList.find('li:visible').eq(_this.data.currentFocus).find('a').focus();
					break;

				//UP KEY
				case 38:
					if(_this.data.currentFocus == 0){
						_this.data.currentFocus = _this.data.matchingResults;
					}
					else{
						_this.data.currentFocus--;
					}
					_this.el.resultList.find('li:visible').eq(_this.data.currentFocus).find('a').focus();
					break;

				//ENTER KEY
				case 13:
					_this.action(_this.el.resultList.find('li:visible').eq(_this.data.currentFocus));
					break;

				//ESC KEY
				case 27:
					_this.reset(_this.el.searchWrap);
					break;
				default:
					_this.el.searchBox.focus();
					break;
			}
		},

		typing:function(e){
			var _this = this;
			if(_this.data.navKeys.indexOf(e.keyCode)>-1){
				return false;
			}
			_this.data.matchingResults=0;
			_this.data.currentFocus=-1;
			var searchValue = _this.el.searchBox.val(); //GET THE VALUE
			var dropDown = _this.el.searchWrap.find('.ss_as_result li:not(.ss_as_no_result)');

			//IF SEARCHBOX TEXT
			if(searchValue!=''){
				_this.el.resultList.addClass('open');
				//LOOP THROUGH ARRAY
				$.each(dropDown,function(index,value){
						if($(value).text().toLowerCase().indexOf(searchValue.toLowerCase()) >= 0){
							$(value).show();
							_this.data.matchingResults++;
						}
						else{
							$(value).hide();
						}
				});
				//IF RESULTS ARE THERE
				if(_this.data.matchingResults==0){
					_this.el.noResult.show();
				}
				else{
					_this.el.noResult.hide();
				}
			}
			//IF TEXTBOX EMPTY
			else{
				_this.el.resultList.removeClass('open');
			}
		},

		reset:function(ele){
			ele.find('.ss_as_text').val('').blur();
			ele.find('.ss_as_result').removeClass('open');
		},

		action:function(selected){
			alert(selected.text());
			this.reset(this.el.searchWrap)
		}
	}

	//CALLING
	ajaxSearchJson.init(ele,data);
}

$(function(){
	ajaxSearch($('#searchItemsList'),demoData);
	ajaxSearch($('#searchItemsList2'),demoData);
});

/*
|------------------------------------------------------------
| FULL SCREEN
|------------------------------------------------------------
*/
function toggleFullScreen() {
  if ((document.fullScreenElement && document.fullScreenElement !== null) ||
   (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if (document.documentElement.requestFullScreen) {
      document.documentElement.requestFullScreen();
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
    } else if (document.documentElement.webkitRequestFullScreen) {
      document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
    }
  } else {
    if (document.cancelFullScreen) {
      document.cancelFullScreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitCancelFullScreen) {
      document.webkitCancelFullScreen();
    }
  }
}

/*
|------------------------------------------------------------
| SMOOTH SCROLL
|------------------------------------------------------------
*/
$(function(){
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 500);
                return false;
            }
        }
    });
});
