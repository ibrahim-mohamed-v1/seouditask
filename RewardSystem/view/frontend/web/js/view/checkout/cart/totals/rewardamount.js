/**
 * Seoudi Software.
 *
 * @category  Seoudi
 * @package   Seoudi_RewardSystem
 * @author    Seoudi
 * @copyright Copyright (c) Seoudi Software Private Limited (https://Seoudi.com)
 * @license   https://store.Seoudi.com/license.html
 */
/*jshint jquery:true*/
define(
    [
        'Seoudi_RewardSystem/js/view/checkout/summary/rewardamount',
        'Magento_Checkout/js/model/cart/totals-processor/default',
        'Magento_Checkout/js/model/totals'
    ],
    function (Component, defaultTotal, totals) {
        'use strict';
        
        return Component.extend({

            /**
             * Reward application procedure
             */
            initialize: function () {
                this._super();
                defaultTotal.estimateTotals();
            },

            /**
             * @override
             */
            isDisplayed: function () {
                var price = 0;
                if (this.totals()) {
                    /**
                     * Name of xml Item in getSegment
                     */
                  if (totals.getSegment('reward_amount') !== null) {
                    price = totals.getSegment('reward_amount').value;
                  }
                }
                price = parseFloat(price);
                if (price) {
                    return true;
                } else {
                    return false;
                }
            }
        });
    }
);
