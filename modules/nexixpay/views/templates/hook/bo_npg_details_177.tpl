{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     7.0.0
*}

{$firstOp = false}

{if $orderInfo.operations|count > 0}
    {$firstOp = $orderInfo.operations[0]}
{/if}

<div class="row">
    {if $firstOp}
        {if $firstOp.customerInfo.cardHolderName OR $firstOp.customerInfo.cardHolderEmail}
            <div class="col-md-4">
                <div class="row">
                    <label class="control-label col-lg-12"><b>{l s='Card Holder' mod='nexixpay'}</b></label>
                </div>
                {if $firstOp.customerInfo.cardHolderName}
                    <div class="row">
                        <label class="control-label col-sm-4">{l s='Name' mod='nexixpay'}</label>
                        <div class="col-sm-8">
                            <p class="form-control-static">{$firstOp.customerInfo.cardHolderName}</p>
                        </div>
                    </div>
                {/if}
                {if isset($firstOp.customerInfo.cardHolderEmail) AND $firstOp.customerInfo.cardHolderEmail != ''}
                    <div class="row">
                        <label class="control-label col-sm-4">Mail</label>
                        <div class="col-sm-8">
                            <p class="form-control-static">{$firstOp.customerInfo.cardHolderEmail|escape:'htmlall':'UTF-8'}</p>
                        </div>
                    </div>
                {/if}
            </div>
        {/if}

        {if $firstOp.paymentCircuit OR strlen(trim($firstOp.paymentInstrumentInfo)) > 0}
            <div class="col-md-4">
                <div class="row">
                    <label class="control-label col-lg-12"><b>{l s='Card Detail' mod='nexixpay'}</b></label>
                </div>
                {if $firstOp.paymentCircuit}
                    <div class="row">
                        <label class="control-label col-sm-4">{l s='Card brand' mod='nexixpay'}</label>
                        <div class="col-sm-8">
                            <p class="form-control-static">{$firstOp.paymentCircuit}</p>
                        </div>
                    </div>
                {/if}
                {if isset($firstOp.paymentInstrumentInfo) AND strlen(trim($firstOp.paymentInstrumentInfo)) > 0}
                    <div class="row">
                        <label class="control-label col-sm-4">{l s='Card pan' mod='nexixpay'}</label>
                        <div class="col-sm-8">
                            <p class="form-control-static">{$firstOp.paymentInstrumentInfo|escape:'htmlall':'UTF-8'}&nbsp;
                            </p>
                        </div>
                    </div>
                {/if}
            </div>
        {/if}
    {/if}

    {if $firstOp OR $orderInfo.orderStatus.order}
        <div class="col-md-4">
            <div class="row">
                <label class="control-label col-lg-12"><b>{l s='Transaction Detail' mod='nexixpay'}</b></label>
            </div>
            <div class="row">
                {if $firstOp AND isset($firstOp.operationTime) AND $firstOp.operationTime != ''}
                    <label class="control-label col-sm-4">{l s='Date' mod='nexixpay'}</label>
                    <div class="col-sm-8">
                        <p class="form-control-static">{$firstOp.operationTime|date_format:"%d/%m/%Y %H:%M:%S"}&nbsp;</p>
                    </div>
                {/if}
                {if isset($orderInfo.orderStatus.order.amount) AND $orderInfo.orderStatus.order.amount != ''}
                    <label class="control-label col-sm-4">{l s='Amount' mod='nexixpay'}</label>
                    <div class="col-sm-8">
                        <p class="form-control-static">{$orderInfo.orderStatus.order.amountFormatted|escape:'htmlall':'UTF-8'} {$currencySign}</p>
                    </div>
                {/if}
                {if isset($orderInfo.orderStatus.order.orderId) AND $orderInfo.orderStatus.order.orderId != ''}
                    <label class="control-label col-sm-4">{l s='Order ID' mod='nexixpay'}</label>
                    <div class="col-sm-8">
                        <p class="form-control-static">{$orderInfo.orderStatus.order.orderId|escape:'htmlall':'UTF-8'}&nbsp;</p>
                    </div>
                {/if}
            </div>
        </div>
    {/if}
</div>

<br />

<div class="row">
    <div class="col-lg-7">
        <div class="panel">
            <b>{l s='Accounting Operations' mod='nexixpay'}</b>
            <div class="table-responsive">
                <table class="table" id="shipping_table">
                    <thead>
                        <tr>
                            <th><span class="title_box">{l s='Operation' mod='nexixpay'}</span></th>
                            <th><span class="title_box">{l s='Result' mod='nexixpay'}</span></th>
                            <th><span class="title_box">{l s='Amount' mod='nexixpay'}</span></th>
                            <th><span class="title_box">{l s='Currency' mod='nexixpay'}</span></th>
                            <th><span class="title_box">{l s='Date' mod='nexixpay'}</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $orderInfo.operations as $operazione}
                            <tr>
                                <td>{$operazione.operationType|escape:'htmlall':'UTF-8'}</td>
                                <td>{$operazione.operationResult|escape:'htmlall':'UTF-8'}</td>
                                <td>{$operazione.amountFormatted|escape:'htmlall':'UTF-8'}</td>
                                <td>{$operazione.currencySign|escape:'htmlall':'UTF-8'}</td>
                                <td>{$operazione.operationTime|date_format:"%d/%m/%Y %H:%M:%S"|escape:'htmlall':'UTF-8'}</td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {if $canRefund || $canAccount}
        <div class="col-lg-5">
            <div class="panel">
                <b>{l s='New Accounting Operation' mod='nexixpay'}</b>
                <div class="table-responsive">
                    <table class="table" id="shipping_table">
                        <thead>
                            <tr>
                                <th><span class="title_box">{l s='Amount' mod='nexixpay'}</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="operation-container">
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
                                        <div class="button-container">
                                            {if $canAccount}
                                                <div class="accounting-button-container">
                                                    <button type="button" class="btn btn-primary nexi_aop" action="accounting"
                                                        id="nexi_contabilizza" style="">
                                                        <i class="icon-ok"></i>
                                                        {l s='Account' mod='nexixpay'}
                                                    </button>
                                                </div>
                                            {/if}
                                            {if $canRefund}
                                                <div class="refund-button-container">
                                                    <button type="button" class="btn btn-primary nexi_aop" action="refunding"
                                                        id="nexi_storna" style="">
                                                        <i class="icon-remove"></i>
                                                        {l s='Refund' mod='nexixpay'}
                                                    </button>
                                                </div>
                                            {/if }
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <p>{$accountingOpDesc|escape:'htmlall':'UTF-8'}</p>
            </div>
        </div>
    {/if}
</div>