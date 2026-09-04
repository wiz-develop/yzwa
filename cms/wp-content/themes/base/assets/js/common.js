jQuery(function($){ 

  /*-------------------------------------------*/
  /* jsでサイトのURL・テーマのパスを使えるようにする
  /*-------------------------------------------*/
  var wp_temp_uri = tmp_path.temp_uri;
  var wp_home_url = tmp_path.home_url;

  /*-------------------------------------------*/
  /* スムーススクロール
  /*-------------------------------------------*/
  var HeaderHeight = $('.site-header').outerHeight();
  var speed = 100;
	$('a[href^="#"]').on('click', function() {
    $(this).off('click');
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top - HeaderHeight;
		$('body,html').animate({scrollTop:position}, speed, 'swing');
		return false;
  });

  $(document).ready(function(){
    var urlHash = location.hash;
    if(urlHash) {
        hashposi = $(urlHash).offset().top - HeaderHeight;
        setTimeout(function () {
          $('body,html').animate({scrollTop:hashposi}, speed, 'swing');
        }, 100);
    }
  });

  /*-------------------------------------------*/
  /* アニメーション
  /*-------------------------------------------*/
  $('.anime').addClass('anime_active');

  $(function () {
    if ($('.business_catch').length) {
        scrollAnimation();
    }
    function scrollAnimation() {
        $(window).scroll(function () {
            $(".business_catch").each(function () {
                let position = $(this).offset().top,
                    scroll = $(window).scrollTop(),
                    windowHeight = $(window).height();

                if (scroll > position - windowHeight + 200) {
                    $(this).addClass('is-animated');
                }
            });
        });
    }
    $(window).trigger('scroll');
  });

  $(function () {
    if ($('.line-anime').length) {
        scrollAnimation();
    }
    function scrollAnimation() {
        $(window).scroll(function () {
            $(".line-anime").each(function () {
                let position = $(this).offset().top,
                    scroll = $(window).scrollTop(),
                    windowHeight = $(window).height();

                if (scroll > position - windowHeight + 200) {
                    $(this).addClass('is-animated');
                }
            });
        });
    }
    $(window).trigger('scroll');
  });

  $(function () {
    if ($('.widget_tit_ja').length) {
        scrollAnimation();
    }
    function scrollAnimation() {
        $(window).scroll(function () {
            $(".widget_tit_ja").each(function () {
                let position = $(this).offset().top,
                    scroll = $(window).scrollTop(),
                    windowHeight = $(window).height();

                if (scroll > position - windowHeight + 200) {
                    $(this).addClass('is-animated');
                }
            });
        });
    }
    $(window).trigger('scroll');
  });

  $(function () {
    if ($('.purun').length) {
        scrollAnimation();
    }
    function scrollAnimation() {
        $(window).scroll(function () {
            $(".purun").each(function () {
                let position = $(this).offset().top,
                    scroll = $(window).scrollTop(),
                    windowHeight = $(window).height();

                if (scroll > position - windowHeight + 200) {
                    $(this).addClass('is-animated');
                }
            });
        });
    }
    $(window).trigger('scroll');
  });

  $(window).on('load',function(){
    if (!$('.home').length) {
      $('body').addClass('appear');
    }
  });

  function delayScrollAnime() {
    var time = 0.2;
    var value = time;
    $('.delayScroll').each(function () {
      var parent = this;				
      var elemPos = $(this).offset().top;
      var scroll = $(window).scrollTop();
      var windowHeight = $(window).height();
      var childs = $(this).children();
      
      if (scroll >= elemPos - windowHeight && !$(parent).hasClass("play")) {
        $(childs).each(function () {
          
          if (!$(this).hasClass("fadeIn")) {
            
            $(parent).addClass("play");
            $(this).css("animation-delay", value + "s");
            $(this).addClass("fadeIn");
            value = value + time;
            
            var index = $(childs).index(this);
            if((childs.length-1) == index){
              $(parent).removeClass("play");
            }
          }
        })
      }else {
        $(childs).removeClass("fadeIn");
        value = time;
      }
    })
  }
  $(window).scroll(function (){
		delayScrollAnime("fadeIn");
	});

  /*-------------------------------------------*/
  /* お問い合わせ お問い合わせ種別の自動選択
  /*-------------------------------------------*/
  var kinds = '';
  
  if(location.search){
      kinds = getParam('kinds');
      if (kinds) {
        document.getElementById('kinds').value = kinds;
      }
  }

  function getParam(name, url) {
      if (!url) url = window.location.href;
      name = name.replace(/[\[\]]/g, "\\$&");
      var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
          results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return '';
      return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  /*-------------------------------------------*/
  /* ポップアップ
  /*-------------------------------------------*/
  // デフォルト
  $(document).on('click','.modal_trigger', function(){
    var modal_box = $(this).next('.modal_box');
    modal_box.fadeIn(); // モーダルを表示する
    $('body').addClass('overflow-hidden');
    $('.business_carousel').slick({ // slick開始
      autoplay: false,
      autoplaySpeed: 2000,
      speed: 800,
      // dots: false,
      arrows: true,
      infinite: true,
      pauseOnHover: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      centerMode: true,
      prevArrow: '<button type="button" class="slick-prev"><img src="'+wp_temp_uri+'/assets/image/common/slick-prev.png"></button>',
      nextArrow: '<button type="button" class="slick-next"><img src="'+wp_temp_uri+'/assets/image/common/slick-next.png"></button>',
      responsive: [{
      //   breakpoint: 992,
      //   settings: {
      //     slidesToShow: 3,
      //   },
      //   },
      // {
        breakpoint: 769,
        settings: {
          centerMode: false,
        },
      },
      ]
    });
    slideAlignHeight('.business_carousel .business_item');
  });

  // ポップアップを閉じる
  $(document).on('click','.modal_close , .modal_bg', function(){
    $('.modal_box').fadeOut(); // モーダルを非表示にする
    $('body').removeClass('overflow-hidden');
    $('.business_carousel.slick-initialized').slick('unslick'); // slick解除
  });

  // メニュー用
  $(document).on('click','.sitemap_trigger', function(){
    $('#sitemap_modal').fadeIn();
    $('body').addClass('overflow-hidden');
  });
  
  /*-------------------------------------------*/
  /* スライドショー
  /*-------------------------------------------*/
  $('.develop_carousel').slick({
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 800,
    dots: false,
    arrows: false,
    infinite: true,
    pauseOnHover: false,
    slidesToShow: 5,
    slidesToScroll: 1,
    centerMode: true,
    prevArrow: '<button type="button" class="slick-prev"><img src="'+wp_temp_uri+'/assets/image/common/slick-prev.png"></button>',
    nextArrow: '<button type="button" class="slick-next"><img src="'+wp_temp_uri+'/assets/image/common/slick-next.png"></button>',
    responsive: [{
      breakpoint: 992,
       settings: {
        slidesToShow: 3,
       },
      },
     {
      breakpoint: 576,
       settings: {
        slidesToShow: 2,
      },
     },
    ]
  });
  slideAlignHeight('.develop_carousel .slide_item');

  $('.case_carousel').slick({
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 800,
    dots: false,
    arrows: false,
    infinite: true,
    pauseOnHover: false,
    slidesToShow: 5,
    slidesToScroll: 1,
    centerMode: true,
    prevArrow: '<button type="button" class="slick-prev"><img src="'+wp_temp_uri+'/assets/image/common/slick-prev.png"></button>',
    nextArrow: '<button type="button" class="slick-next"><img src="'+wp_temp_uri+'/assets/image/common/slick-next.png"></button>',
    responsive: [{
      breakpoint: 992,
       settings: {
        slidesToShow: 3,
       },
      },
      {
        breakpoint: 576,
         settings: {
          slidesToShow: 1,
        },
      },
    ]
  });

  $('.business_slick_content').slick({
    autoplay: true,
    autoplaySpeed: 0,
    speed: 2000,
    cssEase: 'linear',
    swipe: false,
    dots: false,
    arrows: false,
    infinite: true,
    pauseOnHover: false,
    slidesToShow: 5,
    slidesToScroll: 1,
    centerMode: true,
    responsive: [{
      breakpoint: 992,
       settings: {
        slidesToShow: 3,
       },
      },
     {
      breakpoint: 576,
       settings: {
        slidesToShow: 2,
      },
     },
    ]
  });
  slideAlignHeight('.business_slick_content .business_item');

  function slideAlignHeight($class) {
    window.addEventListener('load', function() {
      var maxSliderHeight = 0;
      $($class).each(function(idx, elem) {
        var sliderHeight = $(elem).height();
        if(maxSliderHeight < sliderHeight) {
          maxSliderHeight = sliderHeight;
        }
      });
      $($class).height(maxSliderHeight);
    });
  }

  /*-------------------------------------------*/
  /* アコーディオン
  /*-------------------------------------------*/
  // 上から下へ表示
  $('.ac-parent').on('click', function() {
    $(this).toggleClass('open');
    $(this).next('.ac-child').slideToggle();
  });

  /*-------------------------------------------*/
  /* アーカイブ ページネーション
  /*-------------------------------------------*/
  if ($('.pnavi')) {
    $("a.page-numbers").each( function() {
        var pageNumbers = $(this).attr('href');
        if (pageNumbers == '') {
          $(this).attr('href', location.pathname);
        }
    });
    return false;
  }
});
