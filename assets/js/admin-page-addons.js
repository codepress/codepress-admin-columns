!function(e){var t={};function n(s){if(t[s])return t[s].exports;var o=t[s]={i:s,l:!1,exports:{}};return e[s].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,s){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:s})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var s=Object.create(null);if(n.r(s),Object.defineProperty(s,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(s,o,function(t){return e[t]}.bind(null,o));return s},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=50)}({0:function(e,t){e.exports=jQuery},50:function(e,t,n){"use strict";n.r(t);var s=function(){function e(){this.element=document.createElement("div"),this.element.classList.add("notice"),this.dismissible=!1}return e.prototype.setMessage=function(e){return this.message=e,this},e.prototype.renderDismiss=function(){var e=this,t=document.createElement("button");t.classList.add("notice-dismiss"),t.setAttribute("type","button"),t.insertAdjacentHTML("beforeend",'<span class="screen-reader-text">Dismiss this notice.</span>'),t.addEventListener("click",(function(t){t.preventDefault(),e.element.remove()})),this.element.classList.add("is-dismissible"),this.element.insertAdjacentElement("beforeend",t)},e.prototype.renderContent=function(){this.element.insertAdjacentHTML("afterbegin",this.message)},e.prototype.makeDismissable=function(){return this.dismissible=!0,this},e.prototype.addClass=function(e){return this.element.classList.add(e),this},e.prototype.render=function(){return this.element.innerHTML="",this.renderContent(),this.dismissible&&this.renderDismiss(),this.element},e}(),o=n(0),i=n.n(o),r=function(){function e(e,t){this.element=e,this.slug=t,this.loadingState=!1,this.initEvents()}return e.prototype.getDownloadButton=function(){return this.element.querySelector("[data-install]")},e.prototype.setLoadingState=function(){var e=this.getDownloadButton();e&&(e.insertAdjacentHTML("afterend",'<span class="spinner" style="visibility: visible;"></span>'),e.classList.add("button-disabled")),this.loadingState=!0},e.prototype.removeLoadingState=function(){var e=this.getDownloadButton(),t=this.element.querySelector(".spinner");t&&t.remove(),e&&e.classList.remove("button-disabled"),this.loadingState=!1},e.prototype.initEvents=function(){var e=this,t=this.getDownloadButton();t&&t.addEventListener("click",(function(t){t.preventDefault(),e.loadingState||(e.setLoadingState(),e.download())}))},e.prototype.success=function(e){var t=this.getDownloadButton(),n=this.element.querySelector("h3"),o=new s;o.setMessage("<p>The Add-on <strong>"+n.innerHTML+"</strong> is installed.</p>").makeDismissable().addClass("updated"),document.querySelector(".ac-addons").insertAdjacentElement("beforebegin",o.render()),t&&(t.insertAdjacentHTML("beforebegin",'<span class="active">'+e+"</span>"),t.remove())},e.scrollToTop=function(e){i()("html, body").animate({scrollTop:0},e)},e.prototype.failure=function(t){var n=this.element.querySelector("h3"),o=new s;o.setMessage("<p><strong>"+n.innerHTML+"</strong>: "+t+"</p>").makeDismissable().addClass("notice-error"),document.querySelector(".ac-addons").insertAdjacentElement("beforebegin",o.render()),e.scrollToTop(200)},e.prototype.download=function(){var e=this;this.request().done((function(t){e.removeLoadingState(),t.success?e.success(t.data.status):e.failure(t.data)}))},e.prototype.request=function(){var e={action:"acp-install-addon",plugin_name:this.slug,_ajax_nonce:AC._ajax_nonce};return i.a.ajax({url:ajaxurl,method:"post",data:e})},e}();document.addEventListener("DOMContentLoaded",(function(){document.querySelectorAll(".ac-addon").forEach((function(e){new r(e,e.dataset.slug)}))}))}});