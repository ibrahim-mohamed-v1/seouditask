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
    'Magento_Ui/js/view/messages',
    '../../model/discount-messages'
], function (Component, messageContainer) {
    'use strict';

    return Component.extend({


        initialize: function (config) {
            return this._super(config, messageContainer);
        }
    });
});
