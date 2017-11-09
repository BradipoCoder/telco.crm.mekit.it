{if $tplData.css|@count}
    {foreach from=$tplData.css item=cssPath}
        <link rel="stylesheet" type="text/css" href="{$cssPath}"/>
    {/foreach}
{/if}

<div id="telco_day">
    <h1 class="title">
        {$tplData.title}
    </h1>
    <h2 class="title">
        {$tplData.periods.period_start_format_fancy} - {$tplData.periods.period_end_format_fancy}
    </h2>

    {if $tplData.config.purpose == "view"}
        <div class="configForm">
            <form id="configForm" method="post">

                <table class="configuration" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <input name="cfg_debug" type="checkbox" value="1" {if $tplData.config.debug}checked="checked"{/if} title="cfg_debug" />
                            <label for="cfg_debug">Debug</label>
                        </td>
                        <td>
                            <input name="cfg_print_show_html" type="checkbox" value="1" {if $tplData.config.print_show_html}checked="checked"{/if} title="cfg_print_show_html" />
                            <label for="cfg_print_show_html">Show print html</label>
                        </td>
                        <td>
                            <input name="cfg_print_force_download" type="checkbox" value="1" {if $tplData.config.print_force_download}checked="checked"{/if} title="cfg_print_force_download" />
                            <label for="cfg_print_force_download">Force pdf download</label>
                        </td>
                    </tr>
                </table>

                <table class="parameters" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <label for="date_start">Giorno</label>
                            <input type="date" id="date_start" name="date_start" value="{$tplData.periods.period_start_format_iso}" />
                        </td>
                        <td>
                            {*<label for="date_end">Fine periodo</label>*}
                            {*<input type="date" id="date_end" name="date_end" value="{$tplData.periods.period_end_format_iso}" />*}
                        </td>
                        <td>
                            <input type="submit" name="update" value="Aggiorna" />
                        </td>
                        <td>
                            <input type="submit" name="pdf" value="Pdf" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    {/if}

    {if $tplData.meetings|@count}
        <table class="view table-responsive" cellpadding="0" cellspacing="0">
            <tbody>
                {foreach from=$tplData.meetings item=meeting}
                    <tr>
                        <td style="vertical-align: top; width: 75%;">
                            <table class="view table-responsive table-bordered table-vspaced" cellpadding="0" cellspacing="0">
                                <thead>
                                <tr>
                                    <th colspan="2">
                                        <h4 class="title">
                                            {$meeting.name}
                                        </h4>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width:20%;"><span class="label">Orario:</span></td>
                                        <td>{$meeting.date_start|date_format:'%k:%M'}</td>
                                    </tr>
                                    <tr>
                                        <td><span class="label">Durata prevista:</span></td>
                                        <td>{$meeting.duration_hours}:{$meeting.duration_minutes}</td>
                                    </tr>
                                    <tr>
                                        <td><span class="label">Riferimento RAS:</span></td>
                                        <td>{$meeting.case.case_number} - {$meeting.case.name}</td>
                                    </tr>
                                    <tr>
                                        <td><span class="label">Azienda</span></td>
                                        <td>{$meeting.accounts.name}</td>
                                    </tr>
                                    <tr>
                                        <td><span class="label">Indirizzo / Luogo</span></td>
                                        <td>
                                            {$meeting.accounts.billing_address_street}<br />
                                            {$meeting.accounts.billing_address_postalcode} - {$meeting.accounts.billing_address_city}<br />
                                            {$meeting.location}<br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="label">Contatti</span></td>
                                        <td>
                                            {$meeting.accounts.phone_office}<br />
                                            {$meeting.accounts.phone_alternate}<br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="label">Note:</span></td>
                                        <td>{$meeting.description}</td>
                                    </tr>
                                </tbody>

                            </table>
                        </td>
                        <td style="vertical-align: top;">
                            <table class="view table-responsive table-bordered" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>
                                            <h4 class="title">
                                                Materiali
                                            </h4>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        ...
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>

    {else}
        <h3>Nessun appuntamento per il periodo indicato.</h3>
    {/if}

    {if $tplData.config.debug == 1}
        <hr/>
        <pre>
            {$tplData|@print_r:true}
        </pre>
    {/if}
</div>
