(window.webpackJsonp=window.webpackJsonp||[]).push([[2],{"//t2":function(t,e,n){"use strict";n.d(e,"a",(function(){return o}));var r=n("lJxs"),l=n("AytR"),a=n("8Y7J"),i=n("IheW");let o=(()=>{class t{constructor(t){this.http=t}getList(){return this.http.get(`${l.a.apiUrl}brand/list`).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.brands}))}getListPaginated(t,e,n,r,a){return this.http.post(`${l.a.apiUrl}brand/list-paginated`,{sort:t,direction:e,limit:n,offset:r,filters:a})}getDetail(t){return this.http.get(`${l.a.apiUrl}brand/detail/${t}`,{}).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.brand}))}save(t,e){return e?this.edit(t,e):this.add(t)}add(t){return this.http.post(`${l.a.apiUrl}brand/create`,t)}edit(t,e){return this.http.post(`${l.a.apiUrl}brand/update/${e}`,t)}delete(t){return this.http.delete(`${l.a.apiUrl}brand/delete/${t}`)}deleteBrands(t){return this.http.post(`${l.a.apiUrl}brand/delete-brands`,{brands:t})}}return t.ngInjectableDef=a["\u0275\u0275defineInjectable"]({factory:function(){return new t(a["\u0275\u0275inject"](i.c))},token:t,providedIn:"root"}),t})()},"2wRN":function(t,e,n){"use strict";n.d(e,"a",(function(){return o}));var r=n("lJxs"),l=n("AytR"),a=n("8Y7J"),i=n("IheW");let o=(()=>{class t{constructor(t){this.http=t}getList(){return this.http.get(`${l.a.apiUrl}product-category/list`).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.product_categories}))}getListGrouped(t,e){return this.http.post(`${l.a.apiUrl}product-category/list-grouped`,{filters:e}).pipe(Object(r.a)(e=>{if("ok"===e.result){if(t){let t=[];return t=this._fillCategories(t,e.product_categories,"")}return e.product_categories}}))}getListFlatten(){return this.http.get(`${l.a.apiUrl}product-category/list-flatten`).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.product_categories}))}getDetail(t){return this.http.get(`${l.a.apiUrl}product-category/detail/${t}`).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.product_category}))}save(t,e){return e?this.edit(t,e):this.add(t)}add(t){return this.http.post(`${l.a.apiUrl}product-category/create`,t)}edit(t,e){return this.http.post(`${l.a.apiUrl}product-category/update/${e}`,t)}delete(t){return this.http.delete(`${l.a.apiUrl}product-category/delete/${t}`)}_fillCategories(t,e,n){return e.forEach(e=>{e.label=n+e.label,t.push(e),this._fillCategories(t,e.childs,n+"\u2014")}),t}}return t.ngInjectableDef=a["\u0275\u0275defineInjectable"]({factory:function(){return new t(a["\u0275\u0275inject"](i.c))},token:t,providedIn:"root"}),t})()},H9My:function(t,e,n){"use strict";n.d(e,"a",(function(){return o}));var r=n("AytR"),l=n("lJxs"),a=n("8Y7J"),i=n("IheW");let o=(()=>{class t{constructor(t){this.http=t}getList(){return this.http.get(`${r.a.apiUrl}tax/list`).pipe(Object(l.a)(t=>{if("ok"===t.result)return t.taxes}))}getListPaginated(t,e,n,l,a){return this.http.post(`${r.a.apiUrl}tax/list-paginated`,{sort:t,direction:e,limit:n,offset:l,filters:a})}getDetail(t){return this.http.get(`${r.a.apiUrl}tax/detail/${t}`).pipe(Object(l.a)(t=>{if("ok"===t.result)return t.tax}))}save(t,e=null){return e?this.edit(t,e):this.add(t)}add(t){return this.http.post(`${r.a.apiUrl}tax/create`,t)}edit(t,e){return this.http.post(`${r.a.apiUrl}tax/update/${e}`,t)}delete(t){return this.http.delete(`${r.a.apiUrl}tax/delete/${t}`)}deleteTaxes(t){return this.http.post(`${r.a.apiUrl}tax/delete-taxes`,{taxes:t})}}return t.ngInjectableDef=a["\u0275\u0275defineInjectable"]({factory:function(){return new t(a["\u0275\u0275inject"](i.c))},token:t,providedIn:"root"}),t})()},MfMb:function(t,e,n){"use strict";n.d(e,"a",(function(){return k})),n.d(e,"b",(function(){return O}));var r=n("8Y7J"),l=(n("/0xL"),n("SVse")),a=(n("POq0"),n("Xd0L")),i=(n("IP0z"),n("cUpR"),n("/HVE")),o=n("Fwaw"),s=n("r0V8"),u=n("Gi4r"),c=n("oapL"),p=n("HsOI"),d=n("ZwOa"),h=n("W5yJ"),g=n("Z5h4"),f=n("s7LF"),m=n("5GAg"),b=n("omvX"),v=n("NvT6"),$=n("Mr+X"),y=n("bujt"),k=(n("JjoW"),n("hOhj"),r["\u0275crt"]({encapsulation:0,styles:[".mat-select-search-hidden[_ngcontent-%COMP%]{visibility:hidden}.mat-select-search-inner[_ngcontent-%COMP%]{position:absolute;top:0;width:100%;border-bottom-width:1px;border-bottom-style:solid;z-index:100;font-size:inherit;box-shadow:none;border-radius:4px 4px 0 0;-webkit-transform:translate3d(0,0,0)}.mat-select-search-inner.mat-select-search-inner-multiple[_ngcontent-%COMP%]{width:100%}.mat-select-search-inner.mat-select-search-inner-multiple.mat-select-search-inner-toggle-all[_ngcontent-%COMP%]{display:flex;align-items:center}.mat-select-search-inner[_ngcontent-%COMP%]   .mat-input-element[_ngcontent-%COMP%]{flex-basis:auto}.mat-select-search-inner[_ngcontent-%COMP%]   .mat-input-element[_ngcontent-%COMP%]:-ms-input-placeholder{-ms-user-select:text}  .mat-select-search-panel{transform:none!important;overflow-x:hidden}.mat-select-search-input[_ngcontent-%COMP%]{padding:16px 36px 16px 16px;box-sizing:border-box}.mat-select-search-no-entries-found[_ngcontent-%COMP%]{padding:16px}.mat-select-search-clear[_ngcontent-%COMP%]{position:absolute;right:4px;top:5px}.mat-select-search-spinner[_ngcontent-%COMP%]{position:absolute;right:16px;top:calc(50% - 8px)}.mat-select-search-inside-mat-option[_nghost-%COMP%]   .mat-select-search-input[_ngcontent-%COMP%]{padding-top:0;padding-bottom:0;height:3em;line-height:3em}.mat-select-search-inside-mat-option[_nghost-%COMP%]   .mat-select-search-clear[_ngcontent-%COMP%]{top:3px}  .cdk-overlay-pane-select-search.cdk-overlay-pane-select-search-with-offset{margin-top:-50px}  .mat-option[aria-disabled=true].contains-mat-select-search{position:static;padding:0}  .mat-option[aria-disabled=true].contains-mat-select-search .mat-icon{margin-right:0}  .mat-option[aria-disabled=true].contains-mat-select-search .mat-option-pseudo-checkbox{display:none}  .mat-option[aria-disabled=true].contains-mat-select-search.mat-select-search-no-entries-found{height:6em}.mat-select-search-toggle-all-checkbox[_ngcontent-%COMP%]{padding-left:16px;padding-bottom:2px}"],data:{}}));function I(t){return r["\u0275vid"](0,[(t()(),r["\u0275eld"](0,0,null,null,2,"mat-checkbox",[["class","mat-select-search-toggle-all-checkbox mat-checkbox"]],[[8,"id",0],[1,"tabindex",0],[2,"mat-checkbox-indeterminate",null],[2,"mat-checkbox-checked",null],[2,"mat-checkbox-disabled",null],[2,"mat-checkbox-label-before",null],[2,"_mat-animation-noopable",null]],[[null,"change"]],(function(t,e,n){var r=!0;return"change"===e&&(r=!1!==t.component._emitSelectAllBooleanToParent(n.checked)&&r),r}),g.b,g.a)),r["\u0275prd"](5120,null,f.r,(function(t){return[t]}),[s.b]),r["\u0275did"](2,8568832,null,0,s.b,[r.ElementRef,r.ChangeDetectorRef,m.h,r.NgZone,[8,null],[2,s.a],[2,b.a]],{color:[0,"color"],checked:[1,"checked"],indeterminate:[2,"indeterminate"]},{change:"change"})],(function(t,e){var n=e.component;t(e,2,0,null==n.matFormField?null:n.matFormField.color,n.toggleAllCheckboxChecked,n.toggleAllCheckboxIndeterminate)}),(function(t,e){t(e,0,0,r["\u0275nov"](e,2).id,null,r["\u0275nov"](e,2).indeterminate,r["\u0275nov"](e,2).checked,r["\u0275nov"](e,2).disabled,"before"==r["\u0275nov"](e,2).labelPosition,"NoopAnimations"===r["\u0275nov"](e,2)._animationMode)}))}function U(t){return r["\u0275vid"](0,[(t()(),r["\u0275eld"](0,0,null,null,1,"mat-spinner",[["class","mat-select-search-spinner mat-spinner mat-progress-spinner"],["diameter","16"],["mode","indeterminate"],["role","progressbar"]],[[2,"_mat-animation-noopable",null],[4,"width","px"],[4,"height","px"]],null,null,v.d,v.b)),r["\u0275did"](1,114688,null,0,h.d,[r.ElementRef,i.a,[2,l.DOCUMENT],[2,b.a],h.a],{diameter:[0,"diameter"]},null)],(function(t,e){t(e,1,0,"16")}),(function(t,e){t(e,0,0,r["\u0275nov"](e,1)._noopAnimations,r["\u0275nov"](e,1).diameter,r["\u0275nov"](e,1).diameter)}))}function x(t){return r["\u0275vid"](0,[r["\u0275ncd"](null,0),(t()(),r["\u0275and"](0,null,null,0))],null,null)}function _(t){return r["\u0275vid"](0,[(t()(),r["\u0275eld"](0,0,null,null,2,"mat-icon",[["class","mat-icon notranslate"],["role","img"]],[[2,"mat-icon-inline",null],[2,"mat-icon-no-color",null]],null,null,$.b,$.a)),r["\u0275did"](1,9158656,null,0,u.b,[r.ElementRef,u.d,[8,null],[2,u.a],[2,r.ErrorHandler]],null,null),(t()(),r["\u0275ted"](-1,0,["close"]))],(function(t,e){t(e,1,0)}),(function(t,e){t(e,0,0,r["\u0275nov"](e,1).inline,"primary"!==r["\u0275nov"](e,1).color&&"accent"!==r["\u0275nov"](e,1).color&&"warn"!==r["\u0275nov"](e,1).color)}))}function j(t){return r["\u0275vid"](0,[(t()(),r["\u0275eld"](0,0,null,null,4,"button",[["aria-label","Clear"],["class","mat-select-search-clear"],["mat-button",""],["mat-icon-button",""]],[[1,"disabled",0],[2,"_mat-animation-noopable",null]],[[null,"click"]],(function(t,e,n){var r=!0;return"click"===e&&(r=!1!==t.component._reset(!0)&&r),r}),y.d,y.b)),r["\u0275did"](1,180224,null,0,o.b,[r.ElementRef,m.h,[2,b.a]],null,null),(t()(),r["\u0275and"](16777216,null,0,1,null,x)),r["\u0275did"](3,16384,null,0,l.NgIf,[r.ViewContainerRef,r.TemplateRef],{ngIf:[0,"ngIf"],ngIfElse:[1,"ngIfElse"]},null),(t()(),r["\u0275and"](0,[["defaultIcon",2]],0,0,null,_))],(function(t,e){t(e,3,0,e.component.clearIcon,r["\u0275nov"](e,4))}),(function(t,e){t(e,0,0,r["\u0275nov"](e,1).disabled||null,"NoopAnimations"===r["\u0275nov"](e,1)._animationMode)}))}function C(t){return r["\u0275vid"](0,[(t()(),r["\u0275eld"](0,0,null,null,1,"div",[["class","mat-select-search-no-entries-found"]],null,null,null,null,null)),(t()(),r["\u0275ted"](1,null,[" ","\n"]))],null,(function(t,e){t(e,1,0,e.component.noEntriesFoundLabel)}))}function O(t){return r["\u0275vid"](2,[r["\u0275qud"](402653184,1,{searchSelectInput:0}),r["\u0275qud"](402653184,2,{innerSelectSearch:0}),(t()(),r["\u0275eld"](2,0,null,null,2,"input",[["class","mat-select-search-input mat-select-search-hidden mat-input-element mat-form-field-autofill-control"],["matInput",""]],[[2,"mat-input-server",null],[1,"id",0],[1,"placeholder",0],[8,"disabled",0],[8,"required",0],[1,"readonly",0],[1,"aria-describedby",0],[1,"aria-invalid",0],[1,"aria-required",0]],[[null,"blur"],[null,"focus"],[null,"input"]],(function(t,e,n){var l=!0;return"blur"===e&&(l=!1!==r["\u0275nov"](t,4)._focusChanged(!1)&&l),"focus"===e&&(l=!1!==r["\u0275nov"](t,4)._focusChanged(!0)&&l),"input"===e&&(l=!1!==r["\u0275nov"](t,4)._onInput()&&l),l}),null,null)),r["\u0275prd"](6144,null,p.d,null,[d.b]),r["\u0275did"](4,999424,null,0,d.b,[r.ElementRef,i.a,[8,null],[2,f.v],[2,f.l],a.d,[8,null],c.a,r.NgZone],null,null),(t()(),r["\u0275eld"](5,0,[[2,0],["innerSelectSearch",1]],null,13,"div",[["class","mat-select-search-inner mat-typography mat-datepicker-content mat-tab-header"]],null,null,null,null,null)),r["\u0275prd"](512,null,l["\u0275NgClassImpl"],l["\u0275NgClassR2Impl"],[r.IterableDiffers,r.KeyValueDiffers,r.ElementRef,r.Renderer2]),r["\u0275did"](7,278528,null,0,l.NgClass,[l["\u0275NgClassImpl"]],{klass:[0,"klass"],ngClass:[1,"ngClass"]},null),r["\u0275pod"](8,{"mat-select-search-inner-multiple":0,"mat-select-search-inner-toggle-all":1}),(t()(),r["\u0275and"](16777216,null,null,1,null,I)),r["\u0275did"](10,16384,null,0,l.NgIf,[r.ViewContainerRef,r.TemplateRef],{ngIf:[0,"ngIf"]},null),(t()(),r["\u0275eld"](11,0,[[1,0],["searchSelectInput",1]],null,2,"input",[["autocomplete","off"],["class","mat-select-search-input mat-input-element mat-form-field-autofill-control"],["matInput",""]],[[1,"aria-label",0],[2,"mat-input-server",null],[1,"id",0],[1,"placeholder",0],[8,"disabled",0],[8,"required",0],[1,"readonly",0],[1,"aria-describedby",0],[1,"aria-invalid",0],[1,"aria-required",0]],[[null,"keydown"],[null,"keyup"],[null,"input"],[null,"blur"],[null,"focus"]],(function(t,e,n){var l=!0,a=t.component;return"blur"===e&&(l=!1!==r["\u0275nov"](t,13)._focusChanged(!1)&&l),"focus"===e&&(l=!1!==r["\u0275nov"](t,13)._focusChanged(!0)&&l),"input"===e&&(l=!1!==r["\u0275nov"](t,13)._onInput()&&l),"keydown"===e&&(l=!1!==a._handleKeydown(n)&&l),"keyup"===e&&(l=!1!==a._handleKeyup(n)&&l),"input"===e&&(l=!1!==a.onInputChange(n.target.value)&&l),"blur"===e&&(l=!1!==a.onBlur(n.target.value)&&l),l}),null,null)),r["\u0275prd"](6144,null,p.d,null,[d.b]),r["\u0275did"](13,999424,null,0,d.b,[r.ElementRef,i.a,[8,null],[2,f.v],[2,f.l],a.d,[8,null],c.a,r.NgZone],{placeholder:[0,"placeholder"],type:[1,"type"],value:[2,"value"]},null),(t()(),r["\u0275and"](16777216,null,null,1,null,U)),r["\u0275did"](15,16384,null,0,l.NgIf,[r.ViewContainerRef,r.TemplateRef],{ngIf:[0,"ngIf"]},null),(t()(),r["\u0275and"](16777216,null,null,1,null,j)),r["\u0275did"](17,16384,null,0,l.NgIf,[r.ViewContainerRef,r.TemplateRef],{ngIf:[0,"ngIf"]},null),r["\u0275ncd"](null,1),(t()(),r["\u0275and"](16777216,null,null,1,null,C)),r["\u0275did"](20,16384,null,0,l.NgIf,[r.ViewContainerRef,r.TemplateRef],{ngIf:[0,"ngIf"]},null)],(function(t,e){var n=e.component;t(e,4,0);var r=t(e,8,0,n.matSelect.multiple,n._isToggleAllCheckboxVisible());t(e,7,0,"mat-select-search-inner mat-typography mat-datepicker-content mat-tab-header",r),t(e,10,0,n._isToggleAllCheckboxVisible()),t(e,13,0,n.placeholderLabel,n.type,n.value),t(e,15,0,n.searching),t(e,17,0,n.value&&!n.searching),t(e,20,0,n._noEntriesFound())}),(function(t,e){var n=e.component;t(e,2,0,r["\u0275nov"](e,4)._isServer,r["\u0275nov"](e,4).id,r["\u0275nov"](e,4).placeholder,r["\u0275nov"](e,4).disabled,r["\u0275nov"](e,4).required,r["\u0275nov"](e,4).readonly&&!r["\u0275nov"](e,4)._isNativeSelect||null,r["\u0275nov"](e,4)._ariaDescribedby||null,r["\u0275nov"](e,4).errorState,r["\u0275nov"](e,4).required.toString()),t(e,11,0,n.ariaLabel,r["\u0275nov"](e,13)._isServer,r["\u0275nov"](e,13).id,r["\u0275nov"](e,13).placeholder,r["\u0275nov"](e,13).disabled,r["\u0275nov"](e,13).required,r["\u0275nov"](e,13).readonly&&!r["\u0275nov"](e,13)._isNativeSelect||null,r["\u0275nov"](e,13)._ariaDescribedby||null,r["\u0275nov"](e,13).errorState,r["\u0275nov"](e,13).required.toString())}))}},OBjS:function(t,e,n){"use strict";n.d(e,"a",(function(){return i})),n.d(e,"b",(function(){return o}));var r=n("8Y7J"),l=n("AaDx"),a=(n("SVse"),n("5GAg"),n("/HVE"),n("DkaU")),i=(n("IP0z"),n("Xd0L"),n("cUpR"),r["\u0275crt"]({encapsulation:2,styles:[".mat-tree{display:block}.mat-tree-node{display:flex;align-items:center;min-height:48px;flex:1;overflow:hidden;word-wrap:break-word}.mat-nested-tree-ndoe{border-bottom-width:0}"],data:{}}));function o(t){return r["\u0275vid"](0,[r["\u0275qud"](402653184,1,{_nodeOutlet:0}),(t()(),r["\u0275eld"](1,16777216,null,null,2,null,null,null,null,null,null,null)),r["\u0275prd"](6144,null,a.g,null,[l.i]),r["\u0275did"](3,16384,[[1,4]],0,l.i,[r.ViewContainerRef,[2,a.a]],null,null)],null,null)}},YGwI:function(t,e,n){"use strict";function r(t){const e=new FormData;for(const n of Object.keys(t))e.append(n,t[n]);return e}n.d(e,"a",(function(){return r}))},YZ39:function(t,e,n){"use strict";n.d(e,"a",(function(){return o}));var r=n("lJxs"),l=n("AytR"),a=n("8Y7J"),i=n("IheW");let o=(()=>{class t{constructor(t){this.http=t}getList(){return this.http.get(`${l.a.apiUrl}campaign-template/list`).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.campaign_templates}))}getListPaginated(t,e,n,r,a){return this.http.post(`${l.a.apiUrl}campaign-template/list-paginated`,{sort:t,direction:e,limit:n,offset:r,filters:a})}getDetail(t){return this.http.get(`${l.a.apiUrl}campaign-template/detail/${t}`).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.campaign_template}))}delete(t){return this.http.delete(`${l.a.apiUrl}campaign-template/delete/${t}`)}deleteCampaignTemplates(t){return this.http.post(`${l.a.apiUrl}campaign-template/delete-campaign-templates`,{campaign_templates:t})}save(t,e){return e?this.edit(t,e):this.add(t)}add(t){return this.http.post(`${l.a.apiUrl}campaign-template/create`,t)}edit(t,e){return this.http.post(`${l.a.apiUrl}campaign-template/update/${e}`,t)}duplicate(t){return this.http.post(`${l.a.apiUrl}campaign-template/duplicate/${t}`,{})}}return t.ngInjectableDef=a["\u0275\u0275defineInjectable"]({factory:function(){return new t(a["\u0275\u0275inject"](i.c))},token:t,providedIn:"root"}),t})()},dihp:function(t,e,n){"use strict";n.d(e,"a",(function(){return o}));var r=n("IheW"),l=n("lJxs"),a=n("AytR"),i=n("8Y7J");let o=(()=>{class t{constructor(t){this.http=t}getList(){return this.http.get(`${a.a.apiUrl}role/list`).pipe(Object(l.a)(t=>{if("ok"===t.result)return t.roles}))}getDetail(t){return this.http.get(`${a.a.apiUrl}role/detail/${t}`).pipe(Object(l.a)(t=>{if("ok"===t.result)return t.role}))}delete(t,e){const n={headers:new r.g({"Content-Type":"application/json"}),body:{reassigned_role:e}};return this.http.delete(`${a.a.apiUrl}role/delete/${t}`,n).pipe(Object(l.a)(t=>{if("ok"===t.result)return t.roles}))}save(t,e){return e?this.edit(t,e):this.add(t)}add(t){return this.http.post(`${a.a.apiUrl}role/create`,t)}edit(t,e){return this.http.post(`${a.a.apiUrl}role/update/${e}`,t)}}return t.ngInjectableDef=i["\u0275\u0275defineInjectable"]({factory:function(){return new t(i["\u0275\u0275inject"](r.c))},token:t,providedIn:"root"}),t})()},fH6q:function(t,e,n){"use strict";n.d(e,"a",(function(){return o}));var r=n("lJxs"),l=n("AytR"),a=n("8Y7J"),i=n("IheW");let o=(()=>{class t{constructor(t){this.http=t}getList(t){return this.http.get(`${l.a.apiUrl}category/list/${t}`).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.categories}))}getListGrouped(t,e=null){return this.http.get(`${l.a.apiUrl}category/list-grouped/${t}`).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.categories}))}getDetail(t){return this.http.get(`${l.a.apiUrl}category/detail/${t}`).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.category}))}save(t,e){return e?this.edit(t,e):this.add(t)}add(t){return this.http.post(`${l.a.apiUrl}category/create`,t)}edit(t,e){return this.http.post(`${l.a.apiUrl}category/update/${e}`,t)}delete(t){return this.http.delete(`${l.a.apiUrl}category/delete/${t}`)}}return t.ngInjectableDef=a["\u0275\u0275defineInjectable"]({factory:function(){return new t(a["\u0275\u0275inject"](i.c))},token:t,providedIn:"root"}),t})()},kmKP:function(t,e,n){"use strict";n.d(e,"a",(function(){return s}));var r=n("lJxs"),l=n("IheW"),a=n("AytR"),i=n("YGwI"),o=n("8Y7J");let s=(()=>{class t{constructor(t){this.http=t}getList(t,e){return this.http.post(`${a.a.apiUrl}user/list`,{limit:t,offset:e}).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.users}))}getListPaginated(t,e,n,r,l){return this.http.post(`${a.a.apiUrl}user/list-paginated`,{sort:t,direction:e,limit:n,offset:r,filters:l})}getListByRole(t,e,n){return this.http.post(`${a.a.apiUrl}user/list-by-role`,{role:t,limit:e,offset:n}).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.users}))}getListBySearch(t,e){return this.http.post(`${a.a.apiUrl}user/list-by-role-and-search`,{role:t,search:e}).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.users}))}getListByRolePaginated(t,e,n,r,l,i){return this.http.post(`${a.a.apiUrl}user/list-by-role-paginated`,{role:t,sort:e,direction:n,limit:r,offset:l,filters:i})}getCustomersByCompany(t,e,n,r,l){return this.http.post(`${a.a.apiUrl}user/customers-by-company`,{sort:t,direction:e,limit:n,offset:r,filters:l})}getDetail(t){return this.http.get(`${a.a.apiUrl}user/detail/${t}`,{}).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.user}))}delete(t,e){const n={headers:new l.g({"Content-Type":"application/json"}),body:{reassigned_user:e}};return this.http.delete(`${a.a.apiUrl}user/delete/${t}`,n).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.users}))}save(t,e){return t=Object(i.a)(t),e?this.edit(t,e):this.add(t)}add(t){return this.http.post(`${a.a.apiUrl}user/create`,t)}edit(t,e){return this.http.post(`${a.a.apiUrl}user/update/${e}`,t)}deleteUsers(t){return this.http.post(`${a.a.apiUrl}user/delete-users`,{users:t})}}return t.ngInjectableDef=o["\u0275\u0275defineInjectable"]({factory:function(){return new t(o["\u0275\u0275inject"](l.c))},token:t,providedIn:"root"}),t})()},mB2O:function(t,e,n){"use strict";n.d(e,"a",(function(){return o}));var r=n("lJxs"),l=n("AytR"),a=n("8Y7J"),i=n("IheW");let o=(()=>{class t{constructor(t){this.http=t}getList(){return this.http.get(`${l.a.apiUrl}product/list`,{}).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.products}))}getListPaginated(t,e,n,r,a){return this.http.post(`${l.a.apiUrl}product/list-paginated`,{sort:t,direction:e,limit:n,offset:r,filters:a})}getDetail(t){return this.http.get(`${l.a.apiUrl}product/detail/${t}`,{}).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.product}))}save(t,e){return e?this.edit(t,e):this.add(t)}add(t){return this.http.post(`${l.a.apiUrl}product/create`,t)}edit(t,e){return this.http.post(`${l.a.apiUrl}product/update/${e}`,t)}delete(t){return this.http.delete(`${l.a.apiUrl}product/delete/${t}`)}changeProductsStatus(t,e){return this.http.post(`${l.a.apiUrl}product/change-products-status`,{products:t,active:e})}changeProductsCategory(t,e){return this.http.post(`${l.a.apiUrl}product/change-products-category`,{products:t,category_id:e})}deleteProducts(t){return this.http.post(`${l.a.apiUrl}product/delete-products`,{products:t})}duplicate(t){return this.http.post(`${l.a.apiUrl}product/duplicate/${t}`,{})}getNumberByStatus(){return this.http.get(`${l.a.apiUrl}product/number-by-status`)}getListBySearch(t){return this.http.post(`${l.a.apiUrl}product/list-by-search`,{search:t}).pipe(Object(r.a)(t=>{if("ok"===t.result)return t.products}))}}return t.ngInjectableDef=a["\u0275\u0275defineInjectable"]({factory:function(){return new t(a["\u0275\u0275inject"](i.c))},token:t,providedIn:"root"}),t})()}}]);