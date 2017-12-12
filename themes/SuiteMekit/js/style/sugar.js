/* BASIC SUGAR STUFF*/
(function ($, SUGAR) {
  SUGAR.measurements = {
    "breakpoints": {
      "x-small": 750,
      "small": 768,
      "medium": 992,
      "large": 1130,
      "x-large": 1250
    }
  };

  SUGAR.loaded_once = false;

  SUGAR.themes = SUGAR.namespace("themes");


  $(document).ready(function () {


    SUGAR.append(SUGAR.themes, {
      allMenuBars: {},

      setModuleTabs: function (html) {
        var el = document.getElementById('ajaxHeader');
        if (el) {
          loadSidebar();
          $('#ajaxHeader').html(html);
          if ($(window).width() < 979) {
            $('#bootstrap-container').removeClass('main');
          }
        }
      },

      actionMenu: function () {
        $("ul.clickMenu").each(function (index, node) {
          $(node).sugarActionMenu();
        });
      },

      loadModuleList: function () {
        var nodes = YAHOO.util.Selector.query('#moduleList>div'), currMenuBar;
        this.allMenuBars = {};
        for (var i = 0; i < nodes.length; i++) {
          currMenuBar = SUGAR.themes.currMenuBar = new YAHOO.widget.MenuBar(nodes[i].id, {
            autosubmenudisplay: true,
            visible: false,
            hidedelay: 750,
            lazyload: true
          });
          currMenuBar.render();
          this.allMenuBars[nodes[i].id.substr(nodes[i].id.indexOf('_') + 1)] = currMenuBar;
        }
      },

      setCurrentTab: function () {
      }
    });

    SUGAR.themes.loadModuleList();





    //list view selection checkboxes
    $("ul.clickMenu").each(function (index, node) {
      $(node).sugarActionMenu();
    });

    // Back to top animation (NO ID on element)
    $('#backtotop').click(function (event) {
      event.preventDefault();
      $('html, body').animate({scrollTop: 0}, 500); // Scroll speed to the top
    });

    // Tabs
    var tabs = $("#tabs").tabs();
    tabs.find(".ui-tabs-nav").sortable({
      axis: "x",
      stop: function () {
        tabs.tabs("refresh");
      }
    });

    // JavaScript fix to remove unrequired classes on smaller screens where sidebar is obsolete
    $(window).resize(function () {
      if ($(window).width() < 979) {
        $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 sidebar main');
      }
      if ($(window).width() > 980 && $('.sidebar').is(':visible')) {
        $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main');
      }
    });

    // Alerts Notification
    $(document).ready(function () {
      $('#alert-nav').click(function () {
        $('#alert-nav #alerts').css('display', 'inherit');
      });
    });






    // -----------------------------------------------------------------------------------------------------------UNUSED
    /*
    var listViewCheckboxInit = function () {
      var checkboxesInitialized = false;
      var checkboxesInitializeInterval = false;
      var checkboxesCountdown = 100;
      var initializeBootstrapCheckboxes = function () {
        if (!checkboxesInitialized) {
          if ($('.glyphicon.bootstrap-checkbox').length == 0) {
            if (!checkboxesInitializeInterval) {
              checkboxesInitializeInterval = setInterval(function () {
                checkboxesCountdown--;
                if (checkboxesCountdown <= 0) {
                  clearInterval(checkboxesInitializeInterval);
                  return;
                }
                initializeBootstrapCheckboxes();
              }, 100);
            }
          } else {
            $('.glyphicon.bootstrap-checkbox').each(function (i, e) {
              $(e).removeClass('hidden');
              $(e).next().hide();
              refreshListViewCheckbox(e);
              if (!$(e).hasClass('initialized-checkbox')) {
                $(e).click(function () {
                  $(this).next().click();
                  refreshListViewCheckbox($(this));
                });
                $(e).addClass('initialized-checkbox');
              }
            });

            $('#selectLink > li > ul > li > a, #selectLinkTop > li > ul > li > a, #selectLinkBottom > li > ul > li > a').click(function (e) {
              e.preventDefault();
              $('.glyphicon.bootstrap-checkbox').each(function (i, e) {
                refreshListViewCheckbox(e);
              });
            });

            checkboxesInitialized = true;
            clearInterval(checkboxesInitializeInterval);
            checkboxesInitializeInterval = false;
          }
        }
      };
      initializeBootstrapCheckboxes();
    };

    //listViewCheckboxInit();
    // setInterval(function () {
    //   listViewCheckboxInit();
    // }, 100);
    */

    /*
    setInterval(function () {
      $('#alerts').css({left: 16 - $('#alerts').width() + 'px'});
    }, 100);
    */

    /*
    function IKEADEBUG() {
      //removed body - look for it in SuiteP
    }
    */

    /*
    YAHOO.util.Event.onAvailable('sitemapLinkSpan', function () {
      document.getElementById('sitemapLinkSpan').onclick = function () {
        ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING_PAGE'));
        var callback = {
          success: function (r) {
            ajaxStatus.hideStatus();
            document.getElementById('sm_holder').innerHTML = r.responseText;
            with (document.getElementById('sitemap').style) {
              display = "block";
              position = "absolute";
              right = 0;
              top = 80;
            }
            document.getElementById('sitemapClose').onclick = function () {
              document.getElementById('sitemap').style.display = "none";
            }
          }
        };
        var postData = 'module=Home&action=sitemap&GetSiteMap=now&sugar_body_only=true';
        YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback, postData);
      }
    });
    */
  });


})(jQuery, SUGAR);
