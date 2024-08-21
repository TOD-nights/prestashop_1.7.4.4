/*
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
document.addEventListener('DOMContentLoaded', function () {
  var bondescriptionButton = document.getElementById('bonai_button');
  var bondescriptionButtonMeta = document.getElementById('bonai_button_meta');
  var productContentSelect = document.getElementById('bonaicontent_content_type');
  var langChanger = document.getElementById('form_switch_language');
  var bonaiLoader = document.querySelectorAll('.bonai-loader');
  var bonaiStars = document.querySelectorAll('.bonai-stars');

  if (bondescriptionButton) {
    var completionNumberWrapper = document.querySelector('.completion_number_wrapper');
    bondescriptionButton.addEventListener('click', function (event) {
      var popup = 'bonai_popup';
      var bonaicontent_keywords =
        document.getElementById('input_keywords').value;
      var product_id = document.getElementById('product_id').value;
      var iso_code = document.getElementById('iso_code').value;
      var content_type = document.getElementById(
        'bonaicontent_content_type'
      ).value;
      var completion_number = document.getElementById('completion_number').value;

      toggleLoadingState(bonaiLoader, bonaiStars, true);

      ajaxSearch(
        bonaicontent_keywords,
        product_id,
        iso_code,
        content_type,
        completion_number,
        popup
      );
    });

    if (productContentSelect) {
      productContentSelect.addEventListener('change', function (event) {
        var selectedproductContentOption = event.target.value;
        if (selectedproductContentOption == 'marketplaceDescription') {
          completionNumberWrapper.style.display = 'block';
        } else {
          completionNumberWrapper.style.display = 'none';
        }
      });
    }
  }

  if (bondescriptionButtonMeta) {
    bondescriptionButtonMeta.addEventListener('click', function (event) {
      var popup = 'bonai_popup_meta';
      var bonaicontent_keywords = document.getElementById(
        'input_keywords_meta'
      ).value;
      var product_id = document.getElementById('product_id_meta').value;
      var iso_code = document.getElementById('iso_code_meta').value;
      var content_type = document.getElementById(
        'bonaicontent_content_type_meta'
      ).value;
      var completion_number = 1;

      toggleLoadingState(bonaiLoader, bonaiStars, true);

      ajaxSearch(
        bonaicontent_keywords,
        product_id,
        iso_code,
        content_type,
        completion_number,
        popup
      );
    });
  }

  if (langChanger) {
    langChanger.addEventListener('change', function (event) {
      var selectedOption = event.target.value;
      document.getElementById('iso_code').value = selectedOption;
      document.getElementById('iso_code_meta').value = selectedOption;
    });
  }

  function ajaxSearch(
    bonaicontent_keywords,
    product_id,
    iso_code,
    content_type,
    completion_number,
    popup
  ) {
    $.ajax({
      url: BonAIContentAjaxUrl + '&ajax',
      type: 'POST',
      headers: {
        'cache-control': 'no-cache'
      },
      dataType: 'json',
      data: {
        action: controller_name,
        content_type: content_type,
        bonaicontent_keywords: bonaicontent_keywords,
        product_id: product_id,
        iso_code: iso_code,
        completion_number: completion_number
      },
      success: function (response) {
        response = response['result'];
        var bonaiPopup = document.getElementById(popup);
        if (bonaiPopup) {
          bonaiPopup.innerHTML = response;
          if (popup == 'bonai_popup_meta') {
            var dataContent = bonaiPopup.querySelector('#bonai_result_meta');
          } else if (popup == 'bonai_popup') {
            var dataContent = bonaiPopup.querySelector('#bonai_result');
          }

          if (dataContent) {
            dataContent = dataContent.value;
            toggleLoadingState(bonaiLoader, bonaiStars, false);

            var approveButton = document.getElementById('approve-results');
            var copyButtons = document.querySelectorAll('.copy-results');
            var approveMetaButton = document.getElementById(
              'approve-results-meta'
            );
            var clearResultsButton = document.getElementById('clear-results');
            var clearResultsButtonMeta =
              document.getElementById('clear-results-meta');

            if (copyButtons.length > 0) {
              copyButtons.forEach((copyButton) => {
                copyButton.addEventListener('click', function (event) {
                  let textarea =
                  this.closest('.wrap_item').querySelector('textarea');
                  textarea.select();
                  document.execCommand('copy');
                });
              });
            }

            if (approveButton) {
              approveButton.addEventListener('click', function (event) {
                var contentType =
                  approveButton.getAttribute('data-content_type');
                var formStep1Name = document.getElementById('form_step1_name');
                var descriptionShort =
                  document.getElementById('description_short');
                var description = document.getElementById('description');
                var selector = '[data-locale="' + iso_code + '"]';
                var childElement,
                  inputElement,
                  iframe,
                  iframeWindow,
                  iframeElement;

                if (contentType === 'productTitle' && formStep1Name) {
                  childElement = formStep1Name.querySelector(selector);
                  inputElement = childElement.querySelector('input');
                  inputElement.value = dataContent;
                } else if (
                  contentType === 'productSummary' &&
                  descriptionShort
                ) {
                  childElement = descriptionShort.querySelector(selector);
                  inputElement = childElement.querySelector('textarea');
                  iframe = childElement.querySelector('iframe');
                  iframeWindow = iframe.contentWindow;
                  iframeElement = iframeWindow.document.querySelector('body');
                  inputElement.innerHTML = '<p>' + dataContent + '</p>';
                  iframeElement.innerHTML = '<p>' + dataContent + '</p>';
                } else if (
                  contentType === 'productDescription' &&
                  description
                ) {
                  childElement = description.querySelector(selector);
                  inputElement = childElement.querySelector('textarea');
                  iframe = childElement.querySelector('iframe');
                  iframeWindow = iframe.contentWindow;
                  iframeElement = iframeWindow.document.querySelector('body');
                  inputElement.innerHTML = '<p>' + dataContent + '</p>';
                  iframeElement.innerHTML = '<p>' + dataContent + '</p>';
                }
              });
            }

            if (clearResultsButton) {
              clearResultsButton.addEventListener('click', function () {
                bonaiPopup.innerHTML = '';
              });
            }

            if (approveMetaButton) {
              approveMetaButton.addEventListener('click', function (event) {
                var contentType =
                  approveMetaButton.getAttribute('data-content_type');
                var formMetaTitle = document.getElementById(
                  'form_step5_meta_title'
                );
                var formMetaDescription = document.getElementById(
                  'form_step5_meta_description'
                );
                var selector = '[data-locale="' + iso_code + '"]';
                var childElement, inputElement;
                if (contentType === 'productMetaTitle' && formMetaTitle) {
                  childElement = formMetaTitle.querySelector(selector);
                  inputElement = childElement.querySelector('input');
                  inputElement.value = dataContent;
                } else if (
                  contentType === 'productMetaDescription' &&
                  formMetaDescription
                ) {
                  childElement = formMetaDescription.querySelector(selector);
                  inputElement = childElement.querySelector('textarea');
                  inputElement.innerHTML = dataContent;
                }
              });
            }

            if (clearResultsButtonMeta) {
              clearResultsButtonMeta.addEventListener('click', function () {
                bonaiPopup.innerHTML = '';
              });
            }
          }
        }
      },
      error: function (xhr, status, error) {
        console.log('Error executing the request');
      }
    });
  }

  function toggleLoadingState(loaderElements, starsElements, isLoading) {
    var displayValue = isLoading ? 'block' : 'none';

    for (var i = 0; i < loaderElements.length; i++) {
      loaderElements[i].style.display = displayValue;
    }

    for (var j = 0; j < starsElements.length; j++) {
      starsElements[j].style.display = isLoading ? 'none' : 'block';
    }
  }
});
