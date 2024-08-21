/**
 * Copyright (c) 2019 Nexi Payments S.p.A.
 *
 * @author      iPlusService S.r.l.
 * @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
 * @license     GNU General Public License v3.0
 * @category    Payment Module
 * @package     Nexi XPay
 * @version     7.0.0
 */

var XPay, card = {};

function build(identifier = "xpay-card", cvv = false) {
    // Inizializzazione SDK
    XPay.init();
    if ($(".checkbox-scelta-16")[0]) {
        checkBox16();
    } else if ($(".checkbox-scelta-17")[0]) {
        checkBox17();
    }
    CheckApplePay();
    // Configurazione del pagamento

    if (identifier == "xpay-card") {
        var config = {
            baseConfig: {
                apiKey: $("#build-apiKey").val(),
                enviroment: $("#build-ambiente").val(),
            },
            paymentParams: {
                amount: $("#build-importo").val(),
                transactionId: $("#build-codiceTransazione").val(),
                currency: $("#build-divisa").val(),
                timeStamp: $("#build-timeStamp").val(),
                mac: $("#build-mac").val(),
                url: $("#build-url").val(),
                urlBack: $("#build-urlBack").val(),
                urlPost: $("#build-urlPost").val(),
            },
            customParams: {},
            language: $("#build-languageId").val(),
        };
    } else {
        var config = {
            baseConfig: {
                apiKey: $("#build-apiKey").val(),
                enviroment: $("#build-ambiente").val(),
            },
            paymentParams: {
                amount: $("#build-importo").val(),
                transactionId: $("#build-codiceTransazione-" + identifier).val(),
                currency: $("#build-divisa").val(),
                timeStamp: $("#build-timeStamp-" + identifier).val(),
                mac: $("#build-mac-" + identifier).val(),
                url: $("#build-url").val(),
                urlBack: $("#build-urlBack").val(),
                urlPost: $("#build-urlPost").val(),
            },
            customParams: {},
            language: $("#build-languageId").val(),
        };
    }

    if (cvv) {
        config.customParams = {
            num_contratto: identifier,
        };

        config.serviceType = "paga_oc3d";
        config.requestType = "PR";
    }
    var tds_param = {
        buyer: {},
        // Indirizzo di shipping
        destinationAddress: {},
        // Indirizzo di billing
        billingAddress: {},
        // Informazioni account del cardholder
        cardHolderAcctInfo: {},
        // Informazioni sul rischio
        merchantRiskIndicator: {},
    };

    if ($("#Buyer_email").val() != "" && $("#Buyer_email").val() != undefined) {
        tds_param.buyer.email = $("#Buyer_email").val();
    }
    if ($("#Buyer_homePhone").val() != "" && $("#Buyer_homePhone").val() != undefined) {
        tds_param.buyer.homePhone = $("#Buyer_homePhone").val();
    }
    if ($("#Buyer_workPhone").val() != "" && $("#Buyer_workPhone").val() != undefined) {
        tds_param.buyer.workPhone = $("#Buyer_workPhone").val();
    }
    if ($("#Buyer_account").val() != "" && $("#Buyer_account").val() != undefined) {
        tds_param.buyer.account = $("#Buyer_account").val();
    }

    if ($("#Dest_city").val() != "" && $("#Dest_city").val() != undefined) {
        tds_param.destinationAddress.city = $("#Dest_city").val();
    }
    if ($("#Dest_country").val() != "" && $("#Dest_country").val() != undefined) {
        tds_param.destinationAddress.countryCode = $("#Dest_country").val();
    }
    if ($("#Dest_street").val() != "" && $("#Dest_street").val() != undefined) {
        tds_param.destinationAddress.street = $("#Dest_street").val();
    }
    if ($("#Dest_street2").val() != "" && $("#Dest_street2").val() != undefined) {
        tds_param.destinationAddress.street2 = $("#Dest_street2").val();
    }
    if ($("#Dest_cap").val() != "" && $("#Dest_cap").val() != undefined) {
        tds_param.destinationAddress.postalCode = $("#Dest_cap").val();
    }
    if ($("#Dest_state").val() != "" && $("#Dest_state").val() != undefined) {
        tds_param.destinationAddress.stateCode = $("#Dest_state").val();
    }

    if ($("#Bill_city").val() != "" && $("#Bill_city").val() != undefined) {
        tds_param.billingAddress.city = $("#Bill_city").val();
    }
    if ($("#Bill_country").val() != "" && $("#Bill_country").val() != undefined) {
        tds_param.billingAddress.countryCode = $("#Bill_country").val();
    }
    if ($("#Bill_street").val() != "" && $("#Bill_street").val() != undefined) {
        tds_param.billingAddress.street = $("#Bill_street").val();
    }
    if ($("#Bill_street2").val() != "" && $("#Bill_street2").val() != undefined) {
        tds_param.billingAddress.street2 = $("#Bill_street2").val();
    }
    if ($("#Bill_cap").val() != "" && $("#Bill_cap").val() != undefined) {
        tds_param.billingAddress.postalCode = $("#Bill_cap").val();
    }
    if ($("#Bill_state").val() != "" && $("#Bill_state").val() != undefined) {
        tds_param.billingAddress.stateCode = $("#Bill_state").val();
    }

    if ($("#chAccDate").val() != "" && $("#chAccDate").val() != undefined) {
        tds_param.cardHolderAcctInfo.chAccDate = $("#chAccDate").val();
    }
    if ($("#chAccAgeIndicator").val() != "" && $("#chAccAgeIndicator").val() != undefined) {
        tds_param.cardHolderAcctInfo.chAccAgeIndicator = $("#chAccAgeIndicator").val();
    }
    if ($("#chAccChangeDate").val() != "" && $("#chAccChangeDate").val() != undefined) {
        tds_param.cardHolderAcctInfo.chAccChangeDate = $("#chAccChangeDate").val();
    }
    if ($("#chAccChangeIndicator").val() != "" && $("#chAccChangeIndicator").val() != undefined) {
        tds_param.cardHolderAcctInfo.chAccChangeIndicator = $("#chAccChangeIndicator").val();
    }
    if ($("#nbPurchaseAccount").val() != "" && $("#nbPurchaseAccount").val() != undefined) {
        tds_param.cardHolderAcctInfo.nbPurchaseAccount = $("#nbPurchaseAccount").val();
    }
    if (
        $("#destinationAddressUsageDate").val() != "" &&
        $("#destinationAddressUsageDate").val() != undefined
    ) {
        tds_param.cardHolderAcctInfo.destinationAddressUsageDate = $(
            "#destinationAddressUsageDate"
        ).val();
    }
    if (
        $("#destinationNameIndicator").val() != "" &&
        $("#destinationNameIndicator").val() != undefined
    ) {
        tds_param.cardHolderAcctInfo.destinationNameIndicator = $(
            "#destinationNameIndicator"
        ).val();
    }
    if (
        $("#destinationNameIndicator").val() != "" &&
        $("#destinationNameIndicator").val() != undefined
    ) {
        tds_param.cardHolderAcctInfo.destinationNameIndicator = $(
            "#destinationNameIndicator"
        ).val();
    }
    /*if ($('#reorderItemsIndicator').val() != '' && $('#reorderItemsIndicator').val() != undefined) {
     tds_param.merchantRiskIndicator.reorderItemsIndicator = $('#reorderItemsIndicator').val();
     }*/

    if (Object.keys(tds_param.buyer).length === 0) {
        delete tds_param.buyer;
    }
    if (Object.keys(tds_param.destinationAddress).length === 0) {
        delete tds_param.destinationAddress;
    }
    if (Object.keys(tds_param.billingAddress).length === 0) {
        delete tds_param.billingAddress;
    }
    if (Object.keys(tds_param.cardHolderAcctInfo).length === 0) {
        delete tds_param.cardHolderAcctInfo;
    }
    if (Object.keys(tds_param.merchantRiskIndicator).length === 0) {
        delete tds_param.merchantRiskIndicator;
    }

    if ($("#nexixpaybuild_enabled3ds").val() == 1) {
        config.informazioniSicurezza = tds_param;
    }
    XPay.setConfig(config);

    // Configurazione dello stile per il form dei dati carta
    var style = $.parseJSON($("#build-style-configuration").val());

    // Creazione dell'elemento carta
    card[identifier] = XPay.create(XPay.OPERATION_TYPES.CARD, style);

    if (identifier != "xpay-card") {
        card[identifier].mount("xpay-card-cvv-" + identifier);
    } else {
        card[identifier].mount(identifier);
    }
}

window.addEventListener("load", function () {
    $("#codiceTransazioneSelezionato").val($("#build-codiceTransazione").val());

    build();
    $(".xpay-card-cvv").each(function () {
        var identifier = $(this).attr("id").replace("xpay-card-cvv-", "");
        build(identifier, true);
    });

    $("#payment-confirmation button").on("click", function (e) {
        e.preventDefault();
        if (
            $('input[data-module-name="nexixpaybuild"]').is(":checked") &&
            ($("#nuova-carta").is(":checked") || $("#nuova-carta").val() == 1)
        ) {
            this.disabled = true;
            // Creazione del nonce
            XPay.createNonce("payment-form", card["xpay-card"]);
        } else if (
            $('input[data-module-name="nexixpaybuild"]').is(":checked") &&
            ($(".checkboxContract").is(":checked") || $(".checkboxContract").val() == 1)
        ) {
            this.disabled = true;
            // Creazione del nonce
            XPay.createNonce("payment-form", card[$(".checkboxContract:checked").val()]);
        }
    });
    //ps 1.6.x
    $("#pagaBtn").on("click", function (e) {
        e.preventDefault();
        if ($("#nuova-carta").is(":checked") || $("#nuova-carta").val() == 1) {
            this.disabled = true;
            // Creazione del nonce
            XPay.createNonce("payment-form", card["xpay-card"]);
        } else if ($(".checkboxContract").is(":checked") || $(".checkboxContract").val() == 1) {
            this.disabled = true;
            // Creazione del nonce
            XPay.createNonce("payment-form", card[$(".checkboxContract:checked").val()]);
        }
    });
});

// Handler per la gestione degli errori di validazione carta
window.addEventListener("XPay_Card_Error", function (event) {
    var displayError = document.getElementById("xpay-card-errors");

    if (event.detail.errorMessage) {
        // Visualizzo il messaggio di errore
        displayError.innerHTML = event.detail.errorMessage;
        if ($("#build-border-color-error").val()) {
            $("#xpay-card").css("border", "1px solid " + $("#build-border-color-error").val());
        }
    } else {
        // Nessun errore nascondo eventuali messaggi rimasti
        displayError.innerHTML = "";
        if (document.getElementById("pagaBtn") != null) {
            document.getElementById("pagaBtn").disabled = false;
        }
        if ($("#build-border-color-default").val()) {
            $("#xpay-card").css("border", "1px solid " + $("#build-border-color-default").val());
        }
    }

    if (
        $("#conditions_to_approve[terms-and-conditions]").length &&
        $("#conditions_to_approve[terms-and-conditions]").is(":checked")
    ) {
        $("#payment-confirmation button").prop("disabled", false);
    }
});

window.addEventListener("XPay_Payment_Result", function (event) {
    var keys = Object.keys(event.detail);
    var arr = [];
    for (var i = 0; i < keys.length; i++) {
        arr.push(keys[i] + "=" + event.detail[keys[i]]);
    }
    var query = arr.join("&");

    window.location.href = decodeURIComponent($("#build-url").val()) + "?" + query;
});

// Handler per ricevere nonce pagamento
window.addEventListener("XPay_Nonce", function (event) {
    var response = event.detail;

    if (response.esito && response.esito === "OK") {
        document.getElementById("xpayNonce").setAttribute("value", response.xpayNonce);
        document.getElementById("xpayIdOperazione").setAttribute("value", response.idOperazione);
        document.getElementById("xpayTimeStamp").setAttribute("value", response.timeStamp);
        document.getElementById("xpayEsito").setAttribute("value", response.esito);
        document.getElementById("xpayMac").setAttribute("value", response.mac);

        var form = document.getElementById("nexi-payment-form");

        for (var prop in response.dettaglioCarta) {
            var x = document.createElement("INPUT");
            x.setAttribute("type", "hidden");
            x.setAttribute("name", prop);
            x.setAttribute("value", response.dettaglioCarta[prop]);
            form.appendChild(x);
        }

        // Submit del form contenente il nonce verso il server del merchant
        document.getElementById("nexi-payment-form").submit();
    } else {
        // Visualizzazione errore creazione nonce e ripristino bottone form
        var displayError = document.getElementById("xpay-card-errors");

        var url = window.location.href;
        if (url.indexOf("?") > -1) {
            url += "&errCode=" + response.errore.codice + "&msgError=" + response.errore.messaggio;
        } else {
            url += "?errCode=" + response.errore.codice + "&msgError=" + response.errore.messaggio;
        }
        window.location.href = url;
        //displayError.innerHTML = "[ " + response.errore.codice + " ] " + response.errore.messaggio;

        //document.getElementById('pagaBtn').disabled = false;
    }
});

// Per la versione 1.6
$(".checkbox-scelta-16").on("change", function () {
    checkBox16();
    if (
        typeof $("#build-codiceTransazione-" + $(".checkboxContract:checked").val()).val() ===
        "undefined"
    ) {
        $("#codiceTransazioneSelezionato").val($("#build-codiceTransazione").val());
    } else {
        $("#codiceTransazioneSelezionato").val(
            $("#build-codiceTransazione-" + $(".checkboxContract:checked").val()).val()
        );
    }
});

// Per la versione 1.7
$(".checkbox-scelta-17").on("change", function () {
    checkBox17();
    if (
        typeof $("#build-codiceTransazione-" + $(".checkboxContract:checked").val()).val() ===
        "undefined"
    ) {
        $("#codiceTransazioneSelezionato").val($("#build-codiceTransazione").val());
    } else {
        $("#codiceTransazioneSelezionato").val(
            $("#build-codiceTransazione-" + $(".checkboxContract:checked").val()).val()
        );
    }
});

function checkBox16() {
    if ($("#nuova-carta").is(":checked") || $("#nuova-carta").val() == 1) {
        $("#box-xpay-build").removeClass("hide");
        $("#box-testo-nuova-carta").addClass("hide");
        $(".box-xpay-build-cvv").addClass("hide");
    } else if ($(".checkboxContract").is(":checked") || $(".checkboxContract").val() == 1) {
        $("#box-xpay-build").addClass("hide");
        $("#box-testo-nuova-carta").removeClass("hide");
        $(".box-xpay-build-cvv").addClass("hide");
        $("#box-xpay-build-cvv-" + $(".checkboxContract:checked").val()).removeClass("hide");
    } else {
        $(".box-xpay-build-cvv").addClass("hide");
        $("#box-xpay-build").addClass("hide");
        $("#box-testo-nuova-carta").removeClass("hide");
        $("#pagaBtn").attr("disabled", false);
    }
}

function checkBox17() {
    if ($("#tabella-metodi-pagamento").length) {
        if ($("#nuova-carta").is(":checked")) {
            $("#box-xpay-build").css("display", "block");
            $("#box-testo-nuova-carta").css("display", "none");
            $(".box-xpay-build-cvv").css("display", "none");
        } else if ($(".checkboxContract").is(":checked") || $(".checkboxContract").val() == 1) {
            $("#box-xpay-build").css("display", "none");
            $("#box-testo-nuova-carta").css("display", "block");
            $(".box-xpay-build-cvv").css("display", "none");
            $("#box-xpay-build-cvv-" + $(".checkboxContract:checked").val()).css(
                "display",
                "block"
            );
        } else {
            $(".box-xpay-build-cvv").css("display", "none");
            $("#box-xpay-build").css("display", "none");
            $("#box-testo-nuova-carta").css("display", "block");
            $("#pagaBtn").attr("disabled", false);
        }
    }
}

function CheckApplePay() {
    if (!window.ApplePaySession && $('*[data-module-name="APPLEPAY"]').length) {
        $('*[data-module-name="APPLEPAY"]')[0].parentNode.parentNode.remove();
    }
}

$("#save_token").on("change", function () {
    var requestType = "PA";

    if ($(this).is(":checked")) {
        requestType = "PP";
    }

    XPay.updateConfig(card["xpay-card"], { serviceType: "paga_oc3d", requestType: requestType });
});
