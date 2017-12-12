/*
  Functions called directly from tpl
 */

var refreshListViewCheckbox = function (e) {
  $(e).removeClass('glyphicon-check');
  $(e).removeClass('glyphicon-unchecked');
  if ($(e).next().prop('checked')) {
    $(e).addClass('glyphicon-check');
  }
  else {
    $(e).addClass('glyphicon-unchecked');
  }
  $(e).removeClass('disabled')
  if ($(e).next().prop('disabled')) {
    $(e).addClass('disabled')
  }
};

var selectTab = function(tab) {
  $('#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER').hide();
  $('#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER').eq(tab).show().addClass('active').addClass('in');
};

var changeFirstTab = function(src) {
  var selected = $(src).attr('id');
  var selectedHtml = $(selected.context).html();
  $('#xstab0').html(selectedHtml);

  var i = $(src).parents('li').index();
  selectTab(parseInt(i));
  return true;
};

// fix for tab navigation on user profile for SuiteP theme
var getParameterByName = function (name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
};

var isUserProfilePage = function () {
  var module = getParameterByName('module');
  if (!module) {
    module = $('#EditView_tabs').closest('form#EditView').find('input[name="module"]').val();
  }
  if (!module) {
    if (typeof module_sugar_grp1 !== "undefined") {
      module = module_sugar_grp1;
    }
  }
  return module == 'Users';
};

var isEditViewPage = function () {
  var action = getParameterByName('action');
  if (!action) {
    action = $('#EditView_tabs').closest('form#EditView').find('input[name="page"]').val();
  }
  return action == 'EditView';
};

var isDetailViewPage = function () {
  var action = getParameterByName('action');
  if (!action) {
    action = action_sugar_grp1;
  }
  return action == 'DetailView';
};

// jQuery to toggle sidebar
var loadSidebar = function() {
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
};
