(function($) {
  var $radio_account;

  /**
   * show/hide groups of fields based on radio selection in form
   */
  var accountCreationRadioChange = function()
  {
    var radioValue = $radio_account.filter(':checked').val();//$radio_account.val();
    console.log("VAL: " + radioValue);

    var $selectionDiv = $(".radio-selection-account");
    var $selectionGroups = $(".selection-group", $selectionDiv);
    $(".data-group", $selectionGroups).hide();
    var $selectedGroup = $selectionGroups.filter('.selection-group--' + radioValue);
    $(".data-group", $selectedGroup).show();
  };


  $(document).ready(function()
  {
    //console.log("Ras.js ready.");
    $radio_account = $("input[type=radio][name=account_creation_radios]");

    //accountCreationRadioChange();
    $radio_account.change(accountCreationRadioChange);
    $radio_account.trigger("change");

  });
})(jQuery);