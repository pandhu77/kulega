$(document).ready(function() {
  var owl = $("#slider");
  owl.owlCarousel({
      singleItem: true,
      items : 1,
      loop:true,
      dots:true,
      nav:true,
      autoplay:2000,
      navText: ["<img src='img/left_icon.png' class='owl-prev' >","<img src='img/right_icon.png' class='owl-next' >"],
  });
});


$(document).ready(function(){
$('.small-slider').slick({
  speed: 100,
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    centerPadding:0,
    prevArrow:"<img class='a-left control-c prev slick-prev' src='img/left-arrow-black.png'>",
    nextArrow:"<img class='a-right control-c next slick-next' src='img/right-arrow-black.png'>",
    responsive: [
    {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
        }
      },
    ],
  });
  $('.small-slider1').slick({
    speed: 100,
    arrows: true,
    centerPadding:0,
    prevArrow:"<img class='a-left control-c prev slick-prev' src='img/left-arrow-black.png'>",
    nextArrow:"<img class='a-right control-c next slick-next' src='img/right-arrow-black.png'>",
  });

  $('.small-slider2').slick({
    speed: 100,
    arrows: true,
    centerPadding:0,
    prevArrow:"<img class='a-left control-c prev slick-prev' src='img/left-arrow-black.png'>",
    nextArrow:"<img class='a-right control-c next slick-next' src='img/right-arrow-black.png'>",
  });
});

$(document).ready(function(){
  $('.logo-slider').slick({
    speed: 100,
    slidesToShow: 8,
    slidesToScroll: 1,
    arrows: true,
    centerPadding:0,
    prevArrow:"<img class='a-left control-c prev slick-prev' src='img/left-arrow-black.png'>",
    nextArrow:"<img class='a-right control-c next slick-next' src='img/right-arrow-black.png'>",
    responsive: [
    {
        breakpoint:321,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
          centerMode:true,
        }
      },
    {
        breakpoint:540,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
          centerMode:true,
        }
      },
    {
        breakpoint:640,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
        }
      },
       {
        breakpoint:768,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
          infinite: true,
        }
      },
      {
        breakpoint: 990,
        settings: {
          slidesToShow:6,
          slidesToScroll: 1,
          infinite: true,
        }
      },
      {
        breakpoint: 1100,
        settings: {
          slidesToShow: 7,
          slidesToScroll: 1,
          infinite: true,
        }
      },
    ],
  });
});