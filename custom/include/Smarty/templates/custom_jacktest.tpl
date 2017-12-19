<b>JACK TEST</b>


{sugar_field parentFieldArray='fields' vardef=$fields[$field_name] displayType=$display_type displayParams=$display_params formName=$form_name module=$module}





<pre>
    module: {$module}
    display_type: {$display_type}
    form_name: {$form_name}
    field[{$field_name}]: {$fields[$field_name]|@var_dump}
</pre>
