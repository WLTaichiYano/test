"use strict";!function(a,b){b.mery=b.mery||{},mery.utils=mery.utils||{},mery.utils.footerHeight=function(){var b=50;return b+=a(".m-footer").outerHeight(),b+=a(".m-footerBottom").outerHeight(),b+=a(".m-footer-appLink").outerHeight(!0),b+=a(".bottomBreadcrumb").outerHeight()},mery.utils.format=mery.utils.format||{},mery.utils.format.numberWithDelimiter=function(a){return a.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g,"$1,")},mery.api=mery.api||{},mery.api.updateImageAction=function(b){a.post("/image_actions/update",{image_id:b})},mery.api.updateBrandProductAction=function(b){a.post("/brand_product_actions/update",{brand_product_id:b})},mery.api.updateEcProductAction=function(b,c){a.post("/ec_product_actions/update",{product_id:b,image_id:c.imageId,list_id:c.listId,page:c.page})},mery.api.updateProductAction=function(b,c){"undefined"==typeof c&&(c={});var d={product_id:b};c.listId&&(d.list_id=c.listId),c.page&&(d.page=c.page),a.post("/product_actions/update",d)},mery.api.updateShopItemAction=function(b,c){"undefined"==typeof c&&(c={});var d={shop_item_id:b};c.listId&&(d.list_id=c.listId),c.page&&(d.page=c.page),c.imageNumber&&(d.image_number=c.imageNumber),a.post("/shop_item_actions/update",d)},mery.api.updateHairSalonAction=function(b,c){"undefined"==typeof c&&(c={});var d={hair_salon_id:b};c.listId&&(d.list_id=c.listId),c.page&&(d.page=c.page),a.post("/hair_salon_actions/update",d)},mery.api.updateInstagramPhotoAction=function(b){a.post("/instagram_photo_actions/update",{instagram_photo_id:b})},mery.api.updateTweetAction=function(b){a.post("/tweet_actions/update",{tweet_id:b})},mery.api.updateHairStyleAction=function(b){a.post("/hair_style_actions/update",{hair_style_id:b})},mery.api.updateFoodImageAction=function(b){a.post("/food_image_actions/update",{food_image_id:b})},mery.api.updateRestaurantAction=function(b,c){"undefined"==typeof c&&(c={});var d={restaurant_id:b};c.listId&&(d.list_id=c.listId),c.page&&(d.page=c.page),a.post("/restaurant_actions/update",d)},mery.api.postListShareAction=function(b,c){var d={list_id:b,at:c.at,page:c.page};c.position&&(d.position=c.position),a.post("/list_actions/share",d)},mery.api.postListShareFinishAction=function(b,c){var d={list_id:b,at:c.at,page:c.page};c.position&&(d.position=c.position),a.post("/list_actions/share_finish",d)},mery.api.postListLikeAction=function(b,c){var d={list_id:b,at:c.at,page:c.page};c.position&&(d.position=c.position),a.post("/list_actions/like",d)},mery.api.postAppInstallBannerClose=function(b){"undefined"==typeof b&&(b={});var c={page_id:b.pageId,position:b.position};a.post("/banners/close_app_install",c)},mery.api.postAllianceSiteLinkClickAction=function(b){a.post("/banners/click_banner",{target_id:b.targetId,page_id:b.pageId,position:b.position})},mery.api.postMeryFacebookLikeAction=function(b){a.post("/sns_share/facebook_like",b)},mery.api.postMeryTwitterFollowAction=function(b){a.post("/sns_share/twitter_follow",b)},mery.api.postMeryTwitterFollowFinishAction=function(b){a.post("/sns_share/twitter_follow_finish",b)}}(jQuery,window,document),jQuery(function(a){function b(){var b=200,c=1e3,d=c-1,e=0,f=1,g=2,h=3,i=4;this.animateSmoothSlide=function(b,c){var d={x:0,y:0,z:0,speed:200,onComplete:function(){}},e=a.extend({},d,c),f=[e.x+"px",e.y+"px",e.z+"px"].join(",");b.css({"-webkit-transform":"translate3d("+f+")","-webkit-transition":"-webkit-transform "+e.speed+"ms cubic-bezier(0,0,0.25,1)",transform:"translate3d("+f+")",transition:"transform "+e.speed+"ms cubic-bezier(0,0,0.25,1)"}),setTimeout(e.onCompleted,e.speed+1)},this.hasOverflowScrolling=function(){var a=["webkit"],b=document.createElement("div"),c=document.getElementsByTagName("body")[0],d=!1;c.appendChild(b);for(var e=0;e<a.length;e++){var f=a[e];b.style[f+"OverflowScrolling"]="touch"}b.style.overflowScrolling="touch";var g=window.getComputedStyle(b);d=!!g.overflowScrolling;for(var e=0;e<a.length;e++){var f=a[e];if(g[f+"OverflowScrolling"]){d=!0;break}}return b.parentNode.removeChild(b),d},this.open=function(){var a=this;a.isFullyClose&&(a.animateStatus=h,a.onOpening(),a.overlay.show(0,function(){a.overlay.css("left",0)}),a.sidebar.show(0,function(){a.sidebar.scrollTop(1)}),a.animateSmoothSlide(a.slideContent,{x:a.slideWidth,speed:b,onCompleted:function(){a.overlay.css("z-index",c),a.sidebar.css("z-index",d),a.animateStatus=g,a.onOpened()}}))},this.close=function(){var a=this;a.isFullyOpen()&&(a.animateStatus=i,a.onClosing(),a.sidebar.css("z-index",e),a.animateSmoothSlide(a.slideContent,{x:0,speed:b,onCompleted:function(){a.sidebar.hide(),a.overlay.css("left",0),a.overlay.hide(),a.animateStatus=f,a.onClosed()}}))},this.toggle=function(){this.isFullyOpen()?this.close():this.open()},this.isFullyOpen=function(){return this.animateStatus===g},this.isFullyClose=function(){return this.animateStatus===f},this.init=function(b){var c=this,d={overlay:"#overlay",mainContent:"#page_wrapp",sidebar:"#sidebar",slideContent:"#page_wrapp, #header, #overlay",button:".btn_slide",onOpening:function(){},onClosing:function(){},onOpened:function(){a("#side_menu_head").attr("href",a("#side_menu_head").attr("xhref")),a("#side_menu_head").removeAttr("xhref")},onClosed:function(){a("#side_menu_head").attr("xhref",a("#side_menu_head").attr("href")),a("#side_menu_head").removeAttr("href")}},e=a.extend({},d,b);if(c.hasOverflowScrollingFlag=!1,c.mainContent=a(e.mainContent),c.sidebar=a(e.sidebar),c.button=a(e.button),c.animateStatus=f,c.slideWidth=c.sidebar.width(),c.onOpening=e.onOpening,c.onOpened=e.onOpened,c.onClosing=e.onClosing,c.onClosed=e.onClosed,c.overlay=a("<div id='overlay'>").css({overflow:"hidden",width:"100%",height:"100%","z-index":"999",position:"fixed",left:0,top:0}).hide(),c.mainContent.after(c.overlay),c.slideContent=a(e.slideContent),c.sidebar.css({position:"fixed",top:0,left:0,"-webkit-overflow-scrolling":"touch",overflow:"scroll",height:"100%","min-height":"100%","z-index":-1}).hide(),c.overlay.bind("touchstart touchend touchmove",function(a){a.preventDefault(),c.close()}),c.mainContent.bind("touchstart touchend touchmove",function(a){c.isFullyOpen()&&a.preventDefault()}),c.sidebar.bind("touchstart touchend touchmove",function(a){c.isFullyClose()?a.preventDefault():c.isFullyOpen()&&a.stopPropagation()}),!c.hasOverflowScrollingFlag){var g={x:0,y:0},h=null;c.sidebar.bind("touchstart touchmove",function(a){if("touchstart"==a.type){var b=a.originalEvent.targetTouches[0];g.x=b.pageX,g.y=b.pageY,h=c.sidebar.scrollTop()}else if("touchmove"==a.type){a.preventDefault();var d=g.y-a.originalEvent.targetTouches[0].pageY;c.sidebar.scrollTop(h+d)}})}c.button.bind("touchend click",function(a){a.preventDefault(),c.open()})}}a(".modal_share .modal_close_btn").on("touchend, click",function(b){b.preventDefault(),a(".modal_share").hide()}),a(".share_btn").on("touchend, click",function(b){b.preventDefault(),window.scroll(0,0),a(".modal_share").show()});var c=a("#normal_view"),d=a("#search_view"),e=a("#sp_search");a("#header_search_btn").on("touchend, click",function(){c.hide(),d.show(),e.focus()}),a("#close_search").on("touchend, click",function(a){a.preventDefault(),c.show(),d.hide()});var f=a("#article").attr("data-category");a(".cat_"+f).addClass("active_category");var g=g||{};g.errorImage=function(b,c){var d;d="twitter"===c?"/images/tw_default.png":"/images/insta_default.png",a(b).attr({src:d})},g.errorTweetImage=function(b){a(b).remove()},g.errorInstaImage=function(b){a(b).parent().parent().remove()};var h=function(){var b=a(this).data("sns-type");g.errorImage(this,b)};a('.icon[src="/images/noimage2.png"],.insta_icon[src="/images/noimage2.png"]').each(h),a(".icon,.insta_icon").on("error",h),a(".tweet .icon > img").on("error",h);var i=function(){g.errorInstaImage(this)};a('.insta_photo[src="/images/noimage2.png"]').each(i),a(".insta_photo").on("error",i);var j=function(){g.errorTweetImage(this)};a('.image > img[src="/images/noimage2.png"]').each(j),a(".image > img").on("error",j),a(".icon,.insta_icon,.insta_photo,.image > img").each(function(){this.src=this.src});var k=function(){var b=a(this),c=b.attr("src"),d=b.parents(".article_content");d.length<=0&&(d=b.parents(".x-content-area"));var e=a(d).data("item-id"),f=a(d).data("item-type"),g=a(".articleArea").data("list-id");g||(g=a(".content_area").data("list-id")),a.ajax({url:"/api/registration_not_found_images",method:"POST",dataType:"json",data:{image_url:c,list_id:g,resource_id:e,reference_type:f}}).done(function(){a(d).remove()})};a('.x-article-image[src="/images/noimage2.png"]').each(k),a(".x-article-image").on("error",k),a(".x-article-image").each(function(){this.src=this.src}),a(".x-image-resize").each(function(){var b=a(this),c=new Image;c.onload=function(){var a=b.attr("width"),c=b.attr("height");b.removeClass("x-image-resize"),b.within({width:a,height:c})},c.onerror=function(){var c=b.attr("width"),d=b.attr("height");b.removeClass("x-image-resize"),b.within({width:c,height:d});var e=b.attr("src"),f=b.parent().data("list-id");a.ajax({url:"/api/registration_not_found_images",method:"POST",dataType:"json",data:{image_url:e,list_id:f,resource_id:f,reference_type:"List"}})},c.src=a(this).attr("src")});var l=new b;l.init({overlay:"#overlay",sidebar:"#side_menu",mainContent:"#page_wrapp",slideContent:"#page_wrapp, #header, #overlay, #sp-mery-dfp-appheader0-wrapper",button:".btn_slide"}),a(window).resize(function(){l.close()});var m,n,o;a("#side_menu a").bind("touchstart",function(b){b.preventDefault(),n=b.originalEvent.targetTouches[0].clientY,m&&clearTimeout(m);var c=a(this);c.attr("touchmoved","false"),m=setTimeout(function(){c.addClass("active")},100)}),a("#side_menu a").bind("touchmove",function(b){if(b.preventDefault(),o=b.originalEvent.targetTouches[0].clientY,Math.abs(n-o)>1){m&&clearTimeout(m);var c=a(this);c.attr("touchmoved","true"),c.removeClass("active")}}),a("#side_menu a").bind("touchend",function(b){b.preventDefault();var c=a(this);"false"===c.attr("touchmoved")&&(window.location.href=c.attr("href")),c.removeClass("active")});var p=function(b,c){mery.api.postMeryFacebookLikeAction({page_id:a(c).data("page-id"),position:a(c).data("position"),list_id:a(c).data("list-id"),page:a(c).data("page")})},q=function(b){var c=a(b.target.parentNode);a(c).data("click")&&mery.api.postMeryTwitterFollowAction({page_id:a(c).data("page-id"),position:a(c).data("position"),list_id:a(c).data("list-id"),page:a(c).data("page")})};a(document).on("FBSDKLoaded",function(){FB.Event.subscribe("edge.create",p)}),twttr.ready(function(a){a.events.bind("click",q)})});