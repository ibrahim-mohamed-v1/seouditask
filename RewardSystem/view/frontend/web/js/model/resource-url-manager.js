/**
 * Seoudi Software.
 *
 * @category  Seoudi
 * @package   Seoudi_RewardSystem
 * @author    Seoudi
 * @copyright Copyright (c) Seoudi Software Private Limited (https://Seoudi.com)
 * @license   https://store.Seoudi.com/license.html
 */
/*jshint browser:true jquery:true*/
/*global alert*/
define(
    [
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/url-builder',
        'mageUtils'
    ],
    function (customer, urlBuilder, utils) {
        "use strict";
        return {

            getApplyRewardUrl: function (rewardData, quoteId) {
                var params = (this.getCheckoutMethod() == 'guest') ? {quoteId: quoteId} : {};
                var urls = {
                    'customer': '/carts/mine/credit/' +'params?'+rewardData
                };
                return this.getUrl(urls, params);
            },
            getCancelRewardUrl: function (quoteId) {
                var params = (this.getCheckoutMethod() == 'guest') ? {quoteId: quoteId} : {};
                var urls = {
                    'customer': '/carts/mine/credit/' +'params?cancel=1'
                };
                return this.getUrl(urls, params);
            },
            /** Get url for service */
            getUrl: function (urls, urlParams) {
                var url;

                if (utils.isEmpty(urls)) {
                    return 'Provided service call does not exist.';
                }

                if (!utils.isEmpty(urls['default'])) {
                    url = urls['default'];
                } else {
                    url = urls[this.getCheckoutMethod()];
                }
                return urlBuilder.createUrl(url, urlParams);
            },

            getCheckoutMethod: function () {
                return customer.isLoggedIn() ? 'customer' : 'guest';
            }
        };
    }
);
