/**
 * Seoudi Software.
 *
 * @category  Seoudi
 * @package   Seoudi_RewardSystem
 * @author    Seoudi
 * @copyright Copyright (c) Seoudi Software Private Limited (https://Seoudi.com)
 * @license   https://store.Seoudi.com/license.html
 */

define([
    'jquery',
    'uiComponent',
    'Seoudi_RewardSystem/js/model/reward'
], function ($, Component, rewardData) {
    'use strict';
    
    var RewardMessage = rewardData.getRewardMessage();
    
    return Component.extend({
        defaults: {
            template: 'Seoudi_RewardSystem/checkout/rewardloginmessage'
        },

        checkStatus: function() {
            if(RewardMessage.status == 0) {
                return false;
            } else {
                return true;
            }
        },
        
        getValue: function () {
            return RewardMessage.total_reward_point;
        },

        getRedirectUrl: function() {
            return RewardMessage.url;
        },

        /**
         * Initializes regular properties of instance.
         *
         * @returns {Object} Chainable.
         */
        initConfig: function () {
            this._super();
            return this;
        }
    });
});
