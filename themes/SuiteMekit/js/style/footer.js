;(function ($) {
  $(document).ready(function () {

    // Toggle copyright popup
    $("button").click(function () {
      $("#sugarcopy").toggle();

    });

    /*
    console.log("BTT2!");
    // Back to top animation
    $('#backtotop').click(function (event) {
      event.preventDefault();
      console.log("BTT-CLICK!");
      $('html, body').animate({scrollTop: 0}, 500); // Scroll speed to the top
    });
    */

    // Fix for footer position
    if ($('#bootstrap-container footer').length > 0) {
      var clazz = $('#bootstrap-container footer').attr('class');
      $('body').append('<footer class="' + clazz + '">' + $('#bootstrap-container footer').html() + '</footer>');
      $('#bootstrap-container footer').remove();
      initFooterPopups();
    }

    initFooterPopups();

  });


  var initFooterPopups = function () {
    $("#dialog, #dialog2").dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 100
      },
      hide: {
        effect: "fade",
        duration: 1000
      }
    });
    $("#powered_by").click(function () {
      $("#dialog").dialog("open");
      $("#overlay").show().css({"opacity": "0.5"});
    });
    $("#admin_options").click(function () {
      $("#dialog2").dialog("open");
    });
  };
})(jQuery);