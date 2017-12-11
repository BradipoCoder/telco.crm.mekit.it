<!DOCTYPE html>
<html {$langHeader}>
<head>
    <link rel="SHORTCUT ICON" href="{$FAVICON_URL}">
    <meta http-equiv="Content-Type" content="text/html; charset={$APP.LBL_CHARSET}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1"/>

    <title>{$APP.LBL_BROWSER_TITLE}</title>

    <!--SUGAR JS BEGIN-->
    {$SUGAR_JS}
    <!--SUGAR JS END -->


    {literal}
    <script type="text/javascript">
      <!--
      SUGAR.themes.theme_name = '{/literal}{$THEME}{literal}';
      SUGAR.themes.theme_ie6compat = '{/literal}{$THEME_IE6COMPAT}{literal}';
      SUGAR.themes.hide_image = '{/literal}{sugar_getimagepath file="hide.gif"}{literal}';
      SUGAR.themes.show_image = '{/literal}{sugar_getimagepath file="show.gif"}{literal}';
      SUGAR.themes.loading_image = '{/literal}{sugar_getimagepath file="img_loading.gif"}{literal}';
      SUGAR.themes.allThemes = eval({/literal}{$allThemes}{literal});
      if (YAHOO.env.ua)
        UA = YAHOO.env.ua;
      -->
    </script>
    {/literal}


    <!--SUGAR CSS BEGIN-->
    {$SUGAR_CSS}
    <!--SUGAR CSS END-->

    <link rel="stylesheet" type="text/css" href="themes/{$THEME}/css/colourSelector.php">
    <script type="text/javascript" src='{sugar_getjspath file="themes/$THEME/js/jscolor.js"}'></script>
    <script type="text/javascript" src='{sugar_getjspath file="cache/include/javascript/sugar_field_grp.js"}'></script>
</head>


