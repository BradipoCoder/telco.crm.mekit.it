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

                    {*--- NAME ---*}
                    <div class="row edit-view-row">
                        <div class="col-xs-12 col-sm-12 edit-view-row-item">
                            <div class="col-xs-12 col-sm-2 label" data-label="LBL_SUBJECT">
                                {$MOD_CASES.LBL_SUBJECT}<span class="required">*</span>
                            </div>
                            <div class="col-xs-12 col-sm-10 edit-view-field">
                                {
                                render_module_field
                                module=$module_cases
                                fields=$fields_cases
                                field_name="name"
                                form_name=$form_name
                                tab_index=1
                                }
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

                    {*--- STATE ---*}
                    <div class="row edit-view-row">
                        <div class="col-xs-12 col-sm-12 edit-view-row-item">
                            <div class="col-xs-12 col-sm-2 label" data-label="LBL_STATE">
                                {$MOD_CASES.LBL_STATE}<span class="required">*</span>
                            </div>
                            <div class="col-xs-12 col-sm-10 edit-view-field">
                                {
                                render_module_field
                                module=$module_cases
                                fields=$fields_cases
                                field_name="state"
                                form_name=$form_name
                                tab_index=100
                                }
                            </div>
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
