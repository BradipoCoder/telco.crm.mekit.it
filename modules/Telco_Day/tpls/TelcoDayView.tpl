
<div id="telco_day">
    <h1>TELCO DAY - {$user_full_name}</h1>

    {if $meetings|@count}
        <a class="button" href="/index.php?module=Telco_Day&action=printView">STAMPA</a>
    {/if}

    {if $meetings|@count}
        <table class="view table-responsive table-bordered">
            <thead>
            <tr>
                <th colspan="2">
                    <h2 style="text-align: center">
                        {$current_period_start|date_format:'%A, %e %B %Y'}
                    </h2>
                </th>
            </tr>
            </thead>
            {foreach from=$meetings item=meeting}
                <tr>
                    <td style="vertical-align: top; width: 75%;">
                        <table class="view table-responsive table-bordered">
                            <thead>
                            <tr>
                                <th colspan="2">
                                    <h4 style="text-align: center">
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
                        <table class="view table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        MATERIALI
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
        </table>
        <hr/>
        <pre>
            {$meetings|@print_r:true}
        </pre>
    {else}
        <h3>Non ci sono appuntamenti per questo periodo().</h3>
    {/if}



</div>
