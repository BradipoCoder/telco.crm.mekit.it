/* TOP NAVIGATION BAR UTILITIES */
(function ($) {
  $(document).ready(function () {

    if (document.getElementById('subModuleList')) {
      var parentMenu = false;
      var moduleListDom = document.getElementById('moduleList');

      if (moduleListDom) {
        var parentTabLis = moduleListDom.getElementsByTagName("li");
        var tabNum = 0;
        for (var ii = 0; ii < parentTabLis.length; ii++) {
          var spans = parentTabLis[ii].getElementsByTagName("span");
          for (var jj = 0; jj < spans.length; jj++) {
            if (spans[jj].className.match(/currentTab.*/)) {
              tabNum = ii;
            }
          }
        }
        parentMenu = parentTabLis[tabNum];
      }
      var moduleGroups = document.getElementById('subModuleList').getElementsByTagName("span");
      for (var i = 0; i < moduleGroups.length; i++) {
        if (moduleGroups[i].className.match(/selected/)) {
          tabNum = i;
        }
      }
      var menuHandle = moduleGroups[tabNum];
      if (menuHandle && parentMenu) {
        updateSubmenuPosition(menuHandle, parentMenu);
      }
    }
  });



  var updateSubmenuPosition = function(menuHandle, parentMenu) {
    var left = 0;
    var p = parentMenu;
    while (p && p.tagName.toUpperCase() != 'BODY') {
      left += p.offsetLeft;
      p = p.offsetParent;
    }

    var bw = checkBrowserWidth();
    if (!parentMenu) {
      return;
    }
    var groupTabLeft = left + (parentMenu.offsetWidth / 2);
    var subTabHalfLength = 0;
    var children = menuHandle.getElementsByTagName('li');
    for (var i = 0; i < children.length; i++) {
      if (children[i].className == 'subTabMore' || children[i].parentNode.className == 'cssmenu') {
        continue;
      }
      subTabHalfLength += parseInt(children[i].offsetWidth);
    }
    if (subTabHalfLength != 0) {
      subTabHalfLength = subTabHalfLength / 2;
    }
    var totalLengthInTheory = subTabHalfLength + groupTabLeft;
    if (subTabHalfLength > 0 && groupTabLeft > 0) {
      if (subTabHalfLength >= groupTabLeft) {
        left = 1;
      } else {
        left = groupTabLeft - subTabHalfLength;
      }
    }
    if (totalLengthInTheory > bw) {
      var differ = totalLengthInTheory - bw;
      left = groupTabLeft - subTabHalfLength - differ - 2;
    }
    if (left >= 0) {
      menuHandle.style.marginLeft = left + 'px';
    }
  }


})(jQuery);