{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     5.3.0
*}

<div class="row">
    {if (isset($payInfo.mail) && $payInfo.mail != '') || (isset($payInfo._customer) && $payInfo._customer != '')}
        <div class="col-md-4">
            <div class="row">
                <label class="control-label col-lg-4"><b>{l s='Card Holder' mod='nexixpay'}</b></label>
                <div class="col-lg-8">
                    <p class="form-control-static"></p>
                </div>
            </div>
            {if isset($payInfo._customer) && $payInfo._customer != ''}
                <div class="row">
                    <label class="control-label col-lg-4">{l s='Name' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo._customer|escape:'htmlall':'UTF-8'}</p>
                    </div>
                </div>
            {/if}
            {if isset($payInfo.mail) && $payInfo.mail != ''}
                <div class="row">
                    <label class="control-label col-lg-4">Mail</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo.mail|escape:'htmlall':'UTF-8'}</p>
                    </div>
                </div>
            {/if}
        </div>
    {/if}

    {if (isset($payInfo.brand) && $payInfo.brand != '') || (isset($payInfo.nazionalita) && $payInfo.nazionalita != '') || (isset($payInfo.pan) && $payInfo.pan != '') || (isset($payInfo._exp) && $payInfo._exp != '')}
        <div class="col-md-4">
            <div class="row">
                <label class="control-label col-lg-4"><b>{l s='Card Detail' mod='nexixpay'}</b></label>
                <div class="col-lg-8">
                    <p class="form-control-static"></p>
                </div>
            </div>

            <div class="row">
                {if isset($payInfo.brand) && $payInfo.brand != ''}
                    <label class="control-label col-lg-4">{l s='Card brand' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo.brand|escape:'htmlall':'UTF-8'}</p>
                    </div>
                {/if}
                {if isset($payInfo.nazionalita) && $payInfo.nazionalita != ''}
                    <label class="control-label col-lg-4">{l s='Nationality' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo.nazionalita|escape:'htmlall':'UTF-8'}&nbsp;</p>
                    </div>
                {/if}
                {if isset($payInfo.pan) && $payInfo.pan != ''}
                    <label class="control-label col-lg-4">{l s='Card pan' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo.pan|escape:'htmlall':'UTF-8'}&nbsp;</p>
                    </div>
                {/if}
                {if isset($payInfo._exp) && $payInfo._exp != ''}
                    <label class="control-label col-lg-4">{l s='Expire date' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo._exp|escape:'htmlall':'UTF-8'}&nbsp;</p>
                    </div>
                {/if}
            </div>
        </div>
    {/if}

    {if (isset($payInfo._date) && $payInfo._date != '') || (isset($payInfo._amount) && $payInfo._amount != '') || (isset($payInfo.codTrans) && $payInfo.codTrans != '') || (isset($payInfo.esito) && $payInfo.esito != '') || (isset($payInfo.messaggio) && $payInfo.messaggio != '') || (isset($payInfo.num_contratto) && $payInfo.num_contratto != '') || (isset($aInfoBO['report'][0]['stato']) && $aInfoBO['report'][0]['stato'] != '')}
        <div class="col-md-4">
            <div class="row">
                <label class="control-label col-lg-4"><b>{l s='Transaction Detail' mod='nexixpay'}</b></label>
                <div class="col-lg-8">
                    <p class="form-control-static"></p>
                </div>
            </div>
            <div class="row">
                {if isset($payInfo._date) && $payInfo._date != ''}
                    <label class="control-label col-lg-4">{l s='Date' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo._date|escape:'htmlall':'UTF-8'}&nbsp;</p>
                    </div>
                {/if}
                {if isset($payInfo._amount) && $payInfo._amount != ''}
                    <label class="control-label col-lg-4">{l s='Amount' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo._amount|escape:'htmlall':'UTF-8'} €&nbsp;</p>
                    </div>
                {/if}
                {if isset($payInfo.codTrans) && $payInfo.codTrans != ''}
                    <label class="control-label col-lg-4">{l s='Transaction code' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo.codTrans|escape:'htmlall':'UTF-8'}&nbsp;</p>
                    </div>
                {/if}
                {if isset($payInfo.esito) && $payInfo.esito != ''}
                    <label class="control-label col-lg-4">{l s='Result' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo.esito|escape:'htmlall':'UTF-8'}&nbsp;</p>
                    </div>
                {/if}
                {if isset($payInfo.messaggio) && $payInfo.messaggio != ''}
                    <label class="control-label col-lg-4">{l s='Message' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo.messaggio|escape:'htmlall':'UTF-8'}&nbsp;</p>
                    </div>
                {/if}
                {if isset($payInfo.num_contratto) && $payInfo.num_contratto != ''}
                    <label class="control-label col-lg-4">{l s='# contract' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$payInfo.num_contratto|escape:'htmlall':'UTF-8'}&nbsp;</p>
                    </div>
                {/if}
                {if isset($aInfoBO['report'][0]['stato']) && $aInfoBO['report'][0]['stato'] != ''}
                    <label class="control-label col-lg-4">{l s='Status' mod='nexixpay'}</label>
                    <div class="col-lg-8">
                        <p class="form-control-static">{$aInfoBO['report'][0]['stato']|escape:'htmlall':'UTF-8'}&nbsp;</p>
                    </div>
                {/if}
            </div>
        </div>
    {/if}
</div>

<br>

<div class="row">
    <div class="col-lg-7">
        {if (is_array($aInfoBO['report'][0]['dettaglio'][0]['operazioni']) && count($aInfoBO['report'][0]['dettaglio'][0]['operazioni']) > 0)}
            <div class="panel">
                <b>{l s='Accounting Operations' mod='nexixpay'}</b>
                <div class="table-responsive">
                    <table class="table" id="shipping_table">
                        <thead>
                            <tr>
                                <th>
                                    <span class="title_box ">{l s='Operation' mod='nexixpay'}</span>
                                </th>
                                <th>
                                    <span class="title_box ">{l s='Amount' mod='nexixpay'}</span>
                                </th>
                                <th>
                                    <span class="title_box ">{l s='Currency' mod='nexixpay'}</span>
                                </th>
                                <th>
                                    <span class="title_box ">{l s='Status' mod='nexixpay'}</span>
                                </th>
                                <th>
                                    <span class="title_box ">{l s='Date' mod='nexixpay'}</span>
                                </th>
                                <th>
                                    <span class="title_box ">{l s='User' mod='nexixpay'}</span>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$aInfoBO['report'][0]['dettaglio'][0]['operazioni'] item=operazione}
                                <tr>
                                    <td>{$operazione['tipoOperazione']|escape:'htmlall':'UTF-8'}</td>
                                    <td>{$operazione['importoFormatted']|escape:'htmlall':'UTF-8'}</td>
                                    <td>{$operazione['divisa']|escape:'htmlall':'UTF-8'}</td>
                                    <td>{$operazione['stato']|escape:'htmlall':'UTF-8'}</td>
                                    <td>{$operazione['dataOperazione']|date_format:"%d/%m/%Y %H:%M:%S"|escape:'htmlall':'UTF-8'}
                                    </td>
                                    <td>{$operazione['utente']|escape:'htmlall':'UTF-8'}</td>
                                    <td></td>
                                </tr>
                            {/foreach}

                        </tbody>
                    </table>
                </div>
            </div>
        {/if}
    </div>

    {if $accountingOp}
        <div class="col-lg-5">
            <div class="panel">

                <b>{l s='New Accounting Operation' mod='nexixpay'}</b>
                <div class="table-responsive">
                    <table class="table" id="shipping_table">
                        <thead>
                            <tr>
                                <th>
                                    {if NOT isset($cancelTransaction) OR NOT $cancelTransaction}
                                        <span class="title_box ">{l s='Amount' mod='nexixpay'}</span>
                                    {/if}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="operation-container">
                                        {if isset($cancelTransaction) AND $cancelTransaction}
                                            <input type="hidden" id="nexi_aop_amount" class="form-control"
                                                value="{$aInfoBO['report'][0]['fullImporto']}" type="text">
                                        {else}
                                            <div class="input-container">
                                                <div class="input-group">
                                                    <input id="nexi_aop_amount" class="form-control" value="" type="text">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            {$currencySign}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {/if}
                                        <div class="button-container">
                                            <div class="accounting-button-container">
                                                {if isset($account) AND $account}
                                                    <button type="button" class="btn btn-default nexi_aop" action="accounting"
                                                        id="xpay_contabilizza" style="">
                                                        <i class="icon-ok"></i>
                                                        {l s='Account' mod='nexixpay'}
                                                    </button>
                                                {/if}
                                            </div>
                                            <div class="refund-button-container">
                                                {if isset($cancelTransaction) AND $cancelTransaction}
                                                    <button type="button" class="btn btn-default nexi_aop" action="refunding"
                                                        data-action-q="{l s='cancel the transaction?' mod='nexixpay'}">
                                                        <i class="icon-remove"></i>
                                                        {l s='Cancel' mod='nexixpay'}
                                                    </button>
                                                {elseif isset($cancel) AND $cancel}
                                                    <button type="button" class="btn btn-default nexi_aop" action="refunding"
                                                        id="xpay_storna" style="">
                                                        <i class="icon-remove"></i>
                                                        {l s='Refund' mod='nexixpay'}
                                                    </button>
                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <p>{$accounting_op_text|escape:'htmlall':'UTF-8'}</p>
            </div>
        </div>
    {/if}
</div>