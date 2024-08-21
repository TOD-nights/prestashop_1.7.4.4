/*
 * Copyright (c) 2020 Nexi Payments S.p.A.
 * @author      iPlusService S.r.l.
 * @copyright   Copyright (c) 2020 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
 * @license     GNU General Public License v3.0
 * @category    Payment Module
 * @package     Nexi XPay
 * @version     5.1.0
 */

var clicked = 0;
$("button[name=processPayment]").on("click", function () {
    if (clicked === 1) {
        $("button[name=processPayment]").attr("disabled", true);
    } else {
        clicked = 1;
    }
});

$(document).on("click", ".xpay_delete_contract", function () {
    var id_contract = $(this).attr("data-id-contract");

    if (confirm($("#textDeleteContract").val())) {
        $("html, body").css("cursor", "wait");

        $.ajax({
            type: "POST",
            url: $("#deleteLink").val(),
            data: {
                id_contract: id_contract,
            },
            dataType: "json",
            success: function (response) {
                $("html, body").css("cursor", "default");

                alert(response.msg);

                if (response.res === true) {
                    $("#tr-contract-" + id_contract).remove();
                    location.reload();
                }
            },
        });
    }
});

$(document).on("click", ".xpay_edit_contract", function () {
    var id_contract = $(this).attr("data-id-contract");

    if ($("#edit_card_" + id_contract).is(":hidden")) {
        $("#edit_card_" + id_contract).show();
    } else {
        $("#edit_card_" + id_contract).hide();
    }
});

$(document).on("click", ".save_mods", function () {
    var id_contract = $(this).attr("data-id-contract");

    if (confirm(document.getElementById("textUpdateContract").value)) {
        $.ajax({
            type: "POST",
            url: $("#editLink").val(),
            data: {
                id_contract: id_contract,
                month: $("#new_month_" + id_contract).val(),
                year: $("#new_year_" + id_contract).val(),
            },
            dataType: "json",
            success: function (response) {
                if (response === true) {
                    location.reload();
                }
            },
        });
    }
});
