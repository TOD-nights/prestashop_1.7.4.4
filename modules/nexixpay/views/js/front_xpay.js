/*
 * Copyright (c) 2021 Nexi Payments S.p.A.
 * @author      iPlusService S.r.l.
 * @copyright   Copyright (c) 2021 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
 * @license     GNU General Public License v3.0
 * @category    Payment Module
 * @version     5.3.0
 */

$(document).ready(function () {
    const SELECTED_TOKEN_NEW = "NEW";

    getInstallmentsLabel();

    if (!window.ApplePaySession && $('*[data-module-name="APPLEPAY"]').length) {
        $('*[data-module-name="APPLEPAY"]')[0].parentNode.parentNode.remove();
    }

    $(document).on("change", "#pagodil-installments-number", function () {
        $("#installments").val($(this).val());

        window.localStorage.setItem("lastSelectedInstallments", parseInt($(this).val()));

        getInstallmentsLabel();
    });

    function getInstallmentsAmount() {
        var total = $("#totalAmount").val();
        var total_recurrences = $("#installments").val();

        return (total / total_recurrences).toFixed(2);
    }

    function getInstallmentsLabel() {
        var installmentLabel = $("#installmentLabel").val();
        var total_recurrences = $("#installments").val();

        if ($("#installmentLabel").val() && $("#installments").val()) {
            $("#installment-text").html(
                pagodilSprintf(installmentLabel, total_recurrences, getInstallmentsAmount())
            );
        }
    }

    function pagodilSprintf(str, ...argv) {
        if (argv.length) {
            return pagodilSprintf(str.replace("$", argv.shift()), ...argv);
        } else {
            return str;
        }
    }

    $('#nexi-payment-form input[name="selected_token"]').on("change", function () {
        if ($(this).val() == SELECTED_TOKEN_NEW) {
            $("#save-token-checkbox").show();
            $('#save-token-checkbox input[name="save_token"]').attr("disabled", false);
        } else {
            $("#save-token-checkbox").hide();
            $('#save-token-checkbox input[name="save_token"]').attr("disabled", true);
        }
    });
});
