$(document).ready(function() {

  toggleHeaderBoxShadow();

  $(document).scroll(function() {
    toggleHeaderBoxShadow();
    $(".dropdown").fadeOut(80);
  });

  $(".toggle-menu").click(function() {
    $(".modal").fadeIn(50);
    $(".menu").css("left", "0px");
  });

  $(".hideable").click(function() {
    var id = this.id;
    var blockId = id.replace("-header", "-block");
    var imgId = id.replace("-header", "-img");
    if($("#"+blockId).css("max-height") == "0px"){
         $("#"+blockId).css("max-height", "400px");
         $("#"+imgId).css("transform", "none");
    } else {
         $("#"+blockId).css("max-height", "0px");
         $("#"+imgId).css("transform", "rotate(-90deg)");
    }
  });

  $(".cancel").click(function() {
    $(".modal").fadeOut(50);
    $(".dialog").fadeOut(10);
  });

  $(".modal").click(function() {
    $(".menu").css("left", "-256px");
    $(".modal").fadeOut(50);
    $(".dialog").fadeOut(10);
  });

  $('.menu').click(function(event) {
    event.stopPropagation();
  });

  $("body").click(function() {
    $('.dropdown').fadeOut(20);
  })

  $('.dropdown').click(function(event) {
    event.stopPropagation();
  });
});

function toggleHeaderBoxShadow() {
  if (document.documentElement.scrollTop > 5) {
    $("#header").css("box-shadow", "0 5px 6px -3px rgba(0, 0, 0, 0.4)");
  } else {
    $("#header").css("box-shadow", "none");
  }
}
