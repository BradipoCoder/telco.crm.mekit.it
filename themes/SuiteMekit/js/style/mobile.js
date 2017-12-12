/* MOBILE RELATED UTILITIES*/
(function ($) {
  $(document).ready(function () {

    var hideEmptyFormCellsOnTablet = function () {
      if ($(window).width() <= 767) {
        $('div#content div#pagecontent form#EditView div.edit.view table tbody tr td').each(function (i, e) {
          $(e).find('slot').each(function (i, e) {
            if ($(e).html().trim() == '&nbsp;') {
              $(e).html('&nbsp;');
            }
          });
          if ($(e).html().trim() == '<span>&nbsp;</span>') {
            $(e).addClass('hidden');
            $(e).addClass('hiddenOnTablet');
          }
        });
      }
      else {
        $('div#content div#pagecontent form#EditView div.edit.view table tbody tr td.hidden.hiddenOnTablet').each(function (i, e) {
          $(e).removeClass('hidden');
          $(e).removeClass('hiddenOnTablet');
        });
      }
    };

    $(window).click(function () {
      hideEmptyFormCellsOnTablet();
      setTimeout(function () {
        hideEmptyFormCellsOnTablet();
      }, 500);
    });

    $(window).resize(function () {
      hideEmptyFormCellsOnTablet();
    });

    $(window).load(function () {
      hideEmptyFormCellsOnTablet();
    });

    $(document).ready(function () {
      hideEmptyFormCellsOnTablet();
    });

    setTimeout(function () {
      hideEmptyFormCellsOnTablet();
    }, 1500);
  });
})(jQuery);
