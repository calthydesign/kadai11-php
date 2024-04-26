$(document).ready(function() {
    $('.slide-container').slick({
      dots: false, // ページネーションドットを非表示
      arrows: false, // 前後矢印を非表示
      infinite: false, // 無限ループをオフ
      swipe: false, // スワイプ操作をオフ
      draggable: false, // ドラッグ操作をオフ
    });
  
    $('.next-btn').on('click', function() {
      $('.slide-container').slick('slickNext');
    });
  });