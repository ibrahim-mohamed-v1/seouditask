/**
 * Seoudi Software.
 *
 * @category  Seoudi
 * @package   Seoudi_RewardSystem
 * @author    Seoudi
 * @copyright Copyright (c) Seoudi Software Private Limited (https://Seoudi.com)
 * @license   https://store.Seoudi.com/license.html
 */
define(
    [
        "jquery",
        'ko',
        "uiComponent",
        'Seoudi_RewardSystem/js/model/reward',
        'Magento_Checkout/js/model/error-processor',
        'Seoudi_RewardSystem/js/model/discount-messages',
        'Magento_Checkout/js/model/totals',
        'Magento_Checkout/js/model/cart/totals-processor/default',
        'Magento_Catalog/js/price-utils',
        'Magento_Checkout/js/model/quote',
        'Seoudi_RewardSystem/js/model/reward',
        'Seoudi_RewardSystem/js/action/set-reward-action',
        'Seoudi_RewardSystem/js/action/cancel-reward-action'
    ],
    function (
        $,
        ko,
        Component,
        rewardData,
        errorProcessor,
        messageContainer,
        totals,
        defaultTotal,
        priceUtils,
        quote,
        reward,
        setRewardAction,
        cancelRewardAction
    ) {
        'use strict';
        var totals = quote.getTotals();
        defaultTotal.estimateTotals();
        var rewardValue = rewardData.getRewardData();
        var totalAmount = ko.observable();
        var isLoading = ko.observable(false);
        var isValue = ko.observable(false);
        if (rewardValue.status == 1) {
          var rewradStatus = ko.observable(true);
        } else {
          var rewradStatus = ko.observable(false);
        }
        var session = [];
        var rewardsSession = reward.getRewardSession();
        if (!$.isEmptyObject(rewardsSession)) {
            rewardsSession.amount = priceUtils.formatPrice(rewardsSession.amount, quote.getPriceFormat());
            rewardsSession.avail_amount = priceUtils.formatPrice(rewardsSession.avail_amount, quote.getPriceFormat());
            session.push(rewardsSession);
        }
        var isApplied = ko.observable(session.length > 0);
        var rewardSession = ko.observableArray(session);
        return Component.extend({
             defaults: {
                template: 'Seoudi_RewardSystem/checkout/rewardamount',
                isLoading: isLoading,
                isValue:isValue,
                totalAmount:totalAmount,
                rewardsession:rewardSession,
                rewradStatus:rewradStatus,
                isApplied: isApplied,
            },
            initialize: function () {
                this._super(); //you must call super on components or they will not render
                defaultTotal.estimateTotals();
            },
            rewardPoints: ko.observable(rewardValue.total_reward_point),
            rewardPointAmount: ko.observable(rewardValue.point_amount),
            amountCurrency: ko.observable(rewardValue.currency),
            /**
             * apply reward
             */
            apply: function (value) {
               if (this.validate()) {
                   var formData = $('#reward-form').serialize();
                   isLoading(true);
                   setRewardAction(formData,isApplied,rewardSession,isLoading);
               }
           },
           check: function (value) {
             var points = $('#reward_points').val();
             if (points != '') {
               var total_amount = points*rewardValue.point_amount;
               total_amount = priceUtils.formatPrice(total_amount, quote.getPriceFormat());
               totalAmount(total_amount);
               isValue(true);
             } else {
               isValue(false);
             }
           },
           /**
            * Cancel reward session
            */
            cancel: function () {
                isLoading(true);
                cancelRewardAction(isApplied, isLoading, isValue);

            },
           validate: function () {
                var form = '#reward-form';
                return $(form).validation() && $(form).validation('isValid');
            },
            getajaxUrl: function () {
                return rewardValue.ajaxurl;
            },
        });
    }
);
