<html>
<head>
    <title>{$tplData.title}</title>
    {if $tplData.css|@count}
        {foreach from=$tplData.css item=cssPath}
            <link rel="stylesheet" type="text/css" href="{$cssPath}"/>
        {/foreach}
    {/if}
</head>
<body>
    {$tplData.page_content}
</body>
</html>