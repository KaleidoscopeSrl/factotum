(window.webpackJsonp=window.webpackJsonp||[]).push([[23],{fvjW:function(l,n,e){"use strict";e.r(n);var a=e("8Y7J");class o{}var t=e("pMnS"),i=e("t68o"),d=e("zbXB"),u=e("Xg1U"),r=e("MlvX"),s=e("Xd0L"),c=e("HsOI"),p=e("TSSN"),m=e("dJrM"),g=e("IP0z"),v=e("/HVE"),f=e("omvX"),h=e("Azqq"),b=e("JjoW"),_=e("s7LF"),y=e("hOhj"),C=e("5GAg"),F=e("SVse"),w=e("bujt"),R=e("Fwaw"),I=e("A9xy"),j=e("lJxs"),L=e("AytR"),S=e("IheW");let k=(()=>{class l{constructor(l){this.http=l}saveHomepageLanguages(l){return this.http.post(`${L.a.apiUrl}setting/save-homepage-languages `,l).pipe(Object(j.a)(l=>{if("ok"===l.result)return!0}))}}return l.ngInjectableDef=a["\u0275\u0275defineInjectable"]({factory:function(){return new l(a["\u0275\u0275inject"](S.c))},token:l,providedIn:"root"}),l})();class q{constructor(l,n,e,a,o){this.actions=l,this.utilityService=n,this.formBuilder=e,this.router=a,this.toastr=o,this.availableLanguages={},this.pages=[],this.utilityService.getPagesByLanguage().subscribe(l=>{this.pages=l,this.utilityService.getAvailableLanguages().subscribe(l=>{this.availableLanguages=l,this._addLanguagesToForm()})})}ngOnInit(){this.settingForm=this.formBuilder.group({})}_addLanguagesToForm(){for(const l in this.availableLanguages)if(this.pages[l].length>0){this.settingForm.addControl("page_homepage_"+l,new _.h("",_.A.required));for(const n in this.pages[l])this.pages[l][n].is_home&&this.settingForm.controls["page_homepage_"+l].setValue(this.pages[l][n].id)}}saveHandler(){this.actions.saveHomepageLanguages(this.settingForm.value).subscribe(l=>{this.toastr.success("Impostazioni salvate con successo!")})}}var D=e("iInd"),N=e("EApP"),x=a["\u0275crt"]({encapsulation:2,styles:[],data:{}});function A(l){return a["\u0275vid"](0,[(l()(),a["\u0275eld"](0,0,null,null,2,"mat-option",[["class","mat-option"],["role","option"]],[[1,"tabindex",0],[2,"mat-selected",null],[2,"mat-option-multiple",null],[2,"mat-active",null],[8,"id",0],[1,"aria-selected",0],[1,"aria-disabled",0],[2,"mat-option-disabled",null]],[[null,"click"],[null,"keydown"]],(function(l,n,e){var o=!0;return"click"===n&&(o=!1!==a["\u0275nov"](l,1)._selectViaInteraction()&&o),"keydown"===n&&(o=!1!==a["\u0275nov"](l,1)._handleKeydown(e)&&o),o}),r.c,r.a)),a["\u0275did"](1,8568832,[[10,4]],0,s.s,[a.ElementRef,a.ChangeDetectorRef,[2,s.l],[2,s.r]],{value:[0,"value"]},null),(l()(),a["\u0275ted"](2,0,["",""]))],(function(l,n){l(n,1,0,n.context.$implicit.id)}),(function(l,n){l(n,0,0,a["\u0275nov"](n,1)._getTabIndex(),a["\u0275nov"](n,1).selected,a["\u0275nov"](n,1).multiple,a["\u0275nov"](n,1).active,a["\u0275nov"](n,1).id,a["\u0275nov"](n,1)._getAriaSelected(),a["\u0275nov"](n,1).disabled.toString(),a["\u0275nov"](n,1).disabled),l(n,2,0,n.context.$implicit.title)}))}function O(l){return a["\u0275vid"](0,[(l()(),a["\u0275eld"](0,0,null,null,3,"mat-error",[["class","mat-error"],["role","alert"]],[[1,"id",0]],null,null,null,null)),a["\u0275did"](1,16384,[[6,4]],0,c.b,[],null,null),(l()(),a["\u0275ted"](2,null,[" "," "])),a["\u0275pid"](131072,p.i,[p.j,a.ChangeDetectorRef])],null,(function(l,n){l(n,0,0,a["\u0275nov"](n,1).id),l(n,2,0,a["\u0275unv"](n,2,0,a["\u0275nov"](n,3).transform("validations.required")))}))}function V(l){return a["\u0275vid"](0,[(l()(),a["\u0275eld"](0,0,null,null,25,"mat-form-field",[["class","field stacked mat-form-field"]],[[2,"mat-form-field-appearance-standard",null],[2,"mat-form-field-appearance-fill",null],[2,"mat-form-field-appearance-outline",null],[2,"mat-form-field-appearance-legacy",null],[2,"mat-form-field-invalid",null],[2,"mat-form-field-can-float",null],[2,"mat-form-field-should-float",null],[2,"mat-form-field-has-label",null],[2,"mat-form-field-hide-placeholder",null],[2,"mat-form-field-disabled",null],[2,"mat-form-field-autofilled",null],[2,"mat-focused",null],[2,"mat-accent",null],[2,"mat-warn",null],[2,"ng-untouched",null],[2,"ng-touched",null],[2,"ng-pristine",null],[2,"ng-dirty",null],[2,"ng-valid",null],[2,"ng-invalid",null],[2,"ng-pending",null],[2,"_mat-animation-noopable",null]],null,null,m.b,m.a)),a["\u0275did"](1,7520256,null,9,c.c,[a.ElementRef,a.ChangeDetectorRef,[2,s.j],[2,g.b],[2,c.a],v.a,a.NgZone,[2,f.a]],null,null),a["\u0275qud"](603979776,1,{_controlNonStatic:0}),a["\u0275qud"](335544320,2,{_controlStatic:0}),a["\u0275qud"](603979776,3,{_labelChildNonStatic:0}),a["\u0275qud"](335544320,4,{_labelChildStatic:0}),a["\u0275qud"](603979776,5,{_placeholderChild:0}),a["\u0275qud"](603979776,6,{_errorChildren:1}),a["\u0275qud"](603979776,7,{_hintChildren:1}),a["\u0275qud"](603979776,8,{_prefixChildren:1}),a["\u0275qud"](603979776,9,{_suffixChildren:1}),(l()(),a["\u0275eld"](11,0,null,1,12,"mat-select",[["class","mat-select"],["role","listbox"]],[[2,"ng-untouched",null],[2,"ng-touched",null],[2,"ng-pristine",null],[2,"ng-dirty",null],[2,"ng-valid",null],[2,"ng-invalid",null],[2,"ng-pending",null],[1,"id",0],[1,"tabindex",0],[1,"aria-label",0],[1,"aria-labelledby",0],[1,"aria-required",0],[1,"aria-disabled",0],[1,"aria-invalid",0],[1,"aria-owns",0],[1,"aria-multiselectable",0],[1,"aria-describedby",0],[1,"aria-activedescendant",0],[2,"mat-select-disabled",null],[2,"mat-select-invalid",null],[2,"mat-select-required",null],[2,"mat-select-empty",null]],[[null,"keydown"],[null,"focus"],[null,"blur"]],(function(l,n,e){var o=!0;return"keydown"===n&&(o=!1!==a["\u0275nov"](l,16)._handleKeydown(e)&&o),"focus"===n&&(o=!1!==a["\u0275nov"](l,16)._onFocus()&&o),"blur"===n&&(o=!1!==a["\u0275nov"](l,16)._onBlur()&&o),o}),h.b,h.a)),a["\u0275prd"](6144,null,s.l,null,[b.c]),a["\u0275did"](13,671744,null,0,_.j,[[3,_.c],[8,null],[8,null],[8,null],[2,_.D]],{name:[0,"name"]},null),a["\u0275prd"](2048,null,_.s,null,[_.j]),a["\u0275did"](15,16384,null,0,_.t,[[4,_.s]],null,null),a["\u0275did"](16,2080768,null,3,b.c,[y.d,a.ChangeDetectorRef,a.NgZone,s.d,a.ElementRef,[2,g.b],[2,_.v],[2,_.l],[2,c.c],[6,_.s],[8,null],b.a,C.j],{placeholder:[0,"placeholder"]},null),a["\u0275qud"](603979776,10,{options:1}),a["\u0275qud"](603979776,11,{optionGroups:1}),a["\u0275qud"](603979776,12,{customTrigger:0}),a["\u0275pid"](131072,p.i,[p.j,a.ChangeDetectorRef]),a["\u0275prd"](2048,[[1,4],[2,4]],c.d,null,[b.c]),(l()(),a["\u0275and"](16777216,null,1,1,null,A)),a["\u0275did"](23,278528,null,0,F.NgForOf,[a.ViewContainerRef,a.TemplateRef,a.IterableDiffers],{ngForOf:[0,"ngForOf"]},null),(l()(),a["\u0275and"](16777216,null,5,1,null,O)),a["\u0275did"](25,16384,null,0,F.NgIf,[a.ViewContainerRef,a.TemplateRef],{ngIf:[0,"ngIf"]},null)],(function(l,n){var e=n.component;l(n,13,0,a["\u0275inlineInterpolate"](1,"page_homepage_",n.parent.context.$implicit.key,"")),l(n,16,0,a["\u0275inlineInterpolate"](2,"",a["\u0275unv"](n,16,0,a["\u0275nov"](n,20).transform("settings.placeholder"))," ",n.parent.context.$implicit.key,"")),l(n,23,0,e.pages[n.parent.context.$implicit.key]),l(n,25,0,!e.settingForm.controls["page_homepage_"+n.parent.context.$implicit.key].valid&&e.settingForm.controls["page_homepage_"+n.parent.context.$implicit.key].errors.required)}),(function(l,n){l(n,0,1,["standard"==a["\u0275nov"](n,1).appearance,"fill"==a["\u0275nov"](n,1).appearance,"outline"==a["\u0275nov"](n,1).appearance,"legacy"==a["\u0275nov"](n,1).appearance,a["\u0275nov"](n,1)._control.errorState,a["\u0275nov"](n,1)._canLabelFloat,a["\u0275nov"](n,1)._shouldLabelFloat(),a["\u0275nov"](n,1)._hasFloatingLabel(),a["\u0275nov"](n,1)._hideControlPlaceholder(),a["\u0275nov"](n,1)._control.disabled,a["\u0275nov"](n,1)._control.autofilled,a["\u0275nov"](n,1)._control.focused,"accent"==a["\u0275nov"](n,1).color,"warn"==a["\u0275nov"](n,1).color,a["\u0275nov"](n,1)._shouldForward("untouched"),a["\u0275nov"](n,1)._shouldForward("touched"),a["\u0275nov"](n,1)._shouldForward("pristine"),a["\u0275nov"](n,1)._shouldForward("dirty"),a["\u0275nov"](n,1)._shouldForward("valid"),a["\u0275nov"](n,1)._shouldForward("invalid"),a["\u0275nov"](n,1)._shouldForward("pending"),!a["\u0275nov"](n,1)._animationsEnabled]),l(n,11,1,[a["\u0275nov"](n,15).ngClassUntouched,a["\u0275nov"](n,15).ngClassTouched,a["\u0275nov"](n,15).ngClassPristine,a["\u0275nov"](n,15).ngClassDirty,a["\u0275nov"](n,15).ngClassValid,a["\u0275nov"](n,15).ngClassInvalid,a["\u0275nov"](n,15).ngClassPending,a["\u0275nov"](n,16).id,a["\u0275nov"](n,16).tabIndex,a["\u0275nov"](n,16)._getAriaLabel(),a["\u0275nov"](n,16)._getAriaLabelledby(),a["\u0275nov"](n,16).required.toString(),a["\u0275nov"](n,16).disabled.toString(),a["\u0275nov"](n,16).errorState,a["\u0275nov"](n,16).panelOpen?a["\u0275nov"](n,16)._optionIds:null,a["\u0275nov"](n,16).multiple,a["\u0275nov"](n,16)._ariaDescribedby||null,a["\u0275nov"](n,16)._getAriaActiveDescendant(),a["\u0275nov"](n,16).disabled,a["\u0275nov"](n,16).errorState,a["\u0275nov"](n,16).required,a["\u0275nov"](n,16).empty])}))}function M(l){return a["\u0275vid"](0,[(l()(),a["\u0275eld"](0,0,null,null,2,"div",[],null,null,null,null,null)),(l()(),a["\u0275and"](16777216,null,null,1,null,V)),a["\u0275did"](2,16384,null,0,F.NgIf,[a.ViewContainerRef,a.TemplateRef],{ngIf:[0,"ngIf"]},null)],(function(l,n){var e=n.component;l(n,2,0,e.pages&&e.pages[n.context.$implicit.key].length>0)}),null)}function T(l){return a["\u0275vid"](0,[(l()(),a["\u0275eld"](0,0,null,null,21,"div",[["class","container-fluid"]],null,null,null,null,null)),(l()(),a["\u0275eld"](1,0,null,null,20,"div",[["class","page form-page"]],null,null,null,null,null)),(l()(),a["\u0275eld"](2,0,null,null,2,"h3",[],null,null,null,null,null)),(l()(),a["\u0275ted"](3,null,["",""])),a["\u0275pid"](131072,p.i,[p.j,a.ChangeDetectorRef]),(l()(),a["\u0275eld"](5,0,[["f",1]],null,16,"form",[["novalidate",""]],[[2,"ng-untouched",null],[2,"ng-touched",null],[2,"ng-pristine",null],[2,"ng-dirty",null],[2,"ng-valid",null],[2,"ng-invalid",null],[2,"ng-pending",null]],[[null,"ngSubmit"],[null,"submit"],[null,"reset"]],(function(l,n,e){var o=!0,t=l.component;return"submit"===n&&(o=!1!==a["\u0275nov"](l,7).onSubmit(e)&&o),"reset"===n&&(o=!1!==a["\u0275nov"](l,7).onReset()&&o),"ngSubmit"===n&&(o=!1!==t.saveHandler()&&o),o}),null,null)),a["\u0275did"](6,16384,null,0,_.E,[],null,null),a["\u0275did"](7,540672,null,0,_.l,[[8,null],[8,null]],{form:[0,"form"]},{ngSubmit:"ngSubmit"}),a["\u0275prd"](2048,null,_.c,null,[_.l]),a["\u0275did"](9,16384,null,0,_.u,[[4,_.c]],null,null),(l()(),a["\u0275eld"](10,0,null,null,4,"div",[["class","row clearfix"]],null,null,null,null,null)),(l()(),a["\u0275eld"](11,0,null,null,3,"div",[["class","col col-sm-12 fields-col"]],null,null,null,null,null)),(l()(),a["\u0275and"](16777216,null,null,2,null,M)),a["\u0275did"](13,278528,null,0,F.NgForOf,[a.ViewContainerRef,a.TemplateRef,a.IterableDiffers],{ngForOf:[0,"ngForOf"]},null),a["\u0275pid"](0,F.KeyValuePipe,[a.KeyValueDiffers]),(l()(),a["\u0275eld"](15,0,null,null,6,"div",[["class","row clearfix"]],null,null,null,null,null)),(l()(),a["\u0275eld"](16,0,null,null,5,"div",[["class","col col-sm-12 fields-col tar"]],null,null,null,null,null)),(l()(),a["\u0275eld"](17,0,null,null,4,"div",[["class","field stacked tar"]],null,null,null,null,null)),(l()(),a["\u0275eld"](18,0,null,null,3,"button",[["color","primary"],["mat-raised-button",""]],[[1,"disabled",0],[2,"_mat-animation-noopable",null]],null,null,w.d,w.b)),a["\u0275did"](19,180224,null,0,R.b,[a.ElementRef,C.h,[2,f.a]],{disabled:[0,"disabled"],color:[1,"color"]},null),(l()(),a["\u0275ted"](20,0,["",""])),a["\u0275pid"](131072,p.i,[p.j,a.ChangeDetectorRef])],(function(l,n){var e=n.component;l(n,7,0,e.settingForm),l(n,13,0,a["\u0275unv"](n,13,0,a["\u0275nov"](n,14).transform(e.availableLanguages))),l(n,19,0,e.settingForm.invalid,"primary")}),(function(l,n){l(n,3,0,a["\u0275unv"](n,3,0,a["\u0275nov"](n,4).transform("settings.title"))),l(n,5,0,a["\u0275nov"](n,9).ngClassUntouched,a["\u0275nov"](n,9).ngClassTouched,a["\u0275nov"](n,9).ngClassPristine,a["\u0275nov"](n,9).ngClassDirty,a["\u0275nov"](n,9).ngClassValid,a["\u0275nov"](n,9).ngClassInvalid,a["\u0275nov"](n,9).ngClassPending),l(n,18,0,a["\u0275nov"](n,19).disabled||null,"NoopAnimations"===a["\u0275nov"](n,19)._animationMode),l(n,20,0,a["\u0275unv"](n,20,0,a["\u0275nov"](n,21).transform("save")))}))}function P(l){return a["\u0275vid"](0,[(l()(),a["\u0275eld"](0,0,null,null,1,"app-setting",[],null,null,null,T,x)),a["\u0275did"](1,114688,null,0,q,[k,I.a,_.g,D.m,N.j],null,null)],(function(l,n){l(n,1,0)}),null)}var E=a["\u0275ccf"]("app-setting",q,P,{},{},[]),U=e("POq0"),$=e("QQfA"),z=e("s6ns"),J=e("821u"),Z=e("/Co4"),B=e("fgD+"),H=e("978R"),K=e("2uy1"),W=e("z/SZ"),X=e("cUpR"),G=e("Gi4r"),Q=e("oapL"),Y=e("ZwOa"),ll=e("elxJ"),nl=e("r0V8"),el=e("zMNK"),al=e("8P0U"),ol=e("W5yJ"),tl=e("VQoA"),il=e("S6T7"),dl=e("cw5Z"),ul=e("rWV4"),rl=e("MNke"),sl=e("kNGD"),cl=e("PCNd"),pl=e("dvZr");e.d(n,"SettingModuleNgFactory",(function(){return ml}));var ml=a["\u0275cmf"](o,[],(function(l){return a["\u0275mod"]([a["\u0275mpd"](512,a.ComponentFactoryResolver,a["\u0275CodegenComponentFactoryResolver"],[[8,[t.a,i.a,d.b,d.a,u.a,E]],[3,a.ComponentFactoryResolver],a.NgModuleRef]),a["\u0275mpd"](4608,F.NgLocalization,F.NgLocaleLocalization,[a.LOCALE_ID,[2,F["\u0275angular_packages_common_common_a"]]]),a["\u0275mpd"](4608,_.C,_.C,[]),a["\u0275mpd"](4608,_.g,_.g,[]),a["\u0275mpd"](4608,U.c,U.c,[]),a["\u0275mpd"](4608,s.d,s.d,[]),a["\u0275mpd"](4608,$.c,$.c,[$.i,$.e,a.ComponentFactoryResolver,$.h,$.f,a.Injector,a.NgZone,F.DOCUMENT,g.b,[2,F.Location]]),a["\u0275mpd"](5120,$.j,$.k,[$.c]),a["\u0275mpd"](5120,z.c,z.d,[$.c]),a["\u0275mpd"](135680,z.e,z.e,[$.c,a.Injector,[2,F.Location],[2,z.b],z.c,[3,z.e],$.e]),a["\u0275mpd"](5120,b.a,b.b,[$.c]),a["\u0275mpd"](4608,J.i,J.i,[]),a["\u0275mpd"](5120,J.a,J.b,[$.c]),a["\u0275mpd"](5120,Z.b,Z.c,[$.c]),a["\u0275mpd"](4608,s.c,B.a,[s.h]),a["\u0275mpd"](4608,H.a,H.a,[]),a["\u0275mpd"](4608,K.a,K.a,[a.RendererFactory2,a.PLATFORM_ID]),a["\u0275mpd"](4608,W.a,W.a,[a.ComponentFactoryResolver,a.NgZone,a.Injector,K.a,a.ApplicationRef]),a["\u0275mpd"](1073742336,F.CommonModule,F.CommonModule,[]),a["\u0275mpd"](1073742336,D.o,D.o,[[2,D.t],[2,D.m]]),a["\u0275mpd"](1073742336,_.B,_.B,[]),a["\u0275mpd"](1073742336,_.n,_.n,[]),a["\u0275mpd"](1073742336,_.y,_.y,[]),a["\u0275mpd"](1073742336,g.a,g.a,[]),a["\u0275mpd"](1073742336,s.n,s.n,[[2,s.f],[2,X.f]]),a["\u0275mpd"](1073742336,G.c,G.c,[]),a["\u0275mpd"](1073742336,U.d,U.d,[]),a["\u0275mpd"](1073742336,c.e,c.e,[]),a["\u0275mpd"](1073742336,v.b,v.b,[]),a["\u0275mpd"](1073742336,Q.c,Q.c,[]),a["\u0275mpd"](1073742336,Y.c,Y.c,[]),a["\u0275mpd"](1073742336,s.y,s.y,[]),a["\u0275mpd"](1073742336,R.c,R.c,[]),a["\u0275mpd"](1073742336,ll.d,ll.d,[]),a["\u0275mpd"](1073742336,nl.d,nl.d,[]),a["\u0275mpd"](1073742336,nl.c,nl.c,[]),a["\u0275mpd"](1073742336,el.g,el.g,[]),a["\u0275mpd"](1073742336,y.b,y.b,[]),a["\u0275mpd"](1073742336,$.g,$.g,[]),a["\u0275mpd"](1073742336,z.k,z.k,[]),a["\u0275mpd"](1073742336,s.w,s.w,[]),a["\u0275mpd"](1073742336,s.t,s.t,[]),a["\u0275mpd"](1073742336,b.d,b.d,[]),a["\u0275mpd"](1073742336,al.c,al.c,[]),a["\u0275mpd"](1073742336,C.a,C.a,[]),a["\u0275mpd"](1073742336,J.j,J.j,[]),a["\u0275mpd"](1073742336,Z.e,Z.e,[]),a["\u0275mpd"](1073742336,ol.c,ol.c,[]),a["\u0275mpd"](1073742336,H.d,H.d,[]),a["\u0275mpd"](1073742336,tl.a,tl.a,[]),a["\u0275mpd"](1073742336,tl.g,tl.g,[]),a["\u0275mpd"](1073742336,tl.d,tl.d,[]),a["\u0275mpd"](1073742336,tl.b,tl.b,[]),a["\u0275mpd"](1073742336,tl.e,tl.e,[]),a["\u0275mpd"](1073742336,tl.c,tl.c,[]),a["\u0275mpd"](1073742336,tl.f,tl.f,[]),a["\u0275mpd"](1073742336,il.FileUploadModule,il.FileUploadModule,[]),a["\u0275mpd"](1073742336,dl.b,dl.b,[]),a["\u0275mpd"](1073742336,ul.j,ul.j,[]),a["\u0275mpd"](1073742336,p.g,p.g,[]),a["\u0275mpd"](1073742336,rl.b,rl.b,[]),a["\u0275mpd"](1073742336,sl.f,sl.f,[]),a["\u0275mpd"](1073742336,cl.a,cl.a,[]),a["\u0275mpd"](1073742336,o,o,[]),a["\u0275mpd"](256,sl.a,{separatorKeyCodes:[pl.g]},[]),a["\u0275mpd"](256,s.g,cl.b,[]),a["\u0275mpd"](1024,D.j,(function(){return[[{path:"",component:q}]]}),[])])}))}}]);