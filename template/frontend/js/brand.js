//untuk laod more
$(function () {
  $(".service-item").slice(0, 9).show();
  var max=$(".service-item").length;
  if(max < 9){
    $("#loadMore").hide();
  }
  $("#loadMore").on('click', function (e) {
    e.preventDefault();
    $(".service-item:hidden").slice(0, 9).slideDown();
    if ($(".service-item:hidden").length == 0) {
      $("#loadMore").hide();
      $('a[href=#top]').click(function () {
          $('body,html').animate({
              scrollTop: 0
          }, 600);
          return false;
      });

      $(window).scroll(function () {
          if ($(this).scrollTop() > 50) {
              $("#loadMore").hide();
              $('.totop a').fadeIn();
          } else {
              $('.totop a').fadeOut();
          }
      });
    }

  });
});
