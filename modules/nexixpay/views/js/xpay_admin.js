/*
 * Copyright (c) 2020 Nexi Payments S.p.A.
 * @author      iPlusService S.r.l.
 * @copyright   Copyright (c) 2020 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
 * @license     GNU General Public License v3.0
 * @category    Payment Module
 * @version     5.3.0
 */

const XPAY_PLUGIN_VARIANT = "xpay";

$(document).ready(function () {
    function isXPayBuild() {
        return XPAY_PLUGIN_VARIANT == "xpay_build";
    }

    var controller_xpay = $("#controller_xpay").val();
    var controller_xpay_url = $("#controller_xpay_url").val();
    var id_order = $("#xpay_id_order").val();

    hideShowGatewayProperties($(".gateway-input option:selected").val());

    hideShowCategoriesProperties(
        $('select[name="NEXIXPAY_PAGODIL_ENABLE_ON_CATEGORIES"] option:selected').val()
    );

    hideShowWidgetProperties($('input[name="NEXIXPAY_PAGODIL_SHOW_WIDGET"]:checked').val());

    $(".nexi_aop").click(function () {
        var amount = $("#nexi_aop_amount").val().replace(",", ".");
        var action = $(this).attr("action");

        var actionText = "";

        if ($(this).data("action-q")) {
            actionText = $(this).data("action-q");
        } else {
            actionText =
                $("#" + $(this).attr("action") + "-s").val() +
                " " +
                amount +
                " " +
                $("#currency-label").val();
        }

        if ($.isNumeric(amount) && amount > 0) {
            var domanda = confirm($("#action-question").val() + " " + actionText);

            if (domanda === true) {
                $("html, body").css("cursor", "wait");

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: controller_xpay_url,
                    data: {
                        ajax: true,
                        controller: controller_xpay,
                        action: action,
                        id_order: id_order,
                        amount: amount,
                        gateway: $("#nexi_payment_gateway").val(),
                    },
                    success: function (json) {
                        $("html, body").css("cursor", "default");
                        alert(json["msg"]);
                        window.location.reload();
                    },
                });
            }
        } else {
            alert("Importo non valido!");

            $("#nexi_aop_amount").val("");
            $("#nexi_aop_amount").focus();
        }
    });

    $(".gateway-input").on("change", function () {
        hideShowGatewayProperties($(this).val());
    });

    function hideShowGatewayProperties(flag) {
        if (flag == "npg") {
            $(".xpay-only").each(function () {
                $(this).attr("disabled", true);
                $($(this).parents(".form-group")[0]).hide();
            });

            $(".npg-only").each(function () {
                $(this).attr("disabled", false);
                $($(this).parents(".form-group")[0]).show();
            });

            $(".xpay-only-text").each(function () {
                $(this).hide();
            });

            $(".npg-only-text").each(function () {
                $(this).show();
            });

            if (isXPayBuild()) {
                $("input[name='NEXIXPAY_ENABLE_ONECLICK']").attr("disabled", true);
                $($("input[name='NEXIXPAY_ENABLE_ONECLICK']").parents(".form-group")[0]).hide();

                if ($("div.panel[id*='nexixpaybuild_style']").length) {
                    $("div.panel[id*='nexixpaybuild_style']").hide();
                }
            }

            $("input[name='NEXINPG_ENABLE_MULTICURRENCY']").attr("disabled", false);
            $($("input[name='NEXINPG_ENABLE_MULTICURRENCY']").parents(".form-group")[0]).show();

            if ($("div.panel[id*='pagodil']").length) {
                $("div.panel[id*='pagodil']").hide();
            }
        } else {
            $(".npg-only").each(function () {
                $(this).attr("disabled", true);
                $($(this).parents(".form-group")[0]).hide();
            });

            $(".xpay-only").each(function () {
                $(this).attr("disabled", false);
                $($(this).parents(".form-group")[0]).show();
            });

            $(".npg-only-text").each(function () {
                $(this).hide();
            });

            $(".xpay-only-text").each(function () {
                $(this).show();
            });

            if (isXPayBuild()) {
                $("input[name='NEXIXPAY_ENABLE_ONECLICK']").attr("disabled", false);
                $($("input[name='NEXIXPAY_ENABLE_ONECLICK']").parents(".form-group")[0]).show();

                if ($("div.panel[id*='nexixpaybuild_style']").length) {
                    $("div.panel[id*='nexixpaybuild_style']").show();
                }
            }

            $("input[name='NEXINPG_ENABLE_MULTICURRENCY']").attr("disabled", true);
            $($("input[name='NEXINPG_ENABLE_MULTICURRENCY']").parents(".form-group")[0]).hide();

            if ($("div.panel[id*='pagodil']").length) {
                $("div.panel[id*='pagodil']").show();
            }
        }
    }

    $('input[name="NEXIXPAY_PAGODIL_SHOW_WIDGET"]').on("change", function () {
        hideShowWidgetProperties($(this).val());
    });

    function hideShowWidgetProperties(valore) {
        if (parseInt(valore) == 0) {
            $(".widget-properties").each(function () {
                $(this).parent().parent().hide();
            });
        } else {
            $(".widget-properties").each(function () {
                $(this).parent().parent().show();
            });
        }
    }

    $('select[name="NEXIXPAY_PAGODIL_ENABLE_ON_CATEGORIES"]').on("change", function () {
        hideShowCategoriesProperties($(this).val());
    });

    function hideShowCategoriesProperties(valore) {
        if (valore == "all") {
            $("#categories-tree").parent().parent().parent().hide();
        } else {
            $("#categories-tree").parent().parent().parent().show();
        }
    }

    $(".styleBlock").each(function (_index, element) {
        renderPreview($(element));
    });

    $(".info-helper").each(function (_index, element) {
        sistemaDefault($(element), false);
    });

    $(".styleBlock").on("change", function () {
        renderPreview($(this));
    });

    $(".info-helper").click(function () {
        sistemaDefault($(this), true);
    });

    function renderPreview(element) {
        if (element.data("input-type") === "simple") {
            if (element.data("field") === "border-color") {
                $(".stylePreview .content-anteprima div.Bricks").css(
                    element.data("field"),
                    element.val()
                );
            } else {
                $(".stylePreview .content-anteprima .Bricks input").css(
                    element.data("field"),
                    element.val()
                );
            }
        } else {
            if (element.data("field") === "color") {
                $("#dynamicStyle").html(
                    ".stylePreview .content-anteprima .Bricks input::placeholder { color: " +
                        element.val() +
                        "}"
                );
            }
        }
    }

    function sistemaDefault(element, click) {
        var id = element.data("id");

        if (id) {
            if (click || !$("#" + id).val()) {
                $("#" + id).val(element.data("default"));
                $("#" + id).trigger("change");
            }
        }
    }
});
