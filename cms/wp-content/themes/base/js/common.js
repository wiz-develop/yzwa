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
        setTimeout(function () {
          HeaderHeight = $('.site-header').outerHeight();
          hashposi = $(urlHash).offset().top - HeaderHeight;
          $('body,html').animate({scrollTop:hashposi}, speed, 'swing');
        }, 300);
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

  /*-------------------------------------------*/
  /* ポップアップ
  /*-------------------------------------------*/
  // デフォルト
  $(document).on('click','.modal_trigger', function(){
    var modal_box = $(this).next('.modal_box');
    modal_box.fadeIn(); // モーダルを表示する
    $('body').addClass('overflow-hidden');
    if (modal_box.find('video').get(0)) {
      modal_box.find('video').get(0).play();
      modal_box.find('video').addClass('playing');
    }
  });

  // ポップアップを閉じる
  $(document).on('click','.modal_close , .modal_bg', function(){
    $('.modal_box').fadeOut(); // モーダルを非表示にする
    $('body').removeClass('overflow-hidden');
    $('.playing').get(0).pause();
    $('.playing').removeClass('playing');
  });

  // メニュー用
  $(document).on('click','.sitemap_trigger', function(){
    $('#sitemap_modal').fadeIn();
    $('body').addClass('overflow-hidden');
  });
  
  /*-------------------------------------------*/
  /* スライドショー
  /*-------------------------------------------*/
  $('.service_carousel').slick({
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 800,
    dots: false,
    arrows: false,
    infinite: true,
    pauseOnHover: false,
    slidesToShow: 4,
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
      breakpoint: 769,
       settings: {
        slidesToShow: 2,
      },
     },
    ]
  });
  slideAlignHeight('.service_carousel .slide_item');

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
