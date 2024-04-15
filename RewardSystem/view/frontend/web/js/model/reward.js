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
    ['ko'],
    function (ko) {
        'use strict';
        var rewardData = window.checkoutConfig.rewards;
        var rewardSession = window.checkoutConfig.rewardSession;
        var rewardMessage = window.checkoutConfig.rewardMessage;
        return {
            rewardData: rewardData,
            rewardSession: rewardSession,
            rewardMessage: rewardMessage,

            getRewardData: function () {
                return rewardData;
            },

            getRewardSession: function () {
                return rewardSession;
            },

            getRewardMessage: function () {
                return rewardMessage;
            },
        };
    }
);
