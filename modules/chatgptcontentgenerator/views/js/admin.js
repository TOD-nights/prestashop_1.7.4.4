/**
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

$(function () {
    if (typeof adminPageName == 'undefined') {
        return;
    }

    if (typeof gptShopInfo == 'undefined' || !!gptShopInfo === false) {
        console.error('The gptShopInfo is not defined. Make sure that the the shop data is agreement on the module configuration page');
        return;
    }

    function renderLoaderlayer(el) {
        el.length > 0 && el.css('position', 'relative')
                .append('<div id="gpt_description_loader" class="content-loader-layer"><div class="loader-wrapper"><div class="content-loader"></div></div></div>');
    }

    function getWordsFiled(value, min, max, step) {
        return '<div class="col-md-4">'+
                    '<div class="input-group">' +
                        '<input type="number" id="gpt_description_length" title="' + gptI18n.maxLength + '" class="form-control" min="' + min + '" step="' + step + '" max="' + max + '" value="' + value + '">' +
                        '<div class="input-group-append">' +
                            '<span class="input-group-text"> ' + gptI18n.words + '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>';
    }

    function getInfoButton(message) {
        return '<a class="btn tooltip-link delete pl-0 pr-0">' +
                '<span class="help-box gpt-tooltip" data-toggle="popover" data-content="' + message.replace(/\"/g, "\'") + '" data-original-title="" title=""></span>' +
            '</a>';
    }

    function removeLoaderLayer() {
        $("#gpt_description_loader").remove();
    }

    function renderAlertMessage(messageText, element) {
        var object = $('<div class="alert alert-danger mt-2" role="alert">' +
                        '<p class="alert-text">' + messageText + '</p>' +
                    '</div>');
        if (!!element && element.length) {
            element.append(object);
        }
    }

    function renderTranslateButtonsList (contentButton, options) {
        // if the shop use the single language then not need the translation panel
        if (gptLanguages.length <= 1) {
            $("#actions-wrapper-" + contentButton.getGroupId()).remove();
            return;
        }

        options = Object.assign({}, {
            contentWrapperSelector: '',
            contentEditorPreffix: '',
            entity: '',
        }, options);
        var context = (new ChatGptContent),
            idLang = context.getPageLanguageId(),
            pageLanguage = context.getPageLanguage();
        contentButton.setActions([]).setActions(
            gptLanguages.filter(function (language) {
                return language.id_lang != idLang ? language : null;
            }).map(function (language) {
                return {
                    element: '<a class="dropdown-item" href="#" data-wrapper="' + options.contentWrapperSelector + '" data-content-editor-preffix="' + options.contentEditorPreffix + '" data-entity="' + options.entity + '" data-from="' + language.iso_code + '" data-to="' + pageLanguage.iso_code + '">Translate ' + language.iso_code.charAt(0).toUpperCase() + language.iso_code.slice(1) + ' -> ' + pageLanguage.iso_code.charAt(0).toUpperCase() + pageLanguage.iso_code.slice(1) + '</a>',
                    callback: function () {
                        var contentEditorPreffix = $(this).data('content-editor-preffix');

                        var translate = (function (from, to, contentWrapperSelector, contentEditorPreffix, entity) {
                            return async function  () {
                                var content = new ChatGptContent();
                                text = tinymce.get(contentEditorPreffix + content.getLanguageByIsoCode(from).id_lang)
                                                .getContent({format: 'html'})
                                                .trim();

                                renderLoaderlayer($(contentWrapperSelector));

                                var translatedContent = await content.translateText(text, {
                                    fromLangauge: content.getLanguageByIsoCode(from).iso_code,
                                    toLanguage: content.getLanguageByIsoCode(to).iso_code,
                                    entity: entity
                                });

                                if (typeof translatedContent.inQueue != 'undefined' && translatedContent.inQueue) {
                                    translatedContent = await content.awaitRequestResponse(translatedContent.requestId);

                                    if (translatedContent && translatedContent.status != 'success') {
                                        if (translatedContent.status == 'quota_over') {
                                            window.showErrorMessage(gptI18n.subscriptionLimitЕxceeded);
                                        } else {
                                            window.showErrorMessage(translatedContent.text);
                                        }
                                        removeLoaderLayer();
                                        return;
                                    }
                                }

                                if (translatedContent && translatedContent.text) {
                                    content.setContentIntoEditor(
                                        content.convertTextToHtml(translatedContent.text),
                                        {format: 'html'},
                                        tinymce.get(contentEditorPreffix + content.getLanguageByIsoCode(to).id_lang)
                                    );

                                    window.showSuccessMessage(gptI18n.successMessage.replace(/\%words\%/g, translatedContent.nbWords));
                                }

                                removeLoaderLayer();
                            }
                        })($(this).data('from'), $(this).data('to'), $(this).data('wrapper'), contentEditorPreffix, $(this).data('entity'));

                        var idLang = (new ChatGptContent()).getLanguageByIsoCode($(this).data('to')).id_lang,
                            currentContent = tinymce.get(contentEditorPreffix + idLang)
                                                .getContent({format: 'text'})
                                                .trim();

                        if (currentContent !== '') {
                            (new ChatGptModal)
                                .setHeader(gptI18n.modalTitle)
                                .setBody(gptI18n.translateQuestion)
                                .addAction({
                                        title: gptI18n.buttonCancel,
                                        class: 'btn btn-outline-secondary'
                                    }, function (actionInstance) {
                                        actionInstance.getModal().destroy();
                                    })
                                .addAction({
                                        title: gptI18n.buttonTranslate,
                                    }, function (actionInstance) {
                                        translate($(this).data('from'), $(this).data('to'));
                                        actionInstance.getModal().destroy();
                                    })
                                .open();
                            return;
                        }

                        translate($(this).data('from'), $(this).data('to'), $(this).data('wrapper'));
                    }
                }
            })
        );
    }

    function renderCustomRequestForm (element, options) {
        options = Object.assign({}, {
            contentWrapperSelector: '',
            contentEditorPreffix: '',
            entity: '',
        }, options);

        // var context = (new ChatGptContent),
        //     idLang = context.getPageLanguageId(),
        //     pageLanguage = context.getPageLanguage();

        var customRequestObject = new ChatGptCustomRequest({}, function (instance) {
            async function customRequest () {
                var content = new ChatGptContent(),
                    idLang = content.getPageLanguageId();

                renderLoaderlayer(instance.getWrapper());
                var response = await content.customRequest(instance.getText(), {entity: options.entity});
                if (typeof response.inQueue != 'undefined' && response.inQueue) {
                    response = await content.awaitRequestResponse(response.requestId);

                    // display error message if the request is failure
                    if (response && response.status != 'success') {
                        if (response.status == 'quota_over') {
                            window.showErrorMessage(gptI18n.subscriptionLimitЕxceeded);
                        } else {
                            window.showErrorMessage(response.text);
                        }
                        removeLoaderLayer();
                        return;
                    }
                }

                if (response && response.text) {                    
                    content.setContentIntoEditor(
                        content.convertTextToHtml(response.text),
                        {format: 'html'},
                        tinymce.get(options.contentEditorPreffix + idLang)
                    );

                    window.showSuccessMessage(gptI18n.successMessage.replace(/\%words\%/g, response.nbWords));
                }
                removeLoaderLayer();
            }

            var currentContent = tinymce.get(options.contentEditorPreffix + (new ChatGptContent()).getPageLanguageId())
                                    .getContent({format: 'text'})
                                    .trim();

            if (currentContent !== '') {
                (new ChatGptModal)
                    .setHeader(gptI18n.modalTitle)
                    .setBody(gptI18n.confirmCustomRequest)
                    .addAction({
                            title: gptI18n.buttonCancel,
                            class: 'btn btn-outline-secondary'
                        }, function (actionInstance) {
                            actionInstance.getModal().destroy();
                        })
                    .addAction({
                            title: '<i class="material-icons">send</i> ' + gptI18n.buttonSend,
                        }, function (actionInstance) {
                            customRequest();
                            actionInstance.getModal().destroy();
                        })
                    .open();
                return;
            }

            customRequest();
        }).renderInto(element);
    }

    if (adminPageName == 'productsList' || adminPageName == 'categoriesList') {
        var bulkAction = new ChatGptModalBulkAction({
            title: '<i class="material-icons">receipt</i> ' + gptI18n.bulkButtonName,
            class: 'dropdown-item'
        }, function (bulkActionButton) {
            var modal = new ChatGptModal({
                closable: false,
                keyboard: false,
                backdrop: false,
                class: 'black-modal'
            });

            bulkActionButton.setModal(modal);
            modal
                .setHeader(gptI18n.bulkGeneratingDescription)
                .setBody(
                    '<div class="row">' +
                        '<label class="control-label col-md-6">' + gptI18n.bulkConfirmGenerateDescription + '</label>' +
                        '<div class="col-md-3">' +
                            '<div class="col-sm">' +
                                '<div class="input-group">' +
                                    '<span class="ps-switch">' +
                                        '<input id="allow_gen_content_0" class="ps-switch" name="allow_gen_content" value="0" type="radio" aria-label="No">' +
                                        '<label for="allow_gen_content_0">' + gptI18n.no + '</label>' +
                                        '<input id="allow_gen_content_1" class="ps-switch" name="allow_gen_content" value="1" checked="" type="radio" aria-label="Yes">' +
                                        '<label for="allow_gen_content_1">' + gptI18n.yes + '</label>' +
                                        '<span class="slide-button"></span>' +
                                    '</span>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>'
                )
                .addAction({
                        title: gptI18n.buttonCancel,
                        class: 'btn btn-outline-secondary'
                    }, function (actionInstance) {
                        actionInstance.getModal().destroy();
                    })
                .addAction({
                        title: gptI18n.buttonRegenerate,
                    }, async function (actionInstance) {
                        var modal = actionInstance.getModal();
                        var replace = +$("#allow_gen_content_1").is(':checked');
                        modal.find('body').html(
                            '<div>' +
                                '<span>Generating in progress...</span>' +
                                '<span id="process_generate_status" style="color: darkred;"></span>' +
                                '<div class="progress mt-2" style="width: 100%">' +
                                    '<div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%">' +
                                        '<span>0 %</span>' +
                                    '</div>' +
                                '</div>' +
                                '<div id="process_generate_error_log" class="alert alert-danger mt-2" style="display: none;"><p class="alert-text"></p></div>' +
                                '<div id="process_generate_success_log" class="alert alert-success mt-2" style="display: none;"><p class="alert-text"></p></div>' +
                            '</div>'
                        );
                        var contentInstance = new ChatGptContent();                        
                        var items = [];
                        var inputs = $('<input value="0" />');
                        if (adminPageName == 'productsList') {
                            inputs = $('input:checked[name="bulk_action_selected_products[]"]', $('#product_catalog_list'));
                        } else {
                            inputs = $('input:checked[name="category_id_category[]"]', $('#category_grid_table'));
                        }

                        inputs.each(function () { items.push(+this.value); });

                        modal
                            .setActions([])
                            .addAction({
                                    title: gptI18n.buttonCancel,
                                    class: 'btn btn-outline-secondary'
                                }, function (actionInstance) {
                                    contentInstance.stopCurrentProcess();
                                    actionInstance.getModal().find('#process_generate_status').text(gptI18n.textCanceled);
                                    
                                    actionInstance
                                        .getModal()
                                        .setActions([])
                                        .addAction({
                                                title: gptI18n.buttonClose,
                                                class: 'btn btn-outline-secondary'
                                            }, function (actionInstance) {
                                                actionInstance.getModal().destroy();
                                            })
                                        .renderActions();
                                })
                            .renderActions();

                        var functionName = 'bulkProductDescription';
                        if (adminPageName == 'categoriesList') {
                            functionName = 'bulkCategoryDescription';
                        }
                        await contentInstance[functionName](items, replace, async function (idObject, itemIndex, response, instance) {
                            var progressBar = modal.find('.progress-bar'),
                                itemsCount = items.length;
                            
                            if (typeof response.success != 'undefined' && !response.success) {
                                instance.stopCurrentProcess();
                                progressBar.removeClass('progress-bar-success');
                                progressBar.addClass('progress-bar-danger');
                                modal.find('#process_generate_status').text(gptI18n.bulkGenerationProcessFail);
                                modal.find("#process_generate_error_log").show().text(response.error.message);
                                
                                // render close button
                                modal
                                    .setActions([])
                                    .addAction({
                                            title: gptI18n.buttonClose,
                                            class: 'btn btn-outline-secondary'
                                        }, function (actionInstance) {
                                            actionInstance.getModal().destroy();
                                        })
                                    .renderActions();

                                return;
                            } else if (typeof response.success != 'undefined' && response.success) {
                                var inQueue = false;
                                if (adminPageName == 'categoriesList') {
                                    inQueue = response.categories[0].inQueue;
                                } else if (adminPageName == 'productsList') {
                                    inQueue = response.products[0].inQueue;
                                }
                                if (inQueue) {
                                    var requestId = 0;
                                    if (adminPageName == 'categoriesList') {
                                        requestId = response.categories[0].requestId;
                                    } else if (adminPageName == 'productsList') {
                                        requestId = response.products[0].requestId;
                                    }

                                    // await complete response
                                    requestInfo = await instance.awaitRequestResponse(requestId);
                                    // check request info
                                    if (requestInfo) {
                                        if (requestInfo.status != 'success') {
                                            // if the request sattus is not success then display the error
                                            instance.stopCurrentProcess();
                                            progressBar.removeClass('progress-bar-success');
                                            progressBar.addClass('progress-bar-danger');
                                            modal.find('#process_generate_status').text(gptI18n.bulkGenerationProcessFail);
                                            // modal.find("#process_generate_error_log").show().text(requestInfo.text);
                                            if (requestInfo.status == 'quota_over') {
                                                modal.find("#process_generate_error_log").show().text(gptI18n.subscriptionLimitЕxceeded);
                                            } else {
                                                window.showErrorMessage(requestInfo.text);
                                                modal.find("#process_generate_error_log").show().text(requestInfo.text);
                                            }

                                            // render close button
                                            modal
                                                .setActions([])
                                                .addAction({
                                                        title: gptI18n.buttonClose,
                                                        class: 'btn btn-outline-secondary'
                                                    }, function (actionInstance) {
                                                        actionInstance.getModal().destroy();
                                                    })
                                                .renderActions();

                                            return;
                                        } else if (requestInfo.text) {
                                            // set description
                                            await instance.setDescription(
                                                (adminPageName == 'categoriesList' ? response.categories[0].idCategory : response.products[0].idProduct),
                                                (adminPageName == 'categoriesList' ? 'category' : 'product'),
                                                requestInfo.text,
                                                replace
                                            );
                                        }
                                    }
                                }
                            }

                            progressBar.css('width', `${(itemIndex+1) * 100 / itemsCount}%`);
                            progressBar.find('span').html(`${(itemIndex+1)} / ${itemsCount}`);

                            if (((itemIndex + 1) * 100 / itemsCount) >= 100) {
                                modal
                                    .setActions([])
                                    .addAction({
                                            title: gptI18n.buttonClose,
                                            class: 'btn btn-outline-secondary'
                                        }, function (actionInstance) {
                                            window.location.reload();
                                            actionInstance.getModal().destroy();
                                        })
                                    .renderActions();

                                modal.find('#process_generate_success_log').show().text(gptI18n.bulkGenerationProcessCompleted);
                            }
                        });
                    })
                .open();
        });

        var availableCategoryDescriptionFeature = gptShopInfo.subscription && gptShopInfo.subscription.availableCategoryWords > 0;
        var availableProductDescriptionFeature = gptShopInfo.subscription && gptShopInfo.subscription.availableProductWords > 0;

        if (adminPageName == 'productsList' && availableProductDescriptionFeature) {
            var bulkMenu = $('.bulk-catalog .dropdown-menu');
            bulkMenu.prepend($('<div class="dropdown-divider"></div>'));
            bulkAction.renderInto(bulkMenu, true);
        } else if (adminPageName == 'categoriesList' && availableCategoryDescriptionFeature) {
            var bulkMenu = $("#category_grid_bulk_action_enable_selection").closest('.dropdown-menu');
            bulkMenu.prepend($('<div class="dropdown-divider"></div>'));
            bulkAction.renderInto(bulkMenu, true);
        }

        if ((adminPageName == 'productsList' && availableProductDescriptionFeature) || (adminPageName == 'categoriesList' && availableCategoryDescriptionFeature)) {
            // search table and add new column
            var listTable = $("#product_catalog_list").find('table.table.product');
            var filterColumn = 2,
                headerColumn = 3;
            if (adminPageName == 'categoriesList') {
                listTable = $("#category_grid_table");
                filterColumn = 3;
                headerColumn = 3;
                $(listTable.find('thead').find('tr.column-filters').find('td').get(filterColumn))
                    .after(
                        $(
                            '<th class="text-center">' +
                                '<div class="form-select">' +
                                    '<select id="filter_column_generated_description" class="custom-select" name="filter_column_generated_description" aria-label="filter_column_generated_description select">' +
                                        '<option value=""></option>' +
                                        '<option value="1"' + (columnGeneratedDescription === 1 ? ' selected="selected"' : '') + '>' + gptI18n.yes + '</option>' +
                                        '<option value="0"' + (columnGeneratedDescription === 0 ? ' selected="selected"' : '') + '>' + gptI18n.no + '</option>' +
                                    '</select>' +
                                '</div>' +
                            '</th>'
                        )
                    );
            } else {
                $(listTable.find('thead').find('tr.column-filters').find('th').get(filterColumn))
                    .after(
                        $(
                            '<th class="text-center">' +
                                '<div class="form-select">' +
                                    (typeof gptHomeCategory != 'undefined' ?  '<input type="hidden" name="" id="column_filter_category" value="' + gptHomeCategory + '"/>' : '') +
                                    '<select id="filter_column_generated_description" class="custom-select" name="filter_column_generated_description" aria-label="filter_column_generated_description select">' +
                                        '<option value=""></option>' +
                                        '<option value="1"' + (columnGeneratedDescription === 1 ? ' selected="selected"' : '') + '>' + gptI18n.yes + '</option>' +
                                        '<option value="0"' + (columnGeneratedDescription === 0 ? ' selected="selected"' : '') + '>' + gptI18n.no + '</option>' +
                                    '</select>' +
                                '</div>' +
                            '</th>'
                        )
                    );
            }
            // add head could
            $(listTable.find('thead').find('tr.column-headers').find('th').get(headerColumn))
                .after($('<th scope="col">ChatGPT</th>'));

            

            if (adminPageName == 'productsList') {
                $("#filter_column_generated_description").on('change', function () {
                    if ($('#product_categories_categories input.category:checked[type="radio"]').length > 0) {
                        return;
                    }

                    if (this.value === '') {
                        $("#column_filter_category").attr('name', '');
                    } else {
                        $("#column_filter_category").attr('name', 'filter_category');
                    }
                });

                if (columnGeneratedDescription === 0 || columnGeneratedDescription === 1) {
                    $("#filter_column_generated_description").trigger('change');
                }

                if (catalogProductsList.length) {
                    listTable.find('tbody > tr').each(function (i) {
                        var checked = !!catalogProductsList[i] && !!catalogProductsList[i].generated_description;
                        $($(this).find('td').get(3)).after($('<td class="text-center" style="color: ' + (checked ? '#40e32c' : '#afa9a9') + ';"><i class="material-icons">check</i></td>'));
                    });
                }
            } else if (adminPageName == 'categoriesList') {
                if (columnGeneratedDescription === 0 || columnGeneratedDescription === 1) {
                    // $("#filter_column_generated_description").trigger('change');
                    $('button[name="category[actions][search]"]').attr('disabled', false);
                }

                if (catalogCategoriesList.length) {
                    listTable.find('tbody > tr').each(function (i) {
                        var checked = !!catalogCategoriesList[i] && !!catalogCategoriesList[i].generated_description;
                        $($(this).find('td').get(filterColumn)).after($('<td class="text-center" style="color: ' + (checked ? '#40e32c' : '#afa9a9') + ';"><i class="material-icons">check</i></td>'));
                    });
                }
            }
        }
    } else if (adminPageName == 'productForm') {
        if (!gptShopInfo.subscription || gptShopInfo.subscription.availableProductWords == 0) {
            if (!gptShopInfo.subscription || !gptShopInfo.subscription.plan) {
                renderAlertMessage(gptI18n.subscriptionNotAvaialable, $("#description"));
            } else if (gptShopInfo.subscription.plan.productWords == 0) {
                renderAlertMessage(gptI18n.subscriptionPlanNoFeature, $("#description"));
            }  else if (gptShopInfo.subscription.availableProductWords == 0) {
                renderAlertMessage(gptI18n.subscriptionLimitЕxceeded, $("#description"));
            }
            return;
        }

        $(".summary-description-container").css('overflow', 'visible');

        var actionObject = (new ChatGptAction({
            id: "gpt_description_button",
            title: gptI18n.buttonName,
            additionalHtml: getWordsFiled(400, 10, 1000, 1) +
                (gptUseProductCategory || gptUseProductBrand? getInfoButton(gptI18n.productTooltipMessage) : '')
        }))
            .renderInto($("#description"));

        $(".gpt-tooltip").popover();

        $("#form_switch_language").on('change', function () {
            renderTranslateButtonsList(actionObject, {
                contentWrapperSelector: '#description',
                contentEditorPreffix: 'form_step1_description_',
                entity: 'product',
            });
        });

        renderTranslateButtonsList(actionObject, {
            contentWrapperSelector: '#description',
            contentEditorPreffix: 'form_step1_description_',
            entity: 'product',
        });

        if (gptShopInfo.subscription.plan.customRequest) {
            renderCustomRequestForm($("#description"), {
                contentEditorPreffix: 'form_step1_description_',
                entity: 'product',
            });
        }

        actionObject.getButton().on('click', function (e) {
            e.preventDefault();

            var idLang = (new ChatGptContent()).getPageLanguageId(),
                currentContent = tinymce.get('form_step1_description_' + idLang)
                .getContent({format: 'text'})
                .trim();

            async function updateContent () {
                var content = new ChatGptContent(),
                    idLang = content.getPageLanguageId(),
                    productName = $("#form_step1_name_" + idLang).val();

                renderLoaderlayer($('#description'));
                var idDefaultCategory = 0;
                $('input.default-category').each(function () {
                    if ($(this).is(':checked')) {
                        idDefaultCategory = +this.value
                    }
                })

                var description = await content.getProductDescription(productName, {
                    idLang: idLang,
                    length: $('#gpt_description_length').val(),
                    idDefaultCategory: idDefaultCategory,
                    idBrand: !!+$("#form_step1_id_manufacturer").val() && $("#form_step1_id_manufacturer").val()
                });

                if (typeof description.inQueue != 'undefined' && description.inQueue) {
                    description = await content.awaitRequestResponse(description.requestId);

                    // display error message if the request is failure
                    if (description && description.status != 'success') {
                        if (description.status == 'quota_over') {
                            window.showErrorMessage(gptI18n.subscriptionLimitЕxceeded);
                        } else {
                            window.showErrorMessage(description.text);
                        }

                        removeLoaderLayer();
                        return;
                    }
                }

                if (description && description.text) {
                    content.setContentIntoEditor(
                        content.convertTextToHtml(description.text),
                        {format: 'html'},
                        tinymce.get('form_step1_description_' + idLang)
                    );

                    window.showSuccessMessage(gptI18n.successMessage.replace(/\%words\%/g, description.nbWords));
                }

                removeLoaderLayer();
            }

            if (currentContent !== '') {
                (new ChatGptModal)
                    .setHeader(gptI18n.modalTitle)
                    .setBody(gptI18n.regenerateQuestion)
                    .addAction({
                            title: gptI18n.buttonCancel,
                            class: 'btn btn-outline-secondary'
                        }, function (actionInstance) {
                            actionInstance.getModal().destroy();
                        })
                    .addAction({
                            title: gptI18n.buttonRegenerate,
                        }, function (actionInstance) {
                            updateContent();
                            actionInstance.getModal().destroy();
                        })
                    .open();
                return;
            }

            updateContent();
        });
    } else if (adminPageName == 'categoryForm') {
        if (!gptShopInfo.subscription || gptShopInfo.subscription.availableCategoryWords == 0) {
            if (!gptShopInfo.subscription || !gptShopInfo.subscription.plan) {
                renderAlertMessage(gptI18n.subscriptionNotAvaialable, $("#category_description"));
            } else if (gptShopInfo.subscription.plan.categoryWords == 0) {
                renderAlertMessage(gptI18n.subscriptionPlanNoFeature, $("#category_description"));
            }  else if (gptShopInfo.subscription.availableCategoryWords == 0) {
                renderAlertMessage(gptI18n.subscriptionLimitЕxceeded, $("#category_description"));
            }
            return;
        }

        var contentAction = (new ChatGptAction({
            id: "gpt_description_button",
            title: gptI18n.buttonName,
            additionalHtml: getWordsFiled(180, 10, 1000, 1)
        }))
            .renderInto($("#category_description"));

        var updateCategoryTranslateButtons = function () {
            renderTranslateButtonsList(contentAction, {
                contentWrapperSelector: '#category_description',
                contentEditorPreffix: 'category_description_',
                entity: 'category',
            });
        }

        updateCategoryTranslateButtons();
        if (typeof prestashop != 'undefined') {
            prestashop.component.EventEmitter.on('languageSelected', function () { updateCategoryTranslateButtons(); });
        } else {
            $('body').on('shown.bs.tab', '.translationsLocales.nav .nav-item a[data-toggle="tab"]', updateCategoryTranslateButtons);
        }

        if (gptShopInfo.subscription.plan.customRequest) {
            renderCustomRequestForm($("#category_description"), {
                contentEditorPreffix: 'category_description_',
                entity: 'category',
            });
        }

        contentAction.getButton().on('click', function (e) {
            e.preventDefault();

            async function updateContent () {
                var content = new ChatGptContent(),
                    idLang = content.getPageLanguageId(),
                    categoryName = $("#category_name_" + idLang).val();

                renderLoaderlayer($('#category_description'));

                var description = await content.getCategoryDescription(categoryName, {
                    idLang: idLang,
                    length: $('#gpt_description_length').val()
                });

                if (typeof description.inQueue != 'undefined' && description.inQueue) {
                    description = await content.awaitRequestResponse(description.requestId);

                    // display error message if the request is failure
                    if (description && description.status != 'success') {
                        if (description.status == 'quota_over') {
                            window.showErrorMessage(gptI18n.subscriptionLimitЕxceeded);
                        } else {
                            window.showErrorMessage(description.text);
                        }

                        removeLoaderLayer();
                        return;
                    }
                }

                if (description && description.text) {
                    content.setContentIntoEditor(
                        content.convertTextToHtml(description.text),
                        {format: 'html'},
                        tinymce.get('category_description_' + idLang)
                    );

                    window.showSuccessMessage(gptI18n.successMessage.replace(/\%words\%/g, description.nbWords));
                }

                removeLoaderLayer();
            }

            var currentContent = tinymce.get('category_description_' + (new ChatGptContent()).getPageLanguageId())
                .getContent({format: 'text'})
                .trim();

            if (currentContent !== '') {
                (new ChatGptModal)
                    .setHeader(gptI18n.modalTitle)
                    .setBody(gptI18n.regenerateQuestion)
                    .addAction({
                            title: gptI18n.buttonCancel,
                            class: 'btn btn-outline-secondary'
                        }, function (actionInstance) {
                            actionInstance.getModal().destroy();
                        })
                    .addAction({
                            title: gptI18n.buttonRegenerate,
                        }, function (actionInstance) {
                            updateContent();
                            actionInstance.getModal().destroy();
                        })
                    .open();
                return;
            }

            updateContent();
        });
    }  else if (adminPageName == 'cmsForm') {
        if (!gptShopInfo.subscription || gptShopInfo.subscription.availablePageWords == 0) {
            var alertMessage = '';
            if (!gptShopInfo.subscription || !gptShopInfo.subscription.plan) {
                alertMessage = gptI18n.subscriptionNotAvaialable;
            } else if (gptShopInfo.subscription.plan.productWords == 0) {
                alertMessage = gptI18n.subscriptionPlanNoFeature;
            }  else if (gptShopInfo.subscription.availablePageWords == 0) {
                alertMessage = gptI18n.subscriptionLimitЕxceeded;
            }
            renderAlertMessage(alertMessage, $("#cms_page_content"));
            return;
        }

        var contentAction = (new ChatGptAction({
            id: "gpt_description_button",
            title: gptI18n.buttonName,
            additionalHtml: getWordsFiled(1000, 10, 2000, 1)
        }))
            .renderInto($("#cms_page_content"));

        if (gptShopInfo.subscription.plan.customRequest) {
            renderCustomRequestForm($("#cms_page_content"), {
                contentEditorPreffix: 'cms_page_content_',
                entity: 'page',
            });
        }

        var updateCategoryTranslateButtons = function () {
            renderTranslateButtonsList(contentAction, {
                contentWrapperSelector: '#cms_page_content',
                contentEditorPreffix: 'cms_page_content_',
                entity: 'page',
            });
        }

        updateCategoryTranslateButtons();
        if (typeof prestashop != 'undefined') {
            prestashop.component.EventEmitter.on('languageSelected', function () { updateCategoryTranslateButtons(); });
        } else {
            $('body').on('shown.bs.tab', '.translationsLocales.nav .nav-item a[data-toggle="tab"]', updateCategoryTranslateButtons);
        }

        contentAction.getButton().on('click', async function (e) {
            e.preventDefault();

            var content = new ChatGptContent(),
                idLang = content.getPageLanguageId(),
                pageName = $("#cms_page_title_" + idLang).val();

            renderLoaderlayer($('#cms_page_content'));

            var pageContent = await content.getPageContent(pageName, {
                idLang: idLang,
                length: $('#gpt_description_length').val()
            });

            if (typeof pageContent.inQueue != 'undefined' && pageContent.inQueue) {
                pageContent = await content.awaitRequestResponse(pageContent.requestId);

                // display error message if the request is failure
                if (pageContent && pageContent.status != 'success') {
                    if (pageContent.status == 'quota_over') {
                        window.showErrorMessage(gptI18n.subscriptionLimitЕxceeded);
                    } else {
                        window.showErrorMessage(pageContent.text);
                    }

                    removeLoaderLayer();
                    return;
                }
            }

            if (pageContent && pageContent.text) {
                content.setContentIntoEditor(
                    content.convertTextToHtml(pageContent.text),
                    {format: 'html'},
                    tinymce.get('cms_page_content_' + idLang)
                );

                window.showSuccessMessage(gptI18n.successMessage.replace(/\%words\%/g, pageContent.nbWords));
            }

            removeLoaderLayer();
        });
    }
});

var ChatGptContent = (function() {
    function ChatGptContent () {
        var processStatus = true;
        this.setProcessStatus = function (status) {
            processStatus = status;
            return this;
        }

        this.getProcessStatus = function () {
            return processStatus;
        }
    }

    ChatGptContent.prototype.stopCurrentProcess = function() {
        return this.setProcessStatus(false);
    };

    ChatGptContent.prototype.getOptions = function() {
        return {
            endPoint: gptAjaxUrl,
        };
    };

    ChatGptContent.prototype.getLanguageByIsoCode = function(isoCode) {
        for (var i = 0; i < gptLanguages.length; i++) {
            if (isoCode == gptLanguages[i].iso_code) {
                return gptLanguages[i];
            }
        }

        return false;
    };

    ChatGptContent.prototype.getPageLanguageId = function() {
        if (typeof adminPageName == 'undefined') {
            throw new Error('The admin page is not defined');
        }

        if (adminPageName == 'productForm') {
            var isoCode = document.getElementById('form_switch_language').value;
            var lang = this.getLanguageByIsoCode(isoCode);
            if (lang) {
                return +lang.id_lang;
            }
        } else if (adminPageName == 'categoryForm' || adminPageName == 'cmsForm') {
            var isoCode = (typeof prestashop != 'undefined' && !!prestashop.instance)
                ? (!!prestashop.instance.translatableField ? prestashop.instance.translatableField.getSelectedLocale() : false)
                : $('.translationsLocales.nav .nav-item a.active[data-toggle="tab"]').data('locale');

            if (isoCode && (lang = this.getLanguageByIsoCode(isoCode))) {
                return +lang.id_lang;
            }
        }

        return (typeof default_language != 'undefined') ? +default_language : 1;
    };

    ChatGptContent.prototype.getPageLanguage = function() {
        var idLang = this.getPageLanguageId();
        for (var i = 0; i < gptLanguages.length; i++) {
            if (gptLanguages[i].id_lang == idLang) {
                return gptLanguages[i];
            }
        }

        return gptLanguages[0];
    };

    ChatGptContent.prototype.setContentIntoEditor = function(content, options, editor) {
        if (typeof content == 'undefined') {
            throw new Error('The content is not defined');
        }

        if (!!editor === false || typeof editor.setContent != 'function') {
            throw new Error('The editor is not defined');
        }

        options = (typeof options == 'undefined') ? {} : options;

        try {
            // update content in the tinyMCE
            editor.setContent(content, options);
            // update content in the textarea
            document.getElementById(editor.id).innerHTML = content;
            document.getElementById(editor.id).value = content;
        } catch (e) {}
    };

    ChatGptContent.prototype.convertTextToHtml = function(text) {
        return text.split("\n").map(function (textPart) {
                                        return '<p>' + textPart + '</p>';
                                    }).join('');
    };

    async function request(options, onSuccess, onError) {
        function doRequest (options) {
            return new Promise(function (resolve, reject) {
                    $.ajax(Object.assign({}, options, {
                        success: function (data) {
                            resolve(data);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            reject(errorThrown);
                        }
                    }));
                });
        }

        options = Object.assign({}, {
            type: 'POST',
            url: '#',
            dataType: 'json',
        }, options, {
            cache: false,
            async: true
        });

        return await doRequest(options)
                            .then(function (response) {
                                typeof onSuccess == 'function' && onSuccess(response);
                                return response;
                            })
                            .catch(function (reason) {
                                typeof onError == 'function' && onError(reason);
                                return {
                                    success: false,
                                    error: {
                                        code: 500,
                                        message: reason
                                    }
                                }
                            });
    }

    ChatGptContent.prototype.bulkProductDescription = async function(products, replace, callback) {
        if (typeof products == 'undefined' && products.length == 0) {
            return;
        }

        var idLang = this.getPageLanguageId(),
            result = [];

        for (var i = 0; i < products.length; i++) {
            if (this.getProcessStatus() === false) {
                console.warn('The process has been stopped');
                this.setProcessStatus(true); // allow to run the another process
                break;
            }
            var response = await request({
                url: this.getOptions().endPoint,
                data: {
                    ajax: 1,
                    action: 'bulkProductDescription',
                    replace: replace,
                    ids: products[i],
                    id_language: idLang,
                    length: 350
                }
            });

            if (typeof callback == 'function') {
                await callback(products[i], i, response, this);
            }

            if (typeof response.success != 'undefined' && response.success) {
                result.push({
                    idProduct: products[i],
                    error: false,
                    requestId: (typeof response.products[0].requestId != 'undefined' ? response.products[0].requestId : false),
                    inQueue: (typeof response.products[0].inQueue != 'undefined' ? response.products[0].inQueue : false),
                    text: response.products[0].text,
                    length: response.products[0].text.length,
                    nbWords: response.products[0].nbWords
                });
            } else if (typeof response.success != 'undefined' && !response.success) {
                result.push({
                    idProduct: products[i],
                    error: true,
                    message: response.error.message
                });
            }
        }

        return result;
    };

    ChatGptContent.prototype.getProductDescription = async function(productName, options) {
        options = Object.assign({}, {
            productCategory: '',
            idDefaultCategory: 0,
            idBrand: 0,
            idLang: 0,
            length: 0,
            idProduct: 0
        }, options);
        var response = await request({
            url: this.getOptions().endPoint,
            data: {
                ajax: 1,
                action: 'productDescription',
                id: (options.idProduct ? options.idProduct : idProduct),
                name: productName,
                category: options.productCategory,
                id_language: options.idLang,
                length: options.length,
                id_category_default: options.idDefaultCategory,
                id_manufacturer: options.idBrand,
            }
        });

        if (typeof response.success != 'undefined' && response.success) {
            return {
                requestId: (typeof response.requestId != 'undefined' ? response.requestId : 0),
                inQueue: (typeof response.inQueue != 'undefined' ? response.inQueue : false),
                text: response.text,
                length: response.text.length,
                nbWords: response.nbWords
            }
        } else if (typeof response.success != 'undefined' && !response.success) {
            window.showErrorMessage(response.error.message);
        }

        return false;
    };

    ChatGptContent.prototype.bulkCategoryDescription = async function(categories, replace, callback) {
        if (typeof categories == 'undefined' && categories.length == 0) {
            return;
        }

        var idLang = this.getPageLanguageId(),
            result = [];

        for (var i = 0; i < categories.length; i++) {
            if (this.getProcessStatus() === false) {
                console.warn('The process has been stopped');
                this.setProcessStatus(true); // allow to run the another process
                break;
            }
            var response = await request({
                url: this.getOptions().endPoint,
                data: {
                    ajax: 1,
                    action: 'bulkCategoryDescription',
                    replace: replace,
                    ids: categories[i],
                    id_language: idLang,
                    length: 160
                }
            });

            if (typeof callback == 'function') {
                await callback(categories[i], i, response, this);
            }

            if (typeof response.success != 'undefined' && response.success) {
                result.push({
                    idCategory: response.categories[0].idCategory,
                    error: false,
                    requestId: (typeof response.categories[0].requestId != 'undefined' ? response.categories[0].requestId : 0),
                    inQueue: (typeof response.categories[0].inQueue != 'undefined' ? response.categories[0].inQueue : false),
                    text: response.categories[0].text,
                    length: response.categories[0].text.length,
                    nbWords: response.categories[0].nbWords
                });
            } else if (typeof response.success != 'undefined' && !response.success) {
                result.push({
                    idCategory: categories[i],
                    error: true,
                    message: response.error.message
                });
            }
        }

        return result;
    };

    ChatGptContent.prototype.getCategoryDescription  = async function(categoryName, options) {
        options = Object.assign({}, {idLang: 0,length: 0,}, options);

        var response = await request({
            url: this.getOptions().endPoint,
            data: {
                ajax: 1,
                action: 'categoryDescription',
                id: idCategory,
                name: categoryName,
                id_language: options.idLang,
                length: options.length
            }
        });

        if (typeof response.success != 'undefined' && response.success) {
            return {
                requestId: (typeof response.requestId != 'undefined' ? response.requestId : false),
                inQueue: (typeof response.inQueue != 'undefined' ? response.inQueue : false),
                text: response.text,
                length: response.text.length,
                nbWords: response.nbWords
            }
        } else if (typeof response.success != 'undefined' && !response.success) {
            window.showErrorMessage(response.error.message);
        }

        return false;
    };

    ChatGptContent.prototype.getPageContent  = async function(pageName, options) {
        options = Object.assign({}, {idLang: 0,length: 0,}, options);

        var response = await request({
            url: this.getOptions().endPoint,
            data: {
                ajax: 1,
                action: 'pageContent',
                id: idCms,
                name: pageName,
                id_language: options.idLang,
                length: options.length
            }
        });

        if (typeof response.success != 'undefined' && response.success) {
            return {
                requestId: (typeof response.requestId != 'undefined' ? response.requestId : false),
                inQueue: (typeof response.inQueue != 'undefined' ? response.inQueue : false),
                text: response.text,
                length: response.text.length,
                nbWords: response.nbWords
            }
        } else if (typeof response.success != 'undefined' && !response.success) {
            window.showErrorMessage(response.error.message);
        }

        return false;
    };

    ChatGptContent.prototype.translateText  = async function(text, options) {
        options = Object.assign({}, {fromLangauge: '', toLanguage: '', entity: ''}, options);

        var response = await request({
            url: this.getOptions().endPoint,
            data: {
                ajax: 1,
                action: 'translateText',
                text: text,
                fromLangauge: options.fromLangauge,
                toLanguage: options.toLanguage,
                entity: options.entity
            }
        });

        if (typeof response.success != 'undefined' && response.success) {
            return {
                requestId: (typeof response.requestId != 'undefined' ? response.requestId : false),
                inQueue: (typeof response.inQueue != 'undefined' ? response.inQueue : false),
                text: response.text,
                length: response.text.length,
                nbWords: response.nbWords
            }
        } else if (typeof response.success != 'undefined' && !response.success) {
            window.showErrorMessage(response.error.message);
        }

        return false;
    };

    /**
     * send custom request from administrator
     *
     * avaialable entities: [product, category, page]
     *
     * @param string text
     * @param object options
     */
    ChatGptContent.prototype.customRequest  = async function(text, options) {
        options = Object.assign({}, {entity: ''}, options);

        var response = await request({
            url: this.getOptions().endPoint,
            data: {
                ajax: 1,
                action: 'customRequest',
                text: text,
                entity: options.entity
            }
        });

        if (typeof response.success != 'undefined' && response.success) {
            return {
                requestId: (typeof response.requestId != 'undefined' ? response.requestId : false),
                inQueue: (typeof response.inQueue != 'undefined' ? response.inQueue : false),
                text: response.text,
                length: response.text.length,
                nbWords: response.nbWords
            }
        } else if (typeof response.success != 'undefined' && !response.success) {
            window.showErrorMessage(response.error.message);
        }

        return false;
    };

    /**
     * Await request response if the request was set in queue
     *
     * @param int requestId
     */
    ChatGptContent.prototype.awaitRequestResponse = async function(requestId) {
        var self = this;

        const sleep = function (ms) {
            return new Promise(function (resolve) { setTimeout(resolve, ms); });
        }

        var iterator = 0;
        while (true) {
            if (this.getProcessStatus() === false) {
                console.warn('The process has been stopped');
                this.setProcessStatus(true); // allow to run the another process
                break;
            }
            iterator ++;
            var response = await request({
                url: self.getOptions().endPoint,
                data: {
                    ajax: 1,
                    action: 'getRequestInfo',
                    id: requestId,
                }
            });

            if (typeof response.success != 'undefined' && response.success) {
                if (response.inQueue == false) {
                    return response;
                }
            } else if (typeof response.success != 'undefined' && !response.success) {
                window.showErrorMessage(response.error.message);
            }

            await sleep(1200).then(function () {
            });

            if (iterator == 16) { // 16 * 1.2s = 20s approx
                window.showSuccessMessage(gptI18n.awaitingRequestResponse);
            }
        }
        return false;
    };

    /**
     * Set description for product or categpry
     *
     * @param int $id Entity id
     * @param entityType
     * @param description
     *
     */
    ChatGptContent.prototype.setDescription  = async function(id, entityType, description, replace) {
        var idLang = this.getPageLanguageId();

        replace = (typeof replace == 'undefined' ? 1 : replace);
        replace = !!replace;

        var response = await request({
            url: this.getOptions().endPoint,
            data: {
                ajax: 1,
                action: 'setDescription',
                description: description,
                id: id,
                entity: entityType,
                id_language: idLang,
                replace: +!!replace
            }
        });

        if (typeof response.success != 'undefined' && response.success) {
            return response;
        } else if (typeof response.success != 'undefined' && !response.success) {
            window.showErrorMessage(response.error.message);
        }

        return false;
    };

    return ChatGptContent;
})();
