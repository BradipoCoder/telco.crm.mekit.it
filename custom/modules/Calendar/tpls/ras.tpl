{sugar_getscript file="custom/modules/Calendar/js/Ras.js"}

<div id="CompoundEditView">


    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading panel-heading-collapse" role="tab" id="headingOne">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <div class="col-xs-10 col-sm-11 col-md-11">
                            Richiesta di assistenza
                        </div>
                    </a>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="form-custom-was-horizontal-but-now-it-is-not-anymore by-jack">

                        <div class="form-inline">
                            {*--- NAME ---*}
                            <div class="form-group col-sm-6">
                                <label for="name" data-label="LBL_SUBJECT">{$MOD_CASES.LBL_SUBJECT}<span class="required">*</span></label>
                                {render_module_field field_name="cases_name" tab_index=1 module=$module_cases fields=$fields_cases form_name=$form_name}
                            </div>

                            {*--- ASSIGNED USER ---*}
                            <div class="form-group col-sm-6">
                                <label for="assigned_user_name" data-label="LBL_ASSIGNED_TO_NAME">{$MOD_CASES.LBL_ASSIGNED_TO_NAME}</label>
                                {render_module_field field_name="assigned_user_name" tab_index=2 module=$module_cases fields=$fields_cases form_name=$form_name}
                            </div>
                        </div>

                        {*--- DESCRIPTION ---*}
                        <div class="form-group">
                            <label for="description" data-label="LBL_DESCRIPTION" class="col-sm-12">{$MOD_CASES.LBL_DESCRIPTION}</label>
                            <div class="col-sm-12">
                                {render_module_field field_name="description" tab_index=3 module=$module_cases fields=$fields_cases form_name=$form_name}
                            </div>
                        </div>

                        <div class="radio-selection-account">
                            <div class="selection-group selection-group--select">
                                <label>
                                    <input type="radio" name="account_creation_radios" id="account_creation_radio_1" value="select" checked>
                                    Seleziona cliente esistente
                                </label>
                                {*--- ACCOUNT ---*}
                                <div class="data-group">
                                    <div class="form-group">
                                        <label for="account_name" data-label="LBL_ACCOUNT_NAME" class="col-sm-12 sr-only">{$MOD_CASES.LBL_ACCOUNT_NAME}</label>
                                        <div class="col-sm-12">
                                            {render_module_field field_name="account_name" tab_index=4 module=$module_cases fields=$fields_cases form_name=$form_name}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="selection-group selection-group--create">
                                <label>
                                    <input type="radio" name="account_creation_radios" id="account_creation_radio_2" value="create">
                                    Crea nuovo cliente
                                </label>
                                <div class="data-group">

                                    {*--- ACCOUNT NAME ---*}
                                    <div class="form-group">
                                        <label for="accounts_name" data-label="LBL_NAME">{$MOD_ACCOUNTS.LBL_NAME}</label>
                                        <div class="col-sm-12">
                                            {render_module_field field_name="accounts_name" tab_index=10 module=$module_accounts fields=$fields_accounts form_name=$form_name}
                                        </div>
                                    </div>

                                    <div class="form-inline">
                                        {*--- PHONE OFFICE ---*}
                                        <div class="form-group col-sm-6">
                                            <label for="phone_office" data-label="LBL_PHONE_OFFICE">{$MOD_ACCOUNTS.LBL_PHONE_OFFICE}</label>
                                            {render_module_field field_name="phone_office" tab_index=10 module=$module_accounts fields=$fields_accounts form_name=$form_name}
                                        </div>

                                        {*--- PHONE ALTERNATE ---*}
                                        <div class="form-group col-sm-6">
                                            <label for="phone_alternate" data-label="LBL_PHONE_ALT">{$MOD_ACCOUNTS.LBL_PHONE_ALT}</label>
                                            {render_module_field field_name="phone_alternate" tab_index=10 module=$module_accounts fields=$fields_accounts form_name=$form_name}
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <div class="col-xs-10 col-sm-11 col-md-11">
                        Avanzate
                    </div>
                </a>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">

                    <div class="form-inline">
                        {*--- STATE ---*}
                        <div class="form-group col-sm-4">
                            <label for="state" data-label="LBL_STATE">{$MOD_CASES.LBL_STATE}<span class="required">*</span></label>
                            {render_module_field field_name="state" tab_index=101 module=$module_cases fields=$fields_cases form_name=$form_name}
                        </div>

                        {*--- PRIORITY ---*}
                        <div class="form-group col-sm-4">
                            <label for="priority" data-label="LBL_PRIORITY">{$MOD_CASES.LBL_PRIORITY}<span class="required">*</span></label>
                            {render_module_field field_name="priority" tab_index=102 module=$module_cases fields=$fields_cases form_name=$form_name}
                        </div>

                        {*--- TYPE ---*}
                        <div class="form-group col-sm-4">
                            <label for="type" data-label="LBL_TYPE">{$MOD_CASES.LBL_TYPE}<span class="required">*</span></label>
                            {render_module_field field_name="type" tab_index=103 module=$module_cases fields=$fields_cases form_name=$form_name}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {*{$FORM_CUSTOM}*}

    {*{$FORM_CASES}*}

    {*{$FORM_ACCOUNTS}*}

    {*{$FORM_MEETINGS}*}

</div>
