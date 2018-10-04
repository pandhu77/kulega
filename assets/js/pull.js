$(window).load(function() {
  $(function() {
    var pull = $('.nav-button-bar');
    var menu = $('.nav-bar');
      var pull2 = $('.nav-button-login');
      var menu2 = $('.nav-login');

    $(pull).on('click', function(e) {
      e.preventDefault();
      menu.slideToggle(200);
    });
    $(pull2).on('click', function(e) {
      e.preventDefault();
      menu2.slideToggle(200);
    });
  });
});
