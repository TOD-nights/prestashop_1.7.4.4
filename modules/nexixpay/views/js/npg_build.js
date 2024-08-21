/*
 * Copyright (c) 2020 Nexi Payments S.p.A.
 * @author      iPlusService S.r.l.
 * @copyright   Copyright (c) 2020 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
 * @license     GNU General Public License v3.0
 * @category    Payment Module
 * @version     7.1.0
 */

jQuery(function ($) {
    var disabledByScript = false;
    var readyForPayment = false;

    $(document).ready(function () {
        checkAndloadBuild();
    });

    var isNpgBuildSelected = function () {
        return $('input[name="payment-option"]:checked').data("module-name") == "npgbuild";
    };

    var checkAndloadBuild = function () {
        if (isNpgBuildSelected()) {
            buildFields();
        } else {
            enableSubmitButton();
        }
    };

    var disableSubmitButton = function () {
        disabledByScript = true;

        $("#payment-confirmation button").attr("disabled", true);
    };

    var enableSubmitButton = function () {
        if (disabledByScript && $('input[id="conditions_to_approve[terms-and-conditions]"]').is(":checked")) {
            $("#payment-confirmation button").attr("disabled", false);
        }
    };

    var showLoading = function () {
        $(".loader-container").removeClass("nexi-hide");
    };

    var hideLoading = function () {
        $(".loader-container").addClass("nexi-hide");
    };

    var buildFields = function () {
        readyForPayment = false;
        showLoading();

        cleanErrorMsg();
        cleanBuildFields();

        jQuery.ajax({
            type: "POST",
            data: {
                action: "npgBuildFields",
            },
            url: $("#nexi_ajax_url").val(),
            beforeSend: function () {
                showLoading();

                disableSubmitButton();
            },
            success: function (response) {
                hideLoading();

                var json = JSON.parse(response);

                if (json.error_msg) {
                    $(".npg-build-error-msg-container").html(`<p>${json.error_msg}</p>`);
                } else {
                    $("#nexi-payment-form #npg-orderId").val(json.orderId);

                    var fields = json.fields;

                    for (var i = 0; i < fields.length; i++) {
                        var iframe = document.createElement("iframe");

                        iframe.src = fields[i].src;
                        iframe.className = "iframe-field";

                        $(`#${fields[i].id}`).append(iframe);
                    }
                }
            },
            complete: function () {
                hideLoading();
            },
        });
    };

    var cleanBuildFields = function () {
        $(".build-field-row").each(function (_i, fRow) {
            $(fRow)
                .children("div")
                .children("iframe")
                .each(function (_j, field) {
                    $(field).remove();
                });
        });
    };

    var cleanErrorMsg = function () {
        $(".npg-build-error-msg-container").html("");
    };

    var setErrorMsg = function (error) {
        $(".npg-build-error-msg-container").html(`${error}`);
    };

    $(document).on("change", 'input[name="payment-option"]', function () {
        checkAndloadBuild();
    });

    $(document).on('change', 'input[id="conditions_to_approve[terms-and-conditions]"]', function () {
        if (isNpgBuildSelected() && !readyForPayment) {
            disableSubmitButton();
        }
    });

    window.addEventListener("message", function (event) {
        if ("event" in event.data && "state" in event.data) {
            // Nexi sta notificando che si è pronti per il pagamento
            if (
                event.data.event === "BUILD_FLOW_STATE_CHANGE" &&
                event.data.state === "READY_FOR_PAYMENT"
            ) {
                readyForPayment = true;

                enableSubmitButton();
            }
        }

        if (event.data.event === "BUILD_ERROR") {
            if (event.data.errorCode == "HF0001") {
                setErrorMsg($("#validation-error").val());
            } else if (event.data.errorCode == "HF0003") {
                setErrorMsg($("#session-error").val());
            } else {
                console.error(event.data);
            }
        } else {
            cleanErrorMsg();
        }
    });
});
