/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(M){var s=function(e,t){this.id=++M.FE.ID,this.opts=M.extend(!0,{},M.extend({},s.DEFAULTS,"object"==typeof t&&t));var n=JSON.stringify(this.opts);M.FE.OPTS_MAPPING[n]=M.FE.OPTS_MAPPING[n]||this.id,this.sid=M.FE.OPTS_MAPPING[n],M.FE.SHARED[this.sid]=M.FE.SHARED[this.sid]||{},this.shared=M.FE.SHARED[this.sid],this.shared.count=(this.shared.count||0)+1,this.$oel=M(e),this.$oel.data("froala.editor",this),this.o_doc=e.ownerDocument,this.o_win="defaultView"in this.o_doc?this.o_doc.defaultView:this.o_doc.parentWindow;var r=M(this.o_win).scrollTop();this.$oel.on("froala.doInit",M.proxy(function(){this.$oel.off("froala.doInit"),this.doc=this.$el.get(0).ownerDocument,this.win="defaultView"in this.doc?this.doc.defaultView:this.doc.parentWindow,this.$doc=M(this.doc),this.$win=M(this.win),this.opts.pluginsEnabled||(this.opts.pluginsEnabled=Object.keys(M.FE.PLUGINS)),this.opts.initOnClick?(this.load(M.FE.MODULES),this.$el.on("touchstart.init",function(){M(this).data("touched",!0)}),this.$el.on("touchmove.init",function(){M(this).removeData("touched")}),this.$el.on("mousedown.init touchend.init dragenter.init focus.init",M.proxy(function(e){if("touchend"==e.type&&!this.$el.data("touched"))return!0;if(1===e.which||!e.which){this.$el.off("mousedown.init touchstart.init touchmove.init touchend.init dragenter.init focus.init"),this.load(M.FE.MODULES),this.load(M.FE.PLUGINS);var t=e.originalEvent&&e.originalEvent.originalTarget;t&&"IMG"==t.tagName&&M(t).trigger("mousedown"),"undefined"==typeof this.ul&&this.destroy(),"touchend"==e.type&&this.image&&e.originalEvent&&e.originalEvent.target&&M(e.originalEvent.target).is("img")&&setTimeout(M.proxy(function(){this.image.edit(M(e.originalEvent.target))},this),100),this.ready=!0,this.events.trigger("initialized")}},this)),this.events.trigger("initializationDelayed")):(this.load(M.FE.MODULES),this.load(M.FE.PLUGINS),M(this.o_win).scrollTop(r),"undefined"==typeof this.ul&&this.destroy(),this.ready=!0,this.events.trigger("initialized"))},this)),this._init()};s.DEFAULTS={initOnClick:!1,pluginsEnabled:null},s.MODULES={},s.PLUGINS={},s.VERSION="2.8.4",s.INSTANCES=[],s.OPTS_MAPPING={},s.SHARED={},s.ID=0,s.prototype._init=function(){var e=this.$oel.prop("tagName");this.$oel.closest("label").length;var t=M.proxy(function(){"TEXTAREA"!=e&&(this._original_html=this._original_html||this.$oel.html()),this.$box=this.$box||this.$oel,this.opts.fullPage&&(this.opts.iframe=!0),this.opts.iframe?(this.$iframe=M('<iframe src="about:blank" frameBorder="0">'),this.$wp=M("<div></div>"),this.$box.html(this.$wp),this.$wp.append(this.$iframe),this.$iframe.get(0).contentWindow.document.open(),this.$iframe.get(0).contentWindow.document.write("<!DOCTYPE html>"),this.$iframe.get(0).contentWindow.document.write("<html><head></head><body></body></html>"),this.$iframe.get(0).contentWindow.document.close(),this.$el=this.$iframe.contents().find("body"),this.el=this.$el.get(0),this.$head=this.$iframe.contents().find("head"),this.$html=this.$iframe.contents().find("html"),this.iframe_document=this.$iframe.get(0).contentWindow.document):(this.$el=M("<div></div>"),this.el=this.$el.get(0),this.$wp=M("<div></div>").append(this.$el),this.$box.html(this.$wp)),this.$oel.trigger("froala.doInit")},this),n=M.proxy(function(){this.$box=M("<div>"),this.$oel.before(this.$box).hide(),this._original_html=this.$oel.val(),this.$oel.parents("form").on("submit."+this.id,M.proxy(function(){this.events.trigger("form.submit")},this)),this.$oel.parents("form").on("reset."+this.id,M.proxy(function(){this.events.trigger("form.reset")},this)),t()},this),r=M.proxy(function(){this.$el=this.$oel,this.el=this.$el.get(0),this.$el.attr("contenteditable",!0).css("outline","none").css("display","inline-block"),this.opts.multiLine=!1,this.opts.toolbarInline=!1,this.$oel.trigger("froala.doInit")},this),o=M.proxy(function(){this.$el=this.$oel,this.el=this.$el.get(0),this.opts.toolbarInline=!1,this.$oel.trigger("froala.doInit")},this),i=M.proxy(function(){this.$el=this.$oel,this.el=this.$el.get(0),this.opts.toolbarInline=!1,this.$oel.on("click.popup",function(e){e.preventDefault()}),this.$oel.trigger("froala.doInit")},this);this.opts.editInPopup?i():"TEXTAREA"==e?n():"A"==e?r():"IMG"==e?o():"BUTTON"==e||"INPUT"==e?(this.opts.editInPopup=!0,this.opts.toolbarInline=!1,i()):t()},s.prototype.load=function(e){for(var t in e)if(e.hasOwnProperty(t)){if(this[t])continue;if(M.FE.PLUGINS[t]&&this.opts.pluginsEnabled.indexOf(t)<0)continue;if(this[t]=new e[t](this),this[t]._init&&(this[t]._init(),this.opts.initOnClick&&"core"==t))return!1}},s.prototype.destroy=function(){this.shared.count--,this.events.$off();var e=this.html.get();if(this.opts.iframe&&(this.events.disableBlur(),this.win.focus(),this.events.enableBlur()),this.events.trigger("destroy",[],!0),this.events.trigger("shared.destroy",undefined,!0),0===this.shared.count){for(var t in this.shared)this.shared.hasOwnProperty(t)&&(this.shared[t],M.FE.SHARED[this.sid][t]=null);delete M.FE.SHARED[this.sid]}this.$oel.parents("form").off("."+this.id),this.$oel.off("click.popup"),this.$oel.removeData("froala.editor"),this.$oel.off("froalaEditor"),this.core.destroy(e),M.FE.INSTANCES.splice(M.FE.INSTANCES.indexOf(this),1)},M.fn.froalaEditor=function(o){for(var i=[],e=0;e<arguments.length;e++)i.push(arguments[e]);if("string"==typeof o){var a=[];return this.each(function(){var e=M(this).data("froala.editor");if(e){var t,n;if(0<o.indexOf(".")&&e[o.split(".")[0]]?(e[o.split(".")[0]]&&(t=e[o.split(".")[0]]),n=o.split(".")[1]):(t=e,n=o.split(".")[0]),!t[n])return M.error("Method "+o+" does not exist in Froala Editor.");var r=t[n].apply(e,i.slice(1));r===undefined?a.push(this):0===a.length&&a.push(r)}}),1==a.length?a[0]:a}if("object"==typeof o||!o)return this.each(function(){if(!M(this).data("froala.editor")){new s(this,o)}})},M.fn.froalaEditor.Constructor=s,M.FroalaEditor=s,M.FE=s,M.FE.XS=0,M.FE.SM=1,M.FE.MD=2,M.FE.LG=3;M.FE.LinkRegExCommon="[a-z\\u0080-\\u009f\\u00a1-\\uffff0-9-_.]{1,}",M.FE.LinkRegExEnd="((:[0-9]{1,5})|)(((\\/|\\?|#)[a-z\\u00a1-\\uffff0-9@?\\|!^=%&amp;/~+#-\\'*-_{}]*)|())",M.FE.LinkRegExTLD="(("+M.FE.LinkRegExCommon+")(\\.(com|net|org|edu|mil|gov|co|biz|info|me|dev)))",M.FE.LinkRegExHTTP="((ftp|http|https):\\/\\/"+M.FE.LinkRegExCommon+")",M.FE.LinkRegExAuth="((ftp|http|https):\\/\\/[\\u0021-\\uffff]{1,}@"+M.FE.LinkRegExCommon+")",M.FE.LinkRegExWWW="(www\\."+M.FE.LinkRegExCommon+"\\.[a-z0-9-]{2,24})",M.FE.LinkRegEx="("+M.FE.LinkRegExTLD+"|"+M.FE.LinkRegExHTTP+"|"+M.FE.LinkRegExWWW+"|"+M.FE.LinkRegExAuth+")"+M.FE.LinkRegExEnd,M.FE.LinkProtocols=["mailto","tel","sms","notes","data"],M.FE.MAIL_REGEX=/.+@.+\..+/i,M.FE.MODULES.helpers=function(i){function e(){var e,t,n={},r=(t=-1,"Microsoft Internet Explorer"==navigator.appName?(e=navigator.userAgent,null!==new RegExp("MSIE ([0-9]{1,}[\\.0-9]{0,})").exec(e)&&(t=parseFloat(RegExp.$1))):"Netscape"==navigator.appName&&(e=navigator.userAgent,null!==new RegExp("Trident/.*rv:([0-9]{1,}[\\.0-9]{0,})").exec(e)&&(t=parseFloat(RegExp.$1))),t);if(0<r)n.msie=!0;else{var o=navigator.userAgent.toLowerCase(),i=/(edge)[ \/]([\w.]+)/.exec(o)||/(chrome)[ \/]([\w.]+)/.exec(o)||/(webkit)[ \/]([\w.]+)/.exec(o)||/(opera)(?:.*version|)[ \/]([\w.]+)/.exec(o)||/(msie) ([\w.]+)/.exec(o)||o.indexOf("compatible")<0&&/(mozilla)(?:.*? rv:([\w.]+)|)/.exec(o)||[],a=i[1]||"";i[2];i[1]&&(n[a]=!0),n.chrome?n.webkit=!0:n.webkit&&(n.safari=!0)}return n.msie&&(n.version=r),n}function t(){return/(iPad|iPhone|iPod)/g.test(navigator.userAgent)&&!o()}function n(){return/(Android)/g.test(navigator.userAgent)&&!o()}function r(){return/(Blackberry)/g.test(navigator.userAgent)}function o(){return/(Windows Phone)/gi.test(navigator.userAgent)}function a(e){return parseInt(e,10)||0}var s;var l=null;return{_init:function(){i.browser=e(),function(){function e(e,t){var i=e[t];e[t]=function(e){var t,n=!1,r=!1;if(e&&e.match(s)){e=e.replace(s,""),this.parentNode||(a.appendChild(this),r=!0);var o=this.parentNode;return this.id||(this.id="rootedQuerySelector_id_"+(new Date).getTime(),n=!0),t=i.call(o,"#"+this.id+" "+e),n&&(this.id=""),r&&a.removeChild(this),t}return i.call(this,e)}}var a=i.o_doc.createElement("div");try{a.querySelectorAll(":scope *")}catch(t){var s=/^\s*:scope/gi;e(Element.prototype,"querySelector"),e(Element.prototype,"querySelectorAll"),e(HTMLElement.prototype,"querySelector"),e(HTMLElement.prototype,"querySelectorAll")}}(),Element.prototype.matches||(Element.prototype.matches=Element.prototype.msMatchesSelector||Element.prototype.webkitMatchesSelector),Element.prototype.closest||(Element.prototype.closest=function(e){var t=this;if(!t)return null;if(!document.documentElement.contains(this))return null;do{if(t.matches(e))return t;t=t.parentElement}while(null!==t);return null})},isIOS:t,isMac:function(){return null==l&&(l=0<=navigator.platform.toUpperCase().indexOf("MAC")),l},isAndroid:n,isBlackberry:r,isWindowsPhone:o,isMobile:function(){return n()||t()||r()},isEmail:function(e){return!/^(https?:|ftps?:|)\/\//i.test(e)&&M.FE.MAIL_REGEX.test(e)},requestAnimationFrame:function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||function(e){window.setTimeout(e,1e3/60)}},getPX:a,screenSize:function(){var e=M('<div class="fr-visibility-helper"></div>').appendTo("body:first");try{var t=a(e.css("margin-left"));return e.remove(),t}catch(n){return M.FE.LG}},isTouch:function(){return"ontouchstart"in window||window.DocumentTouch&&document instanceof DocumentTouch},sanitizeURL:function(e){return/^(https?:|ftps?:|)\/\//i.test(e)?e:/^([A-Za-z]:(\\){1,2}|[A-Za-z]:((\\){1,2}[^\\]+)+)(\\)?$/i.test(e)?e:new RegExp("^("+M.FE.LinkProtocols.join("|")+"):\\/\\/","i").test(e)?e:e=encodeURIComponent(e).replace(/%23/g,"#").replace(/%2F/g,"/").replace(/%25/g,"%").replace(/mailto%3A/gi,"mailto:").replace(/file%3A/gi,"file:").replace(/sms%3A/gi,"sms:").replace(/tel%3A/gi,"tel:").replace(/notes%3A/gi,"notes:").replace(/data%3Aimage/gi,"data:image").replace(/blob%3A/gi,"blob:").replace(/%3A(\d)/gi,":$1").replace(/webkit-fake-url%3A/gi,"webkit-fake-url:").replace(/%3F/g,"?").replace(/%3D/g,"=").replace(/%26/g,"&").replace(/&amp;/g,"&").replace(/%2C/g,",").replace(/%3B/g,";").replace(/%2B/g,"+").replace(/%40/g,"@").replace(/%5B/g,"[").replace(/%5D/g,"]").replace(/%7B/g,"{").replace(/%7D/g,"}")},isArray:function(e){return e&&!e.propertyIsEnumerable("length")&&"object"==typeof e&&"number"==typeof e.length},RGBToHex:function(e){function t(e){return("0"+parseInt(e,10).toString(16)).slice(-2)}try{return e&&"transparent"!==e?/^#[0-9A-F]{6}$/i.test(e)?e:("#"+t((e=e.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/))[1])+t(e[2])+t(e[3])).toUpperCase():""}catch(n){return null}},HEXtoRGB:function(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,n,r){return t+t+n+n+r+r});var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return t?"rgb("+parseInt(t[1],16)+", "+parseInt(t[2],16)+", "+parseInt(t[3],16)+")":""},isURL:function(e){return!!/^(https?:|ftps?:|)\/\//i.test(e)&&(e=String(e).replace(/</g,"%3C").replace(/>/g,"%3E").replace(/"/g,"%22").replace(/ /g,"%20"),new RegExp("^"+M.FE.LinkRegExHTTP+M.FE.LinkRegExEnd+"$","gi").test(e))},getAlignment:function(e){var t=(e.css("text-align")||"").replace(/-(.*)-/g,"");if(["left","right","justify","center"].indexOf(t)<0){if(!s){var n=M('<div dir="'+("rtl"==i.opts.direction?"rtl":"auto")+'" style="text-align: '+i.$el.css("text-align")+'; position: fixed; left: -3000px;"><span id="s1">.</span><span id="s2">.</span></div>');M("body:first").append(n);var r=n.find("#s1").get(0).getBoundingClientRect().left,o=n.find("#s2").get(0).getBoundingClientRect().left;n.remove(),s=r<o?"left":"right"}t=s}return t},scrollTop:function(){return i.o_win.pageYOffset?i.o_win.pageYOffset:i.o_doc.documentElement&&i.o_doc.documentElement.scrollTop?i.o_doc.documentElement.scrollTop:i.o_doc.body.scrollTop?i.o_doc.body.scrollTop:0},scrollLeft:function(){return i.o_win.pageXOffset?i.o_win.pageXOffset:i.o_doc.documentElement&&i.o_doc.documentElement.scrollLeft?i.o_doc.documentElement.scrollLeft:i.o_doc.body.scrollLeft?i.o_doc.body.scrollLeft:0},isInViewPort:function(e){var t=e.getBoundingClientRect();return 0<=t.top&&t.bottom<=(window.innerHeight||document.documentElement.clientHeight)||t.top<=0&&t.bottom>=(window.innerHeight||document.documentElement.clientHeight)}}},M.FE.MODULES.events=function(s){var e,a={};function t(e,t,n){f(e,t,n)}function n(e){if(void 0===e&&(e=!0),!s.$wp)return!1;if(s.helpers.isIOS()&&s.$win.get(0).focus(),s.core.hasFocus())return!1;if(!s.core.hasFocus()&&e){var t=s.$win.scrollTop();if(s.browser.msie&&s.$box&&s.$box.css("position","fixed"),s.browser.msie&&s.$wp&&s.$wp.css("overflow","visible"),i(),s.$el.focus(),s.events.trigger("focus"),o(),s.browser.msie&&s.$box&&s.$box.css("position",""),s.browser.msie&&s.$wp&&s.$wp.css("overflow","auto"),t!=s.$win.scrollTop()&&s.$win.scrollTop(t),!s.selection.info(s.el).atStart)return!1}if(!s.core.hasFocus()||0<s.$el.find(".fr-marker").length)return!1;if(s.selection.info(s.el).atStart&&s.selection.isCollapsed()&&null!=s.html.defaultTag()){var n=s.markers.insert();if(n&&!s.node.blockParent(n)){M(n).remove();var r=s.$el.find(s.html.blockTagsQuery()).get(0);r&&(M(r).prepend(M.FE.MARKERS),s.selection.restore())}else n&&M(n).remove()}}var r=!1;function o(){e=!0}function i(){e=!1}function l(){return e}function d(e,t,n){var r,o=e.split(" ");if(1<o.length){for(var i=0;i<o.length;i++)d(o[i],t,n);return!0}void 0===n&&(n=!1),r=0!==e.indexOf("shared.")?a[e]=a[e]||[]:s.shared._events[e]=s.shared._events[e]||[],n?r.unshift(t):r.push(t)}var c=[];function f(e,t,n,r,o){"function"==typeof n&&(o=r,r=n,n=!1);var i=o?s.shared.$_events:c,a=o?s.sid:s.id;n?e.on(t.split(" ").join(".ed"+a+" ")+".ed"+a,n,r):e.on(t.split(" ").join(".ed"+a+" ")+".ed"+a,r),i.push([e,t.split(" ").join(".ed"+a+" ")+".ed"+a])}function p(e){for(var t=0;t<e.length;t++)e[t][0].off(e[t][1])}function u(e,t,n){if(!s.edit.isDisabled()||n){var r,o;if(0!==e.indexOf("shared."))r=a[e];else{if(0<s.shared.count)return!1;r=s.shared._events[e]}if(r)for(var i=0;i<r.length;i++)if(!1===(o=r[i].apply(s,t)))return!1;return!1!==(o=s.$oel.triggerHandler("froalaEditor."+e,M.merge([s],t||[])))&&o}}function g(){for(var e in a)a.hasOwnProperty(e)&&delete a[e]}function h(){for(var e in s.shared._events)s.shared._events.hasOwnProperty(e)&&delete s.shared._events[e]}return{_init:function(){s.shared.$_events=s.shared.$_events||[],s.shared._events={},s.helpers.isMobile()?(s._mousedown="touchstart",s._mouseup="touchend",s._move="touchmove",s._mousemove="touchmove"):(s._mousedown="mousedown",s._mouseup="mouseup",s._move="",s._mousemove="mousemove"),t(s.$el,"click mouseup mousedown touchstart touchend dragenter dragover dragleave dragend drop dragstart",function(e){u(e.type,[e])}),d("mousedown",function(){for(var e=0;e<M.FE.INSTANCES.length;e++)M.FE.INSTANCES[e]!=s&&M.FE.INSTANCES[e].popups&&M.FE.INSTANCES[e].popups.areVisible()&&M.FE.INSTANCES[e].$el.find(".fr-marker").remove()}),t(s.$win,s._mousedown,function(e){u("window.mousedown",[e]),o()}),t(s.$win,s._mouseup,function(e){u("window.mouseup",[e])}),t(s.$win,"cut copy keydown keyup touchmove touchend",function(e){u("window."+e.type,[e])}),t(s.$doc,"dragend drop",function(e){u("document."+e.type,[e])}),t(s.$el,"keydown keypress keyup input",function(e){u(e.type,[e])}),t(s.$el,"focus",function(e){l()&&(n(!1),!1===r&&u(e.type,[e]))}),t(s.$el,"blur",function(e){l()&&!0===r&&(u(e.type,[e]),o())}),d("focus",function(){r=!0}),d("blur",function(){r=!1}),o(),t(s.$el,"cut copy paste beforepaste",function(e){u(e.type,[e])}),d("destroy",g),d("shared.destroy",h)},on:d,trigger:u,bindClick:function(e,t,n){f(e,s._mousedown,t,function(e){var t,n;s.edit.isDisabled()||(n=M((t=e).currentTarget),s.edit.isDisabled()||s.node.hasClass(n.get(0),"fr-disabled")?t.preventDefault():"mousedown"===t.type&&1!==t.which||(s.helpers.isMobile()||t.preventDefault(),(s.helpers.isAndroid()||s.helpers.isWindowsPhone())&&0===n.parents(".fr-dropdown-menu").length&&(t.preventDefault(),t.stopPropagation()),n.addClass("fr-selected"),s.events.trigger("commands.mousedown",[n])))},!0),f(e,s._mouseup+" "+s._move,t,function(e){s.edit.isDisabled()||function(e,t){var n=M(e.currentTarget);if(s.edit.isDisabled()||s.node.hasClass(n.get(0),"fr-disabled"))return e.preventDefault();if(("mouseup"!==e.type||1===e.which)&&s.node.hasClass(n.get(0),"fr-selected"))if("touchmove"!=e.type){if(e.stopPropagation(),e.stopImmediatePropagation(),e.preventDefault(),!s.node.hasClass(n.get(0),"fr-selected"))return s.button.getButtons(".fr-selected",!0).removeClass("fr-selected");if(s.button.getButtons(".fr-selected",!0).removeClass("fr-selected"),n.data("dragging")||n.attr("disabled"))return n.removeData("dragging");var r=n.data("timeout");r&&(clearTimeout(r),n.removeData("timeout")),t.apply(s,[e])}else n.data("timeout")||n.data("timeout",setTimeout(function(){n.data("dragging",!0)},100))}(e,n)},!0),f(e,"mousedown click mouseup",t,function(e){s.edit.isDisabled()||e.stopPropagation()},!0),d("window.mouseup",function(){s.edit.isDisabled()||(e.find(t).removeClass("fr-selected"),o())})},disableBlur:i,enableBlur:o,blurActive:l,focus:n,chainTrigger:function(e,t,n){if(!s.edit.isDisabled()||n){var r,o;if(0!==e.indexOf("shared."))r=a[e];else{if(0<s.shared.count)return!1;r=s.shared._events[e]}if(r)for(var i=0;i<r.length;i++)void 0!==(o=r[i].apply(s,[t]))&&(t=o);return void 0!==(o=s.$oel.triggerHandler("froalaEditor."+e,M.merge([s],[t])))&&(t=o),t}},$on:f,$off:function(){p(c),c=[],0===s.shared.count&&(p(s.shared.$_events),s.shared.$_events=[])}}},M.FE.MODULES.node=function(a){function s(e){return e&&"IFRAME"!=e.tagName?Array.prototype.slice.call(e.childNodes||[]):[]}function l(e){return!!e&&(e.nodeType==Node.ELEMENT_NODE&&0<=M.FE.BLOCK_TAGS.indexOf(e.tagName.toLowerCase()))}function d(e){var t={},n=e.attributes;if(n)for(var r=0;r<n.length;r++){var o=n[r];t[o.nodeName]=o.value}return t}function t(e){for(var t="",n=d(e),r=Object.keys(n).sort(),o=0;o<r.length;o++){var i=r[o],a=n[i];a.indexOf("'")<0&&0<=a.indexOf('"')?t+=" "+i+"='"+a+"'":0<=a.indexOf('"')&&0<=a.indexOf("'")?t+=" "+i+'="'+(a=a.replace(/"/g,"&quot;"))+'"':t+=" "+i+'="'+a+'"'}return t}function n(e){return e===a.el}return{isBlock:l,isEmpty:function(e,t){if(!e)return!0;if(e.querySelector("table"))return!1;var n=s(e);1==n.length&&l(n[0])&&(n=s(n[0]));for(var r=!1,o=0;o<n.length;o++){var i=n[o];if(!(t&&a.node.hasClass(i,"fr-marker")||i.nodeType==Node.TEXT_NODE&&0===i.textContent.length)){if("BR"!=i.tagName&&0<(i.textContent||"").replace(/\u200B/gi,"").replace(/\n/g,"").length)return!1;if(r)return!1;"BR"==i.tagName&&(r=!0)}}return!(e.querySelectorAll(M.FE.VOID_ELEMENTS.join(",")).length-e.querySelectorAll("br").length||e.querySelector(a.opts.htmlAllowedEmptyTags.join(":not(.fr-marker),")+":not(.fr-marker)")||1<e.querySelectorAll(M.FE.BLOCK_TAGS.join(",")).length||e.querySelector(a.opts.htmlDoNotWrapTags.join(":not(.fr-marker),")+":not(.fr-marker)"))},blockParent:function(e){for(;e&&e.parentNode!==a.el&&(!e.parentNode||!a.node.hasClass(e.parentNode,"fr-inner"));)if(l(e=e.parentNode))return e;return null},deepestParent:function(e,t,n){if(void 0===t&&(t=[]),void 0===n&&(n=!0),t.push(a.el),0<=t.indexOf(e.parentNode)||e.parentNode&&a.node.hasClass(e.parentNode,"fr-inner")||e.parentNode&&0<=M.FE.SIMPLE_ENTER_TAGS.indexOf(e.parentNode.tagName)&&n)return null;for(;t.indexOf(e.parentNode)<0&&e.parentNode&&!a.node.hasClass(e.parentNode,"fr-inner")&&(M.FE.SIMPLE_ENTER_TAGS.indexOf(e.parentNode.tagName)<0||!n)&&(!l(e)||!l(e.parentNode)||!n);)e=e.parentNode;return e},rawAttributes:d,attributes:t,clearAttributes:function(e){for(var t=e.attributes,n=t.length-1;0<=n;n--){var r=t[n];e.removeAttribute(r.nodeName)}},openTagString:function(e){return"<"+e.tagName.toLowerCase()+t(e)+">"},closeTagString:function(e){return"</"+e.tagName.toLowerCase()+">"},isFirstSibling:function e(t,n){void 0===n&&(n=!0);for(var r=t.previousSibling;r&&n&&a.node.hasClass(r,"fr-marker");)r=r.previousSibling;return!r||r.nodeType==Node.TEXT_NODE&&""===r.textContent&&e(r)},isLastSibling:function e(t,n){void 0===n&&(n=!0);for(var r=t.nextSibling;r&&n&&a.node.hasClass(r,"fr-marker");)r=r.nextSibling;return!r||r.nodeType==Node.TEXT_NODE&&""===r.textContent&&e(r)},isList:function(e){return!!e&&0<=["UL","OL"].indexOf(e.tagName)},isLink:function(e){return!!e&&e.nodeType==Node.ELEMENT_NODE&&"a"==e.tagName.toLowerCase()},isElement:n,contents:s,isVoid:function(e){return e&&e.nodeType==Node.ELEMENT_NODE&&0<=M.FE.VOID_ELEMENTS.indexOf((e.tagName||"").toLowerCase())},hasFocus:function(e){return e===a.doc.activeElement&&(!a.doc.hasFocus||a.doc.hasFocus())&&!!(n(e)||e.type||e.href||~e.tabIndex)},isEditable:function(e){return(!e.getAttribute||"false"!=e.getAttribute("contenteditable"))&&["STYLE","SCRIPT"].indexOf(e.tagName)<0},isDeletable:function(e){return e&&e.nodeType==Node.ELEMENT_NODE&&e.getAttribute("class")&&0<=(e.getAttribute("class")||"").indexOf("fr-deletable")},hasClass:function(e,t){return e instanceof M&&(e=e.get(0)),e&&e.classList&&e.classList.contains(t)},filter:function(e){return a.browser.msie?e:{acceptNode:e}}}},M.FE.INVISIBLE_SPACE="&#8203;",M.FE.START_MARKER='<span class="fr-marker" data-id="0" data-type="true" style="display: none; line-height: 0;">'+M.FE.INVISIBLE_SPACE+"</span>",M.FE.END_MARKER='<span class="fr-marker" data-id="0" data-type="false" style="display: none; line-height: 0;">'+M.FE.INVISIBLE_SPACE+"</span>",M.FE.MARKERS=M.FE.START_MARKER+M.FE.END_MARKER,M.FE.MODULES.markers=function(d){function l(){if(!d.$wp)return null;try{var e=d.selection.ranges(0),t=e.commonAncestorContainer;if(t!=d.el&&0===d.$el.find(t).length)return null;var n=e.cloneRange(),r=e.cloneRange();n.collapse(!0);var o=M('<span class="fr-marker" style="display: none; line-height: 0;">'+M.FE.INVISIBLE_SPACE+"</span>",d.doc)[0];if(n.insertNode(o),o=d.$el.find("span.fr-marker").get(0)){for(var i=o.nextSibling;i&&i.nodeType===Node.TEXT_NODE&&0===i.textContent.length;)M(i).remove(),i=d.$el.find("span.fr-marker").get(0).nextSibling;return d.selection.clear(),d.selection.get().addRange(r),o}return null}catch(a){}}function c(){d.$el.find(".fr-marker").remove()}return{place:function(e,t,n){var r,o,i;try{var a=e.cloneRange();if(a.collapse(t),a.insertNode(M('<span class="fr-marker" data-id="'+n+'" data-type="'+t+'" style="display: '+(d.browser.safari?"none":"inline-block")+'; line-height: 0;">'+M.FE.INVISIBLE_SPACE+"</span>",d.doc)[0]),!0===t)for(i=(r=d.$el.find('span.fr-marker[data-type="true"][data-id="'+n+'"]').get(0)).nextSibling;i&&i.nodeType===Node.TEXT_NODE&&0===i.textContent.length;)M(i).remove(),i=r.nextSibling;if(!0===t&&!e.collapsed){for(;!d.node.isElement(r.parentNode)&&!i;)M(r.parentNode).after(r),i=r.nextSibling;if(i&&i.nodeType===Node.ELEMENT_NODE&&d.node.isBlock(i)&&"HR"!==i.tagName){for(o=[i];i=o[0],(o=d.node.contents(i))[0]&&d.node.isBlock(o[0]););M(i).prepend(M(r))}}if(!1===t&&!e.collapsed){if((i=(r=d.$el.find('span.fr-marker[data-type="false"][data-id="'+n+'"]').get(0)).previousSibling)&&i.nodeType===Node.ELEMENT_NODE&&d.node.isBlock(i)&&"HR"!==i.tagName){for(o=[i];i=o[o.length-1],(o=d.node.contents(i))[o.length-1]&&d.node.isBlock(o[o.length-1]););M(i).append(M(r))}r.parentNode&&0<=["TD","TH"].indexOf(r.parentNode.tagName)&&r.parentNode.previousSibling&&!r.previousSibling&&M(r.parentNode.previousSibling).append(r)}var s=d.$el.find('span.fr-marker[data-type="'+t+'"][data-id="'+n+'"]').get(0);return s&&(s.style.display="none"),s}catch(l){return null}},insert:l,split:function(){d.selection.isCollapsed()||d.selection.remove();var e=d.$el.find(".fr-marker").get(0);if(null==e&&(e=l()),null==e)return null;var t=d.node.deepestParent(e);if(t||(t=d.node.blockParent(e))&&"LI"!=t.tagName&&(t=null),t)if(d.node.isBlock(t)&&d.node.isEmpty(t))"LI"!=t.tagName||t.parentNode.firstElementChild!=t||d.node.isEmpty(t.parentNode)?M(t).replaceWith('<span class="fr-marker"></span>'):M(t).append('<span class="fr-marker"></span>');else if(d.cursor.isAtStart(e,t))M(t).before('<span class="fr-marker"></span>'),M(e).remove();else if(d.cursor.isAtEnd(e,t))M(t).after('<span class="fr-marker"></span>'),M(e).remove();else{for(var n=e,r="",o="";n=n.parentNode,r+=d.node.closeTagString(n),o=d.node.openTagString(n)+o,n!=t;);M(e).replaceWith('<span id="fr-break"></span>');var i=d.node.openTagString(t)+M(t).html()+d.node.closeTagString(t);i=i.replace(/<span id="fr-break"><\/span>/g,r+'<span class="fr-marker"></span>'+o),M(t).replaceWith(i)}return d.$el.find(".fr-marker").get(0)},insertAtPoint:function(e){var t,n=e.clientX,r=e.clientY;c();var o=null;if("undefined"!=typeof d.doc.caretPositionFromPoint?(t=d.doc.caretPositionFromPoint(n,r),(o=d.doc.createRange()).setStart(t.offsetNode,t.offset),o.setEnd(t.offsetNode,t.offset)):"undefined"!=typeof d.doc.caretRangeFromPoint&&(t=d.doc.caretRangeFromPoint(n,r),(o=d.doc.createRange()).setStart(t.startContainer,t.startOffset),o.setEnd(t.startContainer,t.startOffset)),null!==o&&"undefined"!=typeof d.win.getSelection){var i=d.win.getSelection();i.removeAllRanges(),i.addRange(o)}else if("undefined"!=typeof d.doc.body.createTextRange)try{(o=d.doc.body.createTextRange()).moveToPoint(n,r);var a=o.duplicate();a.moveToPoint(n,r),o.setEndPoint("EndToEnd",a),o.select()}catch(s){return!1}l()},remove:c}},M.FE.MODULES.selection=function(S){function s(){var e="";return S.win.getSelection?e=S.win.getSelection():S.doc.getSelection?e=S.doc.getSelection():S.doc.selection&&(e=S.doc.selection.createRange().text),e.toString()}function T(){return S.win.getSelection?S.win.getSelection():S.doc.getSelection?S.doc.getSelection():S.doc.selection.createRange()}function c(e){var t=T(),n=[];if(t&&t.getRangeAt&&t.rangeCount){n=[];for(var r=0;r<t.rangeCount;r++)n.push(t.getRangeAt(r))}else n=S.doc.createRange?[S.doc.createRange()]:[];return void 0!==e?n[e]:n}function y(){var e=T();try{e.removeAllRanges?e.removeAllRanges():e.empty?e.empty():e.clear&&e.clear()}catch(t){}}function f(e,t){var n=e;return n.nodeType==Node.ELEMENT_NODE&&0<n.childNodes.length&&n.childNodes[t]&&(n=n.childNodes[t]),n.nodeType==Node.TEXT_NODE&&(n=n.parentNode),n}function N(){if(S.$wp){S.markers.remove();var e,t,n=c(),r=[];for(t=0;t<n.length;t++)if(n[t].startContainer!==S.doc||S.browser.msie){var o=(e=n[t]).collapsed,i=S.markers.place(e,!0,t),a=S.markers.place(e,!1,t);if(void 0!==i&&i||!o||(M(".fr-marker").remove(),S.selection.setAtEnd(S.el)),S.el.normalize(),S.browser.safari&&!o)try{(e=S.doc.createRange()).setStartAfter(i),e.setEndBefore(a),r.push(e)}catch(s){}}if(S.browser.safari&&r.length)for(S.selection.clear(),t=0;t<r.length;t++)S.selection.get().addRange(r[t])}}function C(){var e,t=S.el.querySelectorAll('.fr-marker[data-type="true"]');if(!S.$wp)return S.markers.remove(),!1;if(0===t.length)return!1;if(S.browser.msie||S.browser.edge)for(e=0;e<t.length;e++)t[e].style.display="inline-block";S.core.hasFocus()||S.browser.msie||S.browser.webkit||S.$el.focus(),y();var n=T();for(e=0;e<t.length;e++){var r=M(t[e]).data("id"),o=t[e],i=S.doc.createRange(),a=S.$el.find('.fr-marker[data-type="false"][data-id="'+r+'"]');(S.browser.msie||S.browser.edge)&&a.css("display","inline-block");var s=null;if(0<a.length){a=a[0];try{for(var l,d=!1,c=o.nextSibling;c&&c.nodeType==Node.TEXT_NODE&&0===c.textContent.length;)c=(l=c).nextSibling,M(l).remove();for(var f,p,u=a.nextSibling;u&&u.nodeType==Node.TEXT_NODE&&0===u.textContent.length;)u=(l=u).nextSibling,M(l).remove();if(o.nextSibling==a||a.nextSibling==o){for(var g=o.nextSibling==a?o:a,h=g==o?a:o,m=g.previousSibling;m&&m.nodeType==Node.TEXT_NODE&&0===m.length;)m=(l=m).previousSibling,M(l).remove();if(m&&m.nodeType==Node.TEXT_NODE)for(;m&&m.previousSibling&&m.previousSibling.nodeType==Node.TEXT_NODE;)m.previousSibling.textContent=m.previousSibling.textContent+m.textContent,m=m.previousSibling,M(m.nextSibling).remove();for(var E=h.nextSibling;E&&E.nodeType==Node.TEXT_NODE&&0===E.length;)E=(l=E).nextSibling,M(l).remove();if(E&&E.nodeType==Node.TEXT_NODE)for(;E&&E.nextSibling&&E.nextSibling.nodeType==Node.TEXT_NODE;)E.nextSibling.textContent=E.textContent+E.nextSibling.textContent,E=E.nextSibling,M(E.previousSibling).remove();if(m&&(S.node.isVoid(m)||S.node.isBlock(m))&&(m=null),E&&(S.node.isVoid(E)||S.node.isBlock(E))&&(E=null),m&&E&&m.nodeType==Node.TEXT_NODE&&E.nodeType==Node.TEXT_NODE){M(o).remove(),M(a).remove();var v=m.textContent.length;m.textContent=m.textContent+E.textContent,M(E).remove(),S.opts.htmlUntouched||S.spaces.normalize(m),i.setStart(m,v),i.setEnd(m,v),d=!0}else!m&&E&&E.nodeType==Node.TEXT_NODE?(M(o).remove(),M(a).remove(),S.opts.htmlUntouched||S.spaces.normalize(E),s=M(S.doc.createTextNode("\u200b")),M(E).before(s),i.setStart(E,0),i.setEnd(E,0),d=!0):!E&&m&&m.nodeType==Node.TEXT_NODE&&(M(o).remove(),M(a).remove(),S.opts.htmlUntouched||S.spaces.normalize(m),s=M(S.doc.createTextNode("\u200b")),M(m).after(s),i.setStart(m,m.textContent.length),i.setEnd(m,m.textContent.length),d=!0)}if(!d)(S.browser.chrome||S.browser.edge)&&o.nextSibling==a?(f=A(a,i,!0)||i.setStartAfter(a),p=A(o,i,!1)||i.setEndBefore(o)):(o.previousSibling==a&&(a=(o=a).nextSibling),a.nextSibling&&"BR"===a.nextSibling.tagName||!a.nextSibling&&S.node.isBlock(o.previousSibling)||o.previousSibling&&"BR"==o.previousSibling.tagName||(o.style.display="inline",a.style.display="inline",s=M(S.doc.createTextNode("\u200b"))),f=A(o,i,!0)||M(o).before(s)&&i.setStartBefore(o),p=A(a,i,!1)||M(a).after(s)&&i.setEndAfter(a)),"function"==typeof f&&f(),"function"==typeof p&&p()}catch(b){}}s&&s.remove();try{n.addRange(i)}catch(b){}}S.markers.remove()}function A(e,t,n){var r,o=e.previousSibling,i=e.nextSibling;return o&&i&&o.nodeType==Node.TEXT_NODE&&i.nodeType==Node.TEXT_NODE?(r=o.textContent.length,n?(i.textContent=o.textContent+i.textContent,M(o).remove(),M(e).remove(),S.opts.htmlUntouched||S.spaces.normalize(i),function(){t.setStart(i,r)}):(o.textContent=o.textContent+i.textContent,M(i).remove(),M(e).remove(),S.opts.htmlUntouched||S.spaces.normalize(o),function(){t.setEnd(o,r)})):o&&!i&&o.nodeType==Node.TEXT_NODE?(r=o.textContent.length,n?(S.opts.htmlUntouched||S.spaces.normalize(o),function(){t.setStart(o,r)}):(S.opts.htmlUntouched||S.spaces.normalize(o),function(){t.setEnd(o,r)})):!(!i||o||i.nodeType!=Node.TEXT_NODE)&&(n?(S.opts.htmlUntouched||S.spaces.normalize(i),function(){t.setStart(i,0)}):(S.opts.htmlUntouched||S.spaces.normalize(i),function(){t.setEnd(i,0)}))}function x(){for(var e=c(),t=0;t<e.length;t++)if(!e[t].collapsed)return!1;return!0}function o(e){var t,n,r=!1,o=!1;if(S.win.getSelection){var i=S.win.getSelection();i.rangeCount&&((n=(t=i.getRangeAt(0)).cloneRange()).selectNodeContents(e),n.setEnd(t.startContainer,t.startOffset),r=""===n.toString(),n.selectNodeContents(e),n.setStart(t.endContainer,t.endOffset),o=""===n.toString())}else S.doc.selection&&"Control"!=S.doc.selection.type&&((n=(t=S.doc.selection.createRange()).duplicate()).moveToElementText(e),n.setEndPoint("EndToStart",t),r=""===n.text,n.moveToElementText(e),n.setEndPoint("StartToEnd",t),o=""===n.text);return{atStart:r,atEnd:o}}function $(e,t){void 0===t&&(t=!0);var n=M(e).html();n&&n.replace(/\u200b/g,"").length!=n.length&&M(e).html(n.replace(/\u200b/g,""));for(var r=S.node.contents(e),o=0;o<r.length;o++)r[o].nodeType!=Node.ELEMENT_NODE?M(r[o]).remove():($(r[o],0===o),0===o&&(t=!1));e.nodeType==Node.TEXT_NODE?M(e).replaceWith('<span data-first="true" data-text="true"></span>'):t&&M(e).attr("data-first",!0)}function O(){return 0===M(this).find("fr-inner").length}function p(){try{if(!S.$wp)return!1;for(var e=c(0).commonAncestorContainer;e&&!S.node.isElement(e);)e=e.parentNode;return!!S.node.isElement(e)}catch(t){return!1}}function r(e,t){if(!e||0<e.getElementsByClassName("fr-marker").length)return!1;for(var n=e.firstChild;n&&(S.node.isBlock(n)||t&&!S.node.isVoid(n)&&n.nodeType==Node.ELEMENT_NODE);)n=(e=n).firstChild;e.innerHTML=M.FE.MARKERS+e.innerHTML}function i(e,t){if(!e||0<e.getElementsByClassName("fr-marker").length)return!1;for(var n=e.lastChild;n&&(S.node.isBlock(n)||t&&!S.node.isVoid(n)&&n.nodeType==Node.ELEMENT_NODE);)n=(e=n).lastChild;var r=S.doc.createElement("SPAN");r.setAttribute("id","fr-sel-markers"),r.innerHTML=M.FE.MARKERS,e.appendChild(r);var o=e.querySelector("#fr-sel-markers");o.outerHTML=o.innerHTML}return{text:s,get:T,ranges:c,clear:y,element:function(){var e=T();try{if(e.rangeCount){var t,n=c(0),r=n.startContainer;if(r.nodeType==Node.TEXT_NODE&&n.startOffset==(r.textContent||"").length&&r.nextSibling&&(r=r.nextSibling),r.nodeType==Node.ELEMENT_NODE){var o=!1;if(0<r.childNodes.length&&r.childNodes[n.startOffset]){for(t=r.childNodes[n.startOffset];t&&t.nodeType==Node.TEXT_NODE&&0===t.textContent.length;)t=t.nextSibling;if(t&&t.textContent.replace(/\u200B/g,"")===s().replace(/\u200B/g,"")&&(r=t,o=!0),!o&&1<r.childNodes.length&&0<n.startOffset&&r.childNodes[n.startOffset-1]){for(t=r.childNodes[n.startOffset-1];t&&t.nodeType==Node.TEXT_NODE&&0===t.textContent.length;)t=t.nextSibling;t&&t.textContent.replace(/\u200B/g,"")===s().replace(/\u200B/g,"")&&(r=t,o=!0)}}else!n.collapsed&&r.nextSibling&&r.nextSibling.nodeType==Node.ELEMENT_NODE&&(t=r.nextSibling)&&t.textContent.replace(/\u200B/g,"")===s().replace(/\u200B/g,"")&&(r=t,o=!0);!o&&0<r.childNodes.length&&M(r.childNodes[0]).text().replace(/\u200B/g,"")===s().replace(/\u200B/g,"")&&["BR","IMG","HR"].indexOf(r.childNodes[0].tagName)<0&&(r=r.childNodes[0])}for(;r.nodeType!=Node.ELEMENT_NODE&&r.parentNode;)r=r.parentNode;for(var i=r;i&&"HTML"!=i.tagName;){if(i==S.el)return r;i=M(i).parent()[0]}}}catch(a){}return S.el},endElement:function(){var e=T();try{if(e.rangeCount){var t,n=c(0),r=n.endContainer;if(r.nodeType==Node.ELEMENT_NODE){var o=!1;0<r.childNodes.length&&r.childNodes[n.endOffset]&&M(r.childNodes[n.endOffset]).text()===s()?(r=r.childNodes[n.endOffset],o=!0):!n.collapsed&&r.previousSibling&&r.previousSibling.nodeType==Node.ELEMENT_NODE?(t=r.previousSibling)&&t.textContent.replace(/\u200B/g,"")===s().replace(/\u200B/g,"")&&(r=t,o=!0):!n.collapsed&&0<r.childNodes.length&&r.childNodes[n.endOffset]&&(t=r.childNodes[n.endOffset].previousSibling).nodeType==Node.ELEMENT_NODE&&t&&t.textContent.replace(/\u200B/g,"")===s().replace(/\u200B/g,"")&&(r=t,o=!0),!o&&0<r.childNodes.length&&M(r.childNodes[r.childNodes.length-1]).text()===s()&&["BR","IMG","HR"].indexOf(r.childNodes[r.childNodes.length-1].tagName)<0&&(r=r.childNodes[r.childNodes.length-1])}for(r.nodeType==Node.TEXT_NODE&&0===n.endOffset&&r.previousSibling&&r.previousSibling.nodeType==Node.ELEMENT_NODE&&(r=r.previousSibling);r.nodeType!=Node.ELEMENT_NODE&&r.parentNode;)r=r.parentNode;for(var i=r;i&&"HTML"!=i.tagName;){if(i==S.el)return r;i=M(i).parent()[0]}}}catch(a){}return S.el},save:N,restore:C,isCollapsed:x,isFull:function(){if(x())return!1;S.selection.save();var e,t=S.el.querySelectorAll("td, th, img, br");for(e=0;e<t.length;e++)t[e].nextSibling&&(t[e].innerHTML='<span class="fr-mk">'+M.FE.INVISIBLE_SPACE+"</span>"+t[e].innerHTML);var n=!1,r=o(S.el);for(r.atStart&&r.atEnd&&(n=!0),t=S.el.querySelectorAll(".fr-mk"),e=0;e<t.length;e++)t[e].parentNode.removeChild(t[e]);return S.selection.restore(),n},inEditor:p,remove:function(){if(x())return!0;var t;N();var n=function(e){for(var t=e.previousSibling;t&&t.nodeType==Node.TEXT_NODE&&0===t.textContent.length;){var n=t;t=t.previousSibling,M(n).remove()}return t},r=function(e){for(var t=e.nextSibling;t&&t.nodeType==Node.TEXT_NODE&&0===t.textContent.length;){var n=t;t=t.nextSibling,M(n).remove()}return t},o=S.$el.find('.fr-marker[data-type="true"]');for(t=0;t<o.length;t++)for(var i=o[t];!(n(i)||S.node.isBlock(i.parentNode)||S.$el.is(i.parentNode)||S.node.hasClass(i.parentNode,"fr-inner"));)M(i.parentNode).before(i);var a=S.$el.find('.fr-marker[data-type="false"]');for(t=0;t<a.length;t++){for(var s=a[t];!(r(s)||S.node.isBlock(s.parentNode)||S.$el.is(s.parentNode)||S.node.hasClass(s.parentNode,"fr-inner"));)M(s.parentNode).after(s);s.parentNode&&S.node.isBlock(s.parentNode)&&S.node.isEmpty(s.parentNode)&&!S.$el.is(s.parentNode)&&!S.node.hasClass(s.parentNode,"fr-inner")&&S.opts.keepFormatOnDelete&&M(s.parentNode).after(s)}if(function(){for(var e=S.$el.find(".fr-marker"),t=0;t<e.length;t++)if(M(e[t]).parentsUntil('.fr-element, [contenteditable="true"]','[contenteditable="false"]').length)return!1;return!0}()){!function e(t,n){var r=S.node.contents(t.get(0));0<=["TD","TH"].indexOf(t.get(0).tagName)&&1==t.find(".fr-marker").length&&S.node.hasClass(r[0],"fr-marker")&&t.attr("data-del-cell",!0);for(var o=0;o<r.length;o++){var i=r[o];S.node.hasClass(i,"fr-marker")?n=(n+1)%2:n?0<M(i).find(".fr-marker").length?n=e(M(i),n):["TD","TH"].indexOf(i.tagName)<0&&!S.node.hasClass(i,"fr-inner")?!S.opts.keepFormatOnDelete||0<S.$el.find("[data-first]").length||S.node.isVoid(i)?M(i).remove():$(i):S.node.hasClass(i,"fr-inner")?0===M(i).find(".fr-inner").length?M(i).html("<br>"):M(i).find(".fr-inner").filter(O).html("<br>"):(M(i).empty(),M(i).attr("data-del-cell",!0)):0<M(i).find(".fr-marker").length&&(n=e(M(i),n))}return n}(S.$el,0);var l=S.$el.find('[data-first="true"]');if(l.length)S.$el.find(".fr-marker").remove(),l.append(M.FE.INVISIBLE_SPACE+M.FE.MARKERS).removeAttr("data-first"),l.attr("data-text")&&l.replaceWith(l.html());else for(S.$el.find("table").filter(function(){return 0<M(this).find("[data-del-cell]").length&&M(this).find("[data-del-cell]").length==M(this).find("td, th").length}).remove(),S.$el.find("[data-del-cell]").removeAttr("data-del-cell"),o=S.$el.find('.fr-marker[data-type="true"]'),t=0;t<o.length;t++){var d=o[t],c=d.nextSibling,f=S.$el.find('.fr-marker[data-type="false"][data-id="'+M(d).data("id")+'"]').get(0);if(f){if(d&&(!c||c!=f)){var p=S.node.blockParent(d),u=S.node.blockParent(f),g=!1,h=!1;if(p&&0<=["UL","OL"].indexOf(p.tagName)&&(g=!(p=null)),u&&0<=["UL","OL"].indexOf(u.tagName)&&(h=!(u=null)),M(d).after(f),p!=u)if(null!=p||g)if(null!=u||h||0!==M(p).parentsUntil(S.$el,"table").length)p&&u&&0===M(p).parentsUntil(S.$el,"table").length&&0===M(u).parentsUntil(S.$el,"table").length&&0===M(p).find(u).length&&0===M(u).find(p).length&&(M(p).append(M(u).html()),M(u).remove());else{for(c=p;!c.nextSibling&&c.parentNode!=S.el;)c=c.parentNode;for(c=c.nextSibling;c&&"BR"!=c.tagName;){var m=c.nextSibling;M(p).append(c),c=m}c&&"BR"==c.tagName&&M(c).remove()}else{var E=S.node.deepestParent(d);E?(M(E).after(M(u).html()),M(u).remove()):0===M(u).parentsUntil(S.$el,"table").length&&(M(d).next().after(M(u).html()),M(u).remove())}}}else f=M(d).clone().attr("data-type",!1),M(d).after(f)}}S.$el.find("li:empty").remove(),S.opts.keepFormatOnDelete||S.html.fillEmptyBlocks(),S.html.cleanEmptyTags(!0),S.opts.htmlUntouched||(S.clean.lists(),S.$el.find("li:empty").append("<br>"),S.spaces.normalize());var v=S.$el.find(".fr-marker:last").get(0),b=S.$el.find(".fr-marker:first").get(0);void 0!==v&&void 0!==b&&!v.nextSibling&&b.previousSibling&&"BR"==b.previousSibling.tagName&&S.node.isElement(v.parentNode)&&S.node.isElement(b.parentNode)&&S.$el.append("<br>"),C()},blocks:function(){var e,t=[],n=T();if(p()&&n.rangeCount){var r=c();for(e=0;e<r.length;e++){var o,i=r[e],a=f(i.startContainer,i.startOffset),s=f(i.endContainer,i.endOffset);(S.node.isBlock(a)||S.node.hasClass(a,"fr-inner"))&&t.indexOf(a)<0&&t.push(a),(o=S.node.blockParent(a))&&t.indexOf(o)<0&&t.push(o);for(var l=[],d=a;d!==s&&d!==S.el;)l.indexOf(d)<0&&d.children&&d.children.length?(l.push(d),d=d.children[0]):d.nextSibling?d=d.nextSibling:d.parentNode&&(d=d.parentNode,l.push(d)),S.node.isBlock(d)&&l.indexOf(d)<0&&t.indexOf(d)<0&&(d!==s||0<i.endOffset)&&t.push(d);S.node.isBlock(s)&&t.indexOf(s)<0&&0<i.endOffset&&t.push(s),(o=S.node.blockParent(s))&&t.indexOf(o)<0&&t.push(o)}}for(e=t.length-1;0<e;e--)M(t[e]).find(t).length&&t.splice(e,1);return t},info:o,setAtEnd:i,setAtStart:r,setBefore:function(e,t){void 0===t&&(t=!0);for(var n=e.previousSibling;n&&n.nodeType==Node.TEXT_NODE&&0===n.textContent.length;)n=n.previousSibling;return n?(S.node.isBlock(n)?i(n):"BR"==n.tagName?M(n).before(M.FE.MARKERS):M(n).after(M.FE.MARKERS),!0):!!t&&(S.node.isBlock(e)?r(e):M(e).before(M.FE.MARKERS),!0)},setAfter:function(e,t){void 0===t&&(t=!0);for(var n=e.nextSibling;n&&n.nodeType==Node.TEXT_NODE&&0===n.textContent.length;)n=n.nextSibling;return n?(S.node.isBlock(n)?r(n):M(n).before(M.FE.MARKERS),!0):!!t&&(S.node.isBlock(e)?i(e):M(e).after(M.FE.MARKERS),!0)},rangeElement:f}},M.extend(M.FE.DEFAULTS,{htmlAllowedTags:["a","abbr","address","area","article","aside","audio","b","base","bdi","bdo","blockquote","br","button","canvas","caption","cite","code","col","colgroup","datalist","dd","del","details","dfn","dialog","div","dl","dt","em","embed","fieldset","figcaption","figure","footer","form","h1","h2","h3","h4","h5","h6","header","hgroup","hr","i","iframe","img","input","ins","kbd","keygen","label","legend","li","link","main","map","mark","menu","menuitem","meter","nav","noscript","object","ol","optgroup","option","output","p","param","pre","progress","queue","rp","rt","ruby","s","samp","script","style","section","select","small","source","span","strike","strong","sub","summary","sup","table","tbody","td","textarea","tfoot","th","thead","time","tr","track","u","ul","var","video","wbr"],htmlRemoveTags:["script","style"],htmlAllowedAttrs:["accept","accept-charset","accesskey","action","align","allowfullscreen","allowtransparency","alt","async","autocomplete","autofocus","autoplay","autosave","background","bgcolor","border","charset","cellpadding","cellspacing","checked","cite","class","color","cols","colspan","content","contenteditable","contextmenu","controls","coords","data","data-.*","datetime","default","defer","dir","dirname","disabled","download","draggable","dropzone","enctype","for","form","formaction","frameborder","headers","height","hidden","high","href","hreflang","http-equiv","icon","id","ismap","itemprop","keytype","kind","label","lang","language","list","loop","low","max","maxlength","media","method","min","mozallowfullscreen","multiple","muted","name","novalidate","open","optimum","pattern","ping","placeholder","playsinline","poster","preload","pubdate","radiogroup","readonly","rel","required","reversed","rows","rowspan","sandbox","scope","scoped","scrolling","seamless","selected","shape","size","sizes","span","src","srcdoc","srclang","srcset","start","step","summary","spellcheck","style","tabindex","target","title","type","translate","usemap","value","valign","webkitallowfullscreen","width","wrap"],htmlAllowedStyleProps:[".*"],htmlAllowComments:!0,htmlUntouched:!1,fullPage:!1}),M.FE.HTML5Map={B:"STRONG",I:"EM",STRIKE:"S"},M.FE.MODULES.clean=function(c){var f,p,u,g;function o(e){if(e.nodeType==Node.ELEMENT_NODE&&e.getAttribute("class")&&0<=e.getAttribute("class").indexOf("fr-marker"))return!1;var t,n=c.node.contents(e),r=[];for(t=0;t<n.length;t++)n[t].nodeType!=Node.ELEMENT_NODE||c.node.isVoid(n[t])?n[t].nodeType==Node.TEXT_NODE&&(n[t].textContent=n[t].textContent.replace(/\u200b/g,"")):n[t].textContent.replace(/\u200b/g,"").length!=n[t].textContent.length&&o(n[t]);if(e.nodeType==Node.ELEMENT_NODE&&!c.node.isVoid(e)&&(e.normalize(),n=c.node.contents(e),r=e.querySelectorAll(".fr-marker"),n.length-r.length==0)){for(t=0;t<n.length;t++)if(n[t].nodeType==Node.ELEMENT_NODE&&(n[t].getAttribute("class")||"").indexOf("fr-marker")<0)return!1;for(t=0;t<r.length;t++)e.parentNode.insertBefore(r[t].cloneNode(!0),e);return e.parentNode.removeChild(e),!1}}function s(e,t){if(e.nodeType==Node.COMMENT_NODE)return"\x3c!--"+e.nodeValue+"--\x3e";if(e.nodeType==Node.TEXT_NODE)return t?e.textContent.replace(/\&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;"):e.textContent.replace(/\&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\u00A0/g,"&nbsp;").replace(/\u0009/g,"");if(e.nodeType!=Node.ELEMENT_NODE)return e.outerHTML;if(e.nodeType==Node.ELEMENT_NODE&&0<=["STYLE","SCRIPT","NOSCRIPT"].indexOf(e.tagName))return e.outerHTML;if(e.nodeType==Node.ELEMENT_NODE&&"svg"==e.tagName){var n=document.createElement("div"),r=e.cloneNode(!0);return n.appendChild(r),n.innerHTML}if("IFRAME"==e.tagName)return e.outerHTML.replace(/\&lt;/g,"<").replace(/\&gt;/g,">");var o=e.childNodes;if(0===o.length)return e.outerHTML;for(var i="",a=0;a<o.length;a++)"PRE"==e.tagName&&(t=!0),i+=s(o[a],t);return c.node.openTagString(e)+i+c.node.closeTagString(e)}var a=[];function h(e){var t=e.replace(/;;/gi,";");return";"!=(t=t.replace(/^;/gi,"")).charAt(t.length)&&(t+=";"),t}function l(e){var t;for(t in e)if(e.hasOwnProperty(t)){var n=t.match(u),r=null;"style"==t&&c.opts.htmlAllowedStyleProps.length&&(r=e[t].match(g)),n&&r?e[t]=h(r.join(";")):n&&("style"!=t||r)||delete e[t]}for(var o="",i=Object.keys(e).sort(),a=0;a<i.length;a++)e[t=i[a]].indexOf('"')<0?o+=" "+t+'="'+e[t]+'"':o+=" "+t+"='"+e[t]+"'";return o}function d(e,t){var n,r=document.implementation.createHTMLDocument("Froala DOC").createElement("DIV");M(r).append(e);var o="";if(r){var i=c.node.contents(r);for(n=0;n<i.length;n++)t(i[n]);for(i=c.node.contents(r),n=0;n<i.length;n++)o+=s(i[n])}return o}function m(e,t,n){a=[];var r=e=e.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,function(e){return a.push(e),"[FROALA.EDITOR.SCRIPT "+(a.length-1)+"]"}).replace(/<noscript\b[^<]*(?:(?!<\/noscript>)<[^<]*)*<\/noscript>/gi,function(e){return a.push(e),"[FROALA.EDITOR.NOSCRIPT "+(a.length-1)+"]"}).replace(/<meta((?:[\w\W]*?)) http-equiv="/g,'<meta$1 data-fr-http-equiv="').replace(/<img((?:[\w\W]*?)) src="/g,'<img$1 data-fr-src="'),o=null;c.opts.fullPage&&(r=c.html.extractNode(e,"body")||(0<=e.indexOf("<body")?"":e),n&&(o=c.html.extractNode(e,"head")||"")),r=d(r,t),o&&(o=d(o,t));var i=function(e,t,n){if(c.opts.fullPage){var r=c.html.extractDoctype(n),o=l(c.html.extractNodeAttrs(n,"html"));return t=null==t?c.html.extractNode(n,"head")||"<title></title>":t,r+"<html"+o+"><head"+l(c.html.extractNodeAttrs(n,"head"))+">"+t+"</head><body"+l(c.html.extractNodeAttrs(n,"body"))+">"+e+"</body></html>"}return e}(r,o,e);return i.replace(/\[FROALA\.EDITOR\.SCRIPT ([\d]*)\]/gi,function(e,t){return 0<=c.opts.htmlRemoveTags.indexOf("script")?"":a[parseInt(t,10)]}).replace(/\[FROALA\.EDITOR\.NOSCRIPT ([\d]*)\]/gi,function(e,t){return 0<=c.opts.htmlRemoveTags.indexOf("noscript")?"":a[parseInt(t,10)].replace(/\&lt;/g,"<").replace(/\&gt;/g,">")}).replace(/<img((?:[\w\W]*?)) data-fr-src="/g,'<img$1 src="')}function E(e){var t=c.doc.createElement("DIV");return t.innerText=e,t.textContent}function v(e){for(var t=c.node.contents(e),n=0;n<t.length;n++)t[n].nodeType!=Node.TEXT_NODE&&v(t[n]);!function(e){if("SPAN"==e.tagName&&0<=(e.getAttribute("class")||"").indexOf("fr-marker"))return;var t,n;if("PRE"==e.tagName&&0<=(n=(t=e).innerHTML).indexOf("\n")&&(t.innerHTML=n.replace(/\n/g,"<br>")),e.nodeType==Node.ELEMENT_NODE&&(e.getAttribute("data-fr-src")&&0!==e.getAttribute("data-fr-src").indexOf("blob:")&&e.setAttribute("data-fr-src",c.helpers.sanitizeURL(E(e.getAttribute("data-fr-src")))),e.getAttribute("href")&&e.setAttribute("href",c.helpers.sanitizeURL(E(e.getAttribute("href")))),e.getAttribute("src")&&e.setAttribute("src",c.helpers.sanitizeURL(E(e.getAttribute("src")))),0<=["TABLE","TBODY","TFOOT","TR"].indexOf(e.tagName)&&(e.innerHTML=e.innerHTML.trim())),!c.opts.pasteAllowLocalImages&&e.nodeType==Node.ELEMENT_NODE&&"IMG"==e.tagName&&e.getAttribute("data-fr-src")&&0===e.getAttribute("data-fr-src").indexOf("file://"))return e.parentNode.removeChild(e);if(e.nodeType==Node.ELEMENT_NODE&&M.FE.HTML5Map[e.tagName]&&""===c.node.attributes(e)){var r=M.FE.HTML5Map[e.tagName],o="<"+r+">"+e.innerHTML+"</"+r+">";e.insertAdjacentHTML("beforebegin",o),(e=e.previousSibling).parentNode.removeChild(e.nextSibling)}if(c.opts.htmlAllowComments||e.nodeType!=Node.COMMENT_NODE)if(e.tagName&&e.tagName.match(p))e.parentNode.removeChild(e);else if(e.tagName&&!e.tagName.match(f))"svg"===e.tagName?e.parentNode.removeChild(e):c.browser.safari&&"path"==e.tagName&&e.parentNode&&"svg"==e.parentNode.tagName||(e.outerHTML=e.innerHTML);else{var i=e.attributes;if(i)for(var a=i.length-1;0<=a;a--){var s=i[a],l=s.nodeName.match(u),d=null;"style"==s.nodeName&&c.opts.htmlAllowedStyleProps.length&&(d=s.value.match(g)),l&&d?s.value=h(d.join(";")):l&&("style"!=s.nodeName||d)||e.removeAttribute(s.nodeName)}}else 0!==e.data.indexOf("[FROALA.EDITOR")&&e.parentNode.removeChild(e)}(e)}return{_init:function(){c.opts.fullPage&&M.merge(c.opts.htmlAllowedTags,["head","title","style","link","base","body","html","meta"])},html:function(e,t,n,r){void 0===t&&(t=[]),void 0===n&&(n=[]),void 0===r&&(r=!1);var o,i=M.merge([],c.opts.htmlAllowedTags);for(o=0;o<t.length;o++)0<=i.indexOf(t[o])&&i.splice(i.indexOf(t[o]),1);var a=M.merge([],c.opts.htmlAllowedAttrs);for(o=0;o<n.length;o++)0<=a.indexOf(n[o])&&a.splice(a.indexOf(n[o]),1);return a.push("data-fr-.*"),a.push("fr-.*"),f=new RegExp("^"+i.join("$|^")+"$","gi"),u=new RegExp("^"+a.join("$|^")+"$","gi"),p=new RegExp("^"+c.opts.htmlRemoveTags.join("$|^")+"$","gi"),g=c.opts.htmlAllowedStyleProps.length?new RegExp("((^|;|\\s)"+c.opts.htmlAllowedStyleProps.join(":.+?(?=;|$))|((^|;|\\s)")+":.+?(?=(;)|$))","gi"):null,e=m(e,v,!0)},toHTML5:function(){var e=c.el.querySelectorAll(Object.keys(M.FE.HTML5Map).join(","));if(e.length){var t=!1;c.el.querySelector(".fr-marker")||(c.selection.save(),t=!0);for(var n=0;n<e.length;n++)""===c.node.attributes(e[n])&&M(e[n]).replaceWith("<"+M.FE.HTML5Map[e[n].tagName]+">"+e[n].innerHTML+"</"+M.FE.HTML5Map[e[n].tagName]+">");t&&c.selection.restore()}},tables:function(){!function(){for(var e=c.el.querySelectorAll("tr"),t=0;t<e.length;t++){for(var n=e[t].children,r=!0,o=0;o<n.length;o++)if("TH"!=n[o].tagName){r=!1;break}if(!1!==r&&0!==n.length){for(var i=e[t];i&&"TABLE"!=i.tagName&&"THEAD"!=i.tagName;)i=i.parentNode;var a=i;"THEAD"!=a.tagName&&(a=c.doc.createElement("THEAD"),i.insertBefore(a,i.firstChild)),a.appendChild(e[t])}}}()},lists:function(){!function(){var e,t=[];do{if(t.length){var n=t[0],r=c.doc.createElement("ul");n.parentNode.insertBefore(r,n);do{var o=n;n=n.nextSibling,r.appendChild(o)}while(n&&"LI"==n.tagName)}t=[];for(var i=c.el.querySelectorAll("li"),a=0;a<i.length;a++)e=i[a],c.node.isList(e.parentNode)||t.push(i[a])}while(0<t.length)}(),function(){for(var e=c.el.querySelectorAll("ol + ol, ul + ul"),t=0;t<e.length;t++){var n=e[t];if(c.node.isList(n.previousSibling)&&c.node.openTagString(n)==c.node.openTagString(n.previousSibling)){for(var r=c.node.contents(n),o=0;o<r.length;o++)n.previousSibling.appendChild(r[o]);n.parentNode.removeChild(n)}}}(),function(){for(var e=c.el.querySelectorAll("ul, ol"),t=0;t<e.length;t++)for(var n=c.node.contents(e[t]),r=null,o=n.length-1;0<=o;o--)"LI"!=n[o].tagName?(r||(r=M("<li>")).insertBefore(n[o]),r.prepend(n[o])):r=null}(),function(){var e,t,n;do{t=!1;var r=c.el.querySelectorAll("li:empty");for(e=0;e<r.length;e++)r[e].parentNode.removeChild(r[e]);var o=c.el.querySelectorAll("ul, ol");for(e=0;e<o.length;e++)(n=o[e]).querySelector("LI")||(t=!0,n.parentNode.removeChild(n))}while(!0===t)}(),function(){for(var e=c.el.querySelectorAll("ul > ul, ol > ol, ul > ol, ol > ul"),t=0;t<e.length;t++){var n=e[t],r=n.previousSibling;r&&("LI"==r.tagName?r.appendChild(n):M(n).wrap("<li></li>"))}}(),function(){for(var e=c.el.querySelectorAll("li > ul, li > ol"),t=0;t<e.length;t++){var n=e[t];if(n.nextSibling){var r=n.nextSibling,o=M("<li>");M(n.parentNode).after(o);do{var i=r;r=r.nextSibling,o.append(i)}while(r)}}}(),function(){for(var e=c.el.querySelectorAll("li > ul, li > ol"),t=0;t<e.length;t++){var n=e[t];if(c.node.isFirstSibling(n))M(n).before("<br/>");else if(n.previousSibling&&"BR"==n.previousSibling.tagName){for(var r=n.previousSibling.previousSibling;r&&c.node.hasClass(r,"fr-marker");)r=r.previousSibling;r&&"BR"!=r.tagName&&M(n.previousSibling).remove()}}}(),function(){for(var e=c.el.querySelectorAll("li:empty"),t=0;t<e.length;t++)M(e[t]).remove()}()},invisibleSpaces:function(e){return e.replace(/\u200b/g,"").length==e.length?e:c.clean.exec(e,o)},exec:m}},M.FE.MODULES.spaces=function(l){function r(e,t){var n=e.previousSibling,r=e.nextSibling,o=e.textContent,i=e.parentNode;if(!l.html.isPreformatted(i)){t&&(o=o.replace(/[\f\n\r\t\v ]{2,}/g," "),r&&"BR"!==r.tagName&&!l.node.isBlock(r)||!(l.node.isBlock(i)||l.node.isLink(i)&&!i.nextSibling||l.node.isElement(i))||(o=o.replace(/[\f\n\r\t\v ]{1,}$/g,"")),n&&"BR"!==n.tagName&&!l.node.isBlock(n)||!(l.node.isBlock(i)||l.node.isLink(i)&&!i.previousSibling||l.node.isElement(i))||(o=o.replace(/^[\f\n\r\t\v ]{1,}/g,""))," "===o&&(n&&l.node.isVoid(n)||r&&l.node.isVoid(r))&&(o="")),(!n&&l.node.isBlock(r)||!r&&l.node.isBlock(n))&&l.node.isBlock(i)&&(o=o.replace(/^[\f\n\r\t\v ]{1,}/g,"")),t||(o=o.replace(new RegExp(M.FE.UNICODE_NBSP,"g")," "));for(var a="",s=0;s<o.length;s++)32!=o.charCodeAt(s)||0!==s&&32!=a.charCodeAt(s-1)?a+=o[s]:a+=M.FE.UNICODE_NBSP;(!r||r&&l.node.isBlock(r)||r&&r.nodeType==Node.ELEMENT_NODE&&l.win.getComputedStyle(r)&&"block"==l.win.getComputedStyle(r).display)&&(a=a.replace(/ $/,M.FE.UNICODE_NBSP)),!n||l.node.isVoid(n)||l.node.isBlock(n)||1!==(a=a.replace(/^\u00A0([^ $])/," $1")).length||160!==a.charCodeAt(0)||!r||l.node.isVoid(r)||l.node.isBlock(r)||(a=" "),t||(a=a.replace(/([^ \u00A0])\u00A0([^ \u00A0])/g,"$1 $2")),e.textContent!=a&&(e.textContent=a)}}function d(e,t){if(void 0!==e&&e||(e=l.el),void 0===t&&(t=!1),!e.getAttribute||"false"!=e.getAttribute("contenteditable"))if(e.nodeType==Node.TEXT_NODE)r(e,t);else if(e.nodeType==Node.ELEMENT_NODE)for(var n=l.doc.createTreeWalker(e,NodeFilter.SHOW_TEXT,l.node.filter(function(e){for(var t=e.parentNode;t&&t!==l.el;){if("STYLE"==t.tagName||"IFRAME"==t.tagName)return!1;if("PRE"===t.tagName)return!1;t=t.parentNode}return null!=e.textContent.match(/([ \u00A0\f\n\r\t\v]{2,})|(^[ \u00A0\f\n\r\t\v]{1,})|([ \u00A0\f\n\r\t\v]{1,}$)/g)&&!l.node.hasClass(e.parentNode,"fr-marker")}),!1);n.nextNode();)r(n.currentNode,t)}return{normalize:d,normalizeAroundCursor:function(){for(var e=[],t=l.el.querySelectorAll(".fr-marker"),n=0;n<t.length;n++){for(var r=null,o=l.node.blockParent(t[n]),i=(r=o||t[n]).nextSibling,a=r.previousSibling;i&&"BR"==i.tagName;)i=i.nextSibling;for(;a&&"BR"==a.tagName;)a=a.previousSibling;r&&e.indexOf(r)<0&&e.push(r),a&&e.indexOf(a)<0&&e.push(a),i&&e.indexOf(i)<0&&e.push(i)}for(var s=0;s<e.length;s++)d(e[s])}}},M.FE.UNICODE_NBSP=String.fromCharCode(160),M.FE.VOID_ELEMENTS=["area","base","br","col","embed","hr","img","input","keygen","link","menuitem","meta","param","source","track","wbr"],M.FE.BLOCK_TAGS=["address","article","aside","audio","blockquote","canvas","details","dd","div","dl","dt","fieldset","figcaption","figure","footer","form","h1","h2","h3","h4","h5","h6","header","hgroup","hr","li","main","nav","noscript","ol","output","p","pre","section","table","tbody","td","tfoot","th","thead","tr","ul","video"],M.extend(M.FE.DEFAULTS,{htmlAllowedEmptyTags:["textarea","a","iframe","object","video","style","script",".fa",".fr-emoticon",".fr-inner","path","line"],htmlDoNotWrapTags:["script","style"],htmlSimpleAmpersand:!1,htmlIgnoreCSSProperties:[],htmlExecuteScripts:!0}),M.FE.MODULES.html=function(O){function c(){return O.opts.enter==M.FE.ENTER_P?"p":O.opts.enter==M.FE.ENTER_DIV?"div":O.opts.enter==M.FE.ENTER_BR?null:void 0}function s(e,t){return!(!e||e===O.el)&&(t?-1!=["PRE","SCRIPT","STYLE"].indexOf(e.tagName)||s(e.parentNode,t):-1!=["PRE","SCRIPT","STYLE"].indexOf(e.tagName))}function i(e){var t,n=[],r=[];if(e){var o=O.el.querySelectorAll(".fr-marker");for(t=0;t<o.length;t++){var i=O.node.blockParent(o[t])||o[t];if(i){var a=i.nextSibling,s=i.previousSibling;i&&r.indexOf(i)<0&&O.node.isBlock(i)&&r.push(i),s&&O.node.isBlock(s)&&r.indexOf(s)<0&&r.push(s),a&&O.node.isBlock(a)&&r.indexOf(a)<0&&r.push(a)}}}else r=O.el.querySelectorAll(p());var l=p();for(l+=","+M.FE.VOID_ELEMENTS.join(","),l+=", .fr-inner",l+=","+O.opts.htmlAllowedEmptyTags.join(":not(.fr-marker),")+":not(.fr-marker)",t=r.length-1;0<=t;t--)if(!(r[t].textContent&&0<r[t].textContent.replace(/\u200B|\n/g,"").length||0<r[t].querySelectorAll(l).length)){for(var d=O.node.contents(r[t]),c=!1,f=0;f<d.length;f++)if(d[f].nodeType!=Node.COMMENT_NODE&&d[f].textContent&&0<d[f].textContent.replace(/\u200B|\n/g,"").length){c=!0;break}c||n.push(r[t])}return n}function p(){return M.FE.BLOCK_TAGS.join(", ")}function e(e){var t,n,r=M.merge([],M.FE.VOID_ELEMENTS);r=M.merge(r,O.opts.htmlAllowedEmptyTags),r=void 0===e?M.merge(r,M.FE.BLOCK_TAGS):M.merge(r,M.FE.NO_DELETE_TAGS),t=O.el.querySelectorAll("*:empty:not("+r.join("):not(")+"):not(.fr-marker)");do{n=!1;for(var o=0;o<t.length;o++)0!==t[o].attributes.length&&void 0===t[o].getAttribute("href")||(t[o].parentNode.removeChild(t[o]),n=!0);t=O.el.querySelectorAll("*:empty:not("+r.join("):not(")+"):not(.fr-marker)")}while(t.length&&n)}function a(e,t){var n=c();if(t&&(n="div"),n){for(var r=O.doc.createDocumentFragment(),o=null,i=!1,a=e.firstChild,s=!1;a;){var l=a.nextSibling;if(a.nodeType==Node.ELEMENT_NODE&&(O.node.isBlock(a)||0<=O.opts.htmlDoNotWrapTags.indexOf(a.tagName.toLowerCase())&&!O.node.hasClass(a,"fr-marker")))o=null,r.appendChild(a.cloneNode(!0));else if(a.nodeType!=Node.ELEMENT_NODE&&a.nodeType!=Node.TEXT_NODE)o=null,r.appendChild(a.cloneNode(!0));else if("BR"==a.tagName)null==o?(o=O.doc.createElement(n),s=!0,t&&(o.setAttribute("class","fr-temp-div"),o.setAttribute("data-empty",!0)),o.appendChild(a.cloneNode(!0)),r.appendChild(o)):!1===i&&(o.appendChild(O.doc.createElement("br")),t&&(o.setAttribute("class","fr-temp-div"),o.setAttribute("data-empty",!0))),o=null;else{var d=a.textContent;(a.nodeType!==Node.TEXT_NODE||0<d.replace(/\n/g,"").replace(/(^ *)|( *$)/g,"").length||d.length&&d.indexOf("\n")<0)&&(null==o&&(o=O.doc.createElement(n),s=!0,t&&o.setAttribute("class","fr-temp-div"),r.appendChild(o),i=!1),o.appendChild(a.cloneNode(!0)),i||O.node.hasClass(a,"fr-marker")||a.nodeType==Node.TEXT_NODE&&0===d.replace(/ /g,"").length||(i=!0))}a=l}s&&(e.innerHTML="",e.appendChild(r))}}function l(e,t){for(var n=e.length-1;0<=n;n--)a(e[n],t)}function t(e,t,n,r,o){if(!O.$wp)return!1;void 0===e&&(e=!1),void 0===t&&(t=!1),void 0===n&&(n=!1),void 0===r&&(r=!1),void 0===o&&(o=!1);var i=O.$wp.scrollTop();a(O.el,e),r&&l(O.el.querySelectorAll(".fr-inner"),e),t&&l(O.el.querySelectorAll("td, th"),e),n&&l(O.el.querySelectorAll("blockquote"),e),o&&l(O.el.querySelectorAll("li"),e),i!=O.$wp.scrollTop()&&O.$wp.scrollTop(i)}function n(e){if(void 0===e&&(e=O.el),e&&0<=["SCRIPT","STYLE","PRE"].indexOf(e.tagName))return!1;for(var t=O.doc.createTreeWalker(e,NodeFilter.SHOW_TEXT,O.node.filter(function(e){return null!=e.textContent.match(/([ \n]{2,})|(^[ \n]{1,})|([ \n]{1,}$)/g)}),!1);t.nextNode();){var n=t.currentNode;if(!s(n.parentNode,!0)){var r=O.node.isBlock(n.parentNode)||O.node.isElement(n.parentNode),o=n.textContent.replace(/(?!^)( ){2,}(?!$)/g," ").replace(/\n/g," ").replace(/^[ ]{2,}/g," ").replace(/[ ]{2,}$/g," ");if(r){var i=n.previousSibling,a=n.nextSibling;i&&a&&" "==o?o=O.node.isBlock(i)&&O.node.isBlock(a)?"":" ":(i||(o=o.replace(/^ */,"")),a||(o=o.replace(/ *$/,"")))}n.textContent=o}}}function r(e,t,n){var r=new RegExp(t,"gi").exec(e);return r?r[n]:null}function w(e){var t=e.doctype,n="<!DOCTYPE html>";return t&&(n="<!DOCTYPE "+t.name+(t.publicId?' PUBLIC "'+t.publicId+'"':"")+(!t.publicId&&t.systemId?" SYSTEM":"")+(t.systemId?' "'+t.systemId+'"':"")+">"),n}function d(e){var t=e.parentNode;if(t&&(O.node.isBlock(t)||O.node.isElement(t))&&["TD","TH"].indexOf(t.tagName)<0){for(var n=e.previousSibling,r=e.nextSibling;n&&(n.nodeType==Node.TEXT_NODE&&0===n.textContent.replace(/\n|\r/g,"").length||O.node.hasClass(n,"fr-tmp"));)n=n.previousSibling;if(r)return!1;n&&t&&"BR"!=n.tagName&&!O.node.isBlock(n)&&!r&&0<t.textContent.replace(/\u200B/g,"").length&&0<n.textContent.length&&!O.node.hasClass(n,"fr-marker")&&(O.el==t&&!r&&O.opts.enter==M.FE.ENTER_BR&&O.browser.msie||e.parentNode.removeChild(e))}else!t||O.node.isBlock(t)||O.node.isElement(t)||e.previousSibling||e.nextSibling||!O.node.isDeletable(e.parentNode)||d(e.parentNode)}function u(){O.opts.htmlUntouched||(e(),t(),n(),O.spaces.normalize(null,!0),O.html.fillEmptyBlocks(),O.clean.lists(),O.clean.tables(),O.clean.toHTML5(),O.html.cleanBRs()),O.selection.restore(),o(),O.placeholder.refresh()}function o(){O.node.isEmpty(O.el)&&(null!=c()?O.el.querySelector(p())||O.el.querySelector(O.opts.htmlDoNotWrapTags.join(":not(.fr-marker),")+":not(.fr-marker)")||(O.core.hasFocus()?(O.$el.html("<"+c()+">"+M.FE.MARKERS+"<br/></"+c()+">"),O.selection.restore()):O.$el.html("<"+c()+"><br/></"+c()+">")):O.el.querySelector("*:not(.fr-marker):not(br)")||(O.core.hasFocus()?(O.$el.html(M.FE.MARKERS+"<br/>"),O.selection.restore()):O.$el.html("<br/>")))}function g(e,t){return r(e,"<"+t+"[^>]*?>([\\w\\W]*)</"+t+">",1)}function h(e,t){var n=M("<div "+(r(e,"<"+t+"([^>]*?)>",1)||"")+">");return O.node.rawAttributes(n.get(0))}function m(e){return(r(e,"<!DOCTYPE([^>]*?)>",0)||"<!DOCTYPE html>").replace(/\n/g," ").replace(/ {2,}/g," ")}function E(e,t){O.opts.htmlExecuteScripts?e.html(t):e.get(0).innerHTML=t}function F(e){var t;(t=/:not\(([^\)]*)\)/g).test(e)&&(e=e.replace(t,"     $1 "));var n=100*(e.match(/(#[^\s\+>~\.\[:]+)/g)||[]).length+10*(e.match(/(\[[^\]]+\])/g)||[]).length+10*(e.match(/(\.[^\s\+>~\.\[:]+)/g)||[]).length+10*(e.match(/(:[\w-]+\([^\)]*\))/gi)||[]).length+10*(e.match(/(:[^\s\+>~\.\[:]+)/g)||[]).length+(e.match(/(::[^\s\+>~\.\[:]+|:first-line|:first-letter|:before|:after)/gi)||[]).length;return n+=((e=(e=e.replace(/[\*\s\+>~]/g," ")).replace(/[#\.]/g," ")).match(/([^\s\+>~\.\[:]+)/g)||[]).length}function k(e){if(O.events.trigger("html.processGet",[e]),e&&e.getAttribute&&""===e.getAttribute("class")&&e.removeAttribute("class"),e&&e.getAttribute&&""===e.getAttribute("style")&&e.removeAttribute("style"),e&&e.nodeType==Node.ELEMENT_NODE){var t,n=e.querySelectorAll('[class=""],[style=""]');for(t=0;t<n.length;t++){var r=n[t];""===r.getAttribute("class")&&r.removeAttribute("class"),""===r.getAttribute("style")&&r.removeAttribute("style")}if("BR"===e.tagName)d(e);else{var o=e.querySelectorAll("br");for(t=0;t<o.length;t++)d(o[t])}}}function D(e,t){return e[3]-t[3]}function f(e){var t=O.doc.createElement("div");return t.innerHTML=e,null!==t.querySelector(p())}function v(e){var t=null;if(void 0===e&&(t=O.selection.element()),O.opts.keepFormatOnDelete)return!1;var n,r,o=t?(t.textContent.match(/\u200B/g)||[]).length-t.querySelectorAll(".fr-marker").length:0;if((O.el.textContent.match(/\u200B/g)||[]).length-O.el.querySelectorAll(".fr-marker").length==o)return!1;do{r=!1,n=O.el.querySelectorAll("*:not(.fr-marker)");for(var i=0;i<n.length;i++){var a=n[i];if(t!=a){var s=a.textContent;0===a.children.length&&1===s.length&&8203==s.charCodeAt(0)&&"TD"!==a.tagName&&(M(a).remove(),r=!0)}}}while(r)}return{defaultTag:c,isPreformatted:s,emptyBlocks:i,emptyBlockTagsQuery:function(){return M.FE.BLOCK_TAGS.join(":empty, ")+":empty"},blockTagsQuery:p,fillEmptyBlocks:function(e){for(var t=i(e),n=0;n<t.length;n++){var r=t[n];"false"===r.getAttribute("contenteditable")||r.querySelector(O.opts.htmlAllowedEmptyTags.join(":not(.fr-marker),")+":not(.fr-marker)")||O.node.isVoid(r)||"TABLE"!=r.tagName&&"TBODY"!=r.tagName&&"TR"!=r.tagName&&"UL"!=r.tagName&&"OL"!=r.tagName&&r.appendChild(O.doc.createElement("br"))}if(O.browser.msie&&O.opts.enter==M.FE.ENTER_BR){var o=O.node.contents(O.el);o.length&&o[o.length-1].nodeType==Node.TEXT_NODE&&O.$el.append("<br>")}},cleanEmptyTags:e,cleanWhiteTags:v,cleanBlankSpaces:n,blocks:function(){return O.$el.get(0).querySelectorAll(p())},getDoctype:w,set:function(e){var t,n,r,o=O.clean.html((e||"").trim(),[],[],O.opts.fullPage);if(O.opts.fullPage){var i=g(o,"body")||(0<=o.indexOf("<body")?"":o),a=h(o,"body"),s=g(o,"head")||"<title></title>",l=h(o,"head"),d=M("<div>").append(s).contents().each(function(){(this.nodeType==Node.COMMENT_NODE||0<=["BASE","LINK","META","NOSCRIPT","SCRIPT","STYLE","TEMPLATE","TITLE"].indexOf(this.tagName))&&this.parentNode.removeChild(this)}).end().html().trim();s=M("<div>").append(s).contents().map(function(){return this.nodeType==Node.COMMENT_NODE?"\x3c!--"+this.nodeValue+"--\x3e":0<=["BASE","LINK","META","NOSCRIPT","SCRIPT","STYLE","TEMPLATE","TITLE"].indexOf(this.tagName)?this.outerHTML:""}).toArray().join("");var c=m(o),f=h(o,"html");E(O.$el,d+"\n"+i),O.node.clearAttributes(O.el),O.$el.attr(a),O.$el.addClass("fr-view"),O.$el.attr("spellcheck",O.opts.spellcheck),O.$el.attr("dir",O.opts.direction),E(O.$head,s),O.node.clearAttributes(O.$head.get(0)),O.$head.attr(l),O.node.clearAttributes(O.$html.get(0)),O.$html.attr(f),O.iframe_document.doctype.parentNode.replaceChild((t=c,n=O.iframe_document,(r=t.match(/<!DOCTYPE ?([^ ]*) ?([^ ]*) ?"?([^"]*)"? ?"?([^"]*)"?>/i))?n.implementation.createDocumentType(r[1],r[3],r[4]):n.implementation.createDocumentType("html")),O.iframe_document.doctype)}else E(O.$el,o);var p=O.edit.isDisabled();O.edit.on(),O.core.injectStyle(O.opts.iframeDefaultStyle+O.opts.iframeStyle),u(),O.opts.useClasses||(O.$el.find("[fr-original-class]").each(function(){this.setAttribute("class",this.getAttribute("fr-original-class")),this.removeAttribute("fr-original-class")}),O.$el.find("[fr-original-style]").each(function(){this.setAttribute("style",this.getAttribute("fr-original-style")),this.removeAttribute("fr-original-style")})),p&&O.edit.off(),O.events.trigger("html.set")},get:function(e,t){if(!O.$wp)return O.$oel.clone().removeClass("fr-view").removeAttr("contenteditable").get(0).outerHTML;var n="";O.events.trigger("html.beforeGet");var r,o,i=[],a={},s=[],l=O.el.querySelectorAll("input, textarea");for(r=0;r<l.length;r++)l[r].setAttribute("value",l[r].value);if(!O.opts.useClasses&&!t){var d=new RegExp("^"+O.opts.htmlIgnoreCSSProperties.join("$|^")+"$","gi");for(r=0;r<O.doc.styleSheets.length;r++){var c,f=0;try{c=O.doc.styleSheets[r].cssRules,O.doc.styleSheets[r].ownerNode&&"STYLE"==O.doc.styleSheets[r].ownerNode.nodeType&&(f=1)}catch($){}if(c)for(var p=0,u=c.length;p<u;p++)if(c[p].selectorText&&0<c[p].style.cssText.length){var g,h=c[p].selectorText.replace(/body |\.fr-view /g,"").replace(/::/g,":");try{g=O.el.querySelectorAll(h)}catch($){g=[]}for(o=0;o<g.length;o++){!g[o].getAttribute("fr-original-style")&&g[o].getAttribute("style")?(g[o].setAttribute("fr-original-style",g[o].getAttribute("style")),i.push(g[o])):g[o].getAttribute("fr-original-style")||(g[o].setAttribute("fr-original-style",""),i.push(g[o])),a[g[o]]||(a[g[o]]={});for(var m=1e3*f+F(c[p].selectorText),E=c[p].style.cssText.split(";"),v=0;v<E.length;v++){var b=E[v].trim().split(":")[0];if(b&&!b.match(d)&&(a[g[o]][b]||(a[g[o]][b]=0)<=(g[o].getAttribute("fr-original-style")||"").indexOf(b+":")&&(a[g[o]][b]=1e4),m>=a[g[o]][b]&&(a[g[o]][b]=m,E[v].trim().length))){var S=E[v].trim().split(":");S.splice(0,1),s.push([g[o],b.trim(),S.join(":").trim(),m])}}}}}for(s.sort(D),r=0;r<s.length;r++){var T=s[r];T[0].style[T[1]]=T[2]}for(r=0;r<i.length;r++)if(i[r].getAttribute("class")&&(i[r].setAttribute("fr-original-class",i[r].getAttribute("class")),i[r].removeAttribute("class")),0<(i[r].getAttribute("fr-original-style")||"").trim().length){var y=i[r].getAttribute("fr-original-style").split(";");for(o=0;o<y.length;o++)if(0<y[o].indexOf(":")){var N=y[o].split(":"),C=N[0];N.splice(0,1),i[r].style[C.trim()]=N.join(":").trim()}}}if(O.node.isEmpty(O.el))O.opts.fullPage&&(n=w(O.iframe_document),n+="<html"+O.node.attributes(O.$html.get(0))+">"+O.$html.find("head").get(0).outerHTML+"<body></body></html>");else if(void 0===e&&(e=!1),O.opts.fullPage){n=w(O.iframe_document),O.$el.removeClass("fr-view");var A=O.opts.heightMin;O.opts.heightMin=null,O.size.refresh(),n+="<html"+O.node.attributes(O.$html.get(0))+">"+O.$html.html()+"</html>",O.opts.heightMin=A,O.size.refresh(),O.$el.addClass("fr-view")}else n=O.$el.html();if(!O.opts.useClasses&&!t)for(r=0;r<i.length;r++)i[r].getAttribute("fr-original-class")&&(i[r].setAttribute("class",i[r].getAttribute("fr-original-class")),i[r].removeAttribute("fr-original-class")),null!=i[r].getAttribute("fr-original-style")&&void 0!==i[r].getAttribute("fr-original-style")?(0!==i[r].getAttribute("fr-original-style").length?i[r].setAttribute("style",i[r].getAttribute("fr-original-style")):i[r].removeAttribute("style"),i[r].removeAttribute("fr-original-style")):i[r].removeAttribute("style");O.opts.fullPage&&(n=(n=(n=(n=(n=(n=(n=(n=n.replace(/<style data-fr-style="true">(?:[\w\W]*?)<\/style>/g,"")).replace(/<link([^>]*)data-fr-style="true"([^>]*)>/g,"")).replace(/<style(?:[\w\W]*?)class="firebugResetStyles"(?:[\w\W]*?)>(?:[\w\W]*?)<\/style>/g,"")).replace(/<body((?:[\w\W]*?)) spellcheck="true"((?:[\w\W]*?))>((?:[\w\W]*?))<\/body>/g,"<body$1$2>$3</body>")).replace(/<body((?:[\w\W]*?)) contenteditable="(true|false)"((?:[\w\W]*?))>((?:[\w\W]*?))<\/body>/g,"<body$1$3>$4</body>")).replace(/<body((?:[\w\W]*?)) dir="([\w]*)"((?:[\w\W]*?))>((?:[\w\W]*?))<\/body>/g,"<body$1$3>$4</body>")).replace(/<body((?:[\w\W]*?))class="([\w\W]*?)(fr-rtl|fr-ltr)([\w\W]*?)"((?:[\w\W]*?))>((?:[\w\W]*?))<\/body>/g,'<body$1class="$2$4"$5>$6</body>')).replace(/<body((?:[\w\W]*?)) class=""((?:[\w\W]*?))>((?:[\w\W]*?))<\/body>/g,"<body$1$2>$3</body>")),O.opts.htmlSimpleAmpersand&&(n=n.replace(/\&amp;/gi,"&")),O.events.trigger("html.afterGet"),e||(n=n.replace(/<span[^>]*? class\s*=\s*["']?fr-marker["']?[^>]+>\u200b<\/span>/gi,"")),n=O.clean.invisibleSpaces(n),n=O.clean.exec(n,k);var x=O.events.chainTrigger("html.get",n);return"string"==typeof x&&(n=x),n=(n=n.replace(/<pre(?:[\w\W]*?)>(?:[\w\W]*?)<\/pre>/g,function(e){return e.replace(/<br>/g,"\n")})).replace(/<meta((?:[\w\W]*?)) data-fr-http-equiv="/g,'<meta$1 http-equiv="')},getSelected:function(){var e,t,n=function(e,t){for(;t&&(t.nodeType==Node.TEXT_NODE||!O.node.isBlock(t))&&!O.node.isElement(t)&&!O.node.hasClass(t,"fr-inner");)t&&t.nodeType!=Node.TEXT_NODE&&M(e).wrapInner(O.node.openTagString(t)+O.node.closeTagString(t)),t=t.parentNode;t&&e.innerHTML==t.innerHTML&&(e.innerHTML=t.outerHTML)},r="";if("undefined"!=typeof O.win.getSelection){O.browser.mozilla&&(O.selection.save(),1<O.$el.find('.fr-marker[data-type="false"]').length&&(O.$el.find('.fr-marker[data-type="false"][data-id="0"]').remove(),O.$el.find('.fr-marker[data-type="false"]:last').attr("data-id","0"),O.$el.find(".fr-marker").not('[data-id="0"]').remove()),O.selection.restore());for(var o=O.selection.ranges(),i=0;i<o.length;i++){var a=document.createElement("div");a.appendChild(o[i].cloneContents()),n(a,(t=e=void 0,t=null,O.win.getSelection?(e=O.win.getSelection())&&e.rangeCount&&(t=e.getRangeAt(0).commonAncestorContainer).nodeType!=Node.ELEMENT_NODE&&(t=t.parentNode):(e=O.doc.selection)&&"Control"!=e.type&&(t=e.createRange().parentElement()),null!=t&&(0<=M.inArray(O.el,M(t).parents())||t==O.el)?t:null)),0<M(a).find(".fr-element").length&&(a=O.el),r+=a.innerHTML}}else"undefined"!=typeof O.doc.selection&&"Text"==O.doc.selection.type&&(r=O.doc.selection.createRange().htmlText);return r},insert:function(e,t,n){var r,o,i;if(O.selection.isCollapsed()||O.selection.remove(),r=t?e:O.clean.html(e),e.indexOf('class="fr-marker"')<0&&(o=r,(i=O.doc.createElement("div")).innerHTML=o,O.selection.setAtEnd(i),r=i.innerHTML),O.node.isEmpty(O.el)&&!O.opts.keepFormatOnDelete&&f(r))O.el.innerHTML=r;else{var a=O.markers.insert();if(a){O.node.isLastSibling(a)&&M(a).parent().hasClass("fr-deletable")&&M(a).insertAfter(M(a).parent());var s=O.node.blockParent(a);if((f(r)||n)&&(O.node.deepestParent(a)||s&&"LI"==s.tagName)){if(s&&"LI"==s.tagName&&(r=function(e){if(!O.html.defaultTag())return e;var t=O.doc.createElement("div");t.innerHTML=e;for(var n=t.querySelectorAll(":scope > "+O.html.defaultTag()),r=n.length-1;0<=r;r--){var o=n[r];O.node.isBlock(o.previousSibling)||(o.previousSibling&&!O.node.isEmpty(o)&&M("<br>").insertAfter(o.previousSibling),o.outerHTML=o.innerHTML)}return t.innerHTML}(r)),!(a=O.markers.split()))return!1;a.outerHTML=r}else a.outerHTML=r}else O.el.innerHTML=O.el.innerHTML+r}u(),O.keys.positionCaret(),O.events.trigger("html.inserted")},wrap:t,unwrap:function(){O.$el.find("div.fr-temp-div").each(function(){this.previousSibling&&this.previousSibling.nodeType===Node.TEXT_NODE&&M(this).before("<br>"),M(this).attr("data-empty")||!this.nextSibling||O.node.isBlock(this.nextSibling)&&!M(this.nextSibling).hasClass("fr-temp-div")?M(this).replaceWith(M(this).html()):M(this).replaceWith(M(this).html()+"<br>")}),O.$el.find(".fr-temp-div").removeClass("fr-temp-div").filter(function(){return""===M(this).attr("class")}).removeAttr("class")},escapeEntities:function(e){return e.replace(/</gi,"&lt;").replace(/>/gi,"&gt;").replace(/"/gi,"&quot;").replace(/'/gi,"&#39;")},checkIfEmpty:o,extractNode:g,extractNodeAttrs:h,extractDoctype:m,cleanBRs:function(){for(var e=O.el.getElementsByTagName("br"),t=0;t<e.length;t++)d(e[t])},_init:function(){if(O.$wp){var e=function(){v(),O.placeholder&&setTimeout(O.placeholder.refresh,0)};O.events.on("mouseup",e),O.events.on("keydown",e),O.events.on("contentChanged",o)}}}},M.extend(M.FE.DEFAULTS,{height:null,heightMax:null,heightMin:null,width:null}),M.FE.MODULES.size=function(e){function t(){n(),e.opts.height&&e.$el.css("minHeight",e.opts.height-e.helpers.getPX(e.$el.css("padding-top"))-e.helpers.getPX(e.$el.css("padding-bottom"))),e.$iframe.height(e.$el.outerHeight(!0))}function n(){e.opts.heightMin?e.$el.css("minHeight",e.opts.heightMin):e.$el.css("minHeight",""),e.opts.heightMax?(e.$wp.css("maxHeight",e.opts.heightMax),e.$wp.css("overflow","auto")):(e.$wp.css("maxHeight",""),e.$wp.css("overflow","")),e.opts.height?(e.$wp.height(e.opts.height),e.$wp.css("overflow","auto"),e.$el.css("minHeight",e.opts.height-e.helpers.getPX(e.$el.css("padding-top"))-e.helpers.getPX(e.$el.css("padding-bottom")))):(e.$wp.css("height",""),e.opts.heightMin||e.$el.css("minHeight",""),e.opts.heightMax||e.$wp.css("overflow","")),e.opts.width&&e.$box.width(e.opts.width)}return{_init:function(){if(!e.$wp)return!1;n(),e.$iframe&&(e.events.on("keyup keydown",function(){setTimeout(t,0)},!0),e.events.on("commands.after html.set init initialized paste.after",t))},syncIframe:t,refresh:n}},M.extend(M.FE.DEFAULTS,{language:null}),M.FE.LANGUAGE={},M.FE.MODULES.language=function(e){var t;return{_init:function(){M.FE.LANGUAGE&&(t=M.FE.LANGUAGE[e.opts.language]),t&&t.direction&&(e.opts.direction=t.direction)},translate:function(e){return t&&t.translation[e]&&t.translation[e].length?t.translation[e]:e}}},M.extend(M.FE.DEFAULTS,{placeholderText:"Type something"}),M.FE.MODULES.placeholder=function(c){function e(){c.$placeholder||(c.$placeholder=M('<span class="fr-placeholder"></span>'),c.$wp.append(c.$placeholder));var e=c.opts.iframe?c.$iframe.prev().outerHeight(!0):c.$el.prev().outerHeight(!0),t=0,n=0,r=0,o=0,i=0,a=0,s=c.node.contents(c.el),l=M(c.selection.element()).css("text-align");if(s.length&&s[0].nodeType==Node.ELEMENT_NODE){var d=M(s[0]);(!c.opts.toolbarInline||0<c.$el.prev().length)&&c.ready&&(t=c.helpers.getPX(d.css("margin-top")),o=c.helpers.getPX(d.css("padding-top")),n=c.helpers.getPX(d.css("margin-left")),r=c.helpers.getPX(d.css("margin-right")),i=c.helpers.getPX(d.css("padding-left")),a=c.helpers.getPX(d.css("padding-right"))),c.$placeholder.css("font-size",d.css("font-size")),c.$placeholder.css("line-height",d.css("line-height"))}else c.$placeholder.css("font-size",c.$el.css("font-size")),c.$placeholder.css("line-height",c.$el.css("line-height"));c.$wp.addClass("show-placeholder"),c.$placeholder.css({marginTop:Math.max(c.helpers.getPX(c.$el.css("margin-top")),t)+(e||0),paddingTop:Math.max(c.helpers.getPX(c.$el.css("padding-top")),o),paddingLeft:Math.max(c.helpers.getPX(c.$el.css("padding-left")),i),marginLeft:Math.max(c.helpers.getPX(c.$el.css("margin-left")),n),paddingRight:Math.max(c.helpers.getPX(c.$el.css("padding-right")),a),marginRight:Math.max(c.helpers.getPX(c.$el.css("margin-right")),r),textAlign:l}).text(c.language.translate(c.opts.placeholderText||c.$oel.attr("placeholder")||"")),c.$placeholder.html(c.$placeholder.text().replace(/\n/g,"<br>"))}function t(){c.$wp.removeClass("show-placeholder")}function n(){if(!c.$wp)return!1;c.core.isEmpty()?e():t()}return{_init:function(){if(!c.$wp)return!1;c.events.on("init input keydown keyup contentChanged initialized",n)},show:e,hide:t,refresh:n,isVisible:function(){return!c.$wp||c.node.hasClass(c.$wp.get(0),"show-placeholder")}}},M.FE.MODULES.edit=function(t){function e(){if(t.browser.mozilla)try{t.doc.execCommand("enableObjectResizing",!1,"false"),t.doc.execCommand("enableInlineTableEditing",!1,"false")}catch(e){}if(t.browser.msie)try{t.doc.body.addEventListener("mscontrolselect",function(e){return e.preventDefault(),!1})}catch(e){}}var n=!1;function r(){return n}return{_init:function(){t.events.on("focus",function(){r()?t.edit.off():t.edit.on()})},on:function(){t.$wp?(t.$el.attr("contenteditable",!0),t.$el.removeClass("fr-disabled").attr("aria-disabled",!1),t.$tb&&t.$tb.removeClass("fr-disabled").removeAttr("aria-disabled"),e()):t.$el.is("a")&&t.$el.attr("contenteditable",!0),n=!1},off:function(){t.events.disableBlur(),t.$wp?(t.$el.attr("contenteditable",!1),t.$el.addClass("fr-disabled").attr("aria-disabled",!0),t.$tb&&t.$tb.addClass("fr-disabled").attr("aria-disabled",!0)):t.$el.is("a")&&t.$el.attr("contenteditable",!1),t.events.enableBlur(),n=!0},disableDesign:e,isDisabled:r}},M.extend(M.FE.DEFAULTS,{editorClass:null,typingTimer:500,iframe:!1,requestWithCORS:!0,requestWithCredentials:!1,requestHeaders:{},useClasses:!0,spellcheck:!0,iframeDefaultStyle:'html{margin:0px;height:auto;}body{height:auto;padding:10px;background:transparent;color:#000000;position:relative;z-index: 2;-webkit-user-select:auto;margin:0px;overflow:hidden;min-height:20px;}body:after{content:"";display:block;clear:both;}body::-moz-selection{background:#b5d6fd;color:#000;}body::selection{background:#b5d6fd;color:#000;}',iframeStyle:"",iframeStyleFiles:[],direction:"auto",zIndex:1,tabIndex:null,disableRightClick:!1,scrollableContainer:"body",keepFormatOnDelete:!1,theme:null}),M.FE.MODULES.core=function(i){function t(){if(i.$box.addClass("fr-box"+(i.opts.editorClass?" "+i.opts.editorClass:"")),i.$box.attr("role","application"),i.$wp.addClass("fr-wrapper"),i.opts.iframe||i.$el.addClass("fr-element fr-view"),i.opts.iframe){i.$iframe.addClass("fr-iframe"),i.$el.addClass("fr-view");for(var e=0;e<i.o_doc.styleSheets.length;e++){var t;try{t=i.o_doc.styleSheets[e].cssRules}catch(o){}if(t)for(var n=0,r=t.length;n<r;n++)!t[n].selectorText||0!==t[n].selectorText.indexOf(".fr-view")&&0!==t[n].selectorText.indexOf(".fr-element")||0<t[n].style.cssText.length&&(0===t[n].selectorText.indexOf(".fr-view")?i.opts.iframeStyle+=t[n].selectorText.replace(/\.fr-view/g,"body")+"{"+t[n].style.cssText+"}":i.opts.iframeStyle+=t[n].selectorText.replace(/\.fr-element/g,"body")+"{"+t[n].style.cssText+"}")}}"auto"!=i.opts.direction&&i.$box.removeClass("fr-ltr fr-rtl").addClass("fr-"+i.opts.direction),i.$el.attr("dir",i.opts.direction),i.$wp.attr("dir",i.opts.direction),1<i.opts.zIndex&&i.$box.css("z-index",i.opts.zIndex),i.opts.theme&&i.$box.addClass(i.opts.theme+"-theme"),i.opts.tabIndex=i.opts.tabIndex||i.$oel.attr("tabIndex"),i.opts.tabIndex&&i.$el.attr("tabIndex",i.opts.tabIndex)}return{_init:function(){if(M.FE.INSTANCES.push(i),i.drag_support={filereader:"undefined"!=typeof FileReader,formdata:!!i.win.FormData,progress:"upload"in new XMLHttpRequest},i.$wp){t(),i.html.set(i._original_html),i.$el.attr("spellcheck",i.opts.spellcheck),i.helpers.isMobile()&&(i.$el.attr("autocomplete",i.opts.spellcheck?"on":"off"),i.$el.attr("autocorrect",i.opts.spellcheck?"on":"off"),i.$el.attr("autocapitalize",i.opts.spellcheck?"on":"off")),i.opts.disableRightClick&&i.events.$on(i.$el,"contextmenu",function(e){if(2==e.button)return!1});try{i.doc.execCommand("styleWithCSS",!1,!1)}catch(e){}}"TEXTAREA"==i.$oel.get(0).tagName&&(i.events.on("contentChanged",function(){i.$oel.val(i.html.get())}),i.events.on("form.submit",function(){i.$oel.val(i.html.get())}),i.events.on("form.reset",function(){i.html.set(i._original_html)}),i.$oel.val(i.html.get())),i.helpers.isIOS()&&i.events.$on(i.$doc,"selectionchange",function(){i.$doc.get(0).hasFocus()||i.$win.get(0).focus()}),i.events.trigger("init"),i.opts.autofocus&&!i.opts.initOnClick&&i.$wp&&i.events.on("initialized",function(){i.events.focus(!0)})},destroy:function(e){"TEXTAREA"==i.$oel.get(0).tagName&&i.$oel.val(e),i.$box&&i.$box.removeAttr("role"),i.$wp&&("TEXTAREA"==i.$oel.get(0).tagName?(i.$el.html(""),i.$wp.html(""),i.$box.replaceWith(i.$oel),i.$oel.show()):(i.$wp.replaceWith(e),i.$el.html(""),i.$box.removeClass("fr-view fr-ltr fr-box "+(i.opts.editorClass||"")),i.opts.theme&&i.$box.addClass(i.opts.theme+"-theme"))),this.$wp=null,this.$el=null,this.el=null,this.$box=null},isEmpty:function(){return i.node.isEmpty(i.el)},getXHR:function(e,t){var n=new XMLHttpRequest;for(var r in n.open(t,e,!0),i.opts.requestWithCredentials&&(n.withCredentials=!0),i.opts.requestHeaders)i.opts.requestHeaders.hasOwnProperty(r)&&n.setRequestHeader(r,i.opts.requestHeaders[r]);return n},injectStyle:function(e){if(i.opts.iframe){i.$head.find("style[data-fr-style], link[data-fr-style]").remove(),i.$head.append('<style data-fr-style="true">'+e+"</style>");for(var t=0;t<i.opts.iframeStyleFiles.length;t++){var n=M('<link data-fr-style="true" rel="stylesheet" href="'+i.opts.iframeStyleFiles[t]+'">');n.get(0).addEventListener("load",i.size.syncIframe),i.$head.append(n)}}},hasFocus:function(){return i.browser.mozilla&&i.helpers.isMobile()?i.selection.inEditor():i.node.hasFocus(i.el)||0<i.$el.find("*:focus").length},sameInstance:function(e){if(!e)return!1;var t=e.data("instance");return!!t&&t.id==i.id}}},M.FE.MODULES.cursorLists=function(h){function m(e){for(var t=e;"LI"!=t.tagName;)t=t.parentNode;return t}function E(e){for(var t=e;!h.node.isList(t);)t=t.parentNode;return t}return{_startEnter:function(e){var t,n=m(e),r=n.nextSibling,o=n.previousSibling,i=h.html.defaultTag();if(h.node.isEmpty(n,!0)&&r){for(var a="",s="",l=e.parentNode;!h.node.isList(l)&&l.parentNode&&("LI"!==l.parentNode.tagName||l.parentNode===n);)a=h.node.openTagString(l)+a,s+=h.node.closeTagString(l),l=l.parentNode;a=h.node.openTagString(l)+a,s+=h.node.closeTagString(l);var d="";for(d=l.parentNode&&"LI"==l.parentNode.tagName?s+"<li>"+M.FE.MARKERS+"<br>"+a:i?s+"<"+i+">"+M.FE.MARKERS+"<br></"+i+">"+a:s+M.FE.MARKERS+"<br>"+a;["UL","OL"].indexOf(l.tagName)<0||l.parentNode&&"LI"===l.parentNode.tagName;)l=l.parentNode;M(n).replaceWith('<span id="fr-break"></span>');var c=h.node.openTagString(l)+M(l).html()+h.node.closeTagString(l);c=c.replace(/<span id="fr-break"><\/span>/g,d),M(l).replaceWith(c),h.$el.find("li:empty").remove()}else if(o&&r||!h.node.isEmpty(n,!0)){for(var f="<br>",p=e.parentNode;p&&"LI"!=p.tagName;)f=h.node.openTagString(p)+f+h.node.closeTagString(p),p=p.parentNode;M(n).before("<li>"+f+"</li>"),M(e).remove()}else if(o){t=E(n);for(var u=M.FE.MARKERS+"<br>",g=e.parentNode;g&&"LI"!=g.tagName;)u=h.node.openTagString(g)+u+h.node.closeTagString(g),g=g.parentNode;t.parentNode&&"LI"==t.parentNode.tagName?M(t.parentNode).after("<li>"+u+"</li>"):i?M(t).after("<"+i+">"+u+"</"+i+">"):M(t).after(u),M(n).remove()}else(t=E(n)).parentNode&&"LI"==t.parentNode.tagName?r?M(t.parentNode).before(h.node.openTagString(n)+M.FE.MARKERS+"<br></li>"):M(t.parentNode).after(h.node.openTagString(n)+M.FE.MARKERS+"<br></li>"):i?M(t).before("<"+i+">"+M.FE.MARKERS+"<br></"+i+">"):M(t).before(M.FE.MARKERS+"<br>"),M(n).remove()},_middleEnter:function(e){for(var t=m(e),n="",r=e,o="",i="";r!=t;){var a="A"==(r=r.parentNode).tagName&&h.cursor.isAtEnd(e,r)?"fr-to-remove":"";o=h.node.openTagString(M(r).clone().addClass(a).get(0))+o,i=h.node.closeTagString(r)+i}n=i+n+o+M.FE.MARKERS+M.FE.INVISIBLE_SPACE,M(e).replaceWith('<span id="fr-break"></span>');var s=h.node.openTagString(t)+M(t).html()+h.node.closeTagString(t);s=s.replace(/<span id="fr-break"><\/span>/g,n),M(t).replaceWith(s)},_endEnter:function(e){for(var t=m(e),n=M.FE.MARKERS,r="",o=e,i=!1;o!=t;){var a="A"==(o=o.parentNode).tagName&&h.cursor.isAtEnd(e,o)?"fr-to-remove":"";i||o==t||h.node.isBlock(o)||(i=!0,r+=M.FE.INVISIBLE_SPACE),r=h.node.openTagString(M(o).clone().addClass(a).get(0))+r,n+=h.node.closeTagString(o)}var s=r+n;M(e).remove(),M(t).after(s)},_backspace:function(e){var t=m(e),n=t.previousSibling;if(n){n=M(n).find(h.html.blockTagsQuery()).get(-1)||n,M(e).replaceWith(M.FE.MARKERS);var r=h.node.contents(n);r.length&&"BR"==r[r.length-1].tagName&&M(r[r.length-1]).remove(),M(t).find(h.html.blockTagsQuery()).not("ol, ul, table").each(function(){this.parentNode==t&&M(this).replaceWith(M(this).html()+(h.node.isEmpty(this)?"":"<br>"))});for(var o,i=h.node.contents(t)[0];i&&!h.node.isList(i);)o=i.nextSibling,M(n).append(i),i=o;for(n=t.previousSibling;i;)o=i.nextSibling,M(n).append(i),i=o;M(t).remove()}else{var a=E(t);if(M(e).replaceWith(M.FE.MARKERS),a.parentNode&&"LI"==a.parentNode.tagName){var s=a.previousSibling;h.node.isBlock(s)?(M(t).find(h.html.blockTagsQuery()).not("ol, ul, table").each(function(){this.parentNode==t&&M(this).replaceWith(M(this).html()+(h.node.isEmpty(this)?"":"<br>"))}),M(s).append(M(t).html())):M(a).before(M(t).html())}else{var l=h.html.defaultTag();l&&0===M(t).find(h.html.blockTagsQuery()).length?M(a).before("<"+l+">"+M(t).html()+"</"+l+">"):M(a).before(M(t).html())}M(t).remove(),h.html.wrap(),0===M(a).find("li").length&&M(a).remove()}},_del:function(e){var t,n=m(e),r=n.nextSibling;if(r){(t=h.node.contents(r)).length&&"BR"==t[0].tagName&&M(t[0]).remove(),M(r).find(h.html.blockTagsQuery()).not("ol, ul, table").each(function(){this.parentNode==r&&M(this).replaceWith(M(this).html()+(h.node.isEmpty(this)?"":"<br>"))});for(var o,i=e,a=h.node.contents(r)[0];a&&!h.node.isList(a);)o=a.nextSibling,M(i).after(a),i=a,a=o;for(;a;)o=a.nextSibling,M(n).append(a),a=o;M(e).replaceWith(M.FE.MARKERS),M(r).remove()}else{for(var s=n;!s.nextSibling&&s!=h.el;)s=s.parentNode;if(s==h.el)return!1;if(s=s.nextSibling,h.node.isBlock(s))M.FE.NO_DELETE_TAGS.indexOf(s.tagName)<0&&(M(e).replaceWith(M.FE.MARKERS),(t=h.node.contents(n)).length&&"BR"==t[t.length-1].tagName&&M(t[t.length-1]).remove(),M(n).append(M(s).html()),M(s).remove());else for((t=h.node.contents(n)).length&&"BR"==t[t.length-1].tagName&&M(t[t.length-1]).remove(),M(e).replaceWith(M.FE.MARKERS);s&&!h.node.isBlock(s)&&"BR"!=s.tagName;)M(n).append(M(s)),s=s.nextSibling}}}},M.FE.NO_DELETE_TAGS=["TH","TD","TR","TABLE","FORM"],M.FE.SIMPLE_ENTER_TAGS=["TH","TD","LI","DL","DT","FORM"],M.FE.MODULES.cursor=function(u){function i(e){return!!e&&(!!u.node.isBlock(e)||(e.nextSibling&&e.nextSibling.nodeType==Node.TEXT_NODE&&0===e.nextSibling.textContent.replace(/\u200b/g,"").length?i(e.nextSibling):!(e.nextSibling&&(!e.previousSibling||"BR"!=e.nextSibling.tagName||e.nextSibling.nextSibling))&&i(e.parentNode)))}function a(e){return!!e&&(!!u.node.isBlock(e)||(e.previousSibling&&e.previousSibling.nodeType==Node.TEXT_NODE&&0===e.previousSibling.textContent.replace(/\u200b/g,"").length?a(e.previousSibling):!e.previousSibling&&(!(e.previousSibling||!u.node.hasClass(e.parentNode,"fr-inner"))||a(e.parentNode))))}function g(e,t){return!!e&&(e!=u.$wp.get(0)&&(e.previousSibling&&e.previousSibling.nodeType==Node.TEXT_NODE&&0===e.previousSibling.textContent.replace(/\u200b/g,"").length?g(e.previousSibling,t):!e.previousSibling&&(e.parentNode==t||g(e.parentNode,t))))}function h(e,t){return!!e&&(e!=u.$wp.get(0)&&(e.nextSibling&&e.nextSibling.nodeType==Node.TEXT_NODE&&0===e.nextSibling.textContent.replace(/\u200b/g,"").length?h(e.nextSibling,t):!(e.nextSibling&&(!e.previousSibling||"BR"!=e.nextSibling.tagName||e.nextSibling.nextSibling))&&(e.parentNode==t||h(e.parentNode,t))))}function s(e){return 0<M(e).parentsUntil(u.$el,"LI").length&&0===M(e).parentsUntil("LI","TABLE").length}function d(e,t){var n=new RegExp((t?"^":"")+"(([\\uD83C-\\uDBFF\\uDC00-\\uDFFF]+\\u200D)*[\\uD83C-\\uDBFF\\uDC00-\\uDFFF]{2})"+(t?"":"$"),"i"),r=e.match(n);return r?r[0].length:1}function c(e){for(var t,n=e;!n.previousSibling;)if(n=n.parentNode,u.node.isElement(n))return!1;if(n=n.previousSibling,!u.node.isBlock(n)&&u.node.isEditable(n)){for(t=u.node.contents(n);n.nodeType!=Node.TEXT_NODE&&!u.node.isDeletable(n)&&t.length&&u.node.isEditable(n);)n=t[t.length-1],t=u.node.contents(n);if(n.nodeType==Node.TEXT_NODE){var r=n.textContent,o=r.length;if(r.length&&"\n"===r[r.length-1])return n.textContent=r.substring(0,o-2),0===n.textContent.length&&n.parentNode.removeChild(n),c(e);if(u.opts.tabSpaces&&r.length>=u.opts.tabSpaces)0===r.substr(r.length-u.opts.tabSpaces,r.length-1).replace(/ /g,"").replace(new RegExp(M.FE.UNICODE_NBSP,"g"),"").length&&(o=r.length-u.opts.tabSpaces+1);n.textContent=r.substring(0,o-d(r));var i=r.length!=n.textContent.length;if(0===n.textContent.length)if(i&&u.opts.keepFormatOnDelete)M(n).after(M.FE.INVISIBLE_SPACE+M.FE.MARKERS);else if((2!=n.parentNode.childNodes.length||n.parentNode!=e.parentNode)&&1!=n.parentNode.childNodes.length||u.node.isBlock(n.parentNode)||u.node.isElement(n.parentNode)||!u.node.isDeletable(n.parentNode)){for(;!u.node.isElement(n.parentNode)&&u.node.isEmpty(n.parentNode)&&u.node.isDeletable(n.parentNode);){var a=n;n=n.parentNode,a.parentNode.removeChild(a)}M(n).after(M.FE.MARKERS),u.node.isElement(n.parentNode)&&!e.nextSibling&&n.previousSibling&&"BR"==n.previousSibling.tagName&&M(e).after("<br>"),n.parentNode.removeChild(n)}else M(n.parentNode).after(M.FE.MARKERS),M(n.parentNode).remove();else M(n).after(M.FE.MARKERS)}else u.node.isDeletable(n)?(M(n).after(M.FE.MARKERS),M(n).remove()):e.nextSibling&&"BR"==e.nextSibling.tagName&&u.node.isVoid(n)&&"BR"!=n.tagName?(M(e.nextSibling).remove(),M(e).replaceWith(M.FE.MARKERS)):!1!==u.events.trigger("node.remove",[M(n)])&&(M(n).after(M.FE.MARKERS),M(n).remove())}else if(M.FE.NO_DELETE_TAGS.indexOf(n.tagName)<0&&(u.node.isEditable(n)||u.node.isDeletable(n)))if(u.node.isDeletable(n))M(e).replaceWith(M.FE.MARKERS),M(n).remove();else if(u.node.isEmpty(n)&&!u.node.isList(n))M(n).remove(),M(e).replaceWith(M.FE.MARKERS);else{for(u.node.isList(n)&&(n=M(n).find("li:last").get(0)),(t=u.node.contents(n))&&"BR"==t[t.length-1].tagName&&M(t[t.length-1]).remove(),t=u.node.contents(n);t&&u.node.isBlock(t[t.length-1]);)n=t[t.length-1],t=u.node.contents(n);M(n).append(M.FE.MARKERS);for(var s=e;!s.previousSibling;)s=s.parentNode;for(;s&&"BR"!==s.tagName&&!u.node.isBlock(s);){var l=s;s=s.nextSibling,M(n).append(l)}s&&"BR"==s.tagName&&M(s).remove(),M(e).remove()}else e.nextSibling&&"BR"==e.nextSibling.tagName&&M(e.nextSibling).remove()}function l(e){var t=0<M(e).parentsUntil(u.$el,"BLOCKQUOTE").length,n=u.node.deepestParent(e,[],!t);if(n&&"BLOCKQUOTE"==n.tagName){var r=u.node.deepestParent(e,[M(e).parentsUntil(u.$el,"BLOCKQUOTE").get(0)]);r&&r.nextSibling&&(n=r)}if(null!==n){var o,i=n.nextSibling;if(u.node.isBlock(n)&&(u.node.isEditable(n)||u.node.isDeletable(n))&&i&&M.FE.NO_DELETE_TAGS.indexOf(i.tagName)<0)if(u.node.isDeletable(i))M(i).remove(),M(e).replaceWith(M.FE.MARKERS);else if(u.node.isBlock(i)&&u.node.isEditable(i))if(u.node.isList(i))if(u.node.isEmpty(n,!0))M(n).remove(),M(i).find("li:first").prepend(M.FE.MARKERS);else{var a=M(i).find("li:first");"BLOCKQUOTE"==n.tagName&&(o=u.node.contents(n)).length&&u.node.isBlock(o[o.length-1])&&(n=o[o.length-1]),0===a.find("ul, ol").length&&(M(e).replaceWith(M.FE.MARKERS),a.find(u.html.blockTagsQuery()).not("ol, ul, table").each(function(){this.parentNode==a.get(0)&&M(this).replaceWith(M(this).html()+(u.node.isEmpty(this)?"":"<br>"))}),M(n).append(u.node.contents(a.get(0))),a.remove(),0===M(i).find("li").length&&M(i).remove())}else{if((o=u.node.contents(i)).length&&"BR"==o[0].tagName&&M(o[0]).remove(),"BLOCKQUOTE"!=i.tagName&&"BLOCKQUOTE"==n.tagName)for(o=u.node.contents(n);o.length&&u.node.isBlock(o[o.length-1]);)n=o[o.length-1],o=u.node.contents(n);else if("BLOCKQUOTE"==i.tagName&&"BLOCKQUOTE"!=n.tagName)for(o=u.node.contents(i);o.length&&u.node.isBlock(o[0]);)i=o[0],o=u.node.contents(i);M(e).replaceWith(M.FE.MARKERS),M(n).append(i.innerHTML),M(i).remove()}else{for(M(e).replaceWith(M.FE.MARKERS);i&&"BR"!==i.tagName&&!u.node.isBlock(i)&&u.node.isEditable(i);){var s=i;i=i.nextSibling,M(n).append(s)}i&&"BR"==i.tagName&&u.node.isEditable(i)&&M(i).remove()}}}function n(e){for(var t,n=e;!n.nextSibling;)if(n=n.parentNode,u.node.isElement(n))return!1;if("BR"==(n=n.nextSibling).tagName&&u.node.isEditable(n))if(n.nextSibling){if(u.node.isBlock(n.nextSibling)&&u.node.isEditable(n.nextSibling)){if(!(M.FE.NO_DELETE_TAGS.indexOf(n.nextSibling.tagName)<0))return void M(n).remove();n=n.nextSibling,M(n.previousSibling).remove()}}else if(i(n)){if(s(e))u.cursorLists._del(e);else u.node.deepestParent(n)&&((!u.node.isEmpty(u.node.blockParent(n))||(u.node.blockParent(n).nextSibling&&M.FE.NO_DELETE_TAGS.indexOf(u.node.blockParent(n).nextSibling.tagName))<0)&&M(n).remove(),l(e));return}if(!u.node.isBlock(n)&&u.node.isEditable(n)){for(t=u.node.contents(n);n.nodeType!=Node.TEXT_NODE&&t.length&&!u.node.isDeletable(n)&&u.node.isEditable(n);)n=t[0],t=u.node.contents(n);n.nodeType==Node.TEXT_NODE?(M(n).before(M.FE.MARKERS),n.textContent.length&&(n.textContent=n.textContent.substring(d(n.textContent,!0),n.textContent.length))):u.node.isDeletable(n)?(M(n).before(M.FE.MARKERS),M(n).remove()):!1!==u.events.trigger("node.remove",[M(n)])&&(M(n).before(M.FE.MARKERS),M(n).remove()),M(e).remove()}else if(M.FE.NO_DELETE_TAGS.indexOf(n.tagName)<0&&(u.node.isEditable(n)||u.node.isDeletable(n)))if(u.node.isDeletable(n))M(e).replaceWith(M.FE.MARKERS),M(n).remove();else if(u.node.isList(n))e.previousSibling?(M(n).find("li:first").prepend(e),u.cursorLists._backspace(e)):(M(n).find("li:first").prepend(M.FE.MARKERS),M(e).remove());else if((t=u.node.contents(n))&&"BR"==t[0].tagName&&M(t[0]).remove(),t&&"BLOCKQUOTE"==n.tagName){var r=t[0];for(M(e).before(M.FE.MARKERS);r&&"BR"!=r.tagName;){var o=r;r=r.nextSibling,M(e).before(o)}r&&"BR"==r.tagName&&M(r).remove()}else M(e).after(M(n).html()).after(M.FE.MARKERS),M(n).remove()}function f(){for(var e=u.el.querySelectorAll("blockquote:empty"),t=0;t<e.length;t++)e[t].parentNode.removeChild(e[t])}function p(e,t,n){var r,o=u.node.deepestParent(e,[],!n);if(o&&"BLOCKQUOTE"==o.tagName)return h(e,o)?((r=u.html.defaultTag())?M(o).after("<"+r+">"+M.FE.MARKERS+"<br></"+r+">"):M(o).after(M.FE.MARKERS+"<br>"),M(e).remove()):m(e,t,n),!1;if(null==o)(r=u.html.defaultTag())&&u.node.isElement(e.parentNode)?M(e).replaceWith("<"+r+">"+M.FE.MARKERS+"<br></"+r+">"):!e.previousSibling||M(e.previousSibling).is("br")||e.nextSibling?M(e).replaceWith("<br>"+M.FE.MARKERS):M(e).replaceWith("<br>"+M.FE.MARKERS+"<br>");else{var i=e,a="";u.node.isBlock(o)&&!t||(a="<br/>");var s,l="",d="",c="",f="";(r=u.html.defaultTag())&&u.node.isBlock(o)&&(c="<"+r+">",f="</"+r+">",o.tagName==r.toUpperCase()&&(c=u.node.openTagString(M(o).clone().removeAttr("id").get(0))));do{if(i=i.parentNode,!t||i!=o||t&&!u.node.isBlock(o))if(l+=u.node.closeTagString(i),i==o&&u.node.isBlock(o))d=c+d;else{var p="A"==i.tagName&&h(e,i)?"fr-to-remove":"";d=u.node.openTagString(M(i).clone().addClass(p).get(0))+d}}while(i!=o);a=l+a+d+(e.parentNode==o&&u.node.isBlock(o)?"":M.FE.INVISIBLE_SPACE)+M.FE.MARKERS,u.node.isBlock(o)&&!M(o).find("*:last").is("br")&&M(o).append("<br/>"),M(e).after('<span id="fr-break"></span>'),M(e).remove(),o.nextSibling&&!u.node.isBlock(o.nextSibling)||u.node.isBlock(o)||M(o).after("<br>"),s=(s=!t&&u.node.isBlock(o)?u.node.openTagString(o)+M(o).html()+f:u.node.openTagString(o)+M(o).html()+u.node.closeTagString(o)).replace(/<span id="fr-break"><\/span>/g,a),M(o).replaceWith(s)}}function m(e,t,n){var r=u.node.deepestParent(e,[],!n);if(null==r)u.html.defaultTag()&&e.parentNode===u.el?M(e).replaceWith("<"+u.html.defaultTag()+">"+M.FE.MARKERS+"<br></"+u.html.defaultTag()+">"):(e.nextSibling&&!u.node.isBlock(e.nextSibling)||M(e).after("<br>"),M(e).replaceWith("<br>"+M.FE.MARKERS));else{var o=e,i="";"PRE"==r.tagName&&(t=!0),u.node.isBlock(r)&&!t||(i="<br>");var a="",s="";do{var l=o;if(o=o.parentNode,"BLOCKQUOTE"==r.tagName&&u.node.isEmpty(l)&&!u.node.hasClass(l,"fr-marker")&&0<M(l).find(e).length&&M(l).after(e),("BLOCKQUOTE"!=r.tagName||!h(e,o)&&!g(e,o))&&(!t||o!=r||t&&!u.node.isBlock(r))){a+=u.node.closeTagString(o);var d="A"==o.tagName&&h(e,o)?"fr-to-remove":"";s=u.node.openTagString(M(o).clone().addClass(d).removeAttr("id").get(0))+s}}while(o!=r);var c=r==e.parentNode&&u.node.isBlock(r)||e.nextSibling;if("BLOCKQUOTE"==r.tagName){e.previousSibling&&u.node.isBlock(e.previousSibling)&&e.nextSibling&&"BR"==e.nextSibling.tagName&&(M(e.nextSibling).after(e),e.nextSibling&&"BR"==e.nextSibling.tagName&&M(e.nextSibling).remove());var f=u.html.defaultTag();i=a+i+(f?"<"+f+">":"")+M.FE.MARKERS+"<br>"+(f?"</"+f+">":"")+s}else i=a+i+s+(c?"":M.FE.INVISIBLE_SPACE)+M.FE.MARKERS;M(e).replaceWith('<span id="fr-break"></span>');var p=u.node.openTagString(r)+M(r).html()+u.node.closeTagString(r);p=p.replace(/<span id="fr-break"><\/span>/g,i),M(r).replaceWith(p)}}return{enter:function(t){var n=u.markers.insert();if(!n)return!0;u.el.normalize();var r=!1;0<M(n).parentsUntil(u.$el,"BLOCKQUOTE").length&&(r=!(t=!1)),M(n).parentsUntil(u.$el,"TD, TH").length&&(r=!1),i(n)?!s(n)||t||r?p(n,t,r):u.cursorLists._endEnter(n):a(n)?!s(n)||t||r?function e(t,n,r){var o,i=u.node.deepestParent(t,[],!r);if(i&&"TABLE"==i.tagName)return M(i).find("td:first, th:first").prepend(t),e(t,n,r);if(i&&"BLOCKQUOTE"==i.tagName){if(g(t,i))return(o=u.html.defaultTag())?M(i).before("<"+o+">"+M.FE.MARKERS+"<br></"+o+">"):M(i).before(M.FE.MARKERS+"<br>"),M(t).remove(),!1;h(t,i)?p(t,n,!0):m(t,n,!0)}if(null==i)(o=u.html.defaultTag())&&u.node.isElement(t.parentNode)?M(t).replaceWith("<"+o+">"+M.FE.MARKERS+"<br></"+o+">"):M(t).replaceWith("<br>"+M.FE.MARKERS);else{if(u.node.isBlock(i))if("PRE"==i.tagName&&(n=!0),n)M(t).remove(),M(i).prepend("<br>"+M.FE.MARKERS);else{if(u.node.isEmpty(i,!0))return p(t,n,r);if(u.opts.keepFormatOnDelete){for(var a=t,s=M.FE.INVISIBLE_SPACE;a!=i&&!u.node.isElement(a);)a=a.parentNode,s=u.node.openTagString(a)+s+u.node.closeTagString(a);M(i).before(s)}else M(i).before(u.node.openTagString(M(i).clone().removeAttr("id").get(0))+"<br>"+u.node.closeTagString(i))}else M(i).before("<br>");M(t).remove()}}(n,t,r):u.cursorLists._startEnter(n):!s(n)||t||r?m(n,t,r):u.cursorLists._middleEnter(n),u.$el.find(".fr-to-remove").each(function(){for(var e=u.node.contents(this),t=0;t<e.length;t++)e[t].nodeType==Node.TEXT_NODE&&(e[t].textContent=e[t].textContent.replace(/\u200B/g,""));M(this).replaceWith(this.innerHTML)}),u.html.fillEmptyBlocks(!0),u.opts.htmlUntouched||(u.html.cleanEmptyTags(),u.clean.lists()),u.spaces.normalizeAroundCursor(),u.selection.restore()},backspace:function(){var e=!1,t=u.markers.insert();if(!t)return!0;for(var n=t.parentNode;n&&!u.node.isElement(n);){if("false"===n.getAttribute("contenteditable"))return M(t).replaceWith(M.FE.MARKERS),u.selection.restore(),!1;if("true"===n.getAttribute("contenteditable"))break;n=n.parentNode}u.el.normalize();var r=t.previousSibling;if(r){var o=r.textContent;o&&o.length&&8203==o.charCodeAt(o.length-1)&&(1==o.length?M(r).remove():r.textContent=r.textContent.substr(0,o.length-d(o)))}return i(t)?e=c(t):a(t)?s(t)&&g(t,M(t).parents("li:first").get(0))?u.cursorLists._backspace(t):function(e){for(var t=0<M(e).parentsUntil(u.$el,"BLOCKQUOTE").length,n=u.node.deepestParent(e,[],!t),r=n;n&&!n.previousSibling&&"BLOCKQUOTE"!=n.tagName&&n.parentElement!=u.el&&!u.node.hasClass(n.parentElement,"fr-inner")&&M.FE.SIMPLE_ENTER_TAGS.indexOf(n.parentElement.tagName)<0;)n=n.parentElement;if(n&&"BLOCKQUOTE"==n.tagName){var o=u.node.deepestParent(e,[M(e).parentsUntil(u.$el,"BLOCKQUOTE").get(0)]);o&&o.previousSibling&&(r=n=o)}if(null!==n){var i,a=n.previousSibling;if(u.node.isBlock(n)&&u.node.isEditable(n)&&a&&M.FE.NO_DELETE_TAGS.indexOf(a.tagName)<0)if(u.node.isDeletable(a))M(a).remove(),M(e).replaceWith(M.FE.MARKERS);else if(u.node.isEditable(a))if(u.node.isBlock(a))if(u.node.isEmpty(a)&&!u.node.isList(a))M(a).remove(),M(e).after(u.opts.keepFormatOnDelete?M.FE.INVISIBLE_SPACE:"");else{if(u.node.isList(a)&&(a=M(a).find("li:last").get(0)),(i=u.node.contents(a)).length&&"BR"==i[i.length-1].tagName&&M(i[i.length-1]).remove(),"BLOCKQUOTE"==a.tagName&&"BLOCKQUOTE"!=n.tagName)for(i=u.node.contents(a);i.length&&u.node.isBlock(i[i.length-1]);)a=i[i.length-1],i=u.node.contents(a);else if("BLOCKQUOTE"!=a.tagName&&"BLOCKQUOTE"==n.tagName)for(i=u.node.contents(n);i.length&&u.node.isBlock(i[0]);)n=i[0],i=u.node.contents(n);if(u.node.isEmpty(n))M(e).remove(),u.selection.setAtEnd(a,!0);else{M(e).replaceWith(M.FE.MARKERS);var s=a.childNodes;u.node.isBlock(s[s.length-1])?M(s[s.length-1]).append(r.innerHTML):M(a).append(r.innerHTML)}M(r).remove(),u.node.isEmpty(n)&&M(n).remove()}else M(e).replaceWith(M.FE.MARKERS),"BLOCKQUOTE"==n.tagName&&a.nodeType==Node.ELEMENT_NODE?M(a).remove():(M(a).after(u.node.isEmpty(n)?"":M(n).html()),M(n).remove(),"BR"==a.tagName&&M(a).remove())}}(t):e=c(t),M(t).remove(),f(),u.html.fillEmptyBlocks(!0),u.opts.htmlUntouched||(u.html.cleanEmptyTags(),u.clean.lists(),u.spaces.normalizeAroundCursor()),u.selection.restore(),e},del:function(){var e=u.markers.insert();if(!e)return!1;if(u.el.normalize(),i(e))if(s(e))if(0===M(e).parents("li:first").find("ul, ol").length)u.cursorLists._del(e);else{var t=M(e).parents("li:first").find("ul:first, ol:first").find("li:first");(t=t.find(u.html.blockTagsQuery()).get(-1)||t).prepend(e),u.cursorLists._backspace(e)}else l(e);else a(e),n(e);M(e).remove(),f(),u.html.fillEmptyBlocks(!0),u.opts.htmlUntouched||(u.html.cleanEmptyTags(),u.clean.lists()),u.spaces.normalizeAroundCursor(),u.selection.restore()},isAtEnd:h,isAtStart:g}},M.FE.ENTER_P=0,M.FE.ENTER_DIV=1,M.FE.ENTER_BR=2,M.FE.KEYCODE={BACKSPACE:8,TAB:9,ENTER:13,SHIFT:16,CTRL:17,ALT:18,ESC:27,SPACE:32,ARROW_LEFT:37,ARROW_UP:38,ARROW_RIGHT:39,ARROW_DOWN:40,DELETE:46,ZERO:48,ONE:49,TWO:50,THREE:51,FOUR:52,FIVE:53,SIX:54,SEVEN:55,EIGHT:56,NINE:57,FF_SEMICOLON:59,FF_EQUALS:61,QUESTION_MARK:63,A:65,B:66,C:67,D:68,E:69,F:70,G:71,H:72,I:73,J:74,K:75,L:76,M:77,N:78,O:79,P:80,Q:81,R:82,S:83,T:84,U:85,V:86,W:87,X:88,Y:89,Z:90,META:91,NUM_ZERO:96,NUM_ONE:97,NUM_TWO:98,NUM_THREE:99,NUM_FOUR:100,NUM_FIVE:101,NUM_SIX:102,NUM_SEVEN:103,NUM_EIGHT:104,NUM_NINE:105,NUM_MULTIPLY:106,NUM_PLUS:107,NUM_MINUS:109,NUM_PERIOD:110,NUM_DIVISION:111,F1:112,F2:113,F3:114,F4:115,F5:116,F6:117,F7:118,F8:119,F9:120,F10:121,F11:122,F12:123,FF_HYPHEN:173,SEMICOLON:186,DASH:189,EQUALS:187,COMMA:188,HYPHEN:189,PERIOD:190,SLASH:191,APOSTROPHE:192,TILDE:192,SINGLE_QUOTE:222,OPEN_SQUARE_BRACKET:219,BACKSLASH:220,CLOSE_SQUARE_BRACKET:221,IME:229},M.extend(M.FE.DEFAULTS,{enter:M.FE.ENTER_P,multiLine:!0,tabSpaces:0}),M.FE.MODULES.keys=function(l){var d,n,r,c=!1;function e(){if(l.browser.mozilla&&l.selection.isCollapsed()&&!c){var e=l.selection.ranges(0),t=e.startContainer,n=e.startOffset;t&&t.nodeType==Node.TEXT_NODE&&n<=t.textContent.length&&0<n&&32==t.textContent.charCodeAt(n-1)&&(l.selection.save(),l.spaces.normalize(),l.selection.restore())}}function t(){l.selection.isFull()&&setTimeout(function(){var e=l.html.defaultTag();e?l.$el.html("<"+e+">"+M.FE.MARKERS+"<br/></"+e+">"):l.$el.html(M.FE.MARKERS+"<br/>"),l.selection.restore(),l.placeholder.refresh(),l.button.bulkRefresh(),l.undo.saveStep()},0)}function o(){c=!1}function i(){c=!1}function f(){var e=l.html.defaultTag();e?l.$el.html("<"+e+">"+M.FE.MARKERS+"<br/></"+e+">"):l.$el.html(M.FE.MARKERS+"<br/>"),l.selection.restore()}function a(e){var t=l.selection.element();if(t&&0<=["INPUT","TEXTAREA"].indexOf(t.tagName))return!0;if(e&&g(e.which))return!0;l.events.disableBlur(),null;var n=e.which;if(16===n)return!0;if((d=n)===M.FE.KEYCODE.IME)return c=!0;c=!1;var r,o,i,a=h(n)&&!u(e)&&!e.altKey,s=n==M.FE.KEYCODE.BACKSPACE||n==M.FE.KEYCODE.DELETE;if((l.selection.isFull()&&!l.opts.keepFormatOnDelete&&!l.placeholder.isVisible()||s&&l.placeholder.isVisible()&&l.opts.keepFormatOnDelete)&&(a||s)&&(f(),!h(n)))return e.preventDefault(),!0;n==M.FE.KEYCODE.ENTER?e.shiftKey?((i=e).preventDefault(),i.stopPropagation(),l.opts.multiLine&&(l.selection.isCollapsed()||l.selection.remove(),l.cursor.enter(!0))):(o=e,l.opts.multiLine?(l.helpers.isIOS()||(o.preventDefault(),o.stopPropagation()),l.selection.isCollapsed()||l.selection.remove(),l.cursor.enter()):(o.preventDefault(),o.stopPropagation())):n===M.FE.KEYCODE.BACKSPACE&&(e.metaKey||e.ctrlKey)?setTimeout(function(){l.events.disableBlur(),l.events.focus()},0):n!=M.FE.KEYCODE.BACKSPACE||u(e)||e.altKey?n!=M.FE.KEYCODE.DELETE||u(e)||e.altKey||e.shiftKey?n==M.FE.KEYCODE.SPACE?function(e){var t=l.selection.element();if(!l.helpers.isMobile()&&t&&"A"==t.tagName){e.preventDefault(),e.stopPropagation(),l.selection.isCollapsed()||l.selection.remove();var n=l.markers.insert();if(n){var r=n.previousSibling;!n.nextSibling&&n.parentNode&&"A"==n.parentNode.tagName?(n.parentNode.insertAdjacentHTML("afterend","&nbsp;"+M.FE.MARKERS),n.parentNode.removeChild(n)):(r&&r.nodeType==Node.TEXT_NODE&&1==r.textContent.length&&160==r.textContent.charCodeAt(0)?r.textContent=r.textContent+" ":n.insertAdjacentHTML("beforebegin","&nbsp;"),n.outerHTML=M.FE.MARKERS),l.selection.restore()}}}(e):n==M.FE.KEYCODE.TAB?function(e){if(0<l.opts.tabSpaces)if(l.selection.isCollapsed()){l.undo.saveStep(),e.preventDefault(),e.stopPropagation();for(var t="",n=0;n<l.opts.tabSpaces;n++)t+="&nbsp;";l.html.insert(t),l.placeholder.refresh(),l.undo.saveStep()}else e.preventDefault(),e.stopPropagation(),e.shiftKey?l.commands.outdent():l.commands.indent()}(e):u(e)||!h(e.which)||l.selection.isCollapsed()||e.ctrlKey||e.altKey||l.selection.remove():l.placeholder.isVisible()?(l.opts.keepFormatOnDelete||f(),e.preventDefault(),e.stopPropagation()):((r=e).preventDefault(),r.stopPropagation(),""===l.selection.text()?l.cursor.del():l.selection.remove(),l.placeholder.refresh()):l.placeholder.isVisible()?(l.opts.keepFormatOnDelete||f(),e.preventDefault(),e.stopPropagation()):function(e){if(l.selection.isCollapsed())if(l.cursor.backspace(),l.helpers.isIOS()){var t=l.selection.ranges(0);t.deleteContents(),t.insertNode(document.createTextNode("\u200b")),l.selection.get().modify("move","forward","character")}else e.preventDefault(),e.stopPropagation();else e.preventDefault(),e.stopPropagation(),l.selection.remove();l.placeholder.refresh()}(e),l.events.enableBlur()}function s(){if(!l.$wp)return!0;var e;l.opts.height||l.opts.heightMax?(e=l.position.getBoundingRect().top,(l.helpers.isIOS()||l.helpers.isAndroid())&&(e-=l.helpers.scrollTop()),l.opts.iframe&&(e+=l.$iframe.offset().top),e>l.$wp.offset().top-l.helpers.scrollTop()+l.$wp.height()-20&&l.$wp.scrollTop(e+l.$wp.scrollTop()-(l.$wp.height()+l.$wp.offset().top)+l.helpers.scrollTop()+20)):(e=l.position.getBoundingRect().top,l.opts.toolbarBottom&&(e+=l.opts.toolbarStickyOffset),(l.helpers.isIOS()||l.helpers.isAndroid())&&(e-=l.helpers.scrollTop()),l.opts.iframe&&(e+=l.$iframe.offset().top,e-=l.helpers.scrollTop()),(e+=l.opts.toolbarStickyOffset)>l.o_win.innerHeight-20&&M(l.o_win).scrollTop(e+l.helpers.scrollTop()-l.o_win.innerHeight+20),e=l.position.getBoundingRect().top,l.opts.toolbarBottom||(e-=l.opts.toolbarStickyOffset),(l.helpers.isIOS()||l.helpers.isAndroid())&&(e-=l.helpers.scrollTop()),l.opts.iframe&&(e+=l.$iframe.offset().top,e-=l.helpers.scrollTop()),e<l.$tb.height()+20&&M(l.o_win).scrollTop(e+l.helpers.scrollTop()-l.$tb.height()-20))}function p(e){var t=l.selection.element();if(t&&0<=["INPUT","TEXTAREA"].indexOf(t.tagName))return!0;if(e&&0===e.which&&d&&(e.which=d),l.helpers.isAndroid()&&l.browser.mozilla)return!0;if(c)return!1;if(e&&l.helpers.isIOS()&&e.which==M.FE.KEYCODE.ENTER&&l.doc.execCommand("undo"),!l.selection.isCollapsed())return!0;if(e&&(e.which===M.FE.KEYCODE.META||e.which==M.FE.KEYCODE.CTRL))return!0;if(e&&g(e.which))return!0;if(e&&!l.helpers.isIOS()&&(e.which==M.FE.KEYCODE.ENTER||e.which==M.FE.KEYCODE.BACKSPACE||37<=e.which&&e.which<=40&&!l.browser.msie))try{s()}catch(o){}var n,r=l.selection.element();!function(e){if(!e)return!1;var t=e.innerHTML;return!!((t=t.replace(/<span[^>]*? class\s*=\s*["']?fr-marker["']?[^>]+>\u200b<\/span>/gi,""))&&/\u200B/.test(t)&&0<t.replace(/\u200B/gi,"").length)}(r)||l.node.hasClass(r,"fr-marker")||"IFRAME"==r.tagName||(n=r,l.helpers.isIOS()&&0!==((n.textContent||"").match(/[\u3041-\u3096\u30A0-\u30FF\u4E00-\u9FFF\u3130-\u318F\uAC00-\uD7AF]/gi)||[]).length)||(l.selection.save(),function(e){for(var t=l.doc.createTreeWalker(e,NodeFilter.SHOW_TEXT,l.node.filter(function(e){return/\u200B/gi.test(e.textContent)}),!1);t.nextNode();){var n=t.currentNode;n.textContent=n.textContent.replace(/\u200B/gi,"")}}(r),l.selection.restore())}function u(e){if(-1!=navigator.userAgent.indexOf("Mac OS X")){if(e.metaKey&&!e.altKey)return!0}else if(e.ctrlKey&&!e.altKey)return!0;return!1}function g(e){if(e>=M.FE.KEYCODE.ARROW_LEFT&&e<=M.FE.KEYCODE.ARROW_DOWN)return!0}function h(e){if(e>=M.FE.KEYCODE.ZERO&&e<=M.FE.KEYCODE.NINE)return!0;if(e>=M.FE.KEYCODE.NUM_ZERO&&e<=M.FE.KEYCODE.NUM_MULTIPLY)return!0;if(e>=M.FE.KEYCODE.A&&e<=M.FE.KEYCODE.Z)return!0;if(l.browser.webkit&&0===e)return!0;switch(e){case M.FE.KEYCODE.SPACE:case M.FE.KEYCODE.QUESTION_MARK:case M.FE.KEYCODE.NUM_PLUS:case M.FE.KEYCODE.NUM_MINUS:case M.FE.KEYCODE.NUM_PERIOD:case M.FE.KEYCODE.NUM_DIVISION:case M.FE.KEYCODE.SEMICOLON:case M.FE.KEYCODE.FF_SEMICOLON:case M.FE.KEYCODE.DASH:case M.FE.KEYCODE.EQUALS:case M.FE.KEYCODE.FF_EQUALS:case M.FE.KEYCODE.COMMA:case M.FE.KEYCODE.PERIOD:case M.FE.KEYCODE.SLASH:case M.FE.KEYCODE.APOSTROPHE:case M.FE.KEYCODE.SINGLE_QUOTE:case M.FE.KEYCODE.OPEN_SQUARE_BRACKET:case M.FE.KEYCODE.BACKSLASH:case M.FE.KEYCODE.CLOSE_SQUARE_BRACKET:return!0;default:return!1}}function m(e){var t=e.which;if(u(e)||37<=t&&t<=40||!h(t)&&t!=M.FE.KEYCODE.DELETE&&t!=M.FE.KEYCODE.BACKSPACE&&t!=M.FE.KEYCODE.ENTER&&t!=M.FE.KEYCODE.IME)return!0;n||(r=l.snapshot.get(),l.undo.canDo()||l.undo.saveStep()),clearTimeout(n),n=setTimeout(function(){n=null,l.undo.saveStep()},Math.max(250,l.opts.typingTimer))}function E(e){var t=e.which;if(u(e)||37<=t&&t<=40)return!0;r&&n?(l.undo.saveStep(r),r=null):void 0!==t&&0!==t||r||n||l.undo.saveStep()}function v(e){if(e&&"BR"==e.tagName)return!1;try{return 0===(e.textContent||"").length&&e.querySelector&&!e.querySelector(":scope > br")||e.childNodes&&1==e.childNodes.length&&e.childNodes[0].getAttribute&&("false"==e.childNodes[0].getAttribute("contenteditable")||l.node.hasClass(e.childNodes[0],"fr-img-caption"))}catch(t){return!1}}function b(e){var t=l.el.childNodes,n=l.html.defaultTag();return!(!e.target||e.target===l.el)||(0===t.length||void(l.$el.outerHeight()-e.offsetY<=10?v(t[t.length-1])&&(n?l.$el.append("<"+n+">"+M.FE.MARKERS+"<br></"+n+">"):l.$el.append(M.FE.MARKERS+"<br>"),l.selection.restore(),s()):e.offsetY<=10&&v(t[0])&&(n?l.$el.prepend("<"+n+">"+M.FE.MARKERS+"<br></"+n+">"):l.$el.prepend(M.FE.MARKERS+"<br>"),l.selection.restore(),s())))}function S(){n&&clearTimeout(n)}return{_init:function(){l.events.on("keydown",m),l.events.on("input",e),l.events.on("mousedown",i),l.events.on("keyup input",E),l.events.on("keypress",o),l.events.on("keydown",a),l.events.on("keyup",p),l.events.on("destroy",S),l.events.on("html.inserted",p),l.events.on("cut",t),l.events.on("click",b)},ctrlKey:u,isCharacter:h,isArrow:g,forceUndo:function(){n&&(clearTimeout(n),l.undo.saveStep(),r=null)},isIME:function(){return c},isBrowserAction:function(e){var t=e.which;return u(e)||t==M.FE.KEYCODE.F5},positionCaret:s}},M.FE.MODULES.accessibility=function(f){var i=!0;function s(t){t&&t.length&&!f.$el.find('[contenteditable="true"]').is(":focus")&&(t.data("blur-event-set")||t.parents(".fr-popup").length||(f.events.$on(t,"blur",function(){var e=t.parents(".fr-toolbar, .fr-popup").data("instance")||f;e.events.blurActive()&&e.events.trigger("blur"),setTimeout(function(){e.events.enableBlur()},100)},!0),t.data("blur-event-set",!0)),(t.parents(".fr-toolbar, .fr-popup").data("instance")||f).events.disableBlur(),t.focus(),f.shared.$f_el=t)}function p(e,t){var n=t?"last":"first",r=e.find("button:visible:not(.fr-disabled), .fr-group span.fr-command:visible")[n]();if(r.length)return s(r),!0}function a(e){return e.is("input, textarea, select")&&t(),f.events.disableBlur(),e.focus(),!0}function u(e,t){var n=e.find("input, textarea, button, select").filter(":visible").not(":disabled").filter(t?":last":":first");if(n.length)return a(n);if(f.shared.with_kb){var r=e.find(".fr-active-item:visible:first");if(r.length)return a(r);var o=e.find("[tabIndex]:visible:first");if(o.length)return a(o)}}function t(){0===f.$el.find(".fr-marker").length&&f.core.hasFocus()&&f.selection.save()}function l(){var e=f.popups.areVisible();if(e){var t=e.find(".fr-buttons");return t.find("button:focus, .fr-group span:focus").length?!p(e.data("instance").$tb):!p(t)}return!p(f.$tb)}function d(){var e=null;return f.shared.$f_el.is(".fr-dropdown.fr-active")?e=f.shared.$f_el:f.shared.$f_el.closest(".fr-dropdown-menu").prev().is(".fr-dropdown.fr-active")&&(e=f.shared.$f_el.closest(".fr-dropdown-menu").prev()),e}function n(e,t,n){if(f.shared.$f_el){var r=d();r&&(f.button.click(r),f.shared.$f_el=r);var o=e.find("button:visible:not(.fr-disabled), .fr-group span.fr-command:visible"),i=o.index(f.shared.$f_el);if(0===i&&!n||i==o.length-1&&n){var a;if(t){if(e.parent().is(".fr-popup"))a=!u(e.parent().children().not(".fr-buttons"),!n);!1===a&&(f.shared.$f_el=null)}t&&!1===a||p(e,!n)}else s(M(o.get(i+(n?1:-1))));return!1}}function c(e,t){return n(e,t,!0)}function g(e,t){return n(e,t)}function h(e){if(f.shared.$f_el){var t;if(f.shared.$f_el.is(".fr-dropdown.fr-active"))return s(t=e?f.shared.$f_el.next().find(".fr-command:not(.fr-disabled)").first():f.shared.$f_el.next().find(".fr-command:not(.fr-disabled)").last()),!1;if(f.shared.$f_el.is("a.fr-command"))return(t=e?f.shared.$f_el.closest("li").nextAll(":visible:first").find(".fr-command:not(.fr-disabled)").first():f.shared.$f_el.closest("li").prevAll(":visible:first").find(".fr-command:not(.fr-disabled)").first()).length||(t=e?f.shared.$f_el.closest(".fr-dropdown-menu").find(".fr-command:not(.fr-disabled)").first():f.shared.$f_el.closest(".fr-dropdown-menu").find(".fr-command:not(.fr-disabled)").last()),s(t),!1}}function m(){if(f.shared.$f_el){if(f.shared.$f_el.hasClass("fr-dropdown"))f.button.click(f.shared.$f_el);else if(f.shared.$f_el.is("button.fr-back")){f.opts.toolbarInline&&(f.events.disableBlur(),f.events.focus());var e=f.popups.areVisible(f);e&&(f.shared.with_kb=!1),f.button.click(f.shared.$f_el),v(e)}else{if(f.events.disableBlur(),f.button.click(f.shared.$f_el),f.shared.$f_el.attr("data-popup")){var t=f.popups.areVisible(f);t&&t.data("popup-button",f.shared.$f_el)}else if(f.shared.$f_el.attr("data-modal")){var n=f.modals.areVisible(f);n&&n.data("modal-button",f.shared.$f_el)}f.shared.$f_el=null}return!1}}function E(){f.shared.$f_el&&(f.events.disableBlur(),f.shared.$f_el.blur(),f.shared.$f_el=null),!1!==f.events.trigger("toolbar.focusEditor")&&(f.events.disableBlur(),f.$el.focus(),f.events.focus())}function r(r){r&&r.length&&(f.events.$on(r,"keydown",function(e){if(!M(e.target).is("a.fr-command, button.fr-command, .fr-group span.fr-command"))return!0;var t=r.parents(".fr-popup").data("instance")||r.data("instance")||f;f.shared.with_kb=!0;var n=t.accessibility.exec(e,r);return f.shared.with_kb=!1,n},!0),f.events.$on(r,"mouseenter","[tabIndex]",function(e){var t=r.parents(".fr-popup").data("instance")||r.data("instance")||f;if(!i)return e.stopPropagation(),void e.preventDefault();var n=M(e.currentTarget);t.shared.$f_el&&t.shared.$f_el.not(n)&&t.accessibility.focusEditor()},!0))}function v(e){var t=e.data("popup-button");t&&setTimeout(function(){s(t),e.data("popup-button",null)},0)}function o(e){var t=f.popups.areVisible(e);t&&t.data("popup-button",null)}function e(e){var t=-1!=navigator.userAgent.indexOf("Mac OS X")?e.metaKey:e.ctrlKey;if(e.which==M.FE.KEYCODE.F10&&!t&&!e.shiftKey&&e.altKey){f.shared.with_kb=!0;var n=f.popups.areVisible(f),r=!1;return n&&(r=u(n.children().not(".fr-buttons"))),r||l(),f.shared.with_kb=!1,e.preventDefault(),e.stopPropagation(),!1}return!0}return{_init:function(){f.$wp?f.events.on("keydown",e,!0):f.events.$on(f.$win,"keydown",e,!0),f.events.on("mousedown",function(e){o(f),f.shared.$f_el&&(f.accessibility.restoreSelection(),e.stopPropagation(),f.events.disableBlur(),f.shared.$f_el=null)},!0),f.events.on("blur",function(){f.shared.$f_el=null,o(f)},!0)},registerPopup:function(e){var d,c,t=f.popups.get(e),n=(d=e,c=f.popups.get(d),{_tiKeydown:function(e){var t=c.data("instance")||f;if(!1===t.events.trigger("popup.tab",[e]))return!1;var n=e.which,r=c.find(":focus:first");if(M.FE.KEYCODE.TAB==n){e.preventDefault();var o=c.children().not(".fr-buttons"),i=o.find("input, textarea, button, select").filter(":visible").not(".fr-no-touch input, .fr-no-touch textarea, .fr-no-touch button, .fr-no-touch select, :disabled").toArray(),a=i.indexOf(this)+(e.shiftKey?-1:1);if(0<=a&&a<i.length)return t.events.disableBlur(),M(i[a]).focus(),e.stopPropagation(),!1;var s=c.find(".fr-buttons");if(s.length&&p(s,!!e.shiftKey))return e.stopPropagation(),!1;if(u(o))return e.stopPropagation(),!1}else{if(M.FE.KEYCODE.ENTER!=n||!e.target||"TEXTAREA"===e.target.tagName)return M.FE.KEYCODE.ESC==n?(e.preventDefault(),e.stopPropagation(),t.accessibility.restoreSelection(),t.popups.isVisible(d)&&c.find(".fr-back:visible").length?(t.opts.toolbarInline&&(t.events.disableBlur(),t.events.focus()),t.button.exec(c.find(".fr-back:visible:first")),v(c)):t.popups.isVisible(d)&&c.find(".fr-dismiss:visible").length?t.button.exec(c.find(".fr-dismiss:visible:first")):(t.popups.hide(d),t.opts.toolbarInline&&t.toolbar.showInline(null,!0),v(c)),!1):M.FE.KEYCODE.SPACE==n&&(r.is(".fr-submit")||r.is(".fr-dismiss"))?(e.preventDefault(),e.stopPropagation(),t.events.disableBlur(),t.button.exec(r),!0):t.keys.isBrowserAction(e)?void e.stopPropagation():r.is("input[type=text], textarea")?void e.stopPropagation():M.FE.KEYCODE.SPACE==n&&(r.is(".fr-link-attr")||r.is("input[type=file]"))?void e.stopPropagation():(e.stopPropagation(),e.preventDefault(),!1);var l=null;0<c.find(".fr-submit:visible").length?l=c.find(".fr-submit:visible:first"):c.find(".fr-dismiss:visible").length&&(l=c.find(".fr-dismiss:visible:first")),l&&(e.preventDefault(),e.stopPropagation(),t.events.disableBlur(),t.button.exec(l))}},_tiMouseenter:function(){var e=c.data("instance")||f;o(e)}});r(t.find(".fr-buttons")),f.events.$on(t,"mouseenter","tabIndex",n._tiMouseenter,!0),f.events.$on(t.children().not(".fr-buttons"),"keydown","[tabIndex]",n._tiKeydown,!0),f.popups.onHide(e,function(){(t.data("instance")||f).accessibility.restoreSelection()}),f.popups.onShow(e,function(){i=!1,setTimeout(function(){i=!0},0)})},registerToolbar:r,focusToolbarElement:s,focusToolbar:p,focusContent:u,focusPopup:function(r){var o=r.children().not(".fr-buttons");o.data("mouseenter-event-set")||(f.events.$on(o,"mouseenter","[tabIndex]",function(e){var t=r.data("instance")||f;if(!i)return e.stopPropagation(),void e.preventDefault();var n=o.find(":focus:first");n.length&&!n.is("input, button, textarea, select")&&(t.events.disableBlur(),n.blur(),t.events.disableBlur(),t.events.focus())}),o.data("mouseenter-event-set",!0)),!u(o)&&f.shared.with_kb&&p(r.find(".fr-buttons"))},focusModal:function(e){f.core.hasFocus()||(f.events.disableBlur(),f.events.focus()),f.accessibility.saveSelection(),f.events.disableBlur(),f.$el.blur(),f.selection.clear(),f.events.disableBlur(),f.shared.with_kb?e.find(".fr-command[tabIndex], [tabIndex]").first().focus():e.find("[tabIndex]:first").focus()},focusEditor:E,focusPopupButton:v,focusModalButton:function(e){var t=e.data("modal-button");t&&setTimeout(function(){s(t),e.data("modal-button",null)},0)},hasFocus:function(){return null!=f.shared.$f_el},exec:function(e,t){var n=-1!=navigator.userAgent.indexOf("Mac OS X")?e.metaKey:e.ctrlKey,r=e.which,o=!1;return r!=M.FE.KEYCODE.TAB||n||e.shiftKey||e.altKey?r!=M.FE.KEYCODE.ARROW_RIGHT||n||e.shiftKey||e.altKey?r!=M.FE.KEYCODE.TAB||n||!e.shiftKey||e.altKey?r!=M.FE.KEYCODE.ARROW_LEFT||n||e.shiftKey||e.altKey?r!=M.FE.KEYCODE.ARROW_UP||n||e.shiftKey||e.altKey?r!=M.FE.KEYCODE.ARROW_DOWN||n||e.shiftKey||e.altKey?r!=M.FE.KEYCODE.ENTER&&r!=M.FE.KEYCODE.SPACE||n||e.shiftKey||e.altKey?r!=M.FE.KEYCODE.ESC||n||e.shiftKey||e.altKey?r!=M.FE.KEYCODE.F10||n||e.shiftKey||!e.altKey||(o=l()):o=function(e){if(f.shared.$f_el){var t=d();return t?(f.button.click(t),s(t)):e.parent().find(".fr-back:visible").length?(f.shared.with_kb=!1,f.opts.toolbarInline&&(f.events.disableBlur(),f.events.focus()),f.button.exec(e.parent().find(".fr-back:visible:first")),v(e.parent())):f.shared.$f_el.is("button, .fr-group span")&&(e.parent().is(".fr-popup")?(f.accessibility.restoreSelection(),f.shared.$f_el=null,!1!==f.events.trigger("toolbar.esc")&&(f.popups.hide(e.parent()),f.opts.toolbarInline&&f.toolbar.showInline(null,!0),v(e.parent()))):E()),!1}}(t):o=m():o=f.shared.$f_el&&f.shared.$f_el.is(".fr-dropdown:not(.fr-active)")?m():h(!0):o=h():o=g(t):o=g(t,!0):o=c(t):o=c(t,!0),f.shared.$f_el||o!==undefined||(o=!0),!o&&f.keys.isBrowserAction(e)&&(o=!0),!!o||(e.preventDefault(),e.stopPropagation(),!1)},saveSelection:t,restoreSelection:function(){f.$el.find(".fr-marker").length&&(f.events.disableBlur(),f.selection.restore(),f.events.enableBlur())}}},M.FE.MODULES.format=function(h){function l(e,t){var n="<"+e;for(var r in t)t.hasOwnProperty(r)&&(n+=" "+r+'="'+t[r]+'"');return n+=">"}function f(e,t){var n=e;for(var r in t)t.hasOwnProperty(r)&&(n+="id"==r?"#"+t[r]:"class"==r?"."+t[r]:"["+r+'="'+t[r]+'"]');return n}function p(e,t){return!(!e||e.nodeType!=Node.ELEMENT_NODE)&&(e.matches||e.matchesSelector||e.msMatchesSelector||e.mozMatchesSelector||e.webkitMatchesSelector||e.oMatchesSelector).call(e,t)}function m(e,t,n){if(e){for(;e.nodeType===Node.COMMENT_NODE;)e=e.nextSibling;if(e){if(h.node.isBlock(e)&&"HR"!==e.tagName)return m(e.firstChild,t,n),!1;for(var r=M(l(t,n)).insertBefore(e),o=e;o&&!M(o).is(".fr-marker")&&0===M(o).find(".fr-marker").length&&"UL"!=o.tagName&&"OL"!=o.tagName;){var i=o;o=o.nextSibling,r.append(i)}if(o)(M(o).find(".fr-marker").length||"UL"==o.tagName||"OL"==o.tagName)&&m(o.firstChild,t,n);else{for(var a=r.get(0).parentNode;a&&!a.nextSibling&&!h.node.isElement(a);)a=a.parentNode;if(a){var s=a.nextSibling;s&&(h.node.isBlock(s)?"HR"===s.tagName?m(s.nextSibling,t,n):m(s.firstChild,t,n):m(s,t,n))}}r.is(":empty")&&r.remove()}}}function n(e,t){var n;if(void 0===t&&(t={}),t.style&&delete t.style,h.selection.isCollapsed()){h.markers.insert(),h.$el.find(".fr-marker").replaceWith(l(e,t)+M.FE.INVISIBLE_SPACE+M.FE.MARKERS+("</"+e+">")),h.selection.restore()}else{var r;h.selection.save(),m(h.$el.find('.fr-marker[data-type="true"]').get(0).nextSibling,e,t);do{for(r=h.$el.find(f(e,t)+" > "+f(e,t)),n=0;n<r.length;n++)r[n].outerHTML=r[n].innerHTML}while(r.length);h.el.normalize();var o=h.el.querySelectorAll(".fr-marker");for(n=0;n<o.length;n++){var i=M(o[n]);!0===i.data("type")?p(i.get(0).nextSibling,f(e,t))&&i.next().prepend(i):p(i.get(0).previousSibling,f(e,t))&&i.prev().append(i)}h.selection.restore()}}function E(e,t,n,r){if(!r){var o=!1;if(!0===e.data("type"))for(;h.node.isFirstSibling(e.get(0))&&!e.parent().is(h.$el)&&!e.parent().is("ol")&&!e.parent().is("ul");)e.parent().before(e),o=!0;else if(!1===e.data("type"))for(;h.node.isLastSibling(e.get(0))&&!e.parent().is(h.$el)&&!e.parent().is("ol")&&!e.parent().is("ul");)e.parent().after(e),o=!0;if(o)return!0}if(e.parents(t).length||void 0===t){var i="",a="",s=e.parent();if(s.is(h.$el)||h.node.isBlock(s.get(0)))return!1;for(;!h.node.isBlock(s.parent().get(0))&&(void 0===t||void 0!==t&&!p(s.get(0),f(t,n)));)i+=h.node.closeTagString(s.get(0)),a=h.node.openTagString(s.get(0))+a,s=s.parent();var l=e.get(0).outerHTML;e.replaceWith('<span id="mark"></span>');var d=s.html().replace(/<span id="mark"><\/span>/,i+h.node.closeTagString(s.get(0))+a+l+i+h.node.openTagString(s.get(0))+a);return s.replaceWith(h.node.openTagString(s.get(0))+d+h.node.closeTagString(s.get(0))),!0}return!1}function r(t,n){void 0===n&&(n={}),n.style&&delete n.style;var r=h.selection.isCollapsed();h.selection.save();for(var o=!0;o;){o=!1;for(var i=h.$el.find(".fr-marker"),a=0;a<i.length;a++){var s=M(i[a]),l=null;if(s.attr("data-cloned")||r||(l=s.clone().removeClass("fr-marker").addClass("fr-clone"),!0===s.data("type")?s.attr("data-cloned",!0).after(l):s.attr("data-cloned",!0).before(l)),E(s,t,n,r)){o=!0;break}}}!function e(t,n,r,o){for(var i=h.node.contents(t.get(0)),a=0;a<i.length;a++){var s=i[a];if(h.node.hasClass(s,"fr-marker"))n=(n+1)%2;else if(n)if(0<M(s).find(".fr-marker").length)n=e(M(s),n,r,o);else{for(var l=M(s).find(r||"*:not(a):not(br)"),d=l.length-1;0<=d;d--){var c=l[d];h.node.isBlock(c)||h.node.isVoid(c)||void 0!==r&&!p(c,f(r,o))?h.node.isBlock(c)&&void 0===r&&"TABLE"!=s.tagName&&h.node.clearAttributes(c):h.node.hasClass(c,"fr-clone")||(c.outerHTML=c.innerHTML)}void 0===r&&s.nodeType==Node.ELEMENT_NODE&&!h.node.isVoid(s)||p(s,f(r,o))?M(s).replaceWith(s.innerHTML):void 0===r&&s.nodeType==Node.ELEMENT_NODE&&h.node.isBlock(s)&&"TABLE"!=s.tagName&&h.node.clearAttributes(s)}else 0<M(s).find(".fr-marker").length&&(n=e(M(s),n,r,o))}return n}(h.$el,0,t,n),r||(h.$el.find(".fr-marker").remove(),h.$el.find(".fr-clone").removeClass("fr-clone").addClass("fr-marker")),r&&h.$el.find(".fr-marker").before(M.FE.INVISIBLE_SPACE).after(M.FE.INVISIBLE_SPACE),h.html.cleanEmptyTags(),h.el.normalize(),h.selection.restore()}function t(e,t){var n,r,o,i,a,s=null;if(h.selection.isCollapsed()){h.markers.insert();var l=(r=h.$el.find(".fr-marker")).parent();if(h.node.openTagString(l.get(0))=='<span style="'+e+": "+l.css(e)+';">'){if(h.node.isEmpty(l.get(0)))s=M('<span style="'+e+": "+t+';">'+M.FE.INVISIBLE_SPACE+M.FE.MARKERS+"</span>"),l.replaceWith(s);else{var d={};d["style*"]=e+":",E(r,"span",d,!0),r=h.$el.find(".fr-marker"),t?(s=M('<span style="'+e+": "+t+';">'+M.FE.INVISIBLE_SPACE+M.FE.MARKERS+"</span>"),r.replaceWith(s)):r.replaceWith(M.FE.INVISIBLE_SPACE+M.FE.MARKERS)}h.html.cleanEmptyTags()}else h.node.isEmpty(l.get(0))&&l.is("span")?(r.replaceWith(M.FE.MARKERS),l.css(e,t)):(s=M('<span style="'+e+": "+t+';">'+M.FE.INVISIBLE_SPACE+M.FE.MARKERS+"</span>"),r.replaceWith(s));s&&v(s,e,t)}else{if(h.selection.save(),null==t||"color"==e&&0<h.$el.find(".fr-marker").parents("u, a").length){var c=h.$el.find(".fr-marker");for(n=0;n<c.length;n++)if(!0===(r=M(c[n])).data("type"))for(;h.node.isFirstSibling(r.get(0))&&!r.parent().is(h.$el)&&!h.node.isElement(r.parent().get(0))&&!h.node.isBlock(r.parent().get(0));)r.parent().before(r);else for(;h.node.isLastSibling(r.get(0))&&!r.parent().is(h.$el)&&!h.node.isElement(r.parent().get(0))&&!h.node.isBlock(r.parent().get(0));)r.parent().after(r)}var f=h.$el.find('.fr-marker[data-type="true"]').get(0).nextSibling,p={"class":"fr-unprocessed"};for(t&&(p.style=e+": "+t+";"),m(f,"span",p),h.$el.find(".fr-marker + .fr-unprocessed").each(function(){M(this).prepend(M(this).prev())}),h.$el.find(".fr-unprocessed + .fr-marker").each(function(){M(this).prev().append(this)}),(t||"").match(/\dem$/)&&h.$el.find("span.fr-unprocessed").removeClass("fr-unprocessed");0<h.$el.find("span.fr-unprocessed").length;){if((s=h.$el.find("span.fr-unprocessed:first").removeClass("fr-unprocessed")).parent().get(0).normalize(),s.parent().is("span")&&1==s.parent().get(0).childNodes.length){s.parent().css(e,t);var u=s;s=s.parent(),u.replaceWith(u.html())}var g=s.find("span");for(n=g.length-1;0<=n;n--)o=g[n],i=e,a=void 0,(a=M(o)).css(i,""),""===a.attr("style")&&a.replaceWith(a.html());v(s,e,t)}}!function(){var e;for(;0<h.$el.find(".fr-split:empty").length;)h.$el.find(".fr-split:empty").remove();h.$el.find(".fr-split").removeClass("fr-split"),h.$el.find('[style=""]').removeAttr("style"),h.$el.find('[class=""]').removeAttr("class"),h.html.cleanEmptyTags(),M(h.$el.find("span").get().reverse()).each(function(){this.attributes&&0!==this.attributes.length||M(this).replaceWith(this.innerHTML)}),h.el.normalize();var t=h.$el.find("span[style] + span[style]");for(e=0;e<t.length;e++){var n=M(t[e]),r=M(t[e]).prev();n.get(0).previousSibling==r.get(0)&&h.node.openTagString(n.get(0))==h.node.openTagString(r.get(0))&&(n.prepend(r.html()),r.remove())}h.$el.find("span[style] span[style]").each(function(){if(0<=M(this).attr("style").indexOf("font-size")){var e=M(this).parents("span[style]");0<=e.attr("style").indexOf("background-color")&&(M(this).attr("style",M(this).attr("style")+";"+e.attr("style")),E(M(this),"span[style]",{},!1))}}),h.el.normalize(),h.selection.restore()}()}function v(e,t,n){var r,o,i,a=e.parentsUntil(h.$el,"span[style]"),s=[];for(r=a.length-1;0<=r;r--)o=a[r],i=t,0===M(o).attr("style").indexOf(i+":")||0<=M(o).attr("style").indexOf(";"+i+":")||0<=M(o).attr("style").indexOf("; "+i+":")||s.push(a[r]);if((a=a.not(s)).length){for(var l="",d="",c="",f="",p=e.get(0);p=p.parentNode,M(p).addClass("fr-split"),l+=h.node.closeTagString(p),d=h.node.openTagString(M(p).clone().addClass("fr-split").get(0))+d,a.get(0)!=p&&(c+=h.node.closeTagString(p),f=h.node.openTagString(M(p).clone().addClass("fr-split").get(0))+f),a.get(0)!=p;);var u=l+h.node.openTagString(M(a.get(0)).clone().css(t,n||"").get(0))+f+e.css(t,"").get(0).outerHTML+c+"</span>"+d;e.replaceWith('<span id="fr-break"></span>');var g=a.get(0).outerHTML;M(a.get(0)).replaceWith(g.replace(/<span id="fr-break"><\/span>/g,u))}}function o(e,t){void 0===t&&(t={}),t.style&&delete t.style;var n=h.selection.ranges(0),r=n.startContainer;if(r.nodeType==Node.ELEMENT_NODE&&0<r.childNodes.length&&r.childNodes[n.startOffset]&&(r=r.childNodes[n.startOffset]),!n.collapsed&&r.nodeType==Node.TEXT_NODE&&n.startOffset==(r.textContent||"").length){for(;!h.node.isBlock(r.parentNode)&&!r.nextSibling;)r=r.parentNode;r.nextSibling&&(r=r.nextSibling)}for(var o=r;o&&o.nodeType==Node.ELEMENT_NODE&&!p(o,f(e,t));)o=o.firstChild;if(o&&o.nodeType==Node.ELEMENT_NODE&&p(o,f(e,t)))return!0;var i=r;for(i&&i.nodeType!=Node.ELEMENT_NODE&&(i=i.parentNode);i&&i.nodeType==Node.ELEMENT_NODE&&i!=h.el&&!p(i,f(e,t));)i=i.parentNode;return!(!i||i.nodeType!=Node.ELEMENT_NODE||i==h.el||!p(i,f(e,t)))}return{is:o,toggle:function(e,t){o(e,t)?r(e,t):n(e,t)},apply:n,remove:r,applyStyle:t,removeStyle:function(e){t(e,null)}}},M.extend(M.FE.DEFAULTS,{indentMargin:20}),M.FE.COMMANDS={bold:{title:"Bold",toggle:!0,refresh:function(e){var t=this.format.is("strong");e.toggleClass("fr-active",t).attr("aria-pressed",t)}},italic:{title:"Italic",toggle:!0,refresh:function(e){var t=this.format.is("em");e.toggleClass("fr-active",t).attr("aria-pressed",t)}},underline:{title:"Underline",toggle:!0,refresh:function(e){var t=this.format.is("u");e.toggleClass("fr-active",t).attr("aria-pressed",t)}},strikeThrough:{title:"Strikethrough",toggle:!0,refresh:function(e){var t=this.format.is("s");e.toggleClass("fr-active",t).attr("aria-pressed",t)}},subscript:{title:"Subscript",toggle:!0,refresh:function(e){var t=this.format.is("sub");e.toggleClass("fr-active",t).attr("aria-pressed",t)}},superscript:{title:"Superscript",toggle:!0,refresh:function(e){var t=this.format.is("sup");e.toggleClass("fr-active",t).attr("aria-pressed",t)}},outdent:{title:"Decrease Indent"},indent:{title:"Increase Indent"},undo:{title:"Undo",undo:!1,forcedRefresh:!0,disabled:!0},redo:{title:"Redo",undo:!1,forcedRefresh:!0,disabled:!0},insertHR:{title:"Insert Horizontal Line"},clearFormatting:{title:"Clear Formatting"},selectAll:{title:"Select All",undo:!1}},M.FE.RegisterCommand=function(e,t){M.FE.COMMANDS[e]=t},M.FE.MODULES.commands=function(a){function o(e){return a.html.defaultTag()&&(e="<"+a.html.defaultTag()+">"+e+"</"+a.html.defaultTag()+">"),e}var i={bold:function(){e("bold","strong")},subscript:function(){a.format.is("sup")&&a.format.remove("sup"),e("subscript","sub")},superscript:function(){a.format.is("sub")&&a.format.remove("sub"),e("superscript","sup")},italic:function(){e("italic","em")},strikeThrough:function(){e("strikeThrough","s")},underline:function(){e("underline","u")},undo:function(){a.undo.run()},redo:function(){a.undo.redo()},indent:function(){n(1)},outdent:function(){n(-1)},show:function(){a.opts.toolbarInline&&a.toolbar.showInline(null,!0)},insertHR:function(){a.selection.remove();var e="";a.core.isEmpty()&&(e=o(e="<br>")),a.html.insert('<hr id="fr-just">'+e);var t,n=a.$el.find("hr#fr-just");if(n.removeAttr("id"),0===n.next().length){var r=a.html.defaultTag();r?n.after(M("<"+r+">").append("<br>")):n.after("<br>")}n.prev().is("hr")?t=a.selection.setAfter(n.get(0),!1):n.next().is("hr")?t=a.selection.setBefore(n.get(0),!1):a.selection.setAfter(n.get(0),!1)||a.selection.setBefore(n.get(0),!1),t||void 0===t||(e=o(e=M.FE.MARKERS+"<br>"),n.after(e)),a.selection.restore()},clearFormatting:function(){a.format.remove()},selectAll:function(){a.doc.execCommand("selectAll",!1,!1)}};function t(e,t){if(!1!==a.events.trigger("commands.before",M.merge([e],t||[]))){var n=M.FE.COMMANDS[e]&&M.FE.COMMANDS[e].callback||i[e],r=!0,o=!1;M.FE.COMMANDS[e]&&("undefined"!=typeof M.FE.COMMANDS[e].focus&&(r=M.FE.COMMANDS[e].focus),"undefined"!=typeof M.FE.COMMANDS[e].accessibilityFocus&&(o=M.FE.COMMANDS[e].accessibilityFocus)),(!a.core.hasFocus()&&r&&!a.popups.areVisible()||!a.core.hasFocus()&&o&&a.accessibility.hasFocus())&&a.events.focus(!0),M.FE.COMMANDS[e]&&!1!==M.FE.COMMANDS[e].undo&&(a.$el.find(".fr-marker").length&&(a.events.disableBlur(),a.selection.restore()),a.undo.saveStep()),n&&n.apply(a,M.merge([e],t||[])),a.events.trigger("commands.after",M.merge([e],t||[])),M.FE.COMMANDS[e]&&!1!==M.FE.COMMANDS[e].undo&&a.undo.saveStep()}}function e(e,t){a.format.toggle(t)}function n(e){a.selection.save(),a.html.wrap(!0,!0,!0,!0),a.selection.restore();for(var t=a.selection.blocks(),n=0;n<t.length;n++)if("LI"!=t[n].tagName&&"LI"!=t[n].parentNode.tagName){var r=M(t[n]),o="rtl"==a.opts.direction||"rtl"==r.css("direction")?"margin-right":"margin-left",i=a.helpers.getPX(r.css(o));if(r.width()<2*a.opts.indentMargin&&0<e)continue;r.css(o,Math.max(i+e*a.opts.indentMargin,0)||""),r.removeClass("fr-temp-div")}a.selection.save(),a.html.unwrap(),a.selection.restore()}function r(e){return function(){t(e)}}var s={};for(var l in i)i.hasOwnProperty(l)&&(s[l]=r(l));return M.extend(s,{exec:t,_init:function(){a.events.on("keydown",function(e){var t=a.selection.element();if(t&&"HR"==t.tagName&&!a.keys.isArrow(e.which))return e.preventDefault(),!1}),a.events.on("keyup",function(e){var t=a.selection.element();if(t&&"HR"==t.tagName)if(e.which==M.FE.KEYCODE.ARROW_LEFT||e.which==M.FE.KEYCODE.ARROW_UP){if(t.previousSibling)return a.node.isBlock(t.previousSibling)?a.selection.setAtEnd(t.previousSibling):M(t).before(M.FE.MARKERS),a.selection.restore(),!1}else if((e.which==M.FE.KEYCODE.ARROW_RIGHT||e.which==M.FE.KEYCODE.ARROW_DOWN)&&t.nextSibling)return a.node.isBlock(t.nextSibling)?a.selection.setAtStart(t.nextSibling):M(t).after(M.FE.MARKERS),a.selection.restore(),!1}),a.events.on("mousedown",function(e){if(e.target&&"HR"==e.target.tagName)return e.preventDefault(),e.stopPropagation(),!1}),a.events.on("mouseup",function(){var e=a.selection.element();e==a.selection.endElement()&&e&&"HR"==e.tagName&&(e.nextSibling&&(a.node.isBlock(e.nextSibling)?a.selection.setAtStart(e.nextSibling):M(e).after(M.FE.MARKERS)),a.selection.restore())})}})},M.FE.MODULES.data=function(f){var p="NCKB1zwtPA9tqzajXC2c2A7B-16VD3spzJ1C9C3D5oOF2OB1NB1LD7VA5QF4TE3gytXB2A4C-8VA2AC4E1D3GB2EB2KC3KD1MF1juuSB1A8C6yfbmd1B2a1A5qdsdB2tivbC3CB1KC1CH1eLA2sTF1B4I4H-7B-21UB6b1F5bzzzyAB4JC3MG2hjdKC1JE6C1E1cj1pD-16pUE5B4prra2B5ZB3D3C3pxj1EA6A3rnJA2C-7I-7JD9D1E1wYH1F3sTB5TA2G4H4ZA22qZA5BB3mjcvcCC3JB1xillavC-21VE6PC5SI4YC5C8mb1A3WC3BD2B5aoDA2qqAE3A5D-17fOD1D5RD4WC10tE6OAZC3nF-7b1C4A4D3qCF2fgmapcromlHA2QA6a1E1D3e1A6C2bie2F4iddnIA7B2mvnwcIB5OA1DB2OLQA3PB10WC7WC5d1E3uI-7b1D5D6b1E4D2arlAA4EA1F-11srxI-7MB1D7PF1E5B4adB-21YD5vrZH3D3xAC4E1A2GF2CF2J-7yNC2JE1MI2hH-7QB1C6B5B-9bA-7XB13a1B5VievwpKB4LA3NF-10H-9I-8hhaC-16nqPG4wsleTD5zqYF3h1G2B7B4yvGE2Pi1H-7C-21OE6B1uLD1kI4WC1E7C5g1D-8fue1C8C6c1D4D3Hpi1CC4kvGC2E1legallyXB4axVA11rsA4A-9nkdtlmzBA2GD3A13A6CB1dabE1lezrUE6RD5TB4A-7f1C8c1B5d1D4D3tyfCD5C2D2==",u=function(){for(var e=0,t=document.domain,n=t.split("."),r="_gd"+(new Date).getTime();e<n.length-1&&-1==document.cookie.indexOf(r+"="+r);)t=n.slice(-1-++e).join("."),document.cookie=r+"="+r+";domain="+t+";";return document.cookie=r+"=;expires=Thu, 01 Jan 1970 00:00:01 GMT;domain="+t+";",(t||"").replace(/(^\.*)|(\.*$)/g,"")}();function g(e){return e}var h,m,E=g(function(e){if(!e)return e;for(var t="",n=g("charCodeAt"),r=g("fromCharCode"),o="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789".indexOf(e[0]),i=1;i<e.length-2;i++){for(var a=d(++o),s=e[n](i),l="";/[0-9-]/.test(e[i+1]);)l+=e[++i];s=v(s,a,l=parseInt(l,10)||0),s^=o-1&31,t+=String[r](s)}return t});function d(e){for(var t=e.toString(),n=0,r=0;r<t.length;r++)n+=parseInt(t.charAt(r),10);return 10<n?n%9+1:n}function v(e,t,n){for(var r=Math.abs(n);0<r--;)e-=t;return n<0&&(e+=123),e}function b(e){return!(!e||"block"===e.css("display")||(e.remove(),0))}function S(e){return e&&0===f.$box.find(e).length}var e=0;function T(){if(10<e&&(f[g(E("0ppecjvc=="))](),setTimeout(function(){M.FE=null},10)),!f.$box)return!1;f.$wp.prepend(E(g(E(p)))),h=f.$wp.find("> div:first"),m=h.find("> a"),"rtl"==f.opts.direction&&h.css("left","auto").css("right",0).attr("direction","rtl"),e++}function y(e){for(var t=[E("9qqG-7amjlwq=="),E("KA3B3C2A6D1D5H5H1A3=="),E("3B9B3B5F3C4G3E3=="),E("QzbzvxyB2yA-9m=="),E("ji1kacwmgG5bc=="),E("nmA-13aogi1A3c1jd==")],n=0;n<t.length;n++)if(String.prototype.endsWith||(String.prototype.endsWith=function(e,t){return(t===undefined||t>this.length)&&(t=this.length),this.substring(t-e.length,t)===e}),e.endsWith(t[n]))return!0;return!1}return{_init:function(){var e=f.o_win.FEK;try{e=e||localStorage&&localStorage.FEK}catch(v){}e=f.opts.key||e||[""];var t=E(g("ziRA1E3B9pA5B-11D-11xg1A3ZB5D1D4B-11ED2EG2pdeoC1clIH4wB-22yQD5uF4YE3E3A9=="));"string"==typeof e&&(e=[e]);for(var n,r,o,i=!(f.ul=!0),a=0,s=0;s<e.length;s++){var l=(r=e[s],3===(o=(E(r)||"").split("|")).length?o:[null,null,E(r)||""]),d=l[2];if(d===E(g(E("mcVRDoB1BGILD7YFe1BTXBA7B6==")))||0<=d.indexOf(u,d.length-u.length)||y(u)){if(!((null===(n=l[1])||new Date(n)<new Date(E("lC4B3B3D4B5A1E1E4I1A1==")))&&0<(u||"").length)||y(u)){f.ul=!1;break}i=!0,p="RCZB17botVG4A-8yzia1C4A5DG3CD2cFB4qflmCE4I2FB1SC7F6PE4WE3RD6e2A4c1D3d1E2E3ehxdGE3CE2IB2LC1HG2LE1QA3QC7B-13cC-9epmkjc1B4e1C4pgjgvkOC5E1eNE1HB2LD2B-13WD5tvabUA5a1A4f1A2G3C2A-21cihKE3FE2DB2cccJE1iC-7G-7tD-17tVD6A-9qC-7QC7a1E4B4je1E3E2G2ecmsAA1xH-8HB11C1D1lgzQA3dTB8od1D4XE3ohb1B4E4D3mbLA10NA7C-21d1genodKC11PD9PE5tA-8UI3ZC5XB5B-11qXF2F-7wtwjAG3NA1IB1OD1HC1RD4QJ4evUF2D5XG2G4XA8pqocH1F3G2J2hcpHC4D1MD4C1MB8PD5klcQD1A8A6e2A3ed1E2A24A7HC5C3qA-9tiA-61dcC3MD1LE1D4SA3A9ZZXSE4g1C3Pa2C5ufbcGI3I2B4skLF2CA1vxB-22wgUC4kdH-8cVB5iwe1A2D3H3G-7DD5JC2ED2OH2JB10D3C2xHE1KA29PB11wdC-11C4cixb2C7a1C4YYE3B2A15uB-21wpCA1MF1NuC-21dyzD6pPG4I-7pmjc1A4yte1F3B-22yvCC3VbC-7qC-22qNE2hC1vH-8zad1RF6WF3DpI-7C8A-16hpf1F3D2ylalB-13BB2lpA-63IB3uOF6D5G4gabC-21UD2A3PH4ZA20B11b2C6ED4A2H3I1A15DB4KD2laC-8LA5B8B7==",a=l[0]||-1}}var c=new Image;!0===f.ul&&(T(),c.src=i?g(E(t))+"e="+a:g(E(t))+"u"),!0===f.ul&&f.events.on("contentChanged",function(){(b(h)||b(m)||S(h)||S(m))&&T()}),f.events.on("destroy",function(){h&&h.length&&h.remove()},!0)}}},M.extend(M.FE.DEFAULTS,{pastePlain:!1,pasteDeniedTags:["colgroup","col","meta"],pasteDeniedAttrs:["class","id","style"],pasteAllowedStyleProps:[".*"],pasteAllowLocalImages:!1}),M.FE.MODULES.paste=function(b){var a,s,o,S;function n(e,t){try{b.win.localStorage.setItem("fr-copied-html",e),b.win.localStorage.setItem("fr-copied-text",t)}catch(n){}}function e(e){var t=b.html.getSelected();n(t,M("<div>").html(t).text()),"cut"==e.type&&(b.undo.saveStep(),setTimeout(function(){b.selection.save(),b.html.wrap(),b.selection.restore(),b.events.focus(),b.undo.saveStep()},0))}var i=!1;function t(e){if(i)return!1;if(e.originalEvent&&(e=e.originalEvent),!1===b.events.trigger("paste.before",[e]))return e.preventDefault(),!1;if(b.$win.scrollTop(),e&&e.clipboardData&&e.clipboardData.getData){var t="",n=e.clipboardData.types;if(b.helpers.isArray(n))for(var r=0;r<n.length;r++)t+=n[r]+";";else t=n;if(a="",/text\/rtf/.test(t)&&(s=e.clipboardData.getData("text/rtf")),/text\/html/.test(t)&&!b.browser.safari?a=e.clipboardData.getData("text/html"):/text\/rtf/.test(t)&&b.browser.safari?a=s:/public.rtf/.test(t)&&b.browser.safari&&(a=e.clipboardData.getData("text/rtf")),""!==a)return l(),e.preventDefault&&(e.stopPropagation(),e.preventDefault()),!1;a=null}return function(){b.selection.save(),b.events.disableBlur(),a=null,o?(o.html(""),b.browser.edge&&b.opts.iframe&&b.$el.append(o)):(o=M('<div contenteditable="true" style="position: fixed; top: 0; left: -9999px; height: 100%; width: 0; word-break: break-all; overflow:hidden; z-index: 2147483647; line-height: 140%; -moz-user-select: text; -webkit-user-select: text; -ms-user-select: text; user-select: text;" tabIndex="-1"></div>'),b.browser.webkit?(o.css("top",b.$sc.scrollTop()),b.$el.after(o)):b.browser.edge&&b.opts.iframe?b.$el.append(o):b.$box.after(o),b.events.on("destroy",function(){o.remove()}));o.focus(),b.win.setTimeout(l,1)}(),!1}function r(e){if(e.originalEvent&&(e=e.originalEvent),e&&e.dataTransfer&&e.dataTransfer.getData){var t="",n=e.dataTransfer.types;if(b.helpers.isArray(n))for(var r=0;r<n.length;r++)t+=n[r]+";";else t=n;if(a="",/text\/rtf/.test(t)&&(s=e.dataTransfer.getData("text/rtf")),/text\/html/.test(t)?a=e.dataTransfer.getData("text/html"):/text\/rtf/.test(t)&&b.browser.safari?a=s:/text\/plain/.test(t)&&!this.browser.mozilla&&(a=b.html.escapeEntities(e.dataTransfer.getData("text/plain")).replace(/\n/g,"<br>")),""!==a){b.keys.forceUndo(),S=b.snapshot.get(),b.selection.save(),b.$el.find(".fr-marker").removeClass("fr-marker").addClass("fr-marker-helper");var o=b.markers.insertAtPoint(e);if(b.$el.find(".fr-marker").removeClass("fr-marker").addClass("fr-marker-placeholder"),b.$el.find(".fr-marker-helper").addClass("fr-marker").removeClass("fr-marker-helper"),b.selection.restore(),b.selection.remove(),b.$el.find(".fr-marker-placeholder").addClass("fr-marker").removeClass("fr-marker-placeholder"),!1!==o){var i=b.el.querySelector(".fr-marker");return M(i).replaceWith(M.FE.MARKERS),b.selection.restore(),l(),e.preventDefault&&(e.stopPropagation(),e.preventDefault()),!1}}else a=null}}function l(){b.browser.edge&&b.opts.iframe&&b.$box.after(o),S||(b.keys.forceUndo(),S=b.snapshot.get()),a||(a=o.get(0).innerHTML,b.selection.restore(),b.events.enableBlur());var e=a.match(/(class=\"?Mso|class=\'?Mso|class="?Xl|class='?Xl|class=Xl|style=\"[^\"]*\bmso\-|style=\'[^\']*\bmso\-|w:WordDocument)/gi),t=b.events.chainTrigger("paste.beforeCleanup",a);t&&"string"==typeof t&&(a=t),(!e||e&&!1!==b.events.trigger("paste.wordPaste",[a]))&&d(a,e)}function T(e){for(var t="",n=0;n++<e;)t+="&nbsp;";return t}function d(e,t,n){var r,o=null,i=null;if(0<=e.toLowerCase().indexOf("<body")){var a="";0<=e.indexOf("<style")&&(a=e.replace(/[.\s\S\w\W<>]*(<style[^>]*>[\s]*[.\s\S\w\W<>]*[\s]*<\/style>)[.\s\S\w\W<>]*/gi,"$1")),e=(e=a+e.replace(/[.\s\S\w\W<>]*<body[^>]*>[\s]*([.\s\S\w\W<>]*)[\s]*<\/body>[.\s\S\w\W<>]*/gi,"$1")).replace(/ \n/g," ").replace(/\n /g," ").replace(/([^>])\n([^<])/g,"$1 $2")}var s=!1;0<=e.indexOf('id="docs-internal-guid')&&(e=e.replace(/^[\w\W\s\S]* id="docs-internal-guid[^>]*>([\w\W\s\S]*)<\/b>[\w\W\s\S]*$/g,"$1"),s=!0),0<=e.indexOf('content="Sheets"')&&(e=e.replace(/width:0px;/g,""));var l=!1;if(!t&&((l=function(e){var t=null;try{t=b.win.localStorage.getItem("fr-copied-text")}catch(n){}return!(!t||M("<div>").html(e).text().replace(/\u00A0/gi," ").replace(/\r|\n/gi,"")!=t.replace(/\u00A0/gi," ").replace(/\r|\n/gi,""))}(e))&&(e=b.win.localStorage.getItem("fr-copied-html")),!l)){var d=b.opts.htmlAllowedStyleProps;b.opts.htmlAllowedStyleProps=b.opts.pasteAllowedStyleProps,b.opts.htmlAllowComments=!1,e=(e=(e=e.replace(/<span class="Apple-tab-span">\s*<\/span>/g,T(b.opts.tabSpaces||4))).replace(/<span class="Apple-tab-span" style="white-space:pre">(\t*)<\/span>/g,function(e,t){return T(t.length*(b.opts.tabSpaces||4))})).replace(/\t/g,T(b.opts.tabSpaces||4)),e=b.clean.html(e,b.opts.pasteDeniedTags,b.opts.pasteDeniedAttrs),b.opts.htmlAllowedStyleProps=d,b.opts.htmlAllowComments=!0,e=(e=(e=y(e)).replace(/\r/g,"")).replace(/^ */g,"").replace(/ *$/g,"")}!t||b.wordPaste&&n||(0===(e=e.replace(/^\n*/g,"").replace(/^ /g,"")).indexOf("<colgroup>")&&(e="<table>"+e+"</table>"),e=y(e=function(e){var t;e=(e=(e=(e=(e=(e=(e=(e=(e=(e=(e=(e=(e=(e=(e=e.replace(/<p(.*?)class="?'?MsoListParagraph"?'? ([\s\S]*?)>([\s\S]*?)<\/p>/gi,"<ul><li>$3</li></ul>")).replace(/<p(.*?)class="?'?NumberedText"?'? ([\s\S]*?)>([\s\S]*?)<\/p>/gi,"<ol><li>$3</li></ol>")).replace(/<p(.*?)class="?'?MsoListParagraphCxSpFirst"?'?([\s\S]*?)(level\d)?([\s\S]*?)>([\s\S]*?)<\/p>/gi,"<ul><li$3>$5</li>")).replace(/<p(.*?)class="?'?NumberedTextCxSpFirst"?'?([\s\S]*?)(level\d)?([\s\S]*?)>([\s\S]*?)<\/p>/gi,"<ol><li$3>$5</li>")).replace(/<p(.*?)class="?'?MsoListParagraphCxSpMiddle"?'?([\s\S]*?)(level\d)?([\s\S]*?)>([\s\S]*?)<\/p>/gi,"<li$3>$5</li>")).replace(/<p(.*?)class="?'?NumberedTextCxSpMiddle"?'?([\s\S]*?)(level\d)?([\s\S]*?)>([\s\S]*?)<\/p>/gi,"<li$3>$5</li>")).replace(/<p(.*?)class="?'?MsoListBullet"?'?([\s\S]*?)(level\d)?([\s\S]*?)>([\s\S]*?)<\/p>/gi,"<li$3>$5</li>")).replace(/<p(.*?)class="?'?MsoListParagraphCxSpLast"?'?([\s\S]*?)(level\d)?([\s\S]*?)>([\s\S]*?)<\/p>/gi,"<li$3>$5</li></ul>")).replace(/<p(.*?)class="?'?NumberedTextCxSpLast"?'?([\s\S]*?)(level\d)?([\s\S]*?)>([\s\S]*?)<\/p>/gi,"<li$3>$5</li></ol>")).replace(/<span([^<]*?)style="?'?mso-list:Ignore"?'?([\s\S]*?)>([\s\S]*?)<span/gi,"<span><span")).replace(/<!--\[if \!supportLists\]-->([\s\S]*?)<!--\[endif\]-->/gi,"")).replace(/<!\[if \!supportLists\]>([\s\S]*?)<!\[endif\]>/gi,"")).replace(/(\n|\r| class=(")?Mso[a-zA-Z0-9]+(")?)/gi," ")).replace(/<!--[\s\S]*?-->/gi,"")).replace(/<(\/)*(meta|link|span|\\?xml:|st1:|o:|font)(.*?)>/gi,"");var n,r=["style","script","applet","embed","noframes","noscript"];for(t=0;t<r.length;t++){var o=new RegExp("<"+r[t]+".*?"+r[t]+"(.*?)>","gi");e=e.replace(o,"")}for(e=(e=(e=e.replace(/&nbsp;/gi," ")).replace(/<td([^>]*)><\/td>/g,"<td$1><br></td>")).replace(/<th([^>]*)><\/th>/g,"<th$1><br></th>");(e=(n=e).replace(/<[^\/>][^>]*><\/[^>]+>/gi,""))!=n;);e=(e=e.replace(/<lilevel([^1])([^>]*)>/gi,'<li data-indent="true"$2>')).replace(/<lilevel1([^>]*)>/gi,"<li$1>"),e=(e=(e=b.clean.html(e,b.opts.pasteDeniedTags,b.opts.pasteDeniedAttrs)).replace(/<a>(.[^<]+)<\/a>/gi,"$1")).replace(/<br> */g,"<br>");var i=b.o_doc.createElement("div");i.innerHTML=e;var a=i.querySelectorAll("li[data-indent]");for(t=0;t<a.length;t++){var s=a[t],l=s.previousElementSibling;if(l&&"LI"==l.tagName){var d=l.querySelector(":scope > ul, :scope > ol");d||(d=document.createElement("ul"),l.appendChild(d)),d.appendChild(s)}else s.removeAttribute("data-indent")}return b.html.cleanBlankSpaces(i),e=i.innerHTML}(e))),b.opts.pastePlain&&!l&&(e=function(e){var t,n=null,r=b.doc.createElement("div");r.innerHTML=e;var o=r.querySelectorAll("p, div, h1, h2, h3, h4, h5, h6, pre, blockquote");for(t=0;t<o.length;t++)(n=o[t]).outerHTML="<"+(b.html.defaultTag()||"DIV")+">"+n.innerHTML+"</"+(b.html.defaultTag()||"DIV")+">";for(t=(o=r.querySelectorAll("*:not("+"p, div, h1, h2, h3, h4, h5, h6, pre, blockquote, ul, ol, li, table, tbody, thead, tr, td, br, img".split(",").join("):not(")+")")).length-1;0<=t;t--)(n=o[t]).outerHTML=n.innerHTML;var i=function(e){for(var t=b.node.contents(e),n=0;n<t.length;n++)t[n].nodeType!=Node.TEXT_NODE&&t[n].nodeType!=Node.ELEMENT_NODE?t[n].parentNode.removeChild(t[n]):i(t[n])};return i(r),r.innerHTML}(e));var c=b.events.chainTrigger("paste.afterCleanup",e);if("string"==typeof c&&(e=c),""!==e){var f=b.o_doc.createElement("div");0<=(f.innerHTML=e).indexOf("<body>")?(b.html.cleanBlankSpaces(f),b.spaces.normalize(f,!0)):b.spaces.normalize(f);var p=f.getElementsByTagName("span");for(r=p.length-1;0<=r;r--){var u=p[r];0===u.attributes.length&&(u.outerHTML=u.innerHTML)}var g=b.selection.element(),h=!1;if(g&&M(g).parentsUntil(b.el,"ul, ol").length&&(h=!0),h){var m=f.children;1==m.length&&0<=["OL","UL"].indexOf(m[0].tagName)&&(m[0].outerHTML=m[0].innerHTML)}if(!s){var E=f.getElementsByTagName("br");for(r=E.length-1;0<=r;r--){var v=E[r];b.node.isBlock(v.previousSibling)&&v.parentNode.removeChild(v)}}if(b.opts.enter==M.FE.ENTER_BR)for(r=(o=f.querySelectorAll("p, div")).length-1;0<=r;r--)0===(i=o[r]).attributes.length&&(i.outerHTML=i.innerHTML+(i.nextSibling&&!b.node.isEmpty(i)?"<br>":""));else if(b.opts.enter==M.FE.ENTER_DIV)for(r=(o=f.getElementsByTagName("p")).length-1;0<=r;r--)0===(i=o[r]).attributes.length&&(i.outerHTML="<div>"+i.innerHTML+"</div>");else b.opts.enter==M.FE.ENTER_P&&1==f.childNodes.length&&"P"==f.childNodes[0].tagName&&0===f.childNodes[0].attributes.length&&(f.childNodes[0].outerHTML=f.childNodes[0].innerHTML);e=f.innerHTML,l&&(e=function(e){var t,n=b.o_doc.createElement("div");n.innerHTML=e;var r=n.querySelectorAll("*:empty:not(td):not(th):not(tr):not(iframe):not(svg):not("+M.FE.VOID_ELEMENTS.join("):not(")+"):not("+b.opts.htmlAllowedEmptyTags.join("):not(")+")");for(;r.length;){for(t=0;t<r.length;t++)r[t].parentNode.removeChild(r[t]);r=n.querySelectorAll("*:empty:not(td):not(th):not(tr):not(iframe):not(svg):not("+M.FE.VOID_ELEMENTS.join("):not(")+"):not("+b.opts.htmlAllowedEmptyTags.join("):not(")+")")}return n.innerHTML}(e)),b.html.insert(e,!0)}b.events.trigger("paste.after"),b.undo.saveStep(S),S=null,b.undo.saveStep()}function c(e){for(var t=e.length-1;0<=t;t--)e[t].attributes&&e[t].attributes.length&&e.splice(t,1);return e}function y(e){var t,n=b.o_doc.createElement("div");n.innerHTML=e;for(var r=c(Array.prototype.slice.call(n.querySelectorAll(":scope > div:not([style]), td > div:not([style]), th > div:not([style]), li > div:not([style])")));r.length;){var o=r[r.length-1];if(b.html.defaultTag()&&"div"!=b.html.defaultTag())o.querySelector(b.html.blockTagsQuery())?o.outerHTML=o.innerHTML:o.outerHTML="<"+b.html.defaultTag()+">"+o.innerHTML+"</"+b.html.defaultTag()+">";else{var i=o.querySelectorAll("*");!i.length||"BR"!==i[i.length-1].tagName&&0===o.innerText.length?o.outerHTML=o.innerHTML+"<br>":o.outerHTML=o.innerHTML}r=c(Array.prototype.slice.call(n.querySelectorAll(":scope > div:not([style]), td > div:not([style]), th > div:not([style]), li > div:not([style])")))}for(r=c(Array.prototype.slice.call(n.querySelectorAll("div:not([style])")));r.length;){for(t=0;t<r.length;t++){var a=r[t],s=a.innerHTML.replace(/\u0009/gi,"").trim();a.outerHTML=s}r=c(Array.prototype.slice.call(n.querySelectorAll("div:not([style])")))}return n.innerHTML}function f(){b.el.removeEventListener("copy",e),b.el.removeEventListener("cut",e),b.el.removeEventListener("paste",t)}return{_init:function(){b.el.addEventListener("copy",e),b.el.addEventListener("cut",e),b.el.addEventListener("paste",t,{capture:!0}),b.events.on("drop",r),b.browser.msie&&b.browser.version<11&&(b.events.on("mouseup",function(e){2==e.button&&(setTimeout(function(){i=!1},50),i=!0)},!0),b.events.on("beforepaste",t)),b.events.on("destroy",f)},cleanEmptyTagsAndDivs:y,getRtfClipboard:function(){return s},saveCopiedText:n,clean:d}},M.extend(M.FE.DEFAULTS,{shortcutsEnabled:[],shortcutsHint:!0}),M.FE.SHORTCUTS_MAP={},M.FE.RegisterShortcut=function(e,t,n,r,o,i){M.FE.SHORTCUTS_MAP[(o?"^":"")+(i?"@":"")+e]={cmd:t,val:n,letter:r,shift:o,option:i},M.FE.DEFAULTS.shortcutsEnabled.push(t)},M.FE.RegisterShortcut(M.FE.KEYCODE.E,"show",null,"E",!1,!1),M.FE.RegisterShortcut(M.FE.KEYCODE.B,"bold",null,"B",!1,!1),M.FE.RegisterShortcut(M.FE.KEYCODE.I,"italic",null,"I",!1,!1),M.FE.RegisterShortcut(M.FE.KEYCODE.U,"underline",null,"U",!1,!1),M.FE.RegisterShortcut(M.FE.KEYCODE.S,"strikeThrough",null,"S",!1,!1),M.FE.RegisterShortcut(M.FE.KEYCODE.CLOSE_SQUARE_BRACKET,"indent",null,"]",!1,!1),M.FE.RegisterShortcut(M.FE.KEYCODE.OPEN_SQUARE_BRACKET,"outdent",null,"[",!1,!1),M.FE.RegisterShortcut(M.FE.KEYCODE.Z,"undo",null,"Z",!1,!1),M.FE.RegisterShortcut(M.FE.KEYCODE.Z,"redo",null,"Z",!0,!1),M.FE.RegisterShortcut(M.FE.KEYCODE.Y,"redo",null,"Y",!1,!1),M.FE.MODULES.shortcuts=function(s){var r=null;var l=!1;function e(e){if(!s.core.hasFocus())return!0;var t=e.which,n=-1!=navigator.userAgent.indexOf("Mac OS X")?e.metaKey:e.ctrlKey;if("keyup"==e.type&&l&&t!=M.FE.KEYCODE.META)return l=!1;"keydown"==e.type&&(l=!1);var r=(e.shiftKey?"^":"")+(e.altKey?"@":"")+t;if(n&&M.FE.SHORTCUTS_MAP[r]){var o=M.FE.SHORTCUTS_MAP[r].cmd;if(o&&0<=s.opts.shortcutsEnabled.indexOf(o)){var i,a=M.FE.SHORTCUTS_MAP[r].val;if(o&&!a?i=s.$tb.find('.fr-command[data-cmd="'+o+'"]'):o&&a&&(i=s.$tb.find('.fr-command[data-cmd="'+o+'"][data-param1="'+a+'"]')),i.length)return e.preventDefault(),e.stopPropagation(),i.parents(".fr-toolbar").data("instance",s),"keydown"==e.type&&(s.button.exec(i),l=!0),!1;if(o&&(s.commands[o]||M.FE.COMMANDS[o]&&M.FE.COMMANDS[o].callback))return e.preventDefault(),e.stopPropagation(),"keydown"==e.type&&((s.commands[o]||M.FE.COMMANDS[o].callback)(),l=!0),!1}}}return{_init:function(){s.events.on("keydown",e,!0),s.events.on("keyup",e,!0)},get:function(e){if(!s.opts.shortcutsHint)return null;if(!r)for(var t in r={},M.FE.SHORTCUTS_MAP)M.FE.SHORTCUTS_MAP.hasOwnProperty(t)&&0<=s.opts.shortcutsEnabled.indexOf(M.FE.SHORTCUTS_MAP[t].cmd)&&(r[M.FE.SHORTCUTS_MAP[t].cmd+"."+(M.FE.SHORTCUTS_MAP[t].val||"")]={shift:M.FE.SHORTCUTS_MAP[t].shift,option:M.FE.SHORTCUTS_MAP[t].option,letter:M.FE.SHORTCUTS_MAP[t].letter});var n=r[e];return n?(s.helpers.isMac()?String.fromCharCode(8984):s.language.translate("Ctrl")+"+")+(n.shift?s.helpers.isMac()?String.fromCharCode(8679):s.language.translate("Shift")+"+":"")+(n.option?s.helpers.isMac()?String.fromCharCode(8997):s.language.translate("Alt")+"+":"")+n.letter:null}}},M.FE.MODULES.snapshot=function(l){function n(e){for(var t=e.parentNode.childNodes,n=0,r=null,o=0;o<t.length;o++){if(r){var i=t[o].nodeType===Node.TEXT_NODE&&""===t[o].textContent,a=r.nodeType===Node.TEXT_NODE&&t[o].nodeType===Node.TEXT_NODE;i||a||n++}if(t[o]==e)return n;r=t[o]}}function o(e){var t=[];if(!e.parentNode)return[];for(;!l.node.isElement(e);)t.push(n(e)),e=e.parentNode;return t.reverse()}function i(e,t){for(;e&&e.nodeType===Node.TEXT_NODE;){var n=e.previousSibling;n&&n.nodeType==Node.TEXT_NODE&&(t+=n.textContent.length),e=n}return t}function d(e){for(var t=l.el,n=0;n<e.length;n++)t=t.childNodes[e[n]];return t}function r(e,t){try{var n=d(t.scLoc),r=t.scOffset,o=d(t.ecLoc),i=t.ecOffset,a=l.doc.createRange();a.setStart(n,r),a.setEnd(o,i),e.addRange(a)}catch(s){}}return{get:function(){var e,t={};if(l.events.trigger("snapshot.before"),t.html=(l.$wp?l.$el.html():l.$oel.get(0).outerHTML).replace(/ style=""/g,""),t.ranges=[],l.$wp&&l.selection.inEditor()&&l.core.hasFocus())for(var n=l.selection.ranges(),r=0;r<n.length;r++)t.ranges.push({scLoc:o((e=n[r]).startContainer),scOffset:i(e.startContainer,e.startOffset),ecLoc:o(e.endContainer),ecOffset:i(e.endContainer,e.endOffset)});return l.events.trigger("snapshot.after",[t]),t},restore:function(e){l.$el.html()!=e.html&&(l.opts.htmlExecuteScripts?l.$el.html(e.html):l.el.innerHTML=e.html);var t=l.selection.get();l.selection.clear(),l.events.focus(!0);for(var n=0;n<e.ranges.length;n++)r(t,e.ranges[n])},equal:function(e,t){return e.html==t.html&&(!l.core.hasFocus()||JSON.stringify(e.ranges)==JSON.stringify(t.ranges))}}},M.FE.MODULES.undo=function(n){function e(e){var t=e.which;n.keys.ctrlKey(e)&&(90==t&&e.shiftKey&&e.preventDefault(),90==t&&e.preventDefault())}var t=null;function r(){if(!n.undo_stack||n.undoing)return!1;for(;n.undo_stack.length>n.undo_index;)n.undo_stack.pop()}function o(){n.undo_index=0,n.undo_stack=[]}function i(){n.undo_stack=[]}return{_init:function(){o(),n.events.on("initialized",function(){t=(n.$wp?n.$el.html():n.$oel.get(0).outerHTML).replace(/ style=""/g,"")}),n.events.on("blur",function(){n.el.querySelector(".fr-dragging")||n.undo.saveStep()}),n.events.on("keydown",e),n.events.on("destroy",i)},run:function(){if(1<n.undo_index){n.undoing=!0;var e=n.undo_stack[--n.undo_index-1];clearTimeout(n._content_changed_timer),n.snapshot.restore(e),t=e.html,n.popups.hideAll(),n.toolbar.enable(),n.events.trigger("contentChanged"),n.events.trigger("commands.undo"),n.undoing=!1}},redo:function(){if(n.undo_index<n.undo_stack.length){n.undoing=!0;var e=n.undo_stack[n.undo_index++];clearTimeout(n._content_changed_timer),n.snapshot.restore(e),t=e.html,n.popups.hideAll(),n.toolbar.enable(),n.events.trigger("contentChanged"),n.events.trigger("commands.redo"),n.undoing=!1}},canDo:function(){return!(0===n.undo_stack.length||n.undo_index<=1)},canRedo:function(){return n.undo_index!=n.undo_stack.length},dropRedo:r,reset:o,saveStep:function(e){if(!n.undo_stack||n.undoing||n.el.querySelector(".fr-marker"))return!1;void 0===e?(e=n.snapshot.get(),n.undo_stack[n.undo_index-1]&&n.snapshot.equal(n.undo_stack[n.undo_index-1],e)||(r(),n.undo_stack.push(e),n.undo_index++,e.html!=t&&(n.events.trigger("contentChanged"),t=e.html))):(r(),0<n.undo_index?n.undo_stack[n.undo_index-1]=e:(n.undo_stack.push(e),n.undo_index++))}}},M.FE.ICON_TEMPLATES={font_awesome:'<i class="fa fa-[NAME]" aria-hidden="true"></i>',font_awesome_5:'<i class="fas fa-[FA5NAME]" aria-hidden="true"></i>',font_awesome_5r:'<i class="far fa-[FA5NAME]" aria-hidden="true"></i>',font_awesome_5l:'<i class="fal fa-[FA5NAME]" aria-hidden="true"></i>',font_awesome_5b:'<i class="fab fa-[FA5NAME]" aria-hidden="true"></i>',text:'<span style="text-align: center;">[NAME]</span>',image:"<img src=[SRC] alt=[ALT] />",svg:'<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">[PATH]</svg>'},M.FE.ICONS={bold:{NAME:"bold"},italic:{NAME:"italic"},underline:{NAME:"underline"},strikeThrough:{NAME:"strikethrough"},subscript:{NAME:"subscript"},superscript:{NAME:"superscript"},color:{NAME:"tint"},outdent:{NAME:"outdent"},indent:{NAME:"indent"},undo:{NAME:"rotate-left",FA5NAME:"undo"},redo:{NAME:"rotate-right",FA5NAME:"redo"},insertHR:{NAME:"minus"},clearFormatting:{NAME:"eraser"},selectAll:{NAME:"mouse-pointer"}},M.FE.DefineIconTemplate=function(e,t){M.FE.ICON_TEMPLATES[e]=t},M.FE.DefineIcon=function(e,t){M.FE.ICONS[e]=t},M.extend(M.FE.DEFAULTS,{iconsTemplate:"font_awesome"}),M.FE.MODULES.icon=function(o){return{create:function(n){var e=null,r=M.FE.ICONS[n];if(void 0!==r){var t=r.template||M.FE.ICON_DEFAULT_TEMPLATE||o.opts.iconsTemplate;r.FA5NAME||(r.FA5NAME=r.NAME),t&&(t=M.FE.ICON_TEMPLATES[t])&&(e=t.replace(/\[([a-zA-Z0-9]*)\]/g,function(e,t){return"NAME"==t?r[t]||n:r[t]}))}return e||n},getTemplate:function(e){var t=M.FE.ICONS[e],n=o.opts.iconsTemplate;return void 0!==t?n=t.template||M.FE.ICON_DEFAULT_TEMPLATE||o.opts.iconsTemplate:n}}},M.extend(M.FE.DEFAULTS,{tooltips:!0}),M.FE.MODULES.tooltip=function(o){function r(){if(o.helpers.isMobile())return!1;o.$tooltip&&o.$tooltip.removeClass("fr-visible").css("left","-3000px").css("position","fixed")}function i(e,t){if(o.helpers.isMobile())return!1;if(e.data("title")||e.data("title",e.attr("title")),!e.data("title"))return!1;o.$tooltip||o.opts.tooltips&&!o.helpers.isMobile()&&(o.shared.$tooltip?o.$tooltip=o.shared.$tooltip:(o.shared.$tooltip=M('<div class="fr-tooltip"></div>'),o.$tooltip=o.shared.$tooltip,o.opts.theme&&o.$tooltip.addClass(o.opts.theme+"-theme"),M(o.o_doc).find("body:first").append(o.$tooltip)),o.events.on("shared.destroy",function(){o.$tooltip.html("").removeData().remove(),o.$tooltip=null},!0)),e.removeAttr("title"),o.$tooltip.text(o.language.translate(e.data("title"))),o.$tooltip.addClass("fr-visible");var n=e.offset().left+(e.outerWidth()-o.$tooltip.outerWidth())/2;n<0&&(n=0),n+o.$tooltip.outerWidth()>M(o.o_win).width()&&(n=M(o.o_win).width()-o.$tooltip.outerWidth()),void 0===t&&(t=o.opts.toolbarBottom);var r=t?e.offset().top-o.$tooltip.height():e.offset().top+e.outerHeight();o.$tooltip.css("position",""),o.$tooltip.css("left",n),o.$tooltip.css("top",Math.ceil(r)),"static"!=M(o.o_doc).find("body:first").css("position")?(o.$tooltip.css("margin-left",-M(o.o_doc).find("body:first").offset().left),o.$tooltip.css("margin-top",-M(o.o_doc).find("body:first").offset().top)):(o.$tooltip.css("margin-left",""),o.$tooltip.css("margin-top",""))}return{hide:r,to:i,bind:function(e,t,n){o.opts.tooltips&&!o.helpers.isMobile()&&(o.events.$on(e,"mouseenter",t,function(e){o.node.hasClass(e.currentTarget,"fr-disabled")||o.edit.isDisabled()||i(M(e.currentTarget),n)},!0),o.events.$on(e,"mouseleave "+o._mousedown+" "+o._mouseup,t,function(){r()},!0))}}},M.FE.MODULES.button=function(u){var a=[];(u.opts.toolbarInline||u.opts.toolbarContainer)&&(u.shared.buttons||(u.shared.buttons=[]),a=u.shared.buttons);var s=[];function l(e,t,n){for(var r=M(),o=0;o<e.length;o++){var i=M(e[o]);if(i.is(t)&&(r=r.add(i)),n&&i.is(".fr-dropdown")){var a=i.next().find(t);r=r.add(a)}}return r}function d(e,t){var n,r=M();if(!e)return r;for(n in r=(r=r.add(l(a,e,t))).add(l(s,e,t)),u.shared.popups)if(u.shared.popups.hasOwnProperty(n)){var o=u.shared.popups[n].children().find(e);r=r.add(o)}for(n in u.shared.modals)if(u.shared.modals.hasOwnProperty(n)){var i=u.shared.modals[n].$modal.find(e);r=r.add(i)}return r}function r(e){e.addClass("fr-blink"),setTimeout(function(){e.removeClass("fr-blink")},500);for(var t=e.data("cmd"),n=[];void 0!==e.data("param"+(n.length+1));)n.push(e.data("param"+(n.length+1)));var r=d(".fr-dropdown.fr-active");r.length&&(r.removeClass("fr-active").attr("aria-expanded",!1).next().attr("aria-hidden",!0),r.parent(".fr-toolbar:not(.fr-inline)").css("zIndex","")),e.parents(".fr-popup, .fr-toolbar").data("instance").commands.exec(t,n)}function t(e){var t=e.parents(".fr-popup, .fr-toolbar").data("instance");if(0!==e.parents(".fr-popup").length||e.data("popup")||t.popups.hideAll(),t.popups.areVisible()&&!t.popups.areVisible(t)){for(var n=0;n<M.FE.INSTANCES.length;n++)M.FE.INSTANCES[n]!=t&&M.FE.INSTANCES[n].popups&&M.FE.INSTANCES[n].popups.areVisible()&&M.FE.INSTANCES[n].$el.find(".fr-marker").remove();t.popups.hideAll()}u.node.hasClass(e.get(0),"fr-dropdown")?function(e){var t=e.next(),n=u.node.hasClass(e.get(0),"fr-active"),r=d(".fr-dropdown.fr-active").not(e),o=e.parents(".fr-toolbar, .fr-popup").data("instance")||u;if(o.helpers.isIOS()&&!o.el.querySelector(".fr-marker")&&(o.selection.save(),o.selection.clear(),o.selection.restore()),!n){var i=e.data("cmd");t.find(".fr-command").removeClass("fr-active").attr("aria-selected",!1),M.FE.COMMANDS[i]&&M.FE.COMMANDS[i].refreshOnShow&&M.FE.COMMANDS[i].refreshOnShow.apply(o,[e,t]),t.css("left",e.offset().left-e.parent().offset().left-("rtl"==u.opts.direction?t.width()-e.outerWidth():0)),t.addClass("test-height");var a=t.outerHeight();t.removeClass("test-height"),t.css("top","").css("bottom",""),!u.opts.toolbarBottom&&t.offset().top+e.outerHeight()+a<M(u.o_doc).height()?t.css("top",e.position().top+e.outerHeight()):t.css("bottom",e.parents(".fr-popup, .fr-toolbar").first().height()-e.position().top)}e.addClass("fr-blink").toggleClass("fr-active"),e.hasClass("fr-active")?(t.attr("aria-hidden",!1),e.attr("aria-expanded",!0)):(t.attr("aria-hidden",!0),e.attr("aria-expanded",!1)),setTimeout(function(){e.removeClass("fr-blink")},300),t.css("margin-left",""),t.offset().left+t.outerWidth()>u.$sc.offset().left+u.$sc.width()&&t.css("margin-left",-(t.offset().left+t.outerWidth()-u.$sc.offset().left-u.$sc.width())),t.offset().left<u.$sc.offset().left&&"rtl"==u.opts.direction&&t.css("margin-left",u.$sc.offset().left),r.removeClass("fr-active").attr("aria-expanded",!1).next().attr("aria-hidden",!0),r.parent(".fr-toolbar:not(.fr-inline)").css("zIndex",""),0!==e.parents(".fr-popup").length||u.opts.toolbarInline||(u.node.hasClass(e.get(0),"fr-active")?u.$tb.css("zIndex",(u.opts.zIndex||1)+4):u.$tb.css("zIndex",""));var s=t.find("a.fr-command.fr-active:first");u.helpers.isMobile()||(s.length?u.accessibility.focusToolbarElement(s):u.accessibility.focusToolbarElement(e))}(e):(r(e),M.FE.COMMANDS[e.data("cmd")]&&!1!==M.FE.COMMANDS[e.data("cmd")].refreshAfterCallback&&t.button.bulkRefresh())}function i(e){t(M(e.currentTarget))}function c(e){var t=e.find(".fr-dropdown.fr-active");t.length&&(t.removeClass("fr-active").attr("aria-expanded",!1).next().attr("aria-hidden",!0),t.parent(".fr-toolbar:not(.fr-inline)").css("zIndex",""))}function f(e){e.preventDefault(),e.stopPropagation()}function p(e){if(e.stopPropagation(),!u.helpers.isMobile())return!1}function g(e,t,n){if(u.helpers.isMobile()&&!1===t.showOnMobile)return"";var r,o=t.displaySelection;if("function"==typeof o&&(o=o(u)),o){var i="function"==typeof t.defaultSelection?t.defaultSelection(u):t.defaultSelection;r='<span style="width:'+(t.displaySelectionWidth||100)+'px">'+u.language.translate(i||t.title)+"</span>"}else r=u.icon.create(t.icon||e),r+='<span class="fr-sr-only">'+(u.language.translate(t.title)||"")+"</span>";var a=t.popup?' data-popup="true"':"",s=t.modal?' data-modal="true"':"",l=u.shortcuts.get(e+".");l=l?" ("+l+")":"";var d=e+"-"+u.id,c="dropdown-menu-"+d,f='<button id="'+d+'"type="button" tabIndex="-1" role="button"'+(t.toggle?' aria-pressed="false"':"")+("dropdown"==t.type?' aria-controls="'+c+'" aria-expanded="false" aria-haspopup="true"':"")+(t.disabled?' aria-disabled="true"':"")+' title="'+(u.language.translate(t.title)||"")+l+'" class="fr-command fr-btn'+("dropdown"==t.type?" fr-dropdown":"")+" fr-btn-"+u.icon.getTemplate(t.icon)+(t.displaySelection?" fr-selection":"")+(t.back?" fr-back":"")+(t.disabled?" fr-disabled":"")+(n?"":" fr-hidden")+'" data-cmd="'+e+'"'+a+s+">"+r+"</button>";if("dropdown"==t.type){var p='<div id="'+c+'" class="fr-dropdown-menu" role="listbox" aria-labelledby="'+d+'" aria-hidden="true"><div class="fr-dropdown-wrapper" role="presentation"><div class="fr-dropdown-content" role="presentation">';p+=function(e,t){var n="";if(t.html)"function"==typeof t.html?n+=t.html.call(u):n+=t.html;else{var r=t.options;for(var o in"function"==typeof r&&(r=r()),n+='<ul class="fr-dropdown-list" role="presentation">',r)if(r.hasOwnProperty(o)){var i=u.shortcuts.get(e+"."+o);i=i?'<span class="fr-shortcut">'+i+"</span>":"",n+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="'+e+'" data-param1="'+o+'" title="'+r[o]+'">'+u.language.translate(r[o])+"</a></li>"}n+="</ul>"}return n}(e,t),f+=p+="</div></div></div>"}return f}function e(o){var i=u.$tb&&u.$tb.data("instance")||u;if(!1===u.events.trigger("buttons.refresh"))return!0;setTimeout(function(){for(var e=i.selection.inEditor()&&i.core.hasFocus(),t=0;t<o.length;t++){var n=M(o[t]),r=n.data("cmd");0===n.parents(".fr-popup").length?e||M.FE.COMMANDS[r]&&M.FE.COMMANDS[r].forcedRefresh?i.button.refresh(n):u.node.hasClass(n.get(0),"fr-dropdown")||(n.removeClass("fr-active"),n.attr("aria-pressed")&&n.attr("aria-pressed",!1)):n.parents(".fr-popup").is(":visible")&&i.button.refresh(n)}},0)}function n(){e(a),e(s)}function o(){a=[],s=[]}u.shared.popup_buttons||(u.shared.popup_buttons=[]),s=u.shared.popup_buttons;var h=null;function m(){clearTimeout(h),h=setTimeout(n,50)}return{_init:function(){u.opts.toolbarInline?u.events.on("toolbar.show",n):(u.events.on("mouseup",m),u.events.on("keyup",m),u.events.on("blur",m),u.events.on("focus",m),u.events.on("contentChanged",m),u.helpers.isMobile()&&u.events.$on(u.$doc,"selectionchange",n)),u.events.on("shared.destroy",o)},buildList:function(e,t){for(var n="",r=0;r<e.length;r++){var o=e[r],i=M.FE.COMMANDS[o];i&&"undefined"!=typeof i.plugin&&u.opts.pluginsEnabled.indexOf(i.plugin)<0||(i?n+=g(o,i,void 0===t||0<=t.indexOf(o)):"|"==o?n+='<div class="fr-separator fr-vs" role="separator" aria-orientation="vertical"></div>':"-"==o&&(n+='<div class="fr-separator fr-hs" role="separator" aria-orientation="horizontal"></div>'))}return n},bindCommands:function(t,e){u.events.bindClick(t,".fr-command:not(.fr-disabled)",i),u.events.$on(t,u._mousedown+" "+u._mouseup+" "+u._move,".fr-dropdown-menu",f,!0),u.events.$on(t,u._mousedown+" "+u._mouseup+" "+u._move,".fr-dropdown-menu .fr-dropdown-wrapper",p,!0);var n=t.get(0).ownerDocument,r="defaultView"in n?n.defaultView:n.parentWindow,o=function(e){(!e||e.type==u._mouseup&&e.target!=M("html").get(0)||"keydown"==e.type&&(u.keys.isCharacter(e.which)&&!u.keys.ctrlKey(e)||e.which==M.FE.KEYCODE.ESC))&&c(t)};u.events.$on(M(r),u._mouseup+" resize keydown",o,!0),u.opts.iframe&&u.events.$on(u.$win,u._mouseup,o,!0),u.node.hasClass(t.get(0),"fr-popup")?M.merge(s,t.find(".fr-btn").toArray()):M.merge(a,t.find(".fr-btn").toArray()),u.tooltip.bind(t,".fr-btn, .fr-title",e)},refresh:function(e){var t,n=e.parents(".fr-popup, .fr-toolbar").data("instance")||u,r=e.data("cmd");u.node.hasClass(e.get(0),"fr-dropdown")?t=e.next():(e.removeClass("fr-active"),e.attr("aria-pressed")&&e.attr("aria-pressed",!1)),M.FE.COMMANDS[r]&&M.FE.COMMANDS[r].refresh?M.FE.COMMANDS[r].refresh.apply(n,[e,t]):u.refresh[r]&&n.refresh[r](e,t)},bulkRefresh:n,exec:r,click:t,hideActiveDropdowns:c,getButtons:d}},M.FE.MODULES.modals=function(l){l.shared.modals||(l.shared.modals={});var s,d=l.shared.modals;function e(){for(var e in d){var t=d[e];t&&t.$modal&&t.$modal.removeData().remove()}s&&s.removeData().remove(),d={}}function c(e,t){if(d[e]){var n=d[e].$modal,r=n.data("instance")||l;r.events.enableBlur(),n.hide(),s.hide(),M(r.o_doc).find("body:first").removeClass("prevent-scroll fr-mobile"),n.removeClass("fr-active"),t||(r.accessibility.restoreSelection(),r.events.trigger("modals.hide"))}}function n(e){var t;if("string"==typeof e){if(!d[e])return;t=d[e].$modal}else t=e;return t&&l.node.hasClass(t,"fr-active")&&l.core.sameInstance(t)||!1}return{_init:function(){l.events.on("shared.destroy",e,!0)},get:function(e){return d[e]},create:function(n,e,t){if(l.shared.$overlay||(l.shared.$overlay=M('<div class="fr-overlay">').appendTo("body:first")),s=l.shared.$overlay,l.opts.theme&&s.addClass(l.opts.theme+"-theme"),!d[n]){var r=(o=e,i=t,a='<div tabIndex="-1" class="fr-modal'+(l.opts.theme?" "+l.opts.theme+"-theme":"")+'"><div class="fr-modal-wrapper">',a+='<div class="fr-modal-head">'+o+'<i title="'+l.language.translate("Cancel")+'" class="fa fa-times fr-modal-close"></i></div>',a+='<div tabIndex="-1" class="fr-modal-body">'+i+"</div>",M(a+="</div></div>"));d[n]={$modal:r,$head:r.find(".fr-modal-head"),$body:r.find(".fr-modal-body")},l.helpers.isMobile()||r.addClass("fr-desktop"),r.appendTo("body:first"),l.events.$on(r,"click",".fr-modal-close",function(){c(n)},!0),d[n].$body.css("margin-top",d[n].$head.outerHeight()),l.events.$on(r,"keydown",function(e){var t=e.which;return t==M.FE.KEYCODE.ESC?(c(n),l.accessibility.focusModalButton(r),!1):!(!M(e.currentTarget).is("input[type=text], textarea")&&t!=M.FE.KEYCODE.ARROW_UP&&t!=M.FE.KEYCODE.ARROW_DOWN&&!l.keys.isBrowserAction(e)&&(e.preventDefault(),e.stopPropagation(),1))},!0),c(n,!0)}var o,i,a;return d[n]},show:function(e){if(d[e]){var t=d[e].$modal;t.data("instance",l),t.show(),s.show(),M(l.o_doc).find("body:first").addClass("prevent-scroll"),l.helpers.isMobile()&&M(l.o_doc).find("body:first").addClass("fr-mobile"),t.addClass("fr-active"),l.accessibility.focusModal(t)}},hide:c,resize:function(e){if(d[e]){var t=d[e],n=t.$modal,r=t.$body,o=M(l.o_win).height(),i=n.find(".fr-modal-wrapper"),a=o-i.outerHeight(!0)+(i.height()-(r.outerHeight(!0)-r.height())),s="auto";a<r.get(0).scrollHeight&&(s=a),r.height(s)}},isVisible:n,areVisible:function(e){for(var t in d)if(d.hasOwnProperty(t)&&n(t)&&(void 0===e||d[t].$modal.data("instance")==e))return d[t].$modal;return!1}}},M.FE.POPUP_TEMPLATES={"text.edit":"[_EDIT_]"},M.FE.RegisterTemplate=function(e,t){M.FE.POPUP_TEMPLATES[e]=t},M.FE.MODULES.popups=function(c){c.shared.popups||(c.shared.popups={});var f=c.shared.popups;function p(e,t){t.is(":visible")||(t=c.$sc),t.is(f[e].data("container"))||(f[e].data("container",t),t.append(f[e]))}function u(e){return f[e]&&c.node.hasClass(f[e],"fr-active")&&c.core.sameInstance(f[e])||!1}function g(e){for(var t in f)if(f.hasOwnProperty(t)&&u(t)&&(void 0===e||f[t].data("instance")==e))return f[t];return!1}function n(e){var t=null;(t="string"!=typeof e?e:f[e])&&c.node.hasClass(t,"fr-active")&&(t.removeClass("fr-active fr-above"),c.events.trigger("popups.hide."+e),c.$tb&&(1<c.opts.zIndex?c.$tb.css("zIndex",c.opts.zIndex+1):c.$tb.css("zIndex","")),c.events.disableBlur(),t.find("input, textarea, button").filter(":focus").blur(),t.find("input, textarea").attr("disabled","disabled"))}function h(e){for(var t in void 0===e&&(e=[]),f)f.hasOwnProperty(t)&&e.indexOf(t)<0&&n(t)}function t(){c.shared.exit_flag=!0}function m(){c.shared.exit_flag=!1}function i(){return c.shared.exit_flag}function o(e,t){var n,r,o=function(e,t){var n=M.FE.POPUP_TEMPLATES[e];if(!n)return null;for(var r in"function"==typeof n&&(n=n.apply(c)),t)t.hasOwnProperty(r)&&(n=n.replace("[_"+r.toUpperCase()+"_]",t[r]));return n}(e,t);return o?(n=M('<div class="fr-popup'+(c.helpers.isMobile()?" fr-mobile":" fr-desktop")+(c.opts.toolbarInline?" fr-inline":"")+'"><span class="fr-arrow"></span>'+o+"</div>"),c.opts.theme&&n.addClass(c.opts.theme+"-theme"),1<c.opts.zIndex&&(c.opts.editInPopup?n.css("z-index",c.opts.zIndex+2):c.$tb.css("z-index",c.opts.zIndex+2)),"auto"!=c.opts.direction&&n.removeClass("fr-ltr fr-rtl").addClass("fr-"+c.opts.direction),n.find("input, textarea").attr("dir",c.opts.direction).attr("disabled","disabled"),(r=M("body:first")).append(n),n.data("container",r),f[e]=n,c.button.bindCommands(n,!1),n):(n=M('<div class="fr-popup fr-empty"></div>'),(r=M("body:first")).append(n),n.data("container",r),f[e]=n)}function E(r){var o=f[r];return{_windowResize:function(){var e=o.data("instance")||c;!e.helpers.isMobile()&&o.is(":visible")&&(e.events.disableBlur(),e.popups.hide(r),e.events.enableBlur())},_inputFocus:function(e){var t=o.data("instance")||c,n=M(e.currentTarget);if(n.is("input:file")&&n.closest(".fr-layer").addClass("fr-input-focus"),e.preventDefault(),e.stopPropagation(),setTimeout(function(){t.events.enableBlur()},100),t.helpers.isMobile()){var r=M(t.o_win).scrollTop();setTimeout(function(){M(t.o_win).scrollTop(r)},0)}},_inputBlur:function(e){var t=o.data("instance")||c,n=M(e.currentTarget);n.is("input:file")&&n.closest(".fr-layer").removeClass("fr-input-focus"),document.activeElement!=this&&M(this).is(":visible")&&(t.events.blurActive()&&t.events.trigger("blur"),t.events.enableBlur())},_editorKeydown:function(e){var t=o.data("instance")||c;t.keys.ctrlKey(e)||e.which==M.FE.KEYCODE.ALT||e.which==M.FE.KEYCODE.ESC||(u(r)&&o.find(".fr-back:visible").length?t.button.exec(o.find(".fr-back:visible:first")):e.which!=M.FE.KEYCODE.ALT&&t.popups.hide(r))},_preventFocus:function(e){var t=o.data("instance")||c,n=e.originalEvent?e.originalEvent.target||e.originalEvent.originalTarget:null;"mouseup"==e.type||M(n).is(":focus")||t.events.disableBlur(),"mouseup"!=e.type||M(n).hasClass("fr-command")||0<M(n).parents(".fr-command").length||M(n).hasClass("fr-dropdown-content")||c.button.hideActiveDropdowns(o),(c.browser.safari||c.browser.mozilla)&&"mousedown"==e.type&&M(n).is("input[type=file]")&&t.events.disableBlur();var r="input, textarea, button, select, label, .fr-command";if(n&&!M(n).is(r)&&0===M(n).parents(r).length)return e.stopPropagation(),!1;n&&M(n).is(r)&&e.stopPropagation(),m()},_editorMouseup:function(){o.is(":visible")&&i()&&0<o.find("input:focus, textarea:focus, button:focus, select:focus").filter(":visible").length&&c.events.disableBlur()},_windowMouseup:function(e){if(!c.core.sameInstance(o))return!0;var t=o.data("instance")||c;o.is(":visible")&&i()&&(e.stopPropagation(),t.markers.remove(),t.popups.hide(r),m())},_windowKeydown:function(e){if(!c.core.sameInstance(o))return!0;var t=o.data("instance")||c,n=e.which;if(M.FE.KEYCODE.ESC==n){if(t.popups.isVisible(r)&&t.opts.toolbarInline)return e.stopPropagation(),t.popups.isVisible(r)&&(o.find(".fr-back:visible").length?(t.button.exec(o.find(".fr-back:visible:first")),t.accessibility.focusPopupButton(o)):o.find(".fr-dismiss:visible").length?t.button.exec(o.find(".fr-dismiss:visible:first")):(t.popups.hide(r),t.toolbar.showInline(null,!0),t.accessibility.FocusPopupButton(o))),!1;if(t.popups.isVisible(r))return o.find(".fr-back:visible").length?(t.button.exec(o.find(".fr-back:visible:first")),t.accessibility.focusPopupButton(o)):o.find(".fr-dismiss:visible").length?t.button.exec(o.find(".fr-dismiss:visible:first")):(t.popups.hide(r),t.accessibility.focusPopupButton(o)),!1}},_doPlaceholder:function(){0===M(this).next().length&&M(this).attr("placeholder")&&M(this).after('<label for="'+M(this).attr("id")+'">'+M(this).attr("placeholder")+"</label>"),M(this).toggleClass("fr-not-empty",""!==M(this).val())},_repositionPopup:function(){if(!c.opts.height&&!c.opts.heightMax||c.opts.toolbarInline)return!0;if(c.$wp&&u(r)&&o.parent().get(0)==c.$sc.get(0)){var e=o.offset().top-c.$wp.offset().top,t=c.$wp.outerHeight();c.node.hasClass(o.get(0),"fr-above")&&(e+=o.outerHeight()),t<e||e<0?o.addClass("fr-hidden"):o.removeClass("fr-hidden")}}}}function a(e,t){c.events.on("mouseup",e._editorMouseup,!0),c.$wp&&c.events.on("keydown",e._editorKeydown),c.events.on("blur",function(){g()&&c.markers.remove(),h()}),c.$wp&&!c.helpers.isMobile()&&c.events.$on(c.$wp,"scroll.popup"+t,e._repositionPopup),c.events.on("window.mouseup",e._windowMouseup,!0),c.events.on("window.keydown",e._windowKeydown,!0),f[t].data("inst"+c.id,!0),c.events.on("destroy",function(){c.core.sameInstance(f[t])&&f[t].removeClass("fr-active").appendTo("body:first")},!0)}function e(){for(var e in f)if(f.hasOwnProperty(e)){var t=f[e];t&&(t.html("").removeData().remove(),f[e]=null)}f=[]}return c.shared.exit_flag=!1,{_init:function(){c.events.on("shared.destroy",e,!0),c.events.on("window.mousedown",t),c.events.on("window.touchmove",m),c.events.$on(M(c.o_win),"scroll",m),c.events.on("mousedown",function(e){g()&&(e.stopPropagation(),c.$el.find(".fr-marker").remove(),t(),c.events.disableBlur())})},create:function(e,t){var n=o(e,t),r=E(e);return a(r,e),c.events.$on(n,"mousedown mouseup touchstart touchend touch","*",r._preventFocus,!0),c.events.$on(n,"focus","input, textarea, button, select",r._inputFocus,!0),c.events.$on(n,"blur","input, textarea, button, select",r._inputBlur,!0),c.accessibility.registerPopup(e),c.events.$on(n,"keydown keyup change input","input, textarea",r._doPlaceholder,!0),c.helpers.isIOS()&&c.events.$on(n,"touchend","label",function(){M("#"+M(this).attr("for")).prop("checked",function(e,t){return!t})},!0),c.events.$on(M(c.o_win),"resize",r._windowResize,!0),n},get:function(e){var t=f[e];return t&&!t.data("inst"+c.id)&&a(E(e),e),t},show:function(e,t,n,r){if(u(e)||(g()&&0<c.$el.find(".fr-marker").length?(c.events.disableBlur(),c.selection.restore()):g()||(c.events.disableBlur(),c.events.focus(),c.events.enableBlur())),h([e]),!f[e])return!1;var o=c.button.getButtons(".fr-dropdown.fr-active");o.removeClass("fr-active").attr("aria-expanded",!1).parent(".fr-toolbar").css("zIndex",""),o.next().attr("aria-hidden",!0),f[e].data("instance",c),c.$tb&&c.$tb.data("instance",c);var i=f[e].outerWidth(),a=u(e);f[e].addClass("fr-active").removeClass("fr-hidden").find("input, textarea").removeAttr("disabled");var s,l,d=f[e].data("container");s=e,(l=d).is(":visible")||(l=c.$sc),0===l.find([f[s]]).length&&l.append(f[s]),c.opts.toolbarInline&&d&&c.$tb&&d.get(0)==c.$tb.get(0)&&(p(e,c.$sc),n=c.$tb.offset().top-c.helpers.getPX(c.$tb.css("margin-top")),t=c.$tb.offset().left+c.$tb.outerWidth()/2+(parseFloat(c.$tb.find(".fr-arrow").css("margin-left"))||0)+c.$tb.find(".fr-arrow").outerWidth()/2,c.node.hasClass(c.$tb.get(0),"fr-above")&&n&&(n+=c.$tb.outerHeight()),r=0),d=f[e].data("container"),!c.opts.iframe||r||a||(t&&(t-=c.$iframe.offset().left),n&&(n-=c.$iframe.offset().top)),d.is(c.$tb)?c.$tb.css("zIndex",(c.opts.zIndex||1)+4):f[e].css("zIndex",(c.opts.zIndex||1)+4),t&&(t-=i/2),c.opts.toolbarBottom&&d&&c.$tb&&d.get(0)==c.$tb.get(0)&&(f[e].addClass("fr-above"),n&&(n-=f[e].outerHeight())),f[e].removeClass("fr-active"),c.position.at(t,n,f[e],r||0),f[e].addClass("fr-active"),a||c.accessibility.focusPopup(f[e]),c.opts.toolbarInline&&c.toolbar.hide(),c.events.trigger("popups.show."+e),E(e)._repositionPopup(),m()},hide:n,onHide:function(e,t){c.events.on("popups.hide."+e,t)},hideAll:h,setContainer:p,refresh:function(e){f[e].data("instance",c),c.events.trigger("popups.refresh."+e);for(var t=f[e].find(".fr-command"),n=0;n<t.length;n++){var r=M(t[n]);0===r.parents(".fr-dropdown-menu").length&&c.button.refresh(r)}},onRefresh:function(e,t){c.events.on("popups.refresh."+e,t)},onShow:function(e,t){c.events.on("popups.show."+e,t)},isVisible:u,areVisible:g}},M.FE.MODULES.position=function(E){function o(){var e=E.selection.ranges(0).getBoundingClientRect();if(0===e.top&&0===e.left&&0===e.width||0===e.height){var t=!1;0===E.$el.find(".fr-marker").length&&(E.selection.save(),t=!0);var n=E.$el.find(".fr-marker:first");n.css("display","inline"),n.css("line-height","");var r=n.offset(),o=n.outerHeight();n.css("display","none"),n.css("line-height",0),(e={}).left=r.left,e.width=0,e.height=o,e.top=r.top-(E.helpers.isMobile()&&!E.helpers.isIOS()||E.opts.iframe?0:E.helpers.scrollTop()),e.right=1,e.bottom=1,e.ok=!0,t&&E.selection.restore()}return e}function i(e,t,n,r){var o=n.data("container");!o||"BODY"===o.get(0).tagName&&"static"==o.css("position")||(e&&(e-=o.offset().left),t&&(t-=o.offset().top),"BODY"!=o.get(0).tagName?(e&&(e+=o.get(0).scrollLeft),t&&(t+=o.get(0).scrollTop)):"absolute"==o.css("position")&&(e&&(e+=o.position().left),t&&(t+=o.position().top))),E.opts.iframe&&o&&E.$tb&&o.get(0)!=E.$tb.get(0)&&(e&&(e+=E.$iframe.offset().left),t&&(t+=E.$iframe.offset().top));var i,a,s=(i=e,a=n.outerWidth(!0),i+a>E.$sc.get(0).clientWidth-10&&(i=E.$sc.get(0).clientWidth-a-10),i<0&&(i=10),i);if(e){n.css("left",s);var l=n.data("fr-arrow");l||(l=n.find(".fr-arrow"),n.data("fr-arrow",l)),l.data("margin-left")||l.data("margin-left",E.helpers.getPX(l.css("margin-left"))),l.css("margin-left",e-s+l.data("margin-left"))}t&&n.css("top",function(e,t,n){var r=e.outerHeight(!0);if(!E.helpers.isMobile()&&E.$tb&&e.parent().get(0)!=E.$tb.get(0)){var o=e.parent().offset().top,i=t-r-(n||0);e.parent().get(0)==E.$sc.get(0)&&(o-=e.parent().position().top);var a=E.$sc.get(0).clientHeight;o+t+r>E.$sc.offset().top+a&&0<e.parent().offset().top+i&&0<i?i>E.$wp.scrollTop()&&(t=i,e.addClass("fr-above")):e.removeClass("fr-above")}return t}(n,t,r))}function n(e){var n=M(e),t=n.is(".fr-sticky-on"),r=n.data("sticky-top"),o=n.data("sticky-scheduled");if(void 0===r){n.data("sticky-top",0);var i=M('<div class="fr-sticky-dummy" style="height: '+n.outerHeight()+'px;"></div>');E.$box.prepend(i)}else E.$box.find(".fr-sticky-dummy").css("height",n.outerHeight());if(E.core.hasFocus()||0<E.$tb.find("input:visible:focus").length){var a=E.helpers.scrollTop(),s=Math.min(Math.max(a-E.$tb.parent().offset().top,0),E.$tb.parent().outerHeight()-n.outerHeight());s!=r&&s!=o&&(clearTimeout(n.data("sticky-timeout")),n.data("sticky-scheduled",s),n.outerHeight()<a-E.$tb.parent().offset().top&&n.addClass("fr-opacity-0"),n.data("sticky-timeout",setTimeout(function(){var e=E.helpers.scrollTop(),t=Math.min(Math.max(e-E.$tb.parent().offset().top,0),E.$tb.parent().outerHeight()-n.outerHeight());0<t&&"BODY"==E.$tb.parent().get(0).tagName&&(t+=E.$tb.parent().position().top),t!=r&&(n.css("top",Math.max(t,0)),n.data("sticky-top",t),n.data("sticky-scheduled",t)),n.removeClass("fr-opacity-0")},100))),t||(n.css("top","0"),n.width(E.$tb.parent().width()),n.addClass("fr-sticky-on"),E.$box.addClass("fr-sticky-box"))}else clearTimeout(M(e).css("sticky-timeout")),n.css("top","0"),n.css("position",""),n.width(""),n.data("sticky-top",0),n.removeClass("fr-sticky-on"),E.$box.removeClass("fr-sticky-box")}function t(e){if(e.offsetWidth){var t,n,r=M(e),o=r.outerHeight(),i=r.data("sticky-position"),a=M("body"==E.opts.scrollableContainer?E.o_win:E.opts.scrollableContainer).outerHeight(),s=0,l=0;"body"!==E.opts.scrollableContainer&&(s=E.$sc.offset().top,l=M(E.o_win).outerHeight()-s-a);var d="body"==E.opts.scrollableContainer?E.helpers.scrollTop():s,c=r.is(".fr-sticky-on");r.data("sticky-parent")||r.data("sticky-parent",r.parent());var f=r.data("sticky-parent"),p=f.offset().top,u=f.outerHeight();if(r.data("sticky-offset")?E.$box.find(".fr-sticky-dummy").css("height",o+"px"):(r.data("sticky-offset",!0),r.after('<div class="fr-sticky-dummy" style="height: '+o+'px;"></div>')),!i){var g="auto"!==r.css("top")||"auto"!==r.css("bottom");g||r.css("position","fixed"),i={top:E.node.hasClass(r.get(0),"fr-top"),bottom:E.node.hasClass(r.get(0),"fr-bottom")},g||r.css("position",""),r.data("sticky-position",i),r.data("top",E.node.hasClass(r.get(0),"fr-top")?r.css("top"):"auto"),r.data("bottom",E.node.hasClass(r.get(0),"fr-bottom")?r.css("bottom"):"auto")}t=E.helpers.getPX(r.data("top")),n=E.helpers.getPX(r.data("bottom"));var h=i.top&&p<d+t&&d+t<=p+u-o&&(E.helpers.isInViewPort(E.$sc.get(0))||"body"==E.opts.scrollableContainer),m=i.bottom&&p+o<d+a-n&&d+a-n<p+u;h||m?(r.css("width",f.get(0).getBoundingClientRect().width+"px"),c||(r.addClass("fr-sticky-on"),r.removeClass("fr-sticky-off"),r.css("top")&&("auto"!=r.data("top")?r.css("top",E.helpers.getPX(r.data("top"))+s):r.data("top","auto")),r.css("bottom")&&("auto"!=r.data("bottom")?r.css("bottom",E.helpers.getPX(r.data("bottom"))+l):r.css("bottom","auto")))):E.node.hasClass(r.get(0),"fr-sticky-off")||(r.width(""),r.removeClass("fr-sticky-on"),r.addClass("fr-sticky-off"),r.css("top")&&"auto"!=r.data("top")&&i.top&&r.css("top",0),r.css("bottom")&&"auto"!=r.data("bottom")&&i.bottom&&r.css("bottom",0))}}function e(){if(E._stickyElements)for(var e=0;e<E._stickyElements.length;e++)t(E._stickyElements[e])}return{_init:function(){!function(){if(E._stickyElements=[],E.helpers.isIOS()){var t=function(){if(E.helpers.requestAnimationFrame()(t),!1!==E.events.trigger("position.refresh"))for(var e=0;e<E._stickyElements.length;e++)n(E._stickyElements[e])};t(),E.events.$on(M(E.o_win),"scroll",function(){if(E.core.hasFocus())for(var e=0;e<E._stickyElements.length;e++){var t=M(E._stickyElements[e]),n=t.parent(),r=E.helpers.scrollTop();t.outerHeight()<r-n.offset().top&&(t.addClass("fr-opacity-0"),t.data("sticky-top",-1),t.data("sticky-scheduled",-1))}},!0)}else"body"!==E.opts.scrollableContainer&&E.events.$on(M(E.opts.scrollableContainer),"scroll",e,!0),E.events.$on(M(E.o_win),"scroll",e,!0),E.events.$on(M(E.o_win),"resize",e,!0),E.events.on("initialized",e),E.events.on("focus",e),E.events.$on(M(E.o_win),"resize","textarea",e,!0);E.events.on("destroy",function(){E._stickyElements=[]})}()},forSelection:function(e){var t=o();e.css({top:0,left:0});var n=t.top+t.height,r=t.left+t.width/2-e.get(0).offsetWidth/2+E.helpers.scrollLeft();E.opts.iframe||(n+=E.helpers.scrollTop()),i(r,n,e,t.height)},addSticky:function(e){e.addClass("fr-sticky"),E.helpers.isIOS()&&e.addClass("fr-sticky-ios"),e.removeClass("fr-sticky"),E._stickyElements.push(e.get(0))},refresh:e,at:i,getBoundingRect:o}},M.FE.MODULES.refresh=function(o){function i(e,t){e.toggleClass("fr-disabled",t).attr("aria-disabled",t)}return{undo:function(e){i(e,!o.undo.canDo())},redo:function(e){i(e,!o.undo.canRedo())},outdent:function(e){if(o.node.hasClass(e.get(0),"fr-no-refresh"))return!1;for(var t=o.selection.blocks(),n=0;n<t.length;n++){var r="rtl"==o.opts.direction||"rtl"==M(t[n]).css("direction")?"margin-right":"margin-left";if("LI"==t[n].tagName||"LI"==t[n].parentNode.tagName)return i(e,!1),!0;if(0<o.helpers.getPX(M(t[n]).css(r)))return i(e,!1),!0}i(e,!0)},indent:function(e){if(o.node.hasClass(e.get(0),"fr-no-refresh"))return!1;for(var t=o.selection.blocks(),n=0;n<t.length;n++){for(var r=t[n].previousSibling;r&&r.nodeType==Node.TEXT_NODE&&0===r.textContent.length;)r=r.previousSibling;if("LI"!=t[n].tagName||r)return i(e,!1),!0;i(e,!0)}}}},M.extend(M.FE.DEFAULTS,{editInPopup:!1}),M.FE.MODULES.textEdit=function(n){function t(){n.events.$on(n.$el,n._mouseup,function(){setTimeout(function(){var e,t;t=n.popups.get("text.edit"),e="INPUT"===n.$el.prop("tagName")?n.$el.attr("placeholder"):n.$el.text(),t.find("input").val(e).trigger("change"),n.popups.setContainer("text.edit",n.$sc),n.popups.show("text.edit",n.$el.offset().left+n.$el.outerWidth()/2,n.$el.offset().top+n.$el.outerHeight(),n.$el.outerHeight())},10)})}return{_init:function(){var e;n.opts.editInPopup&&(e={edit:'<div id="fr-text-edit-'+n.id+'" class="fr-layer fr-text-edit-layer"><div class="fr-input-line"><input type="text" placeholder="'+n.language.translate("Text")+'" tabIndex="1"></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-submit" data-cmd="updateText" tabIndex="2">'+n.language.translate("Update")+"</button></div></div>"},n.popups.create("text.edit",e),t())},update:function(){var e=n.popups.get("text.edit").find("input").val();0===e.length&&(e=n.opts.placeholderText),"INPUT"===n.$el.prop("tagName")?n.$el.attr("placeholder",e):n.$el.text(e),n.events.trigger("contentChanged"),n.popups.hide("text.edit")}}},M.FE.RegisterCommand("updateText",{focus:!1,undo:!1,callback:function(){this.textEdit.update()}}),M.extend(M.FE.DEFAULTS,{toolbarBottom:!1,toolbarButtons:null,toolbarButtonsXS:null,toolbarButtonsSM:null,toolbarButtonsMD:null,toolbarContainer:null,toolbarInline:!1,toolbarSticky:!0,toolbarStickyOffset:0,toolbarVisibleWithoutSelection:!1}),M.FE.TOOLBAR_BUTTONS=["fullscreen","bold","italic","underline","strikeThrough","subscript","superscript","|","fontFamily","fontSize","color","inlineStyle","paragraphStyle","|","paragraphFormat","align","formatOL","formatUL","outdent","indent","quote","-","insertLink","insertImage","insertVideo","embedly","insertFile","insertTable","|","emoticons","specialCharacters","insertHR","selectAll","clearFormatting","|","print","spellChecker","help","html","|","undo","redo"],M.FE.TOOLBAR_BUTTONS_MD=null,M.FE.TOOLBAR_BUTTONS_SM=["bold","italic","underline","|","fontFamily","fontSize","insertLink","insertImage","table","|","undo","redo"],M.FE.TOOLBAR_BUTTONS_XS=["bold","italic","fontFamily","fontSize","|","undo","redo"],M.FE.MODULES.toolbar=function(o){var r=[];function i(e,t){for(var n=0;n<t.length;n++)"-"!=t[n]&&"|"!=t[n]&&e.indexOf(t[n])<0&&e.push(t[n])}function a(){var e=o.helpers.screenSize();return r[e]}function e(){var e=a();o.$tb.find(".fr-separator").remove(),o.$tb.find("> .fr-command").addClass("fr-hidden");for(var t=0;t<e.length;t++)if("|"==e[t]||"-"==e[t])o.$tb.append(o.button.buildList([e[t]]));else{var n=o.$tb.find('> .fr-command[data-cmd="'+e[t]+'"]'),r=null;o.node.hasClass(n.next().get(0),"fr-dropdown-menu")&&(r=n.next()),n.removeClass("fr-hidden").appendTo(o.$tb),r&&r.appendTo(o.$tb)}}function t(e,t){setTimeout(function(){if((!e||e.which!=M.FE.KEYCODE.ESC)&&o.selection.inEditor()&&o.core.hasFocus()&&!o.popups.areVisible()&&(o.opts.toolbarVisibleWithoutSelection||!o.selection.isCollapsed()&&!o.keys.isIME()||t)){if(o.$tb.data("instance",o),!1===o.events.trigger("toolbar.show",[e]))return!1;o.$tb.show(),o.opts.toolbarContainer||o.position.forSelection(o.$tb),1<o.opts.zIndex?o.$tb.css("z-index",o.opts.zIndex+1):o.$tb.css("z-index",null)}},0)}function n(e){return(!e||"blur"!==e.type||document.activeElement!==o.el)&&(!(!e||"keydown"!==e.type||!o.keys.ctrlKey(e))||(!!o.button.getButtons(".fr-dropdown.fr-active").next().find(o.o_doc.activeElement).length||void(!1!==o.events.trigger("toolbar.hide")&&o.$tb.hide())))}r[M.FE.XS]=o.opts.toolbarButtonsXS||o.opts.toolbarButtons||M.FE.TOOLBAR_BUTTONS_XS||M.FE.TOOLBAR_BUTTONS||[],r[M.FE.SM]=o.opts.toolbarButtonsSM||o.opts.toolbarButtons||M.FE.TOOLBAR_BUTTONS_SM||M.FE.TOOLBAR_BUTTONS||[],r[M.FE.MD]=o.opts.toolbarButtonsMD||o.opts.toolbarButtons||M.FE.TOOLBAR_BUTTONS_MD||M.FE.TOOLBAR_BUTTONS||[],r[M.FE.LG]=o.opts.toolbarButtons||M.FE.TOOLBAR_BUTTONS||[];var s=null;function l(e){clearTimeout(s),e&&e.which==M.FE.KEYCODE.ESC||(s=setTimeout(t,o.opts.typingTimer))}function d(){o.events.on("window.mousedown",n),o.events.on("keydown",n),o.events.on("blur",n),o.helpers.isMobile()||o.events.on("window.mouseup",t),o.helpers.isMobile()?o.helpers.isIOS()||(o.events.on("window.touchend",t),o.browser.mozilla&&setInterval(t,200)):o.events.on("window.keyup",l),o.events.on("keydown",function(e){e&&e.which==M.FE.KEYCODE.ESC&&n()}),o.events.on("keydown",function(e){if(e.which==M.FE.KEYCODE.ALT)return e.stopPropagation(),!1},!0),o.events.$on(o.$wp,"scroll.toolbar",t),o.events.on("commands.after",t),o.helpers.isMobile()&&(o.events.$on(o.$doc,"selectionchange",l),o.events.$on(o.$doc,"orientationchange",t))}function c(){o.$tb.html("").removeData().remove(),o.$tb=null}function f(){o.$box.removeClass("fr-top fr-bottom fr-inline fr-basic"),o.$box.find(".fr-sticky-dummy").remove()}function p(){o.opts.theme&&o.$tb.addClass(o.opts.theme+"-theme"),1<o.opts.zIndex&&o.$tb.css("z-index",o.opts.zIndex+1),"auto"!=o.opts.direction&&o.$tb.removeClass("fr-ltr fr-rtl").addClass("fr-"+o.opts.direction),o.helpers.isMobile()?o.$tb.addClass("fr-mobile"):o.$tb.addClass("fr-desktop"),o.opts.toolbarContainer?(o.opts.toolbarInline&&(d(),n()),o.opts.toolbarBottom?o.$tb.addClass("fr-bottom"):o.$tb.addClass("fr-top")):o.opts.toolbarInline?(o.$sc.append(o.$tb),o.$tb.data("container",o.$sc),o.$tb.addClass("fr-inline"),o.$tb.prepend('<span class="fr-arrow"></span>'),d(),o.opts.toolbarBottom=!1):(o.opts.toolbarBottom&&!o.helpers.isIOS()?(o.$box.append(o.$tb),o.$tb.addClass("fr-bottom"),o.$box.addClass("fr-bottom")):(o.opts.toolbarBottom=!1,o.$box.prepend(o.$tb),o.$tb.addClass("fr-top"),o.$box.addClass("fr-top")),o.$tb.addClass("fr-basic"),o.opts.toolbarSticky&&(o.opts.toolbarStickyOffset&&(o.opts.toolbarBottom?o.$tb.css("bottom",o.opts.toolbarStickyOffset):o.$tb.css("top",o.opts.toolbarStickyOffset)),o.position.addSticky(o.$tb))),function(){var e=M.merge([],a());i(e,r[M.FE.XS]),i(e,r[M.FE.SM]),i(e,r[M.FE.MD]),i(e,r[M.FE.LG]);for(var t=e.length-1;0<=t;t--)"-"!=e[t]&&"|"!=e[t]&&e.indexOf(e[t])<t&&e.splice(t,1);var n=o.button.buildList(e,a());o.$tb.append(n),o.button.bindCommands(o.$tb)}(),o.events.$on(M(o.o_win),"resize",e),o.events.$on(M(o.o_win),"orientationchange",e),o.accessibility.registerToolbar(o.$tb),o.events.$on(o.$tb,o._mousedown+" "+o._mouseup,function(e){var t=e.originalEvent?e.originalEvent.target||e.originalEvent.originalTarget:null;if(t&&"INPUT"!=t.tagName&&!o.edit.isDisabled())return e.stopPropagation(),e.preventDefault(),!1},!0)}var u=!1;return{_init:function(){if(o.$sc=M(o.opts.scrollableContainer).first(),!o.$wp)return!1;o.opts.toolbarContainer?(o.shared.$tb?(o.$tb=o.shared.$tb,o.opts.toolbarInline&&d()):(o.shared.$tb=M('<div class="fr-toolbar"></div>'),o.$tb=o.shared.$tb,M(o.opts.toolbarContainer).append(o.$tb),p(),o.$tb.data("instance",o)),o.opts.toolbarInline?o.$box.addClass("fr-inline"):o.$box.addClass("fr-basic"),o.events.on("focus",function(){o.$tb.data("instance",o)},!0),o.opts.toolbarInline=!1):o.opts.toolbarInline?(o.$box.addClass("fr-inline"),o.shared.$tb?(o.$tb=o.shared.$tb,d()):(o.shared.$tb=M('<div class="fr-toolbar"></div>'),o.$tb=o.shared.$tb,p())):(o.$box.addClass("fr-basic"),o.$tb=M('<div class="fr-toolbar"></div>'),p(),o.$tb.data("instance",o)),o.events.on("destroy",f,!0),o.events.on(o.opts.toolbarInline||o.opts.toolbarContainer?"shared.destroy":"destroy",c,!0)},hide:n,show:function(){if(!1===o.events.trigger("toolbar.show"))return!1;o.$tb.show()},showInline:t,disable:function(){!u&&o.$tb&&(o.$tb.find("> .fr-command").addClass("fr-disabled fr-no-refresh").attr("aria-disabled",!0),u=!0)},enable:function(){u&&o.$tb&&(o.$tb.find("> .fr-command").removeClass("fr-disabled fr-no-refresh").attr("aria-disabled",!1),u=!1),o.button.bulkRefresh()}}}});
// CodeMirror, copyright (c) by Marijn Haverbeke and others
// Distributed under an MIT license: http://codemirror.net/LICENSE

// This is CodeMirror (http://codemirror.net), a code editor
// implemented in JavaScript on top of the browser's DOM.
//
// You can find some technical background for some of the code below
// at http://marijnhaverbeke.nl/blog/#cm-internals .

(function (global, factory) {
	typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
	typeof define === 'function' && define.amd ? define(factory) :
	(global.CodeMirror = factory());
}(this, (function () { 'use strict';

// Kludges for bugs and behavior differences that can't be feature
// detected are enabled based on userAgent etc sniffing.
var userAgent = navigator.userAgent;
var platform = navigator.platform;

var gecko = /gecko\/\d/i.test(userAgent);
var ie_upto10 = /MSIE \d/.test(userAgent);
var ie_11up = /Trident\/(?:[7-9]|\d{2,})\..*rv:(\d+)/.exec(userAgent);
var edge = /Edge\/(\d+)/.exec(userAgent);
var ie = ie_upto10 || ie_11up || edge;
var ie_version = ie && (ie_upto10 ? document.documentMode || 6 : +(edge || ie_11up)[1]);
var webkit = !edge && /WebKit\//.test(userAgent);
var qtwebkit = webkit && /Qt\/\d+\.\d+/.test(userAgent);
var chrome = !edge && /Chrome\//.test(userAgent);
var presto = /Opera\//.test(userAgent);
var safari = /Apple Computer/.test(navigator.vendor);
var mac_geMountainLion = /Mac OS X 1\d\D([8-9]|\d\d)\D/.test(userAgent);
var phantom = /PhantomJS/.test(userAgent);

var ios = !edge && /AppleWebKit/.test(userAgent) && /Mobile\/\w+/.test(userAgent);
var android = /Android/.test(userAgent);
// This is woefully incomplete. Suggestions for alternative methods welcome.
var mobile = ios || android || /webOS|BlackBerry|Opera Mini|Opera Mobi|IEMobile/i.test(userAgent);
var mac = ios || /Mac/.test(platform);
var chromeOS = /\bCrOS\b/.test(userAgent);
var windows = /win/i.test(platform);

var presto_version = presto && userAgent.match(/Version\/(\d*\.\d*)/);
if (presto_version) { presto_version = Number(presto_version[1]); }
if (presto_version && presto_version >= 15) { presto = false; webkit = true; }
// Some browsers use the wrong event properties to signal cmd/ctrl on OS X
var flipCtrlCmd = mac && (qtwebkit || presto && (presto_version == null || presto_version < 12.11));
var captureRightClick = gecko || (ie && ie_version >= 9);

function classTest(cls) { return new RegExp("(^|\\s)" + cls + "(?:$|\\s)\\s*") }

var rmClass = function(node, cls) {
  var current = node.className;
  var match = classTest(cls).exec(current);
  if (match) {
    var after = current.slice(match.index + match[0].length);
    node.className = current.slice(0, match.index) + (after ? match[1] + after : "");
  }
};

function removeChildren(e) {
  for (var count = e.childNodes.length; count > 0; --count)
    { e.removeChild(e.firstChild); }
  return e
}

function removeChildrenAndAdd(parent, e) {
  return removeChildren(parent).appendChild(e)
}

function elt(tag, content, className, style) {
  var e = document.createElement(tag);
  if (className) { e.className = className; }
  if (style) { e.style.cssText = style; }
  if (typeof content == "string") { e.appendChild(document.createTextNode(content)); }
  else if (content) { for (var i = 0; i < content.length; ++i) { e.appendChild(content[i]); } }
  return e
}
// wrapper for elt, which removes the elt from the accessibility tree
function eltP(tag, content, className, style) {
  var e = elt(tag, content, className, style);
  e.setAttribute("role", "presentation");
  return e
}

var range;
if (document.createRange) { range = function(node, start, end, endNode) {
  var r = document.createRange();
  r.setEnd(endNode || node, end);
  r.setStart(node, start);
  return r
}; }
else { range = function(node, start, end) {
  var r = document.body.createTextRange();
  try { r.moveToElementText(node.parentNode); }
  catch(e) { return r }
  r.collapse(true);
  r.moveEnd("character", end);
  r.moveStart("character", start);
  return r
}; }

function contains(parent, child) {
  if (child.nodeType == 3) // Android browser always returns false when child is a textnode
    { child = child.parentNode; }
  if (parent.contains)
    { return parent.contains(child) }
  do {
    if (child.nodeType == 11) { child = child.host; }
    if (child == parent) { return true }
  } while (child = child.parentNode)
}

function activeElt() {
  // IE and Edge may throw an "Unspecified Error" when accessing document.activeElement.
  // IE < 10 will throw when accessed while the page is loading or in an iframe.
  // IE > 9 and Edge will throw when accessed in an iframe if document.body is unavailable.
  var activeElement;
  try {
    activeElement = document.activeElement;
  } catch(e) {
    activeElement = document.body || null;
  }
  while (activeElement && activeElement.shadowRoot && activeElement.shadowRoot.activeElement)
    { activeElement = activeElement.shadowRoot.activeElement; }
  return activeElement
}

function addClass(node, cls) {
  var current = node.className;
  if (!classTest(cls).test(current)) { node.className += (current ? " " : "") + cls; }
}
function joinClasses(a, b) {
  var as = a.split(" ");
  for (var i = 0; i < as.length; i++)
    { if (as[i] && !classTest(as[i]).test(b)) { b += " " + as[i]; } }
  return b
}

var selectInput = function(node) { node.select(); };
if (ios) // Mobile Safari apparently has a bug where select() is broken.
  { selectInput = function(node) { node.selectionStart = 0; node.selectionEnd = node.value.length; }; }
else if (ie) // Suppress mysterious IE10 errors
  { selectInput = function(node) { try { node.select(); } catch(_e) {} }; }

function bind(f) {
  var args = Array.prototype.slice.call(arguments, 1);
  return function(){return f.apply(null, args)}
}

function copyObj(obj, target, overwrite) {
  if (!target) { target = {}; }
  for (var prop in obj)
    { if (obj.hasOwnProperty(prop) && (overwrite !== false || !target.hasOwnProperty(prop)))
      { target[prop] = obj[prop]; } }
  return target
}

// Counts the column offset in a string, taking tabs into account.
// Used mostly to find indentation.
function countColumn(string, end, tabSize, startIndex, startValue) {
  if (end == null) {
    end = string.search(/[^\s\u00a0]/);
    if (end == -1) { end = string.length; }
  }
  for (var i = startIndex || 0, n = startValue || 0;;) {
    var nextTab = string.indexOf("\t", i);
    if (nextTab < 0 || nextTab >= end)
      { return n + (end - i) }
    n += nextTab - i;
    n += tabSize - (n % tabSize);
    i = nextTab + 1;
  }
}

var Delayed = function() {this.id = null;};
Delayed.prototype.set = function (ms, f) {
  clearTimeout(this.id);
  this.id = setTimeout(f, ms);
};

function indexOf(array, elt) {
  for (var i = 0; i < array.length; ++i)
    { if (array[i] == elt) { return i } }
  return -1
}

// Number of pixels added to scroller and sizer to hide scrollbar
var scrollerGap = 30;

// Returned or thrown by various protocols to signal 'I'm not
// handling this'.
var Pass = {toString: function(){return "CodeMirror.Pass"}};

// Reused option objects for setSelection & friends
var sel_dontScroll = {scroll: false};
var sel_mouse = {origin: "*mouse"};
var sel_move = {origin: "+move"};

// The inverse of countColumn -- find the offset that corresponds to
// a particular column.
function findColumn(string, goal, tabSize) {
  for (var pos = 0, col = 0;;) {
    var nextTab = string.indexOf("\t", pos);
    if (nextTab == -1) { nextTab = string.length; }
    var skipped = nextTab - pos;
    if (nextTab == string.length || col + skipped >= goal)
      { return pos + Math.min(skipped, goal - col) }
    col += nextTab - pos;
    col += tabSize - (col % tabSize);
    pos = nextTab + 1;
    if (col >= goal) { return pos }
  }
}

var spaceStrs = [""];
function spaceStr(n) {
  while (spaceStrs.length <= n)
    { spaceStrs.push(lst(spaceStrs) + " "); }
  return spaceStrs[n]
}

function lst(arr) { return arr[arr.length-1] }

function map(array, f) {
  var out = [];
  for (var i = 0; i < array.length; i++) { out[i] = f(array[i], i); }
  return out
}

function insertSorted(array, value, score) {
  var pos = 0, priority = score(value);
  while (pos < array.length && score(array[pos]) <= priority) { pos++; }
  array.splice(pos, 0, value);
}

function nothing() {}

function createObj(base, props) {
  var inst;
  if (Object.create) {
    inst = Object.create(base);
  } else {
    nothing.prototype = base;
    inst = new nothing();
  }
  if (props) { copyObj(props, inst); }
  return inst
}

var nonASCIISingleCaseWordChar = /[\u00df\u0587\u0590-\u05f4\u0600-\u06ff\u3040-\u309f\u30a0-\u30ff\u3400-\u4db5\u4e00-\u9fcc\uac00-\ud7af]/;
function isWordCharBasic(ch) {
  return /\w/.test(ch) || ch > "\x80" &&
    (ch.toUpperCase() != ch.toLowerCase() || nonASCIISingleCaseWordChar.test(ch))
}
function isWordChar(ch, helper) {
  if (!helper) { return isWordCharBasic(ch) }
  if (helper.source.indexOf("\\w") > -1 && isWordCharBasic(ch)) { return true }
  return helper.test(ch)
}

function isEmpty(obj) {
  for (var n in obj) { if (obj.hasOwnProperty(n) && obj[n]) { return false } }
  return true
}

// Extending unicode characters. A series of a non-extending char +
// any number of extending chars is treated as a single unit as far
// as editing and measuring is concerned. This is not fully correct,
// since some scripts/fonts/browsers also treat other configurations
// of code points as a group.
var extendingChars = /[\u0300-\u036f\u0483-\u0489\u0591-\u05bd\u05bf\u05c1\u05c2\u05c4\u05c5\u05c7\u0610-\u061a\u064b-\u065e\u0670\u06d6-\u06dc\u06de-\u06e4\u06e7\u06e8\u06ea-\u06ed\u0711\u0730-\u074a\u07a6-\u07b0\u07eb-\u07f3\u0816-\u0819\u081b-\u0823\u0825-\u0827\u0829-\u082d\u0900-\u0902\u093c\u0941-\u0948\u094d\u0951-\u0955\u0962\u0963\u0981\u09bc\u09be\u09c1-\u09c4\u09cd\u09d7\u09e2\u09e3\u0a01\u0a02\u0a3c\u0a41\u0a42\u0a47\u0a48\u0a4b-\u0a4d\u0a51\u0a70\u0a71\u0a75\u0a81\u0a82\u0abc\u0ac1-\u0ac5\u0ac7\u0ac8\u0acd\u0ae2\u0ae3\u0b01\u0b3c\u0b3e\u0b3f\u0b41-\u0b44\u0b4d\u0b56\u0b57\u0b62\u0b63\u0b82\u0bbe\u0bc0\u0bcd\u0bd7\u0c3e-\u0c40\u0c46-\u0c48\u0c4a-\u0c4d\u0c55\u0c56\u0c62\u0c63\u0cbc\u0cbf\u0cc2\u0cc6\u0ccc\u0ccd\u0cd5\u0cd6\u0ce2\u0ce3\u0d3e\u0d41-\u0d44\u0d4d\u0d57\u0d62\u0d63\u0dca\u0dcf\u0dd2-\u0dd4\u0dd6\u0ddf\u0e31\u0e34-\u0e3a\u0e47-\u0e4e\u0eb1\u0eb4-\u0eb9\u0ebb\u0ebc\u0ec8-\u0ecd\u0f18\u0f19\u0f35\u0f37\u0f39\u0f71-\u0f7e\u0f80-\u0f84\u0f86\u0f87\u0f90-\u0f97\u0f99-\u0fbc\u0fc6\u102d-\u1030\u1032-\u1037\u1039\u103a\u103d\u103e\u1058\u1059\u105e-\u1060\u1071-\u1074\u1082\u1085\u1086\u108d\u109d\u135f\u1712-\u1714\u1732-\u1734\u1752\u1753\u1772\u1773\u17b7-\u17bd\u17c6\u17c9-\u17d3\u17dd\u180b-\u180d\u18a9\u1920-\u1922\u1927\u1928\u1932\u1939-\u193b\u1a17\u1a18\u1a56\u1a58-\u1a5e\u1a60\u1a62\u1a65-\u1a6c\u1a73-\u1a7c\u1a7f\u1b00-\u1b03\u1b34\u1b36-\u1b3a\u1b3c\u1b42\u1b6b-\u1b73\u1b80\u1b81\u1ba2-\u1ba5\u1ba8\u1ba9\u1c2c-\u1c33\u1c36\u1c37\u1cd0-\u1cd2\u1cd4-\u1ce0\u1ce2-\u1ce8\u1ced\u1dc0-\u1de6\u1dfd-\u1dff\u200c\u200d\u20d0-\u20f0\u2cef-\u2cf1\u2de0-\u2dff\u302a-\u302f\u3099\u309a\ua66f-\ua672\ua67c\ua67d\ua6f0\ua6f1\ua802\ua806\ua80b\ua825\ua826\ua8c4\ua8e0-\ua8f1\ua926-\ua92d\ua947-\ua951\ua980-\ua982\ua9b3\ua9b6-\ua9b9\ua9bc\uaa29-\uaa2e\uaa31\uaa32\uaa35\uaa36\uaa43\uaa4c\uaab0\uaab2-\uaab4\uaab7\uaab8\uaabe\uaabf\uaac1\uabe5\uabe8\uabed\udc00-\udfff\ufb1e\ufe00-\ufe0f\ufe20-\ufe26\uff9e\uff9f]/;
function isExtendingChar(ch) { return ch.charCodeAt(0) >= 768 && extendingChars.test(ch) }

// Returns a number from the range [`0`; `str.length`] unless `pos` is outside that range.
function skipExtendingChars(str, pos, dir) {
  while ((dir < 0 ? pos > 0 : pos < str.length) && isExtendingChar(str.charAt(pos))) { pos += dir; }
  return pos
}

// Returns the value from the range [`from`; `to`] that satisfies
// `pred` and is closest to `from`. Assumes that at least `to`
// satisfies `pred`. Supports `from` being greater than `to`.
function findFirst(pred, from, to) {
  // At any point we are certain `to` satisfies `pred`, don't know
  // whether `from` does.
  var dir = from > to ? -1 : 1;
  for (;;) {
    if (from == to) { return from }
    var midF = (from + to) / 2, mid = dir < 0 ? Math.ceil(midF) : Math.floor(midF);
    if (mid == from) { return pred(mid) ? from : to }
    if (pred(mid)) { to = mid; }
    else { from = mid + dir; }
  }
}

// The display handles the DOM integration, both for input reading
// and content drawing. It holds references to DOM nodes and
// display-related state.

function Display(place, doc, input) {
  var d = this;
  this.input = input;

  // Covers bottom-right square when both scrollbars are present.
  d.scrollbarFiller = elt("div", null, "CodeMirror-scrollbar-filler");
  d.scrollbarFiller.setAttribute("cm-not-content", "true");
  // Covers bottom of gutter when coverGutterNextToScrollbar is on
  // and h scrollbar is present.
  d.gutterFiller = elt("div", null, "CodeMirror-gutter-filler");
  d.gutterFiller.setAttribute("cm-not-content", "true");
  // Will contain the actual code, positioned to cover the viewport.
  d.lineDiv = eltP("div", null, "CodeMirror-code");
  // Elements are added to these to represent selection and cursors.
  d.selectionDiv = elt("div", null, null, "position: relative; z-index: 1");
  d.cursorDiv = elt("div", null, "CodeMirror-cursors");
  // A visibility: hidden element used to find the size of things.
  d.measure = elt("div", null, "CodeMirror-measure");
  // When lines outside of the viewport are measured, they are drawn in this.
  d.lineMeasure = elt("div", null, "CodeMirror-measure");
  // Wraps everything that needs to exist inside the vertically-padded coordinate system
  d.lineSpace = eltP("div", [d.measure, d.lineMeasure, d.selectionDiv, d.cursorDiv, d.lineDiv],
                    null, "position: relative; outline: none");
  var lines = eltP("div", [d.lineSpace], "CodeMirror-lines");
  // Moved around its parent to cover visible view.
  d.mover = elt("div", [lines], null, "position: relative");
  // Set to the height of the document, allowing scrolling.
  d.sizer = elt("div", [d.mover], "CodeMirror-sizer");
  d.sizerWidth = null;
  // Behavior of elts with overflow: auto and padding is
  // inconsistent across browsers. This is used to ensure the
  // scrollable area is big enough.
  d.heightForcer = elt("div", null, null, "position: absolute; height: " + scrollerGap + "px; width: 1px;");
  // Will contain the gutters, if any.
  d.gutters = elt("div", null, "CodeMirror-gutters");
  d.lineGutter = null;
  // Actual scrollable element.
  d.scroller = elt("div", [d.sizer, d.heightForcer, d.gutters], "CodeMirror-scroll");
  d.scroller.setAttribute("tabIndex", "-1");
  // The element in which the editor lives.
  d.wrapper = elt("div", [d.scrollbarFiller, d.gutterFiller, d.scroller], "CodeMirror");

  // Work around IE7 z-index bug (not perfect, hence IE7 not really being supported)
  if (ie && ie_version < 8) { d.gutters.style.zIndex = -1; d.scroller.style.paddingRight = 0; }
  if (!webkit && !(gecko && mobile)) { d.scroller.draggable = true; }

  if (place) {
    if (place.appendChild) { place.appendChild(d.wrapper); }
    else { place(d.wrapper); }
  }

  // Current rendered range (may be bigger than the view window).
  d.viewFrom = d.viewTo = doc.first;
  d.reportedViewFrom = d.reportedViewTo = doc.first;
  // Information about the rendered lines.
  d.view = [];
  d.renderedView = null;
  // Holds info about a single rendered line when it was rendered
  // for measurement, while not in view.
  d.externalMeasured = null;
  // Empty space (in pixels) above the view
  d.viewOffset = 0;
  d.lastWrapHeight = d.lastWrapWidth = 0;
  d.updateLineNumbers = null;

  d.nativeBarWidth = d.barHeight = d.barWidth = 0;
  d.scrollbarsClipped = false;

  // Used to only resize the line number gutter when necessary (when
  // the amount of lines crosses a boundary that makes its width change)
  d.lineNumWidth = d.lineNumInnerWidth = d.lineNumChars = null;
  // Set to true when a non-horizontal-scrolling line widget is
  // added. As an optimization, line widget aligning is skipped when
  // this is false.
  d.alignWidgets = false;

  d.cachedCharWidth = d.cachedTextHeight = d.cachedPaddingH = null;

  // Tracks the maximum line length so that the horizontal scrollbar
  // can be kept static when scrolling.
  d.maxLine = null;
  d.maxLineLength = 0;
  d.maxLineChanged = false;

  // Used for measuring wheel scrolling granularity
  d.wheelDX = d.wheelDY = d.wheelStartX = d.wheelStartY = null;

  // True when shift is held down.
  d.shift = false;

  // Used to track whether anything happened since the context menu
  // was opened.
  d.selForContextMenu = null;

  d.activeTouch = null;

  input.init(d);
}

// Find the line object corresponding to the given line number.
function getLine(doc, n) {
  n -= doc.first;
  if (n < 0 || n >= doc.size) { throw new Error("There is no line " + (n + doc.first) + " in the document.") }
  var chunk = doc;
  while (!chunk.lines) {
    for (var i = 0;; ++i) {
      var child = chunk.children[i], sz = child.chunkSize();
      if (n < sz) { chunk = child; break }
      n -= sz;
    }
  }
  return chunk.lines[n]
}

// Get the part of a document between two positions, as an array of
// strings.
function getBetween(doc, start, end) {
  var out = [], n = start.line;
  doc.iter(start.line, end.line + 1, function (line) {
    var text = line.text;
    if (n == end.line) { text = text.slice(0, end.ch); }
    if (n == start.line) { text = text.slice(start.ch); }
    out.push(text);
    ++n;
  });
  return out
}
// Get the lines between from and to, as array of strings.
function getLines(doc, from, to) {
  var out = [];
  doc.iter(from, to, function (line) { out.push(line.text); }); // iter aborts when callback returns truthy value
  return out
}

// Update the height of a line, propagating the height change
// upwards to parent nodes.
function updateLineHeight(line, height) {
  var diff = height - line.height;
  if (diff) { for (var n = line; n; n = n.parent) { n.height += diff; } }
}

// Given a line object, find its line number by walking up through
// its parent links.
function lineNo(line) {
  if (line.parent == null) { return null }
  var cur = line.parent, no = indexOf(cur.lines, line);
  for (var chunk = cur.parent; chunk; cur = chunk, chunk = chunk.parent) {
    for (var i = 0;; ++i) {
      if (chunk.children[i] == cur) { break }
      no += chunk.children[i].chunkSize();
    }
  }
  return no + cur.first
}

// Find the line at the given vertical position, using the height
// information in the document tree.
function lineAtHeight(chunk, h) {
  var n = chunk.first;
  outer: do {
    for (var i$1 = 0; i$1 < chunk.children.length; ++i$1) {
      var child = chunk.children[i$1], ch = child.height;
      if (h < ch) { chunk = child; continue outer }
      h -= ch;
      n += child.chunkSize();
    }
    return n
  } while (!chunk.lines)
  var i = 0;
  for (; i < chunk.lines.length; ++i) {
    var line = chunk.lines[i], lh = line.height;
    if (h < lh) { break }
    h -= lh;
  }
  return n + i
}

function isLine(doc, l) {return l >= doc.first && l < doc.first + doc.size}

function lineNumberFor(options, i) {
  return String(options.lineNumberFormatter(i + options.firstLineNumber))
}

// A Pos instance represents a position within the text.
function Pos(line, ch, sticky) {
  if ( sticky === void 0 ) sticky = null;

  if (!(this instanceof Pos)) { return new Pos(line, ch, sticky) }
  this.line = line;
  this.ch = ch;
  this.sticky = sticky;
}

// Compare two positions, return 0 if they are the same, a negative
// number when a is less, and a positive number otherwise.
function cmp(a, b) { return a.line - b.line || a.ch - b.ch }

function equalCursorPos(a, b) { return a.sticky == b.sticky && cmp(a, b) == 0 }

function copyPos(x) {return Pos(x.line, x.ch)}
function maxPos(a, b) { return cmp(a, b) < 0 ? b : a }
function minPos(a, b) { return cmp(a, b) < 0 ? a : b }

// Most of the external API clips given positions to make sure they
// actually exist within the document.
function clipLine(doc, n) {return Math.max(doc.first, Math.min(n, doc.first + doc.size - 1))}
function clipPos(doc, pos) {
  if (pos.line < doc.first) { return Pos(doc.first, 0) }
  var last = doc.first + doc.size - 1;
  if (pos.line > last) { return Pos(last, getLine(doc, last).text.length) }
  return clipToLen(pos, getLine(doc, pos.line).text.length)
}
function clipToLen(pos, linelen) {
  var ch = pos.ch;
  if (ch == null || ch > linelen) { return Pos(pos.line, linelen) }
  else if (ch < 0) { return Pos(pos.line, 0) }
  else { return pos }
}
function clipPosArray(doc, array) {
  var out = [];
  for (var i = 0; i < array.length; i++) { out[i] = clipPos(doc, array[i]); }
  return out
}

// Optimize some code when these features are not used.
var sawReadOnlySpans = false;
var sawCollapsedSpans = false;

function seeReadOnlySpans() {
  sawReadOnlySpans = true;
}

function seeCollapsedSpans() {
  sawCollapsedSpans = true;
}

// TEXTMARKER SPANS

function MarkedSpan(marker, from, to) {
  this.marker = marker;
  this.from = from; this.to = to;
}

// Search an array of spans for a span matching the given marker.
function getMarkedSpanFor(spans, marker) {
  if (spans) { for (var i = 0; i < spans.length; ++i) {
    var span = spans[i];
    if (span.marker == marker) { return span }
  } }
}
// Remove a span from an array, returning undefined if no spans are
// left (we don't store arrays for lines without spans).
function removeMarkedSpan(spans, span) {
  var r;
  for (var i = 0; i < spans.length; ++i)
    { if (spans[i] != span) { (r || (r = [])).push(spans[i]); } }
  return r
}
// Add a span to a line.
function addMarkedSpan(line, span) {
  line.markedSpans = line.markedSpans ? line.markedSpans.concat([span]) : [span];
  span.marker.attachLine(line);
}

// Used for the algorithm that adjusts markers for a change in the
// document. These functions cut an array of spans at a given
// character position, returning an array of remaining chunks (or
// undefined if nothing remains).
function markedSpansBefore(old, startCh, isInsert) {
  var nw;
  if (old) { for (var i = 0; i < old.length; ++i) {
    var span = old[i], marker = span.marker;
    var startsBefore = span.from == null || (marker.inclusiveLeft ? span.from <= startCh : span.from < startCh);
    if (startsBefore || span.from == startCh && marker.type == "bookmark" && (!isInsert || !span.marker.insertLeft)) {
      var endsAfter = span.to == null || (marker.inclusiveRight ? span.to >= startCh : span.to > startCh);(nw || (nw = [])).push(new MarkedSpan(marker, span.from, endsAfter ? null : span.to));
    }
  } }
  return nw
}
function markedSpansAfter(old, endCh, isInsert) {
  var nw;
  if (old) { for (var i = 0; i < old.length; ++i) {
    var span = old[i], marker = span.marker;
    var endsAfter = span.to == null || (marker.inclusiveRight ? span.to >= endCh : span.to > endCh);
    if (endsAfter || span.from == endCh && marker.type == "bookmark" && (!isInsert || span.marker.insertLeft)) {
      var startsBefore = span.from == null || (marker.inclusiveLeft ? span.from <= endCh : span.from < endCh);(nw || (nw = [])).push(new MarkedSpan(marker, startsBefore ? null : span.from - endCh,
                                            span.to == null ? null : span.to - endCh));
    }
  } }
  return nw
}

// Given a change object, compute the new set of marker spans that
// cover the line in which the change took place. Removes spans
// entirely within the change, reconnects spans belonging to the
// same marker that appear on both sides of the change, and cuts off
// spans partially within the change. Returns an array of span
// arrays with one element for each line in (after) the change.
function stretchSpansOverChange(doc, change) {
  if (change.full) { return null }
  var oldFirst = isLine(doc, change.from.line) && getLine(doc, change.from.line).markedSpans;
  var oldLast = isLine(doc, change.to.line) && getLine(doc, change.to.line).markedSpans;
  if (!oldFirst && !oldLast) { return null }

  var startCh = change.from.ch, endCh = change.to.ch, isInsert = cmp(change.from, change.to) == 0;
  // Get the spans that 'stick out' on both sides
  var first = markedSpansBefore(oldFirst, startCh, isInsert);
  var last = markedSpansAfter(oldLast, endCh, isInsert);

  // Next, merge those two ends
  var sameLine = change.text.length == 1, offset = lst(change.text).length + (sameLine ? startCh : 0);
  if (first) {
    // Fix up .to properties of first
    for (var i = 0; i < first.length; ++i) {
      var span = first[i];
      if (span.to == null) {
        var found = getMarkedSpanFor(last, span.marker);
        if (!found) { span.to = startCh; }
        else if (sameLine) { span.to = found.to == null ? null : found.to + offset; }
      }
    }
  }
  if (last) {
    // Fix up .from in last (or move them into first in case of sameLine)
    for (var i$1 = 0; i$1 < last.length; ++i$1) {
      var span$1 = last[i$1];
      if (span$1.to != null) { span$1.to += offset; }
      if (span$1.from == null) {
        var found$1 = getMarkedSpanFor(first, span$1.marker);
        if (!found$1) {
          span$1.from = offset;
          if (sameLine) { (first || (first = [])).push(span$1); }
        }
      } else {
        span$1.from += offset;
        if (sameLine) { (first || (first = [])).push(span$1); }
      }
    }
  }
  // Make sure we didn't create any zero-length spans
  if (first) { first = clearEmptySpans(first); }
  if (last && last != first) { last = clearEmptySpans(last); }

  var newMarkers = [first];
  if (!sameLine) {
    // Fill gap with whole-line-spans
    var gap = change.text.length - 2, gapMarkers;
    if (gap > 0 && first)
      { for (var i$2 = 0; i$2 < first.length; ++i$2)
        { if (first[i$2].to == null)
          { (gapMarkers || (gapMarkers = [])).push(new MarkedSpan(first[i$2].marker, null, null)); } } }
    for (var i$3 = 0; i$3 < gap; ++i$3)
      { newMarkers.push(gapMarkers); }
    newMarkers.push(last);
  }
  return newMarkers
}

// Remove spans that are empty and don't have a clearWhenEmpty
// option of false.
function clearEmptySpans(spans) {
  for (var i = 0; i < spans.length; ++i) {
    var span = spans[i];
    if (span.from != null && span.from == span.to && span.marker.clearWhenEmpty !== false)
      { spans.splice(i--, 1); }
  }
  if (!spans.length) { return null }
  return spans
}

// Used to 'clip' out readOnly ranges when making a change.
function removeReadOnlyRanges(doc, from, to) {
  var markers = null;
  doc.iter(from.line, to.line + 1, function (line) {
    if (line.markedSpans) { for (var i = 0; i < line.markedSpans.length; ++i) {
      var mark = line.markedSpans[i].marker;
      if (mark.readOnly && (!markers || indexOf(markers, mark) == -1))
        { (markers || (markers = [])).push(mark); }
    } }
  });
  if (!markers) { return null }
  var parts = [{from: from, to: to}];
  for (var i = 0; i < markers.length; ++i) {
    var mk = markers[i], m = mk.find(0);
    for (var j = 0; j < parts.length; ++j) {
      var p = parts[j];
      if (cmp(p.to, m.from) < 0 || cmp(p.from, m.to) > 0) { continue }
      var newParts = [j, 1], dfrom = cmp(p.from, m.from), dto = cmp(p.to, m.to);
      if (dfrom < 0 || !mk.inclusiveLeft && !dfrom)
        { newParts.push({from: p.from, to: m.from}); }
      if (dto > 0 || !mk.inclusiveRight && !dto)
        { newParts.push({from: m.to, to: p.to}); }
      parts.splice.apply(parts, newParts);
      j += newParts.length - 3;
    }
  }
  return parts
}

// Connect or disconnect spans from a line.
function detachMarkedSpans(line) {
  var spans = line.markedSpans;
  if (!spans) { return }
  for (var i = 0; i < spans.length; ++i)
    { spans[i].marker.detachLine(line); }
  line.markedSpans = null;
}
function attachMarkedSpans(line, spans) {
  if (!spans) { return }
  for (var i = 0; i < spans.length; ++i)
    { spans[i].marker.attachLine(line); }
  line.markedSpans = spans;
}

// Helpers used when computing which overlapping collapsed span
// counts as the larger one.
function extraLeft(marker) { return marker.inclusiveLeft ? -1 : 0 }
function extraRight(marker) { return marker.inclusiveRight ? 1 : 0 }

// Returns a number indicating which of two overlapping collapsed
// spans is larger (and thus includes the other). Falls back to
// comparing ids when the spans cover exactly the same range.
function compareCollapsedMarkers(a, b) {
  var lenDiff = a.lines.length - b.lines.length;
  if (lenDiff != 0) { return lenDiff }
  var aPos = a.find(), bPos = b.find();
  var fromCmp = cmp(aPos.from, bPos.from) || extraLeft(a) - extraLeft(b);
  if (fromCmp) { return -fromCmp }
  var toCmp = cmp(aPos.to, bPos.to) || extraRight(a) - extraRight(b);
  if (toCmp) { return toCmp }
  return b.id - a.id
}

// Find out whether a line ends or starts in a collapsed span. If
// so, return the marker for that span.
function collapsedSpanAtSide(line, start) {
  var sps = sawCollapsedSpans && line.markedSpans, found;
  if (sps) { for (var sp = (void 0), i = 0; i < sps.length; ++i) {
    sp = sps[i];
    if (sp.marker.collapsed && (start ? sp.from : sp.to) == null &&
        (!found || compareCollapsedMarkers(found, sp.marker) < 0))
      { found = sp.marker; }
  } }
  return found
}
function collapsedSpanAtStart(line) { return collapsedSpanAtSide(line, true) }
function collapsedSpanAtEnd(line) { return collapsedSpanAtSide(line, false) }

function collapsedSpanAround(line, ch) {
  var sps = sawCollapsedSpans && line.markedSpans, found;
  if (sps) { for (var i = 0; i < sps.length; ++i) {
    var sp = sps[i];
    if (sp.marker.collapsed && (sp.from == null || sp.from < ch) && (sp.to == null || sp.to > ch) &&
        (!found || compareCollapsedMarkers(found, sp.marker) < 0)) { found = sp.marker; }
  } }
  return found
}

// Test whether there exists a collapsed span that partially
// overlaps (covers the start or end, but not both) of a new span.
// Such overlap is not allowed.
function conflictingCollapsedRange(doc, lineNo$$1, from, to, marker) {
  var line = getLine(doc, lineNo$$1);
  var sps = sawCollapsedSpans && line.markedSpans;
  if (sps) { for (var i = 0; i < sps.length; ++i) {
    var sp = sps[i];
    if (!sp.marker.collapsed) { continue }
    var found = sp.marker.find(0);
    var fromCmp = cmp(found.from, from) || extraLeft(sp.marker) - extraLeft(marker);
    var toCmp = cmp(found.to, to) || extraRight(sp.marker) - extraRight(marker);
    if (fromCmp >= 0 && toCmp <= 0 || fromCmp <= 0 && toCmp >= 0) { continue }
    if (fromCmp <= 0 && (sp.marker.inclusiveRight && marker.inclusiveLeft ? cmp(found.to, from) >= 0 : cmp(found.to, from) > 0) ||
        fromCmp >= 0 && (sp.marker.inclusiveRight && marker.inclusiveLeft ? cmp(found.from, to) <= 0 : cmp(found.from, to) < 0))
      { return true }
  } }
}

// A visual line is a line as drawn on the screen. Folding, for
// example, can cause multiple logical lines to appear on the same
// visual line. This finds the start of the visual line that the
// given line is part of (usually that is the line itself).
function visualLine(line) {
  var merged;
  while (merged = collapsedSpanAtStart(line))
    { line = merged.find(-1, true).line; }
  return line
}

function visualLineEnd(line) {
  var merged;
  while (merged = collapsedSpanAtEnd(line))
    { line = merged.find(1, true).line; }
  return line
}

// Returns an array of logical lines that continue the visual line
// started by the argument, or undefined if there are no such lines.
function visualLineContinued(line) {
  var merged, lines;
  while (merged = collapsedSpanAtEnd(line)) {
    line = merged.find(1, true).line
    ;(lines || (lines = [])).push(line);
  }
  return lines
}

// Get the line number of the start of the visual line that the
// given line number is part of.
function visualLineNo(doc, lineN) {
  var line = getLine(doc, lineN), vis = visualLine(line);
  if (line == vis) { return lineN }
  return lineNo(vis)
}

// Get the line number of the start of the next visual line after
// the given line.
function visualLineEndNo(doc, lineN) {
  if (lineN > doc.lastLine()) { return lineN }
  var line = getLine(doc, lineN), merged;
  if (!lineIsHidden(doc, line)) { return lineN }
  while (merged = collapsedSpanAtEnd(line))
    { line = merged.find(1, true).line; }
  return lineNo(line) + 1
}

// Compute whether a line is hidden. Lines count as hidden when they
// are part of a visual line that starts with another line, or when
// they are entirely covered by collapsed, non-widget span.
function lineIsHidden(doc, line) {
  var sps = sawCollapsedSpans && line.markedSpans;
  if (sps) { for (var sp = (void 0), i = 0; i < sps.length; ++i) {
    sp = sps[i];
    if (!sp.marker.collapsed) { continue }
    if (sp.from == null) { return true }
    if (sp.marker.widgetNode) { continue }
    if (sp.from == 0 && sp.marker.inclusiveLeft && lineIsHiddenInner(doc, line, sp))
      { return true }
  } }
}
function lineIsHiddenInner(doc, line, span) {
  if (span.to == null) {
    var end = span.marker.find(1, true);
    return lineIsHiddenInner(doc, end.line, getMarkedSpanFor(end.line.markedSpans, span.marker))
  }
  if (span.marker.inclusiveRight && span.to == line.text.length)
    { return true }
  for (var sp = (void 0), i = 0; i < line.markedSpans.length; ++i) {
    sp = line.markedSpans[i];
    if (sp.marker.collapsed && !sp.marker.widgetNode && sp.from == span.to &&
        (sp.to == null || sp.to != span.from) &&
        (sp.marker.inclusiveLeft || span.marker.inclusiveRight) &&
        lineIsHiddenInner(doc, line, sp)) { return true }
  }
}

// Find the height above the given line.
function heightAtLine(lineObj) {
  lineObj = visualLine(lineObj);

  var h = 0, chunk = lineObj.parent;
  for (var i = 0; i < chunk.lines.length; ++i) {
    var line = chunk.lines[i];
    if (line == lineObj) { break }
    else { h += line.height; }
  }
  for (var p = chunk.parent; p; chunk = p, p = chunk.parent) {
    for (var i$1 = 0; i$1 < p.children.length; ++i$1) {
      var cur = p.children[i$1];
      if (cur == chunk) { break }
      else { h += cur.height; }
    }
  }
  return h
}

// Compute the character length of a line, taking into account
// collapsed ranges (see markText) that might hide parts, and join
// other lines onto it.
function lineLength(line) {
  if (line.height == 0) { return 0 }
  var len = line.text.length, merged, cur = line;
  while (merged = collapsedSpanAtStart(cur)) {
    var found = merged.find(0, true);
    cur = found.from.line;
    len += found.from.ch - found.to.ch;
  }
  cur = line;
  while (merged = collapsedSpanAtEnd(cur)) {
    var found$1 = merged.find(0, true);
    len -= cur.text.length - found$1.from.ch;
    cur = found$1.to.line;
    len += cur.text.length - found$1.to.ch;
  }
  return len
}

// Find the longest line in the document.
function findMaxLine(cm) {
  var d = cm.display, doc = cm.doc;
  d.maxLine = getLine(doc, doc.first);
  d.maxLineLength = lineLength(d.maxLine);
  d.maxLineChanged = true;
  doc.iter(function (line) {
    var len = lineLength(line);
    if (len > d.maxLineLength) {
      d.maxLineLength = len;
      d.maxLine = line;
    }
  });
}

// BIDI HELPERS

function iterateBidiSections(order, from, to, f) {
  if (!order) { return f(from, to, "ltr", 0) }
  var found = false;
  for (var i = 0; i < order.length; ++i) {
    var part = order[i];
    if (part.from < to && part.to > from || from == to && part.to == from) {
      f(Math.max(part.from, from), Math.min(part.to, to), part.level == 1 ? "rtl" : "ltr", i);
      found = true;
    }
  }
  if (!found) { f(from, to, "ltr"); }
}

var bidiOther = null;
function getBidiPartAt(order, ch, sticky) {
  var found;
  bidiOther = null;
  for (var i = 0; i < order.length; ++i) {
    var cur = order[i];
    if (cur.from < ch && cur.to > ch) { return i }
    if (cur.to == ch) {
      if (cur.from != cur.to && sticky == "before") { found = i; }
      else { bidiOther = i; }
    }
    if (cur.from == ch) {
      if (cur.from != cur.to && sticky != "before") { found = i; }
      else { bidiOther = i; }
    }
  }
  return found != null ? found : bidiOther
}

// Bidirectional ordering algorithm
// See http://unicode.org/reports/tr9/tr9-13.html for the algorithm
// that this (partially) implements.

// One-char codes used for character types:
// L (L):   Left-to-Right
// R (R):   Right-to-Left
// r (AL):  Right-to-Left Arabic
// 1 (EN):  European Number
// + (ES):  European Number Separator
// % (ET):  European Number Terminator
// n (AN):  Arabic Number
// , (CS):  Common Number Separator
// m (NSM): Non-Spacing Mark
// b (BN):  Boundary Neutral
// s (B):   Paragraph Separator
// t (S):   Segment Separator
// w (WS):  Whitespace
// N (ON):  Other Neutrals

// Returns null if characters are ordered as they appear
// (left-to-right), or an array of sections ({from, to, level}
// objects) in the order in which they occur visually.
var bidiOrdering = (function() {
  // Character types for codepoints 0 to 0xff
  var lowTypes = "bbbbbbbbbtstwsbbbbbbbbbbbbbbssstwNN%%%NNNNNN,N,N1111111111NNNNNNNLLLLLLLLLLLLLLLLLLLLLLLLLLNNNNNNLLLLLLLLLLLLLLLLLLLLLLLLLLNNNNbbbbbbsbbbbbbbbbbbbbbbbbbbbbbbbbb,N%%%%NNNNLNNNNN%%11NLNNN1LNNNNNLLLLLLLLLLLLLLLLLLLLLLLNLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLN";
  // Character types for codepoints 0x600 to 0x6f9
  var arabicTypes = "nnnnnnNNr%%r,rNNmmmmmmmmmmmrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrmmmmmmmmmmmmmmmmmmmmmnnnnnnnnnn%nnrrrmrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrmmmmmmmnNmmmmmmrrmmNmmmmrr1111111111";
  function charType(code) {
    if (code <= 0xf7) { return lowTypes.charAt(code) }
    else if (0x590 <= code && code <= 0x5f4) { return "R" }
    else if (0x600 <= code && code <= 0x6f9) { return arabicTypes.charAt(code - 0x600) }
    else if (0x6ee <= code && code <= 0x8ac) { return "r" }
    else if (0x2000 <= code && code <= 0x200b) { return "w" }
    else if (code == 0x200c) { return "b" }
    else { return "L" }
  }

  var bidiRE = /[\u0590-\u05f4\u0600-\u06ff\u0700-\u08ac]/;
  var isNeutral = /[stwN]/, isStrong = /[LRr]/, countsAsLeft = /[Lb1n]/, countsAsNum = /[1n]/;

  function BidiSpan(level, from, to) {
    this.level = level;
    this.from = from; this.to = to;
  }

  return function(str, direction) {
    var outerType = direction == "ltr" ? "L" : "R";

    if (str.length == 0 || direction == "ltr" && !bidiRE.test(str)) { return false }
    var len = str.length, types = [];
    for (var i = 0; i < len; ++i)
      { types.push(charType(str.charCodeAt(i))); }

    // W1. Examine each non-spacing mark (NSM) in the level run, and
    // change the type of the NSM to the type of the previous
    // character. If the NSM is at the start of the level run, it will
    // get the type of sor.
    for (var i$1 = 0, prev = outerType; i$1 < len; ++i$1) {
      var type = types[i$1];
      if (type == "m") { types[i$1] = prev; }
      else { prev = type; }
    }

    // W2. Search backwards from each instance of a European number
    // until the first strong type (R, L, AL, or sor) is found. If an
    // AL is found, change the type of the European number to Arabic
    // number.
    // W3. Change all ALs to R.
    for (var i$2 = 0, cur = outerType; i$2 < len; ++i$2) {
      var type$1 = types[i$2];
      if (type$1 == "1" && cur == "r") { types[i$2] = "n"; }
      else if (isStrong.test(type$1)) { cur = type$1; if (type$1 == "r") { types[i$2] = "R"; } }
    }

    // W4. A single European separator between two European numbers
    // changes to a European number. A single common separator between
    // two numbers of the same type changes to that type.
    for (var i$3 = 1, prev$1 = types[0]; i$3 < len - 1; ++i$3) {
      var type$2 = types[i$3];
      if (type$2 == "+" && prev$1 == "1" && types[i$3+1] == "1") { types[i$3] = "1"; }
      else if (type$2 == "," && prev$1 == types[i$3+1] &&
               (prev$1 == "1" || prev$1 == "n")) { types[i$3] = prev$1; }
      prev$1 = type$2;
    }

    // W5. A sequence of European terminators adjacent to European
    // numbers changes to all European numbers.
    // W6. Otherwise, separators and terminators change to Other
    // Neutral.
    for (var i$4 = 0; i$4 < len; ++i$4) {
      var type$3 = types[i$4];
      if (type$3 == ",") { types[i$4] = "N"; }
      else if (type$3 == "%") {
        var end = (void 0);
        for (end = i$4 + 1; end < len && types[end] == "%"; ++end) {}
        var replace = (i$4 && types[i$4-1] == "!") || (end < len && types[end] == "1") ? "1" : "N";
        for (var j = i$4; j < end; ++j) { types[j] = replace; }
        i$4 = end - 1;
      }
    }

    // W7. Search backwards from each instance of a European number
    // until the first strong type (R, L, or sor) is found. If an L is
    // found, then change the type of the European number to L.
    for (var i$5 = 0, cur$1 = outerType; i$5 < len; ++i$5) {
      var type$4 = types[i$5];
      if (cur$1 == "L" && type$4 == "1") { types[i$5] = "L"; }
      else if (isStrong.test(type$4)) { cur$1 = type$4; }
    }

    // N1. A sequence of neutrals takes the direction of the
    // surrounding strong text if the text on both sides has the same
    // direction. European and Arabic numbers act as if they were R in
    // terms of their influence on neutrals. Start-of-level-run (sor)
    // and end-of-level-run (eor) are used at level run boundaries.
    // N2. Any remaining neutrals take the embedding direction.
    for (var i$6 = 0; i$6 < len; ++i$6) {
      if (isNeutral.test(types[i$6])) {
        var end$1 = (void 0);
        for (end$1 = i$6 + 1; end$1 < len && isNeutral.test(types[end$1]); ++end$1) {}
        var before = (i$6 ? types[i$6-1] : outerType) == "L";
        var after = (end$1 < len ? types[end$1] : outerType) == "L";
        var replace$1 = before == after ? (before ? "L" : "R") : outerType;
        for (var j$1 = i$6; j$1 < end$1; ++j$1) { types[j$1] = replace$1; }
        i$6 = end$1 - 1;
      }
    }

    // Here we depart from the documented algorithm, in order to avoid
    // building up an actual levels array. Since there are only three
    // levels (0, 1, 2) in an implementation that doesn't take
    // explicit embedding into account, we can build up the order on
    // the fly, without following the level-based algorithm.
    var order = [], m;
    for (var i$7 = 0; i$7 < len;) {
      if (countsAsLeft.test(types[i$7])) {
        var start = i$7;
        for (++i$7; i$7 < len && countsAsLeft.test(types[i$7]); ++i$7) {}
        order.push(new BidiSpan(0, start, i$7));
      } else {
        var pos = i$7, at = order.length;
        for (++i$7; i$7 < len && types[i$7] != "L"; ++i$7) {}
        for (var j$2 = pos; j$2 < i$7;) {
          if (countsAsNum.test(types[j$2])) {
            if (pos < j$2) { order.splice(at, 0, new BidiSpan(1, pos, j$2)); }
            var nstart = j$2;
            for (++j$2; j$2 < i$7 && countsAsNum.test(types[j$2]); ++j$2) {}
            order.splice(at, 0, new BidiSpan(2, nstart, j$2));
            pos = j$2;
          } else { ++j$2; }
        }
        if (pos < i$7) { order.splice(at, 0, new BidiSpan(1, pos, i$7)); }
      }
    }
    if (direction == "ltr") {
      if (order[0].level == 1 && (m = str.match(/^\s+/))) {
        order[0].from = m[0].length;
        order.unshift(new BidiSpan(0, 0, m[0].length));
      }
      if (lst(order).level == 1 && (m = str.match(/\s+$/))) {
        lst(order).to -= m[0].length;
        order.push(new BidiSpan(0, len - m[0].length, len));
      }
    }

    return direction == "rtl" ? order.reverse() : order
  }
})();

// Get the bidi ordering for the given line (and cache it). Returns
// false for lines that are fully left-to-right, and an array of
// BidiSpan objects otherwise.
function getOrder(line, direction) {
  var order = line.order;
  if (order == null) { order = line.order = bidiOrdering(line.text, direction); }
  return order
}

// EVENT HANDLING

// Lightweight event framework. on/off also work on DOM nodes,
// registering native DOM handlers.

var noHandlers = [];

var on = function(emitter, type, f) {
  if (emitter.addEventListener) {
    emitter.addEventListener(type, f, false);
  } else if (emitter.attachEvent) {
    emitter.attachEvent("on" + type, f);
  } else {
    var map$$1 = emitter._handlers || (emitter._handlers = {});
    map$$1[type] = (map$$1[type] || noHandlers).concat(f);
  }
};

function getHandlers(emitter, type) {
  return emitter._handlers && emitter._handlers[type] || noHandlers
}

function off(emitter, type, f) {
  if (emitter.removeEventListener) {
    emitter.removeEventListener(type, f, false);
  } else if (emitter.detachEvent) {
    emitter.detachEvent("on" + type, f);
  } else {
    var map$$1 = emitter._handlers, arr = map$$1 && map$$1[type];
    if (arr) {
      var index = indexOf(arr, f);
      if (index > -1)
        { map$$1[type] = arr.slice(0, index).concat(arr.slice(index + 1)); }
    }
  }
}

function signal(emitter, type /*, values...*/) {
  var handlers = getHandlers(emitter, type);
  if (!handlers.length) { return }
  var args = Array.prototype.slice.call(arguments, 2);
  for (var i = 0; i < handlers.length; ++i) { handlers[i].apply(null, args); }
}

// The DOM events that CodeMirror handles can be overridden by
// registering a (non-DOM) handler on the editor for the event name,
// and preventDefault-ing the event in that handler.
function signalDOMEvent(cm, e, override) {
  if (typeof e == "string")
    { e = {type: e, preventDefault: function() { this.defaultPrevented = true; }}; }
  signal(cm, override || e.type, cm, e);
  return e_defaultPrevented(e) || e.codemirrorIgnore
}

function signalCursorActivity(cm) {
  var arr = cm._handlers && cm._handlers.cursorActivity;
  if (!arr) { return }
  var set = cm.curOp.cursorActivityHandlers || (cm.curOp.cursorActivityHandlers = []);
  for (var i = 0; i < arr.length; ++i) { if (indexOf(set, arr[i]) == -1)
    { set.push(arr[i]); } }
}

function hasHandler(emitter, type) {
  return getHandlers(emitter, type).length > 0
}

// Add on and off methods to a constructor's prototype, to make
// registering events on such objects more convenient.
function eventMixin(ctor) {
  ctor.prototype.on = function(type, f) {on(this, type, f);};
  ctor.prototype.off = function(type, f) {off(this, type, f);};
}

// Due to the fact that we still support jurassic IE versions, some
// compatibility wrappers are needed.

function e_preventDefault(e) {
  if (e.preventDefault) { e.preventDefault(); }
  else { e.returnValue = false; }
}
function e_stopPropagation(e) {
  if (e.stopPropagation) { e.stopPropagation(); }
  else { e.cancelBubble = true; }
}
function e_defaultPrevented(e) {
  return e.defaultPrevented != null ? e.defaultPrevented : e.returnValue == false
}
function e_stop(e) {e_preventDefault(e); e_stopPropagation(e);}

function e_target(e) {return e.target || e.srcElement}
function e_button(e) {
  var b = e.which;
  if (b == null) {
    if (e.button & 1) { b = 1; }
    else if (e.button & 2) { b = 3; }
    else if (e.button & 4) { b = 2; }
  }
  if (mac && e.ctrlKey && b == 1) { b = 3; }
  return b
}

// Detect drag-and-drop
var dragAndDrop = function() {
  // There is *some* kind of drag-and-drop support in IE6-8, but I
  // couldn't get it to work yet.
  if (ie && ie_version < 9) { return false }
  var div = elt('div');
  return "draggable" in div || "dragDrop" in div
}();

var zwspSupported;
function zeroWidthElement(measure) {
  if (zwspSupported == null) {
    var test = elt("span", "\u200b");
    removeChildrenAndAdd(measure, elt("span", [test, document.createTextNode("x")]));
    if (measure.firstChild.offsetHeight != 0)
      { zwspSupported = test.offsetWidth <= 1 && test.offsetHeight > 2 && !(ie && ie_version < 8); }
  }
  var node = zwspSupported ? elt("span", "\u200b") :
    elt("span", "\u00a0", null, "display: inline-block; width: 1px; margin-right: -1px");
  node.setAttribute("cm-text", "");
  return node
}

// Feature-detect IE's crummy client rect reporting for bidi text
var badBidiRects;
function hasBadBidiRects(measure) {
  if (badBidiRects != null) { return badBidiRects }
  var txt = removeChildrenAndAdd(measure, document.createTextNode("A\u062eA"));
  var r0 = range(txt, 0, 1).getBoundingClientRect();
  var r1 = range(txt, 1, 2).getBoundingClientRect();
  removeChildren(measure);
  if (!r0 || r0.left == r0.right) { return false } // Safari returns null in some cases (#2780)
  return badBidiRects = (r1.right - r0.right < 3)
}

// See if "".split is the broken IE version, if so, provide an
// alternative way to split lines.
var splitLinesAuto = "\n\nb".split(/\n/).length != 3 ? function (string) {
  var pos = 0, result = [], l = string.length;
  while (pos <= l) {
    var nl = string.indexOf("\n", pos);
    if (nl == -1) { nl = string.length; }
    var line = string.slice(pos, string.charAt(nl - 1) == "\r" ? nl - 1 : nl);
    var rt = line.indexOf("\r");
    if (rt != -1) {
      result.push(line.slice(0, rt));
      pos += rt + 1;
    } else {
      result.push(line);
      pos = nl + 1;
    }
  }
  return result
} : function (string) { return string.split(/\r\n?|\n/); };

var hasSelection = window.getSelection ? function (te) {
  try { return te.selectionStart != te.selectionEnd }
  catch(e) { return false }
} : function (te) {
  var range$$1;
  try {range$$1 = te.ownerDocument.selection.createRange();}
  catch(e) {}
  if (!range$$1 || range$$1.parentElement() != te) { return false }
  return range$$1.compareEndPoints("StartToEnd", range$$1) != 0
};

var hasCopyEvent = (function () {
  var e = elt("div");
  if ("oncopy" in e) { return true }
  e.setAttribute("oncopy", "return;");
  return typeof e.oncopy == "function"
})();

var badZoomedRects = null;
function hasBadZoomedRects(measure) {
  if (badZoomedRects != null) { return badZoomedRects }
  var node = removeChildrenAndAdd(measure, elt("span", "x"));
  var normal = node.getBoundingClientRect();
  var fromRange = range(node, 0, 1).getBoundingClientRect();
  return badZoomedRects = Math.abs(normal.left - fromRange.left) > 1
}

// Known modes, by name and by MIME
var modes = {};
var mimeModes = {};

// Extra arguments are stored as the mode's dependencies, which is
// used by (legacy) mechanisms like loadmode.js to automatically
// load a mode. (Preferred mechanism is the require/define calls.)
function defineMode(name, mode) {
  if (arguments.length > 2)
    { mode.dependencies = Array.prototype.slice.call(arguments, 2); }
  modes[name] = mode;
}

function defineMIME(mime, spec) {
  mimeModes[mime] = spec;
}

// Given a MIME type, a {name, ...options} config object, or a name
// string, return a mode config object.
function resolveMode(spec) {
  if (typeof spec == "string" && mimeModes.hasOwnProperty(spec)) {
    spec = mimeModes[spec];
  } else if (spec && typeof spec.name == "string" && mimeModes.hasOwnProperty(spec.name)) {
    var found = mimeModes[spec.name];
    if (typeof found == "string") { found = {name: found}; }
    spec = createObj(found, spec);
    spec.name = found.name;
  } else if (typeof spec == "string" && /^[\w\-]+\/[\w\-]+\+xml$/.test(spec)) {
    return resolveMode("application/xml")
  } else if (typeof spec == "string" && /^[\w\-]+\/[\w\-]+\+json$/.test(spec)) {
    return resolveMode("application/json")
  }
  if (typeof spec == "string") { return {name: spec} }
  else { return spec || {name: "null"} }
}

// Given a mode spec (anything that resolveMode accepts), find and
// initialize an actual mode object.
function getMode(options, spec) {
  spec = resolveMode(spec);
  var mfactory = modes[spec.name];
  if (!mfactory) { return getMode(options, "text/plain") }
  var modeObj = mfactory(options, spec);
  if (modeExtensions.hasOwnProperty(spec.name)) {
    var exts = modeExtensions[spec.name];
    for (var prop in exts) {
      if (!exts.hasOwnProperty(prop)) { continue }
      if (modeObj.hasOwnProperty(prop)) { modeObj["_" + prop] = modeObj[prop]; }
      modeObj[prop] = exts[prop];
    }
  }
  modeObj.name = spec.name;
  if (spec.helperType) { modeObj.helperType = spec.helperType; }
  if (spec.modeProps) { for (var prop$1 in spec.modeProps)
    { modeObj[prop$1] = spec.modeProps[prop$1]; } }

  return modeObj
}

// This can be used to attach properties to mode objects from
// outside the actual mode definition.
var modeExtensions = {};
function extendMode(mode, properties) {
  var exts = modeExtensions.hasOwnProperty(mode) ? modeExtensions[mode] : (modeExtensions[mode] = {});
  copyObj(properties, exts);
}

function copyState(mode, state) {
  if (state === true) { return state }
  if (mode.copyState) { return mode.copyState(state) }
  var nstate = {};
  for (var n in state) {
    var val = state[n];
    if (val instanceof Array) { val = val.concat([]); }
    nstate[n] = val;
  }
  return nstate
}

// Given a mode and a state (for that mode), find the inner mode and
// state at the position that the state refers to.
function innerMode(mode, state) {
  var info;
  while (mode.innerMode) {
    info = mode.innerMode(state);
    if (!info || info.mode == mode) { break }
    state = info.state;
    mode = info.mode;
  }
  return info || {mode: mode, state: state}
}

function startState(mode, a1, a2) {
  return mode.startState ? mode.startState(a1, a2) : true
}

// STRING STREAM

// Fed to the mode parsers, provides helper functions to make
// parsers more succinct.

var StringStream = function(string, tabSize, lineOracle) {
  this.pos = this.start = 0;
  this.string = string;
  this.tabSize = tabSize || 8;
  this.lastColumnPos = this.lastColumnValue = 0;
  this.lineStart = 0;
  this.lineOracle = lineOracle;
};

StringStream.prototype.eol = function () {return this.pos >= this.string.length};
StringStream.prototype.sol = function () {return this.pos == this.lineStart};
StringStream.prototype.peek = function () {return this.string.charAt(this.pos) || undefined};
StringStream.prototype.next = function () {
  if (this.pos < this.string.length)
    { return this.string.charAt(this.pos++) }
};
StringStream.prototype.eat = function (match) {
  var ch = this.string.charAt(this.pos);
  var ok;
  if (typeof match == "string") { ok = ch == match; }
  else { ok = ch && (match.test ? match.test(ch) : match(ch)); }
  if (ok) {++this.pos; return ch}
};
StringStream.prototype.eatWhile = function (match) {
  var start = this.pos;
  while (this.eat(match)){}
  return this.pos > start
};
StringStream.prototype.eatSpace = function () {
    var this$1 = this;

  var start = this.pos;
  while (/[\s\u00a0]/.test(this.string.charAt(this.pos))) { ++this$1.pos; }
  return this.pos > start
};
StringStream.prototype.skipToEnd = function () {this.pos = this.string.length;};
StringStream.prototype.skipTo = function (ch) {
  var found = this.string.indexOf(ch, this.pos);
  if (found > -1) {this.pos = found; return true}
};
StringStream.prototype.backUp = function (n) {this.pos -= n;};
StringStream.prototype.column = function () {
  if (this.lastColumnPos < this.start) {
    this.lastColumnValue = countColumn(this.string, this.start, this.tabSize, this.lastColumnPos, this.lastColumnValue);
    this.lastColumnPos = this.start;
  }
  return this.lastColumnValue - (this.lineStart ? countColumn(this.string, this.lineStart, this.tabSize) : 0)
};
StringStream.prototype.indentation = function () {
  return countColumn(this.string, null, this.tabSize) -
    (this.lineStart ? countColumn(this.string, this.lineStart, this.tabSize) : 0)
};
StringStream.prototype.match = function (pattern, consume, caseInsensitive) {
  if (typeof pattern == "string") {
    var cased = function (str) { return caseInsensitive ? str.toLowerCase() : str; };
    var substr = this.string.substr(this.pos, pattern.length);
    if (cased(substr) == cased(pattern)) {
      if (consume !== false) { this.pos += pattern.length; }
      return true
    }
  } else {
    var match = this.string.slice(this.pos).match(pattern);
    if (match && match.index > 0) { return null }
    if (match && consume !== false) { this.pos += match[0].length; }
    return match
  }
};
StringStream.prototype.current = function (){return this.string.slice(this.start, this.pos)};
StringStream.prototype.hideFirstChars = function (n, inner) {
  this.lineStart += n;
  try { return inner() }
  finally { this.lineStart -= n; }
};
StringStream.prototype.lookAhead = function (n) {
  var oracle = this.lineOracle;
  return oracle && oracle.lookAhead(n)
};
StringStream.prototype.baseToken = function () {
  var oracle = this.lineOracle;
  return oracle && oracle.baseToken(this.pos)
};

var SavedContext = function(state, lookAhead) {
  this.state = state;
  this.lookAhead = lookAhead;
};

var Context = function(doc, state, line, lookAhead) {
  this.state = state;
  this.doc = doc;
  this.line = line;
  this.maxLookAhead = lookAhead || 0;
  this.baseTokens = null;
  this.baseTokenPos = 1;
};

Context.prototype.lookAhead = function (n) {
  var line = this.doc.getLine(this.line + n);
  if (line != null && n > this.maxLookAhead) { this.maxLookAhead = n; }
  return line
};

Context.prototype.baseToken = function (n) {
    var this$1 = this;

  if (!this.baseTokens) { return null }
  while (this.baseTokens[this.baseTokenPos] <= n)
    { this$1.baseTokenPos += 2; }
  var type = this.baseTokens[this.baseTokenPos + 1];
  return {type: type && type.replace(/( |^)overlay .*/, ""),
          size: this.baseTokens[this.baseTokenPos] - n}
};

Context.prototype.nextLine = function () {
  this.line++;
  if (this.maxLookAhead > 0) { this.maxLookAhead--; }
};

Context.fromSaved = function (doc, saved, line) {
  if (saved instanceof SavedContext)
    { return new Context(doc, copyState(doc.mode, saved.state), line, saved.lookAhead) }
  else
    { return new Context(doc, copyState(doc.mode, saved), line) }
};

Context.prototype.save = function (copy) {
  var state = copy !== false ? copyState(this.doc.mode, this.state) : this.state;
  return this.maxLookAhead > 0 ? new SavedContext(state, this.maxLookAhead) : state
};


// Compute a style array (an array starting with a mode generation
// -- for invalidation -- followed by pairs of end positions and
// style strings), which is used to highlight the tokens on the
// line.
function highlightLine(cm, line, context, forceToEnd) {
  // A styles array always starts with a number identifying the
  // mode/overlays that it is based on (for easy invalidation).
  var st = [cm.state.modeGen], lineClasses = {};
  // Compute the base array of styles
  runMode(cm, line.text, cm.doc.mode, context, function (end, style) { return st.push(end, style); },
          lineClasses, forceToEnd);
  var state = context.state;

  // Run overlays, adjust style array.
  var loop = function ( o ) {
    context.baseTokens = st;
    var overlay = cm.state.overlays[o], i = 1, at = 0;
    context.state = true;
    runMode(cm, line.text, overlay.mode, context, function (end, style) {
      var start = i;
      // Ensure there's a token end at the current position, and that i points at it
      while (at < end) {
        var i_end = st[i];
        if (i_end > end)
          { st.splice(i, 1, end, st[i+1], i_end); }
        i += 2;
        at = Math.min(end, i_end);
      }
      if (!style) { return }
      if (overlay.opaque) {
        st.splice(start, i - start, end, "overlay " + style);
        i = start + 2;
      } else {
        for (; start < i; start += 2) {
          var cur = st[start+1];
          st[start+1] = (cur ? cur + " " : "") + "overlay " + style;
        }
      }
    }, lineClasses);
    context.state = state;
    context.baseTokens = null;
    context.baseTokenPos = 1;
  };

  for (var o = 0; o < cm.state.overlays.length; ++o) loop( o );

  return {styles: st, classes: lineClasses.bgClass || lineClasses.textClass ? lineClasses : null}
}

function getLineStyles(cm, line, updateFrontier) {
  if (!line.styles || line.styles[0] != cm.state.modeGen) {
    var context = getContextBefore(cm, lineNo(line));
    var resetState = line.text.length > cm.options.maxHighlightLength && copyState(cm.doc.mode, context.state);
    var result = highlightLine(cm, line, context);
    if (resetState) { context.state = resetState; }
    line.stateAfter = context.save(!resetState);
    line.styles = result.styles;
    if (result.classes) { line.styleClasses = result.classes; }
    else if (line.styleClasses) { line.styleClasses = null; }
    if (updateFrontier === cm.doc.highlightFrontier)
      { cm.doc.modeFrontier = Math.max(cm.doc.modeFrontier, ++cm.doc.highlightFrontier); }
  }
  return line.styles
}

function getContextBefore(cm, n, precise) {
  var doc = cm.doc, display = cm.display;
  if (!doc.mode.startState) { return new Context(doc, true, n) }
  var start = findStartLine(cm, n, precise);
  var saved = start > doc.first && getLine(doc, start - 1).stateAfter;
  var context = saved ? Context.fromSaved(doc, saved, start) : new Context(doc, startState(doc.mode), start);

  doc.iter(start, n, function (line) {
    processLine(cm, line.text, context);
    var pos = context.line;
    line.stateAfter = pos == n - 1 || pos % 5 == 0 || pos >= display.viewFrom && pos < display.viewTo ? context.save() : null;
    context.nextLine();
  });
  if (precise) { doc.modeFrontier = context.line; }
  return context
}

// Lightweight form of highlight -- proceed over this line and
// update state, but don't save a style array. Used for lines that
// aren't currently visible.
function processLine(cm, text, context, startAt) {
  var mode = cm.doc.mode;
  var stream = new StringStream(text, cm.options.tabSize, context);
  stream.start = stream.pos = startAt || 0;
  if (text == "") { callBlankLine(mode, context.state); }
  while (!stream.eol()) {
    readToken(mode, stream, context.state);
    stream.start = stream.pos;
  }
}

function callBlankLine(mode, state) {
  if (mode.blankLine) { return mode.blankLine(state) }
  if (!mode.innerMode) { return }
  var inner = innerMode(mode, state);
  if (inner.mode.blankLine) { return inner.mode.blankLine(inner.state) }
}

function readToken(mode, stream, state, inner) {
  for (var i = 0; i < 10; i++) {
    if (inner) { inner[0] = innerMode(mode, state).mode; }
    var style = mode.token(stream, state);
    if (stream.pos > stream.start) { return style }
  }
  throw new Error("Mode " + mode.name + " failed to advance stream.")
}

var Token = function(stream, type, state) {
  this.start = stream.start; this.end = stream.pos;
  this.string = stream.current();
  this.type = type || null;
  this.state = state;
};

// Utility for getTokenAt and getLineTokens
function takeToken(cm, pos, precise, asArray) {
  var doc = cm.doc, mode = doc.mode, style;
  pos = clipPos(doc, pos);
  var line = getLine(doc, pos.line), context = getContextBefore(cm, pos.line, precise);
  var stream = new StringStream(line.text, cm.options.tabSize, context), tokens;
  if (asArray) { tokens = []; }
  while ((asArray || stream.pos < pos.ch) && !stream.eol()) {
    stream.start = stream.pos;
    style = readToken(mode, stream, context.state);
    if (asArray) { tokens.push(new Token(stream, style, copyState(doc.mode, context.state))); }
  }
  return asArray ? tokens : new Token(stream, style, context.state)
}

function extractLineClasses(type, output) {
  if (type) { for (;;) {
    var lineClass = type.match(/(?:^|\s+)line-(background-)?(\S+)/);
    if (!lineClass) { break }
    type = type.slice(0, lineClass.index) + type.slice(lineClass.index + lineClass[0].length);
    var prop = lineClass[1] ? "bgClass" : "textClass";
    if (output[prop] == null)
      { output[prop] = lineClass[2]; }
    else if (!(new RegExp("(?:^|\s)" + lineClass[2] + "(?:$|\s)")).test(output[prop]))
      { output[prop] += " " + lineClass[2]; }
  } }
  return type
}

// Run the given mode's parser over a line, calling f for each token.
function runMode(cm, text, mode, context, f, lineClasses, forceToEnd) {
  var flattenSpans = mode.flattenSpans;
  if (flattenSpans == null) { flattenSpans = cm.options.flattenSpans; }
  var curStart = 0, curStyle = null;
  var stream = new StringStream(text, cm.options.tabSize, context), style;
  var inner = cm.options.addModeClass && [null];
  if (text == "") { extractLineClasses(callBlankLine(mode, context.state), lineClasses); }
  while (!stream.eol()) {
    if (stream.pos > cm.options.maxHighlightLength) {
      flattenSpans = false;
      if (forceToEnd) { processLine(cm, text, context, stream.pos); }
      stream.pos = text.length;
      style = null;
    } else {
      style = extractLineClasses(readToken(mode, stream, context.state, inner), lineClasses);
    }
    if (inner) {
      var mName = inner[0].name;
      if (mName) { style = "m-" + (style ? mName + " " + style : mName); }
    }
    if (!flattenSpans || curStyle != style) {
      while (curStart < stream.start) {
        curStart = Math.min(stream.start, curStart + 5000);
        f(curStart, curStyle);
      }
      curStyle = style;
    }
    stream.start = stream.pos;
  }
  while (curStart < stream.pos) {
    // Webkit seems to refuse to render text nodes longer than 57444
    // characters, and returns inaccurate measurements in nodes
    // starting around 5000 chars.
    var pos = Math.min(stream.pos, curStart + 5000);
    f(pos, curStyle);
    curStart = pos;
  }
}

// Finds the line to start with when starting a parse. Tries to
// find a line with a stateAfter, so that it can start with a
// valid state. If that fails, it returns the line with the
// smallest indentation, which tends to need the least context to
// parse correctly.
function findStartLine(cm, n, precise) {
  var minindent, minline, doc = cm.doc;
  var lim = precise ? -1 : n - (cm.doc.mode.innerMode ? 1000 : 100);
  for (var search = n; search > lim; --search) {
    if (search <= doc.first) { return doc.first }
    var line = getLine(doc, search - 1), after = line.stateAfter;
    if (after && (!precise || search + (after instanceof SavedContext ? after.lookAhead : 0) <= doc.modeFrontier))
      { return search }
    var indented = countColumn(line.text, null, cm.options.tabSize);
    if (minline == null || minindent > indented) {
      minline = search - 1;
      minindent = indented;
    }
  }
  return minline
}

function retreatFrontier(doc, n) {
  doc.modeFrontier = Math.min(doc.modeFrontier, n);
  if (doc.highlightFrontier < n - 10) { return }
  var start = doc.first;
  for (var line = n - 1; line > start; line--) {
    var saved = getLine(doc, line).stateAfter;
    // change is on 3
    // state on line 1 looked ahead 2 -- so saw 3
    // test 1 + 2 < 3 should cover this
    if (saved && (!(saved instanceof SavedContext) || line + saved.lookAhead < n)) {
      start = line + 1;
      break
    }
  }
  doc.highlightFrontier = Math.min(doc.highlightFrontier, start);
}

// LINE DATA STRUCTURE

// Line objects. These hold state related to a line, including
// highlighting info (the styles array).
var Line = function(text, markedSpans, estimateHeight) {
  this.text = text;
  attachMarkedSpans(this, markedSpans);
  this.height = estimateHeight ? estimateHeight(this) : 1;
};

Line.prototype.lineNo = function () { return lineNo(this) };
eventMixin(Line);

// Change the content (text, markers) of a line. Automatically
// invalidates cached information and tries to re-estimate the
// line's height.
function updateLine(line, text, markedSpans, estimateHeight) {
  line.text = text;
  if (line.stateAfter) { line.stateAfter = null; }
  if (line.styles) { line.styles = null; }
  if (line.order != null) { line.order = null; }
  detachMarkedSpans(line);
  attachMarkedSpans(line, markedSpans);
  var estHeight = estimateHeight ? estimateHeight(line) : 1;
  if (estHeight != line.height) { updateLineHeight(line, estHeight); }
}

// Detach a line from the document tree and its markers.
function cleanUpLine(line) {
  line.parent = null;
  detachMarkedSpans(line);
}

// Convert a style as returned by a mode (either null, or a string
// containing one or more styles) to a CSS style. This is cached,
// and also looks for line-wide styles.
var styleToClassCache = {};
var styleToClassCacheWithMode = {};
function interpretTokenStyle(style, options) {
  if (!style || /^\s*$/.test(style)) { return null }
  var cache = options.addModeClass ? styleToClassCacheWithMode : styleToClassCache;
  return cache[style] ||
    (cache[style] = style.replace(/\S+/g, "cm-$&"))
}

// Render the DOM representation of the text of a line. Also builds
// up a 'line map', which points at the DOM nodes that represent
// specific stretches of text, and is used by the measuring code.
// The returned object contains the DOM node, this map, and
// information about line-wide styles that were set by the mode.
function buildLineContent(cm, lineView) {
  // The padding-right forces the element to have a 'border', which
  // is needed on Webkit to be able to get line-level bounding
  // rectangles for it (in measureChar).
  var content = eltP("span", null, null, webkit ? "padding-right: .1px" : null);
  var builder = {pre: eltP("pre", [content], "CodeMirror-line"), content: content,
                 col: 0, pos: 0, cm: cm,
                 trailingSpace: false,
                 splitSpaces: (ie || webkit) && cm.getOption("lineWrapping")};
  lineView.measure = {};

  // Iterate over the logical lines that make up this visual line.
  for (var i = 0; i <= (lineView.rest ? lineView.rest.length : 0); i++) {
    var line = i ? lineView.rest[i - 1] : lineView.line, order = (void 0);
    builder.pos = 0;
    builder.addToken = buildToken;
    // Optionally wire in some hacks into the token-rendering
    // algorithm, to deal with browser quirks.
    if (hasBadBidiRects(cm.display.measure) && (order = getOrder(line, cm.doc.direction)))
      { builder.addToken = buildTokenBadBidi(builder.addToken, order); }
    builder.map = [];
    var allowFrontierUpdate = lineView != cm.display.externalMeasured && lineNo(line);
    insertLineContent(line, builder, getLineStyles(cm, line, allowFrontierUpdate));
    if (line.styleClasses) {
      if (line.styleClasses.bgClass)
        { builder.bgClass = joinClasses(line.styleClasses.bgClass, builder.bgClass || ""); }
      if (line.styleClasses.textClass)
        { builder.textClass = joinClasses(line.styleClasses.textClass, builder.textClass || ""); }
    }

    // Ensure at least a single node is present, for measuring.
    if (builder.map.length == 0)
      { builder.map.push(0, 0, builder.content.appendChild(zeroWidthElement(cm.display.measure))); }

    // Store the map and a cache object for the current logical line
    if (i == 0) {
      lineView.measure.map = builder.map;
      lineView.measure.cache = {};
    } else {
      (lineView.measure.maps || (lineView.measure.maps = [])).push(builder.map)
      ;(lineView.measure.caches || (lineView.measure.caches = [])).push({});
    }
  }

  // See issue #2901
  if (webkit) {
    var last = builder.content.lastChild;
    if (/\bcm-tab\b/.test(last.className) || (last.querySelector && last.querySelector(".cm-tab")))
      { builder.content.className = "cm-tab-wrap-hack"; }
  }

  signal(cm, "renderLine", cm, lineView.line, builder.pre);
  if (builder.pre.className)
    { builder.textClass = joinClasses(builder.pre.className, builder.textClass || ""); }

  return builder
}

function defaultSpecialCharPlaceholder(ch) {
  var token = elt("span", "\u2022", "cm-invalidchar");
  token.title = "\\u" + ch.charCodeAt(0).toString(16);
  token.setAttribute("aria-label", token.title);
  return token
}

// Build up the DOM representation for a single token, and add it to
// the line map. Takes care to render special characters separately.
function buildToken(builder, text, style, startStyle, endStyle, title, css) {
  if (!text) { return }
  var displayText = builder.splitSpaces ? splitSpaces(text, builder.trailingSpace) : text;
  var special = builder.cm.state.specialChars, mustWrap = false;
  var content;
  if (!special.test(text)) {
    builder.col += text.length;
    content = document.createTextNode(displayText);
    builder.map.push(builder.pos, builder.pos + text.length, content);
    if (ie && ie_version < 9) { mustWrap = true; }
    builder.pos += text.length;
  } else {
    content = document.createDocumentFragment();
    var pos = 0;
    while (true) {
      special.lastIndex = pos;
      var m = special.exec(text);
      var skipped = m ? m.index - pos : text.length - pos;
      if (skipped) {
        var txt = document.createTextNode(displayText.slice(pos, pos + skipped));
        if (ie && ie_version < 9) { content.appendChild(elt("span", [txt])); }
        else { content.appendChild(txt); }
        builder.map.push(builder.pos, builder.pos + skipped, txt);
        builder.col += skipped;
        builder.pos += skipped;
      }
      if (!m) { break }
      pos += skipped + 1;
      var txt$1 = (void 0);
      if (m[0] == "\t") {
        var tabSize = builder.cm.options.tabSize, tabWidth = tabSize - builder.col % tabSize;
        txt$1 = content.appendChild(elt("span", spaceStr(tabWidth), "cm-tab"));
        txt$1.setAttribute("role", "presentation");
        txt$1.setAttribute("cm-text", "\t");
        builder.col += tabWidth;
      } else if (m[0] == "\r" || m[0] == "\n") {
        txt$1 = content.appendChild(elt("span", m[0] == "\r" ? "\u240d" : "\u2424", "cm-invalidchar"));
        txt$1.setAttribute("cm-text", m[0]);
        builder.col += 1;
      } else {
        txt$1 = builder.cm.options.specialCharPlaceholder(m[0]);
        txt$1.setAttribute("cm-text", m[0]);
        if (ie && ie_version < 9) { content.appendChild(elt("span", [txt$1])); }
        else { content.appendChild(txt$1); }
        builder.col += 1;
      }
      builder.map.push(builder.pos, builder.pos + 1, txt$1);
      builder.pos++;
    }
  }
  builder.trailingSpace = displayText.charCodeAt(text.length - 1) == 32;
  if (style || startStyle || endStyle || mustWrap || css) {
    var fullStyle = style || "";
    if (startStyle) { fullStyle += startStyle; }
    if (endStyle) { fullStyle += endStyle; }
    var token = elt("span", [content], fullStyle, css);
    if (title) { token.title = title; }
    return builder.content.appendChild(token)
  }
  builder.content.appendChild(content);
}

function splitSpaces(text, trailingBefore) {
  if (text.length > 1 && !/  /.test(text)) { return text }
  var spaceBefore = trailingBefore, result = "";
  for (var i = 0; i < text.length; i++) {
    var ch = text.charAt(i);
    if (ch == " " && spaceBefore && (i == text.length - 1 || text.charCodeAt(i + 1) == 32))
      { ch = "\u00a0"; }
    result += ch;
    spaceBefore = ch == " ";
  }
  return result
}

// Work around nonsense dimensions being reported for stretches of
// right-to-left text.
function buildTokenBadBidi(inner, order) {
  return function (builder, text, style, startStyle, endStyle, title, css) {
    style = style ? style + " cm-force-border" : "cm-force-border";
    var start = builder.pos, end = start + text.length;
    for (;;) {
      // Find the part that overlaps with the start of this text
      var part = (void 0);
      for (var i = 0; i < order.length; i++) {
        part = order[i];
        if (part.to > start && part.from <= start) { break }
      }
      if (part.to >= end) { return inner(builder, text, style, startStyle, endStyle, title, css) }
      inner(builder, text.slice(0, part.to - start), style, startStyle, null, title, css);
      startStyle = null;
      text = text.slice(part.to - start);
      start = part.to;
    }
  }
}

function buildCollapsedSpan(builder, size, marker, ignoreWidget) {
  var widget = !ignoreWidget && marker.widgetNode;
  if (widget) { builder.map.push(builder.pos, builder.pos + size, widget); }
  if (!ignoreWidget && builder.cm.display.input.needsContentAttribute) {
    if (!widget)
      { widget = builder.content.appendChild(document.createElement("span")); }
    widget.setAttribute("cm-marker", marker.id);
  }
  if (widget) {
    builder.cm.display.input.setUneditable(widget);
    builder.content.appendChild(widget);
  }
  builder.pos += size;
  builder.trailingSpace = false;
}

// Outputs a number of spans to make up a line, taking highlighting
// and marked text into account.
function insertLineContent(line, builder, styles) {
  var spans = line.markedSpans, allText = line.text, at = 0;
  if (!spans) {
    for (var i$1 = 1; i$1 < styles.length; i$1+=2)
      { builder.addToken(builder, allText.slice(at, at = styles[i$1]), interpretTokenStyle(styles[i$1+1], builder.cm.options)); }
    return
  }

  var len = allText.length, pos = 0, i = 1, text = "", style, css;
  var nextChange = 0, spanStyle, spanEndStyle, spanStartStyle, title, collapsed;
  for (;;) {
    if (nextChange == pos) { // Update current marker set
      spanStyle = spanEndStyle = spanStartStyle = title = css = "";
      collapsed = null; nextChange = Infinity;
      var foundBookmarks = [], endStyles = (void 0);
      for (var j = 0; j < spans.length; ++j) {
        var sp = spans[j], m = sp.marker;
        if (m.type == "bookmark" && sp.from == pos && m.widgetNode) {
          foundBookmarks.push(m);
        } else if (sp.from <= pos && (sp.to == null || sp.to > pos || m.collapsed && sp.to == pos && sp.from == pos)) {
          if (sp.to != null && sp.to != pos && nextChange > sp.to) {
            nextChange = sp.to;
            spanEndStyle = "";
          }
          if (m.className) { spanStyle += " " + m.className; }
          if (m.css) { css = (css ? css + ";" : "") + m.css; }
          if (m.startStyle && sp.from == pos) { spanStartStyle += " " + m.startStyle; }
          if (m.endStyle && sp.to == nextChange) { (endStyles || (endStyles = [])).push(m.endStyle, sp.to); }
          if (m.title && !title) { title = m.title; }
          if (m.collapsed && (!collapsed || compareCollapsedMarkers(collapsed.marker, m) < 0))
            { collapsed = sp; }
        } else if (sp.from > pos && nextChange > sp.from) {
          nextChange = sp.from;
        }
      }
      if (endStyles) { for (var j$1 = 0; j$1 < endStyles.length; j$1 += 2)
        { if (endStyles[j$1 + 1] == nextChange) { spanEndStyle += " " + endStyles[j$1]; } } }

      if (!collapsed || collapsed.from == pos) { for (var j$2 = 0; j$2 < foundBookmarks.length; ++j$2)
        { buildCollapsedSpan(builder, 0, foundBookmarks[j$2]); } }
      if (collapsed && (collapsed.from || 0) == pos) {
        buildCollapsedSpan(builder, (collapsed.to == null ? len + 1 : collapsed.to) - pos,
                           collapsed.marker, collapsed.from == null);
        if (collapsed.to == null) { return }
        if (collapsed.to == pos) { collapsed = false; }
      }
    }
    if (pos >= len) { break }

    var upto = Math.min(len, nextChange);
    while (true) {
      if (text) {
        var end = pos + text.length;
        if (!collapsed) {
          var tokenText = end > upto ? text.slice(0, upto - pos) : text;
          builder.addToken(builder, tokenText, style ? style + spanStyle : spanStyle,
                           spanStartStyle, pos + tokenText.length == nextChange ? spanEndStyle : "", title, css);
        }
        if (end >= upto) {text = text.slice(upto - pos); pos = upto; break}
        pos = end;
        spanStartStyle = "";
      }
      text = allText.slice(at, at = styles[i++]);
      style = interpretTokenStyle(styles[i++], builder.cm.options);
    }
  }
}


// These objects are used to represent the visible (currently drawn)
// part of the document. A LineView may correspond to multiple
// logical lines, if those are connected by collapsed ranges.
function LineView(doc, line, lineN) {
  // The starting line
  this.line = line;
  // Continuing lines, if any
  this.rest = visualLineContinued(line);
  // Number of logical lines in this visual line
  this.size = this.rest ? lineNo(lst(this.rest)) - lineN + 1 : 1;
  this.node = this.text = null;
  this.hidden = lineIsHidden(doc, line);
}

// Create a range of LineView objects for the given lines.
function buildViewArray(cm, from, to) {
  var array = [], nextPos;
  for (var pos = from; pos < to; pos = nextPos) {
    var view = new LineView(cm.doc, getLine(cm.doc, pos), pos);
    nextPos = pos + view.size;
    array.push(view);
  }
  return array
}

var operationGroup = null;

function pushOperation(op) {
  if (operationGroup) {
    operationGroup.ops.push(op);
  } else {
    op.ownsGroup = operationGroup = {
      ops: [op],
      delayedCallbacks: []
    };
  }
}

function fireCallbacksForOps(group) {
  // Calls delayed callbacks and cursorActivity handlers until no
  // new ones appear
  var callbacks = group.delayedCallbacks, i = 0;
  do {
    for (; i < callbacks.length; i++)
      { callbacks[i].call(null); }
    for (var j = 0; j < group.ops.length; j++) {
      var op = group.ops[j];
      if (op.cursorActivityHandlers)
        { while (op.cursorActivityCalled < op.cursorActivityHandlers.length)
          { op.cursorActivityHandlers[op.cursorActivityCalled++].call(null, op.cm); } }
    }
  } while (i < callbacks.length)
}

function finishOperation(op, endCb) {
  var group = op.ownsGroup;
  if (!group) { return }

  try { fireCallbacksForOps(group); }
  finally {
    operationGroup = null;
    endCb(group);
  }
}

var orphanDelayedCallbacks = null;

// Often, we want to signal events at a point where we are in the
// middle of some work, but don't want the handler to start calling
// other methods on the editor, which might be in an inconsistent
// state or simply not expect any other events to happen.
// signalLater looks whether there are any handlers, and schedules
// them to be executed when the last operation ends, or, if no
// operation is active, when a timeout fires.
function signalLater(emitter, type /*, values...*/) {
  var arr = getHandlers(emitter, type);
  if (!arr.length) { return }
  var args = Array.prototype.slice.call(arguments, 2), list;
  if (operationGroup) {
    list = operationGroup.delayedCallbacks;
  } else if (orphanDelayedCallbacks) {
    list = orphanDelayedCallbacks;
  } else {
    list = orphanDelayedCallbacks = [];
    setTimeout(fireOrphanDelayed, 0);
  }
  var loop = function ( i ) {
    list.push(function () { return arr[i].apply(null, args); });
  };

  for (var i = 0; i < arr.length; ++i)
    loop( i );
}

function fireOrphanDelayed() {
  var delayed = orphanDelayedCallbacks;
  orphanDelayedCallbacks = null;
  for (var i = 0; i < delayed.length; ++i) { delayed[i](); }
}

// When an aspect of a line changes, a string is added to
// lineView.changes. This updates the relevant part of the line's
// DOM structure.
function updateLineForChanges(cm, lineView, lineN, dims) {
  for (var j = 0; j < lineView.changes.length; j++) {
    var type = lineView.changes[j];
    if (type == "text") { updateLineText(cm, lineView); }
    else if (type == "gutter") { updateLineGutter(cm, lineView, lineN, dims); }
    else if (type == "class") { updateLineClasses(cm, lineView); }
    else if (type == "widget") { updateLineWidgets(cm, lineView, dims); }
  }
  lineView.changes = null;
}

// Lines with gutter elements, widgets or a background class need to
// be wrapped, and have the extra elements added to the wrapper div
function ensureLineWrapped(lineView) {
  if (lineView.node == lineView.text) {
    lineView.node = elt("div", null, null, "position: relative");
    if (lineView.text.parentNode)
      { lineView.text.parentNode.replaceChild(lineView.node, lineView.text); }
    lineView.node.appendChild(lineView.text);
    if (ie && ie_version < 8) { lineView.node.style.zIndex = 2; }
  }
  return lineView.node
}

function updateLineBackground(cm, lineView) {
  var cls = lineView.bgClass ? lineView.bgClass + " " + (lineView.line.bgClass || "") : lineView.line.bgClass;
  if (cls) { cls += " CodeMirror-linebackground"; }
  if (lineView.background) {
    if (cls) { lineView.background.className = cls; }
    else { lineView.background.parentNode.removeChild(lineView.background); lineView.background = null; }
  } else if (cls) {
    var wrap = ensureLineWrapped(lineView);
    lineView.background = wrap.insertBefore(elt("div", null, cls), wrap.firstChild);
    cm.display.input.setUneditable(lineView.background);
  }
}

// Wrapper around buildLineContent which will reuse the structure
// in display.externalMeasured when possible.
function getLineContent(cm, lineView) {
  var ext = cm.display.externalMeasured;
  if (ext && ext.line == lineView.line) {
    cm.display.externalMeasured = null;
    lineView.measure = ext.measure;
    return ext.built
  }
  return buildLineContent(cm, lineView)
}

// Redraw the line's text. Interacts with the background and text
// classes because the mode may output tokens that influence these
// classes.
function updateLineText(cm, lineView) {
  var cls = lineView.text.className;
  var built = getLineContent(cm, lineView);
  if (lineView.text == lineView.node) { lineView.node = built.pre; }
  lineView.text.parentNode.replaceChild(built.pre, lineView.text);
  lineView.text = built.pre;
  if (built.bgClass != lineView.bgClass || built.textClass != lineView.textClass) {
    lineView.bgClass = built.bgClass;
    lineView.textClass = built.textClass;
    updateLineClasses(cm, lineView);
  } else if (cls) {
    lineView.text.className = cls;
  }
}

function updateLineClasses(cm, lineView) {
  updateLineBackground(cm, lineView);
  if (lineView.line.wrapClass)
    { ensureLineWrapped(lineView).className = lineView.line.wrapClass; }
  else if (lineView.node != lineView.text)
    { lineView.node.className = ""; }
  var textClass = lineView.textClass ? lineView.textClass + " " + (lineView.line.textClass || "") : lineView.line.textClass;
  lineView.text.className = textClass || "";
}

function updateLineGutter(cm, lineView, lineN, dims) {
  if (lineView.gutter) {
    lineView.node.removeChild(lineView.gutter);
    lineView.gutter = null;
  }
  if (lineView.gutterBackground) {
    lineView.node.removeChild(lineView.gutterBackground);
    lineView.gutterBackground = null;
  }
  if (lineView.line.gutterClass) {
    var wrap = ensureLineWrapped(lineView);
    lineView.gutterBackground = elt("div", null, "CodeMirror-gutter-background " + lineView.line.gutterClass,
                                    ("left: " + (cm.options.fixedGutter ? dims.fixedPos : -dims.gutterTotalWidth) + "px; width: " + (dims.gutterTotalWidth) + "px"));
    cm.display.input.setUneditable(lineView.gutterBackground);
    wrap.insertBefore(lineView.gutterBackground, lineView.text);
  }
  var markers = lineView.line.gutterMarkers;
  if (cm.options.lineNumbers || markers) {
    var wrap$1 = ensureLineWrapped(lineView);
    var gutterWrap = lineView.gutter = elt("div", null, "CodeMirror-gutter-wrapper", ("left: " + (cm.options.fixedGutter ? dims.fixedPos : -dims.gutterTotalWidth) + "px"));
    cm.display.input.setUneditable(gutterWrap);
    wrap$1.insertBefore(gutterWrap, lineView.text);
    if (lineView.line.gutterClass)
      { gutterWrap.className += " " + lineView.line.gutterClass; }
    if (cm.options.lineNumbers && (!markers || !markers["CodeMirror-linenumbers"]))
      { lineView.lineNumber = gutterWrap.appendChild(
        elt("div", lineNumberFor(cm.options, lineN),
            "CodeMirror-linenumber CodeMirror-gutter-elt",
            ("left: " + (dims.gutterLeft["CodeMirror-linenumbers"]) + "px; width: " + (cm.display.lineNumInnerWidth) + "px"))); }
    if (markers) { for (var k = 0; k < cm.options.gutters.length; ++k) {
      var id = cm.options.gutters[k], found = markers.hasOwnProperty(id) && markers[id];
      if (found)
        { gutterWrap.appendChild(elt("div", [found], "CodeMirror-gutter-elt",
                                   ("left: " + (dims.gutterLeft[id]) + "px; width: " + (dims.gutterWidth[id]) + "px"))); }
    } }
  }
}

function updateLineWidgets(cm, lineView, dims) {
  if (lineView.alignable) { lineView.alignable = null; }
  for (var node = lineView.node.firstChild, next = (void 0); node; node = next) {
    next = node.nextSibling;
    if (node.className == "CodeMirror-linewidget")
      { lineView.node.removeChild(node); }
  }
  insertLineWidgets(cm, lineView, dims);
}

// Build a line's DOM representation from scratch
function buildLineElement(cm, lineView, lineN, dims) {
  var built = getLineContent(cm, lineView);
  lineView.text = lineView.node = built.pre;
  if (built.bgClass) { lineView.bgClass = built.bgClass; }
  if (built.textClass) { lineView.textClass = built.textClass; }

  updateLineClasses(cm, lineView);
  updateLineGutter(cm, lineView, lineN, dims);
  insertLineWidgets(cm, lineView, dims);
  return lineView.node
}

// A lineView may contain multiple logical lines (when merged by
// collapsed spans). The widgets for all of them need to be drawn.
function insertLineWidgets(cm, lineView, dims) {
  insertLineWidgetsFor(cm, lineView.line, lineView, dims, true);
  if (lineView.rest) { for (var i = 0; i < lineView.rest.length; i++)
    { insertLineWidgetsFor(cm, lineView.rest[i], lineView, dims, false); } }
}

function insertLineWidgetsFor(cm, line, lineView, dims, allowAbove) {
  if (!line.widgets) { return }
  var wrap = ensureLineWrapped(lineView);
  for (var i = 0, ws = line.widgets; i < ws.length; ++i) {
    var widget = ws[i], node = elt("div", [widget.node], "CodeMirror-linewidget");
    if (!widget.handleMouseEvents) { node.setAttribute("cm-ignore-events", "true"); }
    positionLineWidget(widget, node, lineView, dims);
    cm.display.input.setUneditable(node);
    if (allowAbove && widget.above)
      { wrap.insertBefore(node, lineView.gutter || lineView.text); }
    else
      { wrap.appendChild(node); }
    signalLater(widget, "redraw");
  }
}

function positionLineWidget(widget, node, lineView, dims) {
  if (widget.noHScroll) {
    (lineView.alignable || (lineView.alignable = [])).push(node);
    var width = dims.wrapperWidth;
    node.style.left = dims.fixedPos + "px";
    if (!widget.coverGutter) {
      width -= dims.gutterTotalWidth;
      node.style.paddingLeft = dims.gutterTotalWidth + "px";
    }
    node.style.width = width + "px";
  }
  if (widget.coverGutter) {
    node.style.zIndex = 5;
    node.style.position = "relative";
    if (!widget.noHScroll) { node.style.marginLeft = -dims.gutterTotalWidth + "px"; }
  }
}

function widgetHeight(widget) {
  if (widget.height != null) { return widget.height }
  var cm = widget.doc.cm;
  if (!cm) { return 0 }
  if (!contains(document.body, widget.node)) {
    var parentStyle = "position: relative;";
    if (widget.coverGutter)
      { parentStyle += "margin-left: -" + cm.display.gutters.offsetWidth + "px;"; }
    if (widget.noHScroll)
      { parentStyle += "width: " + cm.display.wrapper.clientWidth + "px;"; }
    removeChildrenAndAdd(cm.display.measure, elt("div", [widget.node], null, parentStyle));
  }
  return widget.height = widget.node.parentNode.offsetHeight
}

// Return true when the given mouse event happened in a widget
function eventInWidget(display, e) {
  for (var n = e_target(e); n != display.wrapper; n = n.parentNode) {
    if (!n || (n.nodeType == 1 && n.getAttribute("cm-ignore-events") == "true") ||
        (n.parentNode == display.sizer && n != display.mover))
      { return true }
  }
}

// POSITION MEASUREMENT

function paddingTop(display) {return display.lineSpace.offsetTop}
function paddingVert(display) {return display.mover.offsetHeight - display.lineSpace.offsetHeight}
function paddingH(display) {
  if (display.cachedPaddingH) { return display.cachedPaddingH }
  var e = removeChildrenAndAdd(display.measure, elt("pre", "x"));
  var style = window.getComputedStyle ? window.getComputedStyle(e) : e.currentStyle;
  var data = {left: parseInt(style.paddingLeft), right: parseInt(style.paddingRight)};
  if (!isNaN(data.left) && !isNaN(data.right)) { display.cachedPaddingH = data; }
  return data
}

function scrollGap(cm) { return scrollerGap - cm.display.nativeBarWidth }
function displayWidth(cm) {
  return cm.display.scroller.clientWidth - scrollGap(cm) - cm.display.barWidth
}
function displayHeight(cm) {
  return cm.display.scroller.clientHeight - scrollGap(cm) - cm.display.barHeight
}

// Ensure the lineView.wrapping.heights array is populated. This is
// an array of bottom offsets for the lines that make up a drawn
// line. When lineWrapping is on, there might be more than one
// height.
function ensureLineHeights(cm, lineView, rect) {
  var wrapping = cm.options.lineWrapping;
  var curWidth = wrapping && displayWidth(cm);
  if (!lineView.measure.heights || wrapping && lineView.measure.width != curWidth) {
    var heights = lineView.measure.heights = [];
    if (wrapping) {
      lineView.measure.width = curWidth;
      var rects = lineView.text.firstChild.getClientRects();
      for (var i = 0; i < rects.length - 1; i++) {
        var cur = rects[i], next = rects[i + 1];
        if (Math.abs(cur.bottom - next.bottom) > 2)
          { heights.push((cur.bottom + next.top) / 2 - rect.top); }
      }
    }
    heights.push(rect.bottom - rect.top);
  }
}

// Find a line map (mapping character offsets to text nodes) and a
// measurement cache for the given line number. (A line view might
// contain multiple lines when collapsed ranges are present.)
function mapFromLineView(lineView, line, lineN) {
  if (lineView.line == line)
    { return {map: lineView.measure.map, cache: lineView.measure.cache} }
  for (var i = 0; i < lineView.rest.length; i++)
    { if (lineView.rest[i] == line)
      { return {map: lineView.measure.maps[i], cache: lineView.measure.caches[i]} } }
  for (var i$1 = 0; i$1 < lineView.rest.length; i$1++)
    { if (lineNo(lineView.rest[i$1]) > lineN)
      { return {map: lineView.measure.maps[i$1], cache: lineView.measure.caches[i$1], before: true} } }
}

// Render a line into the hidden node display.externalMeasured. Used
// when measurement is needed for a line that's not in the viewport.
function updateExternalMeasurement(cm, line) {
  line = visualLine(line);
  var lineN = lineNo(line);
  var view = cm.display.externalMeasured = new LineView(cm.doc, line, lineN);
  view.lineN = lineN;
  var built = view.built = buildLineContent(cm, view);
  view.text = built.pre;
  removeChildrenAndAdd(cm.display.lineMeasure, built.pre);
  return view
}

// Get a {top, bottom, left, right} box (in line-local coordinates)
// for a given character.
function measureChar(cm, line, ch, bias) {
  return measureCharPrepared(cm, prepareMeasureForLine(cm, line), ch, bias)
}

// Find a line view that corresponds to the given line number.
function findViewForLine(cm, lineN) {
  if (lineN >= cm.display.viewFrom && lineN < cm.display.viewTo)
    { return cm.display.view[findViewIndex(cm, lineN)] }
  var ext = cm.display.externalMeasured;
  if (ext && lineN >= ext.lineN && lineN < ext.lineN + ext.size)
    { return ext }
}

// Measurement can be split in two steps, the set-up work that
// applies to the whole line, and the measurement of the actual
// character. Functions like coordsChar, that need to do a lot of
// measurements in a row, can thus ensure that the set-up work is
// only done once.
function prepareMeasureForLine(cm, line) {
  var lineN = lineNo(line);
  var view = findViewForLine(cm, lineN);
  if (view && !view.text) {
    view = null;
  } else if (view && view.changes) {
    updateLineForChanges(cm, view, lineN, getDimensions(cm));
    cm.curOp.forceUpdate = true;
  }
  if (!view)
    { view = updateExternalMeasurement(cm, line); }

  var info = mapFromLineView(view, line, lineN);
  return {
    line: line, view: view, rect: null,
    map: info.map, cache: info.cache, before: info.before,
    hasHeights: false
  }
}

// Given a prepared measurement object, measures the position of an
// actual character (or fetches it from the cache).
function measureCharPrepared(cm, prepared, ch, bias, varHeight) {
  if (prepared.before) { ch = -1; }
  var key = ch + (bias || ""), found;
  if (prepared.cache.hasOwnProperty(key)) {
    found = prepared.cache[key];
  } else {
    if (!prepared.rect)
      { prepared.rect = prepared.view.text.getBoundingClientRect(); }
    if (!prepared.hasHeights) {
      ensureLineHeights(cm, prepared.view, prepared.rect);
      prepared.hasHeights = true;
    }
    found = measureCharInner(cm, prepared, ch, bias);
    if (!found.bogus) { prepared.cache[key] = found; }
  }
  return {left: found.left, right: found.right,
          top: varHeight ? found.rtop : found.top,
          bottom: varHeight ? found.rbottom : found.bottom}
}

var nullRect = {left: 0, right: 0, top: 0, bottom: 0};

function nodeAndOffsetInLineMap(map$$1, ch, bias) {
  var node, start, end, collapse, mStart, mEnd;
  // First, search the line map for the text node corresponding to,
  // or closest to, the target character.
  for (var i = 0; i < map$$1.length; i += 3) {
    mStart = map$$1[i];
    mEnd = map$$1[i + 1];
    if (ch < mStart) {
      start = 0; end = 1;
      collapse = "left";
    } else if (ch < mEnd) {
      start = ch - mStart;
      end = start + 1;
    } else if (i == map$$1.length - 3 || ch == mEnd && map$$1[i + 3] > ch) {
      end = mEnd - mStart;
      start = end - 1;
      if (ch >= mEnd) { collapse = "right"; }
    }
    if (start != null) {
      node = map$$1[i + 2];
      if (mStart == mEnd && bias == (node.insertLeft ? "left" : "right"))
        { collapse = bias; }
      if (bias == "left" && start == 0)
        { while (i && map$$1[i - 2] == map$$1[i - 3] && map$$1[i - 1].insertLeft) {
          node = map$$1[(i -= 3) + 2];
          collapse = "left";
        } }
      if (bias == "right" && start == mEnd - mStart)
        { while (i < map$$1.length - 3 && map$$1[i + 3] == map$$1[i + 4] && !map$$1[i + 5].insertLeft) {
          node = map$$1[(i += 3) + 2];
          collapse = "right";
        } }
      break
    }
  }
  return {node: node, start: start, end: end, collapse: collapse, coverStart: mStart, coverEnd: mEnd}
}

function getUsefulRect(rects, bias) {
  var rect = nullRect;
  if (bias == "left") { for (var i = 0; i < rects.length; i++) {
    if ((rect = rects[i]).left != rect.right) { break }
  } } else { for (var i$1 = rects.length - 1; i$1 >= 0; i$1--) {
    if ((rect = rects[i$1]).left != rect.right) { break }
  } }
  return rect
}

function measureCharInner(cm, prepared, ch, bias) {
  var place = nodeAndOffsetInLineMap(prepared.map, ch, bias);
  var node = place.node, start = place.start, end = place.end, collapse = place.collapse;

  var rect;
  if (node.nodeType == 3) { // If it is a text node, use a range to retrieve the coordinates.
    for (var i$1 = 0; i$1 < 4; i$1++) { // Retry a maximum of 4 times when nonsense rectangles are returned
      while (start && isExtendingChar(prepared.line.text.charAt(place.coverStart + start))) { --start; }
      while (place.coverStart + end < place.coverEnd && isExtendingChar(prepared.line.text.charAt(place.coverStart + end))) { ++end; }
      if (ie && ie_version < 9 && start == 0 && end == place.coverEnd - place.coverStart)
        { rect = node.parentNode.getBoundingClientRect(); }
      else
        { rect = getUsefulRect(range(node, start, end).getClientRects(), bias); }
      if (rect.left || rect.right || start == 0) { break }
      end = start;
      start = start - 1;
      collapse = "right";
    }
    if (ie && ie_version < 11) { rect = maybeUpdateRectForZooming(cm.display.measure, rect); }
  } else { // If it is a widget, simply get the box for the whole widget.
    if (start > 0) { collapse = bias = "right"; }
    var rects;
    if (cm.options.lineWrapping && (rects = node.getClientRects()).length > 1)
      { rect = rects[bias == "right" ? rects.length - 1 : 0]; }
    else
      { rect = node.getBoundingClientRect(); }
  }
  if (ie && ie_version < 9 && !start && (!rect || !rect.left && !rect.right)) {
    var rSpan = node.parentNode.getClientRects()[0];
    if (rSpan)
      { rect = {left: rSpan.left, right: rSpan.left + charWidth(cm.display), top: rSpan.top, bottom: rSpan.bottom}; }
    else
      { rect = nullRect; }
  }

  var rtop = rect.top - prepared.rect.top, rbot = rect.bottom - prepared.rect.top;
  var mid = (rtop + rbot) / 2;
  var heights = prepared.view.measure.heights;
  var i = 0;
  for (; i < heights.length - 1; i++)
    { if (mid < heights[i]) { break } }
  var top = i ? heights[i - 1] : 0, bot = heights[i];
  var result = {left: (collapse == "right" ? rect.right : rect.left) - prepared.rect.left,
                right: (collapse == "left" ? rect.left : rect.right) - prepared.rect.left,
                top: top, bottom: bot};
  if (!rect.left && !rect.right) { result.bogus = true; }
  if (!cm.options.singleCursorHeightPerLine) { result.rtop = rtop; result.rbottom = rbot; }

  return result
}

// Work around problem with bounding client rects on ranges being
// returned incorrectly when zoomed on IE10 and below.
function maybeUpdateRectForZooming(measure, rect) {
  if (!window.screen || screen.logicalXDPI == null ||
      screen.logicalXDPI == screen.deviceXDPI || !hasBadZoomedRects(measure))
    { return rect }
  var scaleX = screen.logicalXDPI / screen.deviceXDPI;
  var scaleY = screen.logicalYDPI / screen.deviceYDPI;
  return {left: rect.left * scaleX, right: rect.right * scaleX,
          top: rect.top * scaleY, bottom: rect.bottom * scaleY}
}

function clearLineMeasurementCacheFor(lineView) {
  if (lineView.measure) {
    lineView.measure.cache = {};
    lineView.measure.heights = null;
    if (lineView.rest) { for (var i = 0; i < lineView.rest.length; i++)
      { lineView.measure.caches[i] = {}; } }
  }
}

function clearLineMeasurementCache(cm) {
  cm.display.externalMeasure = null;
  removeChildren(cm.display.lineMeasure);
  for (var i = 0; i < cm.display.view.length; i++)
    { clearLineMeasurementCacheFor(cm.display.view[i]); }
}

function clearCaches(cm) {
  clearLineMeasurementCache(cm);
  cm.display.cachedCharWidth = cm.display.cachedTextHeight = cm.display.cachedPaddingH = null;
  if (!cm.options.lineWrapping) { cm.display.maxLineChanged = true; }
  cm.display.lineNumChars = null;
}

function pageScrollX() {
  // Work around https://bugs.chromium.org/p/chromium/issues/detail?id=489206
  // which causes page_Offset and bounding client rects to use
  // different reference viewports and invalidate our calculations.
  if (chrome && android) { return -(document.body.getBoundingClientRect().left - parseInt(getComputedStyle(document.body).marginLeft)) }
  return window.pageXOffset || (document.documentElement || document.body).scrollLeft
}
function pageScrollY() {
  if (chrome && android) { return -(document.body.getBoundingClientRect().top - parseInt(getComputedStyle(document.body).marginTop)) }
  return window.pageYOffset || (document.documentElement || document.body).scrollTop
}

function widgetTopHeight(lineObj) {
  var height = 0;
  if (lineObj.widgets) { for (var i = 0; i < lineObj.widgets.length; ++i) { if (lineObj.widgets[i].above)
    { height += widgetHeight(lineObj.widgets[i]); } } }
  return height
}

// Converts a {top, bottom, left, right} box from line-local
// coordinates into another coordinate system. Context may be one of
// "line", "div" (display.lineDiv), "local"./null (editor), "window",
// or "page".
function intoCoordSystem(cm, lineObj, rect, context, includeWidgets) {
  if (!includeWidgets) {
    var height = widgetTopHeight(lineObj);
    rect.top += height; rect.bottom += height;
  }
  if (context == "line") { return rect }
  if (!context) { context = "local"; }
  var yOff = heightAtLine(lineObj);
  if (context == "local") { yOff += paddingTop(cm.display); }
  else { yOff -= cm.display.viewOffset; }
  if (context == "page" || context == "window") {
    var lOff = cm.display.lineSpace.getBoundingClientRect();
    yOff += lOff.top + (context == "window" ? 0 : pageScrollY());
    var xOff = lOff.left + (context == "window" ? 0 : pageScrollX());
    rect.left += xOff; rect.right += xOff;
  }
  rect.top += yOff; rect.bottom += yOff;
  return rect
}

// Coverts a box from "div" coords to another coordinate system.
// Context may be "window", "page", "div", or "local"./null.
function fromCoordSystem(cm, coords, context) {
  if (context == "div") { return coords }
  var left = coords.left, top = coords.top;
  // First move into "page" coordinate system
  if (context == "page") {
    left -= pageScrollX();
    top -= pageScrollY();
  } else if (context == "local" || !context) {
    var localBox = cm.display.sizer.getBoundingClientRect();
    left += localBox.left;
    top += localBox.top;
  }

  var lineSpaceBox = cm.display.lineSpace.getBoundingClientRect();
  return {left: left - lineSpaceBox.left, top: top - lineSpaceBox.top}
}

function charCoords(cm, pos, context, lineObj, bias) {
  if (!lineObj) { lineObj = getLine(cm.doc, pos.line); }
  return intoCoordSystem(cm, lineObj, measureChar(cm, lineObj, pos.ch, bias), context)
}

// Returns a box for a given cursor position, which may have an
// 'other' property containing the position of the secondary cursor
// on a bidi boundary.
// A cursor Pos(line, char, "before") is on the same visual line as `char - 1`
// and after `char - 1` in writing order of `char - 1`
// A cursor Pos(line, char, "after") is on the same visual line as `char`
// and before `char` in writing order of `char`
// Examples (upper-case letters are RTL, lower-case are LTR):
//     Pos(0, 1, ...)
//     before   after
// ab     a|b     a|b
// aB     a|B     aB|
// Ab     |Ab     A|b
// AB     B|A     B|A
// Every position after the last character on a line is considered to stick
// to the last character on the line.
function cursorCoords(cm, pos, context, lineObj, preparedMeasure, varHeight) {
  lineObj = lineObj || getLine(cm.doc, pos.line);
  if (!preparedMeasure) { preparedMeasure = prepareMeasureForLine(cm, lineObj); }
  function get(ch, right) {
    var m = measureCharPrepared(cm, preparedMeasure, ch, right ? "right" : "left", varHeight);
    if (right) { m.left = m.right; } else { m.right = m.left; }
    return intoCoordSystem(cm, lineObj, m, context)
  }
  var order = getOrder(lineObj, cm.doc.direction), ch = pos.ch, sticky = pos.sticky;
  if (ch >= lineObj.text.length) {
    ch = lineObj.text.length;
    sticky = "before";
  } else if (ch <= 0) {
    ch = 0;
    sticky = "after";
  }
  if (!order) { return get(sticky == "before" ? ch - 1 : ch, sticky == "before") }

  function getBidi(ch, partPos, invert) {
    var part = order[partPos], right = part.level == 1;
    return get(invert ? ch - 1 : ch, right != invert)
  }
  var partPos = getBidiPartAt(order, ch, sticky);
  var other = bidiOther;
  var val = getBidi(ch, partPos, sticky == "before");
  if (other != null) { val.other = getBidi(ch, other, sticky != "before"); }
  return val
}

// Used to cheaply estimate the coordinates for a position. Used for
// intermediate scroll updates.
function estimateCoords(cm, pos) {
  var left = 0;
  pos = clipPos(cm.doc, pos);
  if (!cm.options.lineWrapping) { left = charWidth(cm.display) * pos.ch; }
  var lineObj = getLine(cm.doc, pos.line);
  var top = heightAtLine(lineObj) + paddingTop(cm.display);
  return {left: left, right: left, top: top, bottom: top + lineObj.height}
}

// Positions returned by coordsChar contain some extra information.
// xRel is the relative x position of the input coordinates compared
// to the found position (so xRel > 0 means the coordinates are to
// the right of the character position, for example). When outside
// is true, that means the coordinates lie outside the line's
// vertical range.
function PosWithInfo(line, ch, sticky, outside, xRel) {
  var pos = Pos(line, ch, sticky);
  pos.xRel = xRel;
  if (outside) { pos.outside = true; }
  return pos
}

// Compute the character position closest to the given coordinates.
// Input must be lineSpace-local ("div" coordinate system).
function coordsChar(cm, x, y) {
  var doc = cm.doc;
  y += cm.display.viewOffset;
  if (y < 0) { return PosWithInfo(doc.first, 0, null, true, -1) }
  var lineN = lineAtHeight(doc, y), last = doc.first + doc.size - 1;
  if (lineN > last)
    { return PosWithInfo(doc.first + doc.size - 1, getLine(doc, last).text.length, null, true, 1) }
  if (x < 0) { x = 0; }

  var lineObj = getLine(doc, lineN);
  for (;;) {
    var found = coordsCharInner(cm, lineObj, lineN, x, y);
    var collapsed = collapsedSpanAround(lineObj, found.ch + (found.xRel > 0 ? 1 : 0));
    if (!collapsed) { return found }
    var rangeEnd = collapsed.find(1);
    if (rangeEnd.line == lineN) { return rangeEnd }
    lineObj = getLine(doc, lineN = rangeEnd.line);
  }
}

function wrappedLineExtent(cm, lineObj, preparedMeasure, y) {
  y -= widgetTopHeight(lineObj);
  var end = lineObj.text.length;
  var begin = findFirst(function (ch) { return measureCharPrepared(cm, preparedMeasure, ch - 1).bottom <= y; }, end, 0);
  end = findFirst(function (ch) { return measureCharPrepared(cm, preparedMeasure, ch).top > y; }, begin, end);
  return {begin: begin, end: end}
}

function wrappedLineExtentChar(cm, lineObj, preparedMeasure, target) {
  if (!preparedMeasure) { preparedMeasure = prepareMeasureForLine(cm, lineObj); }
  var targetTop = intoCoordSystem(cm, lineObj, measureCharPrepared(cm, preparedMeasure, target), "line").top;
  return wrappedLineExtent(cm, lineObj, preparedMeasure, targetTop)
}

// Returns true if the given side of a box is after the given
// coordinates, in top-to-bottom, left-to-right order.
function boxIsAfter(box, x, y, left) {
  return box.bottom <= y ? false : box.top > y ? true : (left ? box.left : box.right) > x
}

function coordsCharInner(cm, lineObj, lineNo$$1, x, y) {
  // Move y into line-local coordinate space
  y -= heightAtLine(lineObj);
  var preparedMeasure = prepareMeasureForLine(cm, lineObj);
  // When directly calling `measureCharPrepared`, we have to adjust
  // for the widgets at this line.
  var widgetHeight$$1 = widgetTopHeight(lineObj);
  var begin = 0, end = lineObj.text.length, ltr = true;

  var order = getOrder(lineObj, cm.doc.direction);
  // If the line isn't plain left-to-right text, first figure out
  // which bidi section the coordinates fall into.
  if (order) {
    var part = (cm.options.lineWrapping ? coordsBidiPartWrapped : coordsBidiPart)
                 (cm, lineObj, lineNo$$1, preparedMeasure, order, x, y);
    ltr = part.level != 1;
    // The awkward -1 offsets are needed because findFirst (called
    // on these below) will treat its first bound as inclusive,
    // second as exclusive, but we want to actually address the
    // characters in the part's range
    begin = ltr ? part.from : part.to - 1;
    end = ltr ? part.to : part.from - 1;
  }

  // A binary search to find the first character whose bounding box
  // starts after the coordinates. If we run across any whose box wrap
  // the coordinates, store that.
  var chAround = null, boxAround = null;
  var ch = findFirst(function (ch) {
    var box = measureCharPrepared(cm, preparedMeasure, ch);
    box.top += widgetHeight$$1; box.bottom += widgetHeight$$1;
    if (!boxIsAfter(box, x, y, false)) { return false }
    if (box.top <= y && box.left <= x) {
      chAround = ch;
      boxAround = box;
    }
    return true
  }, begin, end);

  var baseX, sticky, outside = false;
  // If a box around the coordinates was found, use that
  if (boxAround) {
    // Distinguish coordinates nearer to the left or right side of the box
    var atLeft = x - boxAround.left < boxAround.right - x, atStart = atLeft == ltr;
    ch = chAround + (atStart ? 0 : 1);
    sticky = atStart ? "after" : "before";
    baseX = atLeft ? boxAround.left : boxAround.right;
  } else {
    // (Adjust for extended bound, if necessary.)
    if (!ltr && (ch == end || ch == begin)) { ch++; }
    // To determine which side to associate with, get the box to the
    // left of the character and compare it's vertical position to the
    // coordinates
    sticky = ch == 0 ? "after" : ch == lineObj.text.length ? "before" :
      (measureCharPrepared(cm, preparedMeasure, ch - (ltr ? 1 : 0)).bottom + widgetHeight$$1 <= y) == ltr ?
      "after" : "before";
    // Now get accurate coordinates for this place, in order to get a
    // base X position
    var coords = cursorCoords(cm, Pos(lineNo$$1, ch, sticky), "line", lineObj, preparedMeasure);
    baseX = coords.left;
    outside = y < coords.top || y >= coords.bottom;
  }

  ch = skipExtendingChars(lineObj.text, ch, 1);
  return PosWithInfo(lineNo$$1, ch, sticky, outside, x - baseX)
}

function coordsBidiPart(cm, lineObj, lineNo$$1, preparedMeasure, order, x, y) {
  // Bidi parts are sorted left-to-right, and in a non-line-wrapping
  // situation, we can take this ordering to correspond to the visual
  // ordering. This finds the first part whose end is after the given
  // coordinates.
  var index = findFirst(function (i) {
    var part = order[i], ltr = part.level != 1;
    return boxIsAfter(cursorCoords(cm, Pos(lineNo$$1, ltr ? part.to : part.from, ltr ? "before" : "after"),
                                   "line", lineObj, preparedMeasure), x, y, true)
  }, 0, order.length - 1);
  var part = order[index];
  // If this isn't the first part, the part's start is also after
  // the coordinates, and the coordinates aren't on the same line as
  // that start, move one part back.
  if (index > 0) {
    var ltr = part.level != 1;
    var start = cursorCoords(cm, Pos(lineNo$$1, ltr ? part.from : part.to, ltr ? "after" : "before"),
                             "line", lineObj, preparedMeasure);
    if (boxIsAfter(start, x, y, true) && start.top > y)
      { part = order[index - 1]; }
  }
  return part
}

function coordsBidiPartWrapped(cm, lineObj, _lineNo, preparedMeasure, order, x, y) {
  // In a wrapped line, rtl text on wrapping boundaries can do things
  // that don't correspond to the ordering in our `order` array at
  // all, so a binary search doesn't work, and we want to return a
  // part that only spans one line so that the binary search in
  // coordsCharInner is safe. As such, we first find the extent of the
  // wrapped line, and then do a flat search in which we discard any
  // spans that aren't on the line.
  var ref = wrappedLineExtent(cm, lineObj, preparedMeasure, y);
  var begin = ref.begin;
  var end = ref.end;
  if (/\s/.test(lineObj.text.charAt(end - 1))) { end--; }
  var part = null, closestDist = null;
  for (var i = 0; i < order.length; i++) {
    var p = order[i];
    if (p.from >= end || p.to <= begin) { continue }
    var ltr = p.level != 1;
    var endX = measureCharPrepared(cm, preparedMeasure, ltr ? Math.min(end, p.to) - 1 : Math.max(begin, p.from)).right;
    // Weigh against spans ending before this, so that they are only
    // picked if nothing ends after
    var dist = endX < x ? x - endX + 1e9 : endX - x;
    if (!part || closestDist > dist) {
      part = p;
      closestDist = dist;
    }
  }
  if (!part) { part = order[order.length - 1]; }
  // Clip the part to the wrapped line.
  if (part.from < begin) { part = {from: begin, to: part.to, level: part.level}; }
  if (part.to > end) { part = {from: part.from, to: end, level: part.level}; }
  return part
}

var measureText;
// Compute the default text height.
function textHeight(display) {
  if (display.cachedTextHeight != null) { return display.cachedTextHeight }
  if (measureText == null) {
    measureText = elt("pre");
    // Measure a bunch of lines, for browsers that compute
    // fractional heights.
    for (var i = 0; i < 49; ++i) {
      measureText.appendChild(document.createTextNode("x"));
      measureText.appendChild(elt("br"));
    }
    measureText.appendChild(document.createTextNode("x"));
  }
  removeChildrenAndAdd(display.measure, measureText);
  var height = measureText.offsetHeight / 50;
  if (height > 3) { display.cachedTextHeight = height; }
  removeChildren(display.measure);
  return height || 1
}

// Compute the default character width.
function charWidth(display) {
  if (display.cachedCharWidth != null) { return display.cachedCharWidth }
  var anchor = elt("span", "xxxxxxxxxx");
  var pre = elt("pre", [anchor]);
  removeChildrenAndAdd(display.measure, pre);
  var rect = anchor.getBoundingClientRect(), width = (rect.right - rect.left) / 10;
  if (width > 2) { display.cachedCharWidth = width; }
  return width || 10
}

// Do a bulk-read of the DOM positions and sizes needed to draw the
// view, so that we don't interleave reading and writing to the DOM.
function getDimensions(cm) {
  var d = cm.display, left = {}, width = {};
  var gutterLeft = d.gutters.clientLeft;
  for (var n = d.gutters.firstChild, i = 0; n; n = n.nextSibling, ++i) {
    left[cm.options.gutters[i]] = n.offsetLeft + n.clientLeft + gutterLeft;
    width[cm.options.gutters[i]] = n.clientWidth;
  }
  return {fixedPos: compensateForHScroll(d),
          gutterTotalWidth: d.gutters.offsetWidth,
          gutterLeft: left,
          gutterWidth: width,
          wrapperWidth: d.wrapper.clientWidth}
}

// Computes display.scroller.scrollLeft + display.gutters.offsetWidth,
// but using getBoundingClientRect to get a sub-pixel-accurate
// result.
function compensateForHScroll(display) {
  return display.scroller.getBoundingClientRect().left - display.sizer.getBoundingClientRect().left
}

// Returns a function that estimates the height of a line, to use as
// first approximation until the line becomes visible (and is thus
// properly measurable).
function estimateHeight(cm) {
  var th = textHeight(cm.display), wrapping = cm.options.lineWrapping;
  var perLine = wrapping && Math.max(5, cm.display.scroller.clientWidth / charWidth(cm.display) - 3);
  return function (line) {
    if (lineIsHidden(cm.doc, line)) { return 0 }

    var widgetsHeight = 0;
    if (line.widgets) { for (var i = 0; i < line.widgets.length; i++) {
      if (line.widgets[i].height) { widgetsHeight += line.widgets[i].height; }
    } }

    if (wrapping)
      { return widgetsHeight + (Math.ceil(line.text.length / perLine) || 1) * th }
    else
      { return widgetsHeight + th }
  }
}

function estimateLineHeights(cm) {
  var doc = cm.doc, est = estimateHeight(cm);
  doc.iter(function (line) {
    var estHeight = est(line);
    if (estHeight != line.height) { updateLineHeight(line, estHeight); }
  });
}

// Given a mouse event, find the corresponding position. If liberal
// is false, it checks whether a gutter or scrollbar was clicked,
// and returns null if it was. forRect is used by rectangular
// selections, and tries to estimate a character position even for
// coordinates beyond the right of the text.
function posFromMouse(cm, e, liberal, forRect) {
  var display = cm.display;
  if (!liberal && e_target(e).getAttribute("cm-not-content") == "true") { return null }

  var x, y, space = display.lineSpace.getBoundingClientRect();
  // Fails unpredictably on IE[67] when mouse is dragged around quickly.
  try { x = e.clientX - space.left; y = e.clientY - space.top; }
  catch (e) { return null }
  var coords = coordsChar(cm, x, y), line;
  if (forRect && coords.xRel == 1 && (line = getLine(cm.doc, coords.line).text).length == coords.ch) {
    var colDiff = countColumn(line, line.length, cm.options.tabSize) - line.length;
    coords = Pos(coords.line, Math.max(0, Math.round((x - paddingH(cm.display).left) / charWidth(cm.display)) - colDiff));
  }
  return coords
}

// Find the view element corresponding to a given line. Return null
// when the line isn't visible.
function findViewIndex(cm, n) {
  if (n >= cm.display.viewTo) { return null }
  n -= cm.display.viewFrom;
  if (n < 0) { return null }
  var view = cm.display.view;
  for (var i = 0; i < view.length; i++) {
    n -= view[i].size;
    if (n < 0) { return i }
  }
}

function updateSelection(cm) {
  cm.display.input.showSelection(cm.display.input.prepareSelection());
}

function prepareSelection(cm, primary) {
  if ( primary === void 0 ) primary = true;

  var doc = cm.doc, result = {};
  var curFragment = result.cursors = document.createDocumentFragment();
  var selFragment = result.selection = document.createDocumentFragment();

  for (var i = 0; i < doc.sel.ranges.length; i++) {
    if (!primary && i == doc.sel.primIndex) { continue }
    var range$$1 = doc.sel.ranges[i];
    if (range$$1.from().line >= cm.display.viewTo || range$$1.to().line < cm.display.viewFrom) { continue }
    var collapsed = range$$1.empty();
    if (collapsed || cm.options.showCursorWhenSelecting)
      { drawSelectionCursor(cm, range$$1.head, curFragment); }
    if (!collapsed)
      { drawSelectionRange(cm, range$$1, selFragment); }
  }
  return result
}

// Draws a cursor for the given range
function drawSelectionCursor(cm, head, output) {
  var pos = cursorCoords(cm, head, "div", null, null, !cm.options.singleCursorHeightPerLine);

  var cursor = output.appendChild(elt("div", "\u00a0", "CodeMirror-cursor"));
  cursor.style.left = pos.left + "px";
  cursor.style.top = pos.top + "px";
  cursor.style.height = Math.max(0, pos.bottom - pos.top) * cm.options.cursorHeight + "px";

  if (pos.other) {
    // Secondary cursor, shown when on a 'jump' in bi-directional text
    var otherCursor = output.appendChild(elt("div", "\u00a0", "CodeMirror-cursor CodeMirror-secondarycursor"));
    otherCursor.style.display = "";
    otherCursor.style.left = pos.other.left + "px";
    otherCursor.style.top = pos.other.top + "px";
    otherCursor.style.height = (pos.other.bottom - pos.other.top) * .85 + "px";
  }
}

function cmpCoords(a, b) { return a.top - b.top || a.left - b.left }

// Draws the given range as a highlighted selection
function drawSelectionRange(cm, range$$1, output) {
  var display = cm.display, doc = cm.doc;
  var fragment = document.createDocumentFragment();
  var padding = paddingH(cm.display), leftSide = padding.left;
  var rightSide = Math.max(display.sizerWidth, displayWidth(cm) - display.sizer.offsetLeft) - padding.right;
  var docLTR = doc.direction == "ltr";

  function add(left, top, width, bottom) {
    if (top < 0) { top = 0; }
    top = Math.round(top);
    bottom = Math.round(bottom);
    fragment.appendChild(elt("div", null, "CodeMirror-selected", ("position: absolute; left: " + left + "px;\n                             top: " + top + "px; width: " + (width == null ? rightSide - left : width) + "px;\n                             height: " + (bottom - top) + "px")));
  }

  function drawForLine(line, fromArg, toArg) {
    var lineObj = getLine(doc, line);
    var lineLen = lineObj.text.length;
    var start, end;
    function coords(ch, bias) {
      return charCoords(cm, Pos(line, ch), "div", lineObj, bias)
    }

    function wrapX(pos, dir, side) {
      var extent = wrappedLineExtentChar(cm, lineObj, null, pos);
      var prop = (dir == "ltr") == (side == "after") ? "left" : "right";
      var ch = side == "after" ? extent.begin : extent.end - (/\s/.test(lineObj.text.charAt(extent.end - 1)) ? 2 : 1);
      return coords(ch, prop)[prop]
    }

    var order = getOrder(lineObj, doc.direction);
    iterateBidiSections(order, fromArg || 0, toArg == null ? lineLen : toArg, function (from, to, dir, i) {
      var ltr = dir == "ltr";
      var fromPos = coords(from, ltr ? "left" : "right");
      var toPos = coords(to - 1, ltr ? "right" : "left");

      var openStart = fromArg == null && from == 0, openEnd = toArg == null && to == lineLen;
      var first = i == 0, last = !order || i == order.length - 1;
      if (toPos.top - fromPos.top <= 3) { // Single line
        var openLeft = (docLTR ? openStart : openEnd) && first;
        var openRight = (docLTR ? openEnd : openStart) && last;
        var left = openLeft ? leftSide : (ltr ? fromPos : toPos).left;
        var right = openRight ? rightSide : (ltr ? toPos : fromPos).right;
        add(left, fromPos.top, right - left, fromPos.bottom);
      } else { // Multiple lines
        var topLeft, topRight, botLeft, botRight;
        if (ltr) {
          topLeft = docLTR && openStart && first ? leftSide : fromPos.left;
          topRight = docLTR ? rightSide : wrapX(from, dir, "before");
          botLeft = docLTR ? leftSide : wrapX(to, dir, "after");
          botRight = docLTR && openEnd && last ? rightSide : toPos.right;
        } else {
          topLeft = !docLTR ? leftSide : wrapX(from, dir, "before");
          topRight = !docLTR && openStart && first ? rightSide : fromPos.right;
          botLeft = !docLTR && openEnd && last ? leftSide : toPos.left;
          botRight = !docLTR ? rightSide : wrapX(to, dir, "after");
        }
        add(topLeft, fromPos.top, topRight - topLeft, fromPos.bottom);
        if (fromPos.bottom < toPos.top) { add(leftSide, fromPos.bottom, null, toPos.top); }
        add(botLeft, toPos.top, botRight - botLeft, toPos.bottom);
      }

      if (!start || cmpCoords(fromPos, start) < 0) { start = fromPos; }
      if (cmpCoords(toPos, start) < 0) { start = toPos; }
      if (!end || cmpCoords(fromPos, end) < 0) { end = fromPos; }
      if (cmpCoords(toPos, end) < 0) { end = toPos; }
    });
    return {start: start, end: end}
  }

  var sFrom = range$$1.from(), sTo = range$$1.to();
  if (sFrom.line == sTo.line) {
    drawForLine(sFrom.line, sFrom.ch, sTo.ch);
  } else {
    var fromLine = getLine(doc, sFrom.line), toLine = getLine(doc, sTo.line);
    var singleVLine = visualLine(fromLine) == visualLine(toLine);
    var leftEnd = drawForLine(sFrom.line, sFrom.ch, singleVLine ? fromLine.text.length + 1 : null).end;
    var rightStart = drawForLine(sTo.line, singleVLine ? 0 : null, sTo.ch).start;
    if (singleVLine) {
      if (leftEnd.top < rightStart.top - 2) {
        add(leftEnd.right, leftEnd.top, null, leftEnd.bottom);
        add(leftSide, rightStart.top, rightStart.left, rightStart.bottom);
      } else {
        add(leftEnd.right, leftEnd.top, rightStart.left - leftEnd.right, leftEnd.bottom);
      }
    }
    if (leftEnd.bottom < rightStart.top)
      { add(leftSide, leftEnd.bottom, null, rightStart.top); }
  }

  output.appendChild(fragment);
}

// Cursor-blinking
function restartBlink(cm) {
  if (!cm.state.focused) { return }
  var display = cm.display;
  clearInterval(display.blinker);
  var on = true;
  display.cursorDiv.style.visibility = "";
  if (cm.options.cursorBlinkRate > 0)
    { display.blinker = setInterval(function () { return display.cursorDiv.style.visibility = (on = !on) ? "" : "hidden"; },
      cm.options.cursorBlinkRate); }
  else if (cm.options.cursorBlinkRate < 0)
    { display.cursorDiv.style.visibility = "hidden"; }
}

function ensureFocus(cm) {
  if (!cm.state.focused) { cm.display.input.focus(); onFocus(cm); }
}

function delayBlurEvent(cm) {
  cm.state.delayingBlurEvent = true;
  setTimeout(function () { if (cm.state.delayingBlurEvent) {
    cm.state.delayingBlurEvent = false;
    onBlur(cm);
  } }, 100);
}

function onFocus(cm, e) {
  if (cm.state.delayingBlurEvent) { cm.state.delayingBlurEvent = false; }

  if (cm.options.readOnly == "nocursor") { return }
  if (!cm.state.focused) {
    signal(cm, "focus", cm, e);
    cm.state.focused = true;
    addClass(cm.display.wrapper, "CodeMirror-focused");
    // This test prevents this from firing when a context
    // menu is closed (since the input reset would kill the
    // select-all detection hack)
    if (!cm.curOp && cm.display.selForContextMenu != cm.doc.sel) {
      cm.display.input.reset();
      if (webkit) { setTimeout(function () { return cm.display.input.reset(true); }, 20); } // Issue #1730
    }
    cm.display.input.receivedFocus();
  }
  restartBlink(cm);
}
function onBlur(cm, e) {
  if (cm.state.delayingBlurEvent) { return }

  if (cm.state.focused) {
    signal(cm, "blur", cm, e);
    cm.state.focused = false;
    rmClass(cm.display.wrapper, "CodeMirror-focused");
  }
  clearInterval(cm.display.blinker);
  setTimeout(function () { if (!cm.state.focused) { cm.display.shift = false; } }, 150);
}

// Read the actual heights of the rendered lines, and update their
// stored heights to match.
function updateHeightsInViewport(cm) {
  var display = cm.display;
  var prevBottom = display.lineDiv.offsetTop;
  for (var i = 0; i < display.view.length; i++) {
    var cur = display.view[i], height = (void 0);
    if (cur.hidden) { continue }
    if (ie && ie_version < 8) {
      var bot = cur.node.offsetTop + cur.node.offsetHeight;
      height = bot - prevBottom;
      prevBottom = bot;
    } else {
      var box = cur.node.getBoundingClientRect();
      height = box.bottom - box.top;
    }
    var diff = cur.line.height - height;
    if (height < 2) { height = textHeight(display); }
    if (diff > .005 || diff < -.005) {
      updateLineHeight(cur.line, height);
      updateWidgetHeight(cur.line);
      if (cur.rest) { for (var j = 0; j < cur.rest.length; j++)
        { updateWidgetHeight(cur.rest[j]); } }
    }
  }
}

// Read and store the height of line widgets associated with the
// given line.
function updateWidgetHeight(line) {
  if (line.widgets) { for (var i = 0; i < line.widgets.length; ++i) {
    var w = line.widgets[i], parent = w.node.parentNode;
    if (parent) { w.height = parent.offsetHeight; }
  } }
}

// Compute the lines that are visible in a given viewport (defaults
// the the current scroll position). viewport may contain top,
// height, and ensure (see op.scrollToPos) properties.
function visibleLines(display, doc, viewport) {
  var top = viewport && viewport.top != null ? Math.max(0, viewport.top) : display.scroller.scrollTop;
  top = Math.floor(top - paddingTop(display));
  var bottom = viewport && viewport.bottom != null ? viewport.bottom : top + display.wrapper.clientHeight;

  var from = lineAtHeight(doc, top), to = lineAtHeight(doc, bottom);
  // Ensure is a {from: {line, ch}, to: {line, ch}} object, and
  // forces those lines into the viewport (if possible).
  if (viewport && viewport.ensure) {
    var ensureFrom = viewport.ensure.from.line, ensureTo = viewport.ensure.to.line;
    if (ensureFrom < from) {
      from = ensureFrom;
      to = lineAtHeight(doc, heightAtLine(getLine(doc, ensureFrom)) + display.wrapper.clientHeight);
    } else if (Math.min(ensureTo, doc.lastLine()) >= to) {
      from = lineAtHeight(doc, heightAtLine(getLine(doc, ensureTo)) - display.wrapper.clientHeight);
      to = ensureTo;
    }
  }
  return {from: from, to: Math.max(to, from + 1)}
}

// Re-align line numbers and gutter marks to compensate for
// horizontal scrolling.
function alignHorizontally(cm) {
  var display = cm.display, view = display.view;
  if (!display.alignWidgets && (!display.gutters.firstChild || !cm.options.fixedGutter)) { return }
  var comp = compensateForHScroll(display) - display.scroller.scrollLeft + cm.doc.scrollLeft;
  var gutterW = display.gutters.offsetWidth, left = comp + "px";
  for (var i = 0; i < view.length; i++) { if (!view[i].hidden) {
    if (cm.options.fixedGutter) {
      if (view[i].gutter)
        { view[i].gutter.style.left = left; }
      if (view[i].gutterBackground)
        { view[i].gutterBackground.style.left = left; }
    }
    var align = view[i].alignable;
    if (align) { for (var j = 0; j < align.length; j++)
      { align[j].style.left = left; } }
  } }
  if (cm.options.fixedGutter)
    { display.gutters.style.left = (comp + gutterW) + "px"; }
}

// Used to ensure that the line number gutter is still the right
// size for the current document size. Returns true when an update
// is needed.
function maybeUpdateLineNumberWidth(cm) {
  if (!cm.options.lineNumbers) { return false }
  var doc = cm.doc, last = lineNumberFor(cm.options, doc.first + doc.size - 1), display = cm.display;
  if (last.length != display.lineNumChars) {
    var test = display.measure.appendChild(elt("div", [elt("div", last)],
                                               "CodeMirror-linenumber CodeMirror-gutter-elt"));
    var innerW = test.firstChild.offsetWidth, padding = test.offsetWidth - innerW;
    display.lineGutter.style.width = "";
    display.lineNumInnerWidth = Math.max(innerW, display.lineGutter.offsetWidth - padding) + 1;
    display.lineNumWidth = display.lineNumInnerWidth + padding;
    display.lineNumChars = display.lineNumInnerWidth ? last.length : -1;
    display.lineGutter.style.width = display.lineNumWidth + "px";
    updateGutterSpace(cm);
    return true
  }
  return false
}

// SCROLLING THINGS INTO VIEW

// If an editor sits on the top or bottom of the window, partially
// scrolled out of view, this ensures that the cursor is visible.
function maybeScrollWindow(cm, rect) {
  if (signalDOMEvent(cm, "scrollCursorIntoView")) { return }

  var display = cm.display, box = display.sizer.getBoundingClientRect(), doScroll = null;
  if (rect.top + box.top < 0) { doScroll = true; }
  else if (rect.bottom + box.top > (window.innerHeight || document.documentElement.clientHeight)) { doScroll = false; }
  if (doScroll != null && !phantom) {
    var scrollNode = elt("div", "\u200b", null, ("position: absolute;\n                         top: " + (rect.top - display.viewOffset - paddingTop(cm.display)) + "px;\n                         height: " + (rect.bottom - rect.top + scrollGap(cm) + display.barHeight) + "px;\n                         left: " + (rect.left) + "px; width: " + (Math.max(2, rect.right - rect.left)) + "px;"));
    cm.display.lineSpace.appendChild(scrollNode);
    scrollNode.scrollIntoView(doScroll);
    cm.display.lineSpace.removeChild(scrollNode);
  }
}

// Scroll a given position into view (immediately), verifying that
// it actually became visible (as line heights are accurately
// measured, the position of something may 'drift' during drawing).
function scrollPosIntoView(cm, pos, end, margin) {
  if (margin == null) { margin = 0; }
  var rect;
  if (!cm.options.lineWrapping && pos == end) {
    // Set pos and end to the cursor positions around the character pos sticks to
    // If pos.sticky == "before", that is around pos.ch - 1, otherwise around pos.ch
    // If pos == Pos(_, 0, "before"), pos and end are unchanged
    pos = pos.ch ? Pos(pos.line, pos.sticky == "before" ? pos.ch - 1 : pos.ch, "after") : pos;
    end = pos.sticky == "before" ? Pos(pos.line, pos.ch + 1, "before") : pos;
  }
  for (var limit = 0; limit < 5; limit++) {
    var changed = false;
    var coords = cursorCoords(cm, pos);
    var endCoords = !end || end == pos ? coords : cursorCoords(cm, end);
    rect = {left: Math.min(coords.left, endCoords.left),
            top: Math.min(coords.top, endCoords.top) - margin,
            right: Math.max(coords.left, endCoords.left),
            bottom: Math.max(coords.bottom, endCoords.bottom) + margin};
    var scrollPos = calculateScrollPos(cm, rect);
    var startTop = cm.doc.scrollTop, startLeft = cm.doc.scrollLeft;
    if (scrollPos.scrollTop != null) {
      updateScrollTop(cm, scrollPos.scrollTop);
      if (Math.abs(cm.doc.scrollTop - startTop) > 1) { changed = true; }
    }
    if (scrollPos.scrollLeft != null) {
      setScrollLeft(cm, scrollPos.scrollLeft);
      if (Math.abs(cm.doc.scrollLeft - startLeft) > 1) { changed = true; }
    }
    if (!changed) { break }
  }
  return rect
}

// Scroll a given set of coordinates into view (immediately).
function scrollIntoView(cm, rect) {
  var scrollPos = calculateScrollPos(cm, rect);
  if (scrollPos.scrollTop != null) { updateScrollTop(cm, scrollPos.scrollTop); }
  if (scrollPos.scrollLeft != null) { setScrollLeft(cm, scrollPos.scrollLeft); }
}

// Calculate a new scroll position needed to scroll the given
// rectangle into view. Returns an object with scrollTop and
// scrollLeft properties. When these are undefined, the
// vertical/horizontal position does not need to be adjusted.
function calculateScrollPos(cm, rect) {
  var display = cm.display, snapMargin = textHeight(cm.display);
  if (rect.top < 0) { rect.top = 0; }
  var screentop = cm.curOp && cm.curOp.scrollTop != null ? cm.curOp.scrollTop : display.scroller.scrollTop;
  var screen = displayHeight(cm), result = {};
  if (rect.bottom - rect.top > screen) { rect.bottom = rect.top + screen; }
  var docBottom = cm.doc.height + paddingVert(display);
  var atTop = rect.top < snapMargin, atBottom = rect.bottom > docBottom - snapMargin;
  if (rect.top < screentop) {
    result.scrollTop = atTop ? 0 : rect.top;
  } else if (rect.bottom > screentop + screen) {
    var newTop = Math.min(rect.top, (atBottom ? docBottom : rect.bottom) - screen);
    if (newTop != screentop) { result.scrollTop = newTop; }
  }

  var screenleft = cm.curOp && cm.curOp.scrollLeft != null ? cm.curOp.scrollLeft : display.scroller.scrollLeft;
  var screenw = displayWidth(cm) - (cm.options.fixedGutter ? display.gutters.offsetWidth : 0);
  var tooWide = rect.right - rect.left > screenw;
  if (tooWide) { rect.right = rect.left + screenw; }
  if (rect.left < 10)
    { result.scrollLeft = 0; }
  else if (rect.left < screenleft)
    { result.scrollLeft = Math.max(0, rect.left - (tooWide ? 0 : 10)); }
  else if (rect.right > screenw + screenleft - 3)
    { result.scrollLeft = rect.right + (tooWide ? 0 : 10) - screenw; }
  return result
}

// Store a relative adjustment to the scroll position in the current
// operation (to be applied when the operation finishes).
function addToScrollTop(cm, top) {
  if (top == null) { return }
  resolveScrollToPos(cm);
  cm.curOp.scrollTop = (cm.curOp.scrollTop == null ? cm.doc.scrollTop : cm.curOp.scrollTop) + top;
}

// Make sure that at the end of the operation the current cursor is
// shown.
function ensureCursorVisible(cm) {
  resolveScrollToPos(cm);
  var cur = cm.getCursor();
  cm.curOp.scrollToPos = {from: cur, to: cur, margin: cm.options.cursorScrollMargin};
}

function scrollToCoords(cm, x, y) {
  if (x != null || y != null) { resolveScrollToPos(cm); }
  if (x != null) { cm.curOp.scrollLeft = x; }
  if (y != null) { cm.curOp.scrollTop = y; }
}

function scrollToRange(cm, range$$1) {
  resolveScrollToPos(cm);
  cm.curOp.scrollToPos = range$$1;
}

// When an operation has its scrollToPos property set, and another
// scroll action is applied before the end of the operation, this
// 'simulates' scrolling that position into view in a cheap way, so
// that the effect of intermediate scroll commands is not ignored.
function resolveScrollToPos(cm) {
  var range$$1 = cm.curOp.scrollToPos;
  if (range$$1) {
    cm.curOp.scrollToPos = null;
    var from = estimateCoords(cm, range$$1.from), to = estimateCoords(cm, range$$1.to);
    scrollToCoordsRange(cm, from, to, range$$1.margin);
  }
}

function scrollToCoordsRange(cm, from, to, margin) {
  var sPos = calculateScrollPos(cm, {
    left: Math.min(from.left, to.left),
    top: Math.min(from.top, to.top) - margin,
    right: Math.max(from.right, to.right),
    bottom: Math.max(from.bottom, to.bottom) + margin
  });
  scrollToCoords(cm, sPos.scrollLeft, sPos.scrollTop);
}

// Sync the scrollable area and scrollbars, ensure the viewport
// covers the visible area.
function updateScrollTop(cm, val) {
  if (Math.abs(cm.doc.scrollTop - val) < 2) { return }
  if (!gecko) { updateDisplaySimple(cm, {top: val}); }
  setScrollTop(cm, val, true);
  if (gecko) { updateDisplaySimple(cm); }
  startWorker(cm, 100);
}

function setScrollTop(cm, val, forceScroll) {
  val = Math.min(cm.display.scroller.scrollHeight - cm.display.scroller.clientHeight, val);
  if (cm.display.scroller.scrollTop == val && !forceScroll) { return }
  cm.doc.scrollTop = val;
  cm.display.scrollbars.setScrollTop(val);
  if (cm.display.scroller.scrollTop != val) { cm.display.scroller.scrollTop = val; }
}

// Sync scroller and scrollbar, ensure the gutter elements are
// aligned.
function setScrollLeft(cm, val, isScroller, forceScroll) {
  val = Math.min(val, cm.display.scroller.scrollWidth - cm.display.scroller.clientWidth);
  if ((isScroller ? val == cm.doc.scrollLeft : Math.abs(cm.doc.scrollLeft - val) < 2) && !forceScroll) { return }
  cm.doc.scrollLeft = val;
  alignHorizontally(cm);
  if (cm.display.scroller.scrollLeft != val) { cm.display.scroller.scrollLeft = val; }
  cm.display.scrollbars.setScrollLeft(val);
}

// SCROLLBARS

// Prepare DOM reads needed to update the scrollbars. Done in one
// shot to minimize update/measure roundtrips.
function measureForScrollbars(cm) {
  var d = cm.display, gutterW = d.gutters.offsetWidth;
  var docH = Math.round(cm.doc.height + paddingVert(cm.display));
  return {
    clientHeight: d.scroller.clientHeight,
    viewHeight: d.wrapper.clientHeight,
    scrollWidth: d.scroller.scrollWidth, clientWidth: d.scroller.clientWidth,
    viewWidth: d.wrapper.clientWidth,
    barLeft: cm.options.fixedGutter ? gutterW : 0,
    docHeight: docH,
    scrollHeight: docH + scrollGap(cm) + d.barHeight,
    nativeBarWidth: d.nativeBarWidth,
    gutterWidth: gutterW
  }
}

var NativeScrollbars = function(place, scroll, cm) {
  this.cm = cm;
  var vert = this.vert = elt("div", [elt("div", null, null, "min-width: 1px")], "CodeMirror-vscrollbar");
  var horiz = this.horiz = elt("div", [elt("div", null, null, "height: 100%; min-height: 1px")], "CodeMirror-hscrollbar");
  vert.tabIndex = horiz.tabIndex = -1;
  place(vert); place(horiz);

  on(vert, "scroll", function () {
    if (vert.clientHeight) { scroll(vert.scrollTop, "vertical"); }
  });
  on(horiz, "scroll", function () {
    if (horiz.clientWidth) { scroll(horiz.scrollLeft, "horizontal"); }
  });

  this.checkedZeroWidth = false;
  // Need to set a minimum width to see the scrollbar on IE7 (but must not set it on IE8).
  if (ie && ie_version < 8) { this.horiz.style.minHeight = this.vert.style.minWidth = "18px"; }
};

NativeScrollbars.prototype.update = function (measure) {
  var needsH = measure.scrollWidth > measure.clientWidth + 1;
  var needsV = measure.scrollHeight > measure.clientHeight + 1;
  var sWidth = measure.nativeBarWidth;

  if (needsV) {
    this.vert.style.display = "block";
    this.vert.style.bottom = needsH ? sWidth + "px" : "0";
    var totalHeight = measure.viewHeight - (needsH ? sWidth : 0);
    // A bug in IE8 can cause this value to be negative, so guard it.
    this.vert.firstChild.style.height =
      Math.max(0, measure.scrollHeight - measure.clientHeight + totalHeight) + "px";
  } else {
    this.vert.style.display = "";
    this.vert.firstChild.style.height = "0";
  }

  if (needsH) {
    this.horiz.style.display = "block";
    this.horiz.style.right = needsV ? sWidth + "px" : "0";
    this.horiz.style.left = measure.barLeft + "px";
    var totalWidth = measure.viewWidth - measure.barLeft - (needsV ? sWidth : 0);
    this.horiz.firstChild.style.width =
      Math.max(0, measure.scrollWidth - measure.clientWidth + totalWidth) + "px";
  } else {
    this.horiz.style.display = "";
    this.horiz.firstChild.style.width = "0";
  }

  if (!this.checkedZeroWidth && measure.clientHeight > 0) {
    if (sWidth == 0) { this.zeroWidthHack(); }
    this.checkedZeroWidth = true;
  }

  return {right: needsV ? sWidth : 0, bottom: needsH ? sWidth : 0}
};

NativeScrollbars.prototype.setScrollLeft = function (pos) {
  if (this.horiz.scrollLeft != pos) { this.horiz.scrollLeft = pos; }
  if (this.disableHoriz) { this.enableZeroWidthBar(this.horiz, this.disableHoriz, "horiz"); }
};

NativeScrollbars.prototype.setScrollTop = function (pos) {
  if (this.vert.scrollTop != pos) { this.vert.scrollTop = pos; }
  if (this.disableVert) { this.enableZeroWidthBar(this.vert, this.disableVert, "vert"); }
};

NativeScrollbars.prototype.zeroWidthHack = function () {
  var w = mac && !mac_geMountainLion ? "12px" : "18px";
  this.horiz.style.height = this.vert.style.width = w;
  this.horiz.style.pointerEvents = this.vert.style.pointerEvents = "none";
  this.disableHoriz = new Delayed;
  this.disableVert = new Delayed;
};

NativeScrollbars.prototype.enableZeroWidthBar = function (bar, delay, type) {
  bar.style.pointerEvents = "auto";
  function maybeDisable() {
    // To find out whether the scrollbar is still visible, we
    // check whether the element under the pixel in the bottom
    // right corner of the scrollbar box is the scrollbar box
    // itself (when the bar is still visible) or its filler child
    // (when the bar is hidden). If it is still visible, we keep
    // it enabled, if it's hidden, we disable pointer events.
    var box = bar.getBoundingClientRect();
    var elt$$1 = type == "vert" ? document.elementFromPoint(box.right - 1, (box.top + box.bottom) / 2)
        : document.elementFromPoint((box.right + box.left) / 2, box.bottom - 1);
    if (elt$$1 != bar) { bar.style.pointerEvents = "none"; }
    else { delay.set(1000, maybeDisable); }
  }
  delay.set(1000, maybeDisable);
};

NativeScrollbars.prototype.clear = function () {
  var parent = this.horiz.parentNode;
  parent.removeChild(this.horiz);
  parent.removeChild(this.vert);
};

var NullScrollbars = function () {};

NullScrollbars.prototype.update = function () { return {bottom: 0, right: 0} };
NullScrollbars.prototype.setScrollLeft = function () {};
NullScrollbars.prototype.setScrollTop = function () {};
NullScrollbars.prototype.clear = function () {};

function updateScrollbars(cm, measure) {
  if (!measure) { measure = measureForScrollbars(cm); }
  var startWidth = cm.display.barWidth, startHeight = cm.display.barHeight;
  updateScrollbarsInner(cm, measure);
  for (var i = 0; i < 4 && startWidth != cm.display.barWidth || startHeight != cm.display.barHeight; i++) {
    if (startWidth != cm.display.barWidth && cm.options.lineWrapping)
      { updateHeightsInViewport(cm); }
    updateScrollbarsInner(cm, measureForScrollbars(cm));
    startWidth = cm.display.barWidth; startHeight = cm.display.barHeight;
  }
}

// Re-synchronize the fake scrollbars with the actual size of the
// content.
function updateScrollbarsInner(cm, measure) {
  var d = cm.display;
  var sizes = d.scrollbars.update(measure);

  d.sizer.style.paddingRight = (d.barWidth = sizes.right) + "px";
  d.sizer.style.paddingBottom = (d.barHeight = sizes.bottom) + "px";
  d.heightForcer.style.borderBottom = sizes.bottom + "px solid transparent";

  if (sizes.right && sizes.bottom) {
    d.scrollbarFiller.style.display = "block";
    d.scrollbarFiller.style.height = sizes.bottom + "px";
    d.scrollbarFiller.style.width = sizes.right + "px";
  } else { d.scrollbarFiller.style.display = ""; }
  if (sizes.bottom && cm.options.coverGutterNextToScrollbar && cm.options.fixedGutter) {
    d.gutterFiller.style.display = "block";
    d.gutterFiller.style.height = sizes.bottom + "px";
    d.gutterFiller.style.width = measure.gutterWidth + "px";
  } else { d.gutterFiller.style.display = ""; }
}

var scrollbarModel = {"native": NativeScrollbars, "null": NullScrollbars};

function initScrollbars(cm) {
  if (cm.display.scrollbars) {
    cm.display.scrollbars.clear();
    if (cm.display.scrollbars.addClass)
      { rmClass(cm.display.wrapper, cm.display.scrollbars.addClass); }
  }

  cm.display.scrollbars = new scrollbarModel[cm.options.scrollbarStyle](function (node) {
    cm.display.wrapper.insertBefore(node, cm.display.scrollbarFiller);
    // Prevent clicks in the scrollbars from killing focus
    on(node, "mousedown", function () {
      if (cm.state.focused) { setTimeout(function () { return cm.display.input.focus(); }, 0); }
    });
    node.setAttribute("cm-not-content", "true");
  }, function (pos, axis) {
    if (axis == "horizontal") { setScrollLeft(cm, pos); }
    else { updateScrollTop(cm, pos); }
  }, cm);
  if (cm.display.scrollbars.addClass)
    { addClass(cm.display.wrapper, cm.display.scrollbars.addClass); }
}

// Operations are used to wrap a series of changes to the editor
// state in such a way that each change won't have to update the
// cursor and display (which would be awkward, slow, and
// error-prone). Instead, display updates are batched and then all
// combined and executed at once.

var nextOpId = 0;
// Start a new operation.
function startOperation(cm) {
  cm.curOp = {
    cm: cm,
    viewChanged: false,      // Flag that indicates that lines might need to be redrawn
    startHeight: cm.doc.height, // Used to detect need to update scrollbar
    forceUpdate: false,      // Used to force a redraw
    updateInput: null,       // Whether to reset the input textarea
    typing: false,           // Whether this reset should be careful to leave existing text (for compositing)
    changeObjs: null,        // Accumulated changes, for firing change events
    cursorActivityHandlers: null, // Set of handlers to fire cursorActivity on
    cursorActivityCalled: 0, // Tracks which cursorActivity handlers have been called already
    selectionChanged: false, // Whether the selection needs to be redrawn
    updateMaxLine: false,    // Set when the widest line needs to be determined anew
    scrollLeft: null, scrollTop: null, // Intermediate scroll position, not pushed to DOM yet
    scrollToPos: null,       // Used to scroll to a specific position
    focus: false,
    id: ++nextOpId           // Unique ID
  };
  pushOperation(cm.curOp);
}

// Finish an operation, updating the display and signalling delayed events
function endOperation(cm) {
  var op = cm.curOp;
  finishOperation(op, function (group) {
    for (var i = 0; i < group.ops.length; i++)
      { group.ops[i].cm.curOp = null; }
    endOperations(group);
  });
}

// The DOM updates done when an operation finishes are batched so
// that the minimum number of relayouts are required.
function endOperations(group) {
  var ops = group.ops;
  for (var i = 0; i < ops.length; i++) // Read DOM
    { endOperation_R1(ops[i]); }
  for (var i$1 = 0; i$1 < ops.length; i$1++) // Write DOM (maybe)
    { endOperation_W1(ops[i$1]); }
  for (var i$2 = 0; i$2 < ops.length; i$2++) // Read DOM
    { endOperation_R2(ops[i$2]); }
  for (var i$3 = 0; i$3 < ops.length; i$3++) // Write DOM (maybe)
    { endOperation_W2(ops[i$3]); }
  for (var i$4 = 0; i$4 < ops.length; i$4++) // Read DOM
    { endOperation_finish(ops[i$4]); }
}

function endOperation_R1(op) {
  var cm = op.cm, display = cm.display;
  maybeClipScrollbars(cm);
  if (op.updateMaxLine) { findMaxLine(cm); }

  op.mustUpdate = op.viewChanged || op.forceUpdate || op.scrollTop != null ||
    op.scrollToPos && (op.scrollToPos.from.line < display.viewFrom ||
                       op.scrollToPos.to.line >= display.viewTo) ||
    display.maxLineChanged && cm.options.lineWrapping;
  op.update = op.mustUpdate &&
    new DisplayUpdate(cm, op.mustUpdate && {top: op.scrollTop, ensure: op.scrollToPos}, op.forceUpdate);
}

function endOperation_W1(op) {
  op.updatedDisplay = op.mustUpdate && updateDisplayIfNeeded(op.cm, op.update);
}

function endOperation_R2(op) {
  var cm = op.cm, display = cm.display;
  if (op.updatedDisplay) { updateHeightsInViewport(cm); }

  op.barMeasure = measureForScrollbars(cm);

  // If the max line changed since it was last measured, measure it,
  // and ensure the document's width matches it.
  // updateDisplay_W2 will use these properties to do the actual resizing
  if (display.maxLineChanged && !cm.options.lineWrapping) {
    op.adjustWidthTo = measureChar(cm, display.maxLine, display.maxLine.text.length).left + 3;
    cm.display.sizerWidth = op.adjustWidthTo;
    op.barMeasure.scrollWidth =
      Math.max(display.scroller.clientWidth, display.sizer.offsetLeft + op.adjustWidthTo + scrollGap(cm) + cm.display.barWidth);
    op.maxScrollLeft = Math.max(0, display.sizer.offsetLeft + op.adjustWidthTo - displayWidth(cm));
  }

  if (op.updatedDisplay || op.selectionChanged)
    { op.preparedSelection = display.input.prepareSelection(); }
}

function endOperation_W2(op) {
  var cm = op.cm;

  if (op.adjustWidthTo != null) {
    cm.display.sizer.style.minWidth = op.adjustWidthTo + "px";
    if (op.maxScrollLeft < cm.doc.scrollLeft)
      { setScrollLeft(cm, Math.min(cm.display.scroller.scrollLeft, op.maxScrollLeft), true); }
    cm.display.maxLineChanged = false;
  }

  var takeFocus = op.focus && op.focus == activeElt();
  if (op.preparedSelection)
    { cm.display.input.showSelection(op.preparedSelection, takeFocus); }
  if (op.updatedDisplay || op.startHeight != cm.doc.height)
    { updateScrollbars(cm, op.barMeasure); }
  if (op.updatedDisplay)
    { setDocumentHeight(cm, op.barMeasure); }

  if (op.selectionChanged) { restartBlink(cm); }

  if (cm.state.focused && op.updateInput)
    { cm.display.input.reset(op.typing); }
  if (takeFocus) { ensureFocus(op.cm); }
}

function endOperation_finish(op) {
  var cm = op.cm, display = cm.display, doc = cm.doc;

  if (op.updatedDisplay) { postUpdateDisplay(cm, op.update); }

  // Abort mouse wheel delta measurement, when scrolling explicitly
  if (display.wheelStartX != null && (op.scrollTop != null || op.scrollLeft != null || op.scrollToPos))
    { display.wheelStartX = display.wheelStartY = null; }

  // Propagate the scroll position to the actual DOM scroller
  if (op.scrollTop != null) { setScrollTop(cm, op.scrollTop, op.forceScroll); }

  if (op.scrollLeft != null) { setScrollLeft(cm, op.scrollLeft, true, true); }
  // If we need to scroll a specific position into view, do so.
  if (op.scrollToPos) {
    var rect = scrollPosIntoView(cm, clipPos(doc, op.scrollToPos.from),
                                 clipPos(doc, op.scrollToPos.to), op.scrollToPos.margin);
    maybeScrollWindow(cm, rect);
  }

  // Fire events for markers that are hidden/unidden by editing or
  // undoing
  var hidden = op.maybeHiddenMarkers, unhidden = op.maybeUnhiddenMarkers;
  if (hidden) { for (var i = 0; i < hidden.length; ++i)
    { if (!hidden[i].lines.length) { signal(hidden[i], "hide"); } } }
  if (unhidden) { for (var i$1 = 0; i$1 < unhidden.length; ++i$1)
    { if (unhidden[i$1].lines.length) { signal(unhidden[i$1], "unhide"); } } }

  if (display.wrapper.offsetHeight)
    { doc.scrollTop = cm.display.scroller.scrollTop; }

  // Fire change events, and delayed event handlers
  if (op.changeObjs)
    { signal(cm, "changes", cm, op.changeObjs); }
  if (op.update)
    { op.update.finish(); }
}

// Run the given function in an operation
function runInOp(cm, f) {
  if (cm.curOp) { return f() }
  startOperation(cm);
  try { return f() }
  finally { endOperation(cm); }
}
// Wraps a function in an operation. Returns the wrapped function.
function operation(cm, f) {
  return function() {
    if (cm.curOp) { return f.apply(cm, arguments) }
    startOperation(cm);
    try { return f.apply(cm, arguments) }
    finally { endOperation(cm); }
  }
}
// Used to add methods to editor and doc instances, wrapping them in
// operations.
function methodOp(f) {
  return function() {
    if (this.curOp) { return f.apply(this, arguments) }
    startOperation(this);
    try { return f.apply(this, arguments) }
    finally { endOperation(this); }
  }
}
function docMethodOp(f) {
  return function() {
    var cm = this.cm;
    if (!cm || cm.curOp) { return f.apply(this, arguments) }
    startOperation(cm);
    try { return f.apply(this, arguments) }
    finally { endOperation(cm); }
  }
}

// Updates the display.view data structure for a given change to the
// document. From and to are in pre-change coordinates. Lendiff is
// the amount of lines added or subtracted by the change. This is
// used for changes that span multiple lines, or change the way
// lines are divided into visual lines. regLineChange (below)
// registers single-line changes.
function regChange(cm, from, to, lendiff) {
  if (from == null) { from = cm.doc.first; }
  if (to == null) { to = cm.doc.first + cm.doc.size; }
  if (!lendiff) { lendiff = 0; }

  var display = cm.display;
  if (lendiff && to < display.viewTo &&
      (display.updateLineNumbers == null || display.updateLineNumbers > from))
    { display.updateLineNumbers = from; }

  cm.curOp.viewChanged = true;

  if (from >= display.viewTo) { // Change after
    if (sawCollapsedSpans && visualLineNo(cm.doc, from) < display.viewTo)
      { resetView(cm); }
  } else if (to <= display.viewFrom) { // Change before
    if (sawCollapsedSpans && visualLineEndNo(cm.doc, to + lendiff) > display.viewFrom) {
      resetView(cm);
    } else {
      display.viewFrom += lendiff;
      display.viewTo += lendiff;
    }
  } else if (from <= display.viewFrom && to >= display.viewTo) { // Full overlap
    resetView(cm);
  } else if (from <= display.viewFrom) { // Top overlap
    var cut = viewCuttingPoint(cm, to, to + lendiff, 1);
    if (cut) {
      display.view = display.view.slice(cut.index);
      display.viewFrom = cut.lineN;
      display.viewTo += lendiff;
    } else {
      resetView(cm);
    }
  } else if (to >= display.viewTo) { // Bottom overlap
    var cut$1 = viewCuttingPoint(cm, from, from, -1);
    if (cut$1) {
      display.view = display.view.slice(0, cut$1.index);
      display.viewTo = cut$1.lineN;
    } else {
      resetView(cm);
    }
  } else { // Gap in the middle
    var cutTop = viewCuttingPoint(cm, from, from, -1);
    var cutBot = viewCuttingPoint(cm, to, to + lendiff, 1);
    if (cutTop && cutBot) {
      display.view = display.view.slice(0, cutTop.index)
        .concat(buildViewArray(cm, cutTop.lineN, cutBot.lineN))
        .concat(display.view.slice(cutBot.index));
      display.viewTo += lendiff;
    } else {
      resetView(cm);
    }
  }

  var ext = display.externalMeasured;
  if (ext) {
    if (to < ext.lineN)
      { ext.lineN += lendiff; }
    else if (from < ext.lineN + ext.size)
      { display.externalMeasured = null; }
  }
}

// Register a change to a single line. Type must be one of "text",
// "gutter", "class", "widget"
function regLineChange(cm, line, type) {
  cm.curOp.viewChanged = true;
  var display = cm.display, ext = cm.display.externalMeasured;
  if (ext && line >= ext.lineN && line < ext.lineN + ext.size)
    { display.externalMeasured = null; }

  if (line < display.viewFrom || line >= display.viewTo) { return }
  var lineView = display.view[findViewIndex(cm, line)];
  if (lineView.node == null) { return }
  var arr = lineView.changes || (lineView.changes = []);
  if (indexOf(arr, type) == -1) { arr.push(type); }
}

// Clear the view.
function resetView(cm) {
  cm.display.viewFrom = cm.display.viewTo = cm.doc.first;
  cm.display.view = [];
  cm.display.viewOffset = 0;
}

function viewCuttingPoint(cm, oldN, newN, dir) {
  var index = findViewIndex(cm, oldN), diff, view = cm.display.view;
  if (!sawCollapsedSpans || newN == cm.doc.first + cm.doc.size)
    { return {index: index, lineN: newN} }
  var n = cm.display.viewFrom;
  for (var i = 0; i < index; i++)
    { n += view[i].size; }
  if (n != oldN) {
    if (dir > 0) {
      if (index == view.length - 1) { return null }
      diff = (n + view[index].size) - oldN;
      index++;
    } else {
      diff = n - oldN;
    }
    oldN += diff; newN += diff;
  }
  while (visualLineNo(cm.doc, newN) != newN) {
    if (index == (dir < 0 ? 0 : view.length - 1)) { return null }
    newN += dir * view[index - (dir < 0 ? 1 : 0)].size;
    index += dir;
  }
  return {index: index, lineN: newN}
}

// Force the view to cover a given range, adding empty view element
// or clipping off existing ones as needed.
function adjustView(cm, from, to) {
  var display = cm.display, view = display.view;
  if (view.length == 0 || from >= display.viewTo || to <= display.viewFrom) {
    display.view = buildViewArray(cm, from, to);
    display.viewFrom = from;
  } else {
    if (display.viewFrom > from)
      { display.view = buildViewArray(cm, from, display.viewFrom).concat(display.view); }
    else if (display.viewFrom < from)
      { display.view = display.view.slice(findViewIndex(cm, from)); }
    display.viewFrom = from;
    if (display.viewTo < to)
      { display.view = display.view.concat(buildViewArray(cm, display.viewTo, to)); }
    else if (display.viewTo > to)
      { display.view = display.view.slice(0, findViewIndex(cm, to)); }
  }
  display.viewTo = to;
}

// Count the number of lines in the view whose DOM representation is
// out of date (or nonexistent).
function countDirtyView(cm) {
  var view = cm.display.view, dirty = 0;
  for (var i = 0; i < view.length; i++) {
    var lineView = view[i];
    if (!lineView.hidden && (!lineView.node || lineView.changes)) { ++dirty; }
  }
  return dirty
}

// HIGHLIGHT WORKER

function startWorker(cm, time) {
  if (cm.doc.highlightFrontier < cm.display.viewTo)
    { cm.state.highlight.set(time, bind(highlightWorker, cm)); }
}

function highlightWorker(cm) {
  var doc = cm.doc;
  if (doc.highlightFrontier >= cm.display.viewTo) { return }
  var end = +new Date + cm.options.workTime;
  var context = getContextBefore(cm, doc.highlightFrontier);
  var changedLines = [];

  doc.iter(context.line, Math.min(doc.first + doc.size, cm.display.viewTo + 500), function (line) {
    if (context.line >= cm.display.viewFrom) { // Visible
      var oldStyles = line.styles;
      var resetState = line.text.length > cm.options.maxHighlightLength ? copyState(doc.mode, context.state) : null;
      var highlighted = highlightLine(cm, line, context, true);
      if (resetState) { context.state = resetState; }
      line.styles = highlighted.styles;
      var oldCls = line.styleClasses, newCls = highlighted.classes;
      if (newCls) { line.styleClasses = newCls; }
      else if (oldCls) { line.styleClasses = null; }
      var ischange = !oldStyles || oldStyles.length != line.styles.length ||
        oldCls != newCls && (!oldCls || !newCls || oldCls.bgClass != newCls.bgClass || oldCls.textClass != newCls.textClass);
      for (var i = 0; !ischange && i < oldStyles.length; ++i) { ischange = oldStyles[i] != line.styles[i]; }
      if (ischange) { changedLines.push(context.line); }
      line.stateAfter = context.save();
      context.nextLine();
    } else {
      if (line.text.length <= cm.options.maxHighlightLength)
        { processLine(cm, line.text, context); }
      line.stateAfter = context.line % 5 == 0 ? context.save() : null;
      context.nextLine();
    }
    if (+new Date > end) {
      startWorker(cm, cm.options.workDelay);
      return true
    }
  });
  doc.highlightFrontier = context.line;
  doc.modeFrontier = Math.max(doc.modeFrontier, context.line);
  if (changedLines.length) { runInOp(cm, function () {
    for (var i = 0; i < changedLines.length; i++)
      { regLineChange(cm, changedLines[i], "text"); }
  }); }
}

// DISPLAY DRAWING

var DisplayUpdate = function(cm, viewport, force) {
  var display = cm.display;

  this.viewport = viewport;
  // Store some values that we'll need later (but don't want to force a relayout for)
  this.visible = visibleLines(display, cm.doc, viewport);
  this.editorIsHidden = !display.wrapper.offsetWidth;
  this.wrapperHeight = display.wrapper.clientHeight;
  this.wrapperWidth = display.wrapper.clientWidth;
  this.oldDisplayWidth = displayWidth(cm);
  this.force = force;
  this.dims = getDimensions(cm);
  this.events = [];
};

DisplayUpdate.prototype.signal = function (emitter, type) {
  if (hasHandler(emitter, type))
    { this.events.push(arguments); }
};
DisplayUpdate.prototype.finish = function () {
    var this$1 = this;

  for (var i = 0; i < this.events.length; i++)
    { signal.apply(null, this$1.events[i]); }
};

function maybeClipScrollbars(cm) {
  var display = cm.display;
  if (!display.scrollbarsClipped && display.scroller.offsetWidth) {
    display.nativeBarWidth = display.scroller.offsetWidth - display.scroller.clientWidth;
    display.heightForcer.style.height = scrollGap(cm) + "px";
    display.sizer.style.marginBottom = -display.nativeBarWidth + "px";
    display.sizer.style.borderRightWidth = scrollGap(cm) + "px";
    display.scrollbarsClipped = true;
  }
}

function selectionSnapshot(cm) {
  if (cm.hasFocus()) { return null }
  var active = activeElt();
  if (!active || !contains(cm.display.lineDiv, active)) { return null }
  var result = {activeElt: active};
  if (window.getSelection) {
    var sel = window.getSelection();
    if (sel.anchorNode && sel.extend && contains(cm.display.lineDiv, sel.anchorNode)) {
      result.anchorNode = sel.anchorNode;
      result.anchorOffset = sel.anchorOffset;
      result.focusNode = sel.focusNode;
      result.focusOffset = sel.focusOffset;
    }
  }
  return result
}

function restoreSelection(snapshot) {
  if (!snapshot || !snapshot.activeElt || snapshot.activeElt == activeElt()) { return }
  snapshot.activeElt.focus();
  if (snapshot.anchorNode && contains(document.body, snapshot.anchorNode) && contains(document.body, snapshot.focusNode)) {
    var sel = window.getSelection(), range$$1 = document.createRange();
    range$$1.setEnd(snapshot.anchorNode, snapshot.anchorOffset);
    range$$1.collapse(false);
    sel.removeAllRanges();
    sel.addRange(range$$1);
    sel.extend(snapshot.focusNode, snapshot.focusOffset);
  }
}

// Does the actual updating of the line display. Bails out
// (returning false) when there is nothing to be done and forced is
// false.
function updateDisplayIfNeeded(cm, update) {
  var display = cm.display, doc = cm.doc;

  if (update.editorIsHidden) {
    resetView(cm);
    return false
  }

  // Bail out if the visible area is already rendered and nothing changed.
  if (!update.force &&
      update.visible.from >= display.viewFrom && update.visible.to <= display.viewTo &&
      (display.updateLineNumbers == null || display.updateLineNumbers >= display.viewTo) &&
      display.renderedView == display.view && countDirtyView(cm) == 0)
    { return false }

  if (maybeUpdateLineNumberWidth(cm)) {
    resetView(cm);
    update.dims = getDimensions(cm);
  }

  // Compute a suitable new viewport (from & to)
  var end = doc.first + doc.size;
  var from = Math.max(update.visible.from - cm.options.viewportMargin, doc.first);
  var to = Math.min(end, update.visible.to + cm.options.viewportMargin);
  if (display.viewFrom < from && from - display.viewFrom < 20) { from = Math.max(doc.first, display.viewFrom); }
  if (display.viewTo > to && display.viewTo - to < 20) { to = Math.min(end, display.viewTo); }
  if (sawCollapsedSpans) {
    from = visualLineNo(cm.doc, from);
    to = visualLineEndNo(cm.doc, to);
  }

  var different = from != display.viewFrom || to != display.viewTo ||
    display.lastWrapHeight != update.wrapperHeight || display.lastWrapWidth != update.wrapperWidth;
  adjustView(cm, from, to);

  display.viewOffset = heightAtLine(getLine(cm.doc, display.viewFrom));
  // Position the mover div to align with the current scroll position
  cm.display.mover.style.top = display.viewOffset + "px";

  var toUpdate = countDirtyView(cm);
  if (!different && toUpdate == 0 && !update.force && display.renderedView == display.view &&
      (display.updateLineNumbers == null || display.updateLineNumbers >= display.viewTo))
    { return false }

  // For big changes, we hide the enclosing element during the
  // update, since that speeds up the operations on most browsers.
  var selSnapshot = selectionSnapshot(cm);
  if (toUpdate > 4) { display.lineDiv.style.display = "none"; }
  patchDisplay(cm, display.updateLineNumbers, update.dims);
  if (toUpdate > 4) { display.lineDiv.style.display = ""; }
  display.renderedView = display.view;
  // There might have been a widget with a focused element that got
  // hidden or updated, if so re-focus it.
  restoreSelection(selSnapshot);

  // Prevent selection and cursors from interfering with the scroll
  // width and height.
  removeChildren(display.cursorDiv);
  removeChildren(display.selectionDiv);
  display.gutters.style.height = display.sizer.style.minHeight = 0;

  if (different) {
    display.lastWrapHeight = update.wrapperHeight;
    display.lastWrapWidth = update.wrapperWidth;
    startWorker(cm, 400);
  }

  display.updateLineNumbers = null;

  return true
}

function postUpdateDisplay(cm, update) {
  var viewport = update.viewport;

  for (var first = true;; first = false) {
    if (!first || !cm.options.lineWrapping || update.oldDisplayWidth == displayWidth(cm)) {
      // Clip forced viewport to actual scrollable area.
      if (viewport && viewport.top != null)
        { viewport = {top: Math.min(cm.doc.height + paddingVert(cm.display) - displayHeight(cm), viewport.top)}; }
      // Updated line heights might result in the drawn area not
      // actually covering the viewport. Keep looping until it does.
      update.visible = visibleLines(cm.display, cm.doc, viewport);
      if (update.visible.from >= cm.display.viewFrom && update.visible.to <= cm.display.viewTo)
        { break }
    }
    if (!updateDisplayIfNeeded(cm, update)) { break }
    updateHeightsInViewport(cm);
    var barMeasure = measureForScrollbars(cm);
    updateSelection(cm);
    updateScrollbars(cm, barMeasure);
    setDocumentHeight(cm, barMeasure);
    update.force = false;
  }

  update.signal(cm, "update", cm);
  if (cm.display.viewFrom != cm.display.reportedViewFrom || cm.display.viewTo != cm.display.reportedViewTo) {
    update.signal(cm, "viewportChange", cm, cm.display.viewFrom, cm.display.viewTo);
    cm.display.reportedViewFrom = cm.display.viewFrom; cm.display.reportedViewTo = cm.display.viewTo;
  }
}

function updateDisplaySimple(cm, viewport) {
  var update = new DisplayUpdate(cm, viewport);
  if (updateDisplayIfNeeded(cm, update)) {
    updateHeightsInViewport(cm);
    postUpdateDisplay(cm, update);
    var barMeasure = measureForScrollbars(cm);
    updateSelection(cm);
    updateScrollbars(cm, barMeasure);
    setDocumentHeight(cm, barMeasure);
    update.finish();
  }
}

// Sync the actual display DOM structure with display.view, removing
// nodes for lines that are no longer in view, and creating the ones
// that are not there yet, and updating the ones that are out of
// date.
function patchDisplay(cm, updateNumbersFrom, dims) {
  var display = cm.display, lineNumbers = cm.options.lineNumbers;
  var container = display.lineDiv, cur = container.firstChild;

  function rm(node) {
    var next = node.nextSibling;
    // Works around a throw-scroll bug in OS X Webkit
    if (webkit && mac && cm.display.currentWheelTarget == node)
      { node.style.display = "none"; }
    else
      { node.parentNode.removeChild(node); }
    return next
  }

  var view = display.view, lineN = display.viewFrom;
  // Loop over the elements in the view, syncing cur (the DOM nodes
  // in display.lineDiv) with the view as we go.
  for (var i = 0; i < view.length; i++) {
    var lineView = view[i];
    if (lineView.hidden) {
    } else if (!lineView.node || lineView.node.parentNode != container) { // Not drawn yet
      var node = buildLineElement(cm, lineView, lineN, dims);
      container.insertBefore(node, cur);
    } else { // Already drawn
      while (cur != lineView.node) { cur = rm(cur); }
      var updateNumber = lineNumbers && updateNumbersFrom != null &&
        updateNumbersFrom <= lineN && lineView.lineNumber;
      if (lineView.changes) {
        if (indexOf(lineView.changes, "gutter") > -1) { updateNumber = false; }
        updateLineForChanges(cm, lineView, lineN, dims);
      }
      if (updateNumber) {
        removeChildren(lineView.lineNumber);
        lineView.lineNumber.appendChild(document.createTextNode(lineNumberFor(cm.options, lineN)));
      }
      cur = lineView.node.nextSibling;
    }
    lineN += lineView.size;
  }
  while (cur) { cur = rm(cur); }
}

function updateGutterSpace(cm) {
  var width = cm.display.gutters.offsetWidth;
  cm.display.sizer.style.marginLeft = width + "px";
}

function setDocumentHeight(cm, measure) {
  cm.display.sizer.style.minHeight = measure.docHeight + "px";
  cm.display.heightForcer.style.top = measure.docHeight + "px";
  cm.display.gutters.style.height = (measure.docHeight + cm.display.barHeight + scrollGap(cm)) + "px";
}

// Rebuild the gutter elements, ensure the margin to the left of the
// code matches their width.
function updateGutters(cm) {
  var gutters = cm.display.gutters, specs = cm.options.gutters;
  removeChildren(gutters);
  var i = 0;
  for (; i < specs.length; ++i) {
    var gutterClass = specs[i];
    var gElt = gutters.appendChild(elt("div", null, "CodeMirror-gutter " + gutterClass));
    if (gutterClass == "CodeMirror-linenumbers") {
      cm.display.lineGutter = gElt;
      gElt.style.width = (cm.display.lineNumWidth || 1) + "px";
    }
  }
  gutters.style.display = i ? "" : "none";
  updateGutterSpace(cm);
}

// Make sure the gutters options contains the element
// "CodeMirror-linenumbers" when the lineNumbers option is true.
function setGuttersForLineNumbers(options) {
  var found = indexOf(options.gutters, "CodeMirror-linenumbers");
  if (found == -1 && options.lineNumbers) {
    options.gutters = options.gutters.concat(["CodeMirror-linenumbers"]);
  } else if (found > -1 && !options.lineNumbers) {
    options.gutters = options.gutters.slice(0);
    options.gutters.splice(found, 1);
  }
}

// Since the delta values reported on mouse wheel events are
// unstandardized between browsers and even browser versions, and
// generally horribly unpredictable, this code starts by measuring
// the scroll effect that the first few mouse wheel events have,
// and, from that, detects the way it can convert deltas to pixel
// offsets afterwards.
//
// The reason we want to know the amount a wheel event will scroll
// is that it gives us a chance to update the display before the
// actual scrolling happens, reducing flickering.

var wheelSamples = 0;
var wheelPixelsPerUnit = null;
// Fill in a browser-detected starting value on browsers where we
// know one. These don't have to be accurate -- the result of them
// being wrong would just be a slight flicker on the first wheel
// scroll (if it is large enough).
if (ie) { wheelPixelsPerUnit = -.53; }
else if (gecko) { wheelPixelsPerUnit = 15; }
else if (chrome) { wheelPixelsPerUnit = -.7; }
else if (safari) { wheelPixelsPerUnit = -1/3; }

function wheelEventDelta(e) {
  var dx = e.wheelDeltaX, dy = e.wheelDeltaY;
  if (dx == null && e.detail && e.axis == e.HORIZONTAL_AXIS) { dx = e.detail; }
  if (dy == null && e.detail && e.axis == e.VERTICAL_AXIS) { dy = e.detail; }
  else if (dy == null) { dy = e.wheelDelta; }
  return {x: dx, y: dy}
}
function wheelEventPixels(e) {
  var delta = wheelEventDelta(e);
  delta.x *= wheelPixelsPerUnit;
  delta.y *= wheelPixelsPerUnit;
  return delta
}

function onScrollWheel(cm, e) {
  var delta = wheelEventDelta(e), dx = delta.x, dy = delta.y;

  var display = cm.display, scroll = display.scroller;
  // Quit if there's nothing to scroll here
  var canScrollX = scroll.scrollWidth > scroll.clientWidth;
  var canScrollY = scroll.scrollHeight > scroll.clientHeight;
  if (!(dx && canScrollX || dy && canScrollY)) { return }

  // Webkit browsers on OS X abort momentum scrolls when the target
  // of the scroll event is removed from the scrollable element.
  // This hack (see related code in patchDisplay) makes sure the
  // element is kept around.
  if (dy && mac && webkit) {
    outer: for (var cur = e.target, view = display.view; cur != scroll; cur = cur.parentNode) {
      for (var i = 0; i < view.length; i++) {
        if (view[i].node == cur) {
          cm.display.currentWheelTarget = cur;
          break outer
        }
      }
    }
  }

  // On some browsers, horizontal scrolling will cause redraws to
  // happen before the gutter has been realigned, causing it to
  // wriggle around in a most unseemly way. When we have an
  // estimated pixels/delta value, we just handle horizontal
  // scrolling entirely here. It'll be slightly off from native, but
  // better than glitching out.
  if (dx && !gecko && !presto && wheelPixelsPerUnit != null) {
    if (dy && canScrollY)
      { updateScrollTop(cm, Math.max(0, scroll.scrollTop + dy * wheelPixelsPerUnit)); }
    setScrollLeft(cm, Math.max(0, scroll.scrollLeft + dx * wheelPixelsPerUnit));
    // Only prevent default scrolling if vertical scrolling is
    // actually possible. Otherwise, it causes vertical scroll
    // jitter on OSX trackpads when deltaX is small and deltaY
    // is large (issue #3579)
    if (!dy || (dy && canScrollY))
      { e_preventDefault(e); }
    display.wheelStartX = null; // Abort measurement, if in progress
    return
  }

  // 'Project' the visible viewport to cover the area that is being
  // scrolled into view (if we know enough to estimate it).
  if (dy && wheelPixelsPerUnit != null) {
    var pixels = dy * wheelPixelsPerUnit;
    var top = cm.doc.scrollTop, bot = top + display.wrapper.clientHeight;
    if (pixels < 0) { top = Math.max(0, top + pixels - 50); }
    else { bot = Math.min(cm.doc.height, bot + pixels + 50); }
    updateDisplaySimple(cm, {top: top, bottom: bot});
  }

  if (wheelSamples < 20) {
    if (display.wheelStartX == null) {
      display.wheelStartX = scroll.scrollLeft; display.wheelStartY = scroll.scrollTop;
      display.wheelDX = dx; display.wheelDY = dy;
      setTimeout(function () {
        if (display.wheelStartX == null) { return }
        var movedX = scroll.scrollLeft - display.wheelStartX;
        var movedY = scroll.scrollTop - display.wheelStartY;
        var sample = (movedY && display.wheelDY && movedY / display.wheelDY) ||
          (movedX && display.wheelDX && movedX / display.wheelDX);
        display.wheelStartX = display.wheelStartY = null;
        if (!sample) { return }
        wheelPixelsPerUnit = (wheelPixelsPerUnit * wheelSamples + sample) / (wheelSamples + 1);
        ++wheelSamples;
      }, 200);
    } else {
      display.wheelDX += dx; display.wheelDY += dy;
    }
  }
}

// Selection objects are immutable. A new one is created every time
// the selection changes. A selection is one or more non-overlapping
// (and non-touching) ranges, sorted, and an integer that indicates
// which one is the primary selection (the one that's scrolled into
// view, that getCursor returns, etc).
var Selection = function(ranges, primIndex) {
  this.ranges = ranges;
  this.primIndex = primIndex;
};

Selection.prototype.primary = function () { return this.ranges[this.primIndex] };

Selection.prototype.equals = function (other) {
    var this$1 = this;

  if (other == this) { return true }
  if (other.primIndex != this.primIndex || other.ranges.length != this.ranges.length) { return false }
  for (var i = 0; i < this.ranges.length; i++) {
    var here = this$1.ranges[i], there = other.ranges[i];
    if (!equalCursorPos(here.anchor, there.anchor) || !equalCursorPos(here.head, there.head)) { return false }
  }
  return true
};

Selection.prototype.deepCopy = function () {
    var this$1 = this;

  var out = [];
  for (var i = 0; i < this.ranges.length; i++)
    { out[i] = new Range(copyPos(this$1.ranges[i].anchor), copyPos(this$1.ranges[i].head)); }
  return new Selection(out, this.primIndex)
};

Selection.prototype.somethingSelected = function () {
    var this$1 = this;

  for (var i = 0; i < this.ranges.length; i++)
    { if (!this$1.ranges[i].empty()) { return true } }
  return false
};

Selection.prototype.contains = function (pos, end) {
    var this$1 = this;

  if (!end) { end = pos; }
  for (var i = 0; i < this.ranges.length; i++) {
    var range = this$1.ranges[i];
    if (cmp(end, range.from()) >= 0 && cmp(pos, range.to()) <= 0)
      { return i }
  }
  return -1
};

var Range = function(anchor, head) {
  this.anchor = anchor; this.head = head;
};

Range.prototype.from = function () { return minPos(this.anchor, this.head) };
Range.prototype.to = function () { return maxPos(this.anchor, this.head) };
Range.prototype.empty = function () { return this.head.line == this.anchor.line && this.head.ch == this.anchor.ch };

// Take an unsorted, potentially overlapping set of ranges, and
// build a selection out of it. 'Consumes' ranges array (modifying
// it).
function normalizeSelection(ranges, primIndex) {
  var prim = ranges[primIndex];
  ranges.sort(function (a, b) { return cmp(a.from(), b.from()); });
  primIndex = indexOf(ranges, prim);
  for (var i = 1; i < ranges.length; i++) {
    var cur = ranges[i], prev = ranges[i - 1];
    if (cmp(prev.to(), cur.from()) >= 0) {
      var from = minPos(prev.from(), cur.from()), to = maxPos(prev.to(), cur.to());
      var inv = prev.empty() ? cur.from() == cur.head : prev.from() == prev.head;
      if (i <= primIndex) { --primIndex; }
      ranges.splice(--i, 2, new Range(inv ? to : from, inv ? from : to));
    }
  }
  return new Selection(ranges, primIndex)
}

function simpleSelection(anchor, head) {
  return new Selection([new Range(anchor, head || anchor)], 0)
}

// Compute the position of the end of a change (its 'to' property
// refers to the pre-change end).
function changeEnd(change) {
  if (!change.text) { return change.to }
  return Pos(change.from.line + change.text.length - 1,
             lst(change.text).length + (change.text.length == 1 ? change.from.ch : 0))
}

// Adjust a position to refer to the post-change position of the
// same text, or the end of the change if the change covers it.
function adjustForChange(pos, change) {
  if (cmp(pos, change.from) < 0) { return pos }
  if (cmp(pos, change.to) <= 0) { return changeEnd(change) }

  var line = pos.line + change.text.length - (change.to.line - change.from.line) - 1, ch = pos.ch;
  if (pos.line == change.to.line) { ch += changeEnd(change).ch - change.to.ch; }
  return Pos(line, ch)
}

function computeSelAfterChange(doc, change) {
  var out = [];
  for (var i = 0; i < doc.sel.ranges.length; i++) {
    var range = doc.sel.ranges[i];
    out.push(new Range(adjustForChange(range.anchor, change),
                       adjustForChange(range.head, change)));
  }
  return normalizeSelection(out, doc.sel.primIndex)
}

function offsetPos(pos, old, nw) {
  if (pos.line == old.line)
    { return Pos(nw.line, pos.ch - old.ch + nw.ch) }
  else
    { return Pos(nw.line + (pos.line - old.line), pos.ch) }
}

// Used by replaceSelections to allow moving the selection to the
// start or around the replaced test. Hint may be "start" or "around".
function computeReplacedSel(doc, changes, hint) {
  var out = [];
  var oldPrev = Pos(doc.first, 0), newPrev = oldPrev;
  for (var i = 0; i < changes.length; i++) {
    var change = changes[i];
    var from = offsetPos(change.from, oldPrev, newPrev);
    var to = offsetPos(changeEnd(change), oldPrev, newPrev);
    oldPrev = change.to;
    newPrev = to;
    if (hint == "around") {
      var range = doc.sel.ranges[i], inv = cmp(range.head, range.anchor) < 0;
      out[i] = new Range(inv ? to : from, inv ? from : to);
    } else {
      out[i] = new Range(from, from);
    }
  }
  return new Selection(out, doc.sel.primIndex)
}

// Used to get the editor into a consistent state again when options change.

function loadMode(cm) {
  cm.doc.mode = getMode(cm.options, cm.doc.modeOption);
  resetModeState(cm);
}

function resetModeState(cm) {
  cm.doc.iter(function (line) {
    if (line.stateAfter) { line.stateAfter = null; }
    if (line.styles) { line.styles = null; }
  });
  cm.doc.modeFrontier = cm.doc.highlightFrontier = cm.doc.first;
  startWorker(cm, 100);
  cm.state.modeGen++;
  if (cm.curOp) { regChange(cm); }
}

// DOCUMENT DATA STRUCTURE

// By default, updates that start and end at the beginning of a line
// are treated specially, in order to make the association of line
// widgets and marker elements with the text behave more intuitive.
function isWholeLineUpdate(doc, change) {
  return change.from.ch == 0 && change.to.ch == 0 && lst(change.text) == "" &&
    (!doc.cm || doc.cm.options.wholeLineUpdateBefore)
}

// Perform a change on the document data structure.
function updateDoc(doc, change, markedSpans, estimateHeight$$1) {
  function spansFor(n) {return markedSpans ? markedSpans[n] : null}
  function update(line, text, spans) {
    updateLine(line, text, spans, estimateHeight$$1);
    signalLater(line, "change", line, change);
  }
  function linesFor(start, end) {
    var result = [];
    for (var i = start; i < end; ++i)
      { result.push(new Line(text[i], spansFor(i), estimateHeight$$1)); }
    return result
  }

  var from = change.from, to = change.to, text = change.text;
  var firstLine = getLine(doc, from.line), lastLine = getLine(doc, to.line);
  var lastText = lst(text), lastSpans = spansFor(text.length - 1), nlines = to.line - from.line;

  // Adjust the line structure
  if (change.full) {
    doc.insert(0, linesFor(0, text.length));
    doc.remove(text.length, doc.size - text.length);
  } else if (isWholeLineUpdate(doc, change)) {
    // This is a whole-line replace. Treated specially to make
    // sure line objects move the way they are supposed to.
    var added = linesFor(0, text.length - 1);
    update(lastLine, lastLine.text, lastSpans);
    if (nlines) { doc.remove(from.line, nlines); }
    if (added.length) { doc.insert(from.line, added); }
  } else if (firstLine == lastLine) {
    if (text.length == 1) {
      update(firstLine, firstLine.text.slice(0, from.ch) + lastText + firstLine.text.slice(to.ch), lastSpans);
    } else {
      var added$1 = linesFor(1, text.length - 1);
      added$1.push(new Line(lastText + firstLine.text.slice(to.ch), lastSpans, estimateHeight$$1));
      update(firstLine, firstLine.text.slice(0, from.ch) + text[0], spansFor(0));
      doc.insert(from.line + 1, added$1);
    }
  } else if (text.length == 1) {
    update(firstLine, firstLine.text.slice(0, from.ch) + text[0] + lastLine.text.slice(to.ch), spansFor(0));
    doc.remove(from.line + 1, nlines);
  } else {
    update(firstLine, firstLine.text.slice(0, from.ch) + text[0], spansFor(0));
    update(lastLine, lastText + lastLine.text.slice(to.ch), lastSpans);
    var added$2 = linesFor(1, text.length - 1);
    if (nlines > 1) { doc.remove(from.line + 1, nlines - 1); }
    doc.insert(from.line + 1, added$2);
  }

  signalLater(doc, "change", doc, change);
}

// Call f for all linked documents.
function linkedDocs(doc, f, sharedHistOnly) {
  function propagate(doc, skip, sharedHist) {
    if (doc.linked) { for (var i = 0; i < doc.linked.length; ++i) {
      var rel = doc.linked[i];
      if (rel.doc == skip) { continue }
      var shared = sharedHist && rel.sharedHist;
      if (sharedHistOnly && !shared) { continue }
      f(rel.doc, shared);
      propagate(rel.doc, doc, shared);
    } }
  }
  propagate(doc, null, true);
}

// Attach a document to an editor.
function attachDoc(cm, doc) {
  if (doc.cm) { throw new Error("This document is already in use.") }
  cm.doc = doc;
  doc.cm = cm;
  estimateLineHeights(cm);
  loadMode(cm);
  setDirectionClass(cm);
  if (!cm.options.lineWrapping) { findMaxLine(cm); }
  cm.options.mode = doc.modeOption;
  regChange(cm);
}

function setDirectionClass(cm) {
  (cm.doc.direction == "rtl" ? addClass : rmClass)(cm.display.lineDiv, "CodeMirror-rtl");
}

function directionChanged(cm) {
  runInOp(cm, function () {
    setDirectionClass(cm);
    regChange(cm);
  });
}

function History(startGen) {
  // Arrays of change events and selections. Doing something adds an
  // event to done and clears undo. Undoing moves events from done
  // to undone, redoing moves them in the other direction.
  this.done = []; this.undone = [];
  this.undoDepth = Infinity;
  // Used to track when changes can be merged into a single undo
  // event
  this.lastModTime = this.lastSelTime = 0;
  this.lastOp = this.lastSelOp = null;
  this.lastOrigin = this.lastSelOrigin = null;
  // Used by the isClean() method
  this.generation = this.maxGeneration = startGen || 1;
}

// Create a history change event from an updateDoc-style change
// object.
function historyChangeFromChange(doc, change) {
  var histChange = {from: copyPos(change.from), to: changeEnd(change), text: getBetween(doc, change.from, change.to)};
  attachLocalSpans(doc, histChange, change.from.line, change.to.line + 1);
  linkedDocs(doc, function (doc) { return attachLocalSpans(doc, histChange, change.from.line, change.to.line + 1); }, true);
  return histChange
}

// Pop all selection events off the end of a history array. Stop at
// a change event.
function clearSelectionEvents(array) {
  while (array.length) {
    var last = lst(array);
    if (last.ranges) { array.pop(); }
    else { break }
  }
}

// Find the top change event in the history. Pop off selection
// events that are in the way.
function lastChangeEvent(hist, force) {
  if (force) {
    clearSelectionEvents(hist.done);
    return lst(hist.done)
  } else if (hist.done.length && !lst(hist.done).ranges) {
    return lst(hist.done)
  } else if (hist.done.length > 1 && !hist.done[hist.done.length - 2].ranges) {
    hist.done.pop();
    return lst(hist.done)
  }
}

// Register a change in the history. Merges changes that are within
// a single operation, or are close together with an origin that
// allows merging (starting with "+") into a single event.
function addChangeToHistory(doc, change, selAfter, opId) {
  var hist = doc.history;
  hist.undone.length = 0;
  var time = +new Date, cur;
  var last;

  if ((hist.lastOp == opId ||
       hist.lastOrigin == change.origin && change.origin &&
       ((change.origin.charAt(0) == "+" && hist.lastModTime > time - (doc.cm ? doc.cm.options.historyEventDelay : 500)) ||
        change.origin.charAt(0) == "*")) &&
      (cur = lastChangeEvent(hist, hist.lastOp == opId))) {
    // Merge this change into the last event
    last = lst(cur.changes);
    if (cmp(change.from, change.to) == 0 && cmp(change.from, last.to) == 0) {
      // Optimized case for simple insertion -- don't want to add
      // new changesets for every character typed
      last.to = changeEnd(change);
    } else {
      // Add new sub-event
      cur.changes.push(historyChangeFromChange(doc, change));
    }
  } else {
    // Can not be merged, start a new event.
    var before = lst(hist.done);
    if (!before || !before.ranges)
      { pushSelectionToHistory(doc.sel, hist.done); }
    cur = {changes: [historyChangeFromChange(doc, change)],
           generation: hist.generation};
    hist.done.push(cur);
    while (hist.done.length > hist.undoDepth) {
      hist.done.shift();
      if (!hist.done[0].ranges) { hist.done.shift(); }
    }
  }
  hist.done.push(selAfter);
  hist.generation = ++hist.maxGeneration;
  hist.lastModTime = hist.lastSelTime = time;
  hist.lastOp = hist.lastSelOp = opId;
  hist.lastOrigin = hist.lastSelOrigin = change.origin;

  if (!last) { signal(doc, "historyAdded"); }
}

function selectionEventCanBeMerged(doc, origin, prev, sel) {
  var ch = origin.charAt(0);
  return ch == "*" ||
    ch == "+" &&
    prev.ranges.length == sel.ranges.length &&
    prev.somethingSelected() == sel.somethingSelected() &&
    new Date - doc.history.lastSelTime <= (doc.cm ? doc.cm.options.historyEventDelay : 500)
}

// Called whenever the selection changes, sets the new selection as
// the pending selection in the history, and pushes the old pending
// selection into the 'done' array when it was significantly
// different (in number of selected ranges, emptiness, or time).
function addSelectionToHistory(doc, sel, opId, options) {
  var hist = doc.history, origin = options && options.origin;

  // A new event is started when the previous origin does not match
  // the current, or the origins don't allow matching. Origins
  // starting with * are always merged, those starting with + are
  // merged when similar and close together in time.
  if (opId == hist.lastSelOp ||
      (origin && hist.lastSelOrigin == origin &&
       (hist.lastModTime == hist.lastSelTime && hist.lastOrigin == origin ||
        selectionEventCanBeMerged(doc, origin, lst(hist.done), sel))))
    { hist.done[hist.done.length - 1] = sel; }
  else
    { pushSelectionToHistory(sel, hist.done); }

  hist.lastSelTime = +new Date;
  hist.lastSelOrigin = origin;
  hist.lastSelOp = opId;
  if (options && options.clearRedo !== false)
    { clearSelectionEvents(hist.undone); }
}

function pushSelectionToHistory(sel, dest) {
  var top = lst(dest);
  if (!(top && top.ranges && top.equals(sel)))
    { dest.push(sel); }
}

// Used to store marked span information in the history.
function attachLocalSpans(doc, change, from, to) {
  var existing = change["spans_" + doc.id], n = 0;
  doc.iter(Math.max(doc.first, from), Math.min(doc.first + doc.size, to), function (line) {
    if (line.markedSpans)
      { (existing || (existing = change["spans_" + doc.id] = {}))[n] = line.markedSpans; }
    ++n;
  });
}

// When un/re-doing restores text containing marked spans, those
// that have been explicitly cleared should not be restored.
function removeClearedSpans(spans) {
  if (!spans) { return null }
  var out;
  for (var i = 0; i < spans.length; ++i) {
    if (spans[i].marker.explicitlyCleared) { if (!out) { out = spans.slice(0, i); } }
    else if (out) { out.push(spans[i]); }
  }
  return !out ? spans : out.length ? out : null
}

// Retrieve and filter the old marked spans stored in a change event.
function getOldSpans(doc, change) {
  var found = change["spans_" + doc.id];
  if (!found) { return null }
  var nw = [];
  for (var i = 0; i < change.text.length; ++i)
    { nw.push(removeClearedSpans(found[i])); }
  return nw
}

// Used for un/re-doing changes from the history. Combines the
// result of computing the existing spans with the set of spans that
// existed in the history (so that deleting around a span and then
// undoing brings back the span).
function mergeOldSpans(doc, change) {
  var old = getOldSpans(doc, change);
  var stretched = stretchSpansOverChange(doc, change);
  if (!old) { return stretched }
  if (!stretched) { return old }

  for (var i = 0; i < old.length; ++i) {
    var oldCur = old[i], stretchCur = stretched[i];
    if (oldCur && stretchCur) {
      spans: for (var j = 0; j < stretchCur.length; ++j) {
        var span = stretchCur[j];
        for (var k = 0; k < oldCur.length; ++k)
          { if (oldCur[k].marker == span.marker) { continue spans } }
        oldCur.push(span);
      }
    } else if (stretchCur) {
      old[i] = stretchCur;
    }
  }
  return old
}

// Used both to provide a JSON-safe object in .getHistory, and, when
// detaching a document, to split the history in two
function copyHistoryArray(events, newGroup, instantiateSel) {
  var copy = [];
  for (var i = 0; i < events.length; ++i) {
    var event = events[i];
    if (event.ranges) {
      copy.push(instantiateSel ? Selection.prototype.deepCopy.call(event) : event);
      continue
    }
    var changes = event.changes, newChanges = [];
    copy.push({changes: newChanges});
    for (var j = 0; j < changes.length; ++j) {
      var change = changes[j], m = (void 0);
      newChanges.push({from: change.from, to: change.to, text: change.text});
      if (newGroup) { for (var prop in change) { if (m = prop.match(/^spans_(\d+)$/)) {
        if (indexOf(newGroup, Number(m[1])) > -1) {
          lst(newChanges)[prop] = change[prop];
          delete change[prop];
        }
      } } }
    }
  }
  return copy
}

// The 'scroll' parameter given to many of these indicated whether
// the new cursor position should be scrolled into view after
// modifying the selection.

// If shift is held or the extend flag is set, extends a range to
// include a given position (and optionally a second position).
// Otherwise, simply returns the range between the given positions.
// Used for cursor motion and such.
function extendRange(range, head, other, extend) {
  if (extend) {
    var anchor = range.anchor;
    if (other) {
      var posBefore = cmp(head, anchor) < 0;
      if (posBefore != (cmp(other, anchor) < 0)) {
        anchor = head;
        head = other;
      } else if (posBefore != (cmp(head, other) < 0)) {
        head = other;
      }
    }
    return new Range(anchor, head)
  } else {
    return new Range(other || head, head)
  }
}

// Extend the primary selection range, discard the rest.
function extendSelection(doc, head, other, options, extend) {
  if (extend == null) { extend = doc.cm && (doc.cm.display.shift || doc.extend); }
  setSelection(doc, new Selection([extendRange(doc.sel.primary(), head, other, extend)], 0), options);
}

// Extend all selections (pos is an array of selections with length
// equal the number of selections)
function extendSelections(doc, heads, options) {
  var out = [];
  var extend = doc.cm && (doc.cm.display.shift || doc.extend);
  for (var i = 0; i < doc.sel.ranges.length; i++)
    { out[i] = extendRange(doc.sel.ranges[i], heads[i], null, extend); }
  var newSel = normalizeSelection(out, doc.sel.primIndex);
  setSelection(doc, newSel, options);
}

// Updates a single range in the selection.
function replaceOneSelection(doc, i, range, options) {
  var ranges = doc.sel.ranges.slice(0);
  ranges[i] = range;
  setSelection(doc, normalizeSelection(ranges, doc.sel.primIndex), options);
}

// Reset the selection to a single range.
function setSimpleSelection(doc, anchor, head, options) {
  setSelection(doc, simpleSelection(anchor, head), options);
}

// Give beforeSelectionChange handlers a change to influence a
// selection update.
function filterSelectionChange(doc, sel, options) {
  var obj = {
    ranges: sel.ranges,
    update: function(ranges) {
      var this$1 = this;

      this.ranges = [];
      for (var i = 0; i < ranges.length; i++)
        { this$1.ranges[i] = new Range(clipPos(doc, ranges[i].anchor),
                                   clipPos(doc, ranges[i].head)); }
    },
    origin: options && options.origin
  };
  signal(doc, "beforeSelectionChange", doc, obj);
  if (doc.cm) { signal(doc.cm, "beforeSelectionChange", doc.cm, obj); }
  if (obj.ranges != sel.ranges) { return normalizeSelection(obj.ranges, obj.ranges.length - 1) }
  else { return sel }
}

function setSelectionReplaceHistory(doc, sel, options) {
  var done = doc.history.done, last = lst(done);
  if (last && last.ranges) {
    done[done.length - 1] = sel;
    setSelectionNoUndo(doc, sel, options);
  } else {
    setSelection(doc, sel, options);
  }
}

// Set a new selection.
function setSelection(doc, sel, options) {
  setSelectionNoUndo(doc, sel, options);
  addSelectionToHistory(doc, doc.sel, doc.cm ? doc.cm.curOp.id : NaN, options);
}

function setSelectionNoUndo(doc, sel, options) {
  if (hasHandler(doc, "beforeSelectionChange") || doc.cm && hasHandler(doc.cm, "beforeSelectionChange"))
    { sel = filterSelectionChange(doc, sel, options); }

  var bias = options && options.bias ||
    (cmp(sel.primary().head, doc.sel.primary().head) < 0 ? -1 : 1);
  setSelectionInner(doc, skipAtomicInSelection(doc, sel, bias, true));

  if (!(options && options.scroll === false) && doc.cm)
    { ensureCursorVisible(doc.cm); }
}

function setSelectionInner(doc, sel) {
  if (sel.equals(doc.sel)) { return }

  doc.sel = sel;

  if (doc.cm) {
    doc.cm.curOp.updateInput = doc.cm.curOp.selectionChanged = true;
    signalCursorActivity(doc.cm);
  }
  signalLater(doc, "cursorActivity", doc);
}

// Verify that the selection does not partially select any atomic
// marked ranges.
function reCheckSelection(doc) {
  setSelectionInner(doc, skipAtomicInSelection(doc, doc.sel, null, false));
}

// Return a selection that does not partially select any atomic
// ranges.
function skipAtomicInSelection(doc, sel, bias, mayClear) {
  var out;
  for (var i = 0; i < sel.ranges.length; i++) {
    var range = sel.ranges[i];
    var old = sel.ranges.length == doc.sel.ranges.length && doc.sel.ranges[i];
    var newAnchor = skipAtomic(doc, range.anchor, old && old.anchor, bias, mayClear);
    var newHead = skipAtomic(doc, range.head, old && old.head, bias, mayClear);
    if (out || newAnchor != range.anchor || newHead != range.head) {
      if (!out) { out = sel.ranges.slice(0, i); }
      out[i] = new Range(newAnchor, newHead);
    }
  }
  return out ? normalizeSelection(out, sel.primIndex) : sel
}

function skipAtomicInner(doc, pos, oldPos, dir, mayClear) {
  var line = getLine(doc, pos.line);
  if (line.markedSpans) { for (var i = 0; i < line.markedSpans.length; ++i) {
    var sp = line.markedSpans[i], m = sp.marker;
    if ((sp.from == null || (m.inclusiveLeft ? sp.from <= pos.ch : sp.from < pos.ch)) &&
        (sp.to == null || (m.inclusiveRight ? sp.to >= pos.ch : sp.to > pos.ch))) {
      if (mayClear) {
        signal(m, "beforeCursorEnter");
        if (m.explicitlyCleared) {
          if (!line.markedSpans) { break }
          else {--i; continue}
        }
      }
      if (!m.atomic) { continue }

      if (oldPos) {
        var near = m.find(dir < 0 ? 1 : -1), diff = (void 0);
        if (dir < 0 ? m.inclusiveRight : m.inclusiveLeft)
          { near = movePos(doc, near, -dir, near && near.line == pos.line ? line : null); }
        if (near && near.line == pos.line && (diff = cmp(near, oldPos)) && (dir < 0 ? diff < 0 : diff > 0))
          { return skipAtomicInner(doc, near, pos, dir, mayClear) }
      }

      var far = m.find(dir < 0 ? -1 : 1);
      if (dir < 0 ? m.inclusiveLeft : m.inclusiveRight)
        { far = movePos(doc, far, dir, far.line == pos.line ? line : null); }
      return far ? skipAtomicInner(doc, far, pos, dir, mayClear) : null
    }
  } }
  return pos
}

// Ensure a given position is not inside an atomic range.
function skipAtomic(doc, pos, oldPos, bias, mayClear) {
  var dir = bias || 1;
  var found = skipAtomicInner(doc, pos, oldPos, dir, mayClear) ||
      (!mayClear && skipAtomicInner(doc, pos, oldPos, dir, true)) ||
      skipAtomicInner(doc, pos, oldPos, -dir, mayClear) ||
      (!mayClear && skipAtomicInner(doc, pos, oldPos, -dir, true));
  if (!found) {
    doc.cantEdit = true;
    return Pos(doc.first, 0)
  }
  return found
}

function movePos(doc, pos, dir, line) {
  if (dir < 0 && pos.ch == 0) {
    if (pos.line > doc.first) { return clipPos(doc, Pos(pos.line - 1)) }
    else { return null }
  } else if (dir > 0 && pos.ch == (line || getLine(doc, pos.line)).text.length) {
    if (pos.line < doc.first + doc.size - 1) { return Pos(pos.line + 1, 0) }
    else { return null }
  } else {
    return new Pos(pos.line, pos.ch + dir)
  }
}

function selectAll(cm) {
  cm.setSelection(Pos(cm.firstLine(), 0), Pos(cm.lastLine()), sel_dontScroll);
}

// UPDATING

// Allow "beforeChange" event handlers to influence a change
function filterChange(doc, change, update) {
  var obj = {
    canceled: false,
    from: change.from,
    to: change.to,
    text: change.text,
    origin: change.origin,
    cancel: function () { return obj.canceled = true; }
  };
  if (update) { obj.update = function (from, to, text, origin) {
    if (from) { obj.from = clipPos(doc, from); }
    if (to) { obj.to = clipPos(doc, to); }
    if (text) { obj.text = text; }
    if (origin !== undefined) { obj.origin = origin; }
  }; }
  signal(doc, "beforeChange", doc, obj);
  if (doc.cm) { signal(doc.cm, "beforeChange", doc.cm, obj); }

  if (obj.canceled) { return null }
  return {from: obj.from, to: obj.to, text: obj.text, origin: obj.origin}
}

// Apply a change to a document, and add it to the document's
// history, and propagating it to all linked documents.
function makeChange(doc, change, ignoreReadOnly) {
  if (doc.cm) {
    if (!doc.cm.curOp) { return operation(doc.cm, makeChange)(doc, change, ignoreReadOnly) }
    if (doc.cm.state.suppressEdits) { return }
  }

  if (hasHandler(doc, "beforeChange") || doc.cm && hasHandler(doc.cm, "beforeChange")) {
    change = filterChange(doc, change, true);
    if (!change) { return }
  }

  // Possibly split or suppress the update based on the presence
  // of read-only spans in its range.
  var split = sawReadOnlySpans && !ignoreReadOnly && removeReadOnlyRanges(doc, change.from, change.to);
  if (split) {
    for (var i = split.length - 1; i >= 0; --i)
      { makeChangeInner(doc, {from: split[i].from, to: split[i].to, text: i ? [""] : change.text, origin: change.origin}); }
  } else {
    makeChangeInner(doc, change);
  }
}

function makeChangeInner(doc, change) {
  if (change.text.length == 1 && change.text[0] == "" && cmp(change.from, change.to) == 0) { return }
  var selAfter = computeSelAfterChange(doc, change);
  addChangeToHistory(doc, change, selAfter, doc.cm ? doc.cm.curOp.id : NaN);

  makeChangeSingleDoc(doc, change, selAfter, stretchSpansOverChange(doc, change));
  var rebased = [];

  linkedDocs(doc, function (doc, sharedHist) {
    if (!sharedHist && indexOf(rebased, doc.history) == -1) {
      rebaseHist(doc.history, change);
      rebased.push(doc.history);
    }
    makeChangeSingleDoc(doc, change, null, stretchSpansOverChange(doc, change));
  });
}

// Revert a change stored in a document's history.
function makeChangeFromHistory(doc, type, allowSelectionOnly) {
  var suppress = doc.cm && doc.cm.state.suppressEdits;
  if (suppress && !allowSelectionOnly) { return }

  var hist = doc.history, event, selAfter = doc.sel;
  var source = type == "undo" ? hist.done : hist.undone, dest = type == "undo" ? hist.undone : hist.done;

  // Verify that there is a useable event (so that ctrl-z won't
  // needlessly clear selection events)
  var i = 0;
  for (; i < source.length; i++) {
    event = source[i];
    if (allowSelectionOnly ? event.ranges && !event.equals(doc.sel) : !event.ranges)
      { break }
  }
  if (i == source.length) { return }
  hist.lastOrigin = hist.lastSelOrigin = null;

  for (;;) {
    event = source.pop();
    if (event.ranges) {
      pushSelectionToHistory(event, dest);
      if (allowSelectionOnly && !event.equals(doc.sel)) {
        setSelection(doc, event, {clearRedo: false});
        return
      }
      selAfter = event;
    } else if (suppress) {
      source.push(event);
      return
    } else { break }
  }

  // Build up a reverse change object to add to the opposite history
  // stack (redo when undoing, and vice versa).
  var antiChanges = [];
  pushSelectionToHistory(selAfter, dest);
  dest.push({changes: antiChanges, generation: hist.generation});
  hist.generation = event.generation || ++hist.maxGeneration;

  var filter = hasHandler(doc, "beforeChange") || doc.cm && hasHandler(doc.cm, "beforeChange");

  var loop = function ( i ) {
    var change = event.changes[i];
    change.origin = type;
    if (filter && !filterChange(doc, change, false)) {
      source.length = 0;
      return {}
    }

    antiChanges.push(historyChangeFromChange(doc, change));

    var after = i ? computeSelAfterChange(doc, change) : lst(source);
    makeChangeSingleDoc(doc, change, after, mergeOldSpans(doc, change));
    if (!i && doc.cm) { doc.cm.scrollIntoView({from: change.from, to: changeEnd(change)}); }
    var rebased = [];

    // Propagate to the linked documents
    linkedDocs(doc, function (doc, sharedHist) {
      if (!sharedHist && indexOf(rebased, doc.history) == -1) {
        rebaseHist(doc.history, change);
        rebased.push(doc.history);
      }
      makeChangeSingleDoc(doc, change, null, mergeOldSpans(doc, change));
    });
  };

  for (var i$1 = event.changes.length - 1; i$1 >= 0; --i$1) {
    var returned = loop( i$1 );

    if ( returned ) return returned.v;
  }
}

// Sub-views need their line numbers shifted when text is added
// above or below them in the parent document.
function shiftDoc(doc, distance) {
  if (distance == 0) { return }
  doc.first += distance;
  doc.sel = new Selection(map(doc.sel.ranges, function (range) { return new Range(
    Pos(range.anchor.line + distance, range.anchor.ch),
    Pos(range.head.line + distance, range.head.ch)
  ); }), doc.sel.primIndex);
  if (doc.cm) {
    regChange(doc.cm, doc.first, doc.first - distance, distance);
    for (var d = doc.cm.display, l = d.viewFrom; l < d.viewTo; l++)
      { regLineChange(doc.cm, l, "gutter"); }
  }
}

// More lower-level change function, handling only a single document
// (not linked ones).
function makeChangeSingleDoc(doc, change, selAfter, spans) {
  if (doc.cm && !doc.cm.curOp)
    { return operation(doc.cm, makeChangeSingleDoc)(doc, change, selAfter, spans) }

  if (change.to.line < doc.first) {
    shiftDoc(doc, change.text.length - 1 - (change.to.line - change.from.line));
    return
  }
  if (change.from.line > doc.lastLine()) { return }

  // Clip the change to the size of this doc
  if (change.from.line < doc.first) {
    var shift = change.text.length - 1 - (doc.first - change.from.line);
    shiftDoc(doc, shift);
    change = {from: Pos(doc.first, 0), to: Pos(change.to.line + shift, change.to.ch),
              text: [lst(change.text)], origin: change.origin};
  }
  var last = doc.lastLine();
  if (change.to.line > last) {
    change = {from: change.from, to: Pos(last, getLine(doc, last).text.length),
              text: [change.text[0]], origin: change.origin};
  }

  change.removed = getBetween(doc, change.from, change.to);

  if (!selAfter) { selAfter = computeSelAfterChange(doc, change); }
  if (doc.cm) { makeChangeSingleDocInEditor(doc.cm, change, spans); }
  else { updateDoc(doc, change, spans); }
  setSelectionNoUndo(doc, selAfter, sel_dontScroll);
}

// Handle the interaction of a change to a document with the editor
// that this document is part of.
function makeChangeSingleDocInEditor(cm, change, spans) {
  var doc = cm.doc, display = cm.display, from = change.from, to = change.to;

  var recomputeMaxLength = false, checkWidthStart = from.line;
  if (!cm.options.lineWrapping) {
    checkWidthStart = lineNo(visualLine(getLine(doc, from.line)));
    doc.iter(checkWidthStart, to.line + 1, function (line) {
      if (line == display.maxLine) {
        recomputeMaxLength = true;
        return true
      }
    });
  }

  if (doc.sel.contains(change.from, change.to) > -1)
    { signalCursorActivity(cm); }

  updateDoc(doc, change, spans, estimateHeight(cm));

  if (!cm.options.lineWrapping) {
    doc.iter(checkWidthStart, from.line + change.text.length, function (line) {
      var len = lineLength(line);
      if (len > display.maxLineLength) {
        display.maxLine = line;
        display.maxLineLength = len;
        display.maxLineChanged = true;
        recomputeMaxLength = false;
      }
    });
    if (recomputeMaxLength) { cm.curOp.updateMaxLine = true; }
  }

  retreatFrontier(doc, from.line);
  startWorker(cm, 400);

  var lendiff = change.text.length - (to.line - from.line) - 1;
  // Remember that these lines changed, for updating the display
  if (change.full)
    { regChange(cm); }
  else if (from.line == to.line && change.text.length == 1 && !isWholeLineUpdate(cm.doc, change))
    { regLineChange(cm, from.line, "text"); }
  else
    { regChange(cm, from.line, to.line + 1, lendiff); }

  var changesHandler = hasHandler(cm, "changes"), changeHandler = hasHandler(cm, "change");
  if (changeHandler || changesHandler) {
    var obj = {
      from: from, to: to,
      text: change.text,
      removed: change.removed,
      origin: change.origin
    };
    if (changeHandler) { signalLater(cm, "change", cm, obj); }
    if (changesHandler) { (cm.curOp.changeObjs || (cm.curOp.changeObjs = [])).push(obj); }
  }
  cm.display.selForContextMenu = null;
}

function replaceRange(doc, code, from, to, origin) {
  if (!to) { to = from; }
  if (cmp(to, from) < 0) { var assign;
    (assign = [to, from], from = assign[0], to = assign[1]); }
  if (typeof code == "string") { code = doc.splitLines(code); }
  makeChange(doc, {from: from, to: to, text: code, origin: origin});
}

// Rebasing/resetting history to deal with externally-sourced changes

function rebaseHistSelSingle(pos, from, to, diff) {
  if (to < pos.line) {
    pos.line += diff;
  } else if (from < pos.line) {
    pos.line = from;
    pos.ch = 0;
  }
}

// Tries to rebase an array of history events given a change in the
// document. If the change touches the same lines as the event, the
// event, and everything 'behind' it, is discarded. If the change is
// before the event, the event's positions are updated. Uses a
// copy-on-write scheme for the positions, to avoid having to
// reallocate them all on every rebase, but also avoid problems with
// shared position objects being unsafely updated.
function rebaseHistArray(array, from, to, diff) {
  for (var i = 0; i < array.length; ++i) {
    var sub = array[i], ok = true;
    if (sub.ranges) {
      if (!sub.copied) { sub = array[i] = sub.deepCopy(); sub.copied = true; }
      for (var j = 0; j < sub.ranges.length; j++) {
        rebaseHistSelSingle(sub.ranges[j].anchor, from, to, diff);
        rebaseHistSelSingle(sub.ranges[j].head, from, to, diff);
      }
      continue
    }
    for (var j$1 = 0; j$1 < sub.changes.length; ++j$1) {
      var cur = sub.changes[j$1];
      if (to < cur.from.line) {
        cur.from = Pos(cur.from.line + diff, cur.from.ch);
        cur.to = Pos(cur.to.line + diff, cur.to.ch);
      } else if (from <= cur.to.line) {
        ok = false;
        break
      }
    }
    if (!ok) {
      array.splice(0, i + 1);
      i = 0;
    }
  }
}

function rebaseHist(hist, change) {
  var from = change.from.line, to = change.to.line, diff = change.text.length - (to - from) - 1;
  rebaseHistArray(hist.done, from, to, diff);
  rebaseHistArray(hist.undone, from, to, diff);
}

// Utility for applying a change to a line by handle or number,
// returning the number and optionally registering the line as
// changed.
function changeLine(doc, handle, changeType, op) {
  var no = handle, line = handle;
  if (typeof handle == "number") { line = getLine(doc, clipLine(doc, handle)); }
  else { no = lineNo(handle); }
  if (no == null) { return null }
  if (op(line, no) && doc.cm) { regLineChange(doc.cm, no, changeType); }
  return line
}

// The document is represented as a BTree consisting of leaves, with
// chunk of lines in them, and branches, with up to ten leaves or
// other branch nodes below them. The top node is always a branch
// node, and is the document object itself (meaning it has
// additional methods and properties).
//
// All nodes have parent links. The tree is used both to go from
// line numbers to line objects, and to go from objects to numbers.
// It also indexes by height, and is used to convert between height
// and line object, and to find the total height of the document.
//
// See also http://marijnhaverbeke.nl/blog/codemirror-line-tree.html

function LeafChunk(lines) {
  var this$1 = this;

  this.lines = lines;
  this.parent = null;
  var height = 0;
  for (var i = 0; i < lines.length; ++i) {
    lines[i].parent = this$1;
    height += lines[i].height;
  }
  this.height = height;
}

LeafChunk.prototype = {
  chunkSize: function() { return this.lines.length },

  // Remove the n lines at offset 'at'.
  removeInner: function(at, n) {
    var this$1 = this;

    for (var i = at, e = at + n; i < e; ++i) {
      var line = this$1.lines[i];
      this$1.height -= line.height;
      cleanUpLine(line);
      signalLater(line, "delete");
    }
    this.lines.splice(at, n);
  },

  // Helper used to collapse a small branch into a single leaf.
  collapse: function(lines) {
    lines.push.apply(lines, this.lines);
  },

  // Insert the given array of lines at offset 'at', count them as
  // having the given height.
  insertInner: function(at, lines, height) {
    var this$1 = this;

    this.height += height;
    this.lines = this.lines.slice(0, at).concat(lines).concat(this.lines.slice(at));
    for (var i = 0; i < lines.length; ++i) { lines[i].parent = this$1; }
  },

  // Used to iterate over a part of the tree.
  iterN: function(at, n, op) {
    var this$1 = this;

    for (var e = at + n; at < e; ++at)
      { if (op(this$1.lines[at])) { return true } }
  }
};

function BranchChunk(children) {
  var this$1 = this;

  this.children = children;
  var size = 0, height = 0;
  for (var i = 0; i < children.length; ++i) {
    var ch = children[i];
    size += ch.chunkSize(); height += ch.height;
    ch.parent = this$1;
  }
  this.size = size;
  this.height = height;
  this.parent = null;
}

BranchChunk.prototype = {
  chunkSize: function() { return this.size },

  removeInner: function(at, n) {
    var this$1 = this;

    this.size -= n;
    for (var i = 0; i < this.children.length; ++i) {
      var child = this$1.children[i], sz = child.chunkSize();
      if (at < sz) {
        var rm = Math.min(n, sz - at), oldHeight = child.height;
        child.removeInner(at, rm);
        this$1.height -= oldHeight - child.height;
        if (sz == rm) { this$1.children.splice(i--, 1); child.parent = null; }
        if ((n -= rm) == 0) { break }
        at = 0;
      } else { at -= sz; }
    }
    // If the result is smaller than 25 lines, ensure that it is a
    // single leaf node.
    if (this.size - n < 25 &&
        (this.children.length > 1 || !(this.children[0] instanceof LeafChunk))) {
      var lines = [];
      this.collapse(lines);
      this.children = [new LeafChunk(lines)];
      this.children[0].parent = this;
    }
  },

  collapse: function(lines) {
    var this$1 = this;

    for (var i = 0; i < this.children.length; ++i) { this$1.children[i].collapse(lines); }
  },

  insertInner: function(at, lines, height) {
    var this$1 = this;

    this.size += lines.length;
    this.height += height;
    for (var i = 0; i < this.children.length; ++i) {
      var child = this$1.children[i], sz = child.chunkSize();
      if (at <= sz) {
        child.insertInner(at, lines, height);
        if (child.lines && child.lines.length > 50) {
          // To avoid memory thrashing when child.lines is huge (e.g. first view of a large file), it's never spliced.
          // Instead, small slices are taken. They're taken in order because sequential memory accesses are fastest.
          var remaining = child.lines.length % 25 + 25;
          for (var pos = remaining; pos < child.lines.length;) {
            var leaf = new LeafChunk(child.lines.slice(pos, pos += 25));
            child.height -= leaf.height;
            this$1.children.splice(++i, 0, leaf);
            leaf.parent = this$1;
          }
          child.lines = child.lines.slice(0, remaining);
          this$1.maybeSpill();
        }
        break
      }
      at -= sz;
    }
  },

  // When a node has grown, check whether it should be split.
  maybeSpill: function() {
    if (this.children.length <= 10) { return }
    var me = this;
    do {
      var spilled = me.children.splice(me.children.length - 5, 5);
      var sibling = new BranchChunk(spilled);
      if (!me.parent) { // Become the parent node
        var copy = new BranchChunk(me.children);
        copy.parent = me;
        me.children = [copy, sibling];
        me = copy;
     } else {
        me.size -= sibling.size;
        me.height -= sibling.height;
        var myIndex = indexOf(me.parent.children, me);
        me.parent.children.splice(myIndex + 1, 0, sibling);
      }
      sibling.parent = me.parent;
    } while (me.children.length > 10)
    me.parent.maybeSpill();
  },

  iterN: function(at, n, op) {
    var this$1 = this;

    for (var i = 0; i < this.children.length; ++i) {
      var child = this$1.children[i], sz = child.chunkSize();
      if (at < sz) {
        var used = Math.min(n, sz - at);
        if (child.iterN(at, used, op)) { return true }
        if ((n -= used) == 0) { break }
        at = 0;
      } else { at -= sz; }
    }
  }
};

// Line widgets are block elements displayed above or below a line.

var LineWidget = function(doc, node, options) {
  var this$1 = this;

  if (options) { for (var opt in options) { if (options.hasOwnProperty(opt))
    { this$1[opt] = options[opt]; } } }
  this.doc = doc;
  this.node = node;
};

LineWidget.prototype.clear = function () {
    var this$1 = this;

  var cm = this.doc.cm, ws = this.line.widgets, line = this.line, no = lineNo(line);
  if (no == null || !ws) { return }
  for (var i = 0; i < ws.length; ++i) { if (ws[i] == this$1) { ws.splice(i--, 1); } }
  if (!ws.length) { line.widgets = null; }
  var height = widgetHeight(this);
  updateLineHeight(line, Math.max(0, line.height - height));
  if (cm) {
    runInOp(cm, function () {
      adjustScrollWhenAboveVisible(cm, line, -height);
      regLineChange(cm, no, "widget");
    });
    signalLater(cm, "lineWidgetCleared", cm, this, no);
  }
};

LineWidget.prototype.changed = function () {
    var this$1 = this;

  var oldH = this.height, cm = this.doc.cm, line = this.line;
  this.height = null;
  var diff = widgetHeight(this) - oldH;
  if (!diff) { return }
  if (!lineIsHidden(this.doc, line)) { updateLineHeight(line, line.height + diff); }
  if (cm) {
    runInOp(cm, function () {
      cm.curOp.forceUpdate = true;
      adjustScrollWhenAboveVisible(cm, line, diff);
      signalLater(cm, "lineWidgetChanged", cm, this$1, lineNo(line));
    });
  }
};
eventMixin(LineWidget);

function adjustScrollWhenAboveVisible(cm, line, diff) {
  if (heightAtLine(line) < ((cm.curOp && cm.curOp.scrollTop) || cm.doc.scrollTop))
    { addToScrollTop(cm, diff); }
}

function addLineWidget(doc, handle, node, options) {
  var widget = new LineWidget(doc, node, options);
  var cm = doc.cm;
  if (cm && widget.noHScroll) { cm.display.alignWidgets = true; }
  changeLine(doc, handle, "widget", function (line) {
    var widgets = line.widgets || (line.widgets = []);
    if (widget.insertAt == null) { widgets.push(widget); }
    else { widgets.splice(Math.min(widgets.length - 1, Math.max(0, widget.insertAt)), 0, widget); }
    widget.line = line;
    if (cm && !lineIsHidden(doc, line)) {
      var aboveVisible = heightAtLine(line) < doc.scrollTop;
      updateLineHeight(line, line.height + widgetHeight(widget));
      if (aboveVisible) { addToScrollTop(cm, widget.height); }
      cm.curOp.forceUpdate = true;
    }
    return true
  });
  if (cm) { signalLater(cm, "lineWidgetAdded", cm, widget, typeof handle == "number" ? handle : lineNo(handle)); }
  return widget
}

// TEXTMARKERS

// Created with markText and setBookmark methods. A TextMarker is a
// handle that can be used to clear or find a marked position in the
// document. Line objects hold arrays (markedSpans) containing
// {from, to, marker} object pointing to such marker objects, and
// indicating that such a marker is present on that line. Multiple
// lines may point to the same marker when it spans across lines.
// The spans will have null for their from/to properties when the
// marker continues beyond the start/end of the line. Markers have
// links back to the lines they currently touch.

// Collapsed markers have unique ids, in order to be able to order
// them, which is needed for uniquely determining an outer marker
// when they overlap (they may nest, but not partially overlap).
var nextMarkerId = 0;

var TextMarker = function(doc, type) {
  this.lines = [];
  this.type = type;
  this.doc = doc;
  this.id = ++nextMarkerId;
};

// Clear the marker.
TextMarker.prototype.clear = function () {
    var this$1 = this;

  if (this.explicitlyCleared) { return }
  var cm = this.doc.cm, withOp = cm && !cm.curOp;
  if (withOp) { startOperation(cm); }
  if (hasHandler(this, "clear")) {
    var found = this.find();
    if (found) { signalLater(this, "clear", found.from, found.to); }
  }
  var min = null, max = null;
  for (var i = 0; i < this.lines.length; ++i) {
    var line = this$1.lines[i];
    var span = getMarkedSpanFor(line.markedSpans, this$1);
    if (cm && !this$1.collapsed) { regLineChange(cm, lineNo(line), "text"); }
    else if (cm) {
      if (span.to != null) { max = lineNo(line); }
      if (span.from != null) { min = lineNo(line); }
    }
    line.markedSpans = removeMarkedSpan(line.markedSpans, span);
    if (span.from == null && this$1.collapsed && !lineIsHidden(this$1.doc, line) && cm)
      { updateLineHeight(line, textHeight(cm.display)); }
  }
  if (cm && this.collapsed && !cm.options.lineWrapping) { for (var i$1 = 0; i$1 < this.lines.length; ++i$1) {
    var visual = visualLine(this$1.lines[i$1]), len = lineLength(visual);
    if (len > cm.display.maxLineLength) {
      cm.display.maxLine = visual;
      cm.display.maxLineLength = len;
      cm.display.maxLineChanged = true;
    }
  } }

  if (min != null && cm && this.collapsed) { regChange(cm, min, max + 1); }
  this.lines.length = 0;
  this.explicitlyCleared = true;
  if (this.atomic && this.doc.cantEdit) {
    this.doc.cantEdit = false;
    if (cm) { reCheckSelection(cm.doc); }
  }
  if (cm) { signalLater(cm, "markerCleared", cm, this, min, max); }
  if (withOp) { endOperation(cm); }
  if (this.parent) { this.parent.clear(); }
};

// Find the position of the marker in the document. Returns a {from,
// to} object by default. Side can be passed to get a specific side
// -- 0 (both), -1 (left), or 1 (right). When lineObj is true, the
// Pos objects returned contain a line object, rather than a line
// number (used to prevent looking up the same line twice).
TextMarker.prototype.find = function (side, lineObj) {
    var this$1 = this;

  if (side == null && this.type == "bookmark") { side = 1; }
  var from, to;
  for (var i = 0; i < this.lines.length; ++i) {
    var line = this$1.lines[i];
    var span = getMarkedSpanFor(line.markedSpans, this$1);
    if (span.from != null) {
      from = Pos(lineObj ? line : lineNo(line), span.from);
      if (side == -1) { return from }
    }
    if (span.to != null) {
      to = Pos(lineObj ? line : lineNo(line), span.to);
      if (side == 1) { return to }
    }
  }
  return from && {from: from, to: to}
};

// Signals that the marker's widget changed, and surrounding layout
// should be recomputed.
TextMarker.prototype.changed = function () {
    var this$1 = this;

  var pos = this.find(-1, true), widget = this, cm = this.doc.cm;
  if (!pos || !cm) { return }
  runInOp(cm, function () {
    var line = pos.line, lineN = lineNo(pos.line);
    var view = findViewForLine(cm, lineN);
    if (view) {
      clearLineMeasurementCacheFor(view);
      cm.curOp.selectionChanged = cm.curOp.forceUpdate = true;
    }
    cm.curOp.updateMaxLine = true;
    if (!lineIsHidden(widget.doc, line) && widget.height != null) {
      var oldHeight = widget.height;
      widget.height = null;
      var dHeight = widgetHeight(widget) - oldHeight;
      if (dHeight)
        { updateLineHeight(line, line.height + dHeight); }
    }
    signalLater(cm, "markerChanged", cm, this$1);
  });
};

TextMarker.prototype.attachLine = function (line) {
  if (!this.lines.length && this.doc.cm) {
    var op = this.doc.cm.curOp;
    if (!op.maybeHiddenMarkers || indexOf(op.maybeHiddenMarkers, this) == -1)
      { (op.maybeUnhiddenMarkers || (op.maybeUnhiddenMarkers = [])).push(this); }
  }
  this.lines.push(line);
};

TextMarker.prototype.detachLine = function (line) {
  this.lines.splice(indexOf(this.lines, line), 1);
  if (!this.lines.length && this.doc.cm) {
    var op = this.doc.cm.curOp;(op.maybeHiddenMarkers || (op.maybeHiddenMarkers = [])).push(this);
  }
};
eventMixin(TextMarker);

// Create a marker, wire it up to the right lines, and
function markText(doc, from, to, options, type) {
  // Shared markers (across linked documents) are handled separately
  // (markTextShared will call out to this again, once per
  // document).
  if (options && options.shared) { return markTextShared(doc, from, to, options, type) }
  // Ensure we are in an operation.
  if (doc.cm && !doc.cm.curOp) { return operation(doc.cm, markText)(doc, from, to, options, type) }

  var marker = new TextMarker(doc, type), diff = cmp(from, to);
  if (options) { copyObj(options, marker, false); }
  // Don't connect empty markers unless clearWhenEmpty is false
  if (diff > 0 || diff == 0 && marker.clearWhenEmpty !== false)
    { return marker }
  if (marker.replacedWith) {
    // Showing up as a widget implies collapsed (widget replaces text)
    marker.collapsed = true;
    marker.widgetNode = eltP("span", [marker.replacedWith], "CodeMirror-widget");
    if (!options.handleMouseEvents) { marker.widgetNode.setAttribute("cm-ignore-events", "true"); }
    if (options.insertLeft) { marker.widgetNode.insertLeft = true; }
  }
  if (marker.collapsed) {
    if (conflictingCollapsedRange(doc, from.line, from, to, marker) ||
        from.line != to.line && conflictingCollapsedRange(doc, to.line, from, to, marker))
      { throw new Error("Inserting collapsed marker partially overlapping an existing one") }
    seeCollapsedSpans();
  }

  if (marker.addToHistory)
    { addChangeToHistory(doc, {from: from, to: to, origin: "markText"}, doc.sel, NaN); }

  var curLine = from.line, cm = doc.cm, updateMaxLine;
  doc.iter(curLine, to.line + 1, function (line) {
    if (cm && marker.collapsed && !cm.options.lineWrapping && visualLine(line) == cm.display.maxLine)
      { updateMaxLine = true; }
    if (marker.collapsed && curLine != from.line) { updateLineHeight(line, 0); }
    addMarkedSpan(line, new MarkedSpan(marker,
                                       curLine == from.line ? from.ch : null,
                                       curLine == to.line ? to.ch : null));
    ++curLine;
  });
  // lineIsHidden depends on the presence of the spans, so needs a second pass
  if (marker.collapsed) { doc.iter(from.line, to.line + 1, function (line) {
    if (lineIsHidden(doc, line)) { updateLineHeight(line, 0); }
  }); }

  if (marker.clearOnEnter) { on(marker, "beforeCursorEnter", function () { return marker.clear(); }); }

  if (marker.readOnly) {
    seeReadOnlySpans();
    if (doc.history.done.length || doc.history.undone.length)
      { doc.clearHistory(); }
  }
  if (marker.collapsed) {
    marker.id = ++nextMarkerId;
    marker.atomic = true;
  }
  if (cm) {
    // Sync editor state
    if (updateMaxLine) { cm.curOp.updateMaxLine = true; }
    if (marker.collapsed)
      { regChange(cm, from.line, to.line + 1); }
    else if (marker.className || marker.title || marker.startStyle || marker.endStyle || marker.css)
      { for (var i = from.line; i <= to.line; i++) { regLineChange(cm, i, "text"); } }
    if (marker.atomic) { reCheckSelection(cm.doc); }
    signalLater(cm, "markerAdded", cm, marker);
  }
  return marker
}

// SHARED TEXTMARKERS

// A shared marker spans multiple linked documents. It is
// implemented as a meta-marker-object controlling multiple normal
// markers.
var SharedTextMarker = function(markers, primary) {
  var this$1 = this;

  this.markers = markers;
  this.primary = primary;
  for (var i = 0; i < markers.length; ++i)
    { markers[i].parent = this$1; }
};

SharedTextMarker.prototype.clear = function () {
    var this$1 = this;

  if (this.explicitlyCleared) { return }
  this.explicitlyCleared = true;
  for (var i = 0; i < this.markers.length; ++i)
    { this$1.markers[i].clear(); }
  signalLater(this, "clear");
};

SharedTextMarker.prototype.find = function (side, lineObj) {
  return this.primary.find(side, lineObj)
};
eventMixin(SharedTextMarker);

function markTextShared(doc, from, to, options, type) {
  options = copyObj(options);
  options.shared = false;
  var markers = [markText(doc, from, to, options, type)], primary = markers[0];
  var widget = options.widgetNode;
  linkedDocs(doc, function (doc) {
    if (widget) { options.widgetNode = widget.cloneNode(true); }
    markers.push(markText(doc, clipPos(doc, from), clipPos(doc, to), options, type));
    for (var i = 0; i < doc.linked.length; ++i)
      { if (doc.linked[i].isParent) { return } }
    primary = lst(markers);
  });
  return new SharedTextMarker(markers, primary)
}

function findSharedMarkers(doc) {
  return doc.findMarks(Pos(doc.first, 0), doc.clipPos(Pos(doc.lastLine())), function (m) { return m.parent; })
}

function copySharedMarkers(doc, markers) {
  for (var i = 0; i < markers.length; i++) {
    var marker = markers[i], pos = marker.find();
    var mFrom = doc.clipPos(pos.from), mTo = doc.clipPos(pos.to);
    if (cmp(mFrom, mTo)) {
      var subMark = markText(doc, mFrom, mTo, marker.primary, marker.primary.type);
      marker.markers.push(subMark);
      subMark.parent = marker;
    }
  }
}

function detachSharedMarkers(markers) {
  var loop = function ( i ) {
    var marker = markers[i], linked = [marker.primary.doc];
    linkedDocs(marker.primary.doc, function (d) { return linked.push(d); });
    for (var j = 0; j < marker.markers.length; j++) {
      var subMarker = marker.markers[j];
      if (indexOf(linked, subMarker.doc) == -1) {
        subMarker.parent = null;
        marker.markers.splice(j--, 1);
      }
    }
  };

  for (var i = 0; i < markers.length; i++) loop( i );
}

var nextDocId = 0;
var Doc = function(text, mode, firstLine, lineSep, direction) {
  if (!(this instanceof Doc)) { return new Doc(text, mode, firstLine, lineSep, direction) }
  if (firstLine == null) { firstLine = 0; }

  BranchChunk.call(this, [new LeafChunk([new Line("", null)])]);
  this.first = firstLine;
  this.scrollTop = this.scrollLeft = 0;
  this.cantEdit = false;
  this.cleanGeneration = 1;
  this.modeFrontier = this.highlightFrontier = firstLine;
  var start = Pos(firstLine, 0);
  this.sel = simpleSelection(start);
  this.history = new History(null);
  this.id = ++nextDocId;
  this.modeOption = mode;
  this.lineSep = lineSep;
  this.direction = (direction == "rtl") ? "rtl" : "ltr";
  this.extend = false;

  if (typeof text == "string") { text = this.splitLines(text); }
  updateDoc(this, {from: start, to: start, text: text});
  setSelection(this, simpleSelection(start), sel_dontScroll);
};

Doc.prototype = createObj(BranchChunk.prototype, {
  constructor: Doc,
  // Iterate over the document. Supports two forms -- with only one
  // argument, it calls that for each line in the document. With
  // three, it iterates over the range given by the first two (with
  // the second being non-inclusive).
  iter: function(from, to, op) {
    if (op) { this.iterN(from - this.first, to - from, op); }
    else { this.iterN(this.first, this.first + this.size, from); }
  },

  // Non-public interface for adding and removing lines.
  insert: function(at, lines) {
    var height = 0;
    for (var i = 0; i < lines.length; ++i) { height += lines[i].height; }
    this.insertInner(at - this.first, lines, height);
  },
  remove: function(at, n) { this.removeInner(at - this.first, n); },

  // From here, the methods are part of the public interface. Most
  // are also available from CodeMirror (editor) instances.

  getValue: function(lineSep) {
    var lines = getLines(this, this.first, this.first + this.size);
    if (lineSep === false) { return lines }
    return lines.join(lineSep || this.lineSeparator())
  },
  setValue: docMethodOp(function(code) {
    var top = Pos(this.first, 0), last = this.first + this.size - 1;
    makeChange(this, {from: top, to: Pos(last, getLine(this, last).text.length),
                      text: this.splitLines(code), origin: "setValue", full: true}, true);
    if (this.cm) { scrollToCoords(this.cm, 0, 0); }
    setSelection(this, simpleSelection(top), sel_dontScroll);
  }),
  replaceRange: function(code, from, to, origin) {
    from = clipPos(this, from);
    to = to ? clipPos(this, to) : from;
    replaceRange(this, code, from, to, origin);
  },
  getRange: function(from, to, lineSep) {
    var lines = getBetween(this, clipPos(this, from), clipPos(this, to));
    if (lineSep === false) { return lines }
    return lines.join(lineSep || this.lineSeparator())
  },

  getLine: function(line) {var l = this.getLineHandle(line); return l && l.text},

  getLineHandle: function(line) {if (isLine(this, line)) { return getLine(this, line) }},
  getLineNumber: function(line) {return lineNo(line)},

  getLineHandleVisualStart: function(line) {
    if (typeof line == "number") { line = getLine(this, line); }
    return visualLine(line)
  },

  lineCount: function() {return this.size},
  firstLine: function() {return this.first},
  lastLine: function() {return this.first + this.size - 1},

  clipPos: function(pos) {return clipPos(this, pos)},

  getCursor: function(start) {
    var range$$1 = this.sel.primary(), pos;
    if (start == null || start == "head") { pos = range$$1.head; }
    else if (start == "anchor") { pos = range$$1.anchor; }
    else if (start == "end" || start == "to" || start === false) { pos = range$$1.to(); }
    else { pos = range$$1.from(); }
    return pos
  },
  listSelections: function() { return this.sel.ranges },
  somethingSelected: function() {return this.sel.somethingSelected()},

  setCursor: docMethodOp(function(line, ch, options) {
    setSimpleSelection(this, clipPos(this, typeof line == "number" ? Pos(line, ch || 0) : line), null, options);
  }),
  setSelection: docMethodOp(function(anchor, head, options) {
    setSimpleSelection(this, clipPos(this, anchor), clipPos(this, head || anchor), options);
  }),
  extendSelection: docMethodOp(function(head, other, options) {
    extendSelection(this, clipPos(this, head), other && clipPos(this, other), options);
  }),
  extendSelections: docMethodOp(function(heads, options) {
    extendSelections(this, clipPosArray(this, heads), options);
  }),
  extendSelectionsBy: docMethodOp(function(f, options) {
    var heads = map(this.sel.ranges, f);
    extendSelections(this, clipPosArray(this, heads), options);
  }),
  setSelections: docMethodOp(function(ranges, primary, options) {
    var this$1 = this;

    if (!ranges.length) { return }
    var out = [];
    for (var i = 0; i < ranges.length; i++)
      { out[i] = new Range(clipPos(this$1, ranges[i].anchor),
                         clipPos(this$1, ranges[i].head)); }
    if (primary == null) { primary = Math.min(ranges.length - 1, this.sel.primIndex); }
    setSelection(this, normalizeSelection(out, primary), options);
  }),
  addSelection: docMethodOp(function(anchor, head, options) {
    var ranges = this.sel.ranges.slice(0);
    ranges.push(new Range(clipPos(this, anchor), clipPos(this, head || anchor)));
    setSelection(this, normalizeSelection(ranges, ranges.length - 1), options);
  }),

  getSelection: function(lineSep) {
    var this$1 = this;

    var ranges = this.sel.ranges, lines;
    for (var i = 0; i < ranges.length; i++) {
      var sel = getBetween(this$1, ranges[i].from(), ranges[i].to());
      lines = lines ? lines.concat(sel) : sel;
    }
    if (lineSep === false) { return lines }
    else { return lines.join(lineSep || this.lineSeparator()) }
  },
  getSelections: function(lineSep) {
    var this$1 = this;

    var parts = [], ranges = this.sel.ranges;
    for (var i = 0; i < ranges.length; i++) {
      var sel = getBetween(this$1, ranges[i].from(), ranges[i].to());
      if (lineSep !== false) { sel = sel.join(lineSep || this$1.lineSeparator()); }
      parts[i] = sel;
    }
    return parts
  },
  replaceSelection: function(code, collapse, origin) {
    var dup = [];
    for (var i = 0; i < this.sel.ranges.length; i++)
      { dup[i] = code; }
    this.replaceSelections(dup, collapse, origin || "+input");
  },
  replaceSelections: docMethodOp(function(code, collapse, origin) {
    var this$1 = this;

    var changes = [], sel = this.sel;
    for (var i = 0; i < sel.ranges.length; i++) {
      var range$$1 = sel.ranges[i];
      changes[i] = {from: range$$1.from(), to: range$$1.to(), text: this$1.splitLines(code[i]), origin: origin};
    }
    var newSel = collapse && collapse != "end" && computeReplacedSel(this, changes, collapse);
    for (var i$1 = changes.length - 1; i$1 >= 0; i$1--)
      { makeChange(this$1, changes[i$1]); }
    if (newSel) { setSelectionReplaceHistory(this, newSel); }
    else if (this.cm) { ensureCursorVisible(this.cm); }
  }),
  undo: docMethodOp(function() {makeChangeFromHistory(this, "undo");}),
  redo: docMethodOp(function() {makeChangeFromHistory(this, "redo");}),
  undoSelection: docMethodOp(function() {makeChangeFromHistory(this, "undo", true);}),
  redoSelection: docMethodOp(function() {makeChangeFromHistory(this, "redo", true);}),

  setExtending: function(val) {this.extend = val;},
  getExtending: function() {return this.extend},

  historySize: function() {
    var hist = this.history, done = 0, undone = 0;
    for (var i = 0; i < hist.done.length; i++) { if (!hist.done[i].ranges) { ++done; } }
    for (var i$1 = 0; i$1 < hist.undone.length; i$1++) { if (!hist.undone[i$1].ranges) { ++undone; } }
    return {undo: done, redo: undone}
  },
  clearHistory: function() {this.history = new History(this.history.maxGeneration);},

  markClean: function() {
    this.cleanGeneration = this.changeGeneration(true);
  },
  changeGeneration: function(forceSplit) {
    if (forceSplit)
      { this.history.lastOp = this.history.lastSelOp = this.history.lastOrigin = null; }
    return this.history.generation
  },
  isClean: function (gen) {
    return this.history.generation == (gen || this.cleanGeneration)
  },

  getHistory: function() {
    return {done: copyHistoryArray(this.history.done),
            undone: copyHistoryArray(this.history.undone)}
  },
  setHistory: function(histData) {
    var hist = this.history = new History(this.history.maxGeneration);
    hist.done = copyHistoryArray(histData.done.slice(0), null, true);
    hist.undone = copyHistoryArray(histData.undone.slice(0), null, true);
  },

  setGutterMarker: docMethodOp(function(line, gutterID, value) {
    return changeLine(this, line, "gutter", function (line) {
      var markers = line.gutterMarkers || (line.gutterMarkers = {});
      markers[gutterID] = value;
      if (!value && isEmpty(markers)) { line.gutterMarkers = null; }
      return true
    })
  }),

  clearGutter: docMethodOp(function(gutterID) {
    var this$1 = this;

    this.iter(function (line) {
      if (line.gutterMarkers && line.gutterMarkers[gutterID]) {
        changeLine(this$1, line, "gutter", function () {
          line.gutterMarkers[gutterID] = null;
          if (isEmpty(line.gutterMarkers)) { line.gutterMarkers = null; }
          return true
        });
      }
    });
  }),

  lineInfo: function(line) {
    var n;
    if (typeof line == "number") {
      if (!isLine(this, line)) { return null }
      n = line;
      line = getLine(this, line);
      if (!line) { return null }
    } else {
      n = lineNo(line);
      if (n == null) { return null }
    }
    return {line: n, handle: line, text: line.text, gutterMarkers: line.gutterMarkers,
            textClass: line.textClass, bgClass: line.bgClass, wrapClass: line.wrapClass,
            widgets: line.widgets}
  },

  addLineClass: docMethodOp(function(handle, where, cls) {
    return changeLine(this, handle, where == "gutter" ? "gutter" : "class", function (line) {
      var prop = where == "text" ? "textClass"
               : where == "background" ? "bgClass"
               : where == "gutter" ? "gutterClass" : "wrapClass";
      if (!line[prop]) { line[prop] = cls; }
      else if (classTest(cls).test(line[prop])) { return false }
      else { line[prop] += " " + cls; }
      return true
    })
  }),
  removeLineClass: docMethodOp(function(handle, where, cls) {
    return changeLine(this, handle, where == "gutter" ? "gutter" : "class", function (line) {
      var prop = where == "text" ? "textClass"
               : where == "background" ? "bgClass"
               : where == "gutter" ? "gutterClass" : "wrapClass";
      var cur = line[prop];
      if (!cur) { return false }
      else if (cls == null) { line[prop] = null; }
      else {
        var found = cur.match(classTest(cls));
        if (!found) { return false }
        var end = found.index + found[0].length;
        line[prop] = cur.slice(0, found.index) + (!found.index || end == cur.length ? "" : " ") + cur.slice(end) || null;
      }
      return true
    })
  }),

  addLineWidget: docMethodOp(function(handle, node, options) {
    return addLineWidget(this, handle, node, options)
  }),
  removeLineWidget: function(widget) { widget.clear(); },

  markText: function(from, to, options) {
    return markText(this, clipPos(this, from), clipPos(this, to), options, options && options.type || "range")
  },
  setBookmark: function(pos, options) {
    var realOpts = {replacedWith: options && (options.nodeType == null ? options.widget : options),
                    insertLeft: options && options.insertLeft,
                    clearWhenEmpty: false, shared: options && options.shared,
                    handleMouseEvents: options && options.handleMouseEvents};
    pos = clipPos(this, pos);
    return markText(this, pos, pos, realOpts, "bookmark")
  },
  findMarksAt: function(pos) {
    pos = clipPos(this, pos);
    var markers = [], spans = getLine(this, pos.line).markedSpans;
    if (spans) { for (var i = 0; i < spans.length; ++i) {
      var span = spans[i];
      if ((span.from == null || span.from <= pos.ch) &&
          (span.to == null || span.to >= pos.ch))
        { markers.push(span.marker.parent || span.marker); }
    } }
    return markers
  },
  findMarks: function(from, to, filter) {
    from = clipPos(this, from); to = clipPos(this, to);
    var found = [], lineNo$$1 = from.line;
    this.iter(from.line, to.line + 1, function (line) {
      var spans = line.markedSpans;
      if (spans) { for (var i = 0; i < spans.length; i++) {
        var span = spans[i];
        if (!(span.to != null && lineNo$$1 == from.line && from.ch >= span.to ||
              span.from == null && lineNo$$1 != from.line ||
              span.from != null && lineNo$$1 == to.line && span.from >= to.ch) &&
            (!filter || filter(span.marker)))
          { found.push(span.marker.parent || span.marker); }
      } }
      ++lineNo$$1;
    });
    return found
  },
  getAllMarks: function() {
    var markers = [];
    this.iter(function (line) {
      var sps = line.markedSpans;
      if (sps) { for (var i = 0; i < sps.length; ++i)
        { if (sps[i].from != null) { markers.push(sps[i].marker); } } }
    });
    return markers
  },

  posFromIndex: function(off) {
    var ch, lineNo$$1 = this.first, sepSize = this.lineSeparator().length;
    this.iter(function (line) {
      var sz = line.text.length + sepSize;
      if (sz > off) { ch = off; return true }
      off -= sz;
      ++lineNo$$1;
    });
    return clipPos(this, Pos(lineNo$$1, ch))
  },
  indexFromPos: function (coords) {
    coords = clipPos(this, coords);
    var index = coords.ch;
    if (coords.line < this.first || coords.ch < 0) { return 0 }
    var sepSize = this.lineSeparator().length;
    this.iter(this.first, coords.line, function (line) { // iter aborts when callback returns a truthy value
      index += line.text.length + sepSize;
    });
    return index
  },

  copy: function(copyHistory) {
    var doc = new Doc(getLines(this, this.first, this.first + this.size),
                      this.modeOption, this.first, this.lineSep, this.direction);
    doc.scrollTop = this.scrollTop; doc.scrollLeft = this.scrollLeft;
    doc.sel = this.sel;
    doc.extend = false;
    if (copyHistory) {
      doc.history.undoDepth = this.history.undoDepth;
      doc.setHistory(this.getHistory());
    }
    return doc
  },

  linkedDoc: function(options) {
    if (!options) { options = {}; }
    var from = this.first, to = this.first + this.size;
    if (options.from != null && options.from > from) { from = options.from; }
    if (options.to != null && options.to < to) { to = options.to; }
    var copy = new Doc(getLines(this, from, to), options.mode || this.modeOption, from, this.lineSep, this.direction);
    if (options.sharedHist) { copy.history = this.history
    ; }(this.linked || (this.linked = [])).push({doc: copy, sharedHist: options.sharedHist});
    copy.linked = [{doc: this, isParent: true, sharedHist: options.sharedHist}];
    copySharedMarkers(copy, findSharedMarkers(this));
    return copy
  },
  unlinkDoc: function(other) {
    var this$1 = this;

    if (other instanceof CodeMirror$1) { other = other.doc; }
    if (this.linked) { for (var i = 0; i < this.linked.length; ++i) {
      var link = this$1.linked[i];
      if (link.doc != other) { continue }
      this$1.linked.splice(i, 1);
      other.unlinkDoc(this$1);
      detachSharedMarkers(findSharedMarkers(this$1));
      break
    } }
    // If the histories were shared, split them again
    if (other.history == this.history) {
      var splitIds = [other.id];
      linkedDocs(other, function (doc) { return splitIds.push(doc.id); }, true);
      other.history = new History(null);
      other.history.done = copyHistoryArray(this.history.done, splitIds);
      other.history.undone = copyHistoryArray(this.history.undone, splitIds);
    }
  },
  iterLinkedDocs: function(f) {linkedDocs(this, f);},

  getMode: function() {return this.mode},
  getEditor: function() {return this.cm},

  splitLines: function(str) {
    if (this.lineSep) { return str.split(this.lineSep) }
    return splitLinesAuto(str)
  },
  lineSeparator: function() { return this.lineSep || "\n" },

  setDirection: docMethodOp(function (dir) {
    if (dir != "rtl") { dir = "ltr"; }
    if (dir == this.direction) { return }
    this.direction = dir;
    this.iter(function (line) { return line.order = null; });
    if (this.cm) { directionChanged(this.cm); }
  })
});

// Public alias.
Doc.prototype.eachLine = Doc.prototype.iter;

// Kludge to work around strange IE behavior where it'll sometimes
// re-fire a series of drag-related events right after the drop (#1551)
var lastDrop = 0;

function onDrop(e) {
  var cm = this;
  clearDragCursor(cm);
  if (signalDOMEvent(cm, e) || eventInWidget(cm.display, e))
    { return }
  e_preventDefault(e);
  if (ie) { lastDrop = +new Date; }
  var pos = posFromMouse(cm, e, true), files = e.dataTransfer.files;
  if (!pos || cm.isReadOnly()) { return }
  // Might be a file drop, in which case we simply extract the text
  // and insert it.
  if (files && files.length && window.FileReader && window.File) {
    var n = files.length, text = Array(n), read = 0;
    var loadFile = function (file, i) {
      if (cm.options.allowDropFileTypes &&
          indexOf(cm.options.allowDropFileTypes, file.type) == -1)
        { return }

      var reader = new FileReader;
      reader.onload = operation(cm, function () {
        var content = reader.result;
        if (/[\x00-\x08\x0e-\x1f]{2}/.test(content)) { content = ""; }
        text[i] = content;
        if (++read == n) {
          pos = clipPos(cm.doc, pos);
          var change = {from: pos, to: pos,
                        text: cm.doc.splitLines(text.join(cm.doc.lineSeparator())),
                        origin: "paste"};
          makeChange(cm.doc, change);
          setSelectionReplaceHistory(cm.doc, simpleSelection(pos, changeEnd(change)));
        }
      });
      reader.readAsText(file);
    };
    for (var i = 0; i < n; ++i) { loadFile(files[i], i); }
  } else { // Normal drop
    // Don't do a replace if the drop happened inside of the selected text.
    if (cm.state.draggingText && cm.doc.sel.contains(pos) > -1) {
      cm.state.draggingText(e);
      // Ensure the editor is re-focused
      setTimeout(function () { return cm.display.input.focus(); }, 20);
      return
    }
    try {
      var text$1 = e.dataTransfer.getData("Text");
      if (text$1) {
        var selected;
        if (cm.state.draggingText && !cm.state.draggingText.copy)
          { selected = cm.listSelections(); }
        setSelectionNoUndo(cm.doc, simpleSelection(pos, pos));
        if (selected) { for (var i$1 = 0; i$1 < selected.length; ++i$1)
          { replaceRange(cm.doc, "", selected[i$1].anchor, selected[i$1].head, "drag"); } }
        cm.replaceSelection(text$1, "around", "paste");
        cm.display.input.focus();
      }
    }
    catch(e){}
  }
}

function onDragStart(cm, e) {
  if (ie && (!cm.state.draggingText || +new Date - lastDrop < 100)) { e_stop(e); return }
  if (signalDOMEvent(cm, e) || eventInWidget(cm.display, e)) { return }

  e.dataTransfer.setData("Text", cm.getSelection());
  e.dataTransfer.effectAllowed = "copyMove";

  // Use dummy image instead of default browsers image.
  // Recent Safari (~6.0.2) have a tendency to segfault when this happens, so we don't do it there.
  if (e.dataTransfer.setDragImage && !safari) {
    var img = elt("img", null, null, "position: fixed; left: 0; top: 0;");
    img.src = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
    if (presto) {
      img.width = img.height = 1;
      cm.display.wrapper.appendChild(img);
      // Force a relayout, or Opera won't use our image for some obscure reason
      img._top = img.offsetTop;
    }
    e.dataTransfer.setDragImage(img, 0, 0);
    if (presto) { img.parentNode.removeChild(img); }
  }
}

function onDragOver(cm, e) {
  var pos = posFromMouse(cm, e);
  if (!pos) { return }
  var frag = document.createDocumentFragment();
  drawSelectionCursor(cm, pos, frag);
  if (!cm.display.dragCursor) {
    cm.display.dragCursor = elt("div", null, "CodeMirror-cursors CodeMirror-dragcursors");
    cm.display.lineSpace.insertBefore(cm.display.dragCursor, cm.display.cursorDiv);
  }
  removeChildrenAndAdd(cm.display.dragCursor, frag);
}

function clearDragCursor(cm) {
  if (cm.display.dragCursor) {
    cm.display.lineSpace.removeChild(cm.display.dragCursor);
    cm.display.dragCursor = null;
  }
}

// These must be handled carefully, because naively registering a
// handler for each editor will cause the editors to never be
// garbage collected.

function forEachCodeMirror(f) {
  if (!document.getElementsByClassName) { return }
  var byClass = document.getElementsByClassName("CodeMirror");
  for (var i = 0; i < byClass.length; i++) {
    var cm = byClass[i].CodeMirror;
    if (cm) { f(cm); }
  }
}

var globalsRegistered = false;
function ensureGlobalHandlers() {
  if (globalsRegistered) { return }
  registerGlobalHandlers();
  globalsRegistered = true;
}
function registerGlobalHandlers() {
  // When the window resizes, we need to refresh active editors.
  var resizeTimer;
  on(window, "resize", function () {
    if (resizeTimer == null) { resizeTimer = setTimeout(function () {
      resizeTimer = null;
      forEachCodeMirror(onResize);
    }, 100); }
  });
  // When the window loses focus, we want to show the editor as blurred
  on(window, "blur", function () { return forEachCodeMirror(onBlur); });
}
// Called when the window resizes
function onResize(cm) {
  var d = cm.display;
  // Might be a text scaling operation, clear size caches.
  d.cachedCharWidth = d.cachedTextHeight = d.cachedPaddingH = null;
  d.scrollbarsClipped = false;
  cm.setSize();
}

var keyNames = {
  3: "Pause", 8: "Backspace", 9: "Tab", 13: "Enter", 16: "Shift", 17: "Ctrl", 18: "Alt",
  19: "Pause", 20: "CapsLock", 27: "Esc", 32: "Space", 33: "PageUp", 34: "PageDown", 35: "End",
  36: "Home", 37: "Left", 38: "Up", 39: "Right", 40: "Down", 44: "PrintScrn", 45: "Insert",
  46: "Delete", 59: ";", 61: "=", 91: "Mod", 92: "Mod", 93: "Mod",
  106: "*", 107: "=", 109: "-", 110: ".", 111: "/", 127: "Delete", 145: "ScrollLock",
  173: "-", 186: ";", 187: "=", 188: ",", 189: "-", 190: ".", 191: "/", 192: "`", 219: "[", 220: "\\",
  221: "]", 222: "'", 63232: "Up", 63233: "Down", 63234: "Left", 63235: "Right", 63272: "Delete",
  63273: "Home", 63275: "End", 63276: "PageUp", 63277: "PageDown", 63302: "Insert"
};

// Number keys
for (var i = 0; i < 10; i++) { keyNames[i + 48] = keyNames[i + 96] = String(i); }
// Alphabetic keys
for (var i$1 = 65; i$1 <= 90; i$1++) { keyNames[i$1] = String.fromCharCode(i$1); }
// Function keys
for (var i$2 = 1; i$2 <= 12; i$2++) { keyNames[i$2 + 111] = keyNames[i$2 + 63235] = "F" + i$2; }

var keyMap = {};

keyMap.basic = {
  "Left": "goCharLeft", "Right": "goCharRight", "Up": "goLineUp", "Down": "goLineDown",
  "End": "goLineEnd", "Home": "goLineStartSmart", "PageUp": "goPageUp", "PageDown": "goPageDown",
  "Delete": "delCharAfter", "Backspace": "delCharBefore", "Shift-Backspace": "delCharBefore",
  "Tab": "defaultTab", "Shift-Tab": "indentAuto",
  "Enter": "newlineAndIndent", "Insert": "toggleOverwrite",
  "Esc": "singleSelection"
};
// Note that the save and find-related commands aren't defined by
// default. User code or addons can define them. Unknown commands
// are simply ignored.
keyMap.pcDefault = {
  "Ctrl-A": "selectAll", "Ctrl-D": "deleteLine", "Ctrl-Z": "undo", "Shift-Ctrl-Z": "redo", "Ctrl-Y": "redo",
  "Ctrl-Home": "goDocStart", "Ctrl-End": "goDocEnd", "Ctrl-Up": "goLineUp", "Ctrl-Down": "goLineDown",
  "Ctrl-Left": "goGroupLeft", "Ctrl-Right": "goGroupRight", "Alt-Left": "goLineStart", "Alt-Right": "goLineEnd",
  "Ctrl-Backspace": "delGroupBefore", "Ctrl-Delete": "delGroupAfter", "Ctrl-S": "save", "Ctrl-F": "find",
  "Ctrl-G": "findNext", "Shift-Ctrl-G": "findPrev", "Shift-Ctrl-F": "replace", "Shift-Ctrl-R": "replaceAll",
  "Ctrl-[": "indentLess", "Ctrl-]": "indentMore",
  "Ctrl-U": "undoSelection", "Shift-Ctrl-U": "redoSelection", "Alt-U": "redoSelection",
  "fallthrough": "basic"
};
// Very basic readline/emacs-style bindings, which are standard on Mac.
keyMap.emacsy = {
  "Ctrl-F": "goCharRight", "Ctrl-B": "goCharLeft", "Ctrl-P": "goLineUp", "Ctrl-N": "goLineDown",
  "Alt-F": "goWordRight", "Alt-B": "goWordLeft", "Ctrl-A": "goLineStart", "Ctrl-E": "goLineEnd",
  "Ctrl-V": "goPageDown", "Shift-Ctrl-V": "goPageUp", "Ctrl-D": "delCharAfter", "Ctrl-H": "delCharBefore",
  "Alt-D": "delWordAfter", "Alt-Backspace": "delWordBefore", "Ctrl-K": "killLine", "Ctrl-T": "transposeChars",
  "Ctrl-O": "openLine"
};
keyMap.macDefault = {
  "Cmd-A": "selectAll", "Cmd-D": "deleteLine", "Cmd-Z": "undo", "Shift-Cmd-Z": "redo", "Cmd-Y": "redo",
  "Cmd-Home": "goDocStart", "Cmd-Up": "goDocStart", "Cmd-End": "goDocEnd", "Cmd-Down": "goDocEnd", "Alt-Left": "goGroupLeft",
  "Alt-Right": "goGroupRight", "Cmd-Left": "goLineLeft", "Cmd-Right": "goLineRight", "Alt-Backspace": "delGroupBefore",
  "Ctrl-Alt-Backspace": "delGroupAfter", "Alt-Delete": "delGroupAfter", "Cmd-S": "save", "Cmd-F": "find",
  "Cmd-G": "findNext", "Shift-Cmd-G": "findPrev", "Cmd-Alt-F": "replace", "Shift-Cmd-Alt-F": "replaceAll",
  "Cmd-[": "indentLess", "Cmd-]": "indentMore", "Cmd-Backspace": "delWrappedLineLeft", "Cmd-Delete": "delWrappedLineRight",
  "Cmd-U": "undoSelection", "Shift-Cmd-U": "redoSelection", "Ctrl-Up": "goDocStart", "Ctrl-Down": "goDocEnd",
  "fallthrough": ["basic", "emacsy"]
};
keyMap["default"] = mac ? keyMap.macDefault : keyMap.pcDefault;

// KEYMAP DISPATCH

function normalizeKeyName(name) {
  var parts = name.split(/-(?!$)/);
  name = parts[parts.length - 1];
  var alt, ctrl, shift, cmd;
  for (var i = 0; i < parts.length - 1; i++) {
    var mod = parts[i];
    if (/^(cmd|meta|m)$/i.test(mod)) { cmd = true; }
    else if (/^a(lt)?$/i.test(mod)) { alt = true; }
    else if (/^(c|ctrl|control)$/i.test(mod)) { ctrl = true; }
    else if (/^s(hift)?$/i.test(mod)) { shift = true; }
    else { throw new Error("Unrecognized modifier name: " + mod) }
  }
  if (alt) { name = "Alt-" + name; }
  if (ctrl) { name = "Ctrl-" + name; }
  if (cmd) { name = "Cmd-" + name; }
  if (shift) { name = "Shift-" + name; }
  return name
}

// This is a kludge to keep keymaps mostly working as raw objects
// (backwards compatibility) while at the same time support features
// like normalization and multi-stroke key bindings. It compiles a
// new normalized keymap, and then updates the old object to reflect
// this.
function normalizeKeyMap(keymap) {
  var copy = {};
  for (var keyname in keymap) { if (keymap.hasOwnProperty(keyname)) {
    var value = keymap[keyname];
    if (/^(name|fallthrough|(de|at)tach)$/.test(keyname)) { continue }
    if (value == "...") { delete keymap[keyname]; continue }

    var keys = map(keyname.split(" "), normalizeKeyName);
    for (var i = 0; i < keys.length; i++) {
      var val = (void 0), name = (void 0);
      if (i == keys.length - 1) {
        name = keys.join(" ");
        val = value;
      } else {
        name = keys.slice(0, i + 1).join(" ");
        val = "...";
      }
      var prev = copy[name];
      if (!prev) { copy[name] = val; }
      else if (prev != val) { throw new Error("Inconsistent bindings for " + name) }
    }
    delete keymap[keyname];
  } }
  for (var prop in copy) { keymap[prop] = copy[prop]; }
  return keymap
}

function lookupKey(key, map$$1, handle, context) {
  map$$1 = getKeyMap(map$$1);
  var found = map$$1.call ? map$$1.call(key, context) : map$$1[key];
  if (found === false) { return "nothing" }
  if (found === "...") { return "multi" }
  if (found != null && handle(found)) { return "handled" }

  if (map$$1.fallthrough) {
    if (Object.prototype.toString.call(map$$1.fallthrough) != "[object Array]")
      { return lookupKey(key, map$$1.fallthrough, handle, context) }
    for (var i = 0; i < map$$1.fallthrough.length; i++) {
      var result = lookupKey(key, map$$1.fallthrough[i], handle, context);
      if (result) { return result }
    }
  }
}

// Modifier key presses don't count as 'real' key presses for the
// purpose of keymap fallthrough.
function isModifierKey(value) {
  var name = typeof value == "string" ? value : keyNames[value.keyCode];
  return name == "Ctrl" || name == "Alt" || name == "Shift" || name == "Mod"
}

function addModifierNames(name, event, noShift) {
  var base = name;
  if (event.altKey && base != "Alt") { name = "Alt-" + name; }
  if ((flipCtrlCmd ? event.metaKey : event.ctrlKey) && base != "Ctrl") { name = "Ctrl-" + name; }
  if ((flipCtrlCmd ? event.ctrlKey : event.metaKey) && base != "Cmd") { name = "Cmd-" + name; }
  if (!noShift && event.shiftKey && base != "Shift") { name = "Shift-" + name; }
  return name
}

// Look up the name of a key as indicated by an event object.
function keyName(event, noShift) {
  if (presto && event.keyCode == 34 && event["char"]) { return false }
  var name = keyNames[event.keyCode];
  if (name == null || event.altGraphKey) { return false }
  // Ctrl-ScrollLock has keyCode 3, same as Ctrl-Pause,
  // so we'll use event.code when available (Chrome 48+, FF 38+, Safari 10.1+)
  if (event.keyCode == 3 && event.code) { name = event.code; }
  return addModifierNames(name, event, noShift)
}

function getKeyMap(val) {
  return typeof val == "string" ? keyMap[val] : val
}

// Helper for deleting text near the selection(s), used to implement
// backspace, delete, and similar functionality.
function deleteNearSelection(cm, compute) {
  var ranges = cm.doc.sel.ranges, kill = [];
  // Build up a set of ranges to kill first, merging overlapping
  // ranges.
  for (var i = 0; i < ranges.length; i++) {
    var toKill = compute(ranges[i]);
    while (kill.length && cmp(toKill.from, lst(kill).to) <= 0) {
      var replaced = kill.pop();
      if (cmp(replaced.from, toKill.from) < 0) {
        toKill.from = replaced.from;
        break
      }
    }
    kill.push(toKill);
  }
  // Next, remove those actual ranges.
  runInOp(cm, function () {
    for (var i = kill.length - 1; i >= 0; i--)
      { replaceRange(cm.doc, "", kill[i].from, kill[i].to, "+delete"); }
    ensureCursorVisible(cm);
  });
}

function moveCharLogically(line, ch, dir) {
  var target = skipExtendingChars(line.text, ch + dir, dir);
  return target < 0 || target > line.text.length ? null : target
}

function moveLogically(line, start, dir) {
  var ch = moveCharLogically(line, start.ch, dir);
  return ch == null ? null : new Pos(start.line, ch, dir < 0 ? "after" : "before")
}

function endOfLine(visually, cm, lineObj, lineNo, dir) {
  if (visually) {
    var order = getOrder(lineObj, cm.doc.direction);
    if (order) {
      var part = dir < 0 ? lst(order) : order[0];
      var moveInStorageOrder = (dir < 0) == (part.level == 1);
      var sticky = moveInStorageOrder ? "after" : "before";
      var ch;
      // With a wrapped rtl chunk (possibly spanning multiple bidi parts),
      // it could be that the last bidi part is not on the last visual line,
      // since visual lines contain content order-consecutive chunks.
      // Thus, in rtl, we are looking for the first (content-order) character
      // in the rtl chunk that is on the last line (that is, the same line
      // as the last (content-order) character).
      if (part.level > 0 || cm.doc.direction == "rtl") {
        var prep = prepareMeasureForLine(cm, lineObj);
        ch = dir < 0 ? lineObj.text.length - 1 : 0;
        var targetTop = measureCharPrepared(cm, prep, ch).top;
        ch = findFirst(function (ch) { return measureCharPrepared(cm, prep, ch).top == targetTop; }, (dir < 0) == (part.level == 1) ? part.from : part.to - 1, ch);
        if (sticky == "before") { ch = moveCharLogically(lineObj, ch, 1); }
      } else { ch = dir < 0 ? part.to : part.from; }
      return new Pos(lineNo, ch, sticky)
    }
  }
  return new Pos(lineNo, dir < 0 ? lineObj.text.length : 0, dir < 0 ? "before" : "after")
}

function moveVisually(cm, line, start, dir) {
  var bidi = getOrder(line, cm.doc.direction);
  if (!bidi) { return moveLogically(line, start, dir) }
  if (start.ch >= line.text.length) {
    start.ch = line.text.length;
    start.sticky = "before";
  } else if (start.ch <= 0) {
    start.ch = 0;
    start.sticky = "after";
  }
  var partPos = getBidiPartAt(bidi, start.ch, start.sticky), part = bidi[partPos];
  if (cm.doc.direction == "ltr" && part.level % 2 == 0 && (dir > 0 ? part.to > start.ch : part.from < start.ch)) {
    // Case 1: We move within an ltr part in an ltr editor. Even with wrapped lines,
    // nothing interesting happens.
    return moveLogically(line, start, dir)
  }

  var mv = function (pos, dir) { return moveCharLogically(line, pos instanceof Pos ? pos.ch : pos, dir); };
  var prep;
  var getWrappedLineExtent = function (ch) {
    if (!cm.options.lineWrapping) { return {begin: 0, end: line.text.length} }
    prep = prep || prepareMeasureForLine(cm, line);
    return wrappedLineExtentChar(cm, line, prep, ch)
  };
  var wrappedLineExtent = getWrappedLineExtent(start.sticky == "before" ? mv(start, -1) : start.ch);

  if (cm.doc.direction == "rtl" || part.level == 1) {
    var moveInStorageOrder = (part.level == 1) == (dir < 0);
    var ch = mv(start, moveInStorageOrder ? 1 : -1);
    if (ch != null && (!moveInStorageOrder ? ch >= part.from && ch >= wrappedLineExtent.begin : ch <= part.to && ch <= wrappedLineExtent.end)) {
      // Case 2: We move within an rtl part or in an rtl editor on the same visual line
      var sticky = moveInStorageOrder ? "before" : "after";
      return new Pos(start.line, ch, sticky)
    }
  }

  // Case 3: Could not move within this bidi part in this visual line, so leave
  // the current bidi part

  var searchInVisualLine = function (partPos, dir, wrappedLineExtent) {
    var getRes = function (ch, moveInStorageOrder) { return moveInStorageOrder
      ? new Pos(start.line, mv(ch, 1), "before")
      : new Pos(start.line, ch, "after"); };

    for (; partPos >= 0 && partPos < bidi.length; partPos += dir) {
      var part = bidi[partPos];
      var moveInStorageOrder = (dir > 0) == (part.level != 1);
      var ch = moveInStorageOrder ? wrappedLineExtent.begin : mv(wrappedLineExtent.end, -1);
      if (part.from <= ch && ch < part.to) { return getRes(ch, moveInStorageOrder) }
      ch = moveInStorageOrder ? part.from : mv(part.to, -1);
      if (wrappedLineExtent.begin <= ch && ch < wrappedLineExtent.end) { return getRes(ch, moveInStorageOrder) }
    }
  };

  // Case 3a: Look for other bidi parts on the same visual line
  var res = searchInVisualLine(partPos + dir, dir, wrappedLineExtent);
  if (res) { return res }

  // Case 3b: Look for other bidi parts on the next visual line
  var nextCh = dir > 0 ? wrappedLineExtent.end : mv(wrappedLineExtent.begin, -1);
  if (nextCh != null && !(dir > 0 && nextCh == line.text.length)) {
    res = searchInVisualLine(dir > 0 ? 0 : bidi.length - 1, dir, getWrappedLineExtent(nextCh));
    if (res) { return res }
  }

  // Case 4: Nowhere to move
  return null
}

// Commands are parameter-less actions that can be performed on an
// editor, mostly used for keybindings.
var commands = {
  selectAll: selectAll,
  singleSelection: function (cm) { return cm.setSelection(cm.getCursor("anchor"), cm.getCursor("head"), sel_dontScroll); },
  killLine: function (cm) { return deleteNearSelection(cm, function (range) {
    if (range.empty()) {
      var len = getLine(cm.doc, range.head.line).text.length;
      if (range.head.ch == len && range.head.line < cm.lastLine())
        { return {from: range.head, to: Pos(range.head.line + 1, 0)} }
      else
        { return {from: range.head, to: Pos(range.head.line, len)} }
    } else {
      return {from: range.from(), to: range.to()}
    }
  }); },
  deleteLine: function (cm) { return deleteNearSelection(cm, function (range) { return ({
    from: Pos(range.from().line, 0),
    to: clipPos(cm.doc, Pos(range.to().line + 1, 0))
  }); }); },
  delLineLeft: function (cm) { return deleteNearSelection(cm, function (range) { return ({
    from: Pos(range.from().line, 0), to: range.from()
  }); }); },
  delWrappedLineLeft: function (cm) { return deleteNearSelection(cm, function (range) {
    var top = cm.charCoords(range.head, "div").top + 5;
    var leftPos = cm.coordsChar({left: 0, top: top}, "div");
    return {from: leftPos, to: range.from()}
  }); },
  delWrappedLineRight: function (cm) { return deleteNearSelection(cm, function (range) {
    var top = cm.charCoords(range.head, "div").top + 5;
    var rightPos = cm.coordsChar({left: cm.display.lineDiv.offsetWidth + 100, top: top}, "div");
    return {from: range.from(), to: rightPos }
  }); },
  undo: function (cm) { return cm.undo(); },
  redo: function (cm) { return cm.redo(); },
  undoSelection: function (cm) { return cm.undoSelection(); },
  redoSelection: function (cm) { return cm.redoSelection(); },
  goDocStart: function (cm) { return cm.extendSelection(Pos(cm.firstLine(), 0)); },
  goDocEnd: function (cm) { return cm.extendSelection(Pos(cm.lastLine())); },
  goLineStart: function (cm) { return cm.extendSelectionsBy(function (range) { return lineStart(cm, range.head.line); },
    {origin: "+move", bias: 1}
  ); },
  goLineStartSmart: function (cm) { return cm.extendSelectionsBy(function (range) { return lineStartSmart(cm, range.head); },
    {origin: "+move", bias: 1}
  ); },
  goLineEnd: function (cm) { return cm.extendSelectionsBy(function (range) { return lineEnd(cm, range.head.line); },
    {origin: "+move", bias: -1}
  ); },
  goLineRight: function (cm) { return cm.extendSelectionsBy(function (range) {
    var top = cm.cursorCoords(range.head, "div").top + 5;
    return cm.coordsChar({left: cm.display.lineDiv.offsetWidth + 100, top: top}, "div")
  }, sel_move); },
  goLineLeft: function (cm) { return cm.extendSelectionsBy(function (range) {
    var top = cm.cursorCoords(range.head, "div").top + 5;
    return cm.coordsChar({left: 0, top: top}, "div")
  }, sel_move); },
  goLineLeftSmart: function (cm) { return cm.extendSelectionsBy(function (range) {
    var top = cm.cursorCoords(range.head, "div").top + 5;
    var pos = cm.coordsChar({left: 0, top: top}, "div");
    if (pos.ch < cm.getLine(pos.line).search(/\S/)) { return lineStartSmart(cm, range.head) }
    return pos
  }, sel_move); },
  goLineUp: function (cm) { return cm.moveV(-1, "line"); },
  goLineDown: function (cm) { return cm.moveV(1, "line"); },
  goPageUp: function (cm) { return cm.moveV(-1, "page"); },
  goPageDown: function (cm) { return cm.moveV(1, "page"); },
  goCharLeft: function (cm) { return cm.moveH(-1, "char"); },
  goCharRight: function (cm) { return cm.moveH(1, "char"); },
  goColumnLeft: function (cm) { return cm.moveH(-1, "column"); },
  goColumnRight: function (cm) { return cm.moveH(1, "column"); },
  goWordLeft: function (cm) { return cm.moveH(-1, "word"); },
  goGroupRight: function (cm) { return cm.moveH(1, "group"); },
  goGroupLeft: function (cm) { return cm.moveH(-1, "group"); },
  goWordRight: function (cm) { return cm.moveH(1, "word"); },
  delCharBefore: function (cm) { return cm.deleteH(-1, "char"); },
  delCharAfter: function (cm) { return cm.deleteH(1, "char"); },
  delWordBefore: function (cm) { return cm.deleteH(-1, "word"); },
  delWordAfter: function (cm) { return cm.deleteH(1, "word"); },
  delGroupBefore: function (cm) { return cm.deleteH(-1, "group"); },
  delGroupAfter: function (cm) { return cm.deleteH(1, "group"); },
  indentAuto: function (cm) { return cm.indentSelection("smart"); },
  indentMore: function (cm) { return cm.indentSelection("add"); },
  indentLess: function (cm) { return cm.indentSelection("subtract"); },
  insertTab: function (cm) { return cm.replaceSelection("\t"); },
  insertSoftTab: function (cm) {
    var spaces = [], ranges = cm.listSelections(), tabSize = cm.options.tabSize;
    for (var i = 0; i < ranges.length; i++) {
      var pos = ranges[i].from();
      var col = countColumn(cm.getLine(pos.line), pos.ch, tabSize);
      spaces.push(spaceStr(tabSize - col % tabSize));
    }
    cm.replaceSelections(spaces);
  },
  defaultTab: function (cm) {
    if (cm.somethingSelected()) { cm.indentSelection("add"); }
    else { cm.execCommand("insertTab"); }
  },
  // Swap the two chars left and right of each selection's head.
  // Move cursor behind the two swapped characters afterwards.
  //
  // Doesn't consider line feeds a character.
  // Doesn't scan more than one line above to find a character.
  // Doesn't do anything on an empty line.
  // Doesn't do anything with non-empty selections.
  transposeChars: function (cm) { return runInOp(cm, function () {
    var ranges = cm.listSelections(), newSel = [];
    for (var i = 0; i < ranges.length; i++) {
      if (!ranges[i].empty()) { continue }
      var cur = ranges[i].head, line = getLine(cm.doc, cur.line).text;
      if (line) {
        if (cur.ch == line.length) { cur = new Pos(cur.line, cur.ch - 1); }
        if (cur.ch > 0) {
          cur = new Pos(cur.line, cur.ch + 1);
          cm.replaceRange(line.charAt(cur.ch - 1) + line.charAt(cur.ch - 2),
                          Pos(cur.line, cur.ch - 2), cur, "+transpose");
        } else if (cur.line > cm.doc.first) {
          var prev = getLine(cm.doc, cur.line - 1).text;
          if (prev) {
            cur = new Pos(cur.line, 1);
            cm.replaceRange(line.charAt(0) + cm.doc.lineSeparator() +
                            prev.charAt(prev.length - 1),
                            Pos(cur.line - 1, prev.length - 1), cur, "+transpose");
          }
        }
      }
      newSel.push(new Range(cur, cur));
    }
    cm.setSelections(newSel);
  }); },
  newlineAndIndent: function (cm) { return runInOp(cm, function () {
    var sels = cm.listSelections();
    for (var i = sels.length - 1; i >= 0; i--)
      { cm.replaceRange(cm.doc.lineSeparator(), sels[i].anchor, sels[i].head, "+input"); }
    sels = cm.listSelections();
    for (var i$1 = 0; i$1 < sels.length; i$1++)
      { cm.indentLine(sels[i$1].from().line, null, true); }
    ensureCursorVisible(cm);
  }); },
  openLine: function (cm) { return cm.replaceSelection("\n", "start"); },
  toggleOverwrite: function (cm) { return cm.toggleOverwrite(); }
};


function lineStart(cm, lineN) {
  var line = getLine(cm.doc, lineN);
  var visual = visualLine(line);
  if (visual != line) { lineN = lineNo(visual); }
  return endOfLine(true, cm, visual, lineN, 1)
}
function lineEnd(cm, lineN) {
  var line = getLine(cm.doc, lineN);
  var visual = visualLineEnd(line);
  if (visual != line) { lineN = lineNo(visual); }
  return endOfLine(true, cm, line, lineN, -1)
}
function lineStartSmart(cm, pos) {
  var start = lineStart(cm, pos.line);
  var line = getLine(cm.doc, start.line);
  var order = getOrder(line, cm.doc.direction);
  if (!order || order[0].level == 0) {
    var firstNonWS = Math.max(0, line.text.search(/\S/));
    var inWS = pos.line == start.line && pos.ch <= firstNonWS && pos.ch;
    return Pos(start.line, inWS ? 0 : firstNonWS, start.sticky)
  }
  return start
}

// Run a handler that was bound to a key.
function doHandleBinding(cm, bound, dropShift) {
  if (typeof bound == "string") {
    bound = commands[bound];
    if (!bound) { return false }
  }
  // Ensure previous input has been read, so that the handler sees a
  // consistent view of the document
  cm.display.input.ensurePolled();
  var prevShift = cm.display.shift, done = false;
  try {
    if (cm.isReadOnly()) { cm.state.suppressEdits = true; }
    if (dropShift) { cm.display.shift = false; }
    done = bound(cm) != Pass;
  } finally {
    cm.display.shift = prevShift;
    cm.state.suppressEdits = false;
  }
  return done
}

function lookupKeyForEditor(cm, name, handle) {
  for (var i = 0; i < cm.state.keyMaps.length; i++) {
    var result = lookupKey(name, cm.state.keyMaps[i], handle, cm);
    if (result) { return result }
  }
  return (cm.options.extraKeys && lookupKey(name, cm.options.extraKeys, handle, cm))
    || lookupKey(name, cm.options.keyMap, handle, cm)
}

// Note that, despite the name, this function is also used to check
// for bound mouse clicks.

var stopSeq = new Delayed;

function dispatchKey(cm, name, e, handle) {
  var seq = cm.state.keySeq;
  if (seq) {
    if (isModifierKey(name)) { return "handled" }
    if (/\'$/.test(name))
      { cm.state.keySeq = null; }
    else
      { stopSeq.set(50, function () {
        if (cm.state.keySeq == seq) {
          cm.state.keySeq = null;
          cm.display.input.reset();
        }
      }); }
    if (dispatchKeyInner(cm, seq + " " + name, e, handle)) { return true }
  }
  return dispatchKeyInner(cm, name, e, handle)
}

function dispatchKeyInner(cm, name, e, handle) {
  var result = lookupKeyForEditor(cm, name, handle);

  if (result == "multi")
    { cm.state.keySeq = name; }
  if (result == "handled")
    { signalLater(cm, "keyHandled", cm, name, e); }

  if (result == "handled" || result == "multi") {
    e_preventDefault(e);
    restartBlink(cm);
  }

  return !!result
}

// Handle a key from the keydown event.
function handleKeyBinding(cm, e) {
  var name = keyName(e, true);
  if (!name) { return false }

  if (e.shiftKey && !cm.state.keySeq) {
    // First try to resolve full name (including 'Shift-'). Failing
    // that, see if there is a cursor-motion command (starting with
    // 'go') bound to the keyname without 'Shift-'.
    return dispatchKey(cm, "Shift-" + name, e, function (b) { return doHandleBinding(cm, b, true); })
        || dispatchKey(cm, name, e, function (b) {
             if (typeof b == "string" ? /^go[A-Z]/.test(b) : b.motion)
               { return doHandleBinding(cm, b) }
           })
  } else {
    return dispatchKey(cm, name, e, function (b) { return doHandleBinding(cm, b); })
  }
}

// Handle a key from the keypress event
function handleCharBinding(cm, e, ch) {
  return dispatchKey(cm, "'" + ch + "'", e, function (b) { return doHandleBinding(cm, b, true); })
}

var lastStoppedKey = null;
function onKeyDown(e) {
  var cm = this;
  cm.curOp.focus = activeElt();
  if (signalDOMEvent(cm, e)) { return }
  // IE does strange things with escape.
  if (ie && ie_version < 11 && e.keyCode == 27) { e.returnValue = false; }
  var code = e.keyCode;
  cm.display.shift = code == 16 || e.shiftKey;
  var handled = handleKeyBinding(cm, e);
  if (presto) {
    lastStoppedKey = handled ? code : null;
    // Opera has no cut event... we try to at least catch the key combo
    if (!handled && code == 88 && !hasCopyEvent && (mac ? e.metaKey : e.ctrlKey))
      { cm.replaceSelection("", null, "cut"); }
  }

  // Turn mouse into crosshair when Alt is held on Mac.
  if (code == 18 && !/\bCodeMirror-crosshair\b/.test(cm.display.lineDiv.className))
    { showCrossHair(cm); }
}

function showCrossHair(cm) {
  var lineDiv = cm.display.lineDiv;
  addClass(lineDiv, "CodeMirror-crosshair");

  function up(e) {
    if (e.keyCode == 18 || !e.altKey) {
      rmClass(lineDiv, "CodeMirror-crosshair");
      off(document, "keyup", up);
      off(document, "mouseover", up);
    }
  }
  on(document, "keyup", up);
  on(document, "mouseover", up);
}

function onKeyUp(e) {
  if (e.keyCode == 16) { this.doc.sel.shift = false; }
  signalDOMEvent(this, e);
}

function onKeyPress(e) {
  var cm = this;
  if (eventInWidget(cm.display, e) || signalDOMEvent(cm, e) || e.ctrlKey && !e.altKey || mac && e.metaKey) { return }
  var keyCode = e.keyCode, charCode = e.charCode;
  if (presto && keyCode == lastStoppedKey) {lastStoppedKey = null; e_preventDefault(e); return}
  if ((presto && (!e.which || e.which < 10)) && handleKeyBinding(cm, e)) { return }
  var ch = String.fromCharCode(charCode == null ? keyCode : charCode);
  // Some browsers fire keypress events for backspace
  if (ch == "\x08") { return }
  if (handleCharBinding(cm, e, ch)) { return }
  cm.display.input.onKeyPress(e);
}

var DOUBLECLICK_DELAY = 400;

var PastClick = function(time, pos, button) {
  this.time = time;
  this.pos = pos;
  this.button = button;
};

PastClick.prototype.compare = function (time, pos, button) {
  return this.time + DOUBLECLICK_DELAY > time &&
    cmp(pos, this.pos) == 0 && button == this.button
};

var lastClick;
var lastDoubleClick;
function clickRepeat(pos, button) {
  var now = +new Date;
  if (lastDoubleClick && lastDoubleClick.compare(now, pos, button)) {
    lastClick = lastDoubleClick = null;
    return "triple"
  } else if (lastClick && lastClick.compare(now, pos, button)) {
    lastDoubleClick = new PastClick(now, pos, button);
    lastClick = null;
    return "double"
  } else {
    lastClick = new PastClick(now, pos, button);
    lastDoubleClick = null;
    return "single"
  }
}

// A mouse down can be a single click, double click, triple click,
// start of selection drag, start of text drag, new cursor
// (ctrl-click), rectangle drag (alt-drag), or xwin
// middle-click-paste. Or it might be a click on something we should
// not interfere with, such as a scrollbar or widget.
function onMouseDown(e) {
  var cm = this, display = cm.display;
  if (signalDOMEvent(cm, e) || display.activeTouch && display.input.supportsTouch()) { return }
  display.input.ensurePolled();
  display.shift = e.shiftKey;

  if (eventInWidget(display, e)) {
    if (!webkit) {
      // Briefly turn off draggability, to allow widgets to do
      // normal dragging things.
      display.scroller.draggable = false;
      setTimeout(function () { return display.scroller.draggable = true; }, 100);
    }
    return
  }
  if (clickInGutter(cm, e)) { return }
  var pos = posFromMouse(cm, e), button = e_button(e), repeat = pos ? clickRepeat(pos, button) : "single";
  window.focus();

  // #3261: make sure, that we're not starting a second selection
  if (button == 1 && cm.state.selectingText)
    { cm.state.selectingText(e); }

  if (pos && handleMappedButton(cm, button, pos, repeat, e)) { return }

  if (button == 1) {
    if (pos) { leftButtonDown(cm, pos, repeat, e); }
    else if (e_target(e) == display.scroller) { e_preventDefault(e); }
  } else if (button == 2) {
    if (pos) { extendSelection(cm.doc, pos); }
    setTimeout(function () { return display.input.focus(); }, 20);
  } else if (button == 3) {
    if (captureRightClick) { onContextMenu(cm, e); }
    else { delayBlurEvent(cm); }
  }
}

function handleMappedButton(cm, button, pos, repeat, event) {
  var name = "Click";
  if (repeat == "double") { name = "Double" + name; }
  else if (repeat == "triple") { name = "Triple" + name; }
  name = (button == 1 ? "Left" : button == 2 ? "Middle" : "Right") + name;

  return dispatchKey(cm,  addModifierNames(name, event), event, function (bound) {
    if (typeof bound == "string") { bound = commands[bound]; }
    if (!bound) { return false }
    var done = false;
    try {
      if (cm.isReadOnly()) { cm.state.suppressEdits = true; }
      done = bound(cm, pos) != Pass;
    } finally {
      cm.state.suppressEdits = false;
    }
    return done
  })
}

function configureMouse(cm, repeat, event) {
  var option = cm.getOption("configureMouse");
  var value = option ? option(cm, repeat, event) : {};
  if (value.unit == null) {
    var rect = chromeOS ? event.shiftKey && event.metaKey : event.altKey;
    value.unit = rect ? "rectangle" : repeat == "single" ? "char" : repeat == "double" ? "word" : "line";
  }
  if (value.extend == null || cm.doc.extend) { value.extend = cm.doc.extend || event.shiftKey; }
  if (value.addNew == null) { value.addNew = mac ? event.metaKey : event.ctrlKey; }
  if (value.moveOnDrag == null) { value.moveOnDrag = !(mac ? event.altKey : event.ctrlKey); }
  return value
}

function leftButtonDown(cm, pos, repeat, event) {
  if (ie) { setTimeout(bind(ensureFocus, cm), 0); }
  else { cm.curOp.focus = activeElt(); }

  var behavior = configureMouse(cm, repeat, event);

  var sel = cm.doc.sel, contained;
  if (cm.options.dragDrop && dragAndDrop && !cm.isReadOnly() &&
      repeat == "single" && (contained = sel.contains(pos)) > -1 &&
      (cmp((contained = sel.ranges[contained]).from(), pos) < 0 || pos.xRel > 0) &&
      (cmp(contained.to(), pos) > 0 || pos.xRel < 0))
    { leftButtonStartDrag(cm, event, pos, behavior); }
  else
    { leftButtonSelect(cm, event, pos, behavior); }
}

// Start a text drag. When it ends, see if any dragging actually
// happen, and treat as a click if it didn't.
function leftButtonStartDrag(cm, event, pos, behavior) {
  var display = cm.display, moved = false;
  var dragEnd = operation(cm, function (e) {
    if (webkit) { display.scroller.draggable = false; }
    cm.state.draggingText = false;
    off(display.wrapper.ownerDocument, "mouseup", dragEnd);
    off(display.wrapper.ownerDocument, "mousemove", mouseMove);
    off(display.scroller, "dragstart", dragStart);
    off(display.scroller, "drop", dragEnd);
    if (!moved) {
      e_preventDefault(e);
      if (!behavior.addNew)
        { extendSelection(cm.doc, pos, null, null, behavior.extend); }
      // Work around unexplainable focus problem in IE9 (#2127) and Chrome (#3081)
      if (webkit || ie && ie_version == 9)
        { setTimeout(function () {display.wrapper.ownerDocument.body.focus(); display.input.focus();}, 20); }
      else
        { display.input.focus(); }
    }
  });
  var mouseMove = function(e2) {
    moved = moved || Math.abs(event.clientX - e2.clientX) + Math.abs(event.clientY - e2.clientY) >= 10;
  };
  var dragStart = function () { return moved = true; };
  // Let the drag handler handle this.
  if (webkit) { display.scroller.draggable = true; }
  cm.state.draggingText = dragEnd;
  dragEnd.copy = !behavior.moveOnDrag;
  // IE's approach to draggable
  if (display.scroller.dragDrop) { display.scroller.dragDrop(); }
  on(display.wrapper.ownerDocument, "mouseup", dragEnd);
  on(display.wrapper.ownerDocument, "mousemove", mouseMove);
  on(display.scroller, "dragstart", dragStart);
  on(display.scroller, "drop", dragEnd);

  delayBlurEvent(cm);
  setTimeout(function () { return display.input.focus(); }, 20);
}

function rangeForUnit(cm, pos, unit) {
  if (unit == "char") { return new Range(pos, pos) }
  if (unit == "word") { return cm.findWordAt(pos) }
  if (unit == "line") { return new Range(Pos(pos.line, 0), clipPos(cm.doc, Pos(pos.line + 1, 0))) }
  var result = unit(cm, pos);
  return new Range(result.from, result.to)
}

// Normal selection, as opposed to text dragging.
function leftButtonSelect(cm, event, start, behavior) {
  var display = cm.display, doc = cm.doc;
  e_preventDefault(event);

  var ourRange, ourIndex, startSel = doc.sel, ranges = startSel.ranges;
  if (behavior.addNew && !behavior.extend) {
    ourIndex = doc.sel.contains(start);
    if (ourIndex > -1)
      { ourRange = ranges[ourIndex]; }
    else
      { ourRange = new Range(start, start); }
  } else {
    ourRange = doc.sel.primary();
    ourIndex = doc.sel.primIndex;
  }

  if (behavior.unit == "rectangle") {
    if (!behavior.addNew) { ourRange = new Range(start, start); }
    start = posFromMouse(cm, event, true, true);
    ourIndex = -1;
  } else {
    var range$$1 = rangeForUnit(cm, start, behavior.unit);
    if (behavior.extend)
      { ourRange = extendRange(ourRange, range$$1.anchor, range$$1.head, behavior.extend); }
    else
      { ourRange = range$$1; }
  }

  if (!behavior.addNew) {
    ourIndex = 0;
    setSelection(doc, new Selection([ourRange], 0), sel_mouse);
    startSel = doc.sel;
  } else if (ourIndex == -1) {
    ourIndex = ranges.length;
    setSelection(doc, normalizeSelection(ranges.concat([ourRange]), ourIndex),
                 {scroll: false, origin: "*mouse"});
  } else if (ranges.length > 1 && ranges[ourIndex].empty() && behavior.unit == "char" && !behavior.extend) {
    setSelection(doc, normalizeSelection(ranges.slice(0, ourIndex).concat(ranges.slice(ourIndex + 1)), 0),
                 {scroll: false, origin: "*mouse"});
    startSel = doc.sel;
  } else {
    replaceOneSelection(doc, ourIndex, ourRange, sel_mouse);
  }

  var lastPos = start;
  function extendTo(pos) {
    if (cmp(lastPos, pos) == 0) { return }
    lastPos = pos;

    if (behavior.unit == "rectangle") {
      var ranges = [], tabSize = cm.options.tabSize;
      var startCol = countColumn(getLine(doc, start.line).text, start.ch, tabSize);
      var posCol = countColumn(getLine(doc, pos.line).text, pos.ch, tabSize);
      var left = Math.min(startCol, posCol), right = Math.max(startCol, posCol);
      for (var line = Math.min(start.line, pos.line), end = Math.min(cm.lastLine(), Math.max(start.line, pos.line));
           line <= end; line++) {
        var text = getLine(doc, line).text, leftPos = findColumn(text, left, tabSize);
        if (left == right)
          { ranges.push(new Range(Pos(line, leftPos), Pos(line, leftPos))); }
        else if (text.length > leftPos)
          { ranges.push(new Range(Pos(line, leftPos), Pos(line, findColumn(text, right, tabSize)))); }
      }
      if (!ranges.length) { ranges.push(new Range(start, start)); }
      setSelection(doc, normalizeSelection(startSel.ranges.slice(0, ourIndex).concat(ranges), ourIndex),
                   {origin: "*mouse", scroll: false});
      cm.scrollIntoView(pos);
    } else {
      var oldRange = ourRange;
      var range$$1 = rangeForUnit(cm, pos, behavior.unit);
      var anchor = oldRange.anchor, head;
      if (cmp(range$$1.anchor, anchor) > 0) {
        head = range$$1.head;
        anchor = minPos(oldRange.from(), range$$1.anchor);
      } else {
        head = range$$1.anchor;
        anchor = maxPos(oldRange.to(), range$$1.head);
      }
      var ranges$1 = startSel.ranges.slice(0);
      ranges$1[ourIndex] = bidiSimplify(cm, new Range(clipPos(doc, anchor), head));
      setSelection(doc, normalizeSelection(ranges$1, ourIndex), sel_mouse);
    }
  }

  var editorSize = display.wrapper.getBoundingClientRect();
  // Used to ensure timeout re-tries don't fire when another extend
  // happened in the meantime (clearTimeout isn't reliable -- at
  // least on Chrome, the timeouts still happen even when cleared,
  // if the clear happens after their scheduled firing time).
  var counter = 0;

  function extend(e) {
    var curCount = ++counter;
    var cur = posFromMouse(cm, e, true, behavior.unit == "rectangle");
    if (!cur) { return }
    if (cmp(cur, lastPos) != 0) {
      cm.curOp.focus = activeElt();
      extendTo(cur);
      var visible = visibleLines(display, doc);
      if (cur.line >= visible.to || cur.line < visible.from)
        { setTimeout(operation(cm, function () {if (counter == curCount) { extend(e); }}), 150); }
    } else {
      var outside = e.clientY < editorSize.top ? -20 : e.clientY > editorSize.bottom ? 20 : 0;
      if (outside) { setTimeout(operation(cm, function () {
        if (counter != curCount) { return }
        display.scroller.scrollTop += outside;
        extend(e);
      }), 50); }
    }
  }

  function done(e) {
    cm.state.selectingText = false;
    counter = Infinity;
    e_preventDefault(e);
    display.input.focus();
    off(display.wrapper.ownerDocument, "mousemove", move);
    off(display.wrapper.ownerDocument, "mouseup", up);
    doc.history.lastSelOrigin = null;
  }

  var move = operation(cm, function (e) {
    if (e.buttons === 0 || !e_button(e)) { done(e); }
    else { extend(e); }
  });
  var up = operation(cm, done);
  cm.state.selectingText = up;
  on(display.wrapper.ownerDocument, "mousemove", move);
  on(display.wrapper.ownerDocument, "mouseup", up);
}

// Used when mouse-selecting to adjust the anchor to the proper side
// of a bidi jump depending on the visual position of the head.
function bidiSimplify(cm, range$$1) {
  var anchor = range$$1.anchor;
  var head = range$$1.head;
  var anchorLine = getLine(cm.doc, anchor.line);
  if (cmp(anchor, head) == 0 && anchor.sticky == head.sticky) { return range$$1 }
  var order = getOrder(anchorLine);
  if (!order) { return range$$1 }
  var index = getBidiPartAt(order, anchor.ch, anchor.sticky), part = order[index];
  if (part.from != anchor.ch && part.to != anchor.ch) { return range$$1 }
  var boundary = index + ((part.from == anchor.ch) == (part.level != 1) ? 0 : 1);
  if (boundary == 0 || boundary == order.length) { return range$$1 }

  // Compute the relative visual position of the head compared to the
  // anchor (<0 is to the left, >0 to the right)
  var leftSide;
  if (head.line != anchor.line) {
    leftSide = (head.line - anchor.line) * (cm.doc.direction == "ltr" ? 1 : -1) > 0;
  } else {
    var headIndex = getBidiPartAt(order, head.ch, head.sticky);
    var dir = headIndex - index || (head.ch - anchor.ch) * (part.level == 1 ? -1 : 1);
    if (headIndex == boundary - 1 || headIndex == boundary)
      { leftSide = dir < 0; }
    else
      { leftSide = dir > 0; }
  }

  var usePart = order[boundary + (leftSide ? -1 : 0)];
  var from = leftSide == (usePart.level == 1);
  var ch = from ? usePart.from : usePart.to, sticky = from ? "after" : "before";
  return anchor.ch == ch && anchor.sticky == sticky ? range$$1 : new Range(new Pos(anchor.line, ch, sticky), head)
}


// Determines whether an event happened in the gutter, and fires the
// handlers for the corresponding event.
function gutterEvent(cm, e, type, prevent) {
  var mX, mY;
  if (e.touches) {
    mX = e.touches[0].clientX;
    mY = e.touches[0].clientY;
  } else {
    try { mX = e.clientX; mY = e.clientY; }
    catch(e) { return false }
  }
  if (mX >= Math.floor(cm.display.gutters.getBoundingClientRect().right)) { return false }
  if (prevent) { e_preventDefault(e); }

  var display = cm.display;
  var lineBox = display.lineDiv.getBoundingClientRect();

  if (mY > lineBox.bottom || !hasHandler(cm, type)) { return e_defaultPrevented(e) }
  mY -= lineBox.top - display.viewOffset;

  for (var i = 0; i < cm.options.gutters.length; ++i) {
    var g = display.gutters.childNodes[i];
    if (g && g.getBoundingClientRect().right >= mX) {
      var line = lineAtHeight(cm.doc, mY);
      var gutter = cm.options.gutters[i];
      signal(cm, type, cm, line, gutter, e);
      return e_defaultPrevented(e)
    }
  }
}

function clickInGutter(cm, e) {
  return gutterEvent(cm, e, "gutterClick", true)
}

// CONTEXT MENU HANDLING

// To make the context menu work, we need to briefly unhide the
// textarea (making it as unobtrusive as possible) to let the
// right-click take effect on it.
function onContextMenu(cm, e) {
  if (eventInWidget(cm.display, e) || contextMenuInGutter(cm, e)) { return }
  if (signalDOMEvent(cm, e, "contextmenu")) { return }
  cm.display.input.onContextMenu(e);
}

function contextMenuInGutter(cm, e) {
  if (!hasHandler(cm, "gutterContextMenu")) { return false }
  return gutterEvent(cm, e, "gutterContextMenu", false)
}

function themeChanged(cm) {
  cm.display.wrapper.className = cm.display.wrapper.className.replace(/\s*cm-s-\S+/g, "") +
    cm.options.theme.replace(/(^|\s)\s*/g, " cm-s-");
  clearCaches(cm);
}

var Init = {toString: function(){return "CodeMirror.Init"}};

var defaults = {};
var optionHandlers = {};

function defineOptions(CodeMirror) {
  var optionHandlers = CodeMirror.optionHandlers;

  function option(name, deflt, handle, notOnInit) {
    CodeMirror.defaults[name] = deflt;
    if (handle) { optionHandlers[name] =
      notOnInit ? function (cm, val, old) {if (old != Init) { handle(cm, val, old); }} : handle; }
  }

  CodeMirror.defineOption = option;

  // Passed to option handlers when there is no old value.
  CodeMirror.Init = Init;

  // These two are, on init, called from the constructor because they
  // have to be initialized before the editor can start at all.
  option("value", "", function (cm, val) { return cm.setValue(val); }, true);
  option("mode", null, function (cm, val) {
    cm.doc.modeOption = val;
    loadMode(cm);
  }, true);

  option("indentUnit", 2, loadMode, true);
  option("indentWithTabs", false);
  option("smartIndent", true);
  option("tabSize", 4, function (cm) {
    resetModeState(cm);
    clearCaches(cm);
    regChange(cm);
  }, true);

  option("lineSeparator", null, function (cm, val) {
    cm.doc.lineSep = val;
    if (!val) { return }
    var newBreaks = [], lineNo = cm.doc.first;
    cm.doc.iter(function (line) {
      for (var pos = 0;;) {
        var found = line.text.indexOf(val, pos);
        if (found == -1) { break }
        pos = found + val.length;
        newBreaks.push(Pos(lineNo, found));
      }
      lineNo++;
    });
    for (var i = newBreaks.length - 1; i >= 0; i--)
      { replaceRange(cm.doc, val, newBreaks[i], Pos(newBreaks[i].line, newBreaks[i].ch + val.length)); }
  });
  option("specialChars", /[\u0000-\u001f\u007f-\u009f\u00ad\u061c\u200b-\u200f\u2028\u2029\ufeff]/g, function (cm, val, old) {
    cm.state.specialChars = new RegExp(val.source + (val.test("\t") ? "" : "|\t"), "g");
    if (old != Init) { cm.refresh(); }
  });
  option("specialCharPlaceholder", defaultSpecialCharPlaceholder, function (cm) { return cm.refresh(); }, true);
  option("electricChars", true);
  option("inputStyle", mobile ? "contenteditable" : "textarea", function () {
    throw new Error("inputStyle can not (yet) be changed in a running editor") // FIXME
  }, true);
  option("spellcheck", false, function (cm, val) { return cm.getInputField().spellcheck = val; }, true);
  option("rtlMoveVisually", !windows);
  option("wholeLineUpdateBefore", true);

  option("theme", "default", function (cm) {
    themeChanged(cm);
    guttersChanged(cm);
  }, true);
  option("keyMap", "default", function (cm, val, old) {
    var next = getKeyMap(val);
    var prev = old != Init && getKeyMap(old);
    if (prev && prev.detach) { prev.detach(cm, next); }
    if (next.attach) { next.attach(cm, prev || null); }
  });
  option("extraKeys", null);
  option("configureMouse", null);

  option("lineWrapping", false, wrappingChanged, true);
  option("gutters", [], function (cm) {
    setGuttersForLineNumbers(cm.options);
    guttersChanged(cm);
  }, true);
  option("fixedGutter", true, function (cm, val) {
    cm.display.gutters.style.left = val ? compensateForHScroll(cm.display) + "px" : "0";
    cm.refresh();
  }, true);
  option("coverGutterNextToScrollbar", false, function (cm) { return updateScrollbars(cm); }, true);
  option("scrollbarStyle", "native", function (cm) {
    initScrollbars(cm);
    updateScrollbars(cm);
    cm.display.scrollbars.setScrollTop(cm.doc.scrollTop);
    cm.display.scrollbars.setScrollLeft(cm.doc.scrollLeft);
  }, true);
  option("lineNumbers", false, function (cm) {
    setGuttersForLineNumbers(cm.options);
    guttersChanged(cm);
  }, true);
  option("firstLineNumber", 1, guttersChanged, true);
  option("lineNumberFormatter", function (integer) { return integer; }, guttersChanged, true);
  option("showCursorWhenSelecting", false, updateSelection, true);

  option("resetSelectionOnContextMenu", true);
  option("lineWiseCopyCut", true);
  option("pasteLinesPerSelection", true);

  option("readOnly", false, function (cm, val) {
    if (val == "nocursor") {
      onBlur(cm);
      cm.display.input.blur();
    }
    cm.display.input.readOnlyChanged(val);
  });
  option("disableInput", false, function (cm, val) {if (!val) { cm.display.input.reset(); }}, true);
  option("dragDrop", true, dragDropChanged);
  option("allowDropFileTypes", null);

  option("cursorBlinkRate", 530);
  option("cursorScrollMargin", 0);
  option("cursorHeight", 1, updateSelection, true);
  option("singleCursorHeightPerLine", true, updateSelection, true);
  option("workTime", 100);
  option("workDelay", 100);
  option("flattenSpans", true, resetModeState, true);
  option("addModeClass", false, resetModeState, true);
  option("pollInterval", 100);
  option("undoDepth", 200, function (cm, val) { return cm.doc.history.undoDepth = val; });
  option("historyEventDelay", 1250);
  option("viewportMargin", 10, function (cm) { return cm.refresh(); }, true);
  option("maxHighlightLength", 10000, resetModeState, true);
  option("moveInputWithCursor", true, function (cm, val) {
    if (!val) { cm.display.input.resetPosition(); }
  });

  option("tabindex", null, function (cm, val) { return cm.display.input.getField().tabIndex = val || ""; });
  option("autofocus", null);
  option("direction", "ltr", function (cm, val) { return cm.doc.setDirection(val); }, true);
}

function guttersChanged(cm) {
  updateGutters(cm);
  regChange(cm);
  alignHorizontally(cm);
}

function dragDropChanged(cm, value, old) {
  var wasOn = old && old != Init;
  if (!value != !wasOn) {
    var funcs = cm.display.dragFunctions;
    var toggle = value ? on : off;
    toggle(cm.display.scroller, "dragstart", funcs.start);
    toggle(cm.display.scroller, "dragenter", funcs.enter);
    toggle(cm.display.scroller, "dragover", funcs.over);
    toggle(cm.display.scroller, "dragleave", funcs.leave);
    toggle(cm.display.scroller, "drop", funcs.drop);
  }
}

function wrappingChanged(cm) {
  if (cm.options.lineWrapping) {
    addClass(cm.display.wrapper, "CodeMirror-wrap");
    cm.display.sizer.style.minWidth = "";
    cm.display.sizerWidth = null;
  } else {
    rmClass(cm.display.wrapper, "CodeMirror-wrap");
    findMaxLine(cm);
  }
  estimateLineHeights(cm);
  regChange(cm);
  clearCaches(cm);
  setTimeout(function () { return updateScrollbars(cm); }, 100);
}

// A CodeMirror instance represents an editor. This is the object
// that user code is usually dealing with.

function CodeMirror$1(place, options) {
  var this$1 = this;

  if (!(this instanceof CodeMirror$1)) { return new CodeMirror$1(place, options) }

  this.options = options = options ? copyObj(options) : {};
  // Determine effective options based on given values and defaults.
  copyObj(defaults, options, false);
  setGuttersForLineNumbers(options);

  var doc = options.value;
  if (typeof doc == "string") { doc = new Doc(doc, options.mode, null, options.lineSeparator, options.direction); }
  else if (options.mode) { doc.modeOption = options.mode; }
  this.doc = doc;

  var input = new CodeMirror$1.inputStyles[options.inputStyle](this);
  var display = this.display = new Display(place, doc, input);
  display.wrapper.CodeMirror = this;
  updateGutters(this);
  themeChanged(this);
  if (options.lineWrapping)
    { this.display.wrapper.className += " CodeMirror-wrap"; }
  initScrollbars(this);

  this.state = {
    keyMaps: [],  // stores maps added by addKeyMap
    overlays: [], // highlighting overlays, as added by addOverlay
    modeGen: 0,   // bumped when mode/overlay changes, used to invalidate highlighting info
    overwrite: false,
    delayingBlurEvent: false,
    focused: false,
    suppressEdits: false, // used to disable editing during key handlers when in readOnly mode
    pasteIncoming: false, cutIncoming: false, // help recognize paste/cut edits in input.poll
    selectingText: false,
    draggingText: false,
    highlight: new Delayed(), // stores highlight worker timeout
    keySeq: null,  // Unfinished key sequence
    specialChars: null
  };

  if (options.autofocus && !mobile) { display.input.focus(); }

  // Override magic textarea content restore that IE sometimes does
  // on our hidden textarea on reload
  if (ie && ie_version < 11) { setTimeout(function () { return this$1.display.input.reset(true); }, 20); }

  registerEventHandlers(this);
  ensureGlobalHandlers();

  startOperation(this);
  this.curOp.forceUpdate = true;
  attachDoc(this, doc);

  if ((options.autofocus && !mobile) || this.hasFocus())
    { setTimeout(bind(onFocus, this), 20); }
  else
    { onBlur(this); }

  for (var opt in optionHandlers) { if (optionHandlers.hasOwnProperty(opt))
    { optionHandlers[opt](this$1, options[opt], Init); } }
  maybeUpdateLineNumberWidth(this);
  if (options.finishInit) { options.finishInit(this); }
  for (var i = 0; i < initHooks.length; ++i) { initHooks[i](this$1); }
  endOperation(this);
  // Suppress optimizelegibility in Webkit, since it breaks text
  // measuring on line wrapping boundaries.
  if (webkit && options.lineWrapping &&
      getComputedStyle(display.lineDiv).textRendering == "optimizelegibility")
    { display.lineDiv.style.textRendering = "auto"; }
}

// The default configuration options.
CodeMirror$1.defaults = defaults;
// Functions to run when options are changed.
CodeMirror$1.optionHandlers = optionHandlers;

// Attach the necessary event handlers when initializing the editor
function registerEventHandlers(cm) {
  var d = cm.display;
  on(d.scroller, "mousedown", operation(cm, onMouseDown));
  // Older IE's will not fire a second mousedown for a double click
  if (ie && ie_version < 11)
    { on(d.scroller, "dblclick", operation(cm, function (e) {
      if (signalDOMEvent(cm, e)) { return }
      var pos = posFromMouse(cm, e);
      if (!pos || clickInGutter(cm, e) || eventInWidget(cm.display, e)) { return }
      e_preventDefault(e);
      var word = cm.findWordAt(pos);
      extendSelection(cm.doc, word.anchor, word.head);
    })); }
  else
    { on(d.scroller, "dblclick", function (e) { return signalDOMEvent(cm, e) || e_preventDefault(e); }); }
  // Some browsers fire contextmenu *after* opening the menu, at
  // which point we can't mess with it anymore. Context menu is
  // handled in onMouseDown for these browsers.
  if (!captureRightClick) { on(d.scroller, "contextmenu", function (e) { return onContextMenu(cm, e); }); }

  // Used to suppress mouse event handling when a touch happens
  var touchFinished, prevTouch = {end: 0};
  function finishTouch() {
    if (d.activeTouch) {
      touchFinished = setTimeout(function () { return d.activeTouch = null; }, 1000);
      prevTouch = d.activeTouch;
      prevTouch.end = +new Date;
    }
  }
  function isMouseLikeTouchEvent(e) {
    if (e.touches.length != 1) { return false }
    var touch = e.touches[0];
    return touch.radiusX <= 1 && touch.radiusY <= 1
  }
  function farAway(touch, other) {
    if (other.left == null) { return true }
    var dx = other.left - touch.left, dy = other.top - touch.top;
    return dx * dx + dy * dy > 20 * 20
  }
  on(d.scroller, "touchstart", function (e) {
    if (!signalDOMEvent(cm, e) && !isMouseLikeTouchEvent(e) && !clickInGutter(cm, e)) {
      d.input.ensurePolled();
      clearTimeout(touchFinished);
      var now = +new Date;
      d.activeTouch = {start: now, moved: false,
                       prev: now - prevTouch.end <= 300 ? prevTouch : null};
      if (e.touches.length == 1) {
        d.activeTouch.left = e.touches[0].pageX;
        d.activeTouch.top = e.touches[0].pageY;
      }
    }
  });
  on(d.scroller, "touchmove", function () {
    if (d.activeTouch) { d.activeTouch.moved = true; }
  });
  on(d.scroller, "touchend", function (e) {
    var touch = d.activeTouch;
    if (touch && !eventInWidget(d, e) && touch.left != null &&
        !touch.moved && new Date - touch.start < 300) {
      var pos = cm.coordsChar(d.activeTouch, "page"), range;
      if (!touch.prev || farAway(touch, touch.prev)) // Single tap
        { range = new Range(pos, pos); }
      else if (!touch.prev.prev || farAway(touch, touch.prev.prev)) // Double tap
        { range = cm.findWordAt(pos); }
      else // Triple tap
        { range = new Range(Pos(pos.line, 0), clipPos(cm.doc, Pos(pos.line + 1, 0))); }
      cm.setSelection(range.anchor, range.head);
      cm.focus();
      e_preventDefault(e);
    }
    finishTouch();
  });
  on(d.scroller, "touchcancel", finishTouch);

  // Sync scrolling between fake scrollbars and real scrollable
  // area, ensure viewport is updated when scrolling.
  on(d.scroller, "scroll", function () {
    if (d.scroller.clientHeight) {
      updateScrollTop(cm, d.scroller.scrollTop);
      setScrollLeft(cm, d.scroller.scrollLeft, true);
      signal(cm, "scroll", cm);
    }
  });

  // Listen to wheel events in order to try and update the viewport on time.
  on(d.scroller, "mousewheel", function (e) { return onScrollWheel(cm, e); });
  on(d.scroller, "DOMMouseScroll", function (e) { return onScrollWheel(cm, e); });

  // Prevent wrapper from ever scrolling
  on(d.wrapper, "scroll", function () { return d.wrapper.scrollTop = d.wrapper.scrollLeft = 0; });

  d.dragFunctions = {
    enter: function (e) {if (!signalDOMEvent(cm, e)) { e_stop(e); }},
    over: function (e) {if (!signalDOMEvent(cm, e)) { onDragOver(cm, e); e_stop(e); }},
    start: function (e) { return onDragStart(cm, e); },
    drop: operation(cm, onDrop),
    leave: function (e) {if (!signalDOMEvent(cm, e)) { clearDragCursor(cm); }}
  };

  var inp = d.input.getField();
  on(inp, "keyup", function (e) { return onKeyUp.call(cm, e); });
  on(inp, "keydown", operation(cm, onKeyDown));
  on(inp, "keypress", operation(cm, onKeyPress));
  on(inp, "focus", function (e) { return onFocus(cm, e); });
  on(inp, "blur", function (e) { return onBlur(cm, e); });
}

var initHooks = [];
CodeMirror$1.defineInitHook = function (f) { return initHooks.push(f); };

// Indent the given line. The how parameter can be "smart",
// "add"/null, "subtract", or "prev". When aggressive is false
// (typically set to true for forced single-line indents), empty
// lines are not indented, and places where the mode returns Pass
// are left alone.
function indentLine(cm, n, how, aggressive) {
  var doc = cm.doc, state;
  if (how == null) { how = "add"; }
  if (how == "smart") {
    // Fall back to "prev" when the mode doesn't have an indentation
    // method.
    if (!doc.mode.indent) { how = "prev"; }
    else { state = getContextBefore(cm, n).state; }
  }

  var tabSize = cm.options.tabSize;
  var line = getLine(doc, n), curSpace = countColumn(line.text, null, tabSize);
  if (line.stateAfter) { line.stateAfter = null; }
  var curSpaceString = line.text.match(/^\s*/)[0], indentation;
  if (!aggressive && !/\S/.test(line.text)) {
    indentation = 0;
    how = "not";
  } else if (how == "smart") {
    indentation = doc.mode.indent(state, line.text.slice(curSpaceString.length), line.text);
    if (indentation == Pass || indentation > 150) {
      if (!aggressive) { return }
      how = "prev";
    }
  }
  if (how == "prev") {
    if (n > doc.first) { indentation = countColumn(getLine(doc, n-1).text, null, tabSize); }
    else { indentation = 0; }
  } else if (how == "add") {
    indentation = curSpace + cm.options.indentUnit;
  } else if (how == "subtract") {
    indentation = curSpace - cm.options.indentUnit;
  } else if (typeof how == "number") {
    indentation = curSpace + how;
  }
  indentation = Math.max(0, indentation);

  var indentString = "", pos = 0;
  if (cm.options.indentWithTabs)
    { for (var i = Math.floor(indentation / tabSize); i; --i) {pos += tabSize; indentString += "\t";} }
  if (pos < indentation) { indentString += spaceStr(indentation - pos); }

  if (indentString != curSpaceString) {
    replaceRange(doc, indentString, Pos(n, 0), Pos(n, curSpaceString.length), "+input");
    line.stateAfter = null;
    return true
  } else {
    // Ensure that, if the cursor was in the whitespace at the start
    // of the line, it is moved to the end of that space.
    for (var i$1 = 0; i$1 < doc.sel.ranges.length; i$1++) {
      var range = doc.sel.ranges[i$1];
      if (range.head.line == n && range.head.ch < curSpaceString.length) {
        var pos$1 = Pos(n, curSpaceString.length);
        replaceOneSelection(doc, i$1, new Range(pos$1, pos$1));
        break
      }
    }
  }
}

// This will be set to a {lineWise: bool, text: [string]} object, so
// that, when pasting, we know what kind of selections the copied
// text was made out of.
var lastCopied = null;

function setLastCopied(newLastCopied) {
  lastCopied = newLastCopied;
}

function applyTextInput(cm, inserted, deleted, sel, origin) {
  var doc = cm.doc;
  cm.display.shift = false;
  if (!sel) { sel = doc.sel; }

  var paste = cm.state.pasteIncoming || origin == "paste";
  var textLines = splitLinesAuto(inserted), multiPaste = null;
  // When pasting N lines into N selections, insert one line per selection
  if (paste && sel.ranges.length > 1) {
    if (lastCopied && lastCopied.text.join("\n") == inserted) {
      if (sel.ranges.length % lastCopied.text.length == 0) {
        multiPaste = [];
        for (var i = 0; i < lastCopied.text.length; i++)
          { multiPaste.push(doc.splitLines(lastCopied.text[i])); }
      }
    } else if (textLines.length == sel.ranges.length && cm.options.pasteLinesPerSelection) {
      multiPaste = map(textLines, function (l) { return [l]; });
    }
  }

  var updateInput;
  // Normal behavior is to insert the new text into every selection
  for (var i$1 = sel.ranges.length - 1; i$1 >= 0; i$1--) {
    var range$$1 = sel.ranges[i$1];
    var from = range$$1.from(), to = range$$1.to();
    if (range$$1.empty()) {
      if (deleted && deleted > 0) // Handle deletion
        { from = Pos(from.line, from.ch - deleted); }
      else if (cm.state.overwrite && !paste) // Handle overwrite
        { to = Pos(to.line, Math.min(getLine(doc, to.line).text.length, to.ch + lst(textLines).length)); }
      else if (lastCopied && lastCopied.lineWise && lastCopied.text.join("\n") == inserted)
        { from = to = Pos(from.line, 0); }
    }
    updateInput = cm.curOp.updateInput;
    var changeEvent = {from: from, to: to, text: multiPaste ? multiPaste[i$1 % multiPaste.length] : textLines,
                       origin: origin || (paste ? "paste" : cm.state.cutIncoming ? "cut" : "+input")};
    makeChange(cm.doc, changeEvent);
    signalLater(cm, "inputRead", cm, changeEvent);
  }
  if (inserted && !paste)
    { triggerElectric(cm, inserted); }

  ensureCursorVisible(cm);
  cm.curOp.updateInput = updateInput;
  cm.curOp.typing = true;
  cm.state.pasteIncoming = cm.state.cutIncoming = false;
}

function handlePaste(e, cm) {
  var pasted = e.clipboardData && e.clipboardData.getData("Text");
  if (pasted) {
    e.preventDefault();
    if (!cm.isReadOnly() && !cm.options.disableInput)
      { runInOp(cm, function () { return applyTextInput(cm, pasted, 0, null, "paste"); }); }
    return true
  }
}

function triggerElectric(cm, inserted) {
  // When an 'electric' character is inserted, immediately trigger a reindent
  if (!cm.options.electricChars || !cm.options.smartIndent) { return }
  var sel = cm.doc.sel;

  for (var i = sel.ranges.length - 1; i >= 0; i--) {
    var range$$1 = sel.ranges[i];
    if (range$$1.head.ch > 100 || (i && sel.ranges[i - 1].head.line == range$$1.head.line)) { continue }
    var mode = cm.getModeAt(range$$1.head);
    var indented = false;
    if (mode.electricChars) {
      for (var j = 0; j < mode.electricChars.length; j++)
        { if (inserted.indexOf(mode.electricChars.charAt(j)) > -1) {
          indented = indentLine(cm, range$$1.head.line, "smart");
          break
        } }
    } else if (mode.electricInput) {
      if (mode.electricInput.test(getLine(cm.doc, range$$1.head.line).text.slice(0, range$$1.head.ch)))
        { indented = indentLine(cm, range$$1.head.line, "smart"); }
    }
    if (indented) { signalLater(cm, "electricInput", cm, range$$1.head.line); }
  }
}

function copyableRanges(cm) {
  var text = [], ranges = [];
  for (var i = 0; i < cm.doc.sel.ranges.length; i++) {
    var line = cm.doc.sel.ranges[i].head.line;
    var lineRange = {anchor: Pos(line, 0), head: Pos(line + 1, 0)};
    ranges.push(lineRange);
    text.push(cm.getRange(lineRange.anchor, lineRange.head));
  }
  return {text: text, ranges: ranges}
}

function disableBrowserMagic(field, spellcheck) {
  field.setAttribute("autocorrect", "off");
  field.setAttribute("autocapitalize", "off");
  field.setAttribute("spellcheck", !!spellcheck);
}

function hiddenTextarea() {
  var te = elt("textarea", null, null, "position: absolute; bottom: -1em; padding: 0; width: 1px; height: 1em; outline: none");
  var div = elt("div", [te], null, "overflow: hidden; position: relative; width: 3px; height: 0px;");
  // The textarea is kept positioned near the cursor to prevent the
  // fact that it'll be scrolled into view on input from scrolling
  // our fake cursor out of view. On webkit, when wrap=off, paste is
  // very slow. So make the area wide instead.
  if (webkit) { te.style.width = "1000px"; }
  else { te.setAttribute("wrap", "off"); }
  // If border: 0; -- iOS fails to open keyboard (issue #1287)
  if (ios) { te.style.border = "1px solid black"; }
  disableBrowserMagic(te);
  return div
}

// The publicly visible API. Note that methodOp(f) means
// 'wrap f in an operation, performed on its `this` parameter'.

// This is not the complete set of editor methods. Most of the
// methods defined on the Doc type are also injected into
// CodeMirror.prototype, for backwards compatibility and
// convenience.

var addEditorMethods = function(CodeMirror) {
  var optionHandlers = CodeMirror.optionHandlers;

  var helpers = CodeMirror.helpers = {};

  CodeMirror.prototype = {
    constructor: CodeMirror,
    focus: function(){window.focus(); this.display.input.focus();},

    setOption: function(option, value) {
      var options = this.options, old = options[option];
      if (options[option] == value && option != "mode") { return }
      options[option] = value;
      if (optionHandlers.hasOwnProperty(option))
        { operation(this, optionHandlers[option])(this, value, old); }
      signal(this, "optionChange", this, option);
    },

    getOption: function(option) {return this.options[option]},
    getDoc: function() {return this.doc},

    addKeyMap: function(map$$1, bottom) {
      this.state.keyMaps[bottom ? "push" : "unshift"](getKeyMap(map$$1));
    },
    removeKeyMap: function(map$$1) {
      var maps = this.state.keyMaps;
      for (var i = 0; i < maps.length; ++i)
        { if (maps[i] == map$$1 || maps[i].name == map$$1) {
          maps.splice(i, 1);
          return true
        } }
    },

    addOverlay: methodOp(function(spec, options) {
      var mode = spec.token ? spec : CodeMirror.getMode(this.options, spec);
      if (mode.startState) { throw new Error("Overlays may not be stateful.") }
      insertSorted(this.state.overlays,
                   {mode: mode, modeSpec: spec, opaque: options && options.opaque,
                    priority: (options && options.priority) || 0},
                   function (overlay) { return overlay.priority; });
      this.state.modeGen++;
      regChange(this);
    }),
    removeOverlay: methodOp(function(spec) {
      var this$1 = this;

      var overlays = this.state.overlays;
      for (var i = 0; i < overlays.length; ++i) {
        var cur = overlays[i].modeSpec;
        if (cur == spec || typeof spec == "string" && cur.name == spec) {
          overlays.splice(i, 1);
          this$1.state.modeGen++;
          regChange(this$1);
          return
        }
      }
    }),

    indentLine: methodOp(function(n, dir, aggressive) {
      if (typeof dir != "string" && typeof dir != "number") {
        if (dir == null) { dir = this.options.smartIndent ? "smart" : "prev"; }
        else { dir = dir ? "add" : "subtract"; }
      }
      if (isLine(this.doc, n)) { indentLine(this, n, dir, aggressive); }
    }),
    indentSelection: methodOp(function(how) {
      var this$1 = this;

      var ranges = this.doc.sel.ranges, end = -1;
      for (var i = 0; i < ranges.length; i++) {
        var range$$1 = ranges[i];
        if (!range$$1.empty()) {
          var from = range$$1.from(), to = range$$1.to();
          var start = Math.max(end, from.line);
          end = Math.min(this$1.lastLine(), to.line - (to.ch ? 0 : 1)) + 1;
          for (var j = start; j < end; ++j)
            { indentLine(this$1, j, how); }
          var newRanges = this$1.doc.sel.ranges;
          if (from.ch == 0 && ranges.length == newRanges.length && newRanges[i].from().ch > 0)
            { replaceOneSelection(this$1.doc, i, new Range(from, newRanges[i].to()), sel_dontScroll); }
        } else if (range$$1.head.line > end) {
          indentLine(this$1, range$$1.head.line, how, true);
          end = range$$1.head.line;
          if (i == this$1.doc.sel.primIndex) { ensureCursorVisible(this$1); }
        }
      }
    }),

    // Fetch the parser token for a given character. Useful for hacks
    // that want to inspect the mode state (say, for completion).
    getTokenAt: function(pos, precise) {
      return takeToken(this, pos, precise)
    },

    getLineTokens: function(line, precise) {
      return takeToken(this, Pos(line), precise, true)
    },

    getTokenTypeAt: function(pos) {
      pos = clipPos(this.doc, pos);
      var styles = getLineStyles(this, getLine(this.doc, pos.line));
      var before = 0, after = (styles.length - 1) / 2, ch = pos.ch;
      var type;
      if (ch == 0) { type = styles[2]; }
      else { for (;;) {
        var mid = (before + after) >> 1;
        if ((mid ? styles[mid * 2 - 1] : 0) >= ch) { after = mid; }
        else if (styles[mid * 2 + 1] < ch) { before = mid + 1; }
        else { type = styles[mid * 2 + 2]; break }
      } }
      var cut = type ? type.indexOf("overlay ") : -1;
      return cut < 0 ? type : cut == 0 ? null : type.slice(0, cut - 1)
    },

    getModeAt: function(pos) {
      var mode = this.doc.mode;
      if (!mode.innerMode) { return mode }
      return CodeMirror.innerMode(mode, this.getTokenAt(pos).state).mode
    },

    getHelper: function(pos, type) {
      return this.getHelpers(pos, type)[0]
    },

    getHelpers: function(pos, type) {
      var this$1 = this;

      var found = [];
      if (!helpers.hasOwnProperty(type)) { return found }
      var help = helpers[type], mode = this.getModeAt(pos);
      if (typeof mode[type] == "string") {
        if (help[mode[type]]) { found.push(help[mode[type]]); }
      } else if (mode[type]) {
        for (var i = 0; i < mode[type].length; i++) {
          var val = help[mode[type][i]];
          if (val) { found.push(val); }
        }
      } else if (mode.helperType && help[mode.helperType]) {
        found.push(help[mode.helperType]);
      } else if (help[mode.name]) {
        found.push(help[mode.name]);
      }
      for (var i$1 = 0; i$1 < help._global.length; i$1++) {
        var cur = help._global[i$1];
        if (cur.pred(mode, this$1) && indexOf(found, cur.val) == -1)
          { found.push(cur.val); }
      }
      return found
    },

    getStateAfter: function(line, precise) {
      var doc = this.doc;
      line = clipLine(doc, line == null ? doc.first + doc.size - 1: line);
      return getContextBefore(this, line + 1, precise).state
    },

    cursorCoords: function(start, mode) {
      var pos, range$$1 = this.doc.sel.primary();
      if (start == null) { pos = range$$1.head; }
      else if (typeof start == "object") { pos = clipPos(this.doc, start); }
      else { pos = start ? range$$1.from() : range$$1.to(); }
      return cursorCoords(this, pos, mode || "page")
    },

    charCoords: function(pos, mode) {
      return charCoords(this, clipPos(this.doc, pos), mode || "page")
    },

    coordsChar: function(coords, mode) {
      coords = fromCoordSystem(this, coords, mode || "page");
      return coordsChar(this, coords.left, coords.top)
    },

    lineAtHeight: function(height, mode) {
      height = fromCoordSystem(this, {top: height, left: 0}, mode || "page").top;
      return lineAtHeight(this.doc, height + this.display.viewOffset)
    },
    heightAtLine: function(line, mode, includeWidgets) {
      var end = false, lineObj;
      if (typeof line == "number") {
        var last = this.doc.first + this.doc.size - 1;
        if (line < this.doc.first) { line = this.doc.first; }
        else if (line > last) { line = last; end = true; }
        lineObj = getLine(this.doc, line);
      } else {
        lineObj = line;
      }
      return intoCoordSystem(this, lineObj, {top: 0, left: 0}, mode || "page", includeWidgets || end).top +
        (end ? this.doc.height - heightAtLine(lineObj) : 0)
    },

    defaultTextHeight: function() { return textHeight(this.display) },
    defaultCharWidth: function() { return charWidth(this.display) },

    getViewport: function() { return {from: this.display.viewFrom, to: this.display.viewTo}},

    addWidget: function(pos, node, scroll, vert, horiz) {
      var display = this.display;
      pos = cursorCoords(this, clipPos(this.doc, pos));
      var top = pos.bottom, left = pos.left;
      node.style.position = "absolute";
      node.setAttribute("cm-ignore-events", "true");
      this.display.input.setUneditable(node);
      display.sizer.appendChild(node);
      if (vert == "over") {
        top = pos.top;
      } else if (vert == "above" || vert == "near") {
        var vspace = Math.max(display.wrapper.clientHeight, this.doc.height),
        hspace = Math.max(display.sizer.clientWidth, display.lineSpace.clientWidth);
        // Default to positioning above (if specified and possible); otherwise default to positioning below
        if ((vert == 'above' || pos.bottom + node.offsetHeight > vspace) && pos.top > node.offsetHeight)
          { top = pos.top - node.offsetHeight; }
        else if (pos.bottom + node.offsetHeight <= vspace)
          { top = pos.bottom; }
        if (left + node.offsetWidth > hspace)
          { left = hspace - node.offsetWidth; }
      }
      node.style.top = top + "px";
      node.style.left = node.style.right = "";
      if (horiz == "right") {
        left = display.sizer.clientWidth - node.offsetWidth;
        node.style.right = "0px";
      } else {
        if (horiz == "left") { left = 0; }
        else if (horiz == "middle") { left = (display.sizer.clientWidth - node.offsetWidth) / 2; }
        node.style.left = left + "px";
      }
      if (scroll)
        { scrollIntoView(this, {left: left, top: top, right: left + node.offsetWidth, bottom: top + node.offsetHeight}); }
    },

    triggerOnKeyDown: methodOp(onKeyDown),
    triggerOnKeyPress: methodOp(onKeyPress),
    triggerOnKeyUp: onKeyUp,
    triggerOnMouseDown: methodOp(onMouseDown),

    execCommand: function(cmd) {
      if (commands.hasOwnProperty(cmd))
        { return commands[cmd].call(null, this) }
    },

    triggerElectric: methodOp(function(text) { triggerElectric(this, text); }),

    findPosH: function(from, amount, unit, visually) {
      var this$1 = this;

      var dir = 1;
      if (amount < 0) { dir = -1; amount = -amount; }
      var cur = clipPos(this.doc, from);
      for (var i = 0; i < amount; ++i) {
        cur = findPosH(this$1.doc, cur, dir, unit, visually);
        if (cur.hitSide) { break }
      }
      return cur
    },

    moveH: methodOp(function(dir, unit) {
      var this$1 = this;

      this.extendSelectionsBy(function (range$$1) {
        if (this$1.display.shift || this$1.doc.extend || range$$1.empty())
          { return findPosH(this$1.doc, range$$1.head, dir, unit, this$1.options.rtlMoveVisually) }
        else
          { return dir < 0 ? range$$1.from() : range$$1.to() }
      }, sel_move);
    }),

    deleteH: methodOp(function(dir, unit) {
      var sel = this.doc.sel, doc = this.doc;
      if (sel.somethingSelected())
        { doc.replaceSelection("", null, "+delete"); }
      else
        { deleteNearSelection(this, function (range$$1) {
          var other = findPosH(doc, range$$1.head, dir, unit, false);
          return dir < 0 ? {from: other, to: range$$1.head} : {from: range$$1.head, to: other}
        }); }
    }),

    findPosV: function(from, amount, unit, goalColumn) {
      var this$1 = this;

      var dir = 1, x = goalColumn;
      if (amount < 0) { dir = -1; amount = -amount; }
      var cur = clipPos(this.doc, from);
      for (var i = 0; i < amount; ++i) {
        var coords = cursorCoords(this$1, cur, "div");
        if (x == null) { x = coords.left; }
        else { coords.left = x; }
        cur = findPosV(this$1, coords, dir, unit);
        if (cur.hitSide) { break }
      }
      return cur
    },

    moveV: methodOp(function(dir, unit) {
      var this$1 = this;

      var doc = this.doc, goals = [];
      var collapse = !this.display.shift && !doc.extend && doc.sel.somethingSelected();
      doc.extendSelectionsBy(function (range$$1) {
        if (collapse)
          { return dir < 0 ? range$$1.from() : range$$1.to() }
        var headPos = cursorCoords(this$1, range$$1.head, "div");
        if (range$$1.goalColumn != null) { headPos.left = range$$1.goalColumn; }
        goals.push(headPos.left);
        var pos = findPosV(this$1, headPos, dir, unit);
        if (unit == "page" && range$$1 == doc.sel.primary())
          { addToScrollTop(this$1, charCoords(this$1, pos, "div").top - headPos.top); }
        return pos
      }, sel_move);
      if (goals.length) { for (var i = 0; i < doc.sel.ranges.length; i++)
        { doc.sel.ranges[i].goalColumn = goals[i]; } }
    }),

    // Find the word at the given position (as returned by coordsChar).
    findWordAt: function(pos) {
      var doc = this.doc, line = getLine(doc, pos.line).text;
      var start = pos.ch, end = pos.ch;
      if (line) {
        var helper = this.getHelper(pos, "wordChars");
        if ((pos.sticky == "before" || end == line.length) && start) { --start; } else { ++end; }
        var startChar = line.charAt(start);
        var check = isWordChar(startChar, helper)
          ? function (ch) { return isWordChar(ch, helper); }
          : /\s/.test(startChar) ? function (ch) { return /\s/.test(ch); }
          : function (ch) { return (!/\s/.test(ch) && !isWordChar(ch)); };
        while (start > 0 && check(line.charAt(start - 1))) { --start; }
        while (end < line.length && check(line.charAt(end))) { ++end; }
      }
      return new Range(Pos(pos.line, start), Pos(pos.line, end))
    },

    toggleOverwrite: function(value) {
      if (value != null && value == this.state.overwrite) { return }
      if (this.state.overwrite = !this.state.overwrite)
        { addClass(this.display.cursorDiv, "CodeMirror-overwrite"); }
      else
        { rmClass(this.display.cursorDiv, "CodeMirror-overwrite"); }

      signal(this, "overwriteToggle", this, this.state.overwrite);
    },
    hasFocus: function() { return this.display.input.getField() == activeElt() },
    isReadOnly: function() { return !!(this.options.readOnly || this.doc.cantEdit) },

    scrollTo: methodOp(function (x, y) { scrollToCoords(this, x, y); }),
    getScrollInfo: function() {
      var scroller = this.display.scroller;
      return {left: scroller.scrollLeft, top: scroller.scrollTop,
              height: scroller.scrollHeight - scrollGap(this) - this.display.barHeight,
              width: scroller.scrollWidth - scrollGap(this) - this.display.barWidth,
              clientHeight: displayHeight(this), clientWidth: displayWidth(this)}
    },

    scrollIntoView: methodOp(function(range$$1, margin) {
      if (range$$1 == null) {
        range$$1 = {from: this.doc.sel.primary().head, to: null};
        if (margin == null) { margin = this.options.cursorScrollMargin; }
      } else if (typeof range$$1 == "number") {
        range$$1 = {from: Pos(range$$1, 0), to: null};
      } else if (range$$1.from == null) {
        range$$1 = {from: range$$1, to: null};
      }
      if (!range$$1.to) { range$$1.to = range$$1.from; }
      range$$1.margin = margin || 0;

      if (range$$1.from.line != null) {
        scrollToRange(this, range$$1);
      } else {
        scrollToCoordsRange(this, range$$1.from, range$$1.to, range$$1.margin);
      }
    }),

    setSize: methodOp(function(width, height) {
      var this$1 = this;

      var interpret = function (val) { return typeof val == "number" || /^\d+$/.test(String(val)) ? val + "px" : val; };
      if (width != null) { this.display.wrapper.style.width = interpret(width); }
      if (height != null) { this.display.wrapper.style.height = interpret(height); }
      if (this.options.lineWrapping) { clearLineMeasurementCache(this); }
      var lineNo$$1 = this.display.viewFrom;
      this.doc.iter(lineNo$$1, this.display.viewTo, function (line) {
        if (line.widgets) { for (var i = 0; i < line.widgets.length; i++)
          { if (line.widgets[i].noHScroll) { regLineChange(this$1, lineNo$$1, "widget"); break } } }
        ++lineNo$$1;
      });
      this.curOp.forceUpdate = true;
      signal(this, "refresh", this);
    }),

    operation: function(f){return runInOp(this, f)},
    startOperation: function(){return startOperation(this)},
    endOperation: function(){return endOperation(this)},

    refresh: methodOp(function() {
      var oldHeight = this.display.cachedTextHeight;
      regChange(this);
      this.curOp.forceUpdate = true;
      clearCaches(this);
      scrollToCoords(this, this.doc.scrollLeft, this.doc.scrollTop);
      updateGutterSpace(this);
      if (oldHeight == null || Math.abs(oldHeight - textHeight(this.display)) > .5)
        { estimateLineHeights(this); }
      signal(this, "refresh", this);
    }),

    swapDoc: methodOp(function(doc) {
      var old = this.doc;
      old.cm = null;
      attachDoc(this, doc);
      clearCaches(this);
      this.display.input.reset();
      scrollToCoords(this, doc.scrollLeft, doc.scrollTop);
      this.curOp.forceScroll = true;
      signalLater(this, "swapDoc", this, old);
      return old
    }),

    getInputField: function(){return this.display.input.getField()},
    getWrapperElement: function(){return this.display.wrapper},
    getScrollerElement: function(){return this.display.scroller},
    getGutterElement: function(){return this.display.gutters}
  };
  eventMixin(CodeMirror);

  CodeMirror.registerHelper = function(type, name, value) {
    if (!helpers.hasOwnProperty(type)) { helpers[type] = CodeMirror[type] = {_global: []}; }
    helpers[type][name] = value;
  };
  CodeMirror.registerGlobalHelper = function(type, name, predicate, value) {
    CodeMirror.registerHelper(type, name, value);
    helpers[type]._global.push({pred: predicate, val: value});
  };
};

// Used for horizontal relative motion. Dir is -1 or 1 (left or
// right), unit can be "char", "column" (like char, but doesn't
// cross line boundaries), "word" (across next word), or "group" (to
// the start of next group of word or non-word-non-whitespace
// chars). The visually param controls whether, in right-to-left
// text, direction 1 means to move towards the next index in the
// string, or towards the character to the right of the current
// position. The resulting position will have a hitSide=true
// property if it reached the end of the document.
function findPosH(doc, pos, dir, unit, visually) {
  var oldPos = pos;
  var origDir = dir;
  var lineObj = getLine(doc, pos.line);
  function findNextLine() {
    var l = pos.line + dir;
    if (l < doc.first || l >= doc.first + doc.size) { return false }
    pos = new Pos(l, pos.ch, pos.sticky);
    return lineObj = getLine(doc, l)
  }
  function moveOnce(boundToLine) {
    var next;
    if (visually) {
      next = moveVisually(doc.cm, lineObj, pos, dir);
    } else {
      next = moveLogically(lineObj, pos, dir);
    }
    if (next == null) {
      if (!boundToLine && findNextLine())
        { pos = endOfLine(visually, doc.cm, lineObj, pos.line, dir); }
      else
        { return false }
    } else {
      pos = next;
    }
    return true
  }

  if (unit == "char") {
    moveOnce();
  } else if (unit == "column") {
    moveOnce(true);
  } else if (unit == "word" || unit == "group") {
    var sawType = null, group = unit == "group";
    var helper = doc.cm && doc.cm.getHelper(pos, "wordChars");
    for (var first = true;; first = false) {
      if (dir < 0 && !moveOnce(!first)) { break }
      var cur = lineObj.text.charAt(pos.ch) || "\n";
      var type = isWordChar(cur, helper) ? "w"
        : group && cur == "\n" ? "n"
        : !group || /\s/.test(cur) ? null
        : "p";
      if (group && !first && !type) { type = "s"; }
      if (sawType && sawType != type) {
        if (dir < 0) {dir = 1; moveOnce(); pos.sticky = "after";}
        break
      }

      if (type) { sawType = type; }
      if (dir > 0 && !moveOnce(!first)) { break }
    }
  }
  var result = skipAtomic(doc, pos, oldPos, origDir, true);
  if (equalCursorPos(oldPos, result)) { result.hitSide = true; }
  return result
}

// For relative vertical movement. Dir may be -1 or 1. Unit can be
// "page" or "line". The resulting position will have a hitSide=true
// property if it reached the end of the document.
function findPosV(cm, pos, dir, unit) {
  var doc = cm.doc, x = pos.left, y;
  if (unit == "page") {
    var pageSize = Math.min(cm.display.wrapper.clientHeight, window.innerHeight || document.documentElement.clientHeight);
    var moveAmount = Math.max(pageSize - .5 * textHeight(cm.display), 3);
    y = (dir > 0 ? pos.bottom : pos.top) + dir * moveAmount;

  } else if (unit == "line") {
    y = dir > 0 ? pos.bottom + 3 : pos.top - 3;
  }
  var target;
  for (;;) {
    target = coordsChar(cm, x, y);
    if (!target.outside) { break }
    if (dir < 0 ? y <= 0 : y >= doc.height) { target.hitSide = true; break }
    y += dir * 5;
  }
  return target
}

// CONTENTEDITABLE INPUT STYLE

var ContentEditableInput = function(cm) {
  this.cm = cm;
  this.lastAnchorNode = this.lastAnchorOffset = this.lastFocusNode = this.lastFocusOffset = null;
  this.polling = new Delayed();
  this.composing = null;
  this.gracePeriod = false;
  this.readDOMTimeout = null;
};

ContentEditableInput.prototype.init = function (display) {
    var this$1 = this;

  var input = this, cm = input.cm;
  var div = input.div = display.lineDiv;
  disableBrowserMagic(div, cm.options.spellcheck);

  on(div, "paste", function (e) {
    if (signalDOMEvent(cm, e) || handlePaste(e, cm)) { return }
    // IE doesn't fire input events, so we schedule a read for the pasted content in this way
    if (ie_version <= 11) { setTimeout(operation(cm, function () { return this$1.updateFromDOM(); }), 20); }
  });

  on(div, "compositionstart", function (e) {
    this$1.composing = {data: e.data, done: false};
  });
  on(div, "compositionupdate", function (e) {
    if (!this$1.composing) { this$1.composing = {data: e.data, done: false}; }
  });
  on(div, "compositionend", function (e) {
    if (this$1.composing) {
      if (e.data != this$1.composing.data) { this$1.readFromDOMSoon(); }
      this$1.composing.done = true;
    }
  });

  on(div, "touchstart", function () { return input.forceCompositionEnd(); });

  on(div, "input", function () {
    if (!this$1.composing) { this$1.readFromDOMSoon(); }
  });

  function onCopyCut(e) {
    if (signalDOMEvent(cm, e)) { return }
    if (cm.somethingSelected()) {
      setLastCopied({lineWise: false, text: cm.getSelections()});
      if (e.type == "cut") { cm.replaceSelection("", null, "cut"); }
    } else if (!cm.options.lineWiseCopyCut) {
      return
    } else {
      var ranges = copyableRanges(cm);
      setLastCopied({lineWise: true, text: ranges.text});
      if (e.type == "cut") {
        cm.operation(function () {
          cm.setSelections(ranges.ranges, 0, sel_dontScroll);
          cm.replaceSelection("", null, "cut");
        });
      }
    }
    if (e.clipboardData) {
      e.clipboardData.clearData();
      var content = lastCopied.text.join("\n");
      // iOS exposes the clipboard API, but seems to discard content inserted into it
      e.clipboardData.setData("Text", content);
      if (e.clipboardData.getData("Text") == content) {
        e.preventDefault();
        return
      }
    }
    // Old-fashioned briefly-focus-a-textarea hack
    var kludge = hiddenTextarea(), te = kludge.firstChild;
    cm.display.lineSpace.insertBefore(kludge, cm.display.lineSpace.firstChild);
    te.value = lastCopied.text.join("\n");
    var hadFocus = document.activeElement;
    selectInput(te);
    setTimeout(function () {
      cm.display.lineSpace.removeChild(kludge);
      hadFocus.focus();
      if (hadFocus == div) { input.showPrimarySelection(); }
    }, 50);
  }
  on(div, "copy", onCopyCut);
  on(div, "cut", onCopyCut);
};

ContentEditableInput.prototype.prepareSelection = function () {
  var result = prepareSelection(this.cm, false);
  result.focus = this.cm.state.focused;
  return result
};

ContentEditableInput.prototype.showSelection = function (info, takeFocus) {
  if (!info || !this.cm.display.view.length) { return }
  if (info.focus || takeFocus) { this.showPrimarySelection(); }
  this.showMultipleSelections(info);
};

ContentEditableInput.prototype.getSelection = function () {
  return this.cm.display.wrapper.ownerDocument.getSelection()
};

ContentEditableInput.prototype.showPrimarySelection = function () {
  var sel = this.getSelection(), cm = this.cm, prim = cm.doc.sel.primary();
  var from = prim.from(), to = prim.to();

  if (cm.display.viewTo == cm.display.viewFrom || from.line >= cm.display.viewTo || to.line < cm.display.viewFrom) {
    sel.removeAllRanges();
    return
  }

  var curAnchor = domToPos(cm, sel.anchorNode, sel.anchorOffset);
  var curFocus = domToPos(cm, sel.focusNode, sel.focusOffset);
  if (curAnchor && !curAnchor.bad && curFocus && !curFocus.bad &&
      cmp(minPos(curAnchor, curFocus), from) == 0 &&
      cmp(maxPos(curAnchor, curFocus), to) == 0)
    { return }

  var view = cm.display.view;
  var start = (from.line >= cm.display.viewFrom && posToDOM(cm, from)) ||
      {node: view[0].measure.map[2], offset: 0};
  var end = to.line < cm.display.viewTo && posToDOM(cm, to);
  if (!end) {
    var measure = view[view.length - 1].measure;
    var map$$1 = measure.maps ? measure.maps[measure.maps.length - 1] : measure.map;
    end = {node: map$$1[map$$1.length - 1], offset: map$$1[map$$1.length - 2] - map$$1[map$$1.length - 3]};
  }

  if (!start || !end) {
    sel.removeAllRanges();
    return
  }

  var old = sel.rangeCount && sel.getRangeAt(0), rng;
  try { rng = range(start.node, start.offset, end.offset, end.node); }
  catch(e) {} // Our model of the DOM might be outdated, in which case the range we try to set can be impossible
  if (rng) {
    if (!gecko && cm.state.focused) {
      sel.collapse(start.node, start.offset);
      if (!rng.collapsed) {
        sel.removeAllRanges();
        sel.addRange(rng);
      }
    } else {
      sel.removeAllRanges();
      sel.addRange(rng);
    }
    if (old && sel.anchorNode == null) { sel.addRange(old); }
    else if (gecko) { this.startGracePeriod(); }
  }
  this.rememberSelection();
};

ContentEditableInput.prototype.startGracePeriod = function () {
    var this$1 = this;

  clearTimeout(this.gracePeriod);
  this.gracePeriod = setTimeout(function () {
    this$1.gracePeriod = false;
    if (this$1.selectionChanged())
      { this$1.cm.operation(function () { return this$1.cm.curOp.selectionChanged = true; }); }
  }, 20);
};

ContentEditableInput.prototype.showMultipleSelections = function (info) {
  removeChildrenAndAdd(this.cm.display.cursorDiv, info.cursors);
  removeChildrenAndAdd(this.cm.display.selectionDiv, info.selection);
};

ContentEditableInput.prototype.rememberSelection = function () {
  var sel = this.getSelection();
  this.lastAnchorNode = sel.anchorNode; this.lastAnchorOffset = sel.anchorOffset;
  this.lastFocusNode = sel.focusNode; this.lastFocusOffset = sel.focusOffset;
};

ContentEditableInput.prototype.selectionInEditor = function () {
  var sel = this.getSelection();
  if (!sel.rangeCount) { return false }
  var node = sel.getRangeAt(0).commonAncestorContainer;
  return contains(this.div, node)
};

ContentEditableInput.prototype.focus = function () {
  if (this.cm.options.readOnly != "nocursor") {
    if (!this.selectionInEditor())
      { this.showSelection(this.prepareSelection(), true); }
    this.div.focus();
  }
};
ContentEditableInput.prototype.blur = function () { this.div.blur(); };
ContentEditableInput.prototype.getField = function () { return this.div };

ContentEditableInput.prototype.supportsTouch = function () { return true };

ContentEditableInput.prototype.receivedFocus = function () {
  var input = this;
  if (this.selectionInEditor())
    { this.pollSelection(); }
  else
    { runInOp(this.cm, function () { return input.cm.curOp.selectionChanged = true; }); }

  function poll() {
    if (input.cm.state.focused) {
      input.pollSelection();
      input.polling.set(input.cm.options.pollInterval, poll);
    }
  }
  this.polling.set(this.cm.options.pollInterval, poll);
};

ContentEditableInput.prototype.selectionChanged = function () {
  var sel = this.getSelection();
  return sel.anchorNode != this.lastAnchorNode || sel.anchorOffset != this.lastAnchorOffset ||
    sel.focusNode != this.lastFocusNode || sel.focusOffset != this.lastFocusOffset
};

ContentEditableInput.prototype.pollSelection = function () {
  if (this.readDOMTimeout != null || this.gracePeriod || !this.selectionChanged()) { return }
  var sel = this.getSelection(), cm = this.cm;
  // On Android Chrome (version 56, at least), backspacing into an
  // uneditable block element will put the cursor in that element,
  // and then, because it's not editable, hide the virtual keyboard.
  // Because Android doesn't allow us to actually detect backspace
  // presses in a sane way, this code checks for when that happens
  // and simulates a backspace press in this case.
  if (android && chrome && this.cm.options.gutters.length && isInGutter(sel.anchorNode)) {
    this.cm.triggerOnKeyDown({type: "keydown", keyCode: 8, preventDefault: Math.abs});
    this.blur();
    this.focus();
    return
  }
  if (this.composing) { return }
  this.rememberSelection();
  var anchor = domToPos(cm, sel.anchorNode, sel.anchorOffset);
  var head = domToPos(cm, sel.focusNode, sel.focusOffset);
  if (anchor && head) { runInOp(cm, function () {
    setSelection(cm.doc, simpleSelection(anchor, head), sel_dontScroll);
    if (anchor.bad || head.bad) { cm.curOp.selectionChanged = true; }
  }); }
};

ContentEditableInput.prototype.pollContent = function () {
  if (this.readDOMTimeout != null) {
    clearTimeout(this.readDOMTimeout);
    this.readDOMTimeout = null;
  }

  var cm = this.cm, display = cm.display, sel = cm.doc.sel.primary();
  var from = sel.from(), to = sel.to();
  if (from.ch == 0 && from.line > cm.firstLine())
    { from = Pos(from.line - 1, getLine(cm.doc, from.line - 1).length); }
  if (to.ch == getLine(cm.doc, to.line).text.length && to.line < cm.lastLine())
    { to = Pos(to.line + 1, 0); }
  if (from.line < display.viewFrom || to.line > display.viewTo - 1) { return false }

  var fromIndex, fromLine, fromNode;
  if (from.line == display.viewFrom || (fromIndex = findViewIndex(cm, from.line)) == 0) {
    fromLine = lineNo(display.view[0].line);
    fromNode = display.view[0].node;
  } else {
    fromLine = lineNo(display.view[fromIndex].line);
    fromNode = display.view[fromIndex - 1].node.nextSibling;
  }
  var toIndex = findViewIndex(cm, to.line);
  var toLine, toNode;
  if (toIndex == display.view.length - 1) {
    toLine = display.viewTo - 1;
    toNode = display.lineDiv.lastChild;
  } else {
    toLine = lineNo(display.view[toIndex + 1].line) - 1;
    toNode = display.view[toIndex + 1].node.previousSibling;
  }

  if (!fromNode) { return false }
  var newText = cm.doc.splitLines(domTextBetween(cm, fromNode, toNode, fromLine, toLine));
  var oldText = getBetween(cm.doc, Pos(fromLine, 0), Pos(toLine, getLine(cm.doc, toLine).text.length));
  while (newText.length > 1 && oldText.length > 1) {
    if (lst(newText) == lst(oldText)) { newText.pop(); oldText.pop(); toLine--; }
    else if (newText[0] == oldText[0]) { newText.shift(); oldText.shift(); fromLine++; }
    else { break }
  }

  var cutFront = 0, cutEnd = 0;
  var newTop = newText[0], oldTop = oldText[0], maxCutFront = Math.min(newTop.length, oldTop.length);
  while (cutFront < maxCutFront && newTop.charCodeAt(cutFront) == oldTop.charCodeAt(cutFront))
    { ++cutFront; }
  var newBot = lst(newText), oldBot = lst(oldText);
  var maxCutEnd = Math.min(newBot.length - (newText.length == 1 ? cutFront : 0),
                           oldBot.length - (oldText.length == 1 ? cutFront : 0));
  while (cutEnd < maxCutEnd &&
         newBot.charCodeAt(newBot.length - cutEnd - 1) == oldBot.charCodeAt(oldBot.length - cutEnd - 1))
    { ++cutEnd; }
  // Try to move start of change to start of selection if ambiguous
  if (newText.length == 1 && oldText.length == 1 && fromLine == from.line) {
    while (cutFront && cutFront > from.ch &&
           newBot.charCodeAt(newBot.length - cutEnd - 1) == oldBot.charCodeAt(oldBot.length - cutEnd - 1)) {
      cutFront--;
      cutEnd++;
    }
  }

  newText[newText.length - 1] = newBot.slice(0, newBot.length - cutEnd).replace(/^\u200b+/, "");
  newText[0] = newText[0].slice(cutFront).replace(/\u200b+$/, "");

  var chFrom = Pos(fromLine, cutFront);
  var chTo = Pos(toLine, oldText.length ? lst(oldText).length - cutEnd : 0);
  if (newText.length > 1 || newText[0] || cmp(chFrom, chTo)) {
    replaceRange(cm.doc, newText, chFrom, chTo, "+input");
    return true
  }
};

ContentEditableInput.prototype.ensurePolled = function () {
  this.forceCompositionEnd();
};
ContentEditableInput.prototype.reset = function () {
  this.forceCompositionEnd();
};
ContentEditableInput.prototype.forceCompositionEnd = function () {
  if (!this.composing) { return }
  clearTimeout(this.readDOMTimeout);
  this.composing = null;
  this.updateFromDOM();
  this.div.blur();
  this.div.focus();
};
ContentEditableInput.prototype.readFromDOMSoon = function () {
    var this$1 = this;

  if (this.readDOMTimeout != null) { return }
  this.readDOMTimeout = setTimeout(function () {
    this$1.readDOMTimeout = null;
    if (this$1.composing) {
      if (this$1.composing.done) { this$1.composing = null; }
      else { return }
    }
    this$1.updateFromDOM();
  }, 80);
};

ContentEditableInput.prototype.updateFromDOM = function () {
    var this$1 = this;

  if (this.cm.isReadOnly() || !this.pollContent())
    { runInOp(this.cm, function () { return regChange(this$1.cm); }); }
};

ContentEditableInput.prototype.setUneditable = function (node) {
  node.contentEditable = "false";
};

ContentEditableInput.prototype.onKeyPress = function (e) {
  if (e.charCode == 0 || this.composing) { return }
  e.preventDefault();
  if (!this.cm.isReadOnly())
    { operation(this.cm, applyTextInput)(this.cm, String.fromCharCode(e.charCode == null ? e.keyCode : e.charCode), 0); }
};

ContentEditableInput.prototype.readOnlyChanged = function (val) {
  this.div.contentEditable = String(val != "nocursor");
};

ContentEditableInput.prototype.onContextMenu = function () {};
ContentEditableInput.prototype.resetPosition = function () {};

ContentEditableInput.prototype.needsContentAttribute = true;

function posToDOM(cm, pos) {
  var view = findViewForLine(cm, pos.line);
  if (!view || view.hidden) { return null }
  var line = getLine(cm.doc, pos.line);
  var info = mapFromLineView(view, line, pos.line);

  var order = getOrder(line, cm.doc.direction), side = "left";
  if (order) {
    var partPos = getBidiPartAt(order, pos.ch);
    side = partPos % 2 ? "right" : "left";
  }
  var result = nodeAndOffsetInLineMap(info.map, pos.ch, side);
  result.offset = result.collapse == "right" ? result.end : result.start;
  return result
}

function isInGutter(node) {
  for (var scan = node; scan; scan = scan.parentNode)
    { if (/CodeMirror-gutter-wrapper/.test(scan.className)) { return true } }
  return false
}

function badPos(pos, bad) { if (bad) { pos.bad = true; } return pos }

function domTextBetween(cm, from, to, fromLine, toLine) {
  var text = "", closing = false, lineSep = cm.doc.lineSeparator(), extraLinebreak = false;
  function recognizeMarker(id) { return function (marker) { return marker.id == id; } }
  function close() {
    if (closing) {
      text += lineSep;
      if (extraLinebreak) { text += lineSep; }
      closing = extraLinebreak = false;
    }
  }
  function addText(str) {
    if (str) {
      close();
      text += str;
    }
  }
  function walk(node) {
    if (node.nodeType == 1) {
      var cmText = node.getAttribute("cm-text");
      if (cmText) {
        addText(cmText);
        return
      }
      var markerID = node.getAttribute("cm-marker"), range$$1;
      if (markerID) {
        var found = cm.findMarks(Pos(fromLine, 0), Pos(toLine + 1, 0), recognizeMarker(+markerID));
        if (found.length && (range$$1 = found[0].find(0)))
          { addText(getBetween(cm.doc, range$$1.from, range$$1.to).join(lineSep)); }
        return
      }
      if (node.getAttribute("contenteditable") == "false") { return }
      var isBlock = /^(pre|div|p|li|table|br)$/i.test(node.nodeName);
      if (!/^br$/i.test(node.nodeName) && node.textContent.length == 0) { return }

      if (isBlock) { close(); }
      for (var i = 0; i < node.childNodes.length; i++)
        { walk(node.childNodes[i]); }

      if (/^(pre|p)$/i.test(node.nodeName)) { extraLinebreak = true; }
      if (isBlock) { closing = true; }
    } else if (node.nodeType == 3) {
      addText(node.nodeValue.replace(/\u200b/g, "").replace(/\u00a0/g, " "));
    }
  }
  for (;;) {
    walk(from);
    if (from == to) { break }
    from = from.nextSibling;
    extraLinebreak = false;
  }
  return text
}

function domToPos(cm, node, offset) {
  var lineNode;
  if (node == cm.display.lineDiv) {
    lineNode = cm.display.lineDiv.childNodes[offset];
    if (!lineNode) { return badPos(cm.clipPos(Pos(cm.display.viewTo - 1)), true) }
    node = null; offset = 0;
  } else {
    for (lineNode = node;; lineNode = lineNode.parentNode) {
      if (!lineNode || lineNode == cm.display.lineDiv) { return null }
      if (lineNode.parentNode && lineNode.parentNode == cm.display.lineDiv) { break }
    }
  }
  for (var i = 0; i < cm.display.view.length; i++) {
    var lineView = cm.display.view[i];
    if (lineView.node == lineNode)
      { return locateNodeInLineView(lineView, node, offset) }
  }
}

function locateNodeInLineView(lineView, node, offset) {
  var wrapper = lineView.text.firstChild, bad = false;
  if (!node || !contains(wrapper, node)) { return badPos(Pos(lineNo(lineView.line), 0), true) }
  if (node == wrapper) {
    bad = true;
    node = wrapper.childNodes[offset];
    offset = 0;
    if (!node) {
      var line = lineView.rest ? lst(lineView.rest) : lineView.line;
      return badPos(Pos(lineNo(line), line.text.length), bad)
    }
  }

  var textNode = node.nodeType == 3 ? node : null, topNode = node;
  if (!textNode && node.childNodes.length == 1 && node.firstChild.nodeType == 3) {
    textNode = node.firstChild;
    if (offset) { offset = textNode.nodeValue.length; }
  }
  while (topNode.parentNode != wrapper) { topNode = topNode.parentNode; }
  var measure = lineView.measure, maps = measure.maps;

  function find(textNode, topNode, offset) {
    for (var i = -1; i < (maps ? maps.length : 0); i++) {
      var map$$1 = i < 0 ? measure.map : maps[i];
      for (var j = 0; j < map$$1.length; j += 3) {
        var curNode = map$$1[j + 2];
        if (curNode == textNode || curNode == topNode) {
          var line = lineNo(i < 0 ? lineView.line : lineView.rest[i]);
          var ch = map$$1[j] + offset;
          if (offset < 0 || curNode != textNode) { ch = map$$1[j + (offset ? 1 : 0)]; }
          return Pos(line, ch)
        }
      }
    }
  }
  var found = find(textNode, topNode, offset);
  if (found) { return badPos(found, bad) }

  // FIXME this is all really shaky. might handle the few cases it needs to handle, but likely to cause problems
  for (var after = topNode.nextSibling, dist = textNode ? textNode.nodeValue.length - offset : 0; after; after = after.nextSibling) {
    found = find(after, after.firstChild, 0);
    if (found)
      { return badPos(Pos(found.line, found.ch - dist), bad) }
    else
      { dist += after.textContent.length; }
  }
  for (var before = topNode.previousSibling, dist$1 = offset; before; before = before.previousSibling) {
    found = find(before, before.firstChild, -1);
    if (found)
      { return badPos(Pos(found.line, found.ch + dist$1), bad) }
    else
      { dist$1 += before.textContent.length; }
  }
}

// TEXTAREA INPUT STYLE

var TextareaInput = function(cm) {
  this.cm = cm;
  // See input.poll and input.reset
  this.prevInput = "";

  // Flag that indicates whether we expect input to appear real soon
  // now (after some event like 'keypress' or 'input') and are
  // polling intensively.
  this.pollingFast = false;
  // Self-resetting timeout for the poller
  this.polling = new Delayed();
  // Used to work around IE issue with selection being forgotten when focus moves away from textarea
  this.hasSelection = false;
  this.composing = null;
};

TextareaInput.prototype.init = function (display) {
    var this$1 = this;

  var input = this, cm = this.cm;
  this.createField(display);
  var te = this.textarea;

  display.wrapper.insertBefore(this.wrapper, display.wrapper.firstChild);

  // Needed to hide big blue blinking cursor on Mobile Safari (doesn't seem to work in iOS 8 anymore)
  if (ios) { te.style.width = "0px"; }

  on(te, "input", function () {
    if (ie && ie_version >= 9 && this$1.hasSelection) { this$1.hasSelection = null; }
    input.poll();
  });

  on(te, "paste", function (e) {
    if (signalDOMEvent(cm, e) || handlePaste(e, cm)) { return }

    cm.state.pasteIncoming = true;
    input.fastPoll();
  });

  function prepareCopyCut(e) {
    if (signalDOMEvent(cm, e)) { return }
    if (cm.somethingSelected()) {
      setLastCopied({lineWise: false, text: cm.getSelections()});
    } else if (!cm.options.lineWiseCopyCut) {
      return
    } else {
      var ranges = copyableRanges(cm);
      setLastCopied({lineWise: true, text: ranges.text});
      if (e.type == "cut") {
        cm.setSelections(ranges.ranges, null, sel_dontScroll);
      } else {
        input.prevInput = "";
        te.value = ranges.text.join("\n");
        selectInput(te);
      }
    }
    if (e.type == "cut") { cm.state.cutIncoming = true; }
  }
  on(te, "cut", prepareCopyCut);
  on(te, "copy", prepareCopyCut);

  on(display.scroller, "paste", function (e) {
    if (eventInWidget(display, e) || signalDOMEvent(cm, e)) { return }
    cm.state.pasteIncoming = true;
    input.focus();
  });

  // Prevent normal selection in the editor (we handle our own)
  on(display.lineSpace, "selectstart", function (e) {
    if (!eventInWidget(display, e)) { e_preventDefault(e); }
  });

  on(te, "compositionstart", function () {
    var start = cm.getCursor("from");
    if (input.composing) { input.composing.range.clear(); }
    input.composing = {
      start: start,
      range: cm.markText(start, cm.getCursor("to"), {className: "CodeMirror-composing"})
    };
  });
  on(te, "compositionend", function () {
    if (input.composing) {
      input.poll();
      input.composing.range.clear();
      input.composing = null;
    }
  });
};

TextareaInput.prototype.createField = function (_display) {
  // Wraps and hides input textarea
  this.wrapper = hiddenTextarea();
  // The semihidden textarea that is focused when the editor is
  // focused, and receives input.
  this.textarea = this.wrapper.firstChild;
};

TextareaInput.prototype.prepareSelection = function () {
  // Redraw the selection and/or cursor
  var cm = this.cm, display = cm.display, doc = cm.doc;
  var result = prepareSelection(cm);

  // Move the hidden textarea near the cursor to prevent scrolling artifacts
  if (cm.options.moveInputWithCursor) {
    var headPos = cursorCoords(cm, doc.sel.primary().head, "div");
    var wrapOff = display.wrapper.getBoundingClientRect(), lineOff = display.lineDiv.getBoundingClientRect();
    result.teTop = Math.max(0, Math.min(display.wrapper.clientHeight - 10,
                                        headPos.top + lineOff.top - wrapOff.top));
    result.teLeft = Math.max(0, Math.min(display.wrapper.clientWidth - 10,
                                         headPos.left + lineOff.left - wrapOff.left));
  }

  return result
};

TextareaInput.prototype.showSelection = function (drawn) {
  var cm = this.cm, display = cm.display;
  removeChildrenAndAdd(display.cursorDiv, drawn.cursors);
  removeChildrenAndAdd(display.selectionDiv, drawn.selection);
  if (drawn.teTop != null) {
    this.wrapper.style.top = drawn.teTop + "px";
    this.wrapper.style.left = drawn.teLeft + "px";
  }
};

// Reset the input to correspond to the selection (or to be empty,
// when not typing and nothing is selected)
TextareaInput.prototype.reset = function (typing) {
  if (this.contextMenuPending || this.composing) { return }
  var cm = this.cm;
  if (cm.somethingSelected()) {
    this.prevInput = "";
    var content = cm.getSelection();
    this.textarea.value = content;
    if (cm.state.focused) { selectInput(this.textarea); }
    if (ie && ie_version >= 9) { this.hasSelection = content; }
  } else if (!typing) {
    this.prevInput = this.textarea.value = "";
    if (ie && ie_version >= 9) { this.hasSelection = null; }
  }
};

TextareaInput.prototype.getField = function () { return this.textarea };

TextareaInput.prototype.supportsTouch = function () { return false };

TextareaInput.prototype.focus = function () {
  if (this.cm.options.readOnly != "nocursor" && (!mobile || activeElt() != this.textarea)) {
    try { this.textarea.focus(); }
    catch (e) {} // IE8 will throw if the textarea is display: none or not in DOM
  }
};

TextareaInput.prototype.blur = function () { this.textarea.blur(); };

TextareaInput.prototype.resetPosition = function () {
  this.wrapper.style.top = this.wrapper.style.left = 0;
};

TextareaInput.prototype.receivedFocus = function () { this.slowPoll(); };

// Poll for input changes, using the normal rate of polling. This
// runs as long as the editor is focused.
TextareaInput.prototype.slowPoll = function () {
    var this$1 = this;

  if (this.pollingFast) { return }
  this.polling.set(this.cm.options.pollInterval, function () {
    this$1.poll();
    if (this$1.cm.state.focused) { this$1.slowPoll(); }
  });
};

// When an event has just come in that is likely to add or change
// something in the input textarea, we poll faster, to ensure that
// the change appears on the screen quickly.
TextareaInput.prototype.fastPoll = function () {
  var missed = false, input = this;
  input.pollingFast = true;
  function p() {
    var changed = input.poll();
    if (!changed && !missed) {missed = true; input.polling.set(60, p);}
    else {input.pollingFast = false; input.slowPoll();}
  }
  input.polling.set(20, p);
};

// Read input from the textarea, and update the document to match.
// When something is selected, it is present in the textarea, and
// selected (unless it is huge, in which case a placeholder is
// used). When nothing is selected, the cursor sits after previously
// seen text (can be empty), which is stored in prevInput (we must
// not reset the textarea when typing, because that breaks IME).
TextareaInput.prototype.poll = function () {
    var this$1 = this;

  var cm = this.cm, input = this.textarea, prevInput = this.prevInput;
  // Since this is called a *lot*, try to bail out as cheaply as
  // possible when it is clear that nothing happened. hasSelection
  // will be the case when there is a lot of text in the textarea,
  // in which case reading its value would be expensive.
  if (this.contextMenuPending || !cm.state.focused ||
      (hasSelection(input) && !prevInput && !this.composing) ||
      cm.isReadOnly() || cm.options.disableInput || cm.state.keySeq)
    { return false }

  var text = input.value;
  // If nothing changed, bail.
  if (text == prevInput && !cm.somethingSelected()) { return false }
  // Work around nonsensical selection resetting in IE9/10, and
  // inexplicable appearance of private area unicode characters on
  // some key combos in Mac (#2689).
  if (ie && ie_version >= 9 && this.hasSelection === text ||
      mac && /[\uf700-\uf7ff]/.test(text)) {
    cm.display.input.reset();
    return false
  }

  if (cm.doc.sel == cm.display.selForContextMenu) {
    var first = text.charCodeAt(0);
    if (first == 0x200b && !prevInput) { prevInput = "\u200b"; }
    if (first == 0x21da) { this.reset(); return this.cm.execCommand("undo") }
  }
  // Find the part of the input that is actually new
  var same = 0, l = Math.min(prevInput.length, text.length);
  while (same < l && prevInput.charCodeAt(same) == text.charCodeAt(same)) { ++same; }

  runInOp(cm, function () {
    applyTextInput(cm, text.slice(same), prevInput.length - same,
                   null, this$1.composing ? "*compose" : null);

    // Don't leave long text in the textarea, since it makes further polling slow
    if (text.length > 1000 || text.indexOf("\n") > -1) { input.value = this$1.prevInput = ""; }
    else { this$1.prevInput = text; }

    if (this$1.composing) {
      this$1.composing.range.clear();
      this$1.composing.range = cm.markText(this$1.composing.start, cm.getCursor("to"),
                                         {className: "CodeMirror-composing"});
    }
  });
  return true
};

TextareaInput.prototype.ensurePolled = function () {
  if (this.pollingFast && this.poll()) { this.pollingFast = false; }
};

TextareaInput.prototype.onKeyPress = function () {
  if (ie && ie_version >= 9) { this.hasSelection = null; }
  this.fastPoll();
};

TextareaInput.prototype.onContextMenu = function (e) {
  var input = this, cm = input.cm, display = cm.display, te = input.textarea;
  var pos = posFromMouse(cm, e), scrollPos = display.scroller.scrollTop;
  if (!pos || presto) { return } // Opera is difficult.

  // Reset the current text selection only if the click is done outside of the selection
  // and 'resetSelectionOnContextMenu' option is true.
  var reset = cm.options.resetSelectionOnContextMenu;
  if (reset && cm.doc.sel.contains(pos) == -1)
    { operation(cm, setSelection)(cm.doc, simpleSelection(pos), sel_dontScroll); }

  var oldCSS = te.style.cssText, oldWrapperCSS = input.wrapper.style.cssText;
  input.wrapper.style.cssText = "position: absolute";
  var wrapperBox = input.wrapper.getBoundingClientRect();
  te.style.cssText = "position: absolute; width: 30px; height: 30px;\n      top: " + (e.clientY - wrapperBox.top - 5) + "px; left: " + (e.clientX - wrapperBox.left - 5) + "px;\n      z-index: 1000; background: " + (ie ? "rgba(255, 255, 255, .05)" : "transparent") + ";\n      outline: none; border-width: 0; outline: none; overflow: hidden; opacity: .05; filter: alpha(opacity=5);";
  var oldScrollY;
  if (webkit) { oldScrollY = window.scrollY; } // Work around Chrome issue (#2712)
  display.input.focus();
  if (webkit) { window.scrollTo(null, oldScrollY); }
  display.input.reset();
  // Adds "Select all" to context menu in FF
  if (!cm.somethingSelected()) { te.value = input.prevInput = " "; }
  input.contextMenuPending = true;
  display.selForContextMenu = cm.doc.sel;
  clearTimeout(display.detectingSelectAll);

  // Select-all will be greyed out if there's nothing to select, so
  // this adds a zero-width space so that we can later check whether
  // it got selected.
  function prepareSelectAllHack() {
    if (te.selectionStart != null) {
      var selected = cm.somethingSelected();
      var extval = "\u200b" + (selected ? te.value : "");
      te.value = "\u21da"; // Used to catch context-menu undo
      te.value = extval;
      input.prevInput = selected ? "" : "\u200b";
      te.selectionStart = 1; te.selectionEnd = extval.length;
      // Re-set this, in case some other handler touched the
      // selection in the meantime.
      display.selForContextMenu = cm.doc.sel;
    }
  }
  function rehide() {
    input.contextMenuPending = false;
    input.wrapper.style.cssText = oldWrapperCSS;
    te.style.cssText = oldCSS;
    if (ie && ie_version < 9) { display.scrollbars.setScrollTop(display.scroller.scrollTop = scrollPos); }

    // Try to detect the user choosing select-all
    if (te.selectionStart != null) {
      if (!ie || (ie && ie_version < 9)) { prepareSelectAllHack(); }
      var i = 0, poll = function () {
        if (display.selForContextMenu == cm.doc.sel && te.selectionStart == 0 &&
            te.selectionEnd > 0 && input.prevInput == "\u200b") {
          operation(cm, selectAll)(cm);
        } else if (i++ < 10) {
          display.detectingSelectAll = setTimeout(poll, 500);
        } else {
          display.selForContextMenu = null;
          display.input.reset();
        }
      };
      display.detectingSelectAll = setTimeout(poll, 200);
    }
  }

  if (ie && ie_version >= 9) { prepareSelectAllHack(); }
  if (captureRightClick) {
    e_stop(e);
    var mouseup = function () {
      off(window, "mouseup", mouseup);
      setTimeout(rehide, 20);
    };
    on(window, "mouseup", mouseup);
  } else {
    setTimeout(rehide, 50);
  }
};

TextareaInput.prototype.readOnlyChanged = function (val) {
  if (!val) { this.reset(); }
  this.textarea.disabled = val == "nocursor";
};

TextareaInput.prototype.setUneditable = function () {};

TextareaInput.prototype.needsContentAttribute = false;

function fromTextArea(textarea, options) {
  options = options ? copyObj(options) : {};
  options.value = textarea.value;
  if (!options.tabindex && textarea.tabIndex)
    { options.tabindex = textarea.tabIndex; }
  if (!options.placeholder && textarea.placeholder)
    { options.placeholder = textarea.placeholder; }
  // Set autofocus to true if this textarea is focused, or if it has
  // autofocus and no other element is focused.
  if (options.autofocus == null) {
    var hasFocus = activeElt();
    options.autofocus = hasFocus == textarea ||
      textarea.getAttribute("autofocus") != null && hasFocus == document.body;
  }

  function save() {textarea.value = cm.getValue();}

  var realSubmit;
  if (textarea.form) {
    on(textarea.form, "submit", save);
    // Deplorable hack to make the submit method do the right thing.
    if (!options.leaveSubmitMethodAlone) {
      var form = textarea.form;
      realSubmit = form.submit;
      try {
        var wrappedSubmit = form.submit = function () {
          save();
          form.submit = realSubmit;
          form.submit();
          form.submit = wrappedSubmit;
        };
      } catch(e) {}
    }
  }

  options.finishInit = function (cm) {
    cm.save = save;
    cm.getTextArea = function () { return textarea; };
    cm.toTextArea = function () {
      cm.toTextArea = isNaN; // Prevent this from being ran twice
      save();
      textarea.parentNode.removeChild(cm.getWrapperElement());
      textarea.style.display = "";
      if (textarea.form) {
        off(textarea.form, "submit", save);
        if (typeof textarea.form.submit == "function")
          { textarea.form.submit = realSubmit; }
      }
    };
  };

  textarea.style.display = "none";
  var cm = CodeMirror$1(function (node) { return textarea.parentNode.insertBefore(node, textarea.nextSibling); },
    options);
  return cm
}

function addLegacyProps(CodeMirror) {
  CodeMirror.off = off;
  CodeMirror.on = on;
  CodeMirror.wheelEventPixels = wheelEventPixels;
  CodeMirror.Doc = Doc;
  CodeMirror.splitLines = splitLinesAuto;
  CodeMirror.countColumn = countColumn;
  CodeMirror.findColumn = findColumn;
  CodeMirror.isWordChar = isWordCharBasic;
  CodeMirror.Pass = Pass;
  CodeMirror.signal = signal;
  CodeMirror.Line = Line;
  CodeMirror.changeEnd = changeEnd;
  CodeMirror.scrollbarModel = scrollbarModel;
  CodeMirror.Pos = Pos;
  CodeMirror.cmpPos = cmp;
  CodeMirror.modes = modes;
  CodeMirror.mimeModes = mimeModes;
  CodeMirror.resolveMode = resolveMode;
  CodeMirror.getMode = getMode;
  CodeMirror.modeExtensions = modeExtensions;
  CodeMirror.extendMode = extendMode;
  CodeMirror.copyState = copyState;
  CodeMirror.startState = startState;
  CodeMirror.innerMode = innerMode;
  CodeMirror.commands = commands;
  CodeMirror.keyMap = keyMap;
  CodeMirror.keyName = keyName;
  CodeMirror.isModifierKey = isModifierKey;
  CodeMirror.lookupKey = lookupKey;
  CodeMirror.normalizeKeyMap = normalizeKeyMap;
  CodeMirror.StringStream = StringStream;
  CodeMirror.SharedTextMarker = SharedTextMarker;
  CodeMirror.TextMarker = TextMarker;
  CodeMirror.LineWidget = LineWidget;
  CodeMirror.e_preventDefault = e_preventDefault;
  CodeMirror.e_stopPropagation = e_stopPropagation;
  CodeMirror.e_stop = e_stop;
  CodeMirror.addClass = addClass;
  CodeMirror.contains = contains;
  CodeMirror.rmClass = rmClass;
  CodeMirror.keyNames = keyNames;
}

// EDITOR CONSTRUCTOR

defineOptions(CodeMirror$1);

addEditorMethods(CodeMirror$1);

// Set up methods on CodeMirror's prototype to redirect to the editor's document.
var dontDelegate = "iter insert remove copy getEditor constructor".split(" ");
for (var prop in Doc.prototype) { if (Doc.prototype.hasOwnProperty(prop) && indexOf(dontDelegate, prop) < 0)
  { CodeMirror$1.prototype[prop] = (function(method) {
    return function() {return method.apply(this.doc, arguments)}
  })(Doc.prototype[prop]); } }

eventMixin(Doc);

// INPUT HANDLING

CodeMirror$1.inputStyles = {"textarea": TextareaInput, "contenteditable": ContentEditableInput};

// MODE DEFINITION AND QUERYING

// Extra arguments are stored as the mode's dependencies, which is
// used by (legacy) mechanisms like loadmode.js to automatically
// load a mode. (Preferred mechanism is the require/define calls.)
CodeMirror$1.defineMode = function(name/*, mode, …*/) {
  if (!CodeMirror$1.defaults.mode && name != "null") { CodeMirror$1.defaults.mode = name; }
  defineMode.apply(this, arguments);
};

CodeMirror$1.defineMIME = defineMIME;

// Minimal default mode.
CodeMirror$1.defineMode("null", function () { return ({token: function (stream) { return stream.skipToEnd(); }}); });
CodeMirror$1.defineMIME("text/plain", "null");

// EXTENSIONS

CodeMirror$1.defineExtension = function (name, func) {
  CodeMirror$1.prototype[name] = func;
};
CodeMirror$1.defineDocExtension = function (name, func) {
  Doc.prototype[name] = func;
};

CodeMirror$1.fromTextArea = fromTextArea;

addLegacyProps(CodeMirror$1);

CodeMirror$1.version = "5.39.2";

return CodeMirror$1;

})));

/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof module&&module.exports?module.exports=function(e,n){return n===undefined&&(n="undefined"!=typeof window?require("jquery"):require("jquery")(e)),t(n)}:t(window.jQuery)}(function(l){l.FE.PLUGINS.align=function(r){return{apply:function(e){var n=r.selection.element();if(l(n).parents(".fr-img-caption").length)l(n).css("text-align",e);else{r.selection.save(),r.html.wrap(!0,!0,!0,!0),r.selection.restore();for(var t=r.selection.blocks(),i=0;i<t.length;i++)r.helpers.getAlignment(l(t[i].parentNode))==e?l(t[i]).css("text-align","").removeClass("fr-temp-div"):l(t[i]).css("text-align",e).removeClass("fr-temp-div"),""===l(t[i]).attr("class")&&l(t[i]).removeAttr("class"),""===l(t[i]).attr("style")&&l(t[i]).removeAttr("style");r.selection.save(),r.html.unwrap(),r.selection.restore()}},refresh:function(e){var n=r.selection.blocks();if(n.length){var t=r.helpers.getAlignment(l(n[0]));e.find("> *:first").replaceWith(r.icon.create("align-"+t))}},refreshOnShow:function(e,n){var t=r.selection.blocks();if(t.length){var i=r.helpers.getAlignment(l(t[0]));n.find('a.fr-command[data-param1="'+i+'"]').addClass("fr-active").attr("aria-selected",!0)}}}},l.FE.DefineIcon("align",{NAME:"align-left"}),l.FE.DefineIcon("align-left",{NAME:"align-left"}),l.FE.DefineIcon("align-right",{NAME:"align-right"}),l.FE.DefineIcon("align-center",{NAME:"align-center"}),l.FE.DefineIcon("align-justify",{NAME:"align-justify"}),l.FE.RegisterCommand("align",{type:"dropdown",title:"Align",options:{left:"Align Left",center:"Align Center",right:"Align Right",justify:"Align Justify"},html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',n=l.FE.COMMANDS.align.options;for(var t in n)n.hasOwnProperty(t)&&(e+='<li role="presentation"><a class="fr-command fr-title" tabIndex="-1" role="option" data-cmd="align" data-param1="'+t+'" title="'+this.language.translate(n[t])+'">'+this.icon.create("align-"+t)+'<span class="fr-sr-only">'+this.language.translate(n[t])+"</span></a></li>");return e+="</ul>"},callback:function(e,n){this.align.apply(n)},refresh:function(e){this.align.refresh(e)},refreshOnShow:function(e,n){this.align.refreshOnShow(e,n)},plugin:"align"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(a){a.extend(a.FE.DEFAULTS,{charCounterMax:-1,charCounterCount:!0}),a.FE.PLUGINS.charCounter=function(n){var r;function o(){return(n.el.textContent||"").replace(/\u200B/g,"").length}function e(e){if(n.opts.charCounterMax<0)return!0;if(o()<n.opts.charCounterMax)return!0;var t=e.which;return!(!n.keys.ctrlKey(e)&&n.keys.isCharacter(t)||t===a.FE.KEYCODE.IME)||(e.preventDefault(),e.stopPropagation(),n.events.trigger("charCounter.exceeded"),!1)}function t(e){return n.opts.charCounterMax<0?e:a("<div>").html(e).text().length+o()<=n.opts.charCounterMax?e:(n.events.trigger("charCounter.exceeded"),"")}function u(){if(n.opts.charCounterCount){var e=o()+(0<n.opts.charCounterMax?"/"+n.opts.charCounterMax:"");r.text(e),n.opts.toolbarBottom&&r.css("margin-bottom",n.$tb.outerHeight(!0));var t=n.$wp.get(0).offsetWidth-n.$wp.get(0).clientWidth;0<=t&&("rtl"==n.opts.direction?r.css("margin-left",t):r.css("margin-right",t))}}return{_init:function(){return!!n.$wp&&!!n.opts.charCounterCount&&((r=a('<span class="fr-counter"></span>')).css("bottom",n.$wp.css("border-bottom-width")),n.$box.append(r),n.events.on("keydown",e,!0),n.events.on("paste.afterCleanup",t),n.events.on("keyup contentChanged input",function(){n.events.trigger("charCounter.update")}),n.events.on("charCounter.update",u),n.events.trigger("charCounter.update"),void n.events.on("destroy",function(){a(n.o_win).off("resize.char"+n.id),r.removeData().remove(),r=null}))},count:o}}});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(e){e.FE.PLUGINS.codeBeautifier=function(){var e,t,n,i,X={};function k(i,e){var t={"@page":!0,"@font-face":!0,"@keyframes":!0,"@media":!0,"@supports":!0,"@document":!0},n={"@media":!0,"@supports":!0,"@document":!0};e=e||{},i=(i=i||"").replace(/\r\n|[\r\u2028\u2029]/g,"\n");var r=e.indent_size||4,s=e.indent_char||" ",_=e.selector_separator_newline===undefined||e.selector_separator_newline,a=e.end_with_newline!==undefined&&e.end_with_newline,o=e.newline_between_rules===undefined||e.newline_between_rules,l=e.eol?e.eol:"\n";"string"==typeof r&&(r=parseInt(r,10)),e.indent_with_tabs&&(s="\t",r=1),l=l.replace(/\\r/,"\r").replace(/\\n/,"\n");var h,c=/^\s+$/,u=-1,p=0;function d(){return(h=i.charAt(++u))||""}function f(e){var t,n=u;return e&&E(),t=i.charAt(u+1)||"",u=n-1,d(),t}function T(e){for(var t=u;d();)if("\\"===h)d();else{if(-1!==e.indexOf(h))break;if("\n"===h)break}return i.substring(t,u+1)}function E(){for(var e="";c.test(f());)d(),e+=h;return e}function g(){var e="";for(h&&c.test(h)&&(e=h);c.test(d());)e+=h;return e}function x(e){var t=u;for(e="/"===f(),d();d();){if(!e&&"*"===h&&"/"===f()){d();break}if(e&&"\n"===h)return i.substring(t,u)}return i.substring(t,u)+h}function w(e){return i.substring(u-e.length,u).toLowerCase()===e}function K(){for(var e=0,t=u+1;t<i.length;t++){var n=i.charAt(t);if("{"===n)return!0;if("("===n)e+=1;else if(")"===n){if(0==e)return!1;e-=1}else if(";"===n||"}"===n)return!1}return!1}var m=i.match(/^[\t ]*/)[0],R=new Array(r+1).join(s),b=0,v=0;for(var S,A,k={"{":function(e){k.singleSpace(),y.push(e),k.newLine()},"}":function(e){k.newLine(),y.push(e),k.newLine()},_lastCharWhitespace:function(){return c.test(y[y.length-1])},newLine:function(e){y.length&&(e||"\n"===y[y.length-1]||k.trim(),y.push("\n"),m&&y.push(m))},singleSpace:function(){y.length&&!k._lastCharWhitespace()&&y.push(" ")},preserveSingleSpace:function(){V&&k.singleSpace()},trim:function(){for(;k._lastCharWhitespace();)y.pop()}},y=[],O=!1,N=!1,D=!1,C="",L="";;){var I=g(),V=""!==I,P=-1!==I.indexOf("\n");if(L=C,!(C=h))break;if("/"===h&&"*"===f()){var j=0===b;(P||j)&&k.newLine(),y.push(x()),k.newLine(),j&&k.newLine(!0)}else if("/"===h&&"/"===f())P||"{"===L||k.trim(),k.singleSpace(),y.push(x()),k.newLine();else if("@"===h){k.preserveSingleSpace(),y.push(h);var B=(void 0,S=u,A=T(": ,;{}()[]/='\""),u=S-1,d(),A);B.match(/[ :]$/)&&(d(),B=T(": ").replace(/\s$/,""),y.push(B),k.singleSpace()),(B=B.replace(/\s$/,""))in t&&(v+=1,B in n&&(D=!0))}else"#"===h&&"{"===f()?(k.preserveSingleSpace(),y.push(T("}"))):"{"===h?"}"===f(!0)?(E(),d(),k.singleSpace(),y.push("{}"),k.newLine(),o&&0===b&&k.newLine(!0)):(b++,m+=R,k["{"](h),D?(D=!1,O=v<b):O=v<=b):"}"===h?(b--,m=m.slice(0,-r),k["}"](h),N=O=!1,v&&v--,o&&0===b&&k.newLine(!0)):":"===h?(E(),!O&&!D||w("&")||K()?":"===f()?(d(),y.push("::")):y.push(":"):(N=!0,y.push(":"),k.singleSpace())):'"'===h||"'"===h?(k.preserveSingleSpace(),y.push(T(h))):";"===h?(N=!1,y.push(h),k.newLine()):"("===h?w("url")?(y.push(h),E(),d()&&(")"!==h&&'"'!==h&&"'"!==h?y.push(T(")")):u--)):(p++,k.preserveSingleSpace(),y.push(h),E()):")"===h?(y.push(h),p--):","===h?(y.push(h),E(),_&&!N&&p<1?k.newLine():k.singleSpace()):("]"===h||("["===h?k.preserveSingleSpace():"="===h?(E(),h="="):k.preserveSingleSpace()),y.push(h))}var M="";return m&&(M+=m),M+=y.join("").replace(/[\r\n\t ]+$/,""),a&&(M+="\n"),"\n"!=l&&(M=M.replace(/[\n]/g,l)),M}function F(e,t){for(var n=0;n<t.length;n+=1)if(t[n]===e)return!0;return!1}function $(e){return e.replace(/^\s+|\s+$/g,"")}function y(e,t){return new function(i,e){var _,r,s,a,o,l,h,c,u,t,n,p,d,f=[],T="";function E(e,t){var n=0;e&&(n=e.indentation_level,!_.just_added_newline()&&e.line_indent_level>n&&(n=e.line_indent_level));var i={mode:t,parent:e,last_text:e?e.last_text:"",last_word:e?e.last_word:"",declaration_statement:!1,declaration_assignment:!1,multiline_frame:!1,if_block:!1,else_block:!1,do_block:!1,do_while:!1,in_case_statement:!1,in_case:!1,case_body:!1,indentation_level:n,line_indent_level:e?e.line_indent_level:n,start_line_index:_.get_line_number(),ternary_depth:0};return i}p={TK_START_EXPR:function(){O();var e=L.Expression;if("["===a.text){if("TK_WORD"===o||")"===c.last_text)return"TK_RESERVED"===o&&F(c.last_text,s.line_starters)&&(_.space_before_token=!0),v(e),R(),b(),void(d.space_in_paren&&(_.space_before_token=!0));e=L.ArrayLiteral,S(c.mode)&&("["!==c.last_text&&(","!==c.last_text||"]"!==l&&"}"!==l)||d.keep_array_indentation||K())}else"TK_RESERVED"===o&&"for"===c.last_text?e=L.ForInitializer:"TK_RESERVED"===o&&F(c.last_text,["if","while"])&&(e=L.Conditional);";"===c.last_text||"TK_START_BLOCK"===o?K():"TK_END_EXPR"===o||"TK_START_EXPR"===o||"TK_END_BLOCK"===o||"."===c.last_text?w(a.wanted_newline):"TK_RESERVED"===o&&"("===a.text||"TK_WORD"===o||"TK_OPERATOR"===o?"TK_RESERVED"===o&&("function"===c.last_word||"typeof"===c.last_word)||"*"===c.last_text&&"function"===l?d.space_after_anon_function&&(_.space_before_token=!0):"TK_RESERVED"!==o||!F(c.last_text,s.line_starters)&&"catch"!==c.last_text||d.space_before_conditional&&(_.space_before_token=!0):_.space_before_token=!0,"("===a.text&&"TK_RESERVED"===o&&"await"===c.last_word&&(_.space_before_token=!0),"("===a.text&&("TK_EQUALS"!==o&&"TK_OPERATOR"!==o||y()||w()),v(e),R(),d.space_in_paren&&(_.space_before_token=!0),b()},TK_END_EXPR:function(){for(;c.mode===L.Statement;)k();c.multiline_frame&&w("]"===a.text&&S(c.mode)&&!d.keep_array_indentation),d.space_in_paren&&("TK_START_EXPR"!==o||d.space_in_empty_paren?_.space_before_token=!0:(_.trim(),_.space_before_token=!1)),"]"===a.text&&d.keep_array_indentation?(R(),k()):(k(),R()),_.remove_redundant_indentation(u),c.do_while&&u.mode===L.Conditional&&(u.mode=L.Expression,c.do_block=!1,c.do_while=!1)},TK_START_BLOCK:function(){var e=D(1),t=D(2);t&&(":"===t.text&&F(e.type,["TK_STRING","TK_WORD","TK_RESERVED"])||F(e.text,["get","set"])&&F(t.type,["TK_WORD","TK_RESERVED"]))?F(l,["class","interface"])?v(L.BlockStatement):v(L.ObjectLiteral):v(L.BlockStatement);var n=!e.comments_before.length&&"}"===e.text&&"function"===c.last_word&&"TK_END_EXPR"===o;"expand"===d.brace_style||"none"===d.brace_style&&a.wanted_newline?"TK_OPERATOR"!==o&&(n||"TK_EQUALS"===o||"TK_RESERVED"===o&&N(c.last_text)&&"else"!==c.last_text)?_.space_before_token=!0:K(!1,!0):"TK_OPERATOR"!==o&&"TK_START_EXPR"!==o?"TK_START_BLOCK"===o?K():_.space_before_token=!0:S(u.mode)&&","===c.last_text&&("}"===l?_.space_before_token=!0:K()),R(),b()},TK_END_BLOCK:function(){for(;c.mode===L.Statement;)k();var e="TK_START_BLOCK"===o;"expand"===d.brace_style?e||K():e||(S(c.mode)&&d.keep_array_indentation?(d.keep_array_indentation=!1,K(),d.keep_array_indentation=!0):K()),k(),R()},TK_WORD:C,TK_RESERVED:C,TK_SEMICOLON:function(){for(O()&&(_.space_before_token=!1);c.mode===L.Statement&&!c.if_block&&!c.do_block;)k();R()},TK_STRING:function(){O()?_.space_before_token=!0:"TK_RESERVED"===o||"TK_WORD"===o?_.space_before_token=!0:"TK_COMMA"===o||"TK_START_EXPR"===o||"TK_EQUALS"===o||"TK_OPERATOR"===o?y()||w():K(),R()},TK_EQUALS:function(){O(),c.declaration_statement&&(c.declaration_assignment=!0),_.space_before_token=!0,R(),_.space_before_token=!0},TK_OPERATOR:function(){if(O(),"TK_RESERVED"===o&&N(c.last_text))return _.space_before_token=!0,void R();if("*"!==a.text||"TK_DOT"!==o){if(":"===a.text&&c.in_case)return c.case_body=!0,b(),R(),K(),void(c.in_case=!1);if("::"!==a.text){"TK_OPERATOR"===o&&w();var e=!0,t=!0;F(a.text,["--","++","!","~"])||F(a.text,["-","+"])&&(F(o,["TK_START_BLOCK","TK_START_EXPR","TK_EQUALS","TK_OPERATOR"])||F(c.last_text,s.line_starters)||","===c.last_text)?(t=e=!1,!a.wanted_newline||"--"!==a.text&&"++"!==a.text||K(!1,!0),";"===c.last_text&&A(c.mode)&&(e=!0),"TK_RESERVED"===o?e=!0:"TK_END_EXPR"===o?e=!("]"===c.last_text&&("--"===a.text||"++"===a.text)):"TK_OPERATOR"===o&&(e=F(a.text,["--","-","++","+"])&&F(c.last_text,["--","-","++","+"]),F(a.text,["+","-"])&&F(c.last_text,["--","++"])&&(t=!0)),c.mode!==L.BlockStatement&&c.mode!==L.Statement||"{"!==c.last_text&&";"!==c.last_text||K()):":"===a.text?0===c.ternary_depth?e=!1:c.ternary_depth-=1:"?"===a.text?c.ternary_depth+=1:"*"===a.text&&"TK_RESERVED"===o&&"function"===c.last_text&&(t=e=!1),_.space_before_token=_.space_before_token||e,R(),_.space_before_token=t}else R()}else R()},TK_COMMA:function(){if(c.declaration_statement)return A(c.parent.mode)&&(c.declaration_assignment=!1),R(),void(c.declaration_assignment?K(c.declaration_assignment=!1,!0):(_.space_before_token=!0,d.comma_first&&w()));R(),c.mode===L.ObjectLiteral||c.mode===L.Statement&&c.parent.mode===L.ObjectLiteral?(c.mode===L.Statement&&k(),K()):(_.space_before_token=!0,d.comma_first&&w())},TK_BLOCK_COMMENT:function(){if(_.raw)return _.add_raw_token(a),void(a.directives&&"end"===a.directives.preserve&&(d.test_output_raw||(_.raw=!1)));if(a.directives)return K(!1,!0),R(),"start"===a.directives.preserve&&(_.raw=!0),void K(!1,!0);if(!X.newline.test(a.text)&&!a.wanted_newline)return _.space_before_token=!0,R(),void(_.space_before_token=!0);var e,t=function(e){e=e.replace(/\x0d/g,"");for(var t=[],n=e.indexOf("\n");-1!==n;)t.push(e.substring(0,n)),e=e.substring(n+1),n=e.indexOf("\n");return e.length&&t.push(e),t}(a.text),n=!1,i=!1,r=a.whitespace_before,s=r.length;for(K(!1,!0),1<t.length&&(function(e,t){for(var n=0;n<e.length;n++){var i=$(e[n]);if(i.charAt(0)!==t)return!1}return!0}(t.slice(1),"*")?n=!0:function(e,t){for(var n,i=0,r=e.length;i<r;i++)if((n=e[i])&&0!==n.indexOf(t))return!1;return!0}(t.slice(1),r)&&(i=!0)),R(t[0]),e=1;e<t.length;e++)K(!1,!0),n?R(" "+t[e].replace(/^\s+/g,"")):i&&t[e].length>s?R(t[e].substring(s)):_.add_token(t[e]);K(!1,!0)},TK_COMMENT:function(){a.wanted_newline?K(!1,!0):_.trim(!0),_.space_before_token=!0,R(),K(!1,!0)},TK_DOT:function(){O(),"TK_RESERVED"===o&&N(c.last_text)?_.space_before_token=!0:w(")"===c.last_text&&d.break_chained_methods),R()},TK_UNKNOWN:function(){R(),"\n"===a.text[a.text.length-1]&&K()},TK_EOF:function(){for(;c.mode===L.Statement;)k()}},d={},(e=e||{}).braces_on_own_line!==undefined&&(d.brace_style=e.braces_on_own_line?"expand":"collapse");d.brace_style=e.brace_style?e.brace_style:d.brace_style?d.brace_style:"collapse","expand-strict"===d.brace_style&&(d.brace_style="expand");d.indent_size=e.indent_size?parseInt(e.indent_size,10):4,d.indent_char=e.indent_char?e.indent_char:" ",d.eol=e.eol?e.eol:"\n",d.preserve_newlines=e.preserve_newlines===undefined||e.preserve_newlines,d.break_chained_methods=e.break_chained_methods!==undefined&&e.break_chained_methods,d.max_preserve_newlines=e.max_preserve_newlines===undefined?0:parseInt(e.max_preserve_newlines,10),d.space_in_paren=e.space_in_paren!==undefined&&e.space_in_paren,d.space_in_empty_paren=e.space_in_empty_paren!==undefined&&e.space_in_empty_paren,d.jslint_happy=e.jslint_happy!==undefined&&e.jslint_happy,d.space_after_anon_function=e.space_after_anon_function!==undefined&&e.space_after_anon_function,d.keep_array_indentation=e.keep_array_indentation!==undefined&&e.keep_array_indentation,d.space_before_conditional=e.space_before_conditional===undefined||e.space_before_conditional,d.unescape_strings=e.unescape_strings!==undefined&&e.unescape_strings,d.wrap_line_length=e.wrap_line_length===undefined?0:parseInt(e.wrap_line_length,10),d.e4x=e.e4x!==undefined&&e.e4x,d.end_with_newline=e.end_with_newline!==undefined&&e.end_with_newline,d.comma_first=e.comma_first!==undefined&&e.comma_first,d.test_output_raw=e.test_output_raw!==undefined&&e.test_output_raw,d.jslint_happy&&(d.space_after_anon_function=!0);e.indent_with_tabs&&(d.indent_char="\t",d.indent_size=1);d.eol=d.eol.replace(/\\r/,"\r").replace(/\\n/,"\n"),h="";for(;0<d.indent_size;)h+=d.indent_char,d.indent_size-=1;var g=0;if(i&&i.length){for(;" "===i.charAt(g)||"\t"===i.charAt(g);)T+=i.charAt(g),g+=1;i=i.substring(g)}function x(e){var t=e.newlines,n=d.keep_array_indentation&&S(c.mode);if(n)for(i=0;i<t;i+=1)K(0<i);else if(d.max_preserve_newlines&&t>d.max_preserve_newlines&&(t=d.max_preserve_newlines),d.preserve_newlines&&1<e.newlines){K();for(var i=1;i<t;i+=1)K(!0)}p[(a=e).type]()}function w(e){if(e=e!==undefined&&e,!_.just_added_newline())if(d.preserve_newlines&&a.wanted_newline||e)K(!1,!0);else if(d.wrap_line_length){var t=_.current_line.get_character_count()+a.text.length+(_.space_before_token?1:0);t>=d.wrap_line_length&&K(!1,!0)}}function K(e,t){if(!t&&";"!==c.last_text&&","!==c.last_text&&"="!==c.last_text&&"TK_OPERATOR"!==o)for(;c.mode===L.Statement&&!c.if_block&&!c.do_block;)k();_.add_new_line(e)&&(c.multiline_frame=!0)}function m(){_.just_added_newline()&&(d.keep_array_indentation&&S(c.mode)&&a.wanted_newline?(_.current_line.push(a.whitespace_before),_.space_before_token=!1):_.set_indent(c.indentation_level)&&(c.line_indent_level=c.indentation_level))}function R(e){_.raw?_.add_raw_token(a):(d.comma_first&&"TK_COMMA"===o&&_.just_added_newline()&&","===_.previous_line.last()&&(_.previous_line.pop(),m(),_.add_token(","),_.space_before_token=!0),e=e||a.text,m(),_.add_token(e))}function b(){c.indentation_level+=1}function v(e){c?(t.push(c),u=c):u=E(null,e),c=E(u,e)}function S(e){return e===L.ArrayLiteral}function A(e){return F(e,[L.Expression,L.ForInitializer,L.Conditional])}function k(){0<t.length&&(u=c,c=t.pop(),u.mode===L.Statement&&_.remove_redundant_indentation(u))}function y(){return c.parent.mode===L.ObjectLiteral&&c.mode===L.Statement&&(":"===c.last_text&&0===c.ternary_depth||"TK_RESERVED"===o&&F(c.last_text,["get","set"]))}function O(){return!!("TK_RESERVED"===o&&F(c.last_text,["var","let","const"])&&"TK_WORD"===a.type||"TK_RESERVED"===o&&"do"===c.last_text||"TK_RESERVED"===o&&"return"===c.last_text&&!a.wanted_newline||"TK_RESERVED"===o&&"else"===c.last_text&&("TK_RESERVED"!==a.type||"if"!==a.text)||"TK_END_EXPR"===o&&(u.mode===L.ForInitializer||u.mode===L.Conditional)||"TK_WORD"===o&&c.mode===L.BlockStatement&&!c.in_case&&"--"!==a.text&&"++"!==a.text&&"function"!==l&&"TK_WORD"!==a.type&&"TK_RESERVED"!==a.type||c.mode===L.ObjectLiteral&&(":"===c.last_text&&0===c.ternary_depth||"TK_RESERVED"===o&&F(c.last_text,["get","set"])))&&(v(L.Statement),b(),"TK_RESERVED"===o&&F(c.last_text,["var","let","const"])&&"TK_WORD"===a.type&&(c.declaration_statement=!0),y()||w("TK_RESERVED"===a.type&&F(a.text,["do","for","if","while"])),!0)}function N(e){return F(e,["case","return","do","if","throw","else"])}function D(e){var t=r+(e||0);return t<0||t>=f.length?null:f[t]}function C(){if("TK_RESERVED"===a.type&&c.mode!==L.ObjectLiteral&&F(a.text,["set","get"])&&(a.type="TK_WORD"),"TK_RESERVED"===a.type&&c.mode===L.ObjectLiteral){var e=D(1);":"==e.text&&(a.type="TK_WORD")}if(O()||!a.wanted_newline||A(c.mode)||"TK_OPERATOR"===o&&"--"!==c.last_text&&"++"!==c.last_text||"TK_EQUALS"===o||!d.preserve_newlines&&"TK_RESERVED"===o&&F(c.last_text,["var","let","const","set","get"])||K(),c.do_block&&!c.do_while){if("TK_RESERVED"===a.type&&"while"===a.text)return _.space_before_token=!0,R(),_.space_before_token=!0,void(c.do_while=!0);K(),c.do_block=!1}if(c.if_block)if(c.else_block||"TK_RESERVED"!==a.type||"else"!==a.text){for(;c.mode===L.Statement;)k();c.if_block=!1,c.else_block=!1}else c.else_block=!0;if("TK_RESERVED"===a.type&&("case"===a.text||"default"===a.text&&c.in_case_statement))return K(),(c.case_body||d.jslint_happy)&&(0<c.indentation_level&&(!c.parent||c.indentation_level>c.parent.indentation_level)&&(c.indentation_level-=1),c.case_body=!1),R(),c.in_case=!0,void(c.in_case_statement=!0);if("TK_RESERVED"===a.type&&"function"===a.text&&((F(c.last_text,["}",";"])||_.just_added_newline()&&!F(c.last_text,["[","{",":","=",","]))&&(_.just_added_blankline()||a.comments_before.length||(K(),K(!0))),"TK_RESERVED"===o||"TK_WORD"===o?"TK_RESERVED"===o&&F(c.last_text,["get","set","new","return","export","async"])?_.space_before_token=!0:"TK_RESERVED"===o&&"default"===c.last_text&&"export"===l?_.space_before_token=!0:K():"TK_OPERATOR"===o||"="===c.last_text?_.space_before_token=!0:(c.multiline_frame||!A(c.mode)&&!S(c.mode))&&K()),"TK_COMMA"!==o&&"TK_START_EXPR"!==o&&"TK_EQUALS"!==o&&"TK_OPERATOR"!==o||y()||w(),"TK_RESERVED"===a.type&&F(a.text,["function","get","set"]))return R(),void(c.last_word=a.text);if(n="NONE","TK_END_BLOCK"===o?"TK_RESERVED"===a.type&&F(a.text,["else","catch","finally"])?"expand"===d.brace_style||"end-expand"===d.brace_style||"none"===d.brace_style&&a.wanted_newline?n="NEWLINE":(n="SPACE",_.space_before_token=!0):n="NEWLINE":"TK_SEMICOLON"===o&&c.mode===L.BlockStatement?n="NEWLINE":"TK_SEMICOLON"===o&&A(c.mode)?n="SPACE":"TK_STRING"===o?n="NEWLINE":"TK_RESERVED"===o||"TK_WORD"===o||"*"===c.last_text&&"function"===l?n="SPACE":"TK_START_BLOCK"===o?n="NEWLINE":"TK_END_EXPR"===o&&(_.space_before_token=!0,n="NEWLINE"),"TK_RESERVED"===a.type&&F(a.text,s.line_starters)&&")"!==c.last_text&&(n="else"===c.last_text||"export"===c.last_text?"SPACE":"NEWLINE"),"TK_RESERVED"===a.type&&F(a.text,["else","catch","finally"]))if("TK_END_BLOCK"!==o||"expand"===d.brace_style||"end-expand"===d.brace_style||"none"===d.brace_style&&a.wanted_newline)K();else{_.trim(!0);var t=_.current_line;"}"!==t.last()&&K(),_.space_before_token=!0}else"NEWLINE"===n?"TK_RESERVED"===o&&N(c.last_text)?_.space_before_token=!0:"TK_END_EXPR"!==o?"TK_START_EXPR"===o&&"TK_RESERVED"===a.type&&F(a.text,["var","let","const"])||":"===c.last_text||("TK_RESERVED"===a.type&&"if"===a.text&&"else"===c.last_text?_.space_before_token=!0:K()):"TK_RESERVED"===a.type&&F(a.text,s.line_starters)&&")"!==c.last_text&&K():c.multiline_frame&&S(c.mode)&&","===c.last_text&&"}"===l?K():"SPACE"===n&&(_.space_before_token=!0);R(),c.last_word=a.text,"TK_RESERVED"===a.type&&"do"===a.text&&(c.do_block=!0),"TK_RESERVED"===a.type&&"if"===a.text&&(c.if_block=!0)}o="TK_START_BLOCK",l="",(_=new function(t,n){n=n||"",this.indent_cache=[n],this.baseIndentLength=n.length,this.indent_length=t.length,this.raw=!1;var i=[];this.baseIndentString=n,this.indent_string=t,this.previous_line=null,this.current_line=null,this.space_before_token=!1,this.add_outputline=function(){this.previous_line=this.current_line,this.current_line=new function(t){var n=0,i=-1,r=[],s=!0;this.set_indent=function(e){n=t.baseIndentLength+e*t.indent_length,i=e},this.get_character_count=function(){return n},this.is_empty=function(){return s},this.last=function(){return this._empty?null:r[r.length-1]},this.push=function(e){r.push(e),n+=e.length,s=!1},this.pop=function(){var e=null;return s||(e=r.pop(),n-=e.length,s=0===r.length),e},this.remove_indent=function(){0<i&&(i-=1,n-=t.indent_length)},this.trim=function(){for(;" "===this.last();){r.pop();n-=1}s=0===r.length},this.toString=function(){var e="";return this._empty||(0<=i&&(e=t.indent_cache[i]),e+=r.join("")),e}}(this),i.push(this.current_line)},this.add_outputline(),this.get_line_number=function(){return i.length},this.add_new_line=function(e){return(1!==this.get_line_number()||!this.just_added_newline())&&(!(!e&&this.just_added_newline())&&(this.raw||this.add_outputline(),!0))},this.get_code=function(){var e=i.join("\n").replace(/[\r\n\t ]+$/,"");return e},this.set_indent=function(e){if(1<i.length){for(;e>=this.indent_cache.length;)this.indent_cache.push(this.indent_cache[this.indent_cache.length-1]+this.indent_string);return this.current_line.set_indent(e),!0}return this.current_line.set_indent(0),!1},this.add_raw_token=function(e){for(var t=0;t<e.newlines;t++)this.add_outputline();this.current_line.push(e.whitespace_before),this.current_line.push(e.text),this.space_before_token=!1},this.add_token=function(e){this.add_space_before_token(),this.current_line.push(e)},this.add_space_before_token=function(){this.space_before_token&&!this.just_added_newline()&&this.current_line.push(" "),this.space_before_token=!1},this.remove_redundant_indentation=function(e){if(!e.multiline_frame&&e.mode!==L.ForInitializer&&e.mode!==L.Conditional)for(var t=e.start_line_index,n=i.length;t<n;)i[t].remove_indent(),t++},this.trim=function(e){for(e=e!==undefined&&e,this.current_line.trim(t,n);e&&1<i.length&&this.current_line.is_empty();)i.pop(),this.current_line=i[i.length-1],this.current_line.trim();this.previous_line=1<i.length?i[i.length-2]:null},this.just_added_newline=function(){return this.current_line.is_empty()},this.just_added_blankline=function(){if(this.just_added_newline()){if(1===i.length)return!0;var e=i[i.length-2];return e.is_empty()}return!1}}(h,T)).raw=d.test_output_raw,t=[],v(L.BlockStatement),this.beautify=function(){var e,t;for(s=new function(v,S,e){var A="\n\r\t ".split(""),k=/[0-9]/,y=/[01234567]/,O=/[0123456789abcdefABCDEF]/,N="+ - * / % & ++ -- = += -= *= /= %= == === != !== > < >= <= >> << >>> >>>= >>= <<= && &= | || ! ~ , : ? ^ ^= |= :: =>".split(" ");this.line_starters="continue,try,throw,return,var,let,const,if,switch,case,default,for,while,break,function,import,export".split(",");var D,C,L,I,V,P,j=this.line_starters.concat(["do","in","else","get","set","new","catch","finally","typeof","yield","async","await"]),B=/([\s\S]*?)((?:\*\/)|$)/g,M=/([^\n\r\u2028\u2029]*)/g,U=/\/\* beautify( \w+[:]\w+)+ \*\//g,W=/ (\w+)[:](\w+)/g,z=/([\s\S]*?)((?:\/\*\sbeautify\signore:end\s\*\/)|$)/g,G=/((<\?php|<\?=)[\s\S]*?\?>)|(<%[\s\S]*?%>)/g;function _(){var e,t,n=[];if(D=0,C="",P<=V)return["","TK_EOF"];t=I.length?I[I.length-1]:new Q("TK_START_BLOCK","{");var i=v.charAt(V);for(V+=1;F(i,A);){if(X.newline.test(i)?"\n"===i&&"\r"===v.charAt(V-2)||(D+=1,n=[]):n.push(i),P<=V)return["","TK_EOF"];i=v.charAt(V),V+=1}if(n.length&&(C=n.join("")),k.test(i)){var r=!0,s=!0,_=k;for("0"===i&&V<P&&/[Xxo]/.test(v.charAt(V))?(s=r=!1,i+=v.charAt(V),V+=1,_=/[o]/.test(v.charAt(V))?y:O):(i="",V-=1);V<P&&_.test(v.charAt(V));)i+=v.charAt(V),V+=1,r&&V<P&&"."===v.charAt(V)&&(i+=v.charAt(V),V+=1,r=!1),s&&V<P&&/[Ee]/.test(v.charAt(V))&&(i+=v.charAt(V),(V+=1)<P&&/[+-]/.test(v.charAt(V))&&(i+=v.charAt(V),V+=1),r=s=!1);return[i,"TK_WORD"]}if(X.isIdentifierStart(v.charCodeAt(V-1))){if(V<P)for(;X.isIdentifierChar(v.charCodeAt(V))&&(i+=v.charAt(V),(V+=1)!==P););return"TK_DOT"===t.type||"TK_RESERVED"===t.type&&F(t.text,["set","get"])||!F(i,j)?[i,"TK_WORD"]:"in"===i?[i,"TK_OPERATOR"]:[i,"TK_RESERVED"]}if("("===i||"["===i)return[i,"TK_START_EXPR"];if(")"===i||"]"===i)return[i,"TK_END_EXPR"];if("{"===i)return[i,"TK_START_BLOCK"];if("}"===i)return[i,"TK_END_BLOCK"];if(";"===i)return[i,"TK_SEMICOLON"];if("/"===i){var a="";if("*"===v.charAt(V)){V+=1,B.lastIndex=V;var o=B.exec(v);a="/*"+o[0],V+=o[0].length;var l=function(e){if(!e.match(U))return null;var t={};W.lastIndex=0;var n=W.exec(e);for(;n;)t[n[1]]=n[2],n=W.exec(e);return t}(a);return l&&"start"===l.ignore&&(z.lastIndex=V,o=z.exec(v),a+=o[0],V+=o[0].length),[a=a.replace(X.lineBreak,"\n"),"TK_BLOCK_COMMENT",l]}if("/"===v.charAt(V)){V+=1,M.lastIndex=V;var o=M.exec(v);return a="//"+o[0],V+=o[0].length,[a,"TK_COMMENT"]}}if("`"===i||"'"===i||'"'===i||("/"===i||S.e4x&&"<"===i&&v.slice(V-1).match(/^<([-a-zA-Z:0-9_.]+|{[^{}]*}|!\[CDATA\[[\s\S]*?\]\])(\s+[-a-zA-Z:0-9_.]+\s*=\s*('[^']*'|"[^"]*"|{.*?}))*\s*(\/?)\s*>/))&&("TK_RESERVED"===t.type&&F(t.text,["return","case","throw","else","do","typeof","yield"])||"TK_END_EXPR"===t.type&&")"===t.text&&t.parent&&"TK_RESERVED"===t.parent.type&&F(t.parent.text,["if","while","for"])||F(t.type,["TK_COMMENT","TK_START_EXPR","TK_START_BLOCK","TK_END_BLOCK","TK_OPERATOR","TK_EQUALS","TK_EOF","TK_SEMICOLON","TK_COMMA"]))){var h=i,c=!1,u=!1;if(e=i,"/"===h)for(var p=!1;V<P&&(c||p||v.charAt(V)!==h)&&!X.newline.test(v.charAt(V));)e+=v.charAt(V),c?c=!1:(c="\\"===v.charAt(V),"["===v.charAt(V)?p=!0:"]"===v.charAt(V)&&(p=!1)),V+=1;else if(S.e4x&&"<"===h){var d=/<(\/?)([-a-zA-Z:0-9_.]+|{[^{}]*}|!\[CDATA\[[\s\S]*?\]\])(\s+[-a-zA-Z:0-9_.]+\s*=\s*('[^']*'|"[^"]*"|{.*?}))*\s*(\/?)\s*>/g,f=v.slice(V-1),T=d.exec(f);if(T&&0===T.index){for(var E=T[2],g=0;T;){var x=!!T[1],w=T[2],K=!!T[T.length-1]||"![CDATA["===w.slice(0,8);if(w!==E||K||(x?--g:++g),g<=0)break;T=d.exec(f)}var m=T?T.index+T[0].length:f.length;return f=f.slice(0,m),V+=m-1,[f=f.replace(X.lineBreak,"\n"),"TK_STRING"]}}else for(;V<P&&(c||v.charAt(V)!==h&&("`"===h||!X.newline.test(v.charAt(V))));)(c||"`"===h)&&X.newline.test(v.charAt(V))?("\r"===v.charAt(V)&&"\n"===v.charAt(V+1)&&(V+=1),e+="\n"):e+=v.charAt(V),c?("x"!==v.charAt(V)&&"u"!==v.charAt(V)||(u=!0),c=!1):c="\\"===v.charAt(V),V+=1;if(u&&S.unescape_strings&&(e=function(e){var t,n=!1,i="",r=0,s="",_=0;for(;n||r<e.length;)if(t=e.charAt(r),r++,n){if(n=!1,"x"===t)s=e.substr(r,2),r+=2;else{if("u"!==t){i+="\\"+t;continue}s=e.substr(r,4),r+=4}if(!s.match(/^[0123456789abcdefABCDEF]+$/))return e;if(0<=(_=parseInt(s,16))&&_<32){i+="x"===t?"\\x"+s:"\\u"+s;continue}if(34===_||39===_||92===_)i+="\\"+String.fromCharCode(_);else{if("x"===t&&126<_&&_<=255)return e;i+=String.fromCharCode(_)}}else"\\"===t?n=!0:i+=t;return i}(e)),V<P&&v.charAt(V)===h&&(e+=h,V+=1,"/"===h))for(;V<P&&X.isIdentifierStart(v.charCodeAt(V));)e+=v.charAt(V),V+=1;return[e,"TK_STRING"]}if("#"===i){if(0===I.length&&"!"===v.charAt(V)){for(e=i;V<P&&"\n"!==i;)i=v.charAt(V),e+=i,V+=1;return[$(e)+"\n","TK_UNKNOWN"]}var R="#";if(V<P&&k.test(v.charAt(V))){for(;i=v.charAt(V),R+=i,(V+=1)<P&&"#"!==i&&"="!==i;);return"#"===i||("["===v.charAt(V)&&"]"===v.charAt(V+1)?(R+="[]",V+=2):"{"===v.charAt(V)&&"}"===v.charAt(V+1)&&(R+="{}",V+=2)),[R,"TK_WORD"]}}if("<"===i&&("?"===v.charAt(V)||"%"===v.charAt(V))){G.lastIndex=V-1;var b=G.exec(v);if(b)return i=b[0],V+=i.length-1,[i=i.replace(X.lineBreak,"\n"),"TK_STRING"]}if("<"===i&&"\x3c!--"===v.substring(V-1,V+3)){for(V+=3,i="\x3c!--";!X.newline.test(v.charAt(V))&&V<P;)i+=v.charAt(V),V++;return L=!0,[i,"TK_COMMENT"]}if("-"===i&&L&&"--\x3e"===v.substring(V-1,V+2))return L=!1,V+=2,["--\x3e","TK_COMMENT"];if("."===i)return[i,"TK_DOT"];if(F(i,N)){for(;V<P&&F(i+v.charAt(V),N)&&(i+=v.charAt(V),!(P<=(V+=1))););return","===i?[i,"TK_COMMA"]:"="===i?[i,"TK_EQUALS"]:[i,"TK_OPERATOR"]}return[i,"TK_UNKNOWN"]}this.tokenize=function(){var e,t,n;P=v.length,V=0,L=!1,I=[];for(var i=null,r=[],s=[];!t||"TK_EOF"!==t.type;){for(n=_(),e=new Q(n[1],n[0],D,C);"TK_COMMENT"===e.type||"TK_BLOCK_COMMENT"===e.type||"TK_UNKNOWN"===e.type;)"TK_BLOCK_COMMENT"===e.type&&(e.directives=n[2]),s.push(e),n=_(),e=new Q(n[1],n[0],D,C);s.length&&(e.comments_before=s,s=[]),"TK_START_BLOCK"===e.type||"TK_START_EXPR"===e.type?(e.parent=t,r.push(i),i=e):("TK_END_BLOCK"===e.type||"TK_END_EXPR"===e.type)&&i&&("]"===e.text&&"["===i.text||")"===e.text&&"("===i.text||"}"===e.text&&"{"===i.text)&&(e.parent=i.parent,i=r.pop()),I.push(e),t=e}return I}}(i,d,h),f=s.tokenize(),r=0;e=D();){for(var n=0;n<e.comments_before.length;n++)x(e.comments_before[n]);x(e),l=c.last_text,o=e.type,c.last_text=e.text,r+=1}return t=_.get_code(),d.end_with_newline&&(t+="\n"),"\n"!=d.eol&&(t=t.replace(/[\n]/g,d.eol)),t}}(e,t).beautify()}e=X,t="\xaa\xb5\xba\xc0-\xd6\xd8-\xf6\xf8-\u02c1\u02c6-\u02d1\u02e0-\u02e4\u02ec\u02ee\u0370-\u0374\u0376\u0377\u037a-\u037d\u0386\u0388-\u038a\u038c\u038e-\u03a1\u03a3-\u03f5\u03f7-\u0481\u048a-\u0527\u0531-\u0556\u0559\u0561-\u0587\u05d0-\u05ea\u05f0-\u05f2\u0620-\u064a\u066e\u066f\u0671-\u06d3\u06d5\u06e5\u06e6\u06ee\u06ef\u06fa-\u06fc\u06ff\u0710\u0712-\u072f\u074d-\u07a5\u07b1\u07ca-\u07ea\u07f4\u07f5\u07fa\u0800-\u0815\u081a\u0824\u0828\u0840-\u0858\u08a0\u08a2-\u08ac\u0904-\u0939\u093d\u0950\u0958-\u0961\u0971-\u0977\u0979-\u097f\u0985-\u098c\u098f\u0990\u0993-\u09a8\u09aa-\u09b0\u09b2\u09b6-\u09b9\u09bd\u09ce\u09dc\u09dd\u09df-\u09e1\u09f0\u09f1\u0a05-\u0a0a\u0a0f\u0a10\u0a13-\u0a28\u0a2a-\u0a30\u0a32\u0a33\u0a35\u0a36\u0a38\u0a39\u0a59-\u0a5c\u0a5e\u0a72-\u0a74\u0a85-\u0a8d\u0a8f-\u0a91\u0a93-\u0aa8\u0aaa-\u0ab0\u0ab2\u0ab3\u0ab5-\u0ab9\u0abd\u0ad0\u0ae0\u0ae1\u0b05-\u0b0c\u0b0f\u0b10\u0b13-\u0b28\u0b2a-\u0b30\u0b32\u0b33\u0b35-\u0b39\u0b3d\u0b5c\u0b5d\u0b5f-\u0b61\u0b71\u0b83\u0b85-\u0b8a\u0b8e-\u0b90\u0b92-\u0b95\u0b99\u0b9a\u0b9c\u0b9e\u0b9f\u0ba3\u0ba4\u0ba8-\u0baa\u0bae-\u0bb9\u0bd0\u0c05-\u0c0c\u0c0e-\u0c10\u0c12-\u0c28\u0c2a-\u0c33\u0c35-\u0c39\u0c3d\u0c58\u0c59\u0c60\u0c61\u0c85-\u0c8c\u0c8e-\u0c90\u0c92-\u0ca8\u0caa-\u0cb3\u0cb5-\u0cb9\u0cbd\u0cde\u0ce0\u0ce1\u0cf1\u0cf2\u0d05-\u0d0c\u0d0e-\u0d10\u0d12-\u0d3a\u0d3d\u0d4e\u0d60\u0d61\u0d7a-\u0d7f\u0d85-\u0d96\u0d9a-\u0db1\u0db3-\u0dbb\u0dbd\u0dc0-\u0dc6\u0e01-\u0e30\u0e32\u0e33\u0e40-\u0e46\u0e81\u0e82\u0e84\u0e87\u0e88\u0e8a\u0e8d\u0e94-\u0e97\u0e99-\u0e9f\u0ea1-\u0ea3\u0ea5\u0ea7\u0eaa\u0eab\u0ead-\u0eb0\u0eb2\u0eb3\u0ebd\u0ec0-\u0ec4\u0ec6\u0edc-\u0edf\u0f00\u0f40-\u0f47\u0f49-\u0f6c\u0f88-\u0f8c\u1000-\u102a\u103f\u1050-\u1055\u105a-\u105d\u1061\u1065\u1066\u106e-\u1070\u1075-\u1081\u108e\u10a0-\u10c5\u10c7\u10cd\u10d0-\u10fa\u10fc-\u1248\u124a-\u124d\u1250-\u1256\u1258\u125a-\u125d\u1260-\u1288\u128a-\u128d\u1290-\u12b0\u12b2-\u12b5\u12b8-\u12be\u12c0\u12c2-\u12c5\u12c8-\u12d6\u12d8-\u1310\u1312-\u1315\u1318-\u135a\u1380-\u138f\u13a0-\u13f4\u1401-\u166c\u166f-\u167f\u1681-\u169a\u16a0-\u16ea\u16ee-\u16f0\u1700-\u170c\u170e-\u1711\u1720-\u1731\u1740-\u1751\u1760-\u176c\u176e-\u1770\u1780-\u17b3\u17d7\u17dc\u1820-\u1877\u1880-\u18a8\u18aa\u18b0-\u18f5\u1900-\u191c\u1950-\u196d\u1970-\u1974\u1980-\u19ab\u19c1-\u19c7\u1a00-\u1a16\u1a20-\u1a54\u1aa7\u1b05-\u1b33\u1b45-\u1b4b\u1b83-\u1ba0\u1bae\u1baf\u1bba-\u1be5\u1c00-\u1c23\u1c4d-\u1c4f\u1c5a-\u1c7d\u1ce9-\u1cec\u1cee-\u1cf1\u1cf5\u1cf6\u1d00-\u1dbf\u1e00-\u1f15\u1f18-\u1f1d\u1f20-\u1f45\u1f48-\u1f4d\u1f50-\u1f57\u1f59\u1f5b\u1f5d\u1f5f-\u1f7d\u1f80-\u1fb4\u1fb6-\u1fbc\u1fbe\u1fc2-\u1fc4\u1fc6-\u1fcc\u1fd0-\u1fd3\u1fd6-\u1fdb\u1fe0-\u1fec\u1ff2-\u1ff4\u1ff6-\u1ffc\u2071\u207f\u2090-\u209c\u2102\u2107\u210a-\u2113\u2115\u2119-\u211d\u2124\u2126\u2128\u212a-\u212d\u212f-\u2139\u213c-\u213f\u2145-\u2149\u214e\u2160-\u2188\u2c00-\u2c2e\u2c30-\u2c5e\u2c60-\u2ce4\u2ceb-\u2cee\u2cf2\u2cf3\u2d00-\u2d25\u2d27\u2d2d\u2d30-\u2d67\u2d6f\u2d80-\u2d96\u2da0-\u2da6\u2da8-\u2dae\u2db0-\u2db6\u2db8-\u2dbe\u2dc0-\u2dc6\u2dc8-\u2dce\u2dd0-\u2dd6\u2dd8-\u2dde\u2e2f\u3005-\u3007\u3021-\u3029\u3031-\u3035\u3038-\u303c\u3041-\u3096\u309d-\u309f\u30a1-\u30fa\u30fc-\u30ff\u3105-\u312d\u3131-\u318e\u31a0-\u31ba\u31f0-\u31ff\u3400-\u4db5\u4e00-\u9fcc\ua000-\ua48c\ua4d0-\ua4fd\ua500-\ua60c\ua610-\ua61f\ua62a\ua62b\ua640-\ua66e\ua67f-\ua697\ua6a0-\ua6ef\ua717-\ua71f\ua722-\ua788\ua78b-\ua78e\ua790-\ua793\ua7a0-\ua7aa\ua7f8-\ua801\ua803-\ua805\ua807-\ua80a\ua80c-\ua822\ua840-\ua873\ua882-\ua8b3\ua8f2-\ua8f7\ua8fb\ua90a-\ua925\ua930-\ua946\ua960-\ua97c\ua984-\ua9b2\ua9cf\uaa00-\uaa28\uaa40-\uaa42\uaa44-\uaa4b\uaa60-\uaa76\uaa7a\uaa80-\uaaaf\uaab1\uaab5\uaab6\uaab9-\uaabd\uaac0\uaac2\uaadb-\uaadd\uaae0-\uaaea\uaaf2-\uaaf4\uab01-\uab06\uab09-\uab0e\uab11-\uab16\uab20-\uab26\uab28-\uab2e\uabc0-\uabe2\uac00-\ud7a3\ud7b0-\ud7c6\ud7cb-\ud7fb\uf900-\ufa6d\ufa70-\ufad9\ufb00-\ufb06\ufb13-\ufb17\ufb1d\ufb1f-\ufb28\ufb2a-\ufb36\ufb38-\ufb3c\ufb3e\ufb40\ufb41\ufb43\ufb44\ufb46-\ufbb1\ufbd3-\ufd3d\ufd50-\ufd8f\ufd92-\ufdc7\ufdf0-\ufdfb\ufe70-\ufe74\ufe76-\ufefc\uff21-\uff3a\uff41-\uff5a\uff66-\uffbe\uffc2-\uffc7\uffca-\uffcf\uffd2-\uffd7\uffda-\uffdc",n=new RegExp("["+t+"]"),i=new RegExp("["+t+"\u0300-\u036f\u0483-\u0487\u0591-\u05bd\u05bf\u05c1\u05c2\u05c4\u05c5\u05c7\u0610-\u061a\u0620-\u0649\u0672-\u06d3\u06e7-\u06e8\u06fb-\u06fc\u0730-\u074a\u0800-\u0814\u081b-\u0823\u0825-\u0827\u0829-\u082d\u0840-\u0857\u08e4-\u08fe\u0900-\u0903\u093a-\u093c\u093e-\u094f\u0951-\u0957\u0962-\u0963\u0966-\u096f\u0981-\u0983\u09bc\u09be-\u09c4\u09c7\u09c8\u09d7\u09df-\u09e0\u0a01-\u0a03\u0a3c\u0a3e-\u0a42\u0a47\u0a48\u0a4b-\u0a4d\u0a51\u0a66-\u0a71\u0a75\u0a81-\u0a83\u0abc\u0abe-\u0ac5\u0ac7-\u0ac9\u0acb-\u0acd\u0ae2-\u0ae3\u0ae6-\u0aef\u0b01-\u0b03\u0b3c\u0b3e-\u0b44\u0b47\u0b48\u0b4b-\u0b4d\u0b56\u0b57\u0b5f-\u0b60\u0b66-\u0b6f\u0b82\u0bbe-\u0bc2\u0bc6-\u0bc8\u0bca-\u0bcd\u0bd7\u0be6-\u0bef\u0c01-\u0c03\u0c46-\u0c48\u0c4a-\u0c4d\u0c55\u0c56\u0c62-\u0c63\u0c66-\u0c6f\u0c82\u0c83\u0cbc\u0cbe-\u0cc4\u0cc6-\u0cc8\u0cca-\u0ccd\u0cd5\u0cd6\u0ce2-\u0ce3\u0ce6-\u0cef\u0d02\u0d03\u0d46-\u0d48\u0d57\u0d62-\u0d63\u0d66-\u0d6f\u0d82\u0d83\u0dca\u0dcf-\u0dd4\u0dd6\u0dd8-\u0ddf\u0df2\u0df3\u0e34-\u0e3a\u0e40-\u0e45\u0e50-\u0e59\u0eb4-\u0eb9\u0ec8-\u0ecd\u0ed0-\u0ed9\u0f18\u0f19\u0f20-\u0f29\u0f35\u0f37\u0f39\u0f41-\u0f47\u0f71-\u0f84\u0f86-\u0f87\u0f8d-\u0f97\u0f99-\u0fbc\u0fc6\u1000-\u1029\u1040-\u1049\u1067-\u106d\u1071-\u1074\u1082-\u108d\u108f-\u109d\u135d-\u135f\u170e-\u1710\u1720-\u1730\u1740-\u1750\u1772\u1773\u1780-\u17b2\u17dd\u17e0-\u17e9\u180b-\u180d\u1810-\u1819\u1920-\u192b\u1930-\u193b\u1951-\u196d\u19b0-\u19c0\u19c8-\u19c9\u19d0-\u19d9\u1a00-\u1a15\u1a20-\u1a53\u1a60-\u1a7c\u1a7f-\u1a89\u1a90-\u1a99\u1b46-\u1b4b\u1b50-\u1b59\u1b6b-\u1b73\u1bb0-\u1bb9\u1be6-\u1bf3\u1c00-\u1c22\u1c40-\u1c49\u1c5b-\u1c7d\u1cd0-\u1cd2\u1d00-\u1dbe\u1e01-\u1f15\u200c\u200d\u203f\u2040\u2054\u20d0-\u20dc\u20e1\u20e5-\u20f0\u2d81-\u2d96\u2de0-\u2dff\u3021-\u3028\u3099\u309a\ua640-\ua66d\ua674-\ua67d\ua69f\ua6f0-\ua6f1\ua7f8-\ua800\ua806\ua80b\ua823-\ua827\ua880-\ua881\ua8b4-\ua8c4\ua8d0-\ua8d9\ua8f3-\ua8f7\ua900-\ua909\ua926-\ua92d\ua930-\ua945\ua980-\ua983\ua9b3-\ua9c0\uaa00-\uaa27\uaa40-\uaa41\uaa4c-\uaa4d\uaa50-\uaa59\uaa7b\uaae0-\uaae9\uaaf2-\uaaf3\uabc0-\uabe1\uabec\uabed\uabf0-\uabf9\ufb20-\ufb28\ufe00-\ufe0f\ufe20-\ufe26\ufe33\ufe34\ufe4d-\ufe4f\uff10-\uff19\uff3f]"),e.newline=/[\n\r\u2028\u2029]/,e.lineBreak=new RegExp("\r\n|"+e.newline.source),e.allLineBreaks=new RegExp(e.lineBreak.source,"g"),e.isIdentifierStart=function(e){return e<65?36===e||64===e:e<91||(e<97?95===e:e<123||170<=e&&n.test(String.fromCharCode(e)))},e.isIdentifierChar=function(e){return e<48?36===e:e<58||!(e<65)&&(e<91||(e<97?95===e:e<123||170<=e&&i.test(String.fromCharCode(e))))};var L={BlockStatement:"BlockStatement",Statement:"Statement",ObjectLiteral:"ObjectLiteral",ArrayLiteral:"ArrayLiteral",ForInitializer:"ForInitializer",Conditional:"Conditional",Expression:"Expression"};var Q=function(e,t,n,i,r,s){this.type=e,this.text=t,this.comments_before=[],this.newlines=n||0,this.wanted_newline=0<n,this.whitespace_before=i||"",this.parent=null,this.directives=null};return{run:function(e,t){function _(e){return e.replace(/\s+$/g,"")}var n,i,r,T,s,a,E,o,l,g,x,w,h,c;for((t=t||{}).wrap_line_length!==undefined&&0!==parseInt(t.wrap_line_length,10)||t.max_char===undefined||0===parseInt(t.max_char,10)||(t.wrap_line_length=t.max_char),i=t.indent_inner_html!==undefined&&t.indent_inner_html,r=t.indent_size===undefined?4:parseInt(t.indent_size,10),T=t.indent_char===undefined?" ":t.indent_char,a=t.brace_style===undefined?"collapse":t.brace_style,s=0===parseInt(t.wrap_line_length,10)?32786:parseInt(t.wrap_line_length||250,10),E=t.unformatted||["a","span","img","bdo","em","strong","dfn","code","samp","kbd","var","cite","abbr","acronym","q","sub","sup","tt","i","b","big","small","u","s","strike","font","ins","del","address","pre"],o=t.preserve_newlines===undefined||t.preserve_newlines,l=o?isNaN(parseInt(t.max_preserve_newlines,10))?32786:parseInt(t.max_preserve_newlines,10):0,g=t.indent_handlebars!==undefined&&t.indent_handlebars,x=t.wrap_attributes===undefined?"auto":t.wrap_attributes,w=t.wrap_attributes_indent_size===undefined?r:parseInt(t.wrap_attributes_indent_size,10)||r,h=t.end_with_newline!==undefined&&t.end_with_newline,c=Array.isArray(t.extra_liners)?t.extra_liners.concat():"string"==typeof t.extra_liners?t.extra_liners.split(","):"head,body,/html".split(","),t.indent_with_tabs&&(T="\t",r=1),(n=new function(){return this.pos=0,this.token="",this.current_mode="CONTENT",this.tags={parent:"parent1",parentcount:1,parent1:""},this.tag_type="",this.token_text=this.last_token=this.last_text=this.token_type="",this.newlines=0,this.indent_content=i,this.Utils={whitespace:"\n\r\t ".split(""),single_token:"br,input,link,meta,source,!doctype,basefont,base,area,hr,wbr,param,img,isindex,embed".split(","),extra_liners:c,in_array:function(e,t){for(var n=0;n<t.length;n++)if(e==t[n])return!0;return!1}},this.is_whitespace=function(e){for(;0<e.length;e++)if(!this.Utils.in_array(e.charAt(0),this.Utils.whitespace))return!1;return!0},this.traverse_whitespace=function(){var e="";if(e=this.input.charAt(this.pos),this.Utils.in_array(e,this.Utils.whitespace)){for(this.newlines=0;this.Utils.in_array(e,this.Utils.whitespace);)o&&"\n"==e&&this.newlines<=l&&(this.newlines+=1),this.pos++,e=this.input.charAt(this.pos);return!0}return!1},this.space_or_wrap=function(e){this.line_char_count>=this.wrap_line_length?(this.print_newline(!1,e),this.print_indentation(e)):(this.line_char_count++,e.push(" "))},this.get_content=function(){for(var e="",t=[];"<"!=this.input.charAt(this.pos);){if(this.pos>=this.input.length)return t.length?t.join(""):["","TK_EOF"];if(this.traverse_whitespace())this.space_or_wrap(t);else{if(g){var n=this.input.substr(this.pos,3);if("{{#"==n||"{{/"==n)break;if("{{!"==n)return[this.get_tag(),"TK_TAG_HANDLEBARS_COMMENT"];if("{{"==this.input.substr(this.pos,2)&&"{{else}}"==this.get_tag(!0))break}e=this.input.charAt(this.pos),this.pos++,this.line_char_count++,t.push(e)}}return t.length?t.join(""):""},this.get_contents_to=function(e){if(this.pos==this.input.length)return["","TK_EOF"];var t="",n=new RegExp("</"+e+"\\s*>","igm");n.lastIndex=this.pos;var i=n.exec(this.input),r=i?i.index:this.input.length;return this.pos<r&&(t=this.input.substring(this.pos,r),this.pos=r),t},this.record_tag=function(e){this.tags[e+"count"]?this.tags[e+"count"]++:this.tags[e+"count"]=1,this.tags[e+this.tags[e+"count"]]=this.indent_level,this.tags[e+this.tags[e+"count"]+"parent"]=this.tags.parent,this.tags.parent=e+this.tags[e+"count"]},this.retrieve_tag=function(e){if(this.tags[e+"count"]){for(var t=this.tags.parent;t&&e+this.tags[e+"count"]!=t;)t=this.tags[t+"parent"];t&&(this.indent_level=this.tags[e+this.tags[e+"count"]],this.tags.parent=this.tags[t+"parent"]),delete this.tags[e+this.tags[e+"count"]+"parent"],delete this.tags[e+this.tags[e+"count"]],1==this.tags[e+"count"]?delete this.tags[e+"count"]:this.tags[e+"count"]--}},this.indent_to_tag=function(e){if(this.tags[e+"count"]){for(var t=this.tags.parent;t&&e+this.tags[e+"count"]!=t;)t=this.tags[t+"parent"];t&&(this.indent_level=this.tags[e+this.tags[e+"count"]])}},this.get_tag=function(e){var t,n,i="",r=[],s="",_=!1,a=!0,o=this.pos,l=this.line_char_count;e=e!==undefined&&e;do{if(this.pos>=this.input.length)return e&&(this.pos=o,this.line_char_count=l),r.length?r.join(""):["","TK_EOF"];if(i=this.input.charAt(this.pos),this.pos++,this.Utils.in_array(i,this.Utils.whitespace))_=!0;else{if("'"!=i&&'"'!=i||(i+=this.get_unformatted(i),_=!0),"="==i&&(_=!1),r.length&&"="!=r[r.length-1]&&">"!=i&&_){if(this.space_or_wrap(r),_=!1,!a&&"force"==x&&"/"!=i){this.print_newline(!0,r),this.print_indentation(r);for(var h=0;h<w;h++)r.push(T)}for(var c=0;c<r.length;c++)if(" "==r[c]){a=!1;break}}if(g&&"<"==n&&i+this.input.charAt(this.pos)=="{{"&&(i+=this.get_unformatted("}}"),r.length&&" "!=r[r.length-1]&&"<"!=r[r.length-1]&&(i=" "+i),_=!0),"<"!=i||n||(t=this.pos-1,n="<"),g&&!n&&2<=r.length&&"{"==r[r.length-1]&&"{"==r[r.length-2]&&(t="#"==i||"/"==i||"!"==i?this.pos-3:this.pos-2,n="{"),this.line_char_count++,r.push(i),r[1]&&("!"==r[1]||"?"==r[1]||"%"==r[1])){r=[this.get_comment(t)];break}if(g&&r[1]&&"{"==r[1]&&r[2]&&"!"==r[2]){r=[this.get_comment(t)];break}if(g&&"{"==n&&2<r.length&&"}"==r[r.length-2]&&"}"==r[r.length-1])break}}while(">"!=i);var u,p,d=r.join("");u=-1!=d.indexOf(" ")?d.indexOf(" "):"{"==d[0]?d.indexOf("}"):d.indexOf(">"),p="<"!=d[0]&&g?"#"==d[2]?3:2:1;var f=d.substring(p,u).toLowerCase();return"/"==d.charAt(d.length-2)||this.Utils.in_array(f,this.Utils.single_token)?e||(this.tag_type="SINGLE"):g&&"{"==d[0]&&"else"==f?e||(this.indent_to_tag("if"),this.tag_type="HANDLEBARS_ELSE",this.indent_content=!0,this.traverse_whitespace()):this.is_unformatted(f,E)?(s=this.get_unformatted("</"+f+">",d),r.push(s),this.pos,this.tag_type="SINGLE"):"script"==f&&(-1==d.search("type")||-1<d.search("type")&&-1<d.search(/\b(text|application)\/(x-)?(javascript|ecmascript|jscript|livescript)/))?e||(this.record_tag(f),this.tag_type="SCRIPT"):"style"==f&&(-1==d.search("type")||-1<d.search("type")&&-1<d.search("text/css"))?e||(this.record_tag(f),this.tag_type="STYLE"):"!"==f.charAt(0)?e||(this.tag_type="SINGLE",this.traverse_whitespace()):e||("/"==f.charAt(0)?(this.retrieve_tag(f.substring(1)),this.tag_type="END"):(this.record_tag(f),"html"!=f.toLowerCase()&&(this.indent_content=!0),this.tag_type="START"),this.traverse_whitespace()&&this.space_or_wrap(r),this.Utils.in_array(f,this.Utils.extra_liners)&&(this.print_newline(!1,this.output),this.output.length&&"\n"!=this.output[this.output.length-2]&&this.print_newline(!0,this.output))),e&&(this.pos=o,this.line_char_count=l),r.join("")},this.get_comment=function(e){var t="",n=">",i=!1;this.pos=e;var r=this.input.charAt(this.pos);for(this.pos++;this.pos<=this.input.length&&((t+=r)[t.length-1]!=n[n.length-1]||-1==t.indexOf(n));)!i&&t.length<10&&(0===t.indexOf("<![if")?(n="<![endif]>",i=!0):0===t.indexOf("<![cdata[")?(n="]]>",i=!0):0===t.indexOf("<![")?(n="]>",i=!0):0===t.indexOf("\x3c!--")?(n="--\x3e",i=!0):0===t.indexOf("{{!")?(n="}}",i=!0):0===t.indexOf("<?")?(n="?>",i=!0):0===t.indexOf("<%")&&(n="%>",i=!0)),r=this.input.charAt(this.pos),this.pos++;return t},this.get_unformatted=function(e,t){if(t&&-1!=t.toLowerCase().indexOf(e))return"";var n="",i="",r=0,s=!0;do{if(this.pos>=this.input.length)return i;if(n=this.input.charAt(this.pos),this.pos++,this.Utils.in_array(n,this.Utils.whitespace)){if(!s){this.line_char_count--;continue}if("\n"==n||"\r"==n){i+="\n",this.line_char_count=0;continue}}i+=n,this.line_char_count++,s=!0,g&&"{"==n&&i.length&&"{"==i[i.length-2]&&(r=(i+=this.get_unformatted("}}")).length)}while(-1==i.toLowerCase().indexOf(e,r));return i},this.get_token=function(){var e;if("TK_TAG_SCRIPT"==this.last_token||"TK_TAG_STYLE"==this.last_token){var t=this.last_token.substr(7);return"string"!=typeof(e=this.get_contents_to(t))?e:[e,"TK_"+t]}return"CONTENT"==this.current_mode?"string"!=typeof(e=this.get_content())?e:[e,"TK_CONTENT"]:"TAG"==this.current_mode?"string"!=typeof(e=this.get_tag())?e:[e,"TK_TAG_"+this.tag_type]:void 0},this.get_full_indent=function(e){return(e=this.indent_level+e||0)<1?"":new Array(e+1).join(this.indent_string)},this.is_unformatted=function(e,t){if(!this.Utils.in_array(e,t))return!1;if("a"!=e.toLowerCase()||!this.Utils.in_array("a",t))return!0;var n=(this.get_tag(!0)||"").match(/^\s*<\s*\/?([a-z]*)\s*[^>]*>\s*$/);return!(n&&!this.Utils.in_array(n,t))},this.printer=function(e,t,n,i,r){this.input=e||"",this.output=[],this.indent_character=t,this.indent_string="",this.indent_size=n,this.brace_style=r,this.indent_level=0,this.wrap_line_length=i;for(var s=this.line_char_count=0;s<this.indent_size;s++)this.indent_string+=this.indent_character;this.print_newline=function(e,t){this.line_char_count=0,t&&t.length&&(e||"\n"!=t[t.length-1])&&("\n"!=t[t.length-1]&&(t[t.length-1]=_(t[t.length-1])),t.push("\n"))},this.print_indentation=function(e){for(var t=0;t<this.indent_level;t++)e.push(this.indent_string),this.line_char_count+=this.indent_string.length},this.print_token=function(e){this.is_whitespace(e)&&!this.output.length||((e||""!==e)&&this.output.length&&"\n"==this.output[this.output.length-1]&&(this.print_indentation(this.output),e=e.replace(/^\s+/g,"")),this.print_token_raw(e))},this.print_token_raw=function(e){0<this.newlines&&(e=_(e)),e&&""!==e&&(1<e.length&&"\n"==e[e.length-1]?(this.output.push(e.slice(0,-1)),this.print_newline(!1,this.output)):this.output.push(e));for(var t=0;t<this.newlines;t++)this.print_newline(0<t,this.output);this.newlines=0},this.indent=function(){this.indent_level++},this.unindent=function(){0<this.indent_level&&this.indent_level--}},this}).printer(e,T,r,s,a);;){var u=n.get_token();if(n.token_text=u[0],n.token_type=u[1],"TK_EOF"==n.token_type)break;switch(n.token_type){case"TK_TAG_START":n.print_newline(!1,n.output),n.print_token(n.token_text),n.indent_content&&(n.indent(),n.indent_content=!1),n.current_mode="CONTENT";break;case"TK_TAG_STYLE":case"TK_TAG_SCRIPT":n.print_newline(!1,n.output),n.print_token(n.token_text),n.current_mode="CONTENT";break;case"TK_TAG_END":if("TK_CONTENT"==n.last_token&&""===n.last_text){var p=n.token_text.match(/\w+/)[0],d=null;n.output.length&&(d=n.output[n.output.length-1].match(/(?:<|{{#)\s*(\w+)/)),(null==d||d[1]!=p&&!n.Utils.in_array(d[1],E))&&n.print_newline(!1,n.output)}n.print_token(n.token_text),n.current_mode="CONTENT";break;case"TK_TAG_SINGLE":var f=n.token_text.match(/^\s*<([a-z-]+)/i);f&&n.Utils.in_array(f[1],E)||n.print_newline(!1,n.output),n.print_token(n.token_text),n.current_mode="CONTENT";break;case"TK_TAG_HANDLEBARS_ELSE":n.print_token(n.token_text),n.indent_content&&(n.indent(),n.indent_content=!1),n.current_mode="CONTENT";break;case"TK_TAG_HANDLEBARS_COMMENT":case"TK_CONTENT":n.print_token(n.token_text),n.current_mode="TAG";break;case"TK_STYLE":case"TK_SCRIPT":if(""!==n.token_text){n.print_newline(!1,n.output);var K,m=n.token_text,R=1;"TK_SCRIPT"==n.token_type?K=y:"TK_STYLE"==n.token_type&&(K=k),"keep"==t.indent_scripts?R=0:"separate"==t.indent_scripts&&(R=-n.indent_level);var b=n.get_full_indent(R);if(K)m=K(m.replace(/^\s*/,b),t);else{var v=m.match(/^\s*/)[0].match(/[^\n\r]*$/)[0].split(n.indent_string).length-1,S=n.get_full_indent(R-v);m=m.replace(/^\s*/,b).replace(/\r\n|\r|\n/g,"\n"+S).replace(/\s+$/,"")}m&&(n.print_token_raw(m),n.print_newline(!0,n.output))}n.current_mode="TAG";break;default:""!==n.token_text&&n.print_token(n.token_text)}n.last_token=n.token_type,n.last_text=n.token_text}var A=n.output.join("").replace(/[\r\n\t ]+$/,"");return h&&(A+="\n"),A}}}});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(x){x.extend(x.FE.DEFAULTS,{codeMirror:window.CodeMirror,codeMirrorOptions:{lineNumbers:!0,tabMode:"indent",indentWithTabs:!0,lineWrapping:!0,mode:"text/html",tabSize:2},codeBeautifierOptions:{end_with_newline:!0,indent_inner_html:!0,extra_liners:["p","h1","h2","h3","h4","h5","h6","blockquote","pre","ul","ol","table","dl"],brace_style:"expand",indent_char:"\t",indent_size:1,wrap_line_length:0},codeViewKeepActiveButtons:["fullscreen"]}),x.FE.PLUGINS.codeView=function(l){var c,d;function h(){return l.$box.hasClass("fr-code-view")}function u(){return d?d.getValue():c.val()}function f(){h()&&(d&&d.setSize(null,l.opts.height?l.opts.height:"auto"),l.opts.heightMin||l.opts.height?l.$box.find(".CodeMirror-scroll, .CodeMirror-gutters").css("min-height",l.opts.heightMin||l.opts.height):l.$box.find(".CodeMirror-scroll, .CodeMirror-gutters").css("min-height",""))}var p,g=!1;function m(){h()&&l.events.trigger("blur")}function b(){h()&&g&&l.events.trigger("focus")}function s(e){c||(!function(){c=x('<textarea class="fr-code" tabIndex="-1">'),l.$wp.append(c),c.attr("dir",l.opts.direction),l.$box.hasClass("fr-basic")||(p=x('<a data-cmd="html" title="Code View" class="fr-command fr-btn html-switch'+(l.helpers.isMobile()?"":" fr-desktop")+'" role="button" tabIndex="-1"><i class="fa fa-code"></i></button>'),l.$box.append(p),l.events.bindClick(l.$box,"a.html-switch",function(){v(!1)}));var e=function(){return!h()};l.events.on("buttons.refresh",e),l.events.on("copy",e,!0),l.events.on("cut",e,!0),l.events.on("paste",e,!0),l.events.on("destroy",M,!0),l.events.on("html.set",function(){h()&&v(!0)}),l.events.on("codeView.update",f),l.events.on("form.submit",function(){h()&&(l.html.set(u()),l.events.trigger("contentChanged",[],!0))},!0)}(),!d&&l.opts.codeMirror?((d=l.opts.codeMirror.fromTextArea(c.get(0),l.opts.codeMirrorOptions)).on("blur",m),d.on("focus",b)):(l.events.$on(c,"keydown keyup change input",function(){l.opts.height?this.removeAttribute("rows"):(this.rows=1,0===this.value.length?this.style.height="auto":this.style.height=this.scrollHeight+"px")}),l.events.$on(c,"blur",m),l.events.$on(c,"focus",b))),l.undo.saveStep(),l.html.cleanEmptyTags(),l.html.cleanWhiteTags(!0),l.core.hasFocus()&&(l.core.isEmpty()||(l.selection.save(),l.$el.find('.fr-marker[data-type="true"]:first').replaceWith('<span class="fr-tmp fr-sm">F</span>'),l.$el.find('.fr-marker[data-type="false"]:last').replaceWith('<span class="fr-tmp fr-em">F</span>')));var t=l.html.get(!1,!0);l.$el.find("span.fr-tmp").remove(),l.$box.toggleClass("fr-code-view",!0);var n,i,s=!1;if(l.core.hasFocus()&&(s=!0,l.events.disableBlur(),l.$el.blur()),t=(t=t.replace(/<span class="fr-tmp fr-sm">F<\/span>/,"FROALA-SM")).replace(/<span class="fr-tmp fr-em">F<\/span>/,"FROALA-EM"),l.codeBeautifier&&(t=l.codeBeautifier.run(t,l.opts.codeBeautifierOptions)),d){n=t.indexOf("FROALA-SM"),(i=t.indexOf("FROALA-EM"))<n?n=i:i-=9;var o=(t=t.replace(/FROALA-SM/g,"").replace(/FROALA-EM/g,"")).substring(0,n).length-t.substring(0,n).replace(/\n/g,"").length,r=t.substring(0,i).length-t.substring(0,i).replace(/\n/g,"").length;n=t.substring(0,n).length-t.substring(0,t.substring(0,n).lastIndexOf("\n")+1).length,i=t.substring(0,i).length-t.substring(0,t.substring(0,i).lastIndexOf("\n")+1).length,d.setSize(null,l.opts.height?l.opts.height:"auto"),l.opts.heightMin&&l.$box.find(".CodeMirror-scroll").css("min-height",l.opts.heightMin),d.setValue(t),g=!s,d.focus(),g=!0,d.setSelection({line:o,ch:n},{line:r,ch:i}),d.refresh(),d.clearHistory()}else{n=t.indexOf("FROALA-SM"),i=t.indexOf("FROALA-EM")-9,l.opts.heightMin&&c.css("min-height",l.opts.heightMin),l.opts.height&&c.css("height",l.opts.height),l.opts.heightMax&&c.css("max-height",l.opts.height||l.opts.heightMax),c.val(t.replace(/FROALA-SM/g,"").replace(/FROALA-EM/g,"")).trigger("change");var a=x(l.o_doc).scrollTop();g=!s,c.focus(),g=!0,c.get(0).setSelectionRange(n,i),x(l.o_doc).scrollTop(a)}l.$tb.find(" > .fr-command").not(e).filter(function(){return l.opts.codeViewKeepActiveButtons.indexOf(x(this).data("cmd"))<0}).addClass("fr-disabled").attr("aria-disabled",!0),e.addClass("fr-active").attr("aria-pressed",!0),!l.helpers.isMobile()&&l.opts.toolbarInline&&l.toolbar.hide()}function v(e){void 0===e&&(e=!h());var t,n,i=l.$tb.find('.fr-command[data-cmd="html"]');e?(l.popups.hideAll(),s(i)):(l.$box.toggleClass("fr-code-view",!1),t=i,n=u(),l.html.set(n),l.$el.blur(),l.$tb.find(" > .fr-command").not(t).removeClass("fr-disabled").attr("aria-disabled",!1),t.removeClass("fr-active").attr("aria-pressed",!1),l.selection.setAtStart(l.el),l.selection.restore(),l.placeholder.refresh(),l.undo.saveStep())}function M(){h()&&v(!1),d&&d.toTextArea(),c.val("").removeData().remove(),c=null,p&&(p.remove(),p=null)}return{_init:function(){if(!l.$wp)return!1},toggle:v,isActive:h,get:u}},x.FE.RegisterCommand("html",{title:"Code View",undo:!1,focus:!1,forcedRefresh:!0,toggle:!0,callback:function(){this.codeView.toggle()},plugin:"codeView"}),x.FE.DefineIcon("html",{NAME:"code"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(r){"function"==typeof define&&define.amd?define(["jquery"],r):"object"==typeof module&&module.exports?module.exports=function(o,e){return e===undefined&&(e="undefined"!=typeof window?require("jquery"):require("jquery")(o)),r(e)}:r(window.jQuery)}(function(C){C.extend(C.FE.POPUP_TEMPLATES,{"colors.picker":"[_BUTTONS_][_TEXT_COLORS_][_BACKGROUND_COLORS_][_CUSTOM_COLOR_]"}),C.extend(C.FE.DEFAULTS,{colorsText:["#61BD6D","#1ABC9C","#54ACD2","#2C82C9","#9365B8","#475577","#CCCCCC","#41A85F","#00A885","#3D8EB9","#2969B0","#553982","#28324E","#000000","#F7DA64","#FBA026","#EB6B56","#E25041","#A38F84","#EFEFEF","#FFFFFF","#FAC51C","#F37934","#D14841","#B8312F","#7C706B","#D1D5D8","REMOVE"],colorsBackground:["#61BD6D","#1ABC9C","#54ACD2","#2C82C9","#9365B8","#475577","#CCCCCC","#41A85F","#00A885","#3D8EB9","#2969B0","#553982","#28324E","#000000","#F7DA64","#FBA026","#EB6B56","#E25041","#A38F84","#EFEFEF","#FFFFFF","#FAC51C","#F37934","#D14841","#B8312F","#7C706B","#D1D5D8","REMOVE"],colorsStep:7,colorsHEXInput:!0,colorsDefaultTab:"text",colorsButtons:["colorsBack","|","-"]}),C.FE.PLUGINS.colors=function(E){function e(){E.popups.hide("colors.picker")}function s(o){for(var e="text"==o?E.opts.colorsText:E.opts.colorsBackground,r='<div class="fr-color-set fr-'+o+"-color"+(E.opts.colorsDefaultTab==o||"text"!=E.opts.colorsDefaultTab&&"background"!=E.opts.colorsDefaultTab&&"text"==o?" fr-selected-set":"")+'">',t=0;t<e.length;t++)0!==t&&t%E.opts.colorsStep==0&&(r+="<br>"),"REMOVE"!=e[t]?r+='<span class="fr-command fr-select-color" style="background: '+e[t]+';" tabIndex="-1" aria-selected="false" role="button" data-cmd="'+o+'Color" data-param1="'+e[t]+'"><span class="fr-sr-only">'+E.language.translate("Color")+" "+e[t]+"&nbsp;&nbsp;&nbsp;</span></span>":r+='<span class="fr-command fr-select-color" data-cmd="'+o+'Color" tabIndex="-1" role="button" data-param1="REMOVE" title="'+E.language.translate("Clear Formatting")+'">'+E.icon.create("remove")+'<span class="fr-sr-only">'+E.language.translate("Clear Formatting")+"</span></span>";return r+"</div>"}function a(o){var e,r=E.popups.get("colors.picker"),t=C(E.selection.element());e="background"==o?"background-color":"color";var a=r.find(".fr-"+o+"-color .fr-select-color");for(a.find(".fr-selected-color").remove(),a.removeClass("fr-active-item"),a.not('[data-param1="REMOVE"]').attr("aria-selected",!1);t.get(0)!=E.el;){if("transparent"!=t.css(e)&&"rgba(0, 0, 0, 0)"!=t.css(e)){var s=r.find(".fr-"+o+'-color .fr-select-color[data-param1="'+E.helpers.RGBToHex(t.css(e))+'"]');s.append('<span class="fr-selected-color" aria-hidden="true">\uf00c</span>'),s.addClass("fr-active-item").attr("aria-selected",!0);break}t=t.parent()}var l=r.find(".fr-color-hex-layer input");l.length&&l.val(E.helpers.RGBToHex(t.css(e))).trigger("change")}function t(o){"REMOVE"!=o?E.format.applyStyle("background-color",E.helpers.HEXtoRGB(o)):E.format.removeStyle("background-color"),e()}function l(o){"REMOVE"!=o?E.format.applyStyle("color",E.helpers.HEXtoRGB(o)):E.format.removeStyle("color"),e()}return{showColorsPopup:function(){var o=E.$tb.find('.fr-command[data-cmd="color"]'),e=E.popups.get("colors.picker");if(e||(e=function(){var o,e='<div class="fr-buttons fr-colors-buttons">';E.opts.toolbarInline&&0<E.opts.colorsButtons.length&&(e+=E.button.buildList(E.opts.colorsButtons)),e+=(o='<div class="fr-colors-tabs fr-group">',o+='<span class="fr-colors-tab '+("background"==E.opts.colorsDefaultTab?"":"fr-selected-tab ")+'fr-command" tabIndex="-1" role="button" aria-pressed="'+("background"!=E.opts.colorsDefaultTab)+'" data-param1="text" data-cmd="colorChangeSet" title="'+E.language.translate("Text")+'">'+E.language.translate("Text")+"</span>",(o+='<span class="fr-colors-tab '+("background"==E.opts.colorsDefaultTab?"fr-selected-tab ":"")+'fr-command" tabIndex="-1" role="button" aria-pressed="'+("background"==E.opts.colorsDefaultTab)+'" data-param1="background" data-cmd="colorChangeSet" title="'+E.language.translate("Background")+'">'+E.language.translate("Background")+"</span>")+"</div></div>");var r="";E.opts.colorsHEXInput&&(r='<div class="fr-color-hex-layer fr-active fr-layer" id="fr-color-hex-layer-'+E.id+'"><div class="fr-input-line"><input maxlength="7" id="fr-color-hex-layer-text-'+E.id+'" type="text" placeholder="'+E.language.translate("HEX Color")+'" tabIndex="1" aria-required="true"></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-submit" data-cmd="customColor" tabIndex="2" role="button">'+E.language.translate("OK")+"</button></div></div>");var b,t={buttons:e,text_colors:s("text"),background_colors:s("background"),custom_color:r},a=E.popups.create("colors.picker",t);return b=a,E.events.on("popup.tab",function(o){var e=C(o.currentTarget);if(!E.popups.isVisible("colors.picker")||!e.is("span"))return!0;var r=o.which,t=!0;if(C.FE.KEYCODE.TAB==r){var a=b.find(".fr-buttons");t=!E.accessibility.focusToolbar(a,!!o.shiftKey)}else if(C.FE.KEYCODE.ARROW_UP==r||C.FE.KEYCODE.ARROW_DOWN==r||C.FE.KEYCODE.ARROW_LEFT==r||C.FE.KEYCODE.ARROW_RIGHT==r){if(e.is("span.fr-select-color")){var s=e.parent().find("span.fr-select-color"),l=s.index(e),c=E.opts.colorsStep,n=Math.floor(s.length/c),i=l%c,p=Math.floor(l/c),u=p*c+i,d=n*c;C.FE.KEYCODE.ARROW_UP==r?u=((u-c)%d+d)%d:C.FE.KEYCODE.ARROW_DOWN==r?u=(u+c)%d:C.FE.KEYCODE.ARROW_LEFT==r?u=((u-1)%d+d)%d:C.FE.KEYCODE.ARROW_RIGHT==r&&(u=(u+1)%d);var f=C(s.get(u));E.events.disableBlur(),f.focus(),t=!1}}else C.FE.KEYCODE.ENTER==r&&(E.button.exec(e),t=!1);return!1===t&&(o.preventDefault(),o.stopPropagation()),t},!0),a}()),!e.hasClass("fr-active"))if(E.popups.setContainer("colors.picker",E.$tb),a(e.find(".fr-selected-tab").attr("data-param1")),o.is(":visible")){var r=o.offset().left+o.outerWidth()/2,t=o.offset().top+(E.opts.toolbarBottom?10:o.outerHeight()-10);E.popups.show("colors.picker",r,t,o.outerHeight())}else E.position.forSelection(e),E.popups.show("colors.picker")},hideColorsPopup:e,changeSet:function(o,e){o.hasClass("fr-selected-tab")||(o.siblings().removeClass("fr-selected-tab").attr("aria-pressed",!1),o.addClass("fr-selected-tab").attr("aria-pressed",!0),o.parents(".fr-popup").find(".fr-color-set").removeClass("fr-selected-set"),o.parents(".fr-popup").find(".fr-color-set.fr-"+e+"-color").addClass("fr-selected-set"),a(e)),E.accessibility.focusPopup(o.parents(".fr-popup"))},background:t,customColor:function(){var o=E.popups.get("colors.picker"),e=o.find(".fr-color-hex-layer input");if(e.length){var r=e.val();"background"==o.find(".fr-selected-tab").attr("data-param1")?t(r):l(r)}},text:l,back:function(){E.popups.hide("colors.picker"),E.toolbar.showInline()}}},C.FE.DefineIcon("colors",{NAME:"tint"}),C.FE.RegisterCommand("color",{title:"Colors",undo:!1,focus:!0,refreshOnCallback:!1,popup:!0,callback:function(){this.popups.isVisible("colors.picker")?(this.$el.find(".fr-marker").length&&(this.events.disableBlur(),this.selection.restore()),this.popups.hide("colors.picker")):this.colors.showColorsPopup()},plugin:"colors"}),C.FE.RegisterCommand("textColor",{undo:!0,callback:function(o,e){this.colors.text(e)}}),C.FE.RegisterCommand("backgroundColor",{undo:!0,callback:function(o,e){this.colors.background(e)}}),C.FE.RegisterCommand("colorChangeSet",{undo:!1,focus:!1,callback:function(o,e){var r=this.popups.get("colors.picker").find('.fr-command[data-cmd="'+o+'"][data-param1="'+e+'"]');this.colors.changeSet(r,e)}}),C.FE.DefineIcon("colorsBack",{NAME:"arrow-left"}),C.FE.RegisterCommand("colorsBack",{title:"Back",undo:!1,focus:!1,back:!0,refreshAfterCallback:!1,callback:function(){this.colors.back()}}),C.FE.RegisterCommand("customColor",{title:"OK",undo:!0,callback:function(){this.colors.customColor()}}),C.FE.DefineIcon("remove",{NAME:"eraser"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof module&&module.exports?module.exports=function(e,o){return o===undefined&&(o="undefined"!=typeof window?require("jquery"):require("jquery")(e)),t(o)}:t(window.jQuery)}(function(g){g.extend(g.FE.POPUP_TEMPLATES,{emoticons:"[_BUTTONS_][_EMOTICONS_]"}),g.extend(g.FE.DEFAULTS,{emoticonsStep:8,emoticonsSet:[{code:"1f600",desc:"Grinning face"},{code:"1f601",desc:"Grinning face with smiling eyes"},{code:"1f602",desc:"Face with tears of joy"},{code:"1f603",desc:"Smiling face with open mouth"},{code:"1f604",desc:"Smiling face with open mouth and smiling eyes"},{code:"1f605",desc:"Smiling face with open mouth and cold sweat"},{code:"1f606",desc:"Smiling face with open mouth and tightly-closed eyes"},{code:"1f607",desc:"Smiling face with halo"},{code:"1f608",desc:"Smiling face with horns"},{code:"1f609",desc:"Winking face"},{code:"1f60a",desc:"Smiling face with smiling eyes"},{code:"1f60b",desc:"Face savoring delicious food"},{code:"1f60c",desc:"Relieved face"},{code:"1f60d",desc:"Smiling face with heart-shaped eyes"},{code:"1f60e",desc:"Smiling face with sunglasses"},{code:"1f60f",desc:"Smirking face"},{code:"1f610",desc:"Neutral face"},{code:"1f611",desc:"Expressionless face"},{code:"1f612",desc:"Unamused face"},{code:"1f613",desc:"Face with cold sweat"},{code:"1f614",desc:"Pensive face"},{code:"1f615",desc:"Confused face"},{code:"1f616",desc:"Confounded face"},{code:"1f617",desc:"Kissing face"},{code:"1f618",desc:"Face throwing a kiss"},{code:"1f619",desc:"Kissing face with smiling eyes"},{code:"1f61a",desc:"Kissing face with closed eyes"},{code:"1f61b",desc:"Face with stuck out tongue"},{code:"1f61c",desc:"Face with stuck out tongue and winking eye"},{code:"1f61d",desc:"Face with stuck out tongue and tightly-closed eyes"},{code:"1f61e",desc:"Disappointed face"},{code:"1f61f",desc:"Worried face"},{code:"1f620",desc:"Angry face"},{code:"1f621",desc:"Pouting face"},{code:"1f622",desc:"Crying face"},{code:"1f623",desc:"Persevering face"},{code:"1f624",desc:"Face with look of triumph"},{code:"1f625",desc:"Disappointed but relieved face"},{code:"1f626",desc:"Frowning face with open mouth"},{code:"1f627",desc:"Anguished face"},{code:"1f628",desc:"Fearful face"},{code:"1f629",desc:"Weary face"},{code:"1f62a",desc:"Sleepy face"},{code:"1f62b",desc:"Tired face"},{code:"1f62c",desc:"Grimacing face"},{code:"1f62d",desc:"Loudly crying face"},{code:"1f62e",desc:"Face with open mouth"},{code:"1f62f",desc:"Hushed face"},{code:"1f630",desc:"Face with open mouth and cold sweat"},{code:"1f631",desc:"Face screaming in fear"},{code:"1f632",desc:"Astonished face"},{code:"1f633",desc:"Flushed face"},{code:"1f634",desc:"Sleeping face"},{code:"1f635",desc:"Dizzy face"},{code:"1f636",desc:"Face without mouth"},{code:"1f637",desc:"Face with medical mask"}],emoticonsButtons:["emoticonsBack","|"],emoticonsUseImage:!0}),g.FE.PLUGINS.emoticons=function(E){function n(){if(!E.selection.isCollapsed())return!1;var e=E.selection.element(),o=E.selection.endElement();if(e&&E.node.hasClass(e,"fr-emoticon"))return e;if(o&&E.node.hasClass(o,"fr-emoticon"))return o;var t=E.selection.ranges(0),s=t.startContainer;if(s.nodeType==Node.ELEMENT_NODE&&0<s.childNodes.length&&0<t.startOffset){var n=s.childNodes[t.startOffset-1];if(E.node.hasClass(n,"fr-emoticon"))return n}return!1}return{_init:function(){var e=function(){for(var e=E.el.querySelectorAll(".fr-emoticon:not(.fr-deletable)"),o=0;o<e.length;o++)e[o].className+=" fr-deletable"};e(),E.events.on("html.set",e),E.events.on("keydown",function(e){if(E.keys.isCharacter(e.which)&&E.selection.inEditor()){var o=E.selection.ranges(0),t=n();E.node.hasClass(t,"fr-emoticon-img")&&t&&(0===o.startOffset&&E.selection.element()===t?g(t).before(g.FE.MARKERS+g.FE.INVISIBLE_SPACE):g(t).after(g.FE.INVISIBLE_SPACE+g.FE.MARKERS),E.selection.restore())}}),E.events.on("keyup",function(e){for(var o=E.el.querySelectorAll(".fr-emoticon"),t=0;t<o.length;t++)"undefined"!=typeof o[t].textContent&&0===o[t].textContent.replace(/\u200B/gi,"").length&&g(o[t]).remove();if(!(e.which>=g.FE.KEYCODE.ARROW_LEFT&&e.which<=g.FE.KEYCODE.ARROW_DOWN)){var s=n();E.node.hasClass(s,"fr-emoticon-img")&&(g(s).append(g.FE.MARKERS),E.selection.restore())}})},insert:function(e,o){var t=n(),s=E.selection.ranges(0);t?(0===s.startOffset&&E.selection.element()===t?g(t).before(g.FE.MARKERS+g.FE.INVISIBLE_SPACE):0<s.startOffset&&E.selection.element()===t&&s.commonAncestorContainer.parentNode.classList.contains("fr-emoticon")&&g(t).after(g.FE.INVISIBLE_SPACE+g.FE.MARKERS),E.selection.restore(),E.html.insert('<span class="fr-emoticon fr-deletable'+(o?" fr-emoticon-img":"")+'"'+(o?' style="background: url('+o+');"':"")+">"+(o?"&nbsp;":e)+"</span>&nbsp;"+g.FE.MARKERS,!0)):E.html.insert('<span class="fr-emoticon fr-deletable'+(o?" fr-emoticon-img":"")+'"'+(o?' style="background: url('+o+');"':"")+">"+(o?"&nbsp;":e)+"</span>&nbsp;",!0)},showEmoticonsPopup:function(){var e=E.$tb.find('.fr-command[data-cmd="emoticons"]'),o=E.popups.get("emoticons");if(o||(o=function(){var e="";E.opts.toolbarInline&&0<E.opts.emoticonsButtons.length&&(e='<div class="fr-buttons fr-emoticons-buttons">'+E.button.buildList(E.opts.emoticonsButtons)+"</div>");var h,o={buttons:e,emoticons:function(){for(var e='<div style="text-align: center">',o=0;o<E.opts.emoticonsSet.length;o++)0!==o&&o%E.opts.emoticonsStep==0&&(e+="<br>"),e+='<span class="fr-command fr-emoticon" tabIndex="-1" data-cmd="insertEmoticon" title="'+E.language.translate(E.opts.emoticonsSet[o].desc)+'" role="button" data-param1="'+E.opts.emoticonsSet[o].code+'">'+(E.opts.emoticonsUseImage?'<img src="https://cdnjs.cloudflare.com/ajax/libs/emojione/2.0.1/assets/svg/'+E.opts.emoticonsSet[o].code+'.svg"/>':"&#x"+E.opts.emoticonsSet[o].code+";")+'<span class="fr-sr-only">'+E.language.translate(E.opts.emoticonsSet[o].desc)+"&nbsp;&nbsp;&nbsp;</span></span>";return E.opts.emoticonsUseImage&&(e+='<p style="font-size: 12px; text-align: center; padding: 0 5px;">Emoji free by <a class="fr-link" tabIndex="-1" href="http://emojione.com/" target="_blank" rel="nofollow" role="link" aria-label="Open Emoji One website.">Emoji One</a></p>'),e+="</div>"}()},t=E.popups.create("emoticons",o);return E.tooltip.bind(t,".fr-emoticon"),h=t,E.events.on("popup.tab",function(e){var o=g(e.currentTarget);if(!E.popups.isVisible("emoticons")||!o.is("span, a"))return!0;var t,s,n,c=e.which;if(g.FE.KEYCODE.TAB==c){if(o.is("span.fr-emoticon")&&e.shiftKey||o.is("a")&&!e.shiftKey){var i=h.find(".fr-buttons");t=!E.accessibility.focusToolbar(i,!!e.shiftKey)}if(!1!==t){var a=h.find("span.fr-emoticon:focus:first, span.fr-emoticon:visible:first, a");o.is("span.fr-emoticon")&&(a=a.not("span.fr-emoticon:not(:focus)")),s=a.index(o),s=e.shiftKey?((s-1)%a.length+a.length)%a.length:(s+1)%a.length,n=a.get(s),E.events.disableBlur(),n.focus(),t=!1}}else if(g.FE.KEYCODE.ARROW_UP==c||g.FE.KEYCODE.ARROW_DOWN==c||g.FE.KEYCODE.ARROW_LEFT==c||g.FE.KEYCODE.ARROW_RIGHT==c){if(o.is("span.fr-emoticon")){var f=o.parent().find("span.fr-emoticon");s=f.index(o);var d=E.opts.emoticonsStep,r=Math.floor(f.length/d),l=s%d,m=Math.floor(s/d),u=m*d+l,p=r*d;g.FE.KEYCODE.ARROW_UP==c?u=((u-d)%p+p)%p:g.FE.KEYCODE.ARROW_DOWN==c?u=(u+d)%p:g.FE.KEYCODE.ARROW_LEFT==c?u=((u-1)%p+p)%p:g.FE.KEYCODE.ARROW_RIGHT==c&&(u=(u+1)%p),n=g(f.get(u)),E.events.disableBlur(),n.focus(),t=!1}}else g.FE.KEYCODE.ENTER==c&&(o.is("a")?o[0].click():E.button.exec(o),t=!1);return!1===t&&(e.preventDefault(),e.stopPropagation()),t},!0),t}()),!o.hasClass("fr-active")){E.popups.refresh("emoticons"),E.popups.setContainer("emoticons",E.$tb);var t=e.offset().left+e.outerWidth()/2,s=e.offset().top+(E.opts.toolbarBottom?10:e.outerHeight()-10);E.popups.show("emoticons",t,s,e.outerHeight())}},hideEmoticonsPopup:function(){E.popups.hide("emoticons")},back:function(){E.popups.hide("emoticons"),E.toolbar.showInline()}}},g.FE.DefineIcon("emoticons",{NAME:"smile-o",FA5NAME:"smile"}),g.FE.RegisterCommand("emoticons",{title:"Emoticons",undo:!1,focus:!0,refreshOnCallback:!1,popup:!0,callback:function(){this.popups.isVisible("emoticons")?(this.$el.find(".fr-marker").length&&(this.events.disableBlur(),this.selection.restore()),this.popups.hide("emoticons")):this.emoticons.showEmoticonsPopup()},plugin:"emoticons"}),g.FE.RegisterCommand("insertEmoticon",{callback:function(e,o){this.emoticons.insert("&#x"+o+";",this.opts.emoticonsUseImage?"https://cdnjs.cloudflare.com/ajax/libs/emojione/2.0.1/assets/svg/"+o+".svg":null),this.emoticons.hideEmoticonsPopup()}}),g.FE.DefineIcon("emoticonsBack",{NAME:"arrow-left"}),g.FE.RegisterCommand("emoticonsBack",{title:"Back",undo:!1,focus:!1,back:!0,refreshAfterCallback:!1,callback:function(){this.emoticons.back()}})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof module&&module.exports?module.exports=function(e,r){return r===undefined&&(r="undefined"!=typeof window?require("jquery"):require("jquery")(e)),a(r)}:a(window.jQuery)}(function(c){c.extend(c.FE.DEFAULTS,{entities:"&quot;&#39;&iexcl;&cent;&pound;&curren;&yen;&brvbar;&sect;&uml;&copy;&ordf;&laquo;&not;&shy;&reg;&macr;&deg;&plusmn;&sup2;&sup3;&acute;&micro;&para;&middot;&cedil;&sup1;&ordm;&raquo;&frac14;&frac12;&frac34;&iquest;&Agrave;&Aacute;&Acirc;&Atilde;&Auml;&Aring;&AElig;&Ccedil;&Egrave;&Eacute;&Ecirc;&Euml;&Igrave;&Iacute;&Icirc;&Iuml;&ETH;&Ntilde;&Ograve;&Oacute;&Ocirc;&Otilde;&Ouml;&times;&Oslash;&Ugrave;&Uacute;&Ucirc;&Uuml;&Yacute;&THORN;&szlig;&agrave;&aacute;&acirc;&atilde;&auml;&aring;&aelig;&ccedil;&egrave;&eacute;&ecirc;&euml;&igrave;&iacute;&icirc;&iuml;&eth;&ntilde;&ograve;&oacute;&ocirc;&otilde;&ouml;&divide;&oslash;&ugrave;&uacute;&ucirc;&uuml;&yacute;&thorn;&yuml;&OElig;&oelig;&Scaron;&scaron;&Yuml;&fnof;&circ;&tilde;&Alpha;&Beta;&Gamma;&Delta;&Epsilon;&Zeta;&Eta;&Theta;&Iota;&Kappa;&Lambda;&Mu;&Nu;&Xi;&Omicron;&Pi;&Rho;&Sigma;&Tau;&Upsilon;&Phi;&Chi;&Psi;&Omega;&alpha;&beta;&gamma;&delta;&epsilon;&zeta;&eta;&theta;&iota;&kappa;&lambda;&mu;&nu;&xi;&omicron;&pi;&rho;&sigmaf;&sigma;&tau;&upsilon;&phi;&chi;&psi;&omega;&thetasym;&upsih;&piv;&ensp;&emsp;&thinsp;&zwnj;&zwj;&lrm;&rlm;&ndash;&mdash;&lsquo;&rsquo;&sbquo;&ldquo;&rdquo;&bdquo;&dagger;&Dagger;&bull;&hellip;&permil;&prime;&Prime;&lsaquo;&rsaquo;&oline;&frasl;&euro;&image;&weierp;&real;&trade;&alefsym;&larr;&uarr;&rarr;&darr;&harr;&crarr;&lArr;&uArr;&rArr;&dArr;&hArr;&forall;&part;&exist;&empty;&nabla;&isin;&notin;&ni;&prod;&sum;&minus;&lowast;&radic;&prop;&infin;&ang;&and;&or;&cap;&cup;&int;&there4;&sim;&cong;&asymp;&ne;&equiv;&le;&ge;&sub;&sup;&nsub;&sube;&supe;&oplus;&otimes;&perp;&sdot;&lceil;&rceil;&lfloor;&rfloor;&lang;&rang;&loz;&spades;&clubs;&hearts;&diams;"}),c.FE.PLUGINS.entities=function(t){var n,u;function i(e){var r=e.textContent;if(r.match(n)){for(var a="",i=0;i<r.length;i++)u[r[i]]?a+=u[r[i]]:a+=r[i];e.textContent=a}}function o(e){if(e&&0<=["STYLE","SCRIPT","svg","IFRAME"].indexOf(e.tagName))return!0;for(var r=t.node.contents(e),a=0;a<r.length;a++)r[a].nodeType==Node.TEXT_NODE?i(r[a]):o(r[a]);e.nodeType==Node.TEXT_NODE&&i(e)}function l(e){return 0===e.length?"":t.clean.exec(e,o).replace(/\&amp;/g,"&")}return{_init:function(){t.opts.htmlSimpleAmpersand||(t.opts.entities=t.opts.entities+"&amp;");var e=c("<div>").html(t.opts.entities).text(),r=t.opts.entities.split(";");u={},n="";for(var a=0;a<e.length;a++){var i=e.charAt(a);u[i]=r[a]+";",n+="\\"+i+(a<e.length-1?"|":"")}n=new RegExp("("+n+")","g"),t.events.on("html.get",l,!0)}}}});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(i){"function"==typeof define&&define.amd?define(["jquery"],i):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),i(t)}:i(window.jQuery)}(function(C){C.extend(C.FE.POPUP_TEMPLATES,{"file.insert":"[_BUTTONS_][_UPLOAD_LAYER_][_PROGRESS_BAR_]"}),C.extend(C.FE.DEFAULTS,{fileUpload:!0,fileUploadURL:null,fileUploadParam:"file",fileUploadParams:{},fileUploadToS3:!1,fileUploadMethod:"POST",fileMaxSize:10485760,fileAllowedTypes:["*"],fileInsertButtons:["fileBack","|"],fileUseSelectedText:!1}),C.FE.PLUGINS.file=function(f){var r,p="https://i.froala.com/upload",l=2,d=3,u=4,c=5,v=6,i={};function g(){var e=f.popups.get("file.insert");e||(e=E()),e.find(".fr-layer.fr-active").removeClass("fr-active").addClass("fr-pactive"),e.find(".fr-file-progress-bar-layer").addClass("fr-active"),e.find(".fr-buttons").hide(),o(f.language.translate("Uploading"),0)}function n(e){var t=f.popups.get("file.insert");t&&(t.find(".fr-layer.fr-pactive").addClass("fr-active").removeClass("fr-pactive"),t.find(".fr-file-progress-bar-layer").removeClass("fr-active"),t.find(".fr-buttons").show(),e&&(f.events.focus(),f.popups.hide("file.insert")))}function o(e,t){var i=f.popups.get("file.insert");if(i){var r=i.find(".fr-file-progress-bar-layer");r.find("h3").text(e+(t?" "+t+"%":"")),r.removeClass("fr-error"),t?(r.find("div").removeClass("fr-indeterminate"),r.find("div > span").css("width",t+"%")):r.find("div").addClass("fr-indeterminate")}}function h(e,t,i){f.edit.on(),f.events.focus(!0),f.selection.restore(),f.opts.fileUseSelectedText&&f.selection.text().length&&(t=f.selection.text()),f.html.insert('<a href="'+e+'" target="_blank" id="fr-inserted-file" class="fr-file">'+t+"</a>");var r=f.$el.find("#fr-inserted-file");r.removeAttr("id"),f.popups.hide("file.insert"),f.undo.saveStep(),w(),f.events.trigger("file.inserted",[r,i])}function m(e){var t=this.status,i=this.response,r=this.responseXML,n=this.responseText;try{if(f.opts.fileUploadToS3)if(201==t){var o=function(e){try{var t=C(e).find("Location").text(),i=C(e).find("Key").text();return!1===f.events.trigger("file.uploadedToS3",[t,i,e],!0)?(f.edit.on(),!1):t}catch(r){return U(u,e),!1}}(r);o&&h(o,e,i||r)}else U(u,i||r);else if(200<=t&&t<300){var a=function(e){try{if(!1===f.events.trigger("file.uploaded",[e],!0))return f.edit.on(),!1;var t=JSON.parse(e);return t.link?t:(U(l,e),!1)}catch(i){return U(u,e),!1}}(n);a&&h(a.link,e,i||n)}else U(d,i||n)}catch(s){U(u,i||n)}}function b(){U(u,this.response||this.responseText||this.responseXML)}function y(e){if(e.lengthComputable){var t=e.loaded/e.total*100|0;o(f.language.translate("Uploading"),t)}}function U(e,t){f.edit.on(),function(e){g();var t=f.popups.get("file.insert").find(".fr-file-progress-bar-layer");t.addClass("fr-error");var i=t.find("h3");i.text(e),f.events.disableBlur(),i.focus()}(f.language.translate("Something went wrong. Please try again.")),f.events.trigger("file.error",[{code:e,message:i[e]},t])}function S(){f.edit.on(),n(!0)}function a(e){if(void 0!==e&&0<e.length){if(!1===f.events.trigger("file.beforeUpload",[e]))return!1;var t,i=e[0];if(null===f.opts.fileUploadURL||f.opts.fileUploadURL==p)return s=i,(l=new FileReader).addEventListener("load",function(){for(var e=l.result,t=atob(l.result.split(",")[1]),i=[],r=0;r<t.length;r++)i.push(t.charCodeAt(r));e=window.URL.createObjectURL(new Blob([new Uint8Array(i)],{type:s.type})),f.file.insert(e,s.name,null)},!1),g(),l.readAsDataURL(s),!1;if(i.size>f.opts.fileMaxSize)return U(c),!1;if(f.opts.fileAllowedTypes.indexOf("*")<0&&f.opts.fileAllowedTypes.indexOf(i.type.replace(/file\//g,""))<0)return U(v),!1;if(f.drag_support.formdata&&(t=f.drag_support.formdata?new FormData:null),t){var r;if(!1!==f.opts.fileUploadToS3)for(r in t.append("key",f.opts.fileUploadToS3.keyStart+(new Date).getTime()+"-"+(i.name||"untitled")),t.append("success_action_status","201"),t.append("X-Requested-With","xhr"),t.append("Content-Type",i.type),f.opts.fileUploadToS3.params)f.opts.fileUploadToS3.params.hasOwnProperty(r)&&t.append(r,f.opts.fileUploadToS3.params[r]);for(r in f.opts.fileUploadParams)f.opts.fileUploadParams.hasOwnProperty(r)&&t.append(r,f.opts.fileUploadParams[r]);t.append(f.opts.fileUploadParam,i);var n=f.opts.fileUploadURL;f.opts.fileUploadToS3&&(n=f.opts.fileUploadToS3.uploadURL?f.opts.fileUploadToS3.uploadURL:"https://"+f.opts.fileUploadToS3.region+".amazonaws.com/"+f.opts.fileUploadToS3.bucket);var o=f.core.getXHR(n,f.opts.fileUploadMethod);o.onload=function(){m.call(o,i.name)},o.onerror=b,o.upload.onprogress=y,o.onabort=S,g();var a=f.popups.get("file.insert");a&&a.off("abortUpload").on("abortUpload",function(){4!=o.readyState&&o.abort()}),o.send(t)}}var s,l}function s(){n()}function E(e){if(e)return f.popups.onHide("file.insert",s),!0;var t;f.opts.fileUpload||f.opts.fileInsertButtons.splice(f.opts.fileInsertButtons.indexOf("fileUpload"),1),t='<div class="fr-buttons">'+f.button.buildList(f.opts.fileInsertButtons)+"</div>";var i="";f.opts.fileUpload&&(i='<div class="fr-file-upload-layer fr-layer fr-active" id="fr-file-upload-layer-'+f.id+'"><strong>'+f.language.translate("Drop file")+"</strong><br>("+f.language.translate("or click")+')<div class="fr-form"><input type="file" name="'+f.opts.fileUploadParam+'" accept="/*" tabIndex="-1" aria-labelledby="fr-file-upload-layer-'+f.id+'" role="button"></div></div>');var r,n={buttons:t,upload_layer:i,progress_bar:'<div class="fr-file-progress-bar-layer fr-layer"><h3 tabIndex="-1" class="fr-message">Uploading</h3><div class="fr-loader"><span class="fr-progress"></span></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-dismiss" data-cmd="fileDismissError" tabIndex="2" role="button">OK</button></div></div>'},o=f.popups.create("file.insert",n);return r=o,f.events.$on(r,"dragover dragenter",".fr-file-upload-layer",function(){return C(this).addClass("fr-drop"),!1},!0),f.events.$on(r,"dragleave dragend",".fr-file-upload-layer",function(){return C(this).removeClass("fr-drop"),!1},!0),f.events.$on(r,"drop",".fr-file-upload-layer",function(e){e.preventDefault(),e.stopPropagation(),C(this).removeClass("fr-drop");var t=e.originalEvent.dataTransfer;t&&t.files&&(r.data("instance")||f).file.upload(t.files)},!0),f.helpers.isIOS()&&f.events.$on(r,"touchstart",'.fr-file-upload-layer input[type="file"]',function(){C(this).trigger("click")}),f.events.$on(r,"change",'.fr-file-upload-layer input[type="file"]',function(){if(this.files){var e=r.data("instance")||f;e.events.disableBlur(),r.find("input:focus").blur(),e.events.enableBlur(),e.file.upload(this.files)}C(this).val("")},!0),o}function e(e){f.node.hasClass(e,"fr-file")}function t(e){var t=e.originalEvent.dataTransfer;if(t&&t.files&&t.files.length){var i=t.files[0];if(i&&"undefined"!=typeof i.type){if(i.type.indexOf("image")<0){if(!f.opts.fileUpload)return e.preventDefault(),e.stopPropagation(),!1;f.markers.remove(),f.markers.insertAtPoint(e.originalEvent),f.$el.find(".fr-marker").replaceWith(C.FE.MARKERS),f.popups.hideAll();var r=f.popups.get("file.insert");return r||(r=E()),f.popups.setContainer("file.insert",f.$sc),f.popups.show("file.insert",e.originalEvent.pageX,e.originalEvent.pageY),g(),a(t.files),e.preventDefault(),e.stopPropagation(),!1}}else i.type.indexOf("image")<0&&(e.preventDefault(),e.stopPropagation())}}function w(){var e,t=Array.prototype.slice.call(f.el.querySelectorAll("a.fr-file")),i=[];for(e=0;e<t.length;e++)i.push(t[e].getAttribute("href"));if(r)for(e=0;e<r.length;e++)i.indexOf(r[e].getAttribute("href"))<0&&f.events.trigger("file.unlink",[r[e]]);r=t}return i[1]="File cannot be loaded from the passed link.",i[l]="No link in upload response.",i[d]="Error during file upload.",i[u]="Parsing response failed.",i[c]="File is too large.",i[v]="File file type is invalid.",i[7]="Files can be uploaded only to same domain in IE 8 and IE 9.",{_init:function(){f.events.on("drop",t),f.events.$on(f.$win,"keydown",function(e){var t=e.which,i=f.popups.get("file.insert");i&&t==C.FE.KEYCODE.ESC&&i.trigger("abortUpload")}),f.events.on("destroy",function(){var e=f.popups.get("file.insert");e&&e.trigger("abortUpload")}),f.events.on("link.beforeRemove",e),f.$wp&&(w(),f.events.on("contentChanged",w)),E(!0)},showInsertPopup:function(){var e=f.$tb.find('.fr-command[data-cmd="insertFile"]'),t=f.popups.get("file.insert");if(t||(t=E()),n(),!t.hasClass("fr-active"))if(f.popups.refresh("file.insert"),f.popups.setContainer("file.insert",f.$tb),e.is(":visible")){var i=e.offset().left+e.outerWidth()/2,r=e.offset().top+(f.opts.toolbarBottom?10:e.outerHeight()-10);f.popups.show("file.insert",i,r,e.outerHeight())}else f.position.forSelection(t),f.popups.show("file.insert")},upload:a,insert:h,back:function(){f.events.disableBlur(),f.selection.restore(),f.events.enableBlur(),f.popups.hide("file.insert"),f.toolbar.showInline()},hideProgressBar:n}},C.FE.DefineIcon("insertFile",{NAME:"file-o",FA5NAME:"file"}),C.FE.RegisterCommand("insertFile",{title:"Upload File",undo:!1,focus:!0,refreshAfterCallback:!1,popup:!0,callback:function(){this.popups.isVisible("file.insert")?(this.$el.find(".fr-marker").length&&(this.events.disableBlur(),this.selection.restore()),this.popups.hide("file.insert")):this.file.showInsertPopup()},plugin:"file"}),C.FE.DefineIcon("fileBack",{NAME:"arrow-left"}),C.FE.RegisterCommand("fileBack",{title:"Back",undo:!1,focus:!1,back:!0,refreshAfterCallback:!1,callback:function(){this.file.back()},refresh:function(e){this.opts.toolbarInline?(e.removeClass("fr-hidden"),e.next(".fr-separator").removeClass("fr-hidden")):(e.addClass("fr-hidden"),e.next(".fr-separator").addClass("fr-hidden"))}}),C.FE.RegisterCommand("fileDismissError",{title:"OK",callback:function(){this.file.hideProgressBar(!0)}})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(l){l.extend(l.FE.DEFAULTS,{fontFamily:{"Arial,Helvetica,sans-serif":"Arial","Georgia,serif":"Georgia","Impact,Charcoal,sans-serif":"Impact","Tahoma,Geneva,sans-serif":"Tahoma","Times New Roman,Times,serif,-webkit-standard":"Times New Roman","Verdana,Geneva,sans-serif":"Verdana"},fontFamilySelection:!1,fontFamilyDefaultSelection:"Font Family"}),l.FE.PLUGINS.fontFamily=function(o){function i(e){var t=e.replace(/(sans-serif|serif|monospace|cursive|fantasy)/gi,"").replace(/"|'| /g,"").split(",");return l.grep(t,function(e){return 0<e.length})}function r(e,t){for(var n=0;n<e.length;n++)for(var a=0;a<t.length;a++)if(e[n].toLowerCase()==t[a].toLowerCase())return[n,a];return null}function f(){var e=i(l(o.selection.element()).css("font-family")),t=[];for(var n in o.opts.fontFamily)if(o.opts.fontFamily.hasOwnProperty(n)){var a=r(e,i(n));a&&t.push([n,a])}return 0===t.length?null:(t.sort(function(e,t){var n=e[1][0]-t[1][0];return 0===n?e[1][1]-t[1][1]:n}),t[0][0])}return{apply:function(e){o.format.applyStyle("font-family",e)},refreshOnShow:function(e,t){t.find(".fr-command.fr-active").removeClass("fr-active").attr("aria-selected",!1),t.find('.fr-command[data-param1="'+f()+'"]').addClass("fr-active").attr("aria-selected",!0);var n=t.find(".fr-dropdown-list"),a=t.find(".fr-active").parent();a.length?n.parent().scrollTop(a.offset().top-n.offset().top-(n.parent().outerHeight()/2-a.outerHeight()/2)):n.parent().scrollTop(0)},refresh:function(e){if(o.opts.fontFamilySelection){var t=l(o.selection.element()).css("font-family").replace(/(sans-serif|serif|monospace|cursive|fantasy)/gi,"").replace(/"|'|/g,"").split(",");e.find("> span").text(o.opts.fontFamily[f()]||t[0]||o.language.translate(o.opts.fontFamilyDefaultSelection))}}}},l.FE.RegisterCommand("fontFamily",{type:"dropdown",displaySelection:function(e){return e.opts.fontFamilySelection},defaultSelection:function(e){return e.opts.fontFamilyDefaultSelection},displaySelectionWidth:120,html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=this.opts.fontFamily;for(var n in t)t.hasOwnProperty(n)&&(e+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="fontFamily" data-param1="'+n+'" style="font-family: '+n+'" title="'+t[n]+'">'+t[n]+"</a></li>");return e+="</ul>"},title:"Font Family",callback:function(e,t){this.fontFamily.apply(t)},refresh:function(e){this.fontFamily.refresh(e)},refreshOnShow:function(e,t){this.fontFamily.refreshOnShow(e,t)},plugin:"fontFamily"}),l.FE.DefineIcon("fontFamily",{NAME:"font"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(f){f.extend(f.FE.DEFAULTS,{fontSize:["8","9","10","11","12","14","18","24","30","36","48","60","72","96"],fontSizeSelection:!1,fontSizeDefaultSelection:"12",fontSizeUnit:"px"}),f.FE.PLUGINS.fontSize=function(r){return{apply:function(e){r.format.applyStyle("font-size",e)},refreshOnShow:function(e,t){var n=f(r.selection.element()).css("font-size");"pt"===r.opts.fontSizeUnit&&(n=Math.round(72*parseFloat(n,10)/96)+"pt"),t.find(".fr-command.fr-active").removeClass("fr-active").attr("aria-selected",!1),t.find('.fr-command[data-param1="'+n+'"]').addClass("fr-active").attr("aria-selected",!0);var o=t.find(".fr-dropdown-list"),i=t.find(".fr-active").parent();i.length?o.parent().scrollTop(i.offset().top-o.offset().top-(o.parent().outerHeight()/2-i.outerHeight()/2)):o.parent().scrollTop(0)},refresh:function(e){if(r.opts.fontSizeSelection){var t=r.helpers.getPX(f(r.selection.element()).css("font-size"));"pt"===r.opts.fontSizeUnit&&(t=Math.round(72*parseFloat(t,10)/96)+"pt"),e.find("> span").text(t)}}}},f.FE.RegisterCommand("fontSize",{type:"dropdown",title:"Font Size",displaySelection:function(e){return e.opts.fontSizeSelection},displaySelectionWidth:30,defaultSelection:function(e){return e.opts.fontSizeDefaultSelection},html:function(){for(var e='<ul class="fr-dropdown-list" role="presentation">',t=this.opts.fontSize,n=0;n<t.length;n++){var o=t[n];e+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="fontSize" data-param1="'+o+this.opts.fontSizeUnit+'" title="'+o+'">'+o+"</a></li>"}return e+="</ul>"},callback:function(e,t){this.fontSize.apply(t)},refresh:function(e){this.fontSize.refresh(e)},refreshOnShow:function(e,t){this.fontSize.refreshOnShow(e,t)},plugin:"fontSize"}),f.FE.DefineIcon("fontSize",{NAME:"text-height"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(o){"function"==typeof define&&define.amd?define(["jquery"],o):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),o(t)}:o(window.jQuery)}(function(c){c.FE.PLUGINS.fullscreen=function(o){var t,r,s,n;function i(){return o.$box.hasClass("fr-fullscreen")}function e(){if(o.helpers.isIOS()&&o.core.hasFocus())return o.$el.blur(),setTimeout(a,250),!1;t=o.helpers.scrollTop(),o.$box.toggleClass("fr-fullscreen"),c("body:first").toggleClass("fr-fullscreen"),o.helpers.isMobile()&&(o.$tb.data("parent",o.$tb.parent()),o.$tb.prependTo(o.$box),o.$tb.data("sticky-dummy")&&o.$tb.after(o.$tb.data("sticky-dummy"))),r=o.opts.height,s=o.opts.heightMax,n=o.opts.zIndex,o.position.refresh(),o.opts.height=o.o_win.innerHeight-(o.opts.toolbarInline?0:o.$tb.outerHeight()),o.opts.zIndex=2147483641,o.opts.heightMax=null,o.size.refresh(),o.opts.toolbarInline&&o.toolbar.showInline();for(var e=o.$box.parent();!e.is("body:first");)e.data("z-index",e.css("z-index")).data("overflow",e.css("overflow")).css("z-index","2147483640").css("overflow","visible"),e=e.parent();o.opts.toolbarContainer&&o.$box.prepend(o.$tb),o.events.trigger("charCounter.update"),o.events.trigger("codeView.update"),o.$win.trigger("scroll")}function l(){if(o.helpers.isIOS()&&o.core.hasFocus())return o.$el.blur(),setTimeout(a,250),!1;o.$box.toggleClass("fr-fullscreen"),c("body:first").toggleClass("fr-fullscreen"),o.$tb.prependTo(o.$tb.data("parent")),o.$tb.data("sticky-dummy")&&o.$tb.after(o.$tb.data("sticky-dummy")),o.opts.height=r,o.opts.heightMax=s,o.opts.zIndex=n,o.size.refresh(),c(o.o_win).scrollTop(t),o.opts.toolbarInline&&o.toolbar.showInline(),o.events.trigger("charCounter.update"),o.opts.toolbarSticky&&o.opts.toolbarStickyOffset&&(o.opts.toolbarBottom?o.$tb.css("bottom",o.opts.toolbarStickyOffset).data("bottom",o.opts.toolbarStickyOffset):o.$tb.css("top",o.opts.toolbarStickyOffset).data("top",o.opts.toolbarStickyOffset));for(var e=o.$box.parent();!e.is("body:first");)e.data("z-index")&&(e.css("z-index",""),e.css("z-index")!=e.data("z-index")&&e.css("z-index",e.data("z-index")),e.removeData("z-index")),e.data("overflow")?(e.css("overflow",""),e.css("overflow")!=e.data("overflow")&&e.css("overflow",e.data("overflow"))):e.css("overflow",""),e.removeData("overflow"),e=e.parent();o.opts.toolbarContainer&&c(o.opts.toolbarContainer).append(o.$tb),c(o.o_win).trigger("scroll"),o.events.trigger("codeView.update")}function a(){i()?l():e(),f(o.$tb.find('.fr-command[data-cmd="fullscreen"]'))}function f(e){var t=i();e.toggleClass("fr-active",t).attr("aria-pressed",t),e.find("> *:not(.fr-sr-only)").replaceWith(t?o.icon.create("fullscreenCompress"):o.icon.create("fullscreen"))}return{_init:function(){if(!o.$wp)return!1;o.events.$on(c(o.o_win),"resize",function(){i()&&(l(),e())}),o.events.on("toolbar.hide",function(){if(i()&&o.helpers.isMobile())return!1}),o.events.on("position.refresh",function(){if(o.helpers.isIOS())return!i()}),o.events.on("destroy",function(){i()&&l()},!0)},toggle:a,refresh:f,isActive:i}},c.FE.RegisterCommand("fullscreen",{title:"Fullscreen",undo:!1,focus:!1,accessibilityFocus:!0,forcedRefresh:!0,toggle:!0,callback:function(){this.fullscreen.toggle()},refresh:function(e){this.fullscreen.refresh(e)},plugin:"fullscreen"}),c.FE.DefineIcon("fullscreen",{NAME:"expand"}),c.FE.DefineIcon("fullscreenCompress",{NAME:"compress"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),a(t)}:a(window.jQuery)}(function(ye){ye.extend(ye.FE.POPUP_TEMPLATES,{"image.insert":"[_BUTTONS_][_UPLOAD_LAYER_][_BY_URL_LAYER_][_PROGRESS_BAR_]","image.edit":"[_BUTTONS_]","image.alt":"[_BUTTONS_][_ALT_LAYER_]","image.size":"[_BUTTONS_][_SIZE_LAYER_]"}),ye.extend(ye.FE.DEFAULTS,{imageInsertButtons:["imageBack","|","imageUpload","imageByURL"],imageEditButtons:["imageReplace","imageAlign","imageCaption","imageRemove","|","imageLink","linkOpen","linkEdit","linkRemove","-","imageDisplay","imageStyle","imageAlt","imageSize"],imageAltButtons:["imageBack","|"],imageSizeButtons:["imageBack","|"],imageUpload:!0,imageUploadURL:null,imageCORSProxy:"https://cors-anywhere.froala.com",imageUploadRemoteUrls:!0,imageUploadParam:"file",imageUploadParams:{},imageUploadToS3:!1,imageUploadMethod:"POST",imageMaxSize:10485760,imageAllowedTypes:["jpeg","jpg","png","gif"],imageResize:!0,imageResizeWithPercent:!1,imageRoundPercent:!1,imageDefaultWidth:300,imageDefaultAlign:"center",imageDefaultDisplay:"block",imageSplitHTML:!1,imageStyles:{"fr-rounded":"Rounded","fr-bordered":"Bordered","fr-shadow":"Shadow"},imageMove:!0,imageMultipleStyles:!0,imageTextNear:!0,imagePaste:!0,imagePasteProcess:!1,imageMinWidth:16,imageOutputSize:!1,imageDefaultMargin:5}),ye.FE.PLUGINS.image=function(p){var g,l,f,d,o,a,u="https://i.froala.com/upload",t=!1,i=1,c=2,m=3,h=4,v=5,b=6,y=8,r={};function w(){var e=p.popups.get("image.insert").find(".fr-image-by-url-layer input");e.val(""),g&&e.val(g.attr("src")),e.trigger("change")}function n(){var e=p.popups.get("image.edit");if(e||(e=$()),e){var t=ve();be()&&(t=t.find(".fr-img-wrap")),p.popups.setContainer("image.edit",p.$sc),p.popups.refresh("image.edit");var a=t.offset().left+t.outerWidth()/2,i=t.offset().top+t.outerHeight();p.popups.show("image.edit",a,i,t.outerHeight())}}function E(){F()}function e(){for(var e,t,a="IMG"==p.el.tagName?[p.el]:p.el.querySelectorAll("img"),i=0;i<a.length;i++){var r=ye(a[i]);!p.opts.htmlUntouched&&p.opts.useClasses?((p.opts.imageDefaultAlign||p.opts.imageDefaultDisplay)&&(0<(t=r).parents(".fr-img-caption").length&&(t=t.parents(".fr-img-caption:first")),t.hasClass("fr-dii")||t.hasClass("fr-dib")||(t.addClass("fr-fi"+de(t)[0]),t.addClass("fr-di"+ue(t)[0]),t.css("margin",""),t.css("float",""),t.css("display",""),t.css("z-index",""),t.css("position",""),t.css("overflow",""),t.css("vertical-align",""))),p.opts.imageTextNear||(0<r.parents(".fr-img-caption").length?r.parents(".fr-img-caption:first").removeClass("fr-dii").addClass("fr-dib"):r.removeClass("fr-dii").addClass("fr-dib"))):p.opts.htmlUntouched||p.opts.useClasses||(p.opts.imageDefaultAlign||p.opts.imageDefaultDisplay)&&(0<(e=r).parents(".fr-img-caption").length&&(e=e.parents(".fr-img-caption:first")),ge(e,e.hasClass("fr-dib")?"block":e.hasClass("fr-dii")?"inline":null,e.hasClass("fr-fil")?"left":e.hasClass("fr-fir")?"right":de(e)),e.removeClass("fr-dib fr-dii fr-fir fr-fil")),p.opts.iframe&&r.on("load",p.size.syncIframe)}}function C(e){void 0===e&&(e=!0);var t,a=Array.prototype.slice.call(p.el.querySelectorAll("img")),i=[];for(t=0;t<a.length;t++)if(i.push(a[t].getAttribute("src")),ye(a[t]).toggleClass("fr-draggable",p.opts.imageMove),""===a[t].getAttribute("class")&&a[t].removeAttribute("class"),""===a[t].getAttribute("style")&&a[t].removeAttribute("style"),a[t].parentNode&&a[t].parentNode.parentNode&&p.node.hasClass(a[t].parentNode.parentNode,"fr-img-caption")){var r=a[t].parentNode.parentNode;p.browser.mozilla||r.setAttribute("contenteditable",!1),r.setAttribute("draggable",!1),r.classList.add("fr-draggable");var n=a[t].nextSibling;n&&n.setAttribute("contenteditable",!0)}if(o)for(t=0;t<o.length;t++)i.indexOf(o[t].getAttribute("src"))<0&&p.events.trigger("image.removed",[ye(o[t])]);if(o&&e){var s=[];for(t=0;t<o.length;t++)s.push(o[t].getAttribute("src"));for(t=0;t<a.length;t++)s.indexOf(a[t].getAttribute("src"))<0&&p.events.trigger("image.loaded",[ye(a[t])])}o=a}function A(){if(l||function(){var e;p.shared.$image_resizer?(l=p.shared.$image_resizer,d=p.shared.$img_overlay,p.events.on("destroy",function(){l.removeClass("fr-active").appendTo(ye("body:first"))},!0)):(p.shared.$image_resizer=ye('<div class="fr-image-resizer"></div>'),l=p.shared.$image_resizer,p.events.$on(l,"mousedown",function(e){e.stopPropagation()},!0),p.opts.imageResize&&(l.append(s("nw")+s("ne")+s("sw")+s("se")),p.shared.$img_overlay=ye('<div class="fr-image-overlay"></div>'),d=p.shared.$img_overlay,e=l.get(0).ownerDocument,ye(e).find("body:first").append(d)));p.events.on("shared.destroy",function(){l.html("").removeData().remove(),l=null,p.opts.imageResize&&(d.remove(),d=null)},!0),p.helpers.isMobile()||p.events.$on(ye(p.o_win),"resize",function(){g&&!g.hasClass("fr-uploading")?oe(!0):g&&(A(),ce(),I(!1))});if(p.opts.imageResize){e=l.get(0).ownerDocument,p.events.$on(l,p._mousedown,".fr-handler",S),p.events.$on(ye(e),p._mousemove,D),p.events.$on(ye(e.defaultView||e.parentWindow),p._mouseup,x),p.events.$on(d,"mouseleave",x);var i=1,r=null,n=0;p.events.on("keydown",function(e){if(g){var t=-1!=navigator.userAgent.indexOf("Mac OS X")?e.metaKey:e.ctrlKey,a=e.which;(a!==r||200<e.timeStamp-n)&&(i=1),(a==ye.FE.KEYCODE.EQUALS||p.browser.mozilla&&a==ye.FE.KEYCODE.FF_EQUALS)&&t&&!e.altKey?i=Q.call(this,e,1,1,i):(a==ye.FE.KEYCODE.HYPHEN||p.browser.mozilla&&a==ye.FE.KEYCODE.FF_HYPHEN)&&t&&!e.altKey?i=Q.call(this,e,2,-1,i):p.keys.ctrlKey(e)||a!=ye.FE.KEYCODE.ENTER||(g.before("<br>"),B(g)),r=a,n=e.timeStamp}},!0),p.events.on("keyup",function(){i=1})}}(),!g)return!1;var e=p.$wp||p.$sc;e.append(l),l.data("instance",p);var t=e.scrollTop()-("static"!=e.css("position")?e.offset().top:0),a=e.scrollLeft()-("static"!=e.css("position")?e.offset().left:0);a-=p.helpers.getPX(e.css("border-left-width")),t-=p.helpers.getPX(e.css("border-top-width")),p.$el.is("img")&&p.$sc.is("body")&&(a=t=0);var i=ve();be()&&(i=i.find(".fr-img-wrap")),l.css("top",(p.opts.iframe?i.offset().top:i.offset().top+t)-1).css("left",(p.opts.iframe?i.offset().left:i.offset().left+a)-1).css("width",i.get(0).getBoundingClientRect().width).css("height",i.get(0).getBoundingClientRect().height).addClass("fr-active")}function s(e){return'<div class="fr-handler fr-h'+e+'"></div>'}function R(e){be()?g.parents(".fr-img-caption").css("width",e):g.css("width",e)}function S(e){if(!p.core.sameInstance(l))return!0;if(e.preventDefault(),e.stopPropagation(),p.$el.find("img.fr-error").left)return!1;p.undo.canDo()||p.undo.saveStep();var t=e.pageX||e.originalEvent.touches[0].pageX;if("mousedown"==e.type){var a=p.$oel.get(0).ownerDocument,i=a.defaultView||a.parentWindow,r=!1;try{r=i.location!=i.parent.location&&!(i.$&&i.$.FE)}catch(o){}r&&i.frameElement&&(t+=p.helpers.getPX(ye(i.frameElement).offset().left)+i.frameElement.clientLeft)}(f=ye(this)).data("start-x",t),f.data("start-width",g.width()),f.data("start-height",g.height());var n=g.width();if(p.opts.imageResizeWithPercent){var s=g.parentsUntil(p.$el,p.html.blockTagsQuery()).get(0)||p.el;n=(n/ye(s).outerWidth()*100).toFixed(2)+"%"}R(n),d.show(),p.popups.hideAll(),pe()}function D(e){if(!p.core.sameInstance(l))return!0;var t;if(f&&g){if(e.preventDefault(),p.$el.find("img.fr-error").left)return!1;var a=e.pageX||(e.originalEvent.touches?e.originalEvent.touches[0].pageX:null);if(!a)return!1;var i=a-f.data("start-x"),r=f.data("start-width");if((f.hasClass("fr-hnw")||f.hasClass("fr-hsw"))&&(i=0-i),p.opts.imageResizeWithPercent){var n=g.parentsUntil(p.$el,p.html.blockTagsQuery()).get(0)||p.el;r=((r+i)/ye(n).outerWidth()*100).toFixed(2),p.opts.imageRoundPercent&&(r=Math.round(r)),R(r+"%"),(t=be()?(p.helpers.getPX(g.parents(".fr-img-caption").css("width"))/ye(n).outerWidth()*100).toFixed(2):(p.helpers.getPX(g.css("width"))/ye(n).outerWidth()*100).toFixed(2))===r||p.opts.imageRoundPercent||R(t+"%"),g.css("height","").removeAttr("height")}else r+i>=p.opts.imageMinWidth&&(R(r+i),t=be()?p.helpers.getPX(g.parents(".fr-img-caption").css("width")):p.helpers.getPX(g.css("width"))),t!==r+i&&R(t),((g.attr("style")||"").match(/(^height:)|(; *height:)/)||g.attr("height"))&&(g.css("height",f.data("start-height")*g.width()/f.data("start-width")),g.removeAttr("height"));A(),p.events.trigger("image.resize",[he()])}}function x(e){if(!p.core.sameInstance(l))return!0;if(f&&g){if(e&&e.stopPropagation(),p.$el.find("img.fr-error").left)return!1;f=null,d.hide(),A(),n(),p.undo.saveStep(),p.events.trigger("image.resizeEnd",[he()])}}function U(e,t,a){p.edit.on(),g&&g.addClass("fr-error"),function(e){I();var t=p.popups.get("image.insert").find(".fr-image-progress-bar-layer");t.addClass("fr-error");var a=t.find("h3");a.text(e),p.events.disableBlur(),a.focus()}(p.language.translate("Something went wrong. Please try again.")),!g&&a&&J(a),p.events.trigger("image.error",[{code:e,message:r[e]},t,a])}function $(e){if(e)return p.$wp&&p.events.$on(p.$wp,"scroll",function(){g&&p.popups.isVisible("image.edit")&&(p.events.disableBlur(),B(g))}),!0;var t="";if(0<p.opts.imageEditButtons.length){t+='<div class="fr-buttons">',t+=p.button.buildList(p.opts.imageEditButtons);var a={buttons:t+="</div>"};return p.popups.create("image.edit",a)}return!1}function I(e){var t=p.popups.get("image.insert");if(t||(t=H()),t.find(".fr-layer.fr-active").removeClass("fr-active").addClass("fr-pactive"),t.find(".fr-image-progress-bar-layer").addClass("fr-active"),t.find(".fr-buttons").hide(),g){var a=ve();p.popups.setContainer("image.insert",p.$sc);var i=a.offset().left+a.width()/2,r=a.offset().top+a.height();p.popups.show("image.insert",i,r,a.outerHeight())}void 0===e&&k(p.language.translate("Uploading"),0)}function F(e){var t=p.popups.get("image.insert");if(t&&(t.find(".fr-layer.fr-pactive").addClass("fr-active").removeClass("fr-pactive"),t.find(".fr-image-progress-bar-layer").removeClass("fr-active"),t.find(".fr-buttons").show(),e||p.$el.find("img.fr-error").length)){if(p.events.focus(),p.$el.find("img.fr-error").length&&(p.$el.find("img.fr-error").remove(),p.undo.saveStep(),p.undo.run(),p.undo.dropRedo()),!p.$wp&&g){var a=g;oe(!0),p.selection.setAfter(a.get(0)),p.selection.restore()}p.popups.hide("image.insert")}}function k(e,t){var a=p.popups.get("image.insert");if(a){var i=a.find(".fr-image-progress-bar-layer");i.find("h3").text(e+(t?" "+t+"%":"")),i.removeClass("fr-error"),t?(i.find("div").removeClass("fr-indeterminate"),i.find("div > span").css("width",t+"%")):i.find("div").addClass("fr-indeterminate")}}function B(e){se.call(e.get(0))}function O(){var e=ye(this);p.popups.hide("image.insert"),e.removeClass("fr-uploading"),e.next().is("br")&&e.next().remove(),B(e),p.events.trigger("image.loaded",[e])}function P(s,e,o,l,f){p.edit.off(),k(p.language.translate("Loading image")),e&&(s=p.helpers.sanitizeURL(s));var t=new Image;t.onload=function(){var e,t;if(l){p.undo.canDo()||l.hasClass("fr-uploading")||p.undo.saveStep();var a=l.data("fr-old-src");l.data("fr-image-pasted")&&(a=null),p.$wp?((e=l.clone().removeData("fr-old-src").removeClass("fr-uploading").removeAttr("data-fr-image-pasted")).off("load"),a&&l.attr("src",a),l.replaceWith(e)):e=l;for(var i=e.get(0).attributes,r=0;r<i.length;r++){var n=i[r];0===n.nodeName.indexOf("data-")&&e.removeAttr(n.nodeName)}if(void 0!==o)for(t in o)o.hasOwnProperty(t)&&"link"!=t&&e.attr("data-"+t,o[t]);e.on("load",O),e.attr("src",s),p.edit.on(),C(!1),p.undo.saveStep(),p.events.disableBlur(),p.$el.blur(),p.events.trigger(a?"image.replaced":"image.inserted",[e,f])}else e=M(s,o,O),C(!1),p.undo.saveStep(),p.events.disableBlur(),p.$el.blur(),p.events.trigger("image.inserted",[e,f])},t.onerror=function(){U(i)},I(p.language.translate("Loading image")),t.src=s}function N(e){k(p.language.translate("Loading image"));var t=this.status,a=this.response,i=this.responseXML,r=this.responseText;try{if(p.opts.imageUploadToS3)if(201==t){var n=function(e){try{var t=ye(e).find("Location").text(),a=ye(e).find("Key").text();return!1===p.events.trigger("image.uploadedToS3",[t,a,e],!0)?(p.edit.on(),!1):t}catch(i){return U(h,e),!1}}(i);n&&P(n,!1,[],e,a||i)}else U(h,a||i,e);else if(200<=t&&t<300){var s=function(e){try{if(!1===p.events.trigger("image.uploaded",[e],!0))return p.edit.on(),!1;var t=JSON.parse(e);return t.link?t:(U(c,e),!1)}catch(a){return U(h,e),!1}}(r);s&&P(s.link,!1,s,e,a||r)}else U(m,a||r,e)}catch(o){U(h,a||r,e)}}function T(){U(h,this.response||this.responseText||this.responseXML)}function L(e){if(e.lengthComputable){var t=e.loaded/e.total*100|0;k(p.language.translate("Uploading"),t)}}function M(e,t,a){var i,r="";if(t&&void 0!==t)for(i in t)t.hasOwnProperty(i)&&"link"!=i&&(r+=" data-"+i+'="'+t[i]+'"');var n=p.opts.imageDefaultWidth;n&&"auto"!=n&&(n+=p.opts.imageResizeWithPercent?"%":"px");var s=ye('<img src="'+e+'"'+r+(n?' style="width: '+n+';"':"")+">");ge(s,p.opts.imageDefaultDisplay,p.opts.imageDefaultAlign),s.on("load",a),s.on("error",function(){ye(this).addClass("fr-error"),U(y)}),p.edit.on(),p.events.focus(!0),p.selection.restore(),p.undo.saveStep(),p.opts.imageSplitHTML?p.markers.split():p.markers.insert(),p.html.wrap();var o=p.$el.find(".fr-marker");return o.length?(o.parent().is("hr")&&o.parent().after(o),p.node.isLastSibling(o)&&o.parent().hasClass("fr-deletable")&&o.insertAfter(o.parent()),o.replaceWith(s)):p.$el.append(s),p.selection.clear(),s}function z(){p.edit.on(),F(!0)}function _(e,t){if(void 0!==e&&0<e.length){if(!1===p.events.trigger("image.beforeUpload",[e,t]))return!1;var a,i=e[0];if(null===p.opts.imageUploadURL||p.opts.imageUploadURL==u)return s=i,o=t||g,(l=new FileReader).addEventListener("load",function(){var e=l.result;if(l.result.indexOf("svg+xml")<0){for(var t=atob(l.result.split(",")[1]),a=[],i=0;i<t.length;i++)a.push(t.charCodeAt(i));e=window.URL.createObjectURL(new Blob([new Uint8Array(a)],{type:s.type})),p.image.insert(e,!1,null,o)}},!1),I(),l.readAsDataURL(s),!1;if(i.name||(i.name=(new Date).getTime()+"."+(i.type||"image/jpeg").replace(/image\//g,"")),i.size>p.opts.imageMaxSize)return U(v),!1;if(p.opts.imageAllowedTypes.indexOf(i.type.replace(/image\//g,""))<0)return U(b),!1;if(p.drag_support.formdata&&(a=p.drag_support.formdata?new FormData:null),a){var r;if(!1!==p.opts.imageUploadToS3)for(r in a.append("key",p.opts.imageUploadToS3.keyStart+(new Date).getTime()+"-"+(i.name||"untitled")),a.append("success_action_status","201"),a.append("X-Requested-With","xhr"),a.append("Content-Type",i.type),p.opts.imageUploadToS3.params)p.opts.imageUploadToS3.params.hasOwnProperty(r)&&a.append(r,p.opts.imageUploadToS3.params[r]);for(r in p.opts.imageUploadParams)p.opts.imageUploadParams.hasOwnProperty(r)&&a.append(r,p.opts.imageUploadParams[r]);a.append(p.opts.imageUploadParam,i,i.name);var n=p.opts.imageUploadURL;p.opts.imageUploadToS3&&(n=p.opts.imageUploadToS3.uploadURL?p.opts.imageUploadToS3.uploadURL:"https://"+p.opts.imageUploadToS3.region+".amazonaws.com/"+p.opts.imageUploadToS3.bucket),function(t,a,e,r){function n(){var e=ye(this);e.off("load"),e.addClass("fr-uploading"),e.next().is("br")&&e.next().remove(),p.placeholder.refresh(),B(e),A(),I(),p.edit.off(),t.onload=function(){N.call(t,e)},t.onerror=T,t.upload.onprogress=L,t.onabort=z,e.off("abortUpload").on("abortUpload",function(){4!=t.readyState&&t.abort()}),t.send(a)}var s=new FileReader;s.addEventListener("load",function(){var e=s.result;if(s.result.indexOf("svg+xml")<0){for(var t=atob(s.result.split(",")[1]),a=[],i=0;i<t.length;i++)a.push(t.charCodeAt(i));e=window.URL.createObjectURL(new Blob([new Uint8Array(a)],{type:"image/jpeg"}))}r?(r.on("load",n),r.one("error",function(){r.off("load"),r.attr("src",r.data("fr-old-src")),U(y)}),p.edit.on(),p.undo.saveStep(),r.data("fr-old-src",r.attr("src")),r.attr("src",e)):M(e,null,n)},!1),s.readAsDataURL(e)}(p.core.getXHR(n,p.opts.imageUploadMethod),a,i,t||g)}}var s,o,l}function W(e){if(e.is("img")&&0<e.parents(".fr-img-caption").length)return e.parents(".fr-img-caption")}function K(e){var t=e.originalEvent.dataTransfer;if(t&&t.files&&t.files.length){var a=t.files[0];if(a&&a.type&&-1!==a.type.indexOf("image")&&0<=p.opts.imageAllowedTypes.indexOf(a.type.replace(/image\//g,""))){if(!p.opts.imageUpload)return e.preventDefault(),e.stopPropagation(),!1;p.markers.remove(),p.markers.insertAtPoint(e.originalEvent),p.$el.find(".fr-marker").replaceWith(ye.FE.MARKERS),0===p.$el.find(".fr-marker").length&&p.selection.setAtEnd(p.el),p.popups.hideAll();var i=p.popups.get("image.insert");i||(i=H()),p.popups.setContainer("image.insert",p.$sc);var r=e.originalEvent.pageX,n=e.originalEvent.pageY;return p.opts.iframe&&(n+=p.$iframe.offset().top,r+=p.$iframe.offset().left),p.popups.show("image.insert",r,n),I(),0<=p.opts.imageAllowedTypes.indexOf(a.type.replace(/image\//g,""))?(oe(!0),_(t.files)):U(b),e.preventDefault(),e.stopPropagation(),!1}}}function H(e){if(e)return p.popups.onRefresh("image.insert",w),p.popups.onHide("image.insert",E),!0;var t,a="";p.opts.imageUpload||p.opts.imageInsertButtons.splice(p.opts.imageInsertButtons.indexOf("imageUpload"),1),1<p.opts.imageInsertButtons.length&&(a='<div class="fr-buttons">'+p.button.buildList(p.opts.imageInsertButtons)+"</div>");var i=p.opts.imageInsertButtons.indexOf("imageUpload"),r=p.opts.imageInsertButtons.indexOf("imageByURL"),n="";0<=i&&(t=" fr-active",0<=r&&r<i&&(t=""),n='<div class="fr-image-upload-layer'+t+' fr-layer" id="fr-image-upload-layer-'+p.id+'"><strong>'+p.language.translate("Drop image")+"</strong><br>("+p.language.translate("or click")+')<div class="fr-form"><input type="file" accept="image/'+p.opts.imageAllowedTypes.join(", image/").toLowerCase()+'" tabIndex="-1" aria-labelledby="fr-image-upload-layer-'+p.id+'" role="button"></div></div>');var s="";0<=r&&(t=" fr-active",0<=i&&i<r&&(t=""),s='<div class="fr-image-by-url-layer'+t+' fr-layer" id="fr-image-by-url-layer-'+p.id+'"><div class="fr-input-line"><input id="fr-image-by-url-layer-text-'+p.id+'" type="text" placeholder="http://" tabIndex="1" aria-required="true"></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-submit" data-cmd="imageInsertByURL" tabIndex="2" role="button">'+p.language.translate("Insert")+"</button></div></div>");var o,l={buttons:a,upload_layer:n,by_url_layer:s,progress_bar:'<div class="fr-image-progress-bar-layer fr-layer"><h3 tabIndex="-1" class="fr-message">Uploading</h3><div class="fr-loader"><span class="fr-progress"></span></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-dismiss" data-cmd="imageDismissError" tabIndex="2" role="button">OK</button></div></div>'},f=p.popups.create("image.insert",l);return p.$wp&&p.events.$on(p.$wp,"scroll",function(){g&&p.popups.isVisible("image.insert")&&ce()}),o=f,p.events.$on(o,"dragover dragenter",".fr-image-upload-layer",function(){return ye(this).addClass("fr-drop"),!1},!0),p.events.$on(o,"dragleave dragend",".fr-image-upload-layer",function(){return ye(this).removeClass("fr-drop"),!1},!0),p.events.$on(o,"drop",".fr-image-upload-layer",function(e){e.preventDefault(),e.stopPropagation(),ye(this).removeClass("fr-drop");var t=e.originalEvent.dataTransfer;if(t&&t.files){var a=o.data("instance")||p;a.events.disableBlur(),a.image.upload(t.files),a.events.enableBlur()}},!0),p.helpers.isIOS()&&p.events.$on(o,"touchstart",'.fr-image-upload-layer input[type="file"]',function(){ye(this).trigger("click")},!0),p.events.$on(o,"change",'.fr-image-upload-layer input[type="file"]',function(){if(this.files){var e=o.data("instance")||p;e.events.disableBlur(),o.find("input:focus").blur(),e.events.enableBlur(),e.image.upload(this.files,g)}ye(this).val("")},!0),f}function Y(){g&&p.popups.get("image.alt").find("input").val(g.attr("alt")||"").trigger("change")}function X(){var e=p.popups.get("image.alt");e||(e=j()),F(),p.popups.refresh("image.alt"),p.popups.setContainer("image.alt",p.$sc);var t=ve();be()&&(t=t.find(".fr-img-wrap"));var a=t.offset().left+t.outerWidth()/2,i=t.offset().top+t.outerHeight();p.popups.show("image.alt",a,i,t.outerHeight())}function j(e){if(e)return p.popups.onRefresh("image.alt",Y),!0;var t={buttons:'<div class="fr-buttons">'+p.button.buildList(p.opts.imageAltButtons)+"</div>",alt_layer:'<div class="fr-image-alt-layer fr-layer fr-active" id="fr-image-alt-layer-'+p.id+'"><div class="fr-input-line"><input id="fr-image-alt-layer-text-'+p.id+'" type="text" placeholder="'+p.language.translate("Alternative Text")+'" tabIndex="1"></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-submit" data-cmd="imageSetAlt" tabIndex="2" role="button">'+p.language.translate("Update")+"</button></div></div>"},a=p.popups.create("image.alt",t);return p.$wp&&p.events.$on(p.$wp,"scroll.image-alt",function(){g&&p.popups.isVisible("image.alt")&&X()}),a}function G(){if(g){var e=p.popups.get("image.size");e.find('input[name="width"]').val(g.get(0).style.width).trigger("change"),e.find('input[name="height"]').val(g.get(0).style.height).trigger("change")}}function q(){var e=p.popups.get("image.size");e||(e=V()),F(),p.popups.refresh("image.size"),p.popups.setContainer("image.size",p.$sc);var t=ve();be()&&(t=t.find(".fr-img-wrap"));var a=t.offset().left+t.outerWidth()/2,i=t.offset().top+t.outerHeight();p.popups.show("image.size",a,i,t.outerHeight())}function V(e){if(e)return p.popups.onRefresh("image.size",G),!0;var t={buttons:'<div class="fr-buttons">'+p.button.buildList(p.opts.imageSizeButtons)+"</div>",size_layer:'<div class="fr-image-size-layer fr-layer fr-active" id="fr-image-size-layer-'+p.id+'"><div class="fr-image-group"><div class="fr-input-line"><input id="fr-image-size-layer-width-'+p.id+'" type="text" name="width" placeholder="'+p.language.translate("Width")+'" tabIndex="1"></div><div class="fr-input-line"><input id="fr-image-size-layer-height'+p.id+'" type="text" name="height" placeholder="'+p.language.translate("Height")+'" tabIndex="1"></div></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-submit" data-cmd="imageSetSize" tabIndex="2" role="button">'+p.language.translate("Update")+"</button></div></div>"},a=p.popups.create("image.size",t);return p.$wp&&p.events.$on(p.$wp,"scroll.image-size",function(){g&&p.popups.isVisible("image.size")&&q()}),a}function Q(e,t,a,i){return e.pageX=t,S.call(this,e),e.pageX=e.pageX+a*Math.floor(Math.pow(1.1,i)),D.call(this,e),x.call(this,e),++i}function J(e){(e=e||ve())&&!1!==p.events.trigger("image.beforeRemove",[e])&&(p.popups.hideAll(),me(),oe(!0),p.undo.canDo()||p.undo.saveStep(),e.get(0)==p.el?e.removeAttr("src"):(e.get(0).parentNode&&"A"==e.get(0).parentNode.tagName?(p.selection.setBefore(e.get(0).parentNode)||p.selection.setAfter(e.get(0).parentNode)||e.parent().after(ye.FE.MARKERS),ye(e.get(0).parentNode).remove()):(p.selection.setBefore(e.get(0))||p.selection.setAfter(e.get(0))||e.after(ye.FE.MARKERS),e.remove()),p.html.fillEmptyBlocks(),p.selection.restore()),p.undo.saveStep())}function Z(e){var t=e.which;if(g&&(t==ye.FE.KEYCODE.BACKSPACE||t==ye.FE.KEYCODE.DELETE))return e.preventDefault(),e.stopPropagation(),J(),!1;if(g&&t==ye.FE.KEYCODE.ESC){var a=g;return oe(!0),p.selection.setAfter(a.get(0)),p.selection.restore(),e.preventDefault(),!1}if(g&&(t==ye.FE.KEYCODE.ARROW_LEFT||t==ye.FE.KEYCODE.ARROW_RIGHT)){var i=g.get(0);return oe(!0),t==ye.FE.KEYCODE.ARROW_LEFT?p.selection.setBefore(i):p.selection.setAfter(i),p.selection.restore(),e.preventDefault(),!1}return g&&t!=ye.FE.KEYCODE.F10&&!p.keys.isBrowserAction(e)?(e.preventDefault(),e.stopPropagation(),!1):void 0}function ee(e){if(e&&"IMG"==e.tagName){if(p.node.hasClass(e,"fr-uploading")||p.node.hasClass(e,"fr-error")?e.parentNode.removeChild(e):p.node.hasClass(e,"fr-draggable")&&e.classList.remove("fr-draggable"),e.parentNode&&e.parentNode.parentNode&&p.node.hasClass(e.parentNode.parentNode,"fr-img-caption")){var t=e.parentNode.parentNode;t.removeAttribute("contenteditable"),t.removeAttribute("draggable"),t.classList.remove("fr-draggable");var a=e.nextSibling;a&&a.removeAttribute("contenteditable")}}else if(e&&e.nodeType==Node.ELEMENT_NODE)for(var i=e.querySelectorAll("img.fr-uploading, img.fr-error, img.fr-draggable"),r=0;r<i.length;r++)ee(i[r])}function te(e){if(!1===p.events.trigger("image.beforePasteUpload",[e]))return!1;g=ye(e),A(),n(),ce(),I(),g.one("load",function(){A(),I()});for(var t=atob(ye(e).attr("src").split(",")[1]),a=[],i=0;i<t.length;i++)a.push(t.charCodeAt(i));_([new Blob([new Uint8Array(a)],{type:ye(e).attr("src").split(",")[0].replace(/data\:/g,"").replace(/;base64/g,"")})],g)}function ae(){p.opts.imagePaste?p.$el.find("img[data-fr-image-pasted]").each(function(e,a){if(p.opts.imagePasteProcess){var t=p.opts.imageDefaultWidth;t&&"auto"!=t&&(t+=p.opts.imageResizeWithPercent?"%":"px"),ye(a).css("width",t).removeClass("fr-dii fr-dib fr-fir fr-fil"),ge(ye(a),p.opts.imageDefaultDisplay,p.opts.imageDefaultAlign)}if(0===a.src.indexOf("data:"))te(a);else if(0===a.src.indexOf("blob:")||0===a.src.indexOf("http")&&p.opts.imageUploadRemoteUrls&&p.opts.imageCORSProxy){var i=new Image;i.crossOrigin="Anonymous",i.onload=function(){var e=p.o_doc.createElement("CANVAS"),t=e.getContext("2d");e.height=this.naturalHeight,e.width=this.naturalWidth,t.drawImage(this,0,0),a.src=e.toDataURL("image/png"),te(a)},i.src=(0===a.src.indexOf("blob:")?"":p.opts.imageCORSProxy+"/")+a.src}else 0!==a.src.indexOf("http")||0===a.src.indexOf("https://mail.google.com/mail")?(p.selection.save(),ye(a).remove(),p.selection.restore()):ye(a).removeAttr("data-fr-image-pasted")}):p.$el.find("img[data-fr-image-pasted]").remove()}function ie(e){var t=e.target.result,a=p.opts.imageDefaultWidth;a&&"auto"!=a&&(a+=p.opts.imageResizeWithPercent?"%":"px"),p.undo.saveStep(),p.html.insert('<img data-fr-image-pasted="true" src="'+t+'"'+(a?' style="width: '+a+';"':"")+">");var i=p.$el.find('img[data-fr-image-pasted="true"]');i&&ge(i,p.opts.imageDefaultDisplay,p.opts.imageDefaultAlign),p.events.trigger("paste.after")}function re(e){if(e&&e.clipboardData&&e.clipboardData.items){var t=null;if(e.clipboardData.getData("text/rtf"))t=e.clipboardData.items[0].getAsFile();else for(var a=0;a<e.clipboardData.items.length&&!(t=e.clipboardData.items[a].getAsFile());a++);if(t)return i=t,(r=new FileReader).onload=ie,r.readAsDataURL(i),!1}var i,r}function ne(e){return e=e.replace(/<img /gi,'<img data-fr-image-pasted="true" ')}function se(e){if("false"==ye(this).parents("[contenteditable]:not(.fr-element):not(.fr-img-caption):not(body):first").attr("contenteditable"))return!0;if(e&&"touchend"==e.type&&a)return!0;if(e&&p.edit.isDisabled())return e.stopPropagation(),e.preventDefault(),!1;for(var t=0;t<ye.FE.INSTANCES.length;t++)ye.FE.INSTANCES[t]!=p&&ye.FE.INSTANCES[t].events.trigger("image.hideResizer");p.toolbar.disable(),e&&(e.stopPropagation(),e.preventDefault()),p.helpers.isMobile()&&(p.events.disableBlur(),p.$el.blur(),p.events.enableBlur()),p.opts.iframe&&p.size.syncIframe(),g=ye(this),me(),A(),n(),p.browser.msie||p.selection.clear(),p.helpers.isIOS()&&(p.events.disableBlur(),p.$el.blur()),p.button.bulkRefresh(),p.events.trigger("video.hideResizer")}function oe(e){g&&(le||!0===e)&&(p.toolbar.enable(),l.removeClass("fr-active"),p.popups.hide("image.edit"),g=null,pe(),f=null,d&&d.hide())}r[i]="Image cannot be loaded from the passed link.",r[c]="No link in upload response.",r[m]="Error during file upload.",r[h]="Parsing response failed.",r[v]="File is too large.",r[b]="Image file type is invalid.",r[7]="Files can be uploaded only to same domain in IE 8 and IE 9.";var le=!(r[y]="Image file is corrupted.");function fe(){le=!0}function pe(){le=!1}function ge(e,t,a){!p.opts.htmlUntouched&&p.opts.useClasses?(e.removeClass("fr-fil fr-fir fr-dib fr-dii"),a&&e.addClass("fr-fi"+a[0]),t&&e.addClass("fr-di"+t[0])):"inline"==t?(e.css({display:"inline-block",verticalAlign:"bottom",margin:p.opts.imageDefaultMargin}),"center"==a?e.css({"float":"none",marginBottom:"",marginTop:"",maxWidth:"calc(100% - "+2*p.opts.imageDefaultMargin+"px)",textAlign:"center"}):"left"==a?e.css({"float":"left",marginLeft:0,maxWidth:"calc(100% - "+p.opts.imageDefaultMargin+"px)",textAlign:"left"}):e.css({"float":"right",marginRight:0,maxWidth:"calc(100% - "+p.opts.imageDefaultMargin+"px)",textAlign:"right"})):"block"==t&&(e.css({display:"block","float":"none",verticalAlign:"top",margin:p.opts.imageDefaultMargin+"px auto",textAlign:"center"}),"left"==a?e.css({marginLeft:0,textAlign:"left"}):"right"==a&&e.css({marginRight:0,textAlign:"right"}))}function de(e){if(void 0===e&&(e=ve()),e){if(e.hasClass("fr-fil"))return"left";if(e.hasClass("fr-fir"))return"right";if(e.hasClass("fr-dib")||e.hasClass("fr-dii"))return"center";var t=e.css("float");if(e.css("float","none"),"block"==e.css("display")){if(e.css("float",""),e.css("float")!=t&&e.css("float",t),0===parseInt(e.css("margin-left"),10))return"left";if(0===parseInt(e.css("margin-right"),10))return"right"}else{if(e.css("float",""),e.css("float")!=t&&e.css("float",t),"left"==e.css("float"))return"left";if("right"==e.css("float"))return"right"}}return"center"}function ue(e){void 0===e&&(e=ve());var t=e.css("float");return e.css("float","none"),"block"==e.css("display")?(e.css("float",""),e.css("float")!=t&&e.css("float",t),"block"):(e.css("float",""),e.css("float")!=t&&e.css("float",t),"inline")}function ce(){var e=p.popups.get("image.insert");e||(e=H()),p.popups.isVisible("image.insert")||(F(),p.popups.refresh("image.insert"),p.popups.setContainer("image.insert",p.$sc));var t=ve();be()&&(t=t.find(".fr-img-wrap"));var a=t.offset().left+t.outerWidth()/2,i=t.offset().top+t.outerHeight();p.popups.show("image.insert",a,i,t.outerHeight(!0))}function me(){if(g){p.events.disableBlur(),p.selection.clear();var e=p.doc.createRange();e.selectNode(g.get(0)),p.browser.msie&&e.collapse(!0),p.selection.get().addRange(e),p.events.enableBlur()}}function he(){return g}function ve(){return be()?g.parents(".fr-img-caption:first"):g}function be(){return!!g&&0<g.parents(".fr-img-caption").length}return{_init:function(){var i;p.events.$on(p.$el,p._mousedown,"IMG"==p.el.tagName?null:'img:not([contenteditable="false"])',function(e){if("false"==ye(this).parents("[contenteditable]:not(.fr-element):not(.fr-img-caption):not(body):first").attr("contenteditable"))return!0;p.helpers.isMobile()||p.selection.clear(),t=!0,p.popups.areVisible()&&p.events.disableBlur(),p.browser.msie&&(p.events.disableBlur(),p.$el.attr("contenteditable",!1)),p.draggable||"touchstart"==e.type||e.preventDefault(),e.stopPropagation()}),p.events.$on(p.$el,p._mouseup,"IMG"==p.el.tagName?null:'img:not([contenteditable="false"])',function(e){if("false"==ye(this).parents("[contenteditable]:not(.fr-element):not(.fr-img-caption):not(body):first").attr("contenteditable"))return!0;t&&(t=!1,e.stopPropagation(),p.browser.msie&&(p.$el.attr("contenteditable",!0),p.events.enableBlur()))}),p.events.on("keyup",function(e){if(e.shiftKey&&""===p.selection.text().replace(/\n/g,"")&&p.keys.isArrow(e.which)){var t=p.selection.element(),a=p.selection.endElement();t&&"IMG"==t.tagName?B(ye(t)):a&&"IMG"==a.tagName&&B(ye(a))}},!0),p.events.on("drop",K),p.events.on("element.beforeDrop",W),p.events.on("mousedown window.mousedown",fe),p.events.on("window.touchmove",pe),p.events.on("mouseup window.mouseup",function(){if(g)return oe(),!1;pe()}),p.events.on("commands.mousedown",function(e){0<e.parents(".fr-toolbar").length&&oe()}),p.events.on("blur image.hideResizer commands.undo commands.redo element.dropped",function(){oe(!(t=!1))}),p.events.on("modals.hide",function(){g&&(me(),p.selection.clear())}),"IMG"==p.el.tagName&&p.$el.addClass("fr-view"),p.events.$on(p.$el,p.helpers.isMobile()&&!p.helpers.isWindowsPhone()?"touchend":"click","IMG"==p.el.tagName?null:'img:not([contenteditable="false"])',se),p.helpers.isMobile()&&(p.events.$on(p.$el,"touchstart","IMG"==p.el.tagName?null:'img:not([contenteditable="false"])',function(){a=!1}),p.events.$on(p.$el,"touchmove",function(){a=!0})),p.$wp?(p.events.on("window.keydown keydown",Z,!0),p.events.on("keyup",function(e){if(g&&e.which==ye.FE.KEYCODE.ENTER)return!1},!0)):p.events.$on(p.$win,"keydown",Z),p.events.on("toolbar.esc",function(){if(g){if(p.$wp)p.events.disableBlur(),p.events.focus();else{var e=g;oe(!0),p.selection.setAfter(e.get(0)),p.selection.restore()}return!1}},!0),p.events.on("toolbar.focusEditor",function(){if(g)return!1},!0),p.events.on("window.cut window.copy",function(e){if(g&&p.popups.isVisible("image.edit")&&!p.popups.get("image.edit").find(":focus").length){var t=ve();be()?(t.before(ye.FE.START_MARKER),t.after(ye.FE.END_MARKER),p.selection.restore(),p.paste.saveCopiedText(t.get(0).outerHTML,t.text())):(me(),p.paste.saveCopiedText(g.get(0).outerHTML,g.attr("alt"))),"copy"==e.type?setTimeout(function(){B(g)}):(oe(!0),p.undo.saveStep(),setTimeout(function(){p.undo.saveStep()},0))}},!0),p.browser.msie&&p.events.on("keydown",function(e){if(!p.selection.isCollapsed()||!g)return!0;var t=e.which;t==ye.FE.KEYCODE.C&&p.keys.ctrlKey(e)?p.events.trigger("window.copy"):t==ye.FE.KEYCODE.X&&p.keys.ctrlKey(e)&&p.events.trigger("window.cut")}),p.events.$on(ye(p.o_win),"keydown",function(e){var t=e.which;if(g&&t==ye.FE.KEYCODE.BACKSPACE)return e.preventDefault(),!1}),p.events.$on(p.$win,"keydown",function(e){var t=e.which;g&&g.hasClass("fr-uploading")&&t==ye.FE.KEYCODE.ESC&&g.trigger("abortUpload")}),p.events.on("destroy",function(){g&&g.hasClass("fr-uploading")&&g.trigger("abortUpload")}),p.events.on("paste.before",re),p.events.on("paste.beforeCleanup",ne),p.events.on("paste.after",ae),p.events.on("html.set",e),p.events.on("html.inserted",e),e(),p.events.on("destroy",function(){o=[]}),p.events.on("html.processGet",ee),p.opts.imageOutputSize&&p.events.on("html.beforeGet",function(){i=p.el.querySelectorAll("img");for(var e=0;e<i.length;e++){var t=i[e].style.width||ye(i[e]).width(),a=i[e].style.height||ye(i[e]).height();t&&i[e].setAttribute("width",(""+t).replace(/px/,"")),a&&i[e].setAttribute("height",(""+a).replace(/px/,""))}}),p.opts.iframe&&p.events.on("image.loaded",p.size.syncIframe),p.$wp&&(C(),p.events.on("contentChanged",C)),p.events.$on(ye(p.o_win),"orientationchange.image",function(){setTimeout(function(){g&&B(g)},100)}),$(!0),H(!0),V(!0),j(!0),p.events.on("node.remove",function(e){if("IMG"==e.get(0).tagName)return J(e),!1})},showInsertPopup:function(){var e=p.$tb.find('.fr-command[data-cmd="insertImage"]'),t=p.popups.get("image.insert");if(t||(t=H()),F(),!t.hasClass("fr-active"))if(p.popups.refresh("image.insert"),p.popups.setContainer("image.insert",p.$tb),e.is(":visible")){var a=e.offset().left+e.outerWidth()/2,i=e.offset().top+(p.opts.toolbarBottom?10:e.outerHeight()-10);p.popups.show("image.insert",a,i,e.outerHeight())}else p.position.forSelection(t),p.popups.show("image.insert")},showLayer:function(e){var t,a,i=p.popups.get("image.insert");if(g||p.opts.toolbarInline){if(g){var r=ve();be()&&(r=r.find(".fr-img-wrap")),a=r.offset().top+r.outerHeight(),t=r.offset().left+r.outerWidth()/2}}else{var n=p.$tb.find('.fr-command[data-cmd="insertImage"]');t=n.offset().left+n.outerWidth()/2,a=n.offset().top+(p.opts.toolbarBottom?10:n.outerHeight()-10)}!g&&p.opts.toolbarInline&&(a=i.offset().top-p.helpers.getPX(i.css("margin-top")),i.hasClass("fr-above")&&(a+=i.outerHeight())),i.find(".fr-layer").removeClass("fr-active"),i.find(".fr-"+e+"-layer").addClass("fr-active"),p.popups.show("image.insert",t,a,g?g.outerHeight():0),p.accessibility.focusPopup(i)},refreshUploadButton:function(e){p.popups.get("image.insert").find(".fr-image-upload-layer").hasClass("fr-active")&&e.addClass("fr-active").attr("aria-pressed",!0)},refreshByURLButton:function(e){p.popups.get("image.insert").find(".fr-image-by-url-layer").hasClass("fr-active")&&e.addClass("fr-active").attr("aria-pressed",!0)},upload:_,insertByURL:function(){var e=p.popups.get("image.insert").find(".fr-image-by-url-layer input");if(0<e.val().length){I(),k(p.language.translate("Loading image"));var t=e.val();if(p.opts.imageUploadRemoteUrls&&p.opts.imageCORSProxy&&p.opts.imageUpload){var a=new XMLHttpRequest;a.onload=function(){200==this.status?_([new Blob([this.response],{type:this.response.type||"image/png"})],g):U(i)},a.onerror=function(){P(t,!0,[],g)},a.open("GET",p.opts.imageCORSProxy+"/"+t,!0),a.responseType="blob",a.send()}else P(t,!0,[],g);e.val(""),e.blur()}},align:function(e){var t=ve();t.removeClass("fr-fir fr-fil"),!p.opts.htmlUntouched&&p.opts.useClasses?"left"==e?t.addClass("fr-fil"):"right"==e&&t.addClass("fr-fir"):ge(t,ue(),e),me(),A(),n(),p.selection.clear()},refreshAlign:function(e){g&&e.find("> *:first").replaceWith(p.icon.create("image-align-"+de()))},refreshAlignOnShow:function(e,t){g&&t.find('.fr-command[data-param1="'+de()+'"]').addClass("fr-active").attr("aria-selected",!0)},display:function(e){var t=ve();t.removeClass("fr-dii fr-dib"),!p.opts.htmlUntouched&&p.opts.useClasses?"inline"==e?t.addClass("fr-dii"):"block"==e&&t.addClass("fr-dib"):ge(t,e,de()),me(),A(),n(),p.selection.clear()},refreshDisplayOnShow:function(e,t){g&&t.find('.fr-command[data-param1="'+ue()+'"]').addClass("fr-active").attr("aria-selected",!0)},replace:ce,back:function(){g?(p.events.disableBlur(),ye(".fr-popup input:focus").blur(),B(g)):(p.events.disableBlur(),p.selection.restore(),p.events.enableBlur(),p.popups.hide("image.insert"),p.toolbar.showInline())},get:he,getEl:ve,insert:P,showProgressBar:I,remove:J,hideProgressBar:F,applyStyle:function(e,t,a){if(void 0===t&&(t=p.opts.imageStyles),void 0===a&&(a=p.opts.imageMultipleStyles),!g)return!1;var i=ve();if(!a){var r=Object.keys(t);r.splice(r.indexOf(e),1),i.removeClass(r.join(" "))}"object"==typeof t[e]?(i.removeAttr("style"),i.css(t[e].style)):i.toggleClass(e),B(g)},showAltPopup:X,showSizePopup:q,setAlt:function(e){if(g){var t=p.popups.get("image.alt");g.attr("alt",e||t.find("input").val()||""),t.find("input:focus").blur(),B(g)}},setSize:function(e,t){if(g){var a=p.popups.get("image.size");e=e||a.find('input[name="width"]').val()||"",t=t||a.find('input[name="height"]').val()||"";var i=/^[\d]+((px)|%)*$/g;g.removeAttr("width").removeAttr("height"),e.match(i)?g.css("width",e):g.css("width",""),t.match(i)?g.css("height",t):g.css("height",""),be()&&(g.parent().removeAttr("width").removeAttr("height"),e.match(i)?g.parent().css("width",e):g.parent().css("width",""),t.match(i)?g.parent().css("height",t):g.parent().css("height","")),a.find("input:focus").blur(),B(g)}},toggleCaption:function(){var e;g&&!be()?((e=g).parent().is("a")&&(e=g.parent()),e.wrap("<span "+(p.browser.mozilla?"":'contenteditable="false"')+'class="fr-img-caption '+g.attr("class")+'" style="'+(g.attr("style")?g.attr("style")+" ":"")+"width: "+g.width()+'px;" draggable="false"></span>'),e.wrap('<span class="fr-img-wrap"></span>'),e.after('<span class="fr-inner" contenteditable="true">'+ye.FE.START_MARKER+"Image caption"+ye.FE.END_MARKER+"</span>"),g.removeAttr("class").removeAttr("style").removeAttr("width"),oe(!0),p.selection.restore()):(e=ve(),g.insertAfter(e),g.attr("class",e.attr("class").replace("fr-img-caption","")).attr("style",e.attr("style")),e.remove(),B(g))},hasCaption:be,exitEdit:oe,edit:B}},ye.FE.DefineIcon("insertImage",{NAME:"image"}),ye.FE.RegisterShortcut(ye.FE.KEYCODE.P,"insertImage",null,"P"),ye.FE.RegisterCommand("insertImage",{title:"Insert Image",undo:!1,focus:!0,refreshAfterCallback:!1,popup:!0,callback:function(){this.popups.isVisible("image.insert")?(this.$el.find(".fr-marker").length&&(this.events.disableBlur(),this.selection.restore()),this.popups.hide("image.insert")):this.image.showInsertPopup()},plugin:"image"}),ye.FE.DefineIcon("imageUpload",{NAME:"upload"}),ye.FE.RegisterCommand("imageUpload",{title:"Upload Image",undo:!1,focus:!1,toggle:!0,callback:function(){this.image.showLayer("image-upload")},refresh:function(e){this.image.refreshUploadButton(e)}}),ye.FE.DefineIcon("imageByURL",{NAME:"link"}),ye.FE.RegisterCommand("imageByURL",{title:"By URL",undo:!1,focus:!1,toggle:!0,callback:function(){this.image.showLayer("image-by-url")},refresh:function(e){this.image.refreshByURLButton(e)}}),ye.FE.RegisterCommand("imageInsertByURL",{title:"Insert Image",undo:!0,refreshAfterCallback:!1,callback:function(){this.image.insertByURL()},refresh:function(e){this.image.get()?e.text(this.language.translate("Replace")):e.text(this.language.translate("Insert"))}}),ye.FE.DefineIcon("imageDisplay",{NAME:"star"}),ye.FE.RegisterCommand("imageDisplay",{title:"Display",type:"dropdown",options:{inline:"Inline",block:"Break Text"},callback:function(e,t){this.image.display(t)},refresh:function(e){this.opts.imageTextNear||e.addClass("fr-hidden")},refreshOnShow:function(e,t){this.image.refreshDisplayOnShow(e,t)}}),ye.FE.DefineIcon("image-align",{NAME:"align-left"}),ye.FE.DefineIcon("image-align-left",{NAME:"align-left"}),ye.FE.DefineIcon("image-align-right",{NAME:"align-right"}),ye.FE.DefineIcon("image-align-center",{NAME:"align-justify"}),ye.FE.DefineIcon("imageAlign",{NAME:"align-justify"}),ye.FE.RegisterCommand("imageAlign",{type:"dropdown",title:"Align",options:{left:"Align Left",center:"None",right:"Align Right"},html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=ye.FE.COMMANDS.imageAlign.options;for(var a in t)t.hasOwnProperty(a)&&(e+='<li role="presentation"><a class="fr-command fr-title" tabIndex="-1" role="option" data-cmd="imageAlign" data-param1="'+a+'" title="'+this.language.translate(t[a])+'">'+this.icon.create("image-align-"+a)+'<span class="fr-sr-only">'+this.language.translate(t[a])+"</span></a></li>");return e+="</ul>"},callback:function(e,t){this.image.align(t)},refresh:function(e){this.image.refreshAlign(e)},refreshOnShow:function(e,t){this.image.refreshAlignOnShow(e,t)}}),ye.FE.DefineIcon("imageReplace",{NAME:"exchange",FA5NAME:"exchange-alt"}),ye.FE.RegisterCommand("imageReplace",{title:"Replace",undo:!1,focus:!1,popup:!0,refreshAfterCallback:!1,callback:function(){this.image.replace()}}),ye.FE.DefineIcon("imageRemove",{NAME:"trash"}),ye.FE.RegisterCommand("imageRemove",{title:"Remove",callback:function(){this.image.remove()}}),ye.FE.DefineIcon("imageBack",{NAME:"arrow-left"}),ye.FE.RegisterCommand("imageBack",{title:"Back",undo:!1,focus:!1,back:!0,callback:function(){this.image.back()},refresh:function(e){this.image.get()||this.opts.toolbarInline?(e.removeClass("fr-hidden"),e.next(".fr-separator").removeClass("fr-hidden")):(e.addClass("fr-hidden"),e.next(".fr-separator").addClass("fr-hidden"))}}),ye.FE.RegisterCommand("imageDismissError",{title:"OK",undo:!1,callback:function(){this.image.hideProgressBar(!0)}}),ye.FE.DefineIcon("imageStyle",{NAME:"magic"}),ye.FE.RegisterCommand("imageStyle",{title:"Style",type:"dropdown",html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=this.opts.imageStyles;for(var a in t)if(t.hasOwnProperty(a)){var i=t[a];"object"==typeof i&&(i=i.title),e+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="imageStyle" data-param1="'+a+'">'+this.language.translate(i)+"</a></li>"}return e+="</ul>"},callback:function(e,t){this.image.applyStyle(t)},refreshOnShow:function(e,t){var a=this.image.getEl();a&&t.find(".fr-command").each(function(){var e=ye(this).data("param1"),t=a.hasClass(e);ye(this).toggleClass("fr-active",t).attr("aria-selected",t)})}}),ye.FE.DefineIcon("imageAlt",{NAME:"info"}),ye.FE.RegisterCommand("imageAlt",{undo:!1,focus:!1,popup:!0,title:"Alternative Text",callback:function(){this.image.showAltPopup()}}),ye.FE.RegisterCommand("imageSetAlt",{undo:!0,focus:!1,title:"Update",refreshAfterCallback:!1,callback:function(){this.image.setAlt()}}),ye.FE.DefineIcon("imageSize",{NAME:"arrows-alt"}),ye.FE.RegisterCommand("imageSize",{undo:!1,focus:!1,popup:!0,title:"Change Size",callback:function(){this.image.showSizePopup()}}),ye.FE.RegisterCommand("imageSetSize",{undo:!0,focus:!1,title:"Update",refreshAfterCallback:!1,callback:function(){this.image.setSize()}}),ye.FE.DefineIcon("imageCaption",{NAME:"commenting",FA5NAME:"comment-alt"}),ye.FE.RegisterCommand("imageCaption",{undo:!0,focus:!1,title:"Image Caption",refreshAfterCallback:!0,callback:function(){this.image.toggleCaption()},refresh:function(e){this.image.get()&&e.toggleClass("fr-active",this.image.hasCaption())}})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof module&&module.exports?module.exports=function(e,a){return a===undefined&&(a="undefined"!=typeof window?require("jquery"):require("jquery")(e)),t(a)}:t(window.jQuery)}(function(O){if(O.extend(O.FE.DEFAULTS,{imageManagerLoadURL:"https://i.froala.com/load-files",imageManagerLoadMethod:"get",imageManagerLoadParams:{},imageManagerPreloader:null,imageManagerDeleteURL:"",imageManagerDeleteMethod:"post",imageManagerDeleteParams:{},imageManagerPageSize:12,imageManagerScrollOffset:20,imageManagerToggleTags:!0}),O.FE.PLUGINS.imageManager=function(o){var g,l,r,i,n,d,s,f,m,u,c,h="image_manager",e=10,p=11,v=12,M=13,w=14,b=15,C=21,L=22,t={};function y(){var e=O(window).outerWidth();return e<768?2:e<1200?3:4}function D(){n.empty();for(var e=0;e<c;e++)n.append('<div class="fr-list-column"></div>')}function I(){if(m<s.length&&(n.outerHeight()<=r.outerHeight()+o.opts.imageManagerScrollOffset||r.scrollTop()+o.opts.imageManagerScrollOffset>n.outerHeight()-r.outerHeight())){f++;for(var e=o.opts.imageManagerPageSize*(f-1);e<Math.min(s.length,o.opts.imageManagerPageSize*f);e++)a(s[e])}}function a(i){var n=new Image,s=O('<div class="fr-image-container fr-empty fr-image-'+u+++'" data-loading="'+o.language.translate("Loading")+'.." data-deleting="'+o.language.translate("Deleting")+'..">');T(!1),n.onload=function(){s.height(Math.floor(s.width()/n.width*n.height));var t=O("<img/>");if(i.thumb)t.attr("src",i.thumb);else{if(U(w,i),!i.url)return U(b,i),!1;t.attr("src",i.url)}if(i.url&&t.attr("data-url",i.url),i.tag)if(l.find(".fr-modal-more.fr-not-available").removeClass("fr-not-available"),l.find(".fr-modal-tags").show(),0<=i.tag.indexOf(",")){for(var e=i.tag.split(","),a=0;a<e.length;a++)e[a]=e[a].trim(),0===d.find('a[title="'+e[a]+'"]').length&&d.append('<a role="button" title="'+e[a]+'">'+e[a]+"</a>");t.attr("data-tag",e.join())}else 0===d.find('a[title="'+i.tag.trim()+'"]').length&&d.append('<a role="button" title="'+i.tag.trim()+'">'+i.tag.trim()+"</a>"),t.attr("data-tag",i.tag.trim());for(var r in i.name&&t.attr("alt",i.name),i)i.hasOwnProperty(r)&&"thumb"!=r&&"url"!=r&&"tag"!=r&&t.attr("data-"+r,i[r]);s.append(t).append(O(o.icon.create("imageManagerDelete")).addClass("fr-delete-img").attr("title",o.language.translate("Delete"))).append(O(o.icon.create("imageManagerInsert")).addClass("fr-insert-img").attr("title",o.language.translate("Insert"))),d.find(".fr-selected-tag").each(function(e,a){k(t,a.text)||s.hide()}),t.on("load",function(){s.removeClass("fr-empty"),s.height("auto"),m++,E(x(parseInt(t.parent().attr("class").match(/fr-image-(\d+)/)[1],10)+1)),T(!1),m%o.opts.imageManagerPageSize==0&&I()}),o.events.trigger("imageManager.imageLoaded",[t])},n.onerror=function(){m++,s.remove(),E(x(parseInt(s.attr("class").match(/fr-image-(\d+)/)[1],10)+1)),U(e,i),m%o.opts.imageManagerPageSize==0&&I()},n.src=i.thumb||i.url,P().append(s)}function P(){var r,i;return n.find(".fr-list-column").each(function(e,a){var t=O(a);0===e?(i=t.outerHeight(),r=t):t.outerHeight()<i&&(i=t.outerHeight(),r=t)}),r}function x(e){e===undefined&&(e=0);for(var a=[],t=u-1;e<=t;t--){var r=n.find(".fr-image-"+t);r.length&&(a.push(r),O('<div id="fr-image-hidden-container">').append(r),n.find(".fr-image-"+t).remove())}return a}function E(e){for(var a=e.length-1;0<=a;a--)P().append(e[a])}function T(e){if(e===undefined&&(e=!0),!g.is(":visible"))return!0;var a=y();if(a!=c){c=a;var t=x();D(),E(t)}o.modals.resize(h),e&&I()}function q(e){var a={},t=e.data();for(var r in t)t.hasOwnProperty(r)&&"url"!=r&&"tag"!=r&&(a[r]=t[r]);return a}function S(e){var a=O(e.currentTarget).siblings("img"),t=g.data("instance")||o,r=g.data("current-image");if(o.modals.hide(h),t.image.showProgressBar(),r)r.data("fr-old-src",r.attr("src")),r.trigger("click");else{t.events.focus(!0),t.selection.restore();var i=t.position.getBoundingRect(),n=i.left+i.width/2+O(o.doc).scrollLeft(),s=i.top+i.height+O(o.doc).scrollTop();t.popups.setContainer("image.insert",o.$sc),t.popups.show("image.insert",n,s)}t.image.insert(a.data("url"),!1,q(a),r)}function R(e){var t=O(e.currentTarget).siblings("img"),a=o.language.translate("Are you sure? Image will be deleted.");confirm(a)&&(o.opts.imageManagerDeleteURL?!1!==o.events.trigger("imageManager.beforeDeleteImage",[t])&&(t.parent().addClass("fr-image-deleting"),O.ajax({method:o.opts.imageManagerDeleteMethod,url:o.opts.imageManagerDeleteURL,data:O.extend(O.extend({src:t.attr("src")},q(t)),o.opts.imageManagerDeleteParams),crossDomain:o.opts.requestWithCORS,xhrFields:{withCredentials:o.opts.requestWithCredentials},headers:o.opts.requestHeaders}).done(function(e){o.events.trigger("imageManager.imageDeleted",[e]);var a=x(parseInt(t.parent().attr("class").match(/fr-image-(\d+)/)[1],10)+1);t.parent().remove(),E(a),g.find("#fr-modal-tags > a").each(function(){0===g.find('#fr-image-list [data-tag*="'+O(this).text()+'"]').length&&O(this).removeClass("fr-selected-tag").hide()}),H(),T(!0)}).fail(function(e){U(C,e.response||e.responseText)})):U(L))}function U(e,a){10<=e&&e<20?i.hide():20<=e&&e<30&&O(".fr-image-deleting").removeClass("fr-image-deleting"),o.events.trigger("imageManager.error",[{code:e,message:t[e]},a])}function F(){var e=l.find(".fr-modal-head-line").outerHeight(),a=d.outerHeight();l.toggleClass("fr-show-tags"),l.hasClass("fr-show-tags")?(l.css("height",e+a),d.find("a").css("opacity",1)):(l.css("height",e),d.find("a").css("opacity",0))}function H(){var e=d.find(".fr-selected-tag");0<e.length?(n.find("img").parent().show(),e.each(function(e,r){n.find("img").each(function(e,a){var t=O(a);k(t,r.text)||t.parent().hide()})})):n.find("img").parent().show(),E(x()),I()}function j(e){e.preventDefault();var a=O(e.currentTarget);a.toggleClass("fr-selected-tag"),o.opts.imageManagerToggleTags&&a.siblings("a").removeClass("fr-selected-tag"),H()}function k(e,a){for(var t=(e.attr("data-tag")||"").split(","),r=0;r<t.length;r++)if(t[r]==a)return!0;return!1}return t[e]="Image cannot be loaded from the passed link.",t[p]="Error during load images request.",t[v]="Missing imageManagerLoadURL option.",t[M]="Parsing load response failed.",t[w]="Missing image thumb.",t[b]="Missing image URL.",t[C]="Error during delete image request.",t[L]="Missing imageManagerDeleteURL option.",{require:["image"],_init:function(){if(!o.$wp&&"IMG"!=o.el.tagName)return!1},show:function(){if(!g){var e,a='<div class="fr-modal-head-line"><i class="fa fa-bars fr-modal-more fr-not-available" id="fr-modal-more-'+o.sid+'" title="'+o.language.translate("Tags")+'"></i><h4 data-text="true">'+o.language.translate("Manage Images")+"</h4></div>";a+='<div class="fr-modal-tags" id="fr-modal-tags"></div>',e=o.opts.imageManagerPreloader?'<img class="fr-preloader" id="fr-preloader" alt="'+o.language.translate("Loading")+'.." src="'+o.opts.imageManagerPreloader+'" style="display: none;">':'<span class="fr-preloader" id="fr-preloader" style="display: none;">'+o.language.translate("Loading")+"</span>",e+='<div class="fr-image-list" id="fr-image-list"></div>';var t=o.modals.create(h,a,e);g=t.$modal,l=t.$head,r=t.$body}g.data("current-image",o.image.get()),o.modals.show(h),i||(i=g.find("#fr-preloader"),n=g.find("#fr-image-list"),d=g.find("#fr-modal-tags"),c=y(),D(),l.css("height",l.find(".fr-modal-head-line").outerHeight()),o.events.$on(O(o.o_win),"resize",function(){T(!!s)}),o.helpers.isMobile()&&(o.events.bindClick(n,"div.fr-image-container",function(e){g.find(".fr-mobile-selected").removeClass("fr-mobile-selected"),O(e.currentTarget).addClass("fr-mobile-selected")}),g.on(o._mousedown,function(){g.find(".fr-mobile-selected").removeClass("fr-mobile-selected")})),o.events.bindClick(n,".fr-insert-img",S),o.events.bindClick(n,".fr-delete-img",R),g.on(o._mousedown+" "+o._mouseup,function(e){e.stopPropagation()}),g.on(o._mousedown,"*",function(){o.events.disableBlur()}),r.on("scroll",I),o.events.bindClick(g,"i#fr-modal-more-"+o.sid,F),o.events.bindClick(d,"a",j)),i.show(),n.find(".fr-list-column").empty(),o.opts.imageManagerLoadURL?O.ajax({url:o.opts.imageManagerLoadURL,method:o.opts.imageManagerLoadMethod,data:o.opts.imageManagerLoadParams,dataType:"json",crossDomain:o.opts.requestWithCORS,xhrFields:{withCredentials:o.opts.requestWithCredentials},headers:o.opts.requestHeaders}).done(function(e,a,t){o.events.trigger("imageManager.imagesLoaded",[e]),function(e,a){try{n.find(".fr-list-column").empty(),u=m=f=0,s=e,I()}catch(t){U(M,a)}}(e,t.response),i.hide()}).fail(function(){var e=this.xhr();U(p,e.response||e.responseText)}):U(v)},hide:function(){o.modals.hide(h)}}},!O.FE.PLUGINS.image)throw new Error("Image manager plugin requires image plugin.");O.FE.DEFAULTS.imageInsertButtons.push("imageManager"),O.FE.RegisterCommand("imageManager",{title:"Browse",undo:!1,focus:!1,modal:!0,callback:function(){this.imageManager.show()},plugin:"imageManager"}),O.FE.DefineIcon("imageManager",{NAME:"folder"}),O.FE.DefineIcon("imageManagerInsert",{NAME:"plus"}),O.FE.DefineIcon("imageManagerDelete",{NAME:"trash"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof module&&module.exports?module.exports=function(e,n){return n===undefined&&(n="undefined"!=typeof window?require("jquery"):require("jquery")(e)),t(n)}:t(window.jQuery)}(function(r){r.extend(r.FE.DEFAULTS,{inlineStyles:{"Big Red":"font-size: 20px; color: red;","Small Blue":"font-size: 14px; color: blue;"}}),r.FE.PLUGINS.inlineStyle=function(l){return{apply:function(e){if(""!==l.selection.text())for(var n=e.split(";"),t=0;t<n.length;t++){var i=n[t].split(":");n[t].length&&2==i.length&&l.format.applyStyle(i[0].trim(),i[1].trim())}else l.html.insert('<span style="'+e+'">'+r.FE.INVISIBLE_SPACE+r.FE.MARKERS+"</span>")}}},r.FE.RegisterCommand("inlineStyle",{type:"dropdown",html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',n=this.opts.inlineStyles;for(var t in n)n.hasOwnProperty(t)&&(e+='<li role="presentation"><span style="'+n[t]+'" role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="inlineStyle" data-param1="'+n[t]+'" title="'+this.language.translate(t)+'">'+this.language.translate(t)+"</a></span></li>");return e+="</ul>"},title:"Inline Style",callback:function(e,n){this.inlineStyle.apply(n)},plugin:"inlineStyle"}),r.FE.DefineIcon("inlineStyle",{NAME:"paint-brush"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(v){v.extend(v.FE.DEFAULTS,{lineBreakerTags:["table","hr","form","dl","span.fr-video",".fr-embedly"],lineBreakerOffset:15,lineBreakerHorizontalOffset:10}),v.FE.PLUGINS.lineBreaker=function(d){var g,t,a;function s(e,t){var n,r,a,o,i,s,f,l;if(null==e)i=(o=t.parent()).offset().top,n=(f=t.offset().top)-Math.min((f-i)/2,d.opts.lineBreakerOffset),a=o.outerWidth(),r=o.offset().left;else if(null==t)(s=(o=e.parent()).offset().top+o.outerHeight())<(l=e.offset().top+e.outerHeight())&&(s=(o=v(o).parent()).offset().top+o.outerHeight()),n=l+Math.min(Math.abs(s-l)/2,d.opts.lineBreakerOffset),a=o.outerWidth(),r=o.offset().left;else{o=e.parent();var p=e.offset().top+e.height(),u=t.offset().top;if(u<p)return!1;n=(p+u)/2,a=o.outerWidth(),r=o.offset().left}d.opts.iframe&&(r+=d.$iframe.offset().left-d.helpers.scrollLeft(),n+=d.$iframe.offset().top-d.helpers.scrollTop()),d.$box.append(g),g.css("top",n-d.win.pageYOffset),g.css("left",r-d.win.pageXOffset),g.css("width",a),g.data("tag1",e),g.data("tag2",t),g.addClass("fr-visible").data("instance",d)}function f(e){if(e){var t=v(e);if(0===d.$el.find(t).length)return null;if(e.nodeType!=Node.TEXT_NODE&&t.is(d.opts.lineBreakerTags.join(",")))return t;if(0<t.parents(d.opts.lineBreakerTags.join(",")).length)return e=t.parents(d.opts.lineBreakerTags.join(",")).get(0),0!==d.$el.find(e).length&&v(e).is(d.opts.lineBreakerTags.join(","))?v(e):null}return null}function o(e,t){var n=d.doc.elementFromPoint(e,t);return n&&!v(n).closest(".fr-line-breaker").length&&!d.node.isElement(n)&&n!=d.$wp.get(0)&&function(e){if("undefined"!=typeof e.inFroalaWrapper)return e.inFroalaWrapper;for(var t=e;e.parentNode&&e.parentNode!==d.$wp.get(0);)e=e.parentNode;return t.inFroalaWrapper=e.parentNode==d.$wp.get(0),t.inFroalaWrapper}(n)?n:null}function i(e,t,n){for(var r=n,a=null;r<=d.opts.lineBreakerOffset&&!a;)(a=o(e,t-r))||(a=o(e,t+r)),r+=n;return a}function l(e,t,n){for(var r=null,a=100;!r&&e>d.$box.offset().left&&e<d.$box.offset().left+d.$box.outerWidth()&&0<a;)(r=o(e,t))||(r=i(e,t,5)),"left"==n?e-=d.opts.lineBreakerHorizontalOffset:e+=d.opts.lineBreakerHorizontalOffset,a-=d.opts.lineBreakerHorizontalOffset;return r}function n(e){var t=a=null,n=null,r=d.doc.elementFromPoint(e.pageX-d.win.pageXOffset,e.pageY-d.win.pageYOffset);r&&("HTML"==r.tagName||"BODY"==r.tagName||d.node.isElement(r)||0<=(r.getAttribute("class")||"").indexOf("fr-line-breaker"))?((n=i(e.pageX-d.win.pageXOffset,e.pageY-d.win.pageYOffset,1))||(n=l(e.pageX-d.win.pageXOffset-d.opts.lineBreakerHorizontalOffset,e.pageY-d.win.pageYOffset,"left")),n||(n=l(e.pageX-d.win.pageXOffset+d.opts.lineBreakerHorizontalOffset,e.pageY-d.win.pageYOffset,"right")),t=f(n)):t=f(r),t?function(e,t){var n,r,a=e.offset().top,o=e.offset().top+e.outerHeight();if(Math.abs(o-t)<=d.opts.lineBreakerOffset||Math.abs(t-a)<=d.opts.lineBreakerOffset)if(Math.abs(o-t)<Math.abs(t-a)){for(var i=(r=e.get(0)).nextSibling;i&&i.nodeType==Node.TEXT_NODE&&0===i.textContent.length;)i=i.nextSibling;if(!i)return s(e,null);if(n=f(i))return s(e,n)}else{if(!(r=e.get(0)).previousSibling)return s(null,e);if(n=f(r.previousSibling))return s(n,e)}g.removeClass("fr-visible").removeData("instance")}(t,e.pageY):d.core.sameInstance(g)&&g.removeClass("fr-visible").removeData("instance")}function e(e){return!(g.hasClass("fr-visible")&&!d.core.sameInstance(g))&&(d.popups.areVisible()||d.el.querySelector(".fr-selected-cell")?(g.removeClass("fr-visible"),!0):void(!1!==t||d.edit.isDisabled()||(a&&clearTimeout(a),a=setTimeout(n,30,e))))}function r(){a&&clearTimeout(a),g.hasClass("fr-visible")&&g.removeClass("fr-visible").removeData("instance")}function p(){t=!0,r()}function u(){t=!1}function c(e){e.preventDefault();var t=g.data("instance")||d;g.removeClass("fr-visible").removeData("instance");var n=g.data("tag1"),r=g.data("tag2"),a=d.html.defaultTag();null==n?a&&"TD"!=r.parent().get(0).tagName&&0===r.parents(a).length?r.before("<"+a+">"+v.FE.MARKERS+"<br></"+a+">"):r.before(v.FE.MARKERS+"<br>"):a&&"TD"!=n.parent().get(0).tagName&&0===n.parents(a).length?n.after("<"+a+">"+v.FE.MARKERS+"<br></"+a+">"):n.after(v.FE.MARKERS+"<br>"),t.selection.restore()}return{_init:function(){if(!d.$wp)return!1;d.shared.$line_breaker||(d.shared.$line_breaker=v('<div class="fr-line-breaker"><a class="fr-floating-btn" role="button" tabIndex="-1" title="'+d.language.translate("Break")+'"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><rect x="21" y="11" width="2" height="8"/><rect x="14" y="17" width="7" height="2"/><path d="M14.000,14.000 L14.000,22.013 L9.000,18.031 L14.000,14.000 Z"/></svg></a></div>')),g=d.shared.$line_breaker,d.events.on("shared.destroy",function(){g.html("").removeData().remove(),g=null},!0),d.events.on("destroy",function(){g.removeData("instance").removeClass("fr-visible").appendTo("body:first"),clearTimeout(a)},!0),d.events.$on(g,"mousemove",function(e){e.stopPropagation()},!0),d.events.bindClick(g,"a",c),t=!1,d.events.$on(d.$win,"mousemove",e),d.events.$on(v(d.win),"scroll",r),d.events.on("popups.show.table.edit",r),d.events.on("commands.after",r),d.events.$on(v(d.win),"mousedown",p),d.events.$on(v(d.win),"mouseup",u)}}}});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(m){m.extend(m.FE.POPUP_TEMPLATES,{"link.edit":"[_BUTTONS_]","link.insert":"[_BUTTONS_][_INPUT_LAYER_]"}),m.extend(m.FE.DEFAULTS,{linkEditButtons:["linkOpen","linkStyle","linkEdit","linkRemove"],linkInsertButtons:["linkBack","|","linkList"],linkAttributes:{},linkAutoPrefix:"http://",linkStyles:{"fr-green":"Green","fr-strong":"Thick"},linkMultipleStyles:!0,linkConvertEmailAddress:!0,linkAlwaysBlank:!1,linkAlwaysNoFollow:!1,linkNoOpener:!0,linkNoReferrer:!0,linkList:[{text:"Froala",href:"https://froala.com",target:"_blank"},{text:"Google",href:"https://google.com",target:"_blank"},{displayText:"Facebook",href:"https://facebook.com"}],linkText:!0}),m.FE.PLUGINS.link=function(d){function c(){var e=d.image?d.image.get():null;if(!e&&d.$wp){var t=d.selection.ranges(0).commonAncestorContainer;try{t&&(t.contains&&t.contains(d.el)||!d.el.contains(t)||d.el==t)&&(t=null)}catch(r){t=null}if(t&&"A"===t.tagName)return t;var n=d.selection.element(),i=d.selection.endElement();"A"==n.tagName||d.node.isElement(n)||(n=m(n).parentsUntil(d.$el,"a:first").get(0)),"A"==i.tagName||d.node.isElement(i)||(i=m(i).parentsUntil(d.$el,"a:first").get(0));try{i&&(i.contains&&i.contains(d.el)||!d.el.contains(i)||d.el==i)&&(i=null)}catch(r){i=null}try{n&&(n.contains&&n.contains(d.el)||!d.el.contains(n)||d.el==n)&&(n=null)}catch(r){n=null}return i&&i==n&&"A"==i.tagName?(d.browser.msie||d.helpers.isMobile())&&(d.selection.info(n).atEnd||d.selection.info(n).atStart)?null:n:null}return"A"==d.el.tagName?d.el:e&&e.get(0).parentNode&&"A"==e.get(0).parentNode.tagName?e.get(0).parentNode:void 0}function u(){var e,t,n,i,r=d.image?d.image.get():null,l=[];if(r)"A"==r.get(0).parentNode.tagName&&l.push(r.get(0).parentNode);else if(d.win.getSelection){var a=d.win.getSelection();if(a.getRangeAt&&a.rangeCount){i=d.doc.createRange();for(var s=0;s<a.rangeCount;++s)if((t=(e=a.getRangeAt(s)).commonAncestorContainer)&&1!=t.nodeType&&(t=t.parentNode),t&&"a"==t.nodeName.toLowerCase())l.push(t);else{n=t.getElementsByTagName("a");for(var o=0;o<n.length;++o)i.selectNodeContents(n[o]),i.compareBoundaryPoints(e.END_TO_START,e)<1&&-1<i.compareBoundaryPoints(e.START_TO_END,e)&&l.push(n[o])}}}else if(d.doc.selection&&"Control"!=d.doc.selection.type)if("a"==(t=(e=d.doc.selection.createRange()).parentElement()).nodeName.toLowerCase())l.push(t);else{n=t.getElementsByTagName("a"),i=d.doc.body.createTextRange();for(var p=0;p<n.length;++p)i.moveToElementText(n[p]),-1<i.compareEndPoints("StartToEnd",e)&&i.compareEndPoints("EndToStart",e)<1&&l.push(n[p])}return l}function k(r){if(d.core.hasFocus()){if(a(),r&&"keyup"===r.type&&(r.altKey||r.which==m.FE.KEYCODE.ALT))return!0;setTimeout(function(){if(!r||r&&(1==r.which||"mouseup"!=r.type)){var e=c(),t=d.image?d.image.get():null;if(e&&!t){if(d.image){var n=d.node.contents(e);if(1==n.length&&"IMG"==n[0].tagName){var i=d.selection.ranges(0);return 0===i.startOffset&&0===i.endOffset?m(e).before(m.FE.MARKERS):m(e).after(m.FE.MARKERS),d.selection.restore(),!1}}r&&r.stopPropagation(),l(e)}}},d.helpers.isIOS()?100:0)}}function l(e){var t=d.popups.get("link.edit");t||(t=function(){var e="";1<=d.opts.linkEditButtons.length&&("A"==d.el.tagName&&0<=d.opts.linkEditButtons.indexOf("linkRemove")&&d.opts.linkEditButtons.splice(d.opts.linkEditButtons.indexOf("linkRemove"),1),e='<div class="fr-buttons">'+d.button.buildList(d.opts.linkEditButtons)+"</div>");var t={buttons:e},n=d.popups.create("link.edit",t);d.$wp&&d.events.$on(d.$wp,"scroll.link-edit",function(){c()&&d.popups.isVisible("link.edit")&&l(c())});return n}());var n=m(e);d.popups.isVisible("link.edit")||d.popups.refresh("link.edit"),d.popups.setContainer("link.edit",d.$sc);var i=n.offset().left+m(e).outerWidth()/2,r=n.offset().top+n.outerHeight();d.popups.show("link.edit",i,r,n.outerHeight())}function a(){d.popups.hide("link.edit")}function o(){}function p(){var e=d.popups.get("link.insert"),t=c();if(t){var n,i,r=m(t),l=e.find('input.fr-link-attr[type="text"]'),a=e.find('input.fr-link-attr[type="checkbox"]');for(n=0;n<l.length;n++)(i=m(l[n])).val(r.attr(i.attr("name")||""));for(a.prop("checked",!1),n=0;n<a.length;n++)i=m(a[n]),r.attr(i.attr("name"))==i.data("checked")&&i.prop("checked",!0);e.find('input.fr-link-attr[type="text"][name="text"]').val(r.text())}else e.find('input.fr-link-attr[type="text"]').val(""),e.find('input.fr-link-attr[type="checkbox"]').prop("checked",!1),e.find('input.fr-link-attr[type="text"][name="text"]').val(d.selection.text());e.find("input.fr-link-attr").trigger("change"),(d.image?d.image.get():null)?e.find('.fr-link-attr[name="text"]').parent().hide():e.find('.fr-link-attr[name="text"]').parent().show()}function s(e){if(e)return d.popups.onRefresh("link.insert",p),d.popups.onHide("link.insert",o),!0;var t="";1<=d.opts.linkInsertButtons.length&&(t='<div class="fr-buttons">'+d.button.buildList(d.opts.linkInsertButtons)+"</div>");var n="",i=0;for(var r in n='<div class="fr-link-insert-layer fr-layer fr-active" id="fr-link-insert-layer-'+d.id+'">',n+='<div class="fr-input-line"><input id="fr-link-insert-layer-url-'+d.id+'" name="href" type="text" class="fr-link-attr" placeholder="'+d.language.translate("URL")+'" tabIndex="'+ ++i+'"></div>',d.opts.linkText&&(n+='<div class="fr-input-line"><input id="fr-link-insert-layer-text-'+d.id+'" name="text" type="text" class="fr-link-attr" placeholder="'+d.language.translate("Text")+'" tabIndex="'+ ++i+'"></div>'),d.opts.linkAttributes)if(d.opts.linkAttributes.hasOwnProperty(r)){var l=d.opts.linkAttributes[r];n+='<div class="fr-input-line"><input name="'+r+'" type="text" class="fr-link-attr" placeholder="'+d.language.translate(l)+'" tabIndex="'+ ++i+'"></div>'}d.opts.linkAlwaysBlank||(n+='<div class="fr-checkbox-line"><span class="fr-checkbox"><input name="target" class="fr-link-attr" data-checked="_blank" type="checkbox" id="fr-link-target-'+d.id+'" tabIndex="'+ ++i+'"><span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10" height="10" viewBox="0 0 32 32"><path d="M27 4l-15 15-7-7-5 5 12 12 20-20z" fill="#FFF"></path></svg></span></span><label for="fr-link-target-'+d.id+'">'+d.language.translate("Open in new tab")+"</label></div>");var a={buttons:t,input_layer:n+='<div class="fr-action-buttons"><button class="fr-command fr-submit" role="button" data-cmd="linkInsert" href="#" tabIndex="'+ ++i+'" type="button">'+d.language.translate("Insert")+"</button></div></div>"},s=d.popups.create("link.insert",a);return d.$wp&&d.events.$on(d.$wp,"scroll.link-insert",function(){(d.image?d.image.get():null)&&d.popups.isVisible("link.insert")&&h(),d.popups.isVisible("link.insert")&&g()}),s}function f(e,t,n){if(void 0===n&&(n={}),!1===d.events.trigger("link.beforeInsert",[e,t,n]))return!1;var i=d.image?d.image.get():null;i||"A"==d.el.tagName?"A"==d.el.tagName&&d.$el.focus():(d.selection.restore(),d.popups.hide("link.insert"));var r=e;d.opts.linkConvertEmailAddress&&d.helpers.isEmail(e)&&!/^mailto:.*/i.test(e)&&(e="mailto:"+e);if(""===d.opts.linkAutoPrefix||new RegExp("^("+m.FE.LinkProtocols.join("|")+"):.","i").test(e)||/^data:image.*/i.test(e)||/^(https?:|ftps?:|file:|)\/\//i.test(e)||/^([A-Za-z]:(\\){1,2}|[A-Za-z]:((\\){1,2}[^\\]+)+)(\\)?$/i.test(e)||["/","{","[","#","(","."].indexOf((e||"")[0])<0&&(e=d.opts.linkAutoPrefix+d.helpers.sanitizeURL(e)),e=d.helpers.sanitizeURL(e),d.opts.linkAlwaysBlank&&(n.target="_blank"),d.opts.linkAlwaysNoFollow&&(n.rel="nofollow"),"_blank"==n.target?(d.opts.linkNoOpener&&(n.rel?n.rel+=" noopener":n.rel="noopener"),d.opts.linkNoReferrer&&(n.rel?n.rel+=" noreferrer":n.rel="noreferrer")):null==n.target&&(n.rel?n.rel=n.rel.replace(/noopener/,"").replace(/noreferrer/,""):n.rel=null),t=t||"",e===d.opts.linkAutoPrefix)return d.popups.get("link.insert").find('input[name="href"]').addClass("fr-error"),d.events.trigger("link.bad",[r]),!1;var l,a=c();if(a){if((l=m(a)).attr("href",e),0<t.length&&l.text()!=t&&!i){for(var s=l.get(0);1===s.childNodes.length&&s.childNodes[0].nodeType==Node.ELEMENT_NODE;)s=s.childNodes[0];m(s).text(t)}i||l.prepend(m.FE.START_MARKER).append(m.FE.END_MARKER),l.attr(n),i||d.selection.restore()}else{i?i.wrap('<a href="'+e+'"></a>'):(d.format.remove("a"),d.selection.isCollapsed()?(t=0===t.length?r:t,d.html.insert('<a href="'+e+'">'+m.FE.START_MARKER+t.replace(/&/g,"&amp;")+m.FE.END_MARKER+"</a>"),d.selection.restore()):0<t.length&&t!=d.selection.text().replace(/\n/g,"")?(d.selection.remove(),d.html.insert('<a href="'+e+'">'+m.FE.START_MARKER+t.replace(/&/g,"&amp;")+m.FE.END_MARKER+"</a>"),d.selection.restore()):(!function(){if(!d.selection.isCollapsed()){d.selection.save();for(var e=d.$el.find(".fr-marker").addClass("fr-unprocessed").toArray();e.length;){var t=m(e.pop());t.removeClass("fr-unprocessed");var n=d.node.deepestParent(t.get(0));if(n){for(var i=t.get(0),r="",l="";i=i.parentNode,d.node.isBlock(i)||(r+=d.node.closeTagString(i),l=d.node.openTagString(i)+l),i!=n;);var a=d.node.openTagString(t.get(0))+t.html()+d.node.closeTagString(t.get(0));t.replaceWith('<span id="fr-break"></span>');var s=n.outerHTML;s=s.replace(/<span id="fr-break"><\/span>/g,r+a+l),n.outerHTML=s}e=d.$el.find(".fr-marker.fr-unprocessed").toArray()}d.html.cleanEmptyTags(),d.selection.restore()}}(),d.format.apply("a",{href:e})));for(var o=u(),p=0;p<o.length;p++)(l=m(o[p])).attr(n),l.removeAttr("_moz_dirty");1==o.length&&d.$wp&&!i&&(m(o[0]).prepend(m.FE.START_MARKER).append(m.FE.END_MARKER),d.selection.restore())}if(i){var f=d.popups.get("link.insert");f&&f.find("input:focus").blur(),d.image.edit(i)}else k()}function g(){a();var e=c();if(e){var t=d.popups.get("link.insert");t||(t=s()),d.popups.isVisible("link.insert")||(d.popups.refresh("link.insert"),d.selection.save(),d.helpers.isMobile()&&(d.events.disableBlur(),d.$el.blur(),d.events.enableBlur())),d.popups.setContainer("link.insert",d.$sc);var n=(d.image?d.image.get():null)||m(e),i=n.offset().left+n.outerWidth()/2,r=n.offset().top+n.outerHeight();d.popups.show("link.insert",i,r,n.outerHeight())}}function h(){var e=d.image?d.image.getEl():null;if(e){var t=d.popups.get("link.insert");d.image.hasCaption()&&(e=e.find(".fr-img-wrap")),t||(t=s()),p(),d.popups.setContainer("link.insert",d.$sc);var n=e.offset().left+e.outerWidth()/2,i=e.offset().top+e.outerHeight();d.popups.show("link.insert",n,i,e.outerHeight())}}return{_init:function(){d.events.on("keyup",function(e){e.which!=m.FE.KEYCODE.ESC&&k(e)}),d.events.on("window.mouseup",k),d.events.$on(d.$el,"click","a",function(e){d.edit.isDisabled()&&e.preventDefault()}),d.helpers.isMobile()&&d.events.$on(d.$doc,"selectionchange",k),s(!0),"A"==d.el.tagName&&d.$el.addClass("fr-view"),d.events.on("toolbar.esc",function(){if(d.popups.isVisible("link.edit"))return d.events.disableBlur(),d.events.focus(),!1},!0)},remove:function(){var e=c(),t=d.image?d.image.get():null;if(!1===d.events.trigger("link.beforeRemove",[e]))return!1;t&&e?(t.unwrap(),d.image.edit(t)):e&&(d.selection.save(),m(e).replaceWith(m(e).html()),d.selection.restore(),a())},showInsertPopup:function(){var e=d.$tb.find('.fr-command[data-cmd="insertLink"]'),t=d.popups.get("link.insert");if(t||(t=s()),!t.hasClass("fr-active"))if(d.popups.refresh("link.insert"),d.popups.setContainer("link.insert",d.$tb||d.$sc),e.is(":visible")){var n=e.offset().left+e.outerWidth()/2,i=e.offset().top+(d.opts.toolbarBottom?10:e.outerHeight()-10);d.popups.show("link.insert",n,i,e.outerHeight())}else d.position.forSelection(t),d.popups.show("link.insert")},usePredefined:function(e){var t,n,i=d.opts.linkList[e],r=d.popups.get("link.insert"),l=r.find('input.fr-link-attr[type="text"]'),a=r.find('input.fr-link-attr[type="checkbox"]');for(n=0;n<l.length;n++)i[(t=m(l[n])).attr("name")]?t.val(i[t.attr("name")]):"text"!=t.attr("name")&&t.val("");for(n=0;n<a.length;n++)(t=m(a[n])).prop("checked",t.data("checked")==i[t.attr("name")]);d.accessibility.focusPopup(r)},insertCallback:function(){var e,t,n=d.popups.get("link.insert"),i=n.find('input.fr-link-attr[type="text"]'),r=n.find('input.fr-link-attr[type="checkbox"]'),l=(i.filter('[name="href"]').val()||"").trim(),a=i.filter('[name="text"]').val(),s={};for(t=0;t<i.length;t++)e=m(i[t]),["href","text"].indexOf(e.attr("name"))<0&&(s[e.attr("name")]=e.val());for(t=0;t<r.length;t++)(e=m(r[t])).is(":checked")?s[e.attr("name")]=e.data("checked"):s[e.attr("name")]=e.data("unchecked")||null;var o=d.helpers.scrollTop();f(l,a,s),m(d.o_win).scrollTop(o)},insert:f,update:g,get:c,allSelected:u,back:function(){d.image&&d.image.get()?d.image.back():(d.events.disableBlur(),d.selection.restore(),d.events.enableBlur(),c()&&d.$wp?(d.selection.restore(),a(),k()):"A"==d.el.tagName?(d.$el.focus(),k()):(d.popups.hide("link.insert"),d.toolbar.showInline()))},imageLink:h,applyStyle:function(e,t,n){void 0===n&&(n=d.opts.linkMultipleStyles),void 0===t&&(t=d.opts.linkStyles);var i=c();if(!i)return!1;if(!n){var r=Object.keys(t);r.splice(r.indexOf(e),1),m(i).removeClass(r.join(" "))}m(i).toggleClass(e),k()}}},m.FE.DefineIcon("insertLink",{NAME:"link"}),m.FE.RegisterShortcut(m.FE.KEYCODE.K,"insertLink",null,"K"),m.FE.RegisterCommand("insertLink",{title:"Insert Link",undo:!1,focus:!0,refreshOnCallback:!1,popup:!0,callback:function(){this.popups.isVisible("link.insert")?(this.$el.find(".fr-marker").length&&(this.events.disableBlur(),this.selection.restore()),this.popups.hide("link.insert")):this.link.showInsertPopup()},plugin:"link"}),m.FE.DefineIcon("linkOpen",{NAME:"external-link",FA5NAME:"external-link-alt"}),m.FE.RegisterCommand("linkOpen",{title:"Open Link",undo:!1,refresh:function(e){this.link.get()?e.removeClass("fr-hidden"):e.addClass("fr-hidden")},callback:function(){var e=this.link.get();e&&(this.o_win.open(e.href,"_blank","noopener"),this.popups.hide("link.edit"))},plugin:"link"}),m.FE.DefineIcon("linkEdit",{NAME:"edit"}),m.FE.RegisterCommand("linkEdit",{title:"Edit Link",undo:!1,refreshAfterCallback:!1,popup:!0,callback:function(){this.link.update()},refresh:function(e){this.link.get()?e.removeClass("fr-hidden"):e.addClass("fr-hidden")},plugin:"link"}),m.FE.DefineIcon("linkRemove",{NAME:"unlink"}),m.FE.RegisterCommand("linkRemove",{title:"Unlink",callback:function(){this.link.remove()},refresh:function(e){this.link.get()?e.removeClass("fr-hidden"):e.addClass("fr-hidden")},plugin:"link"}),m.FE.DefineIcon("linkBack",{NAME:"arrow-left"}),m.FE.RegisterCommand("linkBack",{title:"Back",undo:!1,focus:!1,back:!0,refreshAfterCallback:!1,callback:function(){this.link.back()},refresh:function(e){var t=this.link.get()&&this.doc.hasFocus();(this.image?this.image.get():null)||t||this.opts.toolbarInline?(e.removeClass("fr-hidden"),e.next(".fr-separator").removeClass("fr-hidden")):(e.addClass("fr-hidden"),e.next(".fr-separator").addClass("fr-hidden"))},plugin:"link"}),m.FE.DefineIcon("linkList",{NAME:"search"}),m.FE.RegisterCommand("linkList",{title:"Choose Link",type:"dropdown",focus:!1,undo:!1,refreshAfterCallback:!1,html:function(){for(var e='<ul class="fr-dropdown-list" role="presentation">',t=this.opts.linkList,n=0;n<t.length;n++)e+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="linkList" data-param1="'+n+'">'+(t[n].displayText||t[n].text)+"</a></li>";return e+="</ul>"},callback:function(e,t){this.link.usePredefined(t)},plugin:"link"}),m.FE.RegisterCommand("linkInsert",{focus:!1,refreshAfterCallback:!1,callback:function(){this.link.insertCallback()},refresh:function(e){this.link.get()?e.text(this.language.translate("Update")):e.text(this.language.translate("Insert"))},plugin:"link"}),m.FE.DefineIcon("imageLink",{NAME:"link"}),m.FE.RegisterCommand("imageLink",{title:"Insert Link",undo:!1,focus:!1,popup:!0,callback:function(){this.link.imageLink()},refresh:function(e){var t;this.link.get()?((t=e.prev()).hasClass("fr-separator")&&t.removeClass("fr-hidden"),e.addClass("fr-hidden")):((t=e.prev()).hasClass("fr-separator")&&t.addClass("fr-hidden"),e.removeClass("fr-hidden"))},plugin:"link"}),m.FE.DefineIcon("linkStyle",{NAME:"magic"}),m.FE.RegisterCommand("linkStyle",{title:"Style",type:"dropdown",html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=this.opts.linkStyles;for(var n in t)t.hasOwnProperty(n)&&(e+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="linkStyle" data-param1="'+n+'">'+this.language.translate(t[n])+"</a></li>");return e+="</ul>"},callback:function(e,t){this.link.applyStyle(t)},refreshOnShow:function(e,t){var n=this.link.get();if(n){var i=m(n);t.find(".fr-command").each(function(){var e=m(this).data("param1"),t=i.hasClass(e);m(this).toggleClass("fr-active",t).attr("aria-selected",t)})}},refresh:function(e){this.link.get()?e.removeClass("fr-hidden"):e.addClass("fr-hidden")},plugin:"link"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(m){m.FE.PLUGINS.lists=function(d){function g(e){return'<span class="fr-open-'+e.toLowerCase()+'"></span>'}function c(e){return'<span class="fr-close-'+e.toLowerCase()+'"></span>'}function a(e,t){!function(e,t){for(var n=[],a=0;a<e.length;a++){var r=e[a].parentNode;"LI"==e[a].tagName&&r.tagName!=t&&n.indexOf(r)<0&&n.push(r)}for(a=n.length-1;0<=a;a--){var i=m(n[a]);i.replaceWith("<"+t.toLowerCase()+" "+d.node.attributes(i.get(0))+">"+i.html()+"</"+t.toLowerCase()+">")}}(e,t);var n,a=d.html.defaultTag(),r=null;e.length&&(n="rtl"==d.opts.direction||"rtl"==m(e[0]).css("direction")?"margin-right":"margin-left");for(var i=0;i<e.length;i++)if("LI"!=e[i].tagName){var o=d.helpers.getPX(m(e[i]).css(n))||0;(e[i].style.marginLeft=null)===r&&(r=o);var l=0<r?"<"+t+' style="'+n+": "+r+'px;">':"<"+t+">",s="</"+t+">";for(o-=r;0<o/d.opts.indentMargin;)l+="<"+t+">",s+=s,o-=d.opts.indentMargin;a&&e[i].tagName.toLowerCase()==a?m(e[i]).replaceWith(l+"<li"+d.node.attributes(e[i])+">"+m(e[i]).html()+"</li>"+s):m(e[i]).wrap(l+"<li></li>"+s)}d.clean.lists()}function r(e){var t,n;for(t=e.length-1;0<=t;t--)for(n=t-1;0<=n;n--)if(m(e[n]).find(e[t]).length||e[n]==e[t]){e.splice(t,1);break}var a=[];for(t=0;t<e.length;t++){var r=m(e[t]),i=e[t].parentNode,o=r.attr("class");if(r.before(c(i.tagName)),"LI"==i.parentNode.tagName)r.before(c("LI")),r.after(g("LI"));else{var l="";o&&(l+=' class="'+o+'"');var s="rtl"==d.opts.direction||"rtl"==r.css("direction")?"margin-right":"margin-left";d.helpers.getPX(m(i).css(s))&&0<=(m(i).attr("style")||"").indexOf(s+":")&&(l+=' style="'+s+":"+d.helpers.getPX(m(i).css(s))+'px;"'),d.html.defaultTag()&&0===r.find(d.html.blockTagsQuery()).length&&r.wrapInner("<"+d.html.defaultTag()+l+"></"+d.html.defaultTag()+">"),d.node.isEmpty(r.get(0),!0)||0!==r.find(d.html.blockTagsQuery()).length||r.append("<br>"),r.append(g("LI")),r.prepend(c("LI"))}r.after(g(i.tagName)),"LI"==i.parentNode.tagName&&(i=i.parentNode.parentNode),a.indexOf(i)<0&&a.push(i)}for(t=0;t<a.length;t++){var f=m(a[t]),p=f.html();p=(p=p.replace(/<span class="fr-close-([a-z]*)"><\/span>/g,"</$1>")).replace(/<span class="fr-open-([a-z]*)"><\/span>/g,"<$1>"),f.replaceWith(d.node.openTagString(f.get(0))+p+d.node.closeTagString(f.get(0)))}d.$el.find("li:empty").remove(),d.$el.find("ul:empty, ol:empty").remove(),d.clean.lists(),d.html.wrap()}function i(e){d.selection.save();for(var t=0;t<e.length;t++){var n=e[t].previousSibling;if(n){var a=m(e[t]).find("> ul, > ol").last().get(0);if(a){for(var r=m("<li>").prependTo(m(a)),i=d.node.contents(e[t])[0];i&&!d.node.isList(i);){var o=i.nextSibling;r.append(i),i=o}m(n).append(m(a)),m(e[t]).remove()}else{var l=m(n).find("> ul, > ol").last().get(0);if(l)m(l).append(m(e[t]));else{var s=m("<"+e[t].parentNode.tagName+">");m(n).append(s),s.append(m(e[t]))}}}}d.clean.lists(),d.selection.restore()}function o(e){d.selection.save(),r(e),d.selection.restore()}function e(e){if("indent"==e||"outdent"==e){for(var t=!1,n=d.selection.blocks(),a=[],r=0;r<n.length;r++)"LI"==n[r].tagName?(t=!0,a.push(n[r])):"LI"==n[r].parentNode.tagName&&(t=!0,a.push(n[r].parentNode));t&&("indent"==e?i(a):o(a))}}return{_init:function(){d.events.on("commands.after",e),d.events.on("keydown",function(e){if(e.which==m.FE.KEYCODE.TAB){for(var t=d.selection.blocks(),n=[],a=0;a<t.length;a++)"LI"==t[a].tagName?n.push(t[a]):"LI"==t[a].parentNode.tagName&&n.push(t[a].parentNode);if(1<n.length||n.length&&(d.selection.info(n[0]).atStart||d.node.isEmpty(n[0])))return e.preventDefault(),e.stopPropagation(),e.shiftKey?o(n):i(n),!1}},!0)},format:function(e){d.selection.save(),d.html.wrap(!0,!0,!0,!0),d.selection.restore();for(var t=d.selection.blocks(),n=0;n<t.length;n++)"LI"!=t[n].tagName&&"LI"==t[n].parentNode.tagName&&(t[n]=t[n].parentNode);d.selection.save(),function(e,t){for(var n=!0,a=0;a<e.length;a++){if("LI"!=e[a].tagName)return!1;e[a].parentNode.tagName!=t&&(n=!1)}return n}(t,e)?r(t):a(t,e),d.html.unwrap(),d.selection.restore()},refresh:function(e,t){var n=m(d.selection.element());if(n.get(0)!=d.el){var a=n.get(0);(a="LI"!=a.tagName&&a.firstElementChild&&"LI"!=a.firstElementChild.tagName?n.parents("li").get(0):"LI"==a.tagName||a.firstElementChild?a.firstElementChild&&"LI"==a.firstElementChild.tagName?n.get(0).firstChild:n.get(0):n.parents("li").get(0))&&a.parentNode.tagName==t&&d.el.contains(a.parentNode)&&e.addClass("fr-active")}}}},m.FE.RegisterCommand("formatUL",{title:"Unordered List",refresh:function(e){this.lists.refresh(e,"UL")},callback:function(){this.lists.format("UL")},plugin:"lists"}),m.FE.RegisterCommand("formatOL",{title:"Ordered List",refresh:function(e){this.lists.refresh(e,"OL")},callback:function(){this.lists.format("OL")},plugin:"lists"}),m.FE.DefineIcon("formatUL",{NAME:"list-ul"}),m.FE.DefineIcon("formatOL",{NAME:"list-ol"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof module&&module.exports?module.exports=function(a,e){return e===undefined&&(e="undefined"!=typeof window?require("jquery"):require("jquery")(a)),t(e)}:t(window.jQuery)}(function(g){g.extend(g.FE.DEFAULTS,{paragraphFormat:{N:"Normal",H1:"Heading 1",H2:"Heading 2",H3:"Heading 3",H4:"Heading 4",PRE:"Code"},paragraphFormatSelection:!1,paragraphDefaultSelection:"Paragraph Format"}),g.FE.PLUGINS.paragraphFormat=function(h){function f(a,e){var t=h.html.defaultTag();if(e&&e.toLowerCase()!=t)if(0<a.find("ul, ol").length){var r=g("<"+e+">");a.prepend(r);for(var n=h.node.contents(a.get(0))[0];n&&["UL","OL"].indexOf(n.tagName)<0;){var o=n.nextSibling;r.append(n),n=o}}else a.html("<"+e+">"+a.html()+"</"+e+">")}return{apply:function(a){"N"==a&&(a=h.html.defaultTag()),h.selection.save(),h.html.wrap(!0,!0,!h.opts.paragraphFormat.BLOCKQUOTE,!0,!0),h.selection.restore();var e,t,r,n,o,i,p,l,s=h.selection.blocks();h.selection.save(),h.$el.find("pre").attr("skip",!0);for(var d=0;d<s.length;d++)if(s[d].tagName!=a&&!h.node.isList(s[d])){var m=g(s[d]);"LI"==s[d].tagName?f(m,a):"LI"==s[d].parentNode.tagName&&s[d]?(i=m,p=a,l=h.html.defaultTag(),p&&p.toLowerCase()!=l||(p='div class="fr-temp-div"'),i.replaceWith(g("<"+p+">").html(i.html()))):0<=["TD","TH"].indexOf(s[d].parentNode.tagName)?(r=m,n=a,o=h.html.defaultTag(),n||(n='div class="fr-temp-div"'+(h.node.isEmpty(r.get(0),!0)?' data-empty="true"':"")),n.toLowerCase()==o?(h.node.isEmpty(r.get(0),!0)||r.append("<br/>"),r.replaceWith(r.html())):r.replaceWith(g("<"+n+">").html(r.html()))):(e=m,(t=a)||(t='div class="fr-temp-div"'+(h.node.isEmpty(e.get(0),!0)?' data-empty="true"':"")),e.replaceWith(g("<"+t+" "+h.node.attributes(e.get(0))+">").html(e.html()).removeAttr("data-empty")))}h.$el.find('pre:not([skip="true"]) + pre:not([skip="true"])').each(function(){g(this).prev().append("<br>"+g(this).html()),g(this).remove()}),h.$el.find("pre").removeAttr("skip"),h.html.unwrap(),h.selection.restore()},refreshOnShow:function(a,e){var t=h.selection.blocks();if(t.length){var r=t[0],n="N",o=h.html.defaultTag();r.tagName.toLowerCase()!=o&&r!=h.el&&(n=r.tagName),e.find('.fr-command[data-param1="'+n+'"]').addClass("fr-active").attr("aria-selected",!0)}else e.find('.fr-command[data-param1="N"]').addClass("fr-active").attr("aria-selected",!0)},refresh:function(a){if(h.opts.paragraphFormatSelection){var e=h.selection.blocks();if(e.length){var t=e[0],r="N",n=h.html.defaultTag();t.tagName.toLowerCase()!=n&&t!=h.el&&(r=t.tagName),0<=["LI","TD","TH"].indexOf(r)&&(r="N"),a.find("> span").text(h.language.translate(h.opts.paragraphFormat[r]))}else a.find("> span").text(h.language.translate(h.opts.paragraphFormat.N))}}}},g.FE.RegisterCommand("paragraphFormat",{type:"dropdown",displaySelection:function(a){return a.opts.paragraphFormatSelection},defaultSelection:function(a){return a.language.translate(a.opts.paragraphDefaultSelection)},displaySelectionWidth:125,html:function(){var a='<ul class="fr-dropdown-list" role="presentation">',e=this.opts.paragraphFormat;for(var t in e)if(e.hasOwnProperty(t)){var r=this.shortcuts.get("paragraphFormat."+t);r=r?'<span class="fr-shortcut">'+r+"</span>":"",a+='<li role="presentation"><'+("N"==t?this.html.defaultTag()||"DIV":t)+' style="padding: 0 !important; margin: 0 !important;" role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="paragraphFormat" data-param1="'+t+'" title="'+this.language.translate(e[t])+'">'+this.language.translate(e[t])+"</a></"+("N"==t?this.html.defaultTag()||"DIV":t)+"></li>"}return a+="</ul>"},title:"Paragraph Format",callback:function(a,e){this.paragraphFormat.apply(e)},refresh:function(a){this.paragraphFormat.refresh(a)},refreshOnShow:function(a,e){this.paragraphFormat.refreshOnShow(a,e)},plugin:"paragraphFormat"}),g.FE.DefineIcon("paragraphFormat",{NAME:"paragraph"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof module&&module.exports?module.exports=function(e,a){return a===undefined&&(a="undefined"!=typeof window?require("jquery"):require("jquery")(e)),t(a)}:t(window.jQuery)}(function(i){i.extend(i.FE.DEFAULTS,{paragraphStyles:{"fr-text-gray":"Gray","fr-text-bordered":"Bordered","fr-text-spaced":"Spaced","fr-text-uppercase":"Uppercase"},paragraphMultipleStyles:!0}),i.FE.PLUGINS.paragraphStyle=function(o){return{_init:function(){},apply:function(e,a,t){void 0===a&&(a=o.opts.paragraphStyles),void 0===t&&(t=o.opts.paragraphMultipleStyles);var r="";t||((r=Object.keys(a)).splice(r.indexOf(e),1),r=r.join(" ")),o.selection.save(),o.html.wrap(!0,!0,!0,!0),o.selection.restore();var n=o.selection.blocks();o.selection.save();for(var s=i(n[0]).hasClass(e),l=0;l<n.length;l++)i(n[l]).removeClass(r).toggleClass(e,!s),i(n[l]).hasClass("fr-temp-div")&&i(n[l]).removeClass("fr-temp-div"),""===i(n[l]).attr("class")&&i(n[l]).removeAttr("class");o.html.unwrap(),o.selection.restore()},refreshOnShow:function(e,a){var t=o.selection.blocks();if(t.length){var r=i(t[0]);a.find(".fr-command").each(function(){var e=i(this).data("param1"),a=r.hasClass(e);i(this).toggleClass("fr-active",a).attr("aria-selected",a)})}}}},i.FE.RegisterCommand("paragraphStyle",{type:"dropdown",html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',a=this.opts.paragraphStyles;for(var t in a)a.hasOwnProperty(t)&&(e+='<li role="presentation"><a class="fr-command '+t+'" tabIndex="-1" role="option" data-cmd="paragraphStyle" data-param1="'+t+'" title="'+this.language.translate(a[t])+'">'+this.language.translate(a[t])+"</a></li>");return e+="</ul>"},title:"Paragraph Style",callback:function(e,a){this.paragraphStyle.apply(a)},refreshOnShow:function(e,a){this.paragraphStyle.refreshOnShow(e,a)},plugin:"paragraphStyle"}),i.FE.DefineIcon("paragraphStyle",{NAME:"magic"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(d){d.extend(d.FE.DEFAULTS,{quickInsertButtons:["image","video","embedly","table","ul","ol","hr"],quickInsertTags:["p","div","h1","h2","h3","h4","h5","h6","pre","blockquote"]}),d.FE.QUICK_INSERT_BUTTONS={},d.FE.DefineIcon("quickInsert",{PATH:'<path d="M22,16.75 L16.75,16.75 L16.75,22 L15.25,22.000 L15.25,16.75 L10,16.75 L10,15.25 L15.25,15.25 L15.25,10 L16.75,10 L16.75,15.25 L22,15.25 L22,16.75 Z"/>',template:"svg"}),d.FE.RegisterQuickInsertButton=function(e,t){d.FE.QUICK_INSERT_BUTTONS[e]=d.extend({undo:!0},t)},d.FE.RegisterQuickInsertButton("image",{icon:"insertImage",requiredPlugin:"image",title:"Insert Image",undo:!1,callback:function(){var e=this;e.shared.$qi_image_input||(e.shared.$qi_image_input=d('<input accept="image/*" name="quickInsertImage'+this.id+'" style="display: none;" type="file">'),d("body:first").append(e.shared.$qi_image_input),e.events.$on(e.shared.$qi_image_input,"change",function(){var e=d(this).data("inst");this.files&&(e.quickInsert.hide(),e.image.upload(this.files)),d(this).val("")},!0)),e.$qi_image_input=e.shared.$qi_image_input,e.helpers.isMobile()&&e.selection.save(),e.events.disableBlur(),e.$qi_image_input.data("inst",e).trigger("click")}}),d.FE.RegisterQuickInsertButton("video",{icon:"insertVideo",requiredPlugin:"video",title:"Insert Video",undo:!1,callback:function(){var e=prompt(this.language.translate("Paste the URL of the video you want to insert."));e&&this.video.insertByURL(e)}}),d.FE.RegisterQuickInsertButton("embedly",{icon:"embedly",requiredPlugin:"embedly",title:"Embed URL",undo:!1,callback:function(){var e=prompt(this.language.translate("Paste the URL of any web content you want to insert."));e&&this.embedly.add(e)}}),d.FE.RegisterQuickInsertButton("table",{icon:"insertTable",requiredPlugin:"table",title:"Insert Table",callback:function(){this.table.insert(2,2)}}),d.FE.RegisterQuickInsertButton("ol",{icon:"formatOL",requiredPlugin:"lists",title:"Ordered List",callback:function(){this.lists.format("OL")}}),d.FE.RegisterQuickInsertButton("ul",{icon:"formatUL",requiredPlugin:"lists",title:"Unordered List",callback:function(){this.lists.format("UL")}}),d.FE.RegisterQuickInsertButton("hr",{icon:"insertHR",title:"Insert Horizontal Line",callback:function(){this.commands.insertHR()}}),d.FE.PLUGINS.quickInsert=function(r){var a,l;function t(e){var t,n,i;t=e.offset().top-r.$box.offset().top,n=0-a.outerWidth(),r.opts.enter!=d.FE.ENTER_BR?i=(a.outerHeight()-e.outerHeight())/2:(d("<span>"+d.FE.INVISIBLE_SPACE+"</span>").insertAfter(e),i=(a.outerHeight()-e.next().outerHeight())/2,e.next().remove()),r.opts.iframe&&(t+=r.$iframe.offset().top-r.helpers.scrollTop()),a.hasClass("fr-on")&&0<=t&&l.css("top",t-i),0<=t&&t-i<=r.$box.outerHeight()-e.outerHeight()?(a.hasClass("fr-hidden")&&(a.hasClass("fr-on")&&o(),a.removeClass("fr-hidden")),a.css("top",t-i)):a.hasClass("fr-visible")&&(a.addClass("fr-hidden"),u()),a.css("left",n)}function n(e){a||function(){r.shared.$quick_insert||(r.shared.$quick_insert=d('<div class="fr-quick-insert"><a class="fr-floating-btn" role="button" tabIndex="-1" title="'+r.language.translate("Quick Insert")+'">'+r.icon.create("quickInsert")+"</a></div>"));a=r.shared.$quick_insert,r.tooltip.bind(r.$box,".fr-quick-insert > a.fr-floating-btn"),r.events.on("destroy",function(){a.removeClass("fr-on").appendTo(d("body:first")).css("left",-9999).css("top",-9999),l&&(u(),l.appendTo(d("body:first")))},!0),r.events.on("shared.destroy",function(){a.html("").removeData().remove(),a=null,l&&(l.html("").removeData().remove(),l=null)},!0),r.events.on("commands.before",s),r.events.on("commands.after",function(){r.popups.areVisible()||i()}),r.events.bindClick(r.$box,".fr-quick-insert > a",o),r.events.bindClick(r.$box,".fr-qi-helper > a.fr-btn",function(e){var t=d(e.currentTarget).data("cmd");if(!1===r.events.trigger("quickInsert.commands.before",[t]))return!1;d.FE.QUICK_INSERT_BUTTONS[t].callback.apply(r,[e.currentTarget]),d.FE.QUICK_INSERT_BUTTONS[t].undo&&r.undo.saveStep(),r.events.trigger("quickInsert.commands.after",[t]),r.quickInsert.hide()}),r.events.$on(r.$wp,"scroll",function(){a.hasClass("fr-visible")&&t(a.data("tag"))})}(),a.hasClass("fr-on")&&u(),r.$box.append(a),t(e),a.data("tag",e),a.addClass("fr-visible")}function i(){if(r.core.hasFocus()){var e=r.selection.element();if(r.opts.enter==d.FE.ENTER_BR||r.node.isBlock(e)||(e=r.node.blockParent(e)),r.opts.enter==d.FE.ENTER_BR&&!r.node.isBlock(e)){var t=r.node.deepestParent(e);t&&(e=t)}e&&(r.opts.enter!=d.FE.ENTER_BR&&r.node.isEmpty(e)&&r.node.isElement(e.parentNode)&&0<=r.opts.quickInsertTags.indexOf(e.tagName.toLowerCase())||r.opts.enter==d.FE.ENTER_BR&&("BR"==e.tagName&&(!e.previousSibling||"BR"==e.previousSibling.tagName||r.node.isBlock(e.previousSibling))||r.node.isEmpty(e)&&(!e.previousSibling||"BR"==e.previousSibling.tagName||r.node.isBlock(e.previousSibling))&&(!e.nextSibling||"BR"==e.nextSibling.tagName||r.node.isBlock(e.nextSibling))))?a&&a.data("tag").is(d(e))&&a.hasClass("fr-on")?u():r.selection.isCollapsed()&&n(d(e)):s()}}function s(){a&&(a.hasClass("fr-on")&&u(),a.removeClass("fr-visible fr-on"),a.css("left",-9999).css("top",-9999))}function o(e){if(e&&e.preventDefault(),a.hasClass("fr-on")&&!a.hasClass("fr-hidden"))u();else{if(!r.shared.$qi_helper){for(var t=r.opts.quickInsertButtons,n='<div class="fr-qi-helper">',i=0,s=0;s<t.length;s++){var o=d.FE.QUICK_INSERT_BUTTONS[t[s]];o&&(!o.requiredPlugin||d.FE.PLUGINS[o.requiredPlugin]&&0<=r.opts.pluginsEnabled.indexOf(o.requiredPlugin))&&(n+='<a class="fr-btn fr-floating-btn" role="button" title="'+r.language.translate(o.title)+'" tabIndex="-1" data-cmd="'+t[s]+'" style="transition-delay: '+.025*i+++'s;">'+r.icon.create(o.icon)+"</a>")}n+="</div>",r.shared.$qi_helper=d(n),r.tooltip.bind(r.shared.$qi_helper,"> a.fr-btn"),r.events.$on(r.shared.$qi_helper,"mousedown",function(e){e.preventDefault()},!0)}(l=r.shared.$qi_helper).appendTo(r.$box),setTimeout(function(){l.css("top",parseFloat(a.css("top"))),l.css("left",parseFloat(a.css("left"))+a.outerWidth()),l.find("a").addClass("fr-size-1"),a.addClass("fr-on")},10)}}function u(){var e=r.$box.find(".fr-qi-helper");e.length&&(e.find("a").removeClass("fr-size-1"),e.css("left",-9999),a.hasClass("fr-hidden")||a.removeClass("fr-on"))}return{_init:function(){if(!r.$wp)return!1;r.opts.iframe&&r.$el.parent("html").find("head").append('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">'),r.popups.onShow("image.edit",s),r.events.on("mouseup",i),r.helpers.isMobile()&&r.events.$on(d(r.o_doc),"selectionchange",i),r.events.on("blur",s),r.events.on("keyup",i),r.events.on("keydown",function(){setTimeout(function(){i()},0)})},hide:s}}});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(i){i.FE.PLUGINS.quote=function(o){function r(e){for(;e.parentNode&&e.parentNode!=o.el;)e=e.parentNode;return e}return{apply:function(e){o.selection.save(),o.html.wrap(!0,!0,!0,!0),o.selection.restore(),"increase"==e?function(){var e,t=o.selection.blocks();for(e=0;e<t.length;e++)t[e]=r(t[e]);o.selection.save();var n=i("<blockquote>");for(n.insertBefore(t[0]),e=0;e<t.length;e++)n.append(t[e]);o.html.unwrap(),o.selection.restore()}():"decrease"==e&&function(){var e,t=o.selection.blocks();for(e=0;e<t.length;e++)"BLOCKQUOTE"!=t[e].tagName&&(t[e]=i(t[e]).parentsUntil(o.$el,"BLOCKQUOTE").get(0));for(o.selection.save(),e=0;e<t.length;e++)t[e]&&i(t[e]).replaceWith(t[e].innerHTML);o.html.unwrap(),o.selection.restore()}()}}},i.FE.RegisterShortcut(i.FE.KEYCODE.SINGLE_QUOTE,"quote","increase","'"),i.FE.RegisterShortcut(i.FE.KEYCODE.SINGLE_QUOTE,"quote","decrease","'",!0),i.FE.RegisterCommand("quote",{title:"Quote",type:"dropdown",options:{increase:"Increase",decrease:"Decrease"},callback:function(e,t){this.quote.apply(t)},plugin:"quote"}),i.FE.DefineIcon("quote",{NAME:"quote-left"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),a(t)}:a(window.jQuery)}(function(Z){Z.extend(Z.FE.POPUP_TEMPLATES,{"table.insert":"[_BUTTONS_][_ROWS_COLUMNS_]","table.edit":"[_BUTTONS_]","table.colors":"[_BUTTONS_][_COLORS_][_CUSTOM_COLOR_]"}),Z.extend(Z.FE.DEFAULTS,{tableInsertMaxSize:10,tableEditButtons:["tableHeader","tableRemove","|","tableRows","tableColumns","tableStyle","-","tableCells","tableCellBackground","tableCellVerticalAlign","tableCellHorizontalAlign","tableCellStyle"],tableInsertButtons:["tableBack","|"],tableResizer:!0,tableDefaultWidth:"100%",tableResizerOffset:5,tableResizingLimit:30,tableColorsButtons:["tableBack","|"],tableColors:["#61BD6D","#1ABC9C","#54ACD2","#2C82C9","#9365B8","#475577","#CCCCCC","#41A85F","#00A885","#3D8EB9","#2969B0","#553982","#28324E","#000000","#F7DA64","#FBA026","#EB6B56","#E25041","#A38F84","#EFEFEF","#FFFFFF","#FAC51C","#F37934","#D14841","#B8312F","#7C706B","#D1D5D8","REMOVE"],tableColorsStep:7,tableCellStyles:{"fr-highlighted":"Highlighted","fr-thick":"Thick"},tableStyles:{"fr-dashed-borders":"Dashed Borders","fr-alternate-rows":"Alternate Rows"},tableCellMultipleStyles:!0,tableMultipleStyles:!0,tableInsertHelper:!0,tableInsertHelperOffset:15}),Z.FE.PLUGINS.table=function(E){var C,o,s,n,l,r,w;function h(){var e=O();if(e){var t=E.popups.get("table.edit");if(t||(t=p()),t){E.popups.setContainer("table.edit",E.$sc);var a=M(e),l=(a.left+a.right)/2,s=a.bottom;E.popups.show("table.edit",l,s,a.bottom-a.top),E.edit.isDisabled()&&(1<J().length&&E.toolbar.disable(),E.$el.removeClass("fr-no-selection"),E.edit.on(),E.button.bulkRefresh(),E.selection.setAtEnd(E.$el.find(".fr-selected-cell:last").get(0)),E.selection.restore())}}}function f(){var e,t,a,l,s=O();if(s){var n=E.popups.get("table.colors");n||(n=function(){var e="";0<E.opts.tableColorsButtons.length&&(e='<div class="fr-buttons fr-table-colors-buttons">'+E.button.buildList(E.opts.tableColorsButtons)+"</div>");var t="";E.opts.colorsHEXInput&&(t='<div class="fr-table-colors-hex-layer fr-active fr-layer" id="fr-table-colors-hex-layer-'+E.id+'"><div class="fr-input-line"><input maxlength="7" id="fr-table-colors-hex-layer-text-'+E.id+'" type="text" placeholder="'+E.language.translate("HEX Color")+'" tabIndex="1" aria-required="true"></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-submit" data-cmd="tableCellBackgroundCustomColor" tabIndex="2" role="button">'+E.language.translate("OK")+"</button></div></div>");var a={buttons:e,colors:function(){for(var e='<div class="fr-table-colors">',t=0;t<E.opts.tableColors.length;t++)0!==t&&t%E.opts.tableColorsStep==0&&(e+="<br>"),"REMOVE"!=E.opts.tableColors[t]?e+='<span class="fr-command" style="background: '+E.opts.tableColors[t]+';" tabIndex="-1" role="button" data-cmd="tableCellBackgroundColor" data-param1="'+E.opts.tableColors[t]+'"><span class="fr-sr-only">'+E.language.translate("Color")+" "+E.opts.tableColors[t]+"&nbsp;&nbsp;&nbsp;</span></span>":e+='<span class="fr-command" data-cmd="tableCellBackgroundColor" tabIndex="-1" role="button" data-param1="REMOVE" title="'+E.language.translate("Clear Formatting")+'">'+E.icon.create("tableColorRemove")+'<span class="fr-sr-only">'+E.language.translate("Clear Formatting")+"</span></span>";return e+="</div>"}(),custom_color:t},l=E.popups.create("table.colors",a);return E.events.$on(E.$wp,"scroll.table-colors",function(){E.popups.isVisible("table.colors")&&f()}),u=l,E.events.on("popup.tab",function(e){var t=Z(e.currentTarget);if(!E.popups.isVisible("table.colors")||!t.is("span"))return!0;var a=e.which,l=!0;if(Z.FE.KEYCODE.TAB==a){var s=u.find(".fr-buttons");l=!E.accessibility.focusToolbar(s,!!e.shiftKey)}else if(Z.FE.KEYCODE.ARROW_UP==a||Z.FE.KEYCODE.ARROW_DOWN==a||Z.FE.KEYCODE.ARROW_LEFT==a||Z.FE.KEYCODE.ARROW_RIGHT==a){var n=t.parent().find("span.fr-command"),r=n.index(t),o=E.opts.colorsStep,i=Math.floor(n.length/o),f=r%o,c=Math.floor(r/o),d=c*o+f,p=i*o;Z.FE.KEYCODE.ARROW_UP==a?d=((d-o)%p+p)%p:Z.FE.KEYCODE.ARROW_DOWN==a?d=(d+o)%p:Z.FE.KEYCODE.ARROW_LEFT==a?d=((d-1)%p+p)%p:Z.FE.KEYCODE.ARROW_RIGHT==a&&(d=(d+1)%p);var h=Z(n.get(d));E.events.disableBlur(),h.focus(),l=!1}else Z.FE.KEYCODE.ENTER==a&&(E.button.exec(t),l=!1);return!1===l&&(e.preventDefault(),e.stopPropagation()),l},!0),l;var u}()),E.popups.setContainer("table.colors",E.$sc);var r=M(s),o=(r.left+r.right)/2,i=r.bottom;e=E.popups.get("table.colors"),t=E.$el.find(".fr-selected-cell:first"),a=E.helpers.RGBToHex(t.css("background-color")),l=e.find(".fr-table-colors-hex-layer input"),e.find(".fr-selected-color").removeClass("fr-selected-color fr-active-item"),e.find('span[data-param1="'+a+'"]').addClass("fr-selected-color fr-active-item"),l.val(a).trigger("change"),E.popups.show("table.colors",o,i,r.bottom-r.top)}}function i(){0===J().length&&E.toolbar.enable()}function c(e){if(e)return E.popups.onHide("table.insert",function(){E.popups.get("table.insert").find('.fr-table-size .fr-select-table-size > span[data-row="1"][data-col="1"]').trigger("mouseenter")}),!0;var t="";0<E.opts.tableInsertButtons.length&&(t='<div class="fr-buttons">'+E.button.buildList(E.opts.tableInsertButtons)+"</div>");var a,l={buttons:t,rows_columns:function(){for(var e='<div class="fr-table-size"><div class="fr-table-size-info">1 &times; 1</div><div class="fr-select-table-size">',t=1;t<=E.opts.tableInsertMaxSize;t++){for(var a=1;a<=E.opts.tableInsertMaxSize;a++){var l="inline-block";2<t&&!E.helpers.isMobile()&&(l="none");var s="fr-table-cell ";1==t&&1==a&&(s+=" hover"),e+='<span class="fr-command '+s+'" tabIndex="-1" data-cmd="tableInsert" data-row="'+t+'" data-col="'+a+'" data-param1="'+t+'" data-param2="'+a+'" style="display: '+l+';" role="button"><span></span><span class="fr-sr-only">'+t+" &times; "+a+"&nbsp;&nbsp;&nbsp;</span></span>"}e+='<div class="new-line"></div>'}return e+="</div></div>"}()},s=E.popups.create("table.insert",l);return E.events.$on(s,"mouseenter",".fr-table-size .fr-select-table-size .fr-table-cell",function(e){d(Z(e.currentTarget))},!0),a=s,E.events.$on(a,"focus","[tabIndex]",function(e){var t=Z(e.currentTarget);d(t)}),E.events.on("popup.tab",function(e){var t=Z(e.currentTarget);if(!E.popups.isVisible("table.insert")||!t.is("span, a"))return!0;var a,l=e.which;if(Z.FE.KEYCODE.ARROW_UP==l||Z.FE.KEYCODE.ARROW_DOWN==l||Z.FE.KEYCODE.ARROW_LEFT==l||Z.FE.KEYCODE.ARROW_RIGHT==l){if(t.is("span.fr-table-cell")){var s=t.parent().find("span.fr-table-cell"),n=s.index(t),r=E.opts.tableInsertMaxSize,o=n%r,i=Math.floor(n/r);Z.FE.KEYCODE.ARROW_UP==l?i=Math.max(0,i-1):Z.FE.KEYCODE.ARROW_DOWN==l?i=Math.min(E.opts.tableInsertMaxSize-1,i+1):Z.FE.KEYCODE.ARROW_LEFT==l?o=Math.max(0,o-1):Z.FE.KEYCODE.ARROW_RIGHT==l&&(o=Math.min(E.opts.tableInsertMaxSize-1,o+1));var f=i*r+o,c=Z(s.get(f));d(c),E.events.disableBlur(),c.focus(),a=!1}}else Z.FE.KEYCODE.ENTER==l&&(E.button.exec(t),a=!1);return!1===a&&(e.preventDefault(),e.stopPropagation()),a},!0),s}function d(e){var t=e.data("row"),a=e.data("col"),l=e.parent();l.siblings(".fr-table-size-info").html(t+" &times; "+a),l.find("> span").removeClass("hover fr-active-item");for(var s=1;s<=E.opts.tableInsertMaxSize;s++)for(var n=0;n<=E.opts.tableInsertMaxSize;n++){var r=l.find('> span[data-row="'+s+'"][data-col="'+n+'"]');s<=t&&n<=a?r.addClass("hover"):s<=t+1||s<=2&&!E.helpers.isMobile()?r.css("display","inline-block"):2<s&&!E.helpers.isMobile()&&r.css("display","none")}e.addClass("fr-active-item")}function p(e){if(e)return E.popups.onHide("table.edit",i),!0;if(0<E.opts.tableEditButtons.length){var t={buttons:'<div class="fr-buttons">'+E.button.buildList(E.opts.tableEditButtons)+"</div>"},a=E.popups.create("table.edit",t);return E.events.$on(E.$wp,"scroll.table-edit",function(){E.popups.isVisible("table.edit")&&h()}),a}return!1}function u(){if(0<J().length){var e=Q();E.selection.setBefore(e.get(0))||E.selection.setAfter(e.get(0)),E.selection.restore(),E.popups.hide("table.edit"),e.remove(),E.toolbar.enable()}}function b(e){var t=Q();if(0<t.length){if(0<E.$el.find("th.fr-selected-cell").length&&"above"==e)return;var a,l,s,n=O(),r=$(n);l="above"==e?r.min_i:r.max_i;var o="<tr>";for(a=0;a<n[l].length;a++)if("below"==e&&l<n.length-1&&n[l][a]==n[l+1][a]||"above"==e&&0<l&&n[l][a]==n[l-1][a]){if(0===a||0<a&&n[l][a]!=n[l][a-1]){var i=Z(n[l][a]);i.attr("rowspan",parseInt(i.attr("rowspan"),10)+1)}}else o+="<td><br></td>";o+="</tr>",s=0<E.$el.find("th.fr-selected-cell").length&&"below"==e?Z(t.find("tbody").not(t.find("table tbody"))):Z(t.find("tr").not(t.find("table tr")).get(l)),"below"==e?"TBODY"==s.prop("tagName")?s.prepend(o):s.after(o):"above"==e&&(s.before(o),E.popups.isVisible("table.edit")&&h())}}function g(e,t,a){var l,s,n,r,o,i=0,f=O(a);if(e<(t=Math.min(t,f[0].length-1)))for(s=e;s<=t;s++)if(!(e<s&&f[0][s]==f[0][s-1])&&1<(r=Math.min(parseInt(f[0][s].getAttribute("colspan"),10)||1,t-e+1))&&f[0][s]==f[0][s+1])for(i=r-1,l=1;l<f.length;l++)if(f[l][s]!=f[l-1][s]){for(n=s;n<s+r;n++)if(1<(o=parseInt(f[l][n].getAttribute("colspan"),10)||1)&&f[l][n]==f[l][n+1])n+=i=Math.min(i,o-1);else if(!(i=Math.max(0,i-1)))break;if(!i)break}i&&v(f,i,"colspan",0,f.length-1,e,t)}function m(e,t,a){var l,s,n,r,o,i=0,f=O(a);if(e<(t=Math.min(t,f.length-1)))for(l=e;l<=t;l++)if(!(e<l&&f[l][0]==f[l-1][0])&&1<(r=Math.min(parseInt(f[l][0].getAttribute("rowspan"),10)||1,t-e+1))&&f[l][0]==f[l+1][0])for(i=r-1,s=1;s<f[0].length;s++)if(f[l][s]!=f[l][s-1]){for(n=l;n<l+r;n++)if(1<(o=parseInt(f[n][s].getAttribute("rowspan"),10)||1)&&f[n][s]==f[n+1][s])n+=i=Math.min(i,o-1);else if(!(i=Math.max(0,i-1)))break;if(!i)break}i&&v(f,i,"rowspan",e,t,0,f[0].length-1)}function v(e,t,a,l,s,n,r){var o,i,f;for(o=l;o<=s;o++)for(i=n;i<=r;i++)l<o&&e[o][i]==e[o-1][i]||n<i&&e[o][i]==e[o][i-1]||1<(f=parseInt(e[o][i].getAttribute(a),10)||1)&&(1<f-t?e[o][i].setAttribute(a,f-t):e[o][i].removeAttribute(a))}function R(e,t,a,l,s){m(e,t,s),g(a,l,s)}function t(e){var t=E.$el.find(".fr-selected-cell");"REMOVE"!=e?t.css("background-color",E.helpers.HEXtoRGB(e)):t.css("background-color",""),h()}function O(e){var f=[];return null==(e=e||null)&&0<J().length&&(e=Q()),e&&e.find("tr:visible").not(e.find("table tr")).each(function(o,e){var t=Z(e),i=0;t.find("> th, > td").each(function(e,t){for(var a=Z(t),l=parseInt(a.attr("colspan"),10)||1,s=parseInt(a.attr("rowspan"),10)||1,n=o;n<o+s;n++)for(var r=i;r<i+l;r++)f[n]||(f[n]=[]),f[n][r]?i++:f[n][r]=t;i+=l})}),f}function A(e,t){for(var a=0;a<t.length;a++)for(var l=0;l<t[a].length;l++)if(t[a][l]==e)return{row:a,col:l}}function F(e,t,a){for(var l=e+1,s=t+1;l<a.length;){if(a[l][t]!=a[e][t]){l--;break}l++}for(l==a.length&&l--;s<a[e].length;){if(a[e][s]!=a[e][t]){s--;break}s++}return s==a[e].length&&s--,{row:l,col:s}}function x(){E.el.querySelector(".fr-cell-fixed")&&E.el.querySelector(".fr-cell-fixed").classList.remove("fr-cell-fixed"),E.el.querySelector(".fr-cell-handler")&&E.el.querySelector(".fr-cell-handler").classList.remove("fr-cell-handler")}function D(){var e=E.$el.find(".fr-selected-cell");0<e.length&&e.each(function(){var e=Z(this);e.removeClass("fr-selected-cell"),""===e.attr("class")&&e.removeAttr("class")}),x()}function y(){E.events.disableBlur(),E.selection.clear(),E.$el.addClass("fr-no-selection"),E.$el.blur(),E.events.enableBlur()}function $(e){var t=E.$el.find(".fr-selected-cell");if(0<t.length){var a,l=e.length,s=0,n=e[0].length,r=0;for(a=0;a<t.length;a++){var o=A(t[a],e),i=F(o.row,o.col,e);l=Math.min(o.row,l),s=Math.max(i.row,s),n=Math.min(o.col,n),r=Math.max(i.col,r)}return{min_i:l,max_i:s,min_j:n,max_j:r}}return null}function M(e){var t=$(e),a=Z(e[t.min_i][t.min_j]),l=Z(e[t.min_i][t.max_j]),s=Z(e[t.max_i][t.min_j]);return{left:a.offset().left,right:l.offset().left+l.outerWidth(),top:a.offset().top,bottom:s.offset().top+s.outerHeight()}}function _(t,a){if(Z(t).is(a))D(),Z(t).addClass("fr-selected-cell");else{y(),E.edit.off();var l=O(),s=A(t,l),n=A(a,l),r=function e(t,a,l,s,n){var r,o,i,f,c=t,d=a,p=l,h=s;for(r=c;r<=d;r++)(1<(parseInt(Z(n[r][p]).attr("rowspan"),10)||1)||1<(parseInt(Z(n[r][p]).attr("colspan"),10)||1))&&(f=F((i=A(n[r][p],n)).row,i.col,n),c=Math.min(i.row,c),d=Math.max(f.row,d),p=Math.min(i.col,p),h=Math.max(f.col,h)),(1<(parseInt(Z(n[r][h]).attr("rowspan"),10)||1)||1<(parseInt(Z(n[r][h]).attr("colspan"),10)||1))&&(f=F((i=A(n[r][h],n)).row,i.col,n),c=Math.min(i.row,c),d=Math.max(f.row,d),p=Math.min(i.col,p),h=Math.max(f.col,h));for(o=p;o<=h;o++)(1<(parseInt(Z(n[c][o]).attr("rowspan"),10)||1)||1<(parseInt(Z(n[c][o]).attr("colspan"),10)||1))&&(f=F((i=A(n[c][o],n)).row,i.col,n),c=Math.min(i.row,c),d=Math.max(f.row,d),p=Math.min(i.col,p),h=Math.max(f.col,h)),(1<(parseInt(Z(n[d][o]).attr("rowspan"),10)||1)||1<(parseInt(Z(n[d][o]).attr("colspan"),10)||1))&&(f=F((i=A(n[d][o],n)).row,i.col,n),c=Math.min(i.row,c),d=Math.max(f.row,d),p=Math.min(i.col,p),h=Math.max(f.col,h));return c==t&&d==a&&p==l&&h==s?{min_i:t,max_i:a,min_j:l,max_j:s}:e(c,d,p,h,n)}(Math.min(s.row,n.row),Math.max(s.row,n.row),Math.min(s.col,n.col),Math.max(s.col,n.col),l);D(),t.classList.add("fr-cell-fixed"),a.classList.add("fr-cell-handler");for(var o=r.min_i;o<=r.max_i;o++)for(var i=r.min_j;i<=r.max_j;i++)Z(l[o][i]).addClass("fr-selected-cell")}}function I(e){var t=null,a=Z(e.target);return"TD"==e.target.tagName||"TH"==e.target.tagName?t=e.target:0<a.closest("td").length?t=a.closest("td").get(0):0<a.closest("th").length&&(t=a.closest("th").get(0)),0===E.$el.find(t).length?null:t}function T(){D(),E.popups.hide("table.edit")}function e(e){var t=I(e);if("false"==Z(t).parents("[contenteditable]:not(.fr-element):not(.fr-img-caption):not(body):first").attr("contenteditable"))return!0;if(0<J().length&&!t&&T(),!E.edit.isDisabled()||E.popups.isVisible("table.edit"))if(1!=e.which||1==e.which&&E.helpers.isMac()&&e.ctrlKey)(3==e.which||1==e.which&&E.helpers.isMac()&&e.ctrlKey)&&t&&T();else if(n=!0,t){0<J().length&&!e.shiftKey&&T(),e.stopPropagation(),E.events.trigger("image.hideResizer"),E.events.trigger("video.hideResizer"),s=!0;var a=t.tagName.toLowerCase();e.shiftKey&&0<E.$el.find(a+".fr-selected-cell").length?Z(E.$el.find(a+".fr-selected-cell").closest("table")).is(Z(t).closest("table"))?_(l,t):y():((E.keys.ctrlKey(e)||e.shiftKey)&&(1<J().length||0===Z(t).find(E.selection.element()).length&&!Z(t).is(E.selection.element()))&&y(),l=t,0<E.opts.tableEditButtons.length&&_(l,l))}}function a(e){if(s||E.$tb.is(e.target)||E.$tb.is(Z(e.target).closest(E.$tb.get(0)))||(0<J().length&&E.toolbar.enable(),D()),!(1!=e.which||1==e.which&&E.helpers.isMac()&&e.ctrlKey)){if(n=!1,s)s=!1,I(e)||1!=J().length?0<J().length&&(E.selection.isCollapsed()?h():D()):D();if(w){w=!1,C.removeClass("fr-moving"),E.$el.removeClass("fr-no-selection"),E.edit.on();var t=parseFloat(C.css("left"))+E.opts.tableResizerOffset+E.$wp.offset().left;E.opts.iframe&&(t-=E.$iframe.offset().left),C.data("release-position",t),C.removeData("max-left"),C.removeData("max-right"),function(){var e=C.data("origin"),t=C.data("release-position");if(e!==t){var a=C.data("first"),l=C.data("second"),s=C.data("table"),n=s.outerWidth();if(E.undo.canDo()||E.undo.saveStep(),null!==a&&null!==l){var r,o,i,f=O(s),c=[],d=[],p=[],h=[];for(r=0;r<f.length;r++)o=Z(f[r][a]),i=Z(f[r][l]),c[r]=o.outerWidth(),p[r]=i.outerWidth(),d[r]=c[r]/n*100,h[r]=p[r]/n*100;for(r=0;r<f.length;r++)if(o=Z(f[r][a]),i=Z(f[r][l]),f[r][a]!=f[r][l]){var u=(d[r]*(c[r]+t-e)/c[r]).toFixed(4);o.css("width",u+"%"),i.css("width",(d[r]+h[r]-u).toFixed(4)+"%")}}else{var b,g=s.parent(),m=n/g.width()*100,v=(parseInt(s.css("margin-left"),10)||0)/g.width()*100,w=(parseInt(s.css("margin-right"),10)||0)/g.width()*100;"rtl"==E.opts.direction&&0===l||"rtl"!=E.opts.direction&&0!==l?(b=(n+t-e)/n*m,s.css("margin-right","calc(100% - "+Math.round(b).toFixed(4)+"% - "+Math.round(v).toFixed(4)+"%)")):("rtl"==E.opts.direction&&0!==l||"rtl"!=E.opts.direction&&0===l)&&(b=(n-t+e)/n*m,s.css("margin-left","calc(100% - "+Math.round(b).toFixed(4)+"% - "+Math.round(w).toFixed(4)+"%)")),s.css("width",Math.round(b).toFixed(4)+"%")}E.selection.restore(),E.undo.saveStep(),E.events.trigger("table.resized",[s.get(0)])}C.removeData("origin"),C.removeData("release-position"),C.removeData("first"),C.removeData("second"),C.removeData("table")}(),W()}}}function N(e){if(!0===s&&0<E.opts.tableEditButtons.length){if(Z(e.currentTarget).closest("table").is(Q())){if("TD"==e.currentTarget.tagName&&0===E.$el.find("th.fr-selected-cell").length)return void _(l,e.currentTarget);if("TH"==e.currentTarget.tagName&&0===E.$el.find("td.fr-selected-cell").length)return void _(l,e.currentTarget)}y()}}function S(e,t,a,l){for(var s,n=t;n!=E.el&&"TD"!=n.tagName&&"TH"!=n.tagName&&("up"==l?s=n.previousElementSibling:"down"==l&&(s=n.nextElementSibling),!s);)n=n.parentNode;"TD"==n.tagName||"TH"==n.tagName?function(e,t){for(var a=e;a&&"TABLE"!=a.tagName&&a.parentNode!=E.el;)a=a.parentNode;if(a&&"TABLE"==a.tagName){var l=O(Z(a));"up"==t?z(A(e,l),a,l):"down"==t&&B(A(e,l),a,l)}}(n,l):s&&("up"==l&&E.selection.setAtEnd(s),"down"==l&&E.selection.setAtStart(s))}function z(e,t,a){0<e.row?E.selection.setAtEnd(a[e.row-1][e.col]):S(0,t,0,"up")}function B(e,t,a){var l=parseInt(a[e.row][e.col].getAttribute("rowspan"),10)||1;e.row<a.length-l?E.selection.setAtStart(a[e.row+l][e.col]):S(0,t,0,"down")}function W(){C&&(C.find("div").css("opacity",0),C.css("top",0),C.css("left",0),C.css("height",0),C.find("div").css("height",0),C.hide())}function k(){o&&o.removeClass("fr-visible").css("left","-9999px")}function K(e,t){var a=Z(t),l=a.closest("table"),s=l.parent();if(t&&"TD"!=t.tagName&&"TH"!=t.tagName&&(0<a.closest("td").length?t=a.closest("td"):0<a.closest("th").length&&(t=a.closest("th"))),!t||"TD"!=t.tagName&&"TH"!=t.tagName)C&&a.get(0)!=C.get(0)&&a.parent().get(0)!=C.get(0)&&E.core.sameInstance(C)&&W();else{if(a=Z(t),0===E.$el.find(a).length)return!1;var n=a.offset().left-1,r=n+a.outerWidth();if(Math.abs(e.pageX-n)<=E.opts.tableResizerOffset||Math.abs(r-e.pageX)<=E.opts.tableResizerOffset){var o,i,f,c,d,p=O(l),h=A(t,p),u=F(h.row,h.col,p),b=l.offset().top,g=l.outerHeight()-1;"rtl"!=E.opts.direction?e.pageX-n<=E.opts.tableResizerOffset?(f=n,0<h.col?(c=n-j(h.col-1,p)+E.opts.tableResizingLimit,d=n+j(h.col,p)-E.opts.tableResizingLimit,o=h.col-1,i=h.col):(o=null,i=0,c=l.offset().left-1-parseInt(l.css("margin-left"),10),d=l.offset().left-1+l.width()-p[0].length*E.opts.tableResizingLimit)):r-e.pageX<=E.opts.tableResizerOffset&&(f=r,u.col<p[u.row].length&&p[u.row][u.col+1]?(c=r-j(u.col,p)+E.opts.tableResizingLimit,d=r+j(u.col+1,p)-E.opts.tableResizingLimit,o=u.col,i=u.col+1):(o=u.col,i=null,c=l.offset().left-1+p[0].length*E.opts.tableResizingLimit,d=s.offset().left-1+s.width()+parseFloat(s.css("padding-left")))):r-e.pageX<=E.opts.tableResizerOffset?(f=r,0<h.col?(c=r-j(h.col,p)+E.opts.tableResizingLimit,d=r+j(h.col-1,p)-E.opts.tableResizingLimit,o=h.col,i=h.col-1):(o=null,i=0,c=l.offset().left+p[0].length*E.opts.tableResizingLimit,d=s.offset().left-1+s.width()+parseFloat(s.css("padding-left")))):e.pageX-n<=E.opts.tableResizerOffset&&(f=n,u.col<p[u.row].length&&p[u.row][u.col+1]?(c=n-j(u.col+1,p)+E.opts.tableResizingLimit,d=n+j(u.col,p)-E.opts.tableResizingLimit,o=u.col+1,i=u.col):(o=u.col,i=null,c=s.offset().left+parseFloat(s.css("padding-left")),d=l.offset().left-1+l.width()-p[0].length*E.opts.tableResizingLimit)),C||(E.shared.$table_resizer||(E.shared.$table_resizer=Z('<div class="fr-table-resizer"><div></div></div>')),C=E.shared.$table_resizer,E.events.$on(C,"mousedown",function(e){return!E.core.sameInstance(C)||(0<J().length&&T(),1==e.which?(E.selection.save(),w=!0,C.addClass("fr-moving"),y(),E.edit.off(),C.find("div").css("opacity",1),!1):void 0)}),E.events.$on(C,"mousemove",function(e){if(!E.core.sameInstance(C))return!0;w&&(E.opts.iframe&&(e.pageX-=E.$iframe.offset().left),X(e))}),E.events.on("shared.destroy",function(){C.html("").removeData().remove(),C=null},!0),E.events.on("destroy",function(){E.$el.find(".fr-selected-cell").removeClass("fr-selected-cell"),C.hide().appendTo(Z("body:first"))},!0)),C.data("table",l),C.data("first",o),C.data("second",i),C.data("instance",E),E.$wp.append(C);var m=f-E.win.pageXOffset-E.opts.tableResizerOffset-E.$wp.offset().left,v=b-E.$wp.offset().top+E.$wp.scrollTop();E.opts.iframe&&(m+=E.$iframe.offset().left,v+=E.$iframe.offset().top,c+=E.$iframe.offset().left,d+=E.$iframe.offset().left),C.data("max-left",c),C.data("max-right",d),C.data("origin",f-E.win.pageXOffset),C.css("top",v),C.css("left",m),C.css("height",g),C.find("div").css("height",g),C.css("padding-left",E.opts.tableResizerOffset),C.css("padding-right",E.opts.tableResizerOffset),C.show()}else E.core.sameInstance(C)&&W()}}function L(e,t){if(E.$box.find(".fr-line-breaker").is(":visible"))return!1;o||q(),E.$box.append(o),o.data("instance",E);var a,l=Z(t).find("tr:first"),s=e.pageX,n=0,r=0;E.opts.iframe&&(n+=E.$iframe.offset().left-E.helpers.scrollLeft(),r+=E.$iframe.offset().top-E.helpers.scrollTop()),l.find("th, td").each(function(){var e=Z(this);return e.offset().left<=s&&s<e.offset().left+e.outerWidth()/2?(a=parseInt(o.find("a").css("width"),10),o.css("top",r+e.offset().top-E.$box.offset().top-E.win.pageYOffset-a-5),o.css("left",n+e.offset().left-E.$box.offset().left-E.win.pageXOffset-a/2),o.data("selected-cell",e),o.data("position","before"),o.addClass("fr-visible"),!1):e.offset().left+e.outerWidth()/2<=s&&s<e.offset().left+e.outerWidth()?(a=parseInt(o.find("a").css("width"),10),o.css("top",r+e.offset().top-E.$box.offset().top-E.win.pageYOffset-a-5),o.css("left",n+e.offset().left-E.$box.offset().left+e.outerWidth()-E.win.pageXOffset-a/2),o.data("selected-cell",e),o.data("position","after"),o.addClass("fr-visible"),!1):void 0})}function H(e,t){if(E.$box.find(".fr-line-breaker").is(":visible"))return!1;o||q(),E.$box.append(o),o.data("instance",E);var a,l=Z(t),s=e.pageY,n=0,r=0;E.opts.iframe&&(n+=E.$iframe.offset().left-E.helpers.scrollLeft(),r+=E.$iframe.offset().top-E.helpers.scrollTop()),l.find("tr").each(function(){var e=Z(this);return e.offset().top<=s&&s<e.offset().top+e.outerHeight()/2?(a=parseInt(o.find("a").css("width"),10),o.css("top",r+e.offset().top-E.$box.offset().top-E.win.pageYOffset-a/2),o.css("left",n+e.offset().left-E.$box.offset().left-E.win.pageXOffset-a-5),o.data("selected-cell",e.find("td:first")),o.data("position","above"),o.addClass("fr-visible"),!1):e.offset().top+e.outerHeight()/2<=s&&s<e.offset().top+e.outerHeight()?(a=parseInt(o.find("a").css("width"),10),o.css("top",r+e.offset().top-E.$box.offset().top+e.outerHeight()-E.win.pageYOffset-a/2),o.css("left",n+e.offset().left-E.$box.offset().left-E.win.pageXOffset-a-5),o.data("selected-cell",e.find("td:first")),o.data("position","below"),o.addClass("fr-visible"),!1):void 0})}function Y(e){r=null;var t=E.doc.elementFromPoint(e.pageX-E.win.pageXOffset,e.pageY-E.win.pageYOffset);E.opts.tableResizer&&(!E.popups.areVisible()||E.popups.areVisible()&&E.popups.isVisible("table.edit"))&&K(e,t),!E.opts.tableInsertHelper||E.popups.areVisible()||E.$tb.hasClass("fr-inline")&&E.$tb.is(":visible")||function(e,t){if(0===J().length){var a,l,s;if(t&&("HTML"==t.tagName||"BODY"==t.tagName||E.node.isElement(t)))for(a=1;a<=E.opts.tableInsertHelperOffset;a++){if(l=E.doc.elementFromPoint(e.pageX-E.win.pageXOffset,e.pageY-E.win.pageYOffset+a),Z(l).hasClass("fr-tooltip"))return;if(l&&("TH"==l.tagName||"TD"==l.tagName||"TABLE"==l.tagName)&&(Z(l).parents(".fr-wrapper").length||E.opts.iframe))return L(e,Z(l).closest("table"));if(s=E.doc.elementFromPoint(e.pageX-E.win.pageXOffset+a,e.pageY-E.win.pageYOffset),Z(s).hasClass("fr-tooltip"))return;if(s&&("TH"==s.tagName||"TD"==s.tagName||"TABLE"==s.tagName)&&(Z(s).parents(".fr-wrapper").length||E.opts.iframe))return H(e,Z(s).closest("table"))}E.core.sameInstance(o)&&k()}}(e,t)}function P(){if(w){var e=C.data("table").offset().top-E.win.pageYOffset;E.opts.iframe&&(e+=E.$iframe.offset().top-E.helpers.scrollTop()),C.css("top",e)}}function j(e,t){var a,l=Z(t[0][e]).outerWidth();for(a=1;a<t.length;a++)l=Math.min(l,Z(t[a][e]).outerWidth());return l}function V(e,t,a){var l,s=0;for(l=e;l<=t;l++)s+=j(l,a);return s}function X(e){if(1<J().length&&n&&y(),!1===n&&!1===s&&!1===w)r&&clearTimeout(r),E.edit.isDisabled()&&!E.popups.isVisible("table.edit")||(r=setTimeout(Y,30,e));else if(w){var t=e.pageX-E.win.pageXOffset;E.opts.iframe&&(t+=E.$iframe.offset().left);var a=C.data("max-left"),l=C.data("max-right");a<=t&&t<=l?C.css("left",t-E.opts.tableResizerOffset-E.$wp.offset().left):t<a&&parseFloat(C.css("left"),10)>a-E.opts.tableResizerOffset?C.css("left",a-E.opts.tableResizerOffset-E.$wp.offset().left):l<t&&parseFloat(C.css("left"),10)<l-E.opts.tableResizerOffset&&C.css("left",l-E.opts.tableResizerOffset-E.$wp.offset().left)}else n&&k()}function U(e){E.node.isEmpty(e.get(0))?e.prepend(Z.FE.MARKERS):e.prepend(Z.FE.START_MARKER).append(Z.FE.END_MARKER)}function q(){E.shared.$ti_helper||(E.shared.$ti_helper=Z('<div class="fr-insert-helper"><a class="fr-floating-btn" role="button" tabIndex="-1" title="'+E.language.translate("Insert")+'"><svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M22,16.75 L16.75,16.75 L16.75,22 L15.25,22.000 L15.25,16.75 L10,16.75 L10,15.25 L15.25,15.25 L15.25,10 L16.75,10 L16.75,15.25 L22,15.25 L22,16.75 Z"/></svg></a></div>'),E.events.bindClick(E.shared.$ti_helper,"a",function(){var e=o.data("selected-cell"),t=o.data("position"),a=o.data("instance")||E;"before"==t?(E.undo.saveStep(),e.addClass("fr-selected-cell"),a.table.insertColumn(t),e.removeClass("fr-selected-cell"),E.undo.saveStep()):"after"==t?(E.undo.saveStep(),e.addClass("fr-selected-cell"),a.table.insertColumn(t),e.removeClass("fr-selected-cell"),E.undo.saveStep()):"above"==t?(E.undo.saveStep(),e.addClass("fr-selected-cell"),a.table.insertRow(t),e.removeClass("fr-selected-cell"),E.undo.saveStep()):"below"==t&&(E.undo.saveStep(),e.addClass("fr-selected-cell"),a.table.insertRow(t),e.removeClass("fr-selected-cell"),E.undo.saveStep()),k()}),E.events.on("shared.destroy",function(){E.shared.$ti_helper.html("").removeData().remove(),E.shared.$ti_helper=null},!0),E.events.$on(E.shared.$ti_helper,"mousemove",function(e){e.stopPropagation()},!0),E.events.$on(Z(E.o_win),"scroll",function(){k()},!0),E.events.$on(E.$wp,"scroll",function(){k()},!0)),o=E.shared.$ti_helper,E.events.on("destroy",function(){o=null}),E.tooltip.bind(E.$box,".fr-insert-helper > a.fr-floating-btn")}function G(){l=null,clearTimeout(r)}function J(){return E.el.querySelectorAll(".fr-selected-cell")}function Q(){var e=J();if(e.length){for(var t=e[0];t&&"TABLE"!=t.tagName&&t.parentNode!=E.el;)t=t.parentNode;return t&&"TABLE"==t.tagName?Z(t):Z([])}return Z([])}return{_init:function(){if(!E.$wp)return!1;if(!E.helpers.isMobile()){w=s=n=!1,E.events.$on(E.$el,"mousedown",e),E.popups.onShow("image.edit",function(){D(),s=n=!1}),E.popups.onShow("link.edit",function(){D(),s=n=!1}),E.events.on("commands.mousedown",function(e){0<e.parents(".fr-toolbar").length&&D()}),E.events.$on(E.$el,"mouseenter","th, td",N),E.events.$on(E.$win,"mouseup",a),E.opts.iframe&&E.events.$on(Z(E.o_win),"mouseup",a),E.events.$on(E.$win,"mousemove",X),E.events.$on(Z(E.o_win),"scroll",P),E.events.on("contentChanged",function(){0<J().length&&(h(),E.$el.find("img").on("load.selected-cells",function(){Z(this).off("load.selected-cells"),0<J().length&&h()}))}),E.events.$on(Z(E.o_win),"resize",function(){D()}),E.events.on("toolbar.esc",function(){if(0<J().length)return E.events.disableBlur(),E.events.focus(),!1},!0),E.events.$on(Z(E.o_win),"keydown",function(){n&&s&&(s=n=!1,E.$el.removeClass("fr-no-selection"),E.edit.on(),E.selection.setAtEnd(E.$el.find(".fr-selected-cell:last").get(0)),E.selection.restore(),D())}),E.events.$on(E.$el,"keydown",function(e){e.shiftKey?!1===function(e){var t=J();if(0<t.length){var a,l,s=O(),n=e.which;1==t.length?l=a=t[0]:(a=E.el.querySelector(".fr-cell-fixed"),l=E.el.querySelector(".fr-cell-handler"));var r=A(l,s);if(Z.FE.KEYCODE.ARROW_RIGHT==n){if(r.col<s[0].length-1)return _(a,s[r.row][r.col+1]),!1}else if(Z.FE.KEYCODE.ARROW_DOWN==n){if(r.row<s.length-1)return _(a,s[r.row+1][r.col]),!1}else if(Z.FE.KEYCODE.ARROW_LEFT==n){if(0<r.col)return _(a,s[r.row][r.col-1]),!1}else if(Z.FE.KEYCODE.ARROW_UP==n&&0<r.row)return _(a,s[r.row-1][r.col]),!1}}(e)&&setTimeout(function(){h()},0):function(e){var t=e.which,a=E.selection.blocks();if(a.length&&("TD"==(a=a[0]).tagName||"TH"==a.tagName)){for(var l=a;l&&"TABLE"!=l.tagName&&l.parentNode!=E.el;)l=l.parentNode;if(l&&"TABLE"==l.tagName&&(Z.FE.KEYCODE.ARROW_LEFT==t||Z.FE.KEYCODE.ARROW_UP==t||Z.FE.KEYCODE.ARROW_RIGHT==t||Z.FE.KEYCODE.ARROW_DOWN==t)&&(0<J().length&&T(),E.browser.webkit&&(Z.FE.KEYCODE.ARROW_UP==t||Z.FE.KEYCODE.ARROW_DOWN==t))){var s=E.selection.ranges(0).startContainer;if(s.nodeType==Node.TEXT_NODE&&(Z.FE.KEYCODE.ARROW_UP==t&&s.previousSibling||Z.FE.KEYCODE.ARROW_DOWN==t&&s.nextSibling))return;e.preventDefault(),e.stopPropagation();var n=O(Z(l)),r=A(a,n);Z.FE.KEYCODE.ARROW_UP==t?z(r,l,n):Z.FE.KEYCODE.ARROW_DOWN==t&&B(r,l,n),E.selection.restore()}}}(e)}),E.events.on("keydown",function(e){if(!1===function(e){if(e.which==Z.FE.KEYCODE.TAB){var t;if(0<J().length)t=E.$el.find(".fr-selected-cell:last");else{var a=E.selection.element();"TD"==a.tagName||"TH"==a.tagName?t=Z(a):a!=E.el&&(0<Z(a).parentsUntil(E.$el,"td").length?t=Z(a).parents("td:first"):0<Z(a).parentsUntil(E.$el,"th").length&&(t=Z(a).parents("th:first")))}if(t)return e.preventDefault(),!!(0<Z(E.selection.element()).parentsUntil(E.$el,"ol, ul").length&&(0<Z(E.selection.element()).parents("li").prev().length||Z(E.selection.element()).is("li")&&0<Z(E.selection.element()).prev().length))||(T(),e.shiftKey?0<t.prev().length?U(t.prev()):0<t.closest("tr").length&&0<t.closest("tr").prev().length?U(t.closest("tr").prev().find("td:last")):0<t.closest("tbody").length&&0<t.closest("table").find("thead tr").length&&U(t.closest("table").find("thead tr th:last")):0<t.next().length?U(t.next()):0<t.closest("tr").length&&0<t.closest("tr").next().length?U(t.closest("tr").next().find("td:first")):0<t.closest("thead").length&&0<t.closest("table").find("tbody tr").length?U(t.closest("table").find("tbody tr td:first")):(t.addClass("fr-selected-cell"),b("below"),D(),U(t.closest("tr").next().find("td:first"))),E.selection.restore(),!1)}}(e))return!1;var t=J();if(0<t.length){if(0<t.length&&E.keys.ctrlKey(e)&&e.which==Z.FE.KEYCODE.A)return D(),E.popups.isVisible("table.edit")&&E.popups.hide("table.edit"),t=[],!0;if(e.which==Z.FE.KEYCODE.ESC&&E.popups.isVisible("table.edit"))return D(),E.popups.hide("table.edit"),e.preventDefault(),e.stopPropagation(),e.stopImmediatePropagation(),!(t=[]);if(1<t.length&&(e.which==Z.FE.KEYCODE.BACKSPACE||e.which==Z.FE.KEYCODE.DELETE)){E.undo.saveStep();for(var a=0;a<t.length;a++)Z(t[a]).html("<br>"),a==t.length-1&&Z(t[a]).prepend(Z.FE.MARKERS);return E.selection.restore(),E.undo.saveStep(),!(t=[])}if(1<t.length&&e.which!=Z.FE.KEYCODE.F10&&!E.keys.isBrowserAction(e))return e.preventDefault(),!(t=[])}else if(!(t=[])===function(e){if(e.altKey&&e.which==Z.FE.KEYCODE.SPACE){var t,a=E.selection.element();if("TD"==a.tagName||"TH"==a.tagName?t=a:0<Z(a).closest("td").length?t=Z(a).closest("td").get(0):0<Z(a).closest("th").length&&(t=Z(a).closest("th").get(0)),t)return e.preventDefault(),_(t,t),h(),!1}}(e))return!1},!0);var t=[];E.events.on("html.beforeGet",function(){t=J();for(var e=0;e<t.length;e++)t[e].className=(t[e].className||"").replace(/fr-selected-cell/g,"")}),E.events.on("html.afterGet",function(){for(var e=0;e<t.length;e++)t[e].className=(t[e].className?t[e].className.trim()+" ":"")+"fr-selected-cell";t=[]}),c(!0),p(!0)}E.events.on("destroy",G)},insert:function(e,t){var a,l,s="<table "+(E.opts.tableDefaultWidth?'style="width: '+E.opts.tableDefaultWidth+';" ':"")+'class="fr-inserted-table"><tbody>',n=100/t;for(a=0;a<e;a++){for(s+="<tr>",l=0;l<t;l++)s+="<td"+(E.opts.tableDefaultWidth?' style="width: '+n.toFixed(4)+'%;"':"")+">",0===a&&0===l&&(s+=Z.FE.MARKERS),s+="<br></td>";s+="</tr>"}s+="</tbody></table>",E.html.insert(s),E.selection.restore();var r=E.$el.find(".fr-inserted-table");r.removeClass("fr-inserted-table"),E.events.trigger("table.inserted",[r.get(0)])},remove:u,insertRow:b,deleteRow:function(){var e=Q();if(0<e.length){var t,a,l,s=O(),n=$(s);if(0===n.min_i&&n.max_i==s.length-1)u();else{for(t=n.max_i;t>=n.min_i;t--){for(l=Z(e.find("tr").not(e.find("table tr")).get(t)),a=0;a<s[t].length;a++)if(0===a||s[t][a]!=s[t][a-1]){var r=Z(s[t][a]);if(1<parseInt(r.attr("rowspan"),10)){var o=parseInt(r.attr("rowspan"),10)-1;1==o?r.removeAttr("rowspan"):r.attr("rowspan",o)}if(t<s.length-1&&s[t][a]==s[t+1][a]&&(0===t||s[t][a]!=s[t-1][a])){for(var i=s[t][a],f=a;0<f&&s[t][f]==s[t][f-1];)f--;0===f?Z(e.find("tr").not(e.find("table tr")).get(t+1)).prepend(i):Z(s[t+1][f-1]).after(i)}}var c=l.parent();l.remove(),0===c.find("tr").length&&c.remove(),s=O(e)}R(0,s.length-1,0,s[0].length-1,e),0<n.min_i?E.selection.setAtEnd(s[n.min_i-1][0]):E.selection.setAtEnd(s[0][0]),E.selection.restore(),E.popups.hide("table.edit")}}},insertColumn:function(i){var e=Q();if(0<e.length){var f,c=O(),t=$(c);f="before"==i?t.min_j:t.max_j;var a,d=100/c[0].length,p=100/(c[0].length+1);e.find("th, td").each(function(){(a=Z(this)).data("old-width",a.outerWidth()/e.outerWidth()*100)}),e.find("tr").not(e.find("table tr")).each(function(e){for(var t,a=Z(this),l=0,s=0;l-1<f;){if(!(t=a.find("> th, > td").get(s))){t=null;break}t==c[e][l]?(l+=parseInt(Z(t).attr("colspan"),10)||1,s++):(l+=parseInt(Z(c[e][l]).attr("colspan"),10)||1,"after"==i&&(t=0===s?-1:a.find("> th, > td").get(s-1)))}var n,r=Z(t);if("after"==i&&f<l-1||"before"==i&&0<f&&c[e][f]==c[e][f-1]){if(0===e||0<e&&c[e][f]!=c[e-1][f]){var o=parseInt(r.attr("colspan"),10)+1;r.attr("colspan",o),r.css("width",(r.data("old-width")*p/d+p).toFixed(4)+"%"),r.removeData("old-width")}}else n=0<a.find("th").length?'<th style="width: '+p.toFixed(4)+'%;"><br></th>':'<td style="width: '+p.toFixed(4)+'%;"><br></td>',-1==t?a.prepend(n):null==t?a.append(n):"before"==i?r.before(n):"after"==i&&r.after(n)}),e.find("th, td").each(function(){(a=Z(this)).data("old-width")&&(a.css("width",(a.data("old-width")*p/d).toFixed(4)+"%"),a.removeData("old-width"))}),E.popups.isVisible("table.edit")&&h()}},deleteColumn:function(){var e=Q();if(0<e.length){var t,a,l,s=O(),n=$(s);if(0===n.min_j&&n.max_j==s[0].length-1)u();else{var r=0;for(t=0;t<s.length;t++)for(a=0;a<s[0].length;a++)(l=Z(s[t][a])).hasClass("fr-selected-cell")||(l.data("old-width",l.outerWidth()/e.outerWidth()*100),(a<n.min_j||a>n.max_j)&&(r+=l.outerWidth()/e.outerWidth()*100));for(r/=s.length,a=n.max_j;a>=n.min_j;a--)for(t=0;t<s.length;t++)if(0===t||s[t][a]!=s[t-1][a])if(l=Z(s[t][a]),1<(parseInt(l.attr("colspan"),10)||1)){var o=parseInt(l.attr("colspan"),10)-1;1==o?l.removeAttr("colspan"):l.attr("colspan",o),l.css("width",(100*(l.data("old-width")-j(a,s))/r).toFixed(4)+"%"),l.removeData("old-width")}else{var i=Z(l.parent().get(0));l.remove(),0===i.find("> th, > td").length&&(0===i.prev().length||0===i.next().length||i.prev().find("> th[rowspan], > td[rowspan]").length<i.prev().find("> th, > td").length)&&i.remove()}R(0,s.length-1,0,s[0].length-1,e),0<n.min_j?E.selection.setAtEnd(s[n.min_i][n.min_j-1]):E.selection.setAtEnd(s[n.min_i][0]),E.selection.restore(),E.popups.hide("table.edit"),e.find("th, td").each(function(){(l=Z(this)).data("old-width")&&(l.css("width",(100*l.data("old-width")/r).toFixed(4)+"%"),l.removeData("old-width"))})}}},mergeCells:function(){if(1<J().length&&(0===E.$el.find("th.fr-selected-cell").length||0===E.$el.find("td.fr-selected-cell").length)){x();var e,t,a=$(O()),l=E.$el.find(".fr-selected-cell"),s=Z(l[0]),n=s.parent().find(".fr-selected-cell"),r=s.closest("table"),o=s.html(),i=0;for(e=0;e<n.length;e++)i+=Z(n[e]).outerWidth();for(s.css("width",Math.min(100,i/r.outerWidth()*100).toFixed(4)+"%"),a.min_j<a.max_j&&s.attr("colspan",a.max_j-a.min_j+1),a.min_i<a.max_i&&s.attr("rowspan",a.max_i-a.min_i+1),e=1;e<l.length;e++)"<br>"!=(t=Z(l[e])).html()&&""!==t.html()&&(o+="<br>"+t.html()),t.remove();s.html(o),E.selection.setAtEnd(s.get(0)),E.selection.restore(),E.toolbar.enable(),m(a.min_i,a.max_i,r);var f=r.find("tr:empty");for(e=f.length-1;0<=e;e--)Z(f[e]).remove();g(a.min_j,a.max_j,r),h()}},splitCellVertically:function(){if(1==J().length){var e=E.$el.find(".fr-selected-cell"),t=parseInt(e.attr("colspan"),10)||1,a=e.parent().outerWidth(),l=e.outerWidth(),s=e.clone().html("<br>"),n=O(),r=A(e.get(0),n);if(1<t){var o=Math.ceil(t/2);l=V(r.col,r.col+o-1,n)/a*100;var i=V(r.col+o,r.col+t-1,n)/a*100;1<o?e.attr("colspan",o):e.removeAttr("colspan"),1<t-o?s.attr("colspan",t-o):s.removeAttr("colspan"),e.css("width",l.toFixed(4)+"%"),s.css("width",i.toFixed(4)+"%")}else{var f;for(f=0;f<n.length;f++)if(0===f||n[f][r.col]!=n[f-1][r.col]){var c=Z(n[f][r.col]);if(!c.is(e)){var d=(parseInt(c.attr("colspan"),10)||1)+1;c.attr("colspan",d)}}l=l/a*100/2,e.css("width",l.toFixed(4)+"%"),s.css("width",l.toFixed(4)+"%")}e.after(s),D(),E.popups.hide("table.edit")}},splitCellHorizontally:function(){if(1==J().length){var e=E.$el.find(".fr-selected-cell"),t=e.parent(),a=e.closest("table"),l=parseInt(e.attr("rowspan"),10),s=O(),n=A(e.get(0),s),r=e.clone().html("<br>");if(1<l){var o=Math.ceil(l/2);1<o?e.attr("rowspan",o):e.removeAttr("rowspan"),1<l-o?r.attr("rowspan",l-o):r.removeAttr("rowspan");for(var i=n.row+o,f=0===n.col?n.col:n.col-1;0<=f&&(s[i][f]==s[i][f-1]||0<i&&s[i][f]==s[i-1][f]);)f--;-1==f?Z(a.find("tr").not(a.find("table tr")).get(i)).prepend(r):Z(s[i][f]).after(r)}else{var c,d=Z("<tr>").append(r);for(c=0;c<s[0].length;c++)if(0===c||s[n.row][c]!=s[n.row][c-1]){var p=Z(s[n.row][c]);p.is(e)||p.attr("rowspan",(parseInt(p.attr("rowspan"),10)||1)+1)}t.after(d)}D(),E.popups.hide("table.edit")}},addHeader:function(){var e=Q();if(0<e.length&&0===e.find("th").length){var t,a="<thead><tr>",l=0;for(e.find("tr:first > td").each(function(){var e=Z(this);l+=parseInt(e.attr("colspan"),10)||1}),t=0;t<l;t++)a+="<th><br></th>";a+="</tr></thead>",e.prepend(a),h()}},removeHeader:function(){var e=Q(),t=e.find("thead");if(0<t.length)if(0===e.find("tbody tr").length)u();else if(t.remove(),0<J().length)h();else{E.popups.hide("table.edit");var a=e.find("tbody tr:first td:first").get(0);a&&(E.selection.setAtEnd(a),E.selection.restore())}},setBackground:t,showInsertPopup:function(){var e=E.$tb.find('.fr-command[data-cmd="insertTable"]'),t=E.popups.get("table.insert");if(t||(t=c()),!t.hasClass("fr-active")){E.popups.refresh("table.insert"),E.popups.setContainer("table.insert",E.$tb);var a=e.offset().left+e.outerWidth()/2,l=e.offset().top+(E.opts.toolbarBottom?10:e.outerHeight()-10);E.popups.show("table.insert",a,l,e.outerHeight())}},showEditPopup:h,showColorsPopup:f,back:function(){0<J().length?h():(E.popups.hide("table.insert"),E.toolbar.showInline())},verticalAlign:function(e){E.$el.find(".fr-selected-cell").css("vertical-align",e)},horizontalAlign:function(e){E.$el.find(".fr-selected-cell").css("text-align",e)},applyStyle:function(e,t,a,l){if(0<t.length){if(!a){var s=Object.keys(l);s.splice(s.indexOf(e),1),t.removeClass(s.join(" "))}t.toggleClass(e)}},selectedTable:Q,selectedCells:J,customColor:function(){var e=E.popups.get("table.colors").find(".fr-table-colors-hex-layer input");e.length&&t(e.val())},selectCells:_}},Z.FE.DefineIcon("insertTable",{NAME:"table"}),Z.FE.RegisterCommand("insertTable",{title:"Insert Table",undo:!1,focus:!0,refreshOnCallback:!1,popup:!0,callback:function(){this.popups.isVisible("table.insert")?(this.$el.find(".fr-marker").length&&(this.events.disableBlur(),this.selection.restore()),this.popups.hide("table.insert")):this.table.showInsertPopup()},plugin:"table"}),Z.FE.RegisterCommand("tableInsert",{callback:function(e,t,a){this.table.insert(t,a),this.popups.hide("table.insert")}}),Z.FE.DefineIcon("tableHeader",{NAME:"header",FA5NAME:"heading"}),Z.FE.RegisterCommand("tableHeader",{title:"Table Header",focus:!1,toggle:!0,callback:function(){this.popups.get("table.edit").find('.fr-command[data-cmd="tableHeader"]').hasClass("fr-active")?this.table.removeHeader():this.table.addHeader()},refresh:function(e){var t=this.table.selectedTable();0<t.length&&(0===t.find("th").length?e.removeClass("fr-active").attr("aria-pressed",!1):e.addClass("fr-active").attr("aria-pressed",!0))}}),Z.FE.DefineIcon("tableRows",{NAME:"bars"}),Z.FE.RegisterCommand("tableRows",{type:"dropdown",focus:!1,title:"Row",options:{above:"Insert row above",below:"Insert row below","delete":"Delete row"},html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=Z.FE.COMMANDS.tableRows.options;for(var a in t)t.hasOwnProperty(a)&&(e+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="tableRows" data-param1="'+a+'" title="'+this.language.translate(t[a])+'">'+this.language.translate(t[a])+"</a></li>");return e+="</ul>"},callback:function(e,t){"above"==t||"below"==t?this.table.insertRow(t):this.table.deleteRow()}}),Z.FE.DefineIcon("tableColumns",{NAME:"bars fa-rotate-90"}),Z.FE.RegisterCommand("tableColumns",{type:"dropdown",focus:!1,title:"Column",options:{before:"Insert column before",after:"Insert column after","delete":"Delete column"},html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=Z.FE.COMMANDS.tableColumns.options;for(var a in t)t.hasOwnProperty(a)&&(e+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="tableColumns" data-param1="'+a+'" title="'+this.language.translate(t[a])+'">'+this.language.translate(t[a])+"</a></li>");return e+="</ul>"},callback:function(e,t){"before"==t||"after"==t?this.table.insertColumn(t):this.table.deleteColumn()}}),Z.FE.DefineIcon("tableCells",{NAME:"square-o",FA5NAME:"square"}),Z.FE.RegisterCommand("tableCells",{type:"dropdown",focus:!1,title:"Cell",options:{merge:"Merge cells","vertical-split":"Vertical split","horizontal-split":"Horizontal split"},html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=Z.FE.COMMANDS.tableCells.options;for(var a in t)t.hasOwnProperty(a)&&(e+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="tableCells" data-param1="'+a+'" title="'+this.language.translate(t[a])+'">'+this.language.translate(t[a])+"</a></li>");return e+="</ul>"},callback:function(e,t){"merge"==t?this.table.mergeCells():"vertical-split"==t?this.table.splitCellVertically():this.table.splitCellHorizontally()},refreshOnShow:function(e,t){1<this.$el.find(".fr-selected-cell").length?(t.find('a[data-param1="vertical-split"]').addClass("fr-disabled").attr("aria-disabled",!0),t.find('a[data-param1="horizontal-split"]').addClass("fr-disabled").attr("aria-disabled",!0),t.find('a[data-param1="merge"]').removeClass("fr-disabled").attr("aria-disabled",!1)):(t.find('a[data-param1="merge"]').addClass("fr-disabled").attr("aria-disabled",!0),t.find('a[data-param1="vertical-split"]').removeClass("fr-disabled").attr("aria-disabled",!1),t.find('a[data-param1="horizontal-split"]').removeClass("fr-disabled").attr("aria-disabled",!1))}}),Z.FE.DefineIcon("tableRemove",{NAME:"trash"}),Z.FE.RegisterCommand("tableRemove",{title:"Remove Table",focus:!1,callback:function(){this.table.remove()}}),Z.FE.DefineIcon("tableStyle",{NAME:"paint-brush"}),Z.FE.RegisterCommand("tableStyle",{title:"Table Style",type:"dropdown",focus:!1,html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=this.opts.tableStyles;for(var a in t)t.hasOwnProperty(a)&&(e+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="tableStyle" data-param1="'+a+'" title="'+this.language.translate(t[a])+'">'+this.language.translate(t[a])+"</a></li>");return e+="</ul>"},callback:function(e,t){this.table.applyStyle(t,this.$el.find(".fr-selected-cell").closest("table"),this.opts.tableMultipleStyles,this.opts.tableStyles)},refreshOnShow:function(e,t){var a=this.$el.find(".fr-selected-cell").closest("table");a&&t.find(".fr-command").each(function(){var e=Z(this).data("param1"),t=a.hasClass(e);Z(this).toggleClass("fr-active",t).attr("aria-selected",t)})}}),Z.FE.DefineIcon("tableCellBackground",{NAME:"tint"}),Z.FE.RegisterCommand("tableCellBackground",{title:"Cell Background",focus:!1,popup:!0,callback:function(){this.table.showColorsPopup()}}),Z.FE.RegisterCommand("tableCellBackgroundColor",{undo:!0,focus:!1,callback:function(e,t){this.table.setBackground(t)}}),Z.FE.DefineIcon("tableBack",{NAME:"arrow-left"}),Z.FE.RegisterCommand("tableBack",{title:"Back",undo:!1,focus:!1,back:!0,callback:function(){this.table.back()},refresh:function(e){0!==this.table.selectedCells().length||this.opts.toolbarInline?(e.removeClass("fr-hidden"),e.next(".fr-separator").removeClass("fr-hidden")):(e.addClass("fr-hidden"),e.next(".fr-separator").addClass("fr-hidden"))}}),Z.FE.DefineIcon("tableCellVerticalAlign",{NAME:"arrows-v",FA5NAME:"arrows-alt-v"}),Z.FE.RegisterCommand("tableCellVerticalAlign",{type:"dropdown",focus:!1,title:"Vertical Align",options:{Top:"Align Top",Middle:"Align Middle",Bottom:"Align Bottom"},html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=Z.FE.COMMANDS.tableCellVerticalAlign.options;for(var a in t)t.hasOwnProperty(a)&&(e+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="tableCellVerticalAlign" data-param1="'+a.toLowerCase()+'" title="'+this.language.translate(t[a])+'">'+this.language.translate(a)+"</a></li>");return e+="</ul>"},callback:function(e,t){this.table.verticalAlign(t)},refreshOnShow:function(e,t){t.find('.fr-command[data-param1="'+this.$el.find(".fr-selected-cell").css("vertical-align")+'"]').addClass("fr-active").attr("aria-selected",!0)}}),Z.FE.DefineIcon("tableCellHorizontalAlign",{NAME:"align-left"}),Z.FE.DefineIcon("align-left",{NAME:"align-left"}),Z.FE.DefineIcon("align-right",{NAME:"align-right"}),Z.FE.DefineIcon("align-center",{NAME:"align-center"}),Z.FE.DefineIcon("align-justify",{NAME:"align-justify"}),Z.FE.RegisterCommand("tableCellHorizontalAlign",{type:"dropdown",focus:!1,title:"Horizontal Align",options:{left:"Align Left",center:"Align Center",right:"Align Right",justify:"Align Justify"},html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=Z.FE.COMMANDS.tableCellHorizontalAlign.options;for(var a in t)t.hasOwnProperty(a)&&(e+='<li role="presentation"><a class="fr-command fr-title" tabIndex="-1" role="option" data-cmd="tableCellHorizontalAlign" data-param1="'+a+'" title="'+this.language.translate(t[a])+'">'+this.icon.create("align-"+a)+'<span class="fr-sr-only">'+this.language.translate(t[a])+"</span></a></li>");return e+="</ul>"},callback:function(e,t){this.table.horizontalAlign(t)},refresh:function(e){var t=this.table.selectedCells();t.length&&e.find("> *:first").replaceWith(this.icon.create("align-"+this.helpers.getAlignment(Z(t[0]))))},refreshOnShow:function(e,t){t.find('.fr-command[data-param1="'+this.helpers.getAlignment(this.$el.find(".fr-selected-cell:first"))+'"]').addClass("fr-active").attr("aria-selected",!0)}}),Z.FE.DefineIcon("tableCellStyle",{NAME:"magic"}),Z.FE.RegisterCommand("tableCellStyle",{title:"Cell Style",type:"dropdown",focus:!1,html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=this.opts.tableCellStyles;for(var a in t)t.hasOwnProperty(a)&&(e+='<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="tableCellStyle" data-param1="'+a+'" title="'+this.language.translate(t[a])+'">'+this.language.translate(t[a])+"</a></li>");return e+="</ul>"},callback:function(e,t){this.table.applyStyle(t,this.$el.find(".fr-selected-cell"),this.opts.tableCellMultipleStyles,this.opts.tableCellStyles)},refreshOnShow:function(e,t){var a=this.$el.find(".fr-selected-cell:first");a&&t.find(".fr-command").each(function(){var e=Z(this).data("param1"),t=a.hasClass(e);Z(this).toggleClass("fr-active",t).attr("aria-selected",t)})}}),Z.FE.RegisterCommand("tableCellBackgroundCustomColor",{title:"OK",undo:!0,callback:function(){this.table.customColor()}}),Z.FE.DefineIcon("tableColorRemove",{NAME:"eraser"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(n){"function"==typeof define&&define.amd?define(["jquery"],n):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),n(t)}:n(window.jQuery)}(function(l){l.extend(l.FE.DEFAULTS,{saveInterval:1e4,saveURL:null,saveParams:{},saveParam:"body",saveMethod:"POST"}),l.FE.PLUGINS.save=function(i){var e=null,u=null,t=!1,v=1,f=2,n={};function d(e,t){i.events.trigger("save.error",[{code:e,message:n[e]},t])}function s(e){void 0===e&&(e=i.html.get());var t=e,n=i.events.trigger("save.before",[e]);if(!1===n)return!1;if("string"==typeof n&&(e=n),i.opts.saveURL){var s={};for(var o in i.opts.saveParams)if(i.opts.saveParams.hasOwnProperty(o)){var a=i.opts.saveParams[o];s[o]="function"==typeof a?a.call(this):a}var r={};r[i.opts.saveParam]=e,l.ajax({type:i.opts.saveMethod,url:i.opts.saveURL,data:l.extend(r,s),crossDomain:i.opts.requestWithCORS,xhrFields:{withCredentials:i.opts.requestWithCredentials},headers:i.opts.requestHeaders}).done(function(e){u=t,i.events.trigger("save.after",[e])}).fail(function(e){d(f,e.response||e.responseText)})}else d(v)}function o(){clearTimeout(e),e=setTimeout(function(){var e=i.html.get();(u!=e||t)&&(t=!1,s(u=e))},i.opts.saveInterval)}return n[v]="Missing saveURL option.",n[f]="Something went wrong during save.",{_init:function(){i.opts.saveInterval&&(u=i.html.get(),i.events.on("contentChanged",o),i.events.on("keydown destroy",function(){clearTimeout(e)}))},save:s,reset:function(){o(),t=!1},force:function(){t=!0}}},l.FE.DefineIcon("save",{NAME:"floppy-o",FA5NAME:"disk"}),l.FE.RegisterCommand("save",{title:"Save",undo:!1,focus:!1,refreshAfterCallback:!1,callback:function(){this.save.save()},plugin:"save"})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof module&&module.exports?module.exports=function(e,n){return n===undefined&&(n="undefined"!=typeof window?require("jquery"):require("jquery")(e)),t(n)}:t(window.jQuery)}(function(f){f.FE.URLRegEx="(^| |\\u00A0)("+f.FE.LinkRegEx+"|([a-z0-9+-_.]{1,}@[a-z0-9+-_.]{1,}\\.[a-z0-9+-_]{1,}))$",f.FE.PLUGINS.url=function(i){var l=null;function n(e,n,t){for(var r="";t.length&&"."==t[t.length-1];)r+=".",t=t.substring(0,t.length-1);var o=t;if(i.opts.linkConvertEmailAddress)i.helpers.isEmail(o)&&!/^mailto:.*/i.test(o)&&(o="mailto:"+o);else if(i.helpers.isEmail(o))return n+t;return/^((http|https|ftp|ftps|mailto|tel|sms|notes|data)\:)/i.test(o)||(o="//"+o),(n||"")+"<a"+(i.opts.linkAlwaysBlank?' target="_blank"':"")+(l?' rel="'+l+'"':"")+' data-fr-linked="true" href="'+o+'">'+t.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/&amp;/g,"&").replace(/&/g,"&amp;")+"</a>"+r}function a(){return new RegExp(f.FE.URLRegEx,"gi")}function s(e){return i.opts.linkAlwaysNoFollow&&(l="nofollow"),i.opts.linkAlwaysBlank&&(i.opts.linkNoOpener&&(l?l+=" noopener":l="noopener"),i.opts.linkNoReferrer&&(l?l+=" noreferrer":l="noreferrer")),e.replace(a(),n)}function p(e){var n=e.split(" ");return n[n.length-1]}function t(){var n=i.selection.ranges(0),t=n.startContainer;if(!t||t.nodeType!==Node.TEXT_NODE||n.startOffset!==(t.textContent||"").length)return!1;if(function e(n){return!!n&&("A"===n.tagName||!(!n.parentNode||n.parentNode==i.el)&&e(n.parentNode))}(t))return!1;if(a().test(p(t.textContent))){f(t).before(s(t.textContent));var r=f(t.parentNode).find("a[data-fr-linked]");r.removeAttr("data-fr-linked"),t.parentNode.removeChild(t),i.events.trigger("url.linked",[r.get(0)])}else if(t.textContent.split(" ").length<=2&&t.previousSibling&&"A"===t.previousSibling.tagName){var o=t.previousSibling.innerText+t.textContent;a().test(p(o))&&(f(t.previousSibling).replaceWith(s(o)),t.parentNode.removeChild(t))}}return{_init:function(){i.events.on("keypress",function(e){!i.selection.isCollapsed()||"."!=e.key&&")"!=e.key&&"("!=e.key||t()},!0),i.events.on("keydown",function(e){var n=e.which;!i.selection.isCollapsed()||n!=f.FE.KEYCODE.ENTER&&n!=f.FE.KEYCODE.SPACE||t()},!0),i.events.on("paste.beforeCleanup",function(e){if(i.helpers.isURL(e)){var n=null;return i.opts.linkAlwaysBlank&&(i.opts.linkNoOpener&&(n?n+=" noopener":n="noopener"),i.opts.linkNoReferrer&&(n?n+=" noreferrer":n="noreferrer")),"<a"+(i.opts.linkAlwaysBlank?' target="_blank"':"")+(n?' rel="'+n+'"':"")+' href="'+e+'" >'+e+"</a>"}})}}}});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

!function(i){"function"==typeof define&&define.amd?define(["jquery"],i):"object"==typeof module&&module.exports?module.exports=function(e,t){return t===undefined&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),i(t)}:i(window.jQuery)}(function(Z){Z.extend(Z.FE.POPUP_TEMPLATES,{"video.insert":"[_BUTTONS_][_BY_URL_LAYER_][_EMBED_LAYER_][_UPLOAD_LAYER_][_PROGRESS_BAR_]","video.edit":"[_BUTTONS_]","video.size":"[_BUTTONS_][_SIZE_LAYER_]"}),Z.extend(Z.FE.DEFAULTS,{videoAllowedTypes:["mp4","webm","ogg"],videoAllowedProviders:[".*"],videoDefaultAlign:"center",videoDefaultDisplay:"block",videoDefaultWidth:600,videoEditButtons:["videoReplace","videoRemove","|","videoDisplay","videoAlign","videoSize"],videoInsertButtons:["videoBack","|","videoByURL","videoEmbed","videoUpload"],videoMaxSize:52428800,videoMove:!0,videoResize:!0,videoSizeButtons:["videoBack","|"],videoSplitHTML:!1,videoTextNear:!0,videoUpload:!0,videoUploadMethod:"POST",videoUploadParam:"file",videoUploadParams:{},videoUploadToS3:!1,videoUploadURL:null}),Z.FE.VIDEO_PROVIDERS=[{test_regex:/^.*((youtu.be)|(youtube.com))\/((v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))?\??v?=?([^#\&\?]*).*/,url_regex:/(?:https?:\/\/)?(?:www\.)?(?:m\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=|embed\/)?([0-9a-zA-Z_\-]+)(.+)?/g,url_text:"https://www.youtube.com/embed/$1",html:'<iframe width="640" height="360" src="{url}?wmode=opaque" frameborder="0" allowfullscreen></iframe>',provider:"youtube"},{test_regex:/^.*(?:vimeo.com)\/(?:channels(\/\w+\/)?|groups\/*\/videos\/\u200b\d+\/|video\/|)(\d+)(?:$|\/|\?)/,url_regex:/(?:https?:\/\/)?(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:[a-zA-Z0-9_\-]+)?(\/[a-zA-Z0-9_\-]+)?/i,url_text:"https://player.vimeo.com/video/$1",html:'<iframe width="640" height="360" src="{url}" frameborder="0" allowfullscreen></iframe>',provider:"vimeo"},{test_regex:/^.+(dailymotion.com|dai.ly)\/(video|hub)?\/?([^_]+)[^#]*(#video=([^_&]+))?/,url_regex:/(?:https?:\/\/)?(?:www\.)?(?:dailymotion\.com|dai\.ly)\/(?:video|hub)?\/?(.+)/g,url_text:"https://www.dailymotion.com/embed/video/$1",html:'<iframe width="640" height="360" src="{url}" frameborder="0" allowfullscreen></iframe>',provider:"dailymotion"},{test_regex:/^.+(screen.yahoo.com)\/[^_&]+/,url_regex:"",url_text:"",html:'<iframe width="640" height="360" src="{url}?format=embed" frameborder="0" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" allowtransparency="true"></iframe>',provider:"yahoo"},{test_regex:/^.+(rutube.ru)\/[^_&]+/,url_regex:/(?:https?:\/\/)?(?:www\.)?(?:rutube\.ru)\/(?:video)?\/?(.+)/g,url_text:"https://rutube.ru/play/embed/$1",html:'<iframe width="640" height="360" src="{url}" frameborder="0" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" allowtransparency="true"></iframe>',provider:"rutube"},{test_regex:/^(?:.+)vidyard.com\/(?:watch)?\/?([^.&/]+)\/?(?:[^_.&]+)?/,url_regex:/^(?:.+)vidyard.com\/(?:watch)?\/?([^.&/]+)\/?(?:[^_.&]+)?/g,url_text:"https://play.vidyard.com/$1",html:'<iframe width="640" height="360" src="{url}" frameborder="0" allowfullscreen></iframe>',provider:"vidyard"}],Z.FE.VIDEO_EMBED_REGEX=/^\W*((<iframe.*><\/iframe>)|(<embed.*>))\W*$/i,Z.FE.PLUGINS.video=function(v){var a,f,p,u,o,i,l="https://i.froala.com/upload",d=2,c=3,h=4,g=5,m=6,r={};function b(){var e=v.popups.get("video.insert");e.find(".fr-video-by-url-layer input").val("").trigger("change");var t=e.find(".fr-video-embed-layer textarea");t.val("").trigger("change"),(t=e.find(".fr-video-upload-layer input")).val("").trigger("change")}function s(){var e=v.popups.get("video.edit");if(e||(e=function(){var e="";if(0<v.opts.videoEditButtons.length){e+='<div class="fr-buttons">',e+=v.button.buildList(v.opts.videoEditButtons);var t={buttons:e+="</div>"},i=v.popups.create("video.edit",t);return v.events.$on(v.$wp,"scroll.video-edit",function(){u&&v.popups.isVisible("video.edit")&&(v.events.disableBlur(),x(u))}),i}return!1}()),e){v.popups.setContainer("video.edit",v.$sc),v.popups.refresh("video.edit");var t=u.find("iframe, embed, video"),i=t.offset().left+t.outerWidth()/2,o=t.offset().top+t.outerHeight();v.popups.show("video.edit",i,o,t.outerHeight())}}function n(e){if(e)return v.popups.onRefresh("video.insert",b),v.popups.onHide("image.insert",j),!0;var t="";v.opts.videoUpload||v.opts.videoInsertButtons.splice(v.opts.videoInsertButtons.indexOf("videoUpload"),1),1<v.opts.videoInsertButtons.length&&(t='<div class="fr-buttons">'+v.button.buildList(v.opts.videoInsertButtons)+"</div>");var i,o="",r=v.opts.videoInsertButtons.indexOf("videoUpload"),s=v.opts.videoInsertButtons.indexOf("videoByURL"),n=v.opts.videoInsertButtons.indexOf("videoEmbed");0<=s&&(i=" fr-active",(r<s&&0<=r||n<s&&0<=n)&&(i=""),o='<div class="fr-video-by-url-layer fr-layer'+i+'" id="fr-video-by-url-layer-'+v.id+'"><div class="fr-input-line"><input id="fr-video-by-url-layer-text-'+v.id+'" type="text" placeholder="'+v.language.translate("Paste in a video URL")+'" tabIndex="1" aria-required="true"></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-submit" data-cmd="videoInsertByURL" tabIndex="2" role="button">'+v.language.translate("Insert")+"</button></div></div>");var a="";0<=n&&(i=" fr-active",(r<n&&0<=r||s<n&&0<=s)&&(i=""),a='<div class="fr-video-embed-layer fr-layer'+i+'" id="fr-video-embed-layer-'+v.id+'"><div class="fr-input-line"><textarea id="fr-video-embed-layer-text'+v.id+'" type="text" placeholder="'+v.language.translate("Embedded Code")+'" tabIndex="1" aria-required="true" rows="5"></textarea></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-submit" data-cmd="videoInsertEmbed" tabIndex="2" role="button">'+v.language.translate("Insert")+"</button></div></div>");var d="";0<=r&&(i=" fr-active",(n<r&&0<=n||s<r&&0<=s)&&(i=""),d='<div class="fr-video-upload-layer fr-layer'+i+'" id="fr-video-upload-layer-'+v.id+'"><strong>'+v.language.translate("Drop video")+"</strong><br>("+v.language.translate("or click")+')<div class="fr-form"><input type="file" accept="video/'+v.opts.videoAllowedTypes.join(", video/").toLowerCase()+'" tabIndex="-1" aria-labelledby="fr-video-upload-layer-'+v.id+'" role="button"></div></div>');var l={buttons:t,by_url_layer:o,embed_layer:a,upload_layer:d,progress_bar:'<div class="fr-video-progress-bar-layer fr-layer"><h3 tabIndex="-1" class="fr-message">Uploading</h3><div class="fr-loader"><span class="fr-progress"></span></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-dismiss" data-cmd="videoDismissError" tabIndex="2" role="button">OK</button></div></div>'},f=v.popups.create("video.insert",l);return function(o){v.events.$on(o,"dragover dragenter",".fr-video-upload-layer",function(){return Z(this).addClass("fr-drop"),!1},!0),v.events.$on(o,"dragleave dragend",".fr-video-upload-layer",function(){return Z(this).removeClass("fr-drop"),!1},!0),v.events.$on(o,"drop",".fr-video-upload-layer",function(e){e.preventDefault(),e.stopPropagation(),Z(this).removeClass("fr-drop");var t=e.originalEvent.dataTransfer;if(t&&t.files){var i=o.data("instance")||v;i.events.disableBlur(),i.video.upload(t.files),i.events.enableBlur()}},!0),v.helpers.isIOS()&&v.events.$on(o,"touchstart",'.fr-video-upload-layer input[type="file"]',function(){Z(this).trigger("click")},!0);v.events.$on(o,"change",'.fr-video-upload-layer input[type="file"]',function(){if(this.files){var e=o.data("instance")||v;e.events.disableBlur(),o.find("input:focus").blur(),e.events.enableBlur(),e.video.upload(this.files)}Z(this).val("")},!0)}(f),f}function y(e){v.events.focus(!0),v.selection.restore();var t=!1;u&&(K(),t=!0),v.html.insert('<span contenteditable="false" draggable="true" class="fr-jiv fr-video">'+e+"</span>",!1,v.opts.videoSplitHTML),v.popups.hide("video.insert");var i=v.$el.find(".fr-jiv");i.removeClass("fr-jiv"),W(i,v.opts.videoDefaultDisplay,v.opts.videoDefaultAlign),i.toggleClass("fr-draggable",v.opts.videoMove),v.events.trigger(t?"video.replaced":"video.inserted",[i])}function w(){var e=Z(this);v.popups.hide("video.insert"),e.removeClass("fr-uploading"),e.parent().next().is("br")&&e.parent().next().remove(),x(e.parent()),v.events.trigger("video.loaded",[e.parent()])}function E(a,e,d,l,f){v.edit.off(),_("Loading video"),e&&(a=v.helpers.sanitizeURL(a));C("Loading video"),function(){var e,t;if(l){v.undo.canDo()||l.find("video").hasClass("fr-uploading")||v.undo.saveStep();var i=l.find("video").data("fr-old-src"),o=l.data("fr-replaced");l.data("fr-replaced",!1),v.$wp?((e=l.clone()).find("video").removeData("fr-old-src").removeClass("fr-uploading"),e.find("video").off("canplay"),i&&l.find("video").attr("src",i),l.replaceWith(e)):e=l;for(var r=e.find("video").get(0).attributes,s=0;s<r.length;s++){var n=r[s];0===n.nodeName.indexOf("data-")&&e.find("video").removeAttr(n.nodeName)}if(void 0!==d)for(t in d)d.hasOwnProperty(t)&&"link"!=t&&e.find("video").attr("data-"+t,d[t]);e.find("video").on("canplay",w),e.find("video").attr("src",a),v.edit.on(),F(),v.undo.saveStep(),v.$el.blur(),v.events.trigger(o?"video.replaced":"video.inserted",[e,f])}else e=function(e,t,i){var o,r="";if(t&&void 0!==t)for(o in t)t.hasOwnProperty(o)&&"link"!=o&&(r+=" data-"+o+'="'+t[o]+'"');var s=v.opts.videoDefaultWidth;s&&"auto"!=s&&(s+="px");var n=Z('<span contenteditable="false" draggable="true" class="fr-video fr-dv'+v.opts.videoDefaultDisplay[0]+("center"!=v.opts.videoDefaultAlign?" fr-fv"+v.opts.videoDefaultAlign[0]:"")+'"><video src="'+e+'" '+r+(s?' style="width: '+s+';" ':"")+" controls>"+v.language.translate("Your browser does not support HTML5 video.")+"</video></span>");n.toggleClass("fr-draggable",v.opts.videoMove),v.edit.on(),v.events.focus(!0),v.selection.restore(),v.undo.saveStep(),v.opts.videoSplitHTML?v.markers.split():v.markers.insert(),v.html.wrap();var a=v.$el.find(".fr-marker");return v.node.isLastSibling(a)&&a.parent().hasClass("fr-deletable")&&a.insertAfter(a.parent()),a.replaceWith(n),v.selection.clear(),n.find("video").get(0).readyState>n.find("video").get(0).HAVE_FUTURE_DATA||v.helpers.isIOS()?i.call(n.find("video").get(0)):n.find("video").on("canplaythrough load",i),n}(a,d,w),F(),v.undo.saveStep(),v.events.trigger("video.inserted",[e,f])}()}function C(e){var t=v.popups.get("video.insert");if(t||(t=n()),t.find(".fr-layer.fr-active").removeClass("fr-active").addClass("fr-pactive"),t.find(".fr-video-progress-bar-layer").addClass("fr-active"),t.find(".fr-buttons").hide(),u){var i=u.find("video");v.popups.setContainer("video.insert",v.$sc);var o=i.offset().left+i.width()/2,r=i.offset().top+i.height();v.popups.show("video.insert",o,r,i.outerHeight())}void 0===e&&_(v.language.translate("Uploading"),0)}function A(e){var t=v.popups.get("video.insert");if(t&&(t.find(".fr-layer.fr-pactive").addClass("fr-active").removeClass("fr-pactive"),t.find(".fr-video-progress-bar-layer").removeClass("fr-active"),t.find(".fr-buttons").show(),e||v.$el.find("video.fr-error").length)){if(v.events.focus(),v.$el.find("video.fr-error").length&&(v.$el.find("video.fr-error").parent().remove(),v.undo.saveStep(),v.undo.run(),v.undo.dropRedo()),!v.$wp&&u){var i=u;z(!0),v.selection.setAfter(i.find("video").get(0)),v.selection.restore()}v.popups.hide("video.insert")}}function _(e,t){var i=v.popups.get("video.insert");if(i){var o=i.find(".fr-video-progress-bar-layer");o.find("h3").text(e+(t?" "+t+"%":"")),o.removeClass("fr-error"),t?(o.find("div").removeClass("fr-indeterminate"),o.find("div > span").css("width",t+"%")):o.find("div").addClass("fr-indeterminate")}}function x(e){O.call(e.get(0))}function R(e){_("Loading video");var t=this.status,i=this.response,o=this.responseXML,r=this.responseText;try{if(v.opts.videoUploadToS3)if(201==t){var s=function(e){try{var t=Z(e).find("Location").text(),i=Z(e).find("Key").text();return!1===v.events.trigger("video.uploadedToS3",[t,i,e],!0)?(v.edit.on(),!1):t}catch(o){return N(h,e),!1}}(o);s&&E(s,!1,[],e,i||o)}else N(h,i||o);else if(200<=t&&t<300){var n=function(e){try{if(!1===v.events.trigger("video.uploaded",[e],!0))return v.edit.on(),!1;var t=JSON.parse(e);return t.link?t:(N(d,e),!1)}catch(i){return N(h,e),!1}}(r);n&&E(n.link,!1,n,e,i||r)}else N(c,i||r)}catch(a){N(h,i||r)}}function S(){N(h,this.response||this.responseText||this.responseXML)}function D(e){if(e.lengthComputable){var t=e.loaded/e.total*100|0;_(v.language.translate("Uploading"),t)}}function U(){v.edit.on(),A(!0)}function I(e){if(!v.core.sameInstance(p))return!0;e.preventDefault(),e.stopPropagation();var t=e.pageX||(e.originalEvent.touches?e.originalEvent.touches[0].pageX:null),i=e.pageY||(e.originalEvent.touches?e.originalEvent.touches[0].pageY:null);if(!t||!i)return!1;if("mousedown"==e.type){var o=v.$oel.get(0).ownerDocument,r=o.defaultView||o.parentWindow,s=!1;try{s=r.location!=r.parent.location&&!(r.$&&r.$.FE)}catch(n){}s&&r.frameElement&&(t+=v.helpers.getPX(Z(r.frameElement).offset().left)+r.frameElement.clientLeft,i=e.clientY+v.helpers.getPX(Z(r.frameElement).offset().top)+r.frameElement.clientTop)}v.undo.canDo()||v.undo.saveStep(),(f=Z(this)).data("start-x",t),f.data("start-y",i),a.show(),v.popups.hideAll(),P()}function B(e){if(!v.core.sameInstance(p))return!0;if(f){e.preventDefault();var t=e.pageX||(e.originalEvent.touches?e.originalEvent.touches[0].pageX:null),i=e.pageY||(e.originalEvent.touches?e.originalEvent.touches[0].pageY:null);if(!t||!i)return!1;var o=f.data("start-x"),r=f.data("start-y");f.data("start-x",t),f.data("start-y",i);var s=t-o,n=i-r,a=u.find("iframe, embed, video"),d=a.width(),l=a.height();(f.hasClass("fr-hnw")||f.hasClass("fr-hsw"))&&(s=0-s),(f.hasClass("fr-hnw")||f.hasClass("fr-hne"))&&(n=0-n),a.css("width",d+s),a.css("height",l+n),a.removeAttr("width"),a.removeAttr("height"),L()}}function $(e){if(!v.core.sameInstance(p))return!0;f&&u&&(e&&e.stopPropagation(),f=null,a.hide(),L(),s(),v.undo.saveStep())}function t(e){return'<div class="fr-handler fr-h'+e+'"></div>'}function k(e,t,i,o){return e.pageX=t,e.pageY=t,I.call(this,e),e.pageX=e.pageX+i*Math.floor(Math.pow(1.1,o)),e.pageY=e.pageY+i*Math.floor(Math.pow(1.1,o)),B.call(this,e),$.call(this,e),++o}function F(){var e,t=Array.prototype.slice.call(v.el.querySelectorAll("video, .fr-video > *")),i=[];for(e=0;e<t.length;e++)i.push(t[e].getAttribute("src")),Z(t[e]).toggleClass("fr-draggable",v.opts.videoMove),""===t[e].getAttribute("class")&&t[e].removeAttribute("class"),""===t[e].getAttribute("style")&&t[e].removeAttribute("style");if(o)for(e=0;e<o.length;e++)i.indexOf(o[e].getAttribute("src"))<0&&v.events.trigger("video.removed",[Z(o[e])]);o=t}function L(){p||function(){var e;if(v.shared.$video_resizer?(p=v.shared.$video_resizer,a=v.shared.$vid_overlay,v.events.on("destroy",function(){p.removeClass("fr-active").appendTo(Z("body:first"))},!0)):(v.shared.$video_resizer=Z('<div class="fr-video-resizer"></div>'),p=v.shared.$video_resizer,v.events.$on(p,"mousedown",function(e){e.stopPropagation()},!0),v.opts.videoResize&&(p.append(t("nw")+t("ne")+t("sw")+t("se")),v.shared.$vid_overlay=Z('<div class="fr-video-overlay"></div>'),a=v.shared.$vid_overlay,e=p.get(0).ownerDocument,Z(e).find("body:first").append(a))),v.events.on("shared.destroy",function(){p.html("").removeData().remove(),p=null,v.opts.videoResize&&(a.remove(),a=null)},!0),v.helpers.isMobile()||v.events.$on(Z(v.o_win),"resize.video",function(){z(!0)}),v.opts.videoResize){e=p.get(0).ownerDocument,v.events.$on(p,v._mousedown,".fr-handler",I),v.events.$on(Z(e),v._mousemove,B),v.events.$on(Z(e.defaultView||e.parentWindow),v._mouseup,$),v.events.$on(a,"mouseleave",$);var o=1,r=null,s=0;v.events.on("keydown",function(e){if(u){var t=-1!=navigator.userAgent.indexOf("Mac OS X")?e.metaKey:e.ctrlKey,i=e.which;(i!==r||200<e.timeStamp-s)&&(o=1),(i==Z.FE.KEYCODE.EQUALS||v.browser.mozilla&&i==Z.FE.KEYCODE.FF_EQUALS)&&t&&!e.altKey?o=k.call(this,e,1,1,o):(i==Z.FE.KEYCODE.HYPHEN||v.browser.mozilla&&i==Z.FE.KEYCODE.FF_HYPHEN)&&t&&!e.altKey&&(o=k.call(this,e,2,-1,o)),r=i,s=e.timeStamp}}),v.events.on("keyup",function(){o=1})}}(),(v.$wp||v.$sc).append(p),p.data("instance",v);var e=u.find("iframe, embed, video");p.css("top",(v.opts.iframe?e.offset().top-1:e.offset().top-v.$wp.offset().top-1)+v.$wp.scrollTop()).css("left",(v.opts.iframe?e.offset().left-1:e.offset().left-v.$wp.offset().left-1)+v.$wp.scrollLeft()).css("width",e.get(0).getBoundingClientRect().width).css("height",e.get(0).getBoundingClientRect().height).addClass("fr-active")}function O(e){if(e&&"touchend"==e.type&&i)return!0;if(e&&v.edit.isDisabled())return e.stopPropagation(),e.preventDefault(),!1;if(v.edit.isDisabled())return!1;for(var t=0;t<Z.FE.INSTANCES.length;t++)Z.FE.INSTANCES[t]!=v&&Z.FE.INSTANCES[t].events.trigger("video.hideResizer");v.toolbar.disable(),v.helpers.isMobile()&&(v.events.disableBlur(),v.$el.blur(),v.events.enableBlur()),v.$el.find(".fr-video.fr-active").removeClass("fr-active"),(u=Z(this)).addClass("fr-active"),v.opts.iframe&&v.size.syncIframe(),G(),L(),s(),v.selection.clear(),v.button.bulkRefresh(),v.events.trigger("image.hideResizer")}function z(e){u&&(v.shared.vid_exit_flag||!0===e)&&(p.removeClass("fr-active"),v.toolbar.enable(),u.removeClass("fr-active"),u=null,P())}function e(){v.shared.vid_exit_flag=!0}function P(){v.shared.vid_exit_flag=!1}function T(e){var t=e.originalEvent.dataTransfer;if(t&&t.files&&t.files.length){var i=t.files[0];if(i&&i.type&&-1!==i.type.indexOf("video")){if(!v.opts.videoUpload)return e.preventDefault(),e.stopPropagation(),!1;v.markers.remove(),v.markers.insertAtPoint(e.originalEvent),v.$el.find(".fr-marker").replaceWith(Z.FE.MARKERS),v.popups.hideAll();var o=v.popups.get("video.insert");return o||(o=n()),v.popups.setContainer("video.insert",v.$sc),v.popups.show("video.insert",e.originalEvent.pageX,e.originalEvent.pageY),C(),0<=v.opts.videoAllowedTypes.indexOf(i.type.replace(/video\//g,""))?M(t.files):N(m),e.preventDefault(),e.stopPropagation(),!1}}}function M(e){if(void 0!==e&&0<e.length){if(!1===v.events.trigger("video.beforeUpload",[e]))return!1;var t,i=e[0];if(null===v.opts.videoUploadURL||v.opts.videoUploadURL==l)return a=i,(d=new FileReader).addEventListener("load",function(){d.result;for(var e=atob(d.result.split(",")[1]),t=[],i=0;i<e.length;i++)t.push(e.charCodeAt(i));E(window.URL.createObjectURL(new Blob([new Uint8Array(t)],{type:a.type})),!1,null,u)},!1),C(),d.readAsDataURL(a),!1;if(i.size>v.opts.videoMaxSize)return N(g),!1;if(v.opts.videoAllowedTypes.indexOf(i.type.replace(/video\//g,""))<0)return N(m),!1;if(v.drag_support.formdata&&(t=v.drag_support.formdata?new FormData:null),t){var o;if(!1!==v.opts.videoUploadToS3)for(o in t.append("key",v.opts.videoUploadToS3.keyStart+(new Date).getTime()+"-"+(i.name||"untitled")),t.append("success_action_status","201"),t.append("X-Requested-With","xhr"),t.append("Content-Type",i.type),v.opts.videoUploadToS3.params)v.opts.videoUploadToS3.params.hasOwnProperty(o)&&t.append(o,v.opts.videoUploadToS3.params[o]);for(o in v.opts.videoUploadParams)v.opts.videoUploadParams.hasOwnProperty(o)&&t.append(o,v.opts.videoUploadParams[o]);t.append(v.opts.videoUploadParam,i);var r=v.opts.videoUploadURL;v.opts.videoUploadToS3&&(r=v.opts.videoUploadToS3.uploadURL?v.opts.videoUploadToS3.uploadURL:"https://"+v.opts.videoUploadToS3.region+".amazonaws.com/"+v.opts.videoUploadToS3.bucket);var s=v.core.getXHR(r,v.opts.videoUploadMethod);s.onload=function(){R.call(s,u)},s.onerror=S,s.upload.onprogress=D,s.onabort=U,C(),v.events.disableBlur(),v.edit.off(),v.events.enableBlur();var n=v.popups.get("video.insert");n&&n.off("abortUpload").on("abortUpload",function(){4!=s.readyState&&s.abort()}),s.send(t)}}var a,d}function N(e,t){v.edit.on(),u&&u.find("video").addClass("fr-error"),function(e){C();var t=v.popups.get("video.insert").find(".fr-video-progress-bar-layer");t.addClass("fr-error");var i=t.find("h3");i.text(e),v.events.disableBlur(),i.focus()}(v.language.translate("Something went wrong. Please try again.")),v.events.trigger("video.error",[{code:e,message:r[e]},t])}function V(){if(u){var e=v.popups.get("video.size"),t=u.find("iframe, embed, video");e.find('input[name="width"]').val(t.get(0).style.width||t.attr("width")).trigger("change"),e.find('input[name="height"]').val(t.get(0).style.height||t.attr("height")).trigger("change")}}function Y(e){if(e)return v.popups.onRefresh("video.size",V),!0;var t={buttons:'<div class="fr-buttons">'+v.button.buildList(v.opts.videoSizeButtons)+"</div>",size_layer:'<div class="fr-video-size-layer fr-layer fr-active" id="fr-video-size-layer-'+v.id+'"><div class="fr-video-group"><div class="fr-input-line"><input id="fr-video-size-layer-width-'+v.id+'" type="text" name="width" placeholder="'+v.language.translate("Width")+'" tabIndex="1"></div><div class="fr-input-line"><input id="fr-video-size-layer-height-'+v.id+'" type="text" name="height" placeholder="'+v.language.translate("Height")+'" tabIndex="1"></div></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-submit" data-cmd="videoSetSize" tabIndex="2" role="button">'+v.language.translate("Update")+"</button></div></div>"},i=v.popups.create("video.size",t);return v.events.$on(v.$wp,"scroll",function(){u&&v.popups.isVisible("video.size")&&(v.events.disableBlur(),x(u))}),i}function H(e){if(void 0===e&&(e=u),e){if(e.hasClass("fr-fvl"))return"left";if(e.hasClass("fr-fvr"))return"right";if(e.hasClass("fr-dvb")||e.hasClass("fr-dvi"))return"center";if("block"==e.css("display")){if("left"==e.css("text-algin"))return"left";if("right"==e.css("text-align"))return"right"}else{if("left"==e.css("float"))return"left";if("right"==e.css("float"))return"right"}}return"center"}function X(e){void 0===e&&(e=u);var t=e.css("float");return e.css("float","none"),"block"==e.css("display")?(e.css("float",""),e.css("float")!=t&&e.css("float",t),"block"):(e.css("float",""),e.css("float")!=t&&e.css("float",t),"inline")}function K(){if(u&&!1!==v.events.trigger("video.beforeRemove",[u])){var e=u;v.popups.hideAll(),z(!0),v.selection.setBefore(e.get(0))||v.selection.setAfter(e.get(0)),e.remove(),v.selection.restore(),v.html.fillEmptyBlocks(),v.events.trigger("video.removed",[e])}}function j(){A()}function W(e,t,i){!v.opts.htmlUntouched&&v.opts.useClasses?(e.removeClass("fr-fvl fr-fvr fr-dvb fr-dvi"),e.addClass("fr-fv"+i[0]+" fr-dv"+t[0])):"inline"==t?(e.css({display:"inline-block"}),"center"==i?e.css({"float":"none"}):"left"==i?e.css({"float":"left"}):e.css({"float":"right"})):(e.css({display:"block",clear:"both"}),"left"==i?e.css({textAlign:"left"}):"right"==i?e.css({textAlign:"right"}):e.css({textAlign:"center"}))}function q(){v.$el.find("video").filter(function(){return 0===Z(this).parents("span.fr-video").length}).wrap('<span class="fr-video" contenteditable="false"></span>'),v.$el.find("embed, iframe").filter(function(){if(v.browser.safari&&this.getAttribute("src")&&this.setAttribute("src",this.src),0<Z(this).parents("span.fr-video").length)return!1;for(var e=Z(this).attr("src"),t=0;t<Z.FE.VIDEO_PROVIDERS.length;t++){var i=Z.FE.VIDEO_PROVIDERS[t];if(i.test_regex.test(e)&&new RegExp(v.opts.videoAllowedProviders.join("|")).test(i.provider))return!0}return!1}).map(function(){return 0===Z(this).parents("object").length?this:Z(this).parents("object").get(0)}).wrap('<span class="fr-video" contenteditable="false"></span>');for(var e,t,i=v.$el.find("span.fr-video, video"),o=0;o<i.length;o++){var r=Z(i[o]);!v.opts.htmlUntouched&&v.opts.useClasses?((t=r).hasClass("fr-dvi")||t.hasClass("fr-dvb")||(t.addClass("fr-fv"+H(t)[0]),t.addClass("fr-dv"+X(t)[0])),v.opts.videoTextNear||r.removeClass("fr-dvi").addClass("fr-dvb")):v.opts.htmlUntouched||v.opts.useClasses||(W(e=r,e.hasClass("fr-dvb")?"block":e.hasClass("fr-dvi")?"inline":null,e.hasClass("fr-fvl")?"left":e.hasClass("fr-fvr")?"right":H(e)),e.removeClass("fr-dvb fr-dvi fr-fvr fr-fvl"))}i.toggleClass("fr-draggable",v.opts.videoMove)}function G(){if(u){v.selection.clear();var e=v.doc.createRange();e.selectNode(u.get(0)),v.selection.get().addRange(e)}}return r[1]="Video cannot be loaded from the passed link.",r[d]="No link in upload response.",r[c]="Error during file upload.",r[h]="Parsing response failed.",r[g]="File is too large.",r[m]="Video file type is invalid.",r[7]="Files can be uploaded only to same domain in IE 8 and IE 9.",v.shared.vid_exit_flag=!1,{_init:function(){v.events.on("drop",T,!0),v.events.on("mousedown window.mousedown",e),v.events.on("window.touchmove",P),v.events.on("mouseup window.mouseup",z),v.events.on("commands.mousedown",function(e){0<e.parents(".fr-toolbar").length&&z()}),v.events.on("video.hideResizer commands.undo commands.redo element.dropped",function(){z(!0)}),v.helpers.isMobile()&&(v.events.$on(v.$el,"touchstart","span.fr-video",function(){i=!1}),v.events.$on(v.$el,"touchmove",function(){i=!0})),v.events.on("html.set",q),q(),v.events.$on(v.$el,"mousedown","span.fr-video",function(e){e.stopPropagation()}),v.events.$on(v.$el,"click touchend","span.fr-video",function(e){if("false"==Z(this).parents("[contenteditable]:not(.fr-element):not(.fr-img-caption):not(body):first").attr("contenteditable"))return!0;O.call(this,e)}),v.events.on("keydown",function(e){var t=e.which;return!u||t!=Z.FE.KEYCODE.BACKSPACE&&t!=Z.FE.KEYCODE.DELETE?u&&t==Z.FE.KEYCODE.ESC?(z(!0),e.preventDefault(),!1):u&&t!=Z.FE.KEYCODE.F10&&!v.keys.isBrowserAction(e)?(e.preventDefault(),!1):void 0:(e.preventDefault(),K(),v.undo.saveStep(),!1)},!0),v.events.on("toolbar.esc",function(){if(u)return v.events.disableBlur(),v.events.focus(),!1},!0),v.events.on("toolbar.focusEditor",function(){if(u)return!1},!0),v.events.on("keydown",function(){v.$el.find("span.fr-video:empty").remove()}),v.$wp&&(F(),v.events.on("contentChanged",F)),n(!0),Y(!0)},showInsertPopup:function(){var e=v.$tb.find('.fr-command[data-cmd="insertVideo"]'),t=v.popups.get("video.insert");if(t||(t=n()),A(),!t.hasClass("fr-active"))if(v.popups.refresh("video.insert"),v.popups.setContainer("video.insert",v.$tb),e.is(":visible")){var i=e.offset().left+e.outerWidth()/2,o=e.offset().top+(v.opts.toolbarBottom?10:e.outerHeight()-10);v.popups.show("video.insert",i,o,e.outerHeight())}else v.position.forSelection(t),v.popups.show("video.insert")},showLayer:function(e){var t,i,o=v.popups.get("video.insert");if(!u&&!v.opts.toolbarInline){var r=v.$tb.find('.fr-command[data-cmd="insertVideo"]');t=r.offset().left+r.outerWidth()/2,i=r.offset().top+(v.opts.toolbarBottom?10:r.outerHeight()-10)}v.opts.toolbarInline&&(i=o.offset().top-v.helpers.getPX(o.css("margin-top")),o.hasClass("fr-above")&&(i+=o.outerHeight())),o.find(".fr-layer").removeClass("fr-active"),o.find(".fr-"+e+"-layer").addClass("fr-active"),v.popups.show("video.insert",t,i,0),v.accessibility.focusPopup(o)},refreshByURLButton:function(e){v.popups.get("video.insert").find(".fr-video-by-url-layer").hasClass("fr-active")&&e.addClass("fr-active").attr("aria-pressed",!0)},refreshEmbedButton:function(e){v.popups.get("video.insert").find(".fr-video-embed-layer").hasClass("fr-active")&&e.addClass("fr-active").attr("aria-pressed",!0)},refreshUploadButton:function(e){v.popups.get("video.insert").find(".fr-video-upload-layer").hasClass("fr-active")&&e.addClass("fr-active").attr("aria-pressed",!0)},upload:M,insertByURL:function(e){void 0===e&&(e=(v.popups.get("video.insert").find('.fr-video-by-url-layer input[type="text"]').val()||"").trim());var t=null;if(/^http/.test(e)||(e="https://"+e),v.helpers.isURL(e))for(var i=0;i<Z.FE.VIDEO_PROVIDERS.length;i++){var o=Z.FE.VIDEO_PROVIDERS[i];if(o.test_regex.test(e)&&new RegExp(v.opts.videoAllowedProviders.join("|")).test(o.provider)){t=e.replace(o.url_regex,o.url_text),t=o.html.replace(/\{url\}/,t);break}}t?y(t):v.events.trigger("video.linkError",[e])},insertEmbed:function(e){void 0===e&&(e=v.popups.get("video.insert").find(".fr-video-embed-layer textarea").val()||""),0!==e.length&&Z.FE.VIDEO_EMBED_REGEX.test(e)?y(e):v.events.trigger("video.codeError",[e])},insert:y,align:function(e){u.removeClass("fr-fvr fr-fvl"),!v.opts.htmlUntouched&&v.opts.useClasses?"left"==e?u.addClass("fr-fvl"):"right"==e&&u.addClass("fr-fvr"):W(u,X(),e),G(),L(),s(),v.selection.clear()},refreshAlign:function(e){if(!u)return!1;e.find("> *:first").replaceWith(v.icon.create("video-align-"+H()))},refreshAlignOnShow:function(e,t){u&&t.find('.fr-command[data-param1="'+H()+'"]').addClass("fr-active").attr("aria-selected",!0)},display:function(e){u.removeClass("fr-dvi fr-dvb"),!v.opts.htmlUntouched&&v.opts.useClasses?"inline"==e?u.addClass("fr-dvi"):"block"==e&&u.addClass("fr-dvb"):W(u,e,H()),G(),L(),s(),v.selection.clear()},refreshDisplayOnShow:function(e,t){u&&t.find('.fr-command[data-param1="'+X()+'"]').addClass("fr-active").attr("aria-selected",!0)},remove:K,hideProgressBar:A,showSizePopup:function(){var e=v.popups.get("video.size");e||(e=Y()),A(),v.popups.refresh("video.size"),v.popups.setContainer("video.size",v.$sc);var t=u.find("iframe, embed, video"),i=t.offset().left+t.width()/2,o=t.offset().top+t.height();v.popups.show("video.size",i,o,t.height())},replace:function(){var e=v.popups.get("video.insert");e||(e=n()),v.popups.isVisible("video.insert")||(A(),v.popups.refresh("video.insert"),v.popups.setContainer("video.insert",v.$sc));var t=u.offset().left+u.width()/2,i=u.offset().top+u.height();v.popups.show("video.insert",t,i,u.outerHeight())},back:function(){u?(v.events.disableBlur(),u.trigger("click")):(v.events.disableBlur(),v.selection.restore(),v.events.enableBlur(),v.popups.hide("video.insert"),v.toolbar.showInline())},setSize:function(e,t){if(u){var i=v.popups.get("video.size"),o=u.find("iframe, embed, video");o.css("width",e||i.find('input[name="width"]').val()),o.css("height",t||i.find('input[name="height"]').val()),o.get(0).style.width&&o.removeAttr("width"),o.get(0).style.height&&o.removeAttr("height"),i.find("input:focus").blur(),setTimeout(function(){u.trigger("click")},v.helpers.isAndroid()?50:0)}},get:function(){return u}}},Z.FE.RegisterCommand("insertVideo",{title:"Insert Video",undo:!1,focus:!0,refreshAfterCallback:!1,popup:!0,callback:function(){this.popups.isVisible("video.insert")?(this.$el.find(".fr-marker").length&&(this.events.disableBlur(),this.selection.restore()),this.popups.hide("video.insert")):this.video.showInsertPopup()},plugin:"video"}),Z.FE.DefineIcon("insertVideo",{NAME:"video-camera",FA5NAME:"camera"}),Z.FE.DefineIcon("videoByURL",{NAME:"link"}),Z.FE.RegisterCommand("videoByURL",{title:"By URL",undo:!1,focus:!1,toggle:!0,callback:function(){this.video.showLayer("video-by-url")},refresh:function(e){this.video.refreshByURLButton(e)}}),Z.FE.DefineIcon("videoEmbed",{NAME:"code"}),Z.FE.RegisterCommand("videoEmbed",{title:"Embedded Code",undo:!1,focus:!1,toggle:!0,callback:function(){this.video.showLayer("video-embed")},refresh:function(e){this.video.refreshEmbedButton(e)}}),Z.FE.DefineIcon("videoUpload",{NAME:"upload"}),Z.FE.RegisterCommand("videoUpload",{title:"Upload Video",undo:!1,focus:!1,toggle:!0,callback:function(){this.video.showLayer("video-upload")},refresh:function(e){this.video.refreshUploadButton(e)}}),Z.FE.RegisterCommand("videoInsertByURL",{undo:!0,focus:!0,callback:function(){this.video.insertByURL()}}),Z.FE.RegisterCommand("videoInsertEmbed",{undo:!0,focus:!0,callback:function(){this.video.insertEmbed()}}),Z.FE.DefineIcon("videoDisplay",{NAME:"star"}),Z.FE.RegisterCommand("videoDisplay",{title:"Display",type:"dropdown",options:{inline:"Inline",block:"Break Text"},callback:function(e,t){this.video.display(t)},refresh:function(e){this.opts.videoTextNear||e.addClass("fr-hidden")},refreshOnShow:function(e,t){this.video.refreshDisplayOnShow(e,t)}}),Z.FE.DefineIcon("video-align",{NAME:"align-left"}),Z.FE.DefineIcon("video-align-left",{NAME:"align-left"}),Z.FE.DefineIcon("video-align-right",{NAME:"align-right"}),Z.FE.DefineIcon("video-align-center",{NAME:"align-justify"}),Z.FE.DefineIcon("videoAlign",{NAME:"align-center"}),Z.FE.RegisterCommand("videoAlign",{type:"dropdown",title:"Align",options:{left:"Align Left",center:"None",right:"Align Right"},html:function(){var e='<ul class="fr-dropdown-list" role="presentation">',t=Z.FE.COMMANDS.videoAlign.options;for(var i in t)t.hasOwnProperty(i)&&(e+='<li role="presentation"><a class="fr-command fr-title" tabIndex="-1" role="option" data-cmd="videoAlign" data-param1="'+i+'" title="'+this.language.translate(t[i])+'">'+this.icon.create("video-align-"+i)+'<span class="fr-sr-only">'+this.language.translate(t[i])+"</span></a></li>");return e+="</ul>"},callback:function(e,t){this.video.align(t)},refresh:function(e){this.video.refreshAlign(e)},refreshOnShow:function(e,t){this.video.refreshAlignOnShow(e,t)}}),Z.FE.DefineIcon("videoReplace",{NAME:"exchange",FA5NAME:"exchange-alt"}),Z.FE.RegisterCommand("videoReplace",{title:"Replace",undo:!1,focus:!1,popup:!0,refreshAfterCallback:!1,callback:function(){this.video.replace()}}),Z.FE.DefineIcon("videoRemove",{NAME:"trash"}),Z.FE.RegisterCommand("videoRemove",{title:"Remove",callback:function(){this.video.remove()}}),Z.FE.DefineIcon("videoSize",{NAME:"arrows-alt"}),Z.FE.RegisterCommand("videoSize",{undo:!1,focus:!1,popup:!0,title:"Change Size",callback:function(){this.video.showSizePopup()}}),Z.FE.DefineIcon("videoBack",{NAME:"arrow-left"}),Z.FE.RegisterCommand("videoBack",{title:"Back",undo:!1,focus:!1,back:!0,callback:function(){this.video.back()},refresh:function(e){this.video.get()||this.opts.toolbarInline?(e.removeClass("fr-hidden"),e.next(".fr-separator").removeClass("fr-hidden")):(e.addClass("fr-hidden"),e.next(".fr-separator").addClass("fr-hidden"))}}),Z.FE.RegisterCommand("videoDismissError",{title:"OK",undo:!1,callback:function(){this.video.hideProgressBar(!0)}}),Z.FE.RegisterCommand("videoSetSize",{undo:!0,focus:!1,title:"Update",refreshAfterCallback:!1,callback:function(){this.video.setSize()}})});
/*!
 * froala_editor v2.8.4 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = function( root, jQuery ) {
            if ( jQuery === undefined ) {
                // require('jQuery') returns a factory that requires window to
                // build a jQuery instance, we normalize how we use modules
                // that require this pattern but the window provided is a noop
                // if it's defined (how jquery works)
                if ( typeof window !== 'undefined' ) {
                    jQuery = require('jquery');
                }
                else {
                    jQuery = require('jquery')(root);
                }
            }
            return factory(jQuery);
        };
    } else {
        // Browser globals
        factory(window.jQuery);
    }
}(function ($) {
/**
 * Italian
 */

$.FE.LANGUAGE['it'] = {
  translation: {
    // Place holder
    "Type something": "Digita qualcosa",

    // Basic formatting
    "Bold": "Grassetto",
    "Italic": "Corsivo",
    "Underline": "Sottolineato",
    "Strikethrough": "Barrato",

    // Main buttons
    "Insert": "Inserisci",
    "Delete": "Cancella",
    "Cancel": "Cancella",
    "OK": "OK",
    "Back": "Indietro",
    "Remove": "Rimuovi",
    "More": "Di pi\u00f9",
    "Update": "Aggiorna",
    "Style": "Stile",

    // Font
    "Font Family": "Carattere",
    "Font Size": "Dimensione Carattere",

    // Colors
    "Colors": "Colori",
    "Background": "Sfondo",
    "Text": "Testo",
    "HEX Color": "Colore Esadecimale",

    // Paragraphs
    "Paragraph Format": "Formattazione",
    "Normal": "Normale",
    "Code": "Codice",
    "Heading 1": "Intestazione 1",
    "Heading 2": "Intestazione 2",
    "Heading 3": "Intestazione 3",
    "Heading 4": "Intestazione 4",

    // Style
    "Paragraph Style": "Stile Paragrafo",
    "Inline Style": "Stile in Linea",

    // Alignment
    "Align": "Allinea",
    "Align Left": "Allinea a Sinistra",
    "Align Center": "Allinea al Cento",
    "Align Right": "Allinea a Destra",
    "Align Justify": "Giustifica",
    "None": "Nessuno",

    // Lists
    "Ordered List": "Elenchi Numerati",
    "Unordered List": "Elenchi Puntati",

    // Indent
    "Decrease Indent": "Riduci Rientro",
    "Increase Indent": "Aumenta Rientro",

    // Links
    "Insert Link": "Inserisci Link",
    "Open in new tab": "Apri in nuova scheda",
    "Open Link": "Apri Link",
    "Edit Link": "Modifica Link",
    "Unlink": "Rimuovi Link",
    "Choose Link": "Scegli Link",

    // Images
    "Insert Image": "Inserisci Immagine",
    "Upload Image": "Carica Immagine",
    "By URL": "Inserisci URL",
    "Browse": "Sfoglia",
    "Drop image": "Rilascia immagine",
    "or click": "oppure clicca qui",
    "Manage Images": "Gestione Immagini",
    "Loading": "Caricamento",
    "Deleting": "Eliminazione",
    "Tags": "Etichetta",
    "Are you sure? Image will be deleted.": "Sei sicuro? L\'immagine verr\u00e0 cancellata.",
    "Replace": "Sostituisci",
    "Uploading": "Caricamento",
    "Loading image": "Caricamento immagine",
    "Display": "Visualizzazione",
    "Inline": "In Linea",
    "Break Text": "Separa dal Testo",
    "Alternative Text": "Testo Alternativo",
    "Change Size": "Cambia Dimensioni",
    "Width": "Larghezza",
    "Height": "Altezza",
    "Something went wrong. Please try again.": "Qualcosa non ha funzionato. Riprova, per favore.",
    "Image Caption": "Didascalia",
    "Advanced Edit": "Avanzato",

    // Video
    "Insert Video": "Inserisci Video",
    "Embedded Code": "Codice Incorporato",
    "Paste in a video URL": "Incolla l'URL del video",
    "Drop video": "Rilascia video",
    "Your browser does not support HTML5 video.": "Il tuo browser non supporta i video html5.",
    "Upload Video": "Carica Video",

    // Tables
    "Insert Table": "Inserisci Tabella",
    "Table Header": "Intestazione Tabella",
    "Remove Table": "Rimuovi Tabella",
    "Table Style": "Stile Tabella",
    "Horizontal Align": "Allineamento Orizzontale",
    "Row": "Riga",
    "Insert row above": "Inserisci una riga prima",
    "Insert row below": "Inserisci una riga dopo",
    "Delete row": "Cancella riga",
    "Column": "Colonna",
    "Insert column before": "Inserisci una colonna prima",
    "Insert column after": "Inserisci una colonna dopo",
    "Delete column": "Cancella colonna",
    "Cell": "Cella",
    "Merge cells": "Unisci celle",
    "Horizontal split": "Dividi in orizzontale",
    "Vertical split": "Dividi in verticale",
    "Cell Background": "Sfondo Cella",
    "Vertical Align": "Allineamento Verticale",
    "Top": "Alto",
    "Middle": "Centro",
    "Bottom": "Basso",
    "Align Top": "Allinea in Alto",
    "Align Middle": "Allinea al Centro",
    "Align Bottom": "Allinea in Basso",
    "Cell Style": "Stile Cella",

    // Files
    "Upload File": "Carica File",
    "Drop file": "Rilascia file",

    // Emoticons
    "Emoticons": "Emoticon",
    "Grinning face": "Sorridente",
    "Grinning face with smiling eyes": "Sorridente con gli occhi sorridenti",
    "Face with tears of joy": "Con lacrime di gioia",
    "Smiling face with open mouth": "Sorridente con la bocca aperta",
    "Smiling face with open mouth and smiling eyes": "Sorridente con la bocca aperta e gli occhi sorridenti",
    "Smiling face with open mouth and cold sweat": "Sorridente con la bocca aperta e sudore freddo",
    "Smiling face with open mouth and tightly-closed eyes": "Sorridente con la bocca aperta e gli occhi stretti",
    "Smiling face with halo": "Sorridente con aureola",
    "Smiling face with horns": "Diavolo sorridente",
    "Winking face": "Ammiccante",
    "Smiling face with smiling eyes": "Sorridente imbarazzato",
    "Face savoring delicious food": "Goloso",
    "Relieved face": "Rassicurato",
    "Smiling face with heart-shaped eyes": "Sorridente con gli occhi a forma di cuore",
    "Smiling face with sunglasses": "Sorridente con gli occhiali da sole",
    "Smirking face": "Compiaciuto",
    "Neutral face": "Neutro",
    "Expressionless face": "Inespressivo",
    "Unamused face": "Annoiato",
    "Face with cold sweat": "Sudare freddo",
    "Pensive face": "Pensieroso",
    "Confused face": "Perplesso",
    "Confounded face": "Confuso",
    "Kissing face": "Bacio",
    "Face throwing a kiss": "Manda un bacio",
    "Kissing face with smiling eyes": "Bacio con gli occhi sorridenti",
    "Kissing face with closed eyes": "Bacio con gli occhi chiusi",
    "Face with stuck out tongue": "Linguaccia",
    "Face with stuck out tongue and winking eye": "Linguaccia ammiccante",
    "Face with stuck out tongue and tightly-closed eyes": "Linguaccia con occhi stretti",
    "Disappointed face": "Deluso",
    "Worried face": "Preoccupato",
    "Angry face": "Arrabbiato",
    "Pouting face": "Imbronciato",
    "Crying face": "Pianto",
    "Persevering face": "Perseverante",
    "Face with look of triumph": "Trionfante",
    "Disappointed but relieved face": "Deluso ma rassicurato",
    "Frowning face with open mouth": "Accigliato con la bocca aperta",
    "Anguished face": "Angosciato",
    "Fearful face": "Pauroso",
    "Weary face": "Stanco",
    "Sleepy face": "Assonnato",
    "Tired face": "Snervato",
    "Grimacing face": "Smorfia",
    "Loudly crying face": "Pianto a gran voce",
    "Face with open mouth": "Bocca aperta",
    "Hushed face": "Silenzioso",
    "Face with open mouth and cold sweat": "Bocca aperta e sudore freddo",
    "Face screaming in fear": "Urlante dalla paura",
    "Astonished face": "Stupito",
    "Flushed face": "Arrossito",
    "Sleeping face": "Addormentato",
    "Dizzy face": "Stordito",
    "Face without mouth": "Senza parole",
    "Face with medical mask": "Malattia infettiva",

    // Line breaker
    "Break": "Separatore",

    // Math
    "Subscript": "Pedice",
    "Superscript": "Apice",

    // Full screen
    "Fullscreen": "Schermo intero",

    // Horizontal line
    "Insert Horizontal Line": "Inserisci Divisore Orizzontale",

    // Clear formatting
    "Clear Formatting": "Cancella Formattazione",

    // Undo, redo
    "Undo": "Annulla",
    "Redo": "Ripeti",

    // Select all
    "Select All": "Seleziona Tutto",

    // Code view
    "Code View": "Visualizza Codice",

    // Quote
    "Quote": "Citazione",
    "Increase": "Aumenta",
    "Decrease": "Diminuisci",

    // Quick Insert
    "Quick Insert": "Inserimento Rapido",

    // Spcial Characters
    "Special Characters": "Caratteri Speciali",
    "Latin": "Latino",
    "Greek": "Greco",
    "Cyrillic": "Cirillico",
    "Punctuation": "Punteggiatura",
    "Currency": "Valuta",
    "Arrows": "Frecce",
    "Math": "Matematica",
    "Misc": "Misc",

    // Print.
    "Print": "Stampa",

    // Spell Checker.
    "Spell Checker": "Correttore Ortografico",

    // Help
    "Help": "Aiuto",
    "Shortcuts": "Scorciatoie",
    "Inline Editor": "Editor in Linea",
    "Show the editor": "Mostra Editor",
    "Common actions": "Azioni comuni",
    "Copy": "Copia",
    "Cut": "Taglia",
    "Paste": "Incolla",
    "Basic Formatting": "Formattazione di base",
    "Increase quote level": "Aumenta il livello di citazione",
    "Decrease quote level": "Diminuisci il livello di citazione",
    "Image / Video": "Immagine / Video",
    "Resize larger": "Pi\u00f9 grande",
    "Resize smaller": "Pi\u00f9 piccolo",
    "Table": "Tabella",
    "Select table cell": "Seleziona la cella della tabella",
    "Extend selection one cell": "Estendi la selezione di una cella",
    "Extend selection one row": "Estendi la selezione una riga",
    "Navigation": "Navigazione",
    "Focus popup / toolbar": "Metti a fuoco la barra degli strumenti",
    "Return focus to previous position": "Rimetti il fuoco sulla posizione precedente",

    // Embed.ly
    "Embed URL": "Incorpora URL",
    "Paste in a URL to embed": "Incolla un URL da incorporare",

    // Word Paste.
    "The pasted content is coming from a Microsoft Word document. Do you want to keep the format or clean it up?": "Il contenuto incollato proviene da un documento di Microsoft Word. Vuoi mantenere la formattazione di Word o pulirlo?",
    "Keep": "Mantieni",
    "Clean": "Pulisci",
    "Word Paste Detected": "\u00c8 stato rilevato un incolla da Word"
  },
  direction: "ltr"
};

}));

//# sourceMappingURL=editor.js.map
