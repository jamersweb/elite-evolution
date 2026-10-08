$(document).ready(function() {
    $(document).on('click', '.like-reaction', function() {
        var likeaction = $(this);

        if ($(this).find('img').hasClass('active')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "/elite-evolution/public/post-dislike",
                data: {
                    // _token: "{{ csrf_token() }}",
                    id: $(this).data('id'),
                    type: $(this).data('type'),
                    reaction: $(this).data('reaction'),
                },
                dataType: "json",
                beforeSend: function() {
                    $(".ajaxpreload").show();
                },
                success: function(data) {
                    if (data != 'ffalse') {
                        $(likeaction).find('img').attr("src","../frontend/img/heart-line.png"),
                        $(likeaction).find('img').removeClass("active"),
                            toastr.error('Listing remove from your wishlist')

                        $(likeaction).parents('.like-container').find('.like-count').text(data);
                    } else {
                        window.location.href = '/';

                    }
                }
            });

        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "/elite-evolution/public/post-like",
                data: {
                    // "_token": "{{ csrf_token() }}",
                    id: $(this).data('id'),
                    type: $(this).data('type'),
                    reaction: $(this).data('reaction'),
                },
                dataType: "json",
                beforeSend: function() {
                    $(".ajaxpreload").show();
                },
                success: function(data) {
                    console.log(data);
                    if (data != false) {

                        $(likeaction).find('img').attr("src","../frontend/img/heart.png"),
                        $(likeaction).find('img').addClass("active"),
                            toastr.success('Listing added to your wishlist successfully')

                            $(likeaction).parents('.like-container').find('.like-count').text(data);

                    } else {
                        window.location.href = '/';

                    }
                }
            });
        }

    });
});



// var numSlick=0;$(".slider-products").each((function(){numSlick++,$(this).addClass("slider-"+numSlick).slick({slidesToShow:1,slidesToScroll:1,arrows:!0,fade:!0,asNavFor:".slider-nav.slider-"+numSlick})})),numSlick=0,$(".slider-nav").each((function(){numSlick++,$(this).addClass("slider-"+numSlick).slick({vertical:!1,slidesToShow:4,slidesToScroll:1,asNavFor:".slider-products.slider-"+numSlick,arrow:!0,focusOnSelect:!0,responsive:[{breakpoint:800,settings:{slidesToShow:3}}]})}));const navbarMenu=document.getElementById("menu"),burgerMenu=document.getElementById("burger"),bgOverlay=document.querySelector(".overlay");burgerMenu&&bgOverlay&&(burgerMenu.addEventListener("click",(()=>{navbarMenu.classList.add("is-active"),bgOverlay.classList.toggle("is-active")})),bgOverlay.addEventListener("click",(()=>{navbarMenu.classList.remove("show"),bgOverlay.classList.toggle("show")}))),document.querySelectorAll(".menu-link").forEach((e=>{e.addEventListener("click",(()=>{navbarMenu.classList.remove("is-active"),bgOverlay.classList.remove("is-active")}))}));const searchBlock=document.querySelector(".search-block"),searchToggle=document.querySelector(".search-toggle"),searchCancel=document.querySelector(".search-cancel");searchToggle&&searchCancel&&(searchToggle.addEventListener("click",(()=>{searchBlock.classList.add("is-active")})),searchCancel.addEventListener("click",(()=>{searchBlock.classList.remove("is-active")}))),$(".like-reaction").click((function(){$(this).find('img').hasClass("active")?($(this).find('img').attr("src","../frontend/img/heart-line.png"),$(this).find('img').removeClass("active")):($(this).find('img').attr("src","../frontend/img/heart.png"),$(this).find('img').addClass("active"))})),$(".like_img").click((function(){$(this).hasClass("active")?($(this).attr("src","assets/img/Path 81.png"),$(this).removeClass("active")):($(this).attr("src","assets/img/filled.png"),$(this).addClass("active"))})),$("#selectbox1").each((function(){var e=$(this),s=$(this).children("option").length;e.addClass("s-hidden"),e.wrap('<div class="select"></div>'),e.after('<div class="styledSelect"></div>');var t=e.next("div.styledSelect");t.text(e.children("option").eq(0).text());for(var l=$("<ul />",{class:"options"}).insertAfter(t),a=0;a<s;a++)$("<li />",{text:e.children("option").eq(a).text(),rel:e.children("option").eq(a).val()}).appendTo(l);var i=l.children("li");t.click((function(e){e.stopPropagation(),$("div.styledSelect.active").each((function(){$(this).removeClass("active").next("ul.options").hide()})),$(this).toggleClass("active").next("ul.options").toggle()})),i.click((function(s){s.stopPropagation(),t.text($(this).text()).removeClass("active"),e.val($(this).attr("rel")),l.hide()})),$(document).click((function(){t.removeClass("active"),l.hide()}))})),$(".togle").click((function(){$(this).toggleClass("click"),$(".sidebar").toggleClass("show"),$(".overlay").toggleClass("is-active")})),$(".search-toggle").click((function(){$(".togle").toggleClass("click"),$(".sidebar").toggleClass("show"),$(".overlay").toggleClass("is-active")})),bgOverlay.addEventListener("click",(()=>{$(".togle").removeClass("click"),$(".sidebar").removeClass("show"),$(".overlay").removeClass("is-active")})),$(".feat-btn").click((function(){$("nav ul .feat-show").toggleClass("show"),$("nav ul .first").toggleClass("rotate")})),$(".serv-btn").click((function(){$("nav ul .serv-show").toggleClass("show1"),$("nav ul .second").toggleClass("rotate")})),$(".comm-btn").click((function(){$("nav ul .comm-show").toggleClass("show2"),$("nav ul .third").toggleClass("rotate")})),$("nav ul li.linkz").click((function(){$(this).addClass("active").siblings().removeClass("active")})),$("[data-fancybox]").fancybox({afterClose:function(){$(this.href).show()},buttons:["close"],wheel:!1,transitionEffect:"slide",loop:!0,toolbar:!1,clickContent:!1});
