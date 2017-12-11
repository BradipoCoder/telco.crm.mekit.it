/*
(function ($) {
  $(document).ready(function () {
    loadSidebar();
  });
})(jQuery);

// jQuery to toggle sidebar
function loadSidebar() {
  if ($('#sidebar_container').length) {
    $('#buttontoggle').click(function () {
      $('.sidebar').toggle();
      if ($('.sidebar').is(':visible')) {
        $.cookie('sidebartoggle', 'expanded');
        $('#buttontoggle').removeClass('button-toggle-collapsed');
        $('#buttontoggle').addClass('button-toggle-expanded');
        $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2');
        $('footer').removeClass('collapsedSidebar');
        $('footer').addClass('expandedSidebar');
        $('#bootstrap-container').removeClass('collapsedSidebar');
        $('#bootstrap-container').addClass('expandedSidebar');
      }
      if ($('.sidebar').is(':hidden')) {
        $.cookie('sidebartoggle', 'collapsed');
        $('#buttontoggle').removeClass('button-toggle-expanded');
        $('#buttontoggle').addClass('button-toggle-collapsed');
        $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 col-sm-3 col-md-2 sidebar');
        $('footer').removeClass('expandedSidebar');
        $('footer').addClass('collapsedSidebar');
        $('#bootstrap-container').removeClass('expandedSidebar');
        $('#bootstrap-container').addClass('collapsedSidebar');
      }
    });

    var sidebartoggle = $.cookie('sidebartoggle');
    if (sidebartoggle == 'collapsed') {
      $('.sidebar').hide();
      $('#buttontoggle').removeClass('button-toggle-expanded');
      $('#buttontoggle').addClass('button-toggle-collapsed');
      $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 col-sm-3 col-md-2 sidebar');
      $('footer').removeClass('expandedSidebar');
      $('footer').addClass('collapsedSidebar');
      $('#bootstrap-container').removeClass('expandedSidebar');
      $('#bootstrap-container').addClass('collapsedSidebar');
    }
    else {
      $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2');
      $('#buttontoggle').removeClass('button-toggle-collapsed');
      $('#buttontoggle').addClass('button-toggle-expanded');
      $('footer').removeClass('collapsedSidebar');
      $('footer').addClass('expandedSidebar');
      $('#bootstrap-container').removeClass('collapsedSidebar');
      $('#bootstrap-container').addClass('expandedSidebar');
    }
  }
}
*/
