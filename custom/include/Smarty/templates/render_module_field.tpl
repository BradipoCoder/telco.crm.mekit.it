{*
* RENDER MODULE FIELD
* --------------------
*}
{capture name="capture-sugar-field" assign="field_markup"}
    {sugar_field
        parentFieldArray=$parent_field_array
        vardef=$vardef
        displayType=$display_type
        displayParams=$display_params
        formName=$form_name
        module=$module
        accesskey=$access_key
        tabindex=$tab_index
        typeOverride=$type_override
    }
{/capture}

<!-- RENDER MODULE FIELD({$field_name}) START -->
{eval var=$field_markup}
<!-- RENDER MODULE FIELD({$field_name}) END -->

<pre>
    {*---------------------------*}
    {*--- RENDER MODULE FIELD ---*}
    {*---------------------------*}
    {*module: {$module}*}
    {*form_name: {$form_name}*}
    field_name: {$field_name}
    vardef: {$vardef|@json_encode}
    {*display_params: {$display_params|@json_encode}*}
</pre>

