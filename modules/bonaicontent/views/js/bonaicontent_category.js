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
  setTimeout(() => {
    var container = document.querySelector('.admincategories');
    container.addEventListener('click', function (event) {
      var target = event.target;
      if (target.matches('.js-locale-item, .nav-link')) {
        var locale = target.dataset.locale;
        document.getElementById('iso_code').value = locale;
      }
    });
  }, 300);
  var bonaiLoader = document.querySelectorAll('.bonai-loader');
  var bonaiStars = document.querySelectorAll('.bonai-stars');

  if (bondescriptionButton) {
    bondescriptionButton.addEventListener('click', function (event) {
      var popup = 'bonai_popup';
      var bonaicontent_keywords =
        document.getElementById('input_keywords').value;
      var category_id = document.getElementById('category_id').value;
      var iso_code = document.getElementById('iso_code').value;

      var content_type = document.getElementById(
        'bonaicontent_content_type'
      ).value;
      var completion_number = 1;

      toggleLoadingState(bonaiLoader, bonaiStars, true);

      ajaxSearch(
        bonaicontent_keywords,
        category_id,
        iso_code,
        content_type,
        completion_number,
        popup
      );
    });
  }

  function ajaxSearch(
    bonaicontent_keywords,
    category_id,
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
        category_id: category_id,
        iso_code: iso_code,
        completion_number: completion_number
      },
      success: function (response) {
        response = response['result'];
        var bonaiPopup = document.getElementById(popup);
        if (bonaiPopup) {
          bonaiPopup.innerHTML = response;
          var dataContent = bonaiPopup.querySelector('#bonai_result');

          if (dataContent) {
            dataContent = dataContent.value;
            toggleLoadingState(bonaiLoader, bonaiStars, false);

            var approveButton = document.getElementById('approve-results');
            var copyButtons = document.querySelectorAll('.copy-results');
            var clearResultsButton = document.getElementById('clear-results');

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
                var selector = '.js-locale-' + iso_code;
                var description = document.getElementById(
                  'category_description'
                );

                var childElement,
                  inputElement,
                  iframe,
                  iframeWindow,
                  iframeElement;

                if (contentType === 'categoryMetaDescription') {
                  let domElements = document.querySelectorAll(selector);
                  domElements.forEach((element) => {
                    inputElement = element.querySelector('textarea');
                    if (inputElement) {
                      inputElement.innerHTML = dataContent;
                    }
                  });
                } else if (
                  contentType === 'categoryDescription' &&
                  description
                ) {
                  selector = '[data-locale="' + iso_code + '"]';
                  tabContent = description.querySelector('.tab-content');
                  childElement = tabContent.querySelector(selector);
                  inputElement = childElement.querySelector('textarea');
                  iframe = childElement.querySelector('iframe');
                  console.log(iframe);
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
